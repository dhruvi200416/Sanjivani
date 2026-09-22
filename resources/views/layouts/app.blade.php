<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.brand_name') }} - @yield('title', 'Online Medicine Delivery')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* --- ALL YOUR EXISTING CSS STAYS THE SAME --- */
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
            --light-gray: #F5F5F5;
            --shadow: 0 4px 15px rgba(46, 125, 50, 0.15);
            --shadow-hover: 0 8px 30px rgba(46, 125, 50, 0.25);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
            overflow-x: hidden;
            background-color: var(--white);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--pale-green);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-green);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--dark-green);
        }

        .navbar-sanjivani {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 50%, var(--light-green) 100%);
            padding: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
            transition: var(--transition);
        }

        .navbar-sanjivani.scrolled {
            background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
            box-shadow: 0 2px 30px rgba(0, 0, 0, 0.2);
        }

        .navbar-top-bar {
            background: rgba(0, 0, 0, 0.15);
            padding: 6px 0;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .navbar-top-bar a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: var(--transition);
        }

        .navbar-top-bar a:hover {
            color: var(--white);
        }

        .navbar-top-bar .separator {
            margin: 0 12px;
            opacity: 0.5;
        }

        .navbar-main {
            padding: 12px 0;
        }

        .navbar-brand-custom {
            display: flex;
            align-items: center;
            text-decoration: none;
            gap: 12px;
        }

        .navbar-brand-custom .brand-logo {
            width: 50px;
            height: 50px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: var(--transition);
        }

        .navbar-brand-custom:hover .brand-logo {
            transform: rotate(10deg) scale(1.05);
        }

        .navbar-brand-custom .brand-logo img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }

        .navbar-brand-custom .brand-logo i {
            font-size: 1.5rem;
            color: var(--primary-green);
        }

        .navbar-brand-custom .brand-text {
            display: flex;
            flex-direction: column;
        }

        .navbar-brand-custom .brand-name {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--white);
            line-height: 1.1;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand-custom .brand-tagline {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .nav-link-custom {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 8px 18px !important;
            border-radius: 25px;
            transition: var(--transition);
            position: relative;
            margin: 0 3px;
        }

        .nav-link-custom::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--white);
            transition: var(--transition);
            border-radius: 2px;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: var(--white) !important;
            background: rgba(255, 255, 255, 0.15);
        }

        .nav-link-custom:hover::after,
        .nav-link-custom.active::after {
            width: 60%;
        }

        .navbar-auth-btns {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-nav-login {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.7);
            color: var(--white);
            padding: 8px 24px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-nav-login:hover {
            background: var(--white);
            color: var(--primary-green);
            border-color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        .btn-nav-register {
            background: var(--white);
            border: 2px solid var(--white);
            color: var(--primary-green);
            padding: 8px 24px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-nav-register:hover {
            background: var(--off-white);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
            color: var(--dark-green);
        }

        /* ==== LANGUAGE SWITCH BUTTON (new) ==== */
        .btn-lang-switch {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.6);
            color: var(--white);
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
            background: var(--white);
            color: var(--primary-green);
            border-color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        .navbar-toggler-custom {
            border: 2px solid rgba(255, 255, 255, 0.5);
            padding: 8px 12px;
            border-radius: 8px;
            transition: var(--transition);
        }

        .navbar-toggler-custom:hover {
            border-color: var(--white);
            background: rgba(255, 255, 255, 0.1);
        }

        .navbar-toggler-custom .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .footer-sanjivani {
            background: linear-gradient(180deg, var(--dark-green) 0%, #0D3311 100%);
            color: rgba(255, 255, 255, 0.85);
            position: relative;
            overflow: hidden;
        }

        .footer-wave {
            position: absolute;
            top: -2px;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .footer-wave svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 70px;
        }

        .footer-wave .shape-fill {
            fill: var(--white);
        }

        .footer-top {
            padding: 90px 0 50px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .footer-brand .brand-icon {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, var(--light-green), var(--accent-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
        }

        .footer-brand .brand-icon i {
            font-size: 1.5rem;
            color: var(--white);
        }

        .footer-brand h3 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--white);
            margin: 0;
        }

        .footer-desc {
            font-size: 0.9rem;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 25px;
            max-width: 350px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .footer-social a {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1rem;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-social a:hover {
            background: var(--light-green);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
        }

        .footer-heading {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 12px;
        }

        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, var(--light-green), var(--accent-green));
            border-radius: 2px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-links li a i {
            font-size: 0.7rem;
            transition: var(--transition);
        }

        .footer-links li a:hover {
            color: var(--accent-green);
            padding-left: 5px;
        }

        .footer-contact-item {
            display: flex;
            gap: 15px;
            margin-bottom: 18px;
        }

        .footer-contact-item .icon-box {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-green);
            font-size: 0.9rem;
        }

        .footer-contact-item .contact-text {
            font-size: 0.85rem;
            line-height: 1.6;
        }

        .footer-contact-item .contact-text strong {
            display: block;
            color: var(--white);
            font-weight: 600;
            margin-bottom: 2px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 0;
            text-align: center;
        }

        .footer-bottom p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            margin: 0;
        }

        .footer-bottom a {
            color: var(--accent-green);
            text-decoration: none;
            font-weight: 600;
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.4);
            z-index: 9998;
            border: none;
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.5);
        }

        .btn-sanjivani {
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            color: var(--white);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-sanjivani:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: var(--white);
        }

        .btn-sanjivani-outline {
            background: transparent;
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            padding: 10px 28px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-sanjivani-outline:hover {
            background: var(--primary-green);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .sanjivani-alert {
            position: fixed;
            top: 120px;
            right: 20px;
            z-index: 10000;
            min-width: 300px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-hover);
            animation: slideInRight 0.5s ease;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 991px) {
            .navbar-main {
                padding: 10px 0;
            }

            .navbar-collapse {
                background: rgba(27, 94, 32, 0.98);
                border-radius: 15px;
                padding: 20px;
                margin-top: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .nav-link-custom {
                padding: 12px 18px !important;
                margin: 3px 0;
            }

            .navbar-auth-btns {
                flex-direction: column;
                margin-top: 10px;
                padding-top: 15px;
                border-top: 1px solid rgba(255, 255, 255, 0.15);
            }

            .btn-nav-login,
            .btn-nav-register,
            .btn-lang-switch {
                width: 100%;
                text-align: center;
                justify-content: center;
            }

            .navbar-brand-custom .brand-name {
                font-size: 1.3rem;
            }

            .navbar-top-bar {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .newsletter-form {
                flex-direction: column;
            }

            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 42px;
                height: 42px;
                font-size: 1rem;
            }
        }

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
    </style>

    @yield('styles')
</head>

<body>

    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="spinner"></div>
            <p><i class="fas fa-leaf"></i> {{ __('messages.brand_name') }}</p>
        </div>
    </div>

    <nav class="navbar-sanjivani" id="mainNavbar">
        <div class="navbar-top-bar d-none d-lg-block">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="mailto:support@sanjivani.com"><i class="fas fa-envelope me-1"></i> support@sanjivani.com</a>
                        <span class="separator">|</span>
                        <a href="tel:+919876543210"><i class="fas fa-phone me-1"></i> +91 98765 43210</a>
                    </div>
                    <div>
                        <a href="#"><i class="fas fa-truck me-1"></i> {{ __('messages.topbar_delivery') }}</a>
                        <span class="separator">|</span>
                        <a href="#"><i class="fas fa-shield-halved me-1"></i> {{ __('messages.topbar_genuine') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="navbar-main">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ url('/') }}" class="navbar-brand-custom">
                        <div class="brand-logo">
                            @if(file_exists(public_path('images/Sanjivani.jpeg')))
                            <img src="{{ asset('images/Sanjivani.jpeg') }}" alt="Sanjivani Logo">
                            @else
                            <i class="fas fa-leaf"></i>
                            @endif
                        </div>
                        <div class="brand-text">
                            <span class="brand-name">{{ __('messages.brand_name') }}</span>
                            <span class="brand-tagline">{{ __('messages.brand_tagline') }}</span>
                        </div>
                    </a>

                    <button class="navbar-toggler-custom d-lg-none" type="button" onclick="toggleMobileMenu()">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="d-none d-lg-flex align-items-center gap-1" id="desktopNav">
                        <a href="{{ url('/') }}" class="nav-link-custom {{ request()->is('/') ? 'active' : '' }}">
                            <i class="fas fa-home me-1"></i> {{ __('messages.nav_home') }}
                        </a>
                        <a href="{{ url('/about') }}" class="nav-link-custom {{ request()->is('about') ? 'active' : '' }}">
                            <i class="fas fa-info-circle me-1"></i> {{ __('messages.nav_about') }}
                        </a>
                        <a href="{{ url('/contact') }}" class="nav-link-custom {{ request()->is('contact') ? 'active' : '' }}">
                            <i class="fas fa-envelope me-1"></i> {{ __('messages.nav_contact') }}
                        </a>
                    </div>

                    <div class="navbar-auth-btns d-none d-lg-flex">
                        {{-- ========== LANGUAGE SWITCHER BUTTON ========== --}}
                        @if(app()->getLocale() == 'gu')
                        <a href="{{ route('locale.switch', 'en') }}" class="btn-lang-switch" title="Switch to English">
                            <i class="fas fa-globe"></i> {{ __('messages.lang_english') }}
                        </a>
                        @else
                        <a href="{{ route('locale.switch', 'gu') }}" class="btn-lang-switch" title="ગુજરાતીમાં બદલો">
                            <i class="fas fa-globe"></i> {{ __('messages.lang_gujarati') }}
                        </a>
                        @endif

                        @if(session('user_id'))
                        @php
                        $role = session('user_role');
                        $dashboardUrl = '#';
                        if($role == 'admin') $dashboardUrl = url('/admin/dashboard');
                        elseif($role == 'customer') $dashboardUrl = url('/customer/dashboard');
                        elseif($role == 'pharmacy') $dashboardUrl = url('/pharmacy/dashboard');
                        elseif($role == 'delivery') $dashboardUrl = url('/delivery/dashboard');
                        @endphp
                        <a href="{{ $dashboardUrl }}" class="btn-nav-login">
                            <i class="fas fa-tachometer-alt me-1"></i> {{ __('messages.nav_dashboard') }}
                        </a>
                        <a href="{{ url('/logout') }}" class="btn-nav-register">
                            <i class="fas fa-sign-out-alt me-1"></i> {{ __('messages.nav_logout') }}
                        </a>
                        @else
                        <a href="{{ url('/login') }}" class="btn-nav-login">
                            <i class="fas fa-sign-in-alt me-1"></i> {{ __('messages.nav_login') }}
                        </a>
                        <a href="{{ url('/register') }}" class="btn-nav-register">
                            <i class="fas fa-user-plus me-1"></i> {{ __('messages.nav_register') }}
                        </a>
                        @endif
                    </div>
                </div>

                <div class="d-lg-none" id="mobileMenu" style="display: none;">
                    <div class="navbar-collapse mt-3">
                        <a href="{{ url('/') }}" class="nav-link-custom d-block {{ request()->is('/') ? 'active' : '' }}">
                            <i class="fas fa-home me-2"></i> {{ __('messages.nav_home') }}
                        </a>
                        <a href="{{ url('/about') }}" class="nav-link-custom d-block {{ request()->is('about') ? 'active' : '' }}">
                            <i class="fas fa-info-circle me-2"></i> {{ __('messages.nav_about') }}
                        </a>
                        <a href="{{ url('/contact') }}" class="nav-link-custom d-block {{ request()->is('contact') ? 'active' : '' }}">
                            <i class="fas fa-envelope me-2"></i> {{ __('messages.nav_contact') }}
                        </a>
                        <div class="navbar-auth-btns">
                            {{-- Language Switcher (mobile) --}}
                            @if(app()->getLocale() == 'gu')
                            <a href="{{ route('locale.switch', 'en') }}" class="btn-lang-switch">
                                <i class="fas fa-globe"></i> {{ __('messages.lang_english') }}
                            </a>
                            @else
                            <a href="{{ route('locale.switch', 'gu') }}" class="btn-lang-switch">
                                <i class="fas fa-globe"></i> {{ __('messages.lang_gujarati') }}
                            </a>
                            @endif

                            @if(session('user_id'))
                            <a href="{{ $dashboardUrl ?? '#' }}" class="btn-nav-login">
                                <i class="fas fa-tachometer-alt me-1"></i> {{ __('messages.nav_dashboard') }}
                            </a>
                            <a href="{{ url('/logout') }}" class="btn-nav-register">
                                <i class="fas fa-sign-out-alt me-1"></i> {{ __('messages.nav_logout') }}
                            </a>
                            @else
                            <a href="{{ url('/login') }}" class="btn-nav-login">
                                <i class="fas fa-sign-in-alt me-1"></i> {{ __('messages.nav_login') }}
                            </a>
                            <a href="{{ url('/register') }}" class="btn-nav-register">
                                <i class="fas fa-user-plus me-1"></i> {{ __('messages.nav_register') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
    <div class="sanjivani-alert alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="sanjivani-alert alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <main>@yield('content')</main>

    <footer class="footer-sanjivani">
        <div class="footer-wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>

        <div class="footer-top">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-brand">
                            <div class="brand-icon"><i class="fas fa-leaf"></i></div>
                            <h3>{{ __('messages.brand_name') }}</h3>
                        </div>
                        <p class="footer-desc">{{ __('messages.footer_desc') }}</p>
                        <div class="footer-social">
                            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                            <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <h5 class="footer-heading">{{ __('messages.footer_quick_links') }}</h5>
                        <ul class="footer-links">
                            <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> {{ __('messages.nav_home') }}</a></li>
                            <li><a href="{{ url('/about') }}"><i class="fas fa-chevron-right"></i> {{ __('messages.footer_about_us') }}</a></li>
                            <li><a href="{{ url('/contact') }}"><i class="fas fa-chevron-right"></i> {{ __('messages.nav_contact') }}</a></li>
                            <li><a href="{{ url('/login') }}"><i class="fas fa-chevron-right"></i> {{ __('messages.nav_login') }}</a></li>
                            <li><a href="{{ url('/register') }}"><i class="fas fa-chevron-right"></i> {{ __('messages.nav_register') }}</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <h5 class="footer-heading">{{ __('messages.footer_services') }}</h5>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-chevron-right"></i> {{ __('messages.footer_medicine_delivery') }}</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> {{ __('messages.footer_prescription') }}</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> {{ __('messages.footer_health_checkup') }}</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> {{ __('messages.footer_lab_tests') }}</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> {{ __('messages.footer_health_tips') }}</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <h5 class="footer-heading">{{ __('messages.footer_contact_us') }}</h5>
                        <div class="footer-contact-item">
                            <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="contact-text">
                                <strong>{{ __('messages.footer_address') }}</strong>
                                {{ __('messages.footer_address_value') }}
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <div class="icon-box"><i class="fas fa-phone-alt"></i></div>
                            <div class="contact-text">
                                <strong>{{ __('messages.footer_phone') }}</strong>
                                {{ __('messages.footer_phone_value') }}
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <div class="icon-box"><i class="fas fa-envelope"></i></div>
                            <div class="contact-text">
                                <strong>{{ __('messages.footer_email') }}</strong>
                                support@sanjivani.com
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <div class="icon-box"><i class="fas fa-clock"></i></div>
                            <div class="contact-text">
                                <strong>{{ __('messages.footer_working_hours') }}</strong>
                                {{ __('messages.footer_working_hours_value') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p>
                    &copy; {{ date('Y') }} <a href="{{ url('/') }}">Sanjivani</a>. {{ __('messages.footer_rights') }}
                    {{ __('messages.footer_made_with') }} <i class="fas fa-heart text-danger"></i> {{ __('messages.footer_for_healthcare') }}
                </p>
            </div>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
        $(window).on('load', function() {
            setTimeout(function() {
                $('#pageLoader').addClass('hide');
                setTimeout(function() {
                    $('#pageLoader').remove();
                }, 500);
            }, 800);
        });
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 50) $('#mainNavbar').addClass('scrolled');
            else $('#mainNavbar').removeClass('scrolled');
            if ($(this).scrollTop() > 300) $('#backToTop').addClass('visible');
            else $('#backToTop').removeClass('visible');
        });

        function toggleMobileMenu() {
            $('#mobileMenu').slideToggle(300);
        }

        function scrollToTop() {
            $('html, body').animate({
                scrollTop: 0
            }, 600);
        }
        setTimeout(function() {
            $('.sanjivani-alert').fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>

    @yield('scripts')
</body>

</html>