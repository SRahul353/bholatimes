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
        'footer_text' => 'দৈনিক ভোলা টাইমস্ জেলার শীর্ষস্থানীয় একটি অনলাইন সংবাদপত্র। আমরা অত্যন্ত সততা, নিষ্ঠা ও নিরপেক্ষতার সাথে সব ধরণের স্থানীয় ও জাতীয় সংবাদ সবার আগে প্রকাশ করি।',
        'social_facebook' => '#',
        'social_twitter' => '#',
        'social_youtube' => '#',
        'social_instagram' => '#',
        'contact_address' => 'বার্তা ও বাণিজ্যিক কার্যালয়- আমানত পাড়া, ভোলা।',
        'contact_phone' => '০১৭১১৪৬৯৫৩৯',
        'contact_email' => 'news.bholatimes@gmail.com',
        'editorial_board_president' => 'সামস্-উল-আলম মিঠু',
        'editorial_publisher' => 'মোঃ আলী জিন্নাহ (রাজিব)',
        'editorial_editor' => 'মোঃ হেলাল উদ্দিন',
        'copyright_text' => 'দৈনিক ভোলা টাইমস্। সর্বস্বত্ব সংরক্ষিত।'
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
    <title>ডিজিটাল ই-পেপার | দৈনিক ভোলা টাইমস্</title>
    
    <!-- SEO Optimization Meta Tags -->
    <meta name="description" content="দৈনিক ভোলা টাইমস্ ডিজিটাল ই-পেপার সংস্করণ - ভোলার প্রথম ও জনপ্রিয় অনলাইন ও প্রিন্ট পত্রিকার প্রতিদিনের ই-পেপার ব্রডশিট সংস্করণ।">
    <meta name="keywords" content="দৈনিক ভোলা টাইমস্, ই-পেপার, ভোলা নিউজ, ভোলা জেলা সংবাদপত্র, Dainik Bhola Times, E-Paper Bhola, Bhola Times e-paper">
    <meta name="author" content="দৈনিক ভোলা টাইমস্">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="ডিজিটাল ই-পেপার | দৈনিক ভোলা টাইমস্">
    <meta property="og:description" content="দৈনিক ভোলা টাইমস্ ডিজিটাল ই-পেপার সংস্করণ - ভোলার প্রথম ও জনপ্রিয় অনলাইন ও প্রিন্ট পত্রিকার প্রতিদিনের ই-পেপার ব্রডশিট সংস্করণ।">
    <meta property="og:image" content="{{ asset('assets/images/og-image.jpg') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="ডিজিটাল ই-পেপার | দৈনিক ভোলা টাইমস্">
    <meta property="twitter:description" content="দৈনিক ভোলা টাইমস্ ডিজিটাল ই-পেপার সংস্করণ - ভোলার প্রথম ও জনপ্রিয় অনলাইন ও প্রিন্ট পত্রিকার প্রতিদিনের ই-পেপার ব্রডশিট সংস্করণ।">

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
            --primary: {{ $themeSettings['primary_color'] ?? '#1a1a2e' }};
            --primary-light: #2d2d44;
            --accent: {{ $themeSettings['accent_color'] ?? '#e70d0d' }};
            --accent-hover: #c60b0b;
            --bg-site: {{ $themeSettings['bg_site'] ?? '#f0f1f5' }};
            --bg-card: #ffffff;
            --text-main: {{ $themeSettings['text_main'] ?? '#1e1e2f' }};
            --text-dark: {{ $themeSettings['primary_color'] ?? '#1a1a2e' }};
            --text-light: #6b7280;
            --border-color: #cbd5e1;
            --shadow-sm: 0 1px 3px rgba(26, 26, 46, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(26, 26, 46, 0.08);
            --shadow-lg: 0 10px 20px -5px rgba(26, 26, 46, 0.1);
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Noto Sans Bengali', 'Outfit', sans-serif;
            background-color: #1a1a24; /* Match epaper dark slate canvas */
            margin: 0;
            padding: 0;
            color: var(--text-main);
        }

        .epaper-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 32px 0;
            background-color: #1a1a24; /* Sleek dark slate canvas */
            min-height: 100vh;
        }
        
        .epaper-controls {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            align-items: center;
            flex-wrap: wrap;
            width: 100%;
            max-width: 1200px;
        }

        .epaper-container {
            width: 100%;
            max-width: 1200px; /* Broadsheet Desktop Width */
            background-color: #f6f3eb; /* Genuine newsprint cream background */
            border: 12px solid #111111; /* Classic heavy black border frame */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            display: flex;
            flex-direction: column;
            color: #111111; /* Charcoal printed ink */
            font-family: 'Noto Serif Bengali', serif;
            position: relative;
            padding: 24px;
            box-sizing: border-box;
            /* Broad sheet 14x25 ratio */
            aspect-ratio: 14 / 25;
            overflow: hidden;
            transition: var(--transition);
        }

        /* Broad sheet Masthead */
        .epaper-masthead {
            grid-column: span 8;
            grid-row: span 2;
            border-bottom: 5px double #111111;
            padding-bottom: 8px;
            margin-bottom: 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .epaper-logo {
            font-family: 'Noto Serif Bengali', serif;
            font-size: 3.8rem;
            font-weight: 900;
            color: #111111;
            letter-spacing: -2px;
            line-height: 1;
            margin-bottom: 8px;
        }

        .epaper-logo span {
            color: var(--accent);
        }

        .epaper-slogan {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 8px;
            color: #333333;
            text-transform: uppercase;
        }

        .epaper-meta-strip {
            border-top: 1px solid #111111;
            border-bottom: 1px solid #111111;
            padding: 6px 16px;
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            font-weight: 700;
            color: #111111;
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        /* Broadsheet Columns Grid */
        .epaper-broadsheet-grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            grid-template-rows: repeat(16, 1fr);
            gap: 16px;
            flex-grow: 1;
            overflow: hidden;
        }

        /* News Article Box in Print layout */
        .print-news-article {
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            min-width: 0;
            background-color: transparent;
            overflow: hidden;
        }

        .print-news-article:hover {
            background-color: rgba(231, 13, 13, 0.03);
            transform: scale(1.005);
        }

        /* Empty broadsheet slot placeholder styling */
        .print-news-article.empty-slot {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed rgba(17, 17, 17, 0.2);
            background-color: rgba(17, 17, 17, 0.015);
            padding: 16px;
            box-sizing: border-box;
            text-align: center;
            color: #555555;
            transition: var(--transition);
            cursor: default;
        }
        
        .print-news-article.empty-slot:hover {
            background-color: rgba(231, 13, 13, 0.01);
            border-color: rgba(17, 17, 17, 0.3);
        }

        .print-news-article.empty-slot i {
            font-size: 1.8rem;
            margin-bottom: 8px;
            color: var(--accent);
            opacity: 0.5;
        }

        .print-news-article.empty-slot h5 {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 4px;
            font-family: 'Noto Sans Bengali', sans-serif;
            color: #333333;
        }

        .print-news-article.empty-slot p {
            font-size: 0.75rem;
            margin: 0;
            color: #666666;
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        .print-title {
            font-size: 0.95rem;
            font-weight: 800;
            line-height: 1.35;
            margin-bottom: 6px;
            color: #111111;
            text-align: center;
        }

        .print-lead-title {
            font-size: 1.9rem;
            font-weight: 900;
            line-height: 1.25;
            margin-bottom: 10px;
            color: #111111;
            text-align: center;
        }

        .print-image-wrapper {
            width: 100%;
            overflow: hidden;
            margin-bottom: 10px;
            border: 1px solid #111111;
            background-color: #cbd5e1;
        }

        .print-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: grayscale(100%) contrast(125%); /* Authentic printed broadsheet grayscale */
            transition: var(--transition);
        }

        .print-excerpt {
            font-size: 0.82rem;
            line-height: 1.55;
            color: #222222;
            text-align: justify;
            overflow: hidden;
            display: block;
            text-overflow: clip;
        }

        /* Specific layouts for different broadsheet spans in 8-column layout */
        .span-4 {
            grid-column: span 4;
            border-right: 1px solid rgba(17, 17, 17, 0.15);
            padding-right: 14px;
            border-bottom: 2px solid #111111;
            padding-bottom: 16px;
            margin-bottom: 4px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .span-3 {
            grid-column: span 3;
            border-right: none; /* Last in the row */
            padding-right: 0;
            border-bottom: 2px solid #111111;
            padding-bottom: 16px;
            margin-bottom: 4px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .span-2 {
            grid-column: span 2;
            border-right: 1px solid rgba(17, 17, 17, 0.15);
            padding-right: 14px;
            border-bottom: 1px solid rgba(17, 17, 17, 0.15);
            padding-bottom: 14px;
            margin-bottom: 4px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .span-2-last {
            border-right: none;
            padding-right: 0;
        }

        .span-1 {
            grid-column: span 1;
            border-right: 1px solid rgba(17, 17, 17, 0.15);
            padding-right: 12px;
            border-bottom: 2px solid #111111;
            padding-bottom: 16px;
            margin-bottom: 4px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .span-1-last {
            border-right: none;
            padding-right: 0;
        }

        /* Bottom Broad Sheet Declaration info */
        .broadsheet-footer-brand {
            border-top: 1px dashed rgba(17, 17, 17, 0.3);
            margin-top: 12px;
            padding-top: 8px;
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            font-weight: 600;
            color: #444444;
        }

        /* Page 2 Masthead Banner */
        .epaper-masthead-page2 {
            grid-column: span 8;
            grid-row: span 2;
            border-bottom: 5px double #111111;
            padding-bottom: 8px;
            margin-bottom: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Noto Sans Bengali', sans-serif;
            color: #111111;
        }
        .epaper-masthead-page2 .left-brand {
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: -1px;
        }
        .epaper-masthead-page2 .left-brand span {
            color: var(--accent);
        }
        .epaper-masthead-page2 .center-title {
            font-size: 1.15rem;
            font-weight: 800;
            border: 2px solid #111111;
            padding: 4px 16px;
            background-color: transparent;
            letter-spacing: 1px;
        }
        .epaper-masthead-page2 .right-meta {
            font-size: 0.85rem;
            font-weight: 700;
            text-align: right;
            line-height: 1.4;
        }

        /* Print Media Stylesheet */
        @media print {
            .epaper-controls, .epaper-page-divider, .fallback-box-wrapper {
                display: none !important;
            }
            body {
                background-color: #ffffff !important;
            }
            .epaper-wrapper {
                padding: 0 !important;
                background-color: #ffffff !important;
            }
            .epaper-container {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                page-break-after: always;
                aspect-ratio: auto !important;
            }
        }
    </style>
</head>
<body>

<div class="epaper-wrapper">
    <!-- Action Controls and Date Picker -->
    <div class="epaper-controls container d-flex flex-wrap align-items-center justify-content-between gap-3 px-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i>পোর্টাল হোমপেজ</a>
            <button class="btn btn-primary btn-sm" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>প্রিন্ট ভিউ (Print)</button>
            <span class="badge bg-danger p-2 d-none d-md-inline-block"><i class="fa-solid fa-expand me-1"></i>ডাবল ক্লিক করে বড় করুন</span>
        </div>
        
        <form action="{{ route('epaper') }}" method="GET" class="d-flex align-items-center gap-2 m-0 bg-dark p-1 px-2 rounded border border-secondary">
            <label for="epaperDate" class="text-white mb-0 d-none d-sm-inline-block" style="font-family: 'Noto Sans Bengali', sans-serif; font-size: 0.85rem;">তারিখ নির্বাচন করুন:</label>
            <input type="date" id="epaperDate" name="date" class="form-control form-control-sm border-0 text-dark" style="max-width: 150px; font-family: 'Outfit', 'Noto Sans Bengali', sans-serif; font-size: 0.85rem;" value="{{ $selectedDate->format('Y-m-d') }}">
            <button type="submit" class="btn btn-danger btn-sm" style="font-family: 'Noto Sans Bengali', sans-serif; background-color: var(--accent); border-color: var(--accent); font-size: 0.85rem;"><i class="fa-solid fa-magnifying-glass me-1"></i>ই-পেপার দেখুন</button>
        </form>
    </div>

    @if($hasSavedEPaper && $posts->filter()->count() > 0)
        <!-- The 14x21 broadsheet page wrapper -->
        <div class="epaper-container" id="broadsheetPaper">

            <!-- Broadsheet Columns Grid (8 columns layout, 16 rows) -->
            <div class="epaper-broadsheet-grid">
                
                <!-- Broadsheet Masthead (8 columns, 2 rows) -->
                <header class="epaper-masthead">
                    <h1 class="epaper-logo">দৈনিক ভোলা<span>টাইমস্</span></h1>
                    <p class="epaper-slogan">সত্যের সন্ধানে সার্বক্ষণিক | প্রথম পাতা</p>
                    
                    <div class="epaper-meta-strip">
                        <span>ভলিউম: ১০ | সংখ্যা: ১৪২</span>
                        <span>
                            <span id="epaperCurrentDate"></span>
                            <span class="mx-2">|</span>
                            <span id="epaperHijriDate"></span>
                        </span>
                        <span>মূল্য: ৫ টাকা</span>
                    </div>
                </header>
                
                <!-- ROW 1: 8 Columns total (4 + 1 + 3) -->
                <!-- Slot 1 (Lead story): spans 4 columns, 4 rows -->
                @if($posts->count() > 0 && $posts->get(0))
                    @php $lead = $posts->get(0); @endphp
                    <article class="print-news-article span-4" style="grid-row: span 4;" onclick="openPrintReader(this)"
                             data-title="{{ $lead->title }}"
                             data-content="{{ strip_tags($lead->content) }}"
                             data-image="{{ $lead->featured_image_url }}"
                             data-author="{{ $lead->user ? $lead->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $lead->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $lead->slug) }}">
                        <h2 class="print-lead-title" style="width: 100%; text-align: center; font-size: 1.5rem; font-weight: 900; line-height: 1.3; margin-top: 4px; margin-bottom: 8px; border-bottom: 1px solid rgba(17, 17, 17, 0.15); padding-bottom: 6px; flex-shrink: 0;">
                            {{ $lead->title }}
                        </h2>
                        <div class="print-image-wrapper" style="width: 100%; height: 50%; margin-bottom: 12px; flex-shrink: 0;">
                            <img src="{{ $lead->featured_image_url }}" alt="{{ $lead->title }}" class="print-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=800'">
                        </div>
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <div class="print-excerpt" style="font-size: 0.85rem; line-height: 1.65; flex-grow: 1; min-height: 0; overflow: hidden; column-count: 3; column-gap: 20px; column-rule: 1px solid rgba(17, 17, 17, 0.12);">
                                {!! mb_substr(strip_tags($lead->content), 0, 1200) . (mb_strlen(strip_tags($lead->content)) > 1200 ? '... <strong class="text-danger">(বাকি অংশ ২য় পাতায়)</strong>' : '') !!}
                            </div>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-4" style="grid-row: span 4;">
                        <div>
                            <i class="fa-solid fa-newspaper"></i>
                            <h5>প্রধান খবর</h5>
                            <p>দৈনিক ভোলা টাইমস্</p>
                        </div>
                    </div>
                @endif

                <!-- Slot 2: 1 column, 4 rows -->
                @if($posts->count() > 1 && $posts->get(1))
                    @php $story2 = $posts->get(1); @endphp
                    <article class="print-news-article span-1" style="grid-row: span 4;" onclick="openPrintReader(this)"
                             data-title="{{ $story2->title }}"
                             data-content="{{ strip_tags($story2->content) }}"
                             data-image="{{ $story2->featured_image_url }}"
                             data-author="{{ $story2->user ? $story2->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $story2->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $story2->slug) }}">
                        <h3 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0;">{{ $story2->title }}</h3>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_substr(strip_tags($story2->content), 0, 400) . (mb_strlen(strip_tags($story2->content)) > 400 ? '... <strong class="text-danger">(২য় পাতায় দেখুন)</strong>' : '') !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 4;">
                        <div>
                            <i class="fa-solid fa-feather-pointed"></i>
                            <h5>ফিচার</h5>
                            <p>মতামত</p>
                        </div>
                    </div>
                @endif

                <!-- Slot 3: 3 columns, 4 rows -->
                @if($posts->count() > 2 && $posts->get(2))
                    @php $story3 = $posts->get(2); @endphp
                    <article class="print-news-article span-3" style="grid-row: span 4;" onclick="openPrintReader(this)"
                             data-title="{{ $story3->title }}"
                             data-content="{{ strip_tags($story3->content) }}"
                             data-image="{{ $story3->featured_image_url }}"
                             data-author="{{ $story3->user ? $story3->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $story3->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $story3->slug) }}">
                        <h2 class="print-lead-title" style="font-size: 1.25rem; font-weight: 850; line-height: 1.35; margin-bottom: 6px; flex-shrink: 0;">{{ $story3->title }}</h2>
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <div class="print-excerpt" style="font-size: 0.82rem; line-height: 1.65; flex-grow: 1; min-height: 0; overflow: hidden; column-count: 2; column-gap: 16px; column-rule: 1px solid rgba(17, 17, 17, 0.12);">
                                @if($story3->featured_image_url)
                                    <div class="print-image-wrapper" style="width: 100%; height: 230px; margin-bottom: 8px; break-inside: avoid; display: block; flex-shrink: 0;">
                                        <img src="{{ $story3->featured_image_url }}" alt="{{ $story3->title }}" class="print-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                                    </div>
                                @endif
                                {!! mb_substr(strip_tags($story3->content), 0, 900) . (mb_strlen(strip_tags($story3->content)) > 900 ? '... <strong class="text-danger">(২য় পাতায় দেখুন)</strong>' : '') !!}
                            </div>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-3" style="grid-row: span 4;">
                        <div>
                            <i class="fa-solid fa-briefcase"></i>
                            <h5>বিশেষ খবর</h5>
                            <p>দৈনিক ভোলা টাইমস্</p>
                        </div>
                    </div>
                @endif

                <!-- SECTION 2: 3 col + 2 col + 1 col + 2 col = 8 columns total -->
                <!-- Slot 4: 3 columns, 3 rows -->
                @if($posts->count() > 3 && $posts->get(3))
                    @php $post = $posts->get(3); @endphp
                    <article class="print-news-article span-3" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h3 class="print-title" style="font-size: 1.2rem; font-weight: 850; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; width: 100%; text-align: center;">{{ $post->title }}</h3>
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <div class="print-excerpt" style="font-size: 0.82rem; line-height: 1.6; flex-grow: 1; min-height: 0; overflow: hidden; column-count: 2; column-gap: 16px; column-rule: 1px solid rgba(17, 17, 17, 0.12);">
                                @if($post->featured_image_url)
                                    <div class="print-image-wrapper" style="width: 100%; height: 130px; margin-bottom: 8px; break-inside: avoid; display: block; flex-shrink: 0;">
                                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="print-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                                    </div>
                                @endif
                                {!! mb_substr(strip_tags($post->content), 0, 700) . (mb_strlen(strip_tags($post->content)) > 700 ? '... <strong class="text-danger">(বাকি অংশ ২য় পাতায়)</strong>' : '') !!}
                            </div>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-3" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;">
                        <div>
                            <i class="fa-solid fa-star"></i>
                            <h5>ফিচার সংবাদ</h5>
                        </div>
                    </div>
                @endif

                <!-- Slot 5: 2 columns, 3 rows -->
                @if($posts->count() > 4 && $posts->get(4))
                    @php $post = $posts->get(4); @endphp
                    <article class="print-news-article span-2" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h3 class="print-title" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; width: 100%; text-align: center;">{{ $post->title }}</h3>
                        @if($post->featured_image_url)
                            <div class="print-image-wrapper" style="width: 100%; height: 110px; margin-bottom: 8px; flex-shrink: 0; display: block;">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="print-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                            </div>
                        @endif
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <p class="print-excerpt" style="font-size: 0.8rem; line-height: 1.55; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                                {!! mb_substr(strip_tags($post->content), 0, 500) . (mb_strlen(strip_tags($post->content)) > 500 ? '... <strong class="text-danger">(বাকি অংশ ২য় পাতায়)</strong>' : '') !!}
                            </p>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-2" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;">
                        <div>
                            <i class="fa-solid fa-flag"></i>
                            <h5>দেশজুড়ে</h5>
                        </div>
                    </div>
                @endif

                <!-- Slot 6: 1 column, 3 rows -->
                @if($posts->count() > 5 && $posts->get(5))
                    @php $post = $posts->get(5); @endphp
                    <article class="print-news-article span-1" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">{{ $post->title }}</h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_substr(strip_tags($post->content), 0, 300) . (mb_strlen(strip_tags($post->content)) > 300 ? '... <strong class="text-danger">(২য় পাতায় দেখুন)</strong>' : '') !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;">
                        <div>
                            <i class="fa-solid fa-circle-info"></i>
                            <h5>বিজ্ঞপ্তি</h5>
                        </div>
                    </div>
                @endif

                <!-- Slot 7: 2 columns, 3 rows -->
                @if($posts->count() > 6 && $posts->get(6))
                    @php $post = $posts->get(6); @endphp
                    <article class="print-news-article span-2" style="grid-row: span 3; border-right: none; padding-right: 0; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h3 class="print-title" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; width: 100%; text-align: center;">{{ $post->title }}</h3>
                        @if($post->featured_image_url)
                            <div class="print-image-wrapper" style="width: 100%; height: 110px; margin-bottom: 8px; flex-shrink: 0; display: block;">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="print-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                            </div>
                        @endif
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <p class="print-excerpt" style="font-size: 0.8rem; line-height: 1.55; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                                {!! mb_substr(strip_tags($post->content), 0, 500) . (mb_strlen(strip_tags($post->content)) > 500 ? '... <strong class="text-danger">(২য় পাতায় দেখুন)</strong>' : '') !!}
                            </p>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-2" style="grid-row: span 3; border-right: none; padding-right: 0; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;">
                        <div>
                            <i class="fa-solid fa-users"></i>
                            <h5>জনমত</h5>
                        </div>
                    </div>
                @endif

                <!-- SECTION 3: 2 col + 1 col + 3 col + 2 col = 8 columns total -->
                <!-- Slot 8: 2 columns, 3 rows -->
                @if($posts->count() > 7 && $posts->get(7))
                    @php $post = $posts->get(7); @endphp
                    <article class="print-news-article span-2" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h3 class="print-title" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; width: 100%; text-align: center;">{{ $post->title }}</h3>
                        @if($post->featured_image_url)
                            <div class="print-image-wrapper" style="width: 100%; height: 110px; margin-bottom: 8px; flex-shrink: 0; display: block;">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="print-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                            </div>
                        @endif
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <p class="print-excerpt" style="font-size: 0.8rem; line-height: 1.55; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                                {!! mb_substr(strip_tags($post->content), 0, 500) . (mb_strlen(strip_tags($post->content)) > 500 ? '... <strong class="text-danger">(বাকি অংশ ২য় পাতায়)</strong>' : '') !!}
                            </p>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-2" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;">
                        <div>
                            <i class="fa-solid fa-flag"></i>
                            <h5>আমাদের ভোলা</h5>
                        </div>
                    </div>
                @endif

                <!-- Slot 9: 1 column, 3 rows -->
                @if($posts->count() > 8 && $posts->get(8))
                    @php $post = $posts->get(8); @endphp
                    <article class="print-news-article span-1" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">{{ $post->title }}</h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_substr(strip_tags($post->content), 0, 300) . (mb_strlen(strip_tags($post->content)) > 300 ? '... <strong class="text-danger">(২য় পাতায় দেখুন)</strong>' : '') !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;">
                        <div>
                            <i class="fa-solid fa-bullhorn"></i>
                            <h5>ঘোষণা</h5>
                        </div>
                    </div>
                @endif

                <!-- Slot 10: 3 columns, 3 rows -->
                @if($posts->count() > 9 && $posts->get(9))
                    @php $post = $posts->get(9); @endphp
                    <article class="print-news-article span-3" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h3 class="print-title" style="font-size: 1.2rem; font-weight: 850; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; width: 100%; text-align: center;">{{ $post->title }}</h3>
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <div class="print-excerpt" style="font-size: 0.82rem; line-height: 1.6; flex-grow: 1; min-height: 0; overflow: hidden; column-count: 2; column-gap: 16px; column-rule: 1px solid rgba(17, 17, 17, 0.12);">
                                @if($post->featured_image_url)
                                    <div class="print-image-wrapper" style="width: 100%; height: 130px; margin-bottom: 8px; break-inside: avoid; display: block; flex-shrink: 0;">
                                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="print-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                                    </div>
                                @endif
                                {!! mb_substr(strip_tags($post->content), 0, 700) . (mb_strlen(strip_tags($post->content)) > 700 ? '... <strong class="text-danger">(২য় পাতায় দেখুন)</strong>' : '') !!}
                            </div>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-3" style="grid-row: span 3; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;">
                        <div>
                            <i class="fa-solid fa-users"></i>
                            <h5>জনমত কলাম</h5>
                        </div>
                    </div>
                @endif

                <!-- Slot 11: 2 columns, 3 rows -->
                @if($posts->count() > 10 && $posts->get(10))
                    @php $post = $posts->get(10); @endphp
                    <article class="print-news-article span-2" style="grid-row: span 3; border-right: none; padding-right: 0; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h3 class="print-title" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; width: 100%; text-align: center;">{{ $post->title }}</h3>
                        @if($post->featured_image_url)
                            <div class="print-image-wrapper" style="width: 100%; height: 110px; margin-bottom: 8px; flex-shrink: 0; display: block;">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="print-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                            </div>
                        @endif
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <p class="print-excerpt" style="font-size: 0.8rem; line-height: 1.55; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                                {!! mb_substr(strip_tags($post->content), 0, 500) . (mb_strlen(strip_tags($post->content)) > 500 ? '... <strong class="text-danger">(২য় পাতায় দেখুন)</strong>' : '') !!}
                            </p>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-2" style="grid-row: span 3; border-right: none; padding-right: 0; border-bottom: 2px solid #111111; padding-bottom: 12px; margin-bottom: 4px;">
                        <div>
                            <i class="fa-solid fa-users"></i>
                            <h5>জনমত</h5>
                        </div>
                    </div>
                @endif

                <!-- SECTION 4: 1 col + 3 col + 1 col + 1 col + 2 col = 8 columns total -->
                <!-- Slot 12: 1 column, 4 rows -->
                @if($posts->count() > 11 && $posts->get(11))
                    @php $post = $posts->get(11); @endphp
                    <article class="print-news-article span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">{{ $post->title }}</h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_substr(strip_tags($post->content), 0, 400) . (mb_strlen(strip_tags($post->content)) > 400 ? '... <strong class="text-danger">(২য় পাতায় দেখুন)</strong>' : '') !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;">
                        <div>
                            <i class="fa-solid fa-briefcase"></i>
                            <h5>অর্থনীতি</h5>
                        </div>
                    </div>
                @endif

                <!-- Slot 13: 3 columns, 4 rows -->
                @if($posts->count() > 12 && $posts->get(12))
                    @php $post = $posts->get(12); @endphp
                    <article class="print-news-article span-3" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h3 class="print-title" style="font-size: 1.2rem; font-weight: 850; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; width: 100%; text-align: center;">{{ $post->title }}</h3>
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <div class="print-excerpt" style="font-size: 0.82rem; line-height: 1.6; flex-grow: 1; min-height: 0; overflow: hidden; column-count: 2; column-gap: 16px; column-rule: 1px solid rgba(17, 17, 17, 0.12);">
                                @if($post->featured_image_url)
                                    <div class="print-image-wrapper" style="width: 100%; height: 130px; margin-bottom: 8px; break-inside: avoid; display: block; flex-shrink: 0;">
                                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="print-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                                    </div>
                                @endif
                                {!! mb_substr(strip_tags($post->content), 0, 900) . (mb_strlen(strip_tags($post->content)) > 900 ? '... <strong class="text-danger">(বাকি অংশ ২য় পাতায়)</strong>' : '') !!}
                            </div>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-3" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;">
                        <div>
                            <i class="fa-solid fa-camera"></i>
                            <h5>সচিত্র খবর</h5>
                        </div>
                    </div>
                @endif

                <!-- Slot 14: 1 column, 4 rows -->
                @if($posts->count() > 13 && $posts->get(13))
                    @php $post = $posts->get(13); @endphp
                    <article class="print-news-article span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">{{ $post->title }}</h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_substr(strip_tags($post->content), 0, 400) . (mb_strlen(strip_tags($post->content)) > 400 ? '... <strong class="text-danger">(২য় পাতায় দেখুন)</strong>' : '') !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;">
                        <div>
                            <i class="fa-solid fa-globe"></i>
                            <h5>আন্তর্জাতিক</h5>
                        </div>
                    </div>
                @endif

                <!-- Slot 15: 1 column, 4 rows -->
                @if($posts->count() > 14 && $posts->get(14))
                    @php $post = $posts->get(14); @endphp
                    <article class="print-news-article span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">{{ $post->title }}</h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_substr(strip_tags($post->content), 0, 400) . (mb_strlen(strip_tags($post->content)) > 400 ? '...' : '') !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;">
                        <div>
                            <i class="fa-solid fa-heart"></i>
                            <h5>বিনোদন</h5>
                        </div>
                    </div>
                @endif

                <!-- Slot 16: 2 columns, 4 rows -->
                @if($posts->count() > 15 && $posts->get(15))
                    @php $post = $posts->get(15); @endphp
                    <article class="print-news-article span-2" style="grid-row: span 4; border-right: none; padding-right: 0; border-bottom: none; padding-bottom: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post->title }}"
                             data-content="{{ strip_tags($post->content) }}"
                             data-image="{{ $post->featured_image_url }}"
                             data-author="{{ $post->user ? $post->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post->slug) }}">
                        <h3 class="print-title" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; width: 100%; text-align: center;">{{ $post->title }}</h3>
                        @if($post->featured_image_url)
                            <div class="print-image-wrapper" style="width: 100%; height: 110px; margin-bottom: 8px; flex-shrink: 0; display: block;">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="print-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                            </div>
                        @endif
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <p class="print-excerpt" style="font-size: 0.8rem; line-height: 1.55; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                                {!! mb_substr(strip_tags($post->content), 0, 600) . (mb_strlen(strip_tags($post->content)) > 600 ? '... <strong class="text-danger">(বাকি অংশ ২য় পাতায়)</strong>' : '') !!}
                            </p>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-2" style="grid-row: span 4; border-right: none; padding-right: 0; border-bottom: none; padding-bottom: 0;">
                        <div>
                            <i class="fa-solid fa-pen-nib"></i>
                            <h5>সম্পাদকীয়</h5>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Broadsheet editorial footer info -->
            <div class="broadsheet-footer-brand">
                <span>সম্পাদক মণ্ডলীর সভাপতি: {{ $themeSettings['editorial_board_president'] ?? 'সামস্-উল-আলম মিঠু' }}, প্রধান সম্পাদক ও প্রকাশক: {{ $themeSettings['editorial_publisher'] ?? 'মোঃ আলী জিন্নাহ (রাজিব)' }}, ভারপ্রাপ্ত সম্পাদক: {{ $themeSettings['editorial_editor'] ?? 'মোঃ হেলাল উদ্দিন' }} | বার্তা কার্যালয়: {{ $themeSettings['contact_address'] ?? 'বার্তা ও বাণিজ্যিক কার্যালয়- আমানত পাড়া, ভোলা।' }}</span>
                <span>দৈনিক ভোলা টাইমস্ ডিজিটাল ই-পেপার সংস্করণ</span>
            </div>
        </div>

        <!-- Spacer / Page Break divider -->
        <div class="epaper-page-divider my-4 text-center d-print-none" style="width: 100%; max-width: 1200px;">
            <hr style="border: 2px dashed rgba(255,255,255,0.25); margin: 24px 0;">
            <span class="badge bg-danger px-3 py-2 fs-6"><i class="fa-solid fa-file-lines me-2"></i>দ্বিতীয় পাতা</span>
            <hr style="border: 2px dashed rgba(255,255,255,0.25); margin: 24px 0;">
        </div>

        <!-- PAGE 2 CONTAINER -->
        @php
            $lead = $posts->get(0);
            $post2 = $posts->get(1);
            $story3 = $posts->get(2);
            $post4 = $posts->get(3);
            $post5 = $posts->get(4);
            $post6 = $posts->get(5);
            $post7 = $posts->get(6);
            $post8 = $posts->get(7);
            $post9 = $posts->get(8);
            $post10 = $posts->get(9);
            $post11 = $posts->get(10);
            $post12 = $posts->get(11);
            $post13 = $posts->get(12);
            $post14 = $posts->get(13);
            $post15 = $posts->get(14);
            $post16 = $posts->get(15);
        @endphp
        <div class="epaper-container" id="broadsheetPaperPage2">

            <!-- Broadsheet Columns Grid (8 columns layout, 16 rows) -->
            <div class="epaper-broadsheet-grid">
                
                <!-- Broadsheet Masthead Page 2 -->
                <header class="epaper-masthead-page2">
                    <div class="left-brand">দৈনিক ভোলা<span>টাইমস্</span></div>
                    <div class="center-title">বাকি অংশ (২য় পাতা)</div>
                    <div class="right-meta">
                        <span>ভলিউম: ১০ | সংখ্যা: ১৪২</span><br>
                        <span class="epaperCurrentDate2"></span>
                    </div>
                </header>
                
                <!-- ROW 1: 8 Columns total (4 + 1 + 3) -->
                <!-- Lead Continuation (Left) -->
                @if($lead)
                    <article class="print-news-article span-4" style="grid-row: span 4;" onclick="openPrintReader(this)"
                             data-title="{{ $lead->title }}"
                             data-content="{{ strip_tags($lead->content) }}"
                             data-image="{{ $lead->featured_image_url }}"
                             data-author="{{ $lead->user ? $lead->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $lead->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $lead->slug) }}">
                        <h3 class="print-title" style="font-size: 1.15rem; font-weight: 850; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; text-align: left; border-bottom: 1px dashed rgba(17, 17, 17, 0.15); padding-bottom: 4px;">
                            {{ $lead->title }} <span class="badge bg-danger ms-1" style="font-size: 0.7rem; vertical-align: middle; font-weight: normal; padding: 2px 6px;">১ম পাতার পর</span>
                        </h3>
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <div class="print-excerpt" style="font-size: 0.8rem; line-height: 1.6; flex-grow: 1; min-height: 0; overflow: hidden; column-count: 2; column-gap: 16px; column-rule: 1px solid rgba(17, 17, 17, 0.12); text-align: justify;">
                                {!! mb_strlen(strip_tags($lead->content)) > 1200 ? mb_substr(strip_tags($lead->content), 1200) : 'দৈনিক ভোলা টাইমস্ এর বিশেষ প্রতিবেদন। বিস্তারিত অনলাইন সংস্করণে।' !!}
                            </div>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-4" style="grid-row: span 4;">
                        <div>
                            <i class="fa-solid fa-feather-pointed"></i>
                            <h5>সম্পাদকীয় কলাম</h5>
                            <p>দৈনিক ভোলা টাইমস্ বস্তুনিষ্ঠ সংবাদ পরিবেশনে অঙ্গীকারাবদ্ধ।</p>
                        </div>
                    </div>
                @endif

                <!-- Post 2 Continuation -->
                @if($post2)
                    <article class="print-news-article span-1" style="grid-row: span 4;" onclick="openPrintReader(this)"
                             data-title="{{ $post2->title }}"
                             data-content="{{ strip_tags($post2->content) }}"
                             data-image="{{ $post2->featured_image_url }}"
                             data-author="{{ $post2->user ? $post2->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post2->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post2->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">
                            {{ $post2->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post2->content)) > 400 ? mb_substr(strip_tags($post2->content), 400) : 'দৈনিক ভোলা টাইমস্ অনলাইন সংস্করণ।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 4;">
                        <div>
                            <i class="fa-solid fa-star"></i>
                            <h5>মতামত</h5>
                        </div>
                    </div>
                @endif

                <!-- Post 3 Continuation -->
                @if($story3)
                    <article class="print-news-article span-3" style="grid-row: span 4;" onclick="openPrintReader(this)"
                             data-title="{{ $story3->title }}"
                             data-content="{{ strip_tags($story3->content) }}"
                             data-image="{{ $story3->featured_image_url }}"
                             data-author="{{ $story3->user ? $story3->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $story3->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $story3->slug) }}">
                        <h3 class="print-title" style="font-size: 1.15rem; font-weight: 850; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; text-align: left; border-bottom: 1px dashed rgba(17, 17, 17, 0.15); padding-bottom: 4px;">
                            {{ $story3->title }} <span class="badge bg-danger ms-1" style="font-size: 0.7rem; vertical-align: middle; font-weight: normal; padding: 2px 6px;">১ম পাতার পর</span>
                        </h3>
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <div class="print-excerpt" style="font-size: 0.8rem; line-height: 1.6; flex-grow: 1; min-height: 0; overflow: hidden; column-count: 2; column-gap: 16px; column-rule: 1px solid rgba(17, 17, 17, 0.12); text-align: justify;">
                                {!! mb_strlen(strip_tags($story3->content)) > 900 ? mb_substr(strip_tags($story3->content), 900) : 'জনগুরুত্বপূর্ণ সংবাদটি সম্পূর্ণ পড়তে আমাদের অনলাইন সংস্করণে চোখ রাখুন।' !!}
                            </div>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-3" style="grid-row: span 4;">
                        <div>
                            <i class="fa-solid fa-newspaper"></i>
                            <h5>বিশেষ সংবাদ</h5>
                            <p>দৈনিক ভোলা টাইমস্</p>
                        </div>
                    </div>
                @endif


                <!-- ROW 2: 8 Columns total (3 + 2 + 1 + 2) -->
                <!-- Post 4 Continuation -->
                @if($post4)
                    <article class="print-news-article span-3" style="grid-row: span 3;" onclick="openPrintReader(this)"
                             data-title="{{ $post4->title }}"
                             data-content="{{ strip_tags($post4->content) }}"
                             data-image="{{ $post4->featured_image_url }}"
                             data-author="{{ $post4->user ? $post4->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post4->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post4->slug) }}">
                        <h3 class="print-title" style="font-size: 1.15rem; font-weight: 850; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; text-align: left; border-bottom: 1px dashed rgba(17, 17, 17, 0.15); padding-bottom: 4px;">
                            {{ $post4->title }} <span class="badge bg-danger ms-1" style="font-size: 0.7rem; vertical-align: middle; font-weight: normal; padding: 2px 6px;">১ম পাতার পর</span>
                        </h3>
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <div class="print-excerpt" style="font-size: 0.8rem; line-height: 1.6; flex-grow: 1; min-height: 0; overflow: hidden; column-count: 2; column-gap: 16px; column-rule: 1px solid rgba(17, 17, 17, 0.12); text-align: justify;">
                                {!! mb_strlen(strip_tags($post4->content)) > 700 ? mb_substr(strip_tags($post4->content), 700) : 'আমাদের বিশেষ প্রতিনিধির পাঠানো সচিত্র প্রতিবেদন। দৈনিক ভোলা টাইমস্।' !!}
                            </div>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-3" style="grid-row: span 3;">
                        <div>
                            <i class="fa-solid fa-quote-left"></i>
                            <h5>জনমত কলাম</h5>
                            <p>দৈনিক ভোলা টাইমস্</p>
                        </div>
                    </div>
                @endif

                <!-- Post 5 Continuation -->
                @if($post5)
                    <article class="print-news-article span-2" style="grid-row: span 3;" onclick="openPrintReader(this)"
                             data-title="{{ $post5->title }}"
                             data-content="{{ strip_tags($post5->content) }}"
                             data-image="{{ $post5->featured_image_url }}"
                             data-author="{{ $post5->user ? $post5->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post5->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post5->slug) }}">
                        <h3 class="print-title" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; text-align: center;">
                            {{ $post5->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h3>
                        <p class="print-excerpt" style="font-size: 0.8rem; line-height: 1.55; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post5->content)) > 500 ? mb_substr(strip_tags($post5->content), 500) : 'সত্যের সন্ধানে সার্বক্ষণিক আমাদের খবর। দৈনিক ভোলা টাইমস্ অনলাইন সংস্করণ।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-2" style="grid-row: span 3;">
                        <div>
                            <i class="fa-solid fa-circle-info"></i>
                            <h5>বিজ্ঞপ্তি</h5>
                        </div>
                    </div>
                @endif

                <!-- Post 6 Continuation -->
                @if($post6)
                    <article class="print-news-article span-1" style="grid-row: span 3;" onclick="openPrintReader(this)"
                             data-title="{{ $post6->title }}"
                             data-content="{{ strip_tags($post6->content) }}"
                             data-image="{{ $post6->featured_image_url }}"
                             data-author="{{ $post6->user ? $post6->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post6->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post6->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">
                            {{ $post6->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post6->content)) > 300 ? mb_substr(strip_tags($post6->content), 300) : 'বার্তা বিভাগ, দৈনিক ভোলা টাইমস্।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 3;">
                        <div>
                            <i class="fa-solid fa-pencil"></i>
                            <h5>ফিচার</h5>
                        </div>
                    </div>
                @endif

                <!-- Post 7 Continuation -->
                @if($post7)
                    <article class="print-news-article span-2" style="grid-row: span 3; border-right: none; padding-right: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post7->title }}"
                             data-content="{{ strip_tags($post7->content) }}"
                             data-image="{{ $post7->featured_image_url }}"
                             data-author="{{ $post7->user ? $post7->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post7->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post7->slug) }}">
                        <h3 class="print-title" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; text-align: center;">
                            {{ $post7->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h3>
                        <p class="print-excerpt" style="font-size: 0.8rem; line-height: 1.55; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post7->content)) > 500 ? mb_substr(strip_tags($post7->content), 500) : 'দৈনিক ভোলা টাইমস্ এর পরিবেশিত বিশেষ সংবাদ।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-2" style="grid-row: span 3; border-right: none; padding-right: 0;">
                        <div>
                            <i class="fa-solid fa-flag"></i>
                            <h5>দেশজুড়ে</h5>
                        </div>
                    </div>
                @endif


                <!-- ROW 3: 8 Columns total (2 + 1 + 3 + 2) -->
                <!-- Post 8 Continuation -->
                @if($post8)
                    <article class="print-news-article span-2" style="grid-row: span 3;" onclick="openPrintReader(this)"
                             data-title="{{ $post8->title }}"
                             data-content="{{ strip_tags($post8->content) }}"
                             data-image="{{ $post8->featured_image_url }}"
                             data-author="{{ $post8->user ? $post8->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post8->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post8->slug) }}">
                        <h3 class="print-title" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; text-align: center;">
                            {{ $post8->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h3>
                        <p class="print-excerpt" style="font-size: 0.8rem; line-height: 1.55; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post8->content)) > 500 ? mb_substr(strip_tags($post8->content), 500) : 'জনস্বার্থে প্রচারিত বিশেষ আয়োজন। বিস্তারিত অনলাইন পোর্টালে পঠিত।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-2" style="grid-row: span 3;">
                        <div>
                            <i class="fa-solid fa-flag"></i>
                            <h5>আমাদের ভোলা</h5>
                        </div>
                    </div>
                @endif

                <!-- Post 9 Continuation -->
                @if($post9)
                    <article class="print-news-article span-1" style="grid-row: span 3;" onclick="openPrintReader(this)"
                             data-title="{{ $post9->title }}"
                             data-content="{{ strip_tags($post9->content) }}"
                             data-image="{{ $post9->featured_image_url }}"
                             data-author="{{ $post9->user ? $post9->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post9->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post9->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">
                            {{ $post9->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post9->content)) > 300 ? mb_substr(strip_tags($post9->content), 300) : 'দৈনিক ভোলা টাইমস্ অনলাইন সংস্করণ।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 3;">
                        <div>
                            <i class="fa-solid fa-bullhorn"></i>
                            <h5>ঘোষণা</h5>
                        </div>
                    </div>
                @endif

                <!-- Post 10 Continuation -->
                @if($post10)
                    <article class="print-news-article span-3" style="grid-row: span 3;" onclick="openPrintReader(this)"
                             data-title="{{ $post10->title }}"
                             data-content="{{ strip_tags($post10->content) }}"
                             data-image="{{ $post10->featured_image_url }}"
                             data-author="{{ $post10->user ? $post10->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post10->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post10->slug) }}">
                        <h3 class="print-title" style="font-size: 1.15rem; font-weight: 850; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; text-align: left; border-bottom: 1px dashed rgba(17, 17, 17, 0.15); padding-bottom: 4px;">
                            {{ $post10->title }} <span class="badge bg-danger ms-1" style="font-size: 0.7rem; vertical-align: middle; font-weight: normal; padding: 2px 6px;">১ম পাতার পর</span>
                        </h3>
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <div class="print-excerpt" style="font-size: 0.8rem; line-height: 1.6; flex-grow: 1; min-height: 0; overflow: hidden; column-count: 2; column-gap: 16px; column-rule: 1px solid rgba(17, 17, 17, 0.12); text-align: justify;">
                                {!! mb_strlen(strip_tags($post10->content)) > 700 ? mb_substr(strip_tags($post10->content), 700) : 'নিরপেক্ষ ও বস্তুনিষ্ঠ সংবাদের বিশ্বস্ত অনলাইন ঠিকানা দৈনিক ভোলা টাইমস্।' !!}
                            </div>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-3" style="grid-row: span 3;">
                        <div>
                            <i class="fa-solid fa-users"></i>
                            <h5>জনমত কলাম</h5>
                            <p>দৈনিক ভোলা টাইমস্</p>
                        </div>
                    </div>
                @endif

                <!-- Post 11 Continuation -->
                @if($post11)
                    <article class="print-news-article span-2" style="grid-row: span 3; border-right: none; padding-right: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post11->title }}"
                             data-content="{{ strip_tags($post11->content) }}"
                             data-image="{{ $post11->featured_image_url }}"
                             data-author="{{ $post11->user ? $post11->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post11->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post11->slug) }}">
                        <h3 class="print-title" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; text-align: center;">
                            {{ $post11->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h3>
                        <p class="print-excerpt" style="font-size: 0.8rem; line-height: 1.55; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post11->content)) > 500 ? mb_substr(strip_tags($post11->content), 500) : 'সবার আগে সর্বশেষ খবর পেতে দৈনিক ভোলা টাইমস্ এর সাথেই থাকুন।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-2" style="grid-row: span 3; border-right: none; padding-right: 0;">
                        <div>
                            <i class="fa-solid fa-users"></i>
                            <h5>জনমত</h5>
                        </div>
                    </div>
                @endif


                <!-- ROW 4: 8 Columns total (1 + 3 + 1 + 1 + 2) -->
                <!-- Post 12 Continuation -->
                @if($post12)
                    <article class="print-news-article span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post12->title }}"
                             data-content="{{ strip_tags($post12->content) }}"
                             data-image="{{ $post12->featured_image_url }}"
                             data-author="{{ $post12->user ? $post12->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post12->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post12->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">
                            {{ $post12->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post12->content)) > 400 ? mb_substr(strip_tags($post12->content), 400) : 'দৈনিক ভোলা টাইমস্ ডিজিটাল সংস্করণ।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;">
                        <div>
                            <i class="fa-solid fa-briefcase"></i>
                            <h5>অর্থনীতি</h5>
                        </div>
                    </div>
                @endif

                <!-- Post 13 Continuation -->
                @if($post13)
                    <article class="print-news-article span-3" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post13->title }}"
                             data-content="{{ strip_tags($post13->content) }}"
                             data-image="{{ $post13->featured_image_url }}"
                             data-author="{{ $post13->user ? $post13->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post13->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post13->slug) }}">
                        <h3 class="print-title" style="font-size: 1.15rem; font-weight: 850; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; text-align: left; border-bottom: 1px dashed rgba(17, 17, 17, 0.15); padding-bottom: 4px;">
                            {{ $post13->title }} <span class="badge bg-danger ms-1" style="font-size: 0.7rem; vertical-align: middle; font-weight: normal; padding: 2px 6px;">১ম পাতার পর</span>
                        </h3>
                        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow: hidden; min-height: 0; width: 100%;">
                            <div class="print-excerpt" style="font-size: 0.8rem; line-height: 1.6; flex-grow: 1; min-height: 0; overflow: hidden; column-count: 2; column-gap: 16px; column-rule: 1px solid rgba(17, 17, 17, 0.12); text-align: justify;">
                                {!! mb_strlen(strip_tags($post13->content)) > 900 ? mb_substr(strip_tags($post13->content), 900) : 'সর্বশেষ তথ্যের আপডেট পেতে দৈনিক ভোলা টাইমস্ অনলাইন সংস্করণ ভিজিট করুন।' !!}
                            </div>
                        </div>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-3" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;">
                        <div>
                            <i class="fa-solid fa-camera"></i>
                            <h5>সচিত্র খবর</h5>
                        </div>
                    </div>
                @endif

                <!-- Post 14 Continuation -->
                @if($post14)
                    <article class="print-news-article span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post14->title }}"
                             data-content="{{ strip_tags($post14->content) }}"
                             data-image="{{ $post14->featured_image_url }}"
                             data-author="{{ $post14->user ? $post14->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post14->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post14->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">
                            {{ $post14->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post14->content)) > 400 ? mb_substr(strip_tags($post14->content), 400) : 'দৈনিক ভোলা টাইমস্ অনলাইন।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;">
                        <div>
                            <i class="fa-solid fa-globe"></i>
                            <h5>আন্তর্জাতিক</h5>
                        </div>
                    </div>
                @endif

                <!-- Post 15 Continuation -->
                @if($post15)
                    <article class="print-news-article span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post15->title }}"
                             data-content="{{ strip_tags($post15->content) }}"
                             data-image="{{ $post15->featured_image_url }}"
                             data-author="{{ $post15->user ? $post15->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post15->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post15->slug) }}">
                        <h4 class="print-title" style="font-size: 0.95rem; font-weight: 800; line-height: 1.4; flex-shrink: 0; text-align: center;">
                            {{ $post15->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h4>
                        <p class="print-excerpt" style="font-size: 0.8rem; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post15->content)) > 400 ? mb_substr(strip_tags($post15->content), 400) : 'সর্বশেষ সংবাদের বিশ্বস্ত অনলাইন ঠিকানা দৈনিক ভোলা টাইমস্।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-1" style="grid-row: span 4; border-bottom: none; padding-bottom: 0;">
                        <div>
                            <i class="fa-solid fa-heart"></i>
                            <h5>বিনোদন</h5>
                        </div>
                    </div>
                @endif

                <!-- Post 16 Continuation -->
                @if($post16)
                    <article class="print-news-article span-2" style="grid-row: span 4; border-right: none; padding-right: 0; border-bottom: none; padding-bottom: 0;" onclick="openPrintReader(this)"
                             data-title="{{ $post16->title }}"
                             data-content="{{ strip_tags($post16->content) }}"
                             data-image="{{ $post16->featured_image_url }}"
                             data-author="{{ $post16->user ? $post16->user->name : 'বার্তা কক্ষ' }}"
                             data-date="{{ $post16->created_at->format('d M, Y') }}"
                             data-url="{{ route('post', $post16->slug) }}">
                        <h3 class="print-title" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 8px; flex-shrink: 0; width: 100%; text-align: center;">
                            {{ $post16->title }} <span class="badge bg-danger d-block mt-1 mx-auto" style="font-size: 0.6rem; font-weight: normal; padding: 1px 3px; width: fit-content;">১ম পাতার পর</span>
                        </h3>
                        <p class="print-excerpt" style="font-size: 0.8rem; line-height: 1.55; flex-grow: 1; min-height: 0; overflow: hidden; margin-bottom: 0;">
                            {!! mb_strlen(strip_tags($post16->content)) > 600 ? mb_substr(strip_tags($post16->content), 600) : 'দৈনিক ভোলা টাইমস্ ডিজিটাল সংস্করণ, ভোলা সদর, বাংলাদেশ।' !!}
                        </p>
                    </article>
                @else
                    <div class="print-news-article empty-slot span-2" style="grid-row: span 4; border-right: none; padding-right: 0; border-bottom: none; padding-bottom: 0;">
                        <div>
                            <i class="fa-solid fa-pen-nib"></i>
                            <h5>সম্পাদকীয় প্যানেল</h5>
                            <p style="font-size: 0.75rem; color: #555; margin: 0;">দৈনিক ভোলা টাইমস্</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Broadsheet editorial footer info Page 2 -->
            <div class="broadsheet-footer-brand">
                <span>সম্পাদক মণ্ডলীর সভাপতি: {{ $themeSettings['editorial_board_president'] ?? 'সামস্-উল-আলম মিঠু' }}, প্রধান সম্পাদক ও প্রকাশক: {{ $themeSettings['editorial_publisher'] ?? 'মোঃ আলী জিন্নাহ (রাজিব)' }}, ভারপ্রাপ্ত সম্পাদক: {{ $themeSettings['editorial_editor'] ?? 'মোঃ হেলাল উদ্দিন' }} | পৃষ্ঠা ২ - {{ $themeSettings['contact_address'] ?? 'বার্তা ও বাণিজ্যিক কার্যালয়- আমানত পাড়া, ভোলা।' }}</span>
                <span>দৈনিক ভোলা টাইমস্ ডিজিটাল ই-পেপার সংস্করণ - দ্বিতীয় পাতা (বাকি অংশ)</span>
            </div>
        </div>
    @else
        <!-- Beautiful empty-state fallback / premium fallback -->
        <div class="fallback-box-wrapper d-flex align-items-center justify-content-center px-3" style="width: 100%; min-height: 70vh;">
            <div class="fallback-container text-center py-5 px-4 rounded shadow-lg" style="background-color: #1e2230; border: 1px solid rgba(255,255,255,0.1); max-width: 600px; width: 100%;">
                <div class="mb-4">
                    <i class="fa-solid fa-calendar-xmark text-danger" style="font-size: 4.5rem; filter: drop-shadow(0 0 15px rgba(231, 13, 13, 0.4));"></i>
                </div>
                <h3 class="text-white mb-3" style="font-family: 'Noto Sans Bengali', sans-serif; font-weight: 800; font-size: 1.8rem; letter-spacing: -0.5px;">দুঃখিত, এই তারিখের কোনো ই-পেপার সংস্করণ পাওয়া যায়নি!</h3>
                <p class="text-secondary mb-4 fs-6" style="font-family: 'Noto Sans Bengali', sans-serif; line-height: 1.6;">{{ \Carbon\Carbon::parse($selectedDate)->format('d M, Y') }} তারিখে <strong>দৈনিক ভোলা টাইমস্</strong>-এর কোনো ডিজিটাল ই-পেপার সংস্করণ ডাটাবেজে সংরক্ষণ করা হয়নি। অনুগ্রহ করে অন্য কোনো তারিখ নির্বাচন করুন বা আজকের সর্বশেষ সংস্করণে ফিরে যান।</p>
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="{{ route('epaper') }}" class="btn btn-danger btn-lg px-4 py-2" style="font-family: 'Noto Sans Bengali', sans-serif; background-color: var(--accent); border-color: var(--accent); font-weight: 700; font-size: 0.95rem; border-radius: var(--radius-lg);"><i class="fa-solid fa-newspaper me-2"></i>সর্বশেষ ই-পেপার সংস্করণ</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg text-white px-4 py-2" style="font-family: 'Noto Sans Bengali', sans-serif; border-color: rgba(255,255,255,0.3); font-weight: 700; font-size: 0.95rem; border-radius: var(--radius-lg);"><i class="fa-solid fa-house me-2"></i>পোর্টাল হোমপেজ</a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Broadsheet Interactive Modal Reader -->
<div class="modal fade" id="printReaderModal" tabindex="-1" aria-labelledby="printReaderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content text-white" style="background-color: #0f172a; border: 1px solid rgba(255,255,255,0.15); box-shadow: var(--shadow-lg);">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="printModalTitle" style="font-family: 'Noto Sans Bengali', sans-serif; font-weight: 800; color: #ffffff;">সংবাদ শিরোনাম</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-family: 'Noto Sans Bengali', sans-serif;">
                <div class="text-center mb-3">
                    <img id="printModalImage" src="" alt="" class="img-fluid rounded border border-secondary" style="max-height: 380px; object-fit: cover; width: 100%;">
                </div>
                <div class="d-flex justify-content-between mb-3 text-secondary" style="font-size: 0.85rem;">
                    <span id="printModalAuthor"><i class="fa-solid fa-user me-1 text-danger"></i>লেখকঃ</span>
                    <span id="printModalDate"><i class="fa-regular fa-calendar-days me-1 text-danger"></i>তারিখঃ</span>
                </div>
                <div id="printModalContent" class="fs-5" style="line-height: 1.8; text-align: justify; color: #cbd5e1;">
                    সংবাদ বিবরণ...
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <a id="printModalFullLink" href="#" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-arrow-up-right-from-square me-1"></i>অনলাইন সংস্করণ পঠন</a>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">বন্ধ করুন</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3.3 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    // Load dates in E-Paper Masthead
    document.addEventListener('DOMContentLoaded', function() {
        const selectedDateVal = new Date('{{ $selectedDate->format('Y-m-d') }}');
        const dateSpan = document.getElementById('epaperCurrentDate');
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const banglaDateFormatter = new Intl.DateTimeFormat('bn-BD', options);
        if(dateSpan) dateSpan.textContent = banglaDateFormatter.format(selectedDateVal);

        // Update date for Page 2 header if exists
        document.querySelectorAll('.epaperCurrentDate2').forEach(function(el) {
            el.textContent = banglaDateFormatter.format(selectedDateVal);
        });

        const hijriSpan = document.getElementById('epaperHijriDate');
        const hijriOptions = { day: 'numeric', month: 'long', year: 'numeric' };
        try {
            const hijriDateFormatter = new Intl.DateTimeFormat('bn-BD-u-ca-islamic-umalqura', hijriOptions);
            if(hijriSpan) hijriSpan.textContent = hijriDateFormatter.format(selectedDateVal) + ' হিজরি';
        } catch(e) {
            const hijriDateFormatter = new Intl.DateTimeFormat('bn-BD-u-ca-islamic', hijriOptions);
            if(hijriSpan) hijriSpan.textContent = hijriDateFormatter.format(selectedDateVal) + ' হিজরি';
        }
    });

    // Open broadsheet print reader modal
    function openPrintReader(element) {
        const title = element.getAttribute('data-title');
        const content = element.getAttribute('data-content');
        const image = element.getAttribute('data-image');
        const author = element.getAttribute('data-author');
        const date = element.getAttribute('data-date');
        const url = element.getAttribute('data-url');

        document.getElementById('printModalTitle').textContent = title;
        document.getElementById('printModalContent').textContent = content;
        document.getElementById('printModalAuthor').innerHTML = `<i class="fa-solid fa-user me-1 text-danger"></i>লেখকঃ <strong>${author}</strong>`;
        document.getElementById('printModalDate').innerHTML = `<i class="fa-regular fa-calendar-days me-1 text-danger"></i>তারিখঃ <strong>${date}</strong>`;
        
        const modalImg = document.getElementById('printModalImage');
        if(image) {
            modalImg.src = image;
            modalImg.style.display = 'block';
        } else {
            modalImg.style.display = 'none';
        }

        document.getElementById('printModalFullLink').href = url;

        // Show bootstrap modal
        const printModal = new bootstrap.Modal(document.getElementById('printReaderModal'));
        printModal.show();
    }
</script>
</body>
</html>
