@extends('layouts.admin')

@section('title', 'Edit Profile - Sanjivani Admin')
@section('page_title')
    <i class="fas fa-edit"></i> Edit Profile
@endsection

@section('styles')
<style>
    .edit-profile-card {
        background: var(--white); border-radius: 18px;
        box-shadow: var(--shadow); overflow: hidden;
    }

    .edit-tabs {
        display: flex; background: var(--off-white); border-bottom: 1px solid #E0E0E0;
    }

    .edit-tab {
        flex: 1; padding: 15px 20px; text-align: center;
        cursor: pointer; font-size: 0.9rem; font-weight: 600;
        color: var(--gray-text); transition: var(--transition);
        border: none; background: transparent;
        border-bottom: 3px solid transparent;
    }

    .edit-tab i { margin-right: 6px; }

    .edit-tab:hover { color: var(--primary-green); background: var(--pale-green); }

    .edit-tab.active {
        color: var(--primary-green); background: var(--white);
        border-bottom-color: var(--primary-green);
    }

    .edit-tab-content {
        display: none; padding: 30px;
    }

    .edit-tab-content.active { display: block; }

    .form-group-edit { margin-bottom: 20px; position: relative; }

    .form-label-edit {
        font-size: 0.85rem; font-weight: 600; color: var(--dark-text);
        margin-bottom: 8px; display: block;
    }

    .form-label-edit .req { color: #E53935; }

    .input-wrap-edit { position: relative; }

    .form-control-edit {
        width: 100%; padding: 12px 16px 12px 44px;
        border: 2px solid #E0E0E0; border-radius: 12px;
        font-size: 0.92rem; font-family: 'Poppins', sans-serif;
        outline: none; transition: var(--transition); background: var(--white);
    }

    .form-control-edit:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
    }

    .form-control-edit.error { border-color: #E53935; background: #FFF5F5; }
    .form-control-edit.success { border-color: var(--light-green); background: #F1F8E9; }

    .form-icon-edit {
        position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
        color: var(--primary-green); font-size: 0.95rem;
    }

    .form-icon-right {
        position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
        color: var(--gray-text); font-size: 0.9rem; cursor: pointer;
    }
    .form-icon-right:hover { color: var(--primary-green); }

    textarea.form-control-edit { min-height: 90px; padding-top: 12px; resize: vertical; }

    .err-msg {
        color: #E53935; font-size: 0.78rem; margin-top: 5px;
        display: none; font-weight: 500;
    }
    .err-msg.show { display: block; }

    .avatar-upload {
        text-align: center; margin-bottom: 25px;
    }

    .avatar-upload .avatar-wrap {
        position: relative; display: inline-block;
    }

    .avatar-upload .avatar-big {
        width: 130px; height: 130px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); display: flex; align-items: center; justify-content: center;
        font-size: 3rem; font-weight: 800;
        box-shadow: 0 10px 30px rgba(46,125,50,0.25);
        border: 5px solid var(--white); margin: 0 auto;
        overflow: hidden;
    }

    .avatar-upload .avatar-big img {
        width: 100%; height: 100%; object-fit: cover;
    }

    .avatar-upload .change-btn {
        position: absolute; bottom: 5px; right: 5px;
        width: 40px; height: 40px; border-radius: 50%;
        background: var(--white); color: var(--primary-green);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; border: 3px solid var(--pale-green);
        transition: var(--transition);
    }

    .avatar-upload .change-btn:hover {
        background: var(--primary-green); color: var(--white);
        border-color: var(--white);
    }

    .btn-save {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); border: none; padding: 12px 35px;
        border-radius: 30px; font-weight: 700; font-size: 0.95rem;
        cursor: pointer; transition: var(--transition);
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 8px 20px rgba(46,125,50,0.25);
    }

    .btn-save:hover:not(:disabled) {
        transform: translateY(-2px); box-shadow: 0 12px 28px rgba(46,125,50,0.35);
    }
    .btn-save:disabled { opacity: 0.6; cursor: not-allowed; }

    .password-strength {
        margin-top: 8px; display: none;
    }
    .password-strength.show { display: block; }
    .strength-bar {
        width: 100%; height: 5px; background: #E0E0E0;
        border-radius: 3px; overflow: hidden; margin-bottom: 4px;
    }
    .strength-fill { height: 100%; width: 0%; transition: all 0.3s; border-radius: 3px; }
    .strength-text { font-size: 0.75rem; font-weight: 600; }

    .alert-inline {
        padding: 12px 18px; border-radius: 10px;
        margin-bottom: 20px; font-size: 0.88rem;
    }
    .alert-inline.success { background: #E8F5E9; color: #1B5E20; border: 1px solid #A5D6A7; }
    .alert-inline.error { background: #FFEBEE; color: #B71C1C; border: 1px solid #EF9A9A; }

    @media (max-width: 767px) {
        .edit-tab { padding: 12px 8px; font-size: 0.78rem; }
        .edit-tab i { display: none; }
        .edit-tab-content { padding: 20px 18px; }
    }
</style>
@endsection

@section('content')

@php
    $admin = $admin ?? (object)[
        'name' => session('admin_name') ?? 'Admin User',
        'email' => 'admin@sanjivani.com',
        'phone' => '9876543210',
        'address' => '123 Health Street, Medical Plaza, Mumbai',
    ];
@endphp

<div class="edit-profile-card" data-aos="fade-up">
    <div class="edit-tabs">
        <button type="button" class="edit-tab active" data-tab="personal"><i class="fas fa-user"></i> Personal Info</button>
        <button type="button" class="edit-tab" data-tab="password"><i class="fas fa-key"></i> Change Password</button>
    </div>

    <!-- Personal Info Tab -->
    <div class="edit-tab-content active" id="tab-personal">
        @if(session('profile_success'))
            <div class="alert-inline success"><i class="fas fa-check-circle me-2"></i>{{ session('profile_success') }}</div>
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
                    Click camera icon to change photo (Max 2MB, JPG/PNG)
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-edit">
                        <label class="form-label-edit">Full Name <span class="req">*</span></label>
                        <div class="input-wrap-edit">
                            <i class="fas fa-user form-icon-edit"></i>
                            <input type="text" name="name" id="pName" class="form-control-edit" value="{{ $admin->name }}">
                        </div>
                        <span class="err-msg" id="err_pName"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-edit">
                        <label class="form-label-edit">Email Address <span class="req">*</span></label>
                        <div class="input-wrap-edit">
                            <i class="fas fa-envelope form-icon-edit"></i>
                            <input type="email" name="email" id="pEmail" class="form-control-edit" value="{{ $admin->email }}">
                        </div>
                        <span class="err-msg" id="err_pEmail"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-edit">
                        <label class="form-label-edit">Mobile Number <span class="req">*</span></label>
                        <div class="input-wrap-edit">
                            <i class="fas fa-phone form-icon-edit"></i>
                            <input type="text" name="phone" id="pPhone" class="form-control-edit" value="{{ $admin->phone }}" maxlength="10">
                        </div>
                        <span class="err-msg" id="err_pPhone"></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group-edit">
                        <label class="form-label-edit">Address</label>
                        <div class="input-wrap-edit">
                            <i class="fas fa-home form-icon-edit" style="top:20px;transform:none;"></i>
                            <textarea name="address" id="pAddress" class="form-control-edit">{{ $admin->address }}</textarea>
                        </div>
                        <span class="err-msg" id="err_pAddress"></span>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn-save" id="savePBtn">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Password Tab -->
    <div class="edit-tab-content" id="tab-password">
        @if(session('password_success'))
            <div class="alert-inline success"><i class="fas fa-check-circle me-2"></i>{{ session('password_success') }}</div>
        @endif
        @if(session('password_error'))
            <div class="alert-inline error"><i class="fas fa-exclamation-circle me-2"></i>{{ session('password_error') }}</div>
        @endif

        <form id="passwordForm" action="{{ url('/admin/profile/change-password') }}" method="POST" novalidate>
            @csrf

            <div class="form-group-edit">
                <label class="form-label-edit">Current Password <span class="req">*</span></label>
                <div class="input-wrap-edit">
                    <i class="fas fa-lock form-icon-edit"></i>
                    <input type="password" name="current_password" id="currentPwd" class="form-control-edit" placeholder="Enter your current password">
                    <i class="fas fa-eye form-icon-right toggle-pwd" data-target="currentPwd"></i>
                </div>
                <span class="err-msg" id="err_currentPwd"></span>
            </div>

            <div class="form-group-edit">
                <label class="form-label-edit">New Password <span class="req">*</span></label>
                <div class="input-wrap-edit">
                    <i class="fas fa-key form-icon-edit"></i>
                    <input type="password" name="new_password" id="newPwd" class="form-control-edit" placeholder="Min. 6 characters">
                    <i class="fas fa-eye form-icon-right toggle-pwd" data-target="newPwd"></i>
                </div>
                <div class="password-strength" id="pwdStrength">
                    <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                    <span class="strength-text" id="strengthText">Weak</span>
                </div>
                <span class="err-msg" id="err_newPwd"></span>
            </div>

            <div class="form-group-edit">
                <label class="form-label-edit">Confirm New Password <span class="req">*</span></label>
                <div class="input-wrap-edit">
                    <i class="fas fa-check-double form-icon-edit"></i>
                    <input type="password" name="new_password_confirmation" id="confirmPwd" class="form-control-edit" placeholder="Re-type new password">
                    <i class="fas fa-eye form-icon-right toggle-pwd" data-target="confirmPwd"></i>
                </div>
                <span class="err-msg" id="err_confirmPwd"></span>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn-save" id="savePwdBtn">
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

    /* ============ TAB SWITCHING ============ */
    $('.edit-tab').on('click', function () {
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
    $('#avatarInput').on('change', function () {
        var file = this.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('⚠ Image must be less than 2MB');
                $(this).val(''); return;
            }
            if (!file.type.match('image.*')) {
                alert('⚠ Please upload a valid image'); $(this).val(''); return;
            }
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#avatarPreview').html('<img src="' + e.target.result + '">');
            };
            reader.readAsDataURL(file);
        }
    });

    /* ============ PASSWORD TOGGLE ============ */
    $('.toggle-pwd').on('click', function () {
        var target = $(this).data('target');
        var $inp = $('#' + target);
        var type = $inp.attr('type') === 'password' ? 'text' : 'password';
        $inp.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    /* ============ PASSWORD STRENGTH METER ============ */
    $('#newPwd').on('input', function () {
        var val = $(this).val();
        var $wrap = $('#pwdStrength');
        var $fill = $('#strengthFill');
        var $text = $('#strengthText');

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
        $el.closest('.form-group-edit').find('.err-msg').text(msg).addClass('show');
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
    $('#personalForm').on('submit', function (e) {
        e.preventDefault();
        var isValid = true;

        var name = $.trim($('#pName').val());
        if (name === '') { showErr($('#pName'), '⚠ Name required'); isValid = false; }
        else if (name.length < 2) { showErr($('#pName'), '⚠ Min 2 characters'); isValid = false; }
        else if (!/^[a-zA-Z\s.]+$/.test(name)) { showErr($('#pName'), '⚠ Only letters allowed'); isValid = false; }
        else showOk($('#pName'));

        var email = $.trim($('#pEmail').val());
        var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '') { showErr($('#pEmail'), '⚠ Email required'); isValid = false; }
        else if (!emailRe.test(email)) { showErr($('#pEmail'), '⚠ Invalid email'); isValid = false; }
        else showOk($('#pEmail'));

        var phone = $.trim($('#pPhone').val());
        if (phone === '') { showErr($('#pPhone'), '⚠ Phone required'); isValid = false; }
        else if (!/^[6-9]\d{9}$/.test(phone)) { showErr($('#pPhone'), '⚠ Must be 10 digits, starts 6-9'); isValid = false; }
        else showOk($('#pPhone'));

        if (!isValid) return false;

        var $btn = $('#savePBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        this.submit();
    });

    /* Password Form Validation */
    $('#passwordForm').on('submit', function (e) {
        e.preventDefault();
        var isValid = true;

        var cur = $('#currentPwd').val();
        if (cur === '') { showErr($('#currentPwd'), '⚠ Current password required'); isValid = false; }
        else showOk($('#currentPwd'));

        var np = $('#newPwd').val();
        if (np === '') { showErr($('#newPwd'), '⚠ New password required'); isValid = false; }
        else if (np.length < 6) { showErr($('#newPwd'), '⚠ Min 6 characters'); isValid = false; }
        else if (np === cur) { showErr($('#newPwd'), '⚠ New password must be different from current'); isValid = false; }
        else showOk($('#newPwd'));

        var cp = $('#confirmPwd').val();
        if (cp === '') { showErr($('#confirmPwd'), '⚠ Confirm new password'); isValid = false; }
        else if (cp !== np) { showErr($('#confirmPwd'), '⚠ Passwords do not match'); isValid = false; }
        else showOk($('#confirmPwd'));

        if (!isValid) return false;

        var $btn = $('#savePwdBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        this.submit();
    });

    $('#pPhone').on('input', function () { this.value = this.value.replace(/[^0-9]/g, ''); });

    $('.form-control-edit').on('input change', function () {
        if ($(this).hasClass('error') && $.trim($(this).val()) !== '') clear($(this));
    });

});
</script>
@endsection