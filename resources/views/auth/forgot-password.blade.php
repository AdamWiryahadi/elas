<x-guest-layout>
    <div class="top-left-logo">
        <a href="/">
            <img src="{{ asset('images/login-leavesync.png') }}" alt="Company Logo" />
        </a>
    </div>

    <style>
        /* Base Reset */
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

        .forgot-password-page {
            width: 90vw;
            max-width: 900px;
            height: 600px;
            background: white;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            border-radius: 12px;
            display: flex;
            overflow: hidden;
        }

        .forgot-left {
            flex: 1;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .top-left-logo {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

        .top-left-logo img {
            max-width: 120px;
            height: auto;
            cursor: pointer;
        }

        .info-text {
            color: #555;
            font-size: 0.95rem;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        form {
            width: 100%;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px 15px;
            font-size: 1rem;
            border: 1.8px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus {
            border-color: rgb(168, 175, 187);
            outline: none;
        }

        .error, .input-error {
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .btn-send-link {
            margin-top: 20px;
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
        }

        .btn-send-link:hover:not(:disabled) {
            background-color: #3367d6;
        }

        .btn-send-link:disabled {
            background-color: #a3c1f7;
            cursor: not-allowed;
        }

        .forgot-right {
            flex: 1;
            position: relative;
            overflow: hidden;
            display: none;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .btn-back {
            background: transparent;
            border: none;
            color: #007bff;
            cursor: pointer;
            font-size: 1rem;
            margin: 1rem 0;
            padding: 0;
            text-align: left;
        }

        .btn-back:hover {
            text-decoration: underline;
        }


        .bg-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        @media (min-width: 900px) {
            .forgot-right {
                display: block;
            }
        }

        @media (max-width: 899px) {
            .forgot-password-page {
                flex-direction: column;
                height: auto;
            }
            .forgot-left, .forgot-right {
                width: 100%;
                flex: none;
            }
            .forgot-right {
                height: 200px;
            }
        }
    </style>

    <div class="forgot-password-page">
        <div class="forgot-left">
            <h2 class="login-title">Forgot your password?</h2>
            <div class="info-text">
                {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />
                @error('email')
                <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-send-link">
                    {{ __('Email Password Reset Link') }}
                </button>
                <button type="button" class="btn-back" onclick="window.history.back();">
                    &larr; Back
                </button>
            </form>
        </div>

        <div class="forgot-right">
            <video class="bg-video" autoplay muted loop playsinline>
                <source src="{{ asset('/images/bg.mp4') }}" type="video/mp4" />
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</x-guest-layout>
