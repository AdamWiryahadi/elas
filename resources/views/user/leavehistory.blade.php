<x-user-layout>

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-calendar-alt mr-2"></i> Leave History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Leave History</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Your Leave Requests</h3>
                </div>
                <div class="card-body">
                    <!-- Search & Pagination Controls -->
                    <div class="d-flex justify-content-between mb-3">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.loghistory') }}" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>

                        <!-- Pagination Dropdown -->
                        <form method="GET" action="{{ route('admin.loghistory') }}">
                            <select name="per_page" class="form-select" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                            </select>
                        </form>
                    </div>        

                    @if ($leaveRequests->isEmpty())
                        <p class="text-muted">You have not submitted any leave requests yet.</p>
                    @else
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center">Days Taken</th>
                                    <th class="text-center">Days Left</th>
                                    <th class="text-center">Leave Type</th>
                                    <th class="text-center">Reason</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaveRequests as $leaveRequest)
                                    <tr>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('d-m-Y') }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('d-m-Y') }}</td>
                                        
                                        <!-- Days Taken with Rounded Box -->
                                        <td class="text-center">
                                            {{ $leaveRequest->days_taken ?? '-' }}
                                        </td>

                                        <!-- Days Left with Rounded Box -->
                                        <td class="text-center">
                                            {{ $leaveRequest->days_left ?? '-' }}
                                        </td>

                                        <td class="text-center">{{ $leaveRequest->leave_type }}</td>
                                        <td class="text-left">{{ $leaveRequest->reason }}</td>

                                        <!-- Status with Colored Badge -->
                                        <td class="text-center">
                                            @if ($leaveRequest->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif ($leaveRequest->status === 'approved')
                                                <span class="badge badge-success">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('user.editleave', $leaveRequest->id) }}" 
                                                class="btn btn-info btn-sm {{ $leaveRequest->status !== 'pending' ? 'disabled' : '' }}"
                                                {{ $leaveRequest->status !== 'pending' ? 'aria-disabled=true' : '' }}>
                                                    <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $leaveRequests->appends(['search' => request('search'), 'per_page' => request('per_page')])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

</x-user-layout>
