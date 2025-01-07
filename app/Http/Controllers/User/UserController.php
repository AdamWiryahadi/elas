<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
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

        LeaveRequest::create([
            'user_id' => Auth::id(), // Replaced auth()->id() with Auth::id()
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
