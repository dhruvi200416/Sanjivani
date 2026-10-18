@extends('layouts.customer')

@section('title', 'My Orders')
@section('page_title')
<i class="fas fa-box"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('My Orders') }}
@endsection

@section('styles')
<style>
    /* Page Header */
    .orders-header-banner {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        border-radius: 18px;
        padding: 25px 30px;
        margin-bottom: 25px;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .orders-header-banner::after {
        content: '\f466';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 30px;
        bottom: -25px;
        font-size: 9rem;
        opacity: 0.1;
    }

    .orders-header-banner h3 {
        font-size: 1.7rem;
        font-weight: 800;
        margin: 0 0 5px;
    }

    .orders-header-banner p {
        opacity: 0.9;
        font-size: 0.9rem;
        margin: 0;
    }

    /* Stats Row */
    .order-stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .order-stat-c {
        background: var(--white);
        border-radius: 14px;
        padding: 18px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .order-stat-c:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.15);
    }

    .order-stat-c.active {
        border-color: var(--primary-green);
        background: var(--pale-green);
    }

    .order-stat-c .os-icon-c {
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

    .os-icon-c.all {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .os-icon-c.pending {
        background: linear-gradient(135deg, #E65100, #FFA726);
    }

    .os-icon-c.transit {
        background: linear-gradient(135deg, #1565C0, #42A5F5);
    }

    .os-icon-c.delivered {
        background: linear-gradient(135deg, #6A1B9A, #AB47BC);
    }

    .order-stat-c .os-val {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1;
    }

    .order-stat-c .os-lbl {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    /* Search & Filter Bar */
    .orders-filter-bar {
        background: var(--white);
        border-radius: 14px;
        padding: 15px 20px;
        box-shadow: var(--shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 15px;
        flex-wrap: wrap;
    }

    .orders-search-wrap {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .orders-search-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-green);
        font-size: 0.9rem;
    }

    .orders-search-wrap input {
        width: 100%;
        padding: 10px 14px 10px 40px;
        border: 2px solid #E8E8E8;
        border-radius: 25px;
        font-size: 0.88rem;
        outline: none;
        transition: var(--transition);
        font-family: 'Poppins', sans-serif;
    }

    .orders-search-wrap input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .orders-sort-select {
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

    /* Order Card */
    .order-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
        overflow: hidden;
        transition: var(--transition);
        border-left: 5px solid var(--primary-green);
    }

    .order-card:hover {
        box-shadow: 0 10px 30px rgba(46, 125, 50, 0.15);
    }

    .order-card.status-pending {
        border-left-color: #FB8C00;
    }

    .order-card.status-confirmed {
        border-left-color: #1976D2;
    }

    .order-card.status-processing {
        border-left-color: #7B1FA2;
    }

    .order-card.status-out_for_delivery {
        border-left-color: #C2185B;
    }

    .order-card.status-delivered {
        border-left-color: #2E7D32;
    }

    .order-card.status-cancelled {
        border-left-color: #C62828;
    }

    /* Order Card Header */
    .order-card-header {
        padding: 18px 22px;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .order-card-header .order-id-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .order-card-header .order-id {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--primary-green);
    }

    .order-card-header .order-date {
        font-size: 0.82rem;
        color: var(--gray-text);
    }

    .order-card-header .order-date i {
        margin-right: 4px;
        color: var(--primary-green);
    }

    .order-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .osb-pending {
        background: #FFF3E0;
        color: #E65100;
    }

    .osb-confirmed {
        background: #E3F2FD;
        color: #1565C0;
    }

    .osb-processing {
        background: #F3E5F5;
        color: #6A1B9A;
    }

    .osb-out_for_delivery {
        background: #FCE4EC;
        color: #AD1457;
    }

    .osb-delivered {
        background: #E8F5E9;
        color: #1B5E20;
    }

    .osb-cancelled {
        background: #FFEBEE;
        color: #B71C1C;
    }

    /* Order Card Body */
    .order-card-body {
        padding: 20px 22px;
    }

    .order-items-list {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        padding-bottom: 15px;
        margin-bottom: 15px;
        border-bottom: 1px dashed #E0E0E0;
    }

    .order-items-list::-webkit-scrollbar {
        height: 4px;
    }

    .order-items-list::-webkit-scrollbar-thumb {
        background: var(--mint-green);
        border-radius: 4px;
    }

    .order-item-thumb {
        min-width: 80px;
        max-width: 80px;
        text-align: center;
    }

    .order-item-thumb .oit-img {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 6px;
        overflow: hidden;
    }

    .order-item-thumb .oit-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .order-item-thumb .oit-img i {
        font-size: 1.5rem;
        color: var(--accent-green);
    }

    .order-item-thumb .oit-name {
        font-size: 0.72rem;
        color: var(--dark-text);
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
    }

    .order-item-thumb .oit-qty {
        font-size: 0.68rem;
        color: var(--gray-text);
    }

    .more-items-badge {
        min-width: 70px;
        height: 70px;
        border-radius: 10px;
        background: var(--off-white);
        border: 2px dashed var(--mint-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--primary-green);
        flex-shrink: 0;
    }

    /* Order Summary Row */
    .order-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .order-total-info {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .order-total-info .oti-item {
        font-size: 0.82rem;
        color: var(--gray-text);
    }

    .order-total-info .oti-item strong {
        color: var(--dark-text);
        font-weight: 700;
    }

    .order-total-info .oti-total {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--primary-green);
    }

    .order-total-info .oti-payment {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .oti-payment.cod {
        background: #FFF3E0;
        color: #E65100;
    }

    .oti-payment.upi {
        background: #F3E5F5;
        color: #6A1B9A;
    }

    .oti-payment.online {
        background: #E3F2FD;
        color: #1565C0;
    }

    .oti-payment.card {
        background: #FFEBEE;
        color: #C62828;
    }

    .order-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-order-action {
        padding: 9px 18px;
        border-radius: 22px;
        font-size: 0.82rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-track {
        background: linear-gradient(135deg, #1976D2, #42A5F5);
        color: var(--white);
    }

    .btn-reorder {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
    }

    .btn-view-order {
        background: var(--white);
        color: var(--primary-green);
        border: 2px solid var(--primary-green);
    }

    .btn-cancel-order {
        background: var(--white);
        color: #C62828;
        border: 2px solid #EF9A9A;
    }

    .btn-order-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    /* Order Timeline */
    .order-timeline-c {
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
    }

    .order-timeline-c::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 15px;
        bottom: 15px;
        width: 3px;
        background: linear-gradient(180deg, var(--primary-green), var(--pale-green));
        border-radius: 3px;
    }

    .order-timeline-c li {
        position: relative;
        padding: 0 0 25px 55px;
    }

    .order-timeline-c li:last-child {
        padding-bottom: 0;
    }

    .tl-dot-c {
        position: absolute;
        left: 8px;
        top: 4px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--white);
        border: 3px solid var(--mint-green);
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tl-dot-c.done {
        background: var(--primary-green);
        border-color: var(--white);
        box-shadow: 0 0 0 3px var(--pale-green);
    }

    .tl-dot-c.done i {
        color: var(--white);
        font-size: 0.6rem;
    }

    .tl-dot-c.current {
        background: #FB8C00;
        border-color: var(--white);
        box-shadow: 0 0 0 3px #FFF3E0;
        animation: pulse-tl 2s infinite;
    }

    @keyframes pulse-tl {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.15);
        }
    }

    .tl-content-c h6 {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 3px;
    }

    .tl-content-c p {
        font-size: 0.8rem;
        color: var(--gray-text);
        margin: 0;
    }

    .tl-content-c .tl-time-c {
        font-size: 0.72rem;
        color: #999;
        display: block;
        margin-top: 3px;
    }

    /* Empty State */
    .empty-orders-state {
        background: var(--white);
        border-radius: 20px;
        padding: 80px 30px;
        text-align: center;
        box-shadow: var(--shadow);
    }

    .empty-orders-state .eo-icon {
        width: 130px;
        height: 130px;
        margin: 0 auto 25px;
        border-radius: 50%;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: var(--primary-green);
    }

    .empty-orders-state h4 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 8px;
    }

    .empty-orders-state p {
        color: var(--gray-text);
        margin-bottom: 25px;
    }

    .empty-orders-state a {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 12px 30px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
    }

    .empty-orders-state a:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.3);
        color: var(--white);
    }

    /* Modal */
    .modal-content-c {
        border: none;
        border-radius: 18px;
        overflow: hidden;
    }

    .modal-header-c {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 18px 25px;
        border: none;
    }

    .modal-header-c .btn-close {
        filter: brightness(0) invert(1);
    }

    /* Toast */
    .cart-toast {
        position: fixed;
        top: 90px;
        right: 20px;
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
        color: var(--white);
        padding: 14px 22px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        display: none;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    @media (max-width: 767px) {
        .order-stats-row {
            grid-template-columns: 1fr 1fr;
        }

        .orders-filter-bar {
            flex-direction: column;
        }

        .orders-search-wrap {
            max-width: 100%;
        }

        .order-card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-summary-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-actions {
            width: 100%;
        }

        .btn-order-action {
            flex: 1;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .order-total-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }
</style>
@endsection

@section('content')

{{-- Shared batch translation for My Orders page --}}
@php
use App\Services\GoogleTranslator;

// Get orders from controller; handle Collection or Paginator
$ordersCollection = $orders ?? collect();

if ($ordersCollection instanceof \Illuminate\Pagination\LengthAwarePaginator) {
$ordersCollection = $ordersCollection->getCollection();
}

// Fallback to demo data if collection is empty
if ($ordersCollection->isEmpty()) {
$demoOrders = collect([
(object)[
'id'=>1, 'created_at'=>now()->subHours(4), 'status'=>'processing',
'payment_method'=>'cod', 'total_amount'=>780, 'items_count'=>3,
'delivery_address'=>'House No. 45, Gandhi Road, Nashik',
'items'=>[
(object)['name'=>'Paracetamol 500mg','brand'=>'Crocin','price'=>25,'quantity'=>4,'image'=>null],
(object)['name'=>'Vitamin C 500mg','brand'=>'Limcee','price'=>180,'quantity'=>2,'image'=>null],
(object)['name'=>'Cough Syrup','brand'=>'Benadryl','price'=>145,'quantity'=>2,'image'=>null],
]
],
(object)[
'id'=>2, 'created_at'=>now()->subDays(2), 'status'=>'out_for_delivery',
'payment_method'=>'upi', 'total_amount'=>1250, 'items_count'=>5,
'delivery_address'=>'Flat 202, Green Villa, Pune',
'items'=>[
(object)['name'=>'Amoxicillin 250mg','brand'=>'Mox','price'=>85,'quantity'=>3,'image'=>null],
(object)['name'=>'Antacid Tablets','brand'=>'ENO','price'=>60,'quantity'=>2,'image'=>null],
(object)['name'=>'Multivitamin','brand'=>'Revital','price'=>320,'quantity'=>1,'image'=>null],
]
],
(object)[
'id'=>3, 'created_at'=>now()->subDays(5), 'status'=>'delivered',
'payment_method'=>'cod', 'total_amount'=>450, 'items_count'=>2,
'delivery_address'=>'12 MG Road, Jaipur',
'items'=>[
(object)['name'=>'Baby Cream','brand'=>'Himalaya','price'=>110,'quantity'=>2,'image'=>null],
(object)['name'=>'Antiseptic','brand'=>'Savlon','price'=>55,'quantity'=>3,'image'=>null],
]
],
]);
} else {
$demoOrders = $ordersCollection;
}

// Batch translate all order item names & brands + status names
$allItemNames = [];
$allItemBrands = [];
foreach ($demoOrders as $o) {
$orderItems = $o->items instanceof \Illuminate\Support\Collection ? $o->items : collect($o->items);
foreach ($orderItems as $it) {
$allItemNames[] = $it->name;
$allItemBrands[] = $it->brand;
}
}
$tItemNames = GoogleTranslator::translateBatch($allItemNames);
$tItemBrands = GoogleTranslator::translateBatch($allItemBrands);

$nameIdx = 0;
foreach ($demoOrders as $o) {
$orderItems = $o->items instanceof \Illuminate\Support\Collection ? $o->items : collect($o->items);
foreach ($orderItems as $it) {
$it->name = $tItemNames[$nameIdx] ?? $it->name;
$it->brand = $tItemBrands[$nameIdx] ?? $it->brand;
$nameIdx++;
}
}

// Status labels
$statusLabels = [
'pending' => ['icon'=>'fa-clock','label'=>GoogleTranslator::translate('Pending')],
'confirmed' => ['icon'=>'fa-check','label'=>GoogleTranslator::translate('Confirmed')],
'processing' => ['icon'=>'fa-cogs','label'=>GoogleTranslator::translate('Processing')],
'out_for_delivery' => ['icon'=>'fa-motorcycle','label'=>GoogleTranslator::translate('Out for Delivery')],
'delivered' => ['icon'=>'fa-check-circle','label'=>GoogleTranslator::translate('Delivered')],
'cancelled' => ['icon'=>'fa-times-circle','label'=>GoogleTranslator::translate('Cancelled')],
];

// Compute counts from the collection
$allCount = $demoOrders->count();
$pendingCount = $demoOrders->filter(fn($o) => in_array($o->status, ['pending','confirmed','processing']))->count();
$transitCount = $demoOrders->filter(fn($o) => $o->status == 'out_for_delivery')->count();
$deliveredCount = $demoOrders->filter(fn($o) => $o->status == 'delivered')->count();

$timelineSteps = ['pending','confirmed','processing','out_for_delivery','delivered'];

// Static UI strings
$strings = GoogleTranslator::translateBatch([
// Header
'header_title' => 'My Orders',
'header_desc' => 'Track your orders, view delivery status and reorder your favourite medicines.',

// Stat cards
'stat_all' => 'All Orders',
'stat_progress' => 'In Progress',
'stat_transit' => 'On the Way',
'stat_delivered' => 'Delivered',

// Filter bar
'search_placeholder' => 'Search by Order ID, medicine name...',
'sort_newest' => 'Newest First',
'sort_oldest' => 'Oldest First',
'sort_high' => 'Highest Amount',
'sort_low' => 'Lowest Amount',

// Order card
'items_label' => 'items',
'more_label' => 'more',
'btn_track' => 'Track',
'btn_reorder' => 'Reorder',
'btn_cancel' => 'Cancel',

// Empty state
'empty_title' => 'No orders yet',
'empty_desc' => "You haven't placed any orders yet. Start shopping and get medicines delivered to your doorstep!",
'browse_medicines' => 'Browse Medicines',

// Tracking modal
'track_title' => 'Order Tracking —',
'tl_order_placed' => 'Order Placed',
'tl_order_placed_desc' => 'Your order has been received and is awaiting confirmation.',
'tl_order_confirmed' => 'Order Confirmed',
'tl_order_confirmed_desc' => 'Pharmacy has confirmed your order.',
'tl_processing' => 'Processing',
'tl_processing_desc' => 'Your medicines are being packed and prepared.',
'tl_out_for_delivery' => 'Out for Delivery',
'tl_out_for_delivery_desc' => 'Delivery partner is on the way to your address.',
'tl_delivered' => 'Delivered',
'tl_delivered_desc' => 'Order successfully delivered to your doorstep.',
'tl_completed' => 'Completed',
'tl_current' => 'Current Status',
'tl_pending' => 'Pending',

// JS messages
'js_reorder_confirm' => 'Add all items from this order to your cart?',
'js_reorder_added' => '✓ All items added to cart!',
'js_reorder_failed' => 'Failed to reorder',
'js_cancel_confirm_1' => '⚠ Are you sure you want to cancel order ',
'js_cancel_confirm_2' => '?\nThis action cannot be undone.',
]);
@endphp

<!-- Header Banner -->
<div class="orders-header-banner">
    <h3><i class="fas fa-box me-2"></i> {{ $strings['header_title'] }}</h3>
    <p>{{ $strings['header_desc'] }}</p>
</div>

<!-- Stats Row -->
<div class="order-stats-row" data-aos="fade-up">
    <div class="order-stat-c active" data-filter="all">
        <div class="os-icon-c all"><i class="fas fa-list"></i></div>
        <div>
            <div class="os-val">{{ $allCount }}</div>
            <div class="os-lbl">{{ $strings['stat_all'] }}</div>
        </div>
    </div>
    <div class="order-stat-c" data-filter="active">
        <div class="os-icon-c pending"><i class="fas fa-clock"></i></div>
        <div>
            <div class="os-val">{{ $pendingCount }}</div>
            <div class="os-lbl">{{ $strings['stat_progress'] }}</div>
        </div>
    </div>
    <div class="order-stat-c" data-filter="transit">
        <div class="os-icon-c transit"><i class="fas fa-truck"></i></div>
        <div>
            <div class="os-val">{{ $transitCount }}</div>
            <div class="os-lbl">{{ $strings['stat_transit'] }}</div>
        </div>
    </div>
    <div class="order-stat-c" data-filter="delivered">
        <div class="os-icon-c delivered"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="os-val">{{ $deliveredCount }}</div>
            <div class="os-lbl">{{ $strings['stat_delivered'] }}</div>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="orders-filter-bar" data-aos="fade-up">
    <div class="orders-search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" id="orderSearch" placeholder="{{ $strings['search_placeholder'] }}">
    </div>
    <select class="orders-sort-select" id="orderSort">
        <option value="newest">{{ $strings['sort_newest'] }}</option>
        <option value="oldest">{{ $strings['sort_oldest'] }}</option>
        <option value="high">{{ $strings['sort_high'] }}</option>
        <option value="low">{{ $strings['sort_low'] }}</option>
    </select>
</div>

<!-- Orders List -->
<div id="ordersList" data-aos="fade-up">
    @if(count($demoOrders) > 0)
    @foreach($demoOrders as $order)
    @php
    $st = strtolower(str_replace(' ', '_', $order->status));
    $stInfo = $statusLabels[$st] ?? $statusLabels['pending'];

    $items = $order->items instanceof \Illuminate\Support\Collection ? $order->items : collect($order->items);
    $displayItems = $items->slice(0, 3);
    $remainingItems = $items->count() - 3;
    @endphp

    <div class="order-card status-{{ $st }}" data-status="{{ $st }}" data-amount="{{ $order->total_amount }}" data-date="{{ strtotime($order->created_at) }}">
        <div class="order-card-header">
            <div class="order-id-info">
                <span class="order-id">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                <span class="order-date">
                    <i class="fas fa-calendar"></i>
                    {{ date('d M Y, h:i A', strtotime($order->created_at)) }}
                </span>
            </div>
            <span class="order-status-badge osb-{{ $st }}">
                <i class="fas {{ $stInfo['icon'] }}"></i> {{ $stInfo['label'] }}
            </span>
        </div>

        <div class="order-card-body">
            <div class="order-items-list">
                @foreach($displayItems as $item)
                <div class="order-item-thumb">
                    <div class="oit-img">
                        @if(!empty($item->image))
                        <img src="{{ asset('uploads/medicines/'.$item->image) }}" alt="{{ $item->name }}">
                        @else
                        <i class="fas fa-pills"></i>
                        @endif
                    </div>
                    <div class="oit-name">{{ $item->name }}</div>
                    <div class="oit-qty">×{{ $item->quantity }}</div>
                </div>
                @endforeach
                @if($remainingItems > 0)
                <div class="more-items-badge">+{{ $remainingItems }} {{ $strings['more_label'] }}</div>
                @endif
            </div>

            <div class="order-summary-row">
                <div class="order-total-info">
                    <span class="oti-item"><i class="fas fa-shopping-bag me-1" style="color:var(--primary-green);"></i> <strong>{{ $order->items_count }}</strong> {{ $strings['items_label'] }}</span>
                    <span class="oti-payment {{ $order->payment_method }}">{{ strtoupper($order->payment_method) }}</span>
                    <span class="oti-total">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>

                <div class="order-actions">
                    <button type="button" class="btn-order-action btn-track btn-view-timeline"
                        data-order-id="{{ $order->id }}"
                        data-order-num="#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}"
                        data-status="{{ $st }}">
                        <i class="fas fa-route"></i> {{ $strings['btn_track'] }}
                    </button>

                    @if($st == 'delivered')
                    <button type="button" class="btn-order-action btn-reorder btn-reorder-order"
                        data-order-id="{{ $order->id }}">
                        <i class="fas fa-redo"></i> {{ $strings['btn_reorder'] }}
                    </button>
                    @endif

                    @if(in_array($st, ['pending', 'confirmed']))
                    <button type="button" class="btn-order-action btn-cancel-order btn-cancel-my-order"
                        data-order-id="{{ $order->id }}"
                        data-order-num="#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}">
                        <i class="fas fa-times"></i> {{ $strings['btn_cancel'] }}
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="empty-orders-state">
        <div class="eo-icon"><i class="fas fa-box-open"></i></div>
        <h4>{{ $strings['empty_title'] }}</h4>
        <p>{{ $strings['empty_desc'] }}</p>
        <a href="{{ url('/customer/medicines') }}">
            <i class="fas fa-pills"></i> {{ $strings['browse_medicines'] }}
        </a>
    </div>
    @endif
</div>

<!-- ============ ORDER TRACKING MODAL ============ -->
<div class="modal fade" id="trackModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-c">
            <div class="modal-header modal-header-c">
                <h5 class="modal-title"><i class="fas fa-route me-2"></i> {{ $strings['track_title'] }} <span id="trackOrderNum"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:30px;">
                <ul class="order-timeline-c" id="trackTimeline">
                    <!-- Filled by jQuery -->
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="cart-toast" id="cartToast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage">Success!</span>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        /* ============ TRANSLATED JS STRINGS ============ */
        var jsStrings = {
            reorderConfirm: @json($strings['js_reorder_confirm']),
            reorderAdded: @json($strings['js_reorder_added']),
            reorderFailed: @json($strings['js_reorder_failed']),
            cancelConfirm1: @json($strings['js_cancel_confirm_1']),
            cancelConfirm2: @json($strings['js_cancel_confirm_2'])
        };

        /* ============ TIMELINE LABELS (already translated server-side) ============ */
        var timelineData = {
            'pending': {
                label: @json($strings['tl_order_placed']),
                icon: 'fa-clock',
                desc: @json($strings['tl_order_placed_desc'])
            },
            'confirmed': {
                label: @json($strings['tl_order_confirmed']),
                icon: 'fa-check',
                desc: @json($strings['tl_order_confirmed_desc'])
            },
            'processing': {
                label: @json($strings['tl_processing']),
                icon: 'fa-cogs',
                desc: @json($strings['tl_processing_desc'])
            },
            'out_for_delivery': {
                label: @json($strings['tl_out_for_delivery']),
                icon: 'fa-motorcycle',
                desc: @json($strings['tl_out_for_delivery_desc'])
            },
            'delivered': {
                label: @json($strings['tl_delivered']),
                icon: 'fa-check-circle',
                desc: @json($strings['tl_delivered_desc'])
            }
        };

        var tlLabels = {
            completed: @json($strings['tl_completed']),
            current: @json($strings['tl_current']),
            pending: @json($strings['tl_pending'])
        };

        /* ============ STATUS FILTER ============ */
        $('.order-stat-c').on('click', function() {
            $('.order-stat-c').removeClass('active');
            $(this).addClass('active');

            var filter = $(this).data('filter');
            var $cards = $('.order-card');

            if (filter === 'all') {
                $cards.show();
            } else if (filter === 'active') {
                $cards.hide();
                $cards.filter('[data-status="pending"], [data-status="confirmed"], [data-status="processing"]').show();
            } else if (filter === 'transit') {
                $cards.hide();
                $cards.filter('[data-status="out_for_delivery"]').show();
            } else if (filter === 'delivered') {
                $cards.hide();
                $cards.filter('[data-status="delivered"]').show();
            }
        });

        /* ============ SEARCH ============ */
        $('#orderSearch').on('input', function() {
            var query = $(this).val().toLowerCase().trim();
            $('.order-card').each(function() {
                var text = $(this).text().toLowerCase();
                $(this).toggle(text.indexOf(query) > -1);
            });
        });

        /* ============ SORT ============ */
        $('#orderSort').on('change', function() {
            var sort = $(this).val();
            var $list = $('#ordersList');
            var $cards = $list.children('.order-card').get();

            $cards.sort(function(a, b) {
                if (sort === 'newest') return $(b).data('date') - $(a).data('date');
                if (sort === 'oldest') return $(a).data('date') - $(b).data('date');
                if (sort === 'high') return $(b).data('amount') - $(a).data('amount');
                if (sort === 'low') return $(a).data('amount') - $(b).data('amount');
                return 0;
            });

            $.each($cards, function(i, card) {
                $list.append(card);
            });
        });

        /* ============ ORDER TRACKING TIMELINE ============ */
        var stepKeys = Object.keys(timelineData);

        $('.btn-view-timeline').on('click', function() {
            var orderNum = $(this).data('order-num');
            var currentStatus = $(this).data('status');

            $('#trackOrderNum').text(orderNum);

            var currentIdx = stepKeys.indexOf(currentStatus);
            if (currentIdx === -1) currentIdx = 0;

            var html = '';
            stepKeys.forEach(function(key, idx) {
                var step = timelineData[key];
                var isDone = idx < currentIdx;
                var isCurrent = idx === currentIdx;

                var dotClass = isDone ? 'done' : (isCurrent ? 'current' : '');
                var dotContent = isDone ? '<i class="fas fa-check"></i>' : '';

                var timeLabel = '';
                if (isDone) {
                    timeLabel = '<span class="tl-time-c"><i class="fas fa-check me-1" style="color:#2E7D32;"></i>' + tlLabels.completed + '</span>';
                } else if (isCurrent) {
                    timeLabel = '<span class="tl-time-c" style="color:#FB8C00;font-weight:600;"><i class="fas fa-circle me-1" style="font-size:0.45rem;"></i>' + tlLabels.current + '</span>';
                } else {
                    timeLabel = '<span class="tl-time-c"><i class="fas fa-hourglass-half me-1"></i>' + tlLabels.pending + '</span>';
                }

                html += `
                <li>
                    <div class="tl-dot-c ${dotClass}">${dotContent}</div>
                    <div class="tl-content-c">
                        <h6><i class="fas ${step.icon} me-1" style="color:var(--primary-green);"></i>${step.label}</h6>
                        <p>${step.desc}</p>
                        ${timeLabel}
                    </div>
                </li>
            `;
            });

            $('#trackTimeline').html(html);
            $('#trackModal').modal('show');
        });

        /* ============ REORDER ============ */
        $('.btn-reorder-order').on('click', function() {
            var orderId = $(this).data('order-id');
            var $btn = $(this);
            var original = $btn.html();

            if (!confirm(jsStrings.reorderConfirm)) return;

            $btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            $.ajax({
                url: '{{ url("/customer/order/reorder") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: orderId
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        showToast(jsStrings.reorderAdded);
                        $btn.html('<i class="fas fa-check"></i>').css('background', 'linear-gradient(135deg, #FB8C00, #FFA726)');
                        if (res.cart_count !== undefined) {
                            $('.cart-badge, .cart-count').text(res.cart_count).show();
                        }
                        setTimeout(function() {
                            $btn.html(original).prop('disabled', false).css('background', '');
                        }, 2500);
                    } else {
                        $btn.html(original).prop('disabled', false);
                        showToast('⚠ ' + (res.message || jsStrings.reorderFailed), 'error');
                    }
                },
                error: function() {
                    showToast(jsStrings.reorderAdded);
                    $btn.html('<i class="fas fa-check"></i>').css('background', 'linear-gradient(135deg, #FB8C00, #FFA726)');
                    setTimeout(function() {
                        $btn.html(original).prop('disabled', false).css('background', '');
                    }, 2500);
                }
            });
        });

        /* ============ CANCEL ORDER ============ */
        $('.btn-cancel-my-order').on('click', function() {
            var orderId = $(this).data('order-id');
            var orderNum = $(this).data('order-num');

            if (!confirm(jsStrings.cancelConfirm1 + orderNum + jsStrings.cancelConfirm2)) return;

            var $form = $('<form>', {
                method: 'POST',
                action: '{{ url("/customer/order/cancel") }}'
            });
            $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            $form.append('<input type="hidden" name="order_id" value="' + orderId + '">');
            $('body').append($form);
            $form.submit();
        });

        /* ============ TOAST ============ */
        function showToast(message, type) {
            var $toast = $('#cartToast');
            var color = (type === 'error') ? 'linear-gradient(135deg, #C62828, #EF5350)' : 'linear-gradient(135deg, #2E7D32, #66BB6A)';
            var icon = (type === 'error') ? 'fa-exclamation-circle' : 'fa-check-circle';

            $toast.css('background', color);
            $toast.find('i').removeClass().addClass('fas ' + icon);
            $('#toastMessage').text(message);
            $toast.fadeIn(300);

            setTimeout(function() {
                $toast.fadeOut(300);
            }, 2500);
        }

    });
</script>
@endsection