@extends('layouts.pharmacy')

@section('title', 'Order Details')
@section('page_title')
<i class="fas fa-file-invoice"></i> {{ app(\App\Services\GoogleTranslator::class)->translate('Order Details') }}
@endsection

@section('styles')
<style>
    .back-btn-ph {
        background: var(--white);
        color: var(--primary-green);
        border: 2px solid var(--primary-green);
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        margin-bottom: 20px;
    }

    .back-btn-ph:hover {
        background: var(--primary-green);
        color: var(--white);
    }

    .ord-header-ph {
        background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
        color: var(--white);
        border-radius: 18px;
        padding: 25px 30px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    .ord-header-ph::after {
        content: '\f570';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 20px;
        bottom: -30px;
        font-size: 10rem;
        opacity: 0.08;
    }

    .ord-header-ph h3 {
        font-size: 1.7rem;
        font-weight: 800;
        margin: 0 0 5px;
    }

    .ord-header-ph p {
        opacity: 0.9;
        font-size: 0.9rem;
        margin: 0;
    }

    .info-block-ph {
        background: var(--white);
        border-radius: 16px;
        padding: 22px;
        box-shadow: var(--shadow);
        margin-bottom: 20px;
    }

    .info-block-ph h6 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 2px dashed var(--pale-green);
    }

    .info-block-ph h6 i {
        color: var(--primary-green);
        margin-right: 8px;
    }

    .info-row-ph {
        display: flex;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #F5F5F5;
    }

    .info-row-ph:last-child {
        border-bottom: none;
    }

    .info-ico-ph {
        width: 34px;
        height: 34px;
        min-width: 34px;
        border-radius: 8px;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-txt-ph {
        flex: 1;
    }

    .info-txt-ph .lbl {
        font-size: 0.72rem;
        color: var(--gray-text);
        text-transform: uppercase;
        font-weight: 600;
    }

    .info-txt-ph .val {
        font-size: 0.9rem;
        color: var(--dark-text);
        font-weight: 500;
    }

    .items-table-ph {
        width: 100%;
    }

    .items-table-ph thead th {
        background: var(--off-white);
        color: var(--gray-text);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 12px 15px;
        border-bottom: 1px solid #E0E0E0;
    }

    .items-table-ph tbody td {
        padding: 14px 15px;
        font-size: 0.88rem;
        border-bottom: 1px solid #F5F5F5;
    }

    .summary-row-ph {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 0.9rem;
        color: var(--gray-text);
    }

    .summary-row-ph.total {
        border-top: 2px dashed #E0E0E0;
        margin-top: 10px;
        padding-top: 15px;
        font-weight: 800;
        color: var(--primary-green);
        font-size: 1.2rem;
    }

    .action-btns-ph {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .act-btn-ph {
        padding: 12px;
        border-radius: 12px;
        border: none;
        color: var(--white);
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .act-btn-ph:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        color: var(--white);
    }

    .act-confirm {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
    }

    .act-process {
        background: linear-gradient(135deg, #7B1FA2, #AB47BC);
    }

    .act-ship {
        background: linear-gradient(135deg, #C2185B, #E91E63);
    }

    .act-print {
        background: linear-gradient(135deg, #455A64, #78909C);
    }

    .act-cancel {
        background: linear-gradient(135deg, #C62828, #EF5350);
    }

    @media print {

        .sidebar,
        .topbar,
        .back-btn-ph,
        .action-btns-ph {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
        }

        .page-content {
            padding: 20px !important;
        }
    }
</style>
@endsection

@section('content')

@php
use App\Services\GoogleTranslator;

// The controller is now properly providing $order, $customer, and $items.
$st = $order->status;

// Safely get the village name (fixes the null error)
$villageName = $customer->village->name ?? 'N/A';
$translatedVillage = GoogleTranslator::translate($villageName);
$translatedAddress = GoogleTranslator::translate($order->delivery_address);
$translatedNotes = !empty($order->notes) ? GoogleTranslator::translate($order->notes) : '';

$strings = GoogleTranslator::translateBatch([
'back_orders' => 'Back to Orders',
'cust_details' => 'Customer Details',
'lbl_name' => 'Name',
'lbl_phone' => 'Phone',
'lbl_email' => 'Email',
'lbl_village' => 'Village',
'lbl_address' => 'Delivery Address',
'lbl_notes' => 'Notes',
'order_items' => 'Order Items',
'th_med' => 'Medicine',
'th_brand' => 'Brand',
'th_qty' => 'Qty',
'th_price' => 'Price',
'th_total' => 'Total',
'lbl_subtotal' => 'Subtotal',
'lbl_delivery' => 'Delivery',
'lbl_total' => 'Total',
'actions' => 'Actions',
'btn_confirm' => 'Confirm Order',
'btn_process' => 'Start Processing',
'btn_ship' => 'Hand to Delivery',
'btn_print' => 'Print Invoice',
'btn_cancel' => 'Cancel Order',
'payment' => 'Payment',
'lbl_method' => 'Method',
'lbl_status' => 'Status',
'lbl_amount' => 'Amount',
'js_update_status' => 'Update order status to ":status"?',
'js_updating' => 'Updating...',
'js_cancel_confirm' => '⚠ Cancel this order? This cannot be undone.'
]);
@endphp

<a href="{{ url('/pharmacy/orders') }}" class="back-btn-ph"><i class="fas fa-arrow-left"></i> {{ $strings['back_orders'] }}</a>

<div class="ord-header-ph">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3><i class="fas fa-receipt me-2"></i>#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h3>
            <p><i class="fas fa-calendar me-1"></i>{{ date('d M Y, h:i A', strtotime($order->created_at)) }}</p>
        </div>
        <div class="col-md-4 text-md-end">
            <span class="st-badge-ph stb-{{ $st }}" style="font-size:0.9rem;padding:8px 18px;">
                {{ app(\App\Services\GoogleTranslator::class)->translate(ucfirst(str_replace('_',' ',$st))) }}
            </span>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Customer -->
        <div class="info-block-ph">
            <h6><i class="fas fa-user"></i> {{ $strings['cust_details'] }}</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="info-row-ph">
                        <div class="info-ico-ph"><i class="fas fa-user"></i></div>
                        <div class="info-txt-ph">
                            <div class="lbl">{{ $strings['lbl_name'] }}</div>
                            <div class="val">{{ $customer->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row-ph">
                        <div class="info-ico-ph"><i class="fas fa-phone"></i></div>
                        <div class="info-txt-ph">
                            <div class="lbl">{{ $strings['lbl_phone'] }}</div>
                            <div class="val"><a href="tel:{{ $customer->phone ?? '' }}" style="color:var(--primary-green);">{{ $customer->phone ?? 'N/A' }}</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row-ph">
                        <div class="info-ico-ph"><i class="fas fa-envelope"></i></div>
                        <div class="info-txt-ph">
                            <div class="lbl">{{ $strings['lbl_email'] }}</div>
                            <div class="val">{{ $customer->email ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row-ph">
                        <div class="info-ico-ph"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-txt-ph">
                            <div class="lbl">{{ $strings['lbl_village'] }}</div>
                            <div class="val">{{ $translatedVillage }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="info-row-ph">
                        <div class="info-ico-ph"><i class="fas fa-home"></i></div>
                        <div class="info-txt-ph">
                            <div class="lbl">{{ $strings['lbl_address'] }}</div>
                            <div class="val">{{ $translatedAddress }}</div>
                        </div>
                    </div>
                </div>
                @if(!empty($order->notes))
                <div class="col-12">
                    <div class="info-row-ph">
                        <div class="info-ico-ph" style="background:#FFF3E0;color:#FB8C00;"><i class="fas fa-sticky-note"></i></div>
                        <div class="info-txt-ph">
                            <div class="lbl">{{ $strings['lbl_notes'] }}</div>
                            <div class="val">{{ $translatedNotes }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Items -->
        <div class="info-block-ph">
            <h6><i class="fas fa-shopping-bag"></i> {{ $strings['order_items'] }} ({{ count($items) }})</h6>
            <div class="table-responsive">
                <table class="items-table-ph">
                    <thead>
                        <tr>
                            <th>{{ $strings['th_med'] }}</th>
                            <th>{{ $strings['th_brand'] }}</th>
                            <th class="text-center">{{ $strings['th_qty'] }}</th>
                            <th class="text-end">{{ $strings['th_price'] }}</th>
                            <th class="text-end">{{ $strings['th_total'] }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td style="font-weight:600;">{{ GoogleTranslator::translate($item->medicine->name ?? $item->name ?? 'N/A') }}</td>
                            <td style="color:var(--gray-text);">{{ GoogleTranslator::translate($item->medicine->brand ?? $item->brand ?? 'N/A') }}</td>
                            <td class="text-center"><span style="background:var(--pale-green);color:var(--primary-green);padding:3px 10px;border-radius:12px;font-weight:600;">×{{ $item->quantity }}</span></td>
                            <td class="text-end">₹{{ number_format($item->price) }}</td>
                            <td class="text-end" style="font-weight:700;color:var(--primary-green);">₹{{ number_format($item->total ?? ($item->price * $item->quantity)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:15px 0 0;border-top:2px dashed var(--pale-green);margin-top:10px;">
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <div class="summary-row-ph"><span>{{ $strings['lbl_subtotal'] }}</span><span>₹{{ number_format($order->subtotal ?? 0) }}</span></div>
                        <div class="summary-row-ph"><span>{{ $strings['lbl_delivery'] }}</span><span>₹{{ number_format($order->delivery_fee ?? 0) }}</span></div>
                        <div class="summary-row-ph total"><span>{{ $strings['lbl_total'] }}</span><span>₹{{ number_format($order->total_amount ?? 0) }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Actions -->
        <div class="info-block-ph">
            <h6><i class="fas fa-bolt"></i> {{ $strings['actions'] }}</h6>
            <div class="action-btns-ph">
                @if($st == 'pending')
                <button type="button" class="act-btn-ph act-confirm btn-status-ph" data-status="confirmed"><i class="fas fa-check"></i> {{ $strings['btn_confirm'] }}</button>
                @endif
                @if($st == 'confirmed')
                <button type="button" class="act-btn-ph act-process btn-status-ph" data-status="processing"><i class="fas fa-cogs"></i> {{ $strings['btn_process'] }}</button>
                @endif
                @if($st == 'processing')
                <button type="button" class="act-btn-ph act-ship btn-status-ph" data-status="out_for_delivery"><i class="fas fa-motorcycle"></i> {{ $strings['btn_ship'] }}</button>
                @endif
                <button type="button" class="act-btn-ph act-print" onclick="window.print()"><i class="fas fa-print"></i> {{ $strings['btn_print'] }}</button>
                @if(!in_array($st, ['delivered','cancelled']))
                <button type="button" class="act-btn-ph act-cancel" id="cancelOrdPh"><i class="fas fa-times"></i> {{ $strings['btn_cancel'] }}</button>
                @endif
            </div>
        </div>

        <!-- Payment -->
        <div class="info-block-ph">
            <h6><i class="fas fa-money-bill-wave"></i> {{ $strings['payment'] }}</h6>
            <div class="info-row-ph">
                <div class="info-ico-ph"><i class="fas fa-credit-card"></i></div>
                <div class="info-txt-ph">
                    <div class="lbl">{{ $strings['lbl_method'] }}</div>
                    <div class="val">{{ strtoupper($order->payment_method ?? 'COD') }}</div>
                </div>
            </div>
            <div class="info-row-ph">
                <div class="info-ico-ph"><i class="fas fa-check-circle"></i></div>
                <div class="info-txt-ph">
                    <div class="lbl">{{ $strings['lbl_status'] }}</div>
                    <div class="val" style="color:{{ ($order->payment_status ?? '') == 'paid' ? '#2E7D32' : '#FB8C00' }};font-weight:700;">
                        {{ app(\App\Services\GoogleTranslator::class)->translate(strtoupper($order->payment_status ?? 'PENDING')) }}
                    </div>
                </div>
            </div>
            <div class="info-row-ph">
                <div class="info-ico-ph"><i class="fas fa-rupee-sign"></i></div>
                <div class="info-txt-ph">
                    <div class="lbl">{{ $strings['lbl_amount'] }}</div>
                    <div class="val" style="font-size:1.15rem;font-weight:800;color:var(--primary-green);">₹{{ number_format($order->total_amount ?? 0) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        var jsStrings = {
            updateStatus: @json($strings['js_update_status']),
            updating: @json($strings['js_updating']),
            cancelConfirm: @json($strings['js_cancel_confirm'])
        };

        $('.btn-status-ph').on('click', function() {
            var status = $(this).data('status');
            var displayStatus = status.replace('_', ' ');
            var msg = jsStrings.updateStatus.replace(':status', displayStatus);

            if (!confirm(msg)) return;

            var $btn = $(this);
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> ' + jsStrings.updating);

            $.post('{{ url("/pharmacy/order/update-status") }}', {
                _token: '{{ csrf_token() }}',
                order_id: '{{ $order->id }}',
                status: status
            }).always(function() {
                location.reload();
            });
        });

        $('#cancelOrdPh').on('click', function() {
            if (!confirm(jsStrings.cancelConfirm)) return;

            var $f = $('<form>', {
                method: 'POST',
                action: '{{ url("/pharmacy/order/cancel") }}'
            });
            $f.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            $f.append('<input type="hidden" name="order_id" value="{{ $order->id }}">');
            $('body').append($f);
            $f.submit();
        });
    });
</script>
@endsection