@extends('layouts.app')

@section('title', 'Contact Us - Get in Touch')

@section('styles')
<style>
    /* ============ PAGE BANNER ============ */
    .page-banner {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 60%, var(--light-green) 100%);
        padding: 170px 0 100px;
        position: relative;
        overflow: hidden;
        color: var(--white);
        text-align: center;
    }

    .page-banner::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-banner::after {
        content: '';
        position: absolute;
        bottom: -150px;
        left: -100px;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-banner-content {
        position: relative;
        z-index: 2;
    }

    .page-banner .banner-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.18);
        color: var(--white);
        padding: 8px 22px;
        border-radius: 30px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 18px;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .page-banner h1 {
        font-size: 3.2rem;
        font-weight: 800;
        margin-bottom: 15px;
        text-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2);
    }

    .page-banner p {
        font-size: 1.1rem;
        max-width: 640px;
        margin: 0 auto;
        opacity: 0.92;
        line-height: 1.7;
    }

    .breadcrumb-custom {
        background: transparent;
        justify-content: center;
        margin: 22px 0 0;
        padding: 0;
    }

    .breadcrumb-custom .breadcrumb-item {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.9rem;
    }

    .breadcrumb-custom .breadcrumb-item a {
        color: var(--white);
        text-decoration: none;
        transition: var(--transition);
    }

    .breadcrumb-custom .breadcrumb-item a:hover {
        color: #A5D6A7;
    }

    .breadcrumb-custom .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
        content: '›';
        font-size: 1.1rem;
    }

    .breadcrumb-custom .breadcrumb-item.active {
        color: #A5D6A7;
        font-weight: 600;
    }

    /* ============ CONTACT INFO CARDS ============ */
    .contact-info-section {
        padding: 80px 0 40px;
        background: var(--white);
        margin-top: -60px;
        position: relative;
        z-index: 5;
    }

    .info-card {
        background: var(--white);
        border-radius: 20px;
        padding: 35px 25px;
        text-align: center;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        transition: var(--transition);
        height: 100%;
        border-bottom: 4px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.08), transparent);
        transition: var(--transition);
    }

    .info-card:hover {
        transform: translateY(-10px);
        border-bottom-color: var(--light-green);
        box-shadow: 0 20px 45px rgba(46, 125, 50, 0.18);
    }

    .info-card:hover::before {
        left: 0;
    }

    .info-card .info-icon {
        width: 78px;
        height: 78px;
        border-radius: 22px;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        font-size: 1.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 22px;
        transition: var(--transition);
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.3);
        position: relative;
        z-index: 2;
    }

    .info-card:hover .info-icon {
        transform: rotateY(180deg);
    }

    .info-card h5 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 12px;
        position: relative;
        z-index: 2;
    }

    .info-card p {
        color: var(--gray-text);
        font-size: 0.92rem;
        line-height: 1.7;
        margin-bottom: 15px;
        position: relative;
        z-index: 2;
    }

    .info-card .info-link {
        color: var(--primary-green);
        font-weight: 600;
        font-size: 0.92rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition);
        position: relative;
        z-index: 2;
    }

    .info-card .info-link:hover {
        color: var(--dark-green);
        gap: 10px;
    }

    /* ============ CONTACT FORM SECTION ============ */
    .contact-main-section {
        padding: 60px 0 90px;
        background: var(--off-white);
    }

    .contact-form-wrap {
        background: var(--white);
        border-radius: 24px;
        padding: 45px 40px;
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.09);
        position: relative;
        overflow: hidden;
    }

    .contact-form-wrap::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(180deg, var(--primary-green), var(--light-green));
    }

    .form-title {
        font-size: 1.9rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 8px;
    }

    .form-subtitle {
        color: var(--gray-text);
        font-size: 0.95rem;
        margin-bottom: 30px;
    }

    .form-group-custom {
        margin-bottom: 22px;
        position: relative;
    }

    .form-label-custom {
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 8px;
        display: block;
    }

    .form-label-custom .required {
        color: #E53935;
    }

    .form-control-custom {
        width: 100%;
        padding: 13px 16px 13px 44px;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        font-size: 0.94rem;
        font-family: 'Poppins', sans-serif;
        background: var(--white);
        transition: var(--transition);
        outline: none;
    }

    .form-control-custom:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.12);
    }

    .form-control-custom.error {
        border-color: #E53935;
        background: #FFF5F5;
    }

    .form-control-custom.success {
        border-color: var(--light-green);
        background: #F1F8E9;
    }

    .form-icon {
        position: absolute;
        left: 16px;
        top: 42px;
        color: var(--primary-green);
        font-size: 0.95rem;
        pointer-events: none;
    }

    textarea.form-control-custom {
        min-height: 140px;
        resize: vertical;
        padding-left: 44px;
    }

    textarea+.form-icon {
        top: 42px;
    }

    .error-message {
        color: #E53935;
        font-size: 0.8rem;
        margin-top: 6px;
        display: none;
        font-weight: 500;
    }

    .error-message.show {
        display: block;
        animation: shake 0.4s;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    .char-counter {
        font-size: 0.75rem;
        color: var(--gray-text);
        text-align: right;
        margin-top: 5px;
    }

    .char-counter.warning {
        color: #FB8C00;
    }

    .char-counter.danger {
        color: #E53935;
    }

    .btn-submit-contact {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        border: none;
        padding: 14px 45px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.25);
    }

    .btn-submit-contact:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(46, 125, 50, 0.4);
    }

    .btn-submit-contact:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* ============ CONTACT DETAILS SIDE ============ */
    .contact-details-wrap {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        border-radius: 24px;
        padding: 45px 35px;
        color: var(--white);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .contact-details-wrap::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .contact-details-wrap::after {
        content: '\f21e';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        bottom: -30px;
        right: -20px;
        font-size: 11rem;
        opacity: 0.06;
    }

    .contact-details-wrap h3 {
        font-size: 1.7rem;
        font-weight: 800;
        margin-bottom: 12px;
        position: relative;
        z-index: 2;
    }

    .contact-details-wrap>p {
        opacity: 0.85;
        margin-bottom: 30px;
        font-size: 0.92rem;
        line-height: 1.75;
        position: relative;
        z-index: 2;
    }

    .contact-detail-item {
        display: flex;
        gap: 16px;
        margin-bottom: 22px;
        position: relative;
        z-index: 2;
    }

    .contact-detail-item .cd-icon {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1rem;
        transition: var(--transition);
    }

    .contact-detail-item:hover .cd-icon {
        background: var(--white);
        color: var(--primary-green);
        transform: scale(1.08);
    }

    .contact-detail-item .cd-text {
        flex: 1;
    }

    .contact-detail-item .cd-text strong {
        display: block;
        font-size: 0.98rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .contact-detail-item .cd-text span,
    .contact-detail-item .cd-text a {
        font-size: 0.87rem;
        opacity: 0.9;
        color: var(--white);
        text-decoration: none;
        line-height: 1.6;
        display: block;
        transition: var(--transition);
    }

    .contact-detail-item .cd-text a:hover {
        color: #A5D6A7;
        opacity: 1;
    }

    .cd-social {
        display: flex;
        gap: 10px;
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        position: relative;
        z-index: 2;
    }

    .cd-social a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        text-decoration: none;
        transition: var(--transition);
        font-size: 0.9rem;
    }

    .cd-social a:hover {
        background: var(--white);
        color: var(--primary-green);
        transform: translateY(-4px);
    }

    /* ============ FAQ SECTION ============ */
    .faq-section {
        padding: 90px 0;
        background: var(--off-white);
    }

    .faq-section .section-header {
        text-align: center;
        max-width: 640px;
        margin: 0 auto 50px;
    }

    .faq-section .section-badge {
        display: inline-block;
        background: var(--pale-green);
        color: var(--primary-green);
        padding: 7px 22px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .faq-section h2 {
        font-size: 2.3rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 15px;
    }

    .faq-section h2 .highlight {
        color: var(--primary-green);
    }

    .faq-section>.container>.row>.col-lg-10>p {
        color: var(--gray-text);
        font-size: 1rem;
    }

    .faq-item {
        background: var(--white);
        border-radius: 14px;
        margin-bottom: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid transparent;
    }

    .faq-item:hover {
        box-shadow: 0 8px 22px rgba(46, 125, 50, 0.12);
        border-color: var(--mint-green);
    }

    .faq-item.active {
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.18);
        border-color: var(--light-green);
    }

    .faq-question {
        padding: 20px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--dark-text);
        font-size: 1rem;
        transition: var(--transition);
        user-select: none;
    }

    .faq-question:hover {
        color: var(--primary-green);
    }

    .faq-item.active .faq-question {
        color: var(--primary-green);
        background: var(--pale-green);
    }

    .faq-question .faq-toggle-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--pale-green);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        transition: var(--transition);
    }

    .faq-item.active .faq-toggle-icon {
        background: var(--primary-green);
        color: var(--white);
        transform: rotate(180deg);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, padding 0.4s ease;
        padding: 0 25px;
        color: var(--gray-text);
        font-size: 0.9rem;
        line-height: 1.8;
    }

    .faq-item.active .faq-answer {
        max-height: 500px;
        padding: 0 25px 22px;
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 991px) {
        .page-banner {
            padding: 140px 0 80px;
        }

        .page-banner h1 {
            font-size: 2.4rem;
        }

        .contact-details-wrap {
            margin-top: 40px;
        }

        .contact-form-wrap {
            padding: 35px 25px;
        }
    }

    @media (max-width: 767px) {
        .page-banner h1 {
            font-size: 1.9rem;
        }

        .page-banner p {
            font-size: 0.95rem;
        }

        .info-card {
            padding: 28px 20px;
        }

        .info-card .info-icon {
            width: 65px;
            height: 65px;
            font-size: 1.5rem;
        }

        .form-title {
            font-size: 1.5rem;
        }

        .contact-details-wrap {
            padding: 35px 22px;
        }

        .contact-details-wrap h3 {
            font-size: 1.4rem;
        }

        .faq-section h2 {
            font-size: 1.7rem;
        }

        .faq-question {
            font-size: 0.92rem;
            padding: 16px 18px;
        }
    }
</style>
@endsection

@section('content')

{{-- Shared batch translation for the entire Contact page --}}
@php
use App\Services\GoogleTranslator;

// ---------------------------------------------------------
// 1. FAQ items — 6 questions & answers
// ---------------------------------------------------------
$faqs = [
[
'q' => 'How long does medicine delivery take?',
'a' => 'We deliver medicines within 2-4 hours in most cities. In rural areas, delivery may take up to 24 hours depending on the location and pharmacy availability.'
],
[
'q' => 'Do I need a prescription to order medicines?',
'a' => 'For prescription medicines (Rx), you must upload a valid prescription. Over-the-counter (OTC) medicines can be ordered directly without any prescription.'
],
[
'q' => 'What payment methods do you accept?',
'a' => 'We accept all major payment methods including Cash on Delivery (COD), UPI, Debit/Credit Cards, Net Banking and popular digital wallets like Paytm, PhonePe and Google Pay.'
],
[
'q' => 'Can I return or exchange medicines?',
'a' => 'For safety reasons, we do not accept returns of opened medicines. However, if you receive damaged, expired or wrong products, please contact us within 24 hours for a full refund or replacement.'
],
[
'q' => 'How can I track my order?',
'a' => 'Once your order is placed, you can track its status in real-time from your Customer Dashboard under the "My Orders" section. You will also receive SMS and email updates at every step.'
],
[
'q' => 'How do I register my pharmacy on Sanjivani?',
'a' => 'Simply click on "Register" and select "Pharmacy" as your role. Fill in your pharmacy details, upload the required license documents. After admin verification, you can start receiving orders.'
],
];

$faqQuestions = GoogleTranslator::translateBatch(array_column($faqs, 'q'));
$faqAnswers = GoogleTranslator::translateBatch(array_column($faqs, 'a'));
foreach ($faqs as $i => &$f) {
$f['q'] = $faqQuestions[$i] ?? $f['q'];
$f['a'] = $faqAnswers[$i] ?? $f['a'];
}
unset($f);

// ---------------------------------------------------------
// 2. All other page strings — banner, info cards, form, side panel, FAQ heading
// ---------------------------------------------------------
$strings = GoogleTranslator::translateBatch([
// ---- Banner ----
'banner_badge' => 'Get In Touch',
'banner_title' => 'Contact Us',
'banner_desc' => "We'd love to hear from you! Whether you have questions, suggestions or need support — our friendly team is here to help you 24/7.",
'bc_home' => 'Home',
'bc_current' => 'Contact',

// ---- Info cards ----
'info_visit_title' => 'Visit Our Office',
'info_visit_desc' => '123 Health Street, Medical Plaza, Mumbai, Maharashtra - 400001',
'info_visit_link' => 'View on Map',

'info_call_title' => 'Call Us Anytime',
'info_call_phone1' => '+91 98765 43210',
'info_call_phone2' => '+91 12345 67890',
'info_call_link' => 'Call Now',

'info_email_title' => 'Email Us',
'info_email_addr1' => 'support@sanjivani.com',
'info_email_addr2' => 'info@sanjivani.com',
'info_email_link' => 'Send Email',

'info_hours_title' => 'Working Hours',
'info_hours_line1' => 'Mon - Sat: 8:00 AM - 10:00 PM',
'info_hours_line2' => 'Sunday: 9:00 AM - 6:00 PM',
'info_hours_link' => 'Order Now',

// ---- Form ----
'form_title' => 'Send Us a Message',
'form_subtitle' => 'Fill in the form below and our team will get back to you within 24 hours.',

'label_name' => 'Full Name',
'label_email' => 'Email Address',
'label_phone' => 'Mobile Number',
'label_subject' => 'Subject',
'label_message' => 'Message',

'ph_name' => 'Enter your full name',
'ph_email' => 'you@example.com',
'ph_phone' => '10-digit mobile number',
'ph_subject' => 'What is this about?',
'ph_message' => 'Write your message here...',

'char_counter_suffix' => 'characters',
'btn_send' => 'Send Message',
'btn_sending' => 'Sending Message...',

// ---- Contact side panel ----
'side_title' => "Let's Talk!",
'side_desc' => "Have a question about our services, orders or want to partner with us? Reach out through any of the channels below. We're always here to help.",
'side_office_title' => 'Head Office',
'side_office_line1' => '123 Health Street, Medical Plaza,',
'side_office_line2' => 'Mumbai, Maharashtra - 400001',
'side_phone_title' => 'Phone Numbers',
'side_email_title' => 'Email Address',
'side_support_title' => 'Customer Support',
'side_support_desc' => '24/7 support available for all your queries and emergencies',

// ---- FAQ heading ----
'faq_badge' => 'FAQ',
'faq_title' => 'Frequently Asked Questions',
'faq_desc' => 'Find quick answers to the most common questions about our services.',

// ---- JS validation messages ----
'js_name_required' => 'Please enter your full name.',
'js_name_short' => 'Name must be at least 2 characters long.',
'js_name_chars' => 'Name can only contain letters, spaces and dots.',
'js_email_required' => 'Please enter your email address.',
'js_email_invalid' => 'Please enter a valid email address.',
'js_email_long' => 'Email address is too long.',
'js_phone_required' => 'Please enter your mobile number.',
'js_phone_digits' => 'Mobile number must contain only digits.',
'js_phone_length' => 'Mobile number must be exactly 10 digits.',
'js_phone_invalid' => 'Please enter a valid Indian mobile number (starts with 6-9).',
'js_subject_required' => 'Please enter a subject.',
'js_subject_short' => 'Subject must be at least 3 characters long.',
'js_subject_long' => 'Subject must not exceed 150 characters.',
'js_message_required' => 'Please write your message.',
'js_message_short' => 'Message must be at least 10 characters long.',
'js_message_long' => 'Message must not exceed 500 characters.',
]);
@endphp

<!-- ============ PAGE BANNER ============ -->
<section class="page-banner">
    <div class="container">
        <div class="page-banner-content" data-aos="fade-up">
            <span class="banner-badge">
                <i class="fas fa-headset me-1"></i> {{ $strings['banner_badge'] }}
            </span>
            <h1>{{ $strings['banner_title'] }}</h1>
            <p>{{ $strings['banner_desc'] }}</p>

            <nav>
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i>{{ $strings['bc_home'] }}</a></li>
                    <li class="breadcrumb-item active">{{ $strings['bc_current'] }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- ============ QUICK CONTACT INFO ============ -->
<section class="contact-info-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-location-dot"></i></div>
                    <h5>{{ $strings['info_visit_title'] }}</h5>
                    <p>{{ $strings['info_visit_desc'] }}</p>
                    <a href="{{ url('/contact') }}" class="info-link">
                        {{ $strings['info_visit_link'] }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-phone-volume"></i></div>
                    <h5>{{ $strings['info_call_title'] }}</h5>
                    <p>{{ $strings['info_call_phone1'] }}<br>{{ $strings['info_call_phone2'] }}</p>
                    <a href="tel:+919876543210" class="info-link">
                        {{ $strings['info_call_link'] }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-envelope-open-text"></i></div>
                    <h5>{{ $strings['info_email_title'] }}</h5>
                    <p>{{ $strings['info_email_addr1'] }}<br>{{ $strings['info_email_addr2'] }}</p>
                    <a href="mailto:support@sanjivani.com" class="info-link">
                        {{ $strings['info_email_link'] }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-clock"></i></div>
                    <h5>{{ $strings['info_hours_title'] }}</h5>
                    <p>{{ $strings['info_hours_line1'] }}<br>{{ $strings['info_hours_line2'] }}</p>
                    <a href="{{ url('/customer/medicines') }}" class="info-link">
                        {{ $strings['info_hours_link'] }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ MAIN CONTACT FORM ============ -->
<section class="contact-main-section">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Form -->
            <div class="col-lg-7" data-aos="fade-right">
                <div class="contact-form-wrap">
                    <h2 class="form-title">{{ $strings['form_title'] }}</h2>
                    <p class="form-subtitle">{{ $strings['form_subtitle'] }}</p>

                    <form id="contactForm" action="{{ url('/contact/send') }}" method="POST" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">{{ $strings['label_name'] }} <span class="required">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control-custom"
                                        placeholder="{{ $strings['ph_name'] }}"
                                        value="{{ old('name') }}">
                                    <i class="fas fa-user form-icon"></i>
                                    <span class="error-message" id="nameError"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">{{ $strings['label_email'] }} <span class="required">*</span></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control-custom"
                                        placeholder="{{ $strings['ph_email'] }}"
                                        value="{{ old('email') }}">
                                    <i class="fas fa-envelope form-icon"></i>
                                    <span class="error-message" id="emailError"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">{{ $strings['label_phone'] }} <span class="required">*</span></label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control-custom"
                                        placeholder="{{ $strings['ph_phone'] }}"
                                        maxlength="10"
                                        value="{{ old('phone') }}">
                                    <i class="fas fa-phone form-icon"></i>
                                    <span class="error-message" id="phoneError"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">{{ $strings['label_subject'] }} <span class="required">*</span></label>
                                    <input type="text" name="subject" id="subject"
                                        class="form-control-custom"
                                        placeholder="{{ $strings['ph_subject'] }}"
                                        value="{{ old('subject') }}">
                                    <i class="fas fa-tag form-icon"></i>
                                    <span class="error-message" id="subjectError"></span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">{{ $strings['label_message'] }} <span class="required">*</span></label>
                                    <textarea name="message" id="message"
                                        class="form-control-custom"
                                        placeholder="{{ $strings['ph_message'] }}"
                                        maxlength="500">{{ old('message') }}</textarea>
                                    <i class="fas fa-comment form-icon"></i>
                                    <div class="char-counter" id="charCounter">0 / 500 {{ $strings['char_counter_suffix'] }}</div>
                                    <span class="error-message" id="messageError"></span>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn-submit-contact" id="submitBtn">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>{{ $strings['btn_send'] }}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Details Side -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="contact-details-wrap">
                    <h3>{{ $strings['side_title'] }}</h3>
                    <p>{{ $strings['side_desc'] }}</p>

                    <div class="contact-detail-item">
                        <div class="cd-icon"><i class="fas fa-location-dot"></i></div>
                        <div class="cd-text">
                            <strong>{{ $strings['side_office_title'] }}</strong>
                            <span>{{ $strings['side_office_line1'] }}<br>{{ $strings['side_office_line2'] }}</span>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="cd-icon"><i class="fas fa-phone"></i></div>
                        <div class="cd-text">
                            <strong>{{ $strings['side_phone_title'] }}</strong>
                            <a href="tel:+919876543210">{{ $strings['info_call_phone1'] }}</a>
                            <a href="tel:+911234567890">{{ $strings['info_call_phone2'] }}</a>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="cd-icon"><i class="fas fa-envelope"></i></div>
                        <div class="cd-text">
                            <strong>{{ $strings['side_email_title'] }}</strong>
                            <a href="mailto:support@sanjivani.com">{{ $strings['info_email_addr1'] }}</a>
                            <a href="mailto:info@sanjivani.com">{{ $strings['info_email_addr2'] }}</a>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="cd-icon"><i class="fas fa-headset"></i></div>
                        <div class="cd-text">
                            <strong>{{ $strings['side_support_title'] }}</strong>
                            <span>{{ $strings['side_support_desc'] }}</span>
                        </div>
                    </div>

                    <div class="cd-social">
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ FAQ SECTION ============ -->
<section class="faq-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-header" data-aos="fade-up">
                    <span class="section-badge">{{ $strings['faq_badge'] }}</span>
                    <h2>{{ $strings['faq_title'] }}</h2>
                    <p>{{ $strings['faq_desc'] }}</p>
                </div>

                <div class="faq-list">
                    @foreach($faqs as $i => $faq)
                    <div class="faq-item {{ $i === 0 ? 'active' : '' }}" data-aos="fade-up" data-aos-delay="{{ $i * 60 }}">
                        <div class="faq-question">
                            <span><i class="fas fa-circle-question me-2" style="color:var(--light-green);"></i> {{ $faq['q'] }}</span>
                            <span class="faq-toggle-icon"><i class="fas fa-chevron-down"></i></span>
                        </div>
                        <div class="faq-answer">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        /* =============================================
           FAQ ACCORDION
        ============================================= */
        $('.faq-question').on('click', function() {
            var $item = $(this).closest('.faq-item');

            if ($item.hasClass('active')) {
                $item.removeClass('active');
            } else {
                $('.faq-item').removeClass('active');
                $item.addClass('active');
            }
        });

        /* =============================================
           CHARACTER COUNTER FOR MESSAGE
        ============================================= */
        $('#message').on('input', function() {
            var length = $(this).val().length;
            var max = 500;
            var $counter = $('#charCounter');

            $counter.text(length + ' / ' + max + ' ' + @json($strings['char_counter_suffix']));
            $counter.removeClass('warning danger');

            if (length > max * 0.9) {
                $counter.addClass('danger');
            } else if (length > max * 0.75) {
                $counter.addClass('warning');
            }
        });

        /* =============================================
           VALIDATION FUNCTIONS
        ============================================= */
        function showError($input, message) {
            $input.addClass('error').removeClass('success');
            $input.closest('.form-group-custom').find('.error-message')
                .text(message).addClass('show');
        }

        function showSuccess($input) {
            $input.addClass('success').removeClass('error');
            $input.closest('.form-group-custom').find('.error-message')
                .text('').removeClass('show');
        }

        function clearField($input) {
            $input.removeClass('error success');
            $input.closest('.form-group-custom').find('.error-message')
                .text('').removeClass('show');
        }

        /* -------- Name Validation -------- */
        function validateName() {
            var $el = $('#name');
            var value = $.trim($el.val());
            var regex = /^[a-zA-Z\s.]{2,50}$/;

            if (value === '') {
                showError($el, '⚠ ' + @json($strings['js_name_required']));
                return false;
            }
            if (value.length < 2) {
                showError($el, '⚠ ' + @json($strings['js_name_short']));
                return false;
            }
            if (!regex.test(value)) {
                showError($el, '⚠ ' + @json($strings['js_name_chars']));
                return false;
            }
            showSuccess($el);
            return true;
        }

        /* -------- Email Validation -------- */
        function validateEmail() {
            var $el = $('#email');
            var value = $.trim($el.val());
            var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (value === '') {
                showError($el, '⚠ ' + @json($strings['js_email_required']));
                return false;
            }
            if (!regex.test(value)) {
                showError($el, '⚠ ' + @json($strings['js_email_invalid']));
                return false;
            }
            if (value.length > 100) {
                showError($el, '⚠ ' + @json($strings['js_email_long']));
                return false;
            }
            showSuccess($el);
            return true;
        }

        /* -------- Phone Validation -------- */
        function validatePhone() {
            var $el = $('#phone');
            var value = $.trim($el.val());
            var regex = /^[6-9]\d{9}$/;

            if (value === '') {
                showError($el, '⚠ ' + @json($strings['js_phone_required']));
                return false;
            }
            if (!/^\d+$/.test(value)) {
                showError($el, '⚠ ' + @json($strings['js_phone_digits']));
                return false;
            }
            if (value.length !== 10) {
                showError($el, '⚠ ' + @json($strings['js_phone_length']));
                return false;
            }
            if (!regex.test(value)) {
                showError($el, '⚠ ' + @json($strings['js_phone_invalid']));
                return false;
            }
            showSuccess($el);
            return true;
        }

        /* -------- Subject Validation -------- */
        function validateSubject() {
            var $el = $('#subject');
            var value = $.trim($el.val());

            if (value === '') {
                showError($el, '⚠ ' + @json($strings['js_subject_required']));
                return false;
            }
            if (value.length < 3) {
                showError($el, '⚠ ' + @json($strings['js_subject_short']));
                return false;
            }
            if (value.length > 150) {
                showError($el, '⚠ ' + @json($strings['js_subject_long']));
                return false;
            }
            showSuccess($el);
            return true;
        }

        /* -------- Message Validation -------- */
        function validateMessage() {
            var $el = $('#message');
            var value = $.trim($el.val());

            if (value === '') {
                showError($el, '⚠ ' + @json($strings['js_message_required']));
                return false;
            }
            if (value.length < 10) {
                showError($el, '⚠ ' + @json($strings['js_message_short']));
                return false;
            }
            if (value.length > 500) {
                showError($el, '⚠ ' + @json($strings['js_message_long']));
                return false;
            }
            showSuccess($el);
            return true;
        }

        /* =============================================
           REAL-TIME VALIDATION (BLUR + INPUT)
        ============================================= */
        $('#name').on('blur', validateName);
        $('#email').on('blur', validateEmail);
        $('#phone').on('blur', validatePhone);
        $('#subject').on('blur', validateSubject);
        $('#message').on('blur', validateMessage);

        // Clear error while typing
        $('#name, #email, #subject, #message').on('input', function() {
            if ($(this).hasClass('error') && $.trim($(this).val()) !== '') {
                clearField($(this));
            }
        });

        // Phone: only digits
        $('#phone').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if ($(this).hasClass('error') && this.value.length === 10) {
                clearField($(this));
            }
        });

        /* =============================================
           FORM SUBMISSION
        ============================================= */
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();

            var isValid = true;

            if (!validateName()) isValid = false;
            if (!validateEmail()) isValid = false;
            if (!validatePhone()) isValid = false;
            if (!validateSubject()) isValid = false;
            if (!validateMessage()) isValid = false;

            if (!isValid) {
                var $firstError = $('.form-control-custom.error').first();
                if ($firstError.length) {
                    $('html, body').animate({
                        scrollTop: $firstError.offset().top - 150
                    }, 500);
                    $firstError.focus();
                }
                return false;
            }

            var $btn = $('#submitBtn');
            var originalHtml = $btn.html();
            $btn.prop('disabled', true).html(
                '<i class="fas fa-spinner fa-spin"></i> <span>' + @json($strings['btn_sending']) + '</span>'
            );

            this.submit();
        });

    });
</script>
@endsection