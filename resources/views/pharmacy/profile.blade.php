@extends('layouts.pharmacy')

@section('title', 'Pharmacy Profile')
@section('page_title')
<i class="fas fa-user-circle"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('My Profile') }}
@endsection

@section('styles')
<style>
    /* Accordion Card */
    .accordion-card-ph {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 25px;
        border: 1px solid #E0E0E0;
    }

    .accordion-header-ph {
        background: var(--off-white);
        padding: 18px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--dark-text);
        transition: var(--transition);
        user-select: none;
    }

    .accordion-header-ph:hover {
        background: var(--pale-green);
    }

    .accordion-header-ph i.lead-icon {
        color: var(--primary-green);
        margin-right: 10px;
        font-size: 1.1rem;
    }

    .accordion-header-ph .arrow-icon {
        color: var(--gray-text);
        transition: transform 0.3s ease;
    }

    .accordion-header-ph.active {
        border-bottom: 1px solid #E0E0E0;
        color: var(--primary-green);
    }

    .accordion-header-ph.active .arrow-icon {
        transform: rotate(180deg);
        color: var(--primary-green);
    }

    .accordion-body-ph {
        display: none;
        padding: 25px;
    }

    /* Profile Card (Read-only) */
    .profile-card {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 25px;
        border-top: 5px solid var(--primary-green);
        height: 100%;
    }

    .profile-card-header {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        padding: 30px 25px;
        color: var(--white);
        text-align: center;
        position: relative;
    }

    .profile-card-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: var(--white);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0 auto 15px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .profile-card-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-card-header h4 {
        font-weight: 800;
        margin: 0 0 5px;
    }

    .profile-card-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.85rem;
    }

    .profile-card-body {
        padding: 25px;
    }

    .profile-info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px dashed #E0E0E0;
    }

    .profile-info-item:last-child {
        border-bottom: none;
    }

    .profile-info-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .profile-info-text {
        flex: 1;
    }

    .profile-info-text .label {
        font-size: 0.72rem;
        color: var(--gray-text);
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 2px;
        display: block;
    }

    .profile-info-text .value {
        font-size: 0.92rem;
        color: var(--dark-text);
        font-weight: 600;
    }

    /* Edit Form Card */
    .edit-form-card {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        padding: 25px;
        margin-bottom: 25px;
        height: 100%;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--pale-green);
    }

    .section-title i {
        color: var(--primary-green);
        margin-right: 8px;
    }

    /* Image Upload Area */
    .logo-upload-area {
        border: 2px dashed var(--primary-green);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background: var(--off-white);
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .logo-upload-area:hover {
        background: var(--pale-green);
        border-color: var(--light-green);
    }

    .logo-upload-area i.upload-icon {
        font-size: 2.5rem;
        color: var(--primary-green);
        margin-bottom: 10px;
    }

    .logo-upload-area p {
        margin: 0;
        color: var(--primary-green);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .logo-upload-area small {
        color: var(--gray-text);
        font-size: 0.75rem;
        display: block;
        margin-top: 5px;
    }

    .logo-preview-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 10px;
        border: 3px solid var(--primary-green);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Form Fields */
    .form-group-p-ph {
        margin-bottom: 18px;
        position: relative;
    }

    .form-label-p-ph {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 6px;
        display: block;
    }

    .form-label-p-ph .req {
        color: #E53935;
    }

    .input-wrap-p-ph {
        position: relative;
    }

    .form-control-p-ph,
    .form-select-p-ph {
        width: 100%;
        padding: 10px 14px 10px 40px;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: var(--transition);
        background: var(--white);
    }

    .form-select-p-ph {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 12px;
    }

    .form-control-p-ph:focus,
    .form-select-p-ph:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .form-control-p-ph.error,
    .form-select-p-ph.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .form-control-p-ph:disabled {
        background: #F5F5F5;
        color: var(--gray-text);
        cursor: not-allowed;
    }

    textarea.form-control-p-ph {
        min-height: 80px;
        padding-top: 12px;
        resize: vertical;
    }

    .form-icon-p-ph {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-green);
        font-size: 0.9rem;
        pointer-events: none;
    }

    .form-icon-p-ph.textarea {
        top: 18px;
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
        font-size: 0.75rem;
        margin-top: 4px;
        display: none;
        font-weight: 500;
    }

    .err-msg-p-ph.show {
        display: block;
    }

    /* Buttons */
    .btn-save-p-ph {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 11px 30px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.25);
    }

    .btn-save-p-ph:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.35);
    }

    .btn-save-p-ph:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Verification Panel */
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

    .verification-panel.approved h5 {
        color: var(--dark-green);
    }

    .verification-panel.pending h5 {
        color: #E65100;
    }

    .verification-panel.rejected h5 {
        color: #C62828;
    }

    .verification-panel p {
        font-size: 0.88rem;
        color: var(--gray-text);
        margin: 0;
        line-height: 1.6;
    }

    /* Alerts */
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
        .profile-tab-btn-ph {
            padding: 12px 15px;
            font-size: 0.82rem;
        }

        .profile-tab-btn-ph i {
            display: none;
        }

        .profile-tab-content-ph {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

$pharmacy = $pharmacy ?? (object)[
'pharmacy_name' => session('pharmacy_name') ?? 'HealthCare Medicos',
'owner_name' => 'Dr. Vinod Sharma',
'email' => 'healthcare.medicos@example.com',
'phone' => '9822334455',
'license_number' => 'DL-MH-2023-9988A',
'address' => 'Plot No. 12, Main Market, Shivaji Chowk, Rajkot - 360001',
'village_id' => 1,
'status' => 'active',
'created_at' => now()->subMonths(10),
'logo' => null,
];

$villages = $villages ?? collect();

$currentVillage = collect($villages)->firstWhere('id', $pharmacy->village_id);
$villageName = $currentVillage ? $currentVillage->name : 'N/A';

$tPharmName = GoogleTranslator::translate($pharmacy->pharmacy_name);
$tOwnerName = GoogleTranslator::translate($pharmacy->owner_name);
$tAddress = GoogleTranslator::translate($pharmacy->address);
$tVillage = GoogleTranslator::translate($villageName);

$strings = GoogleTranslator::translateBatch([
'verified_partner' => 'Verified Pharmacy Partner',
'partner_since' => 'Partner Since',
'lbl_owner' => 'Owner Name',
'lbl_email' => 'Email Address',
'lbl_phone' => 'Mobile Phone',
'lbl_village' => 'Village / Market Location',
'lbl_address' => 'Complete Physical Address',
'lbl_license' => 'Drug License Number',
'edit_title' => 'Edit Profile Details',
'lbl_pharm_name' => 'Pharmacy / Store Name',
'select_village' => '-- Select Village --',
'ph_address' => 'Detailed store address...',
'btn_save_profile' => 'Update Profile',
'tab_license' => 'License & Status',
'tab_security' => 'Account Security',
'section_license' => 'License Verification & Status',
'status_approved' => 'Account Approved',
'desc_approved' => 'Your pharmacy credentials and drug license are verified. Your store and listed products are active, visible, and can accept customer orders across the platform.',
'status_pending' => 'Verification Pending',
'desc_pending' => 'Your drug license and registration documents are currently under evaluation by the administrative team. Your listed products will become visible to customers once the review completes.',
'status_rejected' => 'Verification Declined',
'desc_rejected' => 'Your registration profile was declined due to mismatched license data or missing documents. Please contact system administrators at support@sanjivani.com to initiate remediation.',
'note_license' => 'Contact administrative support to modify license parameters.',
'section_security' => 'Update Account Password',
'lbl_cur_pwd' => 'Current Password',
'ph_cur_pwd' => 'Enter current password',
'lbl_new_pwd' => 'New Password',
'ph_new_pwd' => 'Min 6 characters',
'lbl_conf_pwd' => 'Confirm New Password',
'ph_conf_pwd' => 'Confirm password',
'btn_change_pwd' => 'Change Account Password',
'js_name_req' => '⚠ Pharmacy name is required',
'js_name_min' => '⚠ Pharmacy name must contain at least 3 characters',
'js_owner_req' => '⚠ Owner name is required',
'js_email_req' => '⚠ Email address is required',
'js_email_invalid' => '⚠ Enter a valid email format',
'js_phone_req' => '⚠ Mobile phone number is required',
'js_phone_invalid' => '⚠ Enter a valid 10-digit mobile starting with 6-9',
'js_village_req' => '⚠ Selecting a local market village is required',
'js_addr_req' => '⚠ Store physical address is required',
'js_addr_min' => '⚠ Physical address details must contain at least 10 characters',
'js_cur_pwd_req' => '⚠ Current password cannot be empty',
'js_new_pwd_req' => '⚠ New password is required',
'js_new_pwd_min' => '⚠ Password must be at least 6 characters',
'js_new_pwd_same' => '⚠ New password must be different from current password',
'js_conf_pwd_req' => '⚠ Confirming your new password is required',
'js_conf_pwd_match' => '⚠ Confirmed password does not match new password input',
'js_saving' => 'Saving...'
]);
@endphp

@if(session('profile_success'))
<div class="alert-inline-p-ph success"><i class="fas fa-check-circle"></i>{{ session('profile_success') }}</div>
@endif

<!-- ============ TOP SECTION: ACCORDIONS (LICENSE & SECURITY) ============ -->

<!-- 1. License & Status Accordion -->
<div class="accordion-card-ph" data-aos="fade-down">
    <div class="accordion-header-ph" id="accordionLicenseBtn">
        <div><i class="fas fa-certificate lead-icon"></i> {{ $strings['tab_license'] }}</div>
        <i class="fas fa-chevron-down arrow-icon"></i>
    </div>
    <div class="accordion-body-ph" id="accordionLicenseBody">
        <h5 class="section-title"><i class="fas fa-certificate"></i> {{ $strings['section_license'] }}</h5>

        @if($pharmacy->status == 'active')
        <div class="verification-panel approved">
            <h5><i class="fas fa-check-circle me-1"></i> {{ $strings['status_approved'] }}</h5>
            <p>{{ $strings['desc_approved'] }}</p>
        </div>
        @elseif($pharmacy->status == 'pending')
        <div class="verification-panel pending">
            <h5><i class="fas fa-hourglass-half me-1"></i> {{ $strings['status_pending'] }}</h5>
            <p>{{ $strings['desc_pending'] }}</p>
        </div>
        @else
        <div class="verification-panel rejected">
            <h5><i class="fas fa-times-circle me-1"></i> {{ $strings['status_rejected'] }}</h5>
            <p>{{ $strings['desc_rejected'] }}</p>
        </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="form-group-p-ph">
                    <label class="form-label-p-ph">{{ $strings['lbl_license'] }}</label>
                    <div class="input-wrap-p-ph">
                        <i class="fas fa-file-signature form-icon-p-ph"></i>
                        <input type="text" class="form-control-p-ph" value="{{ $pharmacy->license_number }}" disabled>
                    </div>
                    <small style="color:var(--gray-text); display:block; margin-top:5px;">{{ $strings['note_license'] }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. Account Security Accordion -->
<div class="accordion-card-ph" data-aos="fade-down">
    <div class="accordion-header-ph" id="accordionSecurityBtn">
        <div><i class="fas fa-key lead-icon"></i> {{ $strings['tab_security'] }}</div>
        <i class="fas fa-chevron-down arrow-icon"></i>
    </div>
    <div class="accordion-body-ph" id="accordionSecurityBody">
        @if(session('password_success'))
        <div class="alert-inline-p-ph success"><i class="fas fa-check-circle"></i>{{ session('password_success') }}</div>
        @endif
        @if(session('password_error'))
        <div class="alert-inline-p-ph error"><i class="fas fa-exclamation-circle"></i>{{ session('password_error') }}</div>
        @endif

        <h5 class="section-title"><i class="fas fa-key"></i> {{ $strings['section_security'] }}</h5>

        <form id="pharmacyPwdForm" action="{{ url('/pharmacy/profile/change-password') }}" method="POST" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">{{ $strings['lbl_cur_pwd'] }} <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-lock form-icon-p-ph"></i>
                            <input type="password" name="current_password" id="curPwd" class="form-control-p-ph" placeholder="{{ $strings['ph_cur_pwd'] }}" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-p-ph toggle-password-visibility" data-target="curPwd"></i>
                        </div>
                        <span class="err-msg-p-ph" id="err_curPwd"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">{{ $strings['lbl_new_pwd'] }} <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-key form-icon-p-ph"></i>
                            <input type="password" name="new_password" id="newPwd" class="form-control-p-ph" placeholder="{{ $strings['ph_new_pwd'] }}" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-p-ph toggle-password-visibility" data-target="newPwd"></i>
                        </div>
                        <span class="err-msg-p-ph" id="err_newPwd"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-p-ph">
                        <label class="form-label-p-ph">{{ $strings['lbl_conf_pwd'] }} <span class="req">*</span></label>
                        <div class="input-wrap-p-ph">
                            <i class="fas fa-check-double form-icon-p-ph"></i>
                            <input type="password" name="new_password_confirmation" id="confPwd" class="form-control-p-ph" placeholder="{{ $strings['ph_conf_pwd'] }}" style="padding-right:45px;">
                            <i class="fas fa-eye form-icon-right-p-ph toggle-password-visibility" data-target="confPwd"></i>
                        </div>
                        <span class="err-msg-p-ph" id="err_confPwd"></span>
                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="submit" class="btn-save-p-ph" id="savePwdBtnPh">
                    <i class="fas fa-save"></i> {{ $strings['btn_change_pwd'] }}
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ============ BOTTOM ROW: PROFILE CARD & EDIT FORM ============ -->
<div class="row g-4 mt-2">
    <!-- LEFT: PROFILE CARD -->
    <div class="col-lg-5">
        <div class="profile-card" data-aos="fade-right">
            <div class="profile-card-header">
                <div class="profile-card-avatar">
                    @if(!empty($pharmacy->logo) && file_exists(public_path('images/'.$pharmacy->logo)))
                    <img src="{{ asset('images/'.$pharmacy->logo) }}" alt="{{ $tPharmName }}">
                    @else
                    {{ strtoupper(substr($tPharmName, 0, 1)) }}
                    @endif
                </div>
                <h4>{{ $tPharmName }}</h4>
                <p><i class="fas fa-check-circle text-warning me-1"></i> {{ $strings['verified_partner'] }}</p>
                <p class="mt-1" style="font-size:0.75rem;"><i class="fas fa-calendar-alt me-1"></i> {{ $strings['partner_since'] }} {{ date('M Y', strtotime($pharmacy->created_at)) }}</p>
            </div>
            <div class="profile-card-body">
                <div class="profile-info-item">
                    <div class="profile-info-icon"><i class="fas fa-user-md"></i></div>
                    <div class="profile-info-text">
                        <span class="label">{{ $strings['lbl_owner'] }}</span>
                        <span class="value">{{ $tOwnerName }}</span>
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="profile-info-text">
                        <span class="label">{{ $strings['lbl_email'] }}</span>
                        <span class="value">{{ $pharmacy->email }}</span>
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-icon"><i class="fas fa-phone"></i></div>
                    <div class="profile-info-text">
                        <span class="label">{{ $strings['lbl_phone'] }}</span>
                        <span class="value">{{ $pharmacy->phone }}</span>
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="profile-info-text">
                        <span class="label">{{ $strings['lbl_village'] }}</span>
                        <span class="value">{{ $tVillage }}</span>
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-icon"><i class="fas fa-file-contract"></i></div>
                    <div class="profile-info-text">
                        <span class="label">{{ $strings['lbl_license'] }}</span>
                        <span class="value">{{ $pharmacy->license_number }}</span>
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-icon"><i class="fas fa-home"></i></div>
                    <div class="profile-info-text">
                        <span class="label">{{ $strings['lbl_address'] }}</span>
                        <span class="value" style="font-weight:500; font-size:0.85rem;">{{ $tAddress }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: EDIT FORM -->
    <div class="col-lg-7">
        <div class="edit-form-card" data-aos="fade-left">
            <h5 class="section-title"><i class="fas fa-edit"></i> {{ $strings['edit_title'] }}</h5>

            <form id="pharmacyProfileForm" action="{{ url('/pharmacy/profile/update') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <!-- Image Upload Area -->
                <div class="logo-upload-area" onclick="$('#logoUploadInput').click()">
                    <div id="logoPreviewContainer">
                        @if(!empty($pharmacy->logo) && file_exists(public_path('images/'.$pharmacy->logo)))
                        <img src="{{ asset('images/'.$pharmacy->logo) }}" class="logo-preview-img" alt="Logo">
                        <p>Change Profile Image</p>
                        @else
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <p>Click to Upload Profile Image</p>
                        <small>JPG, PNG (Max 2MB)</small>
                        @endif
                    </div>
                </div>
                <input type="file" name="logo" id="logoUploadInput" accept="image/*" style="display:none;">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-p-ph">
                            <label class="form-label-p-ph">{{ $strings['lbl_pharm_name'] }} <span class="req">*</span></label>
                            <div class="input-wrap-p-ph">
                                <i class="fas fa-hospital form-icon-p-ph"></i>
                                <input type="text" name="pharmacy_name" id="ph_name" class="form-control-p-ph" value="{{ $tPharmName }}">
                            </div>
                            <span class="err-msg-p-ph" id="err_ph_name"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-p-ph">
                            <label class="form-label-p-ph">{{ $strings['lbl_owner'] }} <span class="req">*</span></label>
                            <div class="input-wrap-p-ph">
                                <i class="fas fa-user-md form-icon-p-ph"></i>
                                <input type="text" name="owner_name" id="ph_owner" class="form-control-p-ph" value="{{ $tOwnerName }}">
                            </div>
                            <span class="err-msg-p-ph" id="err_ph_owner"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-p-ph">
                            <label class="form-label-p-ph">{{ $strings['lbl_email'] }} <span class="req">*</span></label>
                            <div class="input-wrap-p-ph">
                                <i class="fas fa-envelope form-icon-p-ph"></i>
                                <input type="email" name="email" id="ph_email" class="form-control-p-ph" value="{{ $pharmacy->email }}">
                            </div>
                            <span class="err-msg-p-ph" id="err_ph_email"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-p-ph">
                            <label class="form-label-p-ph">{{ $strings['lbl_phone'] }} <span class="req">*</span></label>
                            <div class="input-wrap-p-ph">
                                <i class="fas fa-phone form-icon-p-ph"></i>
                                <input type="text" name="phone" id="ph_phone" class="form-control-p-ph" value="{{ $pharmacy->phone }}" maxlength="10">
                            </div>
                            <span class="err-msg-p-ph" id="err_ph_phone"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group-p-ph">
                            <label class="form-label-p-ph">{{ $strings['lbl_village'] }} <span class="req">*</span></label>
                            <div class="input-wrap-p-ph">
                                <i class="fas fa-map-marker-alt form-icon-p-ph"></i>
                                <select name="village_id" id="ph_village" class="form-select-p-ph">
                                    <option value="">{{ $strings['select_village'] }}</option>
                                    @foreach($villages as $v)
                                    <option value="{{ $v->id }}" {{ $pharmacy->village_id == $v->id ? 'selected' : '' }}>
                                        {{ GoogleTranslator::translate($v->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="err-msg-p-ph" id="err_ph_village"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group-p-ph">
                            <label class="form-label-p-ph">{{ $strings['lbl_address'] }} <span class="req">*</span></label>
                            <div class="input-wrap-p-ph">
                                <i class="fas fa-home form-icon-p-ph textarea"></i>
                                <textarea name="address" id="ph_address" class="form-control-p-ph" placeholder="{{ $strings['ph_address'] }}">{{ $tAddress }}</textarea>
                            </div>
                            <span class="err-msg-p-ph" id="err_ph_address"></span>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn-save-p-ph" id="saveProfileBtn">
                        <i class="fas fa-save"></i> {{ $strings['btn_save_profile'] }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        var jsStrings = {
            nameReq: "{{ $strings['js_name_req'] ?? 'Pharmacy name is required' }}",
            nameMin: "{{ $strings['js_name_min'] ?? 'Pharmacy name must contain at least 3 characters' }}",
            ownerReq: "{{ $strings['js_owner_req'] ?? 'Owner name is required' }}",
            emailReq: "{{ $strings['js_email_req'] ?? 'Email address is required' }}",
            emailInvalid: "{{ $strings['js_email_invalid'] ?? 'Enter a valid email format' }}",
            phoneReq: "{{ $strings['js_phone_req'] ?? 'Mobile phone number is required' }}",
            phoneInvalid: "{{ $strings['js_phone_invalid'] ?? 'Enter a valid 10-digit mobile starting with 6-9' }}",
            villageReq: "{{ $strings['js_village_req'] ?? 'Selecting a local market village is required' }}",
            addrReq: "{{ $strings['js_addr_req'] ?? 'Store physical address is required' }}",
            addrMin: "{{ $strings['js_addr_min'] ?? 'Physical address details must contain at least 10 characters' }}",
            curPwdReq: "{{ $strings['js_cur_pwd_req'] ?? 'Current password cannot be empty' }}",
            newPwdReq: "{{ $strings['js_new_pwd_req'] ?? 'New password is required' }}",
            newPwdMin: "{{ $strings['js_new_pwd_min'] ?? 'Password must be at least 6 characters' }}",
            newPwdSame: "{{ $strings['js_new_pwd_same'] ?? 'New password must be different from current password' }}",
            confPwdReq: "{{ $strings['js_conf_pwd_req'] ?? 'Confirming your new password is required' }}",
            confPwdMatch: "{{ $strings['js_conf_pwd_match'] ?? 'Confirmed password does not match new password input' }}",
            saving: "{{ $strings['js_saving'] ?? 'Saving...' }}"
        };

        /* ============ IMAGE PREVIEW ============ */
        $('#logoUploadInput').on('change', function() {
            var file = this.files[0];
            if (file) {
                // Validate size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Image size must be less than 2MB');
                    $(this).val('');
                    return;
                }

                var reader = new FileReader();
                reader.onload = function(e) {
                    // Replace content with image preview
                    $('#logoPreviewContainer').html(
                        '<img src="' + e.target.result + '" class="logo-preview-img" alt="Preview">' +
                        '<p>Change Profile Image</p>'
                    );
                };
                reader.readAsDataURL(file);
            }
        });

        /* ============ ACCORDION TOGGLE ============ */
        $('#accordionLicenseBtn').on('click', function() {
            $(this).toggleClass('active');
            $('#accordionLicenseBody').slideToggle(300);
        });

        $('#accordionSecurityBtn').on('click', function() {
            $(this).toggleClass('active');
            $('#accordionSecurityBody').slideToggle(300);
        });

        /* ============ PASSWORD VISIBILITY TOGGLER ============ */
        $('.toggle-password-visibility').on('click', function() {
            var target = $(this).data('target');
            var $input = $('#' + target);
            var type = $input.attr('type') === 'password' ? 'text' : 'password';
            $input.attr('type', type);
            $(this).toggleClass('fa-eye fa-eye-slash');
        });

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
        $('.form-control-p-ph, .form-select-p-ph').on('input change', function() {
            if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
                removeError($(this));
            }
        });

        $('#ph_phone').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        /* ============ PROFILE INFORMATION FORM ============ */
        $('#pharmacyProfileForm').on('submit', function(e) {
            e.preventDefault();

            var isValid = true;
            $('.err-msg-p-ph').removeClass('show').text('');
            $('.form-control-p-ph, .form-select-p-ph').removeClass('error');

            var name = $.trim($('#ph_name').val());
            if (name === '') {
                raiseError($('#ph_name'), jsStrings.nameReq);
                isValid = false;
            } else if (name.length < 3) {
                raiseError($('#ph_name'), jsStrings.nameMin);
                isValid = false;
            } else {
                flagSuccess($('#ph_name'));
            }

            var owner = $.trim($('#ph_owner').val());
            if (owner === '') {
                raiseError($('#ph_owner'), jsStrings.ownerReq);
                isValid = false;
            } else {
                flagSuccess($('#ph_owner'));
            }

            var email = $.trim($('#ph_email').val());
            var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '') {
                raiseError($('#ph_email'), jsStrings.emailReq);
                isValid = false;
            } else if (!emailRe.test(email)) {
                raiseError($('#ph_email'), jsStrings.emailInvalid);
                isValid = false;
            } else {
                flagSuccess($('#ph_email'));
            }

            var phone = $.trim($('#ph_phone').val());
            if (phone === '') {
                raiseError($('#ph_phone'), jsStrings.phoneReq);
                isValid = false;
            } else if (!/^[6-9]\d{9}$/.test(phone)) {
                raiseError($('#ph_phone'), jsStrings.phoneInvalid);
                isValid = false;
            } else {
                flagSuccess($('#ph_phone'));
            }

            if ($('#ph_village').val() === '') {
                raiseError($('#ph_village'), jsStrings.villageReq);
                isValid = false;
            } else {
                flagSuccess($('#ph_village'));
            }

            var addr = $.trim($('#ph_address').val());
            if (addr === '') {
                raiseError($('#ph_address'), jsStrings.addrReq);
                isValid = false;
            } else if (addr.length < 10) {
                raiseError($('#ph_address'), jsStrings.addrMin);
                isValid = false;
            } else {
                flagSuccess($('#ph_address'));
            }

            if (!isValid) return false;

            var $btn = $('#saveProfileBtn');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.saving);
            this.submit();
        });

        /* ============ SECURITY PASSWORD CHANGE FORM ============ */
        $('#pharmacyPwdForm').on('submit', function(e) {
            e.preventDefault();

            var isValid = true;
            $('.err-msg-p-ph').removeClass('show').text('');
            $('.form-control-p-ph').removeClass('error');

            var cur = $('#curPwd').val();
            if (cur === '') {
                raiseError($('#curPwd'), jsStrings.curPwdReq);
                isValid = false;
            } else {
                flagSuccess($('#curPwd'));
            }

            var np = $('#newPwd').val();
            if (np === '') {
                raiseError($('#newPwd'), jsStrings.newPwdReq);
                isValid = false;
            } else if (np.length < 6) {
                raiseError($('#newPwd'), jsStrings.newPwdMin);
                isValid = false;
            } else if (np === cur) {
                raiseError($('#newPwd'), jsStrings.newPwdSame);
                isValid = false;
            } else {
                flagSuccess($('#newPwd'));
            }

            var cp = $('#confPwd').val();
            if (cp === '') {
                raiseError($('#confPwd'), jsStrings.confPwdReq);
                isValid = false;
            } else if (cp !== np) {
                raiseError($('#confPwd'), jsStrings.confPwdMatch);
                isValid = false;
            } else {
                flagSuccess($('#confPwd'));
            }

            if (!isValid) return false;

            var $btn = $('#savePwdBtnPh');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.saving);
            this.submit();
        });

    });
</script>
@endsection