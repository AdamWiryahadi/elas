<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>eLeave</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f9fafb;
            font-family: 'Arial', sans-serif;
            padding: 20px; /* Ensure padding for small screens */
            overflow: hidden;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 1200px; /* Limit container width on large screens */
            gap: 20px;
        }

        .image-container, .content-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image {
            max-width: 100%;
            height: auto;
            border-radius: 100px;
        }

        .content-container {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            padding: 10px;
        }

        .title {
            font-size: 96px;
            font-weight: bold;
            color: #FF2D20;
        }

        .header {
            font-size: 18px;
            color: #333;
        }

        .notes {
            font-size: 14px;
            font-style: italic;
            color: grey;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 24px;
            background: linear-gradient(to bottom, #e63946, #d62828); /* Red gradient */
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(230, 57, 70, 0.3);
            display: inline-block;
        }

        /* Hover Effect */
        .btn:hover {
            background: linear-gradient(to bottom, #d62828, #b71c1c); /* Darker red */
            box-shadow: 0 6px 12px rgba(230, 57, 70, 0.5);
            transform: scale(1.05);
        }

        /* Active Click Effect */
        .btn:active {
            background: #b71c1c; /* Even darker red */
            box-shadow: 0 2px 6px rgba(230, 57, 70, 0.6);
            transform: scale(0.98);
        }

        /* Optional: Button Text Style */
        .btn span {
            letter-spacing: 1px;
            text-transform: uppercase;
        }


        .footer {
            text-align: center;
            padding: 10px 0;
            background-color: #f1f1f1;
            color: #555;
            font-size: 14px;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Only mobile styles */
        @media (max-width: 768px) {
            body {
                height: auto;
            }

            .container {
                flex-direction: column;
                gap: 20px;
            }

            .title {
                font-size: 36px;
                text-align: center;
            }

            .header, .notes {
                text-align: center;
            }

            .buttons {
                justify-content: center;
                width: 100%;
            }

            .btn {
                width: 100%; /* Make buttons full width on mobile */
            }
        }

        .helpline-btn {
            position: fixed;
            bottom: 55px;
            right: 20px;
            background-color: #FF2D20; /* Bright red */
            color: white;
            padding: 12px 20px;
            border-radius: 50px; /* Rounded button */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            font-size: 14px;
            font-weight: bold;
            text-decoration: none; /* Removes underline */
            transition: all 0.3s ease;
            z-index: 1000; /* Stays on top */
            border: none;
            text-align: center;
            cursor: pointer;
        }

        .helpline-btn:hover {
            background-color: #D8261B; /* Darker red on hover */
            transform: translateY(-3px); /* Lift effect */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        .helpline-btn:active {
            background-color: #B02018; /* Even darker when clicked */
            transform: translateY(0); /* Button press effect */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .company-logo {
            position: fixed;
            top: 20px;  /* Adjust as needed */
            left: 40px;  /* Adjust as needed */
            width: 60px;  /* Set width */
            height: auto;  /* Keep aspect ratio */
            z-index: 1000;  /* Ensure it stays on top */
        }

        /* Fade-in animation for containers */
        .container {
            opacity: 0;
            animation: fadeIn 1s ease-out forwards; /* Fade in with a duration of 1 second */
        }

        /* Fade-in effect for image and content */
        .image-container, .content-container {
            opacity: 0;
            transform: translateY(30px); /* Start below and move up */
            animation: fadeInUp 1.2s ease-out forwards;
            animation-delay: 0.5s; /* Delay to stagger the animations */
        }

        /* Title fade-in */
        .title {
            opacity: 0;
            animation: fadeIn 1s ease-out forwards;
            animation-delay: 1s;
        }

        /* Header fade-in */
        .header {
            opacity: 0;
            animation: fadeIn 1s ease-out forwards;
            animation-delay: 1.2s;
        }

        /* Notes fade-in */
        .notes {
            opacity: 0;
            animation: fadeIn 1s ease-out forwards;
            animation-delay: 1.4s;
        }

        /* Buttons bounce in */
        .buttons a {
            opacity: 0;
            transform: translateY(20px);
            animation: bounceIn 0.9s ease forwards;
            animation-delay: 1.6s;
        }

        /* Keyframes for animations */
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            60% {
                opacity: 1;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Full-page preloader */
        #preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.9); /* Light overlay */
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }

            /* Spinning Loader */
            .loader {
                width: 50px;
                height: 50px;
                border: 5px solid #e74c3c; /* Red border */
                border-top-color: transparent;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            /* Loader Animation */
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Hide preloader when page loads */
            .hidden {
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.5s ease-out, visibility 0s linear 0.5s;
            }
    </style>
</head>
<a href="tel:+601137882324" class="helpline-btn">
  <i class="fa fa-headset"></i>. Any Problems ?
</a>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- Company Logo -->
    <img src="{{ asset('images/enetechlogo.png') }}" alt="Company Logo" class="company-logo">

    <div class="container">
        <div class="image-container">
            <img src="{{ asset('images/welcomePage.png') }}" alt="Welcome Image" class="image">
        </div>

        <div class="content-container">
        <div class="title">Need a Break?</div>
        <div class="header">Don't play around! Transfer RM50 first, then you can take a break.<br>If not, the boss will send work home! 😜</div><br>
        <div class="notes"><b>***Notes:</b> Just kidding, please make sure no work is left behind, <br> Thank you & Enjoy your break.</div>

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

    <footer class="footer">
        © 2025 ENETECH Sdn Bhd. All rights reserved.
    </footer>
</body>
</html>

<script>
    window.onload = function() {
        document.getElementById("preloader").classList.add("hidden");
    };
</script>