@extends('layouts.pharmacy')

@section('title', 'Pharmacy Dashboard')
@section('page_title')
<i class="fas fa-tachometer-alt"></i> {{ __('messages.nav_dashboard') ?? 'Dashboard' }}
@endsection

@section('styles')
<style>
    .welcome-banner-ph {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 20px;
        padding: 30px 35px;
        color: var(--white);
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .welcome-banner-ph::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .welcome-banner-ph::after {
        content: '\f0f9';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 30px;
        bottom: -30px;
        font-size: 10rem;
        opacity: 0.08;
    }

    .welcome-content-ph {
        position: relative;
        z-index: 2;
    }

    .welcome-content-ph h3 {
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0 0 8px;
    }

    .welcome-content-ph p {
        opacity: 0.9;
        font-size: 0.95rem;
        margin: 0 0 15px;
        max-width: 600px;
    }

    .welcome-btns-ph {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .wb-ph {
        background: var(--white);
        color: var(--primary-green);
        padding: 10px 22px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.88rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        border: none;
    }

    .wb-ph:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        color: var(--dark-green);
    }

    .wb-ph.outline {
        background: transparent;
        color: var(--white);
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .wb-ph.outline:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: var(--white);
        color: var(--white);
    }

    /* Stats */
    .stat-card-ph {
        background: var(--white);
        border-radius: 16px;
        padding: 18px 20px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 14px;
        height: 100%;
    }

    .stat-card-ph:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(46, 125, 50, 0.15);
    }

    .stat-icon-ph {
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--white);
    }

    .si-medicines {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .si-orders {
        background: linear-gradient(135deg, #1565C0, #42A5F5);
    }

    .si-revenue {
        background: linear-gradient(135deg, #7B1FA2, #AB47BC);
    }

    .si-pending {
        background: linear-gradient(135deg, #E65100, #FFA726);
    }

    .si-lowstock {
        background: linear-gradient(135deg, #C62828, #EF5350);
    }

    .si-customers {
        background: linear-gradient(135deg, #00695C, #26A69A);
    }

    .stat-card-ph .sp-val {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1.1;
    }

    .stat-card-ph .sp-lbl {
        font-size: 0.75rem;
        color: var(--gray-text);
        font-weight: 500;
    }

    .stat-card-ph .sp-trend {
        font-size: 0.68rem;
        font-weight: 600;
        display: inline-block;
        padding: 1px 6px;
        border-radius: 8px;
        margin-top: 2px;
    }

    .sp-trend.up {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .sp-trend.down {
        background: #FFEBEE;
        color: #C62828;
    }

    /* Cards */
    .dash-card-ph {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .dash-card-header-ph {
        padding: 14px 22px;
        background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dash-card-header-ph h6 {
        margin: 0;
        font-weight: 700;
        color: var(--dark-text);
        font-size: 0.95rem;
    }

    .dash-card-header-ph h6 i {
        color: var(--primary-green);
        margin-right: 8px;
    }

    .dash-card-header-ph a {
        font-size: 0.78rem;
        color: var(--primary-green);
        font-weight: 600;
        text-decoration: none;
    }

    .dash-card-header-ph a:hover {
        text-decoration: underline;
    }

    .dash-card-body-ph {
        padding: 18px 22px;
    }

    /* Recent Orders */
    .order-mini-ph {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #F5F5F5;
    }

    .order-mini-ph:last-child {
        border-bottom: none;
    }

    .om-ph-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 10px;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }

    .om-ph-info {
        flex: 1;
    }

    .om-ph-info strong {
        font-size: 0.86rem;
        color: var(--dark-text);
        display: block;
    }

    .om-ph-info span {
        font-size: 0.72rem;
        color: var(--gray-text);
    }

    .om-ph-status {
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .oms-ph-pending {
        background: #FFF3E0;
        color: #E65100;
    }

    .oms-ph-confirmed {
        background: #E3F2FD;
        color: #1565C0;
    }

    .oms-ph-processing {
        background: #F3E5F5;
        color: #7B1FA2;
    }

    .oms-ph-delivered {
        background: #E8F5E9;
        color: #1B5E20;
    }

    .oms-ph-cancelled {
        background: #FFEBEE;
        color: #B71C1C;
    }

    .om-ph-price {
        font-weight: 700;
        color: var(--primary-green);
        font-size: 0.88rem;
        white-space: nowrap;
    }

    /* Low Stock */
    .low-stock-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #F5F5F5;
    }

    .low-stock-item:last-child {
        border-bottom: none;
    }

    .ls-icon-ph {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #FFF3E0;
        color: #FB8C00;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }

    .ls-info-ph {
        flex: 1;
    }

    .ls-info-ph strong {
        font-size: 0.82rem;
        color: var(--dark-text);
        display: block;
    }

    .ls-info-ph span {
        font-size: 0.7rem;
        color: var(--gray-text);
    }

    .ls-stock-val {
        font-weight: 700;
        font-size: 0.8rem;
    }

    .ls-stock-val.critical {
        color: #E53935;
    }

    .ls-stock-val.warning {
        color: #FB8C00;
    }

    /* ==========================================
       Quick Actions — 4 tiles in one row
       ========================================== */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    .quick-action-ph {
        text-align: center;
        padding: 12px 6px;
        background: var(--white);
        border: 1.5px solid #E8E8E8;
        border-radius: 12px;
        transition: var(--transition);
        text-decoration: none;
        display: block;
    }

    .quick-action-ph:hover {
        transform: translateY(-3px);
        border-color: var(--light-green);
        box-shadow: 0 6px 18px rgba(46, 125, 50, 0.12);
    }

    .qa-icon-ph {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        margin: 0 auto 6px;
        transition: var(--transition);
    }

    .quick-action-ph:hover .qa-icon-ph {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
    }

    .quick-action-ph h6 {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 1px;
        line-height: 1.2;
    }

    .quick-action-ph p {
        font-size: 0.62rem;
        color: var(--gray-text);
        margin: 0;
        line-height: 1.2;
    }

    /* On small screens, wrap to 2 columns so tiles stay usable */
    @media (max-width: 576px) {
        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .welcome-content-ph h3 {
            font-size: 1.4rem;
        }
    }
</style>
@endsection

@section('content')

{{-- Shared batch translation for the Pharmacy Dashboard --}}
@php
use App\Services\GoogleTranslator;

$pharmacyName = session('pharmacy_name') ?? 'MediCare Pharmacy';
$totalMedicines = $totalMedicines ?? 145;
$totalOrders = $totalOrders ?? 428;
$todayRevenue = $todayRevenue ?? 12580;
$pendingOrders = $pendingOrders ?? 8;
$lowStockCount = $lowStockCount ?? 5;
$totalCustomers = $totalCustomers ?? 312;

$recentOrders = $recentOrders ?? [
(object)['id'=>101,'customer_name'=>'Ramesh Patil','items'=>3,'total'=>780,'status'=>'pending','time'=>'5 min ago'],
(object)['id'=>100,'customer_name'=>'Sunita Sharma','items'=>5,'total'=>1250,'status'=>'confirmed','time'=>'20 min ago'],
(object)['id'=>99,'customer_name'=>'Arjun Verma','items'=>2,'total'=>450,'status'=>'processing','time'=>'1 hr ago'],
(object)['id'=>98,'customer_name'=>'Priya Deshmukh','items'=>4,'total'=>920,'status'=>'delivered','time'=>'3 hrs ago'],
(object)['id'=>97,'customer_name'=>'Amit Kulkarni','items'=>1,'total'=>180,'status'=>'delivered','time'=>'5 hrs ago'],
];

$lowStockMedicines = $lowStockMedicines ?? [
(object)['name'=>'Amoxicillin 250mg','brand'=>'Mox','stock'=>8],
(object)['name'=>'Insulin Injection','brand'=>'Humulin','stock'=>3],
(object)['name'=>'BP Medicine','brand'=>'Amlong','stock'=>12],
(object)['name'=>'Cough Syrup','brand'=>'Benadryl','stock'=>5],
(object)['name'=>'Vitamin D3','brand'=>'Shelcal','stock'=>15],
];

// Normalize to arrays
$roArr = is_array($recentOrders) ? $recentOrders : (method_exists($recentOrders, 'all') ? $recentOrders->all() : []);
$lsArr = is_array($lowStockMedicines) ? $lowStockMedicines : (method_exists($lowStockMedicines, 'all') ? $lowStockMedicines->all() : []);

// ONE combined batch: order customer names + low-stock medicine names + brands
$flat = [];
foreach ($roArr as $o) {
$flat[] = $o->customer_name ?? '';
}
foreach ($lsArr as $m) {
$flat[] = $m->name ?? '';
$flat[] = $m->brand ?? '';
}

$phStrings = GoogleTranslator::translateBatch([
// Welcome banner
'welcome_title' => 'Welcome, :name!',
'welcome_desc' => "Manage your inventory, track orders and grow your pharmacy business with Sanjivani's powerful dashboard.",
'btn_add_medicine' => 'Add Medicine',
'btn_view_orders' => 'View Orders',
'pending_suffix' => 'pending',

// Stat cards
'stat_medicines' => 'Medicines',
'stat_total_orders' => 'Total Orders',
'stat_today_revenue' => 'Today Revenue',
'stat_pending' => 'Pending',
'stat_low_stock' => 'Low Stock',
'stat_customers' => 'Customers',

// Recent Orders
'recent_orders' => 'Recent Orders',
'view_all' => 'View All',
'items_suffix' => 'items',

// Low Stock
'low_stock_alert' => 'Low Stock Alert',
'manage' => 'Manage',
'left_suffix' => 'left',

// Quick Actions
'quick_actions' => 'Quick Actions',
'qa_add_title' => 'Add Medicine',
'qa_add_desc' => 'New product',
'qa_pending_title' => 'Pending',
'qa_pending_desc' => 'orders',
'qa_stock_title' => 'Update Stock',
'qa_stock_desc' => 'low',
'qa_profile_title' => 'Profile',
'qa_profile_desc' => 'Edit info',

// Statuses
'status_pending' => 'Pending',
'status_confirmed' => 'Confirmed',
'status_processing' => 'Processing',
'status_delivered' => 'Delivered',
'status_cancelled' => 'Cancelled',
]);

// Apply translation to order names, low-stock medicine names + brands
if (!empty($flat)) {
$translated = GoogleTranslator::translateBatch($flat);

$offset = 0;
foreach ($roArr as $i => $o) {
$o->customer_name = $translated[$offset + $i] ?? $o->customer_name;
}
$offset += count($roArr);

$lsCount = count($lsArr);
foreach ($lsArr as $i => $m) {
$m->name = $translated[$offset + $i] ?? $m->name;
$m->brand = $translated[$offset + $lsCount + $i] ?? $m->brand;
}

$recentOrders = collect($roArr);
$lowStockMedicines = collect($lsArr);
}
@endphp

<!-- Welcome Banner -->
<div class="welcome-banner-ph">
    <div class="welcome-content-ph">
        <h3>{{ str_replace(':name', $pharmacyName, $phStrings['welcome_title']) }} 🏥</h3>
        <p>{{ $phStrings['welcome_desc'] }}</p>
        <div class="welcome-btns-ph">
            <a href="{{ url('/pharmacy/add-medicine') }}" class="wb-ph">
                <i class="fas fa-plus-circle"></i> {{ $phStrings['btn_add_medicine'] }}
            </a>
            <a href="{{ url('/pharmacy/orders') }}" class="wb-ph outline">
                <i class="fas fa-shopping-cart"></i> {{ $phStrings['btn_view_orders'] }} ({{ $pendingOrders }} {{ $phStrings['pending_suffix'] }})
            </a>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-medicines"><i class="fas fa-pills"></i></div>
            <div>
                <div class="sp-val">{{ $totalMedicines }}</div>
                <div class="sp-lbl">{{ $phStrings['stat_medicines'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-orders"><i class="fas fa-shopping-cart"></i></div>
            <div>
                <div class="sp-val">{{ $totalOrders }}</div>
                <div class="sp-lbl">{{ $phStrings['stat_total_orders'] }}</div>
                <span class="sp-trend up"><i class="fas fa-arrow-up"></i> +12%</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-revenue"><i class="fas fa-rupee-sign"></i></div>
            <div>
                <div class="sp-val">₹{{ number_format($todayRevenue) }}</div>
                <div class="sp-lbl">{{ $phStrings['stat_today_revenue'] }}</div>
                <span class="sp-trend up"><i class="fas fa-arrow-up"></i> +8%</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-pending"><i class="fas fa-clock"></i></div>
            <div>
                <div class="sp-val">{{ $pendingOrders }}</div>
                <div class="sp-lbl">{{ $phStrings['stat_pending'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-lowstock"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <div class="sp-val">{{ $lowStockCount }}</div>
                <div class="sp-lbl">{{ $phStrings['stat_low_stock'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-customers"><i class="fas fa-users"></i></div>
            <div>
                <div class="sp-val">{{ $totalCustomers }}</div>
                <div class="sp-lbl">{{ $phStrings['stat_customers'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="dash-card-ph">
            <div class="dash-card-header-ph">
                <h6><i class="fas fa-shopping-cart"></i> {{ $phStrings['recent_orders'] }}</h6>
                <a href="{{ url('/pharmacy/orders') }}">{{ $phStrings['view_all'] }} <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="dash-card-body-ph">
                @foreach($recentOrders as $ord)
                @php
                $st = strtolower($ord->status ?? 'pending');
                $stLabel = $phStrings['status_' . $st] ?? ucfirst($st);
                @endphp
                <div class="order-mini-ph">
                    <div class="om-ph-icon"><i class="fas fa-box"></i></div>
                    <div class="om-ph-info">
                        <strong>#ORD-{{ str_pad($ord->id, 4, '0', STR_PAD_LEFT) }} — {{ $ord->customer_name }}</strong>
                        <span><i class="fas fa-shopping-bag me-1"></i>{{ $ord->items }} {{ $phStrings['items_suffix'] }} · {{ $ord->time }}</span>
                    </div>
                    <span class="om-ph-status oms-ph-{{ $st }}">
                        {{ $stLabel }}
                    </span>
                    <span class="om-ph-price">₹{{ number_format($ord->total) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Low Stock -->
        <div class="dash-card-ph">
            <div class="dash-card-header-ph">
                <h6><i class="fas fa-exclamation-triangle" style="color:#FB8C00;"></i> {{ $phStrings['low_stock_alert'] }}</h6>
                <a href="{{ url('/pharmacy/medicines') }}">{{ $phStrings['manage'] }}</a>
            </div>
            <div class="dash-card-body-ph">
                @foreach($lowStockMedicines as $med)
                <div class="low-stock-item">
                    <div class="ls-icon-ph"><i class="fas fa-pills"></i></div>
                    <div class="ls-info-ph">
                        <strong>{{ $med->name }}</strong>
                        <span>{{ $med->brand }}</span>
                    </div>
                    <span class="ls-stock-val {{ $med->stock <= 5 ? 'critical' : 'warning' }}">
                        {{ $med->stock }} {{ $phStrings['left_suffix'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions — 4 tiles in one row -->
        <div class="dash-card-ph">
            <div class="dash-card-header-ph">
                <h6><i class="fas fa-bolt"></i> {{ $phStrings['quick_actions'] }}</h6>
            </div>
            <div class="dash-card-body-ph">
                <div class="quick-actions-grid">
                    <a href="{{ url('/pharmacy/add-medicine') }}" class="quick-action-ph">
                        <div class="qa-icon-ph"><i class="fas fa-plus-circle"></i></div>
                        <h6>{{ $phStrings['qa_add_title'] }}</h6>
                        <p>{{ $phStrings['qa_add_desc'] }}</p>
                    </a>
                    <a href="{{ url('/pharmacy/orders?status=pending') }}" class="quick-action-ph">
                        <div class="qa-icon-ph"><i class="fas fa-clock"></i></div>
                        <h6>{{ $phStrings['qa_pending_title'] }}</h6>
                        <p>{{ $pendingOrders }} {{ $phStrings['qa_pending_desc'] }}</p>
                    </a>
                    <a href="{{ url('/pharmacy/medicines?stock=low') }}" class="quick-action-ph">
                        <div class="qa-icon-ph"><i class="fas fa-boxes-stacked"></i></div>
                        <h6>{{ $phStrings['qa_stock_title'] }}</h6>
                        <p>{{ $lowStockCount }} {{ $phStrings['qa_stock_desc'] }}</p>
                    </a>
                    <a href="{{ url('/pharmacy/profile') }}" class="quick-action-ph">
                        <div class="qa-icon-ph"><i class="fas fa-user-circle"></i></div>
                        <h6>{{ $phStrings['qa_profile_title'] }}</h6>
                        <p>{{ $phStrings['qa_profile_desc'] }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{-- No scripts needed — chart removed --}}
@endsection