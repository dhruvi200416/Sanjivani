@extends('layouts.admin')

@section('title', 'Manage Orders - Sanjivani Admin')
@section('page_title')
<i class="fas fa-shopping-cart"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('Manage Orders') }}
@endsection

@section('styles')
<style>
    /* Stats Row */
    .order-stat {
        background: var(--white);
        border-radius: 16px;
        padding: 18px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: var(--transition);
        cursor: pointer;
        border: 2px solid transparent;
    }

    .order-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.15);
    }

    .order-stat.active {
        border-color: var(--primary-green);
        background: var(--pale-green);
    }

    .order-stat .os-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        color: var(--white);
    }

    .os-icon.total {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .os-icon.pending {
        background: linear-gradient(135deg, #E65100, #FFA726);
    }

    .os-icon.progress {
        background: linear-gradient(135deg, #1565C0, #42A5F5);
    }

    .os-icon.delivered {
        background: linear-gradient(135deg, #6A1B9A, #AB47BC);
    }

    .os-icon.cancelled {
        background: linear-gradient(135deg, #B71C1C, #EF5350);
    }

    .order-stat .os-info {
        flex: 1;
    }

    .order-stat .os-value {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1;
        margin-bottom: 3px;
    }

    .order-stat .os-label {
        font-size: 0.78rem;
        color: var(--gray-text);
        font-weight: 500;
    }

    /* Filter Card */
    .filter-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
    }

    .filter-card .form-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
        background: var(--white);
    }

    .filter-input:focus,
    .filter-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .filter-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 35px;
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

    .btn-filter {
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
        width: 100%;
        justify-content: center;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
    }

    .btn-reset {
        background: var(--white);
        color: var(--gray-text);
        border: 2px solid #E0E0E0;
        padding: 8px 22px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: 100%;
        justify-content: center;
    }

    .btn-reset:hover {
        background: var(--pale-green);
        color: var(--primary-green);
        border-color: var(--primary-green);
    }

    /* Orders Table Card */
    .orders-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .orders-header {
        padding: 18px 25px;
        border-bottom: 1px solid #EEE;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .orders-header h6 {
        font-weight: 700;
        color: var(--dark-text);
        margin: 0;
    }

    .orders-header h6 span {
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.75rem;
        margin-left: 8px;
    }

    .export-btn {
        background: transparent;
        color: var(--primary-green);
        border: 2px solid var(--primary-green);
        padding: 7px 18px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .export-btn:hover {
        background: var(--primary-green);
        color: var(--white);
    }

    .orders-table {
        width: 100%;
        margin: 0;
    }

    .orders-table thead th {
        background: var(--off-white);
        color: var(--gray-text);
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 20px;
        border-top: none;
        border-bottom: 1px solid #E0E0E0;
        white-space: nowrap;
    }

    .orders-table tbody td {
        padding: 15px 20px;
        font-size: 0.87rem;
        color: var(--dark-text);
        vertical-align: middle;
        border-bottom: 1px solid #F5F5F5;
    }

    .orders-table tbody tr {
        transition: var(--transition);
    }

    .orders-table tbody tr:hover {
        background: var(--off-white);
    }

    .orders-table tbody tr:last-child td {
        border-bottom: none;
    }

    .order-id-link {
        font-weight: 700;
        color: var(--primary-green);
        text-decoration: none;
        transition: var(--transition);
    }

    .order-id-link:hover {
        color: var(--dark-green);
        text-decoration: underline;
    }

    .customer-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .customer-avatar-sm {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .customer-cell .cname {
        font-weight: 600;
        font-size: 0.87rem;
        color: var(--dark-text);
        display: block;
        line-height: 1.3;
    }

    .customer-cell .cphone {
        font-size: 0.74rem;
        color: var(--gray-text);
    }

    .items-badge {
        display: inline-block;
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .order-price {
        font-weight: 700;
        color: var(--dark-text);
        font-size: 0.92rem;
    }

    .payment-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .payment-cod {
        background: #FFF3E0;
        color: #E65100;
    }

    .payment-online {
        background: #E3F2FD;
        color: #1565C0;
    }

    .payment-upi {
        background: #F3E5F5;
        color: #6A1B9A;
    }

    .status-badge-tbl {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .st-pending {
        background: #FFF3E0;
        color: #FB8C00;
    }

    .st-confirmed {
        background: #E3F2FD;
        color: #1976D2;
    }

    .st-processing {
        background: #F3E5F5;
        color: #7B1FA2;
    }

    .st-out_for_delivery {
        background: #FCE4EC;
        color: #C2185B;
    }

    .st-delivered {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .st-cancelled {
        background: #FFEBEE;
        color: #C62828;
    }

    .action-btns {
        display: flex;
        gap: 6px;
    }

    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        border: none;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.8rem;
        text-decoration: none;
    }

    .btn-action.view {
        background: linear-gradient(135deg, #1565C0, #42A5F5);
    }

    .btn-action.edit {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .btn-action.delete {
        background: linear-gradient(135deg, #C62828, #EF5350);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        color: var(--white);
    }

    /* Pagination */
    .pagination-wrap {
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        border-top: 1px solid #EEE;
    }

    .pagination-info {
        color: var(--gray-text);
        font-size: 0.85rem;
    }

    .pagination-custom {
        display: flex;
        gap: 5px;
        margin: 0;
    }

    .pagination-custom .page-btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: var(--white);
        border: 1px solid #E0E0E0;
        color: var(--dark-text);
        font-size: 0.85rem;
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
    }

    .pagination-custom .page-btn:hover {
        background: var(--pale-green);
        border-color: var(--primary-green);
        color: var(--primary-green);
    }

    .pagination-custom .page-btn.active {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        border-color: var(--primary-green);
        color: var(--white);
    }

    .pagination-custom .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Modals & Popups */
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

    .modal-header-custom .modal-title {
        font-weight: 700;
    }

    .modal-header-custom .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-body-custom {
        padding: 25px;
    }

    .status-option {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: var(--transition);
    }

    .status-option:hover {
        border-color: var(--primary-green);
        background: var(--off-white);
    }

    .status-option.selected {
        border-color: var(--primary-green);
        background: var(--pale-green);
    }

    .status-option input[type="radio"] {
        accent-color: var(--primary-green);
        cursor: pointer;
    }

    .status-option .st-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
    }

    .status-option .st-text strong {
        display: block;
        font-size: 0.9rem;
        color: var(--dark-text);
    }

    .status-option .st-text span {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    /* Custom Alert Popup */
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

    @media (max-width: 767px) {
        .orders-table thead {
            display: none;
        }

        .orders-table tbody td {
            padding: 10px 15px;
            font-size: 0.85rem;
        }
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

$strings = GoogleTranslator::translateBatch([
'stat_total' => 'Total Orders', 'stat_pending' => 'Pending', 'stat_processing' => 'Processing', 'stat_delivered' => 'Delivered', 'stat_cancelled' => 'Cancelled',
'filter_search' => 'Search', 'search_placeholder' => 'Order ID, customer name, phone...', 'filter_status' => 'Status', 'filter_all_status' => 'All Status',
'filter_payment' => 'Payment', 'filter_all_payments' => 'All Payments', 'pay_cod' => 'Cash on Delivery', 'pay_online' => 'Online', 'pay_upi' => 'UPI',
'filter_from' => 'From', 'filter_to' => 'To', 'btn_reset' => 'Reset', 'btn_apply' => 'Apply Filters',
'table_all_orders' => 'All Orders', 'btn_export' => 'Export CSV', 'th_order_id' => 'Order ID', 'th_customer' => 'Customer', 'th_village' => 'Village',
'th_items' => 'Items', 'th_total' => 'Total', 'th_payment' => 'Payment', 'th_status' => 'Status', 'th_date' => 'Date', 'th_action' => 'Action',
'lbl_items' => 'items', 'pg_showing' => 'Showing', 'pg_to' => 'to', 'pg_of' => 'of', 'pg_orders' => 'orders',
'modal_title' => 'Update Order Status', 'modal_desc' => 'Update status for order', 'st_pending_title' => 'Pending', 'st_pending_desc' => 'Order received, awaiting confirmation',
'st_confirmed_title' => 'Confirmed', 'st_confirmed_desc' => 'Order confirmed by pharmacy', 'st_processing_title' => 'Processing', 'st_processing_desc' => 'Being prepared for shipment',
'st_out_title' => 'Out for Delivery', 'st_out_desc' => 'Assigned to delivery partner', 'st_delivered_title' => 'Delivered', 'st_delivered_desc' => 'Successfully delivered to customer',
'st_cancelled_title' => 'Cancelled', 'st_cancelled_desc' => 'Order was cancelled', 'btn_cancel' => 'Cancel', 'btn_update' => 'Update Status',
'err_select_status' => '⚠ Please select a status.', 'js_del_confirm' => 'Are you sure you want to delete order :num? This action cannot be undone.',
'js_date_err_1' => '"To Date" cannot be earlier than "From Date".', 'js_date_err_2' => '"From Date" cannot be later than "To Date".', 'js_updating' => 'Updating...'
]);
@endphp

<!-- ============ ORDER STATS ============ -->
<div class="row g-3 mb-4">
    <div class="col-lg col-md-4 col-6" data-aos="fade-up" data-aos-delay="0">
        <div class="order-stat {{ !request('status') ? 'active' : '' }}" data-status="">
            <div class="os-icon total"><i class="fas fa-list"></i></div>
            <div class="os-info">
                <div class="os-value">{{ $totalOrders ?? 128 }}</div>
                <div class="os-label">{{ $strings['stat_total'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-6" data-aos="fade-up" data-aos-delay="80">
        <div class="order-stat {{ request('status')=='pending' ? 'active' : '' }}" data-status="pending">
            <div class="os-icon pending"><i class="fas fa-clock"></i></div>
            <div class="os-info">
                <div class="os-value">{{ $pendingCount ?? 12 }}</div>
                <div class="os-label">{{ $strings['stat_pending'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-6" data-aos="fade-up" data-aos-delay="160">
        <div class="order-stat {{ request('status')=='processing' ? 'active' : '' }}" data-status="processing">
            <div class="os-icon progress"><i class="fas fa-cogs"></i></div>
            <div class="os-info">
                <div class="os-value">{{ $processingCount ?? 8 }}</div>
                <div class="os-label">{{ $strings['stat_processing'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-6" data-aos="fade-up" data-aos-delay="240">
        <div class="order-stat {{ request('status')=='delivered' ? 'active' : '' }}" data-status="delivered">
            <div class="os-icon delivered"><i class="fas fa-check-circle"></i></div>
            <div class="os-info">
                <div class="os-value">{{ $deliveredCount ?? 98 }}</div>
                <div class="os-label">{{ $strings['stat_delivered'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-6" data-aos="fade-up" data-aos-delay="320">
        <div class="order-stat {{ request('status')=='cancelled' ? 'active' : '' }}" data-status="cancelled">
            <div class="os-icon cancelled"><i class="fas fa-times-circle"></i></div>
            <div class="os-info">
                <div class="os-value">{{ $cancelledCount ?? 10 }}</div>
                <div class="os-label">{{ $strings['stat_cancelled'] }}</div>
            </div>
        </div>
    </div>
</div>

<!-- ============ FILTERS ============ -->
<div class="filter-card" data-aos="fade-up">
    <form id="filterForm" method="GET" action="{{ url('/admin/orders') }}">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4 col-md-6">
                <label class="form-label"><i class="fas fa-search me-1"></i> {{ $strings['filter_search'] }}</label>
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="filter-input" placeholder="{{ $strings['search_placeholder'] }}" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label"><i class="fas fa-filter me-1"></i> {{ $strings['filter_status'] }}</label>
                <select name="status" id="statusFilter" class="filter-select">
                    <option value="">{{ $strings['filter_all_status'] }}</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>{{ $strings['stat_pending'] }}</option>
                    <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>{{ $strings['st_confirmed_title'] }}</option>
                    <option value="processing" {{ request('status')=='processing' ? 'selected' : '' }}>{{ $strings['stat_processing'] }}</option>
                    <option value="out_for_delivery" {{ request('status')=='out_for_delivery' ? 'selected' : '' }}>{{ $strings['st_out_title'] }}</option>
                    <option value="delivered" {{ request('status')=='delivered' ? 'selected' : '' }}>{{ $strings['stat_delivered'] }}</option>
                    <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>{{ $strings['stat_cancelled'] }}</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label"><i class="fas fa-money-check me-1"></i> {{ $strings['filter_payment'] }}</label>
                <select name="payment" class="filter-select">
                    <option value="">{{ $strings['filter_all_payments'] }}</option>
                    <option value="cod" {{ request('payment')=='cod' ? 'selected' : '' }}>{{ $strings['pay_cod'] }}</option>
                    <option value="online" {{ request('payment')=='online' ? 'selected' : '' }}>{{ $strings['pay_online'] }}</option>
                    <option value="upi" {{ request('payment')=='upi' ? 'selected' : '' }}>{{ $strings['pay_upi'] }}</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label"><i class="fas fa-calendar me-1"></i> {{ $strings['filter_from'] }}</label>
                <input type="date" name="from_date" class="filter-input" value="{{ request('from_date') }}">
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label"><i class="fas fa-calendar-check me-1"></i> {{ $strings['filter_to'] }}</label>
                <input type="date" name="to_date" class="filter-input" value="{{ request('to_date') }}">
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-2 offset-md-8">
                <a href="{{ url('/admin/orders') }}" class="btn-reset"><i class="fas fa-undo"></i> {{ $strings['btn_reset'] }}</a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> {{ $strings['btn_apply'] }}</button>
            </div>
        </div>
    </form>
</div>

<!-- ============ ORDERS TABLE ============ -->
<div class="orders-card" data-aos="fade-up">
    <div class="orders-header">
        <h6>
            <i class="fas fa-shopping-cart me-2" style="color:var(--primary-green);"></i>
            {{ $strings['table_all_orders'] }}
            <span>{{ isset($orders) ? (method_exists($orders,'total') ? $orders->total() : count($orders)) : 128 }}</span>
        </h6>
        <a href="{{ url('/admin/orders/export?'.http_build_query(request()->all())) }}" class="export-btn">
            <i class="fas fa-file-excel me-1"></i> {{ $strings['btn_export'] }}
        </a>
    </div>

    <div class="table-responsive">
        <table class="orders-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll" style="accent-color:var(--primary-green);"></th>
                    <th>{{ $strings['th_order_id'] }}</th>
                    <th>{{ $strings['th_customer'] }}</th>
                    <th>{{ $strings['th_village'] }}</th>
                    <th>{{ $strings['th_items'] }}</th>
                    <th>{{ $strings['th_total'] }}</th>
                    <th>{{ $strings['th_payment'] }}</th>
                    <th>{{ $strings['th_status'] }}</th>
                    <th>{{ $strings['th_date'] }}</th>
                    <th>{{ $strings['th_action'] }}</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($orders) && count($orders) > 0)
                @foreach($orders as $order)
                <tr>
                    <td><input type="checkbox" class="row-check" value="{{ $order->id }}" style="accent-color:var(--primary-green);"></td>
                    <td>
                        <a href="{{ url('/admin/order/'.$order->id) }}" class="order-id-link">
                            #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td>
                        <div class="customer-cell">
                            <div class="customer-avatar-sm">{{ strtoupper(substr($order->customer->name ?? 'C', 0, 1)) }}</div>
                            <div>
                                <span class="cname">{{ GoogleTranslator::translate($order->customer->name ?? 'Unknown') }}</span>
                                <span class="cphone"><i class="fas fa-phone me-1"></i>{{ $order->customer->phone ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-size:0.85rem;">
                            <i class="fas fa-map-marker-alt me-1" style="color:#E53935;font-size:0.75rem;"></i>
                            {{ GoogleTranslator::translate($order->customer->village->name ?? 'N/A') }}
                        </span>
                    </td>
                    <td>
                        {{-- Laravel automatically appends _count to the relationship name --}}
                        <span class="items-badge">{{ $order->order_items_count ?? 0 }} {{ $strings['lbl_items'] }}</span>
                    </td>
                    <td class="order-price">₹{{ number_format($order->total_amount ?? 0, 2) }}</td>
                    <td>
                        @php
                        $pay = strtolower($order->payment_method ?? 'cod');
                        $payClass = 'payment-'.$pay;
                        if(!in_array($pay, ['cod','online','upi'])) $payClass = 'payment-cod';
                        @endphp
                        <span class="payment-badge {{ $payClass }}">{{ strtoupper($order->payment_method ?? 'COD') }}</span>
                    </td>
                    <td>
                        @php
                        $status = strtolower(str_replace(' ', '_', $order->order_status ?? 'pending'));
                        $stClass = 'st-'.$status;
                        if(!in_array($status, ['pending','confirmed','processing','out_for_delivery','delivered','cancelled'])) $stClass = 'st-pending';
                        $displayStatus = ucfirst(str_replace('_', ' ', $order->order_status ?? 'pending'));
                        $translatedStatus = $strings['stat_' . ($status == 'out_for_delivery' ? 'out' : $status)] ?? $strings['st_out_title'] ?? $displayStatus;
                        @endphp
                        <span class="status-badge-tbl {{ $stClass }}">{{ $translatedStatus }}</span>
                    </td>
                    <td>
                        <div style="font-size:0.82rem;">{{ date('d M Y', strtotime($order->created_at ?? now())) }}</div>
                        <div style="font-size:0.72rem;color:var(--gray-text);">{{ date('h:i A', strtotime($order->created_at ?? now())) }}</div>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ url('/admin/order/'.$order->id) }}" class="btn-action view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="btn-action edit btn-update-status"
                                data-order-id="{{ $order->id }}"
                                data-order-num="#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}"
                                data-current-status="{{ $order->order_status ?? 'pending' }}"
                                title="Update Status">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn-action delete btn-delete-order"
                                data-order-id="{{ $order->id }}"
                                data-order-num="#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}"
                                title="Delete Order">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="10" class="text-center py-5 text-muted">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: #E0E0E0; margin-bottom: 15px; display: block;"></i>
                        No orders found.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrap">
        <div class="pagination-info">
            {{ $strings['pg_showing'] }} <strong>{{ $orders->firstItem() ?? 0 }} {{ $strings['pg_to'] }} {{ $orders->lastItem() ?? 0 }}</strong> {{ $strings['pg_of'] }} <strong>{{ $orders->total() ?? 0 }}</strong> {{ $strings['pg_orders'] }}
        </div>
        @if(isset($orders) && method_exists($orders, 'links'))
        <div>{{ $orders->appends(request()->all())->links() }}</div>
        @endif
    </div>
</div>

<!-- ============ STATUS UPDATE MODAL ============ -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> {{ $strings['modal_title'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusUpdateForm" action="{{ url('/admin/order/update-status') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" id="modalOrderId">
                <div class="modal-body modal-body-custom">
                    <p class="mb-3 text-muted">{{ $strings['modal_desc'] }} <strong id="modalOrderNum" style="color:var(--primary-green);"></strong></p>

                    <div class="status-option" data-status="pending">
                        <input type="radio" name="status" value="pending">
                        <div class="st-icon" style="background:#FB8C00;"><i class="fas fa-clock"></i></div>
                        <div class="st-text"><strong>{{ $strings['st_pending_title'] }}</strong><span>{{ $strings['st_pending_desc'] }}</span></div>
                    </div>

                    <div class="status-option" data-status="confirmed">
                        <input type="radio" name="status" value="confirmed">
                        <div class="st-icon" style="background:#1976D2;"><i class="fas fa-check"></i></div>
                        <div class="st-text"><strong>{{ $strings['st_confirmed_title'] }}</strong><span>{{ $strings['st_confirmed_desc'] }}</span></div>
                    </div>

                    <div class="status-option" data-status="processing">
                        <input type="radio" name="status" value="processing">
                        <div class="st-icon" style="background:#7B1FA2;"><i class="fas fa-cogs"></i></div>
                        <div class="st-text"><strong>{{ $strings['st_processing_title'] }}</strong><span>{{ $strings['st_processing_desc'] }}</span></div>
                    </div>

                    <div class="status-option" data-status="out_for_delivery">
                        <input type="radio" name="status" value="out_for_delivery">
                        <div class="st-icon" style="background:#C2185B;"><i class="fas fa-motorcycle"></i></div>
                        <div class="st-text"><strong>{{ $strings['st_out_title'] }}</strong><span>{{ $strings['st_out_desc'] }}</span></div>
                    </div>

                    <div class="status-option" data-status="delivered">
                        <input type="radio" name="status" value="delivered">
                        <div class="st-icon" style="background:#2E7D32;"><i class="fas fa-check-circle"></i></div>
                        <div class="st-text"><strong>{{ $strings['st_delivered_title'] }}</strong><span>{{ $strings['st_delivered_desc'] }}</span></div>
                    </div>

                    <div class="status-option" data-status="cancelled">
                        <input type="radio" name="status" value="cancelled">
                        <div class="st-icon" style="background:#C62828;"><i class="fas fa-times-circle"></i></div>
                        <div class="st-text"><strong>{{ $strings['st_cancelled_title'] }}</strong><span>{{ $strings['st_cancelled_desc'] }}</span></div>
                    </div>

                    <div id="statusError" style="color:#E53935;font-size:0.82rem;margin-top:10px;display:none;">
                        {{ $strings['err_select_status'] }}
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="btn-reset" data-bs-dismiss="modal" style="width:auto;padding:10px 22px;">
                        <i class="fas fa-times"></i> {{ $strings['btn_cancel'] }}
                    </button>
                    <button type="submit" class="btn-filter" style="width:auto;padding:10px 25px;">
                        <i class="fas fa-save"></i> {{ $strings['btn_update'] }}
                    </button>
                </div>
            </form>
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
            delConfirm: "{{ $strings['js_del_confirm'] ?? 'Are you sure you want to delete order :num? This action cannot be undone.' }}",
            dateErr1: "{{ $strings['js_date_err_1'] ?? '\"To Date\" cannot be earlier than \"From Date\".' }}",
            dateErr2: "{{ $strings['js_date_err_2'] ?? '\"From Date\" cannot be later than \"To Date\".' }}",
            updating: "{{ $strings['js_updating'] ?? 'Updating...' }}",
            btnCancel: "{{ $strings['btn_cancel'] ?? 'Cancel' }}"
        };

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
                btnGroup.append(`<button type="button" class="alert-btn-cancel" data-bs-dismiss="modal">${jsStrings.btnCancel}</button>`);
                btnGroup.append(`<button type="button" class="alert-btn-confirm" id="customAlertConfirmBtn">Yes, Delete</button>`);
                $('#customAlertConfirmBtn').on('click', function() {
                    $('#customAlertModal').modal('hide');
                    if (onConfirm) onConfirm();
                });
            } else {
                btnGroup.append(`<button type="button" class="alert-btn-ok" data-bs-dismiss="modal">OK</button>`);
            }
            $('#customAlertModal').modal('show');
        }

        $('.order-stat').on('click', function() {
            var status = $(this).data('status');
            var url = new URL(window.location.href);
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            window.location.href = url.toString();
        });

        $('#statusFilter').on('change', function() {
            $('#filterForm').submit();
        });

        $('#selectAll').on('change', function() {
            $('.row-check').prop('checked', $(this).is(':checked'));
        });
        $('.row-check').on('change', function() {
            if ($('.row-check:checked').length === $('.row-check').length) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
        });

        $('.btn-update-status').on('click', function() {
            var orderId = $(this).data('order-id');
            var orderNum = $(this).data('order-num');
            var currentStatus = $(this).data('current-status');
            $('#modalOrderId').val(orderId);
            $('#modalOrderNum').text(orderNum);
            $('.status-option').removeClass('selected');
            $('.status-option input[type="radio"]').prop('checked', false);
            var $currentOption = $('.status-option[data-status="' + currentStatus + '"]');
            $currentOption.addClass('selected');
            $currentOption.find('input[type="radio"]').prop('checked', true);
            $('#statusError').hide();
            $('#statusModal').modal('show');
        });

        $('.status-option').on('click', function() {
            $('.status-option').removeClass('selected');
            $(this).addClass('selected');
            $(this).find('input[type="radio"]').prop('checked', true);
            $('#statusError').hide();
        });

        $('#statusUpdateForm').on('submit', function(e) {
            var selected = $('input[name="status"]:checked').val();
            if (!selected) {
                e.preventDefault();
                $('#statusError').fadeIn();
                return false;
            }
            var $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.updating);
        });

        $('.btn-delete-order').on('click', function() {
            var orderId = $(this).data('order-id');
            var orderNum = $(this).data('order-num');
            var msg = jsStrings.delConfirm.replace(':num', orderNum);
            showCustomAlert('danger', 'Delete Order?', msg, true, function() {
                var $form = $('<form>', {
                    method: 'POST',
                    action: '{{ url("/admin/order/delete") }}/' + orderId
                });
                $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                $form.append('<input type="hidden" name="_method" value="DELETE">');
                $('body').append($form);
                $form.submit();
            });
        });

        $('input[name="search"]').on('keypress', function(e) {
            if (e.which === 13) {
                $('#filterForm').submit();
            }
        });

        $('input[name="to_date"]').on('change', function() {
            var fromDate = $('input[name="from_date"]').val();
            var toDate = $(this).val();
            if (fromDate && toDate && toDate < fromDate) {
                showCustomAlert('warning', 'Invalid Date Range', jsStrings.dateErr1);
                $(this).val('');
            }
        });

        $('input[name="from_date"]').on('change', function() {
            var fromDate = $(this).val();
            var toDate = $('input[name="to_date"]').val();
            if (fromDate && toDate && fromDate > toDate) {
                showCustomAlert('warning', 'Invalid Date Range', jsStrings.dateErr2);
                $('input[name="to_date"]').val('');
            }
        });
    });
</script>
@endsection