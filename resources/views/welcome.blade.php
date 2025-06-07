<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LeaveSync.</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon-leavesync.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset and Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9fafb;
            color: #333;
            overflow-x: hidden;
        }

        /* Container */
        .container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            gap: 20px;
        }

        /* Image Container */
        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
        }

        /* Content Container */
        .content-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 10px;
        }

        .title {
            font-size: 3rem;
            font-weight: bold;
            color: #FF2D20;
        }

        .header {
            font-size: 1.2rem;
            line-height: 1.5;
        }

        .notes {
            font-size: 0.9rem;
            font-style: italic;
            color: grey;
        }

        /* Buttons */
        .buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            background: linear-gradient(to bottom, #e63946, #d62828);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(230, 57, 70, 0.3);
        }

        .btn:hover {
            background: linear-gradient(to bottom, #d62828, #b71c1c);
            box-shadow: 0 6px 12px rgba(230, 57, 70, 0.5);
            transform: scale(1.05);
        }

        .btn:active {
            background: #b71c1c;
            box-shadow: 0 2px 6px rgba(230, 57, 70, 0.6);
            transform: scale(0.98);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 10px 0;
            background-color: rgba(255, 255, 255, 0.9);
            color: #555;
            font-size: 0.9rem;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }

        /* Logos */
        .company-logo {
            position: fixed;
            top: 20px;
            left: 40px;
            width: 60px;
            height: auto;
            z-index: 1000;
        }

        .leavesync-logo {
            position: fixed;
            top: 20px;
            right: 40px;
            width: 120px;
            height: auto;
            z-index: 1000;
        }

        /* Preloader */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #e74c3c;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .hidden {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease-out, visibility 0s linear 0.5s;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding-top: 100px;
            }

            .title {
                font-size: 2rem;
                text-align: center;
            }

            .header,
            .notes {
                text-align: center;
                font-size: 1rem;
            }

            .buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }

            .company-logo {
                width: 40px;
                top: 10px;
                left: 10px;
            }

            .leavesync-logo {
                width: 80px;
                top: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Logos -->
    <img src="{{ asset('images/enetechlogo.png') }}" alt="Company Logo" class="company-logo">
    <img src="{{ asset('images/welcome-leavesync.png') }}" alt="LeaveSync Logo" class="leavesync-logo">

    <!-- Main Content -->
    <div class="container">
        <div class="image-container">
            <img src="{{ asset('images/welcomePage.png') }}" alt="Welcome Image">
        </div>
        <div class="content-container">
            <div class="title">Need a Break?</div>
            <div class="header">
                Don't play around! Transfer RM50 first, then you can take a break.<br>
                If not, the boss will send work home! 😜
            </div>
            <div class="notes">
                <strong>***Notes:</strong> Just kidding, please make sure no work is left behind.<br>
                Thank you & Enjoy your break.
            </div>
            <div class="buttons">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn">Log In</a>
                        @if (Route::has('register'))
                            <!-- <a href="{{ route('register') }}" class="btn">Register</a> -->
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        ©2025 ENETECH SDN. BHD. Version 1.0
    </footer>

    <!-- Scripts -->
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('hidden');
        });
    </script>
</body>
</html>
