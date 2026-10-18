@extends('layouts.admin')

@section('title', 'Order Details - Sanjivani Admin')
@section('page_title')
    <i class="fas fa-file-invoice"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('Order Details') }}
@endsection

@section('styles')
<style>
    /* Back Button */
    .back-btn {
        background: var(--white);
        color: var(--primary-green);
        border: 2px solid var(--primary-green);
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        margin-bottom: 18px;
    }
    .back-btn:hover {
        background: var(--primary-green);
        color: var(--white);
        transform: translateX(-3px);
    }

    /* Order Header Card */
    .order-header-card {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        color: var(--white);
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }
    .order-header-card::after {
        content: '\f570';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: -20px;
        bottom: -30px;
        font-size: 8rem;
        opacity: 0.08;
        color: #ffffff;
    }
    .order-header-info h3 {
        font-size: 1.45rem;
        font-weight: 800;
        margin-bottom: 4px;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }
    .order-header-info p {
        opacity: 0.95;
        font-size: 0.85rem;
        margin: 0;
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    .order-header-info p i {
        margin-right: 5px;
        color: #ffffff !important;
    }
    .order-status-big {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.4);
        padding: 8px 18px;
        border-radius: 24px;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #ffffff !important;
        backdrop-filter: blur(4px);
    }
    .order-status-big i {
        color: #ffffff !important;
    }

    /* Info Cards */
    .info-block {
        background: var(--white);
        border-radius: 14px;
        padding: 18px 20px;
        box-shadow: var(--shadow);
        margin-bottom: 16px;
    }
    .info-block h6 {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 2px dashed var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .info-block h6 i {
        color: var(--primary-green);
        margin-right: 6px;
    }
    .info-block h6 .h6-tag {
        font-size: 0.68rem;
        font-weight: 600;
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 3px 8px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Customer Info */
    .customer-detail {
        display: flex;
        gap: 14px;
        align-items: center;
        margin-bottom: 16px;
    }
    .customer-avatar-lg {
        width: 56px;
        height: 56px;
        min-width: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        font-weight: 700;
    }
    .customer-detail .cd-info h5 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 3px;
    }
    .customer-detail .cd-info span {
        font-size: 0.78rem;
        color: var(--gray-text);
        display: block;
    }
    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #F5F5F5;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-row .info-icon-sm {
        width: 28px;
        height: 28px;
        min-width: 28px;
        border-radius: 7px;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
    }
    .info-row .info-text {
        flex: 1;
        min-width: 0;
    }
    .info-row .info-text .label {
        font-size: 0.68rem;
        color: var(--gray-text);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 1px;
    }
    .info-row .info-text .value {
        font-size: 0.85rem;
        color: var(--dark-text);
        font-weight: 500;
        word-break: break-word;
    }
    .info-row .info-text .value a {
        color: var(--primary-green);
        text-decoration: none;
    }
    .info-row .info-text .value a:hover {
        text-decoration: underline;
    }

    /* Compact Meta Grid */
    .meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .meta-grid.single {
        grid-template-columns: 1fr;
    }
    .meta-item {
        background: #FAFFFA;
        border: 1px solid #EEF5EE;
        border-radius: 10px;
        padding: 10px 12px;
        display: flex;
        align-items: flex-start;
        gap: 9px;
        min-width: 0;
    }
    .meta-item .mi-icon {
        width: 26px;
        height: 26px;
        min-width: 26px;
        border-radius: 7px;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
    }
    .meta-item .mi-body {
        flex: 1;
        min-width: 0;
    }
    .meta-item .mi-label {
        font-size: 0.62rem;
        color: var(--gray-text);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.4px;
        margin-bottom: 1px;
    }
    .meta-item .mi-value {
        font-size: 0.82rem;
        color: var(--dark-text);
        font-weight: 600;
        word-break: break-word;
        line-height: 1.3;
    }
    .meta-item .mi-value.money {
        color: var(--primary-green);
        font-weight: 800;
        font-size: 0.92rem;
    }
    .meta-item.full {
        grid-column: 1 / -1;
    }

    /* Items Table */
    .items-table {
        width: 100%;
        margin: 0;
    }
    .items-table thead th {
        background: var(--off-white);
        color: var(--gray-text);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 14px;
        border-bottom: 1px solid #E0E0E0;
    }
    .items-table tbody td {
        padding: 12px 14px;
        font-size: 0.85rem;
        color: var(--dark-text);
        vertical-align: middle;
        border-bottom: 1px solid #F5F5F5;
    }
    .items-table tbody tr:last-child td {
        border-bottom: none;
    }
    .item-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .item-img {
        width: 42px;
        height: 42px;
        border-radius: 9px;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-green);
        font-size: 1rem;
        overflow: hidden;
        flex-shrink: 0;
    }
    .item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .item-info .item-name {
        font-weight: 600;
        color: var(--dark-text);
        display: block;
        font-size: 0.85rem;
    }
    .item-info .item-brand {
        font-size: 0.72rem;
        color: var(--gray-text);
    }
    .qty-badge {
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 3px 10px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    /* Order Summary */
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        color: var(--gray-text);
        font-size: 0.85rem;
    }
    .summary-row.total {
        border-top: 2px dashed #E0E0E0;
        margin-top: 8px;
        padding-top: 12px;
        font-weight: 700;
        color: var(--primary-green);
        font-size: 1.05rem;
    }

    /* Timeline */
    .order-timeline {
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
    }
    .order-timeline::before {
        content: '';
        position: absolute;
        left: 13px;
        top: 10px;
        bottom: 10px;
        width: 2px;
        background: linear-gradient(180deg, var(--primary-green), var(--pale-green));
    }
    .order-timeline li {
        position: relative;
        padding: 0 0 14px 40px;
    }
    .order-timeline li:last-child {
        padding-bottom: 0;
    }
    .timeline-dot {
        position: absolute;
        left: 4px;
        top: 3px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--white);
        border: 3px solid var(--mint-green);
        z-index: 2;
    }
    .timeline-dot.done {
        background: var(--primary-green);
        border-color: var(--white);
        box-shadow: 0 0 0 2px var(--pale-green);
    }
    .timeline-dot.current {
        background: #FB8C00;
        border-color: var(--white);
        box-shadow: 0 0 0 2px #FFF3E0;
        animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }
    .timeline-content h6 {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 1px;
    }
    .timeline-content p {
        font-size: 0.72rem;
        color: var(--gray-text);
        margin: 0;
        line-height: 1.3;
    }
    .timeline-content .tl-time {
        font-size: 0.66rem;
        color: #999;
        display: block;
        margin-top: 2px;
    }

    /* Action Buttons */
    .quick-actions-panel {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    .action-btn-full {
        padding: 10px 14px;
        border-radius: 10px;
        border: none;
        color: var(--white);
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        text-align: center;
        line-height: 1.2;
    }
    .action-btn-full.wide {
        grid-column: 1 / -1;
    }
    .btn-update { background: linear-gradient(135deg, #1976D2, #42A5F5); }
    .btn-assign { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }
    .btn-print { background: linear-gradient(135deg, #455A64, #78909C); }
    .btn-cancel-order { background: linear-gradient(135deg, #C62828, #EF5350); }
    .action-btn-full:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        color: var(--white);
    }

    /* Prescription Badge */
    .prescription-preview {
        background: var(--pale-green);
        border: 2px dashed var(--primary-green);
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
    }
    .prescription-preview:hover {
        background: var(--mint-green);
    }
    .prescription-preview img {
        max-width: 100%;
        max-height: 150px;
        border-radius: 8px;
        margin-bottom: 8px;
    }
    .prescription-preview i {
        font-size: 3rem;
        color: var(--primary-green);
        margin-bottom: 8px;
    }
    .prescription-preview p {
        margin: 0;
        font-size: 0.82rem;
        color: var(--primary-green);
        font-weight: 600;
    }

    /* Status Modal */
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
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
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
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
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

    @media print {
        .sidebar, .topbar, .back-btn, .quick-actions-panel, .no-print {
            display: none !important;
        }
        .main-content { margin-left: 0 !important; }
        .page-content { padding: 20px !important; }
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

$strings = GoogleTranslator::translateBatch([
    'back_orders'        => 'Back to Orders',
    'order_details'      => 'Order Details',
    'placed_on'          => 'Placed on',
    'order_status'       => 'Order Status',
    'customer_info'      => 'Customer Information',
    'phone'              => 'Phone',
    'email'              => 'Email',
    'delivery_address'   => 'Delivery Address',
    'customer_notes'     => 'Customer Notes',
    'order_items'        => 'Order Items',
    'th_product'         => 'Product',
    'th_qty'             => 'Qty',
    'th_price'           => 'Price',
    'th_total'           => 'Total',
    'subtotal'           => 'Subtotal',
    'delivery_fee'       => 'Delivery Fee',
    'tax_gst'            => 'Tax (GST)',
    'discount'           => 'Discount',
    'total_amount'       => 'Total Amount',
    'prescription'       => 'Prescription Attached',
    'view_full'          => 'Click to view full size',
    'quick_actions'      => 'Quick Actions',
    'update_status'      => 'Update Status',
    'assign_delivery'    => 'Assign Delivery Partner',
    'print_invoice'      => 'Print Invoice',
    'cancel_order'       => 'Cancel Order',
    'payment_details'    => 'Payment Details',
    'payment_method'     => 'Payment Method',
    'payment_status'     => 'Payment Status',
    'pharmacy_details'   => 'Pharmacy Details',
    'pharmacy_name'      => 'Pharmacy Name',
    'contact'            => 'Contact',
    'address'            => 'Address',
    'delivery_partner'   => 'Delivery Partner',
    'order_timeline'     => 'Order Timeline',
    'current_status'     => 'Current Status',
    'completed'          => 'Completed',
    'pending'            => 'Pending',
    'st_pending'         => 'Order Placed',
    'st_pending_desc'    => 'Order received and awaiting confirmation',
    'st_confirmed'       => 'Order Confirmed',
    'st_confirmed_desc'  => 'Confirmed by pharmacy',
    'st_processing'      => 'Processing',
    'st_processing_desc' => 'Being prepared by pharmacy',
    'st_out'             => 'Out for Delivery',
    'st_out_desc'        => 'Assigned to delivery partner',
    'st_delivered'       => 'Delivered',
    'st_delivered_desc'  => 'Successfully delivered',
    'st_cancelled'       => 'Cancelled',
    'st_cancelled_desc'  => 'Order cancelled',
    'modal_update_title'=> 'Update Order Status',
    'modal_select_desc' => 'Select the new status for this order.',
    'modal_note_label'  => 'Add a note (optional)',
    'modal_note_ph'     => 'Add a note for the customer...',
    'btn_cancel'        => 'Cancel',
    'btn_update'        => 'Update Status',
    'assign_modal_title'=> 'Assign Delivery Partner',
    'select_partner'    => 'Select Delivery Partner',
    'choose_partner'    => '-- Choose a partner --',
    'btn_assign'        => 'Assign',
    'err_select_partner'=> '⚠ Please select a delivery partner.',
    'js_updating'       => 'Updating...',
    'js_assigning'      => 'Assigning...',
    'js_cancel_confirm' => 'Are you sure you want to cancel this order? This action cannot be undone.',
    'js_select_status'  => 'Please select a status.'
]);

$order = $order ?? (object)[
    'id' => 1,
    'created_at' => now()->subHours(4),
    'status' => 'processing',
    'payment_method' => 'cod',
    'payment_status' => 'pending',
    'total_amount' => 1580,
    'subtotal' => 1450,
    'delivery_fee' => 50,
    'discount' => 0,
    'tax' => 80,
    'delivery_address' => 'House No. 45, Gandhi Road, Near Sai Temple, Nashik, Maharashtra - 422001',
    'notes' => 'Please deliver in the evening after 6 PM. Ring the bell twice.',
    'prescription' => null,
];

$customer = $customer ?? (object)[
    'name' => 'Ramesh Patil',
    'phone' => '9876543210',
    'email' => 'ramesh.patil@example.com',
    'village' => (object)['name' => 'Nashik']
];

$items = $items ?? [
    (object)['medicine_name'=>'Paracetamol 500mg', 'medicine_brand'=>'Crocin', 'unit_price'=>25, 'quantity'=>4, 'total_price'=>100, 'image'=>null],
    (object)['medicine_name'=>'Vitamin C 500mg', 'medicine_brand'=>'Limcee', 'unit_price'=>180, 'quantity'=>2, 'total_price'=>360, 'image'=>null],
];

$pharmacy = $pharmacy ?? (object)['pharmacy_name'=>'MediCare Pharmacy', 'phone'=>'9812345678', 'address'=>'Main Market, Nashik'];
$deliveryPartner = $deliveryPartner ?? null;

$currentStatus = strtolower(str_replace(' ', '_', $order->status));
$statuses = [
    'pending'          => ['label'=>$strings['st_pending'],    'icon'=>'fa-clock',        'desc'=>$strings['st_pending_desc']],
    'confirmed'        => ['label'=>$strings['st_confirmed'],  'icon'=>'fa-check',        'desc'=>$strings['st_confirmed_desc']],
    'processing'       => ['label'=>$strings['st_processing'], 'icon'=>'fa-cogs',         'desc'=>$strings['st_processing_desc']],
    'out_for_delivery' => ['label'=>$strings['st_out'],        'icon'=>'fa-motorcycle',   'desc'=>$strings['st_out_desc']],
    'delivered'        => ['label'=>$strings['st_delivered'],  'icon'=>'fa-check-circle', 'desc'=>$strings['st_delivered_desc']],
];

$statusKeys = array_keys($statuses);
$currentIndex = array_search($currentStatus, $statusKeys);
if ($currentIndex === false) $currentIndex = 0;
@endphp

<a href="{{ url('/admin/orders') }}" class="back-btn no-print">
    <i class="fas fa-arrow-left"></i> {{ $strings['back_orders'] }}
</a>

<!-- ============ ORDER HEADER ============ -->
<div class="order-header-card" data-aos="fade-up">
    <div class="row align-items-center g-3">
        <div class="col-md-8">
            <div class="order-header-info">
                <h3><i class="fas fa-receipt me-2"></i>Order #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h3>
                <p>
                    <i class="fas fa-calendar"></i> {{ $strings['placed_on'] }} {{ date('d M Y, h:i A', strtotime($order->created_at)) }}
                </p>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            @php
                $stIcon = $statuses[$currentStatus]['icon'] ?? 'fa-clock';
            @endphp
            <span class="order-status-big">
                <i class="fas {{ $stIcon }}"></i> {{ $statuses[$currentStatus]['label'] ?? ucfirst(str_replace('_', ' ', $order->status)) }}
            </span>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- ============ LEFT COLUMN ============ -->
    <div class="col-lg-8">

        <!-- Customer Information -->
        <div class="info-block" data-aos="fade-up">
            <h6><i class="fas fa-user"></i> {{ $strings['customer_info'] }}</h6>

            <div class="customer-detail">
                <div class="customer-avatar-lg">{{ strtoupper(substr($customer->name ?? 'C', 0, 1)) }}</div>
                <div class="cd-info">
                    <h5>{{ GoogleTranslator::translate($customer->name ?? 'Unknown') }}</h5>
                    <span><i class="fas fa-map-marker-alt me-1"></i> {{ GoogleTranslator::translate($customer->village->name ?? 'N/A') }}</span>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-icon-sm"><i class="fas fa-phone"></i></div>
                        <div class="info-text">
                            <div class="label">{{ $strings['phone'] }}</div>
                            <div class="value"><a href="tel:{{ $customer->phone ?? '' }}">{{ $customer->phone ?? 'N/A' }}</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-icon-sm"><i class="fas fa-envelope"></i></div>
                        <div class="info-text">
                            <div class="label">{{ $strings['email'] }}</div>
                            <div class="value"><a href="mailto:{{ $customer->email ?? '' }}">{{ $customer->email ?? 'N/A' }}</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="info-row">
                        <div class="info-icon-sm"><i class="fas fa-home"></i></div>
                        <div class="info-text">
                            <div class="label">{{ $strings['delivery_address'] }}</div>
                            <div class="value">{{ GoogleTranslator::translate($order->delivery_address ?? 'N/A') }}</div>
                        </div>
                    </div>
                </div>
                @if(!empty($order->notes))
                <div class="col-12">
                    <div class="info-row">
                        <div class="info-icon-sm" style="background:#FFF3E0;color:#FB8C00;"><i class="fas fa-sticky-note"></i></div>
                        <div class="info-text">
                            <div class="label">{{ $strings['customer_notes'] }}</div>
                            <div class="value">{{ GoogleTranslator::translate($order->notes) }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="info-block" data-aos="fade-up" data-aos-delay="100">
            {{-- Fixed item count logic --}}
            <h6><i class="fas fa-shopping-bag"></i> {{ $strings['order_items'] }} ({{ is_array($items) ? count($items) : $items->count() }})</h6>

            <div class="table-responsive">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>{{ $strings['th_product'] }}</th>
                            <th class="text-center">{{ $strings['th_qty'] }}</th>
                            <th class="text-end">{{ $strings['th_price'] }}</th>
                            <th class="text-end">{{ $strings['th_total'] }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>
                                    <div class="item-info">
                                        <div class="item-img">
                                            @if(!empty($item->image) && file_exists(public_path('images/'.$item->image)))
                                                <img src="{{ asset('images/'.$item->image) }}" alt="{{ $item->medicine_name }}">
                                            @else
                                                <i class="fas fa-pills"></i>
                                            @endif
                                        </div>
                                        <div>
                                            {{-- Directly using your database columns --}}
                                            <span class="item-name">{{ GoogleTranslator::translate($item->medicine_name ?? 'Unknown') }}</span>
                                            <span class="item-brand">{{ GoogleTranslator::translate($item->medicine_brand ?? 'Generic') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><span class="qty-badge">×{{ $item->quantity }}</span></td>
                                <td class="text-end">₹{{ number_format($item->unit_price ?? 0, 2) }}</td>
                                <td class="text-end" style="font-weight:700;color:var(--primary-green);">₹{{ number_format($item->total_price ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    No items found in this order.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="padding:16px 0 0;border-top:2px dashed var(--pale-green);margin-top:8px;">
                <div class="row justify-content-end">
                    <div class="col-md-6">
                        <div class="summary-row">
                            <span>{{ $strings['subtotal'] }}</span>
                            <span>₹{{ number_format($order->subtotal ?? 0, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>{{ $strings['delivery_fee'] }}</span>
                            <span>₹{{ number_format($order->delivery_fee ?? 0, 2) }}</span>
                        </div>
                        @if(!empty($order->tax) && $order->tax > 0)
                        <div class="summary-row">
                            <span>{{ $strings['tax_gst'] }}</span>
                            <span>₹{{ number_format($order->tax, 2) }}</span>
                        </div>
                        @endif
                        @if(!empty($order->discount) && $order->discount > 0)
                        <div class="summary-row" style="color:#2E7D32;">
                            <span>{{ $strings['discount'] }}</span>
                            <span>- ₹{{ number_format($order->discount, 2) }}</span>
                        </div>
                        @endif
                        <div class="summary-row total">
                            <span>{{ $strings['total_amount'] }}</span>
                            <span>₹{{ number_format($order->total_amount ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prescription -->
        @if(!empty($order->prescription))
        <div class="info-block" data-aos="fade-up" data-aos-delay="150">
            <h6><i class="fas fa-file-prescription"></i> {{ $strings['prescription'] }}</h6>
            <div class="prescription-preview" onclick="window.open('{{ asset('uploads/prescriptions/'.$order->prescription) }}', '_blank')">
                @if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $order->prescription))
                <img src="{{ asset('uploads/prescriptions/'.$order->prescription) }}" alt="Prescription">
                @else
                <i class="fas fa-file-pdf"></i>
                @endif
                <p><i class="fas fa-eye me-1"></i> {{ $strings['view_full'] }}</p>
            </div>
        </div>
        @endif

    </div>

    <!-- ============ RIGHT COLUMN ============ -->
    <div class="col-lg-4">

        <!-- Quick Actions -->
        <div class="info-block quick-actions-panel no-print" data-aos="fade-up" style="display:block;">
            <h6 style="margin-bottom:12px;"><i class="fas fa-bolt"></i> {{ $strings['quick_actions'] }}</h6>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                <button type="button" class="action-btn-full btn-update wide" id="updateStatusBtn"
                    data-current="{{ $currentStatus }}">
                    <i class="fas fa-edit"></i> {{ $strings['update_status'] }}
                </button>

                @if($currentStatus == 'confirmed' || $currentStatus == 'processing')
                <button type="button" class="action-btn-full btn-assign wide" data-bs-toggle="modal" data-bs-target="#assignModal">
                    <i class="fas fa-motorcycle"></i> {{ $strings['assign_delivery'] }}
                </button>
                @endif

                <button type="button" class="action-btn-full btn-print" onclick="window.print()">
                    <i class="fas fa-print"></i> {{ $strings['print_invoice'] }}
                </button>

                @if($currentStatus != 'delivered' && $currentStatus != 'cancelled')
                <button type="button" class="action-btn-full btn-cancel-order" id="cancelOrderBtn">
                    <i class="fas fa-times-circle"></i> {{ $strings['cancel_order'] }}
                </button>
                @endif
            </div>
        </div>

        <!-- Payment + Pharmacy -->
        <div class="info-block" data-aos="fade-up" data-aos-delay="80">
            <h6>
                <span><i class="fas fa-money-check"></i> {{ $strings['payment_details'] }}</span>
                <span class="h6-tag">{{ strtoupper($order->payment_method ?? 'COD') }}</span>
            </h6>

            <div class="meta-grid">
                <div class="meta-item">
                    <div class="mi-icon"><i class="fas fa-credit-card"></i></div>
                    <div class="mi-body">
                        <div class="mi-label">{{ $strings['payment_method'] }}</div>
                        <div class="mi-value">{{ strtoupper($order->payment_method ?? 'COD') }}</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="mi-icon" style="background:{{ ($order->payment_status ?? 'pending')=='paid' ? '#E8F5E9' : '#FFF3E0' }};color:{{ ($order->payment_status ?? 'pending')=='paid' ? '#2E7D32' : '#FB8C00' }};">
                        <i class="fas {{ ($order->payment_status ?? 'pending')=='paid' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                    </div>
                    <div class="mi-body">
                        <div class="mi-label">{{ $strings['payment_status'] }}</div>
                        <div class="mi-value" style="color:{{ ($order->payment_status ?? 'pending')=='paid' ? '#2E7D32' : '#FB8C00' }};">
                            {{ strtoupper($order->payment_status ?? 'PENDING') }}
                        </div>
                    </div>
                </div>
                <div class="meta-item full">
                    <div class="mi-icon" style="background:#E8F5E9;color:#2E7D32;"><i class="fas fa-rupee-sign"></i></div>
                    <div class="mi-body">
                        <div class="mi-label">{{ $strings['total_amount'] }}</div>
                        <div class="mi-value money">₹{{ number_format($order->total_amount ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pharmacy Details -->
        <div class="info-block" data-aos="fade-up" data-aos-delay="140">
            <h6><i class="fas fa-store"></i> {{ $strings['pharmacy_details'] }}</h6>

            <div class="meta-grid single">
                <div class="meta-item">
                    <div class="mi-icon"><i class="fas fa-hospital"></i></div>
                    <div class="mi-body">
                        <div class="mi-label">{{ $strings['pharmacy_name'] }}</div>
                        <div class="mi-value">{{ GoogleTranslator::translate($pharmacy->pharmacy_name ?? 'N/A') }}</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="mi-icon"><i class="fas fa-phone"></i></div>
                    <div class="mi-body">
                        <div class="mi-label">{{ $strings['contact'] }}</div>
                        <div class="mi-value"><a href="tel:{{ $pharmacy->phone ?? '' }}" style="color:var(--primary-green);text-decoration:none;">{{ $pharmacy->phone ?? 'N/A' }}</a></div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="mi-icon"><i class="fas fa-map-pin"></i></div>
                    <div class="mi-body">
                        <div class="mi-label">{{ $strings['address'] }}</div>
                        <div class="mi-value">{{ GoogleTranslator::translate($pharmacy->address ?? 'N/A') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Partner (if assigned) -->
        @if(!empty($deliveryPartner))
        <div class="info-block" data-aos="fade-up" data-aos-delay="180">
            <h6><i class="fas fa-motorcycle"></i> {{ $strings['delivery_partner'] }}</h6>

            <div class="customer-detail" style="margin-bottom:0;">
                <div class="customer-avatar-lg" style="background:linear-gradient(135deg,#7B1FA2,#AB47BC);">
                    {{ strtoupper(substr($deliveryPartner->name, 0, 1)) }}
                </div>
                <div class="cd-info">
                    <h5>{{ GoogleTranslator::translate($deliveryPartner->name) }}</h5>
                    <span><i class="fas fa-phone me-1"></i> {{ $deliveryPartner->phone }}</span>
                    <span><i class="fas fa-motorcycle me-1"></i> {{ $deliveryPartner->vehicle_number ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Order Timeline -->
        <div class="info-block" data-aos="fade-up" data-aos-delay="220">
            <h6><i class="fas fa-history"></i> {{ $strings['order_timeline'] }}</h6>

            <ul class="order-timeline">
                @foreach($statuses as $key => $st)
                @php
                $idx = array_search($key, $statusKeys);
                $isDone = $idx < $currentIndex;
                    $isCurrent=$idx==$currentIndex;
                    @endphp
                    <li>
                    <div class="timeline-dot {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}"></div>
                    <div class="timeline-content">
                        <h6>{{ $st['label'] }}</h6>
                        <p>{{ $st['desc'] }}</p>
                        @if($isCurrent)
                        <span class="tl-time" style="color:#FB8C00;font-weight:600;"><i class="fas fa-circle me-1" style="font-size:0.45rem;"></i> {{ $strings['current_status'] }}</span>
                        @elseif($isDone)
                        <span class="tl-time"><i class="fas fa-check me-1" style="color:#2E7D32;"></i> {{ $strings['completed'] }}</span>
                        @else
                        <span class="tl-time"><i class="fas fa-hourglass-half me-1"></i> {{ $strings['pending'] }}</span>
                        @endif
                    </div>
                    </li>
                    @endforeach
            </ul>
        </div>

    </div>
</div>

<!-- ============ STATUS UPDATE MODAL ============ -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> {{ $strings['modal_update_title'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusUpdateForm" action="{{ url('/admin/order/update-status') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="modal-body" style="padding:25px;">
                    <p class="text-muted mb-3">{{ $strings['modal_select_desc'] }}</p>

                    @foreach(['pending'=>['FB8C00','fa-clock',$strings['st_pending'],$strings['st_pending_desc']],
                    'confirmed'=>['1976D2','fa-check',$strings['st_confirmed'],$strings['st_confirmed_desc']],
                    'processing'=>['7B1FA2','fa-cogs',$strings['st_processing'],$strings['st_processing_desc']],
                    'out_for_delivery'=>['C2185B','fa-motorcycle',$strings['st_out'],$strings['st_out_desc']],
                    'delivered'=>['2E7D32','fa-check-circle',$strings['st_delivered'],$strings['st_delivered_desc']],
                    'cancelled'=>['C62828','fa-times-circle',$strings['st_cancelled'],$strings['st_cancelled_desc']]] as $key=>$data)
                    <div class="status-option {{ $currentStatus==$key ? 'selected' : '' }}" data-status="{{ $key }}">
                        <input type="radio" name="status" value="{{ $key }}" {{ $currentStatus==$key ? 'checked' : '' }}>
                        <div class="st-icon" style="background:#{{ $data[0] }};"><i class="fas {{ $data[1] }}"></i></div>
                        <div class="st-text">
                            <strong>{{ $data[2] }}</strong>
                            <span>{{ $data[3] }}</span>
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-3">
                        <label style="font-size:0.85rem;font-weight:600;color:var(--dark-text);">{{ $strings['modal_note_label'] }}</label>
                        <textarea name="note" class="filter-input" rows="2" placeholder="{{ $strings['modal_note_ph'] }}" style="width:100%;padding:10px 14px;border:2px solid #E8E8E8;border-radius:10px;font-size:0.88rem;margin-top:6px;font-family:'Poppins',sans-serif;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="back-btn" data-bs-dismiss="modal" style="margin:0;"><i class="fas fa-times"></i> {{ $strings['btn_cancel'] }}</button>
                    <button type="submit" class="action-btn-full btn-update" style="width:auto;padding:10px 25px;"><i class="fas fa-save"></i> {{ $strings['btn_update'] }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============ ASSIGN DELIVERY MODAL ============ -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title"><i class="fas fa-motorcycle me-2"></i> {{ $strings['assign_modal_title'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignForm" action="{{ url('/admin/order/assign-delivery') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="modal-body" style="padding:25px;">
                    <label style="font-size:0.85rem;font-weight:600;color:var(--dark-text);margin-bottom:8px;display:block;">{{ $strings['select_partner'] }} <span style="color:red;">*</span></label>
                    <select name="delivery_partner_id" id="deliverySelect" class="filter-select" style="width:100%;">
                        <option value="">{{ $strings['choose_partner'] }}</option>
                        @if(!empty($availablePartners))
                        @foreach($availablePartners as $dp)
                        <option value="{{ $dp->id }}">{{ $dp->name }} ({{ $dp->phone }}) - {{ $dp->vehicle_number }}</option>
                        @endforeach
                        @else
                        <option value="1">Sunil Kumar (9876543210) - MH-01-AB-1234</option>
                        <option value="2">Ravi Sharma (9812345678) - MH-02-CD-5678</option>
                        <option value="3">Amit Verma (9765432109) - MH-03-EF-9012</option>
                        @endif
                    </select>
                    <div id="assignError" style="color:#E53935;font-size:0.82rem;margin-top:8px;display:none;">{{ $strings['err_select_partner'] }}</div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="back-btn" data-bs-dismiss="modal" style="margin:0;"><i class="fas fa-times"></i> {{ $strings['btn_cancel'] }}</button>
                    <button type="submit" class="action-btn-full btn-assign" style="width:auto;padding:10px 25px;"><i class="fas fa-check"></i> {{ $strings['btn_assign'] }}</button>
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
            updating: @json($strings['js_updating']),
            assigning: @json($strings['js_assigning']),
            cancelConfirm: @json($strings['js_cancel_confirm']),
            selectStatus: @json($strings['js_select_status']),
            btnCancel: @json($strings['btn_cancel'])
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

            // Set icon and styling
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
                // Confirm style (Cancel + Yes button)
                btnGroup.append(`<button type="button" class="alert-btn-cancel" data-bs-dismiss="modal">${jsStrings.btnCancel}</button>`);
                btnGroup.append(`<button type="button" class="alert-btn-confirm" id="customAlertConfirmBtn">Yes, Cancel Order</button>`);
                
                $('#customAlertConfirmBtn').on('click', function() {
                    $('#customAlertModal').modal('hide');
                    if (onConfirm) onConfirm();
                });
            } else {
                // Standard alert (Just OK button)
                btnGroup.append(`<button type="button" class="alert-btn-ok" data-bs-dismiss="modal">OK</button>`);
            }

            $('#customAlertModal').modal('show');
        }

        // ==========================================
        // PAGE ACTIONS
        // ==========================================

        $('#updateStatusBtn').on('click', function() {
            $('#statusModal').modal('show');
        });

        $('.status-option').on('click', function() {
            $('.status-option').removeClass('selected');
            $(this).addClass('selected');
            $(this).find('input[type="radio"]').prop('checked', true);
        });

        $('#statusUpdateForm').on('submit', function(e) {
            var selected = $('input[name="status"]:checked').val();
            if (!selected) {
                e.preventDefault();
                showCustomAlert('warning', 'Status Required', jsStrings.selectStatus);
                return false;
            }
            var $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.updating);
        });

        $('#assignForm').on('submit', function(e) {
            var val = $('#deliverySelect').val();
            if (!val) {
                e.preventDefault();
                $('#assignError').fadeIn();
                return false;
            }
            var $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.assigning);
        });

        $('#deliverySelect').on('change', function() {
            if ($(this).val()) $('#assignError').hide();
        });

        // Cancel Order Button (Uses existing update-status route)
        $('#cancelOrderBtn').on('click', function() {
            showCustomAlert(
                'danger', 
                'Cancel Order?', 
                jsStrings.cancelConfirm, 
                true, 
                function() {
                    // Create a hidden form to submit the cancellation
                    var $form = $('<form>', {
                        method: 'POST',
                        action: '{{ url("/admin/order/update-status") }}'
                    });
                    
                    $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                    $form.append('<input type="hidden" name="order_id" value="{{ $order->id }}">');
                    $form.append('<input type="hidden" name="status" value="cancelled">');
                    
                    $('body').append($form);
                    $form.submit();
                }
            );
        });

    });
</script>
@endsection