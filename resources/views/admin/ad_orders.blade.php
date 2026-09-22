@extends('layouts.admin')

@section('title', 'Manage Orders - Sanjivani Admin')
@section('page_title')
    <i class="fas fa-shopping-cart"></i> Manage Orders
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
        box-shadow: 0 8px 25px rgba(46,125,50,0.15);
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

    .os-icon.total   { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .os-icon.pending { background: linear-gradient(135deg, #E65100, #FFA726); }
    .os-icon.progress{ background: linear-gradient(135deg, #1565C0, #42A5F5); }
    .os-icon.delivered { background: linear-gradient(135deg, #6A1B9A, #AB47BC); }
    .os-icon.cancelled { background: linear-gradient(135deg, #B71C1C, #EF5350); }

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

    .filter-input {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #E8E8E8;
        border-radius: 10px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: var(--transition);
    }

    .filter-input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
    }

    .filter-select {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #E8E8E8;
        border-radius: 10px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        background: var(--white);
        cursor: pointer;
        transition: var(--transition);
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 35px;
    }

    .filter-select:focus {
        border-color: var(--primary-green);
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
        box-shadow: 0 5px 15px rgba(46,125,50,0.3);
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

    .payment-cod    { background: #FFF3E0; color: #E65100; }
    .payment-online { background: #E3F2FD; color: #1565C0; }
    .payment-upi    { background: #F3E5F5; color: #6A1B9A; }

    .status-badge-tbl {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .st-pending          { background: #FFF3E0; color: #FB8C00; }
    .st-confirmed        { background: #E3F2FD; color: #1976D2; }
    .st-processing       { background: #F3E5F5; color: #7B1FA2; }
    .st-out_for_delivery { background: #FCE4EC; color: #C2185B; }
    .st-delivered        { background: #E8F5E9; color: #2E7D32; }
    .st-cancelled        { background: #FFEBEE; color: #C62828; }

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

    .btn-action.view   { background: linear-gradient(135deg, #1565C0, #42A5F5); }
    .btn-action.edit   { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .btn-action.delete { background: linear-gradient(135deg, #C62828, #EF5350); }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        color: var(--white);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--mint-green);
        margin-bottom: 15px;
    }

    .empty-state h5 {
        color: var(--gray-text);
        font-weight: 600;
    }

    .empty-state p {
        color: #999;
        font-size: 0.9rem;
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

    /* Status Update Modal */
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

    @media (max-width: 767px) {
        .orders-table thead { display: none; }
        .orders-table tbody td { padding: 10px 15px; font-size: 0.85rem; }
    }
</style>
@endsection

@section('content')

<!-- ============ ORDER STATS ============ -->
<div class="row g-3 mb-4">
    <div class="col-lg col-md-4 col-6" data-aos="fade-up" data-aos-delay="0">
        <div class="order-stat {{ !request('status') ? 'active' : '' }}" data-status="">
            <div class="os-icon total"><i class="fas fa-list"></i></div>
            <div class="os-info">
                <div class="os-value">{{ $totalOrders ?? 128 }}</div>
                <div class="os-label">Total Orders</div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-6" data-aos="fade-up" data-aos-delay="80">
        <div class="order-stat {{ request('status')=='pending' ? 'active' : '' }}" data-status="pending">
            <div class="os-icon pending"><i class="fas fa-clock"></i></div>
            <div class="os-info">
                <div class="os-value">{{ $pendingCount ?? 12 }}</div>
                <div class="os-label">Pending</div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-6" data-aos="fade-up" data-aos-delay="160">
        <div class="order-stat {{ request('status')=='processing' ? 'active' : '' }}" data-status="processing">
            <div class="os-icon progress"><i class="fas fa-cogs"></i></div>
            <div class="os-info">
                <div class="os-value">{{ $processingCount ?? 8 }}</div>
                <div class="os-label">Processing</div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-6" data-aos="fade-up" data-aos-delay="240">
        <div class="order-stat {{ request('status')=='delivered' ? 'active' : '' }}" data-status="delivered">
            <div class="os-icon delivered"><i class="fas fa-check-circle"></i></div>
            <div class="os-info">
                <div class="os-value">{{ $deliveredCount ?? 98 }}</div>
                <div class="os-label">Delivered</div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-6" data-aos="fade-up" data-aos-delay="320">
        <div class="order-stat {{ request('status')=='cancelled' ? 'active' : '' }}" data-status="cancelled">
            <div class="os-icon cancelled"><i class="fas fa-times-circle"></i></div>
            <div class="os-info">
                <div class="os-value">{{ $cancelledCount ?? 10 }}</div>
                <div class="os-label">Cancelled</div>
            </div>
        </div>
    </div>
</div>

<!-- ============ FILTERS ============ -->
<div class="filter-card" data-aos="fade-up">
    <form id="filterForm" method="GET" action="{{ url('/admin/orders') }}">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4 col-md-6">
                <label class="form-label"><i class="fas fa-search me-1"></i> Search</label>
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="filter-input"
                           placeholder="Order ID, customer name, phone..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label"><i class="fas fa-filter me-1"></i> Status</label>
                <select name="status" id="statusFilter" class="filter-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="processing" {{ request('status')=='processing' ? 'selected' : '' }}>Processing</option>
                    <option value="out_for_delivery" {{ request('status')=='out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="delivered" {{ request('status')=='delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label"><i class="fas fa-money-check me-1"></i> Payment</label>
                <select name="payment" class="filter-select">
                    <option value="">All Payments</option>
                    <option value="cod"    {{ request('payment')=='cod' ? 'selected' : '' }}>Cash on Delivery</option>
                    <option value="online" {{ request('payment')=='online' ? 'selected' : '' }}>Online</option>
                    <option value="upi"    {{ request('payment')=='upi' ? 'selected' : '' }}>UPI</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label"><i class="fas fa-calendar me-1"></i> From</label>
                <input type="date" name="from_date" class="filter-input" value="{{ request('from_date') }}">
            </div>
            <div class="col-lg-2 col-md-6">
                <label class="form-label"><i class="fas fa-calendar-check me-1"></i> To</label>
                <input type="date" name="to_date" class="filter-input" value="{{ request('to_date') }}">
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-2 offset-md-8">
                <a href="{{ url('/admin/orders') }}" class="btn-reset">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-filter">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
            </div>
        </div>
    </form>
</div>

<!-- ============ ORDERS TABLE ============ -->
<div class="orders-card" data-aos="fade-up">
    <div class="orders-header">
        <h6>
            <i class="fas fa-shopping-cart me-2" style="color:var(--primary-green);"></i>
            All Orders
            <span>{{ isset($orders) ? (method_exists($orders,'total') ? $orders->total() : count($orders)) : 128 }}</span>
        </h6>
        <a href="{{ url('/admin/orders/export?'.http_build_query(request()->all())) }}" class="export-btn">
            <i class="fas fa-file-excel me-1"></i> Export CSV
        </a>
    </div>

    <div class="table-responsive">
        <table class="orders-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll" style="accent-color:var(--primary-green);"></th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Village</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
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
                                    <div class="customer-avatar-sm">
                                        {{ strtoupper(substr($order->customer->name ?? 'C', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="cname">{{ $order->customer->name ?? 'Unknown' }}</span>
                                        <span class="cphone"><i class="fas fa-phone me-1"></i>{{ $order->customer->phone ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-size:0.85rem;">
                                    <i class="fas fa-map-marker-alt me-1" style="color:#E53935;font-size:0.75rem;"></i>
                                    {{ $order->customer->village->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="items-badge">{{ $order->items_count ?? $order->orderItems->count() ?? 0 }} items</span>
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
                                    $status = strtolower(str_replace(' ', '_', $order->status ?? 'pending'));
                                    $stClass = 'st-'.$status;
                                    if(!in_array($status, ['pending','confirmed','processing','out_for_delivery','delivered','cancelled'])) $stClass = 'st-pending';
                                @endphp
                                <span class="status-badge-tbl {{ $stClass }}">{{ ucfirst(str_replace('_', ' ', $order->status ?? 'pending')) }}</span>
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
                                            data-current-status="{{ $order->status ?? 'pending' }}"
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
                    @php
                        // Demo data if no orders passed
                        $demoOrders = [
                            ['id'=>1, 'name'=>'Ramesh Patil',  'phone'=>'9876543210', 'village'=>'Nashik',   'items'=>3, 'total'=>780,  'pay'=>'cod',    'status'=>'pending',          'time'=>'2 hours ago'],
                            ['id'=>2, 'name'=>'Sunita Sharma', 'phone'=>'9812345678', 'village'=>'Pune',     'items'=>5, 'total'=>1250, 'pay'=>'online', 'status'=>'confirmed',        'time'=>'4 hours ago'],
                            ['id'=>3, 'name'=>'Arjun Verma',   'phone'=>'9998887771', 'village'=>'Jaipur',   'items'=>2, 'total'=>450,  'pay'=>'upi',    'status'=>'processing',       'time'=>'Yesterday'],
                            ['id'=>4, 'name'=>'Priya Deshmukh','phone'=>'9765432109', 'village'=>'Aurangabad','items'=>4,'total'=>920, 'pay'=>'cod',    'status'=>'out_for_delivery', 'time'=>'Yesterday'],
                            ['id'=>5, 'name'=>'Amit Kulkarni', 'phone'=>'9871122334', 'village'=>'Kolhapur', 'items'=>1, 'total'=>180,  'pay'=>'online', 'status'=>'delivered',        'time'=>'2 days ago'],
                            ['id'=>6, 'name'=>'Neha Joshi',    'phone'=>'9822334455', 'village'=>'Nagpur',   'items'=>6, 'total'=>1580, 'pay'=>'upi',    'status'=>'delivered',        'time'=>'3 days ago'],
                            ['id'=>7, 'name'=>'Suresh Rao',    'phone'=>'9776655443', 'village'=>'Solapur',  'items'=>2, 'total'=>340,  'pay'=>'cod',    'status'=>'cancelled',        'time'=>'4 days ago'],
                            ['id'=>8, 'name'=>'Kavita Menon',  'phone'=>'9665544332', 'village'=>'Satara',   'items'=>3, 'total'=>720,  'pay'=>'online', 'status'=>'delivered',        'time'=>'5 days ago'],
                        ];
                    @endphp

                    @foreach($demoOrders as $od)
                        <tr>
                            <td><input type="checkbox" class="row-check" value="{{ $od['id'] }}" style="accent-color:var(--primary-green);"></td>
                            <td>
                                <a href="{{ url('/admin/order/'.$od['id']) }}" class="order-id-link">
                                    #ORD-{{ str_pad($od['id'], 4, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>
                            <td>
                                <div class="customer-cell">
                                    <div class="customer-avatar-sm">{{ strtoupper(substr($od['name'], 0, 1)) }}</div>
                                    <div>
                                        <span class="cname">{{ $od['name'] }}</span>
                                        <span class="cphone"><i class="fas fa-phone me-1"></i>{{ $od['phone'] }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-size:0.85rem;">
                                    <i class="fas fa-map-marker-alt me-1" style="color:#E53935;font-size:0.75rem;"></i>
                                    {{ $od['village'] }}
                                </span>
                            </td>
                            <td><span class="items-badge">{{ $od['items'] }} items</span></td>
                            <td class="order-price">₹{{ number_format($od['total'], 2) }}</td>
                            <td>
                                @php $payClass = 'payment-'.$od['pay']; @endphp
                                <span class="payment-badge {{ $payClass }}">{{ strtoupper($od['pay']) }}</span>
                            </td>
                            <td>
                                <span class="status-badge-tbl st-{{ $od['status'] }}">
                                    {{ ucfirst(str_replace('_', ' ', $od['status'])) }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size:0.82rem;">{{ $od['time'] }}</div>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ url('/admin/order/'.$od['id']) }}" class="btn-action view" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn-action edit btn-update-status"
                                            data-order-id="{{ $od['id'] }}"
                                            data-order-num="#ORD-{{ str_pad($od['id'], 4, '0', STR_PAD_LEFT) }}"
                                            data-current-status="{{ $od['status'] }}"
                                            title="Update Status">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn-action delete btn-delete-order"
                                            data-order-id="{{ $od['id'] }}"
                                            data-order-num="#ORD-{{ str_pad($od['id'], 4, '0', STR_PAD_LEFT) }}"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    @if(empty($orders) || (isset($orders) && count($orders) == 0))
        {{-- Empty state disabled since demo shows --}}
    @endif

    <!-- Pagination -->
    <div class="pagination-wrap">
        <div class="pagination-info">
            Showing <strong>1 to 8</strong> of <strong>{{ $totalOrders ?? 128 }}</strong> orders
        </div>
        @if(isset($orders) && method_exists($orders, 'links'))
            <div>{{ $orders->appends(request()->all())->links() }}</div>
        @else
            <nav>
                <ul class="pagination-custom">
                    <li><a href="#" class="page-btn" title="Previous"><i class="fas fa-chevron-left"></i></a></li>
                    <li><a href="#" class="page-btn active">1</a></li>
                    <li><a href="#" class="page-btn">2</a></li>
                    <li><a href="#" class="page-btn">3</a></li>
                    <li><a href="#" class="page-btn">...</a></li>
                    <li><a href="#" class="page-btn">16</a></li>
                    <li><a href="#" class="page-btn" title="Next"><i class="fas fa-chevron-right"></i></a></li>
                </ul>
            </nav>
        @endif
    </div>
</div>

<!-- ============ STATUS UPDATE MODAL ============ -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusUpdateForm" action="{{ url('/admin/order/update-status') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" id="modalOrderId">
                <div class="modal-body modal-body-custom">
                    <p class="mb-3 text-muted">
                        Update status for order <strong id="modalOrderNum" style="color:var(--primary-green);"></strong>
                    </p>

                    <div class="status-option" data-status="pending">
                        <input type="radio" name="status" value="pending">
                        <div class="st-icon" style="background:#FB8C00;"><i class="fas fa-clock"></i></div>
                        <div class="st-text"><strong>Pending</strong><span>Order received, awaiting confirmation</span></div>
                    </div>

                    <div class="status-option" data-status="confirmed">
                        <input type="radio" name="status" value="confirmed">
                        <div class="st-icon" style="background:#1976D2;"><i class="fas fa-check"></i></div>
                        <div class="st-text"><strong>Confirmed</strong><span>Order confirmed by pharmacy</span></div>
                    </div>

                    <div class="status-option" data-status="processing">
                        <input type="radio" name="status" value="processing">
                        <div class="st-icon" style="background:#7B1FA2;"><i class="fas fa-cogs"></i></div>
                        <div class="st-text"><strong>Processing</strong><span>Being prepared for shipment</span></div>
                    </div>

                    <div class="status-option" data-status="out_for_delivery">
                        <input type="radio" name="status" value="out_for_delivery">
                        <div class="st-icon" style="background:#C2185B;"><i class="fas fa-motorcycle"></i></div>
                        <div class="st-text"><strong>Out for Delivery</strong><span>Assigned to delivery partner</span></div>
                    </div>

                    <div class="status-option" data-status="delivered">
                        <input type="radio" name="status" value="delivered">
                        <div class="st-icon" style="background:#2E7D32;"><i class="fas fa-check-circle"></i></div>
                        <div class="st-text"><strong>Delivered</strong><span>Successfully delivered to customer</span></div>
                    </div>

                    <div class="status-option" data-status="cancelled">
                        <input type="radio" name="status" value="cancelled">
                        <div class="st-icon" style="background:#C62828;"><i class="fas fa-times-circle"></i></div>
                        <div class="st-text"><strong>Cancelled</strong><span>Order was cancelled</span></div>
                    </div>

                    <div id="statusError" style="color:#E53935;font-size:0.82rem;margin-top:10px;display:none;">
                        ⚠ Please select a status.
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="btn-reset" data-bs-dismiss="modal" style="width:auto;padding:10px 22px;">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn-filter" style="width:auto;padding:10px 25px;">
                        <i class="fas fa-save"></i> Update Status
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

    /* ============ STAT CARD CLICK - FILTER BY STATUS ============ */
    $('.order-stat').on('click', function () {
        var status = $(this).data('status');
        var url = new URL(window.location.href);
        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }
        window.location.href = url.toString();
    });

    /* ============ STATUS FILTER AUTO SUBMIT ============ */
    $('#statusFilter').on('change', function () {
        $('#filterForm').submit();
    });

    /* ============ SELECT ALL CHECKBOX ============ */
    $('#selectAll').on('change', function () {
        $('.row-check').prop('checked', $(this).is(':checked'));
    });

    $('.row-check').on('change', function () {
        if ($('.row-check:checked').length === $('.row-check').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });

    /* ============ STATUS UPDATE MODAL ============ */
    $('.btn-update-status').on('click', function () {
        var orderId = $(this).data('order-id');
        var orderNum = $(this).data('order-num');
        var currentStatus = $(this).data('current-status');

        $('#modalOrderId').val(orderId);
        $('#modalOrderNum').text(orderNum);

        // Clear all selections
        $('.status-option').removeClass('selected');
        $('.status-option input[type="radio"]').prop('checked', false);

        // Select current status
        var $currentOption = $('.status-option[data-status="' + currentStatus + '"]');
        $currentOption.addClass('selected');
        $currentOption.find('input[type="radio"]').prop('checked', true);

        $('#statusError').hide();
        $('#statusModal').modal('show');
    });

    /* ============ STATUS OPTION SELECT ============ */
    $('.status-option').on('click', function () {
        $('.status-option').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
        $('#statusError').hide();
    });

    /* ============ STATUS FORM SUBMIT VALIDATION ============ */
    $('#statusUpdateForm').on('submit', function (e) {
        var selected = $('input[name="status"]:checked').val();
        if (!selected) {
            e.preventDefault();
            $('#statusError').fadeIn();
            return false;
        }

        var $btn = $(this).find('button[type="submit"]');
        var original = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
    });

    /* ============ DELETE ORDER ============ */
    $('.btn-delete-order').on('click', function () {
        var orderId = $(this).data('order-id');
        var orderNum = $(this).data('order-num');

        if (confirm('Are you sure you want to delete order ' + orderNum + '?\nThis action cannot be undone.')) {
            // Create form and submit
            var $form = $('<form>', {
                method: 'POST',
                action: '{{ url("/admin/order/delete") }}/' + orderId
            });
            $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            $form.append('<input type="hidden" name="_method" value="DELETE">');
            $('body').append($form);
            $form.submit();
        }
    });

    /* ============ SEARCH INPUT ENTER KEY ============ */
    $('input[name="search"]').on('keypress', function (e) {
        if (e.which === 13) {
            $('#filterForm').submit();
        }
    });

    /* ============ DATE VALIDATION ============ */
    $('input[name="to_date"]').on('change', function () {
        var fromDate = $('input[name="from_date"]').val();
        var toDate = $(this).val();

        if (fromDate && toDate && toDate < fromDate) {
            alert('⚠ "To Date" cannot be earlier than "From Date".');
            $(this).val('');
        }
    });

    $('input[name="from_date"]').on('change', function () {
        var fromDate = $(this).val();
        var toDate = $('input[name="to_date"]').val();

        if (fromDate && toDate && fromDate > toDate) {
            alert('⚠ "From Date" cannot be later than "To Date".');
            $('input[name="to_date"]').val('');
        }
    });

});
</script>
@endsection