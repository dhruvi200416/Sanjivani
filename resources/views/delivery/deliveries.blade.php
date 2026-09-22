@extends('layouts.delivery')

@section('title', 'My Deliveries')
@section('page_title')
<i class="fas fa-truck"></i> My Deliveries
@endsection

@section('styles')
<style>
    .filter-tabs-d {
        background: var(--white); border-radius: 14px; padding: 6px;
        box-shadow: var(--shadow); display: flex; gap: 5px;
        margin-bottom: 20px; overflow-x: auto;
    }

    .filter-tab-d {
        flex: 1; min-width: 120px; padding: 10px 15px;
        text-align: center; border-radius: 10px; cursor: pointer;
        font-size: 0.85rem; font-weight: 600; color: var(--gray-text);
        background: transparent; border: none; transition: var(--transition);
        white-space: nowrap;
    }

    .filter-tab-d:hover { color: var(--primary-green); }

    .filter-tab-d.active {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); box-shadow: 0 4px 12px rgba(46,125,50,0.3);
    }

    .filter-tab-d .tab-count {
        display: inline-block; background: rgba(255,255,255,0.3);
        padding: 1px 8px; border-radius: 10px; margin-left: 5px;
        font-size: 0.72rem;
    }

    .filter-tab-d:not(.active) .tab-count {
        background: var(--pale-green); color: var(--primary-green);
    }

    /* Search Bar */
    .search-bar-d {
        background: var(--white); border-radius: 14px; padding: 12px 18px;
        box-shadow: var(--shadow); margin-bottom: 20px;
        display: flex; gap: 10px; align-items: center;
    }

    .search-input-d {
        flex: 1; padding: 8px 14px; border: 2px solid #E8E8E8;
        border-radius: 25px; font-size: 0.88rem; outline: none;
        transition: var(--transition); font-family: 'Poppins', sans-serif;
    }

    .search-input-d:focus { border-color: var(--primary-green); }

    /* Delivery Card */
    .delivery-card-d {
        background: var(--white); border-radius: 16px;
        box-shadow: var(--shadow); margin-bottom: 15px;
        transition: var(--transition); overflow: hidden;
        border-left: 5px solid var(--primary-green);
    }

    .delivery-card-d.st-assigned { border-left-color: #FB8C00; }
    .delivery-card-d.st-picked_up { border-left-color: #1976D2; }
    .delivery-card-d.st-delivered { border-left-color: #2E7D32; }
    .delivery-card-d.st-cancelled { border-left-color: #C62828; }

    .delivery-card-d:hover {
        box-shadow: 0 10px 25px rgba(46,125,50,0.15);
    }

    .del-card-header {
        padding: 15px 20px; background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 10px;
    }

    .del-order-info {
        display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    }

    .del-order-id {
        font-size: 0.95rem; font-weight: 800; color: var(--primary-green);
    }

    .del-time {
        font-size: 0.78rem; color: var(--gray-text);
    }

    .del-status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 15px;
        font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase;
    }

    .dsb-assigned { background: #FFF3E0; color: #E65100; }
    .dsb-picked_up { background: #E3F2FD; color: #1565C0; }
    .dsb-delivered { background: #E8F5E9; color: #1B5E20; }
    .dsb-cancelled { background: #FFEBEE; color: #B71C1C; }

    .del-card-body { padding: 18px 20px; }

    .del-route-info {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 20px; margin-bottom: 15px;
    }

    .route-point-d {
        display: flex; gap: 10px;
    }

    .rp-icon-d {
        width: 36px; height: 36px; min-width: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: var(--white); font-size: 0.85rem;
    }

    .rp-icon-d.pickup { background: linear-gradient(135deg, #1976D2, #42A5F5); }
    .rp-icon-d.drop { background: linear-gradient(135deg, #2E7D32, #66BB6A); }

    .rp-details-d strong {
        display: block; font-size: 0.85rem; color: var(--dark-text);
        font-weight: 700;
    }

    .rp-details-d p {
        font-size: 0.78rem; color: var(--gray-text);
        margin: 2px 0 0; line-height: 1.4;
    }

    .del-card-footer {
        display: flex; justify-content: space-between;
        align-items: center; flex-wrap: wrap; gap: 12px;
        padding-top: 12px; border-top: 1px dashed #E0E0E0;
    }

    .del-meta {
        display: flex; gap: 15px; flex-wrap: wrap;
    }

    .del-meta span {
        font-size: 0.8rem; color: var(--gray-text);
    }

    .del-meta span i {
        color: var(--primary-green); margin-right: 4px;
    }

    .del-meta .del-earning {
        color: var(--primary-green); font-weight: 800; font-size: 0.95rem;
    }

    .del-actions {
        display: flex; gap: 8px; flex-wrap: wrap;
    }

    .btn-del-action {
        padding: 8px 16px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 600; border: none;
        color: var(--white); cursor: pointer; transition: var(--transition);
        display: inline-flex; align-items: center; gap: 5px;
        text-decoration: none;
    }

    .btn-view-del { background: linear-gradient(135deg, #1976D2, #42A5F5); }
    .btn-navigate-d { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }
    .btn-pickup-d { background: linear-gradient(135deg, #FB8C00, #FFA726); }
    .btn-delivered-d { background: linear-gradient(135deg, var(--primary-green), var(--light-green)); }

    .btn-del-action:hover {
        transform: translateY(-2px); color: var(--white);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .empty-state-d {
        background: var(--white); border-radius: 16px;
        padding: 60px 30px; text-align: center; box-shadow: var(--shadow);
    }

    .empty-state-d i {
        font-size: 4rem; color: var(--mint-green); margin-bottom: 15px;
    }

    .empty-state-d h5 { color: var(--dark-text); font-weight: 700; }
    .empty-state-d p { color: var(--gray-text); font-size: 0.9rem; }

    @media (max-width: 767px) {
        .del-route-info { grid-template-columns: 1fr; gap: 12px; }
        .del-card-footer { flex-direction: column; align-items: flex-start; }
        .del-actions { width: 100%; }
        .btn-del-action { flex: 1; justify-content: center; }
    }
</style>
@endsection

@section('content')

@php
    // Get deliveries from controller; if null, use empty collection
    $deliveriesCollection = $deliveries ?? collect();

    if ($deliveriesCollection instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        $deliveriesCollection = $deliveriesCollection->getCollection();
    }

    if ($deliveriesCollection->isEmpty()) {
        $allDeliveries = collect([
            (object)[
                'id' => 42,
                'order_id' => 'ORD-0042',
                'pharmacy_name' => 'MediCare',
                'pharmacy_address' => 'Shop 5, Market Road, Nashik',
                'customer_name' => 'Ramesh Patil',
                'customer_address' => 'House 45, Gandhi Road, Nashik',
                'customer_phone' => '9876543210',
                'items_count' => 3,
                'earning' => 45,
                'status' => 'picked_up',
                'created_at' => now()->subMinutes(15),
                'distance' => 2.5,   // ✅ added
            ],
            (object)[
                'id' => 43,
                'order_id' => 'ORD-0043',
                'pharmacy_name' => 'HealthPlus',
                'pharmacy_address' => 'Bus Stand, Pune',
                'customer_name' => 'Sunita Sharma',
                'customer_address' => 'Flat 202, Green Villa, Pune',
                'customer_phone' => '9812345678',
                'items_count' => 5,
                'earning' => 60,
                'status' => 'assigned',
                'created_at' => now()->subMinutes(45),
                'distance' => 4.8,
            ],
            (object)[
                'id' => 41,
                'order_id' => 'ORD-0041',
                'pharmacy_name' => 'DiabetCare',
                'pharmacy_address' => 'MG Road, Nashik',
                'customer_name' => 'Arjun Verma',
                'customer_address' => '12 MG Road, Nashik',
                'customer_phone' => '9998887771',
                'items_count' => 2,
                'earning' => 40,
                'status' => 'assigned',
                'created_at' => now()->subHours(1),
                'distance' => 1.2,
            ],
            (object)[
                'id' => 40,
                'order_id' => 'ORD-0040',
                'pharmacy_name' => 'Wellness',
                'pharmacy_address' => 'Station Rd, Nashik',
                'customer_name' => 'Priya Deshmukh',
                'customer_address' => 'Sai Nagar 78, Nashik',
                'customer_phone' => '9765432109',
                'items_count' => 4,
                'earning' => 55,
                'status' => 'picked_up',
                'created_at' => now()->subHours(2),
                'distance' => 3.7,
            ],
            (object)[
                'id' => 39,
                'order_id' => 'ORD-0039',
                'pharmacy_name' => 'City Pharmacy',
                'pharmacy_address' => 'Central Plaza',
                'customer_name' => 'Amit Kulkarni',
                'customer_address' => 'Shivaji Road, Nashik',
                'customer_phone' => '9871122334',
                'items_count' => 1,
                'earning' => 30,
                'status' => 'delivered',
                'created_at' => now()->subHours(3),
                'distance' => 0.8,
            ],
        ]);
    } else {
        $allDeliveries = $deliveriesCollection;
    }

    $allCount      = $allDeliveries->count();
    $assignedCount = $allDeliveries->filter(fn($d) => $d->status == 'assigned')->count();
    $pickedCount   = $allDeliveries->filter(fn($d) => $d->status == 'picked_up')->count();
    $deliveredCount= $allDeliveries->filter(fn($d) => $d->status == 'delivered')->count();
@endphp

<!-- Filter Tabs -->
<div class="filter-tabs-d">
    <button type="button" class="filter-tab-d active" data-filter="all">
        All <span class="tab-count">{{ $allCount }}</span>
    </button>
    <button type="button" class="filter-tab-d" data-filter="assigned">
        <i class="fas fa-clock me-1"></i> Assigned <span class="tab-count">{{ $assignedCount }}</span>
    </button>
    <button type="button" class="filter-tab-d" data-filter="picked_up">
        <i class="fas fa-box me-1"></i> Picked Up <span class="tab-count">{{ $pickedCount }}</span>
    </button>
    <button type="button" class="filter-tab-d" data-filter="delivered">
        <i class="fas fa-check-circle me-1"></i> Delivered <span class="tab-count">{{ $deliveredCount }}</span>
    </button>
</div>

<!-- Search -->
<div class="search-bar-d">
    <i class="fas fa-search" style="color:var(--primary-green);"></i>
    <input type="text" id="delSearch" class="search-input-d" placeholder="Search by Order ID, customer name, address...">
</div>

<!-- Deliveries List -->
<div id="deliveriesList">
    @foreach($allDeliveries as $del)
        <div class="delivery-card-d st-{{ $del->status }}" data-status="{{ $del->status }}">
            <div class="del-card-header">
                <div class="del-order-info">
                    <span class="del-order-id"><i class="fas fa-receipt me-1"></i> {{ $del->order_id }}</span>
                    <span class="del-time"><i class="fas fa-clock me-1"></i> {{ $del->created_at->diffForHumans() }}</span>
                </div>
                <span class="del-status-badge dsb-{{ $del->status }}">
                    {{ ucfirst(str_replace('_', ' ', $del->status)) }}
                </span>
            </div>

            <div class="del-card-body">
                <div class="del-route-info">
                    <div class="route-point-d">
                        <div class="rp-icon-d pickup"><i class="fas fa-store"></i></div>
                        <div class="rp-details-d">
                            <strong>Pickup: {{ $del->pharmacy_name }}</strong>
                            <p>{{ $del->pharmacy_address }}</p>
                        </div>
                    </div>
                    <div class="route-point-d">
                        <div class="rp-icon-d drop"><i class="fas fa-house"></i></div>
                        <div class="rp-details-d">
                            <strong>Deliver: {{ $del->customer_name }}</strong>
                            <p>{{ $del->customer_address }}</p>
                        </div>
                    </div>
                </div>

                <div class="del-card-footer">
                    <div class="del-meta">
                        <span><i class="fas fa-shopping-bag"></i> {{ $del->items_count }} items</span>
                        <span><i class="fas fa-road"></i> {{ $del->distance }} km</span>
                        <span><i class="fas fa-phone"></i> {{ $del->customer_phone }}</span>
                        <span class="del-earning">+₹{{ $del->earning }}</span>
                    </div>

                    <div class="del-actions">
                        <a href="{{ url('/delivery/details/'.$del->id) }}" class="btn-del-action btn-view-del">
                            <i class="fas fa-eye"></i> View
                        </a>

                        @if(in_array($del->status, ['assigned', 'picked_up']))
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($del->status == 'assigned' ? $del->pharmacy_address : $del->customer_address) }}"
                               target="_blank" class="btn-del-action btn-navigate-d">
                                <i class="fas fa-diamond-turn-right"></i> Navigate
                            </a>
                        @endif

                        @if($del->status == 'assigned')
                            <button type="button" class="btn-del-action btn-pickup-d btn-pickup-list"
                                    data-id="{{ $del->id }}">
                                <i class="fas fa-box"></i> Mark Picked
                            </button>
                        @elseif($del->status == 'picked_up')
                            <button type="button" class="btn-del-action btn-delivered-d btn-deliver-list"
                                    data-id="{{ $del->id }}">
                                <i class="fas fa-check"></i> Mark Delivered
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if(count($allDeliveries) == 0)
        <div class="empty-state-d">
            <i class="fas fa-truck"></i>
            <h5>No deliveries yet</h5>
            <p>Stay online to receive new delivery assignments.</p>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* ============ FILTER TABS ============ */
    $('.filter-tab-d').on('click', function () {
        $('.filter-tab-d').removeClass('active');
        $(this).addClass('active');
        var filter = $(this).data('filter');

        if (filter === 'all') {
            $('.delivery-card-d').show();
        } else {
            $('.delivery-card-d').hide();
            $('.delivery-card-d[data-status="' + filter + '"]').show();
        }
    });

    /* ============ SEARCH ============ */
    $('#delSearch').on('input', function () {
        var q = $(this).val().toLowerCase().trim();
        $('.delivery-card-d').each(function () {
            var text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(q) > -1);
        });
    });

    /* ============ MARK PICKUP ============ */
    $('.btn-pickup-list').on('click', function () {
        var id = $(this).data('id');
        var $btn = $(this);
        if (!confirm('Confirm you have picked up the order?')) return;

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.post('{{ url("/delivery/update-status") }}', {
            _token: '{{ csrf_token() }}', delivery_id: id, status: 'picked_up'
        }).always(function () { location.reload(); });
    });

    /* ============ MARK DELIVERED ============ */
    $('.btn-deliver-list').on('click', function () {
        var id = $(this).data('id');
        var $btn = $(this);
        if (!confirm('Confirm you have delivered the order?')) return;

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.post('{{ url("/delivery/update-status") }}', {
            _token: '{{ csrf_token() }}', delivery_id: id, status: 'delivered'
        }).always(function () { location.reload(); });
    });

});
</script>
@endsection