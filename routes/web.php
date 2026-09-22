<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocaleController;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/

// Home / Landing Page
Route::get('/', [CustomerController::class, 'home'])->name('home');
Route::get('/about', [CustomerController::class, 'about']);
Route::get('/contact', [CustomerController::class, 'contact']);
Route::post('/contact/send', [CustomerController::class, 'sendContactMessage']);

Route::get('locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Authentication Routes
Route::middleware(['guest.check'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout Route
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Middleware: LoginCheck + AdminMiddleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['login.check', 'admin.check'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // Manage Orders
    Route::get('/orders', [AdminController::class, 'orders']);
    Route::get('/order/{id}', [AdminController::class, 'orderDetails']);
    Route::post('/order/update-status', [AdminController::class, 'updateOrderStatus']);
    Route::post('/order/assign-delivery', [AdminController::class, 'assignDeliveryPartner']);
    Route::delete('/order/delete/{id}', [AdminController::class, 'deleteOrder']);
    Route::get('/orders/export', [AdminController::class, 'exportOrders']);

    // Manage Medicines
    Route::get('/medicines', [AdminController::class, 'medicines']);
    Route::post('/medicine/save', [AdminController::class, 'saveMedicine']);
    Route::delete('/medicine/delete/{id}', [AdminController::class, 'deleteMedicine']);

    // Manage Pharmacies
    Route::get('/pharmacies', [AdminController::class, 'pharmacies']);
    Route::post('/pharmacy/save', [AdminController::class, 'savePharmacy']);
    Route::post('/pharmacy/status/{id}', [AdminController::class, 'updatePharmacyStatus']);
    Route::delete('/pharmacy/delete/{id}', [AdminController::class, 'deletePharmacy']);

    // Manage Delivery Partners
    Route::get('/delivery-partners', [AdminController::class, 'deliveryPartners']);
    Route::post('/delivery-partner/save', [AdminController::class, 'saveDeliveryPartner']);
    Route::post('/delivery-partner/status/{id}', [AdminController::class, 'updateDeliveryPartnerStatus']);
    Route::delete('/delivery-partner/delete/{id}', [AdminController::class, 'deleteDeliveryPartner']);

    // Manage Customers/Users
    Route::get('/users', [AdminController::class, 'users']);
    Route::post('/user/toggle-status/{id}', [AdminController::class, 'toggleUserStatus']);
    Route::delete('/user/delete/{id}', [AdminController::class, 'deleteUser']);

    // Manage Villages/Areas
    Route::get('/villages', [AdminController::class, 'villages']);
    Route::post('/village/save', [AdminController::class, 'saveVillage']);
    Route::delete('/village/delete/{id}', [AdminController::class, 'deleteVillage']);

    // Profile Settings
    Route::get('/profile', [AdminController::class, 'profile']);
    Route::get('/edit-profile', [AdminController::class, 'editProfile']);
    Route::post('/profile/update', [AdminController::class, 'updateProfile']);
    Route::post('/profile/change-password', [AdminController::class, 'changePassword']);
});

/*
|--------------------------------------------------------------------------
| Customer Portal Routes (Middleware: LoginCheck + CustomerMiddleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['login.check', 'customer.check'])->prefix('customer')->group(function () {
    // Dashboard & Shop
    Route::get('/dashboard', [CustomerController::class, 'dashboard']);
    Route::get('/medicines', [CustomerController::class, 'medicinesCatalog']);
    Route::get('/medicine/{id}', [CustomerController::class, 'medicineDetails']);

    // Shopping Cart
    Route::get('/cart', [CustomerController::class, 'cart']);
    Route::post('/cart/add', [CustomerController::class, 'addToCart']);
    Route::post('/cart/update', [CustomerController::class, 'updateCartQuantity']);
    Route::post('/cart/remove', [CustomerController::class, 'removeFromCart']);
    Route::post('/cart/clear', [CustomerController::class, 'clearCart']);
    Route::post('/cart/apply-coupon', [CustomerController::class, 'applyCoupon']);
    Route::post('/cart/remove-coupon', [CustomerController::class, 'removeCoupon']);

    // Checkout & Order Placement
    Route::get('/checkout', [CustomerController::class, 'checkout']);
    Route::post('/order/place', [CustomerController::class, 'placeOrder']);
    Route::get('/orders', [CustomerController::class, 'ordersHistory']);
    Route::post('/order/cancel', [CustomerController::class, 'cancelOrder']);
    Route::post('/order/reorder', [CustomerController::class, 'reorder']);

    // Prescriptions Upload & Management
    Route::get('/prescription', [CustomerController::class, 'prescriptions']);
    Route::post('/prescription/upload', [CustomerController::class, 'uploadPrescription']);
    Route::delete('/prescription/delete', [CustomerController::class, 'deletePrescription']);

    // Reviews Section
    Route::post('/medicine/{id}/review', [CustomerController::class, 'submitReview']);

    // Customer Profile & Address Book
    Route::get('/profile', [CustomerController::class, 'profile']);
    Route::post('/profile/update', [CustomerController::class, 'updateProfile']);
    Route::post('/profile/upload-avatar', [CustomerController::class, 'uploadAvatar']);
    Route::post('/profile/change-password', [CustomerController::class, 'changePassword']);
    Route::post('/profile/settings', [CustomerController::class, 'saveSettings']);
    Route::delete('/profile/delete-account', [CustomerController::class, 'deleteAccount']);

    // Address Actions
    Route::post('/address/save', [CustomerController::class, 'saveAddress']);
    Route::post('/address/set-default', [CustomerController::class, 'setDefaultAddress']);
    Route::delete('/address/delete', [CustomerController::class, 'deleteAddress']);
});

/*
|--------------------------------------------------------------------------
| Delivery Partner Panel Routes (Middleware: LoginCheck + DeliveryMiddleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['login.check', 'delivery.check'])->prefix('delivery')->group(function () {
    // Dashboard & Online State
    Route::get('/dashboard', [DeliveryController::class, 'dashboard'])->name('delivery.dashboard');
    Route::post('/toggle-status', [DeliveryController::class, 'toggleOnlineStatus'])->name('delivery.toggle-status');

    // Active Delivery Assignments
    Route::get('/deliveries', [DeliveryController::class, 'deliveries'])->name('delivery.deliveries');
    Route::get('/details/{id}', [DeliveryController::class, 'deliveryDetails'])->name('delivery.details');
    Route::post('/update-status', [DeliveryController::class, 'updateDeliveryStatus'])->name('delivery.update-status');
    Route::post('/report-issue', [DeliveryController::class, 'reportIssue'])->name('delivery.report-issue');

    // Delivery Earnings & History Records
    Route::get('/history', [DeliveryController::class, 'history'])->name('delivery.history');
    Route::get('/history/export', [DeliveryController::class, 'exportHistory'])->name('delivery.history.export');

    // Account & Security
    Route::get('/profile', [DeliveryController::class, 'profile'])->name('delivery.profile');
    Route::post('/profile/update', [DeliveryController::class, 'updateProfile'])->name('delivery.profile.update');
    Route::post('/profile/change-password', [DeliveryController::class, 'changePassword'])->name('delivery.profile.password');
});

/*
|--------------------------------------------------------------------------
| Pharmacy Dashboard Routes (Middleware: LoginCheck + PharmacyMiddleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['login.check', 'pharmacy.check'])->prefix('pharmacy')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PharmacyController::class, 'dashboard']);

    // Orders Management
    Route::get('/orders', [PharmacyController::class, 'orders']);
    Route::get('/order/{id}', [PharmacyController::class, 'orderDetails']);
    Route::post('/order/update-status', [PharmacyController::class, 'updateOrderStatus']);
    Route::post('/order/cancel', [PharmacyController::class, 'cancelOrder']);

    // Medicines/Inventory Management
    Route::get('/medicines', [PharmacyController::class, 'medicines']);
    Route::get('/add-medicine', [PharmacyController::class, 'addMedicineForm']);
    Route::post('/medicine/save', [PharmacyController::class, 'saveMedicine']);
    Route::delete('/medicine/delete', [PharmacyController::class, 'deleteMedicine']);

    // Profile Settings
    Route::get('/profile', [PharmacyController::class, 'profile']);
    Route::post('/profile/update', [PharmacyController::class, 'updateProfile']);
    Route::post('/profile/change-password', [PharmacyController::class, 'changePassword']);
});
