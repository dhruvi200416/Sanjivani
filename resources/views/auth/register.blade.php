@extends('layouts.app')

@section('title', 'Register - Create Your Account')

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
        max-width: 1200px;
        margin: 0 auto;
        background: var(--white);
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 25px 70px rgba(46, 125, 50, 0.2);
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 4fr 6fr;
    }

    /* ============ LEFT SIDE - BRANDING ============ */
    .auth-left {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        padding: 45px 40px;
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
        content: '\f0f9';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        bottom: -30px;
        right: -20px;
        font-size: 12rem;
        opacity: 0.08;
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

    .auth-brand .brand-icon i {
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
        margin: 25px 0;
    }

    .auth-welcome h2 {
        font-size: 1.9rem;
        font-weight: 800;
        line-height: 1.3;
        margin-bottom: 15px;
    }

    .auth-welcome p {
        font-size: 0.92rem;
        opacity: 0.92;
        line-height: 1.7;
        margin-bottom: 22px;
    }

    .role-benefits {
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .role-benefits li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
        font-size: 0.85rem;
        line-height: 1.5;
    }

    .role-benefits li .icon {
        width: 30px;
        height: 30px;
        min-width: 30px;
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
        padding-top: 22px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        margin-top: 22px;
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
        padding: 40px 45px;
        max-height: 95vh;
        overflow-y: auto;
    }

    .auth-right::-webkit-scrollbar {
        width: 6px;
    }
    .auth-right::-webkit-scrollbar-track { background: var(--pale-green); }
    .auth-right::-webkit-scrollbar-thumb { background: var(--primary-green); border-radius: 10px; }

    .auth-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 8px;
    }

    .auth-subtitle {
        color: var(--gray-text);
        font-size: 0.9rem;
        margin-bottom: 25px;
    }

    /* Role Selector Tabs */
    .role-tabs {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        background: var(--pale-green);
        padding: 6px;
        border-radius: 14px;
        margin-bottom: 25px;
    }

    .role-tab {
        padding: 12px 6px;
        text-align: center;
        border-radius: 10px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--gray-text);
        background: transparent;
        border: none;
    }

    .role-tab i {
        display: block;
        font-size: 1.15rem;
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

    /* Section Title in Form */
    .form-section-title {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary-green);
        margin: 20px 0 15px;
        padding-bottom: 8px;
        border-bottom: 2px dashed var(--mint-green);
    }

    .form-section-title i {
        margin-right: 6px;
    }

    /* Form Groups */
    .form-group-auth {
        margin-bottom: 18px;
        position: relative;
    }

    .form-label-auth {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 6px;
        display: block;
    }

    .form-label-auth .required {
        color: #E53935;
    }

    .input-wrap {
        position: relative;
    }

    .form-control-auth,
    .form-select-auth {
        width: 100%;
        padding: 11px 45px 11px 42px;
        border: 2px solid #E0E0E0;
        border-radius: 11px;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        background: var(--white);
        transition: var(--transition);
        outline: none;
    }

    .form-select-auth {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 12px;
    }

    textarea.form-control-auth {
        min-height: 80px;
        resize: vertical;
        padding-top: 12px;
    }

    .form-control-auth:focus,
    .form-select-auth:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.12);
    }

    .form-control-auth.error,
    .form-select-auth.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .form-control-auth.success,
    .form-select-auth.success {
        border-color: var(--light-green);
        background: #F1F8E9;
    }

    .input-icon-left {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-green);
        font-size: 0.9rem;
        pointer-events: none;
    }

    textarea + .input-icon-left {
        top: 20px;
        transform: none;
    }

    .input-icon-right {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-text);
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .input-icon-right:hover {
        color: var(--primary-green);
    }

    .error-message {
        color: #E53935;
        font-size: 0.75rem;
        margin-top: 5px;
        display: none;
        font-weight: 500;
    }

    .error-message.show {
        display: block;
        animation: shake 0.4s;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }

    /* Password Strength */
    .password-strength {
        margin-top: 6px;
        display: none;
    }

    .password-strength.show {
        display: block;
    }

    .strength-bar {
        width: 100%;
        height: 5px;
        background: #E0E0E0;
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .strength-fill {
        height: 100%;
        width: 0%;
        transition: all 0.3s;
        border-radius: 3px;
    }

    .strength-text {
        font-size: 0.72rem;
        font-weight: 600;
    }

    /* Terms Checkbox */
    .terms-check {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin: 15px 0 22px;
    }

    .terms-check input[type="checkbox"] {
        appearance: none;
        width: 18px;
        height: 18px;
        min-width: 18px;
        border: 2px solid #CCC;
        border-radius: 5px;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        margin-top: 2px;
    }

    .terms-check input[type="checkbox"]:checked {
        background: var(--primary-green);
        border-color: var(--primary-green);
    }

    .terms-check input[type="checkbox"]:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--white);
        font-size: 0.75rem;
        font-weight: 800;
    }

    .terms-check label {
        font-size: 0.82rem;
        color: var(--gray-text);
        margin: 0;
        cursor: pointer;
        line-height: 1.6;
    }

    .terms-check label a {
        color: var(--primary-green);
        font-weight: 600;
        text-decoration: none;
    }

    .terms-check label a:hover {
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
        margin: 20px 0;
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

    /* Login Link */
    .auth-login-link {
        text-align: center;
        color: var(--gray-text);
        font-size: 0.88rem;
    }

    .auth-login-link a {
        color: var(--primary-green);
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
    }

    .auth-login-link a:hover {
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

    /* Role Info Card (dynamic) */
    .role-info-card {
        background: var(--pale-green);
        border-left: 4px solid var(--primary-green);
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 0.85rem;
        color: var(--dark-text);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .role-info-card i {
        color: var(--primary-green);
        font-size: 1.1rem;
    }

    /* Role sections toggle */
    .role-fields {
        display: none;
    }

    .role-fields.active {
        display: block;
        animation: fadeIn 0.4s;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 991px) {
        .auth-wrap {
            grid-template-columns: 1fr;
            max-width: 620px;
        }
        .auth-left {
            padding: 35px 30px;
        }
        .auth-welcome h2 {
            font-size: 1.5rem;
        }
        .auth-right {
            padding: 35px 30px;
            max-height: none;
        }
    }

    @media (max-width: 576px) {
        .auth-section {
            padding: 100px 15px 40px;
        }
        .auth-left, .auth-right {
            padding: 25px 20px;
        }
        .auth-title {
            font-size: 1.4rem;
        }
        .role-tab {
            padding: 10px 4px;
            font-size: 0.75rem;
        }
    }
</style>
@endsection

@section('content')

{{-- Shared batch translation for the Register page --}}
@php
use App\Services\GoogleTranslator;

$strings = GoogleTranslator::translateBatch([
    // ---- Branding ----
    'brand_tagline' => 'Join The Community',
    'already_have_account' => 'Already have an account?',
    'login_here' => 'Login here',

    // ---- Welcome / headings ----
    'signup_customer_title' => 'Join Sanjivani<br>As A Customer',
    'signup_pharmacy_title' => 'Register Your<br>Pharmacy With Us',
    'signup_delivery_title' => 'Become A<br>Delivery Partner',

    'signup_customer_desc' => 'Create your free account and start ordering medicines from verified pharmacies with doorstep delivery in just a few clicks.',
    'signup_pharmacy_desc' => "Partner with Sanjivani, expand your reach and grow your medicine store's sales with our robust online platform.",
    'signup_delivery_desc' => 'Earn on your own schedule by delivering medicines in your area. Simple app, flexible hours and reliable weekly payouts.',

    // ---- Customer benefits ----
    'c_benefit_1' => 'Free registration in under 2 minutes',
    'c_benefit_2' => 'Order from 150+ verified pharmacies',
    'c_benefit_3' => 'Cash on Delivery available',
    'c_benefit_4' => 'Track orders in real-time',

    // ---- Pharmacy benefits ----
    'p_benefit_1' => 'Reach thousands of local customers',
    'p_benefit_2' => 'Manage inventory from one dashboard',
    'p_benefit_3' => 'Grow your daily sales & revenue',
    'p_benefit_4' => 'Free onboarding & training support',

    // ---- Delivery benefits ----
    'd_benefit_1' => 'Earn on your own flexible schedule',
    'd_benefit_2' => 'Weekly guaranteed payouts',
    'd_benefit_3' => 'Simple app to manage deliveries',
    'd_benefit_4' => 'Insurance & fuel bonus available',

    // ---- Right panel / headings ----
    'form_title' => 'Create Account',
    'form_subtitle' => 'Choose your account type and fill in your details to get started.',

    // ---- Role tabs ----
    'role_customer' => 'Customer',
    'role_pharmacy' => 'Pharmacy',
    'role_delivery' => 'Delivery Partner',

    // ---- Role info cards ----
    'role_info_customer' => 'As a Customer, you can order medicines and get them delivered to your address.',
    'role_info_pharmacy' => 'As a Pharmacy, you will be reviewed and approved by admin before you can accept orders.',
    'role_info_delivery' => 'As a Delivery Partner, your profile will be verified by admin before you can start receiving delivery assignments.',

    // ---- Section headings ----
    'section_personal' => 'Personal Information',
    'section_delivery_address' => 'Delivery Address',
    'section_pharmacy_details' => 'Pharmacy Details',
    'section_delivery_details' => 'Delivery Partner Details',
    'section_security' => 'Security',

    // ---- Common labels ----
    'label_name' => 'Full Name',
    'label_email' => 'Email Address',
    'label_phone' => 'Mobile Number',
    'label_village' => 'Village / Area',
    'label_address' => 'Full Address',
    'label_password' => 'Password',
    'label_confirm_password' => 'Confirm Password',

    // ---- Customer field labels ----
    'ph_name' => 'Your full name',
    'ph_email' => 'you@example.com',
    'ph_phone' => '10-digit mobile number',
    'ph_address' => 'House No, Street, Landmark, City, State, PIN',
    'ph_password' => 'Min. 6 characters',
    'ph_confirm_password' => 'Re-enter password',

    // ---- Village dropdown ----
    'select_village' => '-- Select Village --',

    // ---- Pharmacy labels ----
    'label_pharmacy_name' => 'Pharmacy Name',
    'label_license_number' => 'License Number',
    'label_pharmacy_address' => 'Pharmacy Address',
    'ph_pharmacy_name' => 'Your pharmacy/store name',
    'ph_license_number' => 'Drug License No.',
    'ph_pharmacy_address' => 'Complete pharmacy address',

    // ---- Delivery labels ----
    'label_vehicle_type' => 'Vehicle Type',
    'label_vehicle_number' => 'Vehicle Number',
    'label_aadhar' => 'Aadhar Number',
    'label_dl' => 'Driving License',
    'ph_vehicle_number' => 'MH-01-AB-1234',
    'ph_aadhar' => '12-digit Aadhar',
    'ph_dl' => 'DL Number (optional)',
    'select_vehicle' => '-- Select Vehicle --',
    'vehicle_bike' => 'Bike / Scooter',
    'vehicle_bicycle' => 'Bicycle',
    'vehicle_car' => 'Car',
    'vehicle_auto' => 'Auto Rickshaw',

    // ---- Terms ----
    'terms_agree' => 'I agree to the',
    'terms_and_conditions' => 'Terms & Conditions',
    'terms_and' => 'and',
    'terms_privacy' => 'Privacy Policy',
    'terms_suffix' => 'of Sanjivani.',

    // ---- Buttons / links ----
    'btn_create' => 'Create My Account',
    'btn_creating' => 'Creating Account...',
    'divider_or' => 'OR',
    'already_registered' => 'Already registered?',
    'login_to_account' => 'Login to your account',

    // ---- Password strength labels ----
    'pw_very_weak' => 'Very Weak',
    'pw_weak' => 'Weak',
    'pw_fair' => 'Fair',
    'pw_good' => 'Good',
    'pw_strong' => 'Strong',

    // ---- JS validation messages ----
    'js_name_required' => 'Please enter your full name.',
    'js_name_short' => 'Name must be at least 2 characters.',
    'js_name_long' => 'Name is too long (max 50).',
    'js_name_chars' => 'Only letters, spaces and dots allowed.',
    'js_email_required' => 'Please enter your email.',
    'js_email_invalid' => 'Please enter a valid email.',
    'js_email_long' => 'Email is too long.',
    'js_phone_required' => 'Please enter mobile number.',
    'js_phone_digits' => 'Only digits allowed.',
    'js_phone_length' => 'Must be exactly 10 digits.',
    'js_phone_start' => 'Must start with 6, 7, 8 or 9.',
    'js_village_required' => 'Please select your village.',
    'js_address_required' => 'Please enter your address.',
    'js_address_short' => 'Address must be at least 10 characters.',
    'js_address_long' => 'Address too long (max 300).',
    'js_pharmacy_name_required' => 'Please enter pharmacy name.',
    'js_pharmacy_name_short' => 'Minimum 3 characters.',
    'js_license_required' => 'Please enter license number.',
    'js_license_invalid' => 'Invalid license number.',
    'js_pharmacy_address_required' => 'Please enter pharmacy address.',
    'js_pharmacy_address_short' => 'Minimum 10 characters.',
    'js_vehicle_type_required' => 'Please select vehicle type.',
    'js_vehicle_number_required' => 'Please enter vehicle number.',
    'js_vehicle_number_format' => 'Format: MH-01-AB-1234',
    'js_aadhar_required' => 'Please enter Aadhar number.',
    'js_aadhar_invalid' => 'Aadhar must be exactly 12 digits.',
    'js_password_required' => 'Please enter a password.',
    'js_password_short' => 'Minimum 6 characters required.',
    'js_password_long' => 'Password too long.',
    'js_confirm_required' => 'Please confirm password.',
    'js_confirm_mismatch' => 'Passwords do not match.',
    'js_terms_required' => 'You must agree to the Terms & Conditions.',
]);
@endphp

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
                        <span>{{ $strings['brand_tagline'] }}</span>
                    </div>
                </div>

                <div class="auth-welcome">
                    <h2 id="welcomeTitle">{!! $strings['signup_customer_title'] !!}</h2>
                    <p id="welcomeDesc">{{ $strings['signup_customer_desc'] }}</p>

                    <!-- Customer Benefits -->
                    <ul class="role-benefits" id="customerBenefits">
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['c_benefit_1'] }}</span></li>
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['c_benefit_2'] }}</span></li>
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['c_benefit_3'] }}</span></li>
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['c_benefit_4'] }}</span></li>
                    </ul>

                    <!-- Pharmacy Benefits -->
                    <ul class="role-benefits" id="pharmacyBenefits" style="display:none;">
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['p_benefit_1'] }}</span></li>
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['p_benefit_2'] }}</span></li>
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['p_benefit_3'] }}</span></li>
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['p_benefit_4'] }}</span></li>
                    </ul>

                    <!-- Delivery Benefits -->
                    <ul class="role-benefits" id="deliveryBenefits" style="display:none;">
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['d_benefit_1'] }}</span></li>
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['d_benefit_2'] }}</span></li>
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['d_benefit_3'] }}</span></li>
                        <li><div class="icon"><i class="fas fa-check"></i></div><span>{{ $strings['d_benefit_4'] }}</span></li>
                    </ul>
                </div>

                <div class="auth-bottom-link">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    {{ $strings['already_have_account'] }} <a href="{{ url('/login') }}">{{ $strings['login_here'] }}</a>
                </div>
            </div>

            <!-- ============ RIGHT SIDE - REGISTER FORM ============ -->
            <div class="auth-right">
                <h2 class="auth-title">{{ $strings['form_title'] }}</h2>
                <p class="auth-subtitle">{{ $strings['form_subtitle'] }}</p>

                <!-- Session Alerts -->
                @if(session('register_error'))
                    <div class="auth-alert error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('register_error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="auth-alert error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Role Tabs -->
                <div class="role-tabs">
                    <button type="button" class="role-tab active" data-role="customer">
                        <i class="fas fa-user"></i> {{ $strings['role_customer'] }}
                    </button>
                    <button type="button" class="role-tab" data-role="pharmacy">
                        <i class="fas fa-store"></i> {{ $strings['role_pharmacy'] }}
                    </button>
                    <button type="button" class="role-tab" data-role="delivery">
                        <i class="fas fa-motorcycle"></i> {{ $strings['role_delivery'] }}
                    </button>
                </div>

                <!-- Role Info Card -->
                <div class="role-info-card" id="roleInfoCard">
                    <i class="fas fa-info-circle"></i>
                    <span id="roleInfoText">{{ $strings['role_info_customer'] }}</span>
                </div>

                <!-- Register Form -->
                <form id="registerForm" action="{{ url('/register') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="role" id="roleInput" value="customer">

                    <!-- ============ COMMON FIELDS (ALL ROLES) ============ -->
                    <div class="form-section-title">
                        <i class="fas fa-user-circle"></i> {{ $strings['section_personal'] }}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-auth">
                                <label class="form-label-auth">{{ $strings['label_name'] }} <span class="required">*</span></label>
                                <div class="input-wrap">
                                    <i class="fas fa-user input-icon-left"></i>
                                    <input type="text" name="name" id="name"
                                           class="form-control-auth"
                                           placeholder="{{ $strings['ph_name'] }}"
                                           value="{{ old('name') }}">
                                </div>
                                <span class="error-message" id="nameError"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-auth">
                                <label class="form-label-auth">{{ $strings['label_email'] }} <span class="required">*</span></label>
                                <div class="input-wrap">
                                    <i class="fas fa-envelope input-icon-left"></i>
                                    <input type="email" name="email" id="email"
                                           class="form-control-auth"
                                           placeholder="{{ $strings['ph_email'] }}"
                                           value="{{ old('email') }}">
                                </div>
                                <span class="error-message" id="emailError"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-auth">
                                <label class="form-label-auth">{{ $strings['label_phone'] }} <span class="required">*</span></label>
                                <div class="input-wrap">
                                    <i class="fas fa-phone input-icon-left"></i>
                                    <input type="text" name="phone" id="phone"
                                           class="form-control-auth"
                                           placeholder="{{ $strings['ph_phone'] }}"
                                           maxlength="10"
                                           value="{{ old('phone') }}">
                                </div>
                                <span class="error-message" id="phoneError"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-auth">
                                <label class="form-label-auth">{{ $strings['label_village'] }} <span class="required">*</span></label>
                                <div class="input-wrap">
                                    <i class="fas fa-map-marker-alt input-icon-left"></i>
                                    <select name="village_id" id="village_id" class="form-select-auth">
                                        <option value="">{{ $strings['select_village'] }}</option>
                                        @if(!empty($villages))
                                            @foreach($villages as $v)
                                                <option value="{{ $v->id }}" {{ old('village_id') == $v->id ? 'selected' : '' }}>
                                                    {{ $v->name }}{{ !empty($v->district) ? ' - '.$v->district : '' }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <span class="error-message" id="villageError"></span>
                            </div>
                        </div>
                    </div>

                    <!-- ============ CUSTOMER FIELDS ============ -->
                    <div class="role-fields active" id="customerFields">
                        <div class="form-section-title">
                            <i class="fas fa-location-dot"></i> {{ $strings['section_delivery_address'] }}
                        </div>
                        <div class="form-group-auth">
                            <label class="form-label-auth">{{ $strings['label_address'] }} <span class="required">*</span></label>
                            <div class="input-wrap">
                                <i class="fas fa-home input-icon-left"></i>
                                <textarea name="address" id="address"
                                          class="form-control-auth"
                                          placeholder="{{ $strings['ph_address'] }}"
                                          maxlength="300">{{ old('address') }}</textarea>
                            </div>
                            <span class="error-message" id="addressError"></span>
                        </div>
                    </div>

                    <!-- ============ PHARMACY FIELDS ============ -->
                    <div class="role-fields" id="pharmacyFields">
                        <div class="form-section-title">
                            <i class="fas fa-store"></i> {{ $strings['section_pharmacy_details'] }}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-auth">
                                    <label class="form-label-auth">{{ $strings['label_pharmacy_name'] }} <span class="required">*</span></label>
                                    <div class="input-wrap">
                                        <i class="fas fa-hospital input-icon-left"></i>
                                        <input type="text" name="pharmacy_name" id="pharmacy_name"
                                               class="form-control-auth"
                                               placeholder="{{ $strings['ph_pharmacy_name'] }}"
                                               value="{{ old('pharmacy_name') }}">
                                    </div>
                                    <span class="error-message" id="pharmacyNameError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-auth">
                                    <label class="form-label-auth">{{ $strings['label_license_number'] }} <span class="required">*</span></label>
                                    <div class="input-wrap">
                                        <i class="fas fa-id-card input-icon-left"></i>
                                        <input type="text" name="license_number" id="license_number"
                                               class="form-control-auth"
                                               placeholder="{{ $strings['ph_license_number'] }}"
                                               value="{{ old('license_number') }}">
                                    </div>
                                    <span class="error-message" id="licenseError"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group-auth">
                                    <label class="form-label-auth">{{ $strings['label_pharmacy_address'] }} <span class="required">*</span></label>
                                    <div class="input-wrap">
                                        <i class="fas fa-map-pin input-icon-left"></i>
                                        <textarea name="pharmacy_address" id="pharmacy_address"
                                                  class="form-control-auth"
                                                  placeholder="{{ $strings['ph_pharmacy_address'] }}"
                                                  maxlength="300">{{ old('pharmacy_address') }}</textarea>
                                    </div>
                                    <span class="error-message" id="pharmacyAddressError"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============ DELIVERY FIELDS ============ -->
                    <div class="role-fields" id="deliveryFields">
                        <div class="form-section-title">
                            <i class="fas fa-motorcycle"></i> {{ $strings['section_delivery_details'] }}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-auth">
                                    <label class="form-label-auth">{{ $strings['label_vehicle_type'] }} <span class="required">*</span></label>
                                    <div class="input-wrap">
                                        <i class="fas fa-truck input-icon-left"></i>
                                        <select name="vehicle_type" id="vehicle_type" class="form-select-auth">
                                            <option value="">{{ $strings['select_vehicle'] }}</option>
                                            <option value="Bike"    {{ old('vehicle_type')=='Bike'    ? 'selected' : '' }}>{{ $strings['vehicle_bike'] }}</option>
                                            <option value="Bicycle" {{ old('vehicle_type')=='Bicycle' ? 'selected' : '' }}>{{ $strings['vehicle_bicycle'] }}</option>
                                            <option value="Car"     {{ old('vehicle_type')=='Car'     ? 'selected' : '' }}>{{ $strings['vehicle_car'] }}</option>
                                            <option value="Auto"    {{ old('vehicle_type')=='Auto'    ? 'selected' : '' }}>{{ $strings['vehicle_auto'] }}</option>
                                        </select>
                                    </div>
                                    <span class="error-message" id="vehicleTypeError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-auth">
                                    <label class="form-label-auth">{{ $strings['label_vehicle_number'] }} <span class="required">*</span></label>
                                    <div class="input-wrap">
                                        <i class="fas fa-hashtag input-icon-left"></i>
                                        <input type="text" name="vehicle_number" id="vehicle_number"
                                               class="form-control-auth"
                                               placeholder="{{ $strings['ph_vehicle_number'] }}"
                                               style="text-transform:uppercase;"
                                               value="{{ old('vehicle_number') }}">
                                    </div>
                                    <span class="error-message" id="vehicleNumberError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-auth">
                                    <label class="form-label-auth">{{ $strings['label_aadhar'] }} <span class="required">*</span></label>
                                    <div class="input-wrap">
                                        <i class="fas fa-id-badge input-icon-left"></i>
                                        <input type="text" name="aadhar_number" id="aadhar_number"
                                               class="form-control-auth"
                                               placeholder="{{ $strings['ph_aadhar'] }}"
                                               maxlength="12"
                                               value="{{ old('aadhar_number') }}">
                                    </div>
                                    <span class="error-message" id="aadharError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-auth">
                                    <label class="form-label-auth">{{ $strings['label_dl'] }}</label>
                                    <div class="input-wrap">
                                        <i class="fas fa-id-card input-icon-left"></i>
                                        <input type="text" name="license_dl" id="license_dl"
                                               class="form-control-auth"
                                               placeholder="{{ $strings['ph_dl'] }}"
                                               value="{{ old('license_dl') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============ PASSWORD SECTION ============ -->
                    <div class="form-section-title">
                        <i class="fas fa-lock"></i> {{ $strings['section_security'] }}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-auth">
                                <label class="form-label-auth">{{ $strings['label_password'] }} <span class="required">*</span></label>
                                <div class="input-wrap">
                                    <i class="fas fa-lock input-icon-left"></i>
                                    <input type="password" name="password" id="password"
                                           class="form-control-auth"
                                           placeholder="{{ $strings['ph_password'] }}">
                                    <i class="fas fa-eye input-icon-right toggle-pwd" data-target="password"></i>
                                </div>
                                <div class="password-strength" id="passwordStrength">
                                    <div class="strength-bar">
                                        <div class="strength-fill" id="strengthFill"></div>
                                    </div>
                                    <span class="strength-text" id="strengthText">{{ $strings['pw_weak'] }}</span>
                                </div>
                                <span class="error-message" id="passwordError"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-auth">
                                <label class="form-label-auth">{{ $strings['label_confirm_password'] }} <span class="required">*</span></label>
                                <div class="input-wrap">
                                    <i class="fas fa-lock input-icon-left"></i>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control-auth"
                                           placeholder="{{ $strings['ph_confirm_password'] }}">
                                    <i class="fas fa-eye input-icon-right toggle-pwd" data-target="password_confirmation"></i>
                                </div>
                                <span class="error-message" id="confirmPasswordError"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="terms-check">
                        <input type="checkbox" name="terms" id="terms">
                        <label for="terms">
                            {{ $strings['terms_agree'] }} <a href="#" onclick="return false;">{{ $strings['terms_and_conditions'] }}</a>
                            {{ $strings['terms_and'] }} <a href="#" onclick="return false;">{{ $strings['terms_privacy'] }}</a>
                            {{ $strings['terms_suffix'] }}
                        </label>
                    </div>
                    <span class="error-message" id="termsError" style="margin-top:-15px;margin-bottom:15px;"></span>

                    <button type="submit" class="btn-auth-submit" id="submitBtn">
                        <i class="fas fa-user-plus"></i>
                        <span>{{ $strings['btn_create'] }}</span>
                    </button>

                    <div class="auth-divider">
                        <span>{{ $strings['divider_or'] }}</span>
                    </div>

                    <div class="auth-login-link">
                        {{ $strings['already_registered'] }}
                        <a href="{{ url('/login') }}">{{ $strings['login_to_account'] }}</a>
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
       ROLE TAB SWITCHING + DYNAMIC UI
    ============================================= */
    var roleInfo = {
        'customer': {
            title: {!! json_encode($strings['signup_customer_title']) !!},
            desc:  {!! json_encode($strings['signup_customer_desc']) !!},
            info:  {!! json_encode($strings['role_info_customer']) !!},
            benefits: 'customerBenefits'
        },
        'pharmacy': {
            title: {!! json_encode($strings['signup_pharmacy_title']) !!},
            desc:  {!! json_encode($strings['signup_pharmacy_desc']) !!},
            info:  {!! json_encode($strings['role_info_pharmacy']) !!},
            benefits: 'pharmacyBenefits'
        },
        'delivery': {
            title: {!! json_encode($strings['signup_delivery_title']) !!},
            desc:  {!! json_encode($strings['signup_delivery_desc']) !!},
            info:  {!! json_encode($strings['role_info_delivery']) !!},
            benefits: 'deliveryBenefits'
        }
    };

    $('.role-tab').on('click', function () {
        $('.role-tab').removeClass('active');
        $(this).addClass('active');
        var role = $(this).data('role');

        $('#roleInput').val(role);
        $('#welcomeTitle').html(roleInfo[role].title);
        $('#welcomeDesc').text(roleInfo[role].desc);
        $('#roleInfoText').text(roleInfo[role].info);

        $('.role-benefits').hide();
        $('#' + roleInfo[role].benefits).show();

        $('.role-fields').removeClass('active');
        if (role === 'customer')      $('#customerFields').addClass('active');
        else if (role === 'pharmacy') $('#pharmacyFields').addClass('active');
        else if (role === 'delivery') $('#deliveryFields').addClass('active');
    });

    // Auto-select role from URL (?role=pharmacy)
    var urlParams = new URLSearchParams(window.location.search);
    var roleParam = urlParams.get('role');
    if (roleParam) {
        var $tab = $('.role-tab[data-role="' + roleParam + '"]');
        if ($tab.length) $tab.trigger('click');
    }

    /* =============================================
       PASSWORD SHOW / HIDE
    ============================================= */
    $('.toggle-pwd').on('click', function () {
        var target = $(this).data('target');
        var $pwd = $('#' + target);
        var type = $pwd.attr('type') === 'password' ? 'text' : 'password';
        $pwd.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    /* =============================================
       PASSWORD STRENGTH METER
    ============================================= */
    var pwLabels = {
        veryWeak: {!! json_encode($strings['pw_very_weak']) !!},
        weak:     {!! json_encode($strings['pw_weak']) !!},
        fair:     {!! json_encode($strings['pw_fair']) !!},
        good:     {!! json_encode($strings['pw_good']) !!},
        strong:   {!! json_encode($strings['pw_strong']) !!}
    };

    $('#password').on('input', function () {
        var val = $(this).val();
        var $wrap = $('#passwordStrength');
        var $fill = $('#strengthFill');
        var $text = $('#strengthText');

        if (val.length === 0) {
            $wrap.removeClass('show');
            return;
        }
        $wrap.addClass('show');

        var score = 0;
        if (val.length >= 6) score++;
        if (val.length >= 10) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        var levels = [
            { w: '20%', c: '#E53935', t: pwLabels.veryWeak },
            { w: '40%', c: '#FB8C00', t: pwLabels.weak },
            { w: '60%', c: '#FDD835', t: pwLabels.fair },
            { w: '80%', c: '#7CB342', t: pwLabels.good },
            { w: '100%', c: '#2E7D32', t: pwLabels.strong }
        ];
        var lvl = levels[Math.max(0, score - 1)];
        $fill.css({ width: lvl.w, background: lvl.c });
        $text.text(lvl.t).css('color', lvl.c);
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

    var js = {
        nameRequired:   {!! json_encode($strings['js_name_required']) !!},
        nameShort:      {!! json_encode($strings['js_name_short']) !!},
        nameLong:       {!! json_encode($strings['js_name_long']) !!},
        nameChars:      {!! json_encode($strings['js_name_chars']) !!},
        emailRequired:  {!! json_encode($strings['js_email_required']) !!},
        emailInvalid:   {!! json_encode($strings['js_email_invalid']) !!},
        emailLong:      {!! json_encode($strings['js_email_long']) !!},
        phoneRequired:  {!! json_encode($strings['js_phone_required']) !!},
        phoneDigits:    {!! json_encode($strings['js_phone_digits']) !!},
        phoneLength:    {!! json_encode($strings['js_phone_length']) !!},
        phoneStart:     {!! json_encode($strings['js_phone_start']) !!},
        villageRequired:{!! json_encode($strings['js_village_required']) !!},
        addressRequired:{!! json_encode($strings['js_address_required']) !!},
        addressShort:   {!! json_encode($strings['js_address_short']) !!},
        addressLong:    {!! json_encode($strings['js_address_long']) !!},
        pharmNameReq:   {!! json_encode($strings['js_pharmacy_name_required']) !!},
        pharmNameShort: {!! json_encode($strings['js_pharmacy_name_short']) !!},
        licenseReq:     {!! json_encode($strings['js_license_required']) !!},
        licenseInvalid: {!! json_encode($strings['js_license_invalid']) !!},
        pharmAddrReq:   {!! json_encode($strings['js_pharmacy_address_required']) !!},
        pharmAddrShort: {!! json_encode($strings['js_pharmacy_address_short']) !!},
        vehTypeReq:     {!! json_encode($strings['js_vehicle_type_required']) !!},
        vehNumReq:      {!! json_encode($strings['js_vehicle_number_required']) !!},
        vehNumFormat:   {!! json_encode($strings['js_vehicle_number_format']) !!},
        aadharReq:      {!! json_encode($strings['js_aadhar_required']) !!},
        aadharInvalid:  {!! json_encode($strings['js_aadhar_invalid']) !!},
        pwdReq:         {!! json_encode($strings['js_password_required']) !!},
        pwdShort:       {!! json_encode($strings['js_password_short']) !!},
        pwdLong:        {!! json_encode($strings['js_password_long']) !!},
        confirmReq:     {!! json_encode($strings['js_confirm_required']) !!},
        confirmMismatch:{!! json_encode($strings['js_confirm_mismatch']) !!},
        termsRequired:  {!! json_encode($strings['js_terms_required']) !!}
    };

    /* -------- Validators -------- */
    function validateName() {
        var $el = $('#name');
        var v = $.trim($el.val());
        if (v === '') { showError($el, '⚠ ' + js.nameRequired); return false; }
        if (v.length < 2) { showError($el, '⚠ ' + js.nameShort); return false; }
        if (v.length > 50) { showError($el, '⚠ ' + js.nameLong); return false; }
        if (!/^[a-zA-Z\s.]+$/.test(v)) { showError($el, '⚠ ' + js.nameChars); return false; }
        showSuccess($el); return true;
    }

    function validateEmail() {
        var $el = $('#email');
        var v = $.trim($el.val());
        var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (v === '') { showError($el, '⚠ ' + js.emailRequired); return false; }
        if (!regex.test(v)) { showError($el, '⚠ ' + js.emailInvalid); return false; }
        if (v.length > 100) { showError($el, '⚠ ' + js.emailLong); return false; }
        showSuccess($el); return true;
    }

    function validatePhone() {
        var $el = $('#phone');
        var v = $.trim($el.val());
        if (v === '') { showError($el, '⚠ ' + js.phoneRequired); return false; }
        if (!/^\d+$/.test(v)) { showError($el, '⚠ ' + js.phoneDigits); return false; }
        if (v.length !== 10) { showError($el, '⚠ ' + js.phoneLength); return false; }
        if (!/^[6-9]\d{9}$/.test(v)) { showError($el, '⚠ ' + js.phoneStart); return false; }
        showSuccess($el); return true;
    }

    function validateVillage() {
        var $el = $('#village_id');
        if ($.trim($el.val()) === '') { showError($el, '⚠ ' + js.villageRequired); return false; }
        showSuccess($el); return true;
    }

    function validateAddress() {
        var $el = $('#address');
        var v = $.trim($el.val());
        if (v === '') { showError($el, '⚠ ' + js.addressRequired); return false; }
        if (v.length < 10) { showError($el, '⚠ ' + js.addressShort); return false; }
        if (v.length > 300) { showError($el, '⚠ ' + js.addressLong); return false; }
        showSuccess($el); return true;
    }

    function validatePharmacyName() {
        var $el = $('#pharmacy_name');
        var v = $.trim($el.val());
        if (v === '') { showError($el, '⚠ ' + js.pharmNameReq); return false; }
        if (v.length < 3) { showError($el, '⚠ ' + js.pharmNameShort); return false; }
        showSuccess($el); return true;
    }

    function validateLicense() {
        var $el = $('#license_number');
        var v = $.trim($el.val());
        if (v === '') { showError($el, '⚠ ' + js.licenseReq); return false; }
        if (v.length < 5) { showError($el, '⚠ ' + js.licenseInvalid); return false; }
        showSuccess($el); return true;
    }

    function validatePharmacyAddress() {
        var $el = $('#pharmacy_address');
        var v = $.trim($el.val());
        if (v === '') { showError($el, '⚠ ' + js.pharmAddrReq); return false; }
        if (v.length < 10) { showError($el, '⚠ ' + js.pharmAddrShort); return false; }
        showSuccess($el); return true;
    }

    function validateVehicleType() {
        var $el = $('#vehicle_type');
        if ($.trim($el.val()) === '') { showError($el, '⚠ ' + js.vehTypeReq); return false; }
        showSuccess($el); return true;
    }

    function validateVehicleNumber() {
        var $el = $('#vehicle_number');
        var v = $.trim($el.val()).toUpperCase();
        if (v === '') { showError($el, '⚠ ' + js.vehNumReq); return false; }
        if (!/^[A-Z]{2}[-\s]?\d{1,2}[-\s]?[A-Z]{1,3}[-\s]?\d{1,4}$/.test(v)) {
            showError($el, '⚠ ' + js.vehNumFormat); return false;
        }
        showSuccess($el); return true;
    }

    function validateAadhar() {
        var $el = $('#aadhar_number');
        var v = $.trim($el.val());
        if (v === '') { showError($el, '⚠ ' + js.aadharReq); return false; }
        if (!/^\d{12}$/.test(v)) { showError($el, '⚠ ' + js.aadharInvalid); return false; }
        showSuccess($el); return true;
    }

    function validatePassword() {
        var $el = $('#password');
        var v = $el.val();
        if (v === '') { showError($el, '⚠ ' + js.pwdReq); return false; }
        if (v.length < 6) { showError($el, '⚠ ' + js.pwdShort); return false; }
        if (v.length > 50) { showError($el, '⚠ ' + js.pwdLong); return false; }
        showSuccess($el); return true;
    }

    function validateConfirmPassword() {
        var $el = $('#password_confirmation');
        var v = $el.val();
        var pwd = $('#password').val();
        if (v === '') { showError($el, '⚠ ' + js.confirmReq); return false; }
        if (v !== pwd) { showError($el, '⚠ ' + js.confirmMismatch); return false; }
        showSuccess($el); return true;
    }

    function validateTerms() {
        var checked = $('#terms').is(':checked');
        var $err = $('#termsError');
        if (!checked) {
            $err.text('⚠ ' + js.termsRequired).addClass('show');
            return false;
        }
        $err.text('').removeClass('show');
        return true;
    }

    /* =============================================
       REAL-TIME BLUR / INPUT LISTENERS
    ============================================= */
    $('#name').on('blur', validateName);
    $('#email').on('blur', validateEmail);
    $('#phone').on('blur', validatePhone);
    $('#village_id').on('change', validateVillage);
    $('#address').on('blur', validateAddress);
    $('#pharmacy_name').on('blur', validatePharmacyName);
    $('#license_number').on('blur', validateLicense);
    $('#pharmacy_address').on('blur', validatePharmacyAddress);
    $('#vehicle_type').on('change', validateVehicleType);
    $('#vehicle_number').on('blur', validateVehicleNumber);
    $('#aadhar_number').on('blur', validateAadhar);
    $('#password').on('blur', validatePassword);
    $('#password_confirmation').on('blur', validateConfirmPassword);
    $('#terms').on('change', validateTerms);

    $('#phone, #aadhar_number').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('.form-control-auth, .form-select-auth').on('input change', function () {
        if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
            clearField($(this));
        }
    });

    /* =============================================
       FORM SUBMISSION
    ============================================= */
    $('#registerForm').on('submit', function (e) {
        e.preventDefault();

        var role = $('#roleInput').val();
        var isValid = true;

        if (!validateName())    isValid = false;
        if (!validateEmail())   isValid = false;
        if (!validatePhone())   isValid = false;
        if (!validateVillage()) isValid = false;

        if (role === 'customer') {
            if (!validateAddress()) isValid = false;
        } else if (role === 'pharmacy') {
            if (!validatePharmacyName())    isValid = false;
            if (!validateLicense())         isValid = false;
            if (!validatePharmacyAddress()) isValid = false;
        } else if (role === 'delivery') {
            if (!validateVehicleType())    isValid = false;
            if (!validateVehicleNumber())  isValid = false;
            if (!validateAadhar())         isValid = false;
        }

        if (!validatePassword())        isValid = false;
        if (!validateConfirmPassword()) isValid = false;
        if (!validateTerms())           isValid = false;

        if (!isValid) {
            var $firstError = $('.form-control-auth.error, .form-select-auth.error').first();
            if ($firstError.length) {
                $('html, body').animate({
                    scrollTop: $firstError.offset().top - 150
                }, 400);
                $firstError.focus();
            }
            return false;
        }

        var $btn = $('#submitBtn');
        var original = $btn.html();
        $btn.prop('disabled', true).html(
            '<i class="fas fa-spinner fa-spin"></i> <span>' + {!! json_encode($strings['btn_creating']) !!} + '</span>'
        );

        this.submit();
    });

    setTimeout(function () { $('.auth-alert').fadeOut(500); }, 6000);

});
</script>
@endsection