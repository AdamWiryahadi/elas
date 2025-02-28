<x-admin-layout>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-calendar-alt"></i> Manage Leave</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Leave</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Calendar Card -->
            <div class="card">
                <!-- <div class="card-header">
                    <h3 class="card-title"><i class="far fa-calendar-alt"></i> Leave Calendar</h3>
                </div> -->
                <div class="card-body">
                    <div id="leaveCalendar" style="min-height: 400px; max-width: 1400px; margin: auto;"></div>
                </div>
            </div>

            <!-- Leave Requests Card -->
            <div class="card card-primary card-outline mt-3">
                <div class="card-body">
                    <!-- Pending Requests -->
                    <div class="mb-4">
                        <h3 class="card-title mb-3 text-warning"><i class="fas fa-clock"></i> Pending Leave Requests</h3>
                        @if ($pendingRequests->isEmpty())
                            <div class="alert alert-secondary">No pending leave requests.</div>
                        @else
                            @include('admin.partials.leave_table', ['leaveRequests' => $pendingRequests, 'status' => 'Pending'])
                        @endif
                    </div>

                    <!-- Approved Requests -->
                    <div class="mb-4">
                        <h3 class="card-title mb-3 text-success"><i class="fas fa-check-circle"></i> Approved Leave Requests</h3>
                        @if ($approvedRequests->isEmpty())
                            <div class="alert alert-secondary">No approved leave requests.</div>
                        @else
                            @include('admin.partials.leave_table', ['leaveRequests' => $approvedRequests, 'status' => 'Approved'])
                        @endif
                    </div>

                    <!-- Rejected Requests -->
                    <div class="mb-4">
                        <h3 class="card-title mb-3 text-danger"><i class="fas fa-times-circle"></i> Rejected Leave Requests</h3>
                        @if ($rejectedRequests->isEmpty())
                            <div class="alert alert-secondary">No rejected leave requests.</div>
                        @else
                            @include('admin.partials.leave_table', ['leaveRequests' => $rejectedRequests, 'status' => 'Rejected'])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Themed Calendar Integration -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('leaveCalendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                contentHeight: 400,
                aspectRatio: 1.5,
                themeSystem: 'bootstrap',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                events: [
                    @foreach($allLeaveRequests as $request)
                    {
                        title: '{{ $request->user->name }} - {{ $request->leave_type }}',
                        start: '{{ $request->start_date }}',
                        end: '{{ date('Y-m-d', strtotime($request->end_date . ' +1 day')) }}', // Add one day
                        color: '{{ $request->status === 'approved' ? '#28a745' : ($request->status === 'pending' ? '#ffc107' : '#dc3545') }}'
                    },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>

</x-admin-layout>