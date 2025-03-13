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

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">All Leave Records</h3>
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

                    <!-- Leave Records Table -->
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $leaveRequests->appends(['search' => request('search'), 'per_page' => request('per_page')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
