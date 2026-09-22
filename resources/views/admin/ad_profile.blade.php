@extends('layouts.admin')

@section('title', 'My Profile - Sanjivani Admin')
@section('page_title')
    <i class="fas fa-user-circle"></i> My Profile
@endsection

@section('styles')
<style>
    .profile-header-card {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        border-radius: 20px; padding: 40px 30px; color: var(--white);
        position: relative; overflow: hidden; margin-bottom: 25px;
    }
    .profile-header-card::before {
        content: ''; position: absolute; top: -100px; right: -100px;
        width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%;
    }
    .profile-header-card::after {
        content: '\f508'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 20px; bottom: -30px;
        font-size: 10rem; opacity: 0.08;
    }

    .profile-header-inner {
        display: flex; align-items: center; gap: 25px;
        position: relative; z-index: 2;
    }

    .profile-avatar-big {
        width: 110px; height: 110px; border-radius: 50%;
        background: var(--white); color: var(--primary-green);
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; font-weight: 800;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        border: 5px solid rgba(255,255,255,0.3);
    }

    .profile-header-info h2 { font-size: 2rem; font-weight: 800; margin: 0 0 5px; }
    .profile-header-info .role {
        background: rgba(255,255,255,0.2); padding: 4px 15px;
        border-radius: 20px; font-size: 0.8rem; font-weight: 600;
        display: inline-block; margin-bottom: 10px;
    }
    .profile-header-info .meta { display: flex; gap: 20px; flex-wrap: wrap; }
    .profile-header-info .meta span { font-size: 0.88rem; opacity: 0.9; }
    .profile-header-info .meta span i { margin-right: 5px; }

    .edit-profile-btn {
        margin-left: auto; background: var(--white); color: var(--primary-green);
        padding: 12px 25px; border-radius: 25px; font-weight: 700;
        font-size: 0.9rem; text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        transition: var(--transition); border: none;
    }
    .edit-profile-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.25); color: var(--dark-green); }

    .info-block {
        background: var(--white); border-radius: 16px; padding: 25px;
        box-shadow: var(--shadow); margin-bottom: 20px;
    }

    .info-block h6 {
        font-size: 1rem; font-weight: 700; color: var(--dark-text);
        margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px dashed var(--pale-green);
    }
    .info-block h6 i { color: var(--primary-green); margin-right: 8px; }

    .info-item {
        display: flex; gap: 15px; align-items: flex-start;
        padding: 12px 0; border-bottom: 1px solid #F5F5F5;
    }
    .info-item:last-child { border-bottom: none; }

    .info-item .info-ico {
        width: 40px; height: 40px; min-width: 40px; border-radius: 10px;
        background: var(--pale-green); color: var(--primary-green);
        display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
    }

    .info-item .info-txt { flex: 1; }
    .info-item .info-txt .lbl {
        font-size: 0.72rem; color: var(--gray-text); text-transform: uppercase;
        font-weight: 600; letter-spacing: 0.5px; margin-bottom: 3px;
    }
    .info-item .info-txt .val {
        font-size: 0.95rem; color: var(--dark-text); font-weight: 500;
    }

    .activity-stat {
        background: var(--white); border-radius: 14px; padding: 20px;
        box-shadow: var(--shadow); text-align: center; transition: var(--transition);
    }
    .activity-stat:hover { transform: translateY(-3px); }
    .activity-stat .ast-icon {
        width: 55px; height: 55px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        color: var(--white); font-size: 1.3rem; margin: 0 auto 12px;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
    }
    .activity-stat .ast-val { font-size: 1.6rem; font-weight: 800; color: var(--dark-text); }
    .activity-stat .ast-lbl { font-size: 0.8rem; color: var(--gray-text); }
</style>
@endsection

@section('content')

@php
    $admin = $admin ?? (object)[
        'name' => session('admin_name') ?? 'Admin User',
        'email' => 'admin@sanjivani.com',
        'phone' => '9876543210',
        'address' => '123 Health Street, Medical Plaza, Mumbai',
        'created_at' => now()->subYears(3),
        'last_login' => now()->subHours(2),
    ];
@endphp

<div class="profile-header-card" data-aos="fade-down">
    <div class="profile-header-inner">
        <div class="profile-avatar-big">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
        <div class="profile-header-info">
            <h2>{{ $admin->name }}</h2>
            <span class="role"><i class="fas fa-shield-halved me-1"></i> Administrator</span>
            <div class="meta">
                <span><i class="fas fa-envelope"></i> {{ $admin->email }}</span>
                <span><i class="fas fa-phone"></i> {{ $admin->phone }}</span>
                <span><i class="fas fa-calendar"></i> Joined {{ date('M Y', strtotime($admin->created_at)) }}</span>
            </div>
        </div>
        <a href="{{ url('/admin/edit-profile') }}" class="edit-profile-btn">
            <i class="fas fa-edit"></i> Edit Profile
        </a>
    </div>
</div>

<!-- Activity Stats -->
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-md-3 col-6">
        <div class="activity-stat">
            <div class="ast-icon" style="background:linear-gradient(135deg,#2E7D32,#66BB6A);"><i class="fas fa-shopping-cart"></i></div>
            <div class="ast-val">{{ $totalOrders ?? 128 }}</div>
            <div class="ast-lbl">Orders Managed</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="activity-stat">
            <div class="ast-icon" style="background:linear-gradient(135deg,#1565C0,#42A5F5);"><i class="fas fa-store"></i></div>
            <div class="ast-val">{{ $totalPharmacies ?? 152 }}</div>
            <div class="ast-lbl">Pharmacies Verified</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="activity-stat">
            <div class="ast-icon" style="background:linear-gradient(135deg,#E65100,#FFA726);"><i class="fas fa-motorcycle"></i></div>
            <div class="ast-val">{{ $totalPartners ?? 45 }}</div>
            <div class="ast-lbl">Delivery Partners</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="activity-stat">
            <div class="ast-icon" style="background:linear-gradient(135deg,#7B1FA2,#AB47BC);"><i class="fas fa-users"></i></div>
            <div class="ast-val">{{ $totalCustomers ?? 5240 }}</div>
            <div class="ast-lbl">Total Customers</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="info-block" data-aos="fade-up">
            <h6><i class="fas fa-id-card"></i> Personal Information</h6>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-ico"><i class="fas fa-user"></i></div>
                        <div class="info-txt">
                            <div class="lbl">Full Name</div>
                            <div class="val">{{ $admin->name }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-ico"><i class="fas fa-envelope"></i></div>
                        <div class="info-txt">
                            <div class="lbl">Email Address</div>
                            <div class="val">{{ $admin->email }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-ico"><i class="fas fa-phone"></i></div>
                        <div class="info-txt">
                            <div class="lbl">Mobile Number</div>
                            <div class="val">{{ $admin->phone }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-ico"><i class="fas fa-shield-halved"></i></div>
                        <div class="info-txt">
                            <div class="lbl">Account Role</div>
                            <div class="val">Administrator (Super User)</div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="info-item">
                        <div class="info-ico"><i class="fas fa-home"></i></div>
                        <div class="info-txt">
                            <div class="lbl">Address</div>
                            <div class="val">{{ $admin->address }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="info-block" data-aos="fade-up" data-aos-delay="100">
            <h6><i class="fas fa-history"></i> Account Activity</h6>

            <div class="info-item">
                <div class="info-ico"><i class="fas fa-calendar-check"></i></div>
                <div class="info-txt">
                    <div class="lbl">Member Since</div>
                    <div class="val">{{ date('d M Y', strtotime($admin->created_at)) }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-ico"><i class="fas fa-clock"></i></div>
                <div class="info-txt">
                    <div class="lbl">Last Login</div>
                    <div class="val">{{ date('d M Y, h:i A', strtotime($admin->last_login)) }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-ico" style="background:#E8F5E9;color:#2E7D32;"><i class="fas fa-check-circle"></i></div>
                <div class="info-txt">
                    <div class="lbl">Account Status</div>
                    <div class="val" style="color:#2E7D32;font-weight:700;">Active & Verified</div>
                </div>
            </div>
        </div>

        <div class="info-block" data-aos="fade-up" data-aos-delay="150">
            <h6><i class="fas fa-cog"></i> Quick Actions</h6>

            <a href="{{ url('/admin/edit-profile') }}" class="btn-primary-custom w-100 justify-content-center mb-2" style="background:linear-gradient(135deg,#1976D2,#42A5F5);color:white;border:none;padding:11px 22px;border-radius:10px;font-weight:600;font-size:0.88rem;display:flex;align-items:center;gap:6px;text-decoration:none;">
                <i class="fas fa-edit"></i> Edit Profile
            </a>
            <a href="{{ url('/admin/edit-profile#password') }}" class="btn-primary-custom w-100 justify-content-center mb-2" style="background:linear-gradient(135deg,#E65100,#FFA726);color:white;border:none;padding:11px 22px;border-radius:10px;font-weight:600;font-size:0.88rem;display:flex;align-items:center;gap:6px;text-decoration:none;">
                <i class="fas fa-key"></i> Change Password
            </a>
            <a href="{{ url('/logout') }}" class="btn-primary-custom w-100 justify-content-center" style="background:linear-gradient(135deg,#C62828,#EF5350);color:white;border:none;padding:11px 22px;border-radius:10px;font-weight:600;font-size:0.88rem;display:flex;align-items:center;gap:6px;text-decoration:none;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</div>

@endsection