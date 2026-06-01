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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ডিজিটাল ই-পেপার | দৈনিক ভোলা টাইমস্</title>
    
    <!-- Meta details for SEO -->
    <meta name="description" content="দৈনিক ভোলা টাইমস্ ডিজিটাল ই-পেপার সংস্করণ - ভোলার প্রথম ও জনপ্রিয় অনলাইন পত্রিকা">
    
    <!-- Font Awesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5.3.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Google Fonts: Inter & Noto Serif Bengali -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Noto+Serif+Bengali:wght@400;700&family=Noto+Sans+Bengali:wght@400;700&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* ═══════════════════════════════════════════════
           DYNAMIC PUBLIC E-PAPER VIEWER CSS SYSTEM
           ═══════════════════════════════════════════════ */
        
        :root {
            --bg-dark: #0f172a;
            --bg-card: #1e293b;
            --border: rgba(255,255,255,0.08);
            --text-muted: #94a3b8;
            --accent: #dc2626;
            --radius-md: 8px;
            --radius-lg: 12px;
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        body {
            background-color: var(--bg-dark);
            color: #f1f5f9;
            font-family: 'Outfit', 'Noto Sans Bengali', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* ─── Premium Header Bar ─── */
        .epaper-header {
            background: #161e2e;
            border-bottom: 1px solid var(--border);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            gap: 16px;
        }

        .header-logo {
            font-size: 1.4rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .header-logo span {
            color: var(--accent);
        }

        .zoom-slider-container {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            padding: 6px 14px;
            border-radius: var(--radius-md);
        }
        .zoom-slider-container label {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin: 0;
            font-weight: 700;
        }
        .zoom-slider-container input[type="range"] {
            width: 100px;
            accent-color: var(--accent);
            cursor: pointer;
        }
        .zoom-slider-container span {
            font-size: 0.75rem;
            font-weight: 700;
            min-width: 35px;
            text-align: right;
        }

        /* ─── Pill-Style Tab Navigation ─── */
        .epaper-tabs {
            margin: 16px auto;
            max-width: 936px;
            padding: 4px;
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
        }
        .epaper-tabs .page-tab {
            flex: 1;
            padding: 10px 16px;
            border: 1px solid transparent;
            background: transparent;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Noto Sans Bengali', sans-serif;
        }
        .epaper-tabs .page-tab:hover {
            color: #ffffff;
            background: rgba(255,255,255,0.05);
        }
        .epaper-tabs .page-tab.active {
            background-color: var(--accent);
            border-color: var(--accent);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        /* ─── Canvas Viewport (Scroll & Zoom wrapper) ─── */
        .canvas-viewport {
            width: 100%;
            overflow: auto;
            padding: 20px 0 60px 0;
            display: flex;
            justify-content: center;
        }
        .canvas-viewport::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .canvas-viewport::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }
        .canvas-viewport::-webkit-scrollbar-thumb {
            background: var(--bg-card);
            border-radius: 4px;
        }

        .canvas-center {
            display: inline-block;
            transform-origin: top center;
            transition: zoom 0.15s ease;
        }

        /* ─── Broadsheet Canvas ─── */
        .broadsheet-canvas {
            background: #ffffff;
            border: 1px solid #111111;
            width: 936px;
            height: 1300px;
            color: #111111;
            box-shadow: var(--shadow-lg);
            position: relative;
            font-family: 'SutonnyOMJ', 'SolaimanLipi', 'Noto Serif Bengali', serif;
            box-sizing: border-box;
        }

        /* ─── Page Layers (Background rendering) ─── */
        .page-layer {
            position: absolute;
            left: -9999px;
            top: 0;
            width: 100%;
            height: 1300px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-sizing: border-box;
            background: #ffffff;
        }
        .page-layer.active {
            position: relative;
            left: 0;
        }

        /* ─── Broadsheet Headers/Masthead ─── */
        .front-masthead {
            height: 180px;
            border-bottom: 4px double #111111;
            padding: 10px 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
        }
        .front-masthead-title {
            font-size: 2.8rem;
            font-weight: 800;
            text-align: center;
            letter-spacing: -1px;
            margin: 0;
            color: #000000;
        }
        .front-masthead-title span {
            color: var(--accent);
        }
        
        .inner-page-header {
            border-bottom: 2px solid #111111;
            padding: 8px 0;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 0.95rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #111111;
            font-family: 'Noto Sans Bengali', sans-serif;
            border-top: 1px solid #111111;
            margin-top: 5px;
        }

        .broadsheet-footer-brand {
            border-top: 2px solid #111111;
            padding: 6px 15px;
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            font-weight: bold;
            color: #333333;
            font-family: 'Noto Sans Bengali', sans-serif;
            margin-top: auto;
            margin-bottom: 5px;
        }

        /* ─── 32-Column CSS Grid ─── */
        .broadsheet-grid {
            display: grid;
            grid-template-columns: repeat(32, 1fr);
            gap: 5px;
            flex: 1;
            box-sizing: border-box;
        }
        #grid1 { grid-template-rows: repeat(6, minmax(0, 1fr)); height: calc(1300px - 196px); }
        #grid2 { grid-template-rows: repeat(16, minmax(0, 1fr)); height: 1260px; }
        #grid4 { grid-template-rows: repeat(16, minmax(0, 1fr)); height: 1260px; }

        /* ─── Article Slots & Renderer ─── */
        .drop-slot {
            position: relative;
            padding: 5px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            cursor: pointer;
            box-sizing: border-box;
            transition: background 0.15s ease;
        }
        .drop-slot:hover {
            background: rgba(220,38,38, 0.025);
        }
        .drop-slot.empty-slot {
            display: none !important; /* Hide empty slots on public viewer */
        }

        .rendered-title {
            font-weight: bold;
            color: #111111;
            margin-bottom: 6px;
            line-height: 1.25;
            letter-spacing: -0.2px;
            font-family: 'Noto Serif Bengali', 'SutonnyOMJ', serif;
        }

        .rendered-image-wrapper {
            width: 100%;
            height: 120px;
            background: #f1f5f9;
            margin-bottom: 6px;
            overflow: hidden;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }
        .rendered-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rendered-excerpt {
            font-size: 0.9rem;
            line-height: 1.2;
            color: #222222;
            text-align: justify;
            column-gap: 15px;
            overflow: hidden;
            flex: 1;
            min-height: 0;
            font-family: 'SutonnyOMJ', 'SolaimanLipi', 'Noto Serif Bengali', serif;
        }

        /* ─── Page 3 (Jumps Grid) ─── */
        .jump-grid {
            column-count: 4;
            column-gap: 20px;
            height: 1178px;
            box-sizing: border-box;
        }
        .jump-slot {
            break-inside: avoid;
            margin-bottom: 20px;
            background: #ffffff;
            border-bottom: 2px solid #111111;
            padding-bottom: 15px;
            cursor: pointer;
            box-sizing: border-box;
        }
        .jump-slot:hover {
            background: rgba(220,38,38, 0.02);
        }
        .jump-title {
            font-size: 1.05rem;
            font-weight: bold;
            color: #111111;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 4px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Noto Serif Bengali', sans-serif;
        }
        .jump-meta {
            font-size: 0.7rem;
            color: var(--accent);
            font-weight: 700;
        }

        .jump-tag {
            color: var(--accent);
            font-weight: bold;
            font-size: 0.75rem;
            display: inline-block;
            margin-left: 4px;
            font-family: 'Noto Sans Bengali', sans-serif;
        }

        /* ─── Print Styles ─── */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .epaper-header, .epaper-tabs, .zoom-slider-container {
                display: none !important;
            }
            .canvas-viewport {
                padding: 0 !important;
                overflow: visible !important;
            }
            .canvas-center {
                zoom: 1.0 !important;
                transform: none !important;
            }
            .broadsheet-canvas {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                height: auto !important;
            }
            .page-layer {
                position: relative !important;
                left: 0 !important;
                display: flex !important;
                height: auto !important;
                page-break-after: always !important;
            }
        }
    </style>
</head>
<body>

    <!-- Header bar -->
    <header class="epaper-header">
        <a href="{{ route('home') }}" class="header-logo">
            <i class="fa-solid fa-arrow-left fs-5 text-muted"></i>
            {!! $themeSettings['logo_text'] !!} <span>ই-পেপার</span>
        </a>
        
        <!-- Date Selector Input -->
        <div class="d-flex align-items-center gap-2">
            <label for="epaperDateSelect" style="color: #cbd5e1; font-weight: 700; font-size: 0.85rem;"><i class="fa-solid fa-calendar-days text-danger"></i> তারিখ:</label>
            <input type="date" id="epaperDateSelect" value="{{ $selectedDate->format('Y-m-d') }}" max="{{ date('Y-m-d') }}" class="form-control form-control-sm" style="background: #1e293b; color: #fff; border: 1px solid rgba(255,255,255,0.15); width: 140px; border-radius: 6px; font-weight: 600;" onchange="window.location.href = '?date=' + this.value">
        </div>

        <div class="d-flex align-items-center gap-3">
            <!-- Zoom controller -->
            <div class="zoom-slider-container">
                <label for="zoomSlider"><i class="fa-solid fa-magnifying-glass-plus"></i> জুম</label>
                <input type="range" id="zoomSlider" min="30" max="100" value="55" oninput="updateZoom()">
                <span id="zoomValue">55%</span>
            </div>
            
            <button onclick="shareEPaper()" class="btn btn-outline-light btn-sm px-3" style="border-radius: var(--radius-md); font-weight: 600;"><i class="fa-solid fa-share-nodes me-1"></i> শেয়ার</button>
            <button onclick="window.print()" class="btn btn-danger btn-sm px-3" style="border-radius: var(--radius-md); font-weight: 700; background-color: var(--accent); border-color: var(--accent);"><i class="fa-solid fa-print me-1"></i> প্রিন্ট</button>
        </div>
    </header>

    @if($hasSavedEPaper)
        <!-- Pill-Style Tab Navigation -->
        <div class="epaper-tabs d-flex flex-wrap justify-content-center gap-2">
            <button class="page-tab active" onclick="switchPage(1)"><i class="fa-solid fa-newspaper me-1"></i>প্রথম পাতা (পৃষ্ঠা ১)</button>
            <button class="page-tab" onclick="switchPage(2)"><i class="fa-solid fa-book-open me-1"></i>আজকের সংবাদ (পৃষ্ঠা ২)</button>
            <button class="page-tab" onclick="switchPage(3)"><i class="fa-solid fa-share me-1"></i>বাকি অংশ (পৃষ্ঠা ৩)</button>
            <button class="page-tab" onclick="switchPage(4)"><i class="fa-solid fa-file-text me-1"></i>শেষ পাতা (পৃষ্ঠা ৪)</button>
        </div>

        <!-- Canvas Viewport -->
        <div class="canvas-viewport" id="viewport">
            <div class="canvas-center">
                <div class="broadsheet-canvas" id="canvas">

                    <!-- PAGE 1 -->
                    <div class="page-layer active" id="page1">
                        <header class="front-masthead">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-grow: 1;">
                                <div style="font-family: 'Noto Sans Bengali', sans-serif; font-size: 0.75rem; font-weight: bold; width: 150px; line-height: 1.4;">
                                    ভোলার প্রথম ও জনপ্রিয়<br>অনলাইন পত্রিকা
                                </div>
                                <h1 class="front-masthead-title">
                                    {!! $themeSettings['logo_text'] !!}
                                </h1>
                                <div style="font-family: 'Noto Sans Bengali', sans-serif; font-size: 0.75rem; font-weight: bold; width: 150px; text-align: right; line-height: 1.4;">
                                    প্রকাশক: সামস্-উল-আলম মিঠু<br>
                                    www.bholatimes24.com
                                </div>
                            </div>
                            
                            <!-- Broadsheet Meta Bar -->
                            <div style="background: #111111; color: #ffffff; padding: 6px 15px; display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: bold; margin-top: 5px; font-family: 'Noto Sans Bengali', sans-serif;">
                                <span>রেজিঃ নং - ১২৩৪</span>
                                <span id="mastheadDateDisplay">{{ $formattedDate }}</span>
                                <span id="epaperHijriDate"></span>
                                <span>মূল্য: ৫ টাকা</span>
                            </div>
                        </header>
                        
                        <div class="broadsheet-grid" id="grid1" style="padding: 0 15px 15px 15px;">
                            <!-- Empty slot placeholders — dynamically populated client-side -->
                            <!-- Row 1 & 2 -->
                            <div class="drop-slot empty-slot" data-slot="1" style="grid-column: span 15; grid-row: span 2;"></div>
                            <div class="drop-slot empty-slot" data-slot="2" style="grid-column: span 6; grid-row: span 2;"></div>
                            <div class="drop-slot empty-slot" data-slot="3" style="grid-column: span 11; grid-row: span 2;"></div>
                            <!-- Row 3 & 4 -->
                            <div class="drop-slot empty-slot" data-slot="4" style="grid-column: span 11; grid-row: span 2;"></div>
                            <div class="drop-slot empty-slot" data-slot="5" style="grid-column: span 10; grid-row: span 2;"></div>
                            <div class="drop-slot empty-slot" data-slot="6" style="grid-column: span 11; grid-row: span 2;"></div>
                            <!-- Row 5 & 6 -->
                            <div class="drop-slot empty-slot" data-slot="7" style="grid-column: span 10; grid-row: span 2;"></div>
                            <div class="drop-slot empty-slot" data-slot="8" style="grid-column: span 12; grid-row: span 2;"></div>
                            <div class="drop-slot empty-slot" data-slot="9" style="grid-column: span 10; grid-row: span 2;"></div>
                        </div>
                        
                        <!-- Declaration Footer Page 1 -->
                        <div class="broadsheet-footer-brand">
                            <span>সম্পাদক মণ্ডলীর সভাপতি: {{ $themeSettings['editorial_board_president'] ?? 'সামস্-উল-আলম মিঠু' }}, প্রধান সম্পাদক ও প্রকাশক: {{ $themeSettings['editorial_publisher'] ?? 'মোঃ আলী জিন্নাহ (রাজিব)' }}, ভারপ্রাপ্ত সম্পাদক: {{ $themeSettings['editorial_editor'] ?? 'মোঃ হেলাল উদ্দিন' }}</span>
                            <span>দৈনিক ভোলা টাইমস্ | পৃষ্ঠা ১</span>
                        </div>
                    </div>

                    <!-- PAGE 2 -->
                    <div class="page-layer" id="page2" style="padding: 15px; box-sizing: border-box;">
                        <header class="inner-page-header">
                            <span>আজকের সংবাদ | পৃষ্ঠা ২</span>
                            <span class="epaperCurrentDate2"></span>
                            <span>দৈনিক ভোলা টাইমস্</span>
                        </header>

                        <div class="broadsheet-grid" id="grid2">
                            <div class="drop-slot empty-slot" data-slot="1" style="grid-column: span 16; grid-row: span 6;"></div>
                            <div class="drop-slot" data-slot="2" style="grid-column: span 16; grid-row: span 6;"></div>
                            <div class="drop-slot" data-slot="3" style="grid-column: span 12; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="4" style="grid-column: span 8; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="5" style="grid-column: span 12; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="6" style="grid-column: span 8; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="7" style="grid-column: span 8; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="8" style="grid-column: span 8; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="9" style="grid-column: span 8; grid-row: span 5;"></div>
                        </div>

                        <!-- Declaration Footer Page 2 -->
                        <div class="broadsheet-footer-brand">
                            <span>ভারপ্রাপ্ত সম্পাদক: {{ $themeSettings['editorial_editor'] ?? 'মোঃ হেলাল উদ্দিন' }}</span>
                            <span>দৈনিক ভোলা টাইমস্ | পৃষ্ঠা ২</span>
                        </div>
                    </div>

                    <!-- PAGE 3 (JUMPS) -->
                    <div class="page-layer" id="page3" style="padding: 15px; box-sizing: border-box;">
                        <header class="inner-page-header">
                            <span>বাকি অংশ (ফিচার ও কলাম) | পৃষ্ঠা ৩</span>
                            <span class="epaperCurrentDate2"></span>
                            <span>দৈনিক ভোলা টাইমস্</span>
                        </header>

                        <div class="jump-grid" id="grid3"></div>
                        <div id="grid3Empty" class="d-flex align-items-center justify-content-center" style="height: calc(1300px - 100px); color: #888; font-family: 'Noto Sans Bengali', sans-serif;">
                            <div class="text-center">
                                <i class="fa-solid fa-share fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                                <h5>কোনো সংবাদের অংশবিশেষ ৩য় পাতায় স্থানান্তরিত হয়নি</h5>
                                <p class="text-muted small">১ম ও শেষ পাতায় সংবাদ সংক্ষেপিত হলে বাকি অংশ এখানে স্বয়ংক্রিয়ভাবে উপস্থাপিত হবে।</p>
                            </div>
                        </div>

                        <!-- Declaration Footer Page 3 -->
                        <div class="broadsheet-footer-brand">
                            <span>ভোলার প্রথম ও জনপ্রিয় অনলাইন পত্রিকা</span>
                            <span>দৈনিক ভোলা টাইমস্ | পৃষ্ঠা ৩</span>
                        </div>
                    </div>

                    <!-- PAGE 4 -->
                    <div class="page-layer" id="page4" style="padding: 15px; box-sizing: border-box;">
                        <header class="inner-page-header">
                            <span>শেষ পাতা | পৃষ্ঠা ৪</span>
                            <span class="epaperCurrentDate2"></span>
                            <span>দৈনিক ভোলা টাইমস্</span>
                        </header>

                        <div class="broadsheet-grid" id="grid4">
                            <div class="drop-slot" data-slot="1" style="grid-column: span 12; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="2" style="grid-column: span 8; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="3" style="grid-column: span 12; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="4" style="grid-column: span 8; grid-row: span 4;"></div>
                            <div class="drop-slot" data-slot="5" style="grid-column: span 8; grid-row: span 4;"></div>
                            <div class="drop-slot" data-slot="6" style="grid-column: span 8; grid-row: span 4;"></div>
                            <div class="drop-slot" data-slot="7" style="grid-column: span 8; grid-row: span 4;"></div>
                            <div class="drop-slot" data-slot="8" style="grid-column: span 8; grid-row: span 4;"></div>
                            <div class="drop-slot" data-slot="9" style="grid-column: span 8; grid-row: span 4;"></div>
                            <div class="drop-slot" data-slot="10" style="grid-column: span 8; grid-row: span 4;"></div>
                            <div class="drop-slot" data-slot="11" style="grid-column: span 8; grid-row: span 4;"></div>
                            <div class="drop-slot" data-slot="12" style="grid-column: span 32; grid-row: span 3;"></div>
                        </div>

                        <!-- Declaration Footer Page 4 -->
                        <div class="broadsheet-footer-brand">
                            <span>বার্তা কক্ষ: {{ $themeSettings['contact_phone'] ?? '০১৭১১৪৬৯৫৩৯' }} | ইমেইল: {{ $themeSettings['contact_email'] ?? 'news.bholatimes@gmail.com' }}</span>
                            <span>দৈনিক ভোলা টাইমস্ | পৃষ্ঠা ৪</span>
                        </div>
                    </div>

                </div><!-- .broadsheet-canvas -->
            </div><!-- .canvas-center -->
        </div><!-- .canvas-viewport -->
    @else
        <!-- Beautiful empty-state fallback -->
        <div class="fallback-box-wrapper d-flex align-items-center justify-content-center px-3" style="width: 100%; min-height: 70vh;">
            <div class="fallback-container text-center py-5 px-4 rounded shadow-lg" style="background-color: #1e2230; border: 1px solid rgba(255,255,255,0.1); max-width: 600px; width: 100%;">
                <div class="mb-4">
                    <i class="fa-solid fa-calendar-xmark text-danger" style="font-size: 4.5rem; filter: drop-shadow(0 0 15px rgba(231, 13, 13, 0.4));"></i>
                </div>
                <h3 class="text-white mb-3" style="font-family: 'Noto Sans Bengali', sans-serif; font-weight: 800; font-size: 1.8rem; letter-spacing: -0.5px;">দুঃখিত, এই তারিখের কোনো ই-পেপার সংস্করণ পাওয়া যায়নি!</h3>
                <p class="text-secondary mb-4 fs-6" style="font-family: 'Noto Sans Bengali', sans-serif; line-height: 1.6;">{{ \Carbon\Carbon::parse($selectedDate)->format('d M, Y') }} তারিখে <strong>দৈনিক ভোলা টাইমস্</strong>-এর কোনো ডিজিটাল ই-পেপার সংস্করণ ডাটাবেজে সংরক্ষণ করা হয়নি। অনুগ্রহ করে অন্য কোনো তারিখ নির্বাচন করুন বা আজকের সংস্করণে ফিরে যান।</p>
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="{{ route('epaper') }}" class="btn btn-danger btn-lg px-4 py-2" style="font-family: 'Noto Sans Bengali', sans-serif; background-color: var(--accent); border-color: var(--accent); font-weight: 700; font-size: 0.95rem; border-radius: var(--radius-lg);"><i class="fa-solid fa-newspaper me-2"></i>সর্বশেষ সংস্করণ</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg text-white px-4 py-2" style="font-family: 'Noto Sans Bengali', sans-serif; border-color: rgba(255,255,255,0.3); font-weight: 700; font-size: 0.95rem; border-radius: var(--radius-lg);"><i class="fa-solid fa-house me-2"></i>পোর্টাল হোমপেজ</a>
                </div>
            </div>
        </div>
    @endif

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
                    <div id="printModalContent" class="fs-5" style="line-height: 1.8; text-align: justify; color: #cbd5e1; white-space: pre-wrap;">
                        সংবাদ বিবরণ...
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">বন্ধ করুন</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @if($hasSavedEPaper)
    <script>
        let activePage = 1;
        let scale = 0.55;
        const pagesData = @json($pagesData);

        // Load dates in E-Paper Masthead
        document.addEventListener('DOMContentLoaded', function() {
            const selectedDateVal = new Date('{{ $selectedDate->format('Y-m-d') }}');
            const dateSpan = document.getElementById('mastheadDateDisplay');
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const banglaDateFormatter = new Intl.DateTimeFormat('bn-BD', options);
            
            // Update date for Page headers if they exist
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

            // Render all canvas pages dynamically
            renderCanvas();

            // Auto-scale on page load
            autoScale();
            window.addEventListener('resize', autoScale);

            // Auto-split text and populate Page 3 Jumps immediately
            autoSplitCanvas();
        });

        // Re-run autoScale and autoSplit once stylesheets, images, and fonts are completely loaded
        window.addEventListener('load', function() {
            console.log("Window load event fired. Re-running layout and copy-fitting...");
            autoScale();
            setTimeout(autoSplitCanvas, 100);
        });

        if (document.fonts) {
            document.fonts.ready.then(function() {
                console.log("Web fonts fully loaded. Re-running layout and copy-fitting...");
                autoScale();
                setTimeout(autoSplitCanvas, 150);
            });
        }

        // ─── Render Dynamic Broadsheet Slots from JSON ───
        function renderCanvas() {
            // Reset and hide empty slots
            [1, 2, 4].forEach(page => {
                document.querySelectorAll(`#grid${page} .drop-slot`).forEach(slot => {
                    slot.innerHTML = '';
                    slot.classList.add('empty-slot');
                    slot.classList.remove('occupied');
                    slot.removeAttribute('onclick');
                });
            });

            [1, 2, 4].forEach(page => {
                const slots = pagesData[page] || [];
                slots.forEach(slotData => {
                    const slotEl = document.querySelector(`#grid${page} .drop-slot[data-slot="${slotData.slot_id}"]`);
                    if (!slotEl) return;

                    slotEl.classList.remove('empty-slot');
                    slotEl.classList.add('occupied');
                    
                    // Attach click reader handler
                    slotEl.onclick = function() { openPrintReader(this); };

                    // Hide photo if slot spans only 1 column
                    const gridColumnStyle = slotEl.style.gridColumn || '';
                    const spanCol = gridColumnStyle.includes('span') ? parseInt(gridColumnStyle.split('span')[1].trim()) : 8;
                    let showPhoto = spanCol > 4 && slotData.image;
                    if (slotData.style && slotData.style.hasOwnProperty('show_image')) {
                        showPhoto = slotData.style.show_image && slotData.image;
                    }

                    // Render dynamic content
                    slotEl.innerHTML = `
                        <div class="rendered-content" style="height: 100%; display: flex; flex-direction: column; overflow: hidden; box-sizing: border-box;">
                            <div class="rendered-title" style="font-size: ${slotData.style.font_size || 14}px; text-align: ${slotData.style.title_align || 'center'}; color: ${slotData.style.title_color || '#111111'}; font-weight: ${slotData.style.font_weight || 'bold'}; word-spacing: ${slotData.style.word_spacing || '0px'};">
                                ${slotData.title}
                            </div>
                            ${showPhoto ? `<div class="rendered-image-wrapper" style="flex-shrink:0;"><img src="${slotData.image}"></div>` : ''}
                            <div class="rendered-excerpt" style="column-count: ${slotData.style.columns || 2}; column-gap: 15px; line-height: ${slotData.style.line_height || '1.15'}; text-align: ${slotData.style.text_align || 'justify'}; flex: 1; min-height: 0; overflow: hidden;">
                                ${slotData.content}
                            </div>
                        </div>
                    `;

                    // Set helper attributes for reader modal and auto-split calculations
                    slotEl.setAttribute('data-title', slotData.title);
                    slotEl.setAttribute('data-content', slotData.content);
                    slotEl.setAttribute('data-image', slotData.image || '');
                    slotEl.setAttribute('data-author', slotData.author || 'বার্তা কক্ষ');
                    slotEl.setAttribute('data-date', '{{ $formattedDate }}');
                });
            });
        }

        // ─── Responsive Scale ───
        function autoScale() {
            const viewport = document.getElementById('viewport');
            if (!viewport) return;
            const viewportWidth = viewport.clientWidth;
            const canvasWidth = 936; // broadsheet canvas standard width
            let scaleVal = (viewportWidth - 30) / canvasWidth;
            scaleVal = Math.min(Math.max(0.3, scaleVal), 1.0); // clamp between 30% and 100%
            
            const slider = document.getElementById('zoomSlider');
            if (slider) {
                slider.value = Math.round(scaleVal * 100);
            }
            const valSpan = document.getElementById('zoomValue');
            if (valSpan) {
                valSpan.innerText = Math.round(scaleVal * 100) + '%';
            }
            applyZoom(scaleVal);
        }

        function updateZoom() {
            const slider = document.getElementById('zoomSlider');
            scale = slider.value / 100;
            document.getElementById('zoomValue').innerText = Math.round(scale * 100) + '%';
            applyZoom(scale);
        }

        function applyZoom(scaleVal) {
            const center = document.querySelector('.canvas-center');
            if (center) {
                center.style.zoom = scaleVal;
            }
        }

        // ─── Page Switching ───
        function switchPage(pageNum) {
            activePage = pageNum;
            document.querySelectorAll('.page-tab').forEach((el, i) => {
                el.classList.toggle('active', i + 1 === pageNum);
            });
            document.querySelectorAll('.page-layer').forEach((el, i) => {
                el.classList.toggle('active', i + 1 === pageNum);
            });
        }

        // ─── Open Broadsheet Print Reader Modal ───
        function openPrintReader(element) {
            const title = element.getAttribute('data-title');
            const content = element.getAttribute('data-content');
            const image = element.getAttribute('data-image');
            const author = element.getAttribute('data-author');
            const date = element.getAttribute('data-date');

            document.getElementById('printModalTitle').textContent = title;
            document.getElementById('printModalContent').innerHTML = content.replace(/\n/g, '<br>');
            document.getElementById('printModalAuthor').innerHTML = `<i class="fa-solid fa-user me-1 text-danger"></i>লেখকঃ <strong>${author}</strong>`;
            document.getElementById('printModalDate').innerHTML = `<i class="fa-regular fa-calendar-days me-1 text-danger"></i>তারিখঃ <strong>${date}</strong>`;
            
            const modalImg = document.getElementById('printModalImage');
            if(image) {
                modalImg.src = image;
                modalImg.style.display = 'block';
            } else {
                modalImg.style.display = 'none';
            }

            // Show bootstrap modal
            const printModal = new bootstrap.Modal(document.getElementById('printReaderModal'));
            printModal.show();
        }

        // ─── Web Share API support ───
        function shareEPaper() {
            if (navigator.share) {
                navigator.share({
                    title: 'ডিজিটাল ই-পেপার | দৈনিক ভোলা টাইমস্',
                    text: 'দৈনিক ভোলা টাইমস্ ডিজিটাল ই-পেপার সংস্করণ পড়ুন!',
                    url: window.location.href,
                })
                .then(() => console.log('Successful share'))
                .catch((error) => console.log('Error sharing', error));
            } else {
                // Fallback: Copy to clipboard
                const el = document.createElement('textarea');
                el.value = window.location.href;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                alert('ই-পেপার লিংক ক্লিপবোর্ডে কপি করা হয়েছে!');
            }
        }

        // ─── Client-side automated copy-fitting binary search splitter ───
        function autoSplitCanvas() {
            console.log("Running autoSplitCanvas copy-fitting...");
            let jumpItems = [];

            [1, 4].forEach(page => {
                const slots = document.querySelectorAll(`#page${page} .drop-slot.occupied`);
                console.log(`Page ${page}: found ${slots.length} occupied slots`);
                slots.forEach(slotEl => {
                    const slotId = slotEl.getAttribute('data-slot');
                    const contentEl = slotEl.querySelector('.rendered-content');
                    const excerptEl = slotEl.querySelector('.rendered-excerpt');
                    if (!contentEl || !excerptEl) return;
                    
                    // Restore full content if previously split so we calculate from original text
                    if (slotEl.hasAttribute('data-full-content')) {
                        excerptEl.innerHTML = slotEl.getAttribute('data-full-content');
                    }
                    
                    // Get maximum allowed height
                    const maxAllowedHeight = slotEl.clientHeight - 10;
                    const scrollHeight = contentEl.scrollHeight;
                    console.log(`Slot ${slotId} on Page ${page}: clientHeight=${slotEl.clientHeight}, scrollHeight=${scrollHeight}, maxAllowedHeight=${maxAllowedHeight}`);
                    
                    if (scrollHeight > maxAllowedHeight) {
                        // Save full content if not already saved
                        let cleanText = slotEl.getAttribute('data-full-content') || excerptEl.innerText;
                        if (!slotEl.hasAttribute('data-full-content')) {
                            slotEl.setAttribute('data-full-content', cleanText);
                        }
                        
                        let low = 0;
                        let high = cleanText.length;
                        let bestSplit = 0;
                        const jumpTagHTML = ' <span class="jump-tag">... বাকি অংশ ৩য় পাতায় দেখুন</span>';
                        
                        while (low <= high) {
                            let mid = Math.floor((low + high) / 2);
                            let testText = cleanText.substring(0, mid);
                            excerptEl.innerHTML = testText + jumpTagHTML;
                            
                            if (contentEl.scrollHeight <= maxAllowedHeight) {
                                bestSplit = mid;
                                low = mid + 1;
                            } else {
                                high = mid - 1;
                            }
                        }
                        
                        let finalPageText = cleanText.substring(0, bestSplit);
                        let jumpText = cleanText.substring(bestSplit);
                        
                        excerptEl.innerHTML = finalPageText + jumpTagHTML;
                        
                        // Update content attribute for print modal reader to show the full news!
                        slotEl.setAttribute('data-content', cleanText);
                        
                        console.log(`-> Split triggered for Slot ${slotId}! bestSplit=${bestSplit}, jumpText length=${jumpText.length}`);
                        
                        jumpItems.push({ from_page: page, title: slotEl.getAttribute('data-title'), content: jumpText });
                    } else {
                        console.log(`-> No split needed for Slot ${slotId}`);
                    }
                });
            });

            // Render Page 3 Jumps
            const grid3 = document.getElementById('grid3');
            const grid3Empty = document.getElementById('grid3Empty');
            if (grid3) {
                grid3.innerHTML = '';
                if (jumpItems.length > 0) {
                    if (grid3Empty) grid3Empty.style.display = 'none';
                    console.log(`Rendering ${jumpItems.length} jump items on Page 3`);
                    
                    jumpItems.forEach(jump => {
                        grid3.innerHTML += `
                            <div class="jump-slot" onclick="openPrintReader(this)"
                                 data-title="${jump.title}"
                                 data-content="${jump.content.replace(/"/g, '&quot;')}"
                                 data-image=""
                                 data-author="বার্তা কক্ষ"
                                 data-date="{{ $formattedDate }}"
                                 data-url="#"
                            >
                                <h4 class="jump-title">
                                    ${jump.title}
                                    <span class="jump-meta">(${jump.from_page}ম পাতার পর)</span>
                                </h4>
                                <div class="rendered-excerpt" style="column-count: 1; column-gap: 15px; text-align: justify; line-height: 1.6;">
                                    ${jump.content}
                                </div>
                            </div>
                        `;
                    });
                } else {
                    if (grid3Empty) grid3Empty.style.display = 'flex';
                    console.log('No jump items to render on Page 3');
                }
            }
        }
    </script>
    @endif
</body>
</html>