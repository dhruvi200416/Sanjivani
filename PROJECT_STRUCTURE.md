# Sanjivani Project Structure

This is a Laravel-based medicine ordering and delivery application. The project supports four main roles: admin, customer, delivery partner, and pharmacy.

```text
Sanjivani/
|-- .editorconfig
|-- .env                         # Local environment values; do not share secrets
|-- .env.example                 # Environment variable template
|-- .gitattributes
|-- .gitignore
|-- app.lnk
|-- artisan                       # Laravel command-line entry point
|-- composer.json                 # PHP dependencies and scripts
|-- composer.lock
|-- package.json                  # Frontend dependencies and scripts
|-- phpunit.xml                   # PHPUnit configuration
|-- README.md
|-- vite.config.js                # Vite asset build configuration
|
|-- app/
|   |-- Console/
|   |   `-- Kernel.php
|   |-- Exceptions/
|   |   `-- Handler.php
|   |-- Http/
|   |   |-- Kernel.php
|   |   |-- Controllers/
|   |   |   |-- Controller.php
|   |   |   |-- AdminController.php
|   |   |   |-- AuthController.php
|   |   |   |-- CustomerController.php
|   |   |   |-- DeliveryController.php
|   |   |   `-- PharmacyController.php
|   |   `-- Middleware/
|   |       |-- AdminMiddleware.php
|   |       |-- Authenticate.php
|   |       |-- CustomerMiddleware.php
|   |       |-- DeliveryMiddleware.php
|   |       |-- EncryptCookies.php
|   |       |-- LoginCheck.php
|   |       |-- PharmacyMiddleware.php
|   |       |-- PreventRequestsDuringMaintenance.php
|   |       |-- RedirectIfAuthenticated.php
|   |       |-- TrimStrings.php
|   |       |-- TrustHosts.php
|   |       |-- TrustProxies.php
|   |       |-- ValidateSignature.php
|   |       `-- VerifyCsrfToken.php
|   |-- Models/
|   |   |-- AboutContent.php
|   |   |-- Admin.php
|   |   |-- Cart.php
|   |   |-- ContactMessage.php
|   |   |-- Customer.php
|   |   |-- DeliveryPartner.php
|   |   |-- HomeContent.php
|   |   |-- Medicine.php
|   |   |-- MedicineReview.php
|   |   |-- Order.php
|   |   |-- OrderItem.php
|   |   |-- Pharmacy.php
|   |   |-- Prescription.php
|   |   |-- SiteSetting.php
|   |   `-- Village.php
|   `-- Providers/
|       |-- AppServiceProvider.php
|       |-- AuthServiceProvider.php
|       |-- BroadcastServiceProvider.php
|       |-- EventServiceProvider.php
|       `-- RouteServiceProvider.php
|
|-- bootstrap/
|   |-- app.php
|   `-- cache/
|       |-- .gitignore
|       |-- packages.php
|       `-- services.php
|
|-- config/
|   |-- app.php
|   |-- auth.php
|   |-- broadcasting.php
|   |-- cache.php
|   |-- cors.php
|   |-- database.php
|   |-- filesystems.php
|   |-- hashing.php
|   |-- logging.php
|   |-- mail.php
|   |-- queue.php
|   |-- sanctum.php
|   |-- services.php
|   |-- session.php
|   `-- view.php
|
|-- database/
|   |-- .gitignore
|   |-- factories/
|   |   `-- UserFactory.php
|   |-- migrations/
|   |   |-- 2014_10_12_100000_create_password_reset_tokens_table.php
|   |   |-- 2019_08_19_000000_create_failed_jobs_table.php
|   |   |-- 2019_12_14_000001_create_personal_access_tokens_table.php
|   |   |-- 2026_08_13_132640_create_villages_table.php
|   |   |-- 2026_08_13_132650_create_admins_table.php
|   |   |-- 2026_08_13_132659_create_customers_table.php
|   |   |-- 2026_08_13_132706_create_delivery_partners_table.php
|   |   |-- 2026_08_13_132715_create_pharmacies_table.php
|   |   |-- 2026_08_13_132729_create_medicines_table.php
|   |   |-- 2026_08_13_132736_create_prescriptions_table.php
|   |   |-- 2026_08_13_132745_create_carts_table.php
|   |   |-- 2026_08_13_132751_create_orders_table.php
|   |   |-- 2026_08_13_132758_create_order_items_table.php
|   |   |-- 2026_08_13_132805_create_home_contents_table.php
|   |   |-- 2026_08_13_132811_create_about_contents_table.php
|   |   |-- 2026_08_13_132817_create_contact_messages_table.php
|   |   |-- 2026_08_13_132825_create_site_settings_table.php
|   |   |-- 2026_08_13_132831_create_medicine_reviews_table.php
|   |   |-- 2026_08_14_033710_add_featured_to_medicines_table.php
|   |   `-- 2026_08_17_053228_add_order_status_to_orders_table.php
|   `-- seeders/
|       `-- DatabaseSeeder.php
|
|-- public/
|   |-- .htaccess
|   |-- favicon.ico
|   |-- index.php
|   |-- robots.txt
|   `-- images/
|       `-- Sanjivani.jpeg
|
|-- resources/
|   |-- css/
|   |   `-- app.css
|   |-- js/
|   |   |-- app.js
|   |   `-- bootstrap.js
|   `-- views/
|       |-- about.blade.php
|       |-- contact.blade.php
|       |-- home.blade.php
|       |-- welcome.blade.php
|       |-- auth/                 # Login and registration pages
|       |-- layouts/              # Shared layouts by user role
|       |-- admin/                # Admin dashboard and management pages
|       |-- customer/             # Customer shopping, cart, checkout, and orders
|       |-- delivery/             # Delivery partner workflow and history
|       `-- pharmacy/             # Pharmacy medicine and order management
|
|-- routes/
|   |-- api.php
|   |-- channels.php
|   |-- console.php
|   `-- web.php                   # Main browser routes
|
|-- tests/
|   |-- CreatesApplication.php
|   |-- TestCase.php
|   |-- Feature/
|   |   `-- ExampleTest.php
|   `-- Unit/
|       `-- ExampleTest.php
|
|-- storage/                      # Runtime files, logs, cache, and uploads
`-- vendor/                       # Composer dependencies; generated by Composer
```

## Main Domain Areas

- **Authentication:** `AuthController`, role-specific middleware, and `Admin`, `Customer`, `DeliveryPartner`, and `Pharmacy` models.
- **Medicine catalog:** `Medicine`, `MedicineReview`, pharmacy views, and medicine migrations.
- **Shopping and orders:** `Cart`, `Order`, `OrderItem`, checkout views, and order-status migration.
- **Prescriptions:** `Prescription` model, customer prescription view, and related migration.
- **Administration:** Content, villages, pharmacies, medicines, users, delivery partners, and orders are managed through `AdminController` and `resources/views/admin`.
- **Delivery:** `DeliveryController`, delivery middleware, delivery views, and `DeliveryPartner` model.
- **Frontend:** Blade templates use assets from `resources/css` and `resources/js`, built with Vite.

## Context For Another AI

```text
This is a Laravel medicine delivery web application named Sanjivani.
Please inspect the existing Laravel conventions before changing code.
The application has four roles: admin, customer, delivery partner, and pharmacy.
Controllers are in app/Http/Controllers, Eloquent models are in app/Models,
role access is handled by app/Http/Middleware, routes are mainly in routes/web.php,
and Blade pages are in resources/views/{admin,customer,delivery,pharmacy,auth,layouts}.
Database schema changes are in database/migrations.
Preserve existing public routes, role behavior, and database relationships unless the task requires otherwise.
Do not modify vendor, storage runtime files, or .env secrets.
```
