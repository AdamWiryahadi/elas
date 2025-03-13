<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Holiday;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function index()
    {
        // Count leave request statuses
        $pendingCount = LeaveRequest::where('status', 'pending')->count();
        $approvedCount = LeaveRequest::where('status', 'approved')->count();
        $rejectedCount = LeaveRequest::where('status', 'rejected')->count();

        // Get latest 5 leave requests
        $leaveRequests = LeaveRequest::with('user')->latest()->take(5)->get();

        // Fetch settings (overall quota limit)
        $settings = Setting::first();
        $overall_quota_limit = $settings->quota_limit ?? 10; // Default to 10 if not set

        // Fetch users with their leave requests
        $users = User::with('leaveRequests')->get();

        foreach ($users as $user) {
            // Sum 'days_taken' only for approved leave requests
            $user->leave_taken = $user->leaveRequests->where('status', 'approved')->sum('days_taken');
        
            // Remaining quota is directly from the users table (no calculations)
            $user->remaining_quota = $user->quota; 
        
            // Fetch quota limit from settings table (fallback to default)
            $user->quota_limit = $settings->quota_limit ?? 10;
        }
        
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
        // Fetch all public holidays
        $holidays = Holiday::all();

        // Calculate Days Taken for each request
        foreach ($allLeaveRequests as $leaveRequest) {
            $leaveRequest->days_taken = $this->countWorkingDays($leaveRequest->start_date, $leaveRequest->end_date);
        }

        // Pass the data to the view
        return view('admin.manageleave', compact('pendingRequests', 'approvedRequests', 'rejectedRequests', 'allLeaveRequests', 'settings', 'holidays'));
    }

    public function manageuser(Request $request)
    {
        // Get search and per_page input from request
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default to 10 items per page

        // Fetch users with search and pagination
        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->paginate($perPage);

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

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $newPassword = Str::random(8); // Generate a random password
        $user->password = Hash::make($newPassword);
        $user->save();

        // Send email with new password
        Mail::to($user->email)->send(new ResetPasswordMail($user, $newPassword));

        return redirect()->back()->with('success', 'Password reset successfully. New password sent to user email.');
    }

    // Function to calculate working days excluding weekends and holidays
    private function countWorkingDays($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Ensure start date is not after end date
        if ($start->gt($end)) {
            return 0;
        }

        // Fetch holidays from the database as an array of strings
        $holidays = Holiday::pluck('date')->map(fn($date) => Carbon::parse($date)->toDateString())->toArray();

        $workingDays = 0;

        while ($start->lte($end)) {
            if (!$start->isWeekend() && !in_array($start->toDateString(), $holidays)) {
                $workingDays++;
            }
            $start->addDay();
        }

        return $workingDays;
    }

    public function approveLeave($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $user = $leaveRequest->user;
        $settings = Setting::first();

        // Ensure the request is not already approved
        if ($leaveRequest->status === 'approved') {
            return redirect()->route('admin.manageleave')->with('error', 'Leave request is already approved.');
        }

        $workingDays = $this->countWorkingDays($leaveRequest->start_date, $leaveRequest->end_date);

        if ($settings && $settings->quota_enabled) {
            if ($user->quota < $workingDays) {
                return redirect()->route('admin.manageleave')->with('error', 'Not enough leave quota available.');
            }

            // Deduct quota and store the days left at approval time
            $user->decrement('quota', $workingDays);
        }

        // Store the days taken and days left at the time of approval
        $leaveRequest->update([
            'status' => 'approved',
            'days_taken' => $workingDays,
            'days_left' => $user->quota, // Store the remaining quota at this point
        ]);

        return redirect()->route('admin.manageleave')->with('success', 'Leave request approved successfully.');
    }

    public function rejectLeave($id)
    {
        DB::transaction(function () use ($id) {
            $leaveRequest = LeaveRequest::find($id);

            if (!$leaveRequest) {
                throw new \Exception("Leave request not found");
            }

            $user = $leaveRequest->user;

            if ($leaveRequest->status === 'approved') {
                $daysTaken = $this->countWorkingDays($leaveRequest->start_date, $leaveRequest->end_date);
                $user->quota += $daysTaken;
                $user->save();
            }

            $leaveRequest->update(['status' => 'rejected']);
        });

        return redirect()->route('admin.manageleave')->with('success', 'Leave request rejected successfully and quota restored.');
    }

    public function logHistory(Request $request)
    {
        // Get the search query
        $search = $request->input('search');

        // Get the selected pagination count, default to 10
        $perPage = $request->input('per_page', 10);

        // Fetch leave requests with filtering
        $leaveRequests = LeaveRequest::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('leave_type', 'like', "%{$search}%")
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
        return view('admin.loghistory', compact('leaveRequests', 'search', 'perPage'));
    }

    public function settings(Request $request)
    {
        $settings = Setting::first(); // Fetch global settings

        $search = $request->input('search');
        $perPage = $request->input('per_page', 5); // Default to 5 per page

        $holidays = Holiday::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('date', 'LIKE', "%{$search}%");
        })->orderBy('date', 'desc')->paginate($perPage);

        return view('admin.settings', compact('settings', 'holidays', 'search', 'perPage'));
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

    public function storeHoliday(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'name' => 'required|string|max:255',
        ]);

        Holiday::create([
            'date' => $request->date,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.settings')->with('success', 'Holiday added successfully!');
    }

    public function updateHoliday(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'name' => 'required|string|max:255',
        ]);

        $holiday = Holiday::findOrFail($id);
        $holiday->update([
            'date' => $request->date,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.settings')->with('success', 'Holiday updated successfully!');
    }

    public function deleteHoliday($id)
    {
        Holiday::findOrFail($id)->delete();
        return redirect()->route('admin.settings')->with('success', 'Holiday deleted successfully!');
    }

    public function updateQuota(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $amount = (int) $request->amount; // Convert input to integer

        // Ensure a valid number is entered
        if ($amount <= 0) {
            return redirect()->route('admin.manageuser')->with('error', 'Invalid quota amount.');
        }

        if ($request->action === 'increase') {
            $user->quota += $amount; // Add input amount
        } elseif ($request->action === 'decrease') {
            $user->quota = max(0, $user->quota - $amount); // Prevent negative quota
        }

        $user->save();

        return redirect()->route('admin.manageuser')->with('success', 'Quota updated successfully.');
    }
}