@extends('layouts.admin')

@section('title', 'Manage Pharmacies - Sanjivani Admin')
@section('page_title')
<i class="fas fa-store"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('Manage Pharmacies') }}
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
        cursor: pointer;
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

    /* Pharmacy Cards Row */
    .pharmacy-stat-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .pharmacy-stat {
        background: var(--white);
        border-radius: 14px;
        padding: 18px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 12px;
        transition: var(--transition);
    }

    .pharmacy-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.15);
    }

    .pharmacy-stat .ps-icon {
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

    .ps-icon.total {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .ps-icon.active {
        background: linear-gradient(135deg, #1565C0, #42A5F5);
    }

    .ps-icon.pending {
        background: linear-gradient(135deg, #E65100, #FFA726);
    }

    .ps-icon.rejected {
        background: linear-gradient(135deg, #C62828, #EF5350);
    }

    .ps-info .ps-val {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1;
    }

    .ps-info .ps-lbl {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    /* Pharmacy Card */
    .pharmacy-card {
        background: var(--white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        margin-bottom: 20px;
        border-left: 5px solid var(--primary-green);
    }

    .pharmacy-card.pending {
        border-left-color: #FB8C00;
    }

    .pharmacy-card.rejected {
        border-left-color: #E53935;
    }

    .pharmacy-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.15);
    }

    .pharmacy-card-body {
        padding: 20px;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 20px;
        align-items: center;
    }

    .pharmacy-icon {
        width: 65px;
        height: 65px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        flex-shrink: 0;
    }

    .pharmacy-info h5 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 5px;
    }

    .pharmacy-info h5 .status-tag {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-left: 8px;
        vertical-align: middle;
    }

    .status-tag.active {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .status-tag.pending {
        background: #FFF3E0;
        color: #FB8C00;
    }

    .status-tag.rejected {
        background: #FFEBEE;
        color: #C62828;
    }

    .pharmacy-info .p-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 8px;
    }

    .pharmacy-info .p-meta span {
        font-size: 0.8rem;
        color: var(--gray-text);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .pharmacy-info .p-meta span i {
        color: var(--primary-green);
    }

    .pharmacy-info .p-address {
        font-size: 0.82rem;
        color: var(--gray-text);
        margin-top: 6px;
    }

    .pharmacy-stats-inline {
        display: flex;
        gap: 20px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed #E0E0E0;
    }

    .pharmacy-stats-inline .stat {
        text-align: center;
    }

    .pharmacy-stats-inline .stat strong {
        display: block;
        font-size: 1.1rem;
        color: var(--primary-green);
        font-weight: 800;
    }

    .pharmacy-stats-inline .stat span {
        font-size: 0.7rem;
        color: var(--gray-text);
        text-transform: uppercase;
    }

    .pharmacy-actions {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 120px;
    }

    .p-action-btn {
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

    .p-action-btn.view {
        background: linear-gradient(135deg, #1976D2, #42A5F5);
    }

    .p-action-btn.approve {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .p-action-btn.reject {
        background: linear-gradient(135deg, #E65100, #FFA726);
    }

    .p-action-btn.delete {
        background: linear-gradient(135deg, #C62828, #EF5350);
    }

    .p-action-btn:hover {
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
        .pharmacy-stat-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .pharmacy-card-body {
            grid-template-columns: auto 1fr;
        }

        .pharmacy-actions {
            grid-column: 1 / -1;
            flex-direction: row;
            flex-wrap: wrap;
        }
    }

    @media (max-width: 576px) {
        .pharmacy-stat-row {
            grid-template-columns: 1fr 1fr;
        }

        .pharmacy-card-body {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .pharmacy-icon {
            margin: 0 auto;
        }

        .pharmacy-info .p-meta {
            justify-content: center;
        }

        .pharmacy-stats-inline {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

// Get the underlying items (Collection) from the paginator
$pharmaciesCollection = $pharmacies ?? collect();
if ($pharmaciesCollection instanceof \Illuminate\Pagination\LengthAwarePaginator) {
$pharmaciesCollection = $pharmaciesCollection->getCollection();
}

// If no pharmacies found, use the demo data (wrapped in a Collection)
if ($pharmaciesCollection->isEmpty()) {
$demoPharmacies = collect([
(object)['id'=>1,'pharmacy_name'=>'MediCare Pharmacy','owner_name'=>'Rajesh Kumar','email'=>'medicare@example.com','phone'=>'9876543210','license_number'=>'DL-MH-12345','address'=>'Shop No. 5, Market Road, Nashik','village'=>(object)['name'=>'Nashik'],'status'=>'active','total_medicines'=>145,'total_orders'=>428,'created_at'=>now()->subMonths(8)],
(object)['id'=>2,'pharmacy_name'=>'HealthPlus Pharmacy','owner_name'=>'Sunita Sharma','email'=>'healthplus@example.com','phone'=>'9812345678','license_number'=>'DL-MH-23456','address'=>'Near Bus Stand, Pune','village'=>(object)['name'=>'Pune'],'status'=>'active','total_medicines'=>210,'total_orders'=>892,'created_at'=>now()->subMonths(12)],
(object)['id'=>3,'pharmacy_name'=>'DiabetCare Store','owner_name'=>'Arjun Verma','email'=>'diabetcare@example.com','phone'=>'9998887771','license_number'=>'DL-RJ-34567','address'=>'MG Road, Jaipur','village'=>(object)['name'=>'Jaipur'],'status'=>'pending','total_medicines'=>0,'total_orders'=>0,'created_at'=>now()->subDays(3)],
(object)['id'=>4,'pharmacy_name'=>'Wellness Pharmacy','owner_name'=>'Priya Deshmukh','email'=>'wellness@example.com','phone'=>'9765432109','license_number'=>'DL-MH-45678','address'=>'Station Road, Aurangabad','village'=>(object)['name'=>'Aurangabad'],'status'=>'active','total_medicines'=>98,'total_orders'=>231,'created_at'=>now()->subMonths(4)],
(object)['id'=>5,'pharmacy_name'=>'City Pharmacy','owner_name'=>'Amit Kulkarni','email'=>'city@example.com','phone'=>'9871122334','license_number'=>'DL-MH-56789','address'=>'Central Plaza, Kolhapur','village'=>(object)['name'=>'Kolhapur'],'status'=>'rejected','total_medicines'=>0,'total_orders'=>0,'created_at'=>now()->subDays(15)],
(object)['id'=>6,'pharmacy_name'=>'Green Cross Pharmacy','owner_name'=>'Neha Joshi','email'=>'greencross@example.com','phone'=>'9822334455','license_number'=>'DL-MH-67890','address'=>'Ring Road, Nagpur','village'=>(object)['name'=>'Nagpur'],'status'=>'active','total_medicines'=>187,'total_orders'=>654,'created_at'=>now()->subMonths(6)],
]);
} else {
$demoPharmacies = $pharmaciesCollection;
}

$totalCount = $demoPharmacies->count();
$activeCount = $demoPharmacies->filter(fn($p) => $p->status == 'active')->count();
$pendingCount = $demoPharmacies->filter(fn($p) => $p->status == 'pending')->count();
$rejectedCount= $demoPharmacies->filter(fn($p) => $p->status == 'rejected')->count();

// GATHER ALL UI STRINGS AND TRANSLATE THEM SAFELY
$uiStrings = [
'Manage Pharmacies', 'Search', 'Pharmacy name, owner, license...', 'Status', 'All Status', 'Active', 'Pending', 'Rejected', 'Filter', 'Add Pharmacy',
'Total Pharmacies', 'Pending Approval', 'Medicines', 'Orders', 'Since', 'View', 'Approve', 'Reject', 'Edit', 'Delete',
'Add New Pharmacy', 'Edit Pharmacy', 'Pharmacy Details', 'Pharmacy Name', 'Owner Name', 'Email', 'Phone', 'License Number', 'Village',
'-- Select Village --', 'Full Address', 'Password', 'Leave blank when editing (unless changing)', 'Cancel', 'Save Pharmacy',
'e.g. MediCare Pharmacy', 'Full name of owner', 'pharmacy@example.com', '10-digit mobile', 'DL-XX-XXXXX', 'Complete pharmacy address', 'Min. 6 characters',
'Pharmacy name required', 'Min 3 characters', 'Owner name required', 'Email required', 'Invalid email format', 'Phone required', 'Must be 10 digits, starts 6-9',
'License number required', 'Invalid license number', 'Please select village', 'Address required', 'Min 10 characters', 'Password required', 'Saving...',
'Are you sure you want to approve', 'Are you sure you want to reject', 'Are you sure you want to delete'
];

// Translate the UI array safely (preventing timeouts)
$strings = [];
foreach($uiStrings as $str) {
$strings[$str] = GoogleTranslator::translate($str);
}
@endphp

<!-- Stats Row -->
<div class="pharmacy-stat-row" data-aos="fade-up">
    <div class="pharmacy-stat">
        <div class="ps-icon total"><i class="fas fa-store"></i></div>
        <div class="ps-info">
            <div class="ps-val">{{ $totalCount }}</div>
            <div class="ps-lbl">{{ $strings['Total Pharmacies'] }}</div>
        </div>
    </div>
    <div class="pharmacy-stat">
        <div class="ps-icon active"><i class="fas fa-check-circle"></i></div>
        <div class="ps-info">
            <div class="ps-val">{{ $activeCount }}</div>
            <div class="ps-lbl">{{ $strings['Active'] }}</div>
        </div>
    </div>
    <div class="pharmacy-stat">
        <div class="ps-icon pending"><i class="fas fa-clock"></i></div>
        <div class="ps-info">
            <div class="ps-val">{{ $pendingCount }}</div>
            <div class="ps-lbl">{{ $strings['Pending Approval'] }}</div>
        </div>
    </div>
    <div class="pharmacy-stat">
        <div class="ps-icon rejected"><i class="fas fa-times-circle"></i></div>
        <div class="ps-info">
            <div class="ps-val">{{ $rejectedCount }}</div>
            <div class="ps-lbl">{{ $strings['Rejected'] }}</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="filter-card" data-aos="fade-up">
    <form method="GET" action="{{ url('/admin/pharmacies') }}">
        <div class="row g-3 align-items-end">
            <div class="col-lg-5 col-md-6">
                <label style="font-size:0.78rem;font-weight:600;color:var(--dark-text);text-transform:uppercase;margin-bottom:6px;display:block;"><i class="fas fa-search me-1"></i> {{ $strings['Search'] }}</label>
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="filter-input" placeholder="{{ $strings['Pharmacy name, owner, license...'] }}" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <label style="font-size:0.78rem;font-weight:600;color:var(--dark-text);text-transform:uppercase;margin-bottom:6px;display:block;"><i class="fas fa-filter me-1"></i> {{ $strings['Status'] }}</label>
                <select name="status" class="filter-select">
                    <option value="">{{ $strings['All Status'] }}</option>
                    <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>{{ $strings['Active'] }}</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>{{ $strings['Pending'] }}</option>
                    <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>{{ $strings['Rejected'] }}</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <button type="submit" class="btn-primary-custom w-100 justify-content-center">
                    <i class="fas fa-filter"></i> {{ $strings['Filter'] }}
                </button>
            </div>
            <div class="col-lg-2 col-md-6">
                <button type="button" class="btn-primary-custom w-100 justify-content-center" data-bs-toggle="modal" data-bs-target="#pharmacyModal" id="addPharmacyBtn">
                    <i class="fas fa-plus"></i> {{ $strings['Add Pharmacy'] }}
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Pharmacy List -->
<div data-aos="fade-up">
    @foreach($demoPharmacies as $ph)
    @php
    // Translate dynamic database fields individually
    $translatedPhName = GoogleTranslator::translate($ph->pharmacy_name);
    $translatedOwner = GoogleTranslator::translate($ph->owner_name);
    $translatedVillage = GoogleTranslator::translate($ph->village->name ?? '');
    $translatedAddress = GoogleTranslator::translate($ph->address);
    $translatedStatus = $strings[ucfirst($ph->status)] ?? ucfirst($ph->status);
    @endphp
    <div class="pharmacy-card {{ $ph->status }}">
        <div class="pharmacy-card-body">
            <div class="pharmacy-icon">
                <i class="fas fa-store"></i>
            </div>

            <div class="pharmacy-info">
                <h5>
                    {{ $translatedPhName }}
                    <span class="status-tag {{ $ph->status }}">{{ $translatedStatus }}</span>
                </h5>

                <div class="p-meta">
                    <span><i class="fas fa-user"></i> {{ $translatedOwner }}</span>
                    <span><i class="fas fa-phone"></i> {{ $ph->phone }}</span>
                    <span><i class="fas fa-envelope"></i> {{ $ph->email }}</span>
                    <span><i class="fas fa-id-card"></i> {{ $ph->license_number }}</span>
                </div>

                <div class="p-address">
                    <i class="fas fa-map-marker-alt me-1" style="color:#E53935;"></i>
                    {{ $translatedAddress }}, {{ $translatedVillage }}
                </div>

                @if($ph->status == 'active')
                <div class="pharmacy-stats-inline">
                    <div class="stat">
                        <strong>{{ $ph->total_medicines }}</strong>
                        <span>{{ $strings['Medicines'] }}</span>
                    </div>
                    <div class="stat">
                        <strong>{{ $ph->total_orders }}</strong>
                        <span>{{ $strings['Orders'] }}</span>
                    </div>
                    <div class="stat">
                        <strong>{{ date('M Y', strtotime($ph->created_at)) }}</strong>
                        <span>{{ $strings['Since'] }}</span>
                    </div>
                </div>
                @endif
            </div>

            <div class="pharmacy-actions">
                <button type="button" class="p-action-btn view btn-view-pharmacy"
                    data-ph='@json($ph)'>
                    <i class="fas fa-eye"></i> {{ $strings['View'] }}
                </button>

                @if($ph->status == 'pending')
                <button type="button" class="p-action-btn approve btn-status-pharmacy"
                    data-id="{{ $ph->id }}" data-status="active" data-name="{{ $translatedPhName }}">
                    <i class="fas fa-check"></i> {{ $strings['Approve'] }}
                </button>
                <button type="button" class="p-action-btn reject btn-status-pharmacy"
                    data-id="{{ $ph->id }}" data-status="rejected" data-name="{{ $translatedPhName }}">
                    <i class="fas fa-ban"></i> {{ $strings['Reject'] }}
                </button>
                @else
                <button type="button" class="p-action-btn approve btn-edit-pharmacy" data-ph='@json($ph)'>
                    <i class="fas fa-edit"></i> {{ $strings['Edit'] }}
                </button>
                @endif

                <button type="button" class="p-action-btn delete btn-delete-pharmacy"
                    data-id="{{ $ph->id }}" data-name="{{ $translatedPhName }}">
                    <i class="fas fa-trash"></i> {{ $strings['Delete'] }}
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- ============ ADD/EDIT PHARMACY MODAL ============ -->
<div class="modal fade" id="pharmacyModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" id="phModalTitle"><i class="fas fa-plus-circle me-2"></i> {{ $strings['Add New Pharmacy'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="pharmacyForm" action="{{ url('/admin/pharmacy/save') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="pharmacy_id" id="phId">
                <div class="modal-body" style="padding:25px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Pharmacy Name'] }} <span class="req">*</span></label>
                                <input type="text" name="pharmacy_name" id="ph_name" class="form-control-modal" placeholder="{{ $strings['e.g. MediCare Pharmacy'] }}">
                                <span class="err-msg" id="err_ph_name"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Owner Name'] }} <span class="req">*</span></label>
                                <input type="text" name="owner_name" id="ph_owner" class="form-control-modal" placeholder="{{ $strings['Full name of owner'] }}">
                                <span class="err-msg" id="err_ph_owner"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Email'] }} <span class="req">*</span></label>
                                <input type="email" name="email" id="ph_email" class="form-control-modal" placeholder="{{ $strings['pharmacy@example.com'] }}">
                                <span class="err-msg" id="err_ph_email"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Phone'] }} <span class="req">*</span></label>
                                <input type="text" name="phone" id="ph_phone" class="form-control-modal" placeholder="{{ $strings['10-digit mobile'] }}" maxlength="10">
                                <span class="err-msg" id="err_ph_phone"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['License Number'] }} <span class="req">*</span></label>
                                <input type="text" name="license_number" id="ph_license" class="form-control-modal" placeholder="{{ $strings['DL-XX-XXXXX'] }}">
                                <span class="err-msg" id="err_ph_license"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Village'] }} <span class="req">*</span></label>
                                <select name="village_id" id="ph_village" class="form-control-modal">
                                    <option value="">{{ $strings['-- Select Village --'] }}</option>
                                    @if(!empty($villages))
                                    @foreach($villages as $v)
                                    <option value="{{ $v->id }}">{{ GoogleTranslator::translate($v->name) }}</option>
                                    @endforeach
                                    @else
                                    <option value="1">Nashik</option>
                                    <option value="2">Pune</option>
                                    <option value="3">Mumbai</option>
                                    <option value="4">Aurangabad</option>
                                    @endif
                                </select>
                                <span class="err-msg" id="err_ph_village"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Full Address'] }} <span class="req">*</span></label>
                                <textarea name="address" id="ph_address" class="form-control-modal" rows="2" placeholder="{{ $strings['Complete pharmacy address'] }}"></textarea>
                                <span class="err-msg" id="err_ph_address"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Password'] }} <span class="req">*</span></label>
                                <input type="password" name="password" id="ph_password" class="form-control-modal" placeholder="{{ $strings['Min. 6 characters'] }}">
                                <span class="err-msg" id="err_ph_password"></span>
                                <small style="color:var(--gray-text);font-size:0.72rem;">{{ $strings['Leave blank when editing (unless changing)'] }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modal">
                                <label class="form-label-modal">{{ $strings['Status'] }}</label>
                                <select name="status" id="ph_status" class="form-control-modal">
                                    <option value="active">{{ $strings['Active'] }}</option>
                                    <option value="pending">{{ $strings['Pending'] }}</option>
                                    <option value="rejected">{{ $strings['Rejected'] }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="btn-primary-custom" data-bs-dismiss="modal" style="background:linear-gradient(135deg,#607D8B,#90A4AE);">
                        <i class="fas fa-times"></i> {{ $strings['Cancel'] }}
                    </button>
                    <button type="submit" class="btn-primary-custom" id="savePhBtn">
                        <i class="fas fa-save"></i> {{ $strings['Save Pharmacy'] }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============ VIEW PHARMACY MODAL ============ -->
<div class="modal fade" id="viewPharmacyModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title"><i class="fas fa-store me-2"></i> {{ $strings['Pharmacy Details'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:25px;" id="viewPhContent">
                <!-- filled by jQuery -->
            </div>
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
            phNameReq: "{{ $strings['Pharmacy name required'] ?? 'Pharmacy name required' }}",
            minChars3: "{{ $strings['Min 3 characters'] ?? 'Min 3 characters' }}",
            ownerReq: "{{ $strings['Owner name required'] ?? 'Owner name required' }}",
            emailReq: "{{ $strings['Email required'] ?? 'Email required' }}",
            emailInvalid: "{{ $strings['Invalid email format'] ?? 'Invalid email format' }}",
            phoneReq: "{{ $strings['Phone required'] ?? 'Phone required' }}",
            phoneInvalid: "{{ $strings['Must be 10 digits, starts 6-9'] ?? 'Must be 10 digits, starts 6-9' }}",
            licenseReq: "{{ $strings['License number required'] ?? 'License number required' }}",
            licenseInvalid: "{{ $strings['Invalid license number'] ?? 'Invalid license number' }}",
            villageReq: "{{ $strings['Please select village'] ?? 'Please select village' }}",
            addressReq: "{{ $strings['Address required'] ?? 'Address required' }}",
            minChars10: "{{ $strings['Min 10 characters'] ?? 'Min 10 characters' }}",
            pwdReq: "{{ $strings['Password required'] ?? 'Password required' }}",
            approveConfirm: "{{ $strings['Are you sure you want to approve'] ?? 'Are you sure you want to approve' }}",
            rejectConfirm: "{{ $strings['Are you sure you want to reject'] ?? 'Are you sure you want to reject' }}",
            deleteConfirm: "{{ $strings['Are you sure you want to delete'] ?? 'Are you sure you want to delete' }}",
            addPhTitle: "{{ $strings['Add New Pharmacy'] ?? 'Add New Pharmacy' }}",
            editPhTitle: "{{ $strings['Edit Pharmacy'] ?? 'Edit Pharmacy' }}",
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
                // Re-label the confirm button to "Yes" or "Continue" depending on action, but "Yes, Delete" works well universally here
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

        /* ============ RESET FORM ON ADD ============ */
        $('#addPharmacyBtn').on('click', function() {
            $('#pharmacyForm')[0].reset();
            $('#phId').val('');
            $('#phModalTitle').html('<i class="fas fa-plus-circle me-2"></i> ' + jsStrings.addPhTitle);
            $('.err-msg').removeClass('show').text('');
            $('.form-control-modal').removeClass('error');
        });

        /* ============ EDIT PHARMACY ============ */
        $('.btn-edit-pharmacy').on('click', function() {
            var ph = $(this).data('ph');
            $('#phId').val(ph.id);
            $('#ph_name').val(ph.pharmacy_name);
            $('#ph_owner').val(ph.owner_name);
            $('#ph_email').val(ph.email);
            $('#ph_phone').val(ph.phone);
            $('#ph_license').val(ph.license_number);
            $('#ph_village').val(ph.village_id || '');
            $('#ph_address').val(ph.address);
            $('#ph_status').val(ph.status);
            $('#ph_password').val('');
            $('#phModalTitle').html('<i class="fas fa-edit me-2"></i> ' + jsStrings.editPhTitle);
            $('.err-msg').removeClass('show').text('');
            $('.form-control-modal').removeClass('error');
            $('#pharmacyModal').modal('show');
        });

        /* ============ VIEW PHARMACY ============ */
        $('.btn-view-pharmacy').on('click', function() {
            var ph = $(this).data('ph');

            // Using the backend translated labels for the modal
            var html = `
            <div class="row g-3">
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Pharmacy Name'] }}:</strong><br>${ph.pharmacy_name}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Owner Name'] }}:</strong><br>${ph.owner_name}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Email'] }}:</strong><br><a href="mailto:${ph.email}">${ph.email}</a></div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Phone'] }}:</strong><br><a href="tel:${ph.phone}">${ph.phone}</a></div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['License Number'] }}:</strong><br>${ph.license_number}</div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">{{ $strings['Village'] }}:</strong><br>${ph.village ? ph.village.name : 'N/A'}</div>
                <div class="col-12"><strong style="color:var(--primary-green);">{{ $strings['Full Address'] }}:</strong><br>${ph.address}</div>
                <div class="col-md-4"><strong style="color:var(--primary-green);">{{ $strings['Status'] }}:</strong><br><span class="status-tag ${ph.status}" style="padding:4px 12px;border-radius:15px;">${ph.status.toUpperCase()}</span></div>
                <div class="col-md-4"><strong style="color:var(--primary-green);">{{ $strings['Medicines'] }}:</strong><br>${ph.total_medicines}</div>
                <div class="col-md-4"><strong style="color:var(--primary-green);">{{ $strings['Orders'] }}:</strong><br>${ph.total_orders}</div>
            </div>
        `;
            $('#viewPhContent').html(html);
            $('#viewPharmacyModal').modal('show');
        });

        /* ============ APPROVE/REJECT PHARMACY ============ */
        $('.btn-status-pharmacy').on('click', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');
            var name = $(this).data('name');
            var confirmMsg = status === 'active' ? jsStrings.approveConfirm : jsStrings.rejectConfirm;
            var alertType = status === 'active' ? 'success' : 'warning';

            showCustomAlert(
                alertType,
                status === 'active' ? 'Approve Pharmacy?' : 'Reject Pharmacy?',
                confirmMsg + ' <strong>"' + name + '"</strong>?',
                true,
                function() {
                    var $form = $('<form>', {
                        method: 'POST',
                        action: '{{ url("/admin/pharmacy/status") }}/' + id
                    });
                    $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                    $form.append('<input type="hidden" name="status" value="' + status + '">');
                    $('body').append($form);
                    $form.submit();
                }
            );
        });

        /* ============ DELETE PHARMACY ============ */
        $('.btn-delete-pharmacy').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');

            showCustomAlert(
                'danger',
                'Delete Pharmacy?',
                jsStrings.deleteConfirm + ' <strong>"' + name + '"</strong>?<br>All associated medicines and orders will also be affected.',
                true,
                function() {
                    var $form = $('<form>', {
                        method: 'POST',
                        action: '{{ url("/admin/pharmacy/delete") }}/' + id
                    });
                    $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                    $form.append('<input type="hidden" name="_method" value="DELETE">');
                    $('body').append($form);
                    $form.submit();
                }
            );
        });

        /* ============ FORM VALIDATION ============ */
        function showFieldError($el, msg) {
            $el.addClass('error');
            $el.closest('.form-group-modal').find('.err-msg').text(msg).addClass('show');
        }

        function clearFieldError($el) {
            $el.removeClass('error');
            $el.closest('.form-group-modal').find('.err-msg').removeClass('show').text('');
        }

        // Digits only for phone
        $('#ph_phone').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $('#pharmacyForm').on('submit', function(e) {
            e.preventDefault();

            var isValid = true;
            $('.err-msg').removeClass('show').text('');
            $('.form-control-modal').removeClass('error');

            // Pharmacy Name
            var name = $.trim($('#ph_name').val());
            if (name === '') {
                showFieldError($('#ph_name'), '⚠ ' + jsStrings.phNameReq);
                isValid = false;
            } else if (name.length < 3) {
                showFieldError($('#ph_name'), '⚠ ' + jsStrings.minChars3);
                isValid = false;
            }

            // Owner
            if ($.trim($('#ph_owner').val()) === '') {
                showFieldError($('#ph_owner'), '⚠ ' + jsStrings.ownerReq);
                isValid = false;
            }

            // Email
            var email = $.trim($('#ph_email').val());
            var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '') {
                showFieldError($('#ph_email'), '⚠ ' + jsStrings.emailReq);
                isValid = false;
            } else if (!emailRe.test(email)) {
                showFieldError($('#ph_email'), '⚠ ' + jsStrings.emailInvalid);
                isValid = false;
            }

            // Phone
            var phone = $.trim($('#ph_phone').val());
            if (phone === '') {
                showFieldError($('#ph_phone'), '⚠ ' + jsStrings.phoneReq);
                isValid = false;
            } else if (!/^[6-9]\d{9}$/.test(phone)) {
                showFieldError($('#ph_phone'), '⚠ ' + jsStrings.phoneInvalid);
                isValid = false;
            }

            // License
            var license = $.trim($('#ph_license').val());
            if (license === '') {
                showFieldError($('#ph_license'), '⚠ ' + jsStrings.licenseReq);
                isValid = false;
            } else if (license.length < 5) {
                showFieldError($('#ph_license'), '⚠ ' + jsStrings.licenseInvalid);
                isValid = false;
            }

            // Village
            if ($('#ph_village').val() === '') {
                showFieldError($('#ph_village'), '⚠ ' + jsStrings.villageReq);
                isValid = false;
            }

            // Address
            var addr = $.trim($('#ph_address').val());
            if (addr === '') {
                showFieldError($('#ph_address'), '⚠ ' + jsStrings.addressReq);
                isValid = false;
            } else if (addr.length < 10) {
                showFieldError($('#ph_address'), '⚠ ' + jsStrings.minChars10);
                isValid = false;
            }

            // Password - only required when adding (id empty)
            var isEdit = $('#phId').val() !== '';
            var pwd = $('#ph_password').val();
            if (!isEdit && pwd === '') {
                showFieldError($('#ph_password'), '⚠ ' + jsStrings.pwdReq);
                isValid = false;
            } else if (pwd && pwd.length < 6) {
                showFieldError($('#ph_password'), '⚠ ' + jsStrings.minChars10); // Fallback to general min chars if no specific string
                isValid = false;
            }

            if (!isValid) return false;

            var $btn = $('#savePhBtn');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.saving);
            this.submit();
        });

        $('.form-control-modal').on('input change', function() {
            if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
                clearFieldError($(this));
            }
        });

    });
</script>
@endsection