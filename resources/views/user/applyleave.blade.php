<x-user-layout>
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-calendar-plus mr-2"></i> Apply Leave</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Apply Leave</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Leave Application Form (Left-Aligned) -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Leave Application Form</h3>
                        </div>
                        <div class="card-body">
                            <!-- Leave Application Form -->
                            <form action="{{ route('user.storeleave') }}" method="POST">
                                @csrf
                                <!-- Leave Type -->
                                <div class="form-group">
                                    <label for="leave_type">Leave Type</label>
                                    <select class="form-control" name="leave_type" id="leave_type" required>
                                        <option value="" selected disabled>Select Leave Type</option>
                                        <option value="annual">Annual</option>
                                        <option value="emergency">Emergency</option>
                                        <option value="medical">Medical</option>
                                        <option value="maternity">Maternity</option>
                                        <option value="paternity">Paternity</option>
                                    </select>
                                </div>

                                <!-- Start Date -->
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" required>
                                </div>

                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date" required>
                                </div>

                                <!-- Reason -->
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <textarea class="form-control" name="reason" id="reason" rows="4" required></textarea>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Submit Leave Request
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
</x-user-layout>
