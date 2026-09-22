@extends('layouts.delivery')

@section('title', 'Delivery History')
@section('page_title')
<i class="fas fa-history"></i> Delivery History
@endsection

@section('styles')
<style>
    .earnings-header {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 20px; padding: 30px; color: var(--white);
        position: relative; overflow: hidden; margin-bottom: 25px;
    }

    .earnings-header::after {
        content: '\f0d6'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 30px; bottom: -30px;
        font-size: 10rem; opacity: 0.08;
    }

    .earnings-header h4 {
        font-size: 1.5rem; font-weight: 800; margin: 0 0 15px;
    }

    .earnings-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;
        position: relative; z-index: 2;
    }

    .earning-tile {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 12px; padding: 15px; text-align: center;
        backdrop-filter: blur(10px);
    }

    .earning-tile .et-lbl {
        font-size: 0.78rem; opacity: 0.85;
        text-transform: uppercase; letter-spacing: 0.5px;
    }

    .earning-tile .et-val {
        font-size: 1.5rem; font-weight: 800; margin-top: 5px;
    }

    .earning-tile.pending .et-val { color: #FFD54F; }

    /* Filter Bar */
    .history-filter-bar {
        background: var(--white); border-radius: 14px; padding: 15px 20px;
        box-shadow: var(--shadow); margin-bottom: 20px;
        display: flex; gap: 15px; align-items: center; flex-wrap: wrap;
    }

    .filter-input-h {
        padding: 10px 14px; border: 2px solid #E8E8E8;
        border-radius: 10px; font-size: 0.88rem;
        font-family: 'Poppins', sans-serif; outline: none;
        transition: var(--transition);
    }

    .filter-input-h:focus { border-color: var(--primary-green); }

    .filter-select-h {
        padding: 10px 35px 10px 14px; border: 2px solid #E8E8E8;
        border-radius: 10px; font-size: 0.88rem; outline: none;
        background: var(--white); cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat; background-position: right 12px center;
        background-size: 12px; font-family: 'Poppins', sans-serif;
    }

    /* History Table Card */
    .history-card {
        background: var(--white); border-radius: 16px;
        box-shadow: var(--shadow); overflow: hidden;
    }

    .history-header-c {
        padding: 15px 20px; background: var(--off-white);
        border-bottom: 1px solid #E0E0E0;
        display: flex; justify-content: space-between; align-items: center;
    }

    .history-header-c h6 {
        margin: 0; font-weight: 700; color: var(--dark-text);
    }

    .history-header-c h6 i { color: var(--primary-green); margin-right: 6px; }

    .btn-export-h {
        background: transparent; color: var(--primary-green);
        border: 2px solid var(--primary-green);
        padding: 6px 15px; border-radius: 20px;
        font-size: 0.8rem; font-weight: 600;
        cursor: pointer; transition: var(--transition);
        text-decoration: none;
    }

    .btn-export-h:hover {
        background: var(--primary-green); color: var(--white);
    }

    /* Table */
    .history-table {
        width: 100%; margin: 0;
    }

    .history-table thead th {
        background: var(--off-white); color: var(--gray-text);
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; padding: 12px 15px;
        border-bottom: 1px solid #E0E0E0;
    }

    .history-table tbody td {
        padding: 14px 15px; font-size: 0.86rem;
        color: var(--dark-text); vertical-align: middle;
        border-bottom: 1px solid #F5F5F5;
    }

    .history-table tbody tr { transition: var(--transition); }
    .history-table tbody tr:hover { background: var(--off-white); }

    .h-order-id { font-weight: 700; color: var(--primary-green); text-decoration: none; }
    .h-order-id:hover { text-decoration: underline; }

    .h-status-badge {
        display: inline-block; padding: 4px 10px;
        border-radius: 12px; font-size: 0.7rem;
        font-weight: 700; text-transform: uppercase;
    }

    .hst-delivered { background: #E8F5E9; color: #1B5E20; }
    .hst-cancelled { background: #FFEBEE; color: #B71C1C; }

    .h-earning {
        font-weight: 800; color: var(--primary-green); font-size: 0.95rem;
    }

    .h-earning.negative { color: #C62828; }

    /* Empty */
    .empty-h {
        text-align: center; padding: 60px 30px;
    }

    .empty-h i {
        font-size: 4rem; color: var(--mint-green); margin-bottom: 15px;
    }

    .empty-h h5 { color: var(--gray-text); font-weight: 700; }

    /* Pagination */
    .h-pagination {
        padding: 15px 20px; display: flex;
        justify-content: center; gap: 5px;
        border-top: 1px solid #EEE;
    }

    .h-page-btn {
        width: 36px; height: 36px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px; background: var(--white);
        border: 1px solid #E0E0E0; color: var(--dark-text);
        font-size: 0.85rem; cursor: pointer; text-decoration: none;
    }

    .h-page-btn:hover {
        background: var(--pale-green); border-color: var(--primary-green);
        color: var(--primary-green);
    }

    .h-page-btn.active {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); border-color: var(--primary-green);
    }

    @media (max-width: 767px) {
        .earnings-grid { grid-template-columns: 1fr 1fr; }
        .earning-tile .et-val { font-size: 1.2rem; }
        .history-table thead { display: none; }
        .history-table tbody td { padding: 10px; font-size: 0.85rem; }
    }
</style>
@endsection

@section('content')

@php
    $totalEarnings = $totalEarnings ?? 12580;
    $monthEarnings = $monthEarnings ?? 4580;
    $weekEarnings = $weekEarnings ?? 1250;
    $pendingPayout = $pendingPayout ?? 1200;

    $history = $history ?? [
        (object)['id'=>42,'order_id'=>'ORD-0042','customer_name'=>'Ramesh Patil','distance'=>2.5,'items'=>3,'earning'=>45,'status'=>'delivered','date'=>now()->subHours(2)],
        (object)['id'=>41,'order_id'=>'ORD-0041','customer_name'=>'Sunita Sharma','distance'=>3.2,'items'=>5,'earning'=>60,'status'=>'delivered','date'=>now()->subHours(5)],
        (object)['id'=>40,'order_id'=>'ORD-0040','customer_name'=>'Arjun Verma','distance'=>1.8,'items'=>2,'earning'=>40,'status'=>'delivered','date'=>now()->subDays(1)],
        (object)['id'=>39,'order_id'=>'ORD-0039','customer_name'=>'Priya Deshmukh','distance'=>4.5,'items'=>4,'earning'=>55,'status'=>'delivered','date'=>now()->subDays(1)],
        (object)['id'=>38,'order_id'=>'ORD-0038','customer_name'=>'Amit Kulkarni','distance'=>1.2,'items'=>1,'earning'=>0,'status'=>'cancelled','date'=>now()->subDays(2)],
        (object)['id'=>37,'order_id'=>'ORD-0037','customer_name'=>'Neha Joshi','distance'=>3.8,'items'=>6,'earning'=>65,'status'=>'delivered','date'=>now()->subDays(2)],
        (object)['id'=>36,'order_id'=>'ORD-0036','customer_name'=>'Suresh Rao','distance'=>2.1,'items'=>2,'earning'=>40,'status'=>'delivered','date'=>now()->subDays(3)],
        (object)['id'=>35,'order_id'=>'ORD-0035','customer_name'=>'Kavita Menon','distance'=>2.7,'items'=>3,'earning'=>45,'status'=>'delivered','date'=>now()->subDays(3)],
    ];
@endphp

<!-- Earnings Header -->
<div class="earnings-header">
    <h4><i class="fas fa-wallet me-2"></i> Your Earnings Overview</h4>
    <div class="earnings-grid">
        <div class="earning-tile">
            <div class="et-lbl">This Week</div>
            <div class="et-val">₹{{ number_format($weekEarnings) }}</div>
        </div>
        <div class="earning-tile">
            <div class="et-lbl">This Month</div>
            <div class="et-val">₹{{ number_format($monthEarnings) }}</div>
        </div>
        <div class="earning-tile">
            <div class="et-lbl">Total Earned</div>
            <div class="et-val">₹{{ number_format($totalEarnings) }}</div>
        </div>
        <div class="earning-tile pending">
            <div class="et-lbl">Pending Payout</div>
            <div class="et-val">₹{{ number_format($pendingPayout) }}</div>
        </div>
    </div>
</div>

<!-- Filter Bar -->
<div class="history-filter-bar">
    <div style="flex:1;position:relative;">
        <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--primary-green);"></i>
        <input type="text" id="historySearch" class="filter-input-h" placeholder="Search order ID, customer..." style="padding-left:38px;width:100%;">
    </div>
    <select id="historyPeriod" class="filter-select-h">
        <option value="all">All Time</option>
        <option value="today">Today</option>
        <option value="week">This Week</option>
        <option value="month">This Month</option>
    </select>
    <select id="historyStatus" class="filter-select-h">
        <option value="all">All Status</option>
        <option value="delivered">Delivered</option>
        <option value="cancelled">Cancelled</option>
    </select>
</div>

<!-- History Table -->
<div class="history-card">
    <div class="history-header-c">
        <h6><i class="fas fa-list"></i> Delivery Records ({{ count($history) }})</h6>
        <a href="{{ url('/delivery/history/export') }}" class="btn-export-h">
            <i class="fas fa-file-excel me-1"></i> Export
        </a>
    </div>

    @if(count($history) > 0)
        <div class="table-responsive">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date & Time</th>
                        <th>Distance</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th>Earning</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $h)
                        <tr data-status="{{ $h->status }}">
                            <td>
                                <a href="{{ url('/delivery/details/'.$h->id) }}" class="h-order-id">{{ $h->order_id }}</a>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--primary-green),var(--light-green));color:var(--white);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.75rem;">
                                        {{ strtoupper(substr($h->customer_name, 0, 1)) }}
                                    </div>
                                    <span>{{ $h->customer_name }}</span>
                                </div>
                            </td>
                            <td style="font-size:0.82rem;">
                                {{ date('d M Y', strtotime($h->date)) }}<br>
                                <span style="color:var(--gray-text);font-size:0.72rem;">{{ date('h:i A', strtotime($h->date)) }}</span>
                            </td>
                            <td>{{ $h->distance }} km</td>
                            <td>{{ $h->items }}</td>
                            <td>
                                <span class="h-status-badge hst-{{ $h->status }}">{{ ucfirst($h->status) }}</span>
                            </td>
                            <td class="h-earning {{ $h->earning == 0 ? 'negative' : '' }}">
                                {{ $h->earning > 0 ? '+₹'.$h->earning : '₹0' }}
                            </td>
                            <td>
                                <a href="{{ url('/delivery/details/'.$h->id) }}" style="color:var(--primary-green);text-decoration:none;font-weight:600;font-size:0.8rem;">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="h-pagination">
            <a href="#" class="h-page-btn"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="h-page-btn active">1</a>
            <a href="#" class="h-page-btn">2</a>
            <a href="#" class="h-page-btn">3</a>
            <a href="#" class="h-page-btn"><i class="fas fa-chevron-right"></i></a>
        </div>
    @else
        <div class="empty-h">
            <i class="fas fa-clipboard-list"></i>
            <h5>No delivery history yet</h5>
            <p style="color:var(--gray-text);">Your completed deliveries will appear here.</p>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    $('#historySearch').on('input', function () {
        var q = $(this).val().toLowerCase().trim();
        $('.history-table tbody tr').each(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
        });
    });

    $('#historyStatus').on('change', function () {
        var s = $(this).val();
        $('.history-table tbody tr').each(function () {
            if (s === 'all') $(this).show();
            else $(this).toggle($(this).data('status') == s);
        });
    });

    $('#historyPeriod').on('change', function () {
        // In real app, this would AJAX filter or reload
        location.href = '?period=' + $(this).val();
    });

});
</script>
@endsection