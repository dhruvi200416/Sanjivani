<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pharmacy;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Village;

class PharmacyController extends Controller
{
    /* ============================================
       PHARMACY DASHBOARD
    ============================================ */
    public function dashboard()
    {
        $pharmacyId = session('pharmacy_id');

        $totalMedicines = Medicine::where('pharmacy_id', $pharmacyId)->where('status', 'active')->count();
        $totalOrders    = Order::where('pharmacy_id', $pharmacyId)->count();
        $todayRevenue   = Order::where('pharmacy_id', $pharmacyId)
            ->where('order_status', 'delivered')
            ->whereDate('updated_at', today())
            ->sum('total_amount');

        $pendingOrders  = Order::where('pharmacy_id', $pharmacyId)
            ->where('order_status', 'pending')
            ->count();

        $lowStockCount  = Medicine::where('pharmacy_id', $pharmacyId)
            ->where('status', 'active')
            ->where('stock', '<=', 20)
            ->where('stock', '>', 0)
            ->count();

        $totalCustomers = Order::where('pharmacy_id', $pharmacyId)
            ->distinct('customer_id')
            ->count('customer_id');

        $recentOrders = Order::where('pharmacy_id', $pharmacyId)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return (object)[
                    'id'            => $order->id,
                    'customer_name' => $order->customer->name ?? 'Guest User',
                    'items'         => $order->orderItems()->sum('quantity'),
                    'total'         => $order->total_amount,
                    'status'        => $order->order_status,
                    'time'          => $order->created_at->diffForHumans()
                ];
            });

        $lowStockMedicines = Medicine::where('pharmacy_id', $pharmacyId)
            ->where('status', 'active')
            ->where('stock', '<=', 20)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('pharmacy.dashboard', compact(
            'totalMedicines',
            'totalOrders',
            'todayRevenue',
            'pendingOrders',
            'lowStockCount',
            'totalCustomers',
            'recentOrders',
            'lowStockMedicines'
        ));
    }

    /* ============================================
       PHARMACY ORDERS LIST
    ============================================ */
    public function orders(Request $request)
    {
        $query = Order::where('pharmacy_id', session('pharmacy_id'));

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->status) {
            $query->where('order_status', $request->status);
        }

        if ($request->payment) {
            $query->where('payment_method', $request->payment);
        }

        $orders = $query->latest()->get()->map(function ($order) {
            return (object)[
                'id'            => $order->id,
                'customer_name' => $order->customer->name ?? 'Guest',
                'village'       => $order->customer->village->name ?? 'District Area',
                'items'         => $order->orderItems()->sum('quantity'),
                'total'         => $order->total_amount,
                'payment'       => $order->payment_method,
                'status'        => $order->order_status,
                'date'          => $order->created_at
            ];
        });

        return view('pharmacy.orders', compact('orders'));
    }

    /* ============================================
       ORDER DETAILS
    ============================================ */
    public function orderDetails($id)
    {
        $order = Order::where('pharmacy_id', session('pharmacy_id'))
            ->with(['customer.village', 'orderItems'])
            ->findOrFail($id);

        $customer = $order->customer;
        $items    = $order->orderItems;

        return view('pharmacy.order-details', compact('order', 'customer', 'items'));
    }

    /* ============================================
       UPDATE ORDER STATUS
    ============================================ */
    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status'   => 'required|in:confirmed,processing,out_for_delivery,delivered'
        ]);

        $order = Order::where('pharmacy_id', session('pharmacy_id'))->findOrFail($request->order_id);
        $order->update(['order_status' => $request->status]);

        return response()->json(['success' => true]);
    }

    /* ============================================
       CANCEL ORDER
    ============================================ */
    public function cancelOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        $order = Order::where('pharmacy_id', session('pharmacy_id'))->findOrFail($request->order_id);

        // Restore stock
        foreach ($order->orderItems as $item) {
            Medicine::where('id', $item->medicine_id)->increment('stock', $item->quantity);
        }

        $order->update(['order_status' => 'cancelled']);

        return redirect('/pharmacy/orders')->with('success', 'Order marked as cancelled and stock has been restored.');
    }

    /* ============================================
       MEDICINES LIST
    ============================================ */
    public function medicines(Request $request)
    {
        $query = Medicine::where('pharmacy_id', session('pharmacy_id'))->where('status', 'active');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('brand', 'like', "%{$request->search}%");
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->stock === 'in') {
            $query->where('stock', '>', 20);
        } elseif ($request->stock === 'low') {
            $query->whereBetween('stock', [1, 20]);
        } elseif ($request->stock === 'out') {
            $query->where('stock', 0);
        }

        $medicines = $query->latest()->get();

        return view('pharmacy.medicines', compact('medicines'));
    }

    /* ============================================
       ADD / EDIT MEDICINE FORM LOADER
    ============================================ */
    public function addMedicineForm(Request $request)
    {
        $medicine = null;
        if ($request->id) {
            $medicine = Medicine::where('pharmacy_id', session('pharmacy_id'))
                ->findOrFail($request->id);
        }

        return view('pharmacy.add-medicine', compact('medicine'));
    }

    /* ============================================
       SAVE / UPDATE MEDICINE
    ============================================ */
    public function saveMedicine(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:2|max:100',
            'brand'    => 'required|string|max:50',
            'category' => 'required|string',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except(['_token', 'medicine_id', 'image']);
        $data['pharmacy_id'] = session('pharmacy_id');
        $data['featured'] = $request->has('featured') ? 1 : 0;
        $data['prescription_required'] = $request->has('prescription_required') ? 1 : 0;
        $data['status'] = 'active';

        // Custom image upload to public/images/
        if ($request->hasFile('image')) {
            $imageName = 'med_' . time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->medicine_id) {
            $medicine = Medicine::where('pharmacy_id', session('pharmacy_id'))
                ->findOrFail($request->medicine_id);

            // Cleanup old image from public/images/
            if ($request->hasFile('image') && $medicine->image && file_exists(public_path('images/' . $medicine->image))) {
                unlink(public_path('images/' . $medicine->image));
            }

            $medicine->update($data);
            $msg = 'Medicine updated successfully.';
        } else {
            Medicine::create($data);
            $msg = 'Medicine listed successfully.';
        }

        return redirect('/pharmacy/medicines')->with('success', $msg);
    }

    /* ============================================
       DELETE MEDICINE
    ============================================ */
    public function deleteMedicine(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id'
        ]);

        $medicine = Medicine::where('pharmacy_id', session('pharmacy_id'))->findOrFail($request->medicine_id);

        // Delete associated image file
        if ($medicine->image && file_exists(public_path('images/' . $medicine->image))) {
            unlink(public_path('images/' . $medicine->image));
        }

        // Soft deletion
        $medicine->update(['status' => 'inactive']);

        return redirect('/pharmacy/medicines')->with('success', 'Medicine deleted.');
    }

    /* ============================================
       PROFILE SETTINGS (Plain Text Password)
    ============================================ */
    public function profile()
    {
        $pharmacy = Pharmacy::with('village')->findOrFail(session('pharmacy_id'));
        $villages = Village::active()->orderBy('name')->get();

        return view('pharmacy.profile', compact('pharmacy', 'villages'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'pharmacy_name' => 'required|string|min:3|max:100',
            'owner_name'    => 'required|string|min:2|max:50',
            'email'         => 'required|email',
            'phone'         => 'required|digits:10',
            'village_id'    => 'required|exists:villages,id',
            'address'       => 'required|string|min:10|max:300'
        ]);

        $pharmacy = Pharmacy::findOrFail(session('pharmacy_id'));

        $pharmacy->update($request->only([
            'pharmacy_name',
            'owner_name',
            'email',
            'phone',
            'village_id',
            'address'
        ]));

        session(['pharmacy_name' => $pharmacy->pharmacy_name]);

        return back()->with('profile_success', 'Pharmacy profile updated.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed'
        ]);

        $pharmacy = Pharmacy::findOrFail(session('pharmacy_id'));

        // Plain Text Check
        if ($pharmacy->password !== $request->current_password) {
            return back()->with('password_error', 'The provided current password is incorrect.');
        }

        if ($request->new_password === $request->current_password) {
            return back()->with('password_error', 'New password must be different.');
        }

        $pharmacy->update(['password' => $request->new_password]); // Plain Text

        return back()->with('password_success', 'Password updated successfully.');
    }
}
