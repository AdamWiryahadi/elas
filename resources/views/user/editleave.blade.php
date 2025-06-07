<x-user-layout>
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-edit mr-2"></i> Edit Leave</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Leave</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- Leave Edit Form -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Leave Request</h3>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('user.updateleave', $leaveRequest->id) }}" method="POST" id="edit-leave-form" novalidate>
                                @csrf
                                @method('PATCH')

                                <!-- Leave Type -->
                                <div class="form-group">
                                    <label for="leave_type">Leave Type</label>
                                    <select class="form-control" name="leave_type" id="leave_type" required autofocus>
                                        <option value="annual" {{ $leaveRequest->leave_type === 'annual' ? 'selected' : '' }}>Annual</option>
                                        <option value="emergency" {{ $leaveRequest->leave_type === 'emergency' ? 'selected' : '' }}>Emergency</option>
                                        <option value="medical" {{ $leaveRequest->leave_type === 'medical' ? 'selected' : '' }}>Medical</option>
                                        <option value="maternity" {{ $leaveRequest->leave_type === 'maternity' ? 'selected' : '' }}>Maternity</option>
                                        <option value="paternity" {{ $leaveRequest->leave_type === 'paternity' ? 'selected' : '' }}>Paternity</option>
                                    </select>
                                </div>

                                <!-- Start Date -->
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" required 
                                           value="{{ $leaveRequest->start_date }}" min="{{ date('Y-m-d') }}">
                                </div>

                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date" required 
                                           value="{{ $leaveRequest->end_date }}" min="{{ $leaveRequest->start_date ?? date('Y-m-d') }}">
                                </div>

                                <!-- Total Leave Days Display -->
                                <div class="form-group">
                                    <label for="total_days">Total Leave Days:</label>
                                    <p id="total_days" aria-live="polite" class="text-primary font-weight-bold">0</p>
                                </div>

                                <!-- Reason -->
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <textarea class="form-control" name="reason" id="reason" rows="4" required>{{ $leaveRequest->reason }}</textarea>
                                </div>

                                <!-- Buttons -->
                                <div class="form-group d-flex justify-content-between">
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="submit-btn">
                                        <i class="fas fa-save"></i> Update Leave Request
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');
            const totalDaysEl = document.getElementById('total_days');
            const submitBtn = document.getElementById('submit-btn');
            const form = document.getElementById('edit-leave-form');

            function updateTotalDays() {
                const start = new Date(startInput.value);
                const end = new Date(endInput.value);
                if (!startInput.value || !endInput.value || start > end) {
                    totalDaysEl.textContent = 0;
                    submitBtn.disabled = true;
                    return;
                }
                let diffTime = end - start;
                let diffDays = diffTime / (1000 * 60 * 60 * 24) + 1; // inclusive of start and end
                totalDaysEl.textContent = diffDays;
                submitBtn.disabled = diffDays <= 0;

                // Prevent end date being earlier than start date
                endInput.min = startInput.value;
                if (endInput.value < startInput.value) {
                    endInput.value = startInput.value;
                }
            }

            // Initial call to set total days on page load
            updateTotalDays();

            // Update total days on date input changes
            startInput.addEventListener('change', updateTotalDays);
            endInput.addEventListener('change', updateTotalDays);

            // Optional: simple client-side validation on submit
            form.addEventListener('submit', (e) => {
                if (submitBtn.disabled) {
                    e.preventDefault();
                    alert("Please select a valid date range before submitting.");
                }
            });
        });
    </script>
</x-user-layout>
