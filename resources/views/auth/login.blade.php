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

    .login-page {
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
    .login-left {
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
    .login-title {
      font-weight: 700;
      font-size: 2.2rem;
      color: #222;
      margin-top: 8px;
      margin-bottom: 10px;
      text-align: left;
    }

    .login-subtitle {
        font-size: 0.8rem;
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

    .input-group label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #444;
    }

    .input-group input[type="email"],
    .input-group input[type="password"],
    .input-group input[type="text"] {
        width: 100%;
        padding: 12px 45px 12px 15px;
        font-size: 1rem;
        border: 1.8px solid #ccc;
        border-radius: 8px;
        transition: border-color 0.3s ease;
    }

    .input-group input[type="email"]:focus,
    .input-group input[type="password"]:focus,
    .input-group input[type="text"]:focus {
        border-color: rgb(168, 175, 187);
        outline: none;
    }

    /* Show password icon */
    .show-password {
      position: absolute;
      top: 36px;
      right: 15px;
      cursor: pointer;
      user-select: none;
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .show-password:hover {
      opacity: 1;
    }

    .eye {
        margin-top: 5px;
    }

    /* Error messages */
    .error {
      color: #e74c3c;
      font-size: 0.875rem;
      margin-top: 5px;
    }

    /* Remember me */
    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
      user-select: none;
      font-weight: 600;
      color: #555;
    }

    .remember-me input[type="checkbox"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
    }

    .remember-me label {
        margin: 0;
        padding: 0;
    }

    /* Login button */
    .btn-login {
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
      margin-bottom: 20px;
    }

    .btn-login:hover:not(:disabled) {
      background-color: #3367d6;
    }

    .btn-login:disabled {
      background-color: #a3c1f7;
      cursor: not-allowed;
    }

    /* Google sign in */
    .btn-google-signin {
        display: inline-flex;
        padding: 8px;
        border-radius: 4px;
        background-color: transparent; /* or Google blue if you want */
        cursor: pointer;
    }

    .btn-google-signin svg {
      margin-right: 8px;
    }

    /* Forgot password */
    .forgot-link {
      display: block;
      text-align: center;
      font-weight: 600;
      color: #4285F4;
      text-decoration: none;
      margin-top: 15px;
      font-size: 0.95rem;
      transition: color 0.3s ease;
    }

    .forgot-link:hover {
      color: #2a56c6;
    }

    .register-link:hover {
        text-decoration: underline;
    }


    /* Right side video */
    .login-right {
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
      .login-right {
        display: block;
      }
    }

    @media (max-width: 899px) {
      .login-page {
        flex-direction: column;
        height: auto;
      }
      .login-left, .login-right {
        width: 100%;
        flex: none;
      }
      .login-right {
        height: 200px;
      }
    }
  </style>

  <div class="login-page">
    <div class="login-left">
      <form id="loginForm" method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        <h2 class="login-title">Welcome to LeaveSync.</h2>
        <p class="login-subtitle">Easily apply and manage your leave — all at your fingertips.</p>


        <div class="input-group">
          <label for="email">Email</label>
          <input id="email" type="email" name="email" required autofocus autocomplete="username" value="{{ old('email') }}" />
          @error('email')
            <div class="error">{{ $message }}</div>
          @enderror
        </div>

        <div class="input-group" style="position: relative;">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required autocomplete="current-password" />

        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <span id="togglePassword" title="Show/Hide Password" style="cursor:pointer; position: absolute; top: 40px; right: 10px;">
            <!-- Closed eye icon (default shown) -->
            <svg id="eye-closed" width="24" height="24" viewBox="0 0 64 64" fill="none" stroke="#555" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                <!-- Closed eyelid -->
                <path d="M2 32c10 8 20 12 30 12s20-4 30-12" />
                <!-- Lashes -->
                <line x1="16" y1="40" x2="14" y2="46"/>
                <line x1="24" y1="42" x2="24" y2="48"/>
                <line x1="40" y1="42" x2="40" y2="48"/>
                <line x1="48" y1="40" x2="50" y2="46"/>
            </svg>

            <!-- Open eye icon (hidden initially) -->
            <svg id="eye-open" width="24" height="24" viewBox="0 0 64 64" fill="none" stroke="#555" stroke-width="2" xmlns="http://www.w3.org/2000/svg" style="display:none;">
                <path d="M2 32C10 18 24 10 32 10s22 8 30 22c-8 14-22 22-30 22S10 46 2 32z"/>
                <circle cx="32" cy="32" r="8" fill="#555"/>
                <!-- Lashes -->
                <line x1="16" y1="10" x2="14" y2="4"/>
                <line x1="24" y1="8" x2="24" y2="2"/>
                <line x1="40" y1="8" x2="40" y2="2"/>
                <line x1="48" y1="10" x2="50" y2="4"/>
            </svg>
        </span>
        </div>

        <div class="input-group remember-me">
          <input id="remember_me" type="checkbox" name="remember" />
          <label for="remember_me">Remember me</label>
        </div>

        <button type="submit" class="btn-login">Log in</button>

        <div style="text-align: center; margin-top: 15px; font-size: 0.80rem; color: #555;">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" style="text-decoration: none; color: #555; font-weight: 500;">
            Forgot your password?
            </a>
        @endif
        <span style="margin: 0 10px;">|</span>
        <span>Don't have an account?</span>
            <a href="{{ route('register') }}" style="color: #e63946; font-weight: 600; text-decoration: none; margin-left: 5px;">
                Register now
            </a>
        </div>
      </form>
    </div>

    <div class="login-right">
        <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('/images/bg.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
  </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const eyeOpen = document.querySelector('#eye-open');
        const eyeClosed = document.querySelector('#eye-closed');

        if (togglePassword && passwordInput && eyeOpen && eyeClosed) {
            togglePassword.addEventListener('click', () => {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';

                eyeOpen.style.display = isHidden ? 'inline' : 'none';
                eyeClosed.style.display = isHidden ? 'none' : 'inline';
            });
        }
    });
    </script>
</x-guest-layout>
