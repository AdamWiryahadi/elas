<?php

namespace App\Http\Controllers\User;

use App\Mail\NewLeaveRequestMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\Setting;
use App\Models\Holiday;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; 

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
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $query = LeaveRequest::where('user_id', Auth::id());

        // Search multiple columns correctly
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('leave_type', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('reason', 'like', "%{$search}%");
            });
        }

        // Optional filters: you can add these filters to the request and handle them here
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->latest()->paginate($perPage)->withQueryString();

        // Calculate days_taken if missing, and preserve days_left
        foreach ($leaveRequests as $leaveRequest) {
            if (!$leaveRequest->days_taken) {
                $leaveRequest->days_taken = $this->countWorkingDays($leaveRequest->start_date, $leaveRequest->end_date);
                $leaveRequest->save();
            }
            $leaveRequest->days_left = $leaveRequest->days_left ?? 0;
        }

        return view('user.leavehistory', compact('leaveRequests', 'search', 'perPage'));
    }

    public function export(Request $request)
    {
        $query = LeaveRequest::where('user_id', Auth::id());

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->get();

        $pdf = Pdf::loadView('user.export_pdf', compact('leaveRequests'));
        return $pdf->download('leave-history.pdf');
    }

    // Add this method
    private function countWorkingDays($start_date, $end_date)
    {
        $startDate = \Carbon\Carbon::parse($start_date);
        $endDate = \Carbon\Carbon::parse($end_date);
        $publicHolidays = \App\Models\Holiday::pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->toDateString())->toArray();

        $workingDays = 0;

        while ($startDate <= $endDate) {
            $dayOfWeek = $startDate->dayOfWeek;
            $formattedDate = $startDate->toDateString();

            if ($dayOfWeek !== \Carbon\Carbon::SATURDAY && $dayOfWeek !== \Carbon\Carbon::SUNDAY && !in_array($formattedDate, $publicHolidays)) {
                $workingDays++;
            }

            $startDate->addDay();
        }

        return $workingDays;
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

        // Check for overlapping leaves
        $overlap = LeaveRequest::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved']) // only consider active/pending leaves
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_date', '<=', $request->start_date)
                        ->where('end_date', '>=', $request->end_date);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->withErrors(['overlap' => 'Your leave request overlaps with an existing approved or pending leave.']);
        }

        // Get public holidays
        $publicHolidays = Holiday::pluck('date')
            ->map(fn($date) => Carbon::parse($date)->toDateString())
            ->toArray();

        // Calculate leave days excluding weekends and public holidays
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

        // Store the leave request
        $leaveRequest = LeaveRequest::create([
            'user_id' => $user->id,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
            'days_requested' => $totalLeaveDays,
        ]);

        // Send email to admin
        $adminEmails = ['hrms@enetech.com.my'];
        foreach ($adminEmails as $adminEmail) {
            Mail::to($adminEmail)->send(new NewLeaveRequestMail($leaveRequest));
        }

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

        // Check for overlapping leave requests excluding this current one
        $overlap = LeaveRequest::where('user_id', Auth::id())
            ->where('id', '!=', $id) // Exclude the current leave request
            ->whereIn('status', ['pending', 'approved']) // Only check active requests
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_date', '<=', $request->start_date)
                        ->where('end_date', '>=', $request->end_date);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->withErrors(['overlap' => 'This leave overlaps with another approved or pending request.']);
        }

        // Update the leave request
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

    public function show()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate including optional password (must be confirmed if filled)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // password confirmation required
        ]);

        // If password is provided, hash it before updating
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Remove password from $validated to avoid overwriting with null
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    public function faq()
    {
        return view('user.faq'); // Create this Blade file accordingly
    }

    public function about()
    {
        return view('user.about'); // Create this Blade file accordingly
    }
}
