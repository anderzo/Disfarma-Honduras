<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farmacia</title>

  <meta name="description" content="Spark Admin - Premium Bootstrap 5 Admin Dashboard Template">
  <meta name="author" content="Spark Admin Team">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">

  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/apexcharts/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body>

  <!-- ==========================================
         START: Sidebar Component
         Highly polished, dark-green sticky navigation
         ========================================== -->
  <div class="sidebar-wrapper" id="sidebar">
    <!-- Brand Logo / Identity -->
    <a href="index.html" class="sidebar-brand">
      <i class="bi bi-asterisk"></i>
      <span>DISFARMA HONDURAS</span>
    </a>

    <!-- Navigation Menu -->
    <div class="flex-grow-1 overflow-y-auto">
      <!-- Group: Menu -->
      <div class="sidebar-menu-section">
        <div class="sidebar-menu-title">Menu</div>
        <ul class="sidebar-menu-list">
          <li class="sidebar-menu-item">
            <a href="index.html" class="sidebar-menu-link active" id="menu-overview" title="Overview">
              <i class="bi bi-grid-fill"></i>
              <span>Dashboard</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Group: Components -->
         <li class="sidebar-menu-item">
            <a href="{{ route('medicamentos.index') }}" class="sidebar-menu-link" id="menu-basictables" title="Catálogo de Medicamentos">
              <i class="bi bi-capsule"></i>
              <span>Catálogo</span>
            </a>
          </li>
          <li class="sidebar-menu-item">
            <a href="{{ route('proveedores.index') }}" class="sidebar-menu-link" id="menu-uiforms" title="Proveedores">
              <i class="bi bi-input-cursor-text"></i>
              <span>Proveedores</span>
            </a>
          </li>
          </li>
          <li class="sidebar-menu-item">
            <a href="ui-buttons.html" class="sidebar-menu-link" id="menu-uibuttons" title="Buttons">
              <i class="bi bi-menu-button-wide-fill"></i>
              <span>Empleados</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="sidebar-menu-section">
        <div class="sidebar-menu-title">Pages</div>
        <ul class="sidebar-menu-list">
          <li class="sidebar-menu-item">
            <a href="page-blank.html" class="sidebar-menu-link" id="menu-blankpage" title="Blank Page">
              <i class="bi bi-file-earmark"></i>
              <span>Blank Page</span>
            </a>
          </li>
          <li class="sidebar-menu-item">
            <a href="page-login.html" class="sidebar-menu-link" id="menu-loginpage" title="Login Page">
              <i class="bi bi-box-arrow-in-right"></i>
              <span>Login Screen</span>
            </a>
          </li>
          <li class="sidebar-menu-item">
            <a href="page-404.html" class="sidebar-menu-link" id="menu-404" title="404 Page">
              <i class="bi bi-slash-circle"></i>
              <span>Error 404</span>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Sidebar Profile Card (Dynamic Footer) -->
    <div class="sidebar-profile">
      <img src="{{ asset('assets/images/avatar.png') }}" alt="Administrator" class="sidebar-profile-img"
        onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop'">
      <div class="sidebar-profile-info">
        <div class="sidebar-profile-name">{{ Auth::user()->usuario ?? 'Admin' }}</div>
        <div class="sidebar-profile-email">admin@email.com</div>
      </div>
    </div>
  </div>
  <!-- ==========================================
         END: Sidebar Component
         ========================================== -->


  <!-- ==========================================
         START: Main Content Area
         ========================================== -->
  <div class="main-wrapper">

    <!-- START: Top Navbar Component -->
    <header class="navbar-custom">
      <div class="navbar-left">
        <!-- Desktop sidebar toggle (visible on large screens only) -->
        <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
          id="desktop-sidebar-toggle" aria-label="Minimize Sidebar">
          <i class="bi bi-chevron-bar-left"></i>
        </button>
        <!-- Mobile sidebar toggle -->
        <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
          <i class="bi bi-list"></i>
        </button>

        <!-- Quick Actions Dropdown -->
        <div class="dropdown ms-2">
          <button class="btn-quick-action dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
            id="quick-actions-dropdown">
            <i class="bi bi-plus-lg"></i>
            <span>Create</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-quick-action" aria-labelledby="quick-actions-dropdown">
            <li class="dropdown-header">Quick Action Shortcuts</li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-plus"></i> Nueva</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-person-plus"></i> Nuevo Usuario</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-box-seam"></i> Nuevo Producto</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
          </ul>
        </div>
      </div>

      <!-- Mid navbar: search pill -->
      <div class="navbar-search-wrapper">
        <input type="text" class="navbar-search-input" placeholder="Search anything in Spark..." id="main-search">
        <button class="navbar-search-btn" aria-label="Search">
          <i class="bi bi-search"></i>
        </button>
      </div>

      <!-- Right actions -->
      <div class="navbar-actions">
        <!-- Fullscreen Toggle -->
        <button class="navbar-action-btn me-1" aria-label="Toggle Fullscreen" id="btn-fullscreen">
          <i class="bi bi-arrows-fullscreen"></i>
        </button>
        <div class="dropdown">
          <button class="navbar-action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false" id="btn-notifications" data-bs-auto-close="outside">
            <i class="bi bi-bell"></i>
            <span class="navbar-action-badge"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-notification p-0"
            aria-labelledby="btn-notifications">
            <div class="notification-header">
              <h6 class="notification-title">Notifications</h6>
              <button class="btn-clear-all" type="button">Mark all read</button>
            </div>
            <div class="notification-list">
              <!-- Sale Notification -->
              <a href="#" class="notification-item">
                <div class="notification-icon bg-success text-white">
                  <i class="bi bi-wallet2"></i>
                </div>
                <div class="notification-content">
                  <p class="notification-text">New sale received: <strong>$150.00</strong></p>
                  <span class="notification-time">2 mins ago</span>
                </div>
                <span class="notification-unread-dot"></span>
              </a>
              <!-- User Registration Notification -->
              <a href="#" class="notification-item">
                <div class="notification-icon bg-primary text-white">
                  <i class="bi bi-person-plus-fill"></i>
                </div>
                <div class="notification-content">
                  <p class="notification-text">New user registered: <strong>John Doe</strong></p>
                  <span class="notification-time">1 hour ago</span>
                </div>
                <span class="notification-unread-dot"></span>
              </a>
              <!-- Low Stock Notification -->
              <a href="#" class="notification-item">
                <div class="notification-icon bg-warning text-dark">
                  <i class="bi bi-box-seam-fill"></i>
                </div>
                <div class="notification-content">
                  <p class="notification-text">Stock running low: <strong>Hoodie</strong></p>
                  <span class="notification-time">3 hours ago</span>
                </div>
              </a>
            </div>
            <a href="#" class="notification-footer">View All Notifications</a>
          </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="dropdown ms-2">
          <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false" id="profile-dropdown">
            <img src="{{ asset('assets/images/avatar.png') }}" alt="Profile Image" class="navbar-profile-img">
            <span class="navbar-profile-name d-none d-md-inline">{{ Auth::user()->usuario ?? 'Admin' }}</span>
            <i class="bi bi-chevron-down navbar-profile-caret"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile" aria-labelledby="profile-dropdown">
            <li class="dropdown-header">Welcome !</li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> My Account</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-lock"></i> Lock Screen</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                  <i class="bi bi-box-arrow-right"></i> Cerrar Secion
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </header>
    <!-- END: Top Navbar Component -->

    <!-- START: Dashboard Header Banner -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">An easy way to manage sales with care and precision.</p>
      </div>
      <button class="btn-date-picker" type="button" id="date-picker-trigger">
        <i class="bi bi-calendar4-event"></i>
        <span id="selected-date-range">January 12, 2026 - January 23, 2026</span>
        <i class="bi bi-chevron-down ms-1"></i>
      </button>
    </div>
    <!-- END: Dashboard Header Banner -->

    <!-- START: Main Layout Grid (2 Columns: Dashboard + Performance Pane) -->
    <div class="row g-4">

      <!-- TOP AREA: Quick Info Stat Cards Row (Full Width) -->
      <div class="col-12">
        <div class="row g-4">
          <!-- Stat Card 1: Green Alert Banner -->
          <div class="col-md-4">
            <div class="card alert-green-card">
              <div class="position-relative z-index-2">
                <span class="alert-green-badge">Update</span>
                <div class="alert-green-date">Feb 14th 2026</div>
                <div class="alert-green-text">Sales revenue increased 40% in 1 week</div>
              </div>
              <a href="#" class="alert-green-link z-index-2" id="alert-link-statistics">
                <span>See Statistics</span>
                <i class="bi bi-arrow-right"></i>
              </a>

              <!-- Inline SVG geometric decoration (Lime green 6-pointed star/asterisk with rounded caps) -->
              <svg class="alert-green-bg-shape" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g transform="translate(50,50)">
                  <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" />
                  <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(60)" />
                  <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(120)" />
                </g>
              </svg>
            </div>
          </div>

          <!-- Stat Card 2: Net Income -->
          <div class="col-md-4">
            <div class="card card-stat d-flex flex-column justify-content-between">
              <div>
                <div class="card-header">
                  <span class="stat-label">Net Income</span>
                  <div class="dropdown">
                    <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                      aria-label="More Options" id="btn-more-income">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                      <li><a class="dropdown-item" href="#"><i class="bi bi-arrow-repeat"></i> Refresh</a></li>
                      <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-arrow-down"></i> Export
                          Report</a></li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-eye-slash"></i> Hide Details</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="stat-value">$196.000</div>
                <div class="trend-badge trend-up">
                  <i class="bi bi-arrow-up-right"></i>
                  <span>+35% from last month</span>
                </div>
              </div>
              <div class="sparkline-container sparkline-card-footer">
                <div id="income-sparkline"></div>
              </div>
            </div>
          </div>

          <!-- Stat Card 3: Total Return -->
          <div class="col-md-4">
            <div class="card card-stat d-flex flex-column justify-content-between">
              <div>
                <div class="card-header">
                  <span class="stat-label">Total Return</span>
                  <div class="dropdown">
                    <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                      aria-label="More Options" id="btn-more-return">
                      <i class="bi bi-three-dots"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                      <li><a class="dropdown-item" href="#"><i class="bi bi-arrow-repeat"></i> Refresh</a></li>
                      <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-arrow-down"></i> Export
                          Report</a></li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-eye-slash"></i> Hide Details</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="stat-value">$32.000</div>
                <div class="trend-badge trend-down">
                  <i class="bi bi-arrow-down-left"></i>
                  <span>-24% from last month</span>
                </div>
              </div>
              <div class="sparkline-container sparkline-card-footer">
                <div id="return-sparkline"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END: TOP AREA -->

      </div>

    <!-- START: Footer Component -->
    <footer class="footer-custom">
      <div class="footer-left">
        <span class="footer-logo">
          <i class="bi bi-asterisk"></i> DISFARMA HONDURAS
        </span>
        <span class="footer-separator">|</span>
        <span class="footer-copy">&copy; 2026 Droguería y Distribuidora Farmacéutica San Rafael S. de R.L.</span>
      </div>
      <div class="footer-right">
        <ul class="footer-links">
          <li><a href="#" class="footer-link">Dashboard</a></li>
          <li><a href="#" class="footer-link">Medicamentos</a></li>
          <li><a href="#" class="footer-link">Proveedores</a></li>
          <li><a href="#" class="footer-link">Empleados <span class="status-dot"></span></a></li>
        </ul>
      </div>
    </footer>
    <!-- END: Footer Component -->

  </div>
  <!-- ==========================================
         END: Main Content Area
         ========================================== -->

  <!-- Local Third-Party Libraries Script dependencies -->
  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>

  <!-- Local dashboard interactions controller -->
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>