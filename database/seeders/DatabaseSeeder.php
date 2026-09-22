<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Village;
use App\Models\Customer;
use App\Models\Pharmacy;
use App\Models\DeliveryPartner;
use App\Models\Medicine;
use App\Models\HomeContent;
use App\Models\AboutContent;
use App\Models\SiteSetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ========================================
        // 1. DEFAULT ADMIN ACCOUNT
        // ========================================
        Admin::create([
            'name'       => 'Super Admin',
            'email'      => 'admin@sanjivani.com',
            'phone'      => '9876543210',
            'password'   => Hash::make('admin123'),
            'address'    => '123 Health Street, Medical Plaza, Mumbai',
            'status'     => 'active',
            'last_login' => now(),
        ]);

        // ========================================
        // 2. SAMPLE VILLAGES / CITIES
        // ========================================
        $villages = [
            ['name' => 'Nashik',     'district' => 'Nashik',     'state' => 'Maharashtra', 'pincode' => '422001', 'delivery_charge' => 50],
            ['name' => 'Pune',       'district' => 'Pune',       'state' => 'Maharashtra', 'pincode' => '411001', 'delivery_charge' => 60],
            ['name' => 'Mumbai',     'district' => 'Mumbai',     'state' => 'Maharashtra', 'pincode' => '400001', 'delivery_charge' => 70],
            ['name' => 'Aurangabad', 'district' => 'Aurangabad', 'state' => 'Maharashtra', 'pincode' => '431001', 'delivery_charge' => 55],
            ['name' => 'Kolhapur',   'district' => 'Kolhapur',   'state' => 'Maharashtra', 'pincode' => '416001', 'delivery_charge' => 50],
            ['name' => 'Nagpur',     'district' => 'Nagpur',     'state' => 'Maharashtra', 'pincode' => '440001', 'delivery_charge' => 65],
            ['name' => 'Solapur',    'district' => 'Solapur',    'state' => 'Maharashtra', 'pincode' => '413001', 'delivery_charge' => 45],
            ['name' => 'Satara',     'district' => 'Satara',     'state' => 'Maharashtra', 'pincode' => '415001', 'delivery_charge' => 45],
            ['name' => 'Jaipur',     'district' => 'Jaipur',     'state' => 'Rajasthan',   'pincode' => '302001', 'delivery_charge' => 60],
            ['name' => 'Indore',     'district' => 'Indore',     'state' => 'Madhya Pradesh', 'pincode' => '452001', 'delivery_charge' => 55],
        ];

        foreach ($villages as $v) {
            Village::create(array_merge($v, ['status' => 'active']));
        }

        // ========================================
        // 3. DEMO PHARMACIES
        // ========================================
        $pharmacy1 = Pharmacy::create([
            'pharmacy_name'  => 'MediCare Pharmacy',
            'owner_name'     => 'Dr. Rajesh Kumar',
            'email'          => 'medicare@sanjivani.com',
            'phone'          => '9820011223',
            'password'       => Hash::make('pharmacy123'),
            'license_number' => 'DL-MH-2023-11111',
            'village_id'     => 1,
            'address'        => 'Shop No. 5, Market Road, Nashik',
            'status'         => 'active',
        ]);

        $pharmacy2 = Pharmacy::create([
            'pharmacy_name'  => 'HealthPlus Pharmacy',
            'owner_name'     => 'Dr. Sunita Sharma',
            'email'          => 'healthplus@sanjivani.com',
            'phone'          => '9820022334',
            'password'       => Hash::make('pharmacy123'),
            'license_number' => 'DL-MH-2023-22222',
            'village_id'     => 2,
            'address'        => 'Near Bus Stand, MG Road, Pune',
            'status'         => 'active',
        ]);

        $pharmacy3 = Pharmacy::create([
            'pharmacy_name'  => 'DiabetCare Store',
            'owner_name'     => 'Dr. Arjun Verma',
            'email'          => 'diabetcare@sanjivani.com',
            'phone'          => '9820033445',
            'password'       => Hash::make('pharmacy123'),
            'license_number' => 'DL-RJ-2023-33333',
            'village_id'     => 9,
            'address'        => '12 MG Road, Jaipur',
            'status'         => 'active',
        ]);

        // ========================================
        // 4. DEMO DELIVERY PARTNERS
        // ========================================
        DeliveryPartner::create([
            'name'           => 'Sunil Kumar',
            'email'          => 'sunil@sanjivani.com',
            'phone'          => '9830011223',
            'password'       => Hash::make('delivery123'),
            'village_id'     => 1,
            'address'        => 'Nashik, Maharashtra',
            'vehicle_type'   => 'Bike',
            'vehicle_number' => 'MH-15-AB-1234',
            'aadhar_number'  => '123456789012',
            'license_dl'     => 'MH15-20200012345',
            'rating'         => 4.7,
            'total_deliveries' => 234,
            'total_earnings' => 12580,
            'availability'   => 'online',
            'status'         => 'active',
        ]);

        DeliveryPartner::create([
            'name'           => 'Ravi Sharma',
            'email'          => 'ravi@sanjivani.com',
            'phone'          => '9830022334',
            'password'       => Hash::make('delivery123'),
            'village_id'     => 2,
            'address'        => 'Pune, Maharashtra',
            'vehicle_type'   => 'Scooter',
            'vehicle_number' => 'MH-12-CD-5678',
            'aadhar_number'  => '234567890123',
            'license_dl'     => 'MH12-20190012345',
            'rating'         => 4.9,
            'total_deliveries' => 567,
            'total_earnings' => 28900,
            'availability'   => 'online',
            'status'         => 'active',
        ]);

        // ========================================
        // 5. DEMO CUSTOMERS
        // ========================================
        $customer1 = Customer::create([
            'name'      => 'Ramesh Patil',
            'email'     => 'ramesh@example.com',
            'phone'     => '9876543210',
            'password'  => Hash::make('customer123'),
            'village_id'=> 1,
            'address'   => 'House No. 45, Gandhi Road, Nashik',
            'gender'    => 'male',
            'status'    => 'active',
        ]);

        Customer::create([
            'name'      => 'Sunita Sharma',
            'email'     => 'sunita@example.com',
            'phone'     => '9812345678',
            'password'  => Hash::make('customer123'),
            'village_id'=> 2,
            'address'   => 'Flat 202, Green Villa, Pune',
            'gender'    => 'female',
            'status'    => 'active',
        ]);

        // ========================================
        // 6. DEMO MEDICINES (Active by default)
        // ========================================
        $medicines = [
            // Pharmacy 1 - MediCare
            ['pharmacy_id' => $pharmacy1->id, 'name' => 'Paracetamol 500mg',     'brand' => 'Crocin',      'category' => 'Fever & Pain',  'price' => 25,  'mrp' => 30,  'stock' => 150, 'featured' => true,  'prescription_required' => false],
            ['pharmacy_id' => $pharmacy1->id, 'name' => 'Ibuprofen 400mg',       'brand' => 'Brufen',      'category' => 'Fever & Pain',  'price' => 45,  'mrp' => 55,  'stock' => 90,  'featured' => false, 'prescription_required' => false],
            ['pharmacy_id' => $pharmacy1->id, 'name' => 'Amoxicillin 250mg',     'brand' => 'Mox',         'category' => 'Antibiotic',    'price' => 85,  'mrp' => 100, 'stock' => 8,   'featured' => false, 'prescription_required' => true],
            ['pharmacy_id' => $pharmacy1->id, 'name' => 'Cough Syrup 100ml',     'brand' => 'Benadryl',    'category' => 'Cold & Cough',  'price' => 145, 'mrp' => 160, 'stock' => 45,  'featured' => false, 'prescription_required' => false],
            ['pharmacy_id' => $pharmacy1->id, 'name' => 'Antacid Tablets',       'brand' => 'ENO',         'category' => 'Digestive',     'price' => 60,  'mrp' => 75,  'stock' => 200, 'featured' => true,  'prescription_required' => false],
            ['pharmacy_id' => $pharmacy1->id, 'name' => 'Antiseptic Cream',      'brand' => 'Savlon',      'category' => 'First Aid',     'price' => 55,  'mrp' => 70,  'stock' => 120, 'featured' => true,  'prescription_required' => false],

            // Pharmacy 2 - HealthPlus
            ['pharmacy_id' => $pharmacy2->id, 'name' => 'Vitamin C 500mg',       'brand' => 'Limcee',      'category' => 'Vitamins',      'price' => 180, 'mrp' => 200, 'stock' => 80,  'featured' => true,  'prescription_required' => false],
            ['pharmacy_id' => $pharmacy2->id, 'name' => 'Multivitamin Capsules', 'brand' => 'Revital',     'category' => 'Vitamins',      'price' => 320, 'mrp' => 360, 'stock' => 65,  'featured' => false, 'prescription_required' => false],
            ['pharmacy_id' => $pharmacy2->id, 'name' => 'Face Wash 100ml',       'brand' => 'Himalaya',    'category' => 'Skin Care',     'price' => 130, 'mrp' => 150, 'stock' => 75,  'featured' => false, 'prescription_required' => false],
            ['pharmacy_id' => $pharmacy2->id, 'name' => 'Baby Diaper Rash Cream','brand' => 'Himalaya',    'category' => 'Baby Care',     'price' => 110, 'mrp' => 125, 'stock' => 90,  'featured' => false, 'prescription_required' => false],
            ['pharmacy_id' => $pharmacy2->id, 'name' => 'Ashwagandha Tablets',   'brand' => 'Patanjali',   'category' => 'Ayurvedic',     'price' => 240, 'mrp' => 280, 'stock' => 55,  'featured' => false, 'prescription_required' => false],

            // Pharmacy 3 - DiabetCare
            ['pharmacy_id' => $pharmacy3->id, 'name' => 'Insulin Injection',     'brand' => 'Humulin',     'category' => 'Diabetes',      'price' => 450, 'mrp' => 500, 'stock' => 0,   'featured' => false, 'prescription_required' => true],
            ['pharmacy_id' => $pharmacy3->id, 'name' => 'Metformin 500mg',       'brand' => 'Glycomet',    'category' => 'Diabetes',      'price' => 35,  'mrp' => 45,  'stock' => 200, 'featured' => true,  'prescription_required' => true],
            ['pharmacy_id' => $pharmacy3->id, 'name' => 'Blood Pressure Med',    'brand' => 'Amlong',      'category' => 'Heart Care',    'price' => 75,  'mrp' => 90,  'stock' => 15,  'featured' => false, 'prescription_required' => true],
            ['pharmacy_id' => $pharmacy3->id, 'name' => 'Cholesterol Tablets',   'brand' => 'Atorva',      'category' => 'Heart Care',    'price' => 95,  'mrp' => 120, 'stock' => 40,  'featured' => false, 'prescription_required' => true],
        ];

        foreach ($medicines as $med) {
            Medicine::create(array_merge($med, [
                'composition' => $med['name'],
                'description' => 'High quality ' . $med['name'] . ' by ' . $med['brand'] . '. Consult your physician before use.',
                'status'      => 'active',
            ]));
        }

        // ========================================
        // 7. CMS CONTENT
        // ========================================
        HomeContent::create([
            'hero_badge'    => '100% Genuine & Verified Medicines',
            'hero_title'    => 'Your Health Deserves <span class="highlight">The Best Care</span>',
            'hero_subtitle' => 'Order medicines online from verified local pharmacies and get them delivered to your doorstep within hours.',
            'status'        => 'active',
        ]);

        AboutContent::create([
            'banner_text'        => 'Discover how Sanjivani is transforming healthcare accessibility in India.',
            'story_heading'      => 'Bringing <span class="highlight">Healthcare</span> Closer to You',
            'story_lead'         => 'Sanjivani was born from a simple yet powerful idea — nobody should struggle to get essential medicines.',
            'story_para1'        => 'Founded in 2015, we started with a mission to eliminate the healthcare gap between urban and rural India.',
            'story_para2'        => 'Our technology-driven platform ensures 100% genuine medicines, transparent pricing and lightning-fast delivery.',
            'founder_name'       => 'Dr. Rajesh Kumar',
            'founder_designation'=> 'Founder & CEO, Sanjivani',
            'mission_text'       => 'To revolutionize medicine delivery in India by leveraging technology to connect patients with verified pharmacies.',
            'vision_text'        => 'To become India\'s most trusted digital healthcare partner by 2030.',
            'status'             => 'active',
        ]);

        // ========================================
        // 8. SITE SETTINGS
        // ========================================
        $settings = [
            ['key' => 'site_name',          'value' => 'Sanjivani'],
            ['key' => 'site_tagline',       'value' => 'Your Health, Our Priority'],
            ['key' => 'contact_email',      'value' => 'support@sanjivani.com'],
            ['key' => 'contact_phone',      'value' => '+91 98765 43210'],
            ['key' => 'free_delivery_min',  'value' => '500'],
            ['key' => 'default_tax_rate',   'value' => '5'],
            ['key' => 'maintenance_mode',   'value' => '0'],
        ];

        foreach ($settings as $s) {
            SiteSetting::create(array_merge($s, ['status' => 'active']));
        }
    }
}