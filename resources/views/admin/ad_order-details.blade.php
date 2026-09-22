@extends('layouts.admin')

@section('title', 'Order Details - Sanjivani Admin')
@section('page_title')
    <i class="fas fa-file-invoice"></i> Order Details
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
        margin-bottom: 20px;
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
        border-radius: 18px;
        padding: 25px 30px;
        margin-bottom: 25px;
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
        font-size: 10rem;
        opacity: 0.08;
    }

    .order-header-info h3 {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .order-header-info p {
        opacity: 0.85;
        font-size: 0.9rem;
        margin: 0;
    }

    .order-header-info p i {
        margin-right: 5px;
    }

    .order-status-big {
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.3);
        padding: 12px 25px;
        border-radius: 30px;
        font-size: 0.95rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* Info Cards */
    .info-block {
        background: var(--white);
        border-radius: 16px;
        padding: 22px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
    }

    .info-block h6 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 2px dashed var(--pale-green);
    }

    .info-block h6 i {
        color: var(--primary-green);
        margin-right: 8px;
    }

    /* Customer Info */
    .customer-detail {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-bottom: 20px;
    }

    .customer-avatar-lg {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        font-weight: 700;
    }

    .customer-detail .cd-info h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 3px;
    }

    .customer-detail .cd-info span {
        font-size: 0.82rem;
        color: var(--gray-text);
        display: block;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #F5F5F5;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row .info-icon-sm {
        width: 32px;
        height: 32px;
        min-width: 32px;
        border-radius: 8px;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }

    .info-row .info-text {
        flex: 1;
    }

    .info-row .info-text .label {
        font-size: 0.72rem;
        color: var(--gray-text);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .info-row .info-text .value {
        font-size: 0.9rem;
        color: var(--dark-text);
        font-weight: 500;
    }

    .info-row .info-text .value a {
        color: var(--primary-green);
        text-decoration: none;
    }

    .info-row .info-text .value a:hover {
        text-decoration: underline;
    }

    /* Items Table */
    .items-table {
        width: 100%;
        margin: 0;
    }

    .items-table thead th {
        background: var(--off-white);
        color: var(--gray-text);
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 15px;
        border-bottom: 1px solid #E0E0E0;
    }

    .items-table tbody td {
        padding: 15px;
        font-size: 0.88rem;
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
        gap: 12px;
    }

    .item-img {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-green);
        font-size: 1.1rem;
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
        font-size: 0.9rem;
    }

    .item-info .item-brand {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    /* Order Summary */
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        color: var(--gray-text);
        font-size: 0.9rem;
    }

    .summary-row.total {
        border-top: 2px dashed #E0E0E0;
        margin-top: 10px;
        padding-top: 15px;
        font-weight: 700;
        color: var(--primary-green);
        font-size: 1.2rem;
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
        left: 18px;
        top: 15px;
        bottom: 15px;
        width: 2px;
        background: linear-gradient(180deg, var(--primary-green), var(--pale-green));
    }

    .order-timeline li {
        position: relative;
        padding: 0 0 22px 55px;
    }

    .order-timeline li:last-child {
        padding-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: 8px;
        top: 5px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--white);
        border: 3px solid var(--mint-green);
        z-index: 2;
    }

    .timeline-dot.done {
        background: var(--primary-green);
        border-color: var(--white);
        box-shadow: 0 0 0 3px var(--pale-green);
    }

    .timeline-dot.current {
        background: #FB8C00;
        border-color: var(--white);
        box-shadow: 0 0 0 3px #FFF3E0;
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    .timeline-content h6 {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 3px;
    }

    .timeline-content p {
        font-size: 0.8rem;
        color: var(--gray-text);
        margin: 0;
    }

    .timeline-content .tl-time {
        font-size: 0.72rem;
        color: #999;
        display: block;
        margin-top: 3px;
    }

    /* Action Buttons */
    .quick-actions-panel {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .action-btn-full {
        padding: 12px 18px;
        border-radius: 12px;
        border: none;
        color: var(--white);
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-update  { background: linear-gradient(135deg, #1976D2, #42A5F5); }
    .btn-assign  { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }
    .btn-print   { background: linear-gradient(135deg, #455A64, #78909C); }
    .btn-cancel-order { background: linear-gradient(135deg, #C62828, #EF5350); }

    .action-btn-full:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
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

    /* Status Modal (same as orders page) */
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
    // Fallback demo data
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
        (object)['name'=>'Paracetamol 500mg', 'brand'=>'Crocin', 'price'=>25, 'quantity'=>4, 'total'=>100, 'image'=>null],
        (object)['name'=>'Vitamin C 500mg', 'brand'=>'Limcee', 'price'=>180, 'quantity'=>2, 'total'=>360, 'image'=>null],
        (object)['name'=>'Cough Syrup 100ml', 'brand'=>'Benadryl', 'price'=>145, 'quantity'=>3, 'total'=>435, 'image'=>null],
        (object)['name'=>'Antibiotic Tablets', 'brand'=>'Azithromycin', 'price'=>185, 'quantity'=>3, 'total'=>555, 'image'=>null],
    ];

    $pharmacy = $pharmacy ?? (object)['pharmacy_name'=>'MediCare Pharmacy', 'phone'=>'9812345678', 'address'=>'Main Market, Nashik'];
    $deliveryPartner = $deliveryPartner ?? null;

    $currentStatus = strtolower(str_replace(' ', '_', $order->status));
    $statuses = [
        'pending' => ['label'=>'Order Placed', 'icon'=>'fa-clock', 'desc'=>'Order received and awaiting confirmation'],
        'confirmed' => ['label'=>'Order Confirmed', 'icon'=>'fa-check', 'desc'=>'Confirmed by pharmacy'],
        'processing' => ['label'=>'Processing', 'icon'=>'fa-cogs', 'desc'=>'Being prepared by pharmacy'],
        'out_for_delivery' => ['label'=>'Out for Delivery', 'icon'=>'fa-motorcycle', 'desc'=>'Assigned to delivery partner'],
        'delivered' => ['label'=>'Delivered', 'icon'=>'fa-check-circle', 'desc'=>'Successfully delivered'],
    ];

    $statusKeys = array_keys($statuses);
    $currentIndex = array_search($currentStatus, $statusKeys);
    if ($currentIndex === false) $currentIndex = 0;
@endphp

<a href="{{ url('/admin/orders') }}" class="back-btn no-print">
    <i class="fas fa-arrow-left"></i> Back to Orders
</a>

<!-- ============ ORDER HEADER ============ -->
<div class="order-header-card" data-aos="fade-up">
    <div class="row align-items-center g-3">
        <div class="col-md-8">
            <div class="order-header-info">
                <h3><i class="fas fa-receipt me-2"></i>Order #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h3>
                <p>
                    <i class="fas fa-calendar"></i> Placed on {{ date('d M Y, h:i A', strtotime($order->created_at)) }}
                </p>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            @php
                $stColor = ['pending'=>'#FB8C00','confirmed'=>'#1976D2','processing'=>'#7B1FA2','out_for_delivery'=>'#C2185B','delivered'=>'#2E7D32','cancelled'=>'#C62828'];
                $stIcon = $statuses[$currentStatus]['icon'] ?? 'fa-clock';
            @endphp
            <span class="order-status-big">
                <i class="fas {{ $stIcon }}"></i> {{ ucfirst(str_replace('_', ' ', $order->status)) }}
            </span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- ============ LEFT COLUMN ============ -->
    <div class="col-lg-8">

        <!-- Customer Information -->
        <div class="info-block" data-aos="fade-up">
            <h6><i class="fas fa-user"></i> Customer Information</h6>

            <div class="customer-detail">
                <div class="customer-avatar-lg">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                <div class="cd-info">
                    <h5>{{ $customer->name }}</h5>
                    <span><i class="fas fa-map-marker-alt me-1"></i> {{ $customer->village->name ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-icon-sm"><i class="fas fa-phone"></i></div>
                        <div class="info-text">
                            <div class="label">Phone</div>
                            <div class="value"><a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <div class="info-icon-sm"><i class="fas fa-envelope"></i></div>
                        <div class="info-text">
                            <div class="label">Email</div>
                            <div class="value"><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="info-row">
                        <div class="info-icon-sm"><i class="fas fa-home"></i></div>
                        <div class="info-text">
                            <div class="label">Delivery Address</div>
                            <div class="value">{{ $order->delivery_address }}</div>
                        </div>
                    </div>
                </div>
                @if(!empty($order->notes))
                <div class="col-12">
                    <div class="info-row">
                        <div class="info-icon-sm" style="background:#FFF3E0;color:#FB8C00;"><i class="fas fa-sticky-note"></i></div>
                        <div class="info-text">
                            <div class="label">Customer Notes</div>
                            <div class="value">{{ $order->notes }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="info-block" data-aos="fade-up" data-aos-delay="100">
            <h6><i class="fas fa-shopping-bag"></i> Order Items ({{ count($items) }})</h6>

            <div class="table-responsive">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <div class="item-info">
                                        <div class="item-img">
                                            @if(!empty($item->image) && file_exists(public_path('uploads/medicines/'.$item->image)))
                                                <img src="{{ asset('uploads/medicines/'.$item->image) }}" alt="{{ $item->name }}">
                                            @else
                                                <i class="fas fa-pills"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="item-name">{{ $item->name }}</span>
                                            <span class="item-brand">{{ $item->brand ?? 'Generic' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><span class="items-badge" style="background:var(--pale-green);color:var(--primary-green);padding:4px 12px;border-radius:15px;font-weight:600;">×{{ $item->quantity }}</span></td>
                                <td class="text-end">₹{{ number_format($item->price, 2) }}</td>
                                <td class="text-end" style="font-weight:700;color:var(--primary-green);">₹{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:20px 0 0;border-top:2px dashed var(--pale-green);margin-top:10px;">
                <div class="row justify-content-end">
                    <div class="col-md-6">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($order->subtotal ?? array_sum(array_map(fn($i)=>$i->total, $items)), 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery Fee</span>
                            <span>₹{{ number_format($order->delivery_fee ?? 50, 2) }}</span>
                        </div>
                        @if(!empty($order->tax) && $order->tax > 0)
                        <div class="summary-row">
                            <span>Tax (GST)</span>
                            <span>₹{{ number_format($order->tax, 2) }}</span>
                        </div>
                        @endif
                        @if(!empty($order->discount) && $order->discount > 0)
                        <div class="summary-row" style="color:#2E7D32;">
                            <span>Discount</span>
                            <span>- ₹{{ number_format($order->discount, 2) }}</span>
                        </div>
                        @endif
                        <div class="summary-row total">
                            <span>Total Amount</span>
                            <span>₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prescription -->
        @if(!empty($order->prescription))
        <div class="info-block" data-aos="fade-up" data-aos-delay="150">
            <h6><i class="fas fa-file-prescription"></i> Prescription Attached</h6>
            <div class="prescription-preview" onclick="window.open('{{ asset('uploads/prescriptions/'.$order->prescription) }}', '_blank')">
                @if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $order->prescription))
                    <img src="{{ asset('uploads/prescriptions/'.$order->prescription) }}" alt="Prescription">
                @else
                    <i class="fas fa-file-pdf"></i>
                @endif
                <p><i class="fas fa-eye me-1"></i> Click to view full size</p>
            </div>
        </div>
        @endif

    </div>

    <!-- ============ RIGHT COLUMN ============ -->
    <div class="col-lg-4">

        <!-- Quick Actions -->
        <div class="info-block quick-actions-panel no-print" data-aos="fade-up">
            <h6 style="margin-bottom:15px;"><i class="fas fa-bolt"></i> Quick Actions</h6>

            <button type="button" class="action-btn-full btn-update" id="updateStatusBtn"
                    data-current="{{ $currentStatus }}">
                <i class="fas fa-edit"></i> Update Status
            </button>

            @if($currentStatus == 'confirmed' || $currentStatus == 'processing')
                <button type="button" class="action-btn-full btn-assign" data-bs-toggle="modal" data-bs-target="#assignModal">
                    <i class="fas fa-motorcycle"></i> Assign Delivery Partner
                </button>
            @endif

            <button type="button" class="action-btn-full btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> Print Invoice
            </button>

            @if($currentStatus != 'delivered' && $currentStatus != 'cancelled')
                <button type="button" class="action-btn-full btn-cancel-order" id="cancelOrderBtn">
                    <i class="fas fa-times-circle"></i> Cancel Order
                </button>
            @endif
        </div>

        <!-- Payment Information -->
        <div class="info-block" data-aos="fade-up" data-aos-delay="80">
            <h6><i class="fas fa-money-check"></i> Payment Details</h6>

            <div class="info-row">
                <div class="info-icon-sm"><i class="fas fa-credit-card"></i></div>
                <div class="info-text">
                    <div class="label">Payment Method</div>
                    <div class="value">{{ strtoupper($order->payment_method ?? 'COD') }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon-sm" style="background:{{ ($order->payment_status ?? 'pending')=='paid' ? '#E8F5E9' : '#FFF3E0' }};color:{{ ($order->payment_status ?? 'pending')=='paid' ? '#2E7D32' : '#FB8C00' }};">
                    <i class="fas {{ ($order->payment_status ?? 'pending')=='paid' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                </div>
                <div class="info-text">
                    <div class="label">Payment Status</div>
                    <div class="value" style="color:{{ ($order->payment_status ?? 'pending')=='paid' ? '#2E7D32' : '#FB8C00' }};font-weight:700;">
                        {{ strtoupper($order->payment_status ?? 'PENDING') }}
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon-sm"><i class="fas fa-rupee-sign"></i></div>
                <div class="info-text">
                    <div class="label">Total Amount</div>
                    <div class="value" style="font-size:1.15rem;font-weight:800;color:var(--primary-green);">₹{{ number_format($order->total_amount, 2) }}</div>
                </div>
            </div>
        </div>

        <!-- Pharmacy Info -->
        <div class="info-block" data-aos="fade-up" data-aos-delay="140">
            <h6><i class="fas fa-store"></i> Pharmacy Details</h6>

            <div class="info-row">
                <div class="info-icon-sm"><i class="fas fa-hospital"></i></div>
                <div class="info-text">
                    <div class="label">Pharmacy Name</div>
                    <div class="value">{{ $pharmacy->pharmacy_name ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon-sm"><i class="fas fa-phone"></i></div>
                <div class="info-text">
                    <div class="label">Contact</div>
                    <div class="value"><a href="tel:{{ $pharmacy->phone ?? '' }}">{{ $pharmacy->phone ?? 'N/A' }}</a></div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon-sm"><i class="fas fa-map-pin"></i></div>
                <div class="info-text">
                    <div class="label">Address</div>
                    <div class="value">{{ $pharmacy->address ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Delivery Partner (if assigned) -->
        @if(!empty($deliveryPartner))
        <div class="info-block" data-aos="fade-up" data-aos-delay="180">
            <h6><i class="fas fa-motorcycle"></i> Delivery Partner</h6>

            <div class="customer-detail">
                <div class="customer-avatar-lg" style="background:linear-gradient(135deg,#7B1FA2,#AB47BC);">
                    {{ strtoupper(substr($deliveryPartner->name, 0, 1)) }}
                </div>
                <div class="cd-info">
                    <h5>{{ $deliveryPartner->name }}</h5>
                    <span><i class="fas fa-phone me-1"></i> {{ $deliveryPartner->phone }}</span>
                    <span><i class="fas fa-motorcycle me-1"></i> {{ $deliveryPartner->vehicle_number ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Order Timeline -->
        <div class="info-block" data-aos="fade-up" data-aos-delay="220">
            <h6><i class="fas fa-history"></i> Order Timeline</h6>

            <ul class="order-timeline">
                @foreach($statuses as $key => $st)
                    @php
                        $idx = array_search($key, $statusKeys);
                        $isDone = $idx < $currentIndex;
                        $isCurrent = $idx == $currentIndex;
                    @endphp
                    <li>
                        <div class="timeline-dot {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}"></div>
                        <div class="timeline-content">
                            <h6>{{ $st['label'] }}</h6>
                            <p>{{ $st['desc'] }}</p>
                            @if($isCurrent)
                                <span class="tl-time" style="color:#FB8C00;font-weight:600;"><i class="fas fa-circle me-1" style="font-size:0.5rem;"></i> Current Status</span>
                            @elseif($isDone)
                                <span class="tl-time"><i class="fas fa-check me-1" style="color:#2E7D32;"></i> Completed</span>
                            @else
                                <span class="tl-time"><i class="fas fa-hourglass-half me-1"></i> Pending</span>
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
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusUpdateForm" action="{{ url('/admin/order/update-status') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="modal-body" style="padding:25px;">
                    <p class="text-muted mb-3">Select the new status for this order.</p>

                    @foreach(['pending'=>['FB8C00','fa-clock','Order received, awaiting confirmation'],
                              'confirmed'=>['1976D2','fa-check','Confirmed by pharmacy'],
                              'processing'=>['7B1FA2','fa-cogs','Being prepared'],
                              'out_for_delivery'=>['C2185B','fa-motorcycle','Assigned to delivery partner'],
                              'delivered'=>['2E7D32','fa-check-circle','Successfully delivered'],
                              'cancelled'=>['C62828','fa-times-circle','Order cancelled']] as $key=>$data)
                        <div class="status-option {{ $currentStatus==$key ? 'selected' : '' }}" data-status="{{ $key }}">
                            <input type="radio" name="status" value="{{ $key }}" {{ $currentStatus==$key ? 'checked' : '' }}>
                            <div class="st-icon" style="background:#{{ $data[0] }};"><i class="fas {{ $data[1] }}"></i></div>
                            <div class="st-text">
                                <strong>{{ ucfirst(str_replace('_',' ',$key)) }}</strong>
                                <span>{{ $data[2] }}</span>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-3">
                        <label style="font-size:0.85rem;font-weight:600;color:var(--dark-text);">Add a note (optional)</label>
                        <textarea name="note" class="filter-input" rows="2" placeholder="Add a note for the customer..." style="width:100%;padding:10px 14px;border:2px solid #E8E8E8;border-radius:10px;font-size:0.88rem;margin-top:6px;font-family:'Poppins',sans-serif;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="back-btn" data-bs-dismiss="modal" style="margin:0;"><i class="fas fa-times"></i> Cancel</button>
                    <button type="submit" class="action-btn-full btn-update" style="width:auto;padding:10px 25px;"><i class="fas fa-save"></i> Update Status</button>
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
                <h5 class="modal-title"><i class="fas fa-motorcycle me-2"></i> Assign Delivery Partner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="assignForm" action="{{ url('/admin/order/assign-delivery') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="modal-body" style="padding:25px;">
                    <label style="font-size:0.85rem;font-weight:600;color:var(--dark-text);margin-bottom:8px;display:block;">Select Delivery Partner <span style="color:red;">*</span></label>
                    <select name="delivery_partner_id" id="deliverySelect" class="filter-select" style="width:100%;">
                        <option value="">-- Choose a partner --</option>
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
                    <div id="assignError" style="color:#E53935;font-size:0.82rem;margin-top:8px;display:none;">⚠ Please select a delivery partner.</div>
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="back-btn" data-bs-dismiss="modal" style="margin:0;"><i class="fas fa-times"></i> Cancel</button>
                    <button type="submit" class="action-btn-full btn-assign" style="width:auto;padding:10px 25px;"><i class="fas fa-check"></i> Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* Open status modal */
    $('#updateStatusBtn').on('click', function () {
        $('#statusModal').modal('show');
    });

    /* Status option selection */
    $('.status-option').on('click', function () {
        $('.status-option').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    /* Status form submit */
    $('#statusUpdateForm').on('submit', function (e) {
        var selected = $('input[name="status"]:checked').val();
        if (!selected) {
            e.preventDefault();
            alert('Please select a status.');
            return false;
        }
        var $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
    });

    /* Assign delivery form validation */
    $('#assignForm').on('submit', function (e) {
        var val = $('#deliverySelect').val();
        if (!val) {
            e.preventDefault();
            $('#assignError').fadeIn();
            return false;
        }
        var $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Assigning...');
    });

    $('#deliverySelect').on('change', function () {
        if ($(this).val()) $('#assignError').hide();
    });

    /* Cancel Order */
    $('#cancelOrderBtn').on('click', function () {
        if (confirm('⚠ Are you sure you want to cancel this order?\nThis action cannot be undone.')) {
            var $form = $('<form>', {
                method: 'POST',
                action: '{{ url("/admin/order/cancel/".$order->id) }}'
            });
            $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            $('body').append($form);
            $form.submit();
        }
    });

});
</script>
@endsection