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
            <div class="row d-flex align-items-stretch">
                <!-- Quota Section -->
                <div class="col-md-4 col-12 mb-3 d-flex">
                    <div class="card flex-fill text-center">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Your Remaining Quota</h3>
                        </div>
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <div class="progress-circle mb-3" style="position: relative; width: 120px; height: 120px;">
                                <svg viewBox="0 0 36 36" class="circular-chart" role="img" aria-label="Leave quota progress">
                                    <path class="circle-bg"
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="#eee" stroke-width="3" />
                                    <path class="circle"
                                        stroke-dasharray="{{ $settings->quota_enabled && $settings->quota_limit ? (($quota / $settings->quota_limit) * 100) . ', 100' : '100, 100' }}"
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" 
                                        stroke="{{ $settings->quota_enabled ? '#4caf50' : '#2196f3' }}" 
                                        stroke-width="3" stroke-linecap="round" />
                                    <text x="18" y="20.35" class="percentage" text-anchor="middle" dy=".3em" font-size="8" fill="#000">
                                        {{ $settings->quota_enabled ? "$quota days" : "∞" }}
                                    </text>
                                </svg>
                            </div>
                            <p class="mb-0">{{ $settings->quota_enabled ? "$quota days remaining" : "Unlimited leave available" }}</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="col-md-8 col-12 mb-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h3 class="card-title">Your Profile</h3>
                        </div>
                        <div class="card-body d-flex flex-column align-items-center text-center gap-3">
                            <img src="{{ auth()->user()->profile_photo_url ?? asset('images/default-avatar.jpg') }}"
                                alt="User Image"
                                class="rounded-circle elevation-2"
                                style="width:120px; height:120px; object-fit: cover;">
                            <div>
                                <h5>{{ auth()->user()->name }}</h5>
                                <p class="text-muted mb-1">{{ auth()->user()->email }}</p>
                                <p class="text-muted mb-0">Member since: {{ auth()->user()->created_at->format('d F Y') }}</p>
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
</x-user-layout>

<style>
    .circular-chart {
        max-width: 120px;
        max-height: 120px;
        display: block;
        margin: 0 auto;
    }

    .circle-bg {
        fill: none;
        stroke: #eee;
        stroke-width: 3;
    }

    .circle {
        fill: none;
        stroke-width: 3;
        stroke-linecap: round;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
        stroke-dashoffset: 100;
        animation: progress-animation 1.5s ease forwards;
    }

    .percentage {
        font-family: 'Arial', sans-serif;
        font-size: 0.7rem;
        fill: #333;
        dominant-baseline: middle;
        text-anchor: middle;
    }

    @keyframes progress-animation {
        from {
            stroke-dashoffset: 100;
        }
        to {
            stroke-dashoffset: 0;
    }
    }

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