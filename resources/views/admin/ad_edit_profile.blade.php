@extends('layouts.admin')

@section('title', 'Edit Profile - Sanjivani Admin')
@section('page_title')
<i class="fas fa-edit"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('Edit Profile') }}
@endsection

@section('styles')
<style>
    .edit-profile-card {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .edit-tabs {
        display: flex;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
    }

    .edit-tab {
        flex: 1;
        padding: 15px 20px;
        text-align: center;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--gray-text);
        transition: var(--transition);
        border: none;
        background: transparent;
        border-bottom: 3px solid transparent;
    }

    .edit-tab i {
        margin-right: 6px;
    }

    .edit-tab:hover {
        color: var(--primary-green);
        background: var(--pale-green);
    }

    .edit-tab.active {
        color: var(--primary-green);
        background: var(--white);
        border-bottom-color: var(--primary-green);
    }

    .edit-tab-content {
        display: none;
        padding: 30px;
    }

    .edit-tab-content.active {
        display: block;
    }

    .form-group-edit {
        margin-bottom: 20px;
        position: relative;
    }

    .form-label-edit {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 8px;
        display: block;
    }

    .form-label-edit .req {
        color: #E53935;
    }

    .input-wrap-edit {
        position: relative;
    }

    .form-control-edit {
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

    .form-control-edit:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .form-control-edit.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .form-control-edit.success {
        border-color: var(--light-green);
        background: #F1F8E9;
    }

    .form-icon-edit {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-green);
        font-size: 0.95rem;
    }

    .form-icon-right {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-text);
        font-size: 0.9rem;
        cursor: pointer;
    }

    .form-icon-right:hover {
        color: var(--primary-green);
    }

    textarea.form-control-edit {
        min-height: 90px;
        padding-top: 12px;
        resize: vertical;
    }

    .err-msg {
        color: #E53935;
        font-size: 0.78rem;
        margin-top: 5px;
        display: none;
        font-weight: 500;
    }

    .err-msg.show {
        display: block;
    }

    .avatar-upload {
        text-align: center;
        margin-bottom: 25px;
    }

    .avatar-upload .avatar-wrap {
        position: relative;
        display: inline-block;
    }

    .avatar-upload .avatar-big {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        box-shadow: 0 10px 30px rgba(46, 125, 50, 0.25);
        border: 5px solid var(--white);
        margin: 0 auto;
        overflow: hidden;
    }

    .avatar-upload .avatar-big img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-upload .change-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--white);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid var(--pale-green);
        transition: var(--transition);
    }

    .avatar-upload .change-btn:hover {
        background: var(--primary-green);
        color: var(--white);
        border-color: var(--white);
    }

    .btn-save {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 12px 35px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.25);
    }

    .btn-save:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(46, 125, 50, 0.35);
    }

    .btn-save:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .password-strength {
        margin-top: 8px;
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
        font-size: 0.75rem;
        font-weight: 600;
    }

    .alert-inline {
        padding: 12px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 0.88rem;
    }

    .alert-inline.success {
        background: #E8F5E9;
        color: #1B5E20;
        border: 1px solid #A5D6A7;
    }

    .alert-inline.error {
        background: #FFEBEE;
        color: #B71C1C;
        border: 1px solid #EF9A9A;
    }

    /* ============ Custom Alert Popup ============ */
    #customAlertModal .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        padding: 35px 25px;
        max-width: 420px;
        margin: 0 auto;
    }

    #customAlertModal .alert-icon-wrap {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.4rem;
        animation: scaleIn 0.3s ease-out;
    }

    @keyframes scaleIn {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    #customAlertModal .alert-icon-wrap.warning {
        background: #FFF3E0;
        color: #FB8C00;
    }

    #customAlertModal .alert-icon-wrap.danger {
        background: #FFEBEE;
        color: #C62828;
    }

    #customAlertModal .alert-icon-wrap.success {
        background: #E8F5E9;
        color: #2E7D32;
    }

    #customAlertModal .alert-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 10px;
    }

    #customAlertModal .alert-message {
        font-size: 0.95rem;
        color: var(--gray-text);
        margin-bottom: 30px;
        line-height: 1.5;
    }

    .alert-btn-ok {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 10px 35px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.88rem;
        transition: var(--transition);
    }

    .alert-btn-ok:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(46, 125, 50, 0.3);
        color: var(--white);
    }

    @media (max-width: 767px) {
        .edit-tab {
            padding: 12px 8px;
            font-size: 0.78rem;
        }

        .edit-tab i {
            display: none;
        }

        .edit-tab-content {
            padding: 20px 18px;
        }
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

$admin = $admin ?? (object)[
'name' => session('admin_name') ?? 'Admin User',
'email' => 'admin@sanjivani.com',
'phone' => '9876543210',
'address' => '123 Health Street, Medical Plaza, Mumbai',
];

// GATHER ALL UI STRINGS AND TRANSLATE THEM SAFELY
$uiStrings = [
'Edit Profile', 'Personal Info', 'Change Password', 'Full Name', 'Email Address',
'Mobile Number', 'Address', 'Save Changes', 'Saving...', 'Current Password',
'New Password', 'Confirm New Password', 'Update Password', 'Updating...',
'Click camera icon to change photo (Max 2MB, JPG/PNG)', 'Enter your current password',
'Min. 6 characters', 'Re-type new password', 'Very Weak', 'Weak', 'Fair', 'Good', 'Strong',

// Error messages
'Name required', 'Min 2 characters', 'Only letters allowed', 'Email required', 'Invalid email',
'Phone required', 'Must be 10 digits, starts 6-9', 'Current password required',
'New password required', 'Min 6 characters', 'New password must be different from current',
'Confirm new password', 'Passwords do not match', 'Image must be less than 2MB',
'Please upload a valid image', 'OK'
];

$strings = [];
foreach($uiStrings as $str) {
$strings[$str] = GoogleTranslator::translate($str);
}
@endphp

<div class="edit-profile-card" data-aos="fade-up">
    <div class="edit-tabs">
        <button type="button" class="edit-tab active" data-tab="personal"><i class="fas fa-user"></i> {{ $strings['Personal Info'] }}</button>
        <button type="button" class="edit-tab" data-tab="password"><i class="fas fa-key"></i> {{ $strings['Change Password'] }}</button>
    </div>

    <!-- Personal Info Tab -->
    <div class="edit-tab-content active" id="tab-personal">
        @if(session('profile_success'))
        <div class="alert-inline success"><i class="fas fa-check-circle me-2"></i>{{ GoogleTranslator::translate(session('profile_success')) }}</div>
        @endif

        <form id="personalForm" action="{{ url('/admin/profile/update') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="avatar-upload">
                <div class="avatar-wrap">
                    <div class="avatar-big" id="avatarPreview">
                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                    </div>
                    <label for="avatarInput" class="change-btn" title="Change Photo">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;">
                </div>
                <div style="margin-top:10px;font-size:0.8rem;color:var(--gray-text);">
                    {{ $strings['Click camera icon to change photo (Max 2MB, JPG/PNG)'] }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-edit">
                        <label class="form-label-edit">{{ $strings['Full Name'] }} <span class="req">*</span></label>
                        <div class="input-wrap-edit">
                            <i class="fas fa-user form-icon-edit"></i>
                            <input type="text" name="name" id="pName" class="form-control-edit" value="{{ GoogleTranslator::translate($admin->name) }}">
                        </div>
                        <span class="err-msg" id="err_pName"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-edit">
                        <label class="form-label-edit">{{ $strings['Email Address'] }} <span class="req">*</span></label>
                        <div class="input-wrap-edit">
                            <i class="fas fa-envelope form-icon-edit"></i>
                            <input type="email" name="email" id="pEmail" class="form-control-edit" value="{{ GoogleTranslator::translate($admin->email) }}">
                        </div>
                        <span class="err-msg" id="err_pEmail"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-edit">
                        <label class="form-label-edit">{{ $strings['Mobile Number'] }} <span class="req">*</span></label>
                        <div class="input-wrap-edit">
                            <i class="fas fa-phone form-icon-edit"></i>
                            <input type="text" name="phone" id="pPhone" class="form-control-edit" value="{{ $admin->phone }}" maxlength="10">
                        </div>
                        <span class="err-msg" id="err_pPhone"></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group-edit">
                        <label class="form-label-edit">{{ $strings['Address'] }}</label>
                        <div class="input-wrap-edit">
                            <i class="fas fa-home form-icon-edit" style="top:20px;transform:none;"></i>
                            <textarea name="address" id="pAddress" class="form-control-edit">{{ GoogleTranslator::translate($admin->address) }}</textarea>
                        </div>
                        <span class="err-msg" id="err_pAddress"></span>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn-save" id="savePBtn">
                    <i class="fas fa-save"></i> {{ $strings['Save Changes'] }}
                </button>
            </div>
        </form>
    </div>

    <!-- Password Tab -->
    <div class="edit-tab-content" id="tab-password">
        @if(session('password_success'))
        <div class="alert-inline success"><i class="fas fa-check-circle me-2"></i>{{ GoogleTranslator::translate(session('password_success')) }}</div>
        @endif
        @if(session('password_error'))
        <div class="alert-inline error"><i class="fas fa-exclamation-circle me-2"></i>{{ GoogleTranslator::translate(session('password_error')) }}</div>
        @endif

        <form id="passwordForm" action="{{ url('/admin/profile/change-password') }}" method="POST" novalidate>
            @csrf

            <div class="form-group-edit">
                <label class="form-label-edit">{{ $strings['Current Password'] }} <span class="req">*</span></label>
                <div class="input-wrap-edit">
                    <i class="fas fa-lock form-icon-edit"></i>
                    <input type="password" name="current_password" id="currentPwd" class="form-control-edit" placeholder="{{ $strings['Enter your current password'] }}">
                    <i class="fas fa-eye form-icon-right toggle-pwd" data-target="currentPwd"></i>
                </div>
                <span class="err-msg" id="err_currentPwd"></span>
            </div>

            <div class="form-group-edit">
                <label class="form-label-edit">{{ $strings['New Password'] }} <span class="req">*</span></label>
                <div class="input-wrap-edit">
                    <i class="fas fa-key form-icon-edit"></i>
                    <input type="password" name="new_password" id="newPwd" class="form-control-edit" placeholder="{{ $strings['Min. 6 characters'] }}">
                    <i class="fas fa-eye form-icon-right toggle-pwd" data-target="newPwd"></i>
                </div>
                <div class="password-strength" id="pwdStrength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <span class="strength-text" id="strengthText">{{ $strings['Weak'] }}</span>
                </div>
                <span class="err-msg" id="err_newPwd"></span>
            </div>

            <div class="form-group-edit">
                <label class="form-label-edit">{{ $strings['Confirm New Password'] }} <span class="req">*</span></label>
                <div class="input-wrap-edit">
                    <i class="fas fa-check-double form-icon-edit"></i>
                    <input type="password" name="new_password_confirmation" id="confirmPwd" class="form-control-edit" placeholder="{{ $strings['Re-type new password'] }}">
                    <i class="fas fa-eye form-icon-right toggle-pwd" data-target="confirmPwd"></i>
                </div>
                <span class="err-msg" id="err_confirmPwd"></span>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn-save" id="savePwdBtn">
                    <i class="fas fa-key"></i> {{ $strings['Update Password'] }}
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============ CUSTOM ALERT POPUP MODAL ============ -->
<div class="modal fade" id="customAlertModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="alert-icon-wrap" id="customAlertIconWrap">
                <i class="fas" id="customAlertIcon"></i>
            </div>
            <h5 class="alert-title" id="customAlertTitle">Alert</h5>
            <p class="alert-message" id="customAlertMessage">Message goes here.</p>

            <div class="d-flex justify-content-center gap-3" id="alertBtnGroup">
                <!-- Dynamic Buttons appended here by JS -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        var jsStrings = {
            ok: "{{ $strings['OK'] ?? 'OK' }}",
            saving: "{{ $strings['Saving...'] ?? 'Saving...' }}",
            updating: "{{ $strings['Updating...'] ?? 'Updating...' }}",
            nameReq: "{{ $strings['Name required'] ?? 'Name required' }}",
            minChars2: "{{ $strings['Min 2 characters'] ?? 'Min 2 characters' }}",
            lettersOnly: "{{ $strings['Only letters allowed'] ?? 'Only letters allowed' }}",
            emailReq: "{{ $strings['Email required'] ?? 'Email required' }}",
            emailInvalid: "{{ $strings['Invalid email'] ?? 'Invalid email' }}",
            phoneReq: "{{ $strings['Phone required'] ?? 'Phone required' }}",
            phoneInvalid: "{{ $strings['Must be 10 digits, starts 6-9'] ?? 'Must be 10 digits, starts 6-9' }}",
            curPwdReq: "{{ $strings['Current password required'] ?? 'Current password required' }}",
            newPwdReq: "{{ $strings['New password required'] ?? 'New password required' }}",
            minChars6: "{{ $strings['Min 6 characters'] ?? 'Min 6 characters' }}",
            newPwdDifferent: "{{ $strings['New password must be different from current'] ?? 'New password must be different from current' }}",
            confirmPwdReq: "{{ $strings['Confirm new password'] ?? 'Confirm new password' }}",
            pwdMismatch: "{{ $strings['Passwords do not match'] ?? 'Passwords do not match' }}",
            imgSizeError: "{{ $strings['Image must be less than 2MB'] ?? 'Image must be less than 2MB' }}",
            imgInvalid: "{{ $strings['Please upload a valid image'] ?? 'Please upload a valid image' }}",

            // Strength meter levels
            strVeryWeak: "{{ $strings['Very Weak'] ?? 'Very Weak' }}",
            strWeak: "{{ $strings['Weak'] ?? 'Weak' }}",
            strFair: "{{ $strings['Fair'] ?? 'Fair' }}",
            strGood: "{{ $strings['Good'] ?? 'Good' }}",
            strStrong: "{{ $strings['Strong'] ?? 'Strong' }}"
        };

        // ==========================================
        // CUSTOM ALERT POPUP LOGIC
        // ==========================================
        function showCustomAlert(type, title, message, isConfirm = false, onConfirm = null) {
            var iconWrap = $('#customAlertIconWrap');
            var icon = $('#customAlertIcon');
            var btnGroup = $('#alertBtnGroup');

            iconWrap.removeClass('warning danger success');
            btnGroup.empty();

            if (type === 'warning') {
                iconWrap.addClass('warning');
                icon.attr('class', 'fas fa-exclamation-triangle');
            } else if (type === 'danger') {
                iconWrap.addClass('danger');
                icon.attr('class', 'fas fa-times-circle');
            } else {
                iconWrap.addClass('success');
                icon.attr('class', 'fas fa-check-circle');
            }

            $('#customAlertTitle').text(title);
            $('#customAlertMessage').html(message);

            if (isConfirm) {
                // You can add cancel button logic if needed in the future
                btnGroup.append(`<button type="button" class="alert-btn-confirm" id="customAlertConfirmBtn">${jsStrings.ok}</button>`);
                $('#customAlertConfirmBtn').on('click', function() {
                    $('#customAlertModal').modal('hide');
                    if (onConfirm) onConfirm();
                });
            } else {
                btnGroup.append(`<button type="button" class="alert-btn-ok" data-bs-dismiss="modal">${jsStrings.ok}</button>`);
            }

            $('#customAlertModal').modal('show');
        }

        /* ============ TAB SWITCHING ============ */
        $('.edit-tab').on('click', function() {
            var tab = $(this).data('tab');
            $('.edit-tab').removeClass('active');
            $(this).addClass('active');
            $('.edit-tab-content').removeClass('active');
            $('#tab-' + tab).addClass('active');
        });

        // Auto switch to password tab if URL has #password
        if (window.location.hash === '#password') {
            $('.edit-tab[data-tab="password"]').trigger('click');
        }

        /* ============ AVATAR UPLOAD PREVIEW ============ */
        $('#avatarInput').on('change', function() {
            var file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    showCustomAlert('warning', 'Invalid Image', jsStrings.imgSizeError);
                    $(this).val('');
                    return;
                }
                if (!file.type.match('image.*')) {
                    showCustomAlert('warning', 'Invalid Image', jsStrings.imgInvalid);
                    $(this).val('');
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatarPreview').html('<img src="' + e.target.result + '">');
                };
                reader.readAsDataURL(file);
            }
        });

        /* ============ PASSWORD TOGGLE ============ */
        $('.toggle-pwd').on('click', function() {
            var target = $(this).data('target');
            var $inp = $('#' + target);
            var type = $inp.attr('type') === 'password' ? 'text' : 'password';
            $inp.attr('type', type);
            $(this).toggleClass('fa-eye fa-eye-slash');
        });

        /* ============ PASSWORD STRENGTH METER ============ */
        $('#newPwd').on('input', function() {
            var val = $(this).val();
            var $wrap = $('#pwdStrength');
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

            var levels = [{
                    w: '20%',
                    c: '#E53935',
                    t: jsStrings.strVeryWeak
                },
                {
                    w: '40%',
                    c: '#FB8C00',
                    t: jsStrings.strWeak
                },
                {
                    w: '60%',
                    c: '#FDD835',
                    t: jsStrings.strFair
                },
                {
                    w: '80%',
                    c: '#7CB342',
                    t: jsStrings.strGood
                },
                {
                    w: '100%',
                    c: '#2E7D32',
                    t: jsStrings.strStrong
                }
            ];
            var lvl = levels[Math.max(0, score - 1)];
            $fill.css({
                width: lvl.w,
                background: lvl.c
            });
            $text.text(lvl.t).css('color', lvl.c);
        });

        /* ============ VALIDATION HELPERS ============ */
        function showErr($el, msg) {
            $el.addClass('error').removeClass('success');
            $el.closest('.form-group-edit').find('.err-msg').text('⚠ ' + msg).addClass('show');
        }

        function showOk($el) {
            $el.addClass('success').removeClass('error');
            $el.closest('.form-group-edit').find('.err-msg').removeClass('show').text('');
        }

        function clear($el) {
            $el.removeClass('error success');
            $el.closest('.form-group-edit').find('.err-msg').removeClass('show').text('');
        }

        /* Personal Info Validation */
        $('#personalForm').on('submit', function(e) {
            e.preventDefault();
            var isValid = true;

            var name = $.trim($('#pName').val());
            if (name === '') {
                showErr($('#pName'), jsStrings.nameReq);
                isValid = false;
            } else if (name.length < 2) {
                showErr($('#pName'), jsStrings.minChars2);
                isValid = false;
            } else if (!/^[a-zA-Z\s.]+$/.test(name)) {
                showErr($('#pName'), jsStrings.lettersOnly);
                isValid = false;
            } else showOk($('#pName'));

            var email = $.trim($('#pEmail').val());
            var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '') {
                showErr($('#pEmail'), jsStrings.emailReq);
                isValid = false;
            } else if (!emailRe.test(email)) {
                showErr($('#pEmail'), jsStrings.emailInvalid);
                isValid = false;
            } else showOk($('#pEmail'));

            var phone = $.trim($('#pPhone').val());
            if (phone === '') {
                showErr($('#pPhone'), jsStrings.phoneReq);
                isValid = false;
            } else if (!/^[6-9]\d{9}$/.test(phone)) {
                showErr($('#pPhone'), jsStrings.phoneInvalid);
                isValid = false;
            } else showOk($('#pPhone'));

            if (!isValid) return false;

            var $btn = $('#savePBtn');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.saving);
            this.submit();
        });

        /* Password Form Validation */
        $('#passwordForm').on('submit', function(e) {
            e.preventDefault();
            var isValid = true;

            var cur = $('#currentPwd').val();
            if (cur === '') {
                showErr($('#currentPwd'), jsStrings.curPwdReq);
                isValid = false;
            } else showOk($('#currentPwd'));

            var np = $('#newPwd').val();
            if (np === '') {
                showErr($('#newPwd'), jsStrings.newPwdReq);
                isValid = false;
            } else if (np.length < 6) {
                showErr($('#newPwd'), jsStrings.minChars6);
                isValid = false;
            } else if (np === cur) {
                showErr($('#newPwd'), jsStrings.newPwdDifferent);
                isValid = false;
            } else showOk($('#newPwd'));

            var cp = $('#confirmPwd').val();
            if (cp === '') {
                showErr($('#confirmPwd'), jsStrings.confirmPwdReq);
                isValid = false;
            } else if (cp !== np) {
                showErr($('#confirmPwd'), jsStrings.pwdMismatch);
                isValid = false;
            } else showOk($('#confirmPwd'));

            if (!isValid) return false;

            var $btn = $('#savePwdBtn');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.updating);
            this.submit();
        });

        $('#pPhone').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $('.form-control-edit').on('input change', function() {
            if ($(this).hasClass('error') && $.trim($(this).val()) !== '') clear($(this));
        });

    });
</script>
@endsection