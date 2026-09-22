@extends('layouts.app')

@section('title', 'Home - Online Medicine Delivery')

@section('styles')
<style>
    /* ============ HERO SECTION ============ */
    .hero-section {
        background: linear-gradient(135deg, #E8F5E9 0%, #F1F8E9 50%, #FFFFFF 100%);
        padding: 160px 0 100px;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -150px;
        right: -150px;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(76, 175, 80, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -200px;
        left: -150px;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(46, 125, 50, 0.12) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(76, 175, 80, 0.15);
        color: var(--dark-green);
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 20px;
        border: 1px solid rgba(76, 175, 80, 0.3);
    }

    .hero-badge i {
        color: var(--light-green);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }
    }

    .hero-title {
        font-size: 3.4rem;
        font-weight: 800;
        line-height: 1.15;
        color: var(--dark-text);
        margin-bottom: 20px;
    }

    .hero-title .highlight {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
    }

    .hero-subtitle {
        font-size: 1.08rem;
        color: var(--gray-text);
        line-height: 1.8;
        margin-bottom: 30px;
        max-width: 540px;
    }

    /* Hero Search */
    .hero-search {
        background: var(--white);
        border-radius: 50px;
        padding: 8px;
        box-shadow: 0 10px 40px rgba(46, 125, 50, 0.18);
        display: flex;
        align-items: center;
        gap: 8px;
        max-width: 540px;
        margin-bottom: 30px;
        border: 2px solid transparent;
        transition: var(--transition);
    }

    .hero-search:focus-within {
        border-color: var(--light-green);
        box-shadow: 0 10px 45px rgba(46, 125, 50, 0.28);
    }

    .hero-search .search-icon {
        padding-left: 18px;
        color: var(--primary-green);
        font-size: 1.05rem;
    }

    .hero-search input {
        flex: 1;
        border: none;
        outline: none;
        padding: 12px 8px;
        font-size: 0.95rem;
        background: transparent;
        font-family: 'Poppins', sans-serif;
    }

    .hero-search button {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        border: none;
        color: var(--white);
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.92rem;
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
    }

    .hero-search button:hover {
        transform: scale(1.03);
        box-shadow: 0 5px 20px rgba(76, 175, 80, 0.45);
    }

    .hero-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 35px;
    }

    /* Hero Trust Items */
    .hero-trust {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .trust-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .trust-item .icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-green);
        font-size: 1.05rem;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.15);
    }

    .trust-item .text strong {
        display: block;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--dark-text);
    }

    .trust-item .text span {
        font-size: 0.78rem;
        color: var(--gray-text);
    }

    /* Hero Image */
    .hero-image-wrap {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .hero-image-main {
        width: 100%;
        max-width: 480px;
        border-radius: 30px;
        box-shadow: 0 25px 60px rgba(46, 125, 50, 0.25);
        animation: floatY 5s ease-in-out infinite;
    }

    @keyframes floatY {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-18px);
        }
    }

    .hero-float-card {
        position: absolute;
        background: var(--white);
        border-radius: 16px;
        padding: 14px 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 3;
    }

    .hero-float-card .fc-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        color: var(--white);
    }

    .hero-float-card .fc-text strong {
        display: block;
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--dark-text);
        line-height: 1.1;
    }

    .hero-float-card .fc-text span {
        font-size: 0.72rem;
        color: var(--gray-text);
    }

    .float-card-1 {
        top: 12%;
        left: -5%;
        animation: floatY 4s ease-in-out infinite;
    }

    .float-card-1 .fc-icon {
        background: linear-gradient(135deg, #43A047, #66BB6A);
    }

    .float-card-2 {
        bottom: 15%;
        right: -3%;
        animation: floatY 4.5s ease-in-out infinite 0.5s;
    }

    .float-card-2 .fc-icon {
        background: linear-gradient(135deg, #1E88E5, #42A5F5);
    }

    .float-card-3 {
        bottom: 42%;
        left: -8%;
        animation: floatY 5s ease-in-out infinite 1s;
    }

    .float-card-3 .fc-icon {
        background: linear-gradient(135deg, #FB8C00, #FFA726);
    }

    /* ============ SECTION HEADER ============ */
    .section-padding {
        padding: 90px 0;
    }

    .section-header {
        text-align: center;
        max-width: 680px;
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

    /* ============ FEATURES ============ */
    .features-section {
        background: var(--white);
        margin-top: -50px;
        position: relative;
        z-index: 5;
        padding-bottom: 60px;
    }

    .feature-card {
        background: var(--white);
        border-radius: 20px;
        padding: 32px 25px;
        text-align: center;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.07);
        transition: var(--transition);
        height: 100%;
        border-bottom: 4px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.05), transparent);
        opacity: 0;
        transition: var(--transition);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 18px 45px rgba(46, 125, 50, 0.18);
        border-bottom-color: var(--light-green);
    }

    .feature-card:hover::before {
        opacity: 1;
    }

    .feature-card .feature-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 20px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        color: var(--white);
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        transition: var(--transition);
        position: relative;
        z-index: 2;
    }

    .feature-card:hover .feature-icon {
        transform: rotateY(180deg);
    }

    .feature-card h4 {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--dark-text);
        position: relative;
        z-index: 2;
    }

    .feature-card p {
        font-size: 0.88rem;
        color: var(--gray-text);
        line-height: 1.7;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    /* ============ CATEGORIES ============ */
    .categories-section {
        background: linear-gradient(180deg, var(--off-white) 0%, var(--white) 100%);
    }

    .category-card {
        background: var(--white);
        border-radius: 18px;
        padding: 28px 18px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
        transition: var(--transition);
        text-decoration: none;
        display: block;
        height: 100%;
        border: 2px solid transparent;
    }

    .category-card:hover {
        transform: translateY(-8px);
        border-color: var(--light-green);
        box-shadow: 0 15px 35px rgba(46, 125, 50, 0.2);
    }

    .category-card .cat-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary-green);
        transition: var(--transition);
    }

    .category-card:hover .cat-icon {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        transform: scale(1.1);
    }

    .category-card h6 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 5px;
    }

    .category-card span {
        font-size: 0.78rem;
        color: var(--gray-text);
    }

    /* ============ MEDICINE CARD ============ */
    .medicine-card {
        background: var(--white);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(0, 0, 0, 0.07);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .medicine-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 40px rgba(46, 125, 50, 0.2);
    }

    .medicine-card .med-img-wrap {
        position: relative;
        height: 190px;
        background: var(--pale-green);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .medicine-card .med-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .medicine-card:hover .med-img-wrap img {
        transform: scale(1.08);
    }

    .medicine-card .med-img-wrap .no-img {
        font-size: 3rem;
        color: var(--accent-green);
        opacity: 0.5;
    }

    .med-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        z-index: 2;
    }

    .med-badge.featured {
        background: linear-gradient(135deg, #FB8C00, #FFA726);
        color: var(--white);
    }

    .med-badge.rx {
        background: linear-gradient(135deg, #E53935, #EF5350);
        color: var(--white);
    }

    .med-stock {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.95);
        z-index: 2;
    }

    .med-stock.in {
        color: #2E7D32;
    }

    .med-stock.out {
        color: #C62828;
    }

    .medicine-card .med-body {
        padding: 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .medicine-card .med-cat {
        font-size: 0.72rem;
        color: var(--primary-green);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 6px;
    }

    .medicine-card h5 {
        font-size: 1.02rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 6px;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.6rem;
    }

    .medicine-card .med-brand {
        font-size: 0.8rem;
        color: var(--gray-text);
        margin-bottom: 10px;
    }

    .med-rating {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 12px;
    }

    .med-rating .stars {
        color: #FFC107;
        font-size: 0.8rem;
    }

    .med-rating span {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    .med-footer {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .med-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary-green);
    }

    .med-price small {
        font-size: 0.75rem;
        color: #999;
        text-decoration: line-through;
        font-weight: 500;
        margin-left: 5px;
    }

    .btn-add-cart {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        border: none;
        color: var(--white);
        padding: 9px 18px;
        border-radius: 22px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-add-cart:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 18px rgba(76, 175, 80, 0.45);
        color: var(--white);
    }

    .btn-add-cart:disabled {
        background: #CCC;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* ============ HOW IT WORKS ============ */
    .how-section {
        background: linear-gradient(135deg, var(--dark-green) 0%, var(--primary-green) 100%);
        position: relative;
        overflow: hidden;
    }

    .how-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.08) 0%, transparent 40%),
            radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.06) 0%, transparent 40%);
    }

    .how-section .section-badge {
        background: rgba(255, 255, 255, 0.15);
        color: var(--white);
    }

    .how-section .section-title,
    .how-section .section-desc {
        color: var(--white);
    }

    .how-section .section-desc {
        color: rgba(255, 255, 255, 0.8);
    }

    .step-card {
        text-align: center;
        position: relative;
        z-index: 2;
        padding: 20px;
    }

    .step-card .step-num {
        width: 85px;
        height: 85px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
        border: 2px dashed rgba(255, 255, 255, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: var(--white);
        transition: var(--transition);
        position: relative;
    }

    .step-card:hover .step-num {
        background: var(--white);
        color: var(--primary-green);
        border-style: solid;
        transform: rotate(360deg) scale(1.08);
    }

    .step-card .step-count {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #FFA726;
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 800;
    }

    .step-card h5 {
        color: var(--white);
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .step-card p {
        color: rgba(255, 255, 255, 0.75);
        font-size: 0.88rem;
        line-height: 1.7;
        margin: 0;
    }

    /* ============ STATS ============ */
    .stats-section {
        background: var(--white);
        padding: 70px 0;
    }

    .stat-box {
        text-align: center;
        padding: 25px 15px;
        border-radius: 18px;
        transition: var(--transition);
    }

    .stat-box:hover {
        background: var(--pale-green);
        transform: translateY(-5px);
    }

    .stat-box .stat-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.4rem;
    }

    .stat-box .stat-number {
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--primary-green);
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-box .stat-label {
        font-size: 0.9rem;
        color: var(--gray-text);
        font-weight: 500;
    }

    /* ============ WHY CHOOSE US ============ */
    .why-section {
        background: var(--off-white);
    }

    .why-img-wrap {
        position: relative;
    }

    .why-img-wrap img {
        width: 100%;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(46, 125, 50, 0.22);
    }

    .why-exp-badge {
        position: absolute;
        bottom: 25px;
        right: -15px;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
        padding: 22px 28px;
        border-radius: 18px;
        text-align: center;
        box-shadow: 0 12px 30px rgba(46, 125, 50, 0.35);
    }

    .why-exp-badge strong {
        display: block;
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
    }

    .why-exp-badge span {
        font-size: 0.78rem;
        opacity: 0.9;
    }

    .why-list {
        list-style: none;
        padding: 0;
        margin: 25px 0 0;
    }

    .why-list li {
        display: flex;
        gap: 16px;
        margin-bottom: 22px;
    }

    .why-list li .why-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 14px;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-green);
        font-size: 1.1rem;
        box-shadow: 0 5px 15px rgba(46, 125, 50, 0.12);
        transition: var(--transition);
    }

    .why-list li:hover .why-icon {
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        color: var(--white);
    }

    .why-list li h6 {
        font-size: 1.02rem;
        font-weight: 700;
        margin-bottom: 4px;
        color: var(--dark-text);
    }

    .why-list li p {
        font-size: 0.87rem;
        color: var(--gray-text);
        margin: 0;
        line-height: 1.7;
    }

    /* ============ PRESCRIPTION CTA ============ */
    .prescription-cta {
        background: linear-gradient(135deg, #1B5E20, #388E3C, #4CAF50);
        border-radius: 26px;
        padding: 50px;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .prescription-cta::before {
        content: '\f484';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 40px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12rem;
        opacity: 0.08;
    }

    .prescription-cta h3 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .prescription-cta p {
        font-size: 0.98rem;
        opacity: 0.9;
        margin-bottom: 25px;
        max-width: 560px;
        line-height: 1.8;
    }

    .btn-white {
        background: var(--white);
        color: var(--primary-green);
        border: none;
        padding: 13px 32px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: var(--transition);
    }

    .btn-white:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.22);
        color: var(--dark-green);
    }

    /* ============ TESTIMONIALS ============ */
    .testimonial-card {
        background: var(--white);
        border-radius: 20px;
        padding: 30px 26px;
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.07);
        transition: var(--transition);
        height: 100%;
        position: relative;
        border-top: 4px solid var(--light-green);
    }

    .testimonial-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 42px rgba(46, 125, 50, 0.18);
    }

    .testimonial-card .quote-icon {
        position: absolute;
        top: 22px;
        right: 26px;
        font-size: 2.4rem;
        color: var(--pale-green);
    }

    .testimonial-card .t-stars {
        color: #FFC107;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .testimonial-card p {
        font-size: 0.9rem;
        color: var(--gray-text);
        line-height: 1.85;
        font-style: italic;
        margin-bottom: 22px;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 13px;
        padding-top: 18px;
        border-top: 1px solid #EEE;
    }

    .testimonial-author .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--light-green));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-weight: 700;
        font-size: 1.05rem;
    }

    .testimonial-author strong {
        display: block;
        font-size: 0.95rem;
        color: var(--dark-text);
    }

    .testimonial-author span {
        font-size: 0.78rem;
        color: var(--gray-text);
    }

    /* ============ PARTNER SECTION ============ */
    .partner-card {
        border-radius: 22px;
        padding: 40px 32px;
        color: var(--white);
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
    }

    .partner-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
    }

    .partner-card.pharmacy {
        background: linear-gradient(135deg, #1B5E20, #43A047);
    }

    .partner-card.delivery {
        background: linear-gradient(135deg, #0D47A1, #1976D2);
    }

    .partner-card .p-icon {
        width: 68px;
        height: 68px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        margin-bottom: 20px;
    }

    .partner-card h4 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .partner-card p {
        font-size: 0.9rem;
        opacity: 0.88;
        line-height: 1.75;
        margin-bottom: 22px;
    }

    .partner-card .btn-partner {
        background: var(--white);
        padding: 11px 26px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.88rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
    }

    .partner-card.pharmacy .btn-partner {
        color: #1B5E20;
    }

    .partner-card.delivery .btn-partner {
        color: #0D47A1;
    }

    .partner-card .btn-partner:hover {
        transform: translateX(5px);
    }

    /* ============ NEWSLETTER CTA ============ */
    .cta-section {
        background: linear-gradient(135deg, var(--pale-green), var(--off-white));
        padding: 70px 0;
        text-align: center;
    }

    .cta-section h3 {
        font-size: 2.1rem;
        font-weight: 800;
        color: var(--dark-text);
        margin-bottom: 12px;
    }

    .cta-section p {
        color: var(--gray-text);
        margin-bottom: 28px;
        font-size: 1rem;
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 1199px) {
        .hero-title {
            font-size: 2.9rem;
        }

        .float-card-1,
        .float-card-3 {
            left: 0;
        }

        .float-card-2 {
            right: 0;
        }
    }

    @media (max-width: 991px) {
        .hero-section {
            padding: 130px 0 70px;
            text-align: center;
        }

        .hero-title {
            font-size: 2.4rem;
        }

        .hero-subtitle {
            margin-left: auto;
            margin-right: auto;
        }

        .hero-search {
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons,
        .hero-trust {
            justify-content: center;
        }

        .hero-image-wrap {
            margin-top: 50px;
        }

        .section-title {
            font-size: 2rem;
        }

        .section-padding {
            padding: 65px 0;
        }

        .prescription-cta {
            padding: 35px 28px;
            text-align: center;
        }

        .prescription-cta p {
            margin-left: auto;
            margin-right: auto;
        }

        .why-exp-badge {
            right: 15px;
        }

        .why-img-wrap {
            margin-bottom: 40px;
        }
    }

    @media (max-width: 767px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-search {
            flex-direction: column;
            border-radius: 20px;
            padding: 14px;
        }

        .hero-search input {
            width: 100%;
            text-align: center;
        }

        .hero-search button {
            width: 100%;
        }

        .hero-search .search-icon {
            display: none;
        }

        .hero-float-card {
            display: none;
        }

        .section-title {
            font-size: 1.7rem;
        }

        .prescription-cta h3 {
            font-size: 1.5rem;
        }

        .cta-section h3 {
            font-size: 1.6rem;
        }

        .stat-box .stat-number {
            font-size: 1.9rem;
        }
    }
</style>
@endsection

@section('content')

<!-- ============ HERO SECTION ============ -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-content" data-aos="fade-right">
                    <div class="hero-badge">
                        <i class="fas fa-circle"></i>
                        {{ __('messages.hero_badge') }}
                    </div>

                    <h1 class="hero-title">
                        {!! __('messages.hero_title') !!}
                    </h1>

                    <p class="hero-subtitle">
                        {{ __('messages.hero_subtitle') }}
                    </p>

                    <!-- Search Form -->
                    <form id="heroSearchForm" action="{{ url('/customer/medicines') }}" method="GET" novalidate>
                        <div class="hero-search">
                            <span class="search-icon"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" id="heroSearchInput"
                                placeholder="{{ __('messages.hero_search_placeholder') }}"
                                autocomplete="off">
                            <button type="submit">{{ __('messages.hero_search_btn') }}</button>
                        </div>
                        <div id="heroSearchError" class="text-danger small mb-3" style="display:none;"></div>
                    </form>

                    <div class="hero-buttons">
                        <a href="{{ url('/customer/medicines') }}" class="btn-sanjivani">
                            <i class="fas fa-pills"></i> {{ __('messages.hero_browse_medicines') }}
                        </a>
                        <a href="{{ url('/customer/prescription') }}" class="btn-sanjivani-outline">
                            <i class="fas fa-file-prescription"></i> {{ __('messages.hero_upload_prescription') }}
                        </a>
                    </div>

                    <div class="hero-trust">
                        <div class="trust-item">
                            <div class="icon"><i class="fas fa-truck-fast"></i></div>
                            <div class="text">
                                <strong>{{ __('messages.hero_fast_delivery') }}</strong>
                                <span>{{ __('messages.hero_fast_delivery_sub') }}</span>
                            </div>
                        </div>
                        <div class="trust-item">
                            <div class="icon"><i class="fas fa-shield-heart"></i></div>
                            <div class="text">
                                <strong>{{ __('messages.hero_verified_sellers') }}</strong>
                                <span>{{ __('messages.hero_verified_sellers_sub') }}</span>
                            </div>
                        </div>
                        <div class="trust-item">
                            <div class="icon"><i class="fas fa-headset"></i></div>
                            <div class="text">
                                <strong>{{ __('messages.hero_support') }}</strong>
                                <span>{{ __('messages.hero_support_sub') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-image-wrap" data-aos="fade-left" data-aos-delay="200">
                    <img src="{{ !empty($home->hero_image) && file_exists(public_path('uploads/home/'.$home->hero_image)) ? asset('uploads/home/'.$home->hero_image) : 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=700&q=80' }}"
                        alt="Sanjivani Medicine Delivery" class="hero-image-main">

                    <div class="hero-float-card float-card-1">
                        <div class="fc-icon"><i class="fas fa-pills"></i></div>
                        <div class="fc-text">
                            <strong>{{ $totalMedicines ?? '1200' }}+</strong>
                            <span>{{ __('messages.hero_medicines_available') }}</span>
                        </div>
                    </div>

                    <div class="hero-float-card float-card-2">
                        <div class="fc-icon"><i class="fas fa-users"></i></div>
                        <div class="fc-text">
                            <strong>{{ $totalCustomers ?? '5000' }}+</strong>
                            <span>{{ __('messages.hero_happy_customers') }}</span>
                        </div>
                    </div>

                    <div class="hero-float-card float-card-3">
                        <div class="fc-icon"><i class="fas fa-store"></i></div>
                        <div class="fc-text">
                            <strong>{{ $totalPharmacies ?? '150' }}+</strong>
                            <span>{{ __('messages.hero_partner_pharmacies') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ FEATURES ============ -->
<section class="features-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-truck-medical"></i></div>
                    <h4>{{ __('messages.feat_express_title') }}</h4>
                    <p>{{ __('messages.feat_express_desc') }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-certificate"></i></div>
                    <h4>{{ __('messages.feat_genuine_title') }}</h4>
                    <p>{{ __('messages.feat_genuine_desc') }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-tags"></i></div>
                    <h4>{{ __('messages.feat_best_price_title') }}</h4>
                    <p>{{ __('messages.feat_best_price_desc') }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-user-doctor"></i></div>
                    <h4>{{ __('messages.feat_expert_title') }}</h4>
                    <p>{{ __('messages.feat_expert_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ CATEGORIES ============ -->
<section class="section-padding categories-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">{{ __('messages.categories_badge') }}</span>
            <h2 class="section-title">{!! __('messages.categories_title') !!}</h2>
            <p class="section-desc">{{ __('messages.categories_desc') }}</p>
        </div>

        <div class="row g-4">
            @php
            $defaultCategories = [
            ['name' => __('messages.cat_fever'), 'icon' => 'fa-temperature-high'],
            ['name' => __('messages.cat_cold'), 'icon' => 'fa-head-side-cough'],
            ['name' => __('messages.cat_diabetes'), 'icon' => 'fa-droplet'],
            ['name' => __('messages.cat_heart'), 'icon' => 'fa-heart-pulse'],
            ['name' => __('messages.cat_vitamins'), 'icon' => 'fa-apple-whole'],
            ['name' => __('messages.cat_skin'), 'icon' => 'fa-hand-sparkles'],
            ['name' => __('messages.cat_baby'), 'icon' => 'fa-baby'],
            ['name' => __('messages.cat_firstaid'), 'icon' => 'fa-kit-medical'],
            ['name' => __('messages.cat_ayurvedic'), 'icon' => 'fa-leaf'],
            ['name' => __('messages.cat_digestive'), 'icon' => 'fa-stomach'],
            ['name' => __('messages.cat_eye'), 'icon' => 'fa-eye'],
            ['name' => __('messages.cat_devices'), 'icon' => 'fa-stethoscope'],
            ];
            $iconMap = [
            'fever' => 'fa-temperature-high', 'pain' => 'fa-temperature-high',
            'cold' => 'fa-head-side-cough', 'cough' => 'fa-head-side-cough',
            'diabet' => 'fa-droplet', 'heart' => 'fa-heart-pulse',
            'vitamin' => 'fa-apple-whole', 'skin' => 'fa-hand-sparkles',
            'baby' => 'fa-baby', 'aid' => 'fa-kit-medical',
            'ayur' => 'fa-leaf', 'digest' => 'fa-pills',
            'eye' => 'fa-eye', 'device' => 'fa-stethoscope',
            ];
            @endphp

            @if(!empty($categories) && count($categories) > 0)
            @foreach($categories as $index => $cat)
            @php
            $catName = is_object($cat) ? $cat->category : $cat;
            $catCount = is_object($cat) ? ($cat->total ?? 0) : 0;
            $icon = 'fa-capsules';
            foreach($iconMap as $key => $ic) {
            if(str_contains(strtolower($catName), $key)) { $icon = $ic; break; }
            }
            @endphp
            <div class="col-lg-2 col-md-3 col-sm-4 col-6" data-aos="zoom-in" data-aos-delay="{{ $index * 50 }}">
                <a href="{{ url('/customer/medicines?category='.urlencode($catName)) }}" class="category-card">
                    <div class="cat-icon"><i class="fas {{ $icon }}"></i></div>
                    <h6>{{ $catName }}</h6>
                    <span>{{ $catCount }} {{ __('messages.cat_explore') }}</span>
                </a>
            </div>
            @endforeach
            @else
            @foreach($defaultCategories as $index => $cat)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6" data-aos="zoom-in" data-aos-delay="{{ $index * 50 }}">
                <a href="{{ url('/customer/medicines?category='.urlencode($cat['name'])) }}" class="category-card">
                    <div class="cat-icon"><i class="fas {{ $cat['icon'] }}"></i></div>
                    <h6>{{ $cat['name'] }}</h6>
                    <span>{{ __('messages.cat_explore') }}</span>
                </a>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

<!-- ============ FEATURED MEDICINES ============ -->
<section class="section-padding" style="background: var(--white);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">{{ __('messages.featured_badge') }}</span>
            <h2 class="section-title">{!! __('messages.featured_title') !!}</h2>
            <p class="section-desc">{{ __('messages.featured_desc') }}</p>
        </div>

        <div class="row g-4">
            @if(!empty($featuredMedicines) && count($featuredMedicines) > 0)
            @foreach($featuredMedicines as $index => $med)
            <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">
                <div class="medicine-card">
                    <div class="med-img-wrap">
                        @if($med->image && file_exists(public_path('uploads/medicines/'.$med->image)))
                        <img src="{{ asset('uploads/medicines/'.$med->image) }}" alt="{{ $med->name }}">
                        @else
                        <i class="fas fa-capsules no-img"></i>
                        @endif

                        @if($med->prescription_required ?? false)
                        <span class="med-badge rx"><i class="fas fa-file-prescription"></i> Rx</span>
                        @elseif($med->featured ?? false)
                        <span class="med-badge featured"><i class="fas fa-star"></i> {{ __('messages.featured_badge') }}</span>
                        @endif

                        @if(($med->stock ?? 0) > 0)
                        <span class="med-stock in"><i class="fas fa-check-circle"></i> {{ __('messages.in_stock') }}</span>
                        @else
                        <span class="med-stock out"><i class="fas fa-times-circle"></i> {{ __('messages.out_of_stock') }}</span>
                        @endif
                    </div>

                    <div class="med-body">
                        <div class="med-cat">{{ $med->category ?? 'General' }}</div>
                        <h5>{{ $med->name }}</h5>
                        <div class="med-brand">
                            <i class="fas fa-store me-1"></i>
                            {{ $med->pharmacy->pharmacy_name ?? ($med->brand ?? 'Sanjivani Store') }}
                        </div>

                        <div class="med-rating">
                            @php $rating = round($med->reviews_avg_rating ?? 4.5); @endphp
                            <span class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= $rating ? 's' : 'r' }} fa-star"></i>
                                    @endfor
                            </span>
                            <span>({{ $med->reviews_count ?? rand(10, 90) }})</span>
                        </div>

                        <div class="med-footer">
                            <div class="med-price">
                                ₹{{ number_format($med->price, 2) }}
                                @if(!empty($med->mrp) && $med->mrp > $med->price)
                                <small>₹{{ number_format($med->mrp, 2) }}</small>
                                @endif
                            </div>
                            <a href="{{ url('/customer/medicine/'.$med->id) }}" class="btn-add-cart">
                                <i class="fas fa-cart-plus"></i> {{ __('messages.view') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-12 text-center py-5">
                <i class="fas fa-capsules" style="font-size:4rem;color:var(--mint-green);"></i>
                <h5 class="mt-3 text-muted">{{ __('messages.no_featured') }}</h5>
                <p class="text-muted">{{ __('messages.no_featured_desc') }}</p>
                <a href="{{ url('/customer/medicines') }}" class="btn-sanjivani mt-2">
                    <i class="fas fa-search"></i> {{ __('messages.browse_all') }}
                </a>
            </div>
            @endif
        </div>

        @if(!empty($featuredMedicines) && count($featuredMedicines) > 0)
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ url('/customer/medicines') }}" class="btn-sanjivani">
                {{ __('messages.view_all') }} <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @endif
    </div>
</section>

<!-- ============ HOW IT WORKS ============ -->
<section class="section-padding how-section">
    <div class="container position-relative">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">{{ __('messages.how_badge') }}</span>
            <h2 class="section-title">{!! __('messages.how_title') !!}</h2>
            <p class="section-desc">{{ __('messages.how_desc') }}</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="step-card">
                    <div class="step-num">
                        <i class="fas fa-user-plus"></i>
                        <span class="step-count">1</span>
                    </div>
                    <h5>{{ __('messages.how_step1_title') }}</h5>
                    <p>{{ __('messages.how_step1_desc') }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card">
                    <div class="step-num">
                        <i class="fas fa-magnifying-glass"></i>
                        <span class="step-count">2</span>
                    </div>
                    <h5>{{ __('messages.how_step2_title') }}</h5>
                    <p>{{ __('messages.how_step2_desc') }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card">
                    <div class="step-num">
                        <i class="fas fa-credit-card"></i>
                        <span class="step-count">3</span>
                    </div>
                    <h5>{{ __('messages.how_step3_title') }}</h5>
                    <p>{{ __('messages.how_step3_desc') }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card">
                    <div class="step-num">
                        <i class="fas fa-house-medical"></i>
                        <span class="step-count">4</span>
                    </div>
                    <h5>{{ __('messages.how_step4_title') }}</h5>
                    <p>{{ __('messages.how_step4_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ STATS ============ -->
<section class="stats-section">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-3 col-md-6 col-6" data-aos="zoom-in">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number counter" data-target="{{ $totalCustomers ?? 5240 }}">0</div>
                    <div class="stat-label">{{ __('messages.stat_happy_customers') }}</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-store"></i></div>
                    <div class="stat-number counter" data-target="{{ $totalPharmacies ?? 152 }}">0</div>
                    <div class="stat-label">{{ __('messages.stat_partner_pharmacies') }}</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-capsules"></i></div>
                    <div class="stat-number counter" data-target="{{ $totalMedicines ?? 1280 }}">0</div>
                    <div class="stat-label">{{ __('messages.stat_medicines_listed') }}</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-box-open"></i></div>
                    <div class="stat-number counter" data-target="{{ $totalOrders ?? 8760 }}">0</div>
                    <div class="stat-label">{{ __('messages.stat_orders_delivered') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ WHY CHOOSE US ============ -->
<section class="section-padding why-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="why-img-wrap">
                    <img src="https://images.unsplash.com/photo-1631549916768-4119b2e5f926?w=700&q=80" alt="Why Choose Sanjivani">
                    <div class="why-exp-badge">
                        <strong>10+</strong>
                        <span>{{ __('messages.why_badge') }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <span class="section-badge">{{ __('messages.why_badge') }}</span>
                <h2 class="section-title">{!! __('messages.why_title') !!}</h2>
                <p class="section-desc" style="text-align:left;">
                    {{ __('messages.why_desc') }}
                </p>

                <ul class="why-list">
                    <li>
                        <div class="why-icon"><i class="fas fa-village"></i><i class="fas fa-map-location-dot"></i></div>
                        <div>
                            <h6>{{ __('messages.why_village_title') }}</h6>
                            <p>{{ __('messages.why_village_desc') }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="why-icon"><i class="fas fa-file-shield"></i></div>
                        <div>
                            <h6>{{ __('messages.why_prescription_title') }}</h6>
                            <p>{{ __('messages.why_prescription_desc') }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="why-icon"><i class="fas fa-location-crosshairs"></i></div>
                        <div>
                            <h6>{{ __('messages.why_tracking_title') }}</h6>
                            <p>{{ __('messages.why_tracking_desc') }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="why-icon"><i class="fas fa-hand-holding-dollar"></i></div>
                        <div>
                            <h6>{{ __('messages.why_cod_title') }}</h6>
                            <p>{{ __('messages.why_cod_desc') }}</p>
                        </div>
                    </li>
                </ul>

                <a href="{{ url('/about') }}" class="btn-sanjivani mt-3">
                    {{ __('messages.why_learn_more') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ============ PRESCRIPTION CTA ============ -->
<section class="py-5" style="background: var(--white);">
    <div class="container">
        <div class="prescription-cta" data-aos="zoom-in">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3><i class="fas fa-file-prescription me-2"></i> {{ __('messages.rx_title') }}</h3>
                    <p>{{ __('messages.rx_desc') }}</p>
                    <a href="{{ url('/customer/prescription') }}" class="btn-white">
                        <i class="fas fa-cloud-arrow-up"></i> {{ __('messages.rx_upload_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ TESTIMONIALS ============ -->
<section class="section-padding" style="background: var(--off-white);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">{{ __('messages.test_badge') }}</span>
            <h2 class="section-title">{!! __('messages.test_title') !!}</h2>
            <p class="section-desc">{{ __('messages.test_desc') }}</p>
        </div>

        <div class="row g-4">
            @php
            $testimonials = [
            ['name'=>'Ramesh Patil','loc'=>'Nashik, Maharashtra','text'=>'Living in a small village, getting medicines was always a struggle. Sanjivani delivers right to my home within hours. Truly a life saver for my elderly parents.','rating'=>5],
            ['name'=>'Sunita Sharma','loc'=>'Jaipur, Rajasthan','text'=>'I uploaded my prescription at night and got all medicines the next morning. The pharmacist even called me to confirm the dosage. Excellent service!','rating'=>5],
            ['name'=>'Arjun Verma','loc'=>'Pune, Maharashtra','text'=>'Prices are much better than local shops and the app is very easy to use. Order tracking keeps me updated at every step. Highly recommended.','rating'=>4],
            ];
            @endphp

            @foreach($testimonials as $i => $t)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 120 }}">
                <div class="testimonial-card">
                    <i class="fas fa-quote-right quote-icon"></i>
                    <div class="t-stars">
                        @for($s = 1; $s <= 5; $s++)
                            <i class="fa{{ $s <= $t['rating'] ? 's' : 'r' }} fa-star"></i>
                            @endfor
                    </div>
                    <p>"{{ $t['text'] }}"</p>
                    <div class="testimonial-author">
                        <div class="avatar">{{ strtoupper(substr($t['name'], 0, 1)) }}</div>
                        <div>
                            <strong>{{ $t['name'] }}</strong>
                            <span><i class="fas fa-location-dot me-1"></i>{{ $t['loc'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ============ PARTNER WITH US ============ -->
<section class="section-padding" style="background: var(--white);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">{{ __('messages.partner_badge') }}</span>
            <h2 class="section-title">{!! __('messages.partner_title') !!}</h2>
            <p class="section-desc">{{ __('messages.partner_desc') }}</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="partner-card pharmacy">
                    <div class="p-icon"><i class="fas fa-store"></i></div>
                    <h4>{{ __('messages.partner_pharmacy_title') }}</h4>
                    <p>{{ __('messages.partner_pharmacy_desc') }}</p>
                    <a href="{{ url('/register?role=pharmacy') }}" class="btn-partner">
                        {{ __('messages.partner_pharmacy_btn') }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="partner-card delivery">
                    <div class="p-icon"><i class="fas fa-motorcycle"></i></div>
                    <h4>{{ __('messages.partner_delivery_title') }}</h4>
                    <p>{{ __('messages.partner_delivery_desc') }}</p>
                    <a href="{{ url('/register?role=delivery') }}" class="btn-partner">
                        {{ __('messages.partner_delivery_btn') }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="cta-section">
    <div class="container" data-aos="zoom-in">
        <h3>{{ __('messages.cta_title') }}</h3>
        <p>{{ __('messages.cta_desc') }}</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ url('/register') }}" class="btn-sanjivani">
                <i class="fas fa-user-plus"></i> {{ __('messages.cta_create_account') }}
            </a>
            <a href="{{ url('/contact') }}" class="btn-sanjivani-outline">
                <i class="fas fa-phone"></i> {{ __('messages.cta_talk') }}
            </a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        /* ---------- Hero Search Validation ---------- */
        $('#heroSearchForm').on('submit', function(e) {
            var val = $.trim($('#heroSearchInput').val());
            var $err = $('#heroSearchError');

            $err.hide().text('');

            if (val === '') {
                e.preventDefault();
                $err.text('⚠ ' + @json(__('messages.js_search_required'))).fadeIn();
                $('#heroSearchInput').focus();
                return false;
            }
            if (val.length < 2) {
                e.preventDefault();
                $err.text('⚠ ' + @json(__('messages.js_search_min'))).fadeIn();
                return false;
            }
            if (!/^[a-zA-Z0-9\s\-\.\+]+$/.test(val)) {
                e.preventDefault();
                $err.text('⚠ ' + @json(__('messages.js_search_invalid'))).fadeIn();
                return false;
            }
            return true;
        });

        $('#heroSearchInput').on('keyup', function() {
            if ($.trim($(this).val()) !== '') {
                $('#heroSearchError').fadeOut();
            }
        });

        /* ---------- Animated Counters ---------- */
        var countersStarted = false;

        function animateCounters() {
            $('.counter').each(function() {
                var $this = $(this);
                var target = parseInt($this.data('target')) || 0;

                $({
                    count: 0
                }).animate({
                    count: target
                }, {
                    duration: 2200,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.count).toLocaleString());
                    },
                    complete: function() {
                        $this.text(target.toLocaleString() + '+');
                    }
                });
            });
        }

        $(window).on('scroll load', function() {
            var $stats = $('.stats-section');
            if ($stats.length && !countersStarted) {
                var top = $stats.offset().top;
                if ($(window).scrollTop() + $(window).height() > top + 80) {
                    countersStarted = true;
                    animateCounters();
                }
            }
        });

        /* ---------- Newsletter Validation (Footer) ---------- */
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            var $input = $(this).find('input[type="email"], input[type="text"]').first();
            var email = $.trim($input.val());
            var regex = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;

            if (email === '') {
                alert(@json(__('messages.js_email_required')));
                $input.focus();
                return false;
            }
            if (!regex.test(email)) {
                alert(@json(__('messages.js_email_invalid')));
                $input.focus();
                return false;
            }

            var $btn = $(this).find('button');
            var original = $btn.html();
            $btn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            setTimeout(function() {
                $btn.html('<i class="fas fa-check"></i> Done').prop('disabled', false);
                $input.val('');
                setTimeout(function() {
                    $btn.html(original);
                }, 2000);
            }, 1200);
        });

        /* ---------- Smooth Anchor Scroll ---------- */
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this).attr('href');
            if (target.length > 1 && $(target).length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $(target).offset().top - 110
                }, 600);
            }
        });

        /* ---------- Medicine Card Hover Tilt (subtle) ---------- */
        $('.medicine-card').on('mouseenter', function() {
            $(this).find('.btn-add-cart').addClass('animate__animated animate__pulse');
        }).on('mouseleave', function() {
            $(this).find('.btn-add-cart').removeClass('animate__animated animate__pulse');
        });

    });
</script>
@endsection