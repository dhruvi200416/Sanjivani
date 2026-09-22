@extends('layouts.app')

@section('title', 'About Us - Our Story')

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
        background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-banner::after {
        content: '';
        position: absolute;
        bottom: -150px;
        left: -100px;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
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
        max-width: 700px;
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

    .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
        content: '›';
        font-size: 1.1rem;
    }

    .breadcrumb-custom .breadcrumb-item.active {
        color: #A5D6A7;
        font-weight: 600;
    }

    /* ============ SECTION COMMON ============ */
    .section-padding { padding: 90px 0; }

    .section-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 55px;
    }

    .section-badge {
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

    .section-title {
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 15px;
        line-height: 1.25;
    }

    .section-title .highlight {
        color: var(--primary-green);
    }

    .section-desc {
        font-size: 1rem;
        color: var(--gray-text);
        line-height: 1.8;
    }

    /* ============ ABOUT STORY ============ */
    .story-section {
        padding: 90px 0;
        background: var(--white);
    }

    .story-img-wrap {
        position: relative;
    }

    .story-img-wrap .main-img {
        width: 100%;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(46, 125, 50, 0.25);
    }

    .story-img-wrap .sub-img {
        position: absolute;
        bottom: -40px;
        right: -30px;
        width: 55%;
        border-radius: 20px;
        border: 8px solid var(--white);
        box-shadow: 0 15px 35px rgba(46, 125, 50, 0.28);
    }

    .story-exp-badge {
        position: absolute;
        top: 30px;
        left: -20px;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 20px 25px;
        border-radius: 18px;
        box-shadow: 0 12px 30px rgba(46, 125, 50, 0.35);
        text-align: center;
        z-index: 3;
    }

    .story-exp-badge strong {
        display: block;
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
    }

    .story-exp-badge span {
        font-size: 0.78rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .story-content .section-badge {
        margin-bottom: 15px;
    }

    .story-content h2 {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 18px;
        line-height: 1.3;
    }

    .story-content h2 .highlight {
        color: var(--primary-green);
    }

    .story-content .lead-text {
        font-size: 1.05rem;
        color: var(--dark-text);
        font-weight: 500;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .story-content p {
        color: var(--gray-text);
        font-size: 0.95rem;
        line-height: 1.85;
        margin-bottom: 15px;
    }

    .story-highlights {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin: 25px 0;
    }

    .story-highlights .hl-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: var(--pale-green);
        border-radius: 12px;
        transition: var(--transition);
    }

    .story-highlights .hl-item:hover {
        background: var(--light-green);
        color: var(--white);
        transform: translateX(5px);
    }

    .story-highlights .hl-item:hover i,
    .story-highlights .hl-item:hover span {
        color: var(--white);
    }

    .story-highlights .hl-item i {
        color: var(--primary-green);
        font-size: 1rem;
        transition: var(--transition);
    }

    .story-highlights .hl-item span {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--dark-text);
        transition: var(--transition);
    }

    .signature-wrap {
        display: flex;
        align-items: center;
        gap: 20px;
        padding-top: 25px;
        border-top: 1px solid #EEE;
        margin-top: 25px;
    }

    .signature-wrap .founder-img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-weight: 700;
        font-size: 1.3rem;
    }

    .signature-wrap .founder-info strong {
        display: block;
        font-size: 1rem;
        color: var(--dark-text);
    }

    .signature-wrap .founder-info span {
        font-size: 0.82rem;
        color: var(--gray-text);
    }

    /* ============ MISSION VISION ============ */
    .mission-section {
        padding: 90px 0;
        background: linear-gradient(180deg, var(--off-white) 0%, var(--white) 100%);
    }

    .mv-card {
        background: var(--white);
        border-radius: 24px;
        padding: 45px 35px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.07);
        transition: var(--transition);
        height: 100%;
        position: relative;
        overflow: hidden;
        border-top: 5px solid var(--light-green);
    }

    .mv-card::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(76, 175, 80, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        transition: var(--transition);
    }

    .mv-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(46, 125, 50, 0.18);
    }

    .mv-card:hover::before {
        top: -50px;
        right: -50px;
        transform: scale(1.2);
    }

    .mv-card .mv-icon {
        width: 85px;
        height: 85px;
        border-radius: 22px;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        font-size: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px rgba(46, 125, 50, 0.3);
        transition: var(--transition);
    }

    .mv-card:hover .mv-icon {
        transform: rotate(360deg);
    }

    .mv-card h3 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 15px;
    }

    .mv-card p {
        color: var(--gray-text);
        font-size: 0.95rem;
        line-height: 1.85;
        margin-bottom: 20px;
    }

    .mv-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .mv-list li {
        padding: 8px 0;
        color: var(--dark-text);
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .mv-list li i {
        color: var(--primary-green);
        font-size: 0.85rem;
    }

    /* ============ VALUES ============ */
    .values-section {
        padding: 90px 0;
        background: var(--white);
    }

    .value-card {
        background: var(--white);
        border-radius: 20px;
        padding: 35px 25px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        transition: var(--transition);
        height: 100%;
        border: 2px solid transparent;
        position: relative;
    }

    .value-card:hover {
        transform: translateY(-10px);
        border-color: var(--light-green);
        box-shadow: 0 18px 40px rgba(46, 125, 50, 0.15);
    }

    .value-card .val-icon {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        background: var(--pale-green);
        color: var(--primary-green);
        font-size: 1.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        transition: var(--transition);
        position: relative;
    }

    .value-card .val-icon::before {
        content: '';
        position: absolute;
        top: -8px;
        left: -8px;
        right: -8px;
        bottom: -8px;
        border-radius: 50%;
        border: 2px dashed var(--mint-green);
        transition: var(--transition);
    }

    .value-card:hover .val-icon {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        transform: scale(1.1);
    }

    .value-card:hover .val-icon::before {
        transform: rotate(180deg);
        border-color: var(--primary-green);
    }

    .value-card h5 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 12px;
    }

    .value-card p {
        color: var(--gray-text);
        font-size: 0.88rem;
        line-height: 1.7;
        margin: 0;
    }

    /* ============ ACHIEVEMENTS / STATS ============ */
    .achievement-section {
        padding: 80px 0;
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        position: relative;
        overflow: hidden;
    }

    .achievement-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(circle at 25% 30%, rgba(255,255,255,0.08) 0%, transparent 40%),
                          radial-gradient(circle at 75% 70%, rgba(255,255,255,0.06) 0%, transparent 40%);
    }

    .achievement-section .section-header {
        position: relative;
        z-index: 2;
    }

    .achievement-section .section-badge {
        background: rgba(255, 255, 255, 0.15);
        color: var(--white);
    }

    .achievement-section .section-title,
    .achievement-section .section-desc {
        color: var(--white);
    }

    .achievement-section .section-desc {
        color: rgba(255, 255, 255, 0.85);
    }

    .achievement-box {
        text-align: center;
        padding: 25px 15px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        transition: var(--transition);
        height: 100%;
        position: relative;
        z-index: 2;
    }

    .achievement-box:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-8px);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .achievement-box .ach-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: var(--white);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .achievement-box .ach-number {
        font-size: 2.7rem;
        font-weight: 800;
        color: var(--white);
        line-height: 1;
        margin-bottom: 8px;
    }

    .achievement-box .ach-label {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* ============ TEAM SECTION ============ */
    .team-section {
        padding: 90px 0;
        background: var(--off-white);
    }

    .team-card {
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
        transition: var(--transition);
        text-align: center;
        position: relative;
    }

    .team-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 45px rgba(46, 125, 50, 0.2);
    }

    .team-img-wrap {
        position: relative;
        height: 280px;
        overflow: hidden;
        background: linear-gradient(135deg, var(--pale-green), var(--mint-green));
    }

    .team-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .team-card:hover .team-img-wrap img {
        transform: scale(1.08);
    }

    .team-img-wrap .team-avatar-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        color: var(--white);
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        font-weight: 800;
    }

    .team-social {
        position: absolute;
        bottom: -60px;
        left: 0;
        right: 0;
        padding: 12px;
        background: linear-gradient(180deg, transparent, rgba(0, 0, 0, 0.7));
        display: flex;
        justify-content: center;
        gap: 10px;
        transition: var(--transition);
    }

    .team-card:hover .team-social {
        bottom: 0;
    }

    .team-social a {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--white);
        color: var(--primary-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        transition: var(--transition);
        text-decoration: none;
    }

    .team-social a:hover {
        background: var(--primary-green);
        color: var(--white);
        transform: translateY(-3px);
    }

    .team-info {
        padding: 22px 20px;
    }

    .team-info h5 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 5px;
    }

    .team-info .team-role {
        font-size: 0.85rem;
        color: var(--primary-green);
        font-weight: 600;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .team-info p {
        font-size: 0.85rem;
        color: var(--gray-text);
        margin: 0;
        line-height: 1.6;
    }

    /* ============ TIMELINE / JOURNEY ============ */
    .timeline-section {
        padding: 90px 0;
        background: var(--white);
    }

    .timeline-wrap {
        position: relative;
        max-width: 900px;
        margin: 0 auto;
    }

    .timeline-wrap::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 3px;
        background: linear-gradient(180deg, var(--primary-green), var(--light-green));
        transform: translateX(-50%);
        border-radius: 3px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 45px;
        width: 50%;
        padding: 0 45px;
    }

    .timeline-item:nth-child(odd) {
        left: 0;
        text-align: right;
    }

    .timeline-item:nth-child(even) {
        left: 50%;
    }

    .timeline-item .tl-dot {
        position: absolute;
        top: 25px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--white);
        border: 4px solid var(--primary-green);
        z-index: 2;
        box-shadow: 0 0 0 6px rgba(76, 175, 80, 0.15);
    }

    .timeline-item:nth-child(odd) .tl-dot { right: -11px; }
    .timeline-item:nth-child(even) .tl-dot { left: -11px; }

    .timeline-item .tl-content {
        background: var(--white);
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: var(--transition);
        border: 2px solid transparent;
    }

    .timeline-item .tl-content:hover {
        border-color: var(--light-green);
        transform: scale(1.02);
        box-shadow: 0 12px 30px rgba(46, 125, 50, 0.15);
    }

    .timeline-item .tl-year {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 10px;
    }

    .timeline-item h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 8px;
    }

    .timeline-item p {
        color: var(--gray-text);
        font-size: 0.88rem;
        line-height: 1.7;
        margin: 0;
    }

    /* ============ CTA ============ */
    .about-cta {
        padding: 70px 0;
        background: linear-gradient(135deg, var(--pale-green), var(--off-white));
        text-align: center;
    }

    .about-cta h3 {
        font-size: 2.1rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 12px;
    }

    .about-cta p {
        color: var(--gray-text);
        margin-bottom: 28px;
        font-size: 1rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 991px) {
        .page-banner { padding: 140px 0 80px; }
        .page-banner h1 { font-size: 2.4rem; }
        .section-title { font-size: 2rem; }
        .story-content h2 { font-size: 1.7rem; }
        .story-img-wrap { margin-bottom: 70px; }
        .mv-card { padding: 35px 25px; margin-bottom: 25px; }
        .achievement-box .ach-number { font-size: 2.2rem; }

        .timeline-wrap::before { left: 22px; }
        .timeline-item { width: 100%; left: 0 !important; padding: 0 0 0 55px; text-align: left !important; margin-bottom: 30px; }
        .timeline-item .tl-dot { left: 11px !important; right: auto !important; }
    }

    @media (max-width: 767px) {
        .page-banner h1 { font-size: 1.9rem; }
        .page-banner p { font-size: 0.95rem; }
        .section-title { font-size: 1.7rem; }
        .story-content h2 { font-size: 1.5rem; }
        .story-highlights { grid-template-columns: 1fr; }
        .story-img-wrap .sub-img { display: none; }
        .story-exp-badge { left: 15px; padding: 15px 20px; }
        .story-exp-badge strong { font-size: 1.7rem; }
        .mv-card { padding: 30px 22px; }
        .mv-card h3 { font-size: 1.35rem; }
        .value-card { padding: 28px 20px; }
        .achievement-box .ach-number { font-size: 1.9rem; }
        .team-img-wrap { height: 240px; }
        .about-cta h3 { font-size: 1.6rem; }
    }
</style>
@endsection

@section('content')

<!-- ============ PAGE BANNER ============ -->
<section class="page-banner">
    <div class="container">
        <div class="page-banner-content" data-aos="fade-up">
            <span class="banner-badge">
                <i class="fas fa-leaf me-1"></i> About Sanjivani
            </span>
            <h1>Our Story</h1>
            <p>{{ $about->banner_text ?? 'Discover how Sanjivani is transforming healthcare accessibility in India by connecting patients with verified pharmacies and delivering medicines to every doorstep — even in the remotest villages.' }}</p>

            <nav>
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="breadcrumb-item active">About Us</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- ============ OUR STORY ============ -->
<section class="story-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="story-img-wrap">
                    <img src="{{ !empty($about->main_image) && file_exists(public_path('uploads/about/'.$about->main_image)) ? asset('uploads/about/'.$about->main_image) : 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&q=80' }}"
                         alt="Sanjivani Story" class="main-img">
                    <img src="{{ !empty($about->sub_image) && file_exists(public_path('uploads/about/'.$about->sub_image)) ? asset('uploads/about/'.$about->sub_image) : 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=500&q=80' }}"
                         alt="Sanjivani Team" class="sub-img d-none d-md-block">
                    <div class="story-exp-badge">
                        <strong>10+</strong>
                        <span>Years</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="story-content">
                    <span class="section-badge">Our Journey</span>
                    <h2>{!! $about->story_heading ?? 'Bringing <span class="highlight">Healthcare</span> Closer to You' !!}</h2>
                    <p class="lead-text">
                        {{ $about->story_lead ?? 'Sanjivani was born from a simple yet powerful idea — nobody should struggle to get essential medicines, no matter where they live.' }}
                    </p>
                    <p>
                        {{ $about->story_para1 ?? 'Founded in 2015, we started with a mission to eliminate the healthcare gap between urban and rural India. Today, we proudly serve thousands of families across the country through our network of verified pharmacies and dedicated delivery partners.' }}
                    </p>
                    <p>
                        {{ $about->story_para2 ?? 'Our technology-driven platform ensures 100% genuine medicines, transparent pricing and lightning-fast delivery — bringing peace of mind to families and saving countless lives every single day.' }}
                    </p>

                    <div class="story-highlights">
                        <div class="hl-item">
                            <i class="fas fa-check-circle"></i>
                            <span>ISO Certified</span>
                        </div>
                        <div class="hl-item">
                            <i class="fas fa-shield-halved"></i>
                            <span>Licensed Partners</span>
                        </div>
                        <div class="hl-item">
                            <i class="fas fa-truck-fast"></i>
                            <span>Same Day Delivery</span>
                        </div>
                        <div class="hl-item">
                            <i class="fas fa-hand-holding-heart"></i>
                            <span>Trusted by Millions</span>
                        </div>
                    </div>

                    <div class="signature-wrap">
                        <div class="founder-img">
                            {{ substr($about->founder_name ?? 'Dr. Rajesh Kumar', 0, 1) }}
                        </div>
                        <div class="founder-info">
                            <strong>{{ $about->founder_name ?? 'Dr. Rajesh Kumar' }}</strong>
                            <span>{{ $about->founder_designation ?? 'Founder & CEO, Sanjivani' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ MISSION & VISION ============ -->
<section class="mission-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Purpose</span>
            <h2 class="section-title">Our Mission & <span class="highlight">Vision</span></h2>
            <p class="section-desc">We are driven by a clear purpose — to make quality healthcare accessible, affordable and reliable for every Indian household.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="mv-card">
                    <div class="mv-icon"><i class="fas fa-bullseye"></i></div>
                    <h3>Our Mission</h3>
                    <p>
                        {{ $about->mission_text ?? 'To revolutionize medicine delivery in India by leveraging technology to connect patients with verified pharmacies, ensuring timely access to genuine medicines at fair prices — from bustling cities to the most remote villages.' }}
                    </p>
                    <ul class="mv-list">
                        <li><i class="fas fa-check-circle"></i> Bridge the urban-rural healthcare gap</li>
                        <li><i class="fas fa-check-circle"></i> Deliver 100% authentic medicines</li>
                        <li><i class="fas fa-check-circle"></i> Empower local pharmacies to grow</li>
                        <li><i class="fas fa-check-circle"></i> Create employment through delivery network</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="mv-card">
                    <div class="mv-icon"><i class="fas fa-eye"></i></div>
                    <h3>Our Vision</h3>
                    <p>
                        {{ $about->vision_text ?? 'To become India\'s most trusted digital healthcare partner, ensuring that no family — regardless of their location or income — has to worry about accessing essential medicines when they need them the most.' }}
                    </p>
                    <ul class="mv-list">
                        <li><i class="fas fa-check-circle"></i> Reach 10,000+ villages by 2030</li>
                        <li><i class="fas fa-check-circle"></i> Serve 10 million happy customers</li>
                        <li><i class="fas fa-check-circle"></i> Partner with 5,000+ pharmacies</li>
                        <li><i class="fas fa-check-circle"></i> Set new standards in healthcare delivery</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ CORE VALUES ============ -->
<section class="values-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">What Drives Us</span>
            <h2 class="section-title">Our Core <span class="highlight">Values</span></h2>
            <p class="section-desc">These principles guide every decision we make and every action we take at Sanjivani.</p>
        </div>

        <div class="row g-4">
            @php
                $values = [
                    ['icon'=>'fa-hand-holding-heart', 'title'=>'Compassion', 'desc'=>'We care deeply about our customers and treat every order as if it were for our own family.'],
                    ['icon'=>'fa-shield-halved', 'title'=>'Trust', 'desc'=>'Transparent pricing, genuine medicines and honest service — trust is our foundation.'],
                    ['icon'=>'fa-bolt', 'title'=>'Efficiency', 'desc'=>'Fast, seamless and reliable — we value your time and health above everything else.'],
                    ['icon'=>'fa-lightbulb', 'title'=>'Innovation', 'desc'=>'Constantly improving our technology to make healthcare simpler and better for all.'],
                    ['icon'=>'fa-users', 'title'=>'Community', 'desc'=>'Building strong relationships with pharmacies, delivery partners and communities we serve.'],
                    ['icon'=>'fa-leaf', 'title'=>'Sustainability', 'desc'=>'Eco-friendly packaging and responsible practices for a healthier planet tomorrow.'],
                ];
            @endphp

            @foreach($values as $i => $val)
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $i * 80 }}">
                    <div class="value-card">
                        <div class="val-icon"><i class="fas {{ $val['icon'] }}"></i></div>
                        <h5>{{ $val['title'] }}</h5>
                        <p>{{ $val['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ============ ACHIEVEMENTS / STATS ============ -->
<section class="achievement-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Milestones</span>
            <h2 class="section-title">Our Achievements <span style="color:#A5D6A7;">In Numbers</span></h2>
            <p class="section-desc">A decade of dedication reflected in numbers that continue to grow every day.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6 col-6" data-aos="zoom-in" data-aos-delay="0">
                <div class="achievement-box">
                    <div class="ach-icon"><i class="fas fa-users"></i></div>
                    <div class="ach-number about-counter" data-target="{{ $totalCustomers ?? 5240 }}">0</div>
                    <div class="ach-label">Happy Customers</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="achievement-box">
                    <div class="ach-icon"><i class="fas fa-store"></i></div>
                    <div class="ach-number about-counter" data-target="{{ $totalPharmacies ?? 152 }}">0</div>
                    <div class="ach-label">Verified Pharmacies</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="achievement-box">
                    <div class="ach-icon"><i class="fas fa-map-location-dot"></i></div>
                    <div class="ach-number about-counter" data-target="{{ $totalVillages ?? 480 }}">0</div>
                    <div class="ach-label">Villages Served</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="achievement-box">
                    <div class="ach-icon"><i class="fas fa-award"></i></div>
                    <div class="ach-number about-counter" data-target="{{ $totalAwards ?? 25 }}">0</div>
                    <div class="ach-label">Awards Won</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ TEAM SECTION ============ -->
<section class="team-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Leadership</span>
            <h2 class="section-title">Meet Our <span class="highlight">Expert Team</span></h2>
            <p class="section-desc">Passionate professionals dedicated to transforming healthcare accessibility across India.</p>
        </div>

        <div class="row g-4">
            @php
                $team = [
                    ['name'=>'Dr. Rajesh Kumar', 'role'=>'Founder & CEO', 'desc'=>'20+ years of experience in healthcare and pharmacy industry.', 'img'=>'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=400&q=80'],
                    ['name'=>'Priya Sharma', 'role'=>'Chief Operating Officer', 'desc'=>'Expert in operations and supply chain management.', 'img'=>'https://images.unsplash.com/photo-1594824476967-48c8b964273f?w=400&q=80'],
                    ['name'=>'Amit Patel', 'role'=>'Head of Technology', 'desc'=>'Building innovative platforms for seamless healthcare delivery.', 'img'=>'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&q=80'],
                    ['name'=>'Dr. Sunita Verma', 'role'=>'Chief Pharmacist', 'desc'=>'Ensures quality and authenticity of every medicine delivered.', 'img'=>'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&q=80'],
                ];
            @endphp

            @foreach($team as $i => $member)
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="team-card">
                        <div class="team-img-wrap">
                            @if(!empty($member['img']))
                                <img src="{{ $member['img'] }}" alt="{{ $member['name'] }}">
                            @else
                                <div class="team-avatar-fallback">{{ strtoupper(substr($member['name'], 0, 1)) }}</div>
                            @endif
                            <div class="team-social">
                                <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>{{ $member['name'] }}</h5>
                            <div class="team-role">{{ $member['role'] }}</div>
                            <p>{{ $member['desc'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ============ TIMELINE / JOURNEY ============ -->
<section class="timeline-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Our Journey</span>
            <h2 class="section-title">From Idea to <span class="highlight">Impact</span></h2>
            <p class="section-desc">A timeline of milestones that shaped Sanjivani into what it is today.</p>
        </div>

        <div class="timeline-wrap">
            @php
                $milestones = [
                    ['year'=>'2015', 'title'=>'The Beginning', 'desc'=>'Sanjivani was founded with a mission to deliver medicines to underserved rural areas of Maharashtra.'],
                    ['year'=>'2017', 'title'=>'First 100 Pharmacies', 'desc'=>'Reached a milestone of 100 verified partner pharmacies across 3 states.'],
                    ['year'=>'2019', 'title'=>'Launched Mobile App', 'desc'=>'Introduced our user-friendly mobile application making ordering easier than ever.'],
                    ['year'=>'2021', 'title'=>'Rural Expansion', 'desc'=>'Extended services to 300+ villages, bringing medicines to previously unreached communities.'],
                    ['year'=>'2023', 'title'=>'Award Recognition', 'desc'=>'Honored with the "Best Healthcare Startup" award by the Ministry of Health.'],
                    ['year'=>'2025', 'title'=>'Nationwide Network', 'desc'=>'Serving thousands of families daily across India with same-day delivery in most locations.'],
                ];
            @endphp

            @foreach($milestones as $i => $m)
                <div class="timeline-item" data-aos="{{ $i % 2 == 0 ? 'fade-right' : 'fade-left' }}">
                    <div class="tl-dot"></div>
                    <div class="tl-content">
                        <span class="tl-year">{{ $m['year'] }}</span>
                        <h5>{{ $m['title'] }}</h5>
                        <p>{{ $m['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="about-cta">
    <div class="container" data-aos="zoom-in">
        <h3>Ready to Experience Better Healthcare?</h3>
        <p>Join thousands of families who trust Sanjivani for safe, timely and affordable medicine delivery. Your health, our priority.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ url('/register') }}" class="btn-sanjivani">
                <i class="fas fa-user-plus"></i> Get Started Today
            </a>
            <a href="{{ url('/contact') }}" class="btn-sanjivani-outline">
                <i class="fas fa-headset"></i> Contact Us
            </a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* ---------- Animated Counters for Achievements ---------- */
    var aboutCountersStarted = false;

    function animateAboutCounters() {
        $('.about-counter').each(function () {
            var $this = $(this);
            var target = parseInt($this.data('target')) || 0;

            $({ count: 0 }).animate({ count: target }, {
                duration: 2500,
                easing: 'swing',
                step: function () {
                    $this.text(Math.floor(this.count).toLocaleString());
                },
                complete: function () {
                    $this.text(target.toLocaleString() + '+');
                }
            });
        });
    }

    $(window).on('scroll load', function () {
        var $stats = $('.achievement-section');
        if ($stats.length && !aboutCountersStarted) {
            var top = $stats.offset().top;
            if ($(window).scrollTop() + $(window).height() > top + 100) {
                aboutCountersStarted = true;
                animateAboutCounters();
            }
        }
    });

    /* ---------- Timeline Item Reveal (extra effect) ---------- */
    $('.timeline-item').on('mouseenter', function () {
        $(this).find('.tl-dot').css({
            'background': 'var(--primary-green)',
            'border-color': 'var(--white)',
            'transform': 'scale(1.2)'
        });
    }).on('mouseleave', function () {
        $(this).find('.tl-dot').css({
            'background': 'var(--white)',
            'border-color': 'var(--primary-green)',
            'transform': 'scale(1)'
        });
    });

    /* ---------- Value Card Interactive Hover ---------- */
    $('.value-card').on('mouseenter', function () {
        $(this).find('.val-icon i').addClass('animate__animated animate__pulse');
    }).on('mouseleave', function () {
        $(this).find('.val-icon i').removeClass('animate__animated animate__pulse');
    });

});
</script>
@endsection