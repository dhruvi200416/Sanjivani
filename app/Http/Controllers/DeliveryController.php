<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryPartner;
use App\Models\Order;
use App\Models\Village;

class DeliveryController extends Controller
{
    /* ============================================
       DASHBOARD
    ============================================ */
    public function dashboard()
    {
        $partnerId = session('user_id');
        $partner = DeliveryPartner::findOrFail($partnerId);

        $todayDeliveries = Order::where('delivery_partner_id', $partnerId)
            ->where('order_status', 'delivered')
            ->whereDate('updated_at', today())
            ->count();

        $activeDeliveriesCount = Order::where('delivery_partner_id', $partnerId)
            ->whereIn('order_status', ['confirmed', 'processing', 'out_for_delivery'])
            ->count();

        $weekDeliveries = Order::where('delivery_partner_id', $partnerId)
            ->where('order_status', 'delivered')
            ->where('updated_at', '>=', now()->startOfWeek())
            ->count();

        $weekEarnings = Order::where('delivery_partner_id', $partnerId)
            ->where('order_status', 'delivered')
            ->where('updated_at', '>=', now()->startOfWeek())
            ->sum('delivery_fee');

        $todayEarnings = Order::where('delivery_partner_id', $partnerId)
            ->where('order_status', 'delivered')
            ->whereDate('updated_at', today())
            ->sum('delivery_fee');

        $rating = $partner->rating;
        $totalDistance = $totalDeliveries = $partner->total_deliveries * 3; // Mocking average 3km per delivery

        $activeDeliveries = Order::where('delivery_partner_id', $partnerId)
            ->whereIn('order_status', ['confirmed', 'processing', 'out_for_delivery'])
            ->with(['customer.village', 'pharmacy'])
            ->latest()
            ->get()
            ->map(function ($order) {
                return (object)[
                    'id'               => $order->id,
                    'order_id'         => 'ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                    'pharmacy_name'    => $order->pharmacy->pharmacy_name ?? 'Sanjivani Hub',
                    'pharmacy_address' => $order->pharmacy->address ?? 'Central Hub',
                    'customer_name'    => $order->customer->name ?? 'Unknown Customer',
                    'customer_address' => $order->delivery_address,
                    'customer_phone'   => $order->customer->phone ?? 'N/A',
                    'items_count'      => $order->orderItems()->sum('quantity'),
                    'earning'          => $order->delivery_fee,
                    'status'           => $order->order_status === 'out_for_delivery' ? 'picked_up' : 'assigned',
                    'created_at'       => $order->updated_at
                ];
            });

        return view('delivery.dashboard', compact(
            'partner',
            'todayDeliveries',
            'activeDeliveriesCount',
            'weekDeliveries',
            'weekEarnings',
            'todayEarnings',
            'rating',
            'totalDistance',
            'activeDeliveries'
        ));
    }

    /* ============================================
       TOGGLE ONLINE/OFFLINE AVAILABILITY
    ============================================ */
    public function toggleOnlineStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:online,offline'
        ]);

        $partner = DeliveryPartner::findOrFail(session('user_id'));
        $partner->update(['availability' => $request->status]);
        session(['delivery_status' => $request->status]);

        return response()->json(['success' => true]);
    }

    /* ============================================
       MY DELIVERIES LIST
    ============================================ */
    public function deliveries()
    {
        $partnerId = session('user_id');

        $deliveries = Order::where('delivery_partner_id', $partnerId)
            ->where('status', 'active')
            ->with(['customer.village', 'pharmacy'])
            ->latest()
            ->get()
            ->map(function ($order) {
                return (object)[
                    'id'               => $order->id,
                    'order_id'         => 'ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                    'pharmacy_name'    => $order->pharmacy->pharmacy_name ?? 'Sanjivani Hub',
                    'pharmacy_address' => $order->pharmacy->address ?? 'Central Hub',
                    'customer_name'    => $order->customer->name ?? 'Unknown Customer',
                    'customer_address' => $order->delivery_address,
                    'customer_phone'   => $order->customer->phone ?? 'N/A',
                    'items_count'      => $order->orderItems()->sum('quantity'),
                    'earning'          => $order->delivery_fee,
                    'distance'         => 3.2, // mock value
                    'status'           => $order->order_status === 'out_for_delivery' ? 'picked_up' : $order->order_status,
                    'created_at'       => $order->updated_at
                ];
            });

        return view('delivery.deliveries', compact('deliveries'));
    }

    /* ============================================
       DELIVERY DETAILS
    ============================================ */
    public function deliveryDetails($id)
    {
        $order = Order::where('delivery_partner_id', session('user_id'))
            ->with(['customer.village', 'pharmacy', 'orderItems'])
            ->findOrFail($id);

        $delivery = (object)[
            'id'               => $order->id,
            'order_id'         => 'ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
            'pharmacy_name'    => $order->pharmacy->pharmacy_name ?? 'Sanjivani Hub',
            'pharmacy_address' => $order->pharmacy->address ?? 'Central Hub',
            'pharmacy_phone'   => $order->pharmacy->phone ?? 'N/A',
            'customer_name'    => $order->customer->name ?? 'Unknown Customer',
            'customer_address' => $order->delivery_address,
            'customer_phone'   => $order->customer->phone ?? 'N/A',
            'items_count'      => $order->orderItems()->sum('quantity'),
            'earning'          => $order->delivery_fee,
            'distance'         => 2.5, // mock value
            'total_amount'     => $order->total_amount,
            'payment_method'   => $order->payment_method,
            'status'           => $order->order_status === 'out_for_delivery' ? 'picked_up' : $order->order_status,
            'notes'            => $order->notes,
            'created_at'       => $order->created_at
        ];

        $items = $order->orderItems;

        return view('delivery.delivery-details', compact('delivery', 'items'));
    }

    /* ============================================
       UPDATE DELIVERY STATUS
    ============================================ */
    public function updateDeliveryStatus(Request $request)
    {
        $request->validate([
            'delivery_id' => 'required|exists:orders,id',
            'status'      => 'required|in:picked_up,delivered'
        ]);

        $order = Order::where('delivery_partner_id', session('user_id'))->findOrFail($request->delivery_id);
        $partner = DeliveryPartner::findOrFail(session('user_id'));

        if ($request->status === 'picked_up') {
            $order->update(['order_status' => 'out_for_delivery']);
        } elseif ($request->status === 'delivered') {
            $order->update([
                'order_status'   => 'delivered',
                'payment_status' => 'paid'
            ]);

            // Credit earnings to Delivery Partner
            $partner->increment('total_deliveries');
            $partner->increment('total_earnings', $order->delivery_fee);
        }

        return response()->json(['success' => true]);
    }

    /* ============================================
       REPORT ISSUE / EXCEPTION HANDLING
    ============================================ */
    public function reportIssue(Request $request)
    {
        $request->validate([
            'delivery_id' => 'required|exists:orders,id',
            'reason'      => 'required|string|min:5|max:300'
        ]);

        $order = Order::where('delivery_partner_id', session('user_id'))->findOrFail($request->delivery_id);

        // Mark as cancelled and store notes
        $order->update([
            'order_status' => 'cancelled',
            'notes'        => $order->notes . ' [Delivery Issue: ' . $request->reason . ']'
        ]);

        return redirect('/delivery/dashboard')->with('error', 'Delivery issue reported. Order marked as cancelled.');
    }

    /* ============================================
       DELIVERY HISTORY
    ============================================ */
    public function history(Request $request)
    {
        $partnerId = session('user_id');
        $partner = DeliveryPartner::findOrFail($partnerId);

        $totalEarnings = $partner->total_earnings;
        $monthEarnings = Order::where('delivery_partner_id', $partnerId)
            ->where('order_status', 'delivered')
            ->where('updated_at', '>=', now()->startOfMonth())
            ->sum('delivery_fee');

        $weekEarnings = Order::where('delivery_partner_id', $partnerId)
            ->where('order_status', 'delivered')
            ->where('updated_at', '>=', now()->startOfWeek())
            ->sum('delivery_fee');

        $pendingPayout = 1200; // Mocked payout data

        $query = Order::where('delivery_partner_id', $partnerId)
            ->whereIn('order_status', ['delivered', 'cancelled']);

        if ($request->period === 'today') {
            $query->whereDate('updated_at', today());
        } elseif ($request->period === 'week') {
            $query->where('updated_at', '>=', now()->startOfWeek());
        } elseif ($request->period === 'month') {
            $query->where('updated_at', '>=', now()->startOfMonth());
        }

        $history = $query->latest()->get()->map(function ($order) {
            return (object)[
                'id'            => $order->id,
                'order_id'      => 'ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                'customer_name' => $order->customer->name ?? 'Unknown Customer',
                'distance'      => 3.0, // mock
                'items'         => $order->orderItems()->sum('quantity'),
                'earning'       => $order->order_status === 'delivered' ? $order->delivery_fee : 0,
                'status'        => $order->order_status,
                'date'          => $order->updated_at
            ];
        });

        return view('delivery.history', compact(
            'totalEarnings',
            'monthEarnings',
            'weekEarnings',
            'pendingPayout',
            'history'
        ));
    }

    /* ============================================
       EXPORT HISTORY TO CSV
    ============================================ */
    public function exportHistory()
    {
        $partnerId = session('user_id');
        $deliveries = Order::where('delivery_partner_id', $partnerId)
            ->whereIn('order_status', ['delivered', 'cancelled'])
            ->latest()
            ->get();

        $filename = "delivery_history_" . date('Ymd') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Order ID', 'Recipient', 'Earning', 'Status', 'Date'];

        $callback = function () use ($deliveries, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($deliveries as $del) {
                fputcsv($file, [
                    'ORD-' . str_pad($del->id, 4, '0', STR_PAD_LEFT),
                    $del->customer->name ?? 'N/A',
                    $del->order_status === 'delivered' ? '₹' . $del->delivery_fee : '₹0',
                    ucfirst($del->order_status),
                    $del->updated_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /* ============================================
       PROFILE SETTINGS (Plain Text Password)
    ============================================ */
    public function profile()
    {
        $partner = DeliveryPartner::with('village')->findOrFail(session('user_id'));
        $villages = Village::active()->orderBy('name')->get();

        $totalDeliveries = $partner->total_deliveries;
        $weekDeliveries = Order::where('delivery_partner_id', $partner->id)
            ->where('order_status', 'delivered')
            ->where('updated_at', '>=', now()->startOfWeek())
            ->count();
        $totalDistance = $totalDeliveries * 3.1; // mock
        $totalEarnings = $partner->total_earnings;

        return view('delivery.profile', compact(
            'partner',
            'villages',
            'totalDeliveries',
            'weekDeliveries',
            'totalDistance',
            'totalEarnings'
        ));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|min:2|max:50',
            'email'   => 'required|email',
            'phone'   => 'required|digits:10',
            'address' => 'required|string|min:10|max:200'
        ]);

        $partner = DeliveryPartner::findOrFail(session('user_id'));

        $partner->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address
        ]);

        session(['delivery_name' => $partner->name]);

        return back()->with('profile_success', 'Profile information updated.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed'
        ]);

        $partner = DeliveryPartner::findOrFail(session('user_id'));

        // Plain Text Check
        if ($partner->password !== $request->current_password) {
            return back()->with('password_error', 'The provided current password is incorrect.');
        }

        if ($request->new_password === $request->current_password) {
            return back()->with('password_error', 'New password must be different.');
        }

        $partner->update(['password' => $request->new_password]); // plain text

        return back()->with('password_success', 'Password successfully changed.');
    }
}
