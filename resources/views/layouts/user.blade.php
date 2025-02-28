<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'EHSv1') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <style>
        /* Notification Container */
            #notifications {
                position: fixed;
                bottom: 0;
                right: 0;
                margin: 1rem;
                z-index: 1000;
            }

            /* Base Notification Style */
            .notification {
                display: flex;
                align-items: center;
                padding: 1rem;
                margin-bottom: 1rem;
                border-radius: 0.375rem;
                font-size: 1rem;
                font-weight: 500;
                color: #fff;
                max-width: 300px;
                opacity: 0;
                transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
                transform: translateY(-20px);
            }

            /* Success Notification */
            .notification.success {
                background-color: #48bb78; /* Green */
            }

            /* Error Notification */
            .notification.error {
                background-color: #f56565; /* Red */
            }

            /* Show Notification */
            .notification.show {
                opacity: 1;
                transform: translateY(0);
            }
    </style>

</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    @include('layouts.u-partials.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.u-partials.aside')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{ $slot }}
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <div id="notifications">
        @if (session('success'))
            <div class="notification success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="notification error" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Main Footer -->
    @include('layouts.u-partials.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
<!-- Chart jss -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                notification.classList.add('show'); // Show the notification

                // Automatically hide the notification after 5 seconds
                setTimeout(() => {
                    notification.classList.remove('show'); // Hide the notification
                }, 5000); // 5000ms = 5 seconds
            });
        });
    </script>
</body>
</html>
