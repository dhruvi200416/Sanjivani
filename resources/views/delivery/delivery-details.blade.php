@extends('layouts.delivery')

@section('title', 'Delivery Details')
@section('page_title', '<i class="fas fa-info-circle"></i> Delivery Details')

@section('styles')
<style>
    .back-btn-d {
        background: var(--white); color: var(--primary-green);
        border: 2px solid var(--primary-green); padding: 8px 20px;
        border-radius: 25px; font-weight: 600; font-size: 0.85rem;
        text-decoration: none; display: inline-flex; align-items: center;
        gap: 8px; transition: var(--transition); margin-bottom: 20px;
    }

    .back-btn-d:hover {
        background: var(--primary-green); color: var(--white);
        transform: translateX(-3px);
    }

    .del-header-card {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        color: var(--white); border-radius: 18px; padding: 25px 30px;
        margin-bottom: 25px; position: relative; overflow: hidden;
    }

    .del-header-card::after {
        content: '\f0d1'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 30px; bottom: -30px;
        font-size: 10rem; opacity: 0.08;
    }

    .del-header-info { position: relative; z-index: 2; }

    .del-header-info h3 {
        font-size: 1.7rem; font-weight: 800; margin: 0 0 5px;
    }

    .del-header-info p { opacity: 0.9; font-size: 0.9rem; margin: 0; }

    .del-status-large {
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.3);
        padding: 10px 22px; border-radius: 25px;
        font-size: 0.9rem; font-weight: 700; text-transform: uppercase;
        display: inline-flex; align-items: center; gap: 8px;
    }

    .info-block-d {
        background: var(--white); border-radius: 16px; padding: 22px;
        box-shadow: var(--shadow); margin-bottom: 20px;
    }

    .info-block-d h6 {
        font-size: 1rem; font-weight: 700; color: var(--dark-text);
        margin-bottom: 18px; padding-bottom: 12px;
        border-bottom: 2px dashed var(--pale-green);
    }

    .info-block-d h6 i { color: var(--primary-green); margin-right: 8px; }

    .info-row-d {
        display: flex; gap: 12px; padding: 10px 0;
        border-bottom: 1px solid #F5F5F5;
    }

    .info-row-d:last-child { border-bottom: none; }

    .info-icon-sm-d {
        width: 34px; height: 34px; min-width: 34px; border-radius: 8px;
        background: var(--pale-green); color: var(--primary-green);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem;
    }

    .info-text-d { flex: 1; }

    .info-text-d .label {
        font-size: 0.72rem; color: var(--gray-text);
        text-transform: uppercase; font-weight: 600;
        letter-spacing: 0.5px; margin-bottom: 2px;
    }

    .info-text-d .value {
        font-size: 0.9rem; color: var(--dark-text); font-weight: 500;
    }

    .info-text-d .value a { color: var(--primary-green); text-decoration: none; }

    /* Items List */
    .del-items-list {
        display: flex; flex-direction: column; gap: 10px;
    }

    .del-item-row {
        display: flex; align-items: center; gap: 12px;
        padding: 10px; background: var(--off-white); border-radius: 10px;
    }

    .del-item-row .di-img {
        width: 45px; height: 45px; border-radius: 8px;
        background: var(--pale-green); display: flex;
        align-items: center; justify-content: center;
        color: var(--accent-green); font-size: 1.1rem;
    }

    .del-item-row .di-name {
        flex: 1;
    }

    .del-item-row .di-name strong {
        font-size: 0.88rem; color: var(--dark-text); display: block;
    }

    .del-item-row .di-name span {
        font-size: 0.72rem; color: var(--gray-text);
    }

    .del-item-row .di-qty {
        background: var(--primary-green); color: var(--white);
        padding: 4px 10px; border-radius: 12px;
        font-size: 0.75rem; font-weight: 700;
    }

    /* Action Buttons */
    .action-panel {
        display: flex; flex-direction: column; gap: 10px;
    }

    .btn-panel {
        padding: 12px 18px; border-radius: 12px; border: none;
        color: var(--white); font-weight: 600; font-size: 0.9rem;
        cursor: pointer; transition: var(--transition);
        display: flex; align-items: center; justify-content: center;
        gap: 8px; text-decoration: none;
    }

    .btn-navigate-p { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }
    .btn-call-p { background: linear-gradient(135deg, #1976D2, #42A5F5); }
    .btn-pickup-p { background: linear-gradient(135deg, #FB8C00, #FFA726); }
    .btn-deliver-p { background: linear-gradient(135deg, var(--primary-green), var(--light-green)); }
    .btn-cancel-p { background: linear-gradient(135deg, #C62828, #EF5350); }

    .btn-panel:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15); color: var(--white);
    }

    /* Timeline */
    .del-timeline-d {
        list-style: none; padding: 0; margin: 0; position: relative;
    }

    .del-timeline-d::before {
        content: ''; position: absolute; left: 18px; top: 15px;
        bottom: 15px; width: 3px;
        background: linear-gradient(180deg, var(--primary-green), var(--pale-green));
        border-radius: 3px;
    }

    .del-timeline-d li {
        position: relative; padding: 0 0 22px 55px;
    }

    .del-timeline-d li:last-child { padding-bottom: 0; }

    .tl-dot-d {
        position: absolute; left: 8px; top: 4px;
        width: 24px; height: 24px; border-radius: 50%;
        background: var(--white); border: 3px solid var(--mint-green);
        z-index: 2; display: flex; align-items: center; justify-content: center;
    }

    .tl-dot-d.done {
        background: var(--primary-green); border-color: var(--white);
        box-shadow: 0 0 0 3px var(--pale-green);
    }

    .tl-dot-d.done i { color: var(--white); font-size: 0.6rem; }

    .tl-dot-d.current {
        background: #FB8C00; border-color: var(--white);
        box-shadow: 0 0 0 3px #FFF3E0;
        animation: pulse-tl 2s infinite;
    }

    @keyframes pulse-tl {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.15); }
    }

    .tl-content-d h6 {
        font-size: 0.9rem; font-weight: 700;
        color: var(--dark-text); margin: 0 0 3px;
    }

    .tl-content-d p {
        font-size: 0.78rem; color: var(--gray-text); margin: 0;
    }

    .tl-time-d {
        font-size: 0.7rem; color: #999;
        display: block; margin-top: 3px;
    }
</style>
@endsection

@section('content')

@php
    $delivery = $delivery ?? (object)[
        'id' => 42, 'order_id' => 'ORD-0042',
        'pharmacy_name' => 'MediCare Pharmacy',
        'pharmacy_address' => 'Shop 5, Market Road, Nashik',
        'pharmacy_phone' => '9820011223',
        'customer_name' => 'Ramesh Patil',
        'customer_address' => 'House 45, Gandhi Road, Near Sai Temple, Nashik - 422001',
        'customer_phone' => '9876543210',
        'items_count' => 3, 'earning' => 45, 'distance' => 2.5,
        'total_amount' => 780, 'payment_method' => 'cod',
        'status' => 'picked_up',
        'notes' => 'Please ring the bell twice. Handover to customer only.',
        'created_at' => now()->subMinutes(25),
    ];

    $items = $items ?? [
        (object)['name'=>'Paracetamol 500mg','brand'=>'Crocin','quantity'=>4],
        (object)['name'=>'Vitamin C 500mg','brand'=>'Limcee','quantity'=>2],
        (object)['name'=>'Cough Syrup','brand'=>'Benadryl','quantity'=>2],
    ];

    $currentStatus = $delivery->status;
    $timelineSteps = [
        'assigned' => ['label'=>'Assigned', 'icon'=>'fa-user-check', 'desc'=>'Delivery assigned to you'],
        'picked_up' => ['label'=>'Picked Up', 'icon'=>'fa-box', 'desc'=>'Order picked up from pharmacy'],
        'delivered' => ['label'=>'Delivered', 'icon'=>'fa-check-circle', 'desc'=>'Order delivered to customer'],
    ];

    $statusKeys = array_keys($timelineSteps);
    $currentIdx = array_search($currentStatus, $statusKeys);
    if ($currentIdx === false) $currentIdx = 0;
@endphp

<a href="{{ url('/delivery/deliveries') }}" class="back-btn-d">
    <i class="fas fa-arrow-left"></i> Back to Deliveries
</a>

<div class="del-header-card">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="del-header-info">
                <h3><i class="fas fa-receipt me-2"></i>#{{ $delivery->order_id }}</h3>
                <p><i class="fas fa-calendar me-1"></i>{{ date('d M Y, h:i A', strtotime($delivery->created_at)) }}</p>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <span class="del-status-large">
                <i class="fas fa-truck"></i> {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
            </span>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Pickup Location -->
        <div class="info-block-d">
            <h6><i class="fas fa-store"></i> Pickup From (Pharmacy)</h6>
            <div class="info-row-d">
                <div class="info-icon-sm-d"><i class="fas fa-hospital"></i></div>
                <div class="info-text-d">
                    <div class="label">Pharmacy Name</div>
                    <div class="value">{{ $delivery->pharmacy_name }}</div>
                </div>
            </div>
            <div class="info-row-d">
                <div class="info-icon-sm-d"><i class="fas fa-map-marker-alt"></i></div>
                <div class="info-text-d">
                    <div class="label">Address</div>
                    <div class="value">{{ $delivery->pharmacy_address }}</div>
                </div>
            </div>
            <div class="info-row-d">
                <div class="info-icon-sm-d"><i class="fas fa-phone"></i></div>
                <div class="info-text-d">
                    <div class="label">Contact</div>
                    <div class="value"><a href="tel:{{ $delivery->pharmacy_phone }}">{{ $delivery->pharmacy_phone }}</a></div>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="info-block-d">
            <h6><i class="fas fa-user"></i> Deliver To (Customer)</h6>
            <div class="info-row-d">
                <div class="info-icon-sm-d"><i class="fas fa-user"></i></div>
                <div class="info-text-d">
                    <div class="label">Customer Name</div>
                    <div class="value">{{ $delivery->customer_name }}</div>
                </div>
            </div>
            <div class="info-row-d">
                <div class="info-icon-sm-d"><i class="fas fa-home"></i></div>
                <div class="info-text-d">
                    <div class="label">Delivery Address</div>
                    <div class="value">{{ $delivery->customer_address }}</div>
                </div>
            </div>
            <div class="info-row-d">
                <div class="info-icon-sm-d"><i class="fas fa-phone"></i></div>
                <div class="info-text-d">
                    <div class="label">Contact</div>
                    <div class="value"><a href="tel:{{ $delivery->customer_phone }}">{{ $delivery->customer_phone }}</a></div>
                </div>
            </div>
            @if(!empty($delivery->notes))
            <div class="info-row-d">
                <div class="info-icon-sm-d" style="background:#FFF3E0;color:#FB8C00;"><i class="fas fa-sticky-note"></i></div>
                <div class="info-text-d">
                    <div class="label">Delivery Notes</div>
                    <div class="value">{{ $delivery->notes }}</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Order Items -->
        <div class="info-block-d">
            <h6><i class="fas fa-shopping-bag"></i> Order Items ({{ count($items) }})</h6>
            <div class="del-items-list">
                @foreach($items as $item)
                    <div class="del-item-row">
                        <div class="di-img"><i class="fas fa-pills"></i></div>
                        <div class="di-name">
                            <strong>{{ $item->name }}</strong>
                            <span>{{ $item->brand }}</span>
                        </div>
                        <span class="di-qty">×{{ $item->quantity }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Actions -->
        <div class="info-block-d">
            <h6><i class="fas fa-bolt"></i> Actions</h6>
            <div class="action-panel">
                @if($currentStatus == 'assigned')
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($delivery->pharmacy_address) }}" target="_blank" class="btn-panel btn-navigate-p">
                        <i class="fas fa-diamond-turn-right"></i> Navigate to Pharmacy
                    </a>
                    <a href="tel:{{ $delivery->pharmacy_phone }}" class="btn-panel btn-call-p">
                        <i class="fas fa-phone"></i> Call Pharmacy
                    </a>
                    <button type="button" class="btn-panel btn-pickup-p" id="btnMarkPickup"
                            data-id="{{ $delivery->id }}">
                        <i class="fas fa-box"></i> Mark as Picked Up
                    </button>
                @elseif($currentStatus == 'picked_up')
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($delivery->customer_address) }}" target="_blank" class="btn-panel btn-navigate-p">
                        <i class="fas fa-diamond-turn-right"></i> Navigate to Customer
                    </a>
                    <a href="tel:{{ $delivery->customer_phone }}" class="btn-panel btn-call-p">
                        <i class="fas fa-phone"></i> Call Customer
                    </a>
                    <button type="button" class="btn-panel btn-deliver-p" id="btnMarkDelivered"
                            data-id="{{ $delivery->id }}">
                        <i class="fas fa-check-circle"></i> Mark as Delivered
                    </button>
                @endif

                @if(in_array($currentStatus, ['assigned', 'picked_up']))
                    <button type="button" class="btn-panel btn-cancel-p" id="btnCancelDel">
                        <i class="fas fa-times-circle"></i> Report Issue
                    </button>
                @endif
            </div>
        </div>

        <!-- Payment Info -->
        <div class="info-block-d">
            <h6><i class="fas fa-money-bill-wave"></i> Payment</h6>
            <div class="info-row-d">
                <div class="info-icon-sm-d"><i class="fas fa-credit-card"></i></div>
                <div class="info-text-d">
                    <div class="label">Payment Method</div>
                    <div class="value">{{ strtoupper($delivery->payment_method) }}</div>
                </div>
            </div>
            <div class="info-row-d">
                <div class="info-icon-sm-d"><i class="fas fa-rupee-sign"></i></div>
                <div class="info-text-d">
                    <div class="label">Order Total</div>
                    <div class="value" style="font-weight:800;color:var(--dark-text);font-size:1.05rem;">₹{{ number_format($delivery->total_amount, 2) }}</div>
                </div>
            </div>
            @if(strtolower($delivery->payment_method) == 'cod')
                <div style="background:#FFF3E0;color:#E65100;padding:10px 12px;border-radius:10px;font-size:0.82rem;font-weight:600;margin-top:10px;text-align:center;">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    Collect ₹{{ number_format($delivery->total_amount, 2) }} from customer
                </div>
            @endif
            <div class="info-row-d" style="border-top:2px dashed #E0E0E0;margin-top:8px;padding-top:12px;">
                <div class="info-icon-sm-d" style="background:#E8F5E9;color:#2E7D32;"><i class="fas fa-hand-holding-dollar"></i></div>
                <div class="info-text-d">
                    <div class="label">Your Earning</div>
                    <div class="value" style="font-weight:800;color:var(--primary-green);font-size:1.1rem;">+₹{{ $delivery->earning }}</div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="info-block-d">
            <h6><i class="fas fa-history"></i> Status Timeline</h6>
            <ul class="del-timeline-d">
                @foreach($timelineSteps as $key => $step)
                    @php
                        $idx = array_search($key, $statusKeys);
                        $isDone = $idx < $currentIdx;
                        $isCurrent = $idx == $currentIdx;
                    @endphp
                    <li>
                        <div class="tl-dot-d {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}">
                            @if($isDone) <i class="fas fa-check"></i> @endif
                        </div>
                        <div class="tl-content-d">
                            <h6><i class="fas {{ $step['icon'] }} me-1" style="color:var(--primary-green);"></i>{{ $step['label'] }}</h6>
                            <p>{{ $step['desc'] }}</p>
                            @if($isCurrent)
                                <span class="tl-time-d" style="color:#FB8C00;font-weight:600;">Current</span>
                            @elseif($isDone)
                                <span class="tl-time-d"><i class="fas fa-check me-1" style="color:#2E7D32;"></i>Completed</span>
                            @else
                                <span class="tl-time-d"><i class="fas fa-hourglass-half me-1"></i>Pending</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    $('#btnMarkPickup').on('click', function () {
        var id = $(this).data('id');
        if (!confirm('Confirm you have picked up the order from the pharmacy?')) return;

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        $.post('{{ url("/delivery/update-status") }}', {
            _token: '{{ csrf_token() }}', delivery_id: id, status: 'picked_up'
        }).always(function () { location.reload(); });
    });

    $('#btnMarkDelivered').on('click', function () {
        var id = $(this).data('id');
        if (!confirm('Confirm you have delivered the order to the customer?')) return;

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        $.post('{{ url("/delivery/update-status") }}', {
            _token: '{{ csrf_token() }}', delivery_id: id, status: 'delivered'
        }).always(function () { location.reload(); });
    });

    $('#btnCancelDel').on('click', function () {
        var reason = prompt('Please describe the issue (e.g., customer not available, wrong address):');
        if (!reason || reason.trim().length < 5) {
            if (reason !== null) alert('Please provide a valid reason (min 5 characters).');
            return;
        }

        var $form = $('<form>', { method: 'POST', action: '{{ url("/delivery/report-issue") }}' });
        $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
        $form.append('<input type="hidden" name="delivery_id" value="{{ $delivery->id }}">');
        $form.append('<input type="hidden" name="reason" value="' + reason + '">');
        $('body').append($form);
        $form.submit();
    });

});
</script>
@endsection