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

                                <!-- Total Days Display -->
                                <div class="form-group">
                                    <label>Total Leave Days:</label>
                                    <p class="text-primary font-weight-bold" id="total_days">0</p>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const startDateInput = document.getElementById("start_date");
        const endDateInput = document.getElementById("end_date");
        const totalDaysElement = document.getElementById("total_days");
        let publicHolidays = [];

        // Fetch public holidays from the API
        async function fetchPublicHolidays() {
            try {
                let response = await fetch("{{ route('api.holidays') }}"); // Ensure this route is defined
                let data = await response.json();
                publicHolidays = data.map(holiday => holiday.date); // Store holiday dates as strings (YYYY-MM-DD)
            } catch (error) {
                console.error("Error fetching public holidays:", error);
                publicHolidays = [];
            }
        }

        function isWeekendOrHoliday(date) {
            let day = date.getDay();
            let formattedDate = date.toISOString().split("T")[0]; // Convert date to YYYY-MM-DD format

            return day === 0 || day === 6 || publicHolidays.includes(formattedDate);
        }

        function calculateTotalDays() {
            let startDate = new Date(startDateInput.value);
            let endDate = new Date(endDateInput.value);
            let totalDays = 0;

            if (isNaN(startDate) || isNaN(endDate) || startDate > endDate) {
                totalDaysElement.textContent = 0; // Reset to 0 if invalid selection
                return;
            }

            let currentDate = new Date(startDate);
            while (currentDate <= endDate) {
                if (!isWeekendOrHoliday(currentDate)) {
                    totalDays++;
                }
                currentDate.setDate(currentDate.getDate() + 1);
            }

            totalDaysElement.textContent = totalDays;
        }

        // Load holidays first before event listeners
        fetchPublicHolidays().then(() => {
            startDateInput.addEventListener("change", calculateTotalDays);
            endDateInput.addEventListener("change", calculateTotalDays);
        });
    });
</script>
