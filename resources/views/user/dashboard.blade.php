<x-user-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Welcome Animation -->            
            <div class="card-body text-center">
                <h2>
                    <span class="animate__animated animate__fadeInDown animate__delay-1s">Welcome</span>
                    <span class="animate__animated animate__fadeInDown animate__delay-2s">back</span>
                    <span class="animate__animated animate__fadeInDown animate__delay-3s">{{ auth()->user()->name }}!</span>
                </h2>
                <p class="animate__animated animate__fadeInUp animate__delay-4s mt-3">We're glad to have you here. Let's get started!</p>
            </div>

            <div class="row">
                <!-- Pending -->
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pendingCount }}</h3>
                            <p>Pending Leave Requests</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>

                <!-- Approved -->
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $approvedCount }}</h3>
                            <p>Approved Leave Requests</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <!-- Rejected -->
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $rejectedCount }}</h3>
                            <p>Rejected Leave Requests</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
                        
            <!-- Quota and Profile Section -->
            <div class="row">
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Your Remaining Quota</h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="progress-circle" style="position: relative; width: 102px; height: 102px; margin: auto;">
                                <svg viewBox="0 0 36 36" class="circular-chart">
                                    <path class="circle-bg"
                                        d="M18 2.0845
                                            a 15.9155 15.9155 0 0 1 0 31.831
                                            a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="#eee" stroke-width="3"/>
                                    <path class="circle"
                                        stroke-dasharray="{{ $settings->quota_enabled && $settings->quota_limit ? (($quota / $settings->quota_limit) * 100) . ', 100' : '100, 100' }}"
                                        d="M18 2.0845
                                            a 15.9155 15.9155 0 0 1 0 31.831
                                            a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="{{ $settings->quota_enabled ? '#4caf50' : '#2196f3' }}" stroke-width="3" stroke-linecap="round"/>
                                    <text x="18" y="20.35" class="percentage" text-anchor="middle" dy=".3em" font-size="6" fill="#000">
                                        {{ $settings->quota_enabled ? "$quota days" : "∞" }}
                                    </text>
                                </svg>
                            </div>
                            <p class="mt-2">{{ $settings->quota_enabled ? "$quota days remaining" : "Unlimited leave available" }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Your Profile</h3>
                        </div>
                        <div class="card-body d-flex align-items-center">
                        <img src="{{ auth()->user()->profile_photo_url ?? asset('images/default-avatar.jpg') }}" class="img-circle elevation-2 mr-3" alt="User Image" style="width:150px; height:150px;">
                            <div class="ml-3">
                                <h5>{{ auth()->user()->name }}</h5>
                                <p class="text-muted mb-1">{{ auth()->user()->email }}</p>
                                <p class="text-muted">Member since: {{ auth()->user()->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Section -->
            <div class="card">
                <div class="card-body">
                    <div id="dashboardCalendar" style="min-height: 400px;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Calendar Integration -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('dashboardCalendar');
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
                        color: '{{ $request->status === 'approved' ? '#28a745' : ($request->status === 'pending' ? '#ffc107' : '#dc3545') }}',
                        description: 'Requested by: {{ $request->user->name }}<br>Leave Type: {{ $request->leave_type }}<br>Status: {{ ucfirst($request->status) }}'
                    },
                    @endforeach
                    @foreach($holidays as $holiday)
                    {
                        title: '{{ $holiday->name }}',
                        start: '{{ $holiday->date }}',
                        color: '#007bff',
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
</x-user-layout>

<style>
.circular-chart {
    width: 100%;
    height: 100%;
}
.circle-bg {
    stroke: #eee;
    stroke-width: 3;
}
.circle {
    stroke: #4caf50;
    stroke-width: 3;
    stroke-linecap: round;
    transform: rotate(-90deg);
    transform-origin: 50% 50%;
    transition: stroke-dasharray 0.5s ease;
}
.percentage {
    font-weight: bold;
}

.fc-day-sat, .fc-day-sun {
            background-color: rgba(200, 200, 200, 0.3); /* Light gray */
        }

        /* Make individual day cells have black borders */
        .fc-daygrid-day, .fc-scrollgrid {
            border: 1px solid black !important;
        }
</style>