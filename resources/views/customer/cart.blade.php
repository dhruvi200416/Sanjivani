@extends('layouts.customer')

@section('title', 'My Cart')
@section('page_title')
<i class="fas fa-shopping-cart"></i> Shopping Cart
@endsection

@section('styles')
<style>
    /* Page Header */
    .cart-header {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        border-radius: 18px;
        padding: 25px 30px;
        margin-bottom: 25px;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .cart-header::after {
        content: '\f07a';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 30px;
        bottom: -30px;
        font-size: 9rem;
        opacity: 0.1;
    }

    .cart-header h3 {
        font-size: 1.7rem;
        font-weight: 800;
        margin: 0 0 5px;
    }

    .cart-header p {
        opacity: 0.9;
        font-size: 0.9rem;
        margin: 0;
    }

    .cart-header p span {
        font-weight: 700;
        background: rgba(255,255,255,0.2);
        padding: 3px 10px;
        border-radius: 15px;
        margin-left: 5px;
    }

    /* Cart Items Container */
    .cart-items-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .cart-items-header {
        background: var(--off-white);
        padding: 15px 20px;
        border-bottom: 1px solid #E0E0E0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-items-header h6 {
        margin: 0;
        font-weight: 700;
        color: var(--dark-text);
    }

    .cart-items-header h6 i {
        color: var(--primary-green);
        margin-right: 6px;
    }

    .btn-clear-cart {
        background: transparent;
        color: #C62828;
        border: none;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 8px;
        transition: var(--transition);
    }

    .btn-clear-cart:hover {
        background: #FFEBEE;
    }

    /* Cart Item */
    .cart-item {
        display: grid;
        grid-template-columns: 90px 1fr auto auto auto;
        gap: 20px;
        padding: 20px;
        border-bottom: 1px solid #F5F5F5;
        align-items: center;
        transition: var(--transition);
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item:hover {
        background: var(--off-white);
    }

    .cart-item-img {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .cart-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item-img i {
        font-size: 2.2rem;
        color: var(--accent-green);
    }

    .cart-item-info {
        flex: 1;
    }

    .cart-item-cat {
        display: inline-block;
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .cart-item-info h6 {
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 4px;
    }

    .cart-item-info h6 a {
        color: inherit;
        text-decoration: none;
    }

    .cart-item-info h6 a:hover {
        color: var(--primary-green);
    }

    .cart-item-brand {
        font-size: 0.78rem;
        color: var(--gray-text);
        margin-bottom: 4px;
    }

    .cart-item-brand i {
        color: var(--primary-green);
        margin-right: 4px;
    }

    .cart-item-stock {
        font-size: 0.72rem;
        color: #2E7D32;
        font-weight: 600;
    }

    .cart-item-stock.low {
        color: #FB8C00;
    }

    /* Price */
    .cart-item-price {
        text-align: center;
    }

    .cart-item-price .unit-price {
        font-size: 0.75rem;
        color: var(--gray-text);
        display: block;
    }

    .cart-item-price .price-val {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-green);
    }

    /* Quantity */
    .cart-qty-selector {
        display: flex;
        align-items: center;
        border: 2px solid var(--pale-green);
        border-radius: 22px;
        overflow: hidden;
    }

    .cart-qty-selector:focus-within {
        border-color: var(--primary-green);
    }

    .cart-qty-btn {
        background: var(--pale-green);
        border: none;
        color: var(--primary-green);
        width: 32px;
        height: 32px;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-qty-btn:hover:not(:disabled) {
        background: var(--primary-green);
        color: var(--white);
    }

    .cart-qty-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .cart-qty-input {
        width: 45px;
        height: 32px;
        border: none;
        text-align: center;
        font-weight: 700;
        font-size: 0.88rem;
        outline: none;
        color: var(--dark-text);
        background: var(--white);
    }

    /* Item Total */
    .cart-item-total {
        text-align: right;
        min-width: 90px;
    }

    .cart-item-total .total-lbl {
        font-size: 0.7rem;
        color: var(--gray-text);
        display: block;
    }

    .cart-item-total .total-val {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--dark-text);
    }

    /* Remove Button */
    .btn-remove-item {
        background: #FFEBEE;
        color: #C62828;
        border: none;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }

    .btn-remove-item:hover {
        background: #C62828;
        color: var(--white);
        transform: rotate(10deg);
    }

    /* Order Summary */
    .summary-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }

    .summary-header {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 18px 22px;
    }

    .summary-header h6 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .summary-body {
        padding: 22px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 0.9rem;
        color: var(--gray-text);
        border-bottom: 1px dashed #F5F5F5;
    }

    .summary-row:last-of-type {
        border-bottom: none;
    }

    .summary-row.discount {
        color: #2E7D32;
        font-weight: 600;
    }

    .summary-row.total-final {
        border-top: 2px solid var(--pale-green);
        margin-top: 10px;
        padding-top: 15px;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary-green);
        border-bottom: none;
    }

    /* Coupon */
    .coupon-section {
        padding: 15px 0;
        border-bottom: 1px dashed #E0E0E0;
        margin-bottom: 10px;
    }

    .coupon-section .coupon-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 8px;
        display: block;
    }

    .coupon-input-wrap {
        display: flex;
        gap: 8px;
    }

    .coupon-input {
        flex: 1;
        padding: 10px 14px;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-size: 0.85rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        text-transform: uppercase;
        transition: var(--transition);
    }

    .coupon-input:focus {
        border-color: var(--primary-green);
    }

    .coupon-input.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .coupon-input.success {
        border-color: var(--light-green);
        background: #F1F8E9;
    }

    .btn-apply-coupon {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.82rem;
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
    }

    .btn-apply-coupon:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(46,125,50,0.3);
    }

    .coupon-msg {
        font-size: 0.78rem;
        margin-top: 6px;
        display: none;
    }

    .coupon-msg.show { display: block; }
    .coupon-msg.success { color: #2E7D32; }
    .coupon-msg.error { color: #E53935; }

    .applied-coupon {
        background: #E8F5E9;
        border: 2px dashed #66BB6A;
        border-radius: 10px;
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
    }

    .applied-coupon .code-info strong {
        display: block;
        font-size: 0.82rem;
        color: #1B5E20;
        font-weight: 700;
    }

    .applied-coupon .code-info span {
        font-size: 0.72rem;
        color: #2E7D32;
    }

    .btn-remove-coupon {
        background: transparent;
        border: none;
        color: #C62828;
        cursor: pointer;
        font-size: 1rem;
    }

    /* Checkout Button */
    .btn-checkout {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.98rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 6px 15px rgba(46,125,50,0.25);
        margin-top: 15px;
        text-decoration: none;
    }

    .btn-checkout:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.35);
        color: var(--white);
    }

    .btn-continue-shopping {
        display: block;
        text-align: center;
        color: var(--primary-green);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 12px;
        padding: 8px;
        border-radius: 8px;
        transition: var(--transition);
    }

    .btn-continue-shopping:hover {
        background: var(--pale-green);
    }

    /* Free Shipping Progress */
    .free-shipping-bar {
        background: var(--pale-green);
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 15px;
    }

    .free-shipping-bar .fs-text {
        font-size: 0.82rem;
        color: var(--dark-text);
        margin-bottom: 8px;
    }

    .free-shipping-bar .fs-text.success {
        color: #2E7D32;
        font-weight: 600;
    }

    .fs-progress {
        height: 8px;
        background: var(--white);
        border-radius: 5px;
        overflow: hidden;
    }

    .fs-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-green), var(--light-green));
        border-radius: 5px;
        transition: width 0.5s;
    }

    /* Empty Cart */
    .empty-cart-state {
        background: var(--white);
        border-radius: 20px;
        padding: 80px 30px;
        text-align: center;
        box-shadow: var(--shadow);
    }

    .empty-cart-state .ec-icon {
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

    .empty-cart-state h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 8px;
    }

    .empty-cart-state p {
        color: var(--gray-text);
        margin-bottom: 25px;
        font-size: 0.95rem;
    }

    .empty-cart-state a {
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

    .empty-cart-state a:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(46,125,50,0.3);
        color: var(--white);
    }

    /* Available Coupons */
    .available-coupons-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        margin-top: 20px;
        overflow: hidden;
    }

    .available-coupons-card .header-c {
        padding: 15px 20px;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
    }

    .available-coupons-card .header-c h6 {
        margin: 0;
        font-weight: 700;
        color: var(--dark-text);
        font-size: 0.95rem;
    }

    .available-coupons-card .header-c h6 i {
        color: var(--primary-green);
        margin-right: 6px;
    }

    .coupon-item {
        padding: 15px 20px;
        border-bottom: 1px dashed #F5F5F5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .coupon-item:hover {
        background: var(--off-white);
    }

    .coupon-item:last-child {
        border-bottom: none;
    }

    .coupon-item .cp-info strong {
        display: block;
        font-size: 0.9rem;
        color: var(--dark-text);
        margin-bottom: 3px;
    }

    .coupon-item .cp-info span {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    .coupon-item .cp-code {
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        border: 1px dashed var(--primary-green);
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
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        z-index: 10000;
        display: none;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    @media (max-width: 991px) {
        .summary-card { position: static; margin-top: 25px; }
    }

    @media (max-width: 767px) {
        .cart-item {
            grid-template-columns: 70px 1fr auto;
            gap: 12px;
        }
        .cart-item-img { width: 70px; height: 70px; }
        .cart-item-price,
        .cart-qty-selector,
        .cart-item-total,
        .btn-remove-item {
            grid-column: 2 / -1;
        }
        .cart-item-price { text-align: left; margin-top: 5px; }
        .cart-qty-selector { justify-self: start; margin-top: 5px; }
        .cart-item-total { text-align: left; }
        .btn-remove-item {
            position: absolute;
            top: 20px;
            right: 20px;
            justify-self: end;
        }
        .cart-item { position: relative; }
    }
</style>
@endsection

@section('content')

@php
    // Demo cart data
    $cartItems = $cartItems ?? [
        (object)['id'=>1,'medicine_id'=>1,'name'=>'Paracetamol 500mg','brand'=>'Crocin','category'=>'Fever & Pain','price'=>25,'mrp'=>30,'quantity'=>2,'stock'=>150,'image'=>null],
        (object)['id'=>2,'medicine_id'=>2,'name'=>'Vitamin C 500mg','brand'=>'Limcee','category'=>'Vitamins','price'=>180,'mrp'=>200,'quantity'=>1,'stock'=>80,'image'=>null],
        (object)['id'=>3,'medicine_id'=>4,'name'=>'Cough Syrup 100ml','brand'=>'Benadryl','category'=>'Cold & Cough','price'=>145,'mrp'=>160,'quantity'=>1,'stock'=>15,'image'=>null],
    ];

    $subtotal = 0;
    $totalMrp = 0;
    foreach ($cartItems as $item) {
        $subtotal += $item->price * $item->quantity;
        $totalMrp += $item->mrp * $item->quantity;
    }

    $productDiscount = $totalMrp - $subtotal;
    $couponDiscount = session('cart_coupon_discount', 0);
    $couponCode = session('cart_coupon_code', '');
    $deliveryCharge = $subtotal >= 500 ? 0 : 50;
    $tax = round($subtotal * 0.05, 2); // 5% GST for demo
    $grandTotal = $subtotal + $deliveryCharge + $tax - $couponDiscount;

    $freeShippingRemaining = 500 - $subtotal;
    $freeShippingPercent = min(100, ($subtotal / 500) * 100);
@endphp

<!-- Cart Header -->
<div class="cart-header">
    <h3><i class="fas fa-shopping-cart me-2"></i> My Shopping Cart</h3>
    <p>You have <span>{{ count($cartItems) }} {{ count($cartItems) == 1 ? 'item' : 'items' }}</span> in your cart</p>
</div>

@if(count($cartItems) > 0)

<div class="row g-4">
    <!-- ============ CART ITEMS ============ -->
    <div class="col-lg-8">
        <div class="cart-items-card">
            <div class="cart-items-header">
                <h6><i class="fas fa-list"></i> Cart Items</h6>
                <button type="button" class="btn-clear-cart" id="clearCartBtn">
                    <i class="fas fa-trash-alt me-1"></i> Clear Cart
                </button>
            </div>

            @foreach($cartItems as $item)
                <div class="cart-item" data-cart-id="{{ $item->id }}" data-price="{{ $item->price }}" data-mrp="{{ $item->mrp }}" data-stock="{{ $item->stock }}">
                    <div class="cart-item-img">
                        @if(!empty($item->image) && file_exists(public_path('uploads/medicines/'.$item->image)))
                            <img src="{{ asset('uploads/medicines/'.$item->image) }}" alt="{{ $item->name }}">
                        @else
                            <i class="fas fa-pills"></i>
                        @endif
                    </div>

                    <div class="cart-item-info">
                        <span class="cart-item-cat">{{ $item->category }}</span>
                        <h6>
                            <a href="{{ url('/customer/medicine/'.$item->medicine_id) }}">{{ $item->name }}</a>
                        </h6>
                        <div class="cart-item-brand"><i class="fas fa-tag"></i> {{ $item->brand }}</div>
                        <div class="cart-item-stock {{ $item->stock < 20 ? 'low' : '' }}">
                            <i class="fas fa-check-circle"></i>
                            {{ $item->stock < 20 ? 'Only '.$item->stock.' left in stock' : 'In Stock' }}
                        </div>
                    </div>

                    <div class="cart-item-price">
                        <span class="unit-price">Unit Price</span>
                        <span class="price-val">₹{{ number_format($item->price, 2) }}</span>
                    </div>

                    <div class="cart-qty-selector">
                        <button type="button" class="cart-qty-btn qty-minus" {{ $item->quantity <= 1 ? 'disabled' : '' }}>−</button>
                        <input type="number" class="cart-qty-input qty-input" value="{{ $item->quantity }}" min="1" max="{{ $item->stock }}">
                        <button type="button" class="cart-qty-btn qty-plus" {{ $item->quantity >= $item->stock ? 'disabled' : '' }}>+</button>
                    </div>

                    <div class="cart-item-total">
                        <span class="total-lbl">Total</span>
                        <span class="total-val item-total">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>

                    <button type="button" class="btn-remove-item" title="Remove from cart">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Available Coupons -->
        <div class="available-coupons-card">
            <div class="header-c">
                <h6><i class="fas fa-tag"></i> Available Coupons</h6>
            </div>
            <div class="coupon-item apply-suggestion" data-code="SANJIVANI10">
                <div class="cp-info">
                    <strong>Get 10% OFF (Max ₹100)</strong>
                    <span>Applicable on orders above ₹300</span>
                </div>
                <span class="cp-code">SANJIVANI10</span>
            </div>
            <div class="coupon-item apply-suggestion" data-code="HEALTH50">
                <div class="cp-info">
                    <strong>Flat ₹50 OFF</strong>
                    <span>Applicable on orders above ₹500</span>
                </div>
                <span class="cp-code">HEALTH50</span>
            </div>
            <div class="coupon-item apply-suggestion" data-code="NEWUSER100">
                <div class="cp-info">
                    <strong>₹100 OFF for New Users</strong>
                    <span>Valid for first-time customers</span>
                </div>
                <span class="cp-code">NEWUSER100</span>
            </div>
        </div>
    </div>

    <!-- ============ ORDER SUMMARY ============ -->
    <div class="col-lg-4">
        <div class="summary-card">
            <div class="summary-header">
                <h6><i class="fas fa-receipt me-2"></i> Order Summary</h6>
            </div>

            <div class="summary-body">

                <!-- Free Shipping Progress -->
                @if($subtotal < 500)
                    <div class="free-shipping-bar">
                        <div class="fs-text">
                            Add <strong>₹{{ number_format($freeShippingRemaining, 2) }}</strong> more for <strong>FREE delivery!</strong>
                        </div>
                        <div class="fs-progress">
                            <div class="fs-fill" style="width: {{ $freeShippingPercent }}%;"></div>
                        </div>
                    </div>
                @else
                    <div class="free-shipping-bar">
                        <div class="fs-text success">
                            <i class="fas fa-check-circle me-1"></i> Congrats! You qualify for FREE delivery.
                        </div>
                    </div>
                @endif

                <!-- Coupon Code -->
                <div class="coupon-section">
                    <label class="coupon-label"><i class="fas fa-ticket me-1" style="color:var(--primary-green);"></i> Have a Coupon Code?</label>

                    @if(!empty($couponCode))
                        <div class="applied-coupon" id="appliedCouponBox">
                            <div class="code-info">
                                <strong><i class="fas fa-check-circle me-1"></i> {{ $couponCode }} Applied</strong>
                                <span>You saved ₹{{ number_format($couponDiscount, 2) }}</span>
                            </div>
                            <button type="button" class="btn-remove-coupon" id="removeCouponBtn" title="Remove coupon">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @else
                        <div class="coupon-input-wrap">
                            <input type="text" class="coupon-input" id="couponInput" placeholder="ENTER CODE" maxlength="20">
                            <button type="button" class="btn-apply-coupon" id="applyCouponBtn">Apply</button>
                        </div>
                        <div class="coupon-msg" id="couponMsg"></div>
                    @endif
                </div>

                <!-- Price Breakdown -->
                <div class="summary-row">
                    <span>Subtotal <span style="font-size:0.75rem;color:var(--gray-text);">({{ count($cartItems) }} items)</span></span>
                    <span id="summarySubtotal">₹{{ number_format($subtotal, 2) }}</span>
                </div>
                @if($productDiscount > 0)
                <div class="summary-row discount">
                    <span>Product Discount</span>
                    <span>− ₹{{ number_format($productDiscount, 2) }}</span>
                </div>
                @endif
                @if($couponDiscount > 0)
                <div class="summary-row discount" id="couponDiscountRow">
                    <span>Coupon Discount</span>
                    <span>− ₹{{ number_format($couponDiscount, 2) }}</span>
                </div>
                @endif
                <div class="summary-row">
                    <span>Delivery Charge</span>
                    <span id="summaryDelivery">
                        @if($deliveryCharge == 0)
                            <span style="color:#2E7D32;font-weight:600;">FREE</span>
                        @else
                            ₹{{ number_format($deliveryCharge, 2) }}
                        @endif
                    </span>
                </div>
                <div class="summary-row">
                    <span>Tax (GST 5%)</span>
                    <span id="summaryTax">₹{{ number_format($tax, 2) }}</span>
                </div>
                <div class="summary-row total-final">
                    <span>Grand Total</span>
                    <span id="summaryTotal">₹{{ number_format($grandTotal, 2) }}</span>
                </div>

                <a href="{{ url('/customer/checkout') }}" class="btn-checkout" id="proceedCheckoutBtn">
                    <i class="fas fa-lock"></i> Proceed to Checkout
                    <i class="fas fa-arrow-right ms-1"></i>
                </a>

                <a href="{{ url('/customer/medicines') }}" class="btn-continue-shopping">
                    <i class="fas fa-arrow-left me-1"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>

@else
    <!-- Empty Cart -->
    <div class="empty-cart-state">
        <div class="ec-icon">
            <i class="fas fa-cart-shopping"></i>
        </div>
        <h4>Your cart is empty</h4>
        <p>Looks like you haven't added any medicines to your cart yet. Start shopping now!</p>
        <a href="{{ url('/customer/medicines') }}">
            <i class="fas fa-pills"></i> Browse Medicines
        </a>
    </div>
@endif

<!-- Toast -->
<div class="cart-toast" id="cartToast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage">Cart updated!</span>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    var deliveryFreeThreshold = 500;
    var taxRate = 0.05;

    /* ============ QUANTITY UPDATE ============ */
    $('.qty-plus').on('click', function () {
        var $item = $(this).closest('.cart-item');
        var $input = $item.find('.qty-input');
        var stock = parseInt($item.data('stock'));
        var current = parseInt($input.val()) || 1;

        if (current < stock) {
            $input.val(current + 1);
            updateItemTotal($item);
            updateCartOnServer($item);
        }

        toggleQtyButtons($item);
    });

    $('.qty-minus').on('click', function () {
        var $item = $(this).closest('.cart-item');
        var $input = $item.find('.qty-input');
        var current = parseInt($input.val()) || 1;

        if (current > 1) {
            $input.val(current - 1);
            updateItemTotal($item);
            updateCartOnServer($item);
        }

        toggleQtyButtons($item);
    });

    $('.qty-input').on('input', function () {
        var $item = $(this).closest('.cart-item');
        var stock = parseInt($item.data('stock'));
        var v = parseInt($(this).val()) || 1;

        if (v < 1) v = 1;
        if (v > stock) {
            v = stock;
            showToast('⚠ Only ' + stock + ' items available in stock', 'error');
        }

        $(this).val(v);
        updateItemTotal($item);
        toggleQtyButtons($item);
    });

    $('.qty-input').on('change', function () {
        var $item = $(this).closest('.cart-item');
        updateCartOnServer($item);
    });

    function toggleQtyButtons($item) {
        var $input = $item.find('.qty-input');
        var stock = parseInt($item.data('stock'));
        var current = parseInt($input.val()) || 1;

        $item.find('.qty-minus').prop('disabled', current <= 1);
        $item.find('.qty-plus').prop('disabled', current >= stock);
    }

    function updateItemTotal($item) {
        var price = parseFloat($item.data('price'));
        var qty = parseInt($item.find('.qty-input').val()) || 1;
        var total = price * qty;
        $item.find('.item-total').text('₹' + total.toFixed(2));
        updateOrderSummary();
    }

    function updateOrderSummary() {
        var subtotal = 0;
        var totalMrp = 0;

        $('.cart-item').each(function () {
            var price = parseFloat($(this).data('price'));
            var mrp = parseFloat($(this).data('mrp'));
            var qty = parseInt($(this).find('.qty-input').val()) || 1;
            subtotal += price * qty;
            totalMrp += mrp * qty;
        });

        var deliveryCharge = subtotal >= deliveryFreeThreshold ? 0 : 50;
        var tax = subtotal * taxRate;
        var couponDiscount = parseFloat($('#couponDiscountRow').find('span:last').text().replace(/[^\d.]/g, '')) || 0;
        var grandTotal = subtotal + deliveryCharge + tax - couponDiscount;

        $('#summarySubtotal').text('₹' + subtotal.toFixed(2));
        $('#summaryTax').text('₹' + tax.toFixed(2));

        if (deliveryCharge == 0) {
            $('#summaryDelivery').html('<span style="color:#2E7D32;font-weight:600;">FREE</span>');
        } else {
            $('#summaryDelivery').text('₹' + deliveryCharge.toFixed(2));
        }

        $('#summaryTotal').text('₹' + grandTotal.toFixed(2));

        // Update free shipping bar
        var $fs = $('.free-shipping-bar');
        if (subtotal < deliveryFreeThreshold) {
            var remaining = deliveryFreeThreshold - subtotal;
            var pct = (subtotal / deliveryFreeThreshold) * 100;
            $fs.find('.fs-text').removeClass('success').html(
                'Add <strong>₹' + remaining.toFixed(2) + '</strong> more for <strong>FREE delivery!</strong>'
            );
            $fs.find('.fs-fill').css('width', pct + '%');
        } else {
            $fs.find('.fs-text').addClass('success').html(
                '<i class="fas fa-check-circle me-1"></i> Congrats! You qualify for FREE delivery.'
            );
            $fs.find('.fs-fill').css('width', '100%');
        }
    }

    function updateCartOnServer($item) {
        var cartId = $item.data('cart-id');
        var qty = parseInt($item.find('.qty-input').val()) || 1;

        $.ajax({
            url: '{{ url("/customer/cart/update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_id: cartId,
                quantity: qty
            },
            dataType: 'json',
            success: function (res) {
                if (!res.success) {
                    showToast('⚠ ' + (res.message || 'Failed to update'), 'error');
                }
            },
            error: function () {
                // Silent fail for demo
            }
        });
    }

    /* ============ REMOVE ITEM ============ */
    $('.btn-remove-item').on('click', function () {
        var $item = $(this).closest('.cart-item');
        var cartId = $item.data('cart-id');
        var itemName = $item.find('h6').text().trim();

        if (!confirm('Remove "' + itemName + '" from cart?')) return;

        var $btn = $(this);
        $btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

        $.ajax({
            url: '{{ url("/customer/cart/remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_id: cartId
            },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $item.fadeOut(400, function () {
                        $(this).remove();
                        updateOrderSummary();
                        showToast('✓ Item removed from cart');

                        if ($('.cart-item').length === 0) {
                            location.reload();
                        }

                        // Update cart badges
                        if (res.cart_count !== undefined) {
                            if (res.cart_count > 0) {
                                $('.cart-badge, .cart-count').text(res.cart_count);
                            } else {
                                $('.cart-badge, .cart-count').hide();
                            }
                        }
                    });
                } else {
                    $btn.html('<i class="fas fa-trash"></i>').prop('disabled', false);
                    showToast('⚠ Failed to remove', 'error');
                }
            },
            error: function () {
                // Demo fallback
                $item.fadeOut(400, function () {
                    $(this).remove();
                    updateOrderSummary();
                    showToast('✓ Item removed from cart');
                    if ($('.cart-item').length === 0) {
                        location.reload();
                    }
                });
            }
        });
    });

    /* ============ CLEAR CART ============ */
    $('#clearCartBtn').on('click', function () {
        if (!confirm('⚠ Are you sure you want to clear your entire cart?\nThis will remove all items.')) return;

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Clearing...');

        var $form = $('<form>', { method: 'POST', action: '{{ url("/customer/cart/clear") }}' });
        $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
        $('body').append($form);
        $form.submit();
    });

    /* ============ COUPON: SUGGESTED COUPON CLICK ============ */
    $('.apply-suggestion').on('click', function () {
        var code = $(this).data('code');
        $('#couponInput').val(code);
        $('#applyCouponBtn').trigger('click');
    });

    /* ============ COUPON APPLY ============ */
    $('#applyCouponBtn').on('click', function () {
        var code = $.trim($('#couponInput').val()).toUpperCase();
        var $msg = $('#couponMsg');
        var $input = $('#couponInput');

        $msg.removeClass('show success error').text('');
        $input.removeClass('error success');

        if (code === '') {
            $msg.addClass('show error').text('⚠ Please enter a coupon code.');
            $input.addClass('error');
            return;
        }

        if (code.length < 4) {
            $msg.addClass('show error').text('⚠ Invalid coupon code.');
            $input.addClass('error');
            return;
        }

        var $btn = $(this);
        var original = $btn.text();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: '{{ url("/customer/cart/apply-coupon") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                coupon_code: code
            },
            dataType: 'json',
            success: function (res) {
                $btn.prop('disabled', false).text(original);

                if (res.success) {
                    $input.addClass('success');
                    $msg.addClass('show success').text('✓ ' + (res.message || 'Coupon applied successfully!'));
                    setTimeout(function () { location.reload(); }, 1500);
                } else {
                    $input.addClass('error');
                    $msg.addClass('show error').text('⚠ ' + (res.message || 'Invalid coupon code'));
                }
            },
            error: function () {
                $btn.prop('disabled', false).text(original);

                // Demo fallback: simulate coupon codes
                var validCoupons = {
                    'SANJIVANI10': { discount: 100, msg: '10% off applied!' },
                    'HEALTH50': { discount: 50, msg: '₹50 off applied!' },
                    'NEWUSER100': { discount: 100, msg: '₹100 off for new users!' }
                };

                if (validCoupons[code]) {
                    $input.addClass('success');
                    $msg.addClass('show success').text('✓ ' + validCoupons[code].msg);
                    setTimeout(function () { location.reload(); }, 1500);
                } else {
                    $input.addClass('error');
                    $msg.addClass('show error').text('⚠ Invalid or expired coupon code');
                }
            }
        });
    });

    /* ============ COUPON REMOVE ============ */
    $('#removeCouponBtn').on('click', function () {
        if (!confirm('Remove applied coupon?')) return;

        var $form = $('<form>', { method: 'POST', action: '{{ url("/customer/cart/remove-coupon") }}' });
        $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
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

        setTimeout(function () { $toast.fadeOut(300); }, 2500);
    }

    /* ============ COUPON INPUT UPPERCASE ============ */
    $('#couponInput').on('input', function () {
        var pos = this.selectionStart;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(pos, pos);
        $(this).removeClass('error success');
        $('#couponMsg').hide();
    });

});
</script>
@endsection