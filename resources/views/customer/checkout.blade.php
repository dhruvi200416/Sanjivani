@extends('layouts.customer')

@section('title', 'Checkout')
@section('page_title')
<i class="fas fa-credit-card"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('Checkout') }}
@endsection

@section('styles')
<style>
    /* Progress Steps */
    .checkout-steps {
        background: var(--white);
        border-radius: 16px;
        padding: 20px 30px;
        box-shadow: var(--shadow);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        position: relative;
    }

    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        right: -8px;
        top: 20px;
        width: calc(100% - 60px);
        height: 3px;
        background: #E0E0E0;
        border-radius: 3px;
        left: 60px;
    }

    .step-item.done:not(:last-child)::after {
        background: linear-gradient(90deg, var(--primary-green), var(--light-green));
    }

    .step-num-c {
        width: 45px;
        height: 45px;
        min-width: 45px;
        border-radius: 50%;
        background: #E0E0E0;
        color: var(--gray-text);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        transition: var(--transition);
        z-index: 2;
        position: relative;
    }

    .step-item.active .step-num-c {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        box-shadow: 0 4px 15px rgba(46,125,50,0.3);
    }

    .step-item.done .step-num-c {
        background: var(--primary-green);
        color: var(--white);
    }

    .step-info h6 {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 2px;
    }

    .step-info span {
        font-size: 0.72rem;
        color: var(--gray-text);
    }

    /* Section Card */
    .checkout-section {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .checkout-section-header {
        padding: 18px 22px;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .checkout-section-header h6 {
        margin: 0;
        font-weight: 700;
        color: var(--dark-text);
        font-size: 1rem;
    }

    .checkout-section-header h6 i {
        color: var(--primary-green);
        margin-right: 8px;
    }

    .checkout-section-header .btn-toggle-form {
        background: transparent;
        color: var(--primary-green);
        border: 1px solid var(--primary-green);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }

    .checkout-section-header .btn-toggle-form:hover {
        background: var(--primary-green);
        color: var(--white);
    }

    .checkout-section-body {
        padding: 22px;
    }

    /* Address Cards */
    .address-card {
        border: 2px solid #E0E0E0;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
    }

    .address-card:hover {
        border-color: var(--light-green);
    }

    .address-card.selected {
        border-color: var(--primary-green);
        background: var(--pale-green);
        box-shadow: 0 4px 15px rgba(46,125,50,0.1);
    }

    .address-card.selected::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 15px;
        right: 15px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: var(--primary-green);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }

    .address-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }

    .address-header input[type="radio"] {
        accent-color: var(--primary-green);
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .address-header strong {
        font-size: 0.95rem;
        color: var(--dark-text);
        font-weight: 700;
    }

    .address-header .addr-tag {
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .address-header .addr-tag.home { background: #E3F2FD; color: #1976D2; }
    .address-header .addr-tag.work { background: #FFF3E0; color: #FB8C00; }
    .address-header .addr-tag.other { background: #F3E5F5; color: #7B1FA2; }

    .address-details {
        padding-left: 28px;
        color: var(--gray-text);
        font-size: 0.87rem;
        line-height: 1.6;
    }

    .address-phone {
        display: block;
        margin-top: 4px;
        color: var(--dark-text);
        font-weight: 500;
    }

    .address-phone i {
        color: var(--primary-green);
        margin-right: 5px;
    }

    /* New Address Form */
    .new-address-form {
        display: none;
        padding-top: 15px;
        border-top: 2px dashed #E0E0E0;
        margin-top: 15px;
    }

    .new-address-form.show {
        display: block;
    }

    .form-group-co {
        margin-bottom: 15px;
    }

    .form-label-co {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 6px;
        display: block;
    }

    .form-label-co .req {
        color: #E53935;
    }

    .form-control-co {
        width: 100%;
        padding: 11px 14px;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        transition: var(--transition);
    }

    .form-control-co:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
    }

    .form-control-co.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .form-select-co {
        width: 100%;
        padding: 11px 14px;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        outline: none;
        background: var(--white);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 35px;
    }

    textarea.form-control-co {
        min-height: 70px;
        resize: vertical;
    }

    .err-msg-co {
        color: #E53935;
        font-size: 0.75rem;
        margin-top: 4px;
        display: none;
    }

    .err-msg-co.show { display: block; }

    /* Payment Method */
    .payment-option {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 15px 18px;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: var(--transition);
    }

    .payment-option:hover {
        border-color: var(--light-green);
    }

    .payment-option.selected {
        border-color: var(--primary-green);
        background: var(--pale-green);
    }

    .payment-option input[type="radio"] {
        accent-color: var(--primary-green);
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .pay-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.15rem;
    }

    .pay-icon.cod { background: linear-gradient(135deg, #FB8C00, #FFA726); }
    .pay-icon.online { background: linear-gradient(135deg, #1976D2, #42A5F5); }
    .pay-icon.upi { background: linear-gradient(135deg, #6A1B9A, #AB47BC); }
    .pay-icon.card { background: linear-gradient(135deg, #C62828, #EF5350); }

    .pay-info { flex: 1; }

    .pay-info strong {
        display: block;
        font-size: 0.92rem;
        color: var(--dark-text);
        font-weight: 700;
    }

    .pay-info span {
        font-size: 0.78rem;
        color: var(--gray-text);
    }

    .pay-badge {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
        color: var(--white);
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Order Review Items */
    .review-item {
        display: flex;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #F5F5F5;
        align-items: center;
    }

    .review-item:last-child { border-bottom: none; }

    .review-item .rv-img {
        width: 55px;
        height: 55px;
        border-radius: 10px;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .review-item .rv-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .review-item .rv-img i {
        font-size: 1.5rem;
        color: var(--accent-green);
    }

    .review-item .rv-info {
        flex: 1;
    }

    .review-item .rv-info strong {
        display: block;
        font-size: 0.9rem;
        color: var(--dark-text);
        font-weight: 700;
    }

    .review-item .rv-info span {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    .review-item .rv-qty {
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-right: 12px;
    }

    .review-item .rv-price {
        font-weight: 700;
        color: var(--primary-green);
        font-size: 0.95rem;
        white-space: nowrap;
    }

    /* Delivery Notes */
    .notes-section {
        margin-top: 15px;
    }

    /* Order Summary Sidebar */
    .summary-card-co {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }

    .summary-header-co {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 18px 22px;
    }

    .summary-header-co h6 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .summary-body-co {
        padding: 22px;
    }

    .summary-row-co {
        display: flex;
        justify-content: space-between;
        padding: 9px 0;
        font-size: 0.9rem;
        color: var(--gray-text);
        border-bottom: 1px dashed #F5F5F5;
    }

    .summary-row-co:last-of-type { border-bottom: none; }

    .summary-row-co.discount { color: #2E7D32; font-weight: 600; }

    .summary-row-co.total-final {
        border-top: 2px solid var(--pale-green);
        margin-top: 8px;
        padding-top: 15px;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary-green);
        border-bottom: none;
    }

    .btn-place-order {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 15px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 6px 15px rgba(46,125,50,0.25);
        margin-top: 15px;
    }

    .btn-place-order:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.35);
    }

    .btn-place-order:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-back-cart {
        display: block;
        text-align: center;
        color: var(--primary-green);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 12px;
        padding: 8px;
    }

    .btn-back-cart:hover {
        text-decoration: underline;
    }

    .secure-note {
        background: var(--pale-green);
        border-radius: 10px;
        padding: 12px;
        margin-top: 15px;
        text-align: center;
        font-size: 0.78rem;
        color: var(--dark-green);
    }

    .secure-note i {
        color: var(--primary-green);
        margin-right: 5px;
    }

    /* Terms Checkbox */
    .terms-check-co {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin: 15px 0;
        padding: 12px;
        background: var(--off-white);
        border-radius: 10px;
    }

    .terms-check-co input[type="checkbox"] {
        accent-color: var(--primary-green);
        width: 18px;
        height: 18px;
        cursor: pointer;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .terms-check-co label {
        font-size: 0.82rem;
        color: var(--dark-text);
        margin: 0;
        cursor: pointer;
        line-height: 1.5;
    }

    .terms-check-co a {
        color: var(--primary-green);
        font-weight: 600;
        text-decoration: none;
    }

    /* Prescription Upload */
    .prescription-notice {
        background: linear-gradient(135deg, #FFF3E0, #FFECB3);
        border-left: 4px solid #FB8C00;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .prescription-notice h6 {
        color: #E65100;
        font-weight: 700;
        margin: 0 0 5px;
        font-size: 0.92rem;
    }

    .prescription-notice p {
        color: #6D4C41;
        font-size: 0.82rem;
        margin: 0 0 10px;
    }

    .rx-upload-area {
        border: 2px dashed #FB8C00;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background: var(--white);
    }

    .rx-upload-area:hover {
        background: #FFF3E0;
    }

    .rx-upload-area i {
        font-size: 2rem;
        color: #FB8C00;
        margin-bottom: 5px;
    }

    .rx-upload-area p {
        margin: 0;
        color: #E65100;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.9);
        z-index: 10001;
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .loading-overlay.show {
        display: flex;
    }

    .loading-overlay .spinner {
        width: 60px;
        height: 60px;
        border: 5px solid var(--pale-green);
        border-top: 5px solid var(--primary-green);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .loading-overlay p {
        color: var(--primary-green);
        font-weight: 700;
        font-size: 1.05rem;
    }

    @media (max-width: 991px) {
        .summary-card-co { position: static; margin-top: 25px; }
        .checkout-steps { flex-direction: column; align-items: flex-start; }
        .step-item:not(:last-child)::after { display: none; }
    }

    @media (max-width: 576px) {
        .checkout-section-body { padding: 16px; }
        .payment-option { padding: 12px; }
    }

    /* ============ CUSTOM MODAL STYLES ============ */
    .custom-modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
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
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
    .custom-modal-icon.warning { background: #FFF3E0; color: #FB8C00; }
    .custom-modal-icon.success { background: #E8F5E9; color: #2E7D32; }
    .custom-modal-icon.error { background: #FFEBEE; color: #C62828; }
    
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
        box-shadow: 0 4px 10px rgba(46,125,50,0.3);
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

// Demo cart data
$cartItems = $cartItems ?? [
    (object)['id'=>1,'medicine_id'=>1,'name'=>'Paracetamol 500mg','brand'=>'Crocin','price'=>25,'mrp'=>30,'quantity'=>2,'image'=>null,'prescription_required'=>0],
    (object)['id'=>2,'medicine_id'=>2,'name'=>'Vitamin C 500mg','brand'=>'Limcee','price'=>180,'mrp'=>200,'quantity'=>1,'image'=>null,'prescription_required'=>0],
    (object)['id'=>3,'medicine_id'=>4,'name'=>'Cough Syrup 100ml','brand'=>'Benadryl','price'=>145,'mrp'=>160,'quantity'=>1,'image'=>null,'prescription_required'=>0],
];

$customer = $customer ?? (object)[
    'name' => session('customer_name') ?? 'Ramesh Patil',
    'phone' => '9876543210',
    'email' => 'ramesh@example.com'
];

$addresses = $addresses ?? [
    (object)['id'=>1,'name'=>'Ramesh Patil','phone'=>'9876543210','address_line'=>'House No. 45, Gandhi Road','landmark'=>'Near Sai Temple','city'=>'Nashik','state'=>'Maharashtra','pincode'=>'422001','type'=>'home','is_default'=>1],
    (object)['id'=>2,'name'=>'Ramesh Patil','phone'=>'9812345678','address_line'=>'Office Complex, 3rd Floor','landmark'=>'MG Road','city'=>'Nashik','state'=>'Maharashtra','pincode'=>'422002','type'=>'work','is_default'=>0],
];

$villages = $villages ?? [
    (object)['id'=>1,'name'=>'Nashik'],
    (object)['id'=>2,'name'=>'Pune'],
    (object)['id'=>3,'name'=>'Mumbai'],
    (object)['id'=>4,'name'=>'Aurangabad'],
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
$tax = round($subtotal * 0.05, 2);
$grandTotal = $subtotal + $deliveryCharge + $tax - $couponDiscount;

$hasRxItems = collect($cartItems)->contains(function($i) { return $i->prescription_required ?? false; });

$strings = GoogleTranslator::translateBatch([
    'steps_cart' => 'Cart',
    'steps_cart_sub' => 'Items reviewed',
    'steps_checkout' => 'Checkout',
    'steps_checkout_sub' => 'Address & Payment',
    'steps_conf' => 'Confirmation',
    'steps_conf_sub' => 'Order placed',
    
    'addr_title' => 'Delivery Address',
    'btn_add_new' => 'Add New',
    'btn_cancel' => 'Cancel',
    'lbl_default' => 'Default',
    'no_addr' => 'No saved addresses. Please add a new address below.',
    
    'form_add_title' => 'Add New Address',
    'lbl_name' => 'Full Name',
    'lbl_phone' => 'Mobile Number',
    'ph_phone' => '10-digit mobile',
    'lbl_addr_line' => 'Complete Address',
    'ph_addr_line' => 'House No., Street, Area',
    'lbl_landmark' => 'Landmark',
    'ph_landmark' => 'Near ...',
    'lbl_village' => 'Village/City',
    'select_placeholder' => '-- Select --',
    'lbl_state' => 'State',
    'lbl_pincode' => 'Pincode',
    'ph_pincode' => '6-digit pincode',
    'lbl_addr_type' => 'Address Type',
    'lbl_save_addr' => 'Save this address for future orders',
    
    'rx_title' => 'Prescription Required',
    'rx_desc' => "Some items in your cart require a valid doctor's prescription. Please upload a clear photo or PDF.",
    'rx_upload' => 'Click to upload prescription',
    'rx_format' => 'JPG, PNG or PDF (max 5MB)',
    
    'pay_title' => 'Payment Method',
    'pay_cod' => 'Cash on Delivery (COD)',
    'pay_cod_desc' => 'Pay when you receive your order',
    'pay_recommended' => 'Recommended',
    'pay_upi' => 'UPI Payment',
    'pay_upi_desc' => 'Google Pay, PhonePe, Paytm & more',
    'pay_card' => 'Debit / Credit Card',
    'pay_card_desc' => 'Visa, Mastercard, RuPay accepted',
    'pay_online' => 'Net Banking',
    'pay_online_desc' => 'All major banks supported',
    
    'review_title' => 'Review Your Order',
    'btn_edit_cart' => 'Edit Cart',
    'notes_title' => 'Delivery Instructions (Optional)',
    'notes_ph' => 'E.g., Deliver after 6 PM, Ring the bell twice, etc.',
    'notes_max' => 'Max 200 characters',
    
    'sum_title' => 'Price Details',
    'sum_subtotal' => 'Subtotal',
    'sum_discount' => 'Product Discount',
    'sum_coupon' => 'Coupon',
    'sum_delivery' => 'Delivery Charge',
    'sum_tax' => 'Tax (GST 5%)',
    'sum_total' => 'Total to Pay',
    'sum_free' => 'FREE',
    'sum_saving' => "🎉 You're saving ₹:amount on this order!",
    
    'terms_agree' => 'I agree to the',
    'terms_tnc' => 'Terms & Conditions',
    'terms_and' => 'and',
    'terms_return' => 'Return Policy',
    'terms_of' => 'of Sanjivani.',
    
    'btn_place' => 'Place Order',
    'btn_back_cart' => 'Back to Cart',
    'secure_note' => 'Your data is 100% secure with us',
    'loading_text' => 'Placing your order... Please wait',
    
    // JS Validation & Modal Strings (Fixed Line Breaks)
    'js_alert_title' => 'Notice',
    'js_confirm_title' => 'Confirm Order',
    'js_ok' => 'OK',
    'js_yes' => 'Yes, Place Order',
    'js_no' => 'Cancel',
    
    'js_addr_req' => 'Please select a delivery address or add a new one.',
    'js_name_req' => 'Name required',
    'js_name_min' => 'Min 2 characters',
    'js_phone_req' => 'Phone required',
    'js_phone_inv' => 'Must be 10 digits, starts 6-9',
    'js_addr_line_req' => 'Address required',
    'js_addr_line_min' => 'Min 10 characters',
    'js_village_req' => 'Please select village',
    'js_state_req' => 'State required',
    'js_pin_req' => 'Pincode required',
    'js_pin_inv' => 'Must be 6 digits',
    'js_rx_req' => 'Please upload the prescription',
    'js_terms_req' => 'Please accept the Terms & Conditions',
    'js_file_size' => 'File must be less than 5MB',
    'js_file_type' => 'Only JPG, PNG or PDF files allowed',
    'js_confirm_msg' => 'Place order for ₹:amount?'
]);
@endphp

@if(count($cartItems) == 0)
    <div style="background:var(--white);padding:60px;text-align:center;border-radius:20px;box-shadow:var(--shadow);">
        <i class="fas fa-cart-shopping" style="font-size:5rem;color:var(--mint-green);"></i>
        <h4 style="margin-top:20px;color:var(--dark-text);">{{ app(\App\Services\GoogleTranslator::class)->translate('Your cart is empty') }}</h4>
        <p style="color:var(--gray-text);">{{ app(\App\Services\GoogleTranslator::class)->translate('Add items to cart before checkout') }}</p>
        <a href="{{ url('/customer/medicines') }}" class="btn-place-order" style="max-width:250px;margin:15px auto 0;text-decoration:none;">
            <i class="fas fa-pills"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('Browse Medicines') }}
        </a>
    </div>
@else

<!-- ============ CHECKOUT PROGRESS ============ -->
<div class="checkout-steps">
    <div class="step-item done">
        <div class="step-num-c"><i class="fas fa-check"></i></div>
        <div class="step-info">
            <h6>{{ $strings['steps_cart'] }}</h6>
            <span>{{ $strings['steps_cart_sub'] }}</span>
        </div>
    </div>
    <div class="step-item active">
        <div class="step-num-c">2</div>
        <div class="step-info">
            <h6>{{ $strings['steps_checkout'] }}</h6>
            <span>{{ $strings['steps_checkout_sub'] }}</span>
        </div>
    </div>
    <div class="step-item">
        <div class="step-num-c">3</div>
        <div class="step-info">
            <h6>{{ $strings['steps_conf'] }}</h6>
            <span>{{ $strings['steps_conf_sub'] }}</span>
        </div>
    </div>
</div>

<form id="checkoutForm" action="{{ url('/customer/order/place') }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf

    <div class="row g-4">
        <!-- ============ LEFT COLUMN ============ -->
        <div class="col-lg-8">

            <!-- Delivery Address -->
            <div class="checkout-section">
                <div class="checkout-section-header">
                    <h6><i class="fas fa-location-dot"></i> {{ $strings['addr_title'] }}</h6>
                    <button type="button" class="btn-toggle-form" id="toggleNewAddress">
                        <i class="fas fa-plus me-1"></i> {{ $strings['btn_add_new'] }}
                    </button>
                </div>
                <div class="checkout-section-body">

                    @if(count($addresses) > 0)
                        @foreach($addresses as $addr)
                            <div class="address-card {{ $addr->is_default ? 'selected' : '' }}" data-addr-id="{{ $addr->id }}">
                                <div class="address-header">
                                    <input type="radio" name="address_id" value="{{ $addr->id }}"
                                           {{ $addr->is_default ? 'checked' : '' }}>
                                    <strong>{{ GoogleTranslator::translate($addr->name) }}</strong>
                                    <span class="addr-tag {{ $addr->type }}">{{ GoogleTranslator::translate(ucfirst($addr->type)) }}</span>
                                    @if($addr->is_default)
                                        <span class="addr-tag" style="background:#E8F5E9;color:#2E7D32;">{{ $strings['lbl_default'] }}</span>
                                    @endif
                                </div>
                                <div class="address-details">
                                    {{ GoogleTranslator::translate($addr->address_line) }},
                                    @if(!empty($addr->landmark)){{ GoogleTranslator::translate($addr->landmark) }},@endif
                                    {{ GoogleTranslator::translate($addr->city) }}, {{ GoogleTranslator::translate($addr->state) }} - {{ $addr->pincode }}
                                    <span class="address-phone"><i class="fas fa-phone"></i> {{ $addr->phone }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p style="text-align:center;color:var(--gray-text);padding:20px;">
                            <i class="fas fa-info-circle me-1"></i> {{ $strings['no_addr'] }}
                        </p>
                    @endif

                    <!-- New Address Form -->
                    <div class="new-address-form" id="newAddressForm">
                        <h6 style="font-weight:700;color:var(--dark-text);margin-bottom:15px;font-size:0.95rem;">
                            <i class="fas fa-plus-circle me-1" style="color:var(--primary-green);"></i> {{ $strings['form_add_title'] }}
                        </h6>

                        <input type="hidden" name="use_new_address" id="useNewAddress" value="0">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-co">
                                    <label class="form-label-co">{{ $strings['lbl_name'] }} <span class="req">*</span></label>
                                    <input type="text" name="new_name" id="new_name" class="form-control-co" value="{{ $customer->name }}">
                                    <span class="err-msg-co" id="err_new_name"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-co">
                                    <label class="form-label-co">{{ $strings['lbl_phone'] }} <span class="req">*</span></label>
                                    <input type="text" name="new_phone" id="new_phone" class="form-control-co" placeholder="{{ $strings['ph_phone'] }}" maxlength="10" value="{{ $customer->phone }}">
                                    <span class="err-msg-co" id="err_new_phone"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group-co">
                                    <label class="form-label-co">{{ $strings['lbl_addr_line'] }} <span class="req">*</span></label>
                                    <textarea name="new_address_line" id="new_address_line" class="form-control-co" placeholder="{{ $strings['ph_addr_line'] }}"></textarea>
                                    <span class="err-msg-co" id="err_new_address_line"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-co">
                                    <label class="form-label-co">{{ $strings['lbl_landmark'] }}</label>
                                    <input type="text" name="new_landmark" id="new_landmark" class="form-control-co" placeholder="{{ $strings['ph_landmark'] }}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-co">
                                    <label class="form-label-co">{{ $strings['lbl_village'] }} <span class="req">*</span></label>
                                    <select name="new_village_id" id="new_village_id" class="form-select-co">
                                        <option value="">{{ $strings['select_placeholder'] }}</option>
                                        @foreach($villages as $v)
                                            <option value="{{ $v->id }}">{{ GoogleTranslator::translate($v->name) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="err-msg-co" id="err_new_village_id"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-co">
                                    <label class="form-label-co">{{ $strings['lbl_state'] }} <span class="req">*</span></label>
                                    <input type="text" name="new_state" id="new_state" class="form-control-co" placeholder="Gujarat" value="Gujarat">
                                    <span class="err-msg-co" id="err_new_state"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-co">
                                    <label class="form-label-co">{{ $strings['lbl_pincode'] }} <span class="req">*</span></label>
                                    <input type="text" name="new_pincode" id="new_pincode" class="form-control-co" placeholder="{{ $strings['ph_pincode'] }}" maxlength="6">
                                    <span class="err-msg-co" id="err_new_pincode"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group-co">
                                    <label class="form-label-co">{{ $strings['lbl_addr_type'] }} <span class="req">*</span></label>
                                    <div style="display:flex;gap:15px;">
                                        <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                                            <input type="radio" name="new_type" value="home" checked style="accent-color:var(--primary-green);"> {{ GoogleTranslator::translate('Home') }}
                                        </label>
                                        <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                                            <input type="radio" name="new_type" value="work" style="accent-color:var(--primary-green);"> {{ GoogleTranslator::translate('Work') }}
                                        </label>
                                        <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                                            <input type="radio" name="new_type" value="other" style="accent-color:var(--primary-green);"> {{ GoogleTranslator::translate('Other') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:0.85rem;color:var(--dark-text);">
                                    <input type="checkbox" name="save_address" value="1" style="accent-color:var(--primary-green);width:18px;height:18px;">
                                    {{ $strings['lbl_save_addr'] }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prescription Upload (if needed) -->
            @if($hasRxItems)
            <div class="checkout-section">
                <div class="checkout-section-header">
                    <h6><i class="fas fa-file-prescription"></i> {{ $strings['rx_title'] }}</h6>
                </div>
                <div class="checkout-section-body">
                    <div class="prescription-notice">
                        <h6><i class="fas fa-triangle-exclamation me-1"></i> {{ $strings['rx_title'] }}</h6>
                        <p>{{ $strings['rx_desc'] }}</p>

                        <div class="rx-upload-area" onclick="$('#rxUpload').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p id="rxUploadText">{{ $strings['rx_upload'] }}</p>
                            <small style="color:#6D4C41;font-size:0.72rem;">{{ $strings['rx_format'] }}</small>
                        </div>
                        <input type="file" name="prescription" id="rxUpload" accept="image/*,.pdf" style="display:none;">
                        <span class="err-msg-co" id="err_prescription" style="text-align:center;"></span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Payment Method -->
            <div class="checkout-section">
                <div class="checkout-section-header">
                    <h6><i class="fas fa-credit-card"></i> {{ $strings['pay_title'] }}</h6>
                </div>
                <div class="checkout-section-body">
                    <div class="payment-option selected" data-method="cod">
                        <input type="radio" name="payment_method" value="cod" checked>
                        <div class="pay-icon cod"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="pay-info">
                            <strong>{{ $strings['pay_cod'] }}</strong>
                            <span>{{ $strings['pay_cod_desc'] }}</span>
                        </div>
                        <span class="pay-badge">{{ $strings['pay_recommended'] }}</span>
                    </div>

                    <div class="payment-option" data-method="upi">
                        <input type="radio" name="payment_method" value="upi">
                        <div class="pay-icon upi"><i class="fas fa-mobile-screen"></i></div>
                        <div class="pay-info">
                            <strong>{{ $strings['pay_upi'] }}</strong>
                            <span>{{ $strings['pay_upi_desc'] }}</span>
                        </div>
                    </div>

                    <div class="payment-option" data-method="card">
                        <input type="radio" name="payment_method" value="card">
                        <div class="pay-icon card"><i class="fas fa-credit-card"></i></div>
                        <div class="pay-info">
                            <strong>{{ $strings['pay_card'] }}</strong>
                            <span>{{ $strings['pay_card_desc'] }}</span>
                        </div>
                    </div>

                    <div class="payment-option" data-method="online">
                        <input type="radio" name="payment_method" value="online">
                        <div class="pay-icon online"><i class="fas fa-university"></i></div>
                        <div class="pay-info">
                            <strong>{{ $strings['pay_online'] }}</strong>
                            <span>{{ $strings['pay_online_desc'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Review -->
            <div class="checkout-section">
                <div class="checkout-section-header">
                    <h6><i class="fas fa-list-check"></i> {{ $strings['review_title'] }} ({{ count($cartItems) }} {{ app(\App\Services\GoogleTranslator::class)->translate('items') }})</h6>
                    <a href="{{ url('/customer/cart') }}" style="color:var(--primary-green);font-size:0.82rem;font-weight:600;text-decoration:none;">
                        <i class="fas fa-edit me-1"></i> {{ $strings['btn_edit_cart'] }}
                    </a>
                </div>
                <div class="checkout-section-body">
                    @foreach($cartItems as $item)
                        <div class="review-item">
                            <div class="rv-img">
                                @if(!empty($item->image) && file_exists(public_path('uploads/medicines/'.$item->image)))
                                    <img src="{{ asset('uploads/medicines/'.$item->image) }}" alt="{{ $item->name }}">
                                @else
                                    <i class="fas fa-pills"></i>
                                @endif
                            </div>
                            <div class="rv-info">
                                <strong>{{ GoogleTranslator::translate($item->name) }}</strong>
                                <span><i class="fas fa-tag me-1" style="color:var(--primary-green);"></i>{{ GoogleTranslator::translate($item->brand) }} · ₹{{ number_format($item->price) }}/{{ app(\App\Services\GoogleTranslator::class)->translate('unit') }}</span>
                            </div>
                            <span class="rv-qty">×{{ $item->quantity }}</span>
                            <span class="rv-price">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    @endforeach

                    <!-- Delivery Notes -->
                    <div class="notes-section">
                        <label class="form-label-co">
                            <i class="fas fa-sticky-note me-1" style="color:var(--primary-green);"></i> {{ $strings['notes_title'] }}
                        </label>
                        <textarea name="notes" id="orderNotes" class="form-control-co" placeholder="{{ $strings['notes_ph'] }}" maxlength="200"></textarea>
                        <small style="color:var(--gray-text);font-size:0.72rem;">{{ $strings['notes_max'] }}</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- ============ ORDER SUMMARY SIDEBAR ============ -->
        <div class="col-lg-4">
            <div class="summary-card-co">
                <div class="summary-header-co">
                    <h6><i class="fas fa-receipt me-2"></i> {{ $strings['sum_title'] }}</h6>
                </div>
                <div class="summary-body-co">
                    <div class="summary-row-co">
                        <span>{{ $strings['sum_subtotal'] }} <span style="font-size:0.72rem;color:var(--gray-text);">({{ count($cartItems) }} {{ app(\App\Services\GoogleTranslator::class)->translate('items') }})</span></span>
                        <span>₹{{ number_format($subtotal, 2) }}</span>
                    </div>
                    @if($productDiscount > 0)
                    <div class="summary-row-co discount">
                        <span>{{ $strings['sum_discount'] }}</span>
                        <span>− ₹{{ number_format($productDiscount, 2) }}</span>
                    </div>
                    @endif
                    @if($couponDiscount > 0)
                    <div class="summary-row-co discount">
                        <span>{{ $strings['sum_coupon'] }} ({{ $couponCode }})</span>
                        <span>− ₹{{ number_format($couponDiscount, 2) }}</span>
                    </div>
                    @endif
                    <div class="summary-row-co">
                        <span>{{ $strings['sum_delivery'] }}</span>
                        <span>
                            @if($deliveryCharge == 0)
                                <span style="color:#2E7D32;font-weight:600;">{{ $strings['sum_free'] }}</span>
                            @else
                                ₹{{ number_format($deliveryCharge, 2) }}
                            @endif
                        </span>
                    </div>
                    <div class="summary-row-co">
                        <span>{{ $strings['sum_tax'] }}</span>
                        <span>₹{{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="summary-row-co total-final">
                        <span>{{ $strings['sum_total'] }}</span>
                        <span>₹{{ number_format($grandTotal, 2) }}</span>
                    </div>

                    @if($productDiscount + $couponDiscount > 0)
                    <div style="background:#E8F5E9;color:#2E7D32;padding:8px 12px;border-radius:8px;text-align:center;font-size:0.82rem;font-weight:600;margin-top:10px;">
                        {!! str_replace(':amount', number_format($productDiscount + $couponDiscount, 2), $strings['sum_saving']) !!}
                    </div>
                    @endif

                    <div class="terms-check-co">
                        <input type="checkbox" name="terms" id="termsAccept">
                        <label for="termsAccept">
                            {{ $strings['terms_agree'] }} <a href="#" onclick="return false;">{{ $strings['terms_tnc'] }}</a> {{ $strings['terms_and'] }} <a href="#" onclick="return false;">{{ $strings['terms_return'] }}</a> {{ $strings['terms_of'] }}
                        </label>
                    </div>
                    <span class="err-msg-co" id="err_terms" style="margin-top:-8px;margin-bottom:8px;"></span>

                    <button type="submit" class="btn-place-order" id="placeOrderBtn">
                        <i class="fas fa-lock"></i> {{ $strings['btn_place'] }} · ₹{{ number_format($grandTotal, 2) }}
                    </button>

                    <a href="{{ url('/customer/cart') }}" class="btn-back-cart">
                        <i class="fas fa-arrow-left me-1"></i> {{ $strings['btn_back_cart'] }}
                    </a>

                    <div class="secure-note">
                        <i class="fas fa-shield-halved"></i> {{ $strings['secure_note'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endif

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
    <p>{{ $strings['loading_text'] }}</p>
</div>

<!-- Custom Modal (Replaces native alert/confirm) -->
<div class="custom-modal-overlay" id="customModal">
    <div class="custom-modal">
        <div class="custom-modal-header">
            <div class="custom-modal-icon warning" id="modalIconContainer">
                <i class="fas fa-exclamation-triangle" id="modalIcon"></i>
            </div>
            <h5 id="modalTitle">Notice</h5>
        </div>
        <div class="custom-modal-body" id="modalMessage">
            Message goes here...
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn-modal btn-modal-cancel" id="modalCancelBtn" style="display:none;">
                {{ $strings['js_no'] }}
            </button>
            <button type="button" class="btn-modal btn-modal-confirm" id="modalConfirmBtn">
                {{ $strings['js_ok'] }}
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* ============ CUSTOM MODAL LOGIC ============ */
    var modalCallback = null;

    function showAlert(message, type = 'warning', title = '{{ $strings['js_alert_title'] }}') {
        $('#modalTitle').text(title);
        $('#modalMessage').text(message);
        $('#modalIconContainer').attr('class', 'custom-modal-icon ' + type);
        $('#modalIcon').attr('class', 'fas ' + (type === 'warning' ? 'fa-exclamation-triangle' : (type === 'error' ? 'fa-times-circle' : 'fa-check-circle')));
        $('#modalCancelBtn').hide();
        $('#modalConfirmBtn').text('{{ $strings['js_ok'] }}').off('click').on('click', function() {
            $('#customModal').removeClass('show');
        });
        $('#customModal').addClass('show');
    }

    function showConfirm(message, callback, title = '{{ $strings['js_confirm_title'] }}') {
        $('#modalTitle').text(title);
        $('#modalMessage').text(message);
        $('#modalIconContainer').attr('class', 'custom-modal-icon warning');
        $('#modalIcon').attr('class', 'fas fa-question-circle');
        $('#modalCancelBtn').show().text('{{ $strings['js_no'] }}').off('click').on('click', function() {
            $('#customModal').removeClass('show');
        });
        $('#modalConfirmBtn').text('{{ $strings['js_yes'] }}').off('click').on('click', function() {
            $('#customModal').removeClass('show');
            if (typeof callback === 'function') callback();
        });
        $('#customModal').addClass('show');
    }

    /* ============ ADDRESS SELECTION ============ */
    $('.address-card').on('click', function () {
        $('.address-card').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
        $('#useNewAddress').val('0');
        $('#newAddressForm').removeClass('show');
        $('#toggleNewAddress').html('<i class="fas fa-plus me-1"></i> {{ $strings['btn_add_new'] }}');
    });

    /* ============ TOGGLE NEW ADDRESS FORM ============ */
    $('#toggleNewAddress').on('click', function () {
        var $form = $('#newAddressForm');
        var isShown = $form.hasClass('show');

        if (isShown) {
            $form.removeClass('show');
            $(this).html('<i class="fas fa-plus me-1"></i> {{ $strings['btn_add_new'] }}');
            $('#useNewAddress').val('0');
        } else {
            $form.addClass('show');
            $(this).html('<i class="fas fa-times me-1"></i> {{ $strings['btn_cancel'] }}');
            $('#useNewAddress').val('1');
            $('.address-card').removeClass('selected');
            $('.address-card input[type="radio"]').prop('checked', false);
        }
    });

    /* ============ PAYMENT SELECTION ============ */
    $('.payment-option').on('click', function () {
        $('.payment-option').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    /* ============ PRESCRIPTION UPLOAD ============ */
    $('#rxUpload').on('change', function () {
        var file = this.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                $('#err_prescription').text('⚠ {{ $strings['js_file_size'] }}').addClass('show');
                $(this).val('');
                return;
            }

            var validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
            if (!validTypes.includes(file.type)) {
                $('#err_prescription').text('⚠ {{ $strings['js_file_type'] }}').addClass('show');
                $(this).val('');
                return;
            }

            $('#rxUploadText').html('<i class="fas fa-check-circle me-1" style="color:#2E7D32;"></i> ' + file.name);
            $('#err_prescription').removeClass('show').text('');
        }
    });

    /* ============ NOTES CHAR COUNTER ============ */
    var maxNotes = 200;
    $('#orderNotes').on('input', function () {
        if (this.value.length > maxNotes) {
            this.value = this.value.substring(0, maxNotes);
        }
    });

    /* ============ VALIDATION HELPERS ============ */
    function showErr($el, msg) {
        $el.addClass('error');
        $el.closest('.form-group-co').find('.err-msg-co').text(msg).addClass('show');
    }

    function clearErr($el) {
        $el.removeClass('error');
        $el.closest('.form-group-co').find('.err-msg-co').removeClass('show').text('');
    }

    /* ============ DIGITS ONLY ============ */
    $('#new_phone, #new_pincode').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('.form-control-co, .form-select-co').on('input change', function () {
        if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
            clearErr($(this));
        }
    });

    /* ============ FORM SUBMIT VALIDATION ============ */
    $('#checkoutForm').on('submit', function (e) {
        e.preventDefault();

        var isValid = true;
        $('.err-msg-co').removeClass('show').text('');
        $('.form-control-co, .form-select-co').removeClass('error');

        // Check address selection
        var useNew = $('#useNewAddress').val() === '1';
        var hasSelected = $('input[name="address_id"]:checked').length > 0;

        if (!useNew && !hasSelected) {
            showAlert('⚠ {{ $strings['js_addr_req'] }}', 'warning');
            isValid = false;
            return false;
        }

        // If using new address, validate its fields
        if (useNew) {
            var name = $.trim($('#new_name').val());
            if (name === '') { showErr($('#new_name'), '⚠ {{ $strings['js_name_req'] }}'); isValid = false; }
            else if (name.length < 2) { showErr($('#new_name'), '⚠ {{ $strings['js_name_min'] }}'); isValid = false; }

            var phone = $.trim($('#new_phone').val());
            if (phone === '') { showErr($('#new_phone'), '⚠ {{ $strings['js_phone_req'] }}'); isValid = false; }
            else if (!/^[6-9]\d{9}$/.test(phone)) { showErr($('#new_phone'), '⚠ {{ $strings['js_phone_inv'] }}'); isValid = false; }

            var addr = $.trim($('#new_address_line').val());
            if (addr === '') { showErr($('#new_address_line'), '⚠ {{ $strings['js_addr_line_req'] }}'); isValid = false; }
            else if (addr.length < 10) { showErr($('#new_address_line'), '⚠ {{ $strings['js_addr_line_min'] }}'); isValid = false; }

            if ($('#new_village_id').val() === '') { showErr($('#new_village_id'), '⚠ {{ $strings['js_village_req'] }}'); isValid = false; }

            var state = $.trim($('#new_state').val());
            if (state === '') { showErr($('#new_state'), '⚠ {{ $strings['js_state_req'] }}'); isValid = false; }

            var pin = $.trim($('#new_pincode').val());
            if (pin === '') { showErr($('#new_pincode'), '⚠ {{ $strings['js_pin_req'] }}'); isValid = false; }
            else if (!/^\d{6}$/.test(pin)) { showErr($('#new_pincode'), '⚠ {{ $strings['js_pin_inv'] }}'); isValid = false; }
        }

        // Check prescription if required
        @if($hasRxItems)
        var rxFile = $('#rxUpload')[0].files[0];
        if (!rxFile) {
            $('#err_prescription').text('⚠ {{ $strings['js_rx_req'] }}').addClass('show');
            isValid = false;
            $('html, body').animate({
                scrollTop: $('#rxUpload').closest('.checkout-section').offset().top - 100
            }, 400);
        }
        @endif

        // Check terms
        if (!$('#termsAccept').is(':checked')) {
            $('#err_terms').text('⚠ {{ $strings['js_terms_req'] }}').addClass('show');
            isValid = false;
        }

        if (!isValid) {
            var $firstErr = $('.form-control-co.error, .form-select-co.error').first();
            if ($firstErr.length) {
                $('html, body').animate({ scrollTop: $firstErr.offset().top - 120 }, 400);
                $firstErr.focus();
            }
            return false;
        }

        // Confirm order using custom modal
        var confirmMsg = '{{ $strings['js_confirm_msg'] }}'.replace(':amount', '{{ number_format($grandTotal, 2) }}');
        
        showConfirm(confirmMsg, function() {
            $('#loadingOverlay').addClass('show');
            $('#placeOrderBtn').prop('disabled', true);

            // Submit form
            setTimeout(function() { 
                $('#checkoutForm')[0].submit(); 
            }, 500);
        }, '{{ $strings['js_confirm_title'] }}');
    });

    /* ============ TERMS CHECKBOX CLEAR ERROR ============ */
    $('#termsAccept').on('change', function () {
        if ($(this).is(':checked')) $('#err_terms').removeClass('show').text('');
    });

});
</script>
@endsection