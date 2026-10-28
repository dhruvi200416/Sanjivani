<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - Sanjivani</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Chart.js -->
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--off-white);
            color: var(--dark-text);
            overflow-x: hidden;
        }

        /* ============ PRELOADER ============ */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            transition: opacity 0.5s ease;
        }

        .page-loader.hide {
            opacity: 0;
            pointer-events: none;
        }

        .loader-content {
            text-align: center;
        }

        .loader-content .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid var(--pale-green);
            border-top: 4px solid var(--primary-green);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        .loader-content p {
            color: var(--primary-green);
            font-weight: 600;
            font-size: 1.1rem;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ============ SIDEBAR ============ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark-green) 0%, var(--primary-green) 100%);
            transition: var(--transition);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            min-height: var(--topbar-height);
        }

        .sidebar-brand .brand-icon {
            width: 45px;
            height: 45px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-green);
            font-size: 1.2rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
            flex-shrink: 0;
        }

        .sidebar-brand .brand-icon img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }

        .sidebar-brand .brand-info {
            margin-left: 12px;
            transition: var(--transition);
            white-space: nowrap;
        }

        .sidebar-brand .brand-info h5 {
            color: var(--white);
            font-size: 1.2rem;
            font-weight: 800;
            margin: 0;
        }

        .sidebar-brand .brand-info span {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
        }

        .sidebar.collapsed .brand-info {
            display: none;
        }

        .sidebar-nav {
            padding: 20px 10px;
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 15px 15px 8px;
            font-weight: 600;
        }

        .sidebar.collapsed .nav-section-title {
            text-align: center;
            padding: 15px 0 8px;
            font-size: 0.6rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            margin-bottom: 5px;
            transition: var(--transition);
            position: relative;
            white-space: nowrap;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
            transform: translateX(3px);
        }

        .sidebar-link.active {
            background: linear-gradient(90deg, var(--light-green), var(--accent-green));
            color: var(--white);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
        }

        .sidebar-link i {
            font-size: 1.1rem;
            min-width: 32px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-link .link-title {
            margin-left: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .sidebar.collapsed .link-title {
            display: none;
        }

        .sidebar-link .badge {
            margin-left: auto;
            background: #FFA726;
            color: var(--white);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 20px;
        }

        .sidebar.collapsed .badge {
            display: none;
        }

        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }

        .sidebar.collapsed .sidebar-footer {
            padding: 15px 5px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: var(--white);
            padding: 10px;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #E53935;
            color: var(--white);
        }

        .sidebar.collapsed .logout-btn span {
            display: none;
        }

        /* ============ MAIN CONTENT ============ */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: var(--transition);
            background: var(--off-white);
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        /* ============ TOPBAR ============ */
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--topbar-height);
            background: var(--white);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 999;
            transition: var(--transition);
        }

        .main-content.expanded .topbar {
            left: var(--sidebar-collapsed);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .sidebar-toggle {
            background: transparent;
            border: none;
            font-size: 1.3rem;
            color: var(--primary-green);
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: var(--transition);
        }

        .sidebar-toggle:hover {
            background: var(--pale-green);
            color: var(--dark-green);
        }

        .page-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark-text);
            margin: 0;
        }

        .page-title i {
            color: var(--primary-green);
            margin-right: 8px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .topbar-search {
            position: relative;
        }

        .topbar-search input {
            padding: 9px 15px 9px 40px;
            border: 2px solid #E8E8E8;
            border-radius: 25px;
            font-size: 0.85rem;
            width: 240px;
            outline: none;
            transition: var(--transition);
            font-family: 'Poppins', sans-serif;
        }

        .topbar-search input:focus {
            border-color: var(--primary-green);
            box-shadow: 0 2px 10px rgba(46, 125, 50, 0.1);
        }

        .topbar-search i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-text);
            font-size: 0.9rem;
        }

        /* ============ Language Switcher ============ */
        .btn-lang-switch {
            background: var(--pale-green);
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
            padding: 7px 16px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-lang-switch:hover {
            background: var(--primary-green);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 5px 12px;
            border-radius: 25px;
            transition: var(--transition);
            background: transparent;
            border: none;
        }

        .user-dropdown:hover {
            background: var(--pale-green);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1rem;
        }

        .user-info {
            text-align: left;
            line-height: 1.2;
        }

        .user-info strong {
            display: block;
            font-size: 0.88rem;
            color: var(--dark-text);
        }

        .user-info span {
            font-size: 0.7rem;
            color: var(--gray-text);
        }

        .dropdown-menu-custom {
            border: none;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
            border-radius: 14px;
            padding: 8px;
            min-width: 200px;
        }

        .dropdown-menu-custom .dropdown-item {
            border-radius: 10px;
            padding: 10px 15px;
            font-size: 0.88rem;
            transition: var(--transition);
        }

        .dropdown-menu-custom .dropdown-item:hover {
            background: var(--pale-green);
        }

        /* ============ PAGE CONTENT ============ */
        .page-content {
            padding: calc(var(--topbar-height) + 30px) 30px 30px;
        }

        /* ============ CARDS ============ */
        .dashboard-card {
            background: var(--white);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 20px;
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .dashboard-card:hover {
            box-shadow: 0 8px 25px rgba(46, 125, 50, 0.18);
            transform: translateY(-2px);
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content,
            .main-content.expanded {
                margin-left: 0;
            }

            .topbar,
            .main-content.expanded .topbar {
                left: 0;
            }

            .topbar-search {
                display: none;
            }

            .sidebar-toggle {
                display: block !important;
            }

            #sidebarOverlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            #sidebarOverlay.show {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .page-title {
                display: none;
            }

            .user-info {
                display: none;
            }

            .topbar {
                padding: 0 15px;
            }

            .page-content {
                padding: calc(var(--topbar-height) + 15px) 15px 15px;
            }
        }

        /* Force white text inside profile header cards */
        .profile-header-card h2,
        .profile-header-card .role,
        .profile-header-card .meta span,
        .profile-header-card .meta span i {
            color: #FFFFFF !important;
        }

        /* Keep the edit button text green so it's visible */
        .profile-header-card .edit-profile-btn {
            color: var(--primary-green) !important;
        }
    </style>

    @yield('styles')
</head>

<body>

    <!-- ============ PRELOADER ============ -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="spinner"></div>
            <p><i class="fas fa-leaf"></i> Sanjivani</p>
        </div>
    </div>

    @php
    use App\Services\GoogleTranslator;
    use App\Models\Admin;

    // Translate all static layout strings to the active locale (Gujarati/English)
    $adminLayoutStrings = GoogleTranslator::translateBatch([
    // Brand
    'brand_name' => 'Sanjivani',
    'portal_name' => 'Admin Panel',

    // Sidebar sections
    'menu_main' => 'Main',
    'menu_mgmt' => 'Management',

    // Sidebar links
    'link_dashboard' => 'Dashboard',
    'link_orders' => 'Orders',
    'link_medicines' => 'Medicines',
    'link_pharmacies' => 'Pharmacies',
    'link_delivery' => 'Delivery Partners',
    'link_customers' => 'Customers',
    'link_villages' => 'Villages',
    'link_profile' => 'My Profile',
    'link_logout' => 'Logout',

    // Topbar & Dropdowns
    'search_placeholder' => 'Search...',
    'role_admin' => 'Administrator',
    'dd_profile' => 'My Profile',
    'dd_edit_profile' => 'Edit Profile',
    'dd_logout' => 'Logout',
    'lang_gujarati' => 'ગુજરાતી',
    'lang_english' => 'English',
    ]);

    // Fetch the admin details dynamically from database
    $adminId = session('user_id');
    $adminUser = null;

    if ($adminId) {
    $adminUser = Admin::find($adminId);
    }

    // Fallback logic for raw name
    $rawAdminName = $adminUser ? $adminUser->name : (session('admin_name') ?? 'Admin');

    // Translate the database name dynamically into the active locale (Gujarati)
    $translatedAdminName = GoogleTranslator::translate($rawAdminName);

    // Initial for the avatar circle
    $adminInitial = strtoupper(substr($translatedAdminName, 0, 1));
    @endphp

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebarOverlay"></div>

    <!-- ============ SIDEBAR ============ -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                @if(file_exists(public_path('images/Sanjivani.jpeg')))
                <img src="{{ asset('images/Sanjivani.jpeg') }}" alt="Sanjivani Logo">
                @else
                <i class="fas fa-leaf"></i>
                @endif
            </div>
            <div class="brand-info">
                <h5>{{ $adminLayoutStrings['brand_name'] }}</h5>
                <span>{{ $adminLayoutStrings['portal_name'] }}</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">{{ $adminLayoutStrings['menu_main'] }}</div>
            <a href="{{ url('/admin/dashboard') }}" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span class="link-title">{{ $adminLayoutStrings['link_dashboard'] }}</span>
            </a>
            <a href="{{ url('/admin/orders') }}" class="sidebar-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span class="link-title">{{ $adminLayoutStrings['link_orders'] }}</span>
                @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                <span class="badge">{{ $pendingOrdersCount }}</span>
                @endif
            </a>
            <a href="{{ url('/admin/medicines') }}" class="sidebar-link {{ request()->is('admin/medicines*') ? 'active' : '' }}">
                <i class="fas fa-pills"></i>
                <span class="link-title">{{ $adminLayoutStrings['link_medicines'] }}</span>
            </a>
            <a href="{{ url('/admin/pharmacies') }}" class="sidebar-link {{ request()->is('admin/pharmacies*') ? 'active' : '' }}">
                <i class="fas fa-store"></i>
                <span class="link-title">{{ $adminLayoutStrings['link_pharmacies'] }}</span>
            </a>
            <a href="{{ url('/admin/delivery-partners') }}" class="sidebar-link {{ request()->is('admin/delivery-partners*') ? 'active' : '' }}">
                <i class="fas fa-motorcycle"></i>
                <span class="link-title">{{ $adminLayoutStrings['link_delivery'] }}</span>
            </a>

            <div class="nav-section-title">{{ $adminLayoutStrings['menu_mgmt'] }}</div>
            <a href="{{ url('/admin/users') }}" class="sidebar-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span class="link-title">{{ $adminLayoutStrings['link_customers'] }}</span>
            </a>
            <a href="{{ url('/admin/villages') }}" class="sidebar-link {{ request()->is('admin/villages*') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt"></i>
                <span class="link-title">{{ $adminLayoutStrings['link_villages'] }}</span>
            </a>
            <a href="{{ url('/admin/profile') }}" class="sidebar-link {{ request()->is('admin/profile*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i>
                <span class="link-title">{{ $adminLayoutStrings['link_profile'] }}</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ url('/logout') }}" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>{{ $adminLayoutStrings['link_logout'] }}</span>
            </a>
        </div>
    </aside>

    <!-- ============ MAIN CONTENT ============ -->
    <div class="main-content" id="mainContent">

        <!-- ============ TOPBAR ============ -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle d-lg-none" id="sidebarToggleMobile">
                    <i class="fas fa-bars"></i>
                </button>
                <button class="sidebar-toggle d-none d-lg-block" id="sidebarToggleDesktop">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="page-title">
                    @yield('page_title', $adminLayoutStrings['link_dashboard'])
                </h5>
            </div>

            <div class="topbar-right">
                <div class="topbar-search d-none d-md-block">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="{{ $adminLayoutStrings['search_placeholder'] }}" autocomplete="off">
                </div>

                {{-- LANGUAGE SWITCHER BUTTON --}}
                @if(app()->getLocale() == 'gu')
                <a href="{{ route('locale.switch', 'en') }}" class="btn-lang-switch d-none d-md-inline-flex" title="Switch to English">
                    <i class="fas fa-globe"></i> {{ $adminLayoutStrings['lang_english'] }}
                </a>
                @else
                <a href="{{ route('locale.switch', 'gu') }}" class="btn-lang-switch d-none d-md-inline-flex" title="ગુજરાતીમાં બદલો">
                    <i class="fas fa-globe"></i> {{ $adminLayoutStrings['lang_gujarati'] }}
                </a>
                @endif

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            {{ $adminInitial }}
                        </div>
                        <div class="user-info d-none d-md-block">
                            <strong>{{ $translatedAdminName }}</strong>
                            <span>{{ $adminLayoutStrings['role_admin'] }}</span>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                        <li><a class="dropdown-item" href="{{ url('/admin/profile') }}"><i class="fas fa-user me-2"></i> {{ $adminLayoutStrings['dd_profile'] }}</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/edit-profile') }}"><i class="fas fa-edit me-2"></i> {{ $adminLayoutStrings['dd_edit_profile'] }}</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt me-2"></i> {{ $adminLayoutStrings['dd_logout'] }}</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- ============ PAGE CONTENT ============ -->
        <div class="page-content">
            @yield('content')
        </div>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            /* ============ HIDE PRELOADER ============ */
            // Hides the loader once the page is fully loaded
            setTimeout(function() {
                $('#pageLoader').addClass('hide');
                setTimeout(function() {
                    $('#pageLoader').remove();
                }, 500);
            }, 500); // 500ms delay for smooth animation

            /* ============ SIDEBAR TOGGLE (DESKTOP) ============ */
            $('#sidebarToggleDesktop').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
                $('#mainContent').toggleClass('expanded');
            });

            /* ============ SIDEBAR TOGGLE (MOBILE) ============ */
            $('#sidebarToggleMobile').on('click', function() {
                $('#sidebar').toggleClass('show');
                $('#sidebarOverlay').toggleClass('show');
            });

            $('#sidebarOverlay').on('click', function() {
                $('#sidebar').removeClass('show');
                $('#sidebarOverlay').removeClass('show');
            });

            /* ============ AUTO-CLOSE MOBILE SIDEBAR ON NAV CLICK ============ */
            $('.sidebar-link').on('click', function() {
                if ($(window).width() <= 991) {
                    $('#sidebar').removeClass('show');
                    $('#sidebarOverlay').removeClass('show');
                }
            });

            /* ============ RESIZE HANDLER ============ */
            $(window).on('resize', function() {
                if ($(window).width() > 991) {
                    $('#sidebar').removeClass('show');
                    $('#sidebarOverlay').removeClass('show');
                }
            });

            /* ============ TOPBAR SEARCH (NAVIGATE ON ENTER) ============ */
            $('.topbar-search input').on('keypress', function(e) {
                if (e.which === 13) {
                    var query = $(this).val().trim();
                    if (query.length > 0) {
                        // Fixed the URL spacing bug here
                        window.location.href = '{{ url("/admin/medicines?search=") }}' + encodeURIComponent(query);
                    }
                }
            });

        });
    </script>

    @yield('scripts')
</body>

</html>