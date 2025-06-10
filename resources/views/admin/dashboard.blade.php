<x-admin-layout>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Top Row: Status Cards -->
            <div class="row mb-4">
                <!-- Pending -->
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pendingCount }}</h3>
                            <p>Pending Leave Requests</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>

                <!-- Approved -->
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $approvedCount }}</h3>
                            <p>Approved Leave Requests</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <!-- Rejected -->
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $rejectedCount }}</h3>
                            <p>Rejected Leave Requests</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Section: Leave Request History -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title mb-0">Leave Request History</h3>
                        <a href="{{ route('admin.loghistory') }}" class="btn btn-primary ms-auto"><i class="fas fa-plus me-1"></i>View Full History</a>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Start Date</th>
                                            <th class="text-center">End Date</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Reason</th>
                                            <th class="text-center">Status</th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leaveRequests as $request)
                                            <tr>
                                                <td class="text-left">{{ $request->user->name }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($request->start_date)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($request->end_date)->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ $request->leave_type }}</td>
                                                <td class="text-left">{{ $request->reason }}</td>
                                                <td class="text-center">
                                                    @if ($request->status === 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif ($request->status === 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Staff Leave Quotas -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Staff Leave Quotas</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Total Leave Taken</th>
                                            <th class="text-center">Remaining Quota</th>
                                            <th class="text-center">Quota Limit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="text-left">{{ $user->name }}</td>
                                                <td class="text-center">{{ $user->leave_taken ?? 0 }}</td> <!-- Summed from leave_requests -->
                                                <td class="text-center">
                                                    @if ($settings->quota_enabled)
                                                        {{ $user->remaining_quota }}
                                                    @else
                                                        Unlimited
                                                    @endif
                                                </td> <!-- Taken directly from users.quota -->
                                                <td class="text-center">
                                                    @if ($settings->quota_enabled)
                                                        {{ $user->quota_limit }}
                                                    @else
                                                        Unlimited
                                                    @endif
                                                </td> <!-- Taken from settings.quota_limit -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
