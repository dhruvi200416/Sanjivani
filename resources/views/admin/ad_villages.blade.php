@extends('layouts.admin')

@section('title', 'Manage Villages - Sanjivani Admin')
@section('page_title')
    <i class="fas fa-map-marker-alt"></i> Manage Villages
@endsection

@section('styles')
<style>
    .filter-card { background: var(--white); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); margin-bottom: 20px; }
    .filter-input, .filter-select {
        width: 100%; padding: 10px 14px; border: 2px solid #E8E8E8;
        border-radius: 10px; font-size: 0.88rem; font-family: 'Poppins', sans-serif;
        outline: none; transition: var(--transition);
    }
    .filter-input:focus, .filter-select:focus { border-color: var(--primary-green); box-shadow: 0 0 0 3px rgba(76,175,80,0.1); }
    .filter-select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat; background-position: right 12px center;
        background-size: 12px; padding-right: 35px; background-color: var(--white);
    }
    .search-wrap { position: relative; }
    .search-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--primary-green); font-size: 0.9rem; }
    .search-wrap input { padding-left: 40px; }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); border: none; padding: 10px 22px; border-radius: 10px;
        font-weight: 600; font-size: 0.88rem; cursor: pointer; transition: var(--transition);
        display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
    }
    .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(46,125,50,0.3); color: var(--white); }

    /* Village Card Grid */
    .village-card {
        background: var(--white); border-radius: 16px; padding: 20px;
        box-shadow: var(--shadow); transition: var(--transition); height: 100%;
        border-top: 4px solid var(--light-green); position: relative; overflow: hidden;
    }

    .village-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(46,125,50,0.18); }

    .village-card::before {
        content: '\f3c5'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: -15px; bottom: -20px;
        font-size: 6rem; opacity: 0.05; color: var(--primary-green);
    }

    .village-header {
        display: flex; justify-content: space-between; align-items: flex-start;
        margin-bottom: 15px; position: relative; z-index: 2;
    }

    .village-header .v-icon {
        width: 50px; height: 50px; border-radius: 13px;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
    }

    .village-header h5 {
        font-size: 1.1rem; font-weight: 700; color: var(--dark-text); margin: 0 0 3px;
    }

    .village-header p { font-size: 0.78rem; color: var(--gray-text); margin: 0; }

    .village-header .v-actions { display: flex; gap: 5px; }

    .v-btn {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        color: var(--white); border: none; cursor: pointer;
        transition: var(--transition); font-size: 0.75rem; text-decoration: none;
    }
    .v-btn.edit { background: #1976D2; }
    .v-btn.delete { background: #C62828; }
    .v-btn:hover { transform: translateY(-2px); color: var(--white); }

    .village-info {
        display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;
        padding-top: 15px; border-top: 1px dashed #E0E0E0;
        position: relative; z-index: 2;
    }

    .v-stat {
        text-align: center; padding: 10px 5px;
        background: var(--pale-green); border-radius: 10px;
    }

    .v-stat strong {
        display: block; font-size: 1.15rem; color: var(--primary-green); font-weight: 800;
    }

    .v-stat span { font-size: 0.7rem; color: var(--gray-text); text-transform: uppercase; }

    .modal-content-custom { border: none; border-radius: 18px; overflow: hidden; }
    .modal-header-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); padding: 18px 25px; border: none;
    }
    .modal-header-custom .btn-close { filter: brightness(0) invert(1); }

    .form-group-modal { margin-bottom: 16px; }
    .form-label-modal { font-size: 0.8rem; font-weight: 600; color: var(--dark-text); margin-bottom: 6px; display: block; }
    .form-label-modal .req { color: #E53935; }
    .form-control-modal {
        width: 100%; padding: 10px 14px; border: 2px solid #E8E8E8;
        border-radius: 10px; font-size: 0.88rem; outline: none;
        transition: var(--transition); font-family: 'Poppins', sans-serif;
    }
    .form-control-modal:focus { border-color: var(--primary-green); box-shadow: 0 0 0 3px rgba(76,175,80,0.1); }
    .form-control-modal.error { border-color: #E53935; background: #FFF5F5; }
    .err-msg { color: #E53935; font-size: 0.75rem; margin-top: 4px; display: none; }
    .err-msg.show { display: block; }
</style>
@endsection

@section('content')

@php
    $demoVillages = $villages ?? [
        (object)['id'=>1,'name'=>'Nashik','district'=>'Nashik','state'=>'Maharashtra','pincode'=>'422001','delivery_charge'=>50,'total_customers'=>124,'total_pharmacies'=>8],
        (object)['id'=>2,'name'=>'Pune','district'=>'Pune','state'=>'Maharashtra','pincode'=>'411001','delivery_charge'=>60,'total_customers'=>245,'total_pharmacies'=>15],
        (object)['id'=>3,'name'=>'Mumbai','district'=>'Mumbai','state'=>'Maharashtra','pincode'=>'400001','delivery_charge'=>70,'total_customers'=>489,'total_pharmacies'=>32],
        (object)['id'=>4,'name'=>'Aurangabad','district'=>'Aurangabad','state'=>'Maharashtra','pincode'=>'431001','delivery_charge'=>55,'total_customers'=>98,'total_pharmacies'=>6],
        (object)['id'=>5,'name'=>'Kolhapur','district'=>'Kolhapur','state'=>'Maharashtra','pincode'=>'416001','delivery_charge'=>50,'total_customers'=>76,'total_pharmacies'=>5],
        (object)['id'=>6,'name'=>'Nagpur','district'=>'Nagpur','state'=>'Maharashtra','pincode'=>'440001','delivery_charge'=>65,'total_customers'=>187,'total_pharmacies'=>11],
        (object)['id'=>7,'name'=>'Solapur','district'=>'Solapur','state'=>'Maharashtra','pincode'=>'413001','delivery_charge'=>45,'total_customers'=>54,'total_pharmacies'=>4],
        (object)['id'=>8,'name'=>'Satara','district'=>'Satara','state'=>'Maharashtra','pincode'=>'415001','delivery_charge'=>45,'total_customers'=>67,'total_pharmacies'=>5],
    ];
@endphp

<div class="filter-card" data-aos="fade-up">
    <form method="GET" action="{{ url('/admin/villages') }}">
        <div class="row g-3 align-items-end">
            <div class="col-lg-6 col-md-6">
                <label style="font-size:0.78rem;font-weight:600;color:var(--dark-text);text-transform:uppercase;margin-bottom:6px;display:block;"><i class="fas fa-search me-1"></i> Search</label>
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="filter-input" placeholder="Village name, district, pincode..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <button type="submit" class="btn-primary-custom w-100 justify-content-center">
                    <i class="fas fa-filter"></i> Search
                </button>
            </div>
            <div class="col-lg-3 col-md-6">
                <button type="button" class="btn-primary-custom w-100 justify-content-center" data-bs-toggle="modal" data-bs-target="#villageModal" id="addVillageBtn">
                    <i class="fas fa-plus"></i> Add Village
                </button>
            </div>
        </div>
    </form>
</div>

<div class="row g-3" data-aos="fade-up">
    @foreach($demoVillages as $v)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="village-card">
                <div class="village-header">
                    <div style="display:flex;gap:12px;">
                        <div class="v-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h5>{{ $v->name }}</h5>
                            <p>{{ $v->district }}, {{ $v->state }}</p>
                            <p style="font-size:0.72rem;"><i class="fas fa-mail-bulk me-1"></i> {{ $v->pincode }}</p>
                        </div>
                    </div>
                    <div class="v-actions">
                        <button type="button" class="v-btn edit btn-edit-village" data-v='@json($v)' title="Edit"><i class="fas fa-edit"></i></button>
                        <button type="button" class="v-btn delete btn-delete-village" data-id="{{ $v->id }}" data-name="{{ $v->name }}" title="Delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>

                <div class="village-info">
                    <div class="v-stat">
                        <strong>{{ $v->total_customers }}</strong>
                        <span>Customers</span>
                    </div>
                    <div class="v-stat">
                        <strong>{{ $v->total_pharmacies }}</strong>
                        <span>Pharmacies</span>
                    </div>
                    <div class="v-stat" style="grid-column:1/-1;">
                        <strong>₹{{ $v->delivery_charge }}</strong>
                        <span>Delivery Charge</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Add/Edit Village Modal -->
<div class="modal fade" id="villageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" id="vModalTitle"><i class="fas fa-plus-circle me-2"></i> Add New Village</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="villageForm" action="{{ url('/admin/village/save') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="village_id" id="vId">
                <div class="modal-body" style="padding:25px;">
                    <div class="form-group-modal">
                        <label class="form-label-modal">Village Name <span class="req">*</span></label>
                        <input type="text" name="name" id="v_name" class="form-control-modal" placeholder="e.g. Nashik">
                        <span class="err-msg" id="err_v_name"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">District <span class="req">*</span></label>
                                <input type="text" name="district" id="v_district" class="form-control-modal" placeholder="e.g. Nashik">
                                <span class="err-msg" id="err_v_district"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">State <span class="req">*</span></label>
                                <input type="text" name="state" id="v_state" class="form-control-modal" placeholder="e.g. Maharashtra">
                                <span class="err-msg" id="err_v_state"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">Pincode <span class="req">*</span></label>
                                <input type="text" name="pincode" id="v_pincode" class="form-control-modal" placeholder="6-digit pincode" maxlength="6">
                                <span class="err-msg" id="err_v_pincode"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">Delivery Charge (₹) <span class="req">*</span></label>
                                <input type="number" name="delivery_charge" id="v_charge" class="form-control-modal" placeholder="50" min="0">
                                <span class="err-msg" id="err_v_charge"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="btn-primary-custom" data-bs-dismiss="modal" style="background:linear-gradient(135deg,#607D8B,#90A4AE);"><i class="fas fa-times"></i> Cancel</button>
                    <button type="submit" class="btn-primary-custom" id="saveVBtn"><i class="fas fa-save"></i> Save Village</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    $('#addVillageBtn').on('click', function () {
        $('#villageForm')[0].reset(); $('#vId').val('');
        $('#vModalTitle').html('<i class="fas fa-plus-circle me-2"></i> Add New Village');
        $('.err-msg').removeClass('show').text('');
        $('.form-control-modal').removeClass('error');
    });

    $('.btn-edit-village').on('click', function () {
        var v = $(this).data('v');
        $('#vId').val(v.id);
        $('#v_name').val(v.name);
        $('#v_district').val(v.district);
        $('#v_state').val(v.state);
        $('#v_pincode').val(v.pincode);
        $('#v_charge').val(v.delivery_charge);
        $('#vModalTitle').html('<i class="fas fa-edit me-2"></i> Edit Village');
        $('.err-msg').removeClass('show').text('');
        $('.form-control-modal').removeClass('error');
        $('#villageModal').modal('show');
    });

    $('.btn-delete-village').on('click', function () {
        var id = $(this).data('id'); var name = $(this).data('name');
        if (confirm('⚠ Are you sure you want to delete village "' + name + '"?\nCustomers and pharmacies in this village will need to be reassigned.')) {
            var $form = $('<form>', { method: 'POST', action: '{{ url("/admin/village/delete") }}/' + id });
            $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            $form.append('<input type="hidden" name="_method" value="DELETE">');
            $('body').append($form); $form.submit();
        }
    });

    function showFieldError($el, msg) {
        $el.addClass('error');
        $el.closest('.form-group-modal').find('.err-msg').text(msg).addClass('show');
    }
    function clearFieldError($el) {
        $el.removeClass('error');
        $el.closest('.form-group-modal').find('.err-msg').removeClass('show').text('');
    }

    $('#v_pincode').on('input', function () { this.value = this.value.replace(/[^0-9]/g, ''); });
    $('#v_charge').on('input', function () { this.value = this.value.replace(/[^0-9.]/g, ''); });

    $('#villageForm').on('submit', function (e) {
        e.preventDefault();
        var isValid = true;
        $('.err-msg').removeClass('show').text('');
        $('.form-control-modal').removeClass('error');

        var name = $.trim($('#v_name').val());
        if (name === '') { showFieldError($('#v_name'), '⚠ Village name required'); isValid = false; }
        else if (name.length < 2) { showFieldError($('#v_name'), '⚠ Min 2 characters'); isValid = false; }

        if ($.trim($('#v_district').val()) === '') { showFieldError($('#v_district'), '⚠ District required'); isValid = false; }
        if ($.trim($('#v_state').val()) === '') { showFieldError($('#v_state'), '⚠ State required'); isValid = false; }

        var pin = $.trim($('#v_pincode').val());
        if (pin === '') { showFieldError($('#v_pincode'), '⚠ Pincode required'); isValid = false; }
        else if (!/^\d{6}$/.test(pin)) { showFieldError($('#v_pincode'), '⚠ Must be 6 digits'); isValid = false; }

        var charge = parseFloat($('#v_charge').val());
        if ($('#v_charge').val() === '' || isNaN(charge)) { showFieldError($('#v_charge'), '⚠ Delivery charge required'); isValid = false; }
        else if (charge < 0) { showFieldError($('#v_charge'), '⚠ Cannot be negative'); isValid = false; }

        if (!isValid) return false;

        var $btn = $('#saveVBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        this.submit();
    });

    $('.form-control-modal').on('input change', function () {
        if ($(this).hasClass('error') && $.trim($(this).val()) !== '') clearFieldError($(this));
    });

});
</script>
@endsection