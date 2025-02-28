<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Count statuses
        $pendingCount = LeaveRequest::where('status', 'pending')->count();
        $approvedCount = LeaveRequest::where('status', 'approved')->count();
        $rejectedCount = LeaveRequest::where('status', 'rejected')->count();
    
        // Get all leave requests
        $leaveRequests = LeaveRequest::with('user')->get();
    
        // Get staff leave data
        $users = User::with('leaveRequests')->get();

        // Fetch settings from the database
        $settings = Setting::first();
    
        return view('admin.dashboard', compact('pendingCount', 'approvedCount', 'rejectedCount', 'leaveRequests', 'users', 'settings'));
    }

    public function manageleave()
    {
        // Fetch leave requests grouped by status
        $pendingRequests = LeaveRequest::with('user')->where('status', 'pending')->get();
        $approvedRequests = LeaveRequest::with('user')->where('status', 'approved')->get();
        $rejectedRequests = LeaveRequest::with('user')->where('status', 'rejected')->get();

        // Fetch all leave requests for the calendar
        $allLeaveRequests = LeaveRequest::with('user')->get();
        // Fetch settings from the database
        $settings = Setting::first();

        // Pass the data to the view
        return view('admin.manageleave', compact('pendingRequests', 'approvedRequests', 'rejectedRequests', 'allLeaveRequests', 'settings'));
    }

    public function manageuser()
    {
        // Fetch all users
        $users = User::all();

        // Fetch settings from the database
        $settings = Setting::first();

        // Count admins and regular users
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();

        // Pass the data to the view
        return view('admin.manageuser', compact('users', 'adminCount', 'userCount', 'settings'));
    }


    public function createUser()
    {
        return view('admin.createuser');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,user',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.manageuser')->with('success', 'User created successfully');
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
            return redirect()->route('admin.manageleave')->with('error', 'Leave request not found.');
        }

        // Get the user who requested the leave
        $user = $leaveRequest->user;
        $settings = Setting::first(); // Fetch settings from the database

        // If quota is enabled, prevent approval if the user has no remaining quota
        if ($settings->quota_enabled && $user->quota <= 0) {
            return redirect()->route('admin.manageleave')->with('error', 'Cannot approve leave. User has no remaining quota.');
        }

        // Update the status to 'approved'
        $leaveRequest->update(['status' => 'approved']);

        // Deduct quota if quota is enabled
        if ($settings->quota_enabled) {
            $user->decrement('quota', 1);
        }

        return redirect()->route('admin.manageleave')->with('success', 'Leave request approved successfully.');
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

    public function settings()
    {
        $settings = Setting::first(); // Fetch settings
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'quota_enabled' => 'required|boolean',
            'quota_limit' => 'nullable|integer|min:0',
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
        }

        $setting->quota_enabled = $request->quota_enabled;
        $setting->quota_limit = $request->quota_enabled ? $request->quota_limit : null;
        $setting->save();

        // ✅ Automatically update all users' quota when enabled
        if ($setting->quota_enabled) {
            User::where('quota', '<>', $setting->quota_limit)->update(['quota' => $setting->quota_limit]);
        }

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
}