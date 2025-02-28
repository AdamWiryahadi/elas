<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div id="loader-overlay" class="loader-overlay">
        <div class="spinner"></div>
    </div>

    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
      <span class="brand-text font-weight-light">E-Leave</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/user.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Welcome {{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input id="sidebar-search" class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Dashboard -->
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <!-- All Users -->
          <li class="nav-item">
            <a href="{{ route('admin.manageuser') }}" class="nav-link {{ request()->routeIs('admin.manageuser') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>All Users</p>
            </a>
          </li>

          <!-- All Leaves -->
          <li class="nav-item">
            <a href="{{ route('admin.manageleave') }}" class="nav-link {{ request()->routeIs('admin.manageleave') ? 'active' : '' }}">
              <i class="nav-icon fas fa-ticket-alt"></i>
              <p>All Leaves</p>
            </a>
          </li>

          <!-- Settings -->
          <li class="nav-item">
            <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
              <i class="nav-icon fas fa-sliders-h"></i>
              <p>Settings</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
  </aside>

  <style>
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
  </style>

  <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('sidebar-search');
            const menuItems = document.querySelectorAll('.nav-sidebar .nav-item');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value.toLowerCase();

                menuItems.forEach(function(item) {
                    const linkText = item.textContent.toLowerCase();
                    
                    if (linkText.includes(query)) {
                        item.style.display = ''; // Show matched items
                        let parentMenu = item.closest('.nav-treeview'); // If it's inside a submenu, show it
                        if (parentMenu) {
                            parentMenu.classList.add('show');
                        }
                    } else {
                        item.style.display = 'none'; // Hide non-matching items
                    }
                });
            });
        });

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
  </script>


