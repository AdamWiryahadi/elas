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
                    <!-- Search & Filter & Pagination Controls -->
                    <form method="GET" action="{{ route('user.leavehistory') }}" class="mb-3 d-flex flex-wrap align-items-end gap-3">

                        <!-- Search Input -->
                        <div class="form-group">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" name="search" id="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                        </div>

                        <!-- Start Date Filter -->
                        <div class="form-group">
                            <label for="start_date" class="form-label">Start Date From</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>

                        <!-- End Date Filter -->
                        <div class="form-group">
                            <label for="end_date" class="form-label">End Date To</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>

                        <!-- Status Filter -->
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <!-- Per Page Filter -->
                        <div class="form-group">
                            <label for="per_page" class="form-label">Per Page</label>
                            <select name="per_page" id="per_page" class="form-select">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                            </select>
                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('user.leavehistory') }}" class="btn btn-secondary ms-2">Reset</a>
                        </div>

                        <!-- Buttons next to Export -->
                        <div class="form-group mt-2 ms-auto d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#previewModal">
                                <i class="fas fa-eye"></i> Preview
                            </button>

                            <a href="{{ route('user.leavehistory.export', request()->all()) }}" class="btn btn-secondary">
                                <i class="fas fa-download"></i> Export PDF
                            </a>
                        </div>
                    </form>

                    @if ($leaveRequests->isEmpty())
                        <p class="text-muted">You have not submitted any leave requests yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Start Date</th>
                                        <th class="text-center">End Date</th>
                                        <th class="text-center">Days Taken</th>
                                        <th class="text-center">Days Left</th>
                                        <th class="text-center">Leave Type</th>
                                        <th class="text-left">Reason</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leaveRequests as $leaveRequest)
                                        <tr>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('d-m-Y') }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('d-m-Y') }}</td>
                                            <td class="text-center">{{ $leaveRequest->days_taken ?? '-' }}</td>
                                            <td class="text-center">{{ $leaveRequest->days_left ?? '-' }}</td>
                                            <td class="text-center">{{ $leaveRequest->leave_type }}</td>
                                            
                                            <!-- Truncated Reason with Modal -->
                                            <td class="text-left">
                                                {{ \Illuminate\Support\Str::limit($leaveRequest->reason, 30) }}
                                                @if (strlen($leaveRequest->reason) > 30)
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#reasonModal{{ $leaveRequest->id }}">Read more</a>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="reasonModal{{ $leaveRequest->id }}" tabindex="-1" aria-labelledby="reasonModalLabel{{ $leaveRequest->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="reasonModalLabel{{ $leaveRequest->id }}">Leave Reason</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    {{ $leaveRequest->reason }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Status Badge -->
                                            <td class="text-center">
                                                @if ($leaveRequest->status === 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif ($leaveRequest->status === 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @else
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>

                                            <!-- Disable Edit if in the Past or not Pending -->
                                            <td class="text-center">
                                                @php
                                                    $isPast = \Carbon\Carbon::parse($leaveRequest->start_date)->isPast();
                                                @endphp
                                                <a href="{{ route('user.editleave', $leaveRequest->id) }}" 
                                                    class="btn btn-info btn-sm {{ $leaveRequest->status !== 'pending' || $isPast ? 'disabled' : '' }}"
                                                    {{ $leaveRequest->status !== 'pending' || $isPast ? 'aria-disabled=true' : '' }}>
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $leaveRequests->appends(request()->except('page'))->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Leave Record Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($leaveRequests->isEmpty())
                        <p class="text-muted">No leave requests found for the current filters.</p>
                    @else
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Days Taken</th>
                                    <th>Days Left</th>
                                    <th>Leave Type</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaveRequests as $leaveRequest)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('d-m-Y') }}</td>
                                        <td>{{ $leaveRequest->days_taken ?? '-' }}</td>
                                        <td>{{ $leaveRequest->days_left ?? '-' }}</td>
                                        <td>{{ $leaveRequest->leave_type }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($leaveRequest->reason, 50) }}</td>
                                        <td>
                                            @if ($leaveRequest->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($leaveRequest->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-user-layout>
