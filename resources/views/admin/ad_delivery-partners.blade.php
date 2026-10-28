@extends('layouts.admin')

@section('title', 'Delivery Partners - Sanjivani Admin')

@section('page_title')
<i class="fa-solid fa-motorcycle"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('Delivery Partners') }}
@endsection

@section('styles')
<style>
    .filter-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #E8E8E8;
        border-radius: 10px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: var(--transition);
    }

    .filter-input:focus,
    .filter-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .filter-select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 35px;
        background-color: var(--white);
    }

    .search-wrap {
        position: relative;
    }

    .search-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-green);
        font-size: 0.9rem;
    }

    .search-wrap input {
        padding-left: 40px;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
        color: var(--white);
    }

    .stat-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .stat-mini {
        background: var(--white);
        border-radius: 14px;
        padding: 18px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .stat-mini .sm-icon {
        width: 45px;
        height: 45px;
        min-width: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.1rem;
    }

    .sm-icon.total {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .sm-icon.active {
        background: linear-gradient(135deg, #1565C0, #42A5F5);
    }

    .sm-icon.busy {
        background: linear-gradient(135deg, #7B1FA2, #AB47BC);
    }

    .sm-icon.pending {
        background: linear-gradient(135deg, #E65100, #FFA726);
    }

    .stat-mini .sm-val {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1;
    }

    .stat-mini .sm-lbl {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    /* Delivery Partner Card */
    .dp-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 15px;
        transition: var(--transition);
        border-left: 5px solid var(--primary-green);
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 20px;
        align-items: center;
    }

    .dp-card.pending {
        border-left-color: #FB8C00;
    }

    .dp-card.rejected {
        border-left-color: #E53935;
    }

    .dp-card.busy {
        border-left-color: #7B1FA2;
    }

    .dp-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.15);
    }

    .dp-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .dp-info h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 4px;
    }

    .dp-info h5 .st-tag {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-left: 8px;
        vertical-align: middle;
    }

    .st-tag.available {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .st-tag.busy {
        background: #F3E5F5;
        color: #7B1FA2;
    }

    .st-tag.offline {
        background: #EEEEEE;
        color: #616161;
    }

    .st-tag.pending {
        background: #FFF3E0;
        color: #FB8C00;
    }

    .st-tag.rejected {
        background: #FFEBEE;
        color: #C62828;
    }

    .dp-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 6px;
    }

    .dp-meta span {
        font-size: 0.8rem;
        color: var(--gray-text);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .dp-meta span i {
        color: var(--primary-green);
    }

    .dp-vehicle {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #E0E0E0;
    }

    .dp-vehicle .vh-item {
        text-align: center;
    }

    .dp-vehicle .vh-item strong {
        display: block;
        font-size: 0.95rem;
        color: var(--primary-green);
        font-weight: 700;
    }

    .dp-vehicle .vh-item span {
        font-size: 0.7rem;
        color: var(--gray-text);
        text-transform: uppercase;
    }

    .dp-rating {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #FFF9C4;
        color: #F57F17;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.78rem;
        font-weight: 700;
    }

    .dp-actions {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 120px;
    }

    .dp-btn {
        padding: 7px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        border: none;
        color: var(--white);
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 5px;
        justify-content: center;
        text-decoration: none;
    }

    .dp-btn.view {
        background: linear-gradient(135deg, #1976D2, #42A5F5);
    }

    .dp-btn.approve {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .dp-btn.reject {
        background: linear-gradient(135deg, #E65100, #FFA726);
    }

    .dp-btn.delete {
        background: linear-gradient(135deg, #C62828, #EF5350);
    }

    .dp-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        color: var(--white);
    }

    /* Modal */
    .modal-content-custom {
        border: none;
        border-radius: 18px;
        overflow: hidden;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 18px 25px;
        border: none;
    }

    .modal-header-custom .btn-close {
        filter: brightness(0) invert(1);
    }

    .form-group-modal {
        margin-bottom: 16px;
    }

    .form-label-modal {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 6px;
        display: block;
    }

    .form-label-modal .req {
        color: #E53935;
    }

    .form-control-modal {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #E8E8E8;
        border-radius: 10px;
        font-size: 0.88rem;
        outline: none;
        transition: var(--transition);
        font-family: 'Poppins', sans-serif;
    }

    .form-control-modal:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .form-control-modal.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .err-msg {
        color: #E53935;
        font-size: 0.75rem;
        margin-top: 4px;
        display: none;
    }

    .err-msg.show {
        display: block;
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

    .alert-btn-cancel {
        background: var(--white);
        color: var(--gray-text);
        border: 2px solid #E0E0E0;
        padding: 10px 22px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.88rem;
        transition: var(--transition);
    }

    .alert-btn-cancel:hover {
        background: var(--pale-green);
        color: var(--primary-green);
        border-color: var(--primary-green);
    }

    .alert-btn-confirm {
        background: linear-gradient(135deg, #C62828, #EF5350);
        color: var(--white);
        border: none;
        padding: 10px 22px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.88rem;
        transition: var(--transition);
    }

    .alert-btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(198, 40, 40, 0.3);
        color: var(--white);
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

    @media (max-width: 991px) {
        .stat-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .dp-card {
            grid-template-columns: auto 1fr;
        }

        .dp-actions {
            grid-column: 1 / -1;
            flex-direction: row;
            flex-wrap: wrap;
        }
    }

    @media (max-width: 576px) {
        .dp-card {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .dp-avatar {
            margin: 0 auto;
        }

        .dp-meta,
        .dp-vehicle {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

// Convert paginator or collection into a collection safely
$partnerCollection = collect(
isset($partners) && method_exists($partners, 'items')
? $partners->items()
: ($partners ?? [])
);

// Fallback data if table is empty
if ($partnerCollection->isEmpty()) {
$partnerCollection = collect([
(object)['id'=>1,'name'=>'Sunil Kumar','email'=>'sunil@example.com','phone'=>'9876543210','vehicle_type'=>'Bike','vehicle_number'=>'MH-01-AB-1234','aadhar_number'=>'123456789012','license_dl'=>'MH01-20200012345','address'=>'Nashik','village'=>(object)['name'=>'Nashik'],'status'=>'active','availability'=>'available','rating'=>4.7,'total_deliveries'=>234],
(object)['id'=>2,'name'=>'Ravi Sharma','email'=>'ravi@example.com','phone'=>'9812345678','vehicle_type'=>'Scooter','vehicle_number'=>'MH-02-CD-5678','aadhar_number'=>'234567890123','license_dl'=>'MH02-20190012345','address'=>'Pune','village'=>(object)['name'=>'Pune'],'status'=>'active','availability'=>'busy','rating'=>4.9,'total_deliveries'=>567],
(object)['id'=>3,'name'=>'Amit Verma','email'=>'amit@example.com','phone'=>'9765432109','vehicle_type'=>'Bike','vehicle_number'=>'MH-03-EF-9012','aadhar_number'=>'345678901234','license_dl'=>'MH03-20210012345','address'=>'Aurangabad','village'=>(object)['name'=>'Aurangabad'],'status'=>'pending','availability'=>'offline','rating'=>0,'total_deliveries'=>0],
(object)['id'=>4,'name'=>'Deepak Patil','email'=>'deepak@example.com','phone'=>'9871122334','vehicle_type'=>'Bike','vehicle_number'=>'MH-04-GH-3456','aadhar_number'=>'456789012345','license_dl'=>'MH04-20180012345','address'=>'Kolhapur','village'=>(object)['name'=>'Kolhapur'],'status'=>'active','availability'=>'available','rating'=>4.5,'total_deliveries'=>189],
(object)['id'=>5,'name'=>'Ganesh Rao','email'=>'ganesh@example.com','phone'=>'9822334455','vehicle_type'=>'Bicycle','vehicle_number'=>'N/A','aadhar_number'=>'567890123456','license_dl'=>'','address'=>'Solapur','village'=>(object)['name'=>'Solapur'],'status'=>'rejected','availability'=>'offline','rating'=>0,'total_deliveries'=>0],
]);
}

$totalCount = $partnerCollection->count();
$activeCount = $partnerCollection->filter(fn($p) => ($p->status ?? '') == 'active' && ($p->availability ?? '') == 'available')->count();
$busyCount = $partnerCollection->filter(fn($p) => ($p->availability ?? '') == 'busy')->count();
$pendingCount = $partnerCollection->filter(fn($p) => ($p->status ?? '') == 'pending')->count();

// GATHER ALL UI STRINGS AND TRANSLATE THEM SAFELY
$uiStrings = [
'Delivery Partners', 'Total Partners', 'Available Now', 'On Delivery', 'Pending Approval',
'Search', 'Name, phone, vehicle number...', 'Status', 'All Status', 'Active', 'Pending', 'Rejected',
'Filter', 'Add Partner', 'View', 'Approve', 'Reject', 'Edit', 'Delete',
'Add Delivery Partner', 'Edit Delivery Partner', 'Delivery Partner Details',
'Full Name', 'Email', 'Phone', 'Aadhar Number', 'Vehicle Type', 'Vehicle Number', 'Driving License', 'Village', 'Address', 'Password', 'Status',
'-- Select --', '-- Select Village --', 'Full name', 'email@example.com', '10-digit mobile', '12-digit Aadhar', 'MH-01-AB-1234', 'DL Number (optional)', 'Complete residential address', 'Min. 6 characters', 'Leave blank when editing',
'Save Partner', 'Cancel', 'Bike / Motorcycle', 'Scooter', 'Bicycle', 'Car', 'Auto Rickshaw',
'Name required', 'Min 2 characters', 'Email required', 'Invalid email', 'Phone required', 'Must be 10 digits, starts 6-9', 'Aadhar required', 'Must be 12 digits', 'Select vehicle',
'Vehicle number required', 'Format: MH-01-AB-1234', 'Select village', 'Address required', 'Min 10 characters', 'Password required',
'Are you sure you want to approve', 'Are you sure you want to reject', 'Are you sure you want to delete', 'Yes, Delete', 'OK'
];

// Translate the UI array safely (preventing timeouts)
$strings = [];
foreach($uiStrings as $str) {
$strings[$str] = GoogleTranslator::translate($str);
}
@endphp

<!-- Stats Row -->
<div class="stat-row" data-aos="fade-up">
    <div class="stat-mini">
        <div class="sm-icon total"><i class="fa-solid fa-users"></i></div>
        <div>
            <div class="sm-val">{{ $totalCount }}</div>
            <div class="sm-lbl">{{ $strings['Total Partners'] }}</div>
        </div>
    </div>
    <div class="stat-mini">
        <div class="sm-icon active"><i class="fa-solid fa-circle-check"></i></div>
        <div>
            <div class="sm-val">{{ $activeCount }}</div>
            <div class="sm-lbl">{{ $strings['Available Now'] }}</div>
        </div>
    </div>
    <div class="stat-mini">
        <div class="sm-icon busy"><i class="fa-solid fa-motorcycle"></i></div>
        <div>
            <div class="sm-val">{{ $busyCount }}</div>
            <div class="sm-lbl">{{ $strings['On Delivery'] }}</div>
        </div>
    </div>
    <div class="stat-mini">
        <div class="sm-icon pending"><i class="fa-solid fa-clock"></i></div>
        <div>
            <div class="sm-val">{{ $pendingCount }}</div>
            <div class="sm-lbl">{{ $strings['Pending Approval'] }}</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="filter-card" data-aos="fade-up">
    <form method="GET" action="{{ url('/admin/delivery-partners') }}">
        <div class="row g-3 align-items-end">
            <div class="col-lg-5 col-md-6">
                <label style="font-size:0.78rem;font-weight:600;color:var(--dark-text);text-transform:uppercase;margin-bottom:6px;display:block;"><i class="fa-solid fa-magnifying-glass me-1"></i> {{ $strings['Search'] }}</label>
                <div class="search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" class="filter-input" placeholder="{{ $strings['Name, phone, vehicle number...'] }}" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <label style="font-size:0.78rem;font-weight:600;color:var(--dark-text);text-transform:uppercase;margin-bottom:6px;display:block;"><i class="fa-solid fa-filter me-1"></i> {{ $strings['Status'] }}</label>
                <select name="status" class="filter-select">
                    <option value="">{{ $strings['All Status'] }}</option>
                    <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>{{ $strings['Active'] }}</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>{{ $strings['Pending'] }}</option>
                    <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>{{ $strings['Rejected'] }}</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <button type="submit" class="btn-primary-custom w-100 justify-content-center">
                    <i class="fa-solid fa-filter"></i> {{ $strings['Filter'] }}
                </button>
            </div>
            <div class="col-lg-2 col-md-6">
                <button type="button" class="btn-primary-custom w-100 justify-content-center" data-bs-toggle="modal" data-bs-target="#dpModal" id="addDpBtn">
                    <i class="fa-solid fa-plus"></i> {{ $strings['Add Partner'] }}
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Partners List -->
<div data-aos="fade-up">
    @foreach($partnerCollection as $dp)
    @php
    // Translate dynamic database fields individually
    $translatedName = GoogleTranslator::translate($dp->name);
    $translatedVillage = GoogleTranslator::translate($dp->village->name ?? '');
    $translatedAddress = GoogleTranslator::translate($dp->address);
    $translatedVType = $strings[ucfirst($dp->vehicle_type)] ?? GoogleTranslator::translate($dp->vehicle_type);
    $translatedStatus = $strings[ucfirst($dp->status)] ?? ucfirst($dp->status);
    if ($dp->status == 'active') {
    $translatedStatus = $strings[ucfirst($dp->availability)] ?? ucfirst($dp->availability);
    }
    @endphp
    <div class="dp-card {{ $dp->status == 'pending' ? 'pending' : ($dp->status == 'rejected' ? 'rejected' : ($dp->availability == 'busy' ? 'busy' : '')) }}">
        <div class="dp-avatar">{{ strtoupper(substr($translatedName, 0, 1)) }}</div>

        <div class="dp-info">
            <h5>
                {{ $translatedName }}
                <span class="st-tag {{ $dp->status == 'active' ? $dp->availability : $dp->status }}">
                    {{ $translatedStatus }}
                </span>
                @if(isset($dp->rating) && $dp->rating > 0)
                <span class="dp-rating"><i class="fa-solid fa-star"></i> {{ $dp->rating }} ({{ $dp->total_deliveries }} deliveries)</span>
                @endif
            </h5>

            <div class="dp-meta">
                <span><i class="fa-solid fa-phone"></i> {{ $dp->phone }}</span>
                <span><i class="fa-solid fa-envelope"></i> {{ $dp->email }}</span>
                <span><i class="fa-solid fa-map-location-dot"></i> {{ $translatedVillage }}</span>
                <span><i class="fa-solid fa-id-badge"></i> {{ $dp->aadhar_number }}</span>
            </div>

            <div class="dp-vehicle">
                <div class="vh-item">
                    <strong>{{ $translatedVType }}</strong>
                    <span>{{ $strings['Vehicle Type'] }}</span>
                </div>
                <div class="vh-item">
                    <strong>{{ $dp->vehicle_number }}</strong>
                    <span>{{ $strings['Vehicle Number'] }}</span>
                </div>
                @if(!empty($dp->license_dl))
                <div class="vh-item">
                    <strong>{{ $dp->license_dl }}</strong>
                    <span>{{ $strings['Driving License'] }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="dp-actions">
            <button type="button" class="dp-btn view btn-view-dp" data-dp='@json($dp)'>
                <i class="fa-solid fa-eye"></i> {{ $strings['View'] }}
            </button>

            @if($dp->status == 'pending')
            <button type="button" class="dp-btn approve btn-status-dp" data-id="{{ $dp->id }}" data-status="active" data-name="{{ $translatedName }}">
                <i class="fa-solid fa-check"></i> {{ $strings['Approve'] }}
            </button>
            <button type="button" class="dp-btn reject btn-status-dp" data-id="{{ $dp->id }}" data-status="rejected" data-name="{{ $translatedName }}">
                <i class="fa-solid fa-ban"></i> {{ $strings['Reject'] }}
            </button>
            @else
            <button type="button" class="dp-btn approve btn-edit-dp" data-dp='@json($dp)'>
                <i class="fa-solid fa-pen-to-square"></i> {{ $strings['Edit'] }}
            </button>
            @endif

            <button type="button" class="dp-btn delete btn-delete-dp" data-id="{{ $dp->id }}" data-name="{{ $translatedName }}">
                <i class="fa-solid fa-trash"></i> {{ $strings['Delete'] }}
            </button>
        </div>
    </div>
    @endforeach
</div>

<!-- ============ ADD/EDIT DELIVERY PARTNER MODAL ============ -->
<div class="modal fade" id="dpModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" id="dpModalTitle"><i class="fa-solid fa-circle-plus me-2"></i> {{ $strings['Add Delivery Partner'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="dpForm" action="{{ url('/admin/delivery-partner/save') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="partner_id" id="dpId">
                <div class="modal-body" style="padding:25px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Full Name'] }} <span class="req">*</span></label>
                                <input type="text" name="name" id="dp_name" class="form-control-modal" placeholder="{{ $strings['Full name'] }}">
                                <span class="err-msg" id="err_dp_name"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Email'] }} <span class="req">*</span></label>
                                <input type="email" name="email" id="dp_email" class="form-control-modal" placeholder="{{ $strings['email@example.com'] }}">
                                <span class="err-msg" id="err_dp_email"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Phone'] }} <span class="req">*</span></label>
                                <input type="text" name="phone" id="dp_phone" class="form-control-modal" placeholder="{{ $strings['10-digit mobile'] }}" maxlength="10">
                                <span class="err-msg" id="err_dp_phone"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Aadhar Number'] }} <span class="req">*</span></label>
                                <input type="text" name="aadhar_number" id="dp_aadhar" class="form-control-modal" placeholder="{{ $strings['12-digit Aadhar'] }}" maxlength="12">
                                <span class="err-msg" id="err_dp_aadhar"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Vehicle Type'] }} <span class="req">*</span></label>
                                <select name="vehicle_type" id="dp_vtype" class="form-control-modal">
                                    <option value="">{{ $strings['-- Select --'] }}</option>
                                    <option value="Bike">{{ $strings['Bike / Motorcycle'] }}</option>
                                    <option value="Scooter">{{ $strings['Scooter'] }}</option>
                                    <option value="Bicycle">{{ $strings['Bicycle'] }}</option>
                                    <option value="Car">{{ $strings['Car'] }}</option>
                                    <option value="Auto">{{ $strings['Auto Rickshaw'] }}</option>
                                </select>
                                <span class="err-msg" id="err_dp_vtype"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Vehicle Number'] }} <span class="req">*</span></label>
                                <input type="text" name="vehicle_number" id="dp_vnum" class="form-control-modal" placeholder="{{ $strings['MH-01-AB-1234'] }}" style="text-transform:uppercase;">
                                <span class="err-msg" id="err_dp_vnum"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Driving License'] }}</label>
                                <input type="text" name="license_dl" id="dp_dl" class="form-control-modal" placeholder="{{ $strings['DL Number (optional)'] }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Village'] }} <span class="req">*</span></label>
                                <select name="village_id" id="dp_village" class="form-control-modal">
                                    <option value="">{{ $strings['-- Select Village --'] }}</option>
                                    @if(!empty($villages))
                                    @foreach($villages as $v)<option value="{{ $v->id }}">{{ GoogleTranslator::translate($v->name) }}</option>@endforeach
                                    @else
                                    <option value="1">Nashik</option>
                                    <option value="2">Pune</option>
                                    <option value="3">Mumbai</option>
                                    @endif
                                </select>
                                <span class="err-msg" id="err_dp_village"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Address'] }} <span class="req">*</span></label>
                                <textarea name="address" id="dp_address" class="form-control-modal" rows="2" placeholder="{{ $strings['Complete residential address'] }}"></textarea>
                                <span class="err-msg" id="err_dp_address"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Password'] }} <span class="req">*</span></label>
                                <input type="password" name="password" id="dp_password" class="form-control-modal" placeholder="{{ $strings['Min. 6 characters'] }}">
                                <span class="err-msg" id="err_dp_password"></span>
                                <small style="color:var(--gray-text);font-size:0.72rem;">{{ $strings['Leave blank when editing'] }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Status'] }}</label>
                                <select name="status" id="dp_status" class="form-control-modal">
                                    <option value="active">{{ $strings['Active'] }}</option>
                                    <option value="pending">{{ $strings['Pending'] }}</option>
                                    <option value="rejected">{{ $strings['Rejected'] }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="btn-primary-custom" data-bs-dismiss="modal" style="background:linear-gradient(135deg,#607D8B,#90A4AE);"><i class="fa-solid fa-xmark"></i> {{ $strings['Cancel'] }}</button>
                    <button type="submit" class="btn-primary-custom" id="saveDpBtn"><i class="fa-solid fa-floppy-disk"></i> {{ $strings['Save Partner'] }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============ VIEW MODAL ============ -->
<div class="modal fade" id="viewDpModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title"><i class="fa-solid fa-motorcycle me-2"></i> {{ $strings['Delivery Partner Details'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:25px;" id="viewDpContent"></div>
        </div>
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
            cancel: "{{ $strings['Cancel'] ?? 'Cancel' }}",
            saving: "{{ $strings['Saving...'] ?? 'Saving...' }}",
            addDpTitle: "{{ $strings['Add Delivery Partner'] ?? 'Add Delivery Partner' }}",
            editDpTitle: "{{ $strings['Edit Delivery Partner'] ?? 'Edit Delivery Partner' }}",
            nameReq: "{{ $strings['Name required'] ?? 'Name required' }}",
            minChars2: "{{ $strings['Min 2 characters'] ?? 'Min 2 characters' }}",
            emailReq: "{{ $strings['Email required'] ?? 'Email required' }}",
            emailInvalid: "{{ $strings['Invalid email'] ?? 'Invalid email' }}",
            phoneReq: "{{ $strings['Phone required'] ?? 'Phone required' }}",
            phoneInvalid: "{{ $strings['Must be 10 digits, starts 6-9'] ?? 'Must be 10 digits, starts 6-9' }}",
            aadharReq: "{{ $strings['Aadhar required'] ?? 'Aadhar required' }}",
            aadharInvalid: "{{ $strings['Must be 12 digits'] ?? 'Must be 12 digits' }}",
            vtypeReq: "{{ $strings['Select vehicle'] ?? 'Select vehicle' }}",
            vnumReq: "{{ $strings['Vehicle number required'] ?? 'Vehicle number required' }}",
            vnumFormat: "{{ $strings['Format: MH-01-AB-1234'] ?? 'Format: MH-01-AB-1234' }}",
            villageReq: "{{ $strings['Select village'] ?? 'Select village' }}",
            addressReq: "{{ $strings['Address required'] ?? 'Address required' }}",
            minChars10: "{{ $strings['Min 10 characters'] ?? 'Min 10 characters' }}",
            pwdReq: "{{ $strings['Password required'] ?? 'Password required' }}",
            approveConfirm: "{{ $strings['Are you sure you want to approve'] ?? 'Are you sure you want to approve' }}",
            rejectConfirm: "{{ $strings['Are you sure you want to reject'] ?? 'Are you sure you want to reject' }}",
            deleteConfirm: "{{ $strings['Are you sure you want to delete'] ?? 'Are you sure you want to delete' }}",
            yesDelete: "{{ $strings['Yes, Delete'] ?? 'Yes, Delete' }}",
            ok: "{{ $strings['OK'] ?? 'OK' }}"
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
                btnGroup.append(`<button type="button" class="alert-btn-cancel" data-bs-dismiss="modal">${jsStrings.cancel}</button>`);
                btnGroup.append(`<button type="button" class="alert-btn-confirm" id="customAlertConfirmBtn">${jsStrings.yesDelete}</button>`);

                $('#customAlertConfirmBtn').on('click', function() {
                    $('#customAlertModal').modal('hide');
                    if (onConfirm) onConfirm();
                });
            } else {
                btnGroup.append(`<button type="button" class="alert-btn-ok" data-bs-dismiss="modal">${jsStrings.ok}</button>`);
            }

            $('#customAlertModal').modal('show');
        }

        $('#addDpBtn').on('click', function() {
            $('#dpForm')[0].reset();
            $('#dpId').val('');
            $('#dpModalTitle').html('<i class="fa-solid fa-circle-plus me-2"></i> ' + jsStrings.addDpTitle);
            $('.err-msg').removeClass('show').text('');
            $('.form-control-modal').removeClass('error');
        });

        $('.btn-edit-dp').on('click', function() {
            var dp = $(this).data('dp');
            $('#dpId').val(dp.id);
            $('#dp_name').val(dp.name);
            $('#dp_email').val(dp.email);
            $('#dp_phone').val(dp.phone);
            $('#dp_aadhar').val(dp.aadhar_number);
            $('#dp_vtype').val(dp.vehicle_type);
            $('#dp_vnum').val(dp.vehicle_number);
            $('#dp_dl').val(dp.license_dl);
            $('#dp_village').val(dp.village_id || '');
            $('#dp_address').val(dp.address);
            $('#dp_status').val(dp.status);
            $('#dp_password').val('');
            $('#dpModalTitle').html('<i class="fa-solid fa-pen-to-square me-2"></i> ' + jsStrings.editDpTitle);
            $('.err-msg').removeClass('show').text('');
            $('.form-control-modal').removeClass('error');
            $('#dpModal').modal('show');
        });

        $('.btn-view-dp').on('click', function() {
            var dp = $(this).data('dp');

            // Translate dynamic modal fields
            var transName = "{{ GoogleTranslator::translate($dp->name) }}";
            var transVillage = "{{ GoogleTranslator::translate($dp->village->name ?? '') }}";
            var transAddress = "{{ GoogleTranslator::translate($dp->address) }}";

            var html = `
            <div class="row g-3">
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Full Name'] }}:</strong><br>${transName}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Email'] }}:</strong><br><a href="mailto:${dp.email}">${dp.email}</a></div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Phone'] }}:</strong><br><a href="tel:${dp.phone}">${dp.phone}</a></div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Aadhar Number'] }}:</strong><br>${dp.aadhar_number}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Vehicle Type'] }}:</strong><br>${dp.vehicle_type} - ${dp.vehicle_number}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Driving License'] }}:</strong><br>${dp.license_dl || 'N/A'}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Village'] }}:</strong><br>${transVillage}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Status'] }}:</strong><br><span class="st-tag ${dp.status}" style="padding:4px 12px;border-radius:15px;">${dp.status.toUpperCase()}</span></div>
                <div class="col-12"><strong style="color:var(--primary-green);">{{ $strings['Address'] }}:</strong><br>${transAddress}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">Rating:</strong><br>⭐ ${dp.rating || 0} / 5</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">Total Deliveries:</strong><br>${dp.total_deliveries || 0}</div>
            </div>
        `;
            $('#viewDpContent').html(html);
            $('#viewDpModal').modal('show');
        });

        $('.btn-status-dp').on('click', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');
            var name = $(this).data('name');
            var confirmMsg = status === 'active' ? jsStrings.approveConfirm : jsStrings.rejectConfirm;
            var alertType = status === 'active' ? 'success' : 'warning';

            showCustomAlert(
                alertType,
                status === 'active' ? 'Approve Partner?' : 'Reject Partner?',
                confirmMsg + ' <strong>"' + name + '"</strong>?',
                true,
                function() {
                    var $form = $('<form>', {
                        method: 'POST',
                        action: '{{ url("/admin/delivery-partner/status") }}/' + id
                    });
                    $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                    $form.append('<input type="hidden" name="status" value="' + status + '">');
                    $('body').append($form);
                    $form.submit();
                }
            );
        });

        $('.btn-delete-dp').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');

            showCustomAlert(
                'danger',
                'Delete Partner?',
                jsStrings.deleteConfirm + ' <strong>"' + name + '"</strong>?',
                true,
                function() {
                    var $form = $('<form>', {
                        method: 'POST',
                        action: '{{ url("/admin/delivery-partner/delete") }}/' + id
                    });
                    $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                    $form.append('<input type="hidden" name="_method" value="DELETE">');
                    $('body').append($form);
                    $form.submit();
                }
            );
        });

        function showFieldError($el, msg) {
            $el.addClass('error');
            $el.closest('.form-group-modal').find('.err-msg').text(msg).addClass('show');
        }

        function clearFieldError($el) {
            $el.removeClass('error');
            $el.closest('.form-group-modal').find('.err-msg').removeClass('show').text('');
        }

        $('#dp_phone, #dp_aadhar').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $('#dpForm').on('submit', function(e) {
            e.preventDefault();
            var isValid = true;
            $('.err-msg').removeClass('show').text('');
            $('.form-control-modal').removeClass('error');

            var name = $.trim($('#dp_name').val());
            if (name === '') {
                showFieldError($('#dp_name'), '⚠ ' + jsStrings.nameReq);
                isValid = false;
            } else if (name.length < 2) {
                showFieldError($('#dp_name'), '⚠ ' + jsStrings.minChars2);
                isValid = false;
            }

            var email = $.trim($('#dp_email').val());
            var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '') {
                showFieldError($('#dp_email'), '⚠ ' + jsStrings.emailReq);
                isValid = false;
            } else if (!emailRe.test(email)) {
                showFieldError($('#dp_email'), '⚠ ' + jsStrings.emailInvalid);
                isValid = false;
            }

            var phone = $.trim($('#dp_phone').val());
            if (phone === '') {
                showFieldError($('#dp_phone'), '⚠ ' + jsStrings.phoneReq);
                isValid = false;
            } else if (!/^[6-9]\d{9}$/.test(phone)) {
                showFieldError($('#dp_phone'), '⚠ ' + jsStrings.phoneInvalid);
                isValid = false;
            }

            var aadhar = $.trim($('#dp_aadhar').val());
            if (aadhar === '') {
                showFieldError($('#dp_aadhar'), '⚠ ' + jsStrings.aadharReq);
                isValid = false;
            } else if (!/^\d{12}$/.test(aadhar)) {
                showFieldError($('#dp_aadhar'), '⚠ ' + jsStrings.aadharInvalid);
                isValid = false;
            }

            if ($('#dp_vtype').val() === '') {
                showFieldError($('#dp_vtype'), '⚠ ' + jsStrings.vtypeReq);
                isValid = false;
            }

            var vnum = $.trim($('#dp_vnum').val()).toUpperCase();
            if (vnum === '') {
                showFieldError($('#dp_vnum'), '⚠ ' + jsStrings.vnumReq);
                isValid = false;
            } else if (!/^[A-Z]{2}[-\s]?\d{1,2}[-\s]?[A-Z]{1,3}[-\s]?\d{1,4}$/.test(vnum)) {
                showFieldError($('#dp_vnum'), '⚠ ' + jsStrings.vnumFormat);
                isValid = false;
            }

            if ($('#dp_village').val() === '') {
                showFieldError($('#dp_village'), '⚠ ' + jsStrings.villageReq);
                isValid = false;
            }

            var addr = $.trim($('#dp_address').val());
            if (addr === '') {
                showFieldError($('#dp_address'), '⚠ ' + jsStrings.addressReq);
                isValid = false;
            } else if (addr.length < 10) {
                showFieldError($('#dp_address'), '⚠ ' + jsStrings.minChars10);
                isValid = false;
            }

            var isEdit = $('#dpId').val() !== '';
            var pwd = $('#dp_password').val();
            if (!isEdit && pwd === '') {
                showFieldError($('#dp_password'), '⚠ ' + jsStrings.pwdReq);
                isValid = false;
            } else if (pwd && pwd.length < 6) {
                showFieldError($('#dp_password'), '⚠ ' + jsStrings.minChars10);
                isValid = false;
            }

            if (!isValid) return false;

            var $btn = $('#saveDpBtn');
            $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> ' + jsStrings.saving);
            this.submit();
        });

        $('.form-control-modal').on('input change', function() {
            if ($(this).hasClass('error') && $.trim($(this).val()) !== '') clearFieldError($(this));
        });

    });
</script>
@endsection