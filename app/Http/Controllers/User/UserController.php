<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $allLeaveRequests = LeaveRequest::with('user')->get();
        $quota = $user->quota ?? 'N/A'; // If user has no quota, show 'N/A'
        $settings = Setting::first() ?? new Setting(); // Avoid errors if no settings exist

        return view('user.dashboard', compact('settings', 'allLeaveRequests', 'quota'));
    }

    public function applyleave()
    {
        return view('user.applyleave');
    }

    public function leavehistory()
    {
        // Fetch leave requests for the authenticated user
        $leaveRequests = LeaveRequest::where('user_id', Auth::id())->get();

        // Pass the leave requests to the view
        return view('user.leavehistory', compact('leaveRequests'));
    }
    
    public function storeleave(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|in:annual,emergency,medical,maternity,paternity',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $settings = Setting::first(); // Fetch settings from the database

        // Check if quota is enabled and if the user has remaining leave
        if ($settings->quota_enabled && $user->quota <= 0) {
            return redirect()->back()->with('error', 'You have no remaining leave quota.');
        }

        // Proceed with leave request creation
        LeaveRequest::create([
            'user_id' => $user->id,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
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

        // Ensure the leave request belongs to the authenticated user
        if ($leaveRequest->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $leaveRequest->delete();

        return redirect()->route('user.leavehistory')->with('success', 'Leave request deleted successfully.');
    }
}
