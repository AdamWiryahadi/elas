<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>{{ config('app.name', 'LeaveSync.') }}</title>
  <link rel="shortcut icon" href="{{ asset('images/favicon-leavesync.ico') }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      opacity: 0;
      transition: opacity 1.0s ease;
    }

    body.fade-in {
      opacity: 1;
    }
    body.fade-out {
      opacity: 0;
      pointer-events: none;
    }

    .content-wrapper {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .auth-footer {
      text-align: center;
      padding: 15px 0;
      font-size: 0.85rem;
      color: #999;
    }
  </style>
</head>
<body>
  <div class="content-wrapper">
    {{ $slot }}
  </div>

  <div class="auth-footer">
    &copy; 2025 ENETECH SDN. BHD. Version 1.0
  </div>

  <script>
    window.onload = () => {
      document.body.classList.add('fade-in');
      document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', (e) => {
          const href = link.getAttribute('href');
          if(href && href.startsWith('/') && !link.target) {
            e.preventDefault();
            document.body.classList.remove('fade-in');
            document.body.classList.add('fade-out');
            setTimeout(() => {
              window.location = href;
            }, 1000); // must match CSS transition duration
          }
        });
      });
    }
  </script>
</body>
</html>
