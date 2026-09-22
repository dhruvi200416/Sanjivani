@extends('layouts.delivery')

@section('title', 'Delivery Dashboard')
@section('page_title')
<i class="fas fa-tachometer-alt"></i> Dashboard
@endsection

@section('styles')
<style>
    .welcome-banner-d {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 20px; padding: 30px 35px; color: var(--white);
        position: relative; overflow: hidden; margin-bottom: 25px;
    }

    .welcome-banner-d::before {
        content: ''; position: absolute; top: -100px; right: -100px;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .welcome-banner-d::after {
        content: '\f5dc'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 30px; bottom: -25px;
        font-size: 9rem; opacity: 0.1;
    }

    .welcome-content-d { position: relative; z-index: 2; }

    .welcome-content-d h3 {
        font-size: 1.8rem; font-weight: 800; margin: 0 0 8px;
    }

    .welcome-content-d p {
        opacity: 0.9; font-size: 0.95rem; margin: 0 0 15px; max-width: 600px;
    }

    .welcome-content-d .earnings-big {
        display: inline-flex; align-items: center; gap: 10px;
        background: rgba(255,255,255,0.18); padding: 10px 22px;
        border-radius: 14px; margin-bottom: 10px;
    }

    .welcome-content-d .earnings-big .eb-label {
        font-size: 0.82rem; opacity: 0.85;
    }

    .welcome-content-d .earnings-big .eb-value {
        font-size: 1.6rem; font-weight: 800;
    }

    /* Stats Cards */
    .stat-card-d {
        background: var(--white); border-radius: 16px; padding: 20px;
        box-shadow: var(--shadow); transition: var(--transition);
        display: flex; align-items: center; gap: 15px; height: 100%;
    }

    .stat-card-d:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(46,125,50,0.15);
    }

    .stat-icon-d {
        width: 55px; height: 55px; min-width: 55px; border-radius: 15px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; color: var(--white);
    }

    .si-today    { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .si-active   { background: linear-gradient(135deg, #E65100, #FFA726); }
    .si-week     { background: linear-gradient(135deg, #1565C0, #42A5F5); }
    .si-earnings { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }
    .si-rating   { background: linear-gradient(135deg, #F57F17, #FFC107); }
    .si-distance { background: linear-gradient(135deg, #00695C, #26A69A); }

    .stat-card-d .sd-val {
        font-size: 1.5rem; font-weight: 800; color: var(--dark-text); line-height: 1.1;
    }

    .stat-card-d .sd-lbl {
        font-size: 0.78rem; color: var(--gray-text); font-weight: 500;
    }

    /* Section Card */
    .dash-section-d {
        background: var(--white); border-radius: 16px;
        box-shadow: var(--shadow); overflow: hidden; margin-bottom: 20px;
    }

    .dash-section-header-d {
        padding: 16px 22px; background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        display: flex; justify-content: space-between; align-items: center;
    }

    .dash-section-header-d h6 {
        margin: 0; font-weight: 700; color: var(--dark-text);
    }

    .dash-section-header-d h6 i {
        color: var(--primary-green); margin-right: 8px;
    }

    .dash-section-header-d a {
        font-size: 0.82rem; color: var(--primary-green);
        font-weight: 600; text-decoration: none;
    }

    .dash-section-header-d a:hover { text-decoration: underline; }

    .dash-section-body-d { padding: 20px 22px; }

    /* Active Delivery Card */
    .active-delivery-card {
        border: 2px solid var(--primary-green); border-radius: 14px;
        padding: 18px; margin-bottom: 15px; position: relative;
        background: linear-gradient(135deg, var(--pale-green), var(--white));
        transition: var(--transition);
    }

    .active-delivery-card:hover {
        box-shadow: 0 6px 20px rgba(46,125,50,0.15);
    }

    .active-delivery-card .pulse-badge {
        position: absolute; top: 15px; right: 15px;
        background: #2E7D32; color: var(--white);
        padding: 4px 12px; border-radius: 15px;
        font-size: 0.7rem; font-weight: 700;
        text-transform: uppercase; animation: pulse-badge 2s infinite;
    }

    @keyframes pulse-badge {
        0%, 100% { box-shadow: 0 0 0 0 rgba(46,125,50,0.4); }
        50% { box-shadow: 0 0 0 8px rgba(46,125,50,0); }
    }

    .ad-header {
        display: flex; justify-content: space-between;
        align-items: center; margin-bottom: 12px;
    }

    .ad-header .ad-order-id {
        font-size: 1rem; font-weight: 800; color: var(--primary-green);
    }

    .ad-header .ad-time {
        font-size: 0.78rem; color: var(--gray-text);
    }

    .ad-route {
        display: flex; align-items: stretch; gap: 12px;
        margin-bottom: 15px;
    }

    .ad-route-dots {
        display: flex; flex-direction: column; align-items: center;
        padding: 4px 0;
    }

    .ad-route-dots .dot-start {
        width: 14px; height: 14px; border-radius: 50%;
        background: var(--primary-green); border: 3px solid var(--pale-green);
    }

    .ad-route-dots .dot-line {
        width: 3px; flex: 1; background: var(--mint-green);
        margin: 4px 0; border-radius: 3px;
    }

    .ad-route-dots .dot-end {
        width: 14px; height: 14px; border-radius: 50%;
        background: #E53935; border: 3px solid #FFCDD2;
    }

    .ad-route-info { flex: 1; }

    .ad-route-point {
        margin-bottom: 12px;
    }

    .ad-route-point:last-child { margin-bottom: 0; }

    .ad-route-point .rp-label {
        font-size: 0.7rem; color: var(--gray-text);
        text-transform: uppercase; font-weight: 600;
        letter-spacing: 0.5px; margin-bottom: 2px;
    }

    .ad-route-point .rp-address {
        font-size: 0.88rem; color: var(--dark-text); font-weight: 500;
    }

    .ad-route-point .rp-name {
        font-size: 0.78rem; color: var(--gray-text);
    }

    .ad-footer {
        display: flex; justify-content: space-between;
        align-items: center; padding-top: 12px;
        border-top: 1px dashed var(--mint-green);
    }

    .ad-footer .ad-items {
        font-size: 0.82rem; color: var(--gray-text);
    }

    .ad-footer .ad-items strong {
        color: var(--dark-text);
    }

    .ad-footer .ad-earning {
        font-size: 1.1rem; font-weight: 800; color: var(--primary-green);
    }

    .ad-actions {
        display: flex; gap: 8px; margin-top: 12px;
    }

    .btn-delivery-action {
        flex: 1; padding: 10px; border-radius: 10px;
        font-weight: 600; font-size: 0.85rem; border: none;
        cursor: pointer; transition: var(--transition);
        display: inline-flex; align-items: center;
        justify-content: center; gap: 6px; text-decoration: none;
    }

    .btn-pickup {
        background: linear-gradient(135deg, #1976D2, #42A5F5); color: var(--white);
    }

    .btn-delivered {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
    }

    .btn-navigate {
        background: var(--white); color: var(--primary-green);
        border: 2px solid var(--primary-green);
    }

    .btn-call {
        background: var(--white); color: #1976D2;
        border: 2px solid #1976D2;
    }

    .btn-delivery-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    /* Earnings Chart Placeholder */
    .earnings-summary {
        display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;
    }

    .earning-box {
        background: var(--off-white); border-radius: 12px;
        padding: 15px; text-align: center;
    }

    .earning-box .eb-val {
        font-size: 1.3rem; font-weight: 800; color: var(--primary-green);
    }

    .earning-box .eb-lbl {
        font-size: 0.75rem; color: var(--gray-text);
    }

    /* Tips Card */
    .tip-card {
        background: linear-gradient(135deg, #FFF3E0, #FFECB3);
        border-radius: 12px; padding: 15px;
        border-left: 4px solid #FB8C00;
        margin-bottom: 12px;
    }

    .tip-card h6 {
        color: #E65100; font-weight: 700; margin: 0 0 5px; font-size: 0.9rem;
    }

    .tip-card p {
        color: #6D4C41; font-size: 0.82rem; margin: 0; line-height: 1.5;
    }

    /* Empty State */
    .empty-deliveries {
        text-align: center; padding: 40px 20px; color: var(--gray-text);
    }

    .empty-deliveries i {
        font-size: 3.5rem; color: var(--mint-green); margin-bottom: 12px;
    }

    .empty-deliveries h6 {
        color: var(--dark-text); font-weight: 600;
    }

    @media (max-width: 767px) {
        .welcome-content-d h3 { font-size: 1.4rem; }
        .welcome-content-d .earnings-big .eb-value { font-size: 1.3rem; }
        .earnings-summary { grid-template-columns: 1fr; }
        .ad-footer { flex-direction: column; gap: 8px; align-items: flex-start; }
        .ad-actions { flex-direction: column; }
    }
</style>
@endsection

@section('content')

@php
    $partnerName = session('delivery_name') ?? 'Sunil';
    $todayEarnings = $todayEarnings ?? 850;
    $todayDeliveries = $todayDeliveries ?? 6;
    $activeDeliveriesCount = $activeDeliveriesCount ?? 2;
    $weekDeliveries = $weekDeliveries ?? 34;
    $weekEarnings = $weekEarnings ?? 4580;
    $rating = $rating ?? 4.7;
    $totalDistance = $totalDistance ?? 128;

    $activeDeliveries = $activeDeliveries ?? [
        (object)[
            'id' => 42, 'order_id' => 'ORD-0042',
            'pharmacy_name' => 'MediCare Pharmacy',
            'pharmacy_address' => 'Shop 5, Market Road, Nashik',
            'customer_name' => 'Ramesh Patil',
            'customer_address' => 'House 45, Gandhi Road, Nashik',
            'customer_phone' => '9876543210',
            'items_count' => 3, 'earning' => 45,
            'status' => 'picked_up', 'created_at' => now()->subMinutes(25)
        ],
        (object)[
            'id' => 43, 'order_id' => 'ORD-0043',
            'pharmacy_name' => 'HealthPlus Pharmacy',
            'pharmacy_address' => 'Near Bus Stand, Pune',
            'customer_name' => 'Sunita Sharma',
            'customer_address' => 'Flat 202, Green Villa, Pune',
            'customer_phone' => '9812345678',
            'items_count' => 5, 'earning' => 60,
            'status' => 'assigned', 'created_at' => now()->subMinutes(10)
        ],
    ];
@endphp

<!-- Welcome Banner -->
<div class="welcome-banner-d">
    <div class="welcome-content-d">
        <h3>Hey {{ $partnerName }}! 🏍️ Ready to Deliver?</h3>
        <p>Stay online and start accepting deliveries in your area. The more you deliver, the more you earn!</p>

        <div class="earnings-big">
            <div>
                <div class="eb-label">Today's Earnings</div>
                <div class="eb-value">₹{{ number_format($todayEarnings) }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-card-d">
            <div class="stat-icon-d si-today"><i class="fas fa-box"></i></div>
            <div>
                <div class="sd-val">{{ $todayDeliveries }}</div>
                <div class="sd-lbl">Today</div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-card-d">
            <div class="stat-icon-d si-active"><i class="fas fa-truck"></i></div>
            <div>
                <div class="sd-val">{{ $activeDeliveriesCount }}</div>
                <div class="sd-lbl">Active</div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-card-d">
            <div class="stat-icon-d si-week"><i class="fas fa-calendar-week"></i></div>
            <div>
                <div class="sd-val">{{ $weekDeliveries }}</div>
                <div class="sd-lbl">This Week</div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-card-d">
            <div class="stat-icon-d si-earnings"><i class="fas fa-rupee-sign"></i></div>
            <div>
                <div class="sd-val">₹{{ number_format($weekEarnings) }}</div>
                <div class="sd-lbl">Week Earned</div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-card-d">
            <div class="stat-icon-d si-rating"><i class="fas fa-star"></i></div>
            <div>
                <div class="sd-val">{{ $rating }}</div>
                <div class="sd-lbl">Rating</div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6">
        <div class="stat-card-d">
            <div class="stat-icon-d si-distance"><i class="fas fa-road"></i></div>
            <div>
                <div class="sd-val">{{ $totalDistance }} km</div>
                <div class="sd-lbl">Distance</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Active Deliveries -->
    <div class="col-lg-8">
        <div class="dash-section-d">
            <div class="dash-section-header-d">
                <h6><i class="fas fa-truck-fast"></i> Active Deliveries</h6>
                <a href="{{ url('/delivery/deliveries') }}">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="dash-section-body-d">
                @if(count($activeDeliveries) > 0)
                    @foreach($activeDeliveries as $del)
                        <div class="active-delivery-card">
                            <span class="pulse-badge">
                                {{ $del->status == 'picked_up' ? 'Picked Up' : 'Assigned' }}
                            </span>

                            <div class="ad-header">
                                <span class="ad-order-id">
                                    <i class="fas fa-receipt me-1"></i> {{ $del->order_id }}
                                </span>
                                <span class="ad-time">
                                    <i class="fas fa-clock me-1"></i> {{ $del->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <div class="ad-route">
                                <div class="ad-route-dots">
                                    <div class="dot-start"></div>
                                    <div class="dot-line"></div>
                                    <div class="dot-end"></div>
                                </div>
                                <div class="ad-route-info">
                                    <div class="ad-route-point">
                                        <div class="rp-label">Pickup — {{ $del->pharmacy_name }}</div>
                                        <div class="rp-address">{{ $del->pharmacy_address }}</div>
                                    </div>
                                    <div class="ad-route-point">
                                        <div class="rp-label">Drop — {{ $del->customer_name }}</div>
                                        <div class="rp-address">{{ $del->customer_address }}</div>
                                        <div class="rp-name">
                                            <i class="fas fa-phone me-1" style="color:var(--primary-green);"></i>
                                            <a href="tel:{{ $del->customer_phone }}" style="color:var(--primary-green);text-decoration:none;">
                                                {{ $del->customer_phone }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ad-footer">
                                <span class="ad-items">
                                    <i class="fas fa-shopping-bag me-1" style="color:var(--primary-green);"></i>
                                    <strong>{{ $del->items_count }}</strong> items
                                </span>
                                <span class="ad-earning">+₹{{ $del->earning }}</span>
                            </div>

                            <div class="ad-actions">
                                @if($del->status == 'assigned')
                                    <button type="button" class="btn-delivery-action btn-pickup btn-mark-pickup"
                                            data-id="{{ $del->id }}">
                                        <i class="fas fa-box"></i> Mark Picked Up
                                    </button>
                                @else
                                    <button type="button" class="btn-delivery-action btn-delivered btn-mark-delivered"
                                            data-id="{{ $del->id }}">
                                        <i class="fas fa-check-circle"></i> Mark Delivered
                                    </button>
                                @endif

                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($del->customer_address) }}"
                                   target="_blank" class="btn-delivery-action btn-navigate">
                                    <i class="fas fa-diamond-turn-right"></i> Navigate
                                </a>

                                <a href="tel:{{ $del->customer_phone }}" class="btn-delivery-action btn-call">
                                    <i class="fas fa-phone"></i> Call
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-deliveries">
                        <i class="fas fa-truck"></i>
                        <h6>No active deliveries</h6>
                        <p style="font-size:0.85rem;">Stay online and new deliveries will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-4">
        <!-- Earnings Summary -->
        <div class="dash-section-d">
            <div class="dash-section-header-d">
                <h6><i class="fas fa-wallet"></i> Earnings</h6>
                <a href="{{ url('/delivery/history') }}">Details</a>
            </div>
            <div class="dash-section-body-d">
                <div class="earnings-summary">
                    <div class="earning-box">
                        <div class="eb-val">₹{{ number_format($todayEarnings) }}</div>
                        <div class="eb-lbl">Today</div>
                    </div>
                    <div class="earning-box">
                        <div class="eb-val">₹{{ number_format($weekEarnings) }}</div>
                        <div class="eb-lbl">This Week</div>
                    </div>
                    <div class="earning-box">
                        <div class="eb-val">₹{{ number_format($weekEarnings * 4) }}</div>
                        <div class="eb-lbl">This Month</div>
                    </div>
                    <div class="earning-box">
                        <div class="eb-val" style="color:#FB8C00;">₹1,200</div>
                        <div class="eb-lbl">Pending Payout</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips -->
        <div class="dash-section-d">
            <div class="dash-section-header-d">
                <h6><i class="fas fa-lightbulb"></i> Pro Tips</h6>
            </div>
            <div class="dash-section-body-d">
                <div class="tip-card">
                    <h6><i class="fas fa-clock me-1"></i> Peak Hours</h6>
                    <p>Deliver between 8-11 AM and 6-9 PM for maximum orders and bonus earnings.</p>
                </div>
                <div class="tip-card">
                    <h6><i class="fas fa-star me-1"></i> Maintain Rating</h6>
                    <p>Keep your rating above 4.5 to get priority delivery assignments and bonus tips.</p>
                </div>
                <div class="tip-card">
                    <h6><i class="fas fa-shield-halved me-1"></i> Handle with Care</h6>
                    <p>Medicines are sensitive. Keep them away from direct sunlight and heat during transit.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* ============ MARK PICKED UP ============ */
    $('.btn-mark-pickup').on('click', function () {
        var id = $(this).data('id');
        var $btn = $(this);

        if (!confirm('Confirm you have picked up the order from the pharmacy?')) return;

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            url: '{{ url("/delivery/update-status") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                delivery_id: id,
                status: 'picked_up'
            },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    location.reload();
                }
            },
            error: function () {
                // Demo fallback
                location.reload();
            }
        });
    });

    /* ============ MARK DELIVERED ============ */
    $('.btn-mark-delivered').on('click', function () {
        var id = $(this).data('id');
        var $btn = $(this);

        if (!confirm('Confirm you have delivered the order to the customer?')) return;

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            url: '{{ url("/delivery/update-status") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                delivery_id: id,
                status: 'delivered'
            },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    location.reload();
                }
            },
            error: function () {
                location.reload();
            }
        });
    });

});
</script>
@endsection