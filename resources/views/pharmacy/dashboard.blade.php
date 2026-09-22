@extends('layouts.pharmacy')

@section('title', 'Pharmacy Dashboard')
@section('page_title')
    <i class="fas fa-tachometer-alt"></i> Dashboard
@endsection

@section('styles')
<style>
    .welcome-banner-ph {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 20px; padding: 30px 35px; color: var(--white);
        position: relative; overflow: hidden; margin-bottom: 25px;
    }

    .welcome-banner-ph::before {
        content: ''; position: absolute; top: -100px; right: -100px;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .welcome-banner-ph::after {
        content: '\f0f9'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 30px; bottom: -30px;
        font-size: 10rem; opacity: 0.08;
    }

    .welcome-content-ph { position: relative; z-index: 2; }

    .welcome-content-ph h3 {
        font-size: 1.8rem; font-weight: 800; margin: 0 0 8px;
    }

    .welcome-content-ph p {
        opacity: 0.9; font-size: 0.95rem; margin: 0 0 15px; max-width: 600px;
    }

    .welcome-btns-ph { display: flex; gap: 12px; flex-wrap: wrap; }

    .wb-ph {
        background: var(--white); color: var(--primary-green);
        padding: 10px 22px; border-radius: 25px; font-weight: 700;
        font-size: 0.88rem; text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        transition: var(--transition); border: none;
    }

    .wb-ph:hover {
        transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        color: var(--dark-green);
    }

    .wb-ph.outline {
        background: transparent; color: var(--white);
        border: 2px solid rgba(255,255,255,0.5);
    }

    .wb-ph.outline:hover {
        background: rgba(255,255,255,0.15); border-color: var(--white); color: var(--white);
    }

    /* Stats */
    .stat-card-ph {
        background: var(--white); border-radius: 16px; padding: 20px;
        box-shadow: var(--shadow); transition: var(--transition);
        display: flex; align-items: center; gap: 15px; height: 100%;
    }

    .stat-card-ph:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.15);
    }

    .stat-icon-ph {
        width: 55px; height: 55px; min-width: 55px; border-radius: 15px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; color: var(--white);
    }

    .si-medicines { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .si-orders    { background: linear-gradient(135deg, #1565C0, #42A5F5); }
    .si-revenue   { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }
    .si-pending   { background: linear-gradient(135deg, #E65100, #FFA726); }
    .si-lowstock  { background: linear-gradient(135deg, #C62828, #EF5350); }
    .si-customers { background: linear-gradient(135deg, #00695C, #26A69A); }

    .stat-card-ph .sp-val {
        font-size: 1.5rem; font-weight: 800; color: var(--dark-text); line-height: 1.1;
    }

    .stat-card-ph .sp-lbl {
        font-size: 0.78rem; color: var(--gray-text); font-weight: 500;
    }

    .stat-card-ph .sp-trend {
        font-size: 0.72rem; font-weight: 600; display: inline-block;
        padding: 2px 8px; border-radius: 10px; margin-top: 3px;
    }

    .sp-trend.up { background: #E8F5E9; color: #2E7D32; }
    .sp-trend.down { background: #FFEBEE; color: #C62828; }

    /* Cards */
    .dash-card-ph {
        background: var(--white); border-radius: 16px;
        box-shadow: var(--shadow); overflow: hidden; margin-bottom: 20px;
    }

    .dash-card-header-ph {
        padding: 16px 22px; background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        display: flex; justify-content: space-between; align-items: center;
    }

    .dash-card-header-ph h6 {
        margin: 0; font-weight: 700; color: var(--dark-text);
    }

    .dash-card-header-ph h6 i { color: var(--primary-green); margin-right: 8px; }

    .dash-card-header-ph a {
        font-size: 0.82rem; color: var(--primary-green);
        font-weight: 600; text-decoration: none;
    }

    .dash-card-header-ph a:hover { text-decoration: underline; }

    .dash-card-body-ph { padding: 20px 22px; }

    /* Chart */
    .chart-container-ph { position: relative; height: 280px; }

    /* Recent Orders */
    .order-mini-ph {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 0; border-bottom: 1px solid #F5F5F5;
    }

    .order-mini-ph:last-child { border-bottom: none; }

    .om-ph-icon {
        width: 42px; height: 42px; min-width: 42px; border-radius: 10px;
        background: var(--pale-green); color: var(--primary-green);
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
    }

    .om-ph-info { flex: 1; }

    .om-ph-info strong {
        font-size: 0.88rem; color: var(--dark-text); display: block;
    }

    .om-ph-info span { font-size: 0.75rem; color: var(--gray-text); }

    .om-ph-status {
        padding: 4px 10px; border-radius: 12px;
        font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
    }

    .oms-ph-pending   { background: #FFF3E0; color: #E65100; }
    .oms-ph-confirmed { background: #E3F2FD; color: #1565C0; }
    .oms-ph-processing{ background: #F3E5F5; color: #7B1FA2; }
    .oms-ph-delivered { background: #E8F5E9; color: #1B5E20; }
    .oms-ph-cancelled { background: #FFEBEE; color: #B71C1C; }

    .om-ph-price {
        font-weight: 700; color: var(--primary-green); font-size: 0.92rem;
        white-space: nowrap;
    }

    /* Low Stock */
    .low-stock-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 0; border-bottom: 1px solid #F5F5F5;
    }

    .low-stock-item:last-child { border-bottom: none; }

    .ls-icon-ph {
        width: 38px; height: 38px; border-radius: 8px;
        background: #FFF3E0; color: #FB8C00;
        display: flex; align-items: center; justify-content: center;
    }

    .ls-info-ph { flex: 1; }

    .ls-info-ph strong {
        font-size: 0.85rem; color: var(--dark-text); display: block;
    }

    .ls-info-ph span { font-size: 0.72rem; color: var(--gray-text); }

    .ls-stock-val {
        font-weight: 700; font-size: 0.85rem;
    }

    .ls-stock-val.critical { color: #E53935; }
    .ls-stock-val.warning { color: #FB8C00; }

    /* Quick Actions */
    .quick-action-ph {
        text-align: center; padding: 20px 10px;
        background: var(--white); border-radius: 14px;
        box-shadow: var(--shadow); transition: var(--transition);
        text-decoration: none; display: block; height: 100%;
    }

    .quick-action-ph:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.15);
    }

    .qa-icon-ph {
        width: 55px; height: 55px; border-radius: 15px;
        background: var(--pale-green); color: var(--primary-green);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; margin: 0 auto 10px;
        transition: var(--transition);
    }

    .quick-action-ph:hover .qa-icon-ph {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
    }

    .quick-action-ph h6 {
        font-size: 0.88rem; font-weight: 700; color: var(--dark-text);
        margin-bottom: 3px;
    }

    .quick-action-ph p {
        font-size: 0.72rem; color: var(--gray-text); margin: 0;
    }

    @media (max-width: 576px) {
        .welcome-content-ph h3 { font-size: 1.4rem; }
        .chart-container-ph { height: 220px; }
    }
</style>
@endsection

@section('content')

@php
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
@endphp

<!-- Welcome Banner -->
<div class="welcome-banner-ph">
    <div class="welcome-content-ph">
        <h3>Welcome, {{ $pharmacyName }}! 🏥</h3>
        <p>Manage your inventory, track orders and grow your pharmacy business with Sanjivani's powerful dashboard.</p>
        <div class="welcome-btns-ph">
            <a href="{{ url('/pharmacy/add-medicine') }}" class="wb-ph">
                <i class="fas fa-plus-circle"></i> Add Medicine
            </a>
            <a href="{{ url('/pharmacy/orders') }}" class="wb-ph outline">
                <i class="fas fa-shopping-cart"></i> View Orders ({{ $pendingOrders }} pending)
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
                <div class="sp-lbl">Medicines</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-orders"><i class="fas fa-shopping-cart"></i></div>
            <div>
                <div class="sp-val">{{ $totalOrders }}</div>
                <div class="sp-lbl">Total Orders</div>
                <span class="sp-trend up"><i class="fas fa-arrow-up"></i> +12%</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-revenue"><i class="fas fa-rupee-sign"></i></div>
            <div>
                <div class="sp-val">₹{{ number_format($todayRevenue) }}</div>
                <div class="sp-lbl">Today Revenue</div>
                <span class="sp-trend up"><i class="fas fa-arrow-up"></i> +8%</span>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-pending"><i class="fas fa-clock"></i></div>
            <div>
                <div class="sp-val">{{ $pendingOrders }}</div>
                <div class="sp-lbl">Pending</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-lowstock"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <div class="sp-val">{{ $lowStockCount }}</div>
                <div class="sp-lbl">Low Stock</div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
        <div class="stat-card-ph">
            <div class="stat-icon-ph si-customers"><i class="fas fa-users"></i></div>
            <div>
                <div class="sp-val">{{ $totalCustomers }}</div>
                <div class="sp-lbl">Customers</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Charts + Orders -->
    <div class="col-lg-8">
        <!-- Sales Chart -->
        <div class="dash-card-ph">
            <div class="dash-card-header-ph">
                <h6><i class="fas fa-chart-line"></i> Sales Overview</h6>
                <select id="salesPeriodPh" style="font-size:0.8rem;border-radius:15px;padding:4px 10px;border:1px solid #CCC;outline:none;">
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                </select>
            </div>
            <div class="dash-card-body-ph">
                <div class="chart-container-ph">
                    <canvas id="pharmacySalesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="dash-card-ph">
            <div class="dash-card-header-ph">
                <h6><i class="fas fa-shopping-cart"></i> Recent Orders</h6>
                <a href="{{ url('/pharmacy/orders') }}">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="dash-card-body-ph">
                @foreach($recentOrders as $ord)
                    <div class="order-mini-ph">
                        <div class="om-ph-icon"><i class="fas fa-box"></i></div>
                        <div class="om-ph-info">
                            <strong>#ORD-{{ str_pad($ord->id, 4, '0', STR_PAD_LEFT) }} — {{ $ord->customer_name }}</strong>
                            <span><i class="fas fa-shopping-bag me-1"></i>{{ $ord->items }} items · {{ $ord->time }}</span>
                        </div>
                        <span class="om-ph-status oms-ph-{{ $ord->status }}">
                            {{ ucfirst($ord->status) }}
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
                <h6><i class="fas fa-exclamation-triangle" style="color:#FB8C00;"></i> Low Stock Alert</h6>
                <a href="{{ url('/pharmacy/medicines') }}">Manage</a>
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
                            {{ $med->stock }} left
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dash-card-ph">
            <div class="dash-card-header-ph">
                <h6><i class="fas fa-bolt"></i> Quick Actions</h6>
            </div>
            <div class="dash-card-body-ph">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ url('/pharmacy/add-medicine') }}" class="quick-action-ph">
                            <div class="qa-icon-ph"><i class="fas fa-plus-circle"></i></div>
                            <h6>Add Medicine</h6>
                            <p>New product</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ url('/pharmacy/orders?status=pending') }}" class="quick-action-ph">
                            <div class="qa-icon-ph"><i class="fas fa-clock"></i></div>
                            <h6>Pending</h6>
                            <p>{{ $pendingOrders }} orders</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ url('/pharmacy/medicines?stock=low') }}" class="quick-action-ph">
                            <div class="qa-icon-ph"><i class="fas fa-boxes-stacked"></i></div>
                            <h6>Update Stock</h6>
                            <p>{{ $lowStockCount }} low</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ url('/pharmacy/profile') }}" class="quick-action-ph">
                            <div class="qa-icon-ph"><i class="fas fa-user-circle"></i></div>
                            <h6>Profile</h6>
                            <p>Edit info</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* ============ SALES CHART ============ */
    var ctx = document.getElementById('pharmacySalesChart').getContext('2d');

    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Revenue (₹)',
                data: [8500, 12000, 9800, 15200, 11500, 18000, 12580],
                backgroundColor: 'rgba(76, 175, 80, 0.15)',
                borderColor: 'rgba(46, 125, 50, 1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#2E7D32',
                pointRadius: 5,
                pointHoverRadius: 8
            }, {
                label: 'Orders',
                data: [12, 18, 14, 22, 16, 28, 19],
                backgroundColor: 'rgba(25, 118, 210, 0.1)',
                borderColor: 'rgba(25, 118, 210, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: false,
                pointBackgroundColor: '#1976D2',
                pointRadius: 4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { usePointStyle: true, padding: 15, font: { size: 12 } }
                },
                tooltip: {
                    backgroundColor: '#1B5E20',
                    padding: 12,
                    cornerRadius: 10
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#777', font: { size: 12 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#F0F0F0' },
                    ticks: {
                        color: '#777', font: { size: 11 },
                        callback: function(v) { return '₹' + (v/1000) + 'k'; }
                    }
                },
                y1: {
                    position: 'right',
                    beginAtZero: true,
                    grid: { display: false },
                    ticks: { color: '#1976D2', font: { size: 11 } }
                }
            }
        }
    });

    /* Period selector */
    $('#salesPeriodPh').on('change', function () {
        var period = $(this).val();
        if (period === '7') {
            salesChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            salesChart.data.datasets[0].data = [8500, 12000, 9800, 15200, 11500, 18000, 12580];
            salesChart.data.datasets[1].data = [12, 18, 14, 22, 16, 28, 19];
        } else {
            salesChart.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
            salesChart.data.datasets[0].data = [45000, 52000, 48000, 62000];
            salesChart.data.datasets[1].data = [65, 78, 72, 95];
        }
        salesChart.update();
    });

});
</script>
@endsection