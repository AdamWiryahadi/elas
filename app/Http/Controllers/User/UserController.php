<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\Setting;
use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pendingCount = auth()->user()->leaveRequests()->where('status', 'pending')->count();
        $approvedCount = auth()->user()->leaveRequests()->where('status', 'approved')->count();
        $rejectedCount = auth()->user()->leaveRequests()->where('status', 'rejected')->count();

        $allLeaveRequests = LeaveRequest::with('user')->get();
        $quota = $user->quota ?? 'N/A'; 
        $settings = Setting::first() ?? new Setting(); 

        // Fetch all public holidays
        $holidays = Holiday::all();

        return view('user.dashboard', compact('settings', 'allLeaveRequests', 'quota', 'holidays', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    public function applyleave()
    {
        return view('user.applyleave');
    }

    public function leavehistory(Request $request)
    {
        // Get the search query
        $search = $request->input('search');

        // Get the selected pagination count, default to 10
        $perPage = $request->input('per_page', 10);

        // Fetch leave requests only for the authenticated user
        $leaveRequests = LeaveRequest::where('user_id', Auth::id())
            ->when($search, function ($query) use ($search) {
                return $query->where('leave_type', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage);

        // Ensure historical data remains unchanged
        foreach ($leaveRequests as $leaveRequest) {
            // If `days_taken` is not set, calculate it once and store it
            if (!$leaveRequest->days_taken) {
                $leaveRequest->days_taken = $this->countWorkingDays($leaveRequest->start_date, $leaveRequest->end_date);
                $leaveRequest->save(); // Store in the database to prevent recalculating in the future
            }

            // Use the stored `days_left` to maintain historical accuracy
            $leaveRequest->days_left = $leaveRequest->days_left ?? 0;
        }

        // Pass data to the view
        return view('user.leavehistory', compact('leaveRequests', 'search', 'perPage'));
    }
    
    public function storeLeave(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|in:annual,emergency,medical,maternity,paternity',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $settings = Setting::first();

        if ($settings->quota_enabled && $user->quota <= 0) {
            return redirect()->back()->with('error', 'You have no remaining leave quota.');
        }

        // Get public holidays
        $publicHolidays = Holiday::pluck('date')->map(fn($date) => Carbon::parse($date)->toDateString())->toArray();

        // Calculate leave days, excluding weekends & public holidays
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalLeaveDays = 0;

        while ($startDate <= $endDate) {
            $dayOfWeek = $startDate->dayOfWeek;
            $formattedDate = $startDate->toDateString();

            if ($dayOfWeek !== Carbon::SATURDAY && $dayOfWeek !== Carbon::SUNDAY && !in_array($formattedDate, $publicHolidays)) {
                $totalLeaveDays++;
            }

            $startDate->addDay();
        }

        // Store the leave request but do not deduct quota yet
        LeaveRequest::create([
            'user_id' => $user->id,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',  // Ensure it's stored as 'pending'
            'days_requested' => $totalLeaveDays, // Store the calculated leave days
        ]);

        return redirect()->route('user.leavehistory')->with('success', 'Leave request submitted successfully.');
    }


    public function editLeave($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        if ($leaveRequest->user_id != Auth::id()) {
            abort(403);
        }
        return view('user.editleave', compact('leaveRequest'));
    }

    public function updateleave(Request $request, $id)
    {
        $request->validate([
            'leave_type' => 'required|in:annual,emergency,medical,maternity,paternity',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        $leaveRequest = LeaveRequest::findOrFail($id);
        if ($leaveRequest->user_id != Auth::id()) {
            abort(403);
        }

        $leaveRequest->update([
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        return redirect()->route('user.leavehistory')->with('success', 'Leave request updated successfully.');
    }

    public function deleteLeave($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        if ($leaveRequest->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Restore quota only if the setting is enabled
        $user = Auth::user();
        $settings = Setting::first();

        if ($settings->quota_enabled) {
            // Get public holidays
            $publicHolidays = Holiday::pluck('date')->map(fn($date) => Carbon::parse($date)->toDateString())->toArray();

            // Calculate leave days, excluding weekends & public holidays
            $startDate = Carbon::parse($leaveRequest->start_date);
            $endDate = Carbon::parse($leaveRequest->end_date);
            $restoredDays = 0;

            while ($startDate <= $endDate) {
                $dayOfWeek = $startDate->dayOfWeek;
                $formattedDate = $startDate->toDateString();

                if ($dayOfWeek !== Carbon::SATURDAY && $dayOfWeek !== Carbon::SUNDAY && !in_array($formattedDate, $publicHolidays)) {
                    $restoredDays++;
                }

                $startDate->addDay();
            }

            $user->quota += $restoredDays;
            $user->save();
        }

        $leaveRequest->delete();

        return redirect()->route('user.leavehistory')->with('success', 'Leave request deleted successfully.');
    }

    public function getHolidays()
    {
        return response()->json(Holiday::pluck('date'));
    }

    public function getLeaveQuota()
    {
        return response()->json([
            'quota' => auth()->user()->quota
        ]);
    }

}
