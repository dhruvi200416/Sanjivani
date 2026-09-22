<?php

return [

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],

    'guards' => [

        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // Admin Guard
        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],

        // Customer Guard
        'customer' => [
            'driver'   => 'session',
            'provider' => 'customers',
        ],

        // Pharmacy Guard
        'pharmacy' => [
            'driver'   => 'session',
            'provider' => 'pharmacies',
        ],

        // Delivery Guard
        'delivery' => [
            'driver'   => 'session',
            'provider' => 'delivery_partners',
        ],

    ],

    'providers' => [

        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Customer::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Admin::class,
        ],

        'customers' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Customer::class,
        ],

        'pharmacies' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Pharmacy::class,
        ],

        'delivery_partners' => [
            'driver' => 'eloquent',
            'model'  => App\Models\DeliveryPartner::class,
        ],

    ],

    'passwords' => [

        'users' => [
            'provider' => 'users',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

    ],

    'password_timeout' => 10800,

];