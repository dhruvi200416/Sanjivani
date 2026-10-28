@extends('layouts.pharmacy')

@section('title', 'Manage Orders')
@section('page_title')
<i class="fas fa-shopping-cart"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('Manage Orders') }}
@endsection

@section('styles')
<style>
    .order-stats-ph {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }

    .os-ph {
        background: var(--white);
        border-radius: 14px;
        padding: 16px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .os-ph:hover {
        transform: translateY(-2px);
    }

    .os-ph.active {
        border-color: var(--primary-green);
        background: var(--pale-green);
    }

    .os-ph .os-ic {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1rem;
    }

    .os-ic.all {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .os-ic.pending {
        background: linear-gradient(135deg, #E65100, #FFA726);
    }

    .os-ic.confirmed {
        background: linear-gradient(135deg, #1565C0, #42A5F5);
    }

    .os-ic.processing {
        background: linear-gradient(135deg, #7B1FA2, #AB47BC);
    }

    .os-ic.delivered {
        background: linear-gradient(135deg, #00695C, #26A69A);
    }

    .os-ph .os-v {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1;
    }

    .os-ph .os-l {
        font-size: 0.72rem;
        color: var(--gray-text);
    }

    .filter-bar-ph {
        background: var(--white);
        border-radius: 14px;
        padding: 15px 20px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-input-ph {
        flex: 1;
        min-width: 200px;
        padding: 10px 14px 10px 38px;
        border: 2px solid #E8E8E8;
        border-radius: 25px;
        font-size: 0.88rem;
        outline: none;
        transition: var(--transition);
        font-family: 'Poppins', sans-serif;
    }

    .search-input-ph:focus {
        border-color: var(--primary-green);
    }

    .filter-select-ph {
        padding: 10px 35px 10px 14px;
        border: 2px solid #E8E8E8;
        border-radius: 25px;
        font-size: 0.85rem;
        outline: none;
        background: var(--white);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 10px;
        font-family: 'Poppins', sans-serif;
    }

    .orders-table-ph {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .orders-table-ph table {
        width: 100%;
        margin: 0;
    }

    .orders-table-ph thead th {
        background: var(--off-white);
        color: var(--gray-text);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 18px;
        border-bottom: 1px solid #E0E0E0;
        white-space: nowrap;
    }

    .orders-table-ph tbody td {
        padding: 14px 18px;
        font-size: 0.87rem;
        color: var(--dark-text);
        vertical-align: middle;
        border-bottom: 1px solid #F5F5F5;
    }

    .orders-table-ph tbody tr {
        transition: var(--transition);
    }

    .orders-table-ph tbody tr:hover {
        background: var(--off-white);
    }

    .ord-id-ph {
        font-weight: 700;
        color: var(--primary-green);
        text-decoration: none;
    }

    .ord-id-ph:hover {
        text-decoration: underline;
    }

    .cust-cell-ph {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cust-av-ph {
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

    .cust-cell-ph .cn {
        font-weight: 600;
        font-size: 0.87rem;
        display: block;
    }

    .cust-cell-ph .cp {
        font-size: 0.72rem;
        color: var(--gray-text);
    }

    .st-badge-ph {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .stb-pending {
        background: #FFF3E0;
        color: #E65100;
    }

    .stb-confirmed {
        background: #E3F2FD;
        color: #1565C0;
    }

    .stb-processing {
        background: #F3E5F5;
        color: #7B1FA2;
    }

    .stb-out_for_delivery {
        background: #FCE4EC;
        color: #AD1457;
    }

    .stb-delivered {
        background: #E8F5E9;
        color: #1B5E20;
    }

    .stb-cancelled {
        background: #FFEBEE;
        color: #B71C1C;
    }

    .pay-badge-ph {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .pay-cod {
        background: #FFF3E0;
        color: #E65100;
    }

    .pay-online {
        background: #E3F2FD;
        color: #1565C0;
    }

    .pay-upi {
        background: #F3E5F5;
        color: #6A1B9A;
    }

    .ord-price-ph {
        font-weight: 700;
        color: var(--primary-green);
    }

    .ord-actions-ph {
        display: flex;
        gap: 5px;
    }

    .oa-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        border: none;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.75rem;
        text-decoration: none;
    }

    .oa-btn.view {
        background: #1976D2;
    }

    .oa-btn.confirm {
        background: #2E7D32;
    }

    .oa-btn.process {
        background: #7B1FA2;
    }

    .oa-btn.cancel {
        background: #C62828;
    }

    .oa-btn:hover {
        transform: translateY(-2px);
        color: var(--white);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .empty-orders-ph {
        text-align: center;
        padding: 60px 30px;
    }

    .empty-orders-ph i {
        font-size: 4rem;
        color: var(--mint-green);
        margin-bottom: 15px;
    }

    .empty-orders-ph h5 {
        color: var(--gray-text);
        font-weight: 700;
    }

    .pagination-ph {
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #EEE;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pagination-ph .pg-info {
        font-size: 0.85rem;
        color: var(--gray-text);
    }

    .pg-btns {
        display: flex;
        gap: 5px;
    }

    .pg-btn {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: var(--white);
        border: 1px solid #E0E0E0;
        color: var(--dark-text);
        font-size: 0.82rem;
        cursor: pointer;
        text-decoration: none;
    }

    .pg-btn:hover {
        background: var(--pale-green);
        border-color: var(--primary-green);
        color: var(--primary-green);
    }

    .pg-btn.active {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border-color: var(--primary-green);
    }

    /* Status Modal */
    .modal-content-ph {
        border: none;
        border-radius: 18px;
        overflow: hidden;
    }

    .modal-header-ph {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 18px 25px;
        border: none;
    }

    .modal-header-ph .btn-close {
        filter: brightness(0) invert(1);
    }

    .status-opt-ph {
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

    .status-opt-ph:hover {
        border-color: var(--primary-green);
        background: var(--off-white);
    }

    .status-opt-ph.selected {
        border-color: var(--primary-green);
        background: var(--pale-green);
    }

    .status-opt-ph .so-ic {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1rem;
    }

    .status-opt-ph .so-txt strong {
        display: block;
        font-size: 0.9rem;
        color: var(--dark-text);
    }

    .status-opt-ph .so-txt span {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    @media (max-width: 991px) {
        .order-stats-ph {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 767px) {
        .order-stats-ph {
            grid-template-columns: 1fr 1fr;
        }

        .orders-table-ph thead {
            display: none;
        }

        .orders-table-ph tbody td {
            padding: 10px 12px;
            font-size: 0.85rem;
        }

        .filter-bar-ph {
            flex-direction: column;
        }

        .search-input-ph {
            min-width: 100%;
        }
    }

    /* ============ CUSTOM MODAL STYLES ============ */
    .custom-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10005;
        padding: 20px;
    }

    .custom-modal-overlay.show {
        display: flex;
    }

    .custom-modal {
        background: var(--white);
        border-radius: 16px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }

    .custom-modal-overlay.show .custom-modal {
        transform: scale(1);
    }

    .custom-modal-header {
        padding: 20px 25px;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .custom-modal-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .custom-modal-icon.warning {
        background: #FFF3E0;
        color: #FB8C00;
    }

    .custom-modal-icon.success {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .custom-modal-icon.error {
        background: #FFEBEE;
        color: #C62828;
    }

    .custom-modal-header h5 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark-text);
    }

    .custom-modal-body {
        padding: 20px 25px;
        font-size: 0.95rem;
        color: var(--gray-text);
        line-height: 1.5;
    }

    .custom-modal-footer {
        padding: 15px 25px;
        background: var(--off-white);
        border-top: 1px solid #E0E0E0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-modal {
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        border: none;
    }

    .btn-modal-cancel {
        background: transparent;
        color: var(--gray-text);
        border: 1px solid #E0E0E0;
    }

    .btn-modal-cancel:hover {
        background: #F5F5F5;
    }

    .btn-modal-confirm {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
    }

    .btn-modal-confirm:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(46, 125, 50, 0.3);
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

// Get orders from controller; if null, use demo data
$ordersCollection = $orders ?? null;

// If it's a paginator, extract the underlying Collection
if ($ordersCollection instanceof \Illuminate\Pagination\LengthAwarePaginator) {
$ordersCollection = $ordersCollection->getCollection();
}

// If no real data (or empty collection), fallback to demo data
if (is_null($ordersCollection) || $ordersCollection->isEmpty()) {
$demoOrders = collect([
(object)['id'=>101,'customer_name'=>'Ramesh Patil','phone'=>'9876543210','village'=>'Nashik','items'=>3,'total'=>780,'payment'=>'cod','status'=>'pending','date'=>now()->subMinutes(5)],
(object)['id'=>100,'customer_name'=>'Sunita Sharma','phone'=>'9812345678','village'=>'Pune','items'=>5,'total'=>1250,'payment'=>'online','status'=>'pending','date'=>now()->subMinutes(20)],
(object)['id'=>99,'customer_name'=>'Arjun Verma','phone'=>'9998887771','village'=>'Jaipur','items'=>2,'total'=>450,'payment'=>'upi','status'=>'confirmed','date'=>now()->subHours(1)],
(object)['id'=>98,'customer_name'=>'Priya Deshmukh','phone'=>'9765432109','village'=>'Aurangabad','items'=>4,'total'=>920,'payment'=>'cod','status'=>'processing','date'=>now()->subHours(3)],
(object)['id'=>97,'customer_name'=>'Amit Kulkarni','phone'=>'9871122334','village'=>'Kolhapur','items'=>1,'total'=>180,'payment'=>'online','status'=>'delivered','date'=>now()->subHours(5)],
(object)['id'=>96,'customer_name'=>'Neha Joshi','phone'=>'9822334455','village'=>'Nagpur','items'=>6,'total'=>1580,'payment'=>'upi','status'=>'delivered','date'=>now()->subDays(1)],
(object)['id'=>95,'customer_name'=>'Suresh Rao','phone'=>'9776655443','village'=>'Solapur','items'=>2,'total'=>340,'payment'=>'cod','status'=>'cancelled','date'=>now()->subDays(2)],
(object)['id'=>94,'customer_name'=>'Kavita Menon','phone'=>'9665544332','village'=>'Satara','items'=>3,'total'=>720,'payment'=>'online','status'=>'delivered','date'=>now()->subDays(3)],
]);
} else {
$demoOrders = $ordersCollection;
}

// Translate static strings for this page
$strings = GoogleTranslator::translateBatch([
'stat_all' => 'All',
'stat_pending' => 'Pending',
'stat_confirmed' => 'Confirmed',
'stat_processing' => 'Processing',
'stat_delivered' => 'Delivered',

'search_placeholder' => 'Search Order ID, customer...',
'filter_all_status' => 'All Status',
'filter_all_payments' => 'All Payments',

'th_order_id' => 'Order ID',
'th_customer' => 'Customer',
'th_items' => 'Items',
'th_total' => 'Total',
'th_payment' => 'Payment',
'th_status' => 'Status',
'th_date' => 'Date',
'th_actions' => 'Actions',

'pg_showing' => 'Showing',
'pg_of' => 'of',
'pg_orders' => 'orders',

'modal_title' => 'Update Status',
'modal_cancel' => 'Cancel',
'modal_update' => 'Update',

'status_confirmed' => 'Order confirmed, preparing medicines',
'status_processing' => 'Medicines being packed',
'status_out_for_delivery' => 'Handed to delivery partner',
'status_delivered' => 'Order delivered',

'js_confirm_order' => 'Confirm this order?',
'js_process_order' => 'Start processing this order?',
'js_cancel_order' => 'Cancel order :num?',

// Popup Modal Strings
'popup_confirm_title' => 'Confirm Action',
'popup_cancel_title' => 'Cancel Order',
'popup_yes' => 'Yes, Proceed',
'popup_no' => 'Cancel',
]);
@endphp

<!-- Stats -->
<div class="order-stats-ph" data-aos="fade-up">
    <div class="os-ph active" data-filter="all">
        <div class="os-ic all"><i class="fas fa-list"></i></div>
        <div>
            <div class="os-v">{{ $demoOrders->count() }}</div>
            <div class="os-l">{{ $strings['stat_all'] }}</div>
        </div>
    </div>
    <div class="os-ph" data-filter="pending">
        <div class="os-ic pending"><i class="fas fa-clock"></i></div>
        <div>
            <div class="os-v">{{ $demoOrders->filter(fn($o) => $o->status == 'pending')->count() }}</div>
            <div class="os-l">{{ $strings['stat_pending'] }}</div>
        </div>
    </div>
    <div class="os-ph" data-filter="confirmed">
        <div class="os-ic confirmed"><i class="fas fa-check"></i></div>
        <div>
            <div class="os-v">{{ $demoOrders->filter(fn($o) => $o->status == 'confirmed')->count() }}</div>
            <div class="os-l">{{ $strings['stat_confirmed'] }}</div>
        </div>
    </div>
    <div class="os-ph" data-filter="processing">
        <div class="os-ic processing"><i class="fas fa-cogs"></i></div>
        <div>
            <div class="os-v">{{ $demoOrders->filter(fn($o) => $o->status == 'processing')->count() }}</div>
            <div class="os-l">{{ $strings['stat_processing'] }}</div>
        </div>
    </div>
    <div class="os-ph" data-filter="delivered">
        <div class="os-ic delivered"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="os-v">{{ $demoOrders->filter(fn($o) => $o->status == 'delivered')->count() }}</div>
            <div class="os-l">{{ $strings['stat_delivered'] }}</div>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="filter-bar-ph">
    <div style="flex:1;position:relative;min-width:200px;">
        <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--primary-green);"></i>
        <input type="text" id="orderSearchPh" class="search-input-ph" placeholder="{{ $strings['search_placeholder'] }}">
    </div>
    <select id="statusFilterPh" class="filter-select-ph">
        <option value="">{{ $strings['filter_all_status'] }}</option>
        <option value="pending">{{ $strings['stat_pending'] }}</option>
        <option value="confirmed">{{ $strings['stat_confirmed'] }}</option>
        <option value="processing">{{ $strings['stat_processing'] }}</option>
        <option value="delivered">{{ $strings['stat_delivered'] }}</option>
        <option value="cancelled">{{ app(\App\Services\GoogleTranslator::class)->translate('Cancelled') }}</option>
    </select>
    <select id="paymentFilterPh" class="filter-select-ph">
        <option value="">{{ $strings['filter_all_payments'] }}</option>
        <option value="cod">COD</option>
        <option value="online">Online</option>
        <option value="upi">UPI</option>
    </select>
</div>

<!-- Orders Table -->
<div class="orders-table-ph">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>{{ $strings['th_order_id'] }}</th>
                    <th>{{ $strings['th_customer'] }}</th>
                    <th>{{ $strings['th_items'] }}</th>
                    <th>{{ $strings['th_total'] }}</th>
                    <th>{{ $strings['th_payment'] }}</th>
                    <th>{{ $strings['th_status'] }}</th>
                    <th>{{ $strings['th_date'] }}</th>
                    <th>{{ $strings['th_actions'] }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demoOrders as $ord)
                @php $st = $ord->status; @endphp
                <tr data-status="{{ $st }}" data-payment="{{ $ord->payment }}">
                    <td><a href="{{ url('/pharmacy/order/'.$ord->id) }}" class="ord-id-ph">#ORD-{{ str_pad($ord->id, 4, '0', STR_PAD_LEFT) }}</a></td>
                    <td>
                        <div class="cust-cell-ph">
                            <div class="cust-av-ph">{{ strtoupper(substr($ord->customer_name, 0, 1)) }}</div>
                            <div>
                                <span class="cn">{{ $ord->customer_name }}</span>
                                <span class="cp"><i class="fas fa-map-marker-alt me-1"></i>{{ $ord->village }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span style="background:var(--pale-green);color:var(--primary-green);padding:3px 10px;border-radius:12px;font-weight:600;font-size:0.78rem;">{{ $ord->items }}</span></td>
                    <td class="ord-price-ph">₹{{ number_format($ord->total) }}</td>
                    <td><span class="pay-badge-ph pay-{{ $ord->payment }}">{{ strtoupper($ord->payment) }}</span></td>
                    <td><span class="st-badge-ph stb-{{ $st }}">{{ app(\App\Services\GoogleTranslator::class)->translate(ucfirst(str_replace('_',' ',$st))) }}</span></td>
                    <td style="font-size:0.82rem;">{{ $ord->date->diffForHumans() }}</td>
                    <td>
                        <div class="ord-actions-ph">
                            <a href="{{ url('/pharmacy/order/'.$ord->id) }}" class="oa-btn view" title="{{ app(\App\Services\GoogleTranslator::class)->translate('View') }}"><i class="fas fa-eye"></i></a>
                            @if($st == 'pending')
                            <button type="button" class="oa-btn confirm btn-confirm-order" data-id="{{ $ord->id }}" title="{{ app(\App\Services\GoogleTranslator::class)->translate('Confirm') }}"><i class="fas fa-check"></i></button>
                            @endif
                            @if($st == 'confirmed')
                            <button type="button" class="oa-btn process btn-process-order" data-id="{{ $ord->id }}" title="{{ app(\App\Services\GoogleTranslator::class)->translate('Start Processing') }}"><i class="fas fa-cogs"></i></button>
                            @endif
                            @if(in_array($st, ['pending','confirmed']))
                            <button type="button" class="oa-btn cancel btn-cancel-order-ph" data-id="{{ $ord->id }}" data-num="#ORD-{{ str_pad($ord->id,4,'0',STR_PAD_LEFT) }}" title="{{ app(\App\Services\GoogleTranslator::class)->translate('Cancel') }}"><i class="fas fa-times"></i></button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-ph">
        <div class="pg-info">{{ $strings['pg_showing'] }} <strong>1-{{ count($demoOrders) }}</strong> {{ $strings['pg_of'] }} <strong>{{ $demoOrders->count() }}</strong> {{ $strings['pg_orders'] }}</div>
        <div class="pg-btns">
            <a href="#" class="pg-btn"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="pg-btn active">1</a>
            <a href="#" class="pg-btn">2</a>
            <a href="#" class="pg-btn">3</a>
            <a href="#" class="pg-btn"><i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModalPh" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-ph">
            <div class="modal-header modal-header-ph">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> {{ $strings['modal_title'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusFormPh" action="{{ url('/pharmacy/order/update-status') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" id="modalOrderIdPh">
                <div class="modal-body" style="padding:25px;">
                    @foreach([
                    'confirmed' => ['1976D2','fa-check', $strings['status_confirmed']],
                    'processing' => ['7B1FA2','fa-cogs', $strings['status_processing']],
                    'out_for_delivery' => ['C2185B','fa-motorcycle', $strings['status_out_for_delivery']],
                    'delivered' => ['2E7D32','fa-check-circle', $strings['status_delivered']]
                    ] as $k=>$d)
                    <div class="status-opt-ph" data-status="{{ $k }}">
                        <input type="radio" name="status" value="{{ $k }}" style="accent-color:var(--primary-green);">
                        <div class="so-ic" style="background:#{{ $d[0] }};"><i class="fas {{ $d[1] }}"></i></div>
                        <div class="so-txt"><strong>{{ app(\App\Services\GoogleTranslator::class)->translate(ucfirst(str_replace('_',' ',$k))) }}</strong><span>{{ $d[2] }}</span></div>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:none;background:var(--pale-green);padding:8px 20px;border-radius:20px;font-size:0.85rem;">{{ $strings['modal_cancel'] }}</button>
                    <button type="submit" class="btn-save-dp" style="background:linear-gradient(135deg,var(--primary-green),var(--light-green));color:white;border:none;padding:10px 25px;border-radius:20px;font-weight:700;font-size:0.88rem;cursor:pointer;">
                        <i class="fas fa-save"></i> {{ $strings['modal_update'] }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Alert/Confirm Modal -->
<div class="custom-modal-overlay" id="customModal">
    <div class="custom-modal">
        <div class="custom-modal-header">
            <div class="custom-modal-icon warning" id="modalIconContainer">
                <i class="fas fa-exclamation-triangle" id="modalIcon"></i>
            </div>
            <h5 id="modalTitle">Confirm Action</h5>
        </div>
        <div class="custom-modal-body" id="modalMessage">
            Are you sure you want to proceed?
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn-modal btn-modal-cancel" id="modalCancelBtn" style="display:none;">
                {{ $strings['popup_no'] }}
            </button>
            <button type="button" class="btn-modal btn-modal-confirm" id="modalConfirmBtn">
                {{ $strings['popup_yes'] }}
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        var jsStrings = {
            confirmOrder: "{{ $strings['js_confirm_order'] ?? 'Confirm this order?' }}",
            processOrder: "{{ $strings['js_process_order'] ?? 'Start processing this order?' }}",
            cancelOrder: "{{ $strings['js_cancel_order'] ?? 'Cancel order :num?' }}",
            popupConfirmTitle: "{{ $strings['popup_confirm_title'] ?? 'Confirm Action' }}",
            popupCancelTitle: "{{ $strings['popup_cancel_title'] ?? 'Cancel Order' }}",
            popupYes: "{{ $strings['popup_yes'] ?? 'Yes, Proceed' }}",
            popupNo: "{{ $strings['popup_no'] ?? 'Cancel' }}"
        };

        /* ============ CUSTOM MODAL LOGIC ============ */
        var modalCallback = null;

        function showAlert(message, type = 'warning', title = jsStrings.popupConfirmTitle) {
            $('#modalTitle').text(title);
            $('#modalMessage').text(message);
            $('#modalIconContainer').attr('class', 'custom-modal-icon ' + type);
            $('#modalIcon').attr('class', 'fas ' + (type === 'warning' ? 'fa-exclamation-triangle' : (type === 'error' ? 'fa-times-circle' : 'fa-check-circle')));
            $('#modalCancelBtn').hide();
            $('#modalConfirmBtn').text(jsStrings.popupYes).off('click').on('click', function() {
                $('#customModal').removeClass('show');
            });
            $('#customModal').addClass('show');
        }

        function showConfirm(message, callback, title = jsStrings.popupConfirmTitle) {
            $('#modalTitle').text(title);
            $('#modalMessage').text(message);
            $('#modalIconContainer').attr('class', 'custom-modal-icon warning');
            $('#modalIcon').attr('class', 'fas fa-question-circle');
            $('#modalCancelBtn').show().text(jsStrings.popupNo).off('click').on('click', function() {
                $('#customModal').removeClass('show');
            });
            $('#modalConfirmBtn').text(jsStrings.popupYes).off('click').on('click', function() {
                $('#customModal').removeClass('show');
                if (typeof callback === 'function') callback();
            });
            $('#customModal').addClass('show');
        }

        /* ============ FILTERS & SEARCH ============ */

        /* Stat Filter */
        $('.os-ph').on('click', function() {
            $('.os-ph').removeClass('active');
            $(this).addClass('active');
            var f = $(this).data('filter');
            if (f === 'all') $('tr[data-status]').show();
            else {
                $('tr[data-status]').hide();
                $('tr[data-status="' + f + '"]').show();
            }
        });

        /* Search */
        $('#orderSearchPh').on('input', function() {
            var q = $(this).val().toLowerCase();
            $('tbody tr').each(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
            });
        });

        /* Status Filter */
        $('#statusFilterPh').on('change', function() {
            var s = $(this).val();
            if (!s) $('tr[data-status]').show();
            else {
                $('tr[data-status]').hide();
                $('tr[data-status="' + s + '"]').show();
            }
        });

        /* Payment Filter */
        $('#paymentFilterPh').on('change', function() {
            var p = $(this).val();
            if (!p) $('tr[data-payment]').show();
            else {
                $('tr[data-payment]').hide();
                $('tr[data-payment="' + p + '"]').show();
            }
        });

        /* ============ ACTION BUTTONS ============ */

        /* Confirm Order */
        $('.btn-confirm-order').on('click', function() {
            var id = $(this).data('id');
            var $btn = $(this);

            showConfirm(jsStrings.confirmOrder, function() {
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
                $.post('{{ url("/pharmacy/order/update-status") }}', {
                    _token: '{{ csrf_token() }}',
                    order_id: id,
                    status: 'confirmed'
                }).always(function() {
                    location.reload();
                });
            });
        });

        /* Process Order */
        $('.btn-process-order').on('click', function() {
            var id = $(this).data('id');
            var $btn = $(this);

            showConfirm(jsStrings.processOrder, function() {
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
                $.post('{{ url("/pharmacy/order/update-status") }}', {
                    _token: '{{ csrf_token() }}',
                    order_id: id,
                    status: 'processing'
                }).always(function() {
                    location.reload();
                });
            });
        });

        /* Cancel Order */
        $('.btn-cancel-order-ph').on('click', function() {
            var id = $(this).data('id');
            var num = $(this).data('num');
            var msg = jsStrings.cancelOrder.replace(':num', num);

            showConfirm(msg, function() {
                var $f = $('<form>', {
                    method: 'POST',
                    action: '{{ url("/pharmacy/order/cancel") }}'
                });
                $f.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                $f.append('<input type="hidden" name="order_id" value="' + id + '">');
                $('body').append($f);
                $f.submit();
            }, jsStrings.popupCancelTitle);
        });

        /* Status Modal selection */
        $('.status-opt-ph').on('click', function() {
            $('.status-opt-ph').removeClass('selected');
            $(this).addClass('selected');
            $(this).find('input[type="radio"]').prop('checked', true);
        });

    });
</script>
@endsection