@extends('layouts.admin')

@section('title', 'সোশ্যাল মিডিয়া কার্ড জেনারেটর | ' . $post->title)
@section('header_title', 'সোশ্যাল মিডিয়া কার্ড জেনারেটর')

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@400;700&family=Baloo+Da+2:wght@400;700&family=Galada&family=Hind+Siliguri:wght@400;500;700&family=Mina:wght@400;700&family=Noto+Sans+Bengali:wght@400;500;700&family=Tiro+Bangla:ital@0;1&display=swap');

    /* Full-screen immersive overrides */
    .admin-content {
        padding: 0 !important;
        overflow: hidden !important;
        background-color: #f8fafc; /* Slate 50 light background */
    }

    .admin-header {
        box-shadow: none !important;
        border-bottom: 1px solid #e2e8f0 !important;
        background-color: #ffffff !important;
    }
    
    .admin-header .header-title {
        color: #0f172a !important;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    
    .admin-header .view-site-btn {
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #334155;
    }

    /* Main Studio Container */
    .studio-container {
        display: flex;
        width: 100%;
        height: calc(100vh - 70px);
        position: relative;
        overflow: hidden;
    }

    /* 1. Canvas Workspace (Right side) */
    .canvas-workspace {
        flex: 1;
        height: 100%;
        background-color: #f1f5f9; /* Slate 100 light background */
        background-image: 
            radial-gradient(rgba(15, 23, 42, 0.05) 1.5px, transparent 1.5px),
            linear-gradient(rgba(0, 0, 0, 0.005) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 0, 0, 0.005) 1px, transparent 1px);
        background-size: 24px 24px, 24px 24px, 24px 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 0 40px rgba(15, 23, 42, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Glowing Aura behind canvas */
    .canvas-workspace::before {
        content: '';
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, transparent 70%);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        z-index: 0;
    }

    .scale-container {
        width: 1080px;
        height: 1080px;
        transform-origin: center center;
        flex-shrink: 0;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25), 0 0 40px rgba(15, 23, 42, 0.05);
        border-radius: 8px;
        background-color: #000000;
        position: relative;
        transition: transform 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1;
        border: 1px solid rgba(15, 23, 42, 0.1);
    }

    /* Crop Marks / Designer Guides */
    .canvas-guide {
        position: absolute;
        width: 30px;
        height: 30px;
        border-color: #dc2626; /* Crimson brand color guide */
        border-style: solid;
        pointer-events: none;
        z-index: 5;
    }
    .guide-tl { top: -8px; left: -8px; border-width: 2px 0 0 2px; }
    .guide-tr { top: -8px; right: -8px; border-width: 2px 2px 0 0; }
    .guide-bl { bottom: -8px; left: -8px; border-width: 0 0 2px 2px; }
    .guide-br { bottom: -8px; right: -8px; border-width: 0 2px 2px 0; }

    .canvas-resolution-badge {
        position: absolute;
        top: -36px;
        left: 0;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(4px);
        pointer-events: none;
        z-index: 5;
    }

    /* 2. Left-side Inspector Panel */
    .inspector-panel {
        width: 380px;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-right: 1px solid #e2e8f0;
        box-shadow: 10px 0 30px rgba(15, 23, 42, 0.04);
        display: flex;
        flex-direction: column;
        z-index: 10;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .inspector-panel.collapsed {
        margin-left: -380px;
    }

    .inspector-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .inspector-title {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .inspector-title i {
        color: #dc2626;
        font-size: 0.95rem;
        filter: drop-shadow(0 0 8px rgba(220, 38, 38, 0.3));
    }

    .inspector-content {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Inspector Sections / Cards */
    .inspector-section {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        transition: border-color 0.2s;
    }

    .inspector-section:hover {
        border-color: rgba(220, 38, 38, 0.2);
    }

    .section-title {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
        margin-bottom: 4px;
    }

    .section-title i {
        color: #dc2626;
    }

    /* Premium Styled Form Elements */
    .studio-label {
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
        display: block;
    }

    .studio-select, .studio-input {
        width: 100%;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
        padding: 10px 14px !important;
        border-radius: 8px !important;
        font-size: 0.85rem !important;
        outline: none !important;
        transition: all 0.2s !important;
    }

    .studio-select:focus, .studio-input:focus {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15) !important;
    }

    /* Custom range slider wrapper */
    .slider-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .studio-range {
        flex: 1;
        accent-color: #dc2626;
        cursor: pointer;
        height: 6px;
        border-radius: 3px;
        background: #e2e8f0;
    }

    .slider-val-badge {
        background: rgba(220, 38, 38, 0.06);
        border: 1px solid rgba(220, 38, 38, 0.15);
        color: #dc2626;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 700;
        min-width: 48px;
        text-align: center;
    }

    /* Custom Color Picker Swatches */
    .color-swatch-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .color-swatch {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.15s, border-color 0.15s;
    }

    .color-swatch:hover {
        transform: scale(1.15);
        border-color: #0f172a;
    }

    .color-picker-studio {
        width: 32px;
        height: 32px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        cursor: pointer;
        padding: 0;
        overflow: hidden;
        background: transparent;
        transition: transform 0.2s;
    }

    .color-picker-studio:hover {
        transform: scale(1.1);
    }

    .color-picker-studio::-webkit-color-swatch-wrapper {
        padding: 0;
    }

    .color-picker-studio::-webkit-color-swatch {
        border: none;
    }

    /* Ad Preset Buttons */
    .ad-presets {
        display: flex;
        gap: 8px;
    }
    
    .btn-preset-ad {
        flex: 1;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        padding: 8px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        font-family: 'Noto Sans Bengali', sans-serif;
    }

    .btn-preset-ad:hover, .btn-preset-ad.active {
        border-color: #dc2626;
        background: rgba(220, 38, 38, 0.05);
        color: #dc2626;
    }

    /* Drag and Drop BG Button */
    .bg-upload-zone {
        border: 1.5px dashed #cbd5e1;
        border-radius: 8px;
        padding: 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        color: #64748b;
    }

    .bg-upload-zone:hover {
        border-color: #dc2626;
        background: rgba(220, 38, 38, 0.02);
        color: #334155;
    }

    .bg-upload-zone i {
        font-size: 1.25rem;
        color: #dc2626;
    }

    .bg-upload-preview {
        width: 100%;
        height: 50px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        margin-top: 4px;
    }

    /* Primary Downloads Actions styling */
    .download-gradient-btn {
        width: 100%;
        padding: 14px !important;
        border-radius: 10px !important;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 0.95rem !important;
        font-family: 'Noto Sans Bengali', sans-serif;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.25) !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        border: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .download-gradient-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.4) !important;
        background: linear-gradient(135deg, #34d399 0%, #059669 100%) !important;
    }

    .download-gradient-btn:active {
        transform: translateY(0) !important;
    }

    /* Premium Facebook Sharing Action Button styling */
    .btn-facebook-share {
        width: 100%;
        padding: 13px !important;
        border-radius: 10px !important;
        background: #1877f2 !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 0.9rem !important;
        font-family: 'Noto Sans Bengali', sans-serif;
        box-shadow: 0 6px 15px rgba(24, 119, 242, 0.25) !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        border: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-facebook-share:hover {
        background: #1565c0 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 20px rgba(24, 119, 242, 0.4) !important;
    }

    .btn-facebook-share:active {
        transform: translateY(0) !important;
    }

    /* Toggle Floating Panel Button */
    .toggle-studio-panel-btn {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 12;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(8px);
    }

    .toggle-studio-panel-btn:hover {
        background: #dc2626;
        border-color: #dc2626;
        color: #ffffff;
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(220, 38, 38, 0.3);
    }

    /* 3. Card Elements in-canvas feedback */
    [contenteditable="true"] {
        position: relative;
        outline: none;
        border: 1px dashed transparent;
        border-radius: 6px;
        padding: 4px 8px;
        transition: all 0.2s;
    }

    [contenteditable="true"]:hover {
        border-color: rgba(243, 156, 18, 0.5);
        background: rgba(0, 0, 0, 0.03);
    }

    [contenteditable="true"]:focus {
        border-color: #f39c12;
        background: rgba(0, 0, 0, 0.05);
        box-shadow: 0 0 0 4px rgba(243, 156, 18, 0.15);
    }

    /* Dynamic "Edit" Tooltip on Hover */
    [contenteditable="true"]::after {
        content: 'সম্পাদনা করুন';
        position: absolute;
        bottom: -28px;
        right: 10px;
        background: #f39c12;
        color: #000;
        font-family: 'Noto Sans Bengali', sans-serif !important;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
        pointer-events: none;
        opacity: 0;
        transform: translateY(-5px);
        transition: all 0.2s;
        z-index: 100;
        white-space: nowrap;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    [contenteditable="true"]:hover::after {
        opacity: 1;
        transform: translateY(0);
    }

    [contenteditable="true"]:focus::after {
        display: none; /* Hide when typing */
    }

    /* Exporting mode overrides to prevent any html2canvas shifts or artifacts */
    .exporting [contenteditable="true"] {
        border-color: transparent !important;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 2px 6px !important; /* Perfect match to original padding exactly */
        outline: none !important;
    }
    
    .exporting [contenteditable="true"]::after {
        display: none !important;
        content: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
    }

    /* Count character indicator inside Inspector */
    .char-count-wrapper {
        display: flex;
        justify-content: flex-end;
        font-size: 11px;
        color: #64748b;
        margin-top: 4px;
    }

    .char-count-badge {
        font-weight: 700;
        color: #dc2626;
    }

    /* Canvas Card Content Styling Fixes */
    .news-card-1080 { 
        width: 1080px; 
        height: 1080px;
        position: relative; 
        overflow: hidden; 
        display: flex; 
        flex-direction: column; 
        background-color: #000; 
        flex-shrink: 0;
    }

    .centered-watermark { 
        position: absolute; 
        top: 55%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        width: 75%; 
        opacity: 0.08; 
        z-index: 10; 
        pointer-events: none; 
        filter: grayscale(100%) brightness(150%); 
    }

    .news-image-wrapper { 
        flex: 0 0 648px; 
        width: 1080px; 
        position: relative; 
        z-index: 2; 
        overflow: hidden; 
        border-bottom: 3px solid rgba(255,255,255,0.1); 
        background-color: #000; 
    }
    
    .news-image { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        display: block; 
    }

    .bottom-content-wrapper { 
        flex: 0 0 332px; 
        width: 1080px; 
        background: linear-gradient(160deg, #1e293b 0%, #0a0f1d 100%); 
        display: flex; 
        flex-direction: column; 
        padding: 20px 60px 15px 60px;
        z-index: 2; 
        overflow: hidden;
    }

    .meta-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        height: 50px;
        margin-bottom: 10px;
    }
    
    .news-date { 
        font-family: 'Noto Sans Bengali', sans-serif !important;
        font-size: 24px; 
        color: #f39c12; 
        font-weight: 500; 
    }
    
    .meta-logo img { 
        height: 50px; 
        object-fit: contain; 
        display: block; 
    }

    .headline-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .news-headline { 
        font-family: 'Noto Sans Bengali', sans-serif; 
        font-size: 52px; 
        line-height: 1.35; 
        font-weight: 700; 
        color: #ffffff; 
        text-shadow: 2px 2px 4px rgba(0,0,0,0.6); 
        width: 100%; 
    }
    
    .details-hint { 
        font-family: 'Noto Sans Bengali', sans-serif !important;
        font-size: 22px; 
        color: #ecf0f1; 
        margin-top: 15px; 
        font-weight: 500; 
        display: inline-block;
        background: transparent; 
    }

    .full-width-ad-bar {
        flex: 0 0 100px; 
        width: 1080px;
        background: #111;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 3;
        overflow: hidden;
        border-top: 3px solid #ef4444;
    }
    
    .full-width-ad-bar img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        display: block; 
    }

    /* Success Toast Notification */
    .studio-toast {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translate(-50%, 50px);
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(16, 185, 129, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(16, 185, 129, 0.1);
        padding: 16px 24px;
        border-radius: 12px;
        color: #ffffff;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 14px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-family: 'Noto Sans Bengali', sans-serif;
        min-width: 480px;
    }

    .studio-toast.show {
        transform: translate(-50%, 0);
        opacity: 1;
        visibility: visible;
    }

    .toast-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .toast-body {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .toast-title {
        font-weight: 700;
        font-size: 0.92rem;
        color: #ffffff;
    }

    .toast-desc {
        font-size: 0.78rem;
        color: #cbd5e1;
        line-height: 1.4;
    }

    /* Mobile and tablet responsive adaptations */
    @media (max-width: 1200px) {
        .inspector-panel {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            transform: translateX(-100%);
            margin-left: 0 !important;
        }
        
        .inspector-panel.open {
            transform: translateX(0);
        }
        
        .toggle-studio-panel-btn {
            display: flex !important;
        }
    }
</style>
@endsection

@section('content')
<div class="studio-container">
    <!-- Inspector Panel (Left side) -->
    <div class="inspector-panel" id="inspectorPanel">
        <div class="inspector-header">
            <span class="inspector-title">
                <i class="fa-solid fa-palette"></i> ক্যানভাস ডিজাইন স্টুডিও
            </span>
        </div>

        <div class="inspector-content">
            <!-- Section 1: পোস্ট ও শিরোনাম -->
            <div class="inspector-section">
                <span class="section-title">
                    <i class="fa-solid fa-newspaper"></i> পোস্ট ও শিরোনাম
                </span>
                
                <div>
                    <label class="studio-label"><i class="fa-solid fa-shuffle text-danger me-1"></i> পোস্ট পরিবর্তন করুন</label>
                    <select id="post_switcher" class="studio-select" onchange="window.location.href = '/admin/posts/' + this.value + '/social-card'">
                        @foreach($recentPosts as $p)
                            <option value="{{ $p->id }}" {{ $p->id == $post->id ? 'selected' : '' }}>
                                {{ Str::limit($p->title, 25) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="studio-label"><i class="fa-solid fa-heading text-danger me-1"></i> কাস্টম শিরোনাম</label>
                    <textarea id="live_headline_input" class="studio-input" rows="3" style="resize: none;" placeholder="শিরোনাম টাইপ করুন...">{{ $post->title }}</textarea>
                    <div class="char-count-wrapper">
                        <span>অক্ষর সংখ্যা: <span id="charCount" class="char-count-badge">0</span></span>
                    </div>
                </div>
            </div>

            <!-- Section 2: ফন্ট ও টেক্সট স্টাইল -->
            <div class="inspector-section">
                <span class="section-title">
                    <i class="fa-solid fa-font"></i> ফন্ট ও টেক্সট স্টাইল
                </span>

                <div>
                    <label class="studio-label">ফন্ট ফ্যামিলি</label>
                    <select class="studio-select" id="font_switcher" onchange="changeFontFamily(this.value)">
                        <option value="'Noto Sans Bengali', sans-serif" selected>Noto Sans (ক্লিন)</option>
                        <option value="'Baloo Da 2', sans-serif">Baloo Da 2 (রাউন্ডেড)</option>
                        <option value="'Anek Bangla', sans-serif">Anek Bangla (মডার্ন)</option>
                        <option value="'Tiro Bangla', serif">Tiro Bangla (পত্রিকা স্টাইল)</option>
                        <option value="'Hind Siliguri', sans-serif">Hind Siliguri</option>
                        <option value="'Mina', sans-serif">Mina</option>
                        <option value="'Galada', cursive">Galada (স্টাইলিশ)</option>
                    </select>
                </div>

                <div>
                    <label class="studio-label">ফন্ট সাইজ</label>
                    <div class="slider-wrapper">
                        <input type="range" class="studio-range" id="fontSizeSlider" min="40" max="80" value="52" step="1" oninput="updateFontSize(this.value)">
                        <span class="slider-val-badge" id="fontSizeBadge">52px</span>
                    </div>
                </div>

                <div>
                    <label class="studio-label">লাইন হাইট (স্পেসিং)</label>
                    <div class="slider-wrapper">
                        <input type="range" class="studio-range" id="lineHeightSlider" min="1.0" max="1.6" value="1.3" step="0.05" oninput="updateLineHeight(this.value)">
                        <span class="slider-val-badge" id="lineHeightBadge">1.3</span>
                    </div>
                </div>

                <div>
                    <label class="studio-label">টেক্সট কালার (সিলেক্টেড অংশ)</label>
                    <div class="color-swatch-wrapper">
                        <div class="color-swatch" style="background: #ffffff;" onclick="applyQuickColor('#ffffff')" title="সাদা"></div>
                        <div class="color-swatch" style="background: #f39c12;" onclick="applyQuickColor('#f39c12')" title="সোনালী"></div>
                        <div class="color-swatch" style="background: #ef4444;" onclick="applyQuickColor('#ef4444')" title="লাল"></div>
                        <div class="color-swatch" style="background: #10b981;" onclick="applyQuickColor('#10b981')" title="সবুজ"></div>
                        <div class="color-swatch" style="background: #0ea5e9;" onclick="applyQuickColor('#0ea5e9')" title="আকাশী"></div>
                        <input type="color" class="color-picker-studio" id="colorPicker" oninput="changeSelectedColor(this.value)" value="#ffffff" title="কাস্টম কালার">
                    </div>
                </div>
            </div>

            <!-- Section 3: ব্যাকগ্রাউন্ড ও ব্যানার -->
            <div class="inspector-section">
                <span class="section-title">
                    <i class="fa-regular fa-image"></i> ব্যাকগ্রাউন্ড ও বিজ্ঞাপন
                </span>

                <div>
                    <label class="studio-label">ব্যাকগ্রাউন্ড ছবি পরিবর্তন</label>
                    <label for="social_card_image" class="bg-upload-zone">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span style="font-size: 0.8rem; font-weight: 700;">নতুন ব্যাকগ্রাউন্ড আপলোড করুন</span>
                        <span style="font-size: 0.7rem; color:#64748b;">(JPG, PNG supported)</span>
                        <img id="bg_thumb_preview" class="bg-upload-preview" src="" style="display: none;">
                    </label>
                    <input type="file" id="social_card_image" accept="image/*" style="display: none;" onchange="previewSocialCardImage(this)">
                </div>

                <div>
                    <label class="studio-label">বিজ্ঞাপন ব্যানার</label>
                    <div class="ad-presets mb-2">
                        <button type="button" class="btn-preset-ad active" id="ad_default_btn" onclick="applyAdPreset('default')">ডিফল্ট অ্যাড</button>
                        <button type="button" class="btn-preset-ad" id="ad_sponsor_btn" onclick="applyAdPreset('sponsor')">কাস্টম লিংক</button>
                    </div>
                    <div id="ad_url_container" style="display: none;">
                        <input type="text" id="ad_url_input" placeholder="পিক্সেল ব্যানার ছবির লিংক (১০৮০x১০০)..." class="studio-input">
                        <button type="button" onclick="updateMainAd()" class="btn btn-secondary btn-sm mt-2 w-100" style="font-size: 0.8rem;"><i class="fa-solid fa-check me-1"></i> ব্যানারটি যুক্ত করুন</button>
                    </div>
                </div>
            </div>

            <!-- Section 4: কুইক ডাউনলোড ও ফেসবুক পোস্ট -->
            <div class="inspector-section" style="background: transparent; border: none; padding: 0;">
                <button type="button" onclick="download_SocialCard(event)" class="download-gradient-btn">
                    <i class="fa-solid fa-download" style="font-size: 1.1rem;"></i>  কার্ডটি সেভ করুন
                </button>

                <button type="button" onclick="shareOnFacebook(event)" class="btn-facebook-share mt-2">
                    <i class="fa-brands fa-facebook" style="font-size: 1.15rem;"></i> ফেসবুকে পোস্ট করুন
                </button>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-secondary w-100 justify-content-center" style="border-radius: 8px; font-size: 0.85rem; font-weight: 600;">
                        <i class="fa-solid fa-pen-to-square"></i> সংবাদ সম্পাদনা
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Studio Canvas Workspace (Right side) -->
    <div class="canvas-workspace" id="canvasWorkspace">
        <!-- Toggle button to open/close inspector panel on mobile or desktop -->
        <button class="toggle-studio-panel-btn" id="togglePanelBtn" onclick="toggleInspectorPanel()" title="প্যানেল লুকান/দেখান">
            <i class="fa-solid fa-sliders" id="togglePanelIcon"></i>
        </button>

        <!-- 1080x1080 Canvas Scaled Box -->
        <div class="scale-container" id="scaleContainer">
            <!-- Figma-like crop marks and guidelines -->
            <div class="canvas-guide guide-tl"></div>
            <div class="canvas-guide guide-tr"></div>
            <div class="canvas-guide guide-bl"></div>
            <div class="canvas-guide guide-br"></div>
            <div class="canvas-resolution-badge"><i class="fa-solid fa-vector-square text-danger me-1"></i> ১০৮০ × ১০৮০ পিক্সেল (১:১)</div>

            <div id="social_card_node" class="news-card-1080">
                <!-- News Image Section -->
                <div class="news-image-wrapper">
                    @if($post->social_card_image)
                        <img src="{{ $post->social_card_image_url }}" class="news-image" id="cardImagePreview" crossorigin="anonymous">
                    @elseif($post->featured_image)
                        <img src="{{ $post->featured_image_url }}" class="news-image" id="cardImagePreview" crossorigin="anonymous">
                    @else
                        <img src="" class="news-image" id="cardImagePreview" crossorigin="anonymous" style="display: none;">
                        <div id="cardImagePlaceholder" style="width:100%; height:100%; background:#1e293b; display: flex; flex-direction: column; align-items: center; justify-content: center; color: rgba(255,255,255,0.4); gap: 10px;">
                            <i class="fa-regular fa-image" style="font-size: 50px;"></i>
                            <span style="font-family:'Noto Sans Bengali',sans-serif; font-size: 18px; font-weight:700;">ইমেজ পাওয়া যায়নি</span>
                        </div>
                    @endif
                </div>

                <!-- Bottom Content Section -->
                <div class="bottom-content-wrapper">
                    <div class="meta-row">
                        <div class="news-date" id="cardDatePreview" contenteditable="true" spellcheck="false">
                            তারিখ...
                        </div>
                        <div class="meta-logo">
                            @if(!empty($themeSettings['logo_image']))
                                <img src="{{ asset($themeSettings['logo_image']) }}" alt="Logo" crossorigin="anonymous">
                            @else
                                <h3 style="color:#fff; font-family:'Noto Sans Bengali',sans-serif; margin:0; font-size: 30px; font-weight: 900;">দৈনিক ভোলা<span>টাইমস্</span></h3>
                            @endif
                        </div>
                    </div>

                    <div class="headline-wrapper">
                        <div class="news-headline" id="editable_headline" contenteditable="true" spellcheck="false">
                            {{ $post->title }}
                        </div>
                        <div class="details-hint" contenteditable="true" spellcheck="false">
                            বিস্তারিত কমেন্টে......
                        </div>
                    </div>
                </div>

                <!-- Watermark Logo -->
                @if(!empty($themeSettings['logo_image']))
                    <img src="{{ asset($themeSettings['logo_image']) }}" alt="Watermark" class="centered-watermark" crossorigin="anonymous">
                @endif

                <!-- Advertisement bottom bar -->
                <div class="full-width-ad-bar" id="main_ad_bar">
                    <img src="https://bholatimes24.com/wp-content/uploads/2026/04/Gemini_Generated_Image_66o0b466o0b466o0-1.png" alt="Default Ad" crossorigin="anonymous">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Beautiful floating success toast -->
<div class="studio-toast" id="studioToast">
    <div class="toast-icon">
        <i class="fa-solid fa-circle-check"></i>
    </div>
    <div class="toast-body">
        <span class="toast-title" id="toastTitle">ক্যাপশন কপি করা হয়েছে!</span>
        <span class="toast-desc" id="toastDesc">ইমেজ ডাউনলোড হয়েছে। ফেসবুকে পেস্ট করুন।</span>
    </div>
</div>
@endsection

@section('scripts')
<!-- html2canvas Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    // Pre-populate background image sources from database values
    let featuredImageSrc = '{{ $post->featured_image ? $post->featured_image_url : "" }}';
    let socialCardImageSrc = '{{ $post->social_card_image ? $post->social_card_image_url : "" }}';

    // Convert date numbers to Bengali numerals
    function toBengaliDigits(num) {
        const bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return num.toString().replace(/[0-9]/g, w => bnDigits[+w]);
    }

    // Format and inject dynamic Bengali Date
    function updateBengaliDate() {
        const monthNames = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        const dayNames = ['রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
        const d = new Date('{{ $post->created_at ? $post->created_at->toIso8601String() : "" }}' || new Date());
        const bnDayName = dayNames[d.getDay()];
        const bnDay = toBengaliDigits(d.getDate());
        const bnMonth = monthNames[d.getMonth()];
        const bnYear = toBengaliDigits(d.getFullYear());
        const formattedDate = `${bnDayName}, ${bnDay} ${bnMonth}, ${bnYear}`;
        
        const dateEl = document.getElementById('cardDatePreview');
        if (dateEl) {
            dateEl.innerText = formattedDate;
        }
    }

    // Font selection logic
    function changeFontFamily(fontName) {
        const selection = window.getSelection();
        if (selection.rangeCount > 0 && selection.toString().length > 0) {
            document.execCommand("fontName", false, fontName);
        } else {
            const target = document.getElementById('editable_headline');
            if (target) {
                target.style.fontFamily = fontName;
                const switcher = document.getElementById('font_switcher');
                if (switcher) switcher.value = fontName;
            }
        }
    }

    // Font color logic
    function changeSelectedColor(color) {
        document.execCommand('styleWithCSS', false, true); 
        document.execCommand('foreColor', false, color);
        const picker = document.getElementById('colorPicker');
        if (picker) picker.value = color;
    }

    // Apply quick brand color swatches
    function applyQuickColor(color) {
        changeSelectedColor(color);
    }

    // Font size logic (called by range slider)
    function updateFontSize(size) {
        const badge = document.getElementById('fontSizeBadge');
        if (badge) badge.innerText = size + 'px';
        
        const slider = document.getElementById('fontSizeSlider');
        if (slider) slider.value = size;

        const selection = window.getSelection();
        if (selection.rangeCount > 0 && selection.toString().length > 0) {
            document.execCommand("fontSize", false, "7"); 
            const fontElements = document.querySelectorAll("font[size='7']");
            fontElements.forEach(el => {
                el.removeAttribute("size");
                el.style.fontSize = size + "px";
            });
        } else {
            const target = document.getElementById('editable_headline');
            if (target) target.style.fontSize = size + 'px';
        }
    }

    // Base font size logic (for back-compatibility)
    function changeFontSize(size) {
        updateFontSize(size);
    }

    // Line height logic
    function updateLineHeight(val) {
        const badge = document.getElementById('lineHeightBadge');
        if (badge) badge.innerText = val;
        
        const slider = document.getElementById('lineHeightSlider');
        if (slider) slider.value = val;

        const target = document.getElementById('editable_headline');
        if (target) target.style.lineHeight = val;
    }

    // Base line height logic (for back-compatibility)
    function changeLineHeight(val) {
        updateLineHeight(val);
    }

    // Ad Preset Management
    function applyAdPreset(type) {
        const defaultBtn = document.getElementById('ad_default_btn');
        const sponsorBtn = document.getElementById('ad_sponsor_btn');
        const container = document.getElementById('ad_url_container');
        const adImage = document.querySelector('#main_ad_bar img');

        if (type === 'default') {
            defaultBtn.classList.add('active');
            sponsorBtn.classList.remove('active');
            container.style.display = 'none';
            adImage.src = "https://bholatimes24.com/wp-content/uploads/2026/04/Gemini_Generated_Image_66o0b466o0b466o0-1.png";
        } else {
            defaultBtn.classList.remove('active');
            sponsorBtn.classList.add('active');
            container.style.display = 'block';
            updateMainAd();
        }
    }

    // Ad updating
    function updateMainAd() {
        const url = document.getElementById('ad_url_input').value.trim();
        const adImage = document.querySelector('#main_ad_bar img');
        if (url) {
            adImage.src = url; 
        } else {
            adImage.src = "https://bholatimes24.com/wp-content/uploads/2026/04/Gemini_Generated_Image_66o0b466o0b466o0-1.png";
        }
    }

    // Toggle left inspector panel collapse/expand
    function toggleInspectorPanel() {
        const panel = document.getElementById('inspectorPanel');
        const btn = document.getElementById('togglePanelBtn');
        const icon = document.getElementById('togglePanelIcon');
        
        if (panel.classList.contains('collapsed')) {
            panel.classList.remove('collapsed');
            panel.classList.add('open');
            icon.className = 'fa-solid fa-sliders';
            btn.title = 'প্যানেল লুকান';
        } else {
            panel.classList.add('collapsed');
            panel.classList.remove('open');
            icon.className = 'fa-solid fa-chevron-right';
            btn.title = 'প্যানেল দেখান';
        }
        
        // Wait for CSS transition then trigger canvas resizing
        setTimeout(resizeCanvasWorkspace, 305);
    }

    // Toggle bottom control bar (back-compatibility/no-op)
    function toggleBottomBar() {
        toggleInspectorPanel();
    }

    // Background Image updater
    function updateCardBackground() {
        const cardImg = document.getElementById('cardImagePreview');
        const placeholder = document.getElementById('cardImagePlaceholder');
        const src = socialCardImageSrc || featuredImageSrc;
        const thumb = document.getElementById('bg_thumb_preview');

        if (src) {
            if (cardImg) {
                cardImg.src = src;
                cardImg.style.display = 'block';
            }
            if (placeholder) placeholder.style.display = 'none';
            if (thumb) {
                thumb.src = src;
                thumb.style.display = 'block';
            }
        } else {
            if (cardImg) {
                cardImg.src = '';
                cardImg.style.display = 'none';
            }
            if (placeholder) placeholder.style.display = 'flex';
            if (thumb) {
                thumb.src = '';
                thumb.style.display = 'none';
            }
        }
    }

    // Sync Custom Social Card Image upload
    function previewSocialCardImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                socialCardImageSrc = e.target.result;
                updateCardBackground();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            socialCardImageSrc = '{{ $post->social_card_image ? $post->social_card_image_url : "" }}';
            updateCardBackground();
        }
    }

    // Custom Toast Notification Controller
    function showToast(title, desc) {
        const toast = document.getElementById('studioToast');
        const tTitle = document.getElementById('toastTitle');
        const tDesc = document.getElementById('toastDesc');
        
        if (toast && tTitle && tDesc) {
            tTitle.innerText = title;
            tDesc.innerText = desc;
            
            toast.classList.add('show');
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                toast.classList.remove('show');
            }, 5000);
        }
    }

    // Share & Copy to Clipboard Workflow for Facebook
    function shareOnFacebook(e) {
        e.preventDefault();
        const node = document.getElementById('social_card_node');
        const scaleContainer = document.getElementById('scaleContainer');
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> পোস্ট প্রসেস হচ্ছে...';
        btn.style.pointerEvents = 'none';

        // 1. Remove text cursor caret by blurring active editable element
        const activeEl = document.activeElement;
        if (activeEl && activeEl.isContentEditable) {
            activeEl.blur();
        }

        // 2. Temporarily save and reset scaling transform to 1 (natural 1080x1080 size) to avoid html2canvas crop bugs
        const originalTransform = scaleContainer ? scaleContainer.style.transform : '';
        if (scaleContainer) {
            scaleContainer.style.transform = 'none';
        }

        // 3. Add exporting class to strip borders, outlines, hover tooltips, and revert padding
        node.classList.add('exporting');

        // 4. Capture Canvas image and download it
        setTimeout(() => {
            html2canvas(node, {
                useCORS: true,
                allowTaint: false,
                width: 1080,
                height: 1080,
                scale: 2, 
                backgroundColor: '#000000'
            }).then(canvas => {
                // Restore exporting class and scale transform immediately
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }

                // Download JPG card
                const link = document.createElement('a');
                link.download = 'NewsCard-BholaTimes-{{ $post->id }}.jpg';
                link.href = canvas.toDataURL("image/jpeg", 0.95);
                link.click();

                // 5. Copy Headline and Public URL to Clipboard as Caption
                const headlineText = document.getElementById('editable_headline').innerText.trim();
                const postLink = '{{ route("post", $post->slug) }}';
                const clipboardText = `${headlineText}\n\nবিস্তারিত পড়তে ক্লিক করুন: ${postLink}`;

                navigator.clipboard.writeText(clipboardText).then(() => {
                    // Show a stunning premium success toast
                    showToast(
                        'ক্যাপশন ও লিংক কপিড! 📥',
                        'নিউজ ইমেজ ডাউনলোড হয়েছে। ফেসবুকে ছবিটি আপলোড করে ক্যাপশনটি পেস্ট (Ctrl+V) করুন।'
                    );
                    
                    // 6. Open Facebook in a new tab after 1.5 seconds
                    setTimeout(() => {
                        window.open('https://www.facebook.com/', '_blank');
                    }, 1500);
                }).catch(err => {
                    console.error("Clipboard copy failed:", err);
                    showToast('ডাউনলোড সম্পূর্ণ! 📥', 'ছবিটি ডাউনলোড হয়েছে। ফেসবুকে আপলোড করুন।');
                });
                
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            }).catch(err => {
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }
                console.error("html2canvas render failed:", err);
                alert("ছবি প্রস্তুত করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।");
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            });
        }, 180);
    }

    // Save as Image Function
    function download_SocialCard(e) {
        e.preventDefault();
        const node = document.getElementById('social_card_node');
        const scaleContainer = document.getElementById('scaleContainer');
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> ক্যানভাস প্রস্তুত হচ্ছে...';
        btn.style.pointerEvents = 'none';

        // 1. Remove text cursor caret by blurring active editable element
        const activeEl = document.activeElement;
        if (activeEl && activeEl.isContentEditable) {
            activeEl.blur();
        }

        // 2. Temporarily save and reset scaling transform to 1 (natural 1080x1080 size) to avoid html2canvas crop bugs
        const originalTransform = scaleContainer ? scaleContainer.style.transform : '';
        if (scaleContainer) {
            scaleContainer.style.transform = 'none';
        }

        // 3. Add exporting class to strip borders, outlines, hover tooltips, and revert padding
        node.classList.add('exporting');

        // Brief delay to ensure browser layout adjusts and styles propagate
        setTimeout(() => {
            html2canvas(node, {
                useCORS: true,
                allowTaint: false,
                width: 1080,
                height: 1080,
                scale: 2, 
                backgroundColor: '#000000'
            }).then(canvas => {
                // 4. Restore exporting class and scale transform immediately
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }

                const link = document.createElement('a');
                link.download = 'NewsCard-BholaTimes-{{ $post->id }}.jpg';
                link.href = canvas.toDataURL("image/jpeg", 0.95);
                link.click();
                
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            }).catch(err => {
                node.classList.remove('exporting');
                if (scaleContainer) {
                    scaleContainer.style.transform = originalTransform;
                }
                console.error("html2canvas render failed:", err);
                alert("ছবি সেভ করতে সমস্যা হয়েছে। কনসোল লগ চেক করুন বা ইমেজ লিংকগুলো ঠিক আছে কিনা দেখুন।");
                btn.innerHTML = originalText;
                btn.style.pointerEvents = 'auto';
            });
        }, 180);
    }

    // Dynamic Auto-scaling for the 1080x1080 canvas workspace
    function resizeCanvasWorkspace() {
        const workspace = document.getElementById('canvasWorkspace');
        const scaleContainer = document.getElementById('scaleContainer');
        if (!workspace || !scaleContainer) return;

        const wWidth = workspace.clientWidth;
        const wHeight = workspace.clientHeight;

        // Fit 1080x1080 canvas inside workspace with dynamic margin padding
        const targetSize = 1080;
        const padding = 70; // 35px padding on each side
        const scale = Math.min((wWidth - padding) / targetSize, (wHeight - padding) / targetSize);

        scaleContainer.style.transform = `scale(${scale})`;
    }

    // Character length counter function
    function updateCharCount(text) {
        const countBadge = document.getElementById('charCount');
        if (countBadge) {
            countBadge.innerText = text.length;
            if (text.length > 80) {
                countBadge.style.color = '#dc2626';
            } else {
                countBadge.style.color = '#475569';
            }
        }
    }

    // Event Listeners for real-time form bindings and auto-resizing
    document.addEventListener('DOMContentLoaded', function() {
        const headlineInput = document.getElementById('live_headline_input');
        const headlinePreview = document.getElementById('editable_headline');

        if (headlineInput && headlinePreview) {
            headlineInput.addEventListener('input', function() {
                headlinePreview.innerText = this.value || 'সংবাদের শিরোনাম এখানে লিখুন...';
                updateCharCount(this.value);
            });
            updateCharCount(headlineInput.value);
        }

        // Generate Bengali dynamic date for first load
        updateBengaliDate();

        // Perform initial canvas scaling fit
        resizeCanvasWorkspace();
        
        // Initialize background upload thumbnail if any exists on load
        updateCardBackground();

        // Bind sidebar toggling buttons to resize layout with transition delay
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');
        if (openBtn) openBtn.addEventListener('click', () => setTimeout(resizeCanvasWorkspace, 280));
        if (closeBtn) closeBtn.addEventListener('click', () => setTimeout(resizeCanvasWorkspace, 280));

        // Bind window resize event
        window.addEventListener('resize', resizeCanvasWorkspace);
    });
</script>
@endsection
