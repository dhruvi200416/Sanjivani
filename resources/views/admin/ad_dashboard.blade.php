@extends('layouts.admin')

@section('title', 'Admin Dashboard - Sanjivani')
@extends('layouts.admin')


@section('page_title')
    <i class="fa-solid fa-chart-line"></i> Dashboard
@endsection

@section('styles')
<style>
    /* Stats Cards */
    .stat-card {
        background: var(--white);
        border-radius: 18px;
        padding: 22px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .stat-card:hover {
        box-shadow: 0 10px 30px rgba(46,125,50,0.18);
        transform: translateY(-4px);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        transition: var(--transition);
    }

    .stat-card:hover::after {
        transform: scale(1.3);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: var(--white);
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .stat-icon.green { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .stat-icon.blue  { background: linear-gradient(135deg, #1565C0, #42A5F5); }
    .stat-icon.orange{ background: linear-gradient(135deg, #E65100, #FFA726); }
    .stat-icon.purple{ background: linear-gradient(135deg, #6A1B9A, #AB47BC); }

    .stat-info {
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .stat-info .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1.2;
        margin-bottom: 2px;
    }

    .stat-info .stat-label {
        font-size: 0.8rem;
        color: var(--gray-text);
        font-weight: 500;
    }

    .stat-info .stat-trend {
        font-size: 0.72rem;
        font-weight: 600;
        margin-top: 4px;
        display: inline-block;
        padding: 2px 8px;
        border-radius: 10px;
    }

    .stat-trend.up {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .stat-trend.down {
        background: #FFEBEE;
        color: #C62828;
    }

    /* Chart Card */
    .chart-card {
        background: var(--white);
        border-radius: 18px;
        padding: 25px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
    }

    .chart-card .card-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-card .card-header-custom h6 {
        font-weight: 700;
        color: var(--dark-text);
        margin: 0;
    }

    .chart-card .card-header-custom h6 i {
        color: var(--primary-green);
        margin-right: 8px;
    }

    .chart-card .card-header-custom select {
        font-size: 0.8rem;
        border-radius: 20px;
        padding: 5px 12px;
        border: 1px solid #CCC;
        outline: none;
    }

    .chart-container {
        position: relative;
        height: 280px;
    }

    /* Recent Orders Table */
    .table-card {
        background: var(--white);
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .table-card .card-header-custom {
        padding: 18px 25px;
        background: var(--white);
        border-bottom: 1px solid #EEE;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-card .card-header-custom h6 {
        font-weight: 700;
        color: var(--dark-text);
        margin: 0;
    }

    .table-card .card-header-custom a {
        font-size: 0.82rem;
        color: var(--primary-green);
        font-weight: 600;
        text-decoration: none;
    }

    .table-card .card-header-custom a:hover {
        text-decoration: underline;
    }

    .table-responsive {
        margin: 0;
    }

    .order-table {
        width: 100%;
        margin-bottom: 0;
    }

    .order-table thead th {
        background: var(--off-white);
        color: var(--gray-text);
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 25px;
        border-top: none;
        border-bottom: 1px solid #E0E0E0;
    }

    .order-table tbody td {
        padding: 15px 25px;
        font-size: 0.88rem;
        color: var(--dark-text);
        vertical-align: middle;
        border-bottom: 1px solid #F5F5F5;
    }

    .order-table tbody tr:last-child td {
        border-bottom: none;
    }

    .order-table tbody tr {
        transition: var(--transition);
    }

    .order-table tbody tr:hover {
        background: var(--off-white);
    }

    .order-id {
        font-weight: 700;
        color: var(--primary-green);
        text-decoration: none;
    }

    .order-id:hover {
        text-decoration: underline;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: #FFF3E0;
        color: #FB8C00;
    }

    .status-confirmed {
        background: #E3F2FD;
        color: #1976D2;
    }

    .status-processing {
        background: #F3E5F5;
        color: #7B1FA2;
    }

    .status-out_for_delivery {
        background: #FCE4EC;
        color: #C2185B;
    }

    .status-delivered {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .status-cancelled {
        background: #FFEBEE;
        color: #C62828;
    }

    .customer-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .customer-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .customer-info .customer-name {
        font-weight: 600;
        font-size: 0.88rem;
    }

    .customer-info .customer-location {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    .order-total {
        font-weight: 700;
        color: var(--dark-text);
    }

    /* Quick Actions */
    .quick-action-card {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: var(--shadow);
        text-align: center;
        transition: var(--transition);
        text-decoration: none;
        display: block;
        height: 100%;
    }

    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(46,125,50,0.18);
        text-decoration: none;
    }

    .quick-action-card .qa-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin: 0 auto 12px;
        transition: var(--transition);
    }

    .quick-action-card:hover .qa-icon {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
    }

    .quick-action-card h6 {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 5px;
    }

    .quick-action-card p {
        font-size: 0.75rem;
        color: var(--gray-text);
        margin: 0;
    }

    /* Low Stock List */
    .low-stock-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .low-stock-list li {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #F5F5F5;
    }

    .low-stock-list li:last-child {
        border-bottom: none;
    }

    .low-stock-list .ls-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #FFF3E0;
        color: #FB8C00;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
    }

    .low-stock-list .ls-info {
        flex: 1;
    }

    .low-stock-list .ls-info strong {
        display: block;
        font-size: 0.88rem;
        color: var(--dark-text);
    }

    .low-stock-list .ls-info span {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    .low-stock-list .ls-stock {
        font-weight: 700;
        font-size: 0.85rem;
    }

    .low-stock-list .ls-stock.warning { color: #FB8C00; }
    .low-stock-list .ls-stock.critical { color: #E53935; }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 50%, var(--light-green) 100%);
        border-radius: 20px;
        padding: 28px 30px;
        margin-bottom: 25px;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    /* Double backslash escapes unicode in Blade style blocks safely */
    .welcome-banner::after {
        content: '\\f0c2';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: -20px;
        top: -30px;
        font-size: 10rem;
        opacity: 0.1;
    }

    .welcome-banner h4 {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .welcome-banner p {
        font-size: 0.9rem;
        opacity: 0.85;
        margin: 0;
        max-width: 600px;
        line-height: 1.6;
    }

    @media (max-width: 576px) {
        .stat-card { padding: 16px; }
        .stat-icon { width: 50px; height: 50px; font-size: 1.1rem; }
        .stat-info .stat-value { font-size: 1.4rem; }
        .chart-container { height: 220px; }
    }
</style>
@endsection

@section('content')

<!-- Welcome Banner -->
<div class="welcome-banner" data-aos="fade-up">
    <h4><i class="fas fa-leaf me-2"></i>Welcome back, {{ session('admin_name') ?? 'Admin' }}!</h4>
    <p>Here's what's happening with your pharmacy network today. You have {{ $pendingOrdersCount ?? 3 }} pending orders and {{ $lowStockMedicinesCount ?? 5 }} low stock alerts.</p>
</div>

<!-- ============ STAT CARDS ============ -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-cart-shopping"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($totalOrders ?? 128) }}</div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-trend up"><i class="fas fa-arrow-up me-1"></i>+12%</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-user-group"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($totalCustomers ?? 5240) }}</div>
                <div class="stat-label">Total Customers</div>
                <div class="stat-trend up"><i class="fas fa-arrow-up me-1"></i>+8%</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-shop"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($totalPharmacies ?? 152) }}</div>
                <div class="stat-label">Partner Pharmacies</div>
                <div class="stat-trend up"><i class="fas fa-arrow-up me-1"></i>+4%</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-indian-rupee-sign"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">₹{{ number_format($todayRevenue ?? 45890, 0) }}</div>
                <div class="stat-label">Today's Revenue</div>
                <div class="stat-trend up"><i class="fas fa-arrow-up me-1"></i>+15%</div>
            </div>
        </div>
    </div>
</div>

<!-- ============ CHARTS ROW ============ -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="chart-card" data-aos="fade-up">
            <div class="card-header-custom">
                <h6><i class="fas fa-chart-line"></i> Sales Overview</h6>
                <select id="salesPeriod">
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="365">Last Year</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="chart-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header-custom">
                <h6><i class="fas fa-truck-fast"></i> Delivery Status</h6>
            </div>
            <div class="chart-container" style="height:220px;">
                <canvas id="deliveryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ============ TABLE + LOW STOCK ROW ============ -->
<div class="row g-4 mt-1">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="table-card" data-aos="fade-up">
            <div class="card-header-custom">
                <h6><i class="fas fa-cart-flatbed me-2"></i> Recent Orders</h6>
                <a href="{{ url('/admin/orders') }}">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="table-responsive">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($recentOrders) && count($recentOrders) > 0)
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td><a href="{{ url('/admin/order/'.$order->id) }}" class="order-id">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</a></td>
                                    <td>
                                        <div class="customer-info">
                                            <div class="customer-avatar">{{ strtoupper(substr($order->customer->name ?? 'C', 0, 1)) }}</div>
                                            <div>
                                                <div class="customer-name">{{ $order->customer->name ?? 'Unknown' }}</div>
                                                <div class="customer-location">{{ $order->customer->village->name ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $status = strtolower(str_replace(' ', '_', $order->status ?? 'pending'));
                                            $class = 'status-'.$status;
                                            if(!in_array($status, ['pending','confirmed','processing','out_for_delivery','delivered','cancelled'])) $class = 'status-pending';
                                        @endphp
                                        <span class="status-badge {{ $class }}">{{ ucfirst(str_replace('_', ' ', $order->status ?? 'pending')) }}</span>
                                    </td>
                                    <td class="order-total">₹{{ number_format($order->total_amount ?? 0, 2) }}</td>
                                    <td>{{ date('d M Y', strtotime($order->created_at ?? now())) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No recent orders yet.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-lg-4">
        <div class="chart-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header-custom">
                <h6><i class="fas fa-triangle-exclamation me-2" style="color:#FB8C00;"></i> Low Stock Alert</h6>
                <a href="{{ url('/admin/medicines') }}" style="font-size:0.78rem;color:var(--primary-green);">Manage</a>
            </div>
            <ul class="low-stock-list">
                @if(!empty($lowStockMedicines) && count($lowStockMedicines) > 0)
                    @foreach($lowStockMedicines as $med)
                        <li>
                            <div class="ls-icon"><i class="fas fa-pills"></i></div>
                            <div class="ls-info">
                                <strong>{{ $med->name }}</strong>
                                <span>{{ $med->pharmacy->pharmacy_name ?? 'Unknown' }}</span>
                            </div>
                            <span class="ls-stock {{ $med->stock <= 10 ? 'critical' : 'warning' }}">{{ $med->stock }} left</span>
                        </li>
                    @endforeach
                @else
                    <li class="text-muted py-3 text-center">All medicines are well stocked. 👍</li>
                @endif
            </ul>
        </div>
    </div>
</div>

<!-- ============ QUICK ACTIONS ============ -->
<div class="row g-4 mt-1">
    <div class="col-12">
        <h6 class="mb-3" style="font-weight:700;color:var(--dark-text);"><i class="fas fa-bolt me-2" style="color:var(--primary-green);"></i>Quick Actions</h6>
    </div>
    <div class="col-xl-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="0">
        <a href="{{ url('/admin/add-medicine') }}" class="quick-action-card">
            <div class="qa-icon"><i class="fas fa-circle-plus"></i></div>
            <h6>Add Medicine</h6>
            <p>Create new medicine</p>
        </a>
    </div>
    <div class="col-xl-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="100">
        <a href="{{ url('/admin/pharmacies') }}" class="quick-action-card">
            <div class="qa-icon"><i class="fas fa-store"></i></div>
            <h6>Add Pharmacy</h6>
            <p>Register pharmacy</p>
        </a>
    </div>
    <div class="col-xl-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="200">
        <a href="{{ url('/admin/villages') }}" class="quick-action-card">
            <div class="qa-icon"><i class="fas fa-map-location-dot"></i></div>
            <h6>Add Village</h6>
            <p>New delivery area</p>
        </a>
    </div>
    <div class="col-xl-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="300">
        <a href="{{ url('/admin/delivery-partners') }}" class="quick-action-card">
            <div class="qa-icon"><i class="fas fa-motorcycle"></i></div>
            <h6>Add Delivery</h6>
            <p>Partner onboarding</p>
        </a>
    </div>
    <div class="col-xl-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="400">
        <a href="{{ url('/admin/users') }}" class="quick-action-card">
            <div class="qa-icon"><i class="fas fa-users-gear"></i></div>
            <h6>View Customers</h6>
            <p>Customer directory</p>
        </a>
    </div>
    <div class="col-xl-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="500">
        <a href="{{ url('/admin/profile') }}" class="quick-action-card">
            <div class="qa-icon"><i class="fas fa-user-gear"></i></div>
            <h6>My Profile</h6>
            <p>Edit account info</p>
        </a>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* ============ SALES CHART ============ */
    var salesCtx = document.getElementById('salesChart').getContext('2d');

    var salesData = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Orders',
            data: [35, 42, 38, 55, 48, 65, 72],
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            borderColor: 'rgba(46, 125, 50, 1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#2E7D32',
            pointRadius: 5,
            pointHoverRadius: 8
        }]
    };

    var salesChart = new Chart(salesCtx, {
        type: 'line',
        data: salesData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1B5E20',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 15,
                    cornerRadius: 10,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 12 }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#777',
                        font: { size: 12 }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        borderColor: '#E8E8E8',
                        color: '#E8E8E8'
                    },
                    ticks: {
                        color: '#777',
                        stepSize: 20,
                        font: { size: 12 }
                    }
                }
            }
        }
    });

    /* Period selector */
    $('#salesPeriod').on('change', function () {
        var period = $(this).val();
        var newData = {
            '7': [10, 15, 12, 18, 22, 25, 20],
            '30': [120, 90, 150, 110, 130, 170, 160, 140, 155, 180, 149, 165, 200, 175, 190, 165, 210, 195, 170, 185, 205, 220, 235, 210, 245, 230, 215, 240, 260, 250],
            '365': [1200, 1100, 1350, 1450, 1480, 1600, 1590, 1750, 1700, 1810, 1950, 1920]
        };

        if (period === '7') {
            salesChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            salesChart.data.datasets[0].data = newData['7'];
        } else if (period === '30') {
            salesChart.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
            salesChart.data.datasets[0].data = [650, 720, 780, 890];
        } else {
            salesChart.data.labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            salesChart.data.datasets[0].data = newData['365'];
        }
        salesChart.update();
    });

    /* ============ DELIVERY CHART (DOUGHNUT) ============ */
    var deliveryCtx = document.getElementById('deliveryChart').getContext('2d');

    var deliveryChart = new Chart(deliveryCtx, {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'Pending', 'Processing', 'Cancelled'],
            datasets: [{
                data: [60, 15, 20, 5],
                backgroundColor: [
                    '#2E7D32',
                    '#FB8C00',
                    '#1976D2',
                    '#E53935'
                ],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    backgroundColor: '#1B5E20',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            cutout: '65%'
        }
    });

});
</script>
@endsection