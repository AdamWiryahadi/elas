<x-guest-layout>
    <div class="top-left-logo">
        <a href="/">
            <img src="{{ asset('images/login-leavesync.png') }}" alt="Company Logo" />
        </a>
    </div>

    <style>
        /* Reset and base */
        * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .reset-page {
            width: 90vw;
            max-width: 900px;
            height: 600px;
            background: white;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            border-radius: 12px;
            display: flex;
            overflow: hidden;
        }

        /* Left form side */
        .reset-left {
            flex: 1;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .top-left-logo {
            position: fixed; /* Sticks in place when scrolling */
            top: 20px;       /* Distance from top */
            left: 20px;      /* Distance from left */
            z-index: 1000;   /* On top of other elements */
        }

        .top-left-logo img {
            max-width: 120px; /* Adjust size as needed */
            height: auto;
            cursor: pointer;
        }

        /* Title */
        .reset-title {
            font-weight: 700;
            font-size: 2.2rem;
            color: #222;
            margin-top: 8px;
            margin-bottom: 10px;
            text-align: left;
        }

        .reset-subtitle {
            font-size: 0.9rem;
            color: #555;
            margin-top: 8px;
            margin-bottom: 20px;
            font-weight: 400;
        }

        /* Input groups */
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            font-size: 1rem;
            border: 1.8px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: rgb(168, 175, 187);
            outline: none;
        }

        /* Error messages */
        .error, .input-error {
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        /* Reset button */
        .btn-reset {
            width: 100%;
            padding: 15px;
            background-color: #4285F4;
            border: none;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .btn-reset:hover:not(:disabled) {
            background-color: #3367d6;
        }

        .btn-reset:disabled {
            background-color: #a3c1f7;
            cursor: not-allowed;
        }

        /* Right side video */
        .reset-right {
            flex: 1;
            position: relative;
            overflow: hidden;
            display: none; /* Hidden on small screens */
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .bg-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        /* Responsive */
        @media (min-width: 900px) {
            .reset-right {
                display: block;
            }
        }

        @media (max-width: 899px) {
            .reset-page {
                flex-direction: column;
                height: auto;
            }
            .reset-left, .reset-right {
                width: 100%;
                flex: none;
            }
            .reset-right {
                height: 200px;
            }
        }
    </style>

    <div class="reset-page">
        <div class="reset-left">
            <h2 class="reset-title">Reset Your Password</h2>
            <p class="reset-subtitle">Set a new password to access your account securely.</p>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="input-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    @error('email')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" />
                    @error('password')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                    @error('password_confirmation')
                    <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-reset">{{ __('Reset Password') }}</button>
            </form>
        </div>

        <div class="reset-right">
            <video class="bg-video" autoplay muted loop playsinline>
                <source src="{{ asset('/images/bg.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</x-guest-layout>
