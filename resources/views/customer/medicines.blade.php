@extends('layouts.customer')

@section('title', 'Browse Medicines')
@section('page_title')
<i class="fas fa-pills"></i> {{ __('messages.hero_browse_medicines') ?? 'Browse Medicines' }}
@endsection

@section('styles')
<style>
    /* Page Header Banner */
    .page-header-banner {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        border-radius: 18px;
        padding: 25px 30px;
        margin-bottom: 25px;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .page-header-banner::after {
        content: '\f484';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 30px;
        bottom: -20px;
        font-size: 8rem;
        opacity: 0.1;
    }

    .page-header-banner h4 {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .page-header-banner p {
        opacity: 0.9;
        font-size: 0.9rem;
        margin: 0;
    }

    /* Main Search Bar */
    .main-search-bar {
        background: var(--white);
        border-radius: 50px;
        padding: 6px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .main-search-bar input {
        flex: 1;
        border: none;
        outline: none;
        padding: 12px 20px;
        font-size: 0.95rem;
        background: transparent;
        font-family: 'Poppins', sans-serif;
    }

    .main-search-bar button {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        border: none;
        color: var(--white);
        padding: 11px 28px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .main-search-bar button:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
    }

    /* Filter Sidebar */
    .filter-sidebar {
        background: var(--white);
        border-radius: 16px;
        padding: 22px;
        box-shadow: var(--shadow);
        position: sticky;
        top: 100px;
        overflow-x: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .filter-sidebar h6 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-text);
        padding-bottom: 12px;
        margin-bottom: 15px;
        border-bottom: 2px dashed var(--pale-green);
    }

    .filter-sidebar h6 i {
        color: var(--primary-green);
        margin-right: 6px;
    }

    .filter-section {
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px solid #F5F5F5;
    }

    .filter-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .filter-section .filter-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-checkbox {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        cursor: pointer;
        user-select: none;
        padding: 5px 0;
        transition: var(--transition);
    }

    .filter-checkbox:hover {
        color: var(--primary-green);
    }

    .filter-checkbox input[type="checkbox"],
    .filter-checkbox input[type="radio"] {
        appearance: none;
        width: 17px;
        height: 17px;
        border: 2px solid #CCC;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 10px;
        transition: var(--transition);
        position: relative;
        flex-shrink: 0;
    }

    .filter-checkbox input[type="radio"] {
        border-radius: 50%;
    }

    .filter-checkbox input[type="checkbox"]:checked,
    .filter-checkbox input[type="radio"]:checked {
        background: var(--primary-green);
        border-color: var(--primary-green);
    }

    .filter-checkbox input[type="checkbox"]:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--white);
        font-size: 0.7rem;
        font-weight: 800;
    }

    .filter-checkbox input[type="radio"]:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--white);
    }

    .filter-checkbox label {
        font-size: 0.86rem;
        color: var(--dark-text);
        margin: 0;
        cursor: pointer;
        flex: 1;
    }

    .filter-checkbox .count {
        color: var(--gray-text);
        font-size: 0.75rem;
    }

    .price-range-wrap {
        padding: 10px 0;
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }

    .price-range-wrap input[type="range"] {
        width: 100%;
        max-width: 100%;
        display: block;
        accent-color: var(--primary-green);
    }

    .price-range-inputs {
        display: flex;
        gap: 8px;
        margin-top: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    .price-range-inputs input {
        flex: 1 1 0;
        min-width: 0;
        /* prevents flex overflow */
        width: 100%;
        padding: 7px 12px;
        border: 1px solid #DDD;
        border-radius: 8px;
        font-size: 0.82rem;
        outline: none;
        transition: var(--transition);
        box-sizing: border-box;
    }

    .price-range-inputs input:focus {
        border-color: var(--primary-green);
    }

    .btn-apply-filter {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 10px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 5px;
    }

    .btn-apply-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
    }

    .btn-clear-filter {
        width: 100%;
        background: transparent;
        color: var(--gray-text);
        border: 1px solid #DDD;
        padding: 8px;
        border-radius: 10px;
        font-size: 0.82rem;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 8px;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .btn-clear-filter:hover {
        background: #FFEBEE;
        color: #C62828;
        border-color: #EF9A9A;
    }

    /* Toolbar */
    .toolbar {
        background: var(--white);
        border-radius: 14px;
        padding: 15px 20px;
        box-shadow: var(--shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .toolbar .result-count {
        font-size: 0.88rem;
        color: var(--dark-text);
    }

    .toolbar .result-count strong {
        color: var(--primary-green);
    }

    .toolbar-right {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .toolbar select {
        padding: 8px 30px 8px 14px;
        border: 1px solid #DDD;
        border-radius: 10px;
        font-size: 0.85rem;
        outline: none;
        background: var(--white);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 10px;
        font-family: 'Poppins', sans-serif;
    }

    .btn-filter-mobile {
        background: var(--primary-green);
        color: var(--white);
        border: none;
        padding: 8px 15px;
        border-radius: 10px;
        font-size: 0.82rem;
        cursor: pointer;
        display: none;
    }

    /* Medicine Card */
    .medicine-item-card {
        background: var(--white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .medicine-item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(46, 125, 50, 0.18);
    }

    .med-item-img-wrap {
        position: relative;
        height: 180px;
        background: var(--pale-green);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .med-item-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .medicine-item-card:hover .med-item-img-wrap img {
        transform: scale(1.08);
    }

    .med-item-img-wrap .no-img {
        font-size: 3rem;
        color: var(--accent-green);
    }

    .med-badge-c {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        z-index: 2;
    }

    .med-badge-c.featured {
        background: linear-gradient(135deg, #FB8C00, #FFA726);
        color: var(--white);
    }

    .med-badge-c.rx {
        background: linear-gradient(135deg, #E53935, #EF5350);
        color: var(--white);
    }

    .med-stock-c {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.95);
        z-index: 2;
    }

    .med-stock-c.in {
        color: #2E7D32;
    }

    .med-stock-c.low {
        color: #FB8C00;
    }

    .med-stock-c.out {
        color: #C62828;
    }

    .med-item-body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .med-item-cat {
        font-size: 0.7rem;
        color: var(--primary-green);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .med-item-body h5 {
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0 0 4px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.5rem;
    }

    .med-item-brand {
        font-size: 0.75rem;
        color: var(--gray-text);
        margin-bottom: 8px;
    }

    .med-item-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 10px;
    }

    .med-item-rating .stars {
        color: #FFC107;
        font-size: 0.75rem;
    }

    .med-item-rating .count {
        font-size: 0.72rem;
        color: var(--gray-text);
    }

    .med-item-footer {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding-top: 10px;
        border-top: 1px solid #F5F5F5;
    }

    .med-item-price {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary-green);
        line-height: 1.1;
    }

    .med-item-price small {
        display: block;
        font-size: 0.7rem;
        color: #999;
        text-decoration: line-through;
        font-weight: 500;
    }

    .btn-add-cart-c {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 9px 15px;
        border-radius: 22px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-add-cart-c:hover:not(:disabled) {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
    }

    .btn-add-cart-c:disabled {
        background: #CCC;
        cursor: not-allowed;
    }

    .btn-add-cart-c.added {
        background: linear-gradient(135deg, #E65100, #FFA726);
        pointer-events: none;
    }

    /* Empty State */
    .empty-state-c {
        background: var(--white);
        border-radius: 16px;
        padding: 60px 30px;
        text-align: center;
        box-shadow: var(--shadow);
    }

    .empty-state-c i {
        font-size: 5rem;
        color: var(--mint-green);
        margin-bottom: 15px;
    }

    .empty-state-c h5 {
        color: var(--gray-text);
        font-weight: 700;
    }

    .empty-state-c p {
        color: #999;
    }

    /* Pagination */
    .pagination-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        gap: 10px;
    }

    .pagination-wrap .pagination {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-wrap: wrap;
    }

    .pagination-wrap .pagination li {
        display: inline-block;
    }

    .pagination-wrap .pagination li a,
    .pagination-wrap .pagination li span,
    .pagination-wrap .pagination .page-link {
        min-width: 40px;
        height: 40px;
        padding: 8px 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px !important;
        border: 1px solid #E0E0E0 !important;
        background: var(--white);
        color: var(--dark-text) !important;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: none;
        margin: 0;
    }

    .pagination-wrap .pagination li a:hover,
    .pagination-wrap .pagination .page-link:hover {
        background: var(--pale-green);
        border-color: var(--primary-green) !important;
        color: var(--primary-green) !important;
    }

    .pagination-wrap .pagination .active .page-link,
    .pagination-wrap .pagination li.active span {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green)) !important;
        color: var(--white) !important;
        border-color: var(--primary-green) !important;
    }

    .pagination-wrap .pagination .disabled span,
    .pagination-wrap .pagination .disabled a {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-wrap .pagination svg,
    .pagination-wrap .pagination i,
    .pagination-wrap .pagination .page-link svg {
        width: 14px !important;
        height: 14px !important;
        max-width: 14px !important;
        max-height: 14px !important;
        display: inline-block;
        vertical-align: middle;
    }

    /* Fallback pagination */
    .pagination-c {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 30px;
    }

    .pagination-c .page-btn {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--white);
        border: 1px solid #E0E0E0;
        color: var(--dark-text);
        font-size: 0.85rem;
        cursor: pointer;
        text-decoration: none;
        transition: var(--transition);
    }

    .pagination-c .page-btn:hover {
        background: var(--pale-green);
        border-color: var(--primary-green);
        color: var(--primary-green);
    }

    .pagination-c .page-btn.active {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border-color: var(--primary-green);
    }

    /* Toast Notification */
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
        animation: slideInRight 0.4s;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Filter modal — hidden by default */
    .filter-modal-overlay {
        display: none;
    }

    .filter-modal {
        display: none;
    }

    .filter-modal-overlay.show {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9998;
    }

    .filter-modal.show {
        display: block;
        position: fixed;
        top: 0;
        right: 0;
        width: 90%;
        max-width: 350px;
        height: 100vh;
        background: var(--white);
        z-index: 9999;
        overflow-y: auto;
        padding: 20px;
        box-shadow: -10px 0 30px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 991px) {
        .filter-sidebar {
            display: none;
        }

        .btn-filter-mobile {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .filter-modal .close-filter {
            position: absolute;
            top: 15px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 1.4rem;
            color: var(--gray-text);
            cursor: pointer;
        }
    }
</style>
@endsection

@section('content')

{{-- Shared batch translation for the Medicines page --}}
@php
use App\Services\GoogleTranslator;

// Normalize $medicines safely (Paginator | Collection | array | null)
if (isset($medicines)) {
if ($medicines instanceof \Illuminate\Pagination\LengthAwarePaginator
|| $medicines instanceof \Illuminate\Pagination\Paginator
|| $medicines instanceof \Illuminate\Support\Collection) {
$medsArray = method_exists($medicines, 'items') ? $medicines->items() : $medicines->all();
if (empty($medsArray)) { $medsArray = $medicines->all(); }
} elseif (is_array($medicines)) {
$medsArray = $medicines;
} else {
$medsArray = [];
}
} else {
$medsArray = [
(object)['id'=>1,'name'=>'Paracetamol 500mg','brand'=>'Crocin','category'=>'Fever & Pain','price'=>25,'mrp'=>30,'stock'=>150,'featured'=>1,'prescription_required'=>0,'image'=>null,'rating'=>4.5,'reviews'=>124],
(object)['id'=>2,'name'=>'Vitamin C 500mg','brand'=>'Limcee','category'=>'Vitamins','price'=>180,'mrp'=>200,'stock'=>80,'featured'=>1,'prescription_required'=>0,'image'=>null,'rating'=>4.7,'reviews'=>89],
(object)['id'=>3,'name'=>'Amoxicillin 250mg','brand'=>'Mox','category'=>'Antibiotic','price'=>85,'mrp'=>100,'stock'=>15,'featured'=>0,'prescription_required'=>1,'image'=>null,'rating'=>4.3,'reviews'=>45],
(object)['id'=>4,'name'=>'Cough Syrup 100ml','brand'=>'Benadryl','category'=>'Cold & Cough','price'=>145,'mrp'=>160,'stock'=>45,'featured'=>0,'prescription_required'=>0,'image'=>null,'rating'=>4.4,'reviews'=>67],
];
}

// Batch-translate medicine names, brands, categories
if (!empty($medsArray)) {
$medNames = GoogleTranslator::translateBatch(array_map(fn($m) => $m->name, $medsArray));
$medBrands = GoogleTranslator::translateBatch(array_map(fn($m) => $m->brand, $medsArray));
$medCats = GoogleTranslator::translateBatch(array_map(fn($m) => $m->category, $medsArray));
foreach ($medsArray as $i => $m) {
$m->name = $medNames[$i] ?? $m->name;
$m->brand = $medBrands[$i] ?? $m->brand;
$m->category = $medCats[$i] ?? $m->category;
}
}

// Sidebar categories
$categoryList = [
['name'=>'Fever & Pain','count'=>24],
['name'=>'Cold & Cough','count'=>18],
['name'=>'Vitamins','count'=>32],
['name'=>'Antibiotic','count'=>15],
['name'=>'Diabetes','count'=>12],
['name'=>'Heart Care','count'=>9],
['name'=>'Digestive','count'=>21],
['name'=>'Skin Care','count'=>28],
['name'=>'Baby Care','count'=>16],
['name'=>'Ayurvedic','count'=>22],
['name'=>'First Aid','count'=>19],
];
$catNames = GoogleTranslator::translateBatch(array_column($categoryList, 'name'));
foreach ($categoryList as $i => $c) {
$categoryList[$i]['display'] = $catNames[$i] ?? $c['name'];
}

$selectedCategory = request('category', '');
$selectedMin = request('min_price', 0);
$selectedMax = request('max_price', 5000);

$strings = GoogleTranslator::translateBatch([
'header_title' => 'Explore Our Medicine Catalog',
'header_desc' => 'Find genuine medicines from verified pharmacies at the best prices.',

'search_placeholder' => 'Search for medicines, brands, health products...',
'search_btn' => 'Search',

'filters' => 'Filters',
'filter_categories' => 'Categories',
'filter_price' => 'Price Range',
'filter_avail' => 'Availability',
'filter_in_stock' => 'In Stock Only',
'filter_featured' => 'Featured Only',
'filter_rx' => 'Prescription',
'filter_no_rx' => 'No Prescription',
'filter_with_rx' => 'Rx Required',
'apply_filters' => 'Apply Filters',
'clear_filters' => 'Clear All Filters',
'placeholder_min' => 'Min',
'placeholder_max' => 'Max',

'showing' => 'Showing',
'medicines_suffix' => 'medicines',
'for' => 'for',
'sort_default' => 'Default Sort',
'sort_price_low' => 'Price: Low to High',
'sort_price_high' => 'Price: High to Low',
'sort_name' => 'Name (A-Z)',
'sort_rating' => 'Highest Rated',
'sort_newest' => 'Newest First',

'badge_featured' => 'Featured',
'badge_rx' => 'Rx',
'stock_in' => 'In Stock',
'stock_low' => 'Low',
'stock_out' => 'Out of Stock',
'add_to_cart' => 'Add',
'out_btn' => 'Out',
'mrp_prefix' => 'MRP',

'no_medicines' => 'No medicines found',
'no_medicines_desc' => "Try adjusting your search or filters to find what you're looking for.",
'clear_and_retry' => 'Clear Filters',

'js_search_min' => '⚠ Please enter at least 2 characters to search.',
'js_added_to_cart' => ':name added to cart!',
'js_add_failed' => 'Failed to add to cart',
'js_login_confirm' => 'You need to login first. Go to login page?',
'js_toast_added' => 'Added to cart!',
]);
@endphp

<!-- Page Header -->
<div class="page-header-banner">
    <h4><i class="fas fa-pills me-2"></i> {{ $strings['header_title'] }}</h4>
    <p>{{ $strings['header_desc'] }}</p>
</div>

<!-- Main Search -->
<form id="mainSearchForm" method="GET" action="{{ url('/customer/medicines') }}">
    <div class="main-search-bar">
        <input type="text" name="search" placeholder="🔍 {{ $strings['search_placeholder'] }}"
            value="{{ request('search') }}" autocomplete="off">
        <button type="submit"><i class="fas fa-search me-1"></i> {{ $strings['search_btn'] }}</button>
    </div>
</form>

<div class="row g-4">
    <!-- ============ FILTER SIDEBAR ============ -->
    <div class="col-lg-3">
        <div class="filter-sidebar">
            <h6><i class="fas fa-filter"></i> {{ $strings['filters'] }}</h6>

            <form method="GET" action="{{ url('/customer/medicines') }}" id="filterForm">
                @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div class="filter-section">
                    <div class="filter-title">{{ $strings['filter_categories'] }}</div>
                    @foreach($categoryList as $cat)
                    <div class="filter-checkbox">
                        <input type="radio" name="category" id="cat_{{ $loop->index }}"
                            value="{{ $cat['name'] }}"
                            {{ $selectedCategory == $cat['name'] ? 'checked' : '' }}>
                        <label for="cat_{{ $loop->index }}">{{ $cat['display'] }}</label>
                        <span class="count">({{ $cat['count'] }})</span>
                    </div>
                    @endforeach
                </div>

                <div class="filter-section">
                    <div class="filter-title">{{ $strings['filter_price'] }}</div>
                    <div class="price-range-wrap">
                        <input type="range" id="priceRange" min="0" max="5000" value="{{ $selectedMax }}" step="50">
                        <div class="price-range-inputs">
                            <input type="number" name="min_price" id="minPrice" placeholder="{{ $strings['placeholder_min'] }}" value="{{ $selectedMin }}" min="0">
                            <input type="number" name="max_price" id="maxPrice" placeholder="{{ $strings['placeholder_max'] }}" value="{{ $selectedMax }}" min="0">
                        </div>
                    </div>
                </div>

                <div class="filter-section">
                    <div class="filter-title">{{ $strings['filter_avail'] }}</div>
                    <div class="filter-checkbox">
                        <input type="checkbox" name="in_stock" value="1" id="inStock"
                            {{ request('in_stock') ? 'checked' : '' }}>
                        <label for="inStock">{{ $strings['filter_in_stock'] }}</label>
                    </div>
                    <div class="filter-checkbox">
                        <input type="checkbox" name="featured" value="1" id="featured"
                            {{ request('featured') ? 'checked' : '' }}>
                        <label for="featured">{{ $strings['filter_featured'] }}</label>
                    </div>
                </div>

                <div class="filter-section">
                    <div class="filter-title">{{ $strings['filter_rx'] }}</div>
                    <div class="filter-checkbox">
                        <input type="radio" name="rx" value="0" id="noRx"
                            {{ request('rx') === '0' ? 'checked' : '' }}>
                        <label for="noRx">{{ $strings['filter_no_rx'] }}</label>
                    </div>
                    <div class="filter-checkbox">
                        <input type="radio" name="rx" value="1" id="withRx"
                            {{ request('rx') === '1' ? 'checked' : '' }}>
                        <label for="withRx">{{ $strings['filter_with_rx'] }}</label>
                    </div>
                </div>

                <button type="submit" class="btn-apply-filter">
                    <i class="fas fa-check"></i> {{ $strings['apply_filters'] }}
                </button>
                <a href="{{ url('/customer/medicines') }}" class="btn-clear-filter">
                    <i class="fas fa-times me-1"></i> {{ $strings['clear_filters'] }}
                </a>
            </form>
        </div>
    </div>

    <!-- ============ MEDICINES LIST ============ -->
    <div class="col-lg-9">
        <div class="toolbar">
            <div class="result-count">
                {{ $strings['showing'] }} <strong>{{ count($medsArray) }}</strong> {{ $strings['medicines_suffix'] }}
                @if(request('search'))
                {{ $strings['for'] }} "<strong>{{ request('search') }}</strong>"
                @endif
            </div>
            <div class="toolbar-right">
                <button type="button" class="btn-filter-mobile" id="showFilterBtn">
                    <i class="fas fa-filter"></i> {{ $strings['filters'] }}
                </button>
                <select id="sortSelect">
                    <option value="">{{ $strings['sort_default'] }}</option>
                    <option value="price_low" {{ request('sort')=='price_low'  ? 'selected' : '' }}>{{ $strings['sort_price_low'] }}</option>
                    <option value="price_high" {{ request('sort')=='price_high' ? 'selected' : '' }}>{{ $strings['sort_price_high'] }}</option>
                    <option value="name" {{ request('sort')=='name'       ? 'selected' : '' }}>{{ $strings['sort_name'] }}</option>
                    <option value="rating" {{ request('sort')=='rating'     ? 'selected' : '' }}>{{ $strings['sort_rating'] }}</option>
                    <option value="newest" {{ request('sort')=='newest'     ? 'selected' : '' }}>{{ $strings['sort_newest'] }}</option>
                </select>
            </div>
        </div>

        @if(count($medsArray) > 0)
        <div class="row g-3">
            @foreach($medsArray as $med)
            @php
            $stockClass = $med->stock <= 0 ? 'out' : ($med->stock < 20 ? 'low' : 'in' );
                    if ($med->stock <= 0) {
                        $stockText=$strings['stock_out'];
                        } elseif ($med->stock < 20) {
                            $stockText=$strings['stock_low'] . ': ' . $med->stock;
                            } else {
                            $stockText = $strings['stock_in'];
                            }
                            @endphp
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="medicine-item-card">
                                    <div class="med-item-img-wrap">
                                        @if(!empty($med->image) && file_exists(public_path('uploads/medicines/'.$med->image)))
                                        <img src="{{ asset('uploads/medicines/'.$med->image) }}" alt="{{ $med->name }}">
                                        @else
                                        <i class="fas fa-pills no-img"></i>
                                        @endif

                                        @if($med->prescription_required)
                                        <span class="med-badge-c rx"><i class="fas fa-file-prescription"></i> {{ $strings['badge_rx'] }}</span>
                                        @elseif($med->featured)
                                        <span class="med-badge-c featured"><i class="fas fa-star"></i> {{ $strings['badge_featured'] }}</span>
                                        @endif

                                        <span class="med-stock-c {{ $stockClass }}">
                                            <i class="fas {{ $med->stock > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                            {{ $stockText }}
                                        </span>
                                    </div>

                                    <div class="med-item-body">
                                        <div class="med-item-cat">{{ $med->category }}</div>
                                        <h5>
                                            <a href="{{ url('/customer/medicine/'.$med->id) }}" style="color:inherit;text-decoration:none;">
                                                {{ $med->name }}
                                            </a>
                                        </h5>
                                        <div class="med-item-brand">
                                            <i class="fas fa-tag me-1"></i> {{ $med->brand }}
                                        </div>

                                        <div class="med-item-rating">
                                            <span class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa{{ $i <= round($med->rating ?? 4.5) ? 's' : 'r' }} fa-star"></i>
                                                    @endfor
                                            </span>
                                            <span class="count">({{ $med->reviews ?? 0 }})</span>
                                        </div>

                                        <div class="med-item-footer">
                                            <div class="med-item-price">
                                                ₹{{ number_format($med->price, 0) }}
                                                @if(($med->mrp ?? 0) > $med->price)
                                                <small>{{ $strings['mrp_prefix'] }} ₹{{ number_format($med->mrp, 0) }}</small>
                                                @endif
                                            </div>
                                            @if($med->stock > 0)
                                            <button type="button" class="btn-add-cart-c btn-add-cart"
                                                data-med-id="{{ $med->id }}"
                                                data-med-name="{{ $med->name }}">
                                                <i class="fas fa-cart-plus"></i> {{ $strings['add_to_cart'] }}
                                            </button>
                                            @else
                                            <button type="button" class="btn-add-cart-c" disabled>
                                                <i class="fas fa-times"></i> {{ $strings['out_btn'] }}
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
        </div>

        <!-- Pagination -->
        @if(isset($medicines) && method_exists($medicines, 'links'))
        <div class="pagination-wrap">
            {{ $medicines->appends(request()->all())->links() }}
        </div>
        @else
        <div class="pagination-c">
            <a href="#" class="page-btn"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="page-btn active">1</a>
            <a href="#" class="page-btn">2</a>
            <a href="#" class="page-btn">3</a>
            <a href="#" class="page-btn">...</a>
            <a href="#" class="page-btn">8</a>
            <a href="#" class="page-btn"><i class="fas fa-chevron-right"></i></a>
        </div>
        @endif
        @else
        <div class="empty-state-c">
            <i class="fas fa-pills"></i>
            <h5>{{ $strings['no_medicines'] }}</h5>
            <p>{{ $strings['no_medicines_desc'] }}</p>
            <a href="{{ url('/customer/medicines') }}" class="btn-apply-filter"
                style="max-width:250px;margin:15px auto 0;text-decoration:none;display:inline-block;">
                <i class="fas fa-undo"></i> {{ $strings['clear_and_retry'] }}
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Mobile Filter Modal -->
<div class="filter-modal-overlay" id="filterModalOverlay"></div>
<div class="filter-modal" id="filterModal">
    <button type="button" class="close-filter" id="closeFilterBtn"><i class="fas fa-times"></i></button>
    <h6 style="font-weight:700;color:var(--dark-text);margin-bottom:15px;padding-right:30px;">
        <i class="fas fa-filter" style="color:var(--primary-green);"></i> {{ $strings['filters'] }}
    </h6>
    <div id="mobileFilterContent">
        <!-- Filled by jQuery -->
    </div>
</div>

<!-- Cart Toast -->
<div class="cart-toast" id="cartToast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage">{{ $strings['js_toast_added'] }}</span>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        var jsStrings = {
            searchMin: @json($strings['js_search_min']),
            addedToCart: @json($strings['js_added_to_cart']),
            addFailed: @json($strings['js_add_failed']),
            loginConfirm: @json($strings['js_login_confirm']),
            toastAdded: @json($strings['js_toast_added'])
        };

        var ADD_TO_CART_LABEL = @json($strings['add_to_cart']);

        function tpl(str, key, val) {
            return str.replace(':' + key, val);
        }

        /* ============ SORT ============ */
        $('#sortSelect').on('change', function() {
            var url = new URL(window.location.href);
            if ($(this).val()) url.searchParams.set('sort', $(this).val());
            else url.searchParams.delete('sort');
            window.location.href = url.toString();
        });

        /* ============ PRICE RANGE ============ */
        $('#priceRange').on('input', function() {
            $('#maxPrice').val($(this).val());
        });

        $('#maxPrice').on('input', function() {
            var v = parseInt($(this).val()) || 0;
            if (v > 5000) v = 5000;
            $('#priceRange').val(v);
        });

        $('#minPrice, #maxPrice').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        /* ============ CATEGORY AUTO-SUBMIT ============ */
        $('input[name="category"]').on('change', function() {
            $('#filterForm').submit();
        });

        /* ============ SEARCH VALIDATION ============ */
        $('#mainSearchForm').on('submit', function(e) {
            var val = $.trim($(this).find('input[name="search"]').val());
            if (val.length > 0 && val.length < 2) {
                e.preventDefault();
                alert(jsStrings.searchMin);
                return false;
            }
        });

        /* ============ ADD TO CART ============ */
        $('.btn-add-cart').on('click', function() {
            var $btn = $(this);
            var medId = $btn.data('med-id');
            var medName = $btn.data('med-name');

            if ($btn.hasClass('added')) return;

            var originalHtml = $btn.html();
            $btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            $.ajax({
                url: '{{ url("/customer/cart/add") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    medicine_id: medId,
                    quantity: 1
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $btn.removeClass('btn-add-cart').addClass('added')
                            .html('<i class="fas fa-check"></i> ' + ADD_TO_CART_LABEL)
                            .prop('disabled', false);

                        showToast('✓ ' + tpl(jsStrings.addedToCart, 'name', medName));

                        if (res.cart_count !== undefined) {
                            $('.cart-badge').text(res.cart_count).show();
                            $('.cart-count').text(res.cart_count).show();
                        }

                        setTimeout(function() {
                            $btn.removeClass('added').addClass('btn-add-cart').html(originalHtml).prop('disabled', false);
                        }, 2000);
                    } else {
                        $btn.html(originalHtml).prop('disabled', false);
                        showToast('⚠ ' + (res.message || jsStrings.addFailed), 'error');
                    }
                },
                error: function(xhr) {
                    $btn.html(originalHtml).prop('disabled', false);

                    if (xhr.status === 401) {
                        if (confirm(jsStrings.loginConfirm)) {
                            window.location.href = '{{ url("/login") }}';
                        }
                    } else {
                        $btn.removeClass('btn-add-cart').addClass('added')
                            .html('<i class="fas fa-check"></i> ' + ADD_TO_CART_LABEL)
                            .prop('disabled', false);
                        showToast('✓ ' + tpl(jsStrings.addedToCart, 'name', medName));

                        setTimeout(function() {
                            $btn.removeClass('added').addClass('btn-add-cart').html(originalHtml).prop('disabled', false);
                        }, 2000);
                    }
                }
            });
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

        /* ============ MOBILE FILTER MODAL ============ */
        $('#showFilterBtn').on('click', function() {
            var filterHtml = $('.filter-sidebar form').clone().attr('id', 'mobileFilterForm').prop('outerHTML');
            $('#mobileFilterContent').html(filterHtml);
            $('#filterModal').addClass('show');
            $('#filterModalOverlay').addClass('show');
            $('#mobileFilterContent #priceRange').on('input', function() {
                $('#mobileFilterContent #maxPrice').val($(this).val());
            });
        });

        $('#closeFilterBtn, #filterModalOverlay').on('click', function() {
            $('#filterModal').removeClass('show');
            $('#filterModalOverlay').removeClass('show');
        });

    });
</script>
@endsection