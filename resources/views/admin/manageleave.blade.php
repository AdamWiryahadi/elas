<x-admin-layout>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-calendar-plus"></i> Leave Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Leave Management</li>
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
                        end: '{{ date('Y-m-d', strtotime($request->end_date . ' +1 day')) }}',
                        className: '{{ $request->status }}',
                        description: 'Requested by: {{ $request->user->name }}<br>Leave Type: {{ $request->leave_type }}<br>Status: {{ ucfirst($request->status) }}'
                    },
                    @endforeach
                    @foreach($holidays as $holiday)
                    {
                        title: '{{ $holiday->name }}',
                        start: '{{ $holiday->date }}',
                        className: 'holiday',
                        description: 'Public Holiday: {{ $holiday->name }}'
                    },
                    @endforeach
                ],
                eventDidMount: function(info) {
                    $(info.el).tooltip({
                        title: info.event.extendedProps.description,
                        html: true,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                }
            });

            calendar.render();
        });
    </script>

    <style>
        /* Base calendar background */
        .fc {
            background-color: #ffffff;
            border-radius: 6px;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header customization */
        .fc-toolbar-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #343a40;
        }

        .fc-button {
            background-color: #0d6efd !important;
            border: none !important;
            color: white !important;
            border-radius: 4px !important;
            padding: 0.5rem 1rem !important;
        }

        .fc-button:hover {
            background-color: #0b5ed7 !important;
        }

        .fc-button-primary:not(:disabled):hover {
            background-color: #0b5ed7;
        }

        /* Weekend styling */
        .fc-day-sat, .fc-day-sun {
            background-color: #f8f9fa !important;
        }

        /* Day cell borders */
        .fc-daygrid-day, .fc-scrollgrid {
            border: 1px solid #dee2e6 !important;
        }

        /* Events appearance */
        .fc-event {
            border: none !important;
            color: #fff !important;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.85rem;
        }

        /* Leave status specific colors */
        .fc-event.approved {
            background-color: #28a745 !important;
        }
        .fc-event.pending {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }
        .fc-event.rejected {
            background-color: #dc3545 !important;
        }

        /* Holiday style */
        .fc-event.holiday {
            background-color: #007bff !important;
        }
    </style>

</x-admin-layout>