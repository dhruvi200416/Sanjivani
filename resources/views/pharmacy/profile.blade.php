@extends('layouts.pharmacy')

@section('title', 'Pharmacy Profile')
@section('page_title')
<i class="fas fa-user-circle"></i> My Profile
@endsection

@section('styles')
<style>
    /* Profile Header */
    .profile-header-ph {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 20px;
        padding: 35px 30px;
        color: var(--white);
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .profile-header-ph::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .profile-header-ph::after {
        content: '\f21e';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 30px;
        bottom: -30px;
        font-size: 10rem;
        opacity: 0.08;
    }

    .profile-header-inner-ph {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
    }

    .profile-avatar-big-ph {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--white);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        border: 5px solid rgba(255,255,255,0.3);
        overflow: hidden;
    }

    .profile-header-info-ph {
        flex: 1;
    }

    .profile-header-info-ph h2 {
        font-size: 2rem;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .profile-header-info-ph .status-badge-profile {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 4px 15px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        margin-bottom: 12px;
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .profile-header-meta-ph {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .profile-header-meta-ph span {
        font-size: 0.9rem;
        opacity: 0.92;
    }

    .profile-header-meta-ph span i {
        margin-right: 6px;
    }

    /* Tabs Card */
    .profile-tabs-card-ph {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 25px;
    }

    .profile-tabs-header-ph {
        display: flex;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        overflow-x: auto;
    }

    .profile-tab-btn-ph {
        padding: 16px 24px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--gray-text);
        transition: var(--transition);
        border: none;
        background: transparent;
        border-bottom: 3px solid transparent;
        white-space: nowrap;
    }

    .profile-tab-btn-ph i {
        margin-right: 6px;
    }

    .profile-tab-btn-ph:hover {
        color: var(--primary-green);
        background: var(--pale-green);
    }

    .profile-tab-btn-ph.active {
        color: var(--primary-green);
        background: var(--white);
        border-bottom-color: var(--primary-green);
    }

    .profile-tab-content-ph {
        display: none;
        padding: 30px;
    }

    .profile-tab-content-ph.active {
        display: block;
    }

    /* Form Fields */
    .form-group-p-ph {
        margin-bottom: 20px;
        position: relative;
    }

    .form-label-p-ph {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 8px;
        display: block;
    }

    .form-label-p-ph .req {
        color: #E53935;
    }

    .input-wrap-p-ph {
        position: relative;
    }

    .form-control-p-ph {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        font-size: 0.92rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: var(--transition);
        background: var(--white);
    }

    .form-control-p-ph:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
    }

    .form-control-p-ph.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .form-control-p-ph.success {
        border-color: var(--light-green);
        background: #F1F8E9;
    }

    .form-control-p-ph:disabled {
        background: #F5F5F5;
        color: var(--gray-text);
        cursor: not-allowed;
    }

    textarea.form-control-p-ph {
        min-height: 90px;
        padding-top: 14px;
        resize: vertical;
    }

    .form-icon-p-ph {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-green);
        font-size: 0.95rem;
        pointer-events: none;
    }

    .form-icon-p-ph.textarea {
        top: 22px;
        transform: none;
    }

    .form-icon-right-p-ph {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-text);
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .form-icon-right-p-ph:hover {
        color: var(--primary-green);
    }

    .err-msg-p-ph {
        color: #E53935;
        font-size: 0.78rem;
        margin-top: 5px;
        display: none;
        font-weight: 500;
    }

    .err-msg-p-ph.show { display: block; }

    /* Verification Status Panel */
    .verification-panel {
        background: var(--off-white);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        border-left: 5px solid var(--primary-green);
    }

    .verification-panel.pending {
        border-left-color: #FB8C00;
        background: #FFFDE7;
    }

    .verification-panel.rejected {
        border-left-color: #E53935;
        background: #FFEBEE;
    }

    .verification-panel h5 {
        font-weight: 700;
        margin-bottom: 8px;
    }

    .verification-panel.approved h5 { color: var(--dark-green); }
    .verification-panel.pending h5 { color: #E65100; }
    .verification-panel.rejected h5 { color: #C62828; }

    .verification-panel p {
        font-size: 0.88rem;
        color: var(--gray-text);
        margin: 0;
        line-height: 1.6;
    }

    /* Save Button */
    .btn-save-p-ph {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 12px 35px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 6px 15px rgba(46,125,50,0.25);
    }

    .btn-save-p-ph:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.35);
    }

    .btn-save-p-ph:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Alert */
    .alert-inline-p-ph {
        padding: 12px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 0.88rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-inline-p-ph.success {
        background: #E8F5E9;
        color: #1B5E20;
        border-left: 4px solid #2E7D32;
    }

    .alert-inline-p-ph.error {
        background: #FFEBEE;
        color: #B71C1C;
        border-left: 4px solid #C62828;
    }

    @media (max-width: 767px) {
        .profile-header-inner-ph { flex-direction: column; text-align: center; }
        .profile-header-meta-ph { justify-content: center; }
        .profile-tab-btn-ph { padding: 12px 15px; font-size: 0.82rem; }
        .profile-tab-btn-ph i { display: none; }
        .profile-tab-content-ph { padding: 20px; }
    }
</style>
@endsection

@section('content')

@php
    // Demo Pharmacy Profile data bindings
    $pharmacy = $pharmacy ?? (object)[
        'pharmacy_name' => session('pharmacy_name') ?? 'HealthCare Medicos',
        'owner_name' => 'Dr. Vinod Sharma',
        'email' => 'healthcare.medicos@example.com',
        'phone' => '9822334455',
        'license_number' => 'DL-MH-2023-9988A',
        'address' => 'Plot No. 12, Main Market, Shivaji Chowk, Nashik - 422003',
        'village_id' => 1,
        'status' => 'active', // active, pending, rejected
        'created_at' => now()->subMonths(10),
    ];

    $villages = $villages ?? [
        (object)['id' => 1, 'name' => 'Nashik'],
        (object)['id' => 2, 'name' => 'Pune'],
        (object)['id' => 3, 'name' => 'Mumbai'],
        (object)['id' => 4, 'name' => 'Aurangabad'],
    ];
@endphp

<!-- Profile Header Banner -->
<div class="profile-header-ph" data-aos="fade-down">
    <div class="profile-header-inner-ph">
        <div class="profile-avatar-big-ph">
            {{ strtoupper(substr($pharmacy->pharmacy_name, 0, 1)) }}
        </div>
        <div class="profile-header-info-ph">
            <h2>{{ $pharmacy->pharmacy_name }}</h2>
            <span class="status-badge-profile">
                <i class="fas fa-hospital me-1"></i> Verified Pharmacy Partner
            </span>
            <div class="profile-header-meta-ph">
                <span><i class="fas fa-user-md"></i> {{ $pharmacy->owner_name }}</span>
                <span><i class="fas fa-file-contract"></i> {{ $pharmacy->license_number }}</span>
                <span><i class="fas fa-calendar-alt"></i> Partner Since {{ date('M Y', strtotime($pharmacy->created_at)) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Card -->
<div class="profile-tabs-card-ph" data-aos="fade-up">
    <div class="profile-tabs-header-ph">
        <button type="button" class="profile-tab-btn-ph active" data-tab="store"><i class="fas fa-store"></i> Pharmacy Profile</button>
        <button type="button" class="profile-tab-btn-ph" data-tab="verification"><i class="fas fa-certificate"></i> License & Status</button>
        <button type="button" class="profile-tab-btn-ph" data-tab="password"><i class="fas fa-key"></i> Account Security</button>
    </div>

    <!-- ============ STORE PROFILE TAB ============ -->
    <div class="profile-tab-content-ph active" id="tab-store">
        @if(session('profile_success'))
            <div class="alert-inline-p-ph success"><i class="fas fa-check-circle"></i>{{ session('profile_success') }}</div>
        @endif

        <form id="pharmacyProfileForm" action="{{ url('/pharmacy/profile/update') }}" method="POST" novalidate>
            @csrf

            <h5 style="font-weight:700; color:var(--dark-text); margin-bottom:20px;">
                <i class="fas fa-hospital me-2" style="color:var(--primary-green);"></i>Pharmacy & Contact Information
            </h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">Pharmacy / Store Name <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-hospital form-icon-p-ph"></i>
                            <input type="text" name="pharmacy_name" id="ph_name" class="form-control-p-ph" value="{{ $pharmacy->pharmacy_name }}">
                        </div>
                        <span class="err-msg-p-ph" id="err_ph_name"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">Owner Name <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-user-md form-icon-p-ph"></i>
                            <input type="text" name="owner_name" id="ph_owner" class="form-control-p-ph" value="{{ $pharmacy->owner_name }}">
                        </div>
                        <span class="err-msg-p-ph" id="err_ph_owner"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">Email Address <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-envelope form-icon-p-ph"></i>
                            <input type="email" name="email" id="ph_email" class="form-control-p-ph" value="{{ $pharmacy->email }}">
                        </div>
                        <span class="err-msg-p-ph" id="err_ph_email"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">Mobile Phone <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-phone form-icon-p-ph"></i>
                            <input type="text" name="phone" id="ph_phone" class="form-control-p-ph" value="{{ $pharmacy->phone }}" maxlength="10">
                        </div>
                        <span class="err-msg-p-ph" id="err_ph_phone"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">Village / Market Location <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-map-marker-alt form-icon-p-ph"></i>
                            <select name="village_id" id="ph_village" class="form-select-p">
                                <option value="">-- Select Village --</option>
                                @foreach($villages as $v)
                                    <option value="{{ $v->id }}" {{ $pharmacy->village_id == $v->id ? 'selected' : '' }}>
                                        {{ $v->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <span class="err-msg-p-ph" id="err_ph_village"></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">Complete Physical Address <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-home form-icon-p-ph textarea"></i>
                            <textarea name="address" id="ph_address" class="form-control-p-ph" placeholder="Detailed store address...">{{ $pharmacy->address }}</textarea>
                        </div>
                        <span class="err-msg-p-ph" id="err_ph_address"></span>
                    </div>
                </div>
            </div>

            <div class="text-end mt-2">
                <button type="submit" class="btn-save-p-ph" id="saveProfileBtn">
                    <i class="fas fa-save"></i> Save Profile Details
                </button>
            </div>
        </form>
    </div>

    <!-- ============ VERIFICATION TAB ============ -->
    <div class="profile-tab-content-ph" id="tab-verification">
        <h5 style="font-weight:700; color:var(--dark-text); margin-bottom:20px;">
            <i class="fas fa-certificate me-2" style="color:var(--primary-green);"></i>License Verification & Status
        </h5>

        <!-- Verified Status Banner -->
        @if($pharmacy->status == 'active')
            <div class="verification-panel approved">
                <h5><i class="fas fa-check-circle me-1"></i> Account Approved</h5>
                <p>Your pharmacy credentials and drug license are verified. Your store and listed products are active, visible, and can accept customer orders across the platform.</p>
            </div>
        @elseif($pharmacy->status == 'pending')
            <div class="verification-panel pending">
                <h5><i class="fas fa-hourglass-half me-1"></i> Verification Pending</h5>
                <p>Your drug license and registration documents are currently under evaluation by the administrative team. Your listed products will become visible to customers once the review completes.</p>
            </div>
        @else
            <div class="verification-panel rejected">
                <h5><i class="fas fa-times-circle me-1"></i> Verification Declined</h5>
                <p>Your registration profile was declined due to mismatched license data or missing documents. Please contact system administrators at support@sanjivani.com to initiate remediation.</p>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="form-group-p-ph">
                    <label class="form-label-p-ph">Drug License Number</label>
                    <div class="input-wrap-p-ph">
                        <i class="fas fa-file-signature form-icon-p-ph"></i>
                        <input type="text" class="form-control-p-ph" value="{{ $pharmacy->license_number }}" disabled>
                    </div>
                    <small style="color:var(--gray-text); display:block; margin-top:5px;">Contact administrative support to modify license parameters.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ PASSWORD SECURITY TAB ============ -->
    <div class="profile-tab-content-ph" id="tab-password">
        @if(session('password_success'))
            <div class="alert-inline-p-ph success"><i class="fas fa-check-circle"></i>{{ session('password_success') }}</div>
        @endif
        @if(session('password_error'))
            <div class="alert-inline-p-ph error"><i class="fas fa-exclamation-circle"></i>{{ session('password_error') }}</div>
        @endif

        <h5 style="font-weight:700; color:var(--dark-text); margin-bottom:20px;">
            <i class="fas fa-key me-2" style="color:var(--primary-green);"></i>Update Account Password
        </h5>

        <form id="pharmacyPwdForm" action="{{ url('/pharmacy/profile/change-password') }}" method="POST" novalidate>
            @csrf

            <div class="form-group-p-ph">
                <label class="form-label-p-ph">Current Password <span class="req">*</span></label>
                <div class="input-wrap-p-ph">
                    <i class="fas fa-lock form-icon-p-ph"></i>
                    <input type="password" name="current_password" id="curPwd" class="form-control-p-ph" placeholder="Enter current password" style="padding-right:45px;">
                    <i class="fas fa-eye form-icon-right-p-ph toggle-password-visibility" data-target="curPwd"></i>
                </div>
                <span class="err-msg-p-ph" id="err_curPwd"></span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">New Password <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-key form-icon-p-ph"></i>
                            <input type="password" name="new_password" id="newPwd" class="form-control-p-ph" placeholder="Min 6 characters" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-p-ph toggle-password-visibility" data-target="newPwd"></i>
                        </div>
                        <span class="err-msg-p-ph" id="err_newPwd"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">Confirm New Password <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-check-double form-icon-p-ph"></i>
                            <input type="password" name="new_password_confirmation" id="confPwd" class="form-control-p-ph" placeholder="Confirm password" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-p-ph toggle-password-visibility" data-target="confPwd"></i>
                        </div>
                        <span class="err-msg-p-ph" id="err_confPwd"></span>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn-save-p-ph" id="savePwdBtnPh">
                    <i class="fas fa-save"></i> Change Account Password
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* ============ TAB TRIGGER SYSTEM ============ */
    $('.profile-tab-btn-ph').on('click', function () {
        var tab = $(this).data('tab');
        $('.profile-tab-btn-ph').removeClass('active');
        $(this).addClass('active');
        $('.profile-tab-content-ph').removeClass('active');
        $('#tab-' + tab).addClass('active');

        // Preserve tabs state inside hash redirects
        window.location.hash = tab;
    });

    // Support URL routing direct triggers
    if (window.location.hash) {
        var hash = window.location.hash.substring(1);
        var $tab = $('.profile-tab-btn-ph[data-tab="' + hash + '"]');
        if ($tab.length) $tab.trigger('click');
    }

    /* ============ PASSWORD VISIBILITY TOGGLER ============ */
    $('.toggle-password-visibility').on('click', function () {
        var target = $(this).data('target');
        var $input = $('#' + target);
        var type = $input.attr('type') === 'password' ? 'text' : 'password';
        $input.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    /* ============ FORM VALIDATORS ============ */
    function raiseError($el, msg) {
        $el.addClass('error').removeClass('success');
        $el.closest('.form-group-p-ph').find('.err-msg-p-ph').text(msg).addClass('show');
    }

    function removeError($el) {
        $el.removeClass('error success');
        $el.closest('.form-group-p-ph').find('.err-msg-p-ph').removeClass('show').text('');
    }

    function flagSuccess($el) {
        $el.addClass('success').removeClass('error');
        $el.closest('.form-group-p-ph').find('.err-msg-p-ph').removeClass('show').text('');
    }

    // Live state clearing
    $('.form-control-p-ph').on('input change', function () {
        if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
            removeError($(this));
        }
    });

    $('#ph_phone').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    /* ============ PROFILE INFORMATION FORM ============ */
    $('#pharmacyProfileForm').on('submit', function (e) {
        e.preventDefault();

        var isValid = true;
        $('.err-msg-p-ph').removeClass('show').text('');
        $('.form-control-p-ph').removeClass('error');

        // Name Validation
        var name = $.trim($('#ph_name').val());
        if (name === '') {
            raiseError($('#ph_name'), '⚠ Pharmacy name is required');
            isValid = false;
        } else if (name.length < 3) {
            raiseError($('#ph_name'), '⚠ Pharmacy name must contain at least 3 characters');
            isValid = false;
        } else {
            flagSuccess($('#ph_name'));
        }

        // Owner Name Validation
        var owner = $.trim($('#ph_owner').val());
        if (owner === '') {
            raiseError($('#ph_owner'), '⚠ Owner name is required');
            isValid = false;
        } else {
            flagSuccess($('#ph_owner'));
        }

        // Email Validation
        var email = $.trim($('#ph_email').val());
        var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '') {
            raiseError($('#ph_email'), '⚠ Email address is required');
            isValid = false;
        } else if (!emailRe.test(email)) {
            raiseError($('#ph_email'), '⚠ Enter a valid email format');
            isValid = false;
        } else {
            flagSuccess($('#ph_email'));
        }

        // Mobile Phone Validation
        var phone = $.trim($('#ph_phone').val());
        if (phone === '') {
            raiseError($('#ph_phone'), '⚠ Mobile phone number is required');
            isValid = false;
        } else if (!/^[6-9]\d{9}$/.test(phone)) {
            raiseError($('#ph_phone'), '⚠ Enter a valid 10-digit mobile starting with 6-9');
            isValid = false;
        } else {
            flagSuccess($('#ph_phone'));
        }

        // Village Validation
        if ($('#ph_village').val() === '') {
            raiseError($('#ph_village'), '⚠ Selecting a local market village is required');
            isValid = false;
        } else {
            flagSuccess($('#ph_village'));
        }

        // Address Validation
        var addr = $.trim($('#ph_address').val());
        if (addr === '') {
            raiseError($('#ph_address'), '⚠ Store physical address is required');
            isValid = false;
        } else if (addr.length < 10) {
            raiseError($('#ph_address'), '⚠ Physical address details must contain at least 10 characters');
            isValid = false;
        } else {
            flagSuccess($('#ph_address'));
        }

        if (!isValid) return false;

        var $btn = $('#saveProfileBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        this.submit();
    });

    /* ============ SECURITY PASSWORD CHANGE FORM ============ */
    $('#pharmacyPwdForm').on('submit', function (e) {
        e.preventDefault();

        var isValid = true;
        $('.err-msg-p-ph').removeClass('show').text('');
        $('.form-control-p-ph').removeClass('error');

        // Current Password
        var cur = $('#curPwd').val();
        if (cur === '') {
            raiseError($('#curPwd'), '⚠ Current password cannot be empty');
            isValid = false;
        } else {
            flagSuccess($('#curPwd'));
        }

        // New Password
        var np = $('#newPwd').val();
        if (np === '') {
            raiseError($('#newPwd'), '⚠ New password is required');
            isValid = false;
        } else if (np.length < 6) {
            raiseError($('#newPwd'), '⚠ Password must be at least 6 characters');
            isValid = false;
        } else if (np === cur) {
            raiseError($('#newPwd'), '⚠ New password must be different from current password');
            isValid = false;
        } else {
            flagSuccess($('#newPwd'));
        }

        // Confirmation Password
        var cp = $('#confPwd').val();
        if (cp === '') {
            raiseError($('#confPwd'), '⚠ Confirming your new password is required');
            isValid = false;
        } else if (cp !== np) {
            raiseError($('#confPwd'), '⚠ Confirmed password does not match new password input');
            isValid = false;
        } else {
            flagSuccess($('#confPwd'));
        }

        if (!isValid) return false;

        var $btn = $('#savePwdBtnPh');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        this.submit();
    });

});
</script>
@endsection