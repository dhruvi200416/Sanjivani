<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Medicine;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Prescription;
use App\Models\MedicineReview;
use App\Models\HomeContent;
use App\Models\AboutContent;
use App\Models\ContactMessage;
use App\Models\Village;
use App\Models\Pharmacy;

class CustomerController extends Controller
{
    /* ============================================
       PUBLIC PAGES (No Auth Required)
    ============================================ */

    public function home()
    {
        $home = HomeContent::active()->first();

        $featuredMedicines = Medicine::active()
            ->with('pharmacy')
            ->where('featured', true)
            ->latest()
            ->take(8)
            ->get();

        if ($featuredMedicines->count() == 0) {
            $featuredMedicines = Medicine::active()
                ->with('pharmacy')
                ->latest()
                ->take(8)
                ->get();
        }

        $categories = Medicine::active()
            ->select('category')
            ->selectRaw('count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(12)
            ->get();

        $totalCustomers  = Customer::where('status', 'active')->count();
        $totalPharmacies = Pharmacy::where('status', 'active')->count();
        $totalMedicines  = Medicine::where('status', 'active')->count();
        $totalOrders     = Order::count();

        return view('home', compact(
            'home',
            'featuredMedicines',
            'categories',
            'totalCustomers',
            'totalPharmacies',
            'totalMedicines',
            'totalOrders'
        ));
    }

    public function about()
    {
        $about = AboutContent::active()->first();

        $totalCustomers  = Customer::where('status', 'active')->count();
        $totalPharmacies = Pharmacy::where('status', 'active')->count();
        $totalVillages   = Village::where('status', 'active')->count();

        return view('about', compact('about', 'totalCustomers', 'totalPharmacies', 'totalVillages'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendContactMessage(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|min:2|max:50',
            'email'   => 'required|email',
            'phone'   => 'required|digits:10',
            'subject' => 'required|string|min:3|max:150',
            'message' => 'required|string|min:10|max:500',
        ]);

        ContactMessage::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status'  => 'active',
        ]);

        return back()->with('success', 'Your message has been sent successfully! We will get back to you within 24 hours.');
    }

    /* ============================================
       CUSTOMER DASHBOARD
    ============================================ */

    public function dashboard()
    {
        $customerId = session('user_id');

        $totalOrders      = Order::where('customer_id', $customerId)->count();
        $pendingOrders    = Order::where('customer_id', $customerId)
            ->whereIn('order_status', ['pending', 'confirmed', 'processing'])
            ->count();
        $deliveredOrders  = Order::where('customer_id', $customerId)
            ->where('order_status', 'delivered')
            ->count();
        $totalSpent       = Order::where('customer_id', $customerId)
            ->where('order_status', 'delivered')
            ->sum('total_amount');

        $recentOrders = Order::where('customer_id', $customerId)
            ->latest()
            ->take(5)
            ->get();

        $featuredMedicines = Medicine::active()
            ->where('featured', true)
            ->latest()
            ->take(4)
            ->get();

        return view('customer.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'deliveredOrders',
            'totalSpent',
            'recentOrders',
            'featuredMedicines'
        ));
    }

    /* ============================================
       MEDICINES CATALOG
    ============================================ */

    public function medicinesCatalog(Request $request)
    {
        $query = Medicine::active()->with('pharmacy');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->in_stock) {
            $query->where('stock', '>', 0);
        }

        if ($request->featured) {
            $query->where('featured', true);
        }

        if ($request->rx === '0') {
            $query->where('prescription_required', false);
        } elseif ($request->rx === '1') {
            $query->where('prescription_required', true);
        }

        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->latest();
        }

        $medicines = $query->paginate(12);

        return view('customer.medicines', compact('medicines'));
    }

    /* ============================================
       MEDICINE DETAILS
    ============================================ */

    public function medicineDetails($id)
    {
        $medicine = Medicine::active()->with('pharmacy')->findOrFail($id);

        $reviews = MedicineReview::active()
            ->where('medicine_id', $id)
            ->with('customer')
            ->latest()
            ->take(10)
            ->get();

        $avgRating = MedicineReview::active()
            ->where('medicine_id', $id)
            ->avg('rating') ?? 4.5;

        $totalReviews = MedicineReview::active()
            ->where('medicine_id', $id)
            ->count();

        $relatedMedicines = Medicine::active()
            ->where('category', $medicine->category)
            ->where('id', '!=', $id)
            ->take(6)
            ->get();

        return view('customer.medicine-details', compact(
            'medicine',
            'reviews',
            'avgRating',
            'totalReviews',
            'relatedMedicines'
        ));
    }

    /* ============================================
       SHOPPING CART
    ============================================ */

    public function cart()
    {
        $customerId = session('user_id');

        $cartItems = Cart::where('customer_id', $customerId)
            ->with('medicine')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'id'          => $item->id,
                    'medicine_id' => $item->medicine_id,
                    'name'        => $item->medicine->name ?? 'Unknown',
                    'brand'       => $item->medicine->brand ?? '',
                    'category'    => $item->medicine->category ?? '',
                    'price'       => $item->unit_price,
                    'mrp'         => $item->medicine->mrp ?? $item->unit_price,
                    'quantity'    => $item->quantity,
                    'stock'       => $item->medicine->stock ?? 0,
                    'image'       => $item->medicine->image ?? null,
                ];
            });

        // Update cart count in session
        session(['cart_count' => $cartItems->sum('quantity')]);

        return view('customer.cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity'    => 'integer|min:1',
        ]);

        $customerId = session('user_id');
        $medicineId = $request->medicine_id;
        $quantity   = $request->quantity ?? 1;

        $medicine = Medicine::active()->findOrFail($medicineId);

        if ($medicine->stock <= 0) {
            return response()->json(['success' => false, 'message' => 'Medicine is out of stock.']);
        }

        $existing = Cart::where('customer_id', $customerId)
            ->where('medicine_id', $medicineId)
            ->first();

        if ($existing) {
            $newQty = $existing->quantity + $quantity;
            if ($newQty > $medicine->stock) {
                return response()->json(['success' => false, 'message' => 'Not enough stock available.']);
            }
            $existing->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'customer_id' => $customerId,
                'medicine_id' => $medicineId,
                'quantity'    => $quantity,
                'unit_price'  => $medicine->price,
            ]);
        }

        $cartCount = Cart::where('customer_id', $customerId)->sum('quantity');
        session(['cart_count' => $cartCount]);

        return response()->json([
            'success'    => true,
            'message'    => 'Added to cart!',
            'cart_count' => $cartCount,
        ]);
    }

    public function updateCartQuantity(Request $request)
    {
        $request->validate([
            'cart_id'  => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('customer_id', session('user_id'))
            ->findOrFail($request->cart_id);

        $medicine = Medicine::findOrFail($cart->medicine_id);

        if ($request->quantity > $medicine->stock) {
            return response()->json(['success' => false, 'message' => 'Not enough stock.']);
        }

        $cart->update(['quantity' => $request->quantity]);

        $cartCount = Cart::where('customer_id', session('user_id'))->sum('quantity');
        session(['cart_count' => $cartCount]);

        return response()->json(['success' => true, 'cart_count' => $cartCount]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate(['cart_id' => 'required|exists:carts,id']);

        Cart::where('customer_id', session('user_id'))
            ->where('id', $request->cart_id)
            ->delete();

        $cartCount = Cart::where('customer_id', session('user_id'))->sum('quantity');
        session(['cart_count' => $cartCount]);

        return response()->json(['success' => true, 'cart_count' => $cartCount]);
    }

    public function clearCart()
    {
        Cart::where('customer_id', session('user_id'))->delete();
        session(['cart_count' => 0, 'cart_coupon_code' => null, 'cart_coupon_discount' => 0]);

        return redirect('/customer/cart')->with('success', 'Cart cleared.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);

        $code = strtoupper(trim($request->coupon_code));

        $coupons = [
            'SANJIVANI10' => ['discount' => 100, 'min' => 300],
            'HEALTH50'    => ['discount' => 50,  'min' => 500],
            'NEWUSER100'  => ['discount' => 100, 'min' => 200],
        ];

        if (!isset($coupons[$code])) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.']);
        }

        $subtotal = Cart::where('customer_id', session('user_id'))
            ->sum(\DB::raw('quantity * unit_price'));

        if ($subtotal < $coupons[$code]['min']) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order ₹' . $coupons[$code]['min'] . ' required for this coupon.',
            ]);
        }

        session([
            'cart_coupon_code'     => $code,
            'cart_coupon_discount' => $coupons[$code]['discount'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied! You saved ₹' . $coupons[$code]['discount'],
        ]);
    }

    public function removeCoupon()
    {
        session(['cart_coupon_code' => null, 'cart_coupon_discount' => 0]);
        return redirect('/customer/cart')->with('success', 'Coupon removed.');
    }

    /* ============================================
       CHECKOUT & ORDERS
    ============================================ */

    public function checkout()
    {
        $customerId = session('user_id');
        $customer   = Customer::findOrFail($customerId);

        $cartItems = Cart::where('customer_id', $customerId)
            ->with('medicine')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'id'                    => $item->id,
                    'medicine_id'           => $item->medicine_id,
                    'name'                  => $item->medicine->name ?? 'Unknown',
                    'brand'                 => $item->medicine->brand ?? '',
                    'price'                 => $item->unit_price,
                    'mrp'                   => $item->medicine->mrp ?? $item->unit_price,
                    'quantity'              => $item->quantity,
                    'image'                 => $item->medicine->image ?? null,
                    'prescription_required' => $item->medicine->prescription_required ?? false,
                ];
            });

        if ($cartItems->count() == 0) {
            return redirect('/customer/cart')->with('error', 'Your cart is empty.');
        }

        $addresses = \DB::table('customers')
            ->where('id', $customerId)
            ->first();

        $addresses = collect([(object)[
            'id'           => 1,
            'name'         => $customer->name,
            'phone'        => $customer->phone,
            'address_line' => $customer->address,
            'landmark'     => '',
            'city'         => $customer->village ? $customer->village->name : '',
            'state'        => 'Maharashtra',
            'pincode'      => '',
            'type'         => 'home',
            'is_default'   => 1,
        ]]);

        $villages = Village::active()->orderBy('name')->get();

        return view('customer.checkout', compact('cartItems', 'customer', 'addresses', 'villages'));
    }

    public function placeOrder(Request $request)
    {
        $customerId = session('user_id');

        $cartItems = Cart::where('customer_id', $customerId)->with('medicine')->get();

        if ($cartItems->count() == 0) {
            return redirect('/customer/cart')->with('error', 'Cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->unit_price);
        $deliveryFee = $subtotal >= 500 ? 0 : 50;
        $tax = round($subtotal * 0.05, 2);
        $discount = session('cart_coupon_discount', 0);
        $total = $subtotal + $deliveryFee + $tax - $discount;

        // Get first active pharmacy for demo
        $pharmacy = Pharmacy::where('status', 'active')->first();

        $order = Order::create([
            'customer_id'    => $customerId,
            'pharmacy_id'    => $pharmacy ? $pharmacy->id : null,
            'subtotal'       => $subtotal,
            'delivery_fee'   => $deliveryFee,
            'tax'            => $tax,
            'discount'       => $discount,
            'total_amount'   => $total,
            'coupon_code'    => session('cart_coupon_code'),
            'delivery_address' => $request->new_address_line ?? $request->delivery_address ?? 'Default Address',
            'notes'          => $request->notes,
            'payment_method' => $request->payment_method ?? 'cod',
            'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
            'order_status'   => 'pending',
            'status'         => 'active',
        ]);

        // Create order items and reduce stock
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'       => $order->id,
                'medicine_id'    => $item->medicine_id,
                'medicine_name'  => $item->medicine->name,
                'medicine_brand' => $item->medicine->brand,
                'quantity'       => $item->quantity,
                'unit_price'     => $item->unit_price,
                'total_price'    => $item->quantity * $item->unit_price,
            ]);

            // Reduce medicine stock
            $item->medicine->decrement('stock', $item->quantity);
        }

        // Handle prescription upload to public/images/
        if ($request->hasFile('prescription')) {
            $rxName = 'rx_' . time() . '_' . $order->id . '.' . $request->prescription->extension();
            $request->prescription->move(public_path('images'), $rxName);

            Prescription::create([
                'customer_id'   => $customerId,
                'file_name'     => $rxName,
                'file_path'     => 'images/' . $rxName,
                'doctor_name'   => $request->doctor_name ?? 'N/A',
                'patient_name'  => $request->new_name ?? session('customer_name'),
                'notes'         => $request->notes,
                'status'        => 'active',
                'review_status' => 'pending',
            ]);
        }

        // Clear cart and coupon
        Cart::where('customer_id', $customerId)->delete();
        session(['cart_count' => 0, 'cart_coupon_code' => null, 'cart_coupon_discount' => 0]);

        return redirect('/customer/orders')->with('success', 'Order #ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) . ' placed successfully!');
    }

    public function ordersHistory(Request $request)
    {
        $customerId = session('user_id');

        $orders = Order::where('customer_id', $customerId)
            ->where('status', 'active')
            ->with('orderItems')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->items = $order->orderItems->take(3);
                $order->items_count = $order->orderItems->count();
                return $order;
            });

        return view('customer.orders', compact('orders'));
    }

    public function cancelOrder(Request $request)
    {
        $request->validate(['order_id' => 'required|exists:orders,id']);

        $order = Order::where('customer_id', session('user_id'))
            ->findOrFail($request->order_id);

        if (!in_array($order->order_status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This order cannot be cancelled at this stage.');
        }

        // Restore stock
        foreach ($order->orderItems as $item) {
            Medicine::where('id', $item->medicine_id)->increment('stock', $item->quantity);
        }

        $order->update(['order_status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order_id' => 'required|exists:orders,id']);

        $order = Order::where('customer_id', session('user_id'))
            ->findOrFail($request->order_id);

        $addedCount = 0;

        foreach ($order->orderItems as $item) {
            $medicine = Medicine::active()->find($item->medicine_id);
            if (!$medicine || $medicine->stock <= 0) continue;

            $qty = min($item->quantity, $medicine->stock);

            $existing = Cart::where('customer_id', session('user_id'))
                ->where('medicine_id', $medicine->id)
                ->first();

            if ($existing) {
                $existing->increment('quantity', $qty);
            } else {
                Cart::create([
                    'customer_id' => session('user_id'),
                    'medicine_id' => $medicine->id,
                    'quantity'    => $qty,
                    'unit_price'  => $medicine->price,
                ]);
            }
            $addedCount++;
        }

        $cartCount = Cart::where('customer_id', session('user_id'))->sum('quantity');
        session(['cart_count' => $cartCount]);

        return response()->json([
            'success'    => true,
            'message'    => "{$addedCount} items added to cart.",
            'cart_count' => $cartCount,
        ]);
    }

    /* ============================================
       PRESCRIPTIONS
    ============================================ */

    public function prescriptions()
    {
        $prescriptions = Prescription::active()
            ->where('customer_id', session('user_id'))
            ->latest()
            ->get();

        return view('customer.prescription', compact('prescriptions'));
    }

    public function uploadPrescription(Request $request)
{
    $request->validate([
        'prescription_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        'doctor_name'       => 'required|string|min:3',
        'village_id'        => 'required|exists:villages,id',
    ]);

    $file = $request->file('prescription_file');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $filePath = $file->storeAs('prescriptions', $fileName, 'public');

    Prescription::create([
        'customer_id'   => session('user_id'),
        'file_name'     => $fileName,
        'file_path'     => $filePath,
        'doctor_name'   => $request->doctor_name,
        'patient_name'  => $request->patient_name ?? null, // if you have this field
        'village_id'    => $request->village_id,
        'notes'         => $request->notes ?? null,
        'status'        => 'active',
        'review_status' => 'pending',
    ]);

    return redirect()->back()->with('success', 'Prescription uploaded successfully.');
}

    public function deletePrescription(Request $request)
    {
        $request->validate(['prescription_id' => 'required|exists:prescriptions,id']);

        $rx = Prescription::where('customer_id', session('user_id'))
            ->findOrFail($request->prescription_id);

        // Delete file from public/images/
        if ($rx->file_name && file_exists(public_path('images/' . $rx->file_name))) {
            unlink(public_path('images/' . $rx->file_name));
        }

        $rx->update(['status' => 'inactive']);

        return back()->with('success', 'Prescription deleted.');
    }

    /* ============================================
       REVIEWS
    ============================================ */

    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:500',
        ]);

        $medicine = Medicine::active()->findOrFail($id);

        $existing = MedicineReview::where('medicine_id', $id)
            ->where('customer_id', session('user_id'))
            ->first();

        if ($existing) {
            $existing->update([
                'rating'  => $request->rating,
                'comment' => $request->comment,
            ]);
        } else {
            MedicineReview::create([
                'medicine_id' => $id,
                'customer_id' => session('user_id'),
                'rating'      => $request->rating,
                'comment'     => $request->comment,
                'status'      => 'active',
            ]);
        }

        return back()->with('success', 'Thank you for your review!');
    }

    /* ============================================
       CUSTOMER PROFILE
    ============================================ */

    public function profile()
    {
        $customer = Customer::with('village')->findOrFail(session('user_id'));
        $villages = Village::active()->orderBy('name')->get();

        $totalOrders     = Order::where('customer_id', $customer->id)->count();
        $deliveredOrders = Order::where('customer_id', $customer->id)
            ->where('order_status', 'delivered')
            ->count();
        $totalSpent      = Order::where('customer_id', $customer->id)
            ->where('order_status', 'delivered')
            ->sum('total_amount');
        $totalSaved      = Order::where('customer_id', $customer->id)
            ->sum('discount');

        // Addresses (simplified — stored in customer table)
        $addresses = collect();
        if ($customer->address) {
            $addresses->push((object)[
                'id'           => 1,
                'name'         => $customer->name,
                'phone'        => $customer->phone,
                'address_line' => $customer->address,
                'landmark'     => '',
                'city'         => $customer->village->name ?? '',
                'state'        => 'Maharashtra',
                'pincode'      => '',
                'type'         => 'home',
                'is_default'   => 1,
            ]);
        }

        return view('customer.profile', compact(
            'customer',
            'villages',
            'totalOrders',
            'deliveredOrders',
            'totalSpent',
            'totalSaved',
            'addresses'
        ));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|min:2|max:50',
            'email'      => 'required|email',
            'phone'      => 'required|digits:10',
            'village_id' => 'required|exists:villages,id',
            'address'    => 'nullable|string',
            'gender'     => 'nullable|in:male,female,other',
            'dob'        => 'nullable|date',
        ]);

        $customer = Customer::findOrFail(session('user_id'));

        $customer->update($request->only([
            'name',
            'email',
            'phone',
            'village_id',
            'address',
            'gender',
            'dob'
        ]));

        session([
            'customer_name'  => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => $customer->phone,
        ]);

        return back()->with('profile_success', 'Profile updated successfully.');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048']);

        $customer = Customer::findOrFail(session('user_id'));

        $avatarName = 'cust_' . $customer->id . '_' . time() . '.' . $request->avatar->extension();
        $request->avatar->move(public_path('images'), $avatarName);

        // Delete old avatar from public/images/
        if ($customer->avatar && file_exists(public_path('images/' . $customer->avatar))) {
            unlink(public_path('images/' . $customer->avatar));
        }

        $customer->update(['avatar' => $avatarName]);

        return response()->json(['success' => true, 'avatar' => $avatarName]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $customer = Customer::findOrFail(session('user_id'));

        // Plain text comparison
        if ($customer->password !== $request->current_password) {
            return back()->with('password_error', 'Current password is incorrect.');
        }

        if ($request->new_password === $request->current_password) {
            return back()->with('password_error', 'New password must be different.');
        }

        $customer->update(['password' => $request->new_password]); // Plain text

        return back()->with('password_success', 'Password changed successfully.');
    }

    public function saveSettings(Request $request)
    {
        $customer = Customer::findOrFail(session('user_id'));

        $customer->update([
            'email_notifications' => $request->has('email_notifications'),
            'sms_notifications'   => $request->has('sms_notifications'),
            'promo_notifications' => $request->has('promo_notifications'),
            'rx_reminders'        => $request->has('rx_reminders'),
        ]);

        return back()->with('success', 'Notification preferences saved.');
    }

    public function deleteAccount()
    {
        $customer = Customer::findOrFail(session('user_id'));
        $customer->update(['status' => 'inactive']);

        session()->flush();

        return redirect('/login')->with('success', 'Your account has been deleted.');
    }

    /* ============================================
       ADDRESS MANAGEMENT
    ============================================ */

    public function saveAddress(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|min:2',
            'phone'        => 'required|digits:10',
            'address_line' => 'required|string|min:10',
            'city'         => 'required|string',
            'state'        => 'required|string',
            'pincode'      => 'required|digits:6',
            'type'         => 'required|in:home,work,other',
        ]);

        // Simplified: update customer's main address
        $customer = Customer::findOrFail(session('user_id'));
        $fullAddress = $request->address_line . ', ' . $request->city . ', ' . $request->state . ' - ' . $request->pincode;
        $customer->update([
            'address' => $fullAddress,
            'phone'   => $request->phone,
        ]);

        return back()->with('success', 'Address saved successfully.');
    }

    public function setDefaultAddress(Request $request)
    {
        return back()->with('success', 'Default address updated.');
    }

    public function deleteAddress(Request $request)
    {
        return back()->with('success', 'Address deleted.');
    }
}
