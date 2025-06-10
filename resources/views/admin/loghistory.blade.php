<x-admin-layout>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-calendar-alt"></i> Log History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Log History</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">All Leave Records</h3>
                </div>
                <div class="card-body">
                    <!-- Search & Filter & Pagination Controls -->
                        <form method="GET" action="{{ route('admin.loghistory') }}" class="mb-3 d-flex flex-wrap align-items-end gap-3">

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
                                <a href="{{ route('admin.loghistory') }}" class="btn btn-secondary ms-2">Reset</a>
                            </div>

                            <!-- Buttons next to Export -->
                            <div class="form-group mt-2 ms-auto d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#previewModal">
                                    <i class="fas fa-eye"></i> Preview
                                </button>

                                <a href="{{ route('admin.loghistory.export', request()->all()) }}" class="btn btn-secondary">
                                    <i class="fas fa-download"></i> Export PDF
                                </a>
                            </div>
                        </form>

                        <!-- Leave Records Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">User</th>
                                        <th class="text-center">Start Date</th>
                                        <th class="text-center">End Date</th>
                                        <th class="text-center">Days Taken</th> <!-- New Column -->
                                        <th class="text-center">Days Left</th> <!-- New Column -->
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Reason</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leaveRequests as $request)
                                        <tr>
                                            <td class="text-center">{{ $request->user->name }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($request->start_date)->format('d-m-Y') }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($request->end_date)->format('d-m-Y') }}</td>
                                            <td class="text-center">
                                                {{ $request->days_taken ?? '-' }} <!-- Display Days Taken -->
                                            </td>
                                            <td class="text-center">
                                                {{ $request->days_left ?? '-' }} <!-- Display Days Left -->
                                            </td>
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
                                            <td class="text-center">
                                                <form action="{{ route('admin.loghistory.destroy', $request->id) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger show-confirm" data-id="{{ $request->id }}">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    
                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $leaveRequests->appends(['search' => request('search'), 'per_page' => request('per_page')])->links() }}
                            </div>
                        </div>
                <div>
            </div>
        </div>
    </div>

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
</x-admin-layout>

