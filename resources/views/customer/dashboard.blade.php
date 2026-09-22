@extends('layouts.customer')

@section('title', 'Dashboard')
@section('page_title')
<i class="fas fa-tachometer-alt"></i> Dashboard
@endsection

@section('styles')
<style>
    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 20px;
        padding: 30px 35px;
        margin-bottom: 25px;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .welcome-banner::after {
        content: '\f484';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 40px;
        bottom: -30px;
        font-size: 10rem;
        opacity: 0.1;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .welcome-content h3 {
        font-size: 1.9rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .welcome-content p {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 20px;
        max-width: 600px;
    }

    .welcome-btns {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .wb-btn {
        background: var(--white);
        color: var(--primary-green);
        padding: 11px 25px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        border: none;
    }

    .wb-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        color: var(--dark-green);
    }

    .wb-btn.outline {
        background: transparent;
        color: var(--white);
        border: 2px solid rgba(255,255,255,0.5);
    }

    .wb-btn.outline:hover {
        background: rgba(255,255,255,0.15);
        border-color: var(--white);
        color: var(--white);
    }

    /* Stats Cards */
    .stat-card {
        background: var(--white);
        border-radius: 18px;
        padding: 20px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.15);
    }

    .stat-icon-c {
        width: 55px;
        height: 55px;
        min-width: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--white);
    }

    .icon-total    { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .icon-pending  { background: linear-gradient(135deg, #E65100, #FFA726); }
    .icon-delivered{ background: linear-gradient(135deg, #1565C0, #42A5F5); }
    .icon-spent    { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }

    .stat-card .s-val {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1.1;
    }

    .stat-card .s-lbl {
        font-size: 0.78rem;
        color: var(--gray-text);
        font-weight: 500;
    }

    /* Cards */
    .dash-card {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .dash-card-header {
        padding: 18px 22px;
        border-bottom: 1px solid #EEE;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dash-card-header h6 {
        font-weight: 700;
        color: var(--dark-text);
        margin: 0;
    }

    .dash-card-header h6 i {
        color: var(--primary-green);
        margin-right: 8px;
    }

    .dash-card-header a {
        font-size: 0.82rem;
        color: var(--primary-green);
        font-weight: 600;
        text-decoration: none;
    }

    .dash-card-header a:hover {
        text-decoration: underline;
    }

    .dash-card-body { padding: 20px 22px; }

    /* Order Cards */
    .order-mini {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 14px 0;
        border-bottom: 1px solid #F5F5F5;
    }

    .order-mini:last-child { border-bottom: none; }

    .order-mini .om-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 12px;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .order-mini .om-info {
        flex: 1;
    }

    .order-mini .om-info strong {
        font-size: 0.92rem;
        color: var(--dark-text);
        display: block;
    }

    .order-mini .om-info span {
        font-size: 0.78rem;
        color: var(--gray-text);
    }

    .om-status {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .oms-pending          { background: #FFF3E0; color: #FB8C00; }
    .oms-confirmed        { background: #E3F2FD; color: #1976D2; }
    .oms-processing       { background: #F3E5F5; color: #7B1FA2; }
    .oms-out_for_delivery { background: #FCE4EC; color: #C2185B; }
    .oms-delivered        { background: #E8F5E9; color: #2E7D32; }
    .oms-cancelled        { background: #FFEBEE; color: #C62828; }

    .om-price {
        font-weight: 700;
        color: var(--primary-green);
        font-size: 0.95rem;
        white-space: nowrap;
    }

    /* Quick Categories */
    .cat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .cat-item {
        text-align: center;
        padding: 18px 10px;
        background: var(--pale-green);
        border-radius: 14px;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: block;
    }

    .cat-item:hover {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        transform: translateY(-3px);
    }

    .cat-item:hover .cat-icon-c,
    .cat-item:hover .cat-name-c {
        color: var(--white);
    }

    .cat-icon-c {
        font-size: 1.8rem;
        color: var(--primary-green);
        margin-bottom: 6px;
        transition: var(--transition);
    }

    .cat-name-c {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--dark-text);
        transition: var(--transition);
        display: block;
    }

    /* Featured Medicines */
    .med-mini-card {
        background: var(--white);
        border: 1px solid #EEE;
        border-radius: 14px;
        padding: 15px;
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .med-mini-card:hover {
        border-color: var(--light-green);
        box-shadow: 0 6px 20px rgba(46,125,50,0.1);
        transform: translateY(-3px);
    }

    .med-mini-img {
        height: 120px;
        background: var(--pale-green);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--accent-green);
        margin-bottom: 10px;
        overflow: hidden;
    }

    .med-mini-img img {
        width: 100%; height: 100%; object-fit: cover;
    }

    .med-mini-card h6 {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .med-mini-brand {
        font-size: 0.72rem;
        color: var(--gray-text);
        margin-bottom: 8px;
    }

    .med-mini-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .med-mini-price {
        font-size: 1rem;
        font-weight: 800;
        color: var(--primary-green);
    }

    .btn-mini-cart {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-mini-cart:hover {
        transform: scale(1.05);
        color: var(--white);
    }

    /* Empty States */
    .empty-state-mini {
        text-align: center;
        padding: 30px 20px;
        color: var(--gray-text);
    }

    .empty-state-mini i {
        font-size: 3rem;
        color: var(--mint-green);
        margin-bottom: 10px;
    }

    .empty-state-mini p {
        font-size: 0.9rem;
        margin: 0;
    }

    /* Announcement Card */
    .announce-card {
        background: linear-gradient(135deg, #FFF3E0, #FFECB3);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        border-left: 5px solid #FB8C00;
        margin-bottom: 20px;
    }

    .announce-card i {
        font-size: 1.8rem;
        color: #FB8C00;
    }

    .announce-card h6 {
        margin: 0 0 3px;
        color: #E65100;
        font-weight: 700;
    }

    .announce-card p {
        margin: 0;
        color: #6D4C41;
        font-size: 0.85rem;
    }

    @media (max-width: 576px) {
        .welcome-content h3 { font-size: 1.4rem; }
        .cat-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endsection

@section('content')

@php
    $custName = session('customer_name') ?? 'Customer';

    // Demo data fallbacks
    $totalOrdersCount = $totalOrders ?? 5;
    $pendingOrdersCount = $pendingOrders ?? 2;
    $deliveredOrdersCount = $deliveredOrders ?? 3;
    $totalSpent = $totalSpent ?? 4560;

    $demoRecentOrders = $recentOrders ?? [
        (object)['id'=>1, 'total_amount'=>780, 'status'=>'processing',       'items_count'=>3, 'created_at'=>now()->subHours(4)],
        (object)['id'=>2, 'total_amount'=>1250,'status'=>'delivered',        'items_count'=>5, 'created_at'=>now()->subDays(2)],
        (object)['id'=>3, 'total_amount'=>450, 'status'=>'out_for_delivery', 'items_count'=>2, 'created_at'=>now()->subDays(3)],
        (object)['id'=>4, 'total_amount'=>320, 'status'=>'delivered',        'items_count'=>1, 'created_at'=>now()->subDays(7)],
    ];

    $demoFeatured = $featuredMedicines ?? [
        (object)['id'=>1,'name'=>'Paracetamol 500mg','brand'=>'Crocin','price'=>25,'image'=>null],
        (object)['id'=>2,'name'=>'Vitamin C Tablets','brand'=>'Limcee','price'=>180,'image'=>null],
        (object)['id'=>3,'name'=>'Cough Syrup 100ml','brand'=>'Benadryl','price'=>145,'image'=>null],
        (object)['id'=>4,'name'=>'Multi Vitamin','brand'=>'Revital','price'=>320,'image'=>null],
    ];
@endphp

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-content">
        <h3>Welcome back, {{ $custName }}! 👋</h3>
        <p>Your health is our top priority. Order medicines from verified pharmacies and get doorstep delivery within hours.</p>
        <div class="welcome-btns">
            <a href="{{ url('/customer/medicines') }}" class="wb-btn">
                <i class="fas fa-pills"></i> Browse Medicines
            </a>
            <a href="{{ url('/customer/prescription') }}" class="wb-btn outline">
                <i class="fas fa-file-prescription"></i> Upload Prescription
            </a>
        </div>
    </div>
</div>

<!-- Announcement -->
<div class="announce-card">
    <i class="fas fa-truck-fast"></i>
    <div>
        <h6>Free Delivery on orders above ₹500!</h6>
        <p>Order today and save on delivery charges. Available in your area.</p>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon-c icon-total"><i class="fas fa-box"></i></div>
            <div>
                <div class="s-val">{{ $totalOrdersCount }}</div>
                <div class="s-lbl">Total Orders</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon-c icon-pending"><i class="fas fa-clock"></i></div>
            <div>
                <div class="s-val">{{ $pendingOrdersCount }}</div>
                <div class="s-lbl">Pending Orders</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon-c icon-delivered"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="s-val">{{ $deliveredOrdersCount }}</div>
                <div class="s-lbl">Delivered</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon-c icon-spent"><i class="fas fa-rupee-sign"></i></div>
            <div>
                <div class="s-val">₹{{ number_format($totalSpent) }}</div>
                <div class="s-lbl">Total Spent</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-7">
        <div class="dash-card">
            <div class="dash-card-header">
                <h6><i class="fas fa-history"></i> Recent Orders</h6>
                <a href="{{ url('/customer/orders') }}">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="dash-card-body">
                @if(count($demoRecentOrders) > 0)
                    @foreach($demoRecentOrders as $ord)
                        <div class="order-mini">
                            <div class="om-icon"><i class="fas fa-box"></i></div>
                            <div class="om-info">
                                <strong>Order #ORD-{{ str_pad($ord->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                <span>
                                    <i class="fas fa-shopping-bag me-1"></i> {{ $ord->items_count }} items ·
                                    <i class="fas fa-calendar me-1"></i> {{ date('d M', strtotime($ord->created_at)) }}
                                </span>
                            </div>
                            <div>
                                <span class="om-status oms-{{ $ord->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $ord->status)) }}
                                </span>
                            </div>
                            <div class="om-price">₹{{ number_format($ord->total_amount) }}</div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state-mini">
                        <i class="fas fa-box-open"></i>
                        <p>No orders yet. Start shopping!</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Featured Medicines -->
        <div class="dash-card">
            <div class="dash-card-header">
                <h6><i class="fas fa-star"></i> Featured Medicines</h6>
                <a href="{{ url('/customer/medicines') }}">Shop All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="dash-card-body">
                <div class="row g-3">
                    @foreach($demoFeatured as $med)
                        <div class="col-md-3 col-6">
                            <div class="med-mini-card">
                                <div class="med-mini-img">
                                    @if(!empty($med->image) && file_exists(public_path('uploads/medicines/'.$med->image)))
                                        <img src="{{ asset('uploads/medicines/'.$med->image) }}" alt="{{ $med->name }}">
                                    @else
                                        <i class="fas fa-pills"></i>
                                    @endif
                                </div>
                                <h6>{{ $med->name }}</h6>
                                <div class="med-mini-brand">{{ $med->brand }}</div>
                                <div class="med-mini-footer">
                                    <div class="med-mini-price">₹{{ number_format($med->price) }}</div>
                                    <a href="{{ url('/customer/medicine/'.$med->id) }}" class="btn-mini-cart">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-5">
        <!-- Categories -->
        <div class="dash-card">
            <div class="dash-card-header">
                <h6><i class="fas fa-th-large"></i> Shop by Category</h6>
                <a href="{{ url('/customer/medicines') }}">View All</a>
            </div>
            <div class="dash-card-body">
                <div class="cat-grid">
                    <a href="{{ url('/customer/medicines?category=Fever & Pain') }}" class="cat-item">
                        <div class="cat-icon-c"><i class="fas fa-temperature-high"></i></div>
                        <div class="cat-name-c">Fever & Pain</div>
                    </a>
                    <a href="{{ url('/customer/medicines?category=Cold & Cough') }}" class="cat-item">
                        <div class="cat-icon-c"><i class="fas fa-head-side-cough"></i></div>
                        <div class="cat-name-c">Cold & Cough</div>
                    </a>
                    <a href="{{ url('/customer/medicines?category=Vitamins') }}" class="cat-item">
                        <div class="cat-icon-c"><i class="fas fa-apple-whole"></i></div>
                        <div class="cat-name-c">Vitamins</div>
                    </a>
                    <a href="{{ url('/customer/medicines?category=Diabetes') }}" class="cat-item">
                        <div class="cat-icon-c"><i class="fas fa-droplet"></i></div>
                        <div class="cat-name-c">Diabetes</div>
                    </a>
                    <a href="{{ url('/customer/medicines?category=Heart Care') }}" class="cat-item">
                        <div class="cat-icon-c"><i class="fas fa-heart-pulse"></i></div>
                        <div class="cat-name-c">Heart Care</div>
                    </a>
                    <a href="{{ url('/customer/medicines?category=Skin Care') }}" class="cat-item">
                        <div class="cat-icon-c"><i class="fas fa-hand-sparkles"></i></div>
                        <div class="cat-name-c">Skin Care</div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Health Tips -->
        <div class="dash-card">
            <div class="dash-card-header">
                <h6><i class="fas fa-lightbulb"></i> Daily Health Tips</h6>
            </div>
            <div class="dash-card-body">
                <div style="display:flex;gap:12px;padding-bottom:12px;margin-bottom:12px;border-bottom:1px solid #F5F5F5;">
                    <div style="width:38px;height:38px;min-width:38px;border-radius:10px;background:#E8F5E9;color:#2E7D32;display:flex;align-items:center;justify-content:center;"><i class="fas fa-glass-water"></i></div>
                    <div>
                        <strong style="font-size:0.9rem;color:var(--dark-text);">Stay Hydrated</strong>
                        <p style="font-size:0.8rem;color:var(--gray-text);margin:2px 0 0;">Drink at least 8 glasses of water daily for good health.</p>
                    </div>
                </div>
                <div style="display:flex;gap:12px;padding-bottom:12px;margin-bottom:12px;border-bottom:1px solid #F5F5F5;">
                    <div style="width:38px;height:38px;min-width:38px;border-radius:10px;background:#FFF3E0;color:#FB8C00;display:flex;align-items:center;justify-content:center;"><i class="fas fa-bed"></i></div>
                    <div>
                        <strong style="font-size:0.9rem;color:var(--dark-text);">Get Enough Sleep</strong>
                        <p style="font-size:0.8rem;color:var(--gray-text);margin:2px 0 0;">7-9 hours of sleep boosts immunity and mental health.</p>
                    </div>
                </div>
                <div style="display:flex;gap:12px;">
                    <div style="width:38px;height:38px;min-width:38px;border-radius:10px;background:#E3F2FD;color:#1976D2;display:flex;align-items:center;justify-content:center;"><i class="fas fa-person-running"></i></div>
                    <div>
                        <strong style="font-size:0.9rem;color:var(--dark-text);">Exercise Regularly</strong>
                        <p style="font-size:0.8rem;color:var(--gray-text);margin:2px 0 0;">30 minutes of activity daily keeps you fit and healthy.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection