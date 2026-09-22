<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pharmacy Dashboard') - Sanjivani</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>

    <style>
        :root {
            --primary-green: #2E7D32;
            --dark-green: #1B5E20;
            --light-green: #4CAF50;
            --accent-green: #66BB6A;
            --pale-green: #E8F5E9;
            --mint-green: #C8E6C9;
            --white: #FFFFFF;
            --off-white: #F1F8E9;
            --dark-text: #1A1A2E;
            --gray-text: #555555;
            --sidebar-width: 260px;
            --sidebar-collapsed: 78px;
            --topbar-height: 70px;
            --transition: all 0.3s ease;
            --shadow: 0 4px 15px rgba(46, 125, 50, 0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--off-white);
            color: var(--dark-text);
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark-green) 0%, var(--primary-green) 100%);
            transition: var(--transition); z-index: 1000; overflow-y: auto;
        }

        .sidebar.collapsed { width: var(--sidebar-collapsed); }

        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 5px; }

        .sidebar-brand {
            display: flex; align-items: center; justify-content: center;
            padding: 20px 15px; border-bottom: 1px solid rgba(255,255,255,0.1);
            min-height: var(--topbar-height);
        }

        .sidebar-brand .brand-icon {
            width: 45px; height: 45px; background: var(--white);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; color: var(--primary-green);
            font-size: 1.2rem; box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            flex-shrink: 0; overflow: hidden;
        }

        .sidebar-brand .brand-icon img {
            width: 38px; height: 38px; border-radius: 50%; object-fit: cover;
        }

        .sidebar-brand .brand-info {
            margin-left: 12px; transition: var(--transition); white-space: nowrap;
        }

        .sidebar-brand .brand-info h5 {
            color: var(--white); font-size: 1.15rem; font-weight: 800; margin: 0;
        }

        .sidebar-brand .brand-info span {
            color: rgba(255,255,255,0.7); font-size: 0.62rem;
            text-transform: uppercase; letter-spacing: 1px; display: block;
        }

        .sidebar.collapsed .brand-info { display: none; }

        .sidebar-nav { padding: 20px 10px; }

        .nav-section-title {
            color: rgba(255,255,255,0.5); font-size: 0.7rem;
            text-transform: uppercase; letter-spacing: 2px;
            padding: 15px 15px 8px; font-weight: 600;
        }

        .sidebar.collapsed .nav-section-title {
            text-align: center; padding: 15px 0 8px; font-size: 0.6rem;
        }

        .sidebar-link {
            display: flex; align-items: center; padding: 12px 15px;
            border-radius: 12px; color: rgba(255,255,255,0.85);
            text-decoration: none; margin-bottom: 5px;
            transition: var(--transition); white-space: nowrap;
        }

        .sidebar-link:hover {
            background: rgba(255,255,255,0.1); color: var(--white);
            transform: translateX(3px);
        }

        .sidebar-link.active {
            background: linear-gradient(90deg, var(--light-green), var(--accent-green));
            color: var(--white); box-shadow: 0 4px 12px rgba(76,175,80,0.4);
        }

        .sidebar-link i { font-size: 1.1rem; min-width: 32px; text-align: center; }

        .sidebar-link .link-title {
            margin-left: 12px; font-size: 0.9rem; font-weight: 500;
        }

        .sidebar.collapsed .link-title { display: none; }

        .sidebar-link .badge-count {
            margin-left: auto; background: #FFA726; color: var(--white);
            font-size: 0.65rem; font-weight: 700; padding: 4px 8px;
            border-radius: 20px;
        }

        .sidebar.collapsed .badge-count { display: none; }

        .sidebar-footer {
            padding: 15px; border-top: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar.collapsed .sidebar-footer { padding: 15px 5px; }

        .logout-btn {
            display: flex; align-items: center; justify-content: center;
            gap: 10px; background: rgba(255,255,255,0.1); border: none;
            color: var(--white); padding: 10px; border-radius: 12px;
            cursor: pointer; transition: var(--transition);
            width: 100%; text-decoration: none;
        }

        .logout-btn:hover { background: #E53935; color: var(--white); }
        .sidebar.collapsed .logout-btn span { display: none; }

        .main-content {
            margin-left: var(--sidebar-width); min-height: 100vh;
            transition: var(--transition);
        }

        .main-content.expanded { margin-left: var(--sidebar-collapsed); }

        .topbar {
            position: fixed; top: 0; right: 0; left: var(--sidebar-width);
            height: var(--topbar-height); background: var(--white);
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 30px; z-index: 999; transition: var(--transition);
        }

        .main-content.expanded .topbar { left: var(--sidebar-collapsed); }

        .topbar-left { display: flex; align-items: center; gap: 20px; }

        .sidebar-toggle {
            background: transparent; border: none; font-size: 1.3rem;
            color: var(--primary-green); cursor: pointer; padding: 8px;
            border-radius: 8px; transition: var(--transition);
        }

        .sidebar-toggle:hover { background: var(--pale-green); }

        .page-title {
            font-size: 1.2rem; font-weight: 700; color: var(--dark-text); margin: 0;
        }

        .page-title i { color: var(--primary-green); margin-right: 8px; }

        .topbar-right { display: flex; align-items: center; gap: 18px; }

        .topbar-icon {
            position: relative; width: 42px; height: 42px; border-radius: 50%;
            background: var(--pale-green); display: flex; align-items: center;
            justify-content: center; color: var(--primary-green);
            font-size: 1.05rem; cursor: pointer; transition: var(--transition);
            border: none; text-decoration: none;
        }

        .topbar-icon:hover { background: var(--light-green); color: var(--white); }

        .topbar-icon .notif-badge {
            position: absolute; top: -2px; right: -2px; background: #E53935;
            color: var(--white); min-width: 18px; height: 18px; padding: 0 4px;
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; font-size: 0.6rem; font-weight: 700;
            border: 2px solid var(--white);
        }

        .user-dropdown {
            display: flex; align-items: center; gap: 12px;
            cursor: pointer; padding: 5px 12px; border-radius: 25px;
            transition: var(--transition); background: transparent; border: none;
        }

        .user-dropdown:hover { background: var(--pale-green); }

        .user-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            display: flex; align-items: center; justify-content: center;
            color: var(--white); font-weight: 700; font-size: 1rem;
        }

        .user-info { text-align: left; line-height: 1.2; }
        .user-info strong { display: block; font-size: 0.88rem; color: var(--dark-text); }
        .user-info span { font-size: 0.7rem; color: var(--gray-text); }

        .dropdown-menu-custom {
            border: none; box-shadow: 0 10px 35px rgba(0,0,0,0.15);
            border-radius: 14px; padding: 8px; min-width: 200px;
        }

        .dropdown-menu-custom .dropdown-item {
            border-radius: 10px; padding: 10px 15px;
            font-size: 0.88rem; transition: var(--transition);
        }

        .dropdown-menu-custom .dropdown-item:hover { background: var(--pale-green); }

        .page-content {
            padding: calc(var(--topbar-height) + 30px) 30px 30px;
        }

        .flash-alert {
            padding: 12px 20px; border-radius: 12px; margin-bottom: 20px;
            font-size: 0.9rem; display: flex; align-items: center; gap: 10px;
            animation: slideDown 0.4s;
        }

        @keyframes slideDown {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .flash-alert.success {
            background: #E8F5E9; color: #1B5E20; border-left: 4px solid #2E7D32;
        }

        .flash-alert.error {
            background: #FFEBEE; color: #B71C1C; border-left: 4px solid #C62828;
        }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content, .main-content.expanded { margin-left: 0; }
            .topbar, .main-content.expanded .topbar { left: 0; }
            #sidebarOverlay {
                display: none; position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5); z-index: 999;
            }
            #sidebarOverlay.show { display: block; }
        }

        @media (max-width: 768px) {
            .page-title { display: none; }
            .user-info { display: none; }
            .topbar { padding: 0 15px; }
            .page-content { padding: calc(var(--topbar-height) + 15px) 15px 15px; }
        }
    </style>

    @yield('styles')
</head>
<body>

    <div id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                @if(file_exists(public_path('images/Sanjivani.jpeg')))
                    <img src="{{ asset('images/Sanjivani.jpeg') }}" alt="Sanjivani">
                @else
                    <i class="fas fa-leaf"></i>
                @endif
            </div>
            <div class="brand-info">
                <h5>Sanjivani</h5>
                <span>Pharmacy Portal</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Main</div>
            <a href="{{ url('/pharmacy/dashboard') }}" class="sidebar-link {{ request()->is('pharmacy/dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span class="link-title">Dashboard</span>
            </a>
            <a href="{{ url('/pharmacy/orders') }}" class="sidebar-link {{ request()->is('pharmacy/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span class="link-title">Orders</span>
                @if(session('pending_orders') && session('pending_orders') > 0)
                    <span class="badge-count">{{ session('pending_orders') }}</span>
                @endif
            </a>
            <a href="{{ url('/pharmacy/medicines') }}" class="sidebar-link {{ request()->is('pharmacy/medicines*') ? 'active' : '' }}">
                <i class="fas fa-pills"></i>
                <span class="link-title">My Medicines</span>
            </a>
            <a href="{{ url('/pharmacy/add-medicine') }}" class="sidebar-link {{ request()->is('pharmacy/add-medicine*') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i>
                <span class="link-title">Add Medicine</span>
            </a>

            <div class="nav-section-title">Account</div>
            <a href="{{ url('/pharmacy/profile') }}" class="sidebar-link {{ request()->is('pharmacy/profile*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i>
                <span class="link-title">My Profile</span>
            </a>
            <a href="{{ url('/') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span class="link-title">Back to Home</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ url('/logout') }}" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <div class="main-content" id="mainContent">
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle d-lg-none" id="sidebarToggleMobile">
                    <i class="fas fa-bars"></i>
                </button>
                <button class="sidebar-toggle d-none d-lg-block" id="sidebarToggleDesktop">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="page-title">@yield('page_title', 'Dashboard')</h5>
            </div>

            <div class="topbar-right">
                <div class="dropdown">
                    <button class="topbar-icon" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="notif-badge">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-custom" style="width:310px;">
                        <h6 style="padding:10px 15px;margin:0;font-weight:700;border-bottom:1px solid #EEE;">Notifications</h6>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-shopping-cart me-2" style="color:var(--primary-green);"></i>
                            New order received
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-exclamation-triangle me-2" style="color:#FB8C00;"></i>
                            Low stock alert
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-check-circle me-2" style="color:#2E7D32;"></i>
                            Payment received
                        </a>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="user-dropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(session('pharmacy_name') ?? 'P', 0, 1)) }}
                        </div>
                        <div class="user-info d-none d-md-block">
                            <strong>{{ session('pharmacy_name') ?? 'My Pharmacy' }}</strong>
                            <span>Pharmacy</span>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                        <li><a class="dropdown-item" href="{{ url('/pharmacy/profile') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="{{ url('/pharmacy/medicines') }}"><i class="fas fa-pills me-2"></i> Medicines</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="page-content">
            @if(session('success'))
                <div class="flash-alert success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash-alert error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#sidebarToggleDesktop').on('click', function () {
                $('#sidebar').toggleClass('collapsed');
                $('#mainContent').toggleClass('expanded');
            });

            $('#sidebarToggleMobile').on('click', function () {
                $('#sidebar').toggleClass('show');
                $('#sidebarOverlay').toggleClass('show');
            });

            $('#sidebarOverlay').on('click', function () {
                $('#sidebar').removeClass('show');
                $('#sidebarOverlay').removeClass('show');
            });

            $('.sidebar-link').on('click', function () {
                if ($(window).width() <= 991) {
                    $('#sidebar').removeClass('show');
                    $('#sidebarOverlay').removeClass('show');
                }
            });

            setTimeout(function () { $('.flash-alert').fadeOut(500); }, 5000);
        });
    </script>

    @yield('scripts')
</body>
</html>