<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Pharmacy;
use App\Models\DeliveryPartner;
use App\Models\Village;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,customer,pharmacy,delivery',
        ]);

        $role     = $request->role;
        $email    = $request->email;
        $password = $request->password;

        $model = match ($role) {
            'admin'    => Admin::class,
            'customer' => Customer::class,
            'pharmacy' => Pharmacy::class,
            'delivery' => DeliveryPartner::class,
        };

        $user = $model::where('email', $email)->first();

        if (!$user) {
            return back()->with('login_error', 'No account found with this email for the selected role.');
        }

        // Plain text password comparison
        if ($user->password !== $password) {
            return back()->with('login_error', 'Incorrect password. Please try again.');
        }

        if ($user->status === 'inactive') {
            return back()->with('login_error', 'Your account has been deactivated. Please contact support.');
        }

        session([
            'user_id'   => $user->id,
            'user_role' => $role,
        ]);

        switch ($role) {
            case 'admin':
                session(['admin_name' => $user->name]);
                $user->update(['last_login' => now()]);
                return redirect('/admin/dashboard');

            case 'customer':
                session([
                    'customer_name'  => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone,
                ]);
                $user->update(['last_login' => now()]);
                return redirect('/customer/dashboard');

            case 'pharmacy':
                session([
                    'pharmacy_name' => $user->pharmacy_name,
                    'pharmacy_id'   => $user->id,
                ]);
                $user->update(['last_login' => now()]);
                return redirect('/pharmacy/dashboard');

            case 'delivery':
                session([
                    'delivery_name' => $user->name,
                    'delivery_id'   => $user->id,
                ]);
                $user->update(['last_login' => now()]);
                return redirect('/delivery/dashboard');
        }

        return redirect('/');
    }

    public function showRegister()
    {
        $villages = Village::active()->orderBy('name')->get();
        return view('auth.register', compact('villages'));
    }

    public function register(Request $request)
    {
        $role = $request->role ?? 'customer';

        $rules = [
            'name'       => 'required|string|min:2|max:50',
            'email'      => 'required|email|max:100',
            'phone'      => 'required|digits:10',
            'village_id' => 'required|exists:villages,id',
            'password'   => 'required|min:6|confirmed',
            'terms'      => 'accepted',
        ];

        if ($role === 'customer') {
            $rules['address'] = 'required|string|min:10|max:300';
        } elseif ($role === 'pharmacy') {
            $rules['pharmacy_name']    = 'required|string|min:3|max:100';
            $rules['license_number']   = 'required|string|min:5|max:50';
            $rules['pharmacy_address'] = 'required|string|min:10|max:300';
        } elseif ($role === 'delivery') {
            $rules['vehicle_type']   = 'required|string';
            $rules['vehicle_number'] = 'required|string|min:5|max:20';
            $rules['aadhar_number']  = 'required|digits:12';
        }

        $request->validate($rules);

        $model = match ($role) {
            'customer' => Customer::class,
            'pharmacy' => Pharmacy::class,
            'delivery' => DeliveryPartner::class,
            default    => null,
        };

        if (!$model) {
            return back()->with('register_error', 'Invalid registration role.');
        }

        if ($model::where('email', $request->email)->exists()) {
            return back()->with('register_error', 'Email already registered.');
        }

        if ($model::where('phone', $request->phone)->exists()) {
            return back()->with('register_error', 'Phone number already registered.');
        }

        switch ($role) {
            case 'customer':
                $user = Customer::create([
                    'name'       => $request->name,
                    'email'      => $request->email,
                    'phone'      => $request->phone,
                    'password'   => $request->password, // Plain text
                    'village_id' => $request->village_id,
                    'address'    => $request->address,
                    'status'     => 'active',
                ]);

                session([
                    'user_id'        => $user->id,
                    'user_role'      => 'customer',
                    'customer_name'  => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone,
                ]);
                return redirect('/customer/dashboard')->with('success', 'Welcome to Sanjivani!');

            case 'pharmacy':
                if (Pharmacy::where('license_number', $request->license_number)->exists()) {
                    return back()->with('register_error', 'License number already registered.');
                }

                Pharmacy::create([
                    'pharmacy_name'  => $request->pharmacy_name,
                    'owner_name'     => $request->name,
                    'email'          => $request->email,
                    'phone'          => $request->phone,
                    'password'       => $request->password, // Plain text
                    'license_number' => $request->license_number,
                    'village_id'     => $request->village_id,
                    'address'        => $request->pharmacy_address,
                    'status'         => 'active',
                ]);
                return redirect('/login')->with('register_success', 'Pharmacy registered! Please login.');

            case 'delivery':
                DeliveryPartner::create([
                    'name'           => $request->name,
                    'email'          => $request->email,
                    'phone'          => $request->phone,
                    'password'       => $request->password, // Plain text
                    'village_id'     => $request->village_id,
                    'address'        => $request->address ?? '',
                    'vehicle_type'   => $request->vehicle_type,
                    'vehicle_number' => strtoupper($request->vehicle_number),
                    'aadhar_number'  => $request->aadhar_number,
                    'license_dl'     => $request->license_dl ?? null,
                    'status'         => 'active',
                ]);
                return redirect('/login')->with('register_success', 'Delivery partner registered! Please login.');
        }

        return redirect('/login')->with('register_success', 'Registration successful!');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}