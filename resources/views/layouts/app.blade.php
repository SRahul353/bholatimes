@php
    $themeSettingsPath = storage_path('app/theme_settings.json');
    $themeSettings = [
        'logo_text' => 'দৈনিক ভোলা<span>টাইমস্</span>',
        'logo_image' => '',
        'footer_logo_image' => '',
        'primary_color' => '#1a1a2e',
        'accent_color' => '#e70d0d',
        'bg_site' => '#f0f1f5',
        'text_main' => '#1e1e2f',
        'font_family' => "'Noto Sans Bengali', 'Outfit', sans-serif",
        'custom_css' => '',
        'footer_text' => 'দৈনিক ভোলা টাইমস্ জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র। আমরা অত্যন্ত সততা, নিষ্ঠা ও নিরপেক্ষতার সাথে সব ধরণের স্থানীয় ও জাতীয় সংবাদ সবার আগে প্রকাশ করি।',
        'social_facebook' => '#',
        'social_twitter' => '#',
        'social_youtube' => '#',
        'social_instagram' => '#',
        'contact_address' => 'বার্তা ও বাণিজ্যিক কার্যালয়- আমানত পাড়া, ভোলা।',
        'contact_phone' => '০১৭১১৪৬৯৫৩৯',
        'contact_email' => 'news.bholatimes@gmail.com',
        'editorial_board_president' => 'সামস্-উল-আলম মিঠু',
        'editorial_publisher' => 'মোঃ আলী জিন্নাহ (রাজিব)',
        'editorial_editor' => 'মোঃ হেলাল উদ্দিন',
        'copyright_text' => 'দৈনিক ভোলা টাইমস্. সর্বস্বত্ব সংরক্ষিত।'
    ];
    if (file_exists($themeSettingsPath)) {
        $themeSettings = array_merge($themeSettings, json_decode(file_get_contents($themeSettingsPath), true));
    }
@endphp
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary SEO Meta Tags -->
    <title>@yield('title', 'দৈনিক ভোলা টাইমস্ | Dainik Bhola Times - সত্যের সন্ধানে সার্বক্ষণিক')</title>
    <meta name="description" content="@yield('meta_description', $themeSettings['footer_text'] ?? 'দৈনিক ভোলা টাইমস্ - ভোলা জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র। আমরা অত্যন্ত সততা, নিষ্ঠা ও নিরপেক্ষতার সাথে সব ধরণের স্থানীয় ও জাতীয় সংবাদ সবার আগে প্রকাশ করি।')">
    <meta name="keywords" content="@yield('meta_keywords', 'দৈনিক ভোলা টাইমস্, ভোলা টাইমস্, ভোলা নিউজ, dainik bhola times, bhola times, bhola news, dainikbholatimes, bholatimes, bhola newspaper')">
    <meta name="author" content="দৈনিক ভোলা টাইমস্">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical_url', request()->url())">
    
    <!-- Open Graph / Facebook Meta Tags -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'দৈনিক ভোলা টাইমস্ | Dainik Bhola Times')">
    <meta property="og:description" content="@yield('og_description', $themeSettings['footer_text'] ?? 'দৈনিক ভোলা টাইমস্ - ভোলা জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র।')">
    <meta property="og:image" content="@yield('og_image', asset($themeSettings['logo_image'] ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=800'))">
    <meta property="og:url" content="@yield('og_url', request()->url())">
    <meta property="og:site_name" content="দৈনিক ভোলা টাইমস্">
    <meta property="og:locale" content="bn_BD">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'দৈনিক ভোলা টাইমস্ | Dainik Bhola Times')">
    <meta name="twitter:description" content="@yield('og_description', $themeSettings['footer_text'] ?? 'দৈনিক ভোলা টাইমস্ - ভোলা জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র।')">
    <meta name="twitter:image" content="@yield('og_image', asset($themeSettings['logo_image'] ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=800'))">
    
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&family=Noto+Serif+Bengali:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5.3.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        :root {
            --primary: {{ $themeSettings['primary_color'] ?? '#1a1a2e' }};      /* Jugantor Dark Navy */
            --primary-light: #2d2d44;
            --accent: {{ $themeSettings['accent_color'] ?? '#e70d0d' }};       /* Jugantor Red */
            --accent-hover: #c60b0b;
            --accent-light: #fff1f1;
            --bg-site: {{ $themeSettings['bg_site'] ?? '#f0f1f5' }};      /* Soft Gray Background */
            --bg-card: #ffffff;
            --text-main: {{ $themeSettings['text_main'] ?? '#1e1e2f' }};    /* Deep charcoal */
            --text-dark: {{ $themeSettings['primary_color'] ?? '#1a1a2e' }};    /* Deep dark */
            --text-light: #6b7280;   /* Cool grey */
            --border-color: #e5e7eb;  /* Clean gray border */
            --shadow-sm: 0 1px 3px rgba(26, 26, 46, 0.06);
            --shadow-md: 0 4px 8px -1px rgba(26, 26, 46, 0.1), 0 2px 4px -1px rgba(26, 26, 46, 0.05);
            --shadow-lg: 0 10px 25px -5px rgba(26, 26, 46, 0.1), 0 8px 16px -8px rgba(26, 26, 46, 0.06);
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Basic Resets & Aesthetics */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: {!! $themeSettings['font_family'] ?? "'Noto Sans Bengali', 'Outfit', sans-serif" !!};
            background-color: var(--bg-site);
            color: var(--text-main);
            line-height: 1.7;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: var(--transition);
        }

        /* Container Layout */
        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Premium Header System */
        .top-bar {
            background-color: var(--primary);
            color: #ffffff;
            font-size: 0.82rem;
            padding: 10px 0;
            border-bottom: 3px solid var(--accent);
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        .top-bar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .date-time {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .date-time i {
            color: var(--accent);
        }

        .top-nav-links {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .top-nav-link {
            color: #cbd5e1;
            transition: var(--transition);
            font-weight: 500;
        }

        .top-nav-link:hover {
            color: #ffffff;
        }

        .top-socials {
            display: flex;
            gap: 12px;
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            padding-left: 12px;
        }

        .top-socials a {
            color: #cbd5e1;
        }

        .top-socials a:hover {
            color: var(--accent);
            transform: translateY(-1px);
        }

        .main-header {
            background-color: #ffffff;
            padding: 24px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .header-masthead {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .masthead-left, .masthead-right {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .masthead-right {
            justify-content: flex-end;
        }

        .masthead-center {
            flex: 2;
        }

        .masthead-btn {
            background-color: #f1f2f6;
            color: var(--text-main);
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 700;
            transition: var(--transition);
            border: 1px solid #e2e8f0;
            font-family: 'Noto Sans Bengali', sans-serif;
            display: inline-flex;
            align-items: center;
        }

        .masthead-btn:hover {
            background-color: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
            box-shadow: 0 4px 10px rgba(227, 28, 37, 0.15);
        }

        .btn-epaper {
            background-color: var(--accent);
            color: #ffffff;
            border-color: var(--accent);
        }

        .btn-epaper:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
        }

        .logo-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            font-family: 'Noto Serif Bengali', serif;
            font-size: 3.2rem;
            font-weight: 900;
            color: var(--primary);
            letter-spacing: -1.5px;
            line-height: 1;
            margin: 0;
        }

        .logo-text span {
            color: var(--accent);
        }

        .logo-tagline {
            font-size: 0.82rem;
            color: var(--text-light);
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 6px;
            text-transform: uppercase;
        }

        /* Mock Advertisement Banner */
        .header-ad-frame {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
            height: 100%;
        }

        .header-ad-label {
            font-size: 0.68rem;
            color: var(--text-light);
            text-transform: uppercase;
            margin-bottom: 3px;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .header-ad-box {
            width: 728px;
            height: 90px;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1px dashed #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
            color: #94a3b8;
            font-size: 0.82rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .header-ad-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100px;
            width: 50px;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            transform: skewX(-15deg);
            animation: shineAd 6s infinite;
        }

        @keyframes shineAd {
            0% { left: -100px; }
            15% { left: 100%; }
            100% { left: 100%; }
        }

        .header-ad-box:hover {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #64748b;
            border-color: #94a3b8;
        }

        /* Elegant Sticky Navigation */
        .nav-bar {
            background-color: var(--accent);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(231, 13, 13, 0.15);
            border-bottom: none;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 52px;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            height: 100%;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            height: 100%;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0 16px;
            height: 100%;
            font-weight: 700;
            font-size: 1.02rem;
            color: #ffffff;
            transition: var(--transition);
            border-bottom: 3px solid transparent;
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff;
            border-bottom-color: #ffffff;
            background-color: rgba(255, 255, 255, 0.12);
        }

        .nav-home-icon {
            font-size: 1.15rem;
        }

        /* Search Bar Widget */
        .search-box {
            display: flex;
            align-items: center;
            position: relative;
        }

        .search-input {
            padding: 6px 14px 6px 36px;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 50px;
            font-size: 0.85rem;
            outline: none;
            width: 170px;
            transition: var(--transition);
            font-family: inherit;
            background-color: rgba(255,255,255,0.15);
            color: #ffffff;
        }

        .search-input:focus {
            width: 220px;
            border-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
            background-color: rgba(255,255,255,0.25);
        }

        .search-input::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .search-icon-btn {
            position: absolute;
            left: 12px;
            background: none;
            border: none;
            color: rgba(255,255,255,0.7);
            cursor: pointer;
            outline: none;
        }

        .search-icon-btn:hover {
            color: #ffffff;
        }

        /* Mobile Hamburger */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: var(--primary);
            cursor: pointer;
            outline: none;
        }

        /* Breaking News Ticker System */
        .ticker-section {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 8px 0;
            display: flex;
            align-items: center;
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        .ticker-container {
            display: flex;
            align-items: center;
            width: 100%;
            overflow: hidden;
        }

        .ticker-label {
            background-color: var(--accent);
            color: #ffffff;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            margin-right: 16px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 3px 6px rgba(227, 28, 37, 0.15);
            animation: pulseTicker 2s infinite;
        }

        @keyframes pulseTicker {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .ticker-wrap {
            flex-grow: 1;
            overflow: hidden;
            white-space: nowrap;
        }

        .ticker-marquee {
            display: inline-block;
            animation: marquee 60s linear infinite;
            padding-left: 100%;
        }

        .ticker-marquee:hover {
            animation-play-state: paused;
        }

        @keyframes marquee {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-100%, 0, 0); }
        }

        .ticker-item {
            display: inline-flex;
            align-items: center;
            color: var(--text-main);
            font-size: 0.95rem;
            font-weight: 600;
            margin-right: 32px;
            transition: var(--transition);
        }

        .ticker-item:hover {
            color: var(--accent);
        }

        .ticker-bullet {
            width: 6px;
            height: 6px;
            background-color: var(--accent);
            border-radius: 50%;
            margin-right: 10px;
            display: inline-block;
        }

        /* Main Content Layout */
        .main-content {
            padding: 24px 0 48px 0;
            min-height: calc(100vh - 450px);
        }

        /* Premium Sidebar Widget Styles */
        .sidebar-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
        }

        .sidebar-title {
            font-family: 'Noto Serif Bengali', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 16px;
            padding-bottom: 6px;
            border-bottom: 2px solid var(--accent);
            display: inline-block;
        }

        /* Sidebar Popular list styling globally */
        .sidebar-popular-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-popular-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }

        .sidebar-popular-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .sidebar-popular-img-box {
            width: 80px;
            height: 60px;
            border-radius: var(--radius-sm, 6px);
            overflow: hidden;
            flex-shrink: 0;
            background-color: #f1f5f9;
        }

        .sidebar-popular-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .sidebar-popular-item:hover .sidebar-popular-img {
            transform: scale(1.05);
        }

        .sidebar-popular-title {
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.4;
            margin: 0;
        }

        .sidebar-popular-title a:hover {
            color: var(--accent);
        }

        /* High-End Dark Footer */
        .main-footer {
            background-color: #111827;
            color: #cbd5e1;
            padding: 56px 0 20px 0;
            border-top: 4px solid var(--accent);
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
            margin-bottom: 40px;
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: 35fr 65fr;
            }
        }

        .footer-brand-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 16px;
            font-family: 'Noto Serif Bengali', serif;
        }

        .footer-brand-title span {
            color: var(--accent);
        }

        .footer-text {
            font-size: 0.92rem;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 24px;
            max-width: 460px;
        }

        .footer-social-icons {
            display: flex;
            gap: 12px;
        }

        .footer-social-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            background-color: #1e293b;
            border-radius: 50%;
            color: #ffffff;
            font-size: 1rem;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-social-btn:hover {
            background-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(227, 28, 37, 0.3);
        }

        .footer-sec-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 16px;
            position: relative;
            padding-bottom: 6px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer-sec-title::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--accent);
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 0;
            padding: 0;
        }

        .footer-link {
            font-size: 0.92rem;
            color: #94a3b8;
            transition: var(--transition);
            display: inline-block;
        }

        .footer-link:hover {
            color: #ffffff;
            padding-left: 4px;
        }

        .footer-contact {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 0.92rem;
            color: #94a3b8;
            margin: 0;
            padding: 0;
        }

        .footer-contact li {
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .footer-contact i {
            color: var(--accent);
            margin-top: 4px;
        }

        .footer-editorial {
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .footer-editorial p {
            font-size: 0.85rem;
            margin-bottom: 4px;
            color: #94a3b8;
        }

        .footer-editorial strong {
            color: #e2e8f0;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #64748b;
        }

        @media (min-width: 768px) {
            .footer-bottom {
                flex-direction: row;
            }
        }

        /* Mobile Drawer Drawer Style */
        .mobile-drawer {
            position: fixed;
            top: 0;
            left: -300px;
            width: 280px;
            height: 100%;
            background-color: var(--primary);
            z-index: 10000;
            padding: 24px;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            gap: 24px;
            color: #ffffff;
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        .mobile-drawer.open {
            left: 0;
        }

        .mobile-drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 12px;
        }

        .mobile-drawer-close {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.4rem;
            cursor: pointer;
            outline: none;
        }

        .mobile-drawer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 0;
            margin: 0;
        }

        .mobile-drawer-link {
            font-size: 1.1rem;
            font-weight: 600;
            display: block;
            padding: 6px 0;
            transition: var(--transition);
        }

        .mobile-drawer-link:hover {
            color: var(--accent);
            padding-left: 6px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(10, 17, 40, 0.5);
            backdrop-filter: blur(3px);
            z-index: 9999;
            display: none;
        }

        .overlay.show {
            display: block;
        }

        /* Responsive Media Queries */
        @media (max-width: 1024px) {
            .nav-menu {
                display: none;
            }
            .mobile-menu-toggle {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .logo-text {
                font-size: 2.2rem;
                text-align: center;
            }
            .logo-tagline {
                text-align: center;
            }
            .main-header {
                padding: 12px 0;
            }
            .top-bar-content {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }
            .top-socials {
                border-left: none;
                padding-left: 0;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 12px;
            }
            .logo-text {
                font-size: 1.8rem;
            }
            .main-header {
                padding: 8px 0;
            }
            .top-bar {
                font-size: 0.75rem;
                padding: 6px 0;
            }
            .ticker-item {
                font-size: 0.85rem;
            }
            .main-content {
                padding: 16px 0 32px 0;
            }
        }

        /* Hover Dropdowns and Sub-dropdowns Styling */
        @media (min-width: 1025px) {
            .nav-item.dropdown:hover > .dropdown-menu {
                display: block;
                opacity: 1;
                visibility: visible;
                margin-top: 0;
                transform: translateY(0);
            }
            
            .nav-item.dropdown > .nav-link i {
                transition: transform 0.2s ease-in-out;
            }
            .nav-item.dropdown:hover > .nav-link i {
                transform: rotate(180deg);
            }

            .dropdown-menu {
                display: block;
                opacity: 0;
                visibility: hidden;
                transform: translateY(10px);
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                margin-top: 5px;
            }
            
            /* Nested Sub-menus positioning */
            .dropdown-submenu {
                position: relative;
            }
            
            .dropdown-submenu > .dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: -6px;
                margin-left: 0px;
                border-radius: 0 var(--radius-md) var(--radius-md) var(--radius-md);
            }
            
            .dropdown-submenu:hover > .dropdown-menu {
                display: block;
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
        }

        /* Fade-in Animation for Bootstrap 5 Dropdowns */
        .animate {
            animation-duration: 0.2s;
            animation-fill-mode: both;
        }
        .fade-in {
            animation-name: fadeIn;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Scroll Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Reading Progress Bar */
        .reading-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), #ff6b35);
            z-index: 10001;
            transition: width 0.1s linear;
            box-shadow: 0 0 8px rgba(231, 13, 13, 0.4);
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 44px;
            height: 44px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 50%;
            font-size: 1.1rem;
            cursor: pointer;
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(231, 13, 13, 0.3);
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .back-to-top:hover {
            background: var(--accent-hover);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(231, 13, 13, 0.4);
        }

        /* Custom Selection */
        ::selection {
            background-color: var(--accent);
            color: #ffffff;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #c4c4c4;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        /* Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
            html { scroll-behavior: auto; }
            .reveal { opacity: 1; transform: none; }
        }

        /* Card Image Overlay on Hover */
        .news-grid-img-box::after,
        .lead-image-box::after,
        .side-lead-img-box::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.15) 0%, transparent 50%);
            opacity: 0;
            transition: var(--transition);
            pointer-events: none;
        }
        .news-grid-card:hover .news-grid-img-box::after,
        .lead-news-card:hover .lead-image-box::after,
        .side-lead-card:hover .side-lead-img-box::after {
            opacity: 1;
        }

        /* Jugantor-style accent border on sections */
        .section-accent-border {
            border-left: 4px solid var(--accent);
            padding-left: 12px;
        }

        {!! $themeSettings['custom_css'] ?? '' !!}
    </style>
    @yield('styles')
</head>
<body>

    @include('layouts.partials.header')

    <!-- Main Content Area -->
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    @include('layouts.partials.footer')

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" title="উপরে যান">
        <i class="fa-solid fa-chevron-up"></i>
    </button>

    <!-- Scroll Reveal & Back-to-Top Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Back to top
            const backToTop = document.getElementById('backToTop');
            if (backToTop) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 400) {
                        backToTop.classList.add('visible');
                    } else {
                        backToTop.classList.remove('visible');
                    }
                });
                backToTop.addEventListener('click', function() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Scroll reveal
            const reveals = document.querySelectorAll('.reveal');
            if (reveals.length > 0) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('revealed');
                        }
                    });
                }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
                reveals.forEach(function(el) { observer.observe(el); });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
