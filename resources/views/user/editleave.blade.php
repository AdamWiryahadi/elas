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
            <div class="row">
                <!-- Leave Edit Form -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Leave Request</h3>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('user.updateleave', $leaveRequest->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <!-- Leave Type -->
                                <div class="form-group">
                                    <label for="leave_type">Leave Type</label>
                                    <select class="form-control" name="leave_type" id="leave_type" required>
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
                                    <input type="date" class="form-control" name="start_date" id="start_date" required value="{{ $leaveRequest->start_date }}">
                                </div>

                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date" required value="{{ $leaveRequest->end_date }}">
                                </div>

                                <!-- Reason -->
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <textarea class="form-control" name="reason" id="reason" rows="4" required>{{ $leaveRequest->reason }}</textarea>
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">
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
</x-user-layout>
