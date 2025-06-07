<x-guest-layout>
    <div class="top-left-logo">
        <a href="/">
            <img src="{{ asset('images/login-leavesync.png') }}" alt="Company Logo" />
        </a>
    </div>

    <style>
      /* Copy of the login page styles */
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
        height: 700px; /* a bit taller for more fields */
        background: white;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        border-radius: 12px;
        display: flex;
        overflow: hidden;
      }

      .login-left {
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

      .error {
        color: #e74c3c;
        font-size: 0.875rem;
        margin-top: 5px;
      }

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

      .login-right {
        flex: 1;
        position: relative;
        overflow: hidden;
        display: none;
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
        <form method="POST" action="{{ route('register') }}" class="login-form">
          @csrf

          <h2 class="login-title">Create your account</h2>
          <p class="login-subtitle">Join LeaveSync and manage your leave with ease.</p>

          <div class="input-group">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" required autofocus autocomplete="name" value="{{ old('name') }}" />
            @error('name')
              <div class="error">{{ $message }}</div>
            @enderror
          </div>

          <div class="input-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required autocomplete="username" value="{{ old('email') }}" />
            @error('email')
              <div class="error">{{ $message }}</div>
            @enderror
          </div>

          <div class="input-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" />
            @error('password')
              <div class="error">{{ $message }}</div>
            @enderror
            <span class="show-password" onclick="togglePassword('password')" title="Show/Hide Password" style="cursor:pointer;">
              <svg class="eye" width="20" height="20" fill="#555" viewBox="0 0 24 24">
                <path d="M12 4.5C7 4.5 2.73 8.11 1 12c1.73 3.89 6 7.5 11 7.5s9.27-3.61 11-7.5c-1.73-3.89-6-7.5-11-7.5zm0 13a5.5 5.5 0 110-11 5.5 5.5 0 010 11z"/>
                <circle cx="12" cy="12" r="2.5"/>
              </svg>
            </span>
          </div>

          <div class="input-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <span class="show-password" onclick="togglePassword('password_confirmation')" title="Show/Hide Password" style="cursor:pointer;">
              <svg class="eye" width="20" height="20" fill="#555" viewBox="0 0 24 24">
                <path d="M12 4.5C7 4.5 2.73 8.11 1 12c1.73 3.89 6 7.5 11 7.5s9.27-3.61 11-7.5c-1.73-3.89-6-7.5-11-7.5zm0 13a5.5 5.5 0 110-11 5.5 5.5 0 010 11z"/>
                <circle cx="12" cy="12" r="2.5"/>
              </svg>
            </span>
          </div>

          <button type="submit" class="btn-login">Register</button>

          <div style="text-align: center; margin-top: 15px; font-size: 0.80rem; color: #555;">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}" style="color: #e63946; font-weight: 600; text-decoration: none; margin-left: 5px;">
              Log in
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
      function togglePassword(id) {
        const passwordField = document.getElementById(id);
        if (passwordField.type === "password") {
          passwordField.type = "text";
        } else {
          passwordField.type = "password";
        }
      }
    </script>
</x-guest-layout>
