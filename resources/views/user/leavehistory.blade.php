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
                    @if ($leaveRequests->isEmpty())
                        <p class="text-muted">You have not submitted any leave requests yet.</p>
                    @else
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center">Leave Type</th>
                                    <th class="text-center">Reason</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaveRequests as $leaveRequest)
                                    <tr>
                                        <td class="text-center">{{ $leaveRequest->start_date }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('d-m-Y') }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('d-m-Y') }}</td>
                                        <td class="text-center">{{ $leaveRequest->reason }}</td>
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

                                            <!-- <form action="{{ route('user.deleteleave', $leaveRequest->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this leave request?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form> -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </section>

</x-user-layout>
