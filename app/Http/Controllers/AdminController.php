<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Pharmacy;
use App\Models\DeliveryPartner;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\Village;

class AdminController extends Controller
{
    /* ============ DASHBOARD ============ */
    public function dashboard()
    {
        $totalOrders     = Order::count();
        $totalCustomers  = Customer::active()->count();
        $totalPharmacies = Pharmacy::active()->count();
        $pendingOrdersCount = Order::where('order_status', 'pending')->count();
        $lowStockMedicinesCount = Medicine::active()->where('stock', '<', 20)->count();
        $todayRevenue = Order::whereDate('created_at', today())->where('order_status', 'delivered')->sum('total_amount');

        $recentOrders = Order::with(['customer.village'])->latest()->take(8)->get();
        $lowStockMedicines = Medicine::with('pharmacy')->active()->where('stock', '<', 20)->orderBy('stock')->take(5)->get();

        return view('admin.ad_dashboard', compact(
            'totalOrders',
            'totalCustomers',
            'totalPharmacies',
            'pendingOrdersCount',
            'lowStockMedicinesCount',
            'todayRevenue',
            'recentOrders',
            'lowStockMedicines'
        ));
    }

    /* ============ ORDERS ============ */
    public function orders(Request $request)
    {
        $query = Order::with(['customer.village']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($c) use ($request) {
                        $c->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('phone', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->status) {
            $query->where('order_status', $request->status);
        }

        if ($request->payment) {
            $query->where('payment_method', $request->payment);
        }

        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->latest()->paginate(15);

        $totalOrders     = Order::count();
        $pendingCount    = Order::where('order_status', 'pending')->count();
        $processingCount = Order::whereIn('order_status', ['confirmed', 'processing'])->count();
        $deliveredCount  = Order::where('order_status', 'delivered')->count();
        $cancelledCount  = Order::where('order_status', 'cancelled')->count();

        return view('admin.ad_orders', compact(
            'orders',
            'totalOrders',
            'pendingCount',
            'processingCount',
            'deliveredCount',
            'cancelledCount'
        ));
    }

    public function orderDetails($id)
    {
        $order = Order::with(['customer.village', 'orderItems.medicine', 'pharmacy', 'deliveryPartner'])->findOrFail($id);
        $customer = $order->customer;
        $items = $order->orderItems;
        $pharmacy = $order->pharmacy;
        $deliveryPartner = $order->deliveryPartner;

        return view('admin.ad_order-details', compact('order', 'customer', 'items', 'pharmacy', 'deliveryPartner'));
    }

    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status'   => 'required|in:pending,confirmed,processing,out_for_delivery,delivered,cancelled',
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->order_status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated successfully.');
    }

    public function assignDeliveryPartner(Request $request)
    {
        $request->validate([
            'order_id'          => 'required|exists:orders,id',
            'delivery_partner_id' => 'required|exists:delivery_partners,id',
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->delivery_partner_id = $request->delivery_partner_id;
        $order->order_status = 'out_for_delivery';
        $order->save();

        return back()->with('success', 'Delivery partner assigned successfully.');
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->orderItems()->delete();
        $order->delete();

        return back()->with('success', 'Order deleted successfully.');
    }

    public function exportOrders(Request $request)
    {
        $orders = Order::with('customer')->latest()->get();
        $csv = "Order ID,Customer,Email,Phone,Total,Status,Payment,Date\n";

        foreach ($orders as $o) {
            $csv .= "#ORD-{$o->id},{$o->customer->name},{$o->customer->email},{$o->customer->phone},{$o->total_amount},{$o->order_status},{$o->payment_method},{$o->created_at}\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders_export.csv"',
        ]);
    }

    /* ============ MEDICINES ============ */
    public function medicines(Request $request)
    {
        $query = Medicine::with('pharmacy');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->stock === 'in') {
            $query->where('stock', '>', 0);
        } elseif ($request->stock === 'low') {
            $query->whereBetween('stock', [1, 19]);
        } elseif ($request->stock === 'out') {
            $query->where('stock', 0);
        }

        $medicines = $query->latest()->paginate(12);
        $pharmacies = Pharmacy::active()->get();

        return view('admin.ad_medicines', compact('medicines', 'pharmacies'));
    }

    public function saveMedicine(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|min:2',
            'brand'       => 'required|string',
            'category'    => 'required|string',
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');
        $data['featured'] = $request->has('featured') ? 1 : 0;
        $data['prescription_required'] = $request->has('prescription_required') ? 1 : 0;
        $data['status'] = 'active';

        // Image upload to public/images/
        if ($request->hasFile('image')) {
            $filename = 'medicine_' . time() . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        if ($request->medicine_id) {
            $medicine = Medicine::findOrFail($request->medicine_id);
            if (!$request->hasFile('image')) {
                unset($data['image']);
            }
            $medicine->update($data);
            $msg = 'Medicine updated successfully.';
        } else {
            Medicine::create($data);
            $msg = 'Medicine added successfully.';
        }

        return back()->with('success', $msg);
    }

    public function deleteMedicine($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return back()->with('success', 'Medicine deleted successfully.');
    }

    /* ============ PHARMACIES ============ */
    public function pharmacies(Request $request)
    {
        $query = Pharmacy::with('village');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('pharmacy_name', 'like', '%' . $request->search . '%')
                    ->orWhere('owner_name', 'like', '%' . $request->search . '%')
                    ->orWhere('license_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $pharmacies = $query->latest()->paginate(10);
        $villages = Village::active()->get();

        return view('admin.ad_pharmacies', compact('pharmacies', 'villages'));
    }

    public function savePharmacy(Request $request)
    {
        $request->validate([
            'pharmacy_name'  => 'required|string|min:3',
            'owner_name'     => 'required|string|min:2',
            'email'          => 'required|email',
            'phone'          => 'required|digits:10',
            'license_number' => 'required|string|min:5',
            'village_id'     => 'required|exists:villages,id',
            'address'        => 'required|string|min:10',
        ]);

        $data = $request->except('password');

        if ($request->filled('password')) {
            $data['password'] = $request->password; // Plain text
        }

        if ($request->pharmacy_id) {
            $pharmacy = Pharmacy::findOrFail($request->pharmacy_id);
            if (!$request->filled('password')) {
                unset($data['password']);
            }
            $pharmacy->update($data);
            $msg = 'Pharmacy updated successfully.';
        } else {
            $request->validate(['password' => 'required|min:6']);
            $data['password'] = $request->password; // Plain text
            $data['status'] = $request->status ?? 'active';
            Pharmacy::create($data);
            $msg = 'Pharmacy added successfully.';
        }

        return back()->with('success', $msg);
    }

    public function updatePharmacyStatus($id, Request $request)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $pharmacy->status = $request->status;
        $pharmacy->save();

        return back()->with('success', 'Pharmacy status updated to ' . $request->status . '.');
    }

    public function deletePharmacy($id)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $pharmacy->medicines()->delete();
        $pharmacy->delete();

        return back()->with('success', 'Pharmacy deleted successfully.');
    }

    /* ============ DELIVERY PARTNERS ============ */
    public function deliveryPartners(Request $request)
    {
        $query = DeliveryPartner::with('village');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('vehicle_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $partners = $query->latest()->paginate(10);
        $villages = Village::active()->get();

        return view('admin.ad_delivery-partners', compact('partners', 'villages'));
    }

    public function saveDeliveryPartner(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|min:2',
            'email'          => 'required|email',
            'phone'          => 'required|digits:10',
            'aadhar_number'  => 'required|digits:12',
            'vehicle_type'   => 'required|string',
            'vehicle_number' => 'required|string|min:5',
            'village_id'     => 'required|exists:villages,id',
            'address'        => 'required|string|min:10',
        ]);

        $data = $request->except('password');
        $data['vehicle_number'] = strtoupper($data['vehicle_number']);

        if ($request->filled('password')) {
            $data['password'] = $request->password; // Plain text
        }

        if ($request->partner_id) {
            $partner = DeliveryPartner::findOrFail($request->partner_id);
            if (!$request->filled('password')) {
                unset($data['password']);
            }
            $partner->update($data);
            $msg = 'Delivery partner updated.';
        } else {
            $request->validate(['password' => 'required|min:6']);
            $data['password'] = $request->password; // Plain text
            $data['status'] = $request->status ?? 'active';
            DeliveryPartner::create($data);
            $msg = 'Delivery partner added.';
        }

        return back()->with('success', $msg);
    }

    public function updateDeliveryPartnerStatus($id, Request $request)
    {
        $partner = DeliveryPartner::findOrFail($id);
        $partner->status = $request->status;
        $partner->save();

        return back()->with('success', 'Delivery partner status updated.');
    }

    public function deleteDeliveryPartner($id)
    {
        DeliveryPartner::findOrFail($id)->delete();
        return back()->with('success', 'Delivery partner deleted.');
    }

    /* ============ CUSTOMERS / USERS ============ */
    public function users(Request $request)
    {
        $query = Customer::with('village');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $customers = $query->latest()->paginate(15);

        return view('admin.ad_users', compact('customers'));
    }

    public function toggleUserStatus($id, Request $request)
    {
        $customer = Customer::findOrFail($id);
        $customer->status = $request->action === 'block' ? 'inactive' : 'active';
        $customer->save();

        return back()->with('success', 'Customer status updated to ' . $customer->status . '.');
    }

    public function deleteUser($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->cart()->delete();
        $customer->delete();

        return back()->with('success', 'Customer deleted.');
    }

    /* ============ VILLAGES ============ */
    public function villages(Request $request)
    {
        $query = Village::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('district', 'like', '%' . $request->search . '%')
                    ->orWhere('pincode', 'like', '%' . $request->search . '%');
            });
        }

        $villages = $query->orderBy('name')->paginate(12);

        return view('admin.ad_villages', compact('villages'));
    }

    public function saveVillage(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|min:2',
            'district'        => 'required|string',
            'state'           => 'required|string',
            'pincode'         => 'required|digits:6',
            'delivery_charge' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $data['status'] = 'active';

        if ($request->village_id) {
            Village::findOrFail($request->village_id)->update($data);
            $msg = 'Village updated.';
        } else {
            Village::create($data);
            $msg = 'Village added.';
        }

        return back()->with('success', $msg);
    }

    public function deleteVillage($id)
    {
        Village::findOrFail($id)->delete();
        return back()->with('success', 'Village deleted.');
    }

    /* ============ PROFILE ============ */
    public function profile()
    {
        $admin = Admin::findOrFail(session('user_id'));
        $totalOrders = Order::count();
        $totalPharmacies = Pharmacy::active()->count();
        $totalPartners = DeliveryPartner::active()->count();
        $totalCustomers = Customer::active()->count();

        return view('admin.ad_profile', compact('admin', 'totalOrders', 'totalPharmacies', 'totalPartners', 'totalCustomers'));
    }

    public function editProfile()
    {
        $admin = Admin::findOrFail(session('user_id'));
        return view('admin.ad_edit_profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|min:2',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $admin = Admin::findOrFail(session('user_id'));
        $data = $request->except('avatar');

        // Avatar upload to public/images/
        if ($request->hasFile('avatar')) {
            $filename = 'admin_' . time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('images'), $filename);
            $data['avatar'] = $filename;
        }

        $admin->update($data);
        session(['admin_name' => $admin->name]);

        return back()->with('profile_success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $admin = Admin::findOrFail(session('user_id'));

        // Plain text comparison
        if ($admin->password !== $request->current_password) {
            return back()->with('password_error', 'Current password is incorrect.');
        }

        $admin->password = $request->new_password; // Plain text
        $admin->save();

        return back()->with('password_success', 'Password changed successfully.');
    }
}
