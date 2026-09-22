@extends('layouts.admin')

@section('title', 'Manage Customers - Sanjivani Admin')
@section('page_title')
    <i class="fas fa-users"></i> Manage Customers
@endsection

@section('styles')
<style>
    .filter-card { background: var(--white); border-radius: 16px; padding: 20px; box-shadow: var(--shadow); margin-bottom: 20px; }
    .filter-input, .filter-select {
        width: 100%; padding: 10px 14px; border: 2px solid #E8E8E8;
        border-radius: 10px; font-size: 0.88rem; font-family: 'Poppins', sans-serif;
        outline: none; transition: var(--transition);
    }
    .filter-input:focus, .filter-select:focus { border-color: var(--primary-green); box-shadow: 0 0 0 3px rgba(76,175,80,0.1); }
    .filter-select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232E7D32' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat; background-position: right 12px center;
        background-size: 12px; padding-right: 35px; background-color: var(--white);
    }
    .search-wrap { position: relative; }
    .search-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--primary-green); font-size: 0.9rem; }
    .search-wrap input { padding-left: 40px; }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); border: none; padding: 10px 22px; border-radius: 10px;
        font-weight: 600; font-size: 0.88rem; cursor: pointer; transition: var(--transition);
        display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
    }
    .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(46,125,50,0.3); color: var(--white); }

    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
    .stat-mini {
        background: var(--white); border-radius: 14px; padding: 18px;
        box-shadow: var(--shadow); display: flex; align-items: center; gap: 12px;
    }
    .stat-mini .sm-icon {
        width: 45px; height: 45px; min-width: 45px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: var(--white); font-size: 1.1rem;
    }
    .sm-icon.total   { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .sm-icon.new     { background: linear-gradient(135deg, #1565C0, #42A5F5); }
    .sm-icon.orders  { background: linear-gradient(135deg, #7B1FA2, #AB47BC); }
    .sm-icon.revenue { background: linear-gradient(135deg, #E65100, #FFA726); }
    .stat-mini .sm-val { font-size: 1.4rem; font-weight: 800; color: var(--dark-text); line-height: 1; }
    .stat-mini .sm-lbl { font-size: 0.75rem; color: var(--gray-text); }

    .table-card { background: var(--white); border-radius: 16px; box-shadow: var(--shadow); overflow: hidden; }
    .table-header {
        padding: 18px 25px; border-bottom: 1px solid #EEE;
        display: flex; justify-content: space-between; align-items: center;
    }
    .table-header h6 { font-weight: 700; color: var(--dark-text); margin: 0; }
    .table-header h6 span {
        background: var(--pale-green); color: var(--primary-green);
        padding: 3px 10px; border-radius: 15px; font-size: 0.75rem; margin-left: 8px;
    }

    .users-table { width: 100%; margin: 0; }
    .users-table thead th {
        background: var(--off-white); color: var(--gray-text);
        font-size: 0.76rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; padding: 14px 20px; border-bottom: 1px solid #E0E0E0;
    }
    .users-table tbody td {
        padding: 14px 20px; font-size: 0.87rem; color: var(--dark-text);
        vertical-align: middle; border-bottom: 1px solid #F5F5F5;
    }
    .users-table tbody tr { transition: var(--transition); }
    .users-table tbody tr:hover { background: var(--off-white); }

    .cust-cell { display: flex; align-items: center; gap: 12px; }
    .cust-avatar {
        width: 42px; height: 42px; min-width: 42px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); display: flex; align-items: center; justify-content: center;
        font-size: 1rem; font-weight: 700;
    }
    .cust-cell .cname { font-weight: 600; font-size: 0.9rem; display: block; }
    .cust-cell .cemail { font-size: 0.75rem; color: var(--gray-text); }

    .status-active { background: #E8F5E9; color: #2E7D32; padding: 4px 12px; border-radius: 15px; font-size: 0.72rem; font-weight: 700; }
    .status-blocked { background: #FFEBEE; color: #C62828; padding: 4px 12px; border-radius: 15px; font-size: 0.72rem; font-weight: 700; }

    .cust-actions { display: flex; gap: 6px; }
    .c-action-btn {
        width: 34px; height: 34px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        color: var(--white); border: none; cursor: pointer;
        transition: var(--transition); font-size: 0.8rem; text-decoration: none;
    }
    .c-action-btn.view { background: linear-gradient(135deg, #1976D2, #42A5F5); }
    .c-action-btn.block { background: linear-gradient(135deg, #E65100, #FFA726); }
    .c-action-btn.unblock { background: linear-gradient(135deg, #2E7D32, #66BB6A); }
    .c-action-btn.delete { background: linear-gradient(135deg, #C62828, #EF5350); }
    .c-action-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.15); color: var(--white); }

    .modal-content-custom { border: none; border-radius: 18px; overflow: hidden; }
    .modal-header-custom {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white); padding: 18px 25px; border: none;
    }
    .modal-header-custom .btn-close { filter: brightness(0) invert(1); }

    @media (max-width: 767px) {
        .stat-row { grid-template-columns: 1fr 1fr; }
        .users-table thead { display: none; }
        .users-table tbody td { padding: 10px 15px; font-size: 0.85rem; }
    }
</style>
@endsection

@section('content')

@php
    // Get the actual items (Collection) from the paginator
    $customersCollection = $customers ?? collect();
    if ($customersCollection instanceof \Illuminate\Pagination\LengthAwarePaginator) {
        $customersCollection = $customersCollection->getCollection();
    }

    // If no real data, use demo data (wrapped in a Collection)
    if ($customersCollection->isEmpty()) {
        $demoCustomers = collect([
            (object)['id'=>1,'name'=>'Ramesh Patil','email'=>'ramesh@example.com','phone'=>'9876543210','village'=>(object)['name'=>'Nashik'],'address'=>'House 45, Gandhi Road','status'=>'active','total_orders'=>12,'total_spent'=>4560,'created_at'=>now()->subMonths(6)],
            (object)['id'=>2,'name'=>'Sunita Sharma','email'=>'sunita@example.com','phone'=>'9812345678','village'=>(object)['name'=>'Pune'],'address'=>'Flat 202, Green Villa','status'=>'active','total_orders'=>28,'total_spent'=>12340,'created_at'=>now()->subMonths(9)],
            (object)['id'=>3,'name'=>'Arjun Verma','email'=>'arjun@example.com','phone'=>'9998887771','village'=>(object)['name'=>'Jaipur'],'address'=>'12 MG Road','status'=>'active','total_orders'=>5,'total_spent'=>1890,'created_at'=>now()->subMonths(2)],
            (object)['id'=>4,'name'=>'Priya Deshmukh','email'=>'priya@example.com','phone'=>'9765432109','village'=>(object)['name'=>'Aurangabad'],'address'=>'Sai Nagar, Plot 78','status'=>'active','total_orders'=>15,'total_spent'=>6780,'created_at'=>now()->subMonths(4)],
            (object)['id'=>5,'name'=>'Amit Kulkarni','email'=>'amit@example.com','phone'=>'9871122334','village'=>(object)['name'=>'Kolhapur'],'address'=>'Shivaji Road','status'=>'blocked','total_orders'=>2,'total_spent'=>450,'created_at'=>now()->subMonths(1)],
            (object)['id'=>6,'name'=>'Neha Joshi','email'=>'neha@example.com','phone'=>'9822334455','village'=>(object)['name'=>'Nagpur'],'address'=>'Ring Road, 456','status'=>'active','total_orders'=>19,'total_spent'=>8920,'created_at'=>now()->subMonths(7)],
            (object)['id'=>7,'name'=>'Suresh Rao','email'=>'suresh@example.com','phone'=>'9776655443','village'=>(object)['name'=>'Solapur'],'address'=>'Bank Colony','status'=>'active','total_orders'=>7,'total_spent'=>2340,'created_at'=>now()->subMonths(3)],
            (object)['id'=>8,'name'=>'Kavita Menon','email'=>'kavita@example.com','phone'=>'9665544332','village'=>(object)['name'=>'Satara'],'address'=>'Station Road','status'=>'active','total_orders'=>11,'total_spent'=>4520,'created_at'=>now()->subMonths(5)],
        ]);
    } else {
        $demoCustomers = $customersCollection;
    }

    $totalCount   = $demoCustomers->count();
    $activeCount  = $demoCustomers->filter(fn($c) => $c->status == 'active')->count();
    $totalOrders  = $demoCustomers->sum('total_orders');
    $totalRevenue = $demoCustomers->sum('total_spent');
@endphp

<div class="stat-row" data-aos="fade-up">
    <div class="stat-mini">
        <div class="sm-icon total"><i class="fas fa-users"></i></div>
        <div><div class="sm-val">{{ $totalCount }}</div><div class="sm-lbl">Total Customers</div></div>
    </div>
    <div class="stat-mini">
        <div class="sm-icon new"><i class="fas fa-user-check"></i></div>
        <div><div class="sm-val">{{ $activeCount }}</div><div class="sm-lbl">Active</div></div>
    </div>
    <div class="stat-mini">
        <div class="sm-icon orders"><i class="fas fa-shopping-cart"></i></div>
        <div><div class="sm-val">{{ $totalOrders }}</div><div class="sm-lbl">Total Orders</div></div>
    </div>
    <div class="stat-mini">
        <div class="sm-icon revenue"><i class="fas fa-rupee-sign"></i></div>
        <div><div class="sm-val">₹{{ number_format($totalRevenue) }}</div><div class="sm-lbl">Total Revenue</div></div>
    </div>
</div>

<div class="filter-card" data-aos="fade-up">
    <form method="GET" action="{{ url('/admin/users') }}">
        <div class="row g-3 align-items-end">
            <div class="col-lg-6 col-md-6">
                <label style="font-size:0.78rem;font-weight:600;color:var(--dark-text);text-transform:uppercase;margin-bottom:6px;display:block;"><i class="fas fa-search me-1"></i> Search</label>
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="filter-input" placeholder="Name, email, phone..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <label style="font-size:0.78rem;font-weight:600;color:var(--dark-text);text-transform:uppercase;margin-bottom:6px;display:block;"><i class="fas fa-filter me-1"></i> Status</label>
                <select name="status" class="filter-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                    <option value="blocked" {{ request('status')=='blocked' ? 'selected' : '' }}>Blocked</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <button type="submit" class="btn-primary-custom w-100 justify-content-center">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
            </div>
        </div>
    </form>
</div>

<div class="table-card" data-aos="fade-up">
    <div class="table-header">
        <h6><i class="fas fa-users me-2" style="color:var(--primary-green);"></i> All Customers <span>{{ $totalCount }}</span></h6>
        <a href="#" class="btn-primary-custom" style="background:transparent;color:var(--primary-green);border:2px solid var(--primary-green);padding:7px 18px;font-size:0.82rem;">
            <i class="fas fa-file-excel"></i> Export CSV
        </a>
    </div>

    <div class="table-responsive">
        <table class="users-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Village</th>
                    <th>Orders</th>
                    <th>Spent</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demoCustomers as $i => $c)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div class="cust-cell">
                                <div class="cust-avatar">{{ strtoupper(substr($c->name, 0, 1)) }}</div>
                                <div>
                                    <span class="cname">{{ $c->name }}</span>
                                    <span class="cemail">{{ $c->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td><a href="tel:{{ $c->phone }}" style="color:var(--primary-green);text-decoration:none;">{{ $c->phone }}</a></td>
                        <td><i class="fas fa-map-marker-alt me-1" style="color:#E53935;font-size:0.75rem;"></i> {{ $c->village->name ?? 'N/A' }}</td>
                        <td><span style="background:var(--pale-green);color:var(--primary-green);padding:3px 10px;border-radius:15px;font-weight:600;font-size:0.78rem;">{{ $c->total_orders }}</span></td>
                        <td style="font-weight:700;color:var(--primary-green);">₹{{ number_format($c->total_spent, 2) }}</td>
                        <td style="font-size:0.82rem;">{{ date('d M Y', strtotime($c->created_at)) }}</td>
                        <td>
                            <span class="{{ $c->status == 'active' ? 'status-active' : 'status-blocked' }}">
                                {{ ucfirst($c->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="cust-actions">
                                <button type="button" class="c-action-btn view btn-view-cust" data-c='@json($c)' title="View"><i class="fas fa-eye"></i></button>
                                @if($c->status == 'active')
                                    <button type="button" class="c-action-btn block btn-toggle-cust" data-id="{{ $c->id }}" data-action="block" data-name="{{ $c->name }}" title="Block"><i class="fas fa-ban"></i></button>
                                @else
                                    <button type="button" class="c-action-btn unblock btn-toggle-cust" data-id="{{ $c->id }}" data-action="unblock" data-name="{{ $c->name }}" title="Unblock"><i class="fas fa-check"></i></button>
                                @endif
                                <button type="button" class="c-action-btn delete btn-delete-cust" data-id="{{ $c->id }}" data-name="{{ $c->name }}" title="Delete"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- View Customer Modal -->
<div class="modal fade" id="viewCustModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title"><i class="fas fa-user me-2"></i> Customer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:25px;" id="viewCustContent"></div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    $('.btn-view-cust').on('click', function () {
        var c = $(this).data('c');
        var html = `
            <div class="text-center mb-4">
                <div class="cust-avatar" style="width:80px;height:80px;font-size:2rem;margin:0 auto 12px;">${c.name.charAt(0).toUpperCase()}</div>
                <h4 style="color:var(--dark-text);font-weight:700;margin:0;">${c.name}</h4>
                <p style="color:var(--gray-text);margin:5px 0;">${c.email}</p>
                <span class="${c.status == 'active' ? 'status-active' : 'status-blocked'}">${c.status.toUpperCase()}</span>
            </div>
            <div class="row g-3">
                <div class="col-md-6"><strong style="color:var(--primary-green);">Phone:</strong><br><a href="tel:${c.phone}">${c.phone}</a></div>
                <div class="col-md-6"><strong style="color:var(--primary-green);">Village:</strong><br>${c.village ? c.village.name : 'N/A'}</div>
                <div class="col-12"><strong style="color:var(--primary-green);">Address:</strong><br>${c.address}</div>
                <div class="col-md-4"><strong style="color:var(--primary-green);">Total Orders:</strong><br>${c.total_orders}</div>
                <div class="col-md-4"><strong style="color:var(--primary-green);">Total Spent:</strong><br>₹${Number(c.total_spent).toLocaleString('en-IN')}</div>
                <div class="col-md-4"><strong style="color:var(--primary-green);">Member Since:</strong><br>${new Date(c.created_at).toLocaleDateString('en-IN', {year:'numeric',month:'short',day:'numeric'})}</div>
            </div>
        `;
        $('#viewCustContent').html(html);
        $('#viewCustModal').modal('show');
    });

    $('.btn-toggle-cust').on('click', function () {
        var id = $(this).data('id'); var action = $(this).data('action'); var name = $(this).data('name');
        if (confirm('Are you sure you want to ' + action + ' "' + name + '"?')) {
            var $form = $('<form>', { method: 'POST', action: '{{ url("/admin/user/toggle-status") }}/' + id });
            $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            $form.append('<input type="hidden" name="action" value="' + action + '">');
            $('body').append($form); $form.submit();
        }
    });

    $('.btn-delete-cust').on('click', function () {
        var id = $(this).data('id'); var name = $(this).data('name');
        if (confirm('⚠ Are you sure you want to delete "' + name + '"?\nAll their orders will remain but the customer profile will be removed.')) {
            var $form = $('<form>', { method: 'POST', action: '{{ url("/admin/user/delete") }}/' + id });
            $form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
            $form.append('<input type="hidden" name="_method" value="DELETE">');
            $('body').append($form); $form.submit();
        }
    });

});
</script>
@endsection