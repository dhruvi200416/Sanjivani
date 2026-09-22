@extends('layouts.customer')

@section('title', 'Medicine Details')
@section('page_title')
<i class="fas fa-pills"></i> Medicine Details
@endsection

@section('styles')
<style>
    /* Breadcrumb */
    .breadcrumb-c {
        background: var(--white);
        border-radius: 12px;
        padding: 12px 20px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: var(--gray-text);
        flex-wrap: wrap;
    }

    .breadcrumb-c a {
        color: var(--primary-green);
        text-decoration: none;
        transition: var(--transition);
    }

    .breadcrumb-c a:hover { color: var(--dark-green); }
    .breadcrumb-c .separator { color: #CCC; }
    .breadcrumb-c .current { color: var(--dark-text); font-weight: 600; }

    /* Main Product Card */
    .product-main-card {
        background: var(--white);
        border-radius: 20px;
        padding: 30px;
        box-shadow: var(--shadow);
        margin-bottom: 25px;
    }

    /* Image Gallery */
    .product-gallery {
        position: sticky;
        top: 100px;
    }

    .main-image-wrap {
        background: var(--pale-green);
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .main-image-wrap img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s;
    }

    .main-image-wrap:hover img {
        transform: scale(1.05);
    }

    .main-image-wrap .no-img-big {
        font-size: 8rem;
        color: var(--accent-green);
        opacity: 0.5;
    }

    .badge-corner {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        z-index: 2;
    }

    .badge-corner.featured {
        background: linear-gradient(135deg, #FB8C00, #FFA726);
        color: var(--white);
    }

    .badge-corner.rx {
        background: linear-gradient(135deg, #E53935, #EF5350);
        color: var(--white);
    }

    .discount-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #C62828, #EF5350);
        color: var(--white);
        padding: 8px 12px;
        border-radius: 50%;
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
        box-shadow: 0 4px 15px rgba(198,40,40,0.3);
        z-index: 2;
    }

    /* Thumbnail Gallery */
    .thumbnail-gallery {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    .thumbnail-item {
        aspect-ratio: 1 / 1;
        background: var(--pale-green);
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        border: 3px solid transparent;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .thumbnail-item.active {
        border-color: var(--primary-green);
    }

    .thumbnail-item:hover { transform: translateY(-2px); }

    .thumbnail-item img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .thumbnail-item i {
        font-size: 1.5rem;
        color: var(--accent-green);
    }

    /* Product Info */
    .product-cat-tag {
        display: inline-block;
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
    }

    .product-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 8px;
        line-height: 1.2;
    }

    .product-brand {
        color: var(--gray-text);
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .product-brand i {
        color: var(--primary-green);
        margin-right: 5px;
    }

    /* Rating */
    .product-rating {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px dashed #E0E0E0;
    }

    .rating-stars-lg {
        color: #FFC107;
        font-size: 1rem;
    }

    .rating-value {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--dark-text);
    }

    .rating-count {
        color: var(--gray-text);
        font-size: 0.9rem;
    }

    .rating-count a {
        color: var(--primary-green);
        text-decoration: none;
        font-weight: 600;
    }

    /* Price Section */
    .price-section {
        margin-bottom: 20px;
    }

    .current-price {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--primary-green);
        display: inline-block;
    }

    .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 1.1rem;
        font-weight: 500;
        margin-left: 8px;
    }

    .discount-percent {
        background: #E8F5E9;
        color: #2E7D32;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.82rem;
        font-weight: 700;
        margin-left: 8px;
    }

    .price-note {
        display: block;
        font-size: 0.8rem;
        color: var(--gray-text);
        margin-top: 5px;
    }

    /* Info Row */
    .product-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        padding: 18px;
        background: var(--off-white);
        border-radius: 14px;
        margin-bottom: 20px;
    }

    .pi-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pi-item .pi-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 10px;
        background: var(--white);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        box-shadow: 0 2px 8px rgba(46,125,50,0.1);
    }

    .pi-item .pi-text {
        flex: 1;
    }

    .pi-item .pi-text .lbl {
        font-size: 0.72rem;
        color: var(--gray-text);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .pi-item .pi-text .val {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--dark-text);
    }

    .pi-item .pi-text .val.in { color: #2E7D32; }
    .pi-item .pi-text .val.out { color: #C62828; }
    .pi-item .pi-text .val.low { color: #FB8C00; }

    /* Quantity Selector */
    .qty-section {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .qty-label {
        font-weight: 600;
        color: var(--dark-text);
        font-size: 0.9rem;
    }

    .qty-selector {
        display: flex;
        align-items: center;
        border: 2px solid var(--primary-green);
        border-radius: 25px;
        overflow: hidden;
    }

    .qty-btn {
        background: var(--white);
        border: none;
        color: var(--primary-green);
        width: 38px;
        height: 38px;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .qty-btn:hover:not(:disabled) {
        background: var(--pale-green);
    }

    .qty-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .qty-input {
        width: 55px;
        height: 38px;
        border: none;
        border-left: 1px solid var(--pale-green);
        border-right: 1px solid var(--pale-green);
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        outline: none;
        color: var(--dark-text);
    }

    .stock-warning {
        font-size: 0.78rem;
        color: #FB8C00;
        margin-left: 5px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }

    .btn-large {
        flex: 1;
        padding: 13px 25px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-cart-lg {
        background: var(--white);
        color: var(--primary-green);
        border: 2px solid var(--primary-green);
    }

    .btn-cart-lg:hover:not(:disabled) {
        background: var(--pale-green);
        transform: translateY(-2px);
    }

    .btn-buy-lg {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        box-shadow: 0 6px 18px rgba(46,125,50,0.3);
    }

    .btn-buy-lg:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.4);
        color: var(--white);
    }

    .btn-large:disabled {
        background: #CCC !important;
        color: #999 !important;
        border-color: #CCC !important;
        cursor: not-allowed;
        box-shadow: none !important;
    }

    /* Trust Row */
    .trust-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        padding: 15px;
        background: linear-gradient(135deg, var(--pale-green), var(--off-white));
        border-radius: 14px;
    }

    .trust-item-p {
        text-align: center;
    }

    .trust-item-p i {
        font-size: 1.4rem;
        color: var(--primary-green);
        margin-bottom: 5px;
    }

    .trust-item-p strong {
        display: block;
        font-size: 0.78rem;
        color: var(--dark-text);
        font-weight: 700;
        line-height: 1.2;
    }

    .trust-item-p span {
        font-size: 0.68rem;
        color: var(--gray-text);
    }

    /* Tabs Section */
    .tabs-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 25px;
    }

    .tabs-header {
        display: flex;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
    }

    .tab-btn {
        flex: 1;
        padding: 16px 20px;
        text-align: center;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--gray-text);
        transition: var(--transition);
        border: none;
        background: transparent;
        border-bottom: 3px solid transparent;
    }

    .tab-btn i {
        margin-right: 6px;
    }

    .tab-btn:hover {
        color: var(--primary-green);
        background: var(--pale-green);
    }

    .tab-btn.active {
        color: var(--primary-green);
        background: var(--white);
        border-bottom-color: var(--primary-green);
    }

    .tab-content-panel {
        display: none;
        padding: 25px 30px;
    }

    .tab-content-panel.active {
        display: block;
    }

    .tab-content-panel h6 {
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 12px;
        font-size: 1rem;
    }

    .tab-content-panel p {
        color: var(--gray-text);
        font-size: 0.9rem;
        line-height: 1.8;
        margin-bottom: 15px;
    }

    .tab-content-panel ul {
        padding-left: 20px;
        color: var(--gray-text);
        font-size: 0.9rem;
        line-height: 1.9;
    }

    .info-table {
        width: 100%;
    }

    .info-table tr {
        border-bottom: 1px solid #F5F5F5;
    }

    .info-table tr:last-child {
        border-bottom: none;
    }

    .info-table td {
        padding: 12px 5px;
        font-size: 0.88rem;
    }

    .info-table td:first-child {
        font-weight: 600;
        color: var(--dark-text);
        width: 40%;
    }

    .info-table td:last-child {
        color: var(--gray-text);
    }

    /* Reviews */
    .review-summary {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 30px;
        padding-bottom: 25px;
        margin-bottom: 25px;
        border-bottom: 1px solid #EEE;
    }

    .rating-big {
        text-align: center;
        padding: 20px;
        background: var(--pale-green);
        border-radius: 14px;
    }

    .rating-big .rating-num {
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary-green);
        line-height: 1;
    }

    .rating-big .rating-stars-big {
        color: #FFC107;
        font-size: 1.1rem;
        margin: 8px 0;
    }

    .rating-big .rating-total {
        font-size: 0.82rem;
        color: var(--gray-text);
    }

    .rating-bars {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .rating-bar-row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.82rem;
    }

    .rating-bar-row .r-label {
        width: 50px;
        color: var(--gray-text);
    }

    .rating-bar {
        flex: 1;
        height: 8px;
        background: #F5F5F5;
        border-radius: 5px;
        overflow: hidden;
    }

    .rating-bar .fill {
        height: 100%;
        background: linear-gradient(90deg, #FFC107, #FFA726);
        border-radius: 5px;
    }

    .rating-bar-row .r-count {
        width: 40px;
        text-align: right;
        color: var(--dark-text);
        font-weight: 600;
    }

    /* Review Item */
    .review-item {
        padding: 18px 0;
        border-bottom: 1px solid #F5F5F5;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .review-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
    }

    .review-author strong {
        display: block;
        font-size: 0.9rem;
        color: var(--dark-text);
    }

    .review-author span {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    .review-stars {
        margin-left: auto;
        color: #FFC107;
        font-size: 0.82rem;
    }

    .review-text {
        color: var(--gray-text);
        font-size: 0.9rem;
        line-height: 1.7;
    }

    /* Write Review */
    .write-review-card {
        background: var(--off-white);
        border-radius: 14px;
        padding: 20px;
        margin-top: 20px;
    }

    .write-review-card h6 {
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 15px;
    }

    .star-input {
        display: flex;
        gap: 6px;
        margin-bottom: 12px;
    }

    .star-input i {
        font-size: 1.6rem;
        color: #DDD;
        cursor: pointer;
        transition: var(--transition);
    }

    .star-input i.active,
    .star-input i.hover {
        color: #FFC107;
    }

    .review-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        outline: none;
        transition: var(--transition);
        min-height: 100px;
        resize: vertical;
    }

    .review-textarea:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
    }

    .review-textarea.error {
        border-color: #E53935;
    }

    .btn-submit-review {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 10px 24px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 10px;
    }

    .btn-submit-review:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46,125,50,0.3);
    }

    /* Related Medicines */
    .related-title {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 20px;
    }

    .related-title i {
        color: var(--primary-green);
        margin-right: 8px;
    }

    .related-card {
        background: var(--white);
        border-radius: 14px;
        padding: 15px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        text-align: center;
        height: 100%;
        text-decoration: none;
        display: block;
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.15);
    }

    .related-img {
        height: 100px;
        background: var(--pale-green);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        font-size: 2rem;
        color: var(--accent-green);
        overflow: hidden;
    }

    .related-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-card h6 {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .related-price {
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--primary-green);
    }

    /* Cart Toast */
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
        .product-gallery { position: static; margin-bottom: 25px; }
        .product-title { font-size: 1.5rem; }
        .current-price { font-size: 1.8rem; }
        .review-summary { grid-template-columns: 1fr; }
    }

    @media (max-width: 576px) {
        .product-main-card { padding: 20px; }
        .product-info-grid { grid-template-columns: 1fr; }
        .action-buttons { flex-direction: column; }
        .trust-row { grid-template-columns: 1fr; }
        .tab-btn { padding: 12px 8px; font-size: 0.78rem; }
        .tab-btn i { display: none; }
    }
</style>
@endsection

@section('content')

@php
    // Demo medicine data with fallback
    $medicine = $medicine ?? (object)[
        'id' => 1,
        'name' => 'Paracetamol 500mg Tablets',
        'brand' => 'Crocin Advance',
        'category' => 'Fever & Pain',
        'price' => 25,
        'mrp' => 35,
        'stock' => 150,
        'featured' => 1,
        'prescription_required' => 0,
        'image' => null,
        'description' => 'Paracetamol 500mg tablets are used to relieve mild to moderate pain and fever. They work by blocking pain signals in the brain and reducing fever. Suitable for adults and children over 12 years.',
        'composition' => 'Paracetamol (Acetaminophen) 500mg',
        'manufacturer' => 'GSK Consumer Healthcare',
        'expiry_date' => '2027-12-31',
        'dosage' => '1-2 tablets every 4-6 hours as needed. Do not exceed 8 tablets in 24 hours.',
        'side_effects' => 'Rare side effects may include nausea, skin rash, or allergic reactions. Contact a doctor if symptoms persist.',
        'storage' => 'Store in a cool, dry place below 25°C. Keep out of reach of children.',
        'pharmacy' => (object)['pharmacy_name' => 'MediCare Pharmacy', 'phone' => '9876543210'],
    ];

    $reviews = $reviews ?? [
        (object)['name'=>'Ramesh P.','rating'=>5,'comment'=>'Excellent medicine, works fast for headaches. Delivered on time.','date'=>now()->subDays(2)],
        (object)['name'=>'Sunita S.','rating'=>4,'comment'=>'Good quality, genuine product from a verified pharmacy.','date'=>now()->subDays(5)],
        (object)['name'=>'Arjun V.','rating'=>5,'comment'=>'Very effective and affordable. Highly recommended!','date'=>now()->subDays(10)],
    ];

    $relatedMedicines = $relatedMedicines ?? [
        (object)['id'=>2,'name'=>'Ibuprofen 400mg','price'=>45,'image'=>null],
        (object)['id'=>3,'name'=>'Aspirin 300mg','price'=>35,'image'=>null],
        (object)['id'=>4,'name'=>'Combiflam Tablets','price'=>55,'image'=>null],
        (object)['id'=>5,'name'=>'Diclofenac Gel','price'=>85,'image'=>null],
        (object)['id'=>6,'name'=>'Voveran SR','price'=>65,'image'=>null],
        (object)['id'=>7,'name'=>'Meftal Spas','price'=>75,'image'=>null],
    ];

    $avgRating = 4.5;
    $totalReviews = 87;
    $discount = $medicine->mrp > $medicine->price ? round((($medicine->mrp - $medicine->price) / $medicine->mrp) * 100) : 0;

    $stockClass = $medicine->stock <= 0 ? 'out' : ($medicine->stock < 20 ? 'low' : 'in');
    $stockText = $medicine->stock <= 0 ? 'Out of Stock' : ($medicine->stock < 20 ? 'Only '.$medicine->stock.' left!' : 'In Stock');
@endphp

<!-- Breadcrumb -->
<div class="breadcrumb-c">
    <a href="{{ url('/customer/dashboard') }}"><i class="fas fa-home"></i></a>
    <span class="separator">/</span>
    <a href="{{ url('/customer/medicines') }}">Medicines</a>
    <span class="separator">/</span>
    <a href="{{ url('/customer/medicines?category='.urlencode($medicine->category)) }}">{{ $medicine->category }}</a>
    <span class="separator">/</span>
    <span class="current">{{ $medicine->name }}</span>
</div>

<!-- Main Product Card -->
<div class="product-main-card">
    <div class="row g-4">
        <!-- Left: Gallery -->
        <div class="col-lg-5">
            <div class="product-gallery">
                <div class="main-image-wrap">
                    @if(!empty($medicine->image) && file_exists(public_path('uploads/medicines/'.$medicine->image)))
                        <img src="{{ asset('uploads/medicines/'.$medicine->image) }}" alt="{{ $medicine->name }}" id="mainProductImage">
                    @else
                        <i class="fas fa-pills no-img-big"></i>
                    @endif

                    @if($medicine->prescription_required)
                        <span class="badge-corner rx"><i class="fas fa-file-prescription"></i> Rx Required</span>
                    @elseif($medicine->featured)
                        <span class="badge-corner featured"><i class="fas fa-star"></i> Featured</span>
                    @endif

                    @if($discount > 0)
                        <div class="discount-badge">-{{ $discount }}%</div>
                    @endif
                </div>

                <div class="thumbnail-gallery">
                    <div class="thumbnail-item active">
                        @if(!empty($medicine->image))
                            <img src="{{ asset('uploads/medicines/'.$medicine->image) }}" alt="View 1">
                        @else
                            <i class="fas fa-pills"></i>
                        @endif
                    </div>
                    <div class="thumbnail-item">
                        <i class="fas fa-capsules"></i>
                    </div>
                    <div class="thumbnail-item">
                        <i class="fas fa-prescription-bottle-medical"></i>
                    </div>
                    <div class="thumbnail-item">
                        <i class="fas fa-image"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Product Info -->
        <div class="col-lg-7">
            <span class="product-cat-tag">{{ $medicine->category }}</span>
            <h1 class="product-title">{{ $medicine->name }}</h1>
            <div class="product-brand">
                <i class="fas fa-tag"></i> Brand: <strong>{{ $medicine->brand }}</strong>
            </div>

            <div class="product-rating">
                <span class="rating-stars-lg">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa{{ $i <= round($avgRating) ? 's' : 'r' }} fa-star"></i>
                    @endfor
                </span>
                <span class="rating-value">{{ $avgRating }}</span>
                <span class="rating-count">
                    ({{ $totalReviews }} reviews) · <a href="#reviewsTab" id="scrollToReviews">Read reviews</a>
                </span>
            </div>

            <div class="price-section">
                <span class="current-price">₹{{ number_format($medicine->price, 2) }}</span>
                @if($medicine->mrp > $medicine->price)
                    <span class="old-price">MRP ₹{{ number_format($medicine->mrp, 2) }}</span>
                    <span class="discount-percent">{{ $discount }}% OFF</span>
                @endif
                <small class="price-note">Inclusive of all taxes · Free delivery on orders above ₹500</small>
            </div>

            <div class="product-info-grid">
                <div class="pi-item">
                    <div class="pi-icon"><i class="fas fa-cubes"></i></div>
                    <div class="pi-text">
                        <div class="lbl">Availability</div>
                        <div class="val {{ $stockClass }}">{{ $stockText }}</div>
                    </div>
                </div>
                <div class="pi-item">
                    <div class="pi-icon"><i class="fas fa-store"></i></div>
                    <div class="pi-text">
                        <div class="lbl">Sold By</div>
                        <div class="val">{{ $medicine->pharmacy->pharmacy_name ?? 'Sanjivani' }}</div>
                    </div>
                </div>
                <div class="pi-item">
                    <div class="pi-icon"><i class="fas fa-truck"></i></div>
                    <div class="pi-text">
                        <div class="lbl">Delivery</div>
                        <div class="val">Within 2-4 hours</div>
                    </div>
                </div>
                <div class="pi-item">
                    <div class="pi-icon"><i class="fas fa-file-prescription"></i></div>
                    <div class="pi-text">
                        <div class="lbl">Prescription</div>
                        <div class="val">{{ $medicine->prescription_required ? 'Required' : 'Not Required' }}</div>
                    </div>
                </div>
            </div>

            @if($medicine->stock > 0)
                <div class="qty-section">
                    <span class="qty-label">Quantity:</span>
                    <div class="qty-selector">
                        <button type="button" class="qty-btn" id="qtyMinus" disabled>−</button>
                        <input type="number" class="qty-input" id="qtyInput" value="1" min="1" max="{{ $medicine->stock }}">
                        <button type="button" class="qty-btn" id="qtyPlus">+</button>
                    </div>
                    @if($medicine->stock < 20)
                        <span class="stock-warning"><i class="fas fa-exclamation-triangle me-1"></i>Only {{ $medicine->stock }} available</span>
                    @endif
                </div>
            @endif

            <div class="action-buttons">
                <button type="button" class="btn-large btn-cart-lg" id="addToCartBtn"
                        {{ $medicine->stock <= 0 ? 'disabled' : '' }}>
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
                <button type="button" class="btn-large btn-buy-lg" id="buyNowBtn"
                        {{ $medicine->stock <= 0 ? 'disabled' : '' }}>
                    <i class="fas fa-bolt"></i> Buy Now
                </button>
            </div>

            <div class="trust-row">
                <div class="trust-item-p">
                    <i class="fas fa-shield-halved"></i>
                    <strong>Genuine Product</strong>
                    <span>100% Original</span>
                </div>
                <div class="trust-item-p">
                    <i class="fas fa-truck-fast"></i>
                    <strong>Fast Delivery</strong>
                    <span>2-4 Hours</span>
                </div>
                <div class="trust-item-p">
                    <i class="fas fa-headset"></i>
                    <strong>24/7 Support</strong>
                    <span>Always Available</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============ TABS: DESCRIPTION / DETAILS / REVIEWS ============ -->
<div class="tabs-card" id="reviewsTab">
    <div class="tabs-header">
        <button type="button" class="tab-btn active" data-tab="description">
            <i class="fas fa-info-circle"></i> Description
        </button>
        <button type="button" class="tab-btn" data-tab="details">
            <i class="fas fa-list-check"></i> Product Details
        </button>
        <button type="button" class="tab-btn" data-tab="reviews">
            <i class="fas fa-star"></i> Reviews ({{ $totalReviews }})
        </button>
    </div>

    <!-- Description -->
    <div class="tab-content-panel active" id="tab-description">
        <h6><i class="fas fa-info-circle me-1" style="color:var(--primary-green);"></i> About This Medicine</h6>
        <p>{{ $medicine->description }}</p>

        <h6 style="margin-top:20px;"><i class="fas fa-flask me-1" style="color:var(--primary-green);"></i> Dosage</h6>
        <p>{{ $medicine->dosage }}</p>

        <h6 style="margin-top:20px;"><i class="fas fa-triangle-exclamation me-1" style="color:#FB8C00;"></i> Side Effects</h6>
        <p>{{ $medicine->side_effects }}</p>

        <h6 style="margin-top:20px;"><i class="fas fa-box-open me-1" style="color:var(--primary-green);"></i> Storage Instructions</h6>
        <p>{{ $medicine->storage }}</p>
    </div>

    <!-- Details -->
    <div class="tab-content-panel" id="tab-details">
        <h6><i class="fas fa-list-check me-1" style="color:var(--primary-green);"></i> Product Information</h6>
        <table class="info-table">
            <tr><td>Product Name</td><td>{{ $medicine->name }}</td></tr>
            <tr><td>Brand</td><td>{{ $medicine->brand }}</td></tr>
            <tr><td>Category</td><td>{{ $medicine->category }}</td></tr>
            <tr><td>Composition</td><td>{{ $medicine->composition ?? 'N/A' }}</td></tr>
            <tr><td>Manufacturer</td><td>{{ $medicine->manufacturer ?? 'N/A' }}</td></tr>
            <tr><td>Expiry Date</td><td>{{ !empty($medicine->expiry_date) ? date('M Y', strtotime($medicine->expiry_date)) : 'N/A' }}</td></tr>
            <tr><td>Prescription</td><td>{{ $medicine->prescription_required ? 'Required' : 'Not Required' }}</td></tr>
            <tr><td>Sold By</td><td>{{ $medicine->pharmacy->pharmacy_name ?? 'Sanjivani' }}</td></tr>
            <tr><td>Country of Origin</td><td>India</td></tr>
        </table>
    </div>

    <!-- Reviews -->
    <div class="tab-content-panel" id="tab-reviews">
        <div class="review-summary">
            <div class="rating-big">
                <div class="rating-num">{{ $avgRating }}</div>
                <div class="rating-stars-big">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa{{ $i <= round($avgRating) ? 's' : 'r' }} fa-star"></i>
                    @endfor
                </div>
                <div class="rating-total">{{ $totalReviews }} total reviews</div>
            </div>

            <div class="rating-bars">
                @php
                    $ratingDist = [5=>62, 4=>18, 3=>5, 2=>1, 1=>1];
                @endphp
                @foreach($ratingDist as $star => $count)
                    <div class="rating-bar-row">
                        <span class="r-label">{{ $star }} <i class="fas fa-star" style="color:#FFC107;font-size:0.75rem;"></i></span>
                        <div class="rating-bar">
                            <div class="fill" style="width: {{ ($count / $totalReviews) * 100 }}%;"></div>
                        </div>
                        <span class="r-count">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Reviews List -->
        <h6 style="margin-bottom:15px;">Customer Reviews</h6>
        @if(count($reviews) > 0)
            @foreach($reviews as $rv)
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-avatar">{{ strtoupper(substr($rv->name, 0, 1)) }}</div>
                        <div class="review-author">
                            <strong>{{ $rv->name }}</strong>
                            <span><i class="fas fa-calendar me-1"></i>{{ date('d M Y', strtotime($rv->date)) }}</span>
                        </div>
                        <span class="review-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa{{ $i <= $rv->rating ? 's' : 'r' }} fa-star"></i>
                            @endfor
                        </span>
                    </div>
                    <p class="review-text">{{ $rv->comment }}</p>
                </div>
            @endforeach
        @else
            <p style="text-align:center;color:var(--gray-text);padding:30px;">No reviews yet. Be the first to review!</p>
        @endif

        <!-- Write Review -->
        <div class="write-review-card">
            <h6><i class="fas fa-pen me-1" style="color:var(--primary-green);"></i> Write a Review</h6>
            <form id="reviewForm" action="{{ url('/customer/medicine/'.$medicine->id.'/review') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="rating" id="ratingInput" value="0">

                <label style="font-size:0.85rem;font-weight:600;color:var(--dark-text);margin-bottom:6px;display:block;">Your Rating <span style="color:#E53935;">*</span></label>
                <div class="star-input" id="starInput">
                    <i class="fas fa-star" data-value="1"></i>
                    <i class="fas fa-star" data-value="2"></i>
                    <i class="fas fa-star" data-value="3"></i>
                    <i class="fas fa-star" data-value="4"></i>
                    <i class="fas fa-star" data-value="5"></i>
                </div>
                <span id="ratingError" style="color:#E53935;font-size:0.78rem;display:none;margin-bottom:8px;">⚠ Please select a rating.</span>

                <label style="font-size:0.85rem;font-weight:600;color:var(--dark-text);margin:12px 0 6px;display:block;">Your Review <span style="color:#E53935;">*</span></label>
                <textarea name="comment" id="reviewComment" class="review-textarea" placeholder="Share your experience with this medicine..." maxlength="500"></textarea>
                <span id="commentError" style="color:#E53935;font-size:0.78rem;display:none;margin-top:5px;"></span>

                <button type="submit" class="btn-submit-review" id="submitReviewBtn">
                    <i class="fas fa-paper-plane"></i> Submit Review
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ============ RELATED MEDICINES ============ -->
<h4 class="related-title"><i class="fas fa-thumbs-up"></i> You May Also Like</h4>
<div class="row g-3">
    @foreach($relatedMedicines as $rel)
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ url('/customer/medicine/'.$rel->id) }}" class="related-card">
                <div class="related-img">
                    @if(!empty($rel->image))
                        <img src="{{ asset('uploads/medicines/'.$rel->image) }}" alt="{{ $rel->name }}">
                    @else
                        <i class="fas fa-pills"></i>
                    @endif
                </div>
                <h6>{{ $rel->name }}</h6>
                <div class="related-price">₹{{ number_format($rel->price) }}</div>
            </a>
        </div>
    @endforeach
</div>

<!-- Cart Toast -->
<div class="cart-toast" id="cartToast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage">Added to cart!</span>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    var maxStock = {{ $medicine->stock }};

    /* ============ THUMBNAIL GALLERY ============ */
    $('.thumbnail-item').on('click', function () {
        $('.thumbnail-item').removeClass('active');
        $(this).addClass('active');
        // In real app: change main image based on thumbnail data
    });

    /* ============ QUANTITY SELECTOR ============ */
    $('#qtyPlus').on('click', function () {
        var current = parseInt($('#qtyInput').val()) || 1;
        if (current < maxStock) {
            $('#qtyInput').val(current + 1);
            $('#qtyMinus').prop('disabled', false);
            if (current + 1 >= maxStock) {
                $(this).prop('disabled', true);
            }
        }
    });

    $('#qtyMinus').on('click', function () {
        var current = parseInt($('#qtyInput').val()) || 1;
        if (current > 1) {
            $('#qtyInput').val(current - 1);
            $('#qtyPlus').prop('disabled', false);
            if (current - 1 <= 1) {
                $(this).prop('disabled', true);
            }
        }
    });

    $('#qtyInput').on('input', function () {
        var v = parseInt($(this).val()) || 1;
        if (v < 1) v = 1;
        if (v > maxStock) v = maxStock;
        $(this).val(v);

        $('#qtyMinus').prop('disabled', v <= 1);
        $('#qtyPlus').prop('disabled', v >= maxStock);
    });

    /* ============ TABS ============ */
    $('.tab-btn').on('click', function () {
        var tab = $(this).data('tab');
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        $('.tab-content-panel').removeClass('active');
        $('#tab-' + tab).addClass('active');
    });

    /* Scroll to Reviews */
    $('#scrollToReviews').on('click', function (e) {
        e.preventDefault();
        $('.tab-btn[data-tab="reviews"]').trigger('click');
        $('html, body').animate({
            scrollTop: $('#reviewsTab').offset().top - 90
        }, 500);
    });

    /* ============ ADD TO CART (AJAX) ============ */
    $('#addToCartBtn').on('click', function () {
        var $btn = $(this);
        var qty = parseInt($('#qtyInput').val()) || 1;

        var original = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Adding...').prop('disabled', true);

        $.ajax({
            url: '{{ url("/customer/cart/add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                medicine_id: {{ $medicine->id }},
                quantity: qty
            },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $btn.html('<i class="fas fa-check"></i> Added!');
                    showToast('✓ ' + qty + ' item(s) added to cart!');

                    if (res.cart_count !== undefined) {
                        $('.cart-badge').text(res.cart_count).show();
                        $('.cart-count').text(res.cart_count).show();
                    }

                    setTimeout(function () {
                        $btn.html(original).prop('disabled', false);
                    }, 2000);
                } else {
                    $btn.html(original).prop('disabled', false);
                    showToast('⚠ ' + (res.message || 'Failed'), 'error');
                }
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    if (confirm('Please login to add items to cart. Continue to login?')) {
                        window.location.href = '{{ url("/login") }}';
                    } else {
                        $btn.html(original).prop('disabled', false);
                    }
                } else {
                    // Demo fallback
                    $btn.html('<i class="fas fa-check"></i> Added!');
                    showToast('✓ ' + qty + ' item(s) added to cart!');
                    setTimeout(function () {
                        $btn.html(original).prop('disabled', false);
                    }, 2000);
                }
            }
        });
    });

    /* ============ BUY NOW ============ */
    $('#buyNowBtn').on('click', function () {
        var $btn = $(this);
        var qty = parseInt($('#qtyInput').val()) || 1;
        var original = $btn.html();

        $btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...').prop('disabled', true);

        $.ajax({
            url: '{{ url("/customer/cart/add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                medicine_id: {{ $medicine->id }},
                quantity: qty
            },
            dataType: 'json',
            success: function (res) {
                window.location.href = '{{ url("/customer/checkout") }}';
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    window.location.href = '{{ url("/login") }}';
                } else {
                    // Demo fallback
                    window.location.href = '{{ url("/customer/checkout") }}';
                }
            }
        });
    });

    /* ============ STAR RATING INPUT ============ */
    $('#starInput i').on('mouseenter', function () {
        var val = $(this).data('value');
        $('#starInput i').removeClass('hover');
        $('#starInput i').each(function () {
            if ($(this).data('value') <= val) $(this).addClass('hover');
        });
    }).on('mouseleave', function () {
        $('#starInput i').removeClass('hover');
    }).on('click', function () {
        var val = $(this).data('value');
        $('#ratingInput').val(val);
        $('#starInput i').removeClass('active');
        $('#starInput i').each(function () {
            if ($(this).data('value') <= val) $(this).addClass('active');
        });
        $('#ratingError').hide();
    });

    /* ============ REVIEW FORM VALIDATION ============ */
    $('#reviewForm').on('submit', function (e) {
        e.preventDefault();

        var rating = parseInt($('#ratingInput').val());
        var comment = $.trim($('#reviewComment').val());
        var isValid = true;

        $('#ratingError').hide();
        $('#commentError').hide();
        $('#reviewComment').removeClass('error');

        if (rating < 1 || rating > 5) {
            $('#ratingError').fadeIn();
            isValid = false;
        }

        if (comment === '') {
            $('#commentError').text('⚠ Please write your review.').fadeIn();
            $('#reviewComment').addClass('error');
            isValid = false;
        } else if (comment.length < 10) {
            $('#commentError').text('⚠ Review must be at least 10 characters.').fadeIn();
            $('#reviewComment').addClass('error');
            isValid = false;
        } else if (comment.length > 500) {
            $('#commentError').text('⚠ Review must not exceed 500 characters.').fadeIn();
            $('#reviewComment').addClass('error');
            isValid = false;
        }

        if (!isValid) return false;

        var $btn = $('#submitReviewBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
        this.submit();
    });

    $('#reviewComment').on('input', function () {
        if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
            $(this).removeClass('error');
            $('#commentError').hide();
        }
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

});
</script>
@endsection