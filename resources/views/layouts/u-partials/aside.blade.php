<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div id="loader-overlay" class="loader-overlay">
        <div class="spinner"></div>
    </div>

    <!-- Brand Logo -->
    <a href="{{ route('user.dashboard') }}" class="brand-link d-flex justify-content-center">
        <img id="sidebar-logo" src="{{ asset('images/aside-leavesync.png') }}" 
            alt="LeaveSync Logo" class="custom-brand-logo">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/user.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <div class="d-block" style="color: white;">{{ Auth::user()->name }}</div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Dashboard -->
          <li class="nav-item">
            <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <!-- Apply Leave -->
          <li class="nav-item">
            <a href="{{ route('user.applyleave') }}" class="nav-link {{ request()->routeIs('user.applyleave') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-plus"></i>
              <p>Apply Leave</p>
            </a>
          </li>

          <!-- Leaves History -->
          <li class="nav-item">
            <a href="{{ route('user.leavehistory') }}" class="nav-link {{ request()->routeIs('user.leavehistory') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Leaves History</p>
            </a>
          </li>

          <!-- Profile Settings -->
          <li class="nav-item">
            <a href="{{ route('user.profile') }}" class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>Profile Settings</p>
            </a>
          </li>

          <!-- FAQ (Bottom) -->
          <li class="nav-item mt-auto">
            <a href="{{ route('user.faq') }}" class="nav-link {{ request()->routeIs('user.faq') ? 'active' : '' }}">
              <i class="nav-icon fas fa-comments"></i>
              <p>FAQ</p>
            </a>
          </li>

          <!-- About -->
          <li class="nav-item">
            <a href="{{ route('user.about') }}" class="nav-link {{ request()->routeIs('user.about') ? 'active' : '' }}">
              <i class="nav-icon fas fa-info-circle"></i>
              <p>About</p>
            </a>
          </li>

          <!-- Logout -->
          <li class="nav-item">
            <a href="{{ route('logout') }}" 
              class="nav-link"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        </ul>
      </nav>
    </div>
    <!-- /.sidebar -->
  </aside>

  <style>
    .custom-brand-logo {
        height: 40px !important; /* Default large logo */
        width: auto !important;
        transition: all 0.3s ease-in-out;
    }

    /* Apply blur effect */
    .logo-transition {
        filter: blur(5px);
        transition: filter 0.2s ease-in-out;
    }

    /* Sidebar collapsed (Mini logo) */
    .sidebar-collapse .custom-brand-logo {
        height: 40px !important; /* Adjust mini logo size */
    }

    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .sidebar .nav-sidebar {
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .sidebar .nav-sidebar > li.nav-item.mt-auto {
      margin-top: auto;
    }

  </style>

  <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuLinks = document.querySelectorAll('.nav-sidebar .nav-link');

            menuLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    // Show the loader
                    document.getElementById('loader-overlay').style.display = 'flex';

                    // Simulate loading delay (optional: remove this in production)
                    setTimeout(() => {
                        document.getElementById('loader-overlay').style.display = 'none';
                    }, 2000);
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const logo = document.getElementById("sidebar-logo");
            const sidebar = document.querySelector(".main-sidebar");
            const body = document.body;

            function updateLogo(isCollapsed) {
                logo.classList.add("logo-transition"); // Add blur effect

                setTimeout(() => {
                    if (isCollapsed) {
                        logo.src = "{{ asset('images/aside-mini-leavesync.png') }}";
                        logo.style.height = "40px"; // Mini size
                    } else {
                        logo.src = "{{ asset('images/aside-leavesync.png') }}";
                        logo.style.height = "60px"; // Full size
                    }
                }, 200); // Change image after 0.2s

                setTimeout(() => {
                    logo.classList.remove("logo-transition"); // Remove blur effect
                }, 400); // Restore sharpness after transition
            }

            // Detect sidebar toggle (clicking the button)
            document.addEventListener("click", function (e) {
                if (e.target.closest("[data-widget='pushmenu']")) {
                    updateLogo(body.classList.contains("sidebar-collapse"));
                }
            });

            // Detect hover over sidebar when collapsed
            sidebar.addEventListener("mouseenter", function () {
                if (body.classList.contains("sidebar-collapse")) {
                    updateLogo(false); // Show full logo on hover
                }
            });

            sidebar.addEventListener("mouseleave", function () {
                if (body.classList.contains("sidebar-collapse")) {
                    updateLogo(true); // Return to mini logo when not hovering
                }
            });
        });
  </script>
