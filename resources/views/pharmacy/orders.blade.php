@extends('layouts.pharmacy')

@section('title', 'Manage Orders')
@section('page_title')
<i class="fas fa-shopping-cart"></i> Manage Orders
@endsection

@section('styles')
<style>
    .order-stats-ph {
        display: grid; grid-template-columns: repeat(5, 1fr);
        gap: 12px; margin-bottom: 20px;
    }

    .os-ph {
        background: var(--white); border-radius: 14px; padding: 16px;
        box-shadow: var(--shadow); display: flex; align-items: center;
        gap: 12px; cursor: pointer; transition: var(--transition);
        border: 2px solid transparent;
    }

    .os-ph:hover { transform: translateY(-2px); }
    .os-ph.active { border-color: var(--primary-green); background: var(--pale-green); }

    .os-ph .os-ic {
        width: 42px; height: 42px; min-width: 42px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: var(--white); font-size: 1rem;
    }

    .os-ic.all { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .os-ic.pending { background: linear-gradient(135deg, #E65100, #FFA726); }
    .os-ic.confirmed { background: linear-gradient(135deg, #1565C0, #42A5F5); }
    .os-ic.processing { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }
    .os-ic.delivered { background: linear-gradient(135deg, #00695C, #26A69A); }

    .os-ph .os-v { font-size: 1.3rem; font-weight: 800; color: var(--dark-text); line-height: 1; }
    .os-ph .os-l { font-size: 0.72rem; color: var(--gray-text); }

    .filter-bar-ph {
        background: var(--white); border-radius: 14px; padding: 15px 20px;
        box-shadow: var(--shadow); margin-bottom: 20px;
        display: flex; gap: 12px; align-items: center; flex-wrap: wrap;
    }

    .search-input-ph {
        flex: 1; min-width: 200px; padding: 10px 14px 10px 38px;
        border: 2px solid #E8E8E8; border-radius: 25px;
        font-size: 0.88rem; outline: none; transition: var(--transition);
        font-family: 'Poppins', sans-serif;
    }

    .search-input-ph:focus { border-color: var(--primary-green); }

    .filter-select-ph {
        padding: 10px 35px 10px 14px; border: 2px solid #E8E8E8;
        border-radius: 25px; font-size: 0.85rem; outline: none;
        background: var(--white); cursor: pointer; appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat; background-position: right 12px center;
        background-size: 10px; font-family: 'Poppins', sans-serif;
    }

    .orders-table-ph {
        background: var(--white); border-radius: 16px;
        box-shadow: var(--shadow); overflow: hidden;
    }

    .orders-table-ph table { width: 100%; margin: 0; }

    .orders-table-ph thead th {
        background: var(--off-white); color: var(--gray-text);
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; padding: 14px 18px;
        border-bottom: 1px solid #E0E0E0; white-space: nowrap;
    }

    .orders-table-ph tbody td {
        padding: 14px 18px; font-size: 0.87rem;
        color: var(--dark-text); vertical-align: middle;
        border-bottom: 1px solid #F5F5F5;
    }

    .orders-table-ph tbody tr { transition: var(--transition); }
    .orders-table-ph tbody tr:hover { background: var(--off-white); }

    .ord-id-ph {
        font-weight: 700; color: var(--primary-green); text-decoration: none;
    }

    .ord-id-ph:hover { text-decoration: underline; }

    .cust-cell-ph {
        display: flex; align-items: center; gap: 10px;
    }

    .cust-av-ph {
        width: 36px; height: 36px; min-width: 36px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); display: flex; align-items: center;
        justify-content: center; font-size: 0.85rem; font-weight: 700;
    }

    .cust-cell-ph .cn { font-weight: 600; font-size: 0.87rem; display: block; }
    .cust-cell-ph .cp { font-size: 0.72rem; color: var(--gray-text); }

    .st-badge-ph {
        display: inline-block; padding: 4px 10px; border-radius: 12px;
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    }

    .stb-pending { background: #FFF3E0; color: #E65100; }
    .stb-confirmed { background: #E3F2FD; color: #1565C0; }
    .stb-processing { background: #F3E5F5; color: #7B1FA2; }
    .stb-out_for_delivery { background: #FCE4EC; color: #AD1457; }
    .stb-delivered { background: #E8F5E9; color: #1B5E20; }
    .stb-cancelled { background: #FFEBEE; color: #B71C1C; }

    .pay-badge-ph {
        display: inline-block; padding: 3px 8px; border-radius: 10px;
        font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
    }

    .pay-cod { background: #FFF3E0; color: #E65100; }
    .pay-online { background: #E3F2FD; color: #1565C0; }
    .pay-upi { background: #F3E5F5; color: #6A1B9A; }

    .ord-price-ph { font-weight: 700; color: var(--primary-green); }

    .ord-actions-ph { display: flex; gap: 5px; }

    .oa-btn {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        color: var(--white); border: none; cursor: pointer;
        transition: var(--transition); font-size: 0.75rem; text-decoration: none;
    }

    .oa-btn.view { background: #1976D2; }
    .oa-btn.confirm { background: #2E7D32; }
    .oa-btn.process { background: #7B1FA2; }
    .oa-btn.cancel { background: #C62828; }

    .oa-btn:hover {
        transform: translateY(-2px); color: var(--white);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .empty-orders-ph {
        text-align: center; padding: 60px 30px;
    }

    .empty-orders-ph i { font-size: 4rem; color: var(--mint-green); margin-bottom: 15px; }
    .empty-orders-ph h5 { color: var(--gray-text); font-weight: 700; }

    .pagination-ph {
        padding: 15px 20px; display: flex;
        justify-content: space-between; align-items: center;
        border-top: 1px solid #EEE; flex-wrap: wrap; gap: 10px;
    }

    .pagination-ph .pg-info { font-size: 0.85rem; color: var(--gray-text); }

    .pg-btns { display: flex; gap: 5px; }

    .pg-btn {
        width: 34px; height: 34px; display: flex;
        align-items: center; justify-content: center;
        border-radius: 8px; background: var(--white);
        border: 1px solid #E0E0E0; color: var(--dark-text);
        font-size: 0.82rem; cursor: pointer; text-decoration: none;
    }

    .pg-btn:hover { background: var(--pale-green); border-color: var(--primary-green); color: var(--primary-green); }
    .pg-btn.active { background: linear-gradient(135deg, var(--primary-green), var(--light-green)); color: var(--white); border-color: var(--primary-green); }

    /* Status Modal */
    .modal-content-ph { border: none; border-radius: 18px; overflow: hidden; }
    .modal-header-ph {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); padding: 18px 25px; border: none;
    }
    .modal-header-ph .btn-close { filter: brightness(0) invert(1); }

    .status-opt-ph {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 16px; border: 2px solid #E0E0E0;
        border-radius: 12px; margin-bottom: 10px;
        cursor: pointer; transition: var(--transition);
    }

    .status-opt-ph:hover { border-color: var(--primary-green); background: var(--off-white); }
    .status-opt-ph.selected { border-color: var(--primary-green); background: var(--pale-green); }

    .status-opt-ph .so-ic {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: var(--white); font-size: 1rem;
    }

    .status-opt-ph .so-txt strong { display: block; font-size: 0.9rem; color: var(--dark-text); }
    .status-opt-ph .so-txt span { font-size: 0.75rem; color: var(--gray-text); }

    @media (max-width: 991px) {
        .order-stats-ph { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 767px) {
        .order-stats-ph { grid-template-columns: 1fr 1fr; }
        .orders-table-ph thead { display: none; }
        .orders-table-ph tbody td { padding: 10px 12px; font-size: 0.85rem; }
        .filter-bar-ph { flex-direction: column; }
        .search-input-ph { min-width: 100%; }
    }
</style>
@endsection

@section('content')

@php
    // Get orders from controller; if null, use demo data
    $ordersCollection = $orders ?? null;

    // If it's a paginator, extract the underlying Collection
    if ($ordersCollection instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        $ordersCollection = $ordersCollection->getCollection();
    }

    // If no real data (or empty collection), fallback to demo data
    if (is_null($ordersCollection) || $ordersCollection->isEmpty()) {
        $demoOrders = collect([
            (object)['id'=>101,'customer_name'=>'Ramesh Patil','phone'=>'9876543210','village'=>'Nashik','items'=>3,'total'=>780,'payment'=>'cod','status'=>'pending','date'=>now()->subMinutes(5)],
            (object)['id'=>100,'customer_name'=>'Sunita Sharma','phone'=>'9812345678','village'=>'Pune','items'=>5,'total'=>1250,'payment'=>'online','status'=>'pending','date'=>now()->subMinutes(20)],
            (object)['id'=>99,'customer_name'=>'Arjun Verma','phone'=>'9998887771','village'=>'Jaipur','items'=>2,'total'=>450,'payment'=>'upi','status'=>'confirmed','date'=>now()->subHours(1)],
            (object)['id'=>98,'customer_name'=>'Priya Deshmukh','phone'=>'9765432109','village'=>'Aurangabad','items'=>4,'total'=>920,'payment'=>'cod','status'=>'processing','date'=>now()->subHours(3)],
            (object)['id'=>97,'customer_name'=>'Amit Kulkarni','phone'=>'9871122334','village'=>'Kolhapur','items'=>1,'total'=>180,'payment'=>'online','status'=>'delivered','date'=>now()->subHours(5)],
            (object)['id'=>96,'customer_name'=>'Neha Joshi','phone'=>'9822334455','village'=>'Nagpur','items'=>6,'total'=>1580,'payment'=>'upi','status'=>'delivered','date'=>now()->subDays(1)],
            (object)['id'=>95,'customer_name'=>'Suresh Rao','phone'=>'9776655443','village'=>'Solapur','items'=>2,'total'=>340,'payment'=>'cod','status'=>'cancelled','date'=>now()->subDays(2)],
            (object)['id'=>94,'customer_name'=>'Kavita Menon','phone'=>'9665544332','village'=>'Satara','items'=>3,'total'=>720,'payment'=>'online','status'=>'delivered','date'=>now()->subDays(3)],
        ]);
    } else {
        $demoOrders = $ordersCollection;
    }

    // Count using Collection methods (no array_filter)
    $allC  = $demoOrders->count();
    $pendC = $demoOrders->filter(fn($o) => $o->status == 'pending')->count();
    $confC = $demoOrders->filter(fn($o) => $o->status == 'confirmed')->count();
    $procC = $demoOrders->filter(fn($o) => $o->status == 'processing')->count();
    $delC  = $demoOrders->filter(fn($o) => $o->status == 'delivered')->count();
@endphp

<!-- Stats -->
<div class="order-stats-ph" data-aos="fade-up">
    <div class="os-ph active" data-filter="all">
        <div class="os-ic all"><i class="fas fa-list"></i></div>
        <div><div class="os-v">{{ $allC }}</div><div class="os-l">All</div></div>
    </div>
    <div class="os-ph" data-filter="pending">
        <div class="os-ic pending"><i class="fas fa-clock"></i></div>
        <div><div class="os-v">{{ $pendC }}</div><div class="os-l">Pending</div></div>
    </div>
    <div class="os-ph" data-filter="confirmed">
        <div class="os-ic confirmed"><i class="fas fa-check"></i></div>
        <div><div class="os-v">{{ $confC }}</div><div class="os-l">Confirmed</div></div>
    </div>
    <div class="os-ph" data-filter="processing">
        <div class="os-ic processing"><i class="fas fa-cogs"></i></div>
        <div><div class="os-v">{{ $procC }}</div><div class="os-l">Processing</div></div>
    </div>
    <div class="os-ph" data-filter="delivered">
        <div class="os-ic delivered"><i class="fas fa-check-circle"></i></div>
        <div><div class="os-v">{{ $delC }}</div><div class="os-l">Delivered</div></div>
    </div>
</div>

<!-- Filter Bar -->
<div class="filter-bar-ph">
    <div style="flex:1;position:relative;min-width:200px;">
        <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--primary-green);"></i>
        <input type="text" id="orderSearchPh" class="search-input-ph" placeholder="Search Order ID, customer...">
    </div>
    <select id="statusFilterPh" class="filter-select-ph">
        <option value="">All Status</option>
        <option value="pending">Pending</option>
        <option value="confirmed">Confirmed</option>
        <option value="processing">Processing</option>
        <option value="delivered">Delivered</option>
        <option value="cancelled">Cancelled</option>
    </select>
    <select id="paymentFilterPh" class="filter-select-ph">
        <option value="">All Payments</option>
        <option value="cod">COD</option>
        <option value="online">Online</option>
        <option value="upi">UPI</option>
    </select>
</div>

<!-- Orders Table -->
<div class="orders-table-ph">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demoOrders as $ord)
                    @php $st = $ord->status; @endphp
                    <tr data-status="{{ $st }}" data-payment="{{ $ord->payment }}">
                        <td><a href="{{ url('/pharmacy/order/'.$ord->id) }}" class="ord-id-ph">#ORD-{{ str_pad($ord->id, 4, '0', STR_PAD_LEFT) }}</a></td>
                        <td>
                            <div class="cust-cell-ph">
                                <div class="cust-av-ph">{{ strtoupper(substr($ord->customer_name, 0, 1)) }}</div>
                                <div>
                                    <span class="cn">{{ $ord->customer_name }}</span>
                                    <span class="cp"><i class="fas fa-map-marker-alt me-1"></i>{{ $ord->village }}</span>
                                </div>
                            </div>
                        </td>
                        <td><span style="background:var(--pale-green);color:var(--primary-green);padding:3px 10px;border-radius:12px;font-weight:600;font-size:0.78rem;">{{ $ord->items }}</span></td>
                        <td class="ord-price-ph">₹{{ number_format($ord->total) }}</td>
                        <td><span class="pay-badge-ph pay-{{ $ord->payment }}">{{ strtoupper($ord->payment) }}</span></td>
                        <td><span class="st-badge-ph stb-{{ $st }}">{{ ucfirst(str_replace('_',' ',$st)) }}</span></td>
                        <td style="font-size:0.82rem;">{{ $ord->date->diffForHumans() }}</td>
                        <td>
                            <div class="ord-actions-ph">
                                <a href="{{ url('/pharmacy/order/'.$ord->id) }}" class="oa-btn view" title="View"><i class="fas fa-eye"></i></a>
                                @if($st == 'pending')
                                    <button type="button" class="oa-btn confirm btn-confirm-order" data-id="{{ $ord->id }}" title="Confirm"><i class="fas fa-check"></i></button>
                                @endif
                                @if($st == 'confirmed')
                                    <button type="button" class="oa-btn process btn-process-order" data-id="{{ $ord->id }}" title="Start Processing"><i class="fas fa-cogs"></i></button>
                                @endif
                                @if(in_array($st, ['pending','confirmed']))
                                    <button type="button" class="oa-btn cancel btn-cancel-order-ph" data-id="{{ $ord->id }}" data-num="#ORD-{{ str_pad($ord->id,4,'0',STR_PAD_LEFT) }}" title="Cancel"><i class="fas fa-times"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-ph">
        <div class="pg-info">Showing <strong>1-{{ count($demoOrders) }}</strong> of <strong>{{ $allC }}</strong> orders</div>
        <div class="pg-btns">
            <a href="#" class="pg-btn"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="pg-btn active">1</a>
            <a href="#" class="pg-btn">2</a>
            <a href="#" class="pg-btn">3</a>
            <a href="#" class="pg-btn"><i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModalPh" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-ph">
            <div class="modal-header modal-header-ph">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusFormPh" action="{{ url('/pharmacy/order/update-status') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" id="modalOrderIdPh">
                <div class="modal-body" style="padding:25px;">
                    @foreach(['confirmed'=>['1976D2','fa-check','Order confirmed, preparing medicines'],'processing'=>['7B1FA2','fa-cogs','Medicines being packed'],'out_for_delivery'=>['C2185B','fa-motorcycle','Handed to delivery partner'],'delivered'=>['2E7D32','fa-check-circle','Order delivered']] as $k=>$d)
                        <div class="status-opt-ph" data-status="{{ $k }}">
                            <input type="radio" name="status" value="{{ $k }}" style="accent-color:var(--primary-green);">
                            <div class="so-ic" style="background:#{{ $d[0] }};"><i class="fas {{ $d[1] }}"></i></div>
                            <div class="so-txt"><strong>{{ ucfirst(str_replace('_',' ',$k)) }}</strong><span>{{ $d[2] }}</span></div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer" style="border:none;padding:15px 25px 25px;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:none;background:var(--pale-green);padding:8px 20px;border-radius:20px;font-size:0.85rem;">Cancel</button>
                    <button type="submit" class="btn-save-dp" style="background:linear-gradient(135deg,var(--primary-green),var(--light-green));color:white;border:none;padding:10px 25px;border-radius:20px;font-weight:700;font-size:0.88rem;cursor:pointer;">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* Stat Filter */
    $('.os-ph').on('click', function () {
        $('.os-ph').removeClass('active');
        $(this).addClass('active');
        var f = $(this).data('filter');
        if (f === 'all') $('tr[data-status]').show();
        else { $('tr[data-status]').hide(); $('tr[data-status="' + f + '"]').show(); }
    });

    /* Search */
    $('#orderSearchPh').on('input', function () {
        var q = $(this).val().toLowerCase();
        $('tbody tr').each(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
        });
    });

    /* Status Filter */
    $('#statusFilterPh').on('change', function () {
        var s = $(this).val();
        if (!s) $('tr[data-status]').show();
        else { $('tr[data-status]').hide(); $('tr[data-status="' + s + '"]').show(); }
    });

    /* Payment Filter */
    $('#paymentFilterPh').on('change', function () {
        var p = $(this).val();
        if (!p) $('tr[data-payment]').show();
        else { $('tr[data-payment]').hide(); $('tr[data-payment="' + p + '"]').show(); }
    });

    /* Confirm Order */
    $('.btn-confirm-order').on('click', function () {
        var id = $(this).data('id');
        if (!confirm('Confirm this order?')) return;
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.post('{{ url("/pharmacy/order/update-status") }}', {
            _token: '{{ csrf_token() }}', order_id: id, status: 'confirmed'
        }).always(function () { location.reload(); });
    });

    /* Process Order */
    $('.btn-process-order').on('click', function () {
        var id = $(this).data('id');
        if (!confirm('Start processing this order?')) return;
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.post('{{ url("/pharmacy/order/update-status") }}', {
            _token: '{{ csrf_token() }}', order_id: id, status: 'processing'
        }).always(function () { location.reload(); });
    });

    /* Cancel Order */
    $('.btn-cancel-order-ph').on('click', function () {
        var id = $(this).data('id');
        var num = $(this).data('num');
        if (!confirm('Cancel order ' + num + '?')) return;
        var $f = $('<form>', { method: 'POST', action: '{{ url("/pharmacy/order/cancel") }}' });
        $f.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
        $f.append('<input type="hidden" name="order_id" value="' + id + '">');
        $('body').append($f); $f.submit();
    });

    /* Status Modal */
    $('.status-opt-ph').on('click', function () {
        $('.status-opt-ph').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

});
</script>
@endsection