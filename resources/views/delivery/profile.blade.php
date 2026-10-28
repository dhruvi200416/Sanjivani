@extends('layouts.delivery')

@section('title', 'My Profile')
@section('page_title')
<i class="fas fa-user-circle"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('My Profile') }}
@endsection

@section('styles')
<style>
    .profile-hero {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 20px;
        padding: 35px 30px;
        color: var(--white);
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .profile-hero::after {
        content: '\f5dc';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 30px;
        bottom: -30px;
        font-size: 10rem;
        opacity: 0.1;
    }

    .profile-hero-inner {
        display: flex;
        align-items: center;
        gap: 25px;
        position: relative;
        z-index: 2;
        flex-wrap: wrap;
    }

    /* Static Avatar for Hero */
    .avatar-hero {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: var(--white);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border: 5px solid rgba(255, 255, 255, 0.3);
        overflow: hidden;
    }

    .avatar-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-info {
        flex: 1;
    }

    .hero-info h2 {
        font-size: 1.9rem;
        font-weight: 800;
        margin: 0 0 6px;
    }

    .hero-info .badge-role {
        background: rgba(255, 255, 255, 0.2);
        padding: 4px 15px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 10px;
    }

    .hero-info .rating-hero {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #FFC107;
        color: #333;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 700;
        margin-left: 8px;
    }

    .hero-meta {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .hero-meta span {
        font-size: 0.88rem;
        opacity: 0.92;
    }

    .hero-meta span i {
        margin-right: 5px;
    }

    /* Stat Row */
    .stat-row-p {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-tile-p {
        background: var(--white);
        border-radius: 14px;
        padding: 20px;
        box-shadow: var(--shadow);
        text-align: center;
    }

    .stat-tile-p .st-ic {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.3rem;
        margin: 0 auto 10px;
    }

    .st-total {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .st-week {
        background: linear-gradient(135deg, #1565C0, #42A5F5);
    }

    .st-dist {
        background: linear-gradient(135deg, #E65100, #FFA726);
    }

    .st-earn {
        background: linear-gradient(135deg, #7B1FA2, #AB47BC);
    }

    .stat-tile-p .st-val {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--dark-text);
    }

    .stat-tile-p .st-lbl {
        font-size: 0.78rem;
        color: var(--gray-text);
    }

    /* Tabs */
    .profile-tabs-card {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .profile-tabs-head {
        display: flex;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        overflow-x: auto;
    }

    .profile-tab-b {
        padding: 15px 25px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--gray-text);
        border: none;
        background: transparent;
        border-bottom: 3px solid transparent;
        transition: var(--transition);
        white-space: nowrap;
    }

    .profile-tab-b i {
        margin-right: 6px;
    }

    .profile-tab-b:hover {
        color: var(--primary-green);
        background: var(--pale-green);
    }

    .profile-tab-b.active {
        color: var(--primary-green);
        background: var(--white);
        border-bottom-color: var(--primary-green);
    }

    .tab-content-p {
        display: none;
        padding: 30px;
    }

    .tab-content-p.active {
        display: block;
    }

    /* Image Upload Area (Inside Form) */
    .avatar-upload-area {
        border: 2px dashed var(--primary-green);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background: var(--off-white);
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .avatar-upload-area:hover {
        background: var(--pale-green);
        border-color: var(--light-green);
    }

    .avatar-upload-area i.upload-icon {
        font-size: 2.5rem;
        color: var(--primary-green);
        margin-bottom: 10px;
    }

    .avatar-upload-area p {
        margin: 0;
        color: var(--primary-green);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .avatar-upload-area small {
        color: var(--gray-text);
        font-size: 0.75rem;
        display: block;
        margin-top: 5px;
    }

    .avatar-preview-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 10px;
        border: 3px solid var(--primary-green);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Form Fields */
    .form-group-dp {
        margin-bottom: 18px;
        position: relative;
    }

    .form-label-dp {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 8px;
        display: block;
    }

    .form-label-dp .req {
        color: #E53935;
    }

    .input-wrap-dp {
        position: relative;
    }

    .form-control-dp {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        font-size: 0.92rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: var(--transition);
    }

    .form-control-dp:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .form-control-dp.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .form-control-dp:disabled {
        background: #F5F5F5;
        color: var(--gray-text);
    }

    .form-icon-dp {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-green);
        font-size: 0.95rem;
        pointer-events: none;
    }

    .form-icon-right-dp {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-text);
        font-size: 0.9rem;
        cursor: pointer;
    }

    .err-msg-dp {
        color: #E53935;
        font-size: 0.78rem;
        margin-top: 5px;
        display: none;
    }

    .err-msg-dp.show {
        display: block;
    }

    .btn-save-dp {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 12px 32px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.92rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 6px 15px rgba(46, 125, 50, 0.25);
    }

    .btn-save-dp:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(46, 125, 50, 0.35);
    }

    .vehicle-card {
        background: var(--off-white);
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 15px;
    }

    .vehicle-card h6 {
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 15px;
    }

    .alert-inline-dp {
        padding: 12px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 0.88rem;
    }

    .alert-inline-dp.success {
        background: #E8F5E9;
        color: #1B5E20;
        border-left: 4px solid #2E7D32;
    }

    .alert-inline-dp.error {
        background: #FFEBEE;
        color: #B71C1C;
        border-left: 4px solid #C62828;
    }

    @media (max-width: 767px) {
        .profile-hero-inner {
            flex-direction: column;
            text-align: center;
        }

        .hero-meta {
            justify-content: center;
        }

        .stat-row-p {
            grid-template-columns: 1fr 1fr;
        }

        .profile-tab-b {
            padding: 12px 15px;
            font-size: 0.82rem;
        }

        .profile-tab-b i {
            display: none;
        }

        .tab-content-p {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

$partner = $partner ?? (object)[
'name' => session('delivery_name') ?? 'Sunil Kumar',
'email' => 'sunil@example.com',
'phone' => '9876543210',
'aadhar_number' => '123456789012',
'vehicle_type' => 'Bike',
'vehicle_number' => 'GJ-01-AB-1234',
'license_dl' => 'GJ01-20200012345',
'address' => 'Rajkot, Gujarat',
'village_id' => 1,
'status' => 'active',
'availability' => 'online',
'rating' => 4.7,
'total_deliveries' => 234,
'created_at' => now()->subYears(1),
'avatar' => null,
];

$totalDeliveries = $partner->total_deliveries;
$weekDeliveries = 34;
$totalDistance = 892;
$totalEarnings = 12580;

// Translate DB values
$tName = GoogleTranslator::translate($partner->name);
$tAddress = GoogleTranslator::translate($partner->address);
$tVehicleType = GoogleTranslator::translate($partner->vehicle_type);

$strings = GoogleTranslator::translateBatch([
'badge_role' => 'Delivery Partner',
'lbl_since' => 'Since',
'stat_total' => 'Total Deliveries',
'stat_week' => 'This Week',
'stat_dist' => 'Total Distance',
'stat_earn' => 'Total Earned',

// Tabs
'tab_personal' => 'Personal Info',
'tab_vehicle' => 'Vehicle Details',
'tab_password' => 'Change Password',

// Personal Form
'lbl_name' => 'Full Name',
'lbl_email' => 'Email',
'lbl_phone' => 'Mobile',
'lbl_aadhar' => 'Aadhar Number',
'note_aadhar' => 'Contact admin to change Aadhar',
'lbl_address' => 'Address',
'btn_save' => 'Save Changes',

// Vehicle Form
'vehicle_info' => 'Current Vehicle Information',
'lbl_veh_type' => 'Vehicle Type',
'lbl_veh_num' => 'Vehicle Number',
'lbl_dl' => 'DL Number',
'note_vehicle' => 'To update vehicle or license details, please contact admin at',

// Password Form
'lbl_cur_pwd' => 'Current Password',
'ph_cur_pwd' => 'Enter current password',
'lbl_new_pwd' => 'New Password',
'ph_new_pwd' => 'Min. 6 characters',
'lbl_conf_pwd' => 'Confirm New',
'ph_conf_pwd' => 'Re-type new password',
'btn_update_pwd' => 'Update Password',

// JS Validation & Upload
'js_name_req' => '⚠ Name required',
'js_name_min' => '⚠ Min 2 characters',
'js_email_req' => '⚠ Valid email required',
'js_phone_req' => '⚠ 10 digits, starts 6-9',
'js_addr_req' => '⚠ Address required',
'js_cur_pwd_req' => '⚠ Current password required',
'js_new_pwd_req' => '⚠ New password required',
'js_new_pwd_min' => '⚠ Min 6 characters',
'js_new_pwd_same' => '⚠ Must differ from current',
'js_conf_pwd_match' => '⚠ Passwords do not match',
'js_saving' => 'Saving...',
'js_updating' => 'Updating...',
'js_img_size' => '⚠ Image must be less than 2MB',
'js_img_type' => '⚠ Please upload a valid image file',
'js_img_success' => '✓ Photo updated successfully!'
]);
@endphp

<!-- Hero (Static Image) -->
<div class="profile-hero">
    <div class="profile-hero-inner">

        <div class="avatar-hero" id="heroAvatar">
            @if(!empty($partner->avatar) && file_exists(public_path('images/'.$partner->avatar)))
            <img src="{{ asset('images/'.$partner->avatar) }}" alt="{{ $tName }}">
            @else
            {{ strtoupper(substr($tName, 0, 1)) }}
            @endif
        </div>

        <div class="hero-info">
            <h2>
                {{ $tName }}
                <span class="rating-hero"><i class="fas fa-star"></i> {{ $partner->rating }}</span>
            </h2>
            <span class="badge-role"><i class="fas fa-motorcycle me-1"></i> {{ $strings['badge_role'] }}</span>
            <div class="hero-meta">
                <span><i class="fas fa-phone"></i> {{ $partner->phone }}</span>
                <span><i class="fas fa-envelope"></i> {{ $partner->email }}</span>
                <span><i class="fas fa-calendar"></i> {{ $strings['lbl_since'] }} {{ date('M Y', strtotime($partner->created_at)) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="stat-row-p">
    <div class="stat-tile-p">
        <div class="st-ic st-total"><i class="fas fa-box"></i></div>
        <div class="st-val">{{ $totalDeliveries }}</div>
        <div class="st-lbl">{{ $strings['stat_total'] }}</div>
    </div>
    <div class="stat-tile-p">
        <div class="st-ic st-week"><i class="fas fa-calendar-week"></i></div>
        <div class="st-val">{{ $weekDeliveries }}</div>
        <div class="st-lbl">{{ $strings['stat_week'] }}</div>
    </div>
    <div class="stat-tile-p">
        <div class="st-ic st-dist"><i class="fas fa-road"></i></div>
        <div class="st-val">{{ $totalDistance }} km</div>
        <div class="st-lbl">{{ $strings['stat_dist'] }}</div>
    </div>
    <div class="stat-tile-p">
        <div class="st-ic st-earn"><i class="fas fa-rupee-sign"></i></div>
        <div class="st-val">₹{{ number_format($totalEarnings) }}</div>
        <div class="st-lbl">{{ $strings['stat_earn'] }}</div>
    </div>
</div>

<!-- Tabs -->
<div class="profile-tabs-card">
    <div class="profile-tabs-head">
        <button type="button" class="profile-tab-b active" onclick="openTab('personal', this)"><i class="fas fa-user"></i> {{ $strings['tab_personal'] }}</button>
        <button type="button" class="profile-tab-b" onclick="openTab('vehicle', this)"><i class="fas fa-motorcycle"></i> {{ $strings['tab_vehicle'] }}</button>
        <button type="button" class="profile-tab-b" onclick="openTab('password', this)"><i class="fas fa-key"></i> {{ $strings['tab_password'] }}</button>
    </div>

    <!-- Personal Info -->
    <div class="tab-content-p active" id="tab-personal">
        @if(session('profile_success'))
        <div class="alert-inline-dp success"><i class="fas fa-check-circle me-1"></i>{{ session('profile_success') }}</div>
        @endif

        <!-- Add enctype for file uploads -->
        <form id="personalFormD" action="{{ url('/delivery/profile/update') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <!-- Image Upload Area -->
            <div class="avatar-upload-area" onclick="$('#avatarUploadInput').click()">
                <div id="avatarPreviewContainer">
                    @if(!empty($partner->avatar) && file_exists(public_path('images/'.$partner->avatar)))
                    <img src="{{ asset('images/'.$partner->avatar) }}" class="avatar-preview-img" alt="Avatar">
                    <p>Change Profile Image</p>
                    @else
                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                    <p>Click to Upload Profile Image</p>
                    <small>JPG, PNG (Max 2MB)</small>
                    @endif
                </div>
            </div>

            <!-- Moved file input INSIDE the form and added name="avatar" -->
            <input type="file" name="avatar" id="avatarUploadInput" accept="image/*" style="display:none;">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">{{ $strings['lbl_name'] }} <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-user form-icon-dp"></i>
                            <input type="text" name="name" id="dp_name" class="form-control-dp" value="{{ $tName }}">
                        </div>
                        <span class="err-msg-dp" id="err_dp_name"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">{{ $strings['lbl_email'] }} <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-envelope form-icon-dp"></i>
                            <input type="email" name="email" id="dp_email" class="form-control-dp" value="{{ $partner->email }}">
                        </div>
                        <span class="err-msg-dp" id="err_dp_email"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">{{ $strings['lbl_phone'] }} <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-phone form-icon-dp"></i>
                            <input type="text" name="phone" id="dp_phone" class="form-control-dp" value="{{ $partner->phone }}" maxlength="10">
                        </div>
                        <span class="err-msg-dp" id="err_dp_phone"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">{{ $strings['lbl_aadhar'] }}</label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-id-badge form-icon-dp"></i>
                            <input type="text" class="form-control-dp" value="{{ $partner->aadhar_number }}" disabled>
                        </div>
                        <small style="color:var(--gray-text);font-size:0.72rem;">{{ $strings['note_aadhar'] }}</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group-dp">
                        <label class="form-label-dp">{{ $strings['lbl_address'] }} <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-home form-icon-dp"></i>
                            <input type="text" name="address" id="dp_address" class="form-control-dp" value="{{ $tAddress }}">
                        </div>
                        <span class="err-msg-dp" id="err_dp_address"></span>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn-save-dp" id="savePersonalDp">
                    <i class="fas fa-save"></i> {{ $strings['btn_save'] }}
                </button>
            </div>
        </form>
    </div>

    <!-- Vehicle -->
    <div class="tab-content-p" id="tab-vehicle">
        <div class="vehicle-card">
            <h6><i class="fas fa-motorcycle me-1" style="color:var(--primary-green);"></i> {{ $strings['vehicle_info'] }}</h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group-dp">
                        <label class="form-label-dp">{{ $strings['lbl_veh_type'] }}</label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-truck form-icon-dp"></i>
                            <input type="text" class="form-control-dp" value="{{ $tVehicleType }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-dp">
                        <label class="form-label-dp">{{ $strings['lbl_veh_num'] }}</label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-hashtag form-icon-dp"></i>
                            <input type="text" class="form-control-dp" value="{{ $partner->vehicle_number }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-dp">
                        <label class="form-label-dp">{{ $strings['lbl_dl'] }}</label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-id-card form-icon-dp"></i>
                            <input type="text" class="form-control-dp" value="{{ $partner->license_dl }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div style="background:#FFF3E0;padding:12px 15px;border-radius:10px;color:#E65100;font-size:0.85rem;">
                <i class="fas fa-info-circle me-1"></i>
                {{ $strings['note_vehicle'] }} <a href="mailto:dhruvi@sanjivani.com" style="color:#E65100;font-weight:600;">dhruvi@sanjivani.com</a>
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
                <label class="form-label-dp">{{ $strings['lbl_cur_pwd'] }} <span class="req">*</span></label>
                <div class="input-wrap-dp">
                    <i class="fas fa-lock form-icon-dp"></i>
                    <input type="password" name="current_password" id="cur_pwd_d" class="form-control-dp" placeholder="{{ $strings['ph_cur_pwd'] }}" style="padding-right:45px;">
                    <i class="fas fa-eye form-icon-right-dp toggle-pwd-d" data-target="cur_pwd_d"></i>
                </div>
                <span class="err-msg-dp" id="err_cur_pwd_d"></span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">{{ $strings['lbl_new_pwd'] }} <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-key form-icon-dp"></i>
                            <input type="password" name="new_password" id="new_pwd_d" class="form-control-dp" placeholder="{{ $strings['ph_new_pwd'] }}" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-dp toggle-pwd-d" data-target="new_pwd_d"></i>
                        </div>
                        <span class="err-msg-dp" id="err_new_pwd_d"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-dp">
                        <label class="form-label-dp">{{ $strings['lbl_conf_pwd'] }} <span class="req">*</span></label>
                        <div class="input-wrap-dp">
                            <i class="fas fa-check-double form-icon-dp"></i>
                            <input type="password" name="new_password_confirmation" id="conf_pwd_d" class="form-control-dp" placeholder="{{ $strings['ph_conf_pwd'] }}" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-dp toggle-pwd-d" data-target="conf_pwd_d"></i>
                        </div>
                        <span class="err-msg-dp" id="err_conf_pwd_d"></span>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn-save-dp" id="savePwdDp">
                    <i class="fas fa-key"></i> {{ $strings['btn_update_pwd'] }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Global function to handle tabs directly
    function openTab(tabId, btnElement) {
        document.querySelectorAll('.profile-tab-b').forEach(function(btn) {
            btn.classList.remove('active');
        });
        document.querySelectorAll('.tab-content-p').forEach(function(content) {
            content.classList.remove('active');
        });

        btnElement.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }

    $(document).ready(function() {

        var jsStrings = {
            nameReq: "{{ $strings['js_name_req'] ?? 'Name required' }}",
            nameMin: "{{ $strings['js_name_min'] ?? 'Min 2 characters' }}",
            emailReq: "{{ $strings['js_email_req'] ?? 'Valid email required' }}",
            phoneReq: "{{ $strings['js_phone_req'] ?? '10 digits, starts 6-9' }}",
            addrReq: "{{ $strings['js_addr_req'] ?? 'Address required' }}",
            curPwdReq: "{{ $strings['js_cur_pwd_req'] ?? 'Current password required' }}",
            newPwdReq: "{{ $strings['js_new_pwd_req'] ?? 'New password required' }}",
            newPwdMin: "{{ $strings['js_new_pwd_min'] ?? 'Min 6 characters' }}",
            newPwdSame: "{{ $strings['js_new_pwd_same'] ?? 'Must differ from current' }}",
            confPwdMatch: "{{ $strings['js_conf_pwd_match'] ?? 'Passwords do not match' }}",
            saving: "{{ $strings['js_saving'] ?? 'Saving...' }}",
            updating: "{{ $strings['js_updating'] ?? 'Updating...' }}",
            imgSize: "{{ $strings['js_img_size'] ?? 'Image must be less than 2MB' }}",
            imgType: "{{ $strings['js_img_type'] ?? 'Please upload a valid image file' }}"
        };

        /* ============ IMAGE PREVIEW ONLY ============ */
        $('#avatarUploadInput').on('change', function() {
            var file = this.files[0];
            if (!file) return;

            // Validation
            if (file.size > 2 * 1024 * 1024) {
                alert(jsStrings.imgSize);
                $(this).val('');
                return;
            }
            if (!file.type.match('image.*')) {
                alert(jsStrings.imgType);
                $(this).val('');
                return;
            }

            // Preview
            var reader = new FileReader();
            reader.onload = function(e) {
                // Update form preview
                $('#avatarPreviewContainer').html(
                    '<img src="' + e.target.result + '" class="avatar-preview-img" alt="Preview">' +
                    '<p>Change Profile Image</p>'
                );
                // Update hero preview instantly
                $('#heroAvatar').html('<img src="' + e.target.result + '">');
            };
            reader.readAsDataURL(file);
        });

        /* Password Toggle */
        $('.toggle-pwd-d').on('click', function() {
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

        $('#dp_phone').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $('.form-control-dp').on('input', function() {
            if ($(this).hasClass('error') && $.trim($(this).val()) !== '') clearErr($(this));
        });

        /* Personal Form Submit */
        $('#personalFormD').on('submit', function(e) {
            e.preventDefault();
            var isValid = true;

            var name = $.trim($('#dp_name').val());
            if (name === '') {
                showErr($('#dp_name'), jsStrings.nameReq);
                isValid = false;
            } else if (name.length < 2) {
                showErr($('#dp_name'), jsStrings.nameMin);
                isValid = false;
            }

            var email = $.trim($('#dp_email').val());
            if (email === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showErr($('#dp_email'), jsStrings.emailReq);
                isValid = false;
            }

            var phone = $.trim($('#dp_phone').val());
            if (!/^[6-9]\d{9}$/.test(phone)) {
                showErr($('#dp_phone'), jsStrings.phoneReq);
                isValid = false;
            }

            if ($.trim($('#dp_address').val()) === '') {
                showErr($('#dp_address'), jsStrings.addrReq);
                isValid = false;
            }

            if (!isValid) return false;

            var $btn = $('#savePersonalDp');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.saving);
            this.submit(); // This will now submit the file along with the data
        });

        /* Password Form Submit */
        $('#passwordFormD').on('submit', function(e) {
            e.preventDefault();
            var isValid = true;

            var cur = $('#cur_pwd_d').val();
            if (cur === '') {
                showErr($('#cur_pwd_d'), jsStrings.curPwdReq);
                isValid = false;
            }

            var np = $('#new_pwd_d').val();
            if (np === '') {
                showErr($('#new_pwd_d'), jsStrings.newPwdReq);
                isValid = false;
            } else if (np.length < 6) {
                showErr($('#new_pwd_d'), jsStrings.newPwdMin);
                isValid = false;
            } else if (np === cur) {
                showErr($('#new_pwd_d'), jsStrings.newPwdSame);
                isValid = false;
            }

            var cp = $('#conf_pwd_d').val();
            if (cp !== np) {
                showErr($('#conf_pwd_d'), jsStrings.confPwdMatch);
                isValid = false;
            }

            if (!isValid) return false;

            var $btn = $('#savePwdDp');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.updating);
            this.submit();
        });

    });
</script>
@endpush