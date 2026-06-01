@php
    $themeSettingsPath = storage_path('app/theme_settings.json');
    $themeSettings = [
        'logo_text' => 'দৈনিক ভোলা<span>টাইমস্</span>',
        'logo_image' => '',
    ];
    if (file_exists($themeSettingsPath)) {
        $themeSettings = array_merge($themeSettings, json_decode(file_get_contents($themeSettingsPath), true));
    }
@endphp
@extends('layouts.admin')

@section('title', 'ই-পেপার লেআউট বিল্ডার | অ্যাডমিন প্যানেল')
@section('header_title', 'ই-পেপার লেআউট বিল্ডার')

@section('styles')
<style>
    /* ═══════════════════════════════════════════════
       LAYOUT BUILDER — COMPLETE REDESIGN
       ═══════════════════════════════════════════════ */

    /* ── Root Layout ── */
    .builder-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 0;
        height: calc(100vh - 140px);
        overflow: hidden;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.06);
        background: #0d1117;
    }

    /* ── Left Sidebar ── */
    .news-drawer {
        background: #161b22;
        border-right: 1px solid rgba(255,255,255,0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }

    .drawer-header {
        padding: 16px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        flex-shrink: 0;
    }

    .drawer-header h5 {
        margin: 0 0 12px 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: #e6edf3;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .drawer-header h5 i { color: #3b82f6; }

    .drawer-body {
        flex: 1;
        overflow-y: auto;
        padding: 12px;
    }

    .drawer-body::-webkit-scrollbar { width: 5px; }
    .drawer-body::-webkit-scrollbar-track { background: transparent; }
    .drawer-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 3px; }

    .news-card-item {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 8px;
        cursor: grab;
        display: flex;
        gap: 10px;
        transition: all 0.15s ease;
        user-select: none;
    }
    .news-card-item:active { cursor: grabbing; }
    .news-card-item.placed { opacity: 0.4; pointer-events: none; }
    .news-card-item:hover {
        border-color: #3b82f6;
        background: rgba(59,130,246,0.08);
        transform: translateX(3px);
    }

    .news-item-img {
        width: 56px; height: 42px;
        border-radius: 6px;
        object-fit: cover;
        flex-shrink: 0;
        background: #21262d;
    }

    .news-item-details {
        display: flex; flex-direction: column;
        justify-content: center;
        min-width: 0; flex: 1;
    }

    .news-item-title {
        font-size: 0.8rem; font-weight: 700;
        color: #e6edf3; margin: 0;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-item-meta {
        font-size: 0.65rem; color: #8b949e; margin-top: 2px;
    }

    /* ── Right: Canvas Area ── */
    .canvas-area {
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        background: #0d1117;
    }

    /* Toolbar */
    .canvas-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 16px;
        background: #161b22;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        flex-shrink: 0;
        gap: 12px;
    }

    .page-tabs {
        display: flex;
        gap: 4px;
    }
    .page-tab {
        padding: 6px 14px;
        background: transparent;
        color: #8b949e;
        border-radius: 6px;
        cursor: pointer;
        border: 1px solid transparent;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.15s ease;
    }
    .page-tab:hover { color: #e6edf3; background: rgba(255,255,255,0.05); }
    .page-tab.active {
        background: #3b82f6;
        color: #fff;
        border-color: #3b82f6;
    }

    .zoom-controls {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .zoom-controls label { font-size: 0.75rem; color: #8b949e; margin: 0; }
    .zoom-controls input[type="range"] { width: 100px; accent-color: #3b82f6; }
    .zoom-controls span { font-size: 0.75rem; color: #e6edf3; min-width: 35px; }

    /* Viewport — the scrollable window */
    .canvas-viewport {
        flex: 1;
        overflow: auto;
        background: #010409;
        position: relative;
    }
    .canvas-viewport::-webkit-scrollbar { width: 10px; height: 10px; }
    .canvas-viewport::-webkit-scrollbar-track { background: #0d1117; }
    .canvas-viewport::-webkit-scrollbar-thumb { background: #30363d; border-radius: 5px; }
    .canvas-viewport::-webkit-scrollbar-thumb:hover { background: #484f58; }
    .canvas-viewport::-webkit-scrollbar-corner { background: #0d1117; }

    /* Canvas centering container */
    .canvas-center {
        display: inline-block;
        padding: 40px;
        min-width: 100%;
        min-height: 100%;
        box-sizing: border-box;
    }

    /* The newspaper page itself */
    .broadsheet-canvas {
        background: #ffffff;
        border: 1px solid #333;
        width: 936px;
        height: 1300px;
        padding: 0px;
        color: #111;
        box-shadow: 0 4px 40px rgba(0,0,0,0.6);
        box-sizing: border-box;
        position: relative;
        margin: 0 auto;
        font-family: 'SutonnyOMJ', 'SolaimanLipi', Arial, sans-serif;
    }

    /* Page layers */
    /* Page layers */
    .page-layer {
        position: absolute;
        left: -9999px;
        top: 0;
        width: 100%;
        height: 1300px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .page-layer.active {
        position: relative;
        left: 0;
    }

    /* ── Newspaper Grid ── */
    .broadsheet-grid {
        display: grid;
        grid-template-columns: repeat(32, 1fr);
        gap: 5px;
        flex: 1;
    }
    #grid1 { grid-template-rows: repeat(6, minmax(0, 1fr)); height: calc(1300px - 196px); }
    #grid2 { grid-template-rows: repeat(16, minmax(0, 1fr)); height: 1260px; }
    #grid4 { grid-template-rows: repeat(16, minmax(0, 1fr)); height: 1260px; }

    /* ── Drop Slots ── */
    .drop-slot {
        border: 2px dashed rgba(17,17,17,0.2);
        background: rgba(17,17,17,0.02);
        border-radius: 4px;
        position: relative;
        padding: 5px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .drop-slot:hover { border-color: rgba(17,17,17,0.4); background: rgba(17,17,17,0.04); }
    .drop-slot.dragover {
        border-color: #dc2626;
        background: rgba(220,38,38,0.08);
        box-shadow: inset 0 0 20px rgba(220,38,38,0.1);
    }
    .drop-slot.occupied { border: 1px solid transparent; background: transparent; border-radius: 0; }
    .drop-slot.occupied:hover { outline: 2px solid #3b82f6; outline-offset: -2px; }
    .drop-slot.selected { outline: 3px solid #3b82f6; outline-offset: -3px; }

    .slot-label {
        font-size: 0.6rem; font-weight: 800;
        background: #111; color: #fff;
        padding: 1px 5px; border-radius: 0 0 4px 0;
        position: absolute; top: 0; left: 0; z-index: 2;
    }

    .slot-empty {
        display: flex; flex-direction: column;
        justify-content: center; align-items: center;
        height: 100%; color: #aaa;
        font-size: 0.75rem; pointer-events: none;
    }
    .slot-empty i { color: #ccc; margin-bottom: 4px; }

    /* ── Rendered Content ── */
    .rendered-content {
        display: flex; flex-direction: column;
        height: 100%; pointer-events: auto;
    }
    .rendered-title {
        font-size: 1rem; font-weight: 800;
        line-height: 1.15; margin-bottom: 5px; color: #111;
        text-align: center;
    }
    .rendered-image-wrapper {
        width: 100%; aspect-ratio: 16 / 9;
        background: #ddd; margin-bottom: 5px;
        overflow: hidden;
    }
    .rendered-image-wrapper img {
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .rendered-excerpt {
        font-size: 0.8rem; line-height: 1.15;
        color: #222; text-align: justify;
        column-count: 2; column-gap: 15px;
        overflow: hidden; flex: 1;
    }
    .jump-tag { color: #dc2626; font-weight: bold; font-size: 0.75rem; }

    /* ── Jump Page ── */
    .jump-grid {
        column-count: 4;
        column-gap: 5px;
        height: 1440px;
    }
    .jump-slot {
        break-inside: avoid;
        margin-bottom: 5px;
        background: #ffffff; border-bottom: 2px solid #111; padding-bottom: 5px;
        display: flex; flex-direction: column; overflow: hidden;
    }

    /* ── Bottom Editor Panel ── */
    .editor-panel {
        position: fixed;
        bottom: -100px;
        left: 0; right: 0;
        height: 64px;
        background: #161b22;
        border-top: 2px solid #3b82f6;
        display: flex; align-items: center;
        justify-content: center; gap: 16px;
        padding: 0 24px;
        transition: bottom 0.25s ease;
        z-index: 1000;
        color: #e6edf3;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.4);
    }
    .editor-panel.active { bottom: 0; }
    .editor-panel label { font-size: 0.75rem; color: #8b949e; margin: 0; }
    .editor-panel .form-control-sm {
        background: #0d1117; border-color: #30363d;
        color: #e6edf3; font-size: 0.8rem;
    }


    /* ── Preview Mode ── */
    .preview-mode .drop-slot {
        border-color: transparent !important;
        background: transparent !important;
    }
    .preview-mode .drop-slot:hover {
        outline: none !important;
    }
    .preview-mode .slot-label {
        display: none !important;
    }
    .preview-mode .slot-empty {
        visibility: hidden !important;
    }
    .preview-mode .drop-slot.empty-slot {
        border-color: transparent !important;
        background: transparent !important;
    }

    /* ── Premium Toast Notifications ── */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .premium-toast {
        background: #1f2937;
        color: #ffffff;
        border-left: 5px solid #dc2626;
        padding: 12px 24px;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        font-family: 'Noto Sans Bengali', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0;
        transform: translateY(-20px);
        animation: slideIn 0.3s forwards, fadeOut 0.3s 3.7s forwards;
        min-width: 250px;
    }
    .premium-toast.success { border-left-color: #10b981; }
    .premium-toast.info { border-left-color: #3b82f6; }
    .premium-toast.warning { border-left-color: #f59e0b; }

    @keyframes slideIn {
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOut {
        to { opacity: 0; transform: translateY(-20px); }
    }
</style>
@endsection

@section('content')
<!-- Top Action Bar -->
<div class="action-bar">
    <div class="d-flex align-items-center gap-3">
        <input type="date" id="epaperDate" class="form-control form-control-sm" style="width: 150px;" value="{{ $selectedDate->format('Y-m-d') }}" onchange="loadEPaperLayout()">
        <input type="text" id="epaperSlogan" class="form-control form-control-sm" style="width: 200px;" placeholder="মাস্টহেড স্লোগান">
        <span id="saveStatusBadge" class="badge bg-success px-2.5 py-1.5" style="font-family: 'Noto Sans Bengali', sans-serif;"><i class="fa-solid fa-cloud-check me-1"></i>সংরক্ষিত</span>
    </div>
    <div class="d-flex align-items-center gap-2">
        <!-- Undo/Redo Buttons -->
        <button id="btnUndo" class="btn btn-sm btn-outline-secondary" onclick="undo()" disabled title="Undo (Ctrl+Z)"><i class="fa-solid fa-undo"></i></button>
        <button id="btnRedo" class="btn btn-sm btn-outline-secondary" onclick="redo()" disabled title="Redo (Ctrl+Y)"><i class="fa-solid fa-redo"></i></button>
        
        <!-- Preview Mode Toggle -->
        <button id="btnPreview" class="btn btn-sm btn-outline-info" onclick="togglePreviewMode()" title="Preview Layout"><i class="fa-solid fa-eye"></i> প্রিভিউ</button>
        
        <button class="btn btn-sm btn-outline-warning" onclick="exportToImage()"><i class="fa-solid fa-download"></i> 300 DPI Export</button>
        <button class="btn btn-sm btn-primary" onclick="saveEPaperLayout()"><i class="fa-solid fa-save"></i> Save Layout</button>
    </div>
</div>

<!-- Main Builder -->
<div class="builder-container">
    <!-- Left: WP News Feed -->
    <aside class="news-drawer">
        <div class="drawer-header">
            <h5><i class="fa-brands fa-wordpress"></i> WP News Feed</h5>
            <div class="d-flex gap-2 mb-2">
                <input type="date" id="wpDate" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" style="background:#0d1117;border-color:#30363d;color:#e6edf3;">
                <button class="btn btn-sm btn-outline-secondary" onclick="fetchWPPosts()"><i class="fa-solid fa-sync-alt"></i></button>
            </div>
            <input type="text" id="wpSearch" class="form-control form-control-sm" placeholder="🔍 Search news..." onkeyup="filterWPPosts()" style="background:#0d1117;border-color:#30363d;color:#e6edf3;">
            <button class="btn btn-sm btn-success w-100 mt-2" onclick="autoPlacePostsByTags()" style="font-weight: 700; border-radius: 6px; font-family: 'Noto Sans Bengali', sans-serif;"><i class="fa-solid fa-bolt me-1"></i> ট্যাগ অনুযায়ী অটো-ফিট</button>
        </div>
        <div class="drawer-body" id="wpPostsList">
            <div class="text-center text-muted mt-4"><i class="fa-solid fa-spinner fa-spin"></i> Loading...</div>
        </div>
    </aside>

    <!-- Right: Canvas Area -->
    <div class="canvas-area">
        <!-- Toolbar -->
        <div class="canvas-toolbar">
            <div class="page-tabs">
                <div class="page-tab active" onclick="switchPage(1)">পৃষ্ঠা ১</div>
                <div class="page-tab" onclick="switchPage(2)">পৃষ্ঠা ২</div>
                <div class="page-tab" onclick="switchPage(3)">পৃষ্ঠা ৩</div>
                <div class="page-tab" onclick="switchPage(4)">পৃষ্ঠা ৪</div>
            </div>
            <div class="zoom-controls">
                <label>Zoom</label>
                <input type="range" id="zoomSlider" min="30" max="150" value="55" oninput="updateZoom()">
                <span id="zoomValue">55%</span>
            </div>
        </div>

        <!-- Scrollable Viewport -->
        <div class="canvas-viewport" id="viewport">
            <div class="canvas-center">
                <div class="broadsheet-canvas" id="canvas">

                    <!-- PAGE 1 -->
                    <div class="page-layer active" id="page1">
                        <header class="front-masthead" style="height: 180px; display: flex; flex-direction: column; justify-content: space-between; border-bottom: 3px solid #111; margin-bottom: 16px; padding: 15px 15px 0 15px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-grow: 1;">
                                <!-- Left: Dates -->
                                <div style="width: 25%; font-size: 0.8rem; font-weight: bold; line-height: 1.6; border-right: 2px solid #111; padding-right: 15px;">
                                    <div id="mastheadDateDisplay"><i class="fa-regular fa-calendar" style="width: 15px;"></i> {{ $selectedDate->format('d M Y') }} ({{ ['Sunday'=>'রবিবার','Monday'=>'সোমবার','Tuesday'=>'মঙ্গলবার','Wednesday'=>'বুধবার','Thursday'=>'বৃহস্পতিবার','Friday'=>'শুক্রবার','Saturday'=>'শনিবার'][$selectedDate->format('l')] }})</div>
                                    <div><i class="fa-solid fa-moon" style="width: 15px;"></i> ১৪ জ্যৈষ্ঠ ১৪৩৩ বঙ্গাব্দ</div>
                                    <div><i class="fa-solid fa-star-and-crescent" style="width: 15px;"></i> ১১ জিলহজ ১৪৪৭ হিজরি</div>
                                    <div><i class="fa-solid fa-book-open" style="width: 15px;"></i> বর্ষ: ১, সংখ্যা: ১২০</div>
                                </div>
                                <!-- Middle: Logo -->
                                <div style="width: 50%; text-align: center;">
                                    @if(!empty($themeSettings['logo_image']))
                                        <img src="{{ asset($themeSettings['logo_image']) }}" alt="Logo" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                                    @else
                                        <h1 style="font-size: 4.5rem; font-weight: 900; margin: 0; letter-spacing: -2px; color: #111;">{!! $themeSettings['logo_text'] ?? 'দৈনিক ভোলা<span style="color: #dc2626;">টাইমস্</span>' !!}</h1>
                                    @endif
                                </div>
                                <!-- Right: Balance -->
                                <div style="width: 25%;"></div>
                            </div>
                            <!-- Bottom Strip -->
                            <div style="background: #111; color: #fff; padding: 6px 15px; display: flex; justify-content: space-between; font-size: 0.9rem; font-weight: bold; margin-top: 5px;">
                                <span>রেজিঃ নং - ১২৩৪</span>
                                <span>পৃষ্ঠা: ৪</span>
                                <span>মূল্য: ৫ টাকা</span>
                                <span><i class="fa-brands fa-facebook text-primary"></i> fb.com/bholatimes</span>
                                <span><i class="fa-solid fa-globe text-info"></i> www.bholatimes24.com</span>
                            </div>
                        </header>
                        <div class="broadsheet-grid" id="grid1" style="padding: 0 15px 15px 15px;">
                            <!-- Row 1 & 2 -->
                            <div class="drop-slot" data-slot="1" style="grid-column: span 15; grid-row: span 2;"></div>
                            <div class="drop-slot" data-slot="2" style="grid-column: span 6; grid-row: span 2;"></div>
                            <div class="drop-slot" data-slot="3" style="grid-column: span 11; grid-row: span 2;"></div>
                            <!-- Row 3 & 4 -->
                            <div class="drop-slot" data-slot="4" style="grid-column: span 11; grid-row: span 2;"></div>
                            <div class="drop-slot" data-slot="5" style="grid-column: span 10; grid-row: span 2;"></div>
                            <div class="drop-slot" data-slot="6" style="grid-column: span 11; grid-row: span 2;"></div>
                            <!-- Row 5 & 6 -->
                            <div class="drop-slot" data-slot="7" style="grid-column: span 10; grid-row: span 2;"></div>
                            <div class="drop-slot" data-slot="8" style="grid-column: span 12; grid-row: span 2;"></div>
                            <div class="drop-slot" data-slot="9" style="grid-column: span 10; grid-row: span 2;"></div>
                        </div>
                    </div>

                    <!-- PAGE 2 -->
                    <div class="page-layer" id="page2" style="padding: 15px;">
                        <div style="border-bottom: 2px solid #111; margin-bottom: 10px; font-weight: bold; font-size: 1.2rem;">পৃষ্ঠা ২ (Full News)</div>
                        <div class="broadsheet-grid" id="grid2">
                            <div class="drop-slot" data-slot="1" style="grid-column: span 16; grid-row: span 6;"></div>
                            <div class="drop-slot" data-slot="2" style="grid-column: span 16; grid-row: span 6;"></div>
                            <div class="drop-slot" data-slot="3" style="grid-column: span 12; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="4" style="grid-column: span 8; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="5" style="grid-column: span 12; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="6" style="grid-column: span 8; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="7" style="grid-column: span 8; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="8" style="grid-column: span 8; grid-row: span 5;"></div>
                            <div class="drop-slot" data-slot="9" style="grid-column: span 8; grid-row: span 5;"></div>
                        </div>
                    </div>

                    <!-- PAGE 3 (Jumps) -->
                    <div class="page-layer" id="page3" style="padding: 15px;">
                        <div style="border-bottom: 2px solid #111; margin-bottom: 10px; font-weight: bold; font-size: 1.2rem;">পৃষ্ঠা ৩ (বাকি অংশ)</div>
                        <div class="jump-grid" id="grid3"></div>
                    </div>

                    <!-- PAGE 4 -->
                    <div class="page-layer" id="page4" style="padding: 15px;">
                        <div style="border-bottom: 2px solid #111; margin-bottom: 10px; font-weight: bold; font-size: 1.2rem;">পৃষ্ঠা ৪</div>
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
                    </div>

                </div><!-- .broadsheet-canvas -->
            </div><!-- .canvas-center -->
        </div><!-- .canvas-viewport -->
    </div><!-- .canvas-area -->
</div><!-- .builder-container -->

<!-- Bottom Editor Panel -->
<div class="editor-panel" id="editorPanel" style="height: auto; padding: 15px;">
    <div class="d-flex flex-wrap align-items-center gap-3">
        <div class="d-flex align-items-center gap-1">
            <label class="small fw-bold text-white mb-0">Font Size:</label>
            <input type="number" id="editFontSize" class="form-control form-control-sm" style="width: 70px;" onchange="applyEdit()">
        </div>
        <div class="d-flex align-items-center gap-1">
            <label class="small fw-bold text-white mb-0">Columns:</label>
            <select id="editColumns" class="form-control form-control-sm" style="width: 60px;" onchange="applyEdit()">
                <option value="1">1</option><option value="2">2</option><option value="3">3</option>
            </select>
        </div>

        <div class="d-flex align-items-center gap-1">
            <label class="small fw-bold text-white mb-0">Headline Weight:</label>
            <select id="editFontWeight" class="form-control form-control-sm" style="width: 100px;" onchange="applyEdit()">
                <option value="normal">Normal</option>
                <option value="600">Medium</option>
                <option value="bold">Bold</option>
                <option value="800">Extra Bold</option>
            </select>
        </div>
        <div class="d-flex align-items-center gap-1">
            <label class="small fw-bold text-white mb-0">Headline Space:</label>
            <select id="editWordSpacing" class="form-control form-control-sm" style="width: 90px;" onchange="applyEdit()">
                <option value="-2px">Tight</option>
                <option value="-1px">Semi-Tight</option>
                <option value="0px">Normal</option>
                <option value="2px">Semi-Wide</option>
                <option value="4px">Wide</option>
            </select>
        </div>
        <div class="d-flex align-items-center gap-1">
            <label class="small fw-bold text-white mb-0">Line Height:</label>
            <select id="editLineHeight" class="form-control form-control-sm" style="width: 90px;" onchange="applyEdit()">
                <option value="1.0">Tight (1.0)</option>
                <option value="1.15">Normal (1.15)</option>
                <option value="1.4">Relaxed (1.4)</option>
                <option value="1.6">Loose (1.6)</option>
            </select>
        </div>
        <div class="d-flex align-items-center gap-1">
            <label class="small fw-bold text-white mb-0">Text Align:</label>
            <select id="editTextAlign" class="form-control form-control-sm" style="width: 95px;" onchange="applyEdit()">
                <option value="left">Left</option>
                <option value="center">Center</option>
                <option value="right">Right</option>
                <option value="justify">Justify</option>
            </select>
        </div>
        <div class="d-flex align-items-center gap-1">
            <label class="small fw-bold text-white mb-0">Title Align:</label>
            <select id="editTitleAlign" class="form-control form-control-sm" style="width: 90px;" onchange="applyEdit()">
                <option value="left">Left</option>
                <option value="center">Center</option>
                <option value="right">Right</option>
            </select>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" id="editShowImage" onchange="applyEdit()" style="cursor:pointer;">
                <label class="form-check-label small fw-bold text-white" for="editShowImage" style="cursor:pointer;">Show Photo</label>
            </div>
        </div>
        <div class="ms-auto d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-danger" onclick="removeSelectedSlot()"><i class="fa-solid fa-trash"></i> Delete</button>
            <button class="btn btn-sm btn-outline-light" onclick="closeEditor()"><i class="fa-solid fa-times"></i> Close</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@endsection

@section('scripts')
<script>
    let wpPosts = [];
    let pagesData = { '1': [], '2': [], '3': [], '4': [] };
    let activePage = 1;
    let selectedSlot = null;
    let scale = 0.55;

    // Undo/Redo Stacks
    let undoStack = [];
    let redoStack = [];
    const MAX_HISTORY = 20;
    let isDirty = false;

    document.addEventListener('DOMContentLoaded', () => {
        setupDragEvents();
        setupZoom();
        applyZoom();
        fetchWPPosts();
        loadEPaperLayout();
        setupKeyboardShortcuts();
    });

    // ─── Zoom via CSS zoom (works with native scroll!) ───
    function setupZoom() {
        const viewport = document.getElementById('viewport');
        viewport.addEventListener('wheel', (e) => {
            if (e.ctrlKey) {
                e.preventDefault();
                const delta = e.deltaY > 0 ? -0.05 : 0.05;
                scale = Math.min(Math.max(0.3, scale + delta), 1.5);
                document.getElementById('zoomSlider').value = Math.round(scale * 100);
                applyZoom();
            }
        }, { passive: false });
    }

    function updateZoom() {
        scale = document.getElementById('zoomSlider').value / 100;
        document.getElementById('zoomValue').innerText = Math.round(scale * 100) + '%';
        applyZoom();
    }

    function applyZoom() {
        const center = document.querySelector('.canvas-center');
        // CSS zoom is layout-aware — scrollbars work naturally!
        center.style.zoom = scale;
        document.getElementById('zoomValue').innerText = Math.round(scale * 100) + '%';
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
        closeEditor();
    }

    // ─── Automatic Slot Placement by Tags ───
    function autoPlacePostsByTags() {
        if (!wpPosts || wpPosts.length === 0) {
            showToast("⚠️ বাম পাশে কোনো পোস্ট লোড করা নেই! অনুগ্রহ করে প্রথমে তারিখ অনুযায়ী পোস্ট লোড করুন।", "warning");
            return;
        }

        let placedCount = 0;
        let filledSlots = new Set();
        let placeActions = [];

        // Helper to map Bengali digits to English
        const bnToEn = { '১':'1', '২':'2', '৩':'3', '৪':'4', '৫':'5', '৬':'6', '৭':'7', '৮':'8', '৯':'9', '০':'0', '১০':'10', '১১':'11', '১২':'12' };
        function parseDigits(str) {
            return str.replace(/[০-৯]/g, m => bnToEn[m] || m);
        }

        wpPosts.forEach(post => {
            // Collect all term names and slugs from embedded taxonomy categories & tags
            let terms = [];
            if (post._embedded && post._embedded['wp:term']) {
                post._embedded['wp:term'].forEach(taxonomyArray => {
                    if (Array.isArray(taxonomyArray)) {
                        taxonomyArray.forEach(term => {
                            if (term.name) terms.push(term.name.toLowerCase());
                            if (term.slug) terms.push(term.slug.toLowerCase());
                        });
                    }
                });
            }

            let matchedPage = null;
            let matchedSlot = null;

            for (let term of terms) {
                let normalizedTerm = parseDigits(term);

                // Regex patterns to match: page-[page]-slot-[slot] / p[page]s[slot] / p[page]-s[slot] / page[page]slot[slot]
                let m1 = normalizedTerm.match(/\bpage[-_]?(\d+)[-_]?slot[-_]?(\d+)\b/);
                let m2 = normalizedTerm.match(/\bp(\d+)[-_]?s(\d+)\b/);
                // Bengali patterns: পেইজ/পাতা [page] স্লট [slot]
                let m3 = normalizedTerm.match(/(?:পেইজ|পৃষ্ঠা|পাতা)[-_]?(\d+)[-_]?(?:স্লট)[-_]?(\d+)/);

                let match = m1 || m2 || m3;
                if (match) {
                    matchedPage = parseInt(match[1]);
                    matchedSlot = parseInt(match[2]);
                    break; // stop checking other terms for this post once matched
                }
            }

            if (matchedPage && matchedSlot) {
                const slotKey = `${matchedPage}_${matchedSlot}`;
                // Verify page layout exists, slot isn't already assigned in this batch, and slot element exists
                if ([1, 2, 4].includes(matchedPage) && !filledSlots.has(slotKey)) {
                    const slotEl = document.querySelector(`#grid${matchedPage} .drop-slot[data-slot="${matchedSlot}"]`);
                    if (slotEl) {
                        // Check if this post is already placed elsewhere in the entire pagesData structure
                        let isAlreadyPlaced = false;
                        Object.values(pagesData).forEach(pData => {
                            pData.forEach(s => {
                                if (s && s.post_id === post.id) isAlreadyPlaced = true;
                            });
                        });

                        if (!isAlreadyPlaced) {
                            const img = post._embedded && post._embedded['wp:featuredmedia'] ? post._embedded['wp:featuredmedia'][0].source_url : '';
                            
                            const postData = {
                                id: post.id,
                                title: post.title.rendered,
                                content: post.content ? post.content.rendered : '',
                                excerpt: post.excerpt ? post.excerpt.rendered : '',
                                image: img
                            };
                            
                            const slotObject = getSlotDefaultObject(matchedPage, matchedSlot, postData);

                            placeActions.push({ page: matchedPage, slot: matchedSlot, data: slotObject });
                            filledSlots.add(slotKey);
                            placedCount++;
                        }
                    }
                }
            }
        });

        if (placedCount > 0) {
            // Save state to Undo history before applying changes
            saveHistoryState();

            // Apply all matching placements
            placeActions.forEach(action => {
                // Filter out any existing post placed in the same slot on the target page
                pagesData[action.page] = pagesData[action.page].filter(s => s.slot_id !== action.slot);
                // Insert the new auto-fitted post
                pagesData[action.page].push(action.data);
            });

            // Re-render the canvas slots and sidebar list to show Placed statuses
            renderCanvas();
            renderWPList();
            
            // Mark builder state as unsaved and enable undo
            updateUndoRedoButtons();
            
            showToast(`⚡ ${placedCount}টি নিউজ সফলভাবে ট্যাগ মিলিয়ে স্বয়ংক্রিয়ভাবে স্লটে বসানো হয়েছে!`, "success");
        } else {
            showToast("⚠️ ট্যাগ মিলিয়ে স্লটে বসানোর মতো নতুন কোনো নিউজ পাওয়া যায়নি।", "warning");
        }
    }

    // ─── WP API Fetching ───
    function fetchWPPosts() {
        const dateStr = document.getElementById('wpDate').value;
        document.getElementById('wpPostsList').innerHTML = '<div class="text-center mt-3" style="color:#8b949e;"><i class="fa-solid fa-spinner fa-spin"></i> Loading WP Posts...</div>';

        fetch(`{{ route('admin.epaper.wp_posts') }}?date=${dateStr}`)
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    wpPosts = data.posts;
                    renderWPList();
                } else {
                    document.getElementById('wpPostsList').innerHTML = `<div class="text-danger p-2" style="font-size:0.8rem;">${data.message || 'Error fetching posts.'}</div>`;
                }
            })
            .catch(err => {
                console.error("WP Fetch Error:", err);
                document.getElementById('wpPostsList').innerHTML = '<div class="text-danger p-2" style="font-size:0.8rem;">Error fetching posts.</div>';
            });
    }

    function renderWPList() {
        const query = document.getElementById('wpSearch').value.toLowerCase();
        const list = document.getElementById('wpPostsList');

        const placedIds = [];
        Object.values(pagesData).forEach(page => {
            page.forEach(slot => {
                if(slot && slot.post_id) placedIds.push(parseInt(slot.post_id));
            });
        });

        list.innerHTML = '';
        wpPosts.forEach(post => {
            if (query && !post.title.rendered.toLowerCase().includes(query)) return;

            const isPlaced = placedIds.includes(post.id);
            const img = post._embedded && post._embedded['wp:featuredmedia'] ? post._embedded['wp:featuredmedia'][0].source_url : '';

            const el = document.createElement('div');
            el.className = `news-card-item ${isPlaced ? 'placed' : ''}`;
            el.draggable = !isPlaced;
            el.ondragstart = (e) => {
                e.dataTransfer.setData('text/plain', JSON.stringify({
                    id: post.id,
                    title: post.title.rendered,
                    content: post.content ? post.content.rendered : '',
                    excerpt: post.excerpt ? post.excerpt.rendered : '',
                    image: img
                }));
            };

            el.innerHTML = `
                ${img ? `<img src="${img}" class="news-item-img">` : '<div class="news-item-img d-flex align-items-center justify-content-center" style="color:#484f58;font-size:0.6rem;">No Img</div>'}
                <div class="news-item-details">
                    <div class="news-item-title">${post.title.rendered}</div>
                    <div class="news-item-meta">${isPlaced ? '<span style="color:#3fb950;">✓ Placed</span>' : new Date(post.date).toLocaleDateString()}</div>
                </div>
            `;
            list.appendChild(el);
        });

        if (list.innerHTML === '') {
            list.innerHTML = '<div class="text-center mt-4" style="color:#484f58;font-size:0.8rem;">No posts found for this date.</div>';
        }
    }

    function filterWPPosts() { renderWPList(); }

    // ─── Drag and Drop ───
    function setupDragEvents() {
        document.querySelectorAll('.drop-slot').forEach(slot => {
            slot.ondragover = e => { e.preventDefault(); slot.classList.add('dragover'); };
            slot.ondragleave = () => { slot.classList.remove('dragover'); };
            slot.ondrop = e => {
                e.preventDefault();
                slot.classList.remove('dragover');
                let rawData = e.dataTransfer.getData('text/plain');
                if (!rawData) return;
                const data = JSON.parse(rawData);
                const slotId = parseInt(slot.getAttribute('data-slot'));
                placeContent(activePage, slotId, data);
            };
            slot.onclick = () => selectSlot(activePage, parseInt(slot.getAttribute('data-slot')), slot);
        });
    }

    function getSlotDefaultObject(page, slotId, data) {
        const rawContent = data.content || data.excerpt || '';
        const cleanText = rawContent.replace(/(<([^>]+)>)/gi, "");
        let defaultFontSize = 16;
        let defaultColumns = (page === 1 ? 2 : 3);
        if (page === 1 && slotId === 1) {
            defaultFontSize = 32;
            defaultColumns = 2;
        } else if (page === 1 && slotId === 2) {
            defaultFontSize = 13;
            defaultColumns = 1;
        } else if (page === 1 && slotId === 3) {
            defaultFontSize = 28;
            defaultColumns = 2;
        }
        const style = { 
            font_size: defaultFontSize, 
            columns: defaultColumns, 
            char_limit: (page === 2 ? 5000 : 1500),
            line_height: '1.15',
            title_align: 'center',
            title_color: '#111111',
            font_weight: 'bold',
            word_spacing: '0px',
            text_align: 'justify',
            show_image: true
        };

        return {
            slot_id: slotId, post_id: data.id,
            title: data.title, content: cleanText,
            image: data.image, style: style
        };
    }

    function placeContent(page, slotId, data) {
        if (page === 3) return;
        saveHistoryState();

        const slotData = getSlotDefaultObject(page, slotId, data);

        pagesData[page] = pagesData[page].filter(s => s.slot_id !== slotId);
        pagesData[page].push(slotData);
        renderCanvas();
        renderWPList();
    }

    function renderCanvas() {
        // Reset grids
        [1, 2, 4].forEach(page => {
            document.querySelectorAll(`#grid${page} .drop-slot`).forEach(slot => {
                slot.innerHTML = `<div class="slot-label">Slot ${slot.getAttribute('data-slot')}</div><div class="slot-empty"><i class="fa-solid fa-plus fa-2x"></i><span>Drop Post Here</span></div>`;
                slot.classList.remove('occupied');
            });
        });

        let jumpItems = [];

        [1, 2, 4].forEach(page => {
            pagesData[page].forEach(slotData => {
                const slotEl = document.querySelector(`#grid${page} .drop-slot[data-slot="${slotData.slot_id}"]`);
                if (!slotEl) return;

                slotEl.classList.add('occupied');

                let text = slotData.content;
                let showJump = false;

                if (page === 1 || page === 4) {
                    if (text.length > slotData.style.char_limit) {
                        const jumpText = text.substring(slotData.style.char_limit);
                        text = text.substring(0, slotData.style.char_limit);
                        showJump = true;
                        jumpItems.push({ from_page: page, title: slotData.title, content: jumpText });
                    }
                }

                // Hide photo if slot spans only 1 column
                const gridColumnStyle = slotEl.style.gridColumn;
                const spanCol = gridColumnStyle.includes('span') ? parseInt(gridColumnStyle.split('span')[1].trim()) : 8;
                let showPhoto = spanCol > 4 && slotData.image;
                if (slotData.style.hasOwnProperty('show_image')) {
                    showPhoto = slotData.style.show_image && slotData.image;
                }

                // Render full text first
                slotEl.innerHTML = `
                    <div class="rendered-content" style="height: 100%; display: flex; flex-direction: column; overflow: hidden; box-sizing: border-box;">
                        <div class="rendered-title" contenteditable="true" style="font-size: ${slotData.style.font_size}px; text-align: ${slotData.style.title_align || 'center'}; color: ${slotData.style.title_color || '#111111'}; font-weight: ${slotData.style.font_weight || 'bold'}; word-spacing: ${slotData.style.word_spacing || '0px'};" onfocus="selectSlot(${page}, ${slotData.slot_id}, document.querySelector('#grid${page} .drop-slot[data-slot=\\'${slotData.slot_id}\\']'))" onblur="updateSlotTitle(${page}, ${slotData.slot_id}, this)" onclick="event.stopPropagation()" onmousedown="event.stopPropagation()">${slotData.title}</div>
                        ${showPhoto ? `<div class="rendered-image-wrapper" style="flex-shrink:0;"><img src="/admin/epaper/proxy-image?url=${encodeURIComponent(slotData.image)}" crossorigin="anonymous"></div>` : ''}
                        <div class="rendered-excerpt" contenteditable="true" style="column-count: ${slotData.style.columns}; column-gap: 15px; line-height: ${slotData.style.line_height || '1.15'}; text-align: ${slotData.style.text_align || 'justify'}; flex: 1; min-height: 0; overflow: hidden;" onfocus="selectSlot(${page}, ${slotData.slot_id}, document.querySelector('#grid${page} .drop-slot[data-slot=\\'${slotData.slot_id}\\']'))" onblur="updateSlotContent(${page}, ${slotData.slot_id}, this)" onclick="event.stopPropagation()" onmousedown="event.stopPropagation()">
                            ${slotData.content}
                        </div>
                    </div>
                `;

                // Run auto-split for Page 1 and Page 4
                if (page === 1 || page === 4) {
                    const contentEl = slotEl.querySelector('.rendered-content');
                    const excerptEl = slotEl.querySelector('.rendered-excerpt');
                    const maxAllowedHeight = slotEl.clientHeight - 10;
                    
                    if (contentEl.scrollHeight > maxAllowedHeight) {
                        let cleanText = slotData.content;
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
                        jumpItems.push({ from_page: page, title: slotData.title, content: jumpText });
                    }
                }
            });
        });

        // Render Page 3
        const grid3 = document.getElementById('grid3');
        if (grid3) {
            grid3.innerHTML = '';
            pagesData['3'] = jumpItems;
            jumpItems.forEach(jump => {
                grid3.innerHTML += `
                    <div class="jump-slot">
                        <div style="font-weight:bold; font-size: 1.1rem; border-bottom:1px solid #ddd; margin-bottom:5px;">
                            ${jump.title} <span class="badge bg-danger ms-1" style="font-size: 0.7rem;">${jump.from_page}ম পাতার পর</span>
                        </div>
                        <div class="rendered-excerpt" style="column-count: 1; column-gap: 15px;">${jump.content}</div>
                    </div>
                `;
            });
        }
    }



    // ─── Editor Logic ───
    function selectSlot(page, slotId, el) {
        if (page === 3) return;
        const slotData = pagesData[page].find(s => s.slot_id === slotId);
        if (!slotData) return;

        document.querySelectorAll('.drop-slot').forEach(s => s.classList.remove('selected'));
        if (el) el.classList.add('selected');
        selectedSlot = { page, slotId };

        document.getElementById('editFontSize').value = slotData.style.font_size;
        document.getElementById('editColumns').value = slotData.style.columns;
        document.getElementById('editFontWeight').value = slotData.style.font_weight || 'bold';
        document.getElementById('editWordSpacing').value = slotData.style.word_spacing || '0px';
        document.getElementById('editLineHeight').value = slotData.style.line_height || '1.15';
        document.getElementById('editShowImage').checked = slotData.style.show_image !== false;
        document.getElementById('editTextAlign').value = slotData.style.text_align || 'justify';
        document.getElementById('editTitleAlign').value = slotData.style.title_align || 'center';
        document.getElementById('editorPanel').classList.add('active');
    }

    function applyEdit() {
        if (!selectedSlot) return;
        const slotData = pagesData[selectedSlot.page].find(s => s.slot_id === selectedSlot.slotId);
        if (slotData) {
            saveHistoryState();
            slotData.style.font_size = parseInt(document.getElementById('editFontSize').value);
            slotData.style.columns = parseInt(document.getElementById('editColumns').value);
            slotData.style.font_weight = document.getElementById('editFontWeight').value;
            slotData.style.word_spacing = document.getElementById('editWordSpacing').value;
            slotData.style.line_height = document.getElementById('editLineHeight').value;
            slotData.style.show_image = document.getElementById('editShowImage').checked;
            slotData.style.text_align = document.getElementById('editTextAlign').value;
            slotData.style.title_align = document.getElementById('editTitleAlign').value;
            renderCanvas();
        }
    }

    function removeSelectedSlot() {
        if (!selectedSlot) return;
        saveHistoryState();
        pagesData[selectedSlot.page] = pagesData[selectedSlot.page].filter(s => s.slot_id !== selectedSlot.slotId);
        closeEditor();
        renderCanvas();
        renderWPList();
    }

    function closeEditor() {
        selectedSlot = null;
        document.querySelectorAll('.drop-slot').forEach(s => s.classList.remove('selected'));
        document.getElementById('editorPanel').classList.remove('active');
    }

    // ─── DB Sync ───
    function loadEPaperLayout() {
        const date = document.getElementById('epaperDate').value;
        fetch(`{{ route('admin.epaper.load') }}?date=${date}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    pagesData = data.saved_layout || { '1': [], '2': [], '3': [], '4': [] };
                    // Ensure style properties exist for backwards compatibility
                    [1, 2, 4].forEach(p => {
                        if (pagesData[p]) {
                            pagesData[p].forEach(slotData => {
                                if (!slotData.style) slotData.style = {};
                                if (slotData.style.line_height === undefined) slotData.style.line_height = '1.15';
                                if (slotData.style.title_align === undefined) slotData.style.title_align = 'center';
                                if (slotData.style.title_color === undefined) slotData.style.title_color = '#111111';
                                if (slotData.style.font_weight === undefined) slotData.style.font_weight = 'bold';
                                if (slotData.style.word_spacing === undefined) slotData.style.word_spacing = '0px';
                                if (slotData.style.text_align === undefined) slotData.style.text_align = 'justify';
                                if (slotData.style.show_image === undefined) slotData.style.show_image = true;
                            });
                        }
                    });
                    document.getElementById('epaperSlogan').value = data.title || 'প্রথম পাতা';
                    if (data.formatted_date) {
                        document.getElementById('mastheadDateDisplay').innerHTML = '<i class="fa-regular fa-calendar" style="width: 15px;"></i> ' + data.formatted_date;
                    }
                    
                    // Clear history on layout load
                    undoStack = [];
                    redoStack = [];
                    const btnUndo = document.getElementById('btnUndo');
                    const btnRedo = document.getElementById('btnRedo');
                    if (btnUndo) btnUndo.disabled = true;
                    if (btnRedo) btnRedo.disabled = true;
                    updateSaveBadgeSaved();

                    renderCanvas();
                    renderWPList();
                }
            });
    }

    function saveEPaperLayout() {
        const date = document.getElementById('epaperDate').value;
        const title = document.getElementById('epaperSlogan').value;

        fetch(`{{ route('admin.epaper.save') }}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ date, title, layout: pagesData })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('ই-পেপার লেআউট সফলভাবে সংরক্ষিত হয়েছে।', 'success');
                updateSaveBadgeSaved();
            } else {
                showToast('লেআউট সংরক্ষণ করতে ব্যর্থ হয়েছে।', 'danger');
            }
        });
    }

    // ─── Export ───
    function exportToImage() {
        const canvasEl = document.getElementById('canvas');
        const center = document.querySelector('.canvas-center');
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Rendering...';
        btn.disabled = true;

        // Temporarily reset zoom for export
        const oldZoom = center.style.zoom;
        center.style.zoom = '1';

        html2canvas(canvasEl, {
            scale: 6,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff'
        }).then(canvas => {
            center.style.zoom = oldZoom;
            const link = document.createElement('a');
            link.download = `epaper-page${activePage}-${document.getElementById('epaperDate').value}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
            btn.innerHTML = originalText;
            btn.disabled = false;
            showToast('ই-পেপার ৩০০০ ডিপিআই ইমেজ সফলভাবে এক্সপোর্ট হয়েছে।', 'success');
        }).catch(err => {
            console.error(err);
            center.style.zoom = oldZoom;
            showToast('ই-পেপার এক্সপোর্ট ব্যর্থ হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।', 'danger');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    // ─── Undo/Redo & Shortcuts ───
    function saveHistoryState() {
        const stateCopy = JSON.parse(JSON.stringify(pagesData));
        undoStack.push(stateCopy);
        if (undoStack.length > MAX_HISTORY) {
            undoStack.shift();
        }
        redoStack = []; // clear redo stack
        updateUndoRedoButtons();
    }

    function undo() {
        if (undoStack.length === 0) return;
        const currentState = JSON.parse(JSON.stringify(pagesData));
        redoStack.push(currentState);
        pagesData = undoStack.pop();
        renderCanvas();
        renderWPList();
        closeEditor();
        updateUndoRedoButtons();
        showToast('Undo successful', 'info');
    }

    // Update in-editor text changes back to pagesData if needed before undo
    function updateSlotTitle(page, slotId, el) {
        const slotData = pagesData[page].find(s => s.slot_id === slotId);
        if (slotData && slotData.title !== el.innerText) {
            saveHistoryState();
            slotData.title = el.innerText;
            renderCanvas();
            renderWPList();
        }
    }

    function updateSlotContent(page, slotId, el) {
        const slotData = pagesData[page].find(s => s.slot_id === slotId);
        if (slotData && slotData.content !== el.innerText) {
            saveHistoryState();
            slotData.content = el.innerText;
            renderCanvas();
            renderWPList();
        }
    }



    function redo() {
        if (redoStack.length === 0) return;
        const currentState = JSON.parse(JSON.stringify(pagesData));
        undoStack.push(currentState);
        pagesData = redoStack.pop();
        renderCanvas();
        renderWPList();
        closeEditor();
        updateUndoRedoButtons();
        showToast('Redo successful', 'info');
    }

    function updateUndoRedoButtons() {
        const btnUndo = document.getElementById('btnUndo');
        const btnRedo = document.getElementById('btnRedo');
        if (btnUndo) btnUndo.disabled = undoStack.length === 0;
        if (btnRedo) btnRedo.disabled = redoStack.length === 0;
        
        // Update status badge to unsaved
        const badge = document.getElementById('saveStatusBadge');
        if (badge) {
            badge.innerHTML = '<i class="fa-solid fa-circle-exclamation me-1"></i>সংরক্ষণ করুন';
            badge.className = 'badge bg-warning text-dark px-2.5 py-1.5';
        }
    }

    function updateSaveBadgeSaved() {
        const badge = document.getElementById('saveStatusBadge');
        if (badge) {
            badge.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i>সংরক্ষিত';
            badge.className = 'badge bg-success px-2.5 py-1.5';
        }
    }

    // ─── Keyboard & Toast Helpers ───
    function setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey) {
                if (e.key.toLowerCase() === 'z') {
                    e.preventDefault();
                    undo();
                } else if (e.key.toLowerCase() === 'y') {
                    e.preventDefault();
                    redo();
                }
            } else if (e.key === 'Delete') {
                const active = document.activeElement;
                const isEditable = active.hasAttribute('contenteditable') || 
                                   active.tagName === 'INPUT' || 
                                   active.tagName === 'SELECT' || 
                                   active.tagName === 'TEXTAREA';
                if (!isEditable && selectedSlot) {
                    e.preventDefault();
                    removeSelectedSlot();
                    showToast('Slot content deleted', 'info');
                }
            }
        });
    }

    let isPreviewMode = false;
    function togglePreviewMode() {
        isPreviewMode = !isPreviewMode;
        const canvas = document.getElementById('canvas');
        canvas.classList.toggle('preview-mode', isPreviewMode);
        
        const btn = document.getElementById('btnPreview');
        if (isPreviewMode) {
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> ডিজাইন মুড';
            btn.classList.replace('btn-outline-info', 'btn-info');
        } else {
            btn.innerHTML = '<i class="fa-solid fa-eye"></i> প্রিভিউ';
            btn.classList.replace('btn-info', 'btn-outline-info');
        }
    }

    function showToast(message, type = 'success') {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        
        const toast = document.createElement('div');
        toast.className = `premium-toast ${type}`;
        
        let icon = 'fa-circle-check';
        if (type === 'danger') icon = 'fa-triangle-exclamation';
        else if (type === 'info') icon = 'fa-info-circle';
        else if (type === 'warning') icon = 'fa-circle-exclamation';
        
        toast.innerHTML = `<i class="fa-solid ${icon}"></i> <span>${message}</span>`;
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 4000);
    }
</script>
@endsection
