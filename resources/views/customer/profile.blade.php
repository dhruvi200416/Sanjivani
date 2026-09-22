@extends('layouts.customer')

@section('title', 'My Profile')
@section('page_title')
<i class="fas fa-user-circle"></i> My Profile
@endsection

@section('styles')
<style>
    /* Profile Header */
    .profile-header {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 20px;
        padding: 35px 30px;
        color: var(--white);
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .profile-header::after {
        content: '\f007';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 30px;
        bottom: -30px;
        font-size: 10rem;
        opacity: 0.08;
    }

    .profile-header-inner {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
    }

    .profile-avatar-wrap {
        position: relative;
    }

    .profile-avatar-big {
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

    .profile-avatar-big img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-change-photo {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--white);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid var(--pale-green);
        transition: var(--transition);
        font-size: 0.9rem;
    }

    .profile-change-photo:hover {
        background: var(--primary-green);
        color: var(--white);
        border-color: var(--white);
        transform: scale(1.1);
    }

    .profile-header-info {
        flex: 1;
    }

    .profile-header-info h2 {
        font-size: 2rem;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .profile-header-info .role-tag {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 4px 15px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .profile-header-meta {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .profile-header-meta span {
        font-size: 0.9rem;
        opacity: 0.92;
    }

    .profile-header-meta span i {
        margin-right: 6px;
    }

    /* Stat Cards */
    .profile-stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .profile-stat-c {
        background: var(--white);
        border-radius: 14px;
        padding: 18px;
        box-shadow: var(--shadow);
        text-align: center;
        transition: var(--transition);
    }

    .profile-stat-c:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(46,125,50,0.15);
    }

    .profile-stat-c .ps-icon-c {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.25rem;
        margin: 0 auto 12px;
    }

    .ps-icon-c.orders    { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .ps-icon-c.delivered { background: linear-gradient(135deg, #1565C0, #42A5F5); }
    .ps-icon-c.spent     { background: linear-gradient(135deg, #E65100, #FFA726); }
    .ps-icon-c.saved     { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }

    .profile-stat-c .ps-val {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1;
        margin-bottom: 4px;
    }

    .profile-stat-c .ps-lbl {
        font-size: 0.78rem;
        color: var(--gray-text);
    }

    /* Tabs Card */
    .profile-tabs-card {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .profile-tabs-header {
        display: flex;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        overflow-x: auto;
    }

    .profile-tab-btn {
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

    .profile-tab-btn i {
        margin-right: 6px;
    }

    .profile-tab-btn:hover {
        color: var(--primary-green);
        background: var(--pale-green);
    }

    .profile-tab-btn.active {
        color: var(--primary-green);
        background: var(--white);
        border-bottom-color: var(--primary-green);
    }

    .profile-tab-content {
        display: none;
        padding: 30px;
    }

    .profile-tab-content.active {
        display: block;
    }

    /* Form Fields */
    .form-group-p {
        margin-bottom: 20px;
        position: relative;
    }

    .form-label-p {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 8px;
        display: block;
    }

    .form-label-p .req {
        color: #E53935;
    }

    .input-wrap-p {
        position: relative;
    }

    .form-control-p {
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

    .form-control-p:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
    }

    .form-control-p.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .form-control-p.success {
        border-color: var(--light-green);
        background: #F1F8E9;
    }

    .form-control-p:disabled {
        background: #F5F5F5;
        color: var(--gray-text);
        cursor: not-allowed;
    }

    .form-select-p {
        width: 100%;
        padding: 12px 40px 12px 44px;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        font-size: 0.92rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: var(--transition);
        background: var(--white);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 12px;
    }

    .form-select-p:focus {
        border-color: var(--primary-green);
    }

    textarea.form-control-p {
        min-height: 90px;
        padding-top: 14px;
        resize: vertical;
    }

    .form-icon-p {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-green);
        font-size: 0.95rem;
        pointer-events: none;
    }

    .form-icon-p.textarea {
        top: 22px;
        transform: none;
    }

    .form-icon-right-p {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-text);
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .form-icon-right-p:hover {
        color: var(--primary-green);
    }

    .err-msg-p {
        color: #E53935;
        font-size: 0.78rem;
        margin-top: 5px;
        display: none;
        font-weight: 500;
    }

    .err-msg-p.show { display: block; }

    /* Password Strength */
    .password-strength-p {
        margin-top: 8px;
        display: none;
    }

    .password-strength-p.show { display: block; }

    .strength-bar-p {
        width: 100%;
        height: 5px;
        background: #E0E0E0;
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .strength-fill-p {
        height: 100%;
        width: 0%;
        transition: all 0.3s;
        border-radius: 3px;
    }

    .strength-text-p {
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Save Button */
    .btn-save-p {
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

    .btn-save-p:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.35);
    }

    .btn-save-p:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Alert */
    .alert-inline-p {
        padding: 12px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 0.88rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-inline-p.success {
        background: #E8F5E9;
        color: #1B5E20;
        border-left: 4px solid #2E7D32;
    }

    .alert-inline-p.error {
        background: #FFEBEE;
        color: #B71C1C;
        border-left: 4px solid #C62828;
    }

    /* Addresses Tab */
    .address-item {
        border: 2px solid #E0E0E0;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 15px;
        position: relative;
        transition: var(--transition);
    }

    .address-item:hover {
        border-color: var(--light-green);
        box-shadow: 0 4px 15px rgba(46,125,50,0.08);
    }

    .address-item.default {
        border-color: var(--primary-green);
        background: var(--pale-green);
    }

    .address-item-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
        gap: 10px;
    }

    .address-item-header .addr-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .address-item-header .addr-title strong {
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--dark-text);
    }

    .addr-type-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .addr-type-badge.home { background: #E3F2FD; color: #1976D2; }
    .addr-type-badge.work { background: #FFF3E0; color: #FB8C00; }
    .addr-type-badge.other { background: #F3E5F5; color: #7B1FA2; }
    .addr-type-badge.default { background: #E8F5E9; color: #2E7D32; }

    .address-item-actions {
        display: flex;
        gap: 6px;
    }

    .addr-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        color: var(--white);
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }

    .addr-action-btn.edit { background: linear-gradient(135deg, #1976D2, #42A5F5); }
    .addr-action-btn.delete { background: linear-gradient(135deg, #C62828, #EF5350); }
    .addr-action-btn.set-default { background: linear-gradient(135deg, #2E7D32, #66BB6A); }

    .addr-action-btn:hover {
        transform: translateY(-2px);
        color: var(--white);
    }

    .address-body {
        color: var(--gray-text);
        font-size: 0.88rem;
        line-height: 1.6;
    }

    .address-body .addr-phone {
        display: block;
        color: var(--dark-text);
        font-weight: 500;
        margin-top: 6px;
    }

    .address-body .addr-phone i {
        color: var(--primary-green);
        margin-right: 5px;
    }

    .btn-add-address {
        background: transparent;
        color: var(--primary-green);
        border: 2px dashed var(--primary-green);
        padding: 14px 20px;
        border-radius: 12px;
        width: 100%;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
        margin-bottom: 20px;
    }

    .btn-add-address:hover {
        background: var(--pale-green);
        border-style: solid;
    }

    /* Modal */
    .modal-content-p {
        border: none;
        border-radius: 18px;
        overflow: hidden;
    }

    .modal-header-p {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 18px 25px;
        border: none;
    }

    .modal-header-p .btn-close {
        filter: brightness(0) invert(1);
    }

    /* Danger Zone */
    .danger-zone {
        background: #FFF5F5;
        border: 2px solid #FFCDD2;
        border-radius: 14px;
        padding: 20px;
        margin-top: 30px;
    }

    .danger-zone h6 {
        color: #C62828;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .danger-zone p {
        color: #6D4C41;
        font-size: 0.85rem;
        margin-bottom: 15px;
    }

    .btn-danger-c {
        background: linear-gradient(135deg, #C62828, #EF5350);
        color: var(--white);
        border: none;
        padding: 10px 22px;
        border-radius: 22px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-danger-c:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(198,40,40,0.3);
        color: var(--white);
    }

    @media (max-width: 767px) {
        .profile-header-inner { flex-direction: column; text-align: center; }
        .profile-header-meta { justify-content: center; }
        .profile-stats-row { grid-template-columns: 1fr 1fr; }
        .profile-tab-btn { padding: 12px 15px; font-size: 0.82rem; }
        .profile-tab-btn i { display: none; }
        .profile-tab-content { padding: 20px; }
    }

    @media (max-width: 576px) {
        .profile-header { padding: 25px 20px; }
        .profile-header-info h2 { font-size: 1.5rem; }
        .profile-avatar-big { width: 100px; height: 100px; font-size: 2.5rem; }
    }
</style>
@endsection

@section('content')

@php
    $customer = $customer ?? (object)[
        'name' => session('customer_name') ?? 'Ramesh Patil',
        'email' => 'ramesh@example.com',
        'phone' => '9876543210',
        'address' => 'House No. 45, Gandhi Road, Nashik',
        'village_id' => 1,
        'gender' => 'male',
        'dob' => '1990-05-15',
        'created_at' => now()->subMonths(8),
        'avatar' => null,
    ];

    $villages = $villages ?? [
        (object)['id'=>1,'name'=>'Nashik'],
        (object)['id'=>2,'name'=>'Pune'],
        (object)['id'=>3,'name'=>'Mumbai'],
        (object)['id'=>4,'name'=>'Aurangabad'],
    ];

    $addresses = $addresses ?? [
        (object)['id'=>1,'name'=>'Ramesh Patil','phone'=>'9876543210','address_line'=>'House No. 45, Gandhi Road','landmark'=>'Near Sai Temple','city'=>'Nashik','state'=>'Maharashtra','pincode'=>'422001','type'=>'home','is_default'=>1],
        (object)['id'=>2,'name'=>'Ramesh Patil','phone'=>'9812345678','address_line'=>'Office Complex, 3rd Floor','landmark'=>'MG Road','city'=>'Nashik','state'=>'Maharashtra','pincode'=>'422002','type'=>'work','is_default'=>0],
    ];

    $totalOrdersCount = $totalOrders ?? 12;
    $deliveredCount = $deliveredOrders ?? 9;
    $totalSpent = $totalSpent ?? 8560;
    $totalSaved = $totalSaved ?? 1250;
@endphp

<!-- Profile Header -->
<div class="profile-header" data-aos="fade-down">
    <div class="profile-header-inner">
        <div class="profile-avatar-wrap">
            <div class="profile-avatar-big" id="avatarDisplay">
                @if(!empty($customer->avatar) && file_exists(public_path('uploads/customers/'.$customer->avatar)))
                    <img src="{{ asset('uploads/customers/'.$customer->avatar) }}" alt="{{ $customer->name }}">
                @else
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                @endif
            </div>
            <label for="avatarUploadInput" class="profile-change-photo" title="Change Photo">
                <i class="fas fa-camera"></i>
            </label>
            <input type="file" id="avatarUploadInput" accept="image/*" style="display:none;">
        </div>

        <div class="profile-header-info">
            <h2>{{ $customer->name }}</h2>
            <span class="role-tag"><i class="fas fa-user me-1"></i> Verified Customer</span>
            <div class="profile-header-meta">
                <span><i class="fas fa-envelope"></i> {{ $customer->email }}</span>
                <span><i class="fas fa-phone"></i> {{ $customer->phone }}</span>
                <span><i class="fas fa-calendar"></i> Member since {{ date('M Y', strtotime($customer->created_at)) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="profile-stats-row" data-aos="fade-up">
    <div class="profile-stat-c">
        <div class="ps-icon-c orders"><i class="fas fa-box"></i></div>
        <div class="ps-val">{{ $totalOrdersCount }}</div>
        <div class="ps-lbl">Total Orders</div>
    </div>
    <div class="profile-stat-c">
        <div class="ps-icon-c delivered"><i class="fas fa-check-circle"></i></div>
        <div class="ps-val">{{ $deliveredCount }}</div>
        <div class="ps-lbl">Delivered</div>
    </div>
    <div class="profile-stat-c">
        <div class="ps-icon-c spent"><i class="fas fa-rupee-sign"></i></div>
        <div class="ps-val">₹{{ number_format($totalSpent) }}</div>
        <div class="ps-lbl">Total Spent</div>
    </div>
    <div class="profile-stat-c">
        <div class="ps-icon-c saved"><i class="fas fa-piggy-bank"></i></div>
        <div class="ps-val">₹{{ number_format($totalSaved) }}</div>
        <div class="ps-lbl">Total Saved</div>
    </div>
</div>

<!-- Tabs Card -->
<div class="profile-tabs-card" data-aos="fade-up">
    <div class="profile-tabs-header">
        <button type="button" class="profile-tab-btn active" data-tab="personal"><i class="fas fa-user"></i> Personal Info</button>
        <button type="button" class="profile-tab-btn" data-tab="addresses"><i class="fas fa-map-marker-alt"></i> My Addresses</button>
        <button type="button" class="profile-tab-btn" data-tab="password"><i class="fas fa-key"></i> Change Password</button>
        <button type="button" class="profile-tab-btn" data-tab="settings"><i class="fas fa-cog"></i> Settings</button>
    </div>

    <!-- ============ PERSONAL INFO TAB ============ -->
    <div class="profile-tab-content active" id="tab-personal">
        @if(session('profile_success'))
            <div class="alert-inline-p success"><i class="fas fa-check-circle"></i>{{ session('profile_success') }}</div>
        @endif

        <form id="personalInfoForm" action="{{ url('/customer/profile/update') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <h5 style="font-weight:700;color:var(--dark-text);margin-bottom:20px;">
                <i class="fas fa-id-card me-2" style="color:var(--primary-green);"></i>Personal Information
            </h5>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-p">
                        <label class="form-label-p">Full Name <span class="req">*</span></label>
                        <div class="input-wrap-p">
                            <i class="fas fa-user form-icon-p"></i>
                            <input type="text" name="name" id="p_name" class="form-control-p" value="{{ $customer->name }}">
                        </div>
                        <span class="err-msg-p" id="err_p_name"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p">
                        <label class="form-label-p">Email Address <span class="req">*</span></label>
                        <div class="input-wrap-p">
                            <i class="fas fa-envelope form-icon-p"></i>
                            <input type="email" name="email" id="p_email" class="form-control-p" value="{{ $customer->email }}">
                        </div>
                        <span class="err-msg-p" id="err_p_email"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p">
                        <label class="form-label-p">Mobile Number <span class="req">*</span></label>
                        <div class="input-wrap-p">
                            <i class="fas fa-phone form-icon-p"></i>
                            <input type="text" name="phone" id="p_phone" class="form-control-p" value="{{ $customer->phone }}" maxlength="10">
                        </div>
                        <span class="err-msg-p" id="err_p_phone"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p">
                        <label class="form-label-p">Date of Birth</label>
                        <div class="input-wrap-p">
                            <i class="fas fa-cake-candles form-icon-p"></i>
                            <input type="date" name="dob" id="p_dob" class="form-control-p" value="{{ $customer->dob ?? '' }}" max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p">
                        <label class="form-label-p">Gender</label>
                        <div class="input-wrap-p">
                            <i class="fas fa-venus-mars form-icon-p"></i>
                            <select name="gender" id="p_gender" class="form-select-p">
                                <option value="">-- Select --</option>
                                <option value="male" {{ ($customer->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ ($customer->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ ($customer->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p">
                        <label class="form-label-p">Village/City <span class="req">*</span></label>
                        <div class="input-wrap-p">
                            <i class="fas fa-map-marker-alt form-icon-p"></i>
                            <select name="village_id" id="p_village" class="form-select-p">
                                <option value="">-- Select --</option>
                                @foreach($villages as $v)
                                    <option value="{{ $v->id }}" {{ ($customer->village_id ?? '') == $v->id ? 'selected' : '' }}>
                                        {{ $v->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <span class="err-msg-p" id="err_p_village"></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group-p">
                        <label class="form-label-p">Default Address</label>
                        <div class="input-wrap-p">
                            <i class="fas fa-home form-icon-p textarea"></i>
                            <textarea name="address" id="p_address" class="form-control-p" placeholder="House No., Street, Landmark, City, State, PIN">{{ $customer->address }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn-save-p" id="savePersonalBtn">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- ============ ADDRESSES TAB ============ -->
    <div class="profile-tab-content" id="tab-addresses">
        <h5 style="font-weight:700;color:var(--dark-text);margin-bottom:20px;">
            <i class="fas fa-map-location-dot me-2" style="color:var(--primary-green);"></i>Saved Addresses
        </h5>

        <button type="button" class="btn-add-address" data-bs-toggle="modal" data-bs-target="#addressModal" id="addAddressBtn">
            <i class="fas fa-plus-circle me-1"></i> Add New Address
        </button>

        @if(count($addresses) > 0)
            @foreach($addresses as $addr)
                <div class="address-item {{ $addr->is_default ? 'default' : '' }}">
                    <div class="address-item-header">
                        <div class="addr-title">
                            <strong>{{ $addr->name }}</strong>
                            <span class="addr-type-badge {{ $addr->type }}">{{ ucfirst($addr->type) }}</span>
                            @if($addr->is_default)
                                <span class="addr-type-badge default">Default</span>
                            @endif
                        </div>
                        <div class="address-item-actions">
                            @if(!$addr->is_default)
                                <button type="button" class="addr-action-btn set-default btn-set-default"
                                        data-id="{{ $addr->id }}" title="Set as Default">
                                    <i class="fas fa-star"></i>
                                </button>
                            @endif
                            <button type="button" class="addr-action-btn edit btn-edit-address"
                                    data-addr='@json($addr)' title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if(!$addr->is_default)
                                <button type="button" class="addr-action-btn delete btn-delete-address"
                                        data-id="{{ $addr->id }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="address-body">
                        {{ $addr->address_line }},
                        @if(!empty($addr->landmark)){{ $addr->landmark }},@endif
                        {{ $addr->city }}, {{ $addr->state }} - {{ $addr->pincode }}
                        <span class="addr-phone"><i class="fas fa-phone"></i>{{ $addr->phone }}</span>
                    </div>
                </div>
            @endforeach
        @else
            <div style="text-align:center;padding:40px;color:var(--gray-text);">
                <i class="fas fa-map-marker-alt" style="font-size:3rem;color:var(--mint-green);margin-bottom:12px;"></i>
                <h6 style="color:var(--dark-text);">No saved addresses</h6>
                <p style="font-size:0.85rem;">Add your first address to make checkout faster.</p>
            </div>
        @endif
    </div>

    <!-- ============ PASSWORD TAB ============ -->
    <div class="profile-tab-content" id="tab-password">
        @if(session('password_success'))
            <div class="alert-inline-p success"><i class="fas fa-check-circle"></i>{{ session('password_success') }}</div>
        @endif
        @if(session('password_error'))
            <div class="alert-inline-p error"><i class="fas fa-exclamation-circle"></i>{{ session('password_error') }}</div>
        @endif

        <h5 style="font-weight:700;color:var(--dark-text);margin-bottom:20px;">
            <i class="fas fa-key me-2" style="color:var(--primary-green);"></i>Change Password
        </h5>

        <p style="color:var(--gray-text);font-size:0.9rem;margin-bottom:25px;">
            <i class="fas fa-info-circle me-1" style="color:var(--primary-green);"></i>
            Choose a strong password with at least 6 characters. Mix letters, numbers and special characters for extra security.
        </p>

        <form id="passwordChangeForm" action="{{ url('/customer/profile/change-password') }}" method="POST" novalidate>
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group-p">
                        <label class="form-label-p">Current Password <span class="req">*</span></label>
                        <div class="input-wrap-p">
                            <i class="fas fa-lock form-icon-p"></i>
                            <input type="password" name="current_password" id="curPwd" class="form-control-p" placeholder="Enter current password" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-p toggle-pwd-p" data-target="curPwd"></i>
                        </div>
                        <span class="err-msg-p" id="err_curPwd"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p">
                        <label class="form-label-p">New Password <span class="req">*</span></label>
                        <div class="input-wrap-p">
                            <i class="fas fa-key form-icon-p"></i>
                            <input type="password" name="new_password" id="newPwd" class="form-control-p" placeholder="Min. 6 characters" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-p toggle-pwd-p" data-target="newPwd"></i>
                        </div>
                        <div class="password-strength-p" id="pwdStrength">
                            <div class="strength-bar-p"><div class="strength-fill-p" id="strengthFillP"></div></div>
                            <span class="strength-text-p" id="strengthTextP">Weak</span>
                        </div>
                        <span class="err-msg-p" id="err_newPwd"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p">
                        <label class="form-label-p">Confirm New Password <span class="req">*</span></label>
                        <div class="input-wrap-p">
                            <i class="fas fa-check-double form-icon-p"></i>
                            <input type="password" name="new_password_confirmation" id="confPwd" class="form-control-p" placeholder="Re-type new password" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-p toggle-pwd-p" data-target="confPwd"></i>
                        </div>
                        <span class="err-msg-p" id="err_confPwd"></span>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn-save-p" id="savePwdBtn">
                    <i class="fas fa-key"></i> Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- ============ SETTINGS TAB ============ -->
    <div class="profile-tab-content" id="tab-settings">
        <h5 style="font-weight:700;color:var(--dark-text);margin-bottom:20px;">
            <i class="fas fa-cog me-2" style="color:var(--primary-green);"></i>Notification Preferences
        </h5>

        <form id="settingsForm" action="{{ url('/customer/profile/settings') }}" method="POST">
            @csrf

            <div style="display:flex;flex-direction:column;gap:12px;">
                <label style="display:flex;justify-content:space-between;align-items:center;padding:15px 18px;background:var(--off-white);border-radius:12px;cursor:pointer;">
                    <div>
                        <strong style="display:block;color:var(--dark-text);font-size:0.92rem;">Email Notifications</strong>
                        <span style="font-size:0.78rem;color:var(--gray-text);">Get order updates via email</span>
                    </div>
                    <input type="checkbox" name="email_notifications" value="1" checked style="width:20px;height:20px;accent-color:var(--primary-green);cursor:pointer;">
                </label>

                <label style="display:flex;justify-content:space-between;align-items:center;padding:15px 18px;background:var(--off-white);border-radius:12px;cursor:pointer;">
                    <div>
                        <strong style="display:block;color:var(--dark-text);font-size:0.92rem;">SMS Notifications</strong>
                        <span style="font-size:0.78rem;color:var(--gray-text);">Get order updates via SMS</span>
                    </div>
                    <input type="checkbox" name="sms_notifications" value="1" checked style="width:20px;height:20px;accent-color:var(--primary-green);cursor:pointer;">
                </label>

                <label style="display:flex;justify-content:space-between;align-items:center;padding:15px 18px;background:var(--off-white);border-radius:12px;cursor:pointer;">
                    <div>
                        <strong style="display:block;color:var(--dark-text);font-size:0.92rem;">Promotional Offers</strong>
                        <span style="font-size:0.78rem;color:var(--gray-text);">Receive offers, deals and discounts</span>
                    </div>
                    <input type="checkbox" name="promo_notifications" value="1" style="width:20px;height:20px;accent-color:var(--primary-green);cursor:pointer;">
                </label>

                <label style="display:flex;justify-content:space-between;align-items:center;padding:15px 18px;background:var(--off-white);border-radius:12px;cursor:pointer;">
                    <div>
                        <strong style="display:block;color:var(--dark-text);font-size:0.92rem;">Prescription Reminders</strong>
                        <span style="font-size:0.78rem;color:var(--gray-text);">Get reminded to refill your regular medicines</span>
                    </div>
                    <input type="checkbox" name="rx_reminders" value="1" checked style="width:20px;height:20px;accent-color:var(--primary-green);cursor:pointer;">
                </label>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn-save-p">
                    <i class="fas fa-save"></i> Save Preferences
                </button>
            </div>
        </form>

        <!-- Danger Zone -->
        <div class="danger-zone">
            <h6><i class="fas fa-triangle-exclamation me-1"></i> Danger Zone</h6>
            <p>Permanently delete your account and all associated data. This action cannot be undone.</p>
            <button type="button" class="btn-danger-c" id="deleteAccountBtn">
                <i class="fas fa-trash-alt"></i> Delete My Account
            </button>
        </div>
    </div>
</div>

<!-- ============ ADD/EDIT ADDRESS MODAL ============ -->
<div class="modal fade" id="addressModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-p">
            <div class="modal-header modal-header-p">
                <h5 class="modal-title" id="addrModalTitle"><i class="fas fa-plus-circle me-2"></i> Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addressForm" action="{{ url('/customer/address/save') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="address_id" id="addrId">
                <div class="modal-body" style="padding:25px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="form-label-p">Recipient Name <span class="req">*</span></label>
                                <div class="input-wrap-p">
                                    <i class="fas fa-user form-icon-p"></i>
                                    <input type="text" name="name" id="a_name" class="form-control-p" placeholder="Full name">
                                </div>
                                <span class="err-msg-p" id="err_a_name"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="form-label-p">Mobile Number <span class="req">*</span></label>
                                <div class="input-wrap-p">
                                    <i class="fas fa-phone form-icon-p"></i>
                                    <input type="text" name="phone" id="a_phone" class="form-control-p" placeholder="10-digit mobile" maxlength="10">
                                </div>
                                <span class="err-msg-p" id="err_a_phone"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-p">
                                <label class="form-label-p">Address Line <span class="req">*</span></label>
                                <div class="input-wrap-p">
                                    <i class="fas fa-home form-icon-p textarea"></i>
                                    <textarea name="address_line" id="a_line" class="form-control-p" placeholder="House No., Street, Area"></textarea>
                                </div>
                                <span class="err-msg-p" id="err_a_line"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="form-label-p">Landmark</label>
                                <div class="input-wrap-p">
                                    <i class="fas fa-map-pin form-icon-p"></i>
                                    <input type="text" name="landmark" id="a_landmark" class="form-control-p" placeholder="Near ...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="form-label-p">City <span class="req">*</span></label>
                                <div class="input-wrap-p">
                                    <i class="fas fa-city form-icon-p"></i>
                                    <input type="text" name="city" id="a_city" class="form-control-p" placeholder="City">
                                </div>
                                <span class="err-msg-p" id="err_a_city"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="form-label-p">State <span class="req">*</span></label>
                                <div class="input-wrap-p">
                                    <i class="fas fa-map form-icon-p"></i>
                                    <input type="text" name="state" id="a_state" class="form-control-p" placeholder="State" value="Maharashtra">
                                </div>
                                <span class="err-msg-p" id="err_a_state"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="form-label-p">Pincode <span class="req">*</span></label>
                                <div class="input-wrap-p">
                                    <i class="fas fa-mail-bulk form-icon-p"></i>
                                    <input type="text" name="pincode" id="a_pincode" class="form-control-p" placeholder="6-digit pincode" maxlength="6">
                                </div>
                                <span class="err-msg-p" id="err_a_pincode"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-p">
                                <label class="form-label-p">Address Type <span class="req">*</span></label>
                                <div style="display:flex;gap:20px;padding:8px 0;">
                                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                                        <input type="radio" name="type" value="home" id="a_type_home" checked style="accent-color:var(--primary-green);width:18px;height:18px;">
                                        <i class="fas fa-home" style="color:#1976D2;"></i> Home
                                    </label>
                                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                                        <input type="radio" name="type" value="work" id="a_type_work" style="accent-color:var(--primary-green);width:18px;height:18px;">
                                        <i class="fas fa-briefcase" style="color:#FB8C00;"></i> Work
                                    </label>
                                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                                        <input type="radio" name="type" value="other" id="a_type_other" style="accent-color:var(--primary-green);width:18px;height:18px;">
                                        <i class="fas fa-map-marker-alt" style="color:#7B1FA2;"></i> Other
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:0.85rem;color:var(--dark-text);">
                                <input type="checkbox" name="is_default" id="a_default" value="1" style="accent-color:var(--primary-green);width:18px;height:18px;">
                                Set as default address
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="btn-save-p" data-bs-dismiss="modal" style="background:linear-gradient(135deg,#607D8B,#90A4AE);">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn-save-p" id="saveAddrBtn">
                        <i class="fas fa-save"></i> Save Address
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* ============ TAB SWITCHING ============ */
    $('.profile-tab-btn').on('click', function () {
        var tab = $(this).data('tab');
        $('.profile-tab-btn').removeClass('active');
        $(this).addClass('active');
        $('.profile-tab-content').removeClass('active');
        $('#tab-' + tab).addClass('active');

        // Update URL hash
        window.location.hash = tab;
    });

    // Load tab from URL hash
    if (window.location.hash) {
        var hash = window.location.hash.substring(1);
        var $tab = $('.profile-tab-btn[data-tab="' + hash + '"]');
        if ($tab.length) $tab.trigger('click');
    }

    /* ============ AVATAR UPLOAD ============ */
    $('#avatarUploadInput').on('change', function () {
        var file = this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('⚠ Image must be less than 2MB');
            $(this).val('');
            return;
        }
        if (!file.type.match('image.*')) {
            alert('⚠ Please upload a valid image file');
            $(this).val('');
            return;
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            $('#avatarDisplay').html('<img src="' + e.target.result + '">');
        };
        reader.readAsDataURL(file);

        // Auto upload via AJAX
        var formData = new FormData();
        formData.append('avatar', file);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ url("/customer/profile/upload-avatar") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    alert('✓ Photo updated successfully!');
                }
            }
        });
    });

    /* ============ PASSWORD TOGGLE ============ */
    $('.toggle-pwd-p').on('click', function () {
        var target = $(this).data('target');
        var $inp = $('#' + target);
        var type = $inp.attr('type') === 'password' ? 'text' : 'password';
        $inp.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    /* ============ PASSWORD STRENGTH ============ */
    $('#newPwd').on('input', function () {
        var val = $(this).val();
        var $wrap = $('#pwdStrength');
        var $fill = $('#strengthFillP');
        var $text = $('#strengthTextP');

        if (val.length === 0) { $wrap.removeClass('show'); return; }
        $wrap.addClass('show');

        var score = 0;
        if (val.length >= 6) score++;
        if (val.length >= 10) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        var levels = [
            { w: '20%', c: '#E53935', t: 'Very Weak' },
            { w: '40%', c: '#FB8C00', t: 'Weak' },
            { w: '60%', c: '#FDD835', t: 'Fair' },
            { w: '80%', c: '#7CB342', t: 'Good' },
            { w: '100%', c: '#2E7D32', t: 'Strong' }
        ];
        var lvl = levels[Math.max(0, score - 1)];
        $fill.css({ width: lvl.w, background: lvl.c });
        $text.text(lvl.t).css('color', lvl.c);
    });

    /* ============ VALIDATION HELPERS ============ */
    function showErr($el, msg) {
        $el.addClass('error').removeClass('success');
        $el.closest('.form-group-p').find('.err-msg-p').text(msg).addClass('show');
    }

    function showOk($el) {
        $el.addClass('success').removeClass('error');
        $el.closest('.form-group-p').find('.err-msg-p').removeClass('show').text('');
    }

    function clearErr($el) {
        $el.removeClass('error success');
        $el.closest('.form-group-p').find('.err-msg-p').removeClass('show').text('');
    }

    $('.form-control-p, .form-select-p').on('input change', function () {
        if ($(this).hasClass('error') && $.trim($(this).val()) !== '') clearErr($(this));
    });

    /* ============ DIGITS ONLY ============ */
    $('#p_phone, #a_phone, #a_pincode').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    /* ============ PERSONAL INFO FORM ============ */
    $('#personalInfoForm').on('submit', function (e) {
        e.preventDefault();
        var isValid = true;

        var name = $.trim($('#p_name').val());
        if (name === '') { showErr($('#p_name'), '⚠ Name required'); isValid = false; }
        else if (name.length < 2) { showErr($('#p_name'), '⚠ Min 2 characters'); isValid = false; }
        else if (!/^[a-zA-Z\s.]+$/.test(name)) { showErr($('#p_name'), '⚠ Only letters, spaces, dots allowed'); isValid = false; }
        else showOk($('#p_name'));

        var email = $.trim($('#p_email').val());
        var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '') { showErr($('#p_email'), '⚠ Email required'); isValid = false; }
        else if (!emailRe.test(email)) { showErr($('#p_email'), '⚠ Invalid email'); isValid = false; }
        else showOk($('#p_email'));

        var phone = $.trim($('#p_phone').val());
        if (phone === '') { showErr($('#p_phone'), '⚠ Phone required'); isValid = false; }
        else if (!/^[6-9]\d{9}$/.test(phone)) { showErr($('#p_phone'), '⚠ Must be 10 digits, starts 6-9'); isValid = false; }
        else showOk($('#p_phone'));

        if ($('#p_village').val() === '') { showErr($('#p_village'), '⚠ Please select village'); isValid = false; }
        else showOk($('#p_village'));

        if (!isValid) return false;

        var $btn = $('#savePersonalBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        this.submit();
    });

    /* ============ PASSWORD FORM ============ */
    $('#passwordChangeForm').on('submit', function (e) {
        e.preventDefault();
        var isValid = true;

        var cur = $('#curPwd').val();
        if (cur === '') { showErr($('#curPwd'), '⚠ Current password required'); isValid = false; }
        else showOk($('#curPwd'));

        var np = $('#newPwd').val();
        if (np === '') { showErr($('#newPwd'), '⚠ New password required'); isValid = false; }
        else if (np.length < 6) { showErr($('#newPwd'), '⚠ Min 6 characters'); isValid = false; }
        else if (np === cur) { showErr($('#newPwd'), '⚠ Must be different from current password'); isValid = false; }
        else showOk($('#newPwd'));

        var cp = $('#confPwd').val();
        if (cp === '') { showErr($('#confPwd'), '⚠ Confirm new password'); isValid = false; }
        else if (cp !== np) { showErr($('#confPwd'), '⚠ Passwords do not match'); isValid = false; }
        else showOk($('#confPwd'));

        if (!isValid) return false;

        var $btn = $('#savePwdBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        this.submit();
    });

    /* ============ ADDRESS MODAL - ADD ============ */
    $('#addAddressBtn').on('click', function () {
        $('#addressForm')[0].reset();
        $('#addrId').val('');
        $('#addrModalTitle').html('<i class="fas fa-plus-circle me-2"></i> Add New Address');
        $('.err-msg-p').removeClass('show').text('');
        $('.form-control-p').removeClass('error success');
    });

    /* ============ ADDRESS MODAL - EDIT ============ */
    $('.btn-edit-address').on('click', function () {
        var a = $(this).data('addr');
        $('#addrId').val(a.id);
        $('#a_name').val(a.name);
        $('#a_phone').val(a.phone);
        $('#a_line').val(a.address_line);
        $('#a_landmark').val(a.landmark);
        $('#a_city').val(a.city);
        $('#a_state').val(a.state);
        $('#a_pincode').val(a.pincode);
        $('#a_type_' + a.type).prop('checked', true);
        $('#a_default').prop('checked', a.is_default == 1);

        $('#addrModalTitle').html('<i class="fas fa-edit me-2"></i> Edit Address');
        $('.err-msg-p').removeClass('show').text('');
        $('.form-control-p').removeClass('error success');
        $('#addressModal').modal('show');
    });

    /* ============ ADDRESS FORM VALIDATION ============ */
    $('#addressForm').on('submit', function (e) {
        e.preventDefault();
        var isValid = true;

        var name = $.trim($('#a_name').val());
        if (name === '') { showErr($('#a_name'), '⚠ Name required'); isValid = false; }
        else if (name.length < 2) { showErr($('#a_name'), '⚠ Min 2 characters'); isValid = false; }

        var phone = $.trim($('#a_phone').val());
        if (phone === '') { showErr($('#a_phone'), '⚠ Phone required'); isValid = false; }
        else if (!/^[6-9]\d{9}$/.test(phone)) { showErr($('#a_phone'), '⚠ Must be 10 digits, starts 6-9'); isValid = false; }

        var addr = $.trim($('#a_line').val());
        if (addr === '') { showErr($('#a_line'), '⚠ Address required'); isValid = false; }
        else if (addr.length < 10) { showErr($('#a_line'), '⚠ Min 10 characters'); isValid = false; }

        if ($.trim($('#a_city').val()) === '') { showErr($('#a_city'), '⚠ City required'); isValid = false; }
        if ($.trim($('#a_state').val()) === '') { showErr($('#a_state'), '⚠ State required'); isValid = false; }

        var pin = $.trim($('#a_pincode').val());
        if (pin === '') { showErr($('#a_pincode'), '⚠ Pincode required'); isValid = false; }
        else if (!/^\d{6}$/.test(pin)) { showErr($('#a_pincode'), '⚠ Must be 6 digits'); isValid = false; }

        if (!isValid) return false;

        var $btn = $('#saveAddrBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        this.submit();
    });

    /* ============ SET DEFAULT ADDRESS ============ */
    $('.btn-set-default').on('click', function () {
        var id = $(this).data('id');
        if (!confirm('Set this as your default address?')) return;

        var $form = $('<form>', { method: 'POST', action: '{{ url("/customer/address/set-default") }}' });
        $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
        $form.append('<input type="hidden" name="address_id" value="' + id + '">');
        $('body').append($form); $form.submit();
    });

    /* ============ DELETE ADDRESS ============ */
    $('.btn-delete-address').on('click', function () {
        var id = $(this).data('id');
        if (!confirm('⚠ Are you sure you want to delete this address?')) return;

        var $form = $('<form>', { method: 'POST', action: '{{ url("/customer/address/delete") }}' });
        $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
        $form.append('<input type="hidden" name="address_id" value="' + id + '">');
        $form.append('<input type="hidden" name="_method" value="DELETE">');
        $('body').append($form); $form.submit();
    });

    /* ============ DELETE ACCOUNT ============ */
    $('#deleteAccountBtn').on('click', function () {
        var confirm1 = confirm('⚠ WARNING: This will permanently delete your account, orders history and all data.\n\nAre you sure you want to continue?');
        if (!confirm1) return;

        var input = prompt('Please type "DELETE" to confirm account deletion:');
        if (input !== 'DELETE') {
            alert('Account deletion cancelled.');
            return;
        }

        var $form = $('<form>', { method: 'POST', action: '{{ url("/customer/profile/delete-account") }}' });
        $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
        $form.append('<input type="hidden" name="_method" value="DELETE">');
        $('body').append($form); $form.submit();
    });

});
</script>
@endsection