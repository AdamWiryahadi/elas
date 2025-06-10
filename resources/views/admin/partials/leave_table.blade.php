<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <thead class="thead-light">
            <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Start Date</th>
                <th class="text-center">End Date</th>
                <th class="text-center">Days Request</th>
                <th class="text-center">Days Left</th>
                <th class="text-center">Leave Type</th>
                <th class="text-center">Reason</th>
                <th class="text-center">Status</th>            
                @if ($status === 'Pending')
                    <th class="text-center">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($leaveRequests as $leaveRequest)
                <tr>
                    <td class="text-center">{{ $leaveRequest->user->name }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('d-m-Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('d-m-Y') }}</td>
                    <td class="text-center">
                        @if ($leaveRequest->status === 'pending')
                            {{ $leaveRequest->days_requested ?? '-' }}
                        @elseif ($leaveRequest->status === 'approved')
                            {{ $leaveRequest->days_taken ?? '-' }}
                        @else
                            {{ $leaveRequest->days_requested ?? '-' }}
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $settings->quota_enabled ? $leaveRequest->user->quota : 'Unlimited' }}
                    </td>
                    <td class="text-center">{{ $leaveRequest->leave_type }}</td>
                    <td class="text-left">{{ $leaveRequest->reason }}</td>
                    <td class="text-center">
                        @if ($leaveRequest->status === 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif ($leaveRequest->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>                
                    @if ($status === 'Pending')
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <!-- Approve Button -->
                            <form action="{{ route('admin.approveleave', $leaveRequest->id) }}" method="POST" 
                                class="swal-confirm" data-swal-message="Approve this leave request?">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check-circle"></i> Approve
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <form action="{{ route('admin.rejectleave', $leaveRequest->id) }}" method="POST" 
                                class="swal-confirm" data-swal-message="Reject this leave request?">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-times-circle"></i> Reject
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
<div>
<script>
    document.querySelectorAll('form.swal-confirm').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Stop immediate form submission

            const message = form.getAttribute('data-swal-message') || "Are you sure?";

            Swal.fire({
                title: 'Confirm',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#28a745',  // green confirm
                cancelButtonColor: '#3085d6'    // red cancel
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form if confirmed
                }
            });
        });
    });
</script>
