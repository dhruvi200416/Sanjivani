@extends('layouts.delivery')

@section('title', 'My Profile')
@section('page_title')
<i class="fas fa-user-circle"></i> My Profile
@endsection

@section('styles')
<style>
    .profile-hero {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 20px; padding: 35px 30px; color: var(--white);
        position: relative; overflow: hidden; margin-bottom: 25px;
    }

    .profile-hero::after {
        content: '\f5dc'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 30px; bottom: -30px;
        font-size: 10rem; opacity: 0.1;
    }

    .profile-hero-inner {
        display: flex; align-items: center; gap: 25px;
        position: relative; z-index: 2; flex-wrap: wrap;
    }

    .avatar-hero {
        width: 110px; height: 110px; border-radius: 50%;
        background: var(--white); color: var(--primary-green);
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; font-weight: 800;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        border: 5px solid rgba(255,255,255,0.3);
    }

    .hero-info { flex: 1; }

    .hero-info h2 {
        font-size: 1.9rem; font-weight: 800; margin: 0 0 6px;
    }

    .hero-info .badge-role {
        background: rgba(255,255,255,0.2); padding: 4px 15px;
        border-radius: 20px; font-size: 0.78rem;
        font-weight: 600; display: inline-block; margin-bottom: 10px;
    }

    .hero-info .rating-hero {
        display: inline-flex; align-items: center; gap: 6px;
        background: #FFC107; color: #333; padding: 4px 12px;
        border-radius: 15px; font-size: 0.85rem; font-weight: 700;
        margin-left: 8px;
    }

    .hero-meta { display: flex; gap: 20px; flex-wrap: wrap; }

    .hero-meta span {
        font-size: 0.88rem; opacity: 0.92;
    }

    .hero-meta span i { margin-right: 5px; }

    /* Stat Row */
    .stat-row-p {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 15px; margin-bottom: 25px;
    }

    .stat-tile-p {
        background: var(--white); border-radius: 14px; padding: 20px;
        box-shadow: var(--shadow); text-align: center;
    }

    .stat-tile-p .st-ic {
        width: 55px; height: 55px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        color: var(--white); font-size: 1.3rem; margin: 0 auto 10px;
    }

    .st-total { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .st-week  { background: linear-gradient(135deg, #1565C0, #42A5F5); }
    .st-dist  { background: linear-gradient(135deg, #E65100, #FFA726); }
    .st-earn  { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }

    .stat-tile-p .st-val {
        font-size: 1.5rem; font-weight: 800; color: var(--dark-text);
    }

    .stat-tile-p .st-lbl {
        font-size: 0.78rem; color: var(--gray-text);
    }

    /* Tabs */
    .profile-tabs-card {
        background: var(--white); border-radius: 18px;
        box-shadow: var(--shadow); overflow: hidden;
    }

    .profile-tabs-head {
        display: flex; background: var(--off-white);
        border-bottom: 1px solid #E0E0E0; overflow-x: auto;
    }

    .profile-tab-b {
        padding: 15px 25px; cursor: pointer;
        font-size: 0.9rem; font-weight: 600; color: var(--gray-text);
        border: none; background: transparent;
        border-bottom: 3px solid transparent;
        transition: var(--transition); white-space: nowrap;
    }

    .profile-tab-b i { margin-right: 6px; }

    .profile-tab-b:hover {
        color: var(--primary-green); background: var(--pale-green);
    }

    .profile-tab-b.active {
        color: var(--primary-green); background: var(--white);
        border-bottom-color: var(--primary-green);
    }

    .tab-content-p {
        display: none; padding: 30px;
    }

    .tab-content-p.active { display: block; }

    .form-group-dp {
        margin-bottom: 18px; position: relative;
    }

    .form-label-dp {
        font-size: 0.85rem; font-weight: 600; color: var(--dark-text);
        margin-bottom: 8px; display: block;
    }

    .form-label-dp .req { color: #E53935; }

    .input-wrap-dp { position: relative; }

    .form-control-dp {
        width: 100%; padding: 12px 16px 12px 44px;
        border: 2px solid #E0E0E0; border-radius: 12px;
        font-size: 0.92rem; font-family: 'Poppins', sans-serif;
        outline: none; transition: var(--transition);
    }

    .form-control-dp:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
    }

    .form-control-dp.error { border-color: #E53935; background: #FFF5F5; }
    .form-control-dp:disabled { background: #F5F5F5; color: var(--gray-text); }

    .form-select-dp {
        width: 100%; padding: 12px 40px 12px 44px;
        border: 2px solid #E0E0E0; border-radius: 12px;
        font-size: 0.92rem; outline: none; background: var(--white);
        cursor: pointer; appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat; background-position: right 15px center;
        background-size: 12px; font-family: 'Poppins', sans-serif;
    }

    .form-icon-dp {
        position: absolute; left: 16px; top: 50%;
        transform: translateY(-50%); color: var(--primary-green);
        font-size: 0.95rem; pointer-events: none;
    }

    .form-icon-right-dp {
        position: absolute; right: 16px; top: 50%;
        transform: translateY(-50%); color: var(--gray-text);
        font-size: 0.9rem; cursor: pointer;
    }

    .err-msg-dp {
        color: #E53935; font-size: 0.78rem;
        margin-top: 5px; display: none;
    }

    .err-msg-dp.show { display: block; }

    .btn-save-dp {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); border: none;
        padding: 12px 32px; border-radius: 25px;
        font-weight: 700; font-size: 0.92rem;
        cursor: pointer; transition: var(--transition);
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 6px 15px rgba(46,125,50,0.25);
    }

    .btn-save-dp:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.35);
    }

    .vehicle-card {
        background: var(--off-white); border-radius: 14px;
        padding: 20px; margin-bottom: 15px;
    }

    .vehicle-card h6 {
        font-weight: 700; color: var(--dark-text); margin-bottom: 15px;
    }

    .alert-inline-dp {
        padding: 12px 18px; border-radius: 10px;
        margin-bottom: 20px; font-size: 0.88rem;
    }

    .alert-inline-dp.success {
        background: #E8F5E9; color: #1B5E20;
        border-left: 4px solid #2E7D32;
    }

    .alert-inline-dp.error {
        background: #FFEBEE; color: #B71C1C;
        border-left: 4px solid #C62828;
    }

    @media (max-width: 767px) {
        .profile-hero-inner { flex-direction: column; text-align: center; }
        .hero-meta { justify-content: center; }
        .stat-row-p { grid-template-columns: 1fr 1fr; }
        .profile-tab-b { padding: 12px 15px; font-size: 0.82rem; }
        .profile-tab-b i { display: none; }
        .tab-content-p { padding: 20px; }
    }
</style>
@endsection

@section('content')

@php
    $partner = $partner ?? (object)[
        'name' => session('delivery_name') ?? 'Sunil Kumar',
        'email' => 'sunil@example.com',
        'phone' => '9876543210',
        'aadhar_number' => '123456789012',
        'vehicle_type' => 'Bike',
        'vehicle_number' => 'MH-01-AB-1234',
        'license_dl' => 'MH01-20200012345',
        'address' => 'Nashik, Maharashtra',
        'village_id' => 1,
        'status' => 'active',
        'availability' => 'online',
        'rating' => 4.7,
        'total_deliveries' => 234,
        'created_at' => now()->subYears(1),
    ];

    $totalDeliveries = $partner->total_deliveries;
    $weekDeliveries = 34;
    $totalDistance = 892;
    $totalEarnings = 12580;
@endphp

<!-- Hero -->
<div class="profile-hero">
    <div class="profile-hero-inner">
        <div class="avatar-hero">{{ strtoupper(substr($partner->name, 0, 1)) }}</div>
        <div class="hero-info">
            <h2>
                {{ $partner->name }}
                <span class="rating-hero"><i class="fas fa-star"></i> {{ $partner->rating }}</span>
            </h2>
            <span class="badge-role"><i class="fas fa-motorcycle me-1"></i> Delivery Partner</span>
            <div class="hero-meta">
                <span><i class="fas fa-phone"></i> {{ $partner->phone }}</span>
                <span><i class="fas fa-envelope"></i> {{ $partner->email }}</span>
                <span><i class="fas fa-calendar"></i> Since {{ date('M Y', strtotime($partner->created_at)) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="stat-row-p">
    <div class="stat-tile-p">
        <div class="st-ic st-total"><i class="fas fa-box"></i></div>
        <div class="st-val">{{ $totalDeliveries }}</div>
        <div class="st-lbl">Total Deliveries</div>
    </div>
    <div class="stat-tile-p">
        <div class="st-ic st-week"><i class="fas fa-calendar-week"></i></div>
        <div class="st-val">{{ $weekDeliveries }}</div>
        <div class="st-lbl">This Week</div>
    </div>
    <div class="stat-tile-p">
        <div class="st-ic st-dist"><i class="fas fa-road"></i></div>
        <div class="st-val">{{ $totalDistance }} km</div>
        <div class="st-lbl">Total Distance</div>
    </div>
    <div class="stat-tile-p">
        <div class="st-ic st-earn"><i class="fas fa-rupee-sign"></i></div>
        <div class="st-val">₹{{ number_format($totalEarnings) }}</div>
        <div class="st-lbl">Total Earned</div>
    </div>
</div>

<!-- Tabs -->
<div class="profile-tabs-card">
    <div class="profile-tabs-head">
        <button type="button" class="profile-tab-b active" data-tab="personal"><i class="fas fa-user"></i> Personal Info</button>
        <button type="button" class="profile-tab-b" data-tab="vehicle"><i class="fas fa-motorcycle"></i> Vehicle Details</button>
        <button type="button" class="profile-tab-b" data-tab="password"><i class="fas fa-key"></i> Change Password</button>
    </div>

    <!-- Personal Info -->
    <div class="tab-content-p active" id="tab-personal">
        @if(session('profile_success'))
            <div class="alert-inline-dp success"><i class="fas fa-check-circle me-1"></i>{{ session('profile_success') }}</div>
        @endif

        <form id="personalFormD" action="{{ url('/delivery/profile/update') }}" method="POST" novalidate>
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">Full Name <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-user form-icon-dp"></i>
                            <input type="text" name="name" id="dp_name" class="form-control-dp" value="{{ $partner->name }}">
                        </div>
                        <span class="err-msg-dp" id="err_dp_name"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">Email <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-envelope form-icon-dp"></i>
                            <input type="email" name="email" id="dp_email" class="form-control-dp" value="{{ $partner->email }}">
                        </div>
                        <span class="err-msg-dp" id="err_dp_email"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">Mobile <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-phone form-icon-dp"></i>
                            <input type="text" name="phone" id="dp_phone" class="form-control-dp" value="{{ $partner->phone }}" maxlength="10">
                        </div>
                        <span class="err-msg-dp" id="err_dp_phone"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">Aadhar Number</label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-id-badge form-icon-dp"></i>
                            <input type="text" class="form-control-dp" value="{{ $partner->aadhar_number }}" disabled>
                        </div>
                        <small style="color:var(--gray-text);font-size:0.72rem;">Contact admin to change Aadhar</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group-dp">
                        <label class="form-label-dp">Address <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-home form-icon-dp"></i>
                            <input type="text" name="address" id="dp_address" class="form-control-dp" value="{{ $partner->address }}">
                        </div>
                        <span class="err-msg-dp" id="err_dp_address"></span>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn-save-dp" id="savePersonalDp">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Vehicle -->
    <div class="tab-content-p" id="tab-vehicle">
        <div class="vehicle-card">
            <h6><i class="fas fa-motorcycle me-1" style="color:var(--primary-green);"></i> Current Vehicle Information</h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group-dp">
                        <label class="form-label-dp">Vehicle Type</label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-truck form-icon-dp"></i>
                            <input type="text" class="form-control-dp" value="{{ $partner->vehicle_type }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-dp">
                        <label class="form-label-dp">Vehicle Number</label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-hashtag form-icon-dp"></i>
                            <input type="text" class="form-control-dp" value="{{ $partner->vehicle_number }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-dp">
                        <label class="form-label-dp">DL Number</label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-id-card form-icon-dp"></i>
                            <input type="text" class="form-control-dp" value="{{ $partner->license_dl }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div style="background:#FFF3E0;padding:12px 15px;border-radius:10px;color:#E65100;font-size:0.85rem;">
                <i class="fas fa-info-circle me-1"></i>
                To update vehicle or license details, please contact admin at <a href="mailto:support@sanjivani.com" style="color:#E65100;font-weight:600;">support@sanjivani.com</a>
            </div>
        </div>
    </div>

    <!-- Password -->
    <div class="tab-content-p" id="tab-password">
        @if(session('password_success'))
            <div class="alert-inline-dp success"><i class="fas fa-check-circle me-1"></i>{{ session('password_success') }}</div>
        @endif
        @if(session('password_error'))
            <div class="alert-inline-dp error"><i class="fas fa-exclamation-circle me-1"></i>{{ session('password_error') }}</div>
        @endif

        <form id="passwordFormD" action="{{ url('/delivery/profile/change-password') }}" method="POST" novalidate>
            @csrf

            <div class="form-group-dp">
                <label class="form-label-dp">Current Password <span class="req">*</span></label>
                <div class="input-wrap-dp">
                    <i class="fas fa-lock form-icon-dp"></i>
                    <input type="password" name="current_password" id="cur_pwd_d" class="form-control-dp" placeholder="Enter current password" style="padding-right:45px;">
                    <i class="fas fa-eye form-icon-right-dp toggle-pwd-d" data-target="cur_pwd_d"></i>
                </div>
                <span class="err-msg-dp" id="err_cur_pwd_d"></span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">New Password <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-key form-icon-dp"></i>
                            <input type="password" name="new_password" id="new_pwd_d" class="form-control-dp" placeholder="Min. 6 characters" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-dp toggle-pwd-d" data-target="new_pwd_d"></i>
                        </div>
                        <span class="err-msg-dp" id="err_new_pwd_d"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">Confirm New <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-check-double form-icon-dp"></i>
                            <input type="password" name="new_password_confirmation" id="conf_pwd_d" class="form-control-dp" placeholder="Re-type new password" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-dp toggle-pwd-d" data-target="conf_pwd_d"></i>
                        </div>
                        <span class="err-msg-dp" id="err_conf_pwd_d"></span>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn-save-dp" id="savePwdDp">
                    <i class="fas fa-key"></i> Update Password
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* Tabs */
    $('.profile-tab-b').on('click', function () {
        var tab = $(this).data('tab');
        $('.profile-tab-b').removeClass('active');
        $(this).addClass('active');
        $('.tab-content-p').removeClass('active');
        $('#tab-' + tab).addClass('active');
    });

    /* Password Toggle */
    $('.toggle-pwd-d').on('click', function () {
        var t = $(this).data('target');
        var $i = $('#' + t);
        $i.attr('type', $i.attr('type') === 'password' ? 'text' : 'password');
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    /* Helpers */
    function showErr($el, msg) {
        $el.addClass('error');
        $el.closest('.form-group-dp').find('.err-msg-dp').text(msg).addClass('show');
    }

    function clearErr($el) {
        $el.removeClass('error');
        $el.closest('.form-group-dp').find('.err-msg-dp').removeClass('show').text('');
    }

    $('#dp_phone').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('.form-control-dp').on('input', function () {
        if ($(this).hasClass('error') && $.trim($(this).val()) !== '') clearErr($(this));
    });

    /* Personal Form Submit */
    $('#personalFormD').on('submit', function (e) {
        e.preventDefault();
        var isValid = true;

        var name = $.trim($('#dp_name').val());
        if (name === '') { showErr($('#dp_name'), '⚠ Name required'); isValid = false; }
        else if (name.length < 2) { showErr($('#dp_name'), '⚠ Min 2 characters'); isValid = false; }

        var email = $.trim($('#dp_email').val());
        if (email === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showErr($('#dp_email'), '⚠ Valid email required'); isValid = false;
        }

        var phone = $.trim($('#dp_phone').val());
        if (!/^[6-9]\d{9}$/.test(phone)) {
            showErr($('#dp_phone'), '⚠ 10 digits, starts 6-9'); isValid = false;
        }

        if ($.trim($('#dp_address').val()) === '') {
            showErr($('#dp_address'), '⚠ Address required'); isValid = false;
        }

        if (!isValid) return false;

        var $btn = $('#savePersonalDp');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        this.submit();
    });

    /* Password Form Submit */
    $('#passwordFormD').on('submit', function (e) {
        e.preventDefault();
        var isValid = true;

        var cur = $('#cur_pwd_d').val();
        if (cur === '') { showErr($('#cur_pwd_d'), '⚠ Current password required'); isValid = false; }

        var np = $('#new_pwd_d').val();
        if (np === '') { showErr($('#new_pwd_d'), '⚠ New password required'); isValid = false; }
        else if (np.length < 6) { showErr($('#new_pwd_d'), '⚠ Min 6 characters'); isValid = false; }
        else if (np === cur) { showErr($('#new_pwd_d'), '⚠ Must differ from current'); isValid = false; }

        var cp = $('#conf_pwd_d').val();
        if (cp !== np) { showErr($('#conf_pwd_d'), '⚠ Passwords do not match'); isValid = false; }

        if (!isValid) return false;

        var $btn = $('#savePwdDp');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        this.submit();
    });

});
</script>
@endsection