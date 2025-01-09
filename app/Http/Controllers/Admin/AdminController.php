<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function manageleave()
    {
         // Fetch leave requests grouped by status
    $pendingRequests = LeaveRequest::with('user')->where('status', 'pending')->get();
    $approvedRequests = LeaveRequest::with('user')->where('status', 'approved')->get();
    $rejectedRequests = LeaveRequest::with('user')->where('status', 'rejected')->get();

    // Pass the data to the view
    return view('admin.manageleave', compact('pendingRequests', 'approvedRequests', 'rejectedRequests'));
        
    }

    public function manageuser()
    {
        //return view('admin.manageuser');

         // Fetch all users
        $users = User::all();

        // Pass the data to the view
        return view('admin.manageuser', compact('users'));
    }

    public function deleteUser($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return redirect()->route('admin.manageuser')->with('error', 'User not found');
        }

        // Delete the user
        $user->delete();

        // Redirect back with a success message
        return redirect()->route('admin.manageuser')->with('success', 'User deleted successfully');
    }

    public function approveLeave($id)
{
    // Find the leave request by ID
    $leaveRequest = LeaveRequest::find($id);

    if (!$leaveRequest) {
        return redirect()->route('admin.manageleave')->with('error', 'Leave request not found');
    }

    // Update the status to 'approved'
    $leaveRequest->update(['status' => 'approved']);

    return redirect()->route('admin.manageleave')->with('success', 'Leave request approved successfully');
}

public function rejectLeave($id)
{
    // Find the leave request by ID
    $leaveRequest = LeaveRequest::find($id);

    if (!$leaveRequest) {
        return redirect()->route('admin.manageleave')->with('error', 'Leave request not found');
    }

    // Update the status to 'rejected'
    $leaveRequest->update(['status' => 'rejected']);

    return redirect()->route('admin.manageleave')->with('success', 'Leave request rejected successfully');
}
}
