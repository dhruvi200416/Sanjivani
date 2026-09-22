@extends('layouts.app')

@section('title', 'Login - Access Your Account')

@section('styles')
<style>
    /* ============ AUTH WRAPPER ============ */
    .auth-section {
        min-height: 100vh;
        padding: 120px 0 60px;
        background: linear-gradient(135deg, var(--pale-green) 0%, var(--off-white) 50%, var(--white) 100%);
        position: relative;
        overflow: hidden;
    }

    .auth-section::before {
        content: '';
        position: absolute;
        top: -150px;
        right: -150px;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(76, 175, 80, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .auth-section::after {
        content: '';
        position: absolute;
        bottom: -200px;
        left: -150px;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(46, 125, 50, 0.12) 0%, transparent 70%);
        border-radius: 50%;
    }

    .auth-wrap {
        max-width: 1100px;
        margin: 0 auto;
        background: var(--white);
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 25px 70px rgba(46, 125, 50, 0.2);
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    /* ============ LEFT SIDE - BRANDING ============ */
    .auth-left {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        padding: 50px 45px;
        color: var(--white);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .auth-left::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .auth-left::after {
        content: '\f484';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        bottom: -30px;
        right: -20px;
        font-size: 12rem;
        opacity: 0.08;
        color: var(--white);
    }

    .auth-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 2;
    }

    .auth-brand .brand-icon {
        width: 55px;
        height: 55px;
        background: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .auth-brand .brand-icon i,
    .auth-brand .brand-icon img {
        color: var(--primary-green);
        font-size: 1.5rem;
    }

    .auth-brand .brand-icon img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
    }

    .auth-brand h4 {
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: 1px;
    }

    .auth-brand span {
        font-size: 0.72rem;
        letter-spacing: 1.5px;
        opacity: 0.9;
        text-transform: uppercase;
        display: block;
    }

    .auth-welcome {
        position: relative;
        z-index: 2;
        margin: 30px 0;
    }

    .auth-welcome h2 {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.25;
        margin-bottom: 15px;
    }

    .auth-welcome p {
        font-size: 0.95rem;
        opacity: 0.92;
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .auth-features {
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .auth-features li {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
        font-size: 0.9rem;
    }

    .auth-features li .icon {
        width: 32px;
        height: 32px;
        min-width: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 0.75rem;
    }

    .auth-bottom-link {
        position: relative;
        z-index: 2;
        padding-top: 25px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        margin-top: 25px;
        font-size: 0.88rem;
    }

    .auth-bottom-link a {
        color: var(--white);
        font-weight: 700;
        text-decoration: none;
        border-bottom: 1px dashed rgba(255, 255, 255, 0.5);
        padding-bottom: 2px;
        transition: var(--transition);
    }

    .auth-bottom-link a:hover {
        color: #C8E6C9;
        border-color: #C8E6C9;
    }

    /* ============ RIGHT SIDE - FORM ============ */
    .auth-right {
        padding: 50px 45px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-title {
        font-size: 1.9rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 8px;
    }

    .auth-subtitle {
        color: var(--gray-text);
        font-size: 0.92rem;
        margin-bottom: 30px;
    }

    /* Role Selector Tabs */
    .role-tabs {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        background: var(--pale-green);
        padding: 6px;
        border-radius: 14px;
        margin-bottom: 25px;
    }

    .role-tab {
        padding: 10px 6px;
        text-align: center;
        border-radius: 10px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--gray-text);
        background: transparent;
        border: none;
    }

    .role-tab i {
        display: block;
        font-size: 1.1rem;
        margin-bottom: 4px;
    }

    .role-tab:hover {
        color: var(--primary-green);
    }

    .role-tab.active {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
    }

    /* Form Groups */
    .form-group-auth {
        margin-bottom: 20px;
        position: relative;
    }

    .form-label-auth {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 8px;
        display: block;
    }

    .form-label-auth .required {
        color: #E53935;
    }

    .input-wrap {
        position: relative;
    }

    .form-control-auth {
        width: 100%;
        padding: 13px 45px 13px 44px;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        font-size: 0.94rem;
        font-family: 'Poppins', sans-serif;
        background: var(--white);
        transition: var(--transition);
        outline: none;
    }

    .form-control-auth:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.12);
    }

    .form-control-auth.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .form-control-auth.success {
        border-color: var(--light-green);
        background: #F1F8E9;
    }

    .input-icon-left {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-green);
        font-size: 0.95rem;
        pointer-events: none;
    }

    .input-icon-right {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-text);
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .input-icon-right:hover {
        color: var(--primary-green);
    }

    .error-message {
        color: #E53935;
        font-size: 0.78rem;
        margin-top: 6px;
        display: none;
        font-weight: 500;
    }

    .error-message.show {
        display: block;
        animation: shake 0.4s;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Remember + Forgot */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .remember-check {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        user-select: none;
    }

    .remember-check input[type="checkbox"] {
        appearance: none;
        width: 18px;
        height: 18px;
        border: 2px solid #CCC;
        border-radius: 5px;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }

    .remember-check input[type="checkbox"]:checked {
        background: var(--primary-green);
        border-color: var(--primary-green);
    }

    .remember-check input[type="checkbox"]:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--white);
        font-size: 0.75rem;
        font-weight: 800;
    }

    .remember-check label {
        font-size: 0.85rem;
        color: var(--gray-text);
        margin: 0;
        cursor: pointer;
    }

    .forgot-link {
        color: var(--primary-green);
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
    }

    .forgot-link:hover {
        color: var(--dark-green);
        text-decoration: underline;
    }

    /* Submit Button */
    .btn-auth-submit {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 14px 30px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.25);
    }

    .btn-auth-submit:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(46, 125, 50, 0.4);
    }

    .btn-auth-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Divider */
    .auth-divider {
        text-align: center;
        margin: 25px 0;
        position: relative;
    }

    .auth-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #E0E0E0;
    }

    .auth-divider span {
        background: var(--white);
        padding: 0 15px;
        color: var(--gray-text);
        font-size: 0.82rem;
        position: relative;
    }

    /* Register Link */
    .auth-register-link {
        text-align: center;
        color: var(--gray-text);
        font-size: 0.9rem;
    }

    .auth-register-link a {
        color: var(--primary-green);
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
    }

    .auth-register-link a:hover {
        color: var(--dark-green);
        text-decoration: underline;
    }

    /* Alert */
    .auth-alert {
        padding: 12px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 0.88rem;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideDown 0.4s;
    }

    @keyframes slideDown {
        from { transform: translateY(-10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .auth-alert.success {
        background: #E8F5E9;
        color: #1B5E20;
        border: 1px solid #A5D6A7;
    }

    .auth-alert.error {
        background: #FFEBEE;
        color: #B71C1C;
        border: 1px solid #EF9A9A;
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 991px) {
        .auth-wrap {
            grid-template-columns: 1fr;
            max-width: 550px;
        }
        .auth-left {
            padding: 40px 35px;
        }
        .auth-welcome h2 {
            font-size: 1.6rem;
        }
        .auth-right {
            padding: 40px 35px;
        }
    }

    @media (max-width: 576px) {
        .auth-section {
            padding: 100px 15px 40px;
        }
        .auth-left, .auth-right {
            padding: 30px 25px;
        }
        .auth-title {
            font-size: 1.5rem;
        }
        .role-tabs {
            grid-template-columns: repeat(2, 1fr);
        }
        .role-tab {
            padding: 8px 4px;
            font-size: 0.72rem;
        }
        .form-options {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')

<section class="auth-section">
    <div class="container">
        <div class="auth-wrap" data-aos="zoom-in">

            <!-- ============ LEFT SIDE - BRANDING ============ -->
            <div class="auth-left">
                <div class="auth-brand">
                    <div class="brand-icon">
                        @if(file_exists(public_path('images/Sanjivani.jpeg')))
                            <img src="{{ asset('images/Sanjivani.jpeg') }}" alt="Sanjivani">
                        @else
                            <i class="fas fa-leaf"></i>
                        @endif
                    </div>
                    <div>
                        <h4>Sanjivani</h4>
                        <span>Your Health Priority</span>
                    </div>
                </div>

                <div class="auth-welcome">
                    <h2>Welcome Back!<br>Great to See You Again</h2>
                    <p>
                        Log in to access your account and manage your medicine orders, prescriptions,
                        or pharmacy dashboard — all in one place.
                    </p>

                    <ul class="auth-features">
                        <li>
                            <div class="icon"><i class="fas fa-check"></i></div>
                            <span>Track your medicine orders in real-time</span>
                        </li>
                        <li>
                            <div class="icon"><i class="fas fa-check"></i></div>
                            <span>Upload prescriptions easily & securely</span>
                        </li>
                        <li>
                            <div class="icon"><i class="fas fa-check"></i></div>
                            <span>Fast doorstep delivery in 2-4 hours</span>
                        </li>
                        <li>
                            <div class="icon"><i class="fas fa-check"></i></div>
                            <span>24/7 customer support available</span>
                        </li>
                    </ul>
                </div>

                <div class="auth-bottom-link">
                    <i class="fas fa-user-plus me-2"></i>
                    New here? <a href="{{ url('/register') }}">Create an account</a>
                </div>
            </div>

            <!-- ============ RIGHT SIDE - LOGIN FORM ============ -->
            <div class="auth-right">
                <h2 class="auth-title">Sign In</h2>
                <p class="auth-subtitle">Choose your account type and enter your credentials to continue.</p>

                <!-- Session Alerts -->
                @if(session('login_error'))
                    <div class="auth-alert error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('login_error') }}
                    </div>
                @endif

                @if(session('register_success'))
                    <div class="auth-alert success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('register_success') }}
                    </div>
                @endif

                <!-- Role Tabs -->
                <div class="role-tabs">
                    <button type="button" class="role-tab active" data-role="customer">
                        <i class="fas fa-user"></i> Customer
                    </button>
                    <button type="button" class="role-tab" data-role="pharmacy">
                        <i class="fas fa-store"></i> Pharmacy
                    </button>
                    <button type="button" class="role-tab" data-role="delivery">
                        <i class="fas fa-motorcycle"></i> Delivery
                    </button>
                    <button type="button" class="role-tab" data-role="admin">
                        <i class="fas fa-user-shield"></i> Admin
                    </button>
                </div>

                <!-- Login Form -->
                <form id="loginForm" action="{{ url('/login') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="role" id="roleInput" value="customer">

                    <div class="form-group-auth">
                        <label class="form-label-auth">Email Address <span class="required">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope input-icon-left"></i>
                            <input type="email" name="email" id="email"
                                   class="form-control-auth"
                                   placeholder="you@example.com"
                                   value="{{ old('email') }}"
                                   autocomplete="email">
                        </div>
                        <span class="error-message" id="emailError"></span>
                    </div>

                    <div class="form-group-auth">
                        <label class="form-label-auth">Password <span class="required">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon-left"></i>
                            <input type="password" name="password" id="password"
                                   class="form-control-auth"
                                   placeholder="Enter your password"
                                   autocomplete="current-password">
                            <i class="fas fa-eye input-icon-right" id="togglePassword"></i>
                        </div>
                        <span class="error-message" id="passwordError"></span>
                    </div>

                    <div class="form-options">
                        <div class="remember-check">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="#" class="forgot-link" onclick="alert('Password reset feature coming soon!'); return false;">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" class="btn-auth-submit" id="submitBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login to Account</span>
                    </button>

                    <div class="auth-divider">
                        <span>OR</span>
                    </div>

                    <div class="auth-register-link">
                        Don't have an account yet?
                        <a href="{{ url('/register') }}">Register Now</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* =============================================
       ROLE TAB SWITCHING
    ============================================= */
    $('.role-tab').on('click', function () {
        $('.role-tab').removeClass('active');
        $(this).addClass('active');
        var role = $(this).data('role');
        $('#roleInput').val(role);

        // Update placeholder based on role
        var placeholders = {
            'customer': 'you@example.com',
            'pharmacy': 'pharmacy@example.com',
            'delivery': 'delivery@example.com',
            'admin':    'admin@example.com'
        };
        $('#email').attr('placeholder', placeholders[role]);
    });

    // Auto-select role if passed via URL (?role=pharmacy)
    var urlParams = new URLSearchParams(window.location.search);
    var roleParam = urlParams.get('role');
    if (roleParam) {
        var $tab = $('.role-tab[data-role="' + roleParam + '"]');
        if ($tab.length) $tab.trigger('click');
    }

    /* =============================================
       PASSWORD SHOW / HIDE
    ============================================= */
    $('#togglePassword').on('click', function () {
        var $pwd = $('#password');
        var type = $pwd.attr('type') === 'password' ? 'text' : 'password';
        $pwd.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    /* =============================================
       VALIDATION HELPERS
    ============================================= */
    function showError($input, message) {
        $input.addClass('error').removeClass('success');
        $input.closest('.form-group-auth').find('.error-message')
              .text(message).addClass('show');
    }

    function showSuccess($input) {
        $input.addClass('success').removeClass('error');
        $input.closest('.form-group-auth').find('.error-message')
              .text('').removeClass('show');
    }

    function clearField($input) {
        $input.removeClass('error success');
        $input.closest('.form-group-auth').find('.error-message')
              .text('').removeClass('show');
    }

    /* -------- Email Validation -------- */
    function validateEmail() {
        var $el = $('#email');
        var value = $.trim($el.val());
        var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (value === '') {
            showError($el, '⚠ Please enter your email address.');
            return false;
        }
        if (!regex.test(value)) {
            showError($el, '⚠ Please enter a valid email address.');
            return false;
        }
        if (value.length > 100) {
            showError($el, '⚠ Email address is too long.');
            return false;
        }
        showSuccess($el);
        return true;
    }

    /* -------- Password Validation -------- */
    function validatePassword() {
        var $el = $('#password');
        var value = $el.val();

        if (value === '') {
            showError($el, '⚠ Please enter your password.');
            return false;
        }
        if (value.length < 6) {
            showError($el, '⚠ Password must be at least 6 characters.');
            return false;
        }
        if (value.length > 50) {
            showError($el, '⚠ Password is too long.');
            return false;
        }
        showSuccess($el);
        return true;
    }

    /* =============================================
       REAL-TIME VALIDATION
    ============================================= */
    $('#email').on('blur', validateEmail);
    $('#password').on('blur', validatePassword);

    $('#email, #password').on('input', function () {
        if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
            clearField($(this));
        }
    });

    /* =============================================
       FORM SUBMIT
    ============================================= */
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        var isValid = true;
        if (!validateEmail())    isValid = false;
        if (!validatePassword()) isValid = false;

        if (!isValid) {
            var $firstError = $('.form-control-auth.error').first();
            if ($firstError.length) {
                $('html, body').animate({
                    scrollTop: $firstError.offset().top - 150
                }, 400);
                $firstError.focus();
            }
            return false;
        }

        // Loading state
        var $btn = $('#submitBtn');
        var original = $btn.html();
        $btn.prop('disabled', true).html(
            '<i class="fas fa-spinner fa-spin"></i> <span>Logging In...</span>'
        );

        this.submit();
    });

    /* =============================================
       AUTO-HIDE ALERTS
    ============================================= */
    setTimeout(function () {
        $('.auth-alert').fadeOut(500);
    }, 6000);

});
</script>
@endsection