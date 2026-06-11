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
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ই-পেপার লেআউট বিল্ডার | দৈনিক ভোলা টাইমস্</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* ═══════════════════════════════════════════════
           LAYOUT BUILDER — COMPLETE REDESIGN (STANDALONE)
           ═══════════════════════════════════════════════ */
        
        :root {
            --bg-app: #080c14;
            --bg-sidebar: #0d1321;
            --bg-card: #161f30;
            --bg-card-hover: rgba(59, 130, 246, 0.1);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: #3b82f6;
            --text-main: #e2e8f0;
            --text-muted: #94a3b8;
            --text-white: #ffffff;
            --accent-blue: #3b82f6;
            --accent-crimson: #dc2626;
            --accent-green: #10b981;
            --accent-yellow: #f59e0b;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg-app);
            color: var(--text-main);
            overflow: hidden;
            font-family: 'Noto Sans Bengali', 'Outfit', sans-serif;
            user-select: none;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* --- Header (Top Bar) --- */
        .app-header {
            height: 64px;
            background: var(--bg-sidebar);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            flex-shrink: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-white);
            margin: 0;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-logo span {
            color: var(--accent-crimson);
        }

        .global-settings {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-control-dark {
            background: #080c14 !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            border-radius: 6px;
            font-size: 0.85rem;
            transition: var(--transition);
        }
        .form-control-dark:focus {
            border-color: var(--accent-blue) !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
        }

        .form-control-dark::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        /* --- Workspace Layout --- */
        .app-workspace {
            display: flex;
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        /* --- Sidebar (Left & Right) --- */
        .sidebar {
            width: 320px;
            background: var(--bg-sidebar);
            display: flex;
            flex-direction: column;
            height: 100%;
            flex-shrink: 0;
            overflow: hidden;
            z-index: 90;
        }

        .sidebar-left {
            border-right: 1px solid var(--border-color);
        }

        .sidebar-right {
            border-left: 1px solid var(--border-color);
        }

        .sidebar-header {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            flex-shrink: 0;
        }

        .sidebar-header h5 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-white);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-body {
            flex: 1;
            overflow-y: auto;
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 4px;
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* --- WP Post Cards --- */
        .news-card-item {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px;
            cursor: grab;
            display: flex;
            gap: 8px;
            transition: var(--transition);
            user-select: none;
        }
        .news-card-item:active {
            cursor: grabbing;
        }
        .news-card-item.placed {
            opacity: 0.35;
            pointer-events: none;
            border-color: rgba(255, 255, 255, 0.03);
        }
        .news-card-item:hover {
            border-color: var(--border-hover);
            background: var(--bg-card-hover);
            transform: translateX(3px);
        }

        .news-item-img {
            width: 56px;
            height: 42px;
            border-radius: 4px;
            object-fit: cover;
            flex-shrink: 0;
            background: #111827;
        }

        .news-item-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
            flex: 1;
        }

        .news-item-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-item-meta {
            font-size: 0.65rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* --- Canvas Viewport (Center) --- */
        .canvas-workspace {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            background: var(--bg-app);
        }

        .workspace-toolbar {
            height: 48px;
            background: var(--bg-sidebar);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            flex-shrink: 0;
        }

        /* Page Tabs */
        .page-tabs {
            display: flex;
            gap: 4px;
        }
        .page-tab {
            padding: 5px 12px;
            background: transparent;
            color: var(--text-muted);
            border-radius: 6px;
            cursor: pointer;
            border: 1px solid transparent;
            font-size: 0.8rem;
            font-weight: 600;
            transition: var(--transition);
        }
        .page-tab:hover {
            color: var(--text-white);
            background: rgba(255, 255, 255, 0.04);
        }
        .page-tab.active {
            background: var(--accent-blue);
            color: var(--text-white);
            border-color: var(--accent-blue);
        }

        .zoom-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .zoom-controls label {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin: 0;
        }
        .zoom-controls input[type="range"] {
            width: 100px;
            accent-color: var(--accent-blue);
            cursor: pointer;
        }
        .zoom-controls span {
            font-size: 0.75rem;
            color: var(--text-main);
            min-width: 35px;
        }

        .canvas-viewport {
            flex: 1;
            overflow: auto;
            background: #020617;
            position: relative;
        }
        
        .canvas-viewport::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        .canvas-viewport::-webkit-scrollbar-track {
            background: #020617;
        }
        .canvas-viewport::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 5px;
        }
        .canvas-viewport::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }

        /* Broadsheet Canvas Centering */
        .canvas-center {
            display: inline-block;
            padding: 40px;
            min-width: 100%;
            min-height: 100%;
            box-sizing: border-box;
        }

        /* Broadsheet layout page styling */
        .broadsheet-canvas {
            background: #ffffff;
            border: 1px solid #1e293b;
            width: 936px;
            height: 1300px;
            padding: 0px;
            color: #111111;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.75);
            box-sizing: border-box;
            position: relative;
            margin: 0 auto;
            font-family: 'bangla', 'SutonnyOMJ', 'SolaimanLipi', Arial, sans-serif;
            user-select: text; /* Allow text editing and selection */
        }

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

        /* Broadsheet Grid */
        .broadsheet-grid {
            display: grid;
            grid-template-columns: repeat(32, 1fr);
            gap: 5px;
            flex: 1;
        }
        #grid1 { grid-template-rows: repeat(6, minmax(0, 1fr)); height: calc(1300px - 188px); grid-template-columns: repeat(8, 1fr); }
        #grid2 { grid-template-columns: repeat(3, 1fr); grid-template-rows: repeat(2, minmax(0, 1fr)); height: 1280px; gap: 10px; }
        #grid4 { grid-template-rows: auto repeat(6, minmax(0, 1fr)); height: calc(1300px - 60px); grid-template-columns: repeat(8, 1fr); gap: 10px; }

        /* Category Boxes (Page 2) */
        .category-box {
            border: 2px solid #e5e7eb;
            border-top: 4px solid #111111;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
            border-radius: 4px;
        }
        .category-header {
            background: linear-gradient(to right, #f3f4f6 0%, #ffffff 100%);
            border-bottom: 2px solid #e5e7eb;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .category-header i {
            color: #dc2626;
            font-size: 1.1rem;
        }
        .category-header span {
            font-family: 'Noto Sans Bengali', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            color: #111111;
            letter-spacing: -0.5px;
        }

        /* Drop Slots */
        .drop-slot {
            border: 2px dashed rgba(17, 17, 17, 0.18);
            background: rgba(17, 17, 17, 0.015);
            border-radius: 4px;
            position: relative;
            padding: 5px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            cursor: pointer;
            transition: var(--transition);
        }
        .drop-slot:hover {
            border-color: rgba(17, 17, 17, 0.4);
            background: rgba(17, 17, 17, 0.035);
        }
        .drop-slot.dragover {
            border-color: var(--accent-blue);
            background: rgba(59, 130, 246, 0.08);
            box-shadow: inset 0 0 15px rgba(59, 130, 246, 0.15);
        }
        .drop-slot.occupied {
            border: 1px solid transparent;
            background: transparent;
            border-radius: 0;
            padding: 1px;
        }
        .drop-slot.occupied:hover {
            outline: 2px solid var(--accent-blue);
            outline-offset: -2px;
        }
        .drop-slot.selected {
            outline: 3px solid var(--accent-blue);
            outline-offset: -3px;
        }

        .slot-label {
            font-size: 0.6rem;
            font-weight: 800;
            background: #111111;
            color: #ffffff;
            padding: 1px 5px;
            border-radius: 0 0 4px 0;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 2;
        }

        .slot-empty {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            color: #a3a3a3;
            font-size: 0.75rem;
            pointer-events: none;
        }
        .slot-empty i {
            color: #d4d4d4;
            margin-bottom: 4px;
        }

        /* Rendered Content */
        .rendered-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            pointer-events: auto;
        }
        .rendered-title {
            font-size: 1rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 3px;
            color: #111111;
            text-align: center;
            outline: none;
        }
        .rendered-image-wrapper {
            width: 100%;
            aspect-ratio: 16 / 9;
            background: #e5e5e5;
            margin-bottom: 3px;
            overflow: hidden;
        }
        .rendered-image-wrapper.half {
            width: 50% !important;
            float: left;
            margin-right: 8px;
            margin-bottom: 4px;
            aspect-ratio: 4 / 3 !important;
        }
        .rendered-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .rendered-excerpt {
            font-size: 12px !important;
            line-height: 1.02;
            color: #222222;
            text-align: justify;
            column-count: 2;
            column-gap: 8px;
            overflow: hidden;
            margin-top: auto;
            outline: none;
            font-family: 'bangla', 'SutonnyOMJ', 'SolaimanLipi', Arial, sans-serif;
        }
        .jump-tag {
            color: #111111;
            font-weight: bold;
            font-size: inherit;
        }

        .jump-grid {
            column-count: 4;
            column-gap: 15px;
            height: 1195px;
            column-fill: auto;
            overflow: hidden;
            box-sizing: border-box;
        }
        .jump-slot {
            margin-bottom: 2px;
            background: #ffffff;
            padding-bottom: 2px;
        }

        /* --- Right Sidebar Editor Controls --- */
        .editor-section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 4px;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        /* Switch Styling */
        .form-switch .form-check-input {
            width: 2.5em;
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--border-color);
        }
        .form-switch .form-check-input:checked {
            background-color: var(--accent-blue);
            border-color: var(--accent-blue);
        }

        .editor-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            height: 100%;
        }

        /* Toast Container overrides */
        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .premium-toast {
            background: #1e293b;
            color: var(--text-white);
            border-left: 5px solid var(--accent-crimson);
            padding: 14px 20px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            font-family: 'Noto Sans Bengali', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0;
            transform: translateY(-20px);
            animation: slideIn 0.3s forwards, fadeOut 0.3s 3.7s forwards;
            min-width: 280px;
        }
        .premium-toast.success { border-left-color: var(--accent-green); }
        .premium-toast.info { border-left-color: var(--accent-blue); }
        .premium-toast.warning { border-left-color: var(--accent-yellow); }

        @keyframes slideIn {
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            to { opacity: 0; transform: translateY(-20px); }
        }

        /* Preview Mode Override */
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

        /* Styling for select fields in bootstrap */
        select.form-control-dark {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            background-size: 16px 12px !important;
            appearance: none !important;
            padding-right: 2rem !important;
        }

        /* Page 1 Slot 3 Box Highlight Style */
        #grid1 .drop-slot[data-slot="3"] {
            border: 1.5px solid #222222;
            padding: 6px !important;
            background: rgba(17, 17, 17, 0.02);
        }
        #grid1 .drop-slot[data-slot="3"].dragover {
            border-color: var(--accent-blue);
            background: rgba(59, 130, 246, 0.08);
        }
    </style>
</head>
<body>

    <!-- Premium Standalone Header -->
    <header class="app-header">
        <div class="brand-section">
            <h1 class="brand-logo">
                <i class="fa-solid fa-file-invoice text-primary me-1"></i>
                {!! $themeSettings['logo_text'] ?? 'দৈনিক ভোলা<span>টাইমস্</span>' !!}
                <small class="text-muted fs-6 fw-normal ms-2">| ই-পেপার বিল্ডার</small>
            </h1>
            <span id="saveStatusBadge" class="badge bg-success px-2.5 py-1.5 ms-2" style="font-family: 'Noto Sans Bengali', sans-serif;">
                <i class="fa-solid fa-cloud-check me-1"></i>সংরক্ষিত
            </span>
        </div>

        <!-- Middle: Masthead Slogan -->
        <div class="d-flex align-items-center gap-2">
            <span class="small text-muted fw-bold d-none d-lg-inline">স্লোগান:</span>
            <input type="text" id="epaperSlogan" class="form-control form-control-dark" style="width: 250px;" placeholder="মাস্টহেড স্লোগান">
        </div>

        <!-- Right Action Buttons -->
        <div class="global-settings">
            <!-- E-Paper Date -->
            <input type="date" id="epaperDate" class="form-control form-control-dark" style="width: 140px;" value="{{ $selectedDate->format('Y-m-d') }}" onchange="loadEPaperLayout()">

            <div class="btn-group">
                <button id="btnUndo" class="btn btn-sm btn-outline-secondary text-white border-secondary" onclick="undo()" disabled title="Undo (Ctrl+Z)"><i class="fa-solid fa-undo"></i></button>
                <button id="btnRedo" class="btn btn-sm btn-outline-secondary text-white border-secondary" onclick="redo()" disabled title="Redo (Ctrl+Y)"><i class="fa-solid fa-redo"></i></button>
            </div>
            
            <button id="btnPreview" class="btn btn-sm btn-outline-info text-info border-info" onclick="togglePreviewMode()" title="Preview Layout"><i class="fa-solid fa-eye"></i> প্রিভিউ</button>
            <button class="btn btn-sm btn-outline-warning text-warning border-warning" onclick="exportToImage()"><i class="fa-solid fa-download"></i> 300 DPI Export</button>
            <button class="btn btn-sm btn-primary" onclick="saveEPaperLayout()"><i class="fa-solid fa-save"></i> সংরক্ষণ</button>
            <button class="btn btn-sm btn-outline-danger" onclick="window.close()" title="Exit Builder"><i class="fa-solid fa-right-from-bracket"></i> প্রস্থান</button>
        </div>
    </header>

    <!-- Main Workspace Container -->
    <div class="app-workspace">
        
        <!-- Left Sidebar: WordPress news list -->
        <aside class="sidebar sidebar-left">
            <div class="sidebar-header">
                <h5><i class="fa-brands fa-wordpress text-primary"></i> WP News Feed</h5>
                <div class="d-flex gap-2 mt-3 mb-2">
                    <input type="date" id="wpDate" class="form-control form-control-dark" value="{{ date('Y-m-d') }}">
                    <button class="btn btn-sm btn-outline-secondary border-secondary text-white" onclick="fetchWPPosts()"><i class="fa-solid fa-sync-alt"></i></button>
                </div>
                <input type="text" id="wpSearch" class="form-control form-control-dark" placeholder="🔍 সংবাদ খুঁজুন..." onkeyup="filterWPPosts()">
                <button class="btn btn-sm btn-success w-100 mt-2" onclick="autoPlacePostsByTags()" style="font-weight: 700; border-radius: 6px; font-family: 'Noto Sans Bengali', sans-serif;"><i class="fa-solid fa-bolt me-1"></i> ট্যাগ অনুযায়ী অটো-ফিট</button>
            </div>
            
            <div class="sidebar-body custom-scroll" id="wpPostsList">
                <div class="text-center text-muted mt-4"><i class="fa-solid fa-spinner fa-spin"></i> লোড হচ্ছে...</div>
            </div>
        </aside>

        <!-- Center Viewport: Broadsheet Canvas -->
        <main class="canvas-workspace">
            <!-- Workspace Toolbar -->
            <div class="workspace-toolbar">
                <!-- Page Selector Tab Group -->
                <div class="page-tabs">
                    <div class="page-tab active" onclick="switchPage(1)">পৃষ্ঠা ১</div>
                    <div class="page-tab" onclick="switchPage(2)">পৃষ্ঠা ২</div>
                    <div class="page-tab" onclick="switchPage(3)">পৃষ্ঠা ৩ (বাকি অংশ)</div>
                    <div class="page-tab" onclick="switchPage(4)">পৃষ্ঠা ৪</div>
                </div>

                <!-- Zoom Control Slider -->
                <div class="zoom-controls">
                    <label>Zoom</label>
                    <input type="range" id="zoomSlider" min="30" max="150" value="55" oninput="updateZoom()">
                    <span id="zoomValue">55%</span>
                </div>
            </div>

            <!-- Scrollable Viewport Wrapper -->
            <div class="canvas-viewport" id="viewport">
                <div class="canvas-center">
                    <div class="broadsheet-canvas" id="canvas">

                        <!-- PAGE 1 (Masthead page) -->
                        <div class="page-layer active" id="page1">
                            <header class="front-masthead" style="height: 180px; display: flex; flex-direction: column; justify-content: space-between; border-bottom: 3px solid #111111; margin-bottom: 8px; padding: 10px 15px 0 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; flex-grow: 1;">
                                    <!-- Left: Dates -->
                                    <div style="width: 25%; font-size: 0.8rem; font-weight: bold; line-height: 1.6; border-right: 2px solid #111111; padding-right: 15px;">
                                        <div class="broadsheet-header-date">
                                            <div><i class="fa-solid fa-calendar-days" style="width: 15px;"></i> <span id="epaperEnDate">{{ $formattedEPaperHeaderDate }}</span></div>
                                            <div><i class="fa-solid fa-moon" style="width: 15px;"></i> <span id="epaperBnDate"></span></div>
                                            <div><i class="fa-solid fa-star-and-crescent" style="width: 15px;"></i> <span id="epaperHijriDate"></span></div>
                                        </div>
                                        <div><i class="fa-solid fa-book-open" style="width: 15px;"></i> বর্ষ: ১, সংখ্যা: ১২০</div>
                                    </div>
                                    <!-- Middle: Logo -->
                                    <div style="width: 50%; text-align: center;">
                                        @if(!empty($themeSettings['logo_image']))
                                            <img src="{{ asset($themeSettings['logo_image']) }}" alt="Logo" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                                        @else
                                            <h1 style="font-size: 4.5rem; font-weight: 900; margin: 0; letter-spacing: -2px; color: #111111;">{!! $themeSettings['logo_text'] ?? 'দৈনিক ভোলা<span style="color: #dc2626;">টাইমস্</span>' !!}</h1>
                                        @endif
                                    </div>
                                    <!-- Right: Balance spacer -->
                                    <div style="width: 25%;"></div>
                                </div>
                                <!-- Bottom Strip -->
                                <div style="background: #111111; color: #ffffff; padding: 6px 15px; display: flex; justify-content: space-between; font-size: 0.9rem; font-weight: bold; margin-top: 5px;">
                                    <span>রেজিঃ নং - ১২৩৪</span>
                                    <span>পৃষ্ঠা: ৪</span>
                                    <span>মূল্য: ৫ টাকা</span>
                                    <span><i class="fa-brands fa-facebook text-primary"></i> fb.com/bholatimes</span>
                                    <span><i class="fa-solid fa-globe text-info"></i> www.bholatimes24.com</span>
                                </div>
                            </header>
                            <div class="broadsheet-grid" id="grid1" style="padding: 0 10px 10px 10px;">
                                <!-- Row 1 -->
                                <div class="drop-slot" data-slot="1" style="grid-column: span 4; grid-row: span 2;"></div>
                                <div class="drop-slot" data-slot="2" style="grid-column: span 1; grid-row: span 2;"></div>
                                <div class="drop-slot" data-slot="3" style="grid-column: span 3; grid-row: span 2;"></div>
                                <!-- Row 2 -->
                                <div class="drop-slot" data-slot="4" style="grid-column: span 3; grid-row: span 2;"></div>
                                <div class="drop-slot" data-slot="5" style="grid-column: span 2; grid-row: span 2;"></div>
                                <div class="drop-slot" data-slot="6" style="grid-column: span 1; grid-row: span 2;"></div>
                                <div class="drop-slot" data-slot="7" style="grid-column: span 2; grid-row: span 2;"></div>
                                <!-- Row 3 -->
                                <div class="drop-slot" data-slot="8" style="grid-column: span 2; grid-row: span 2;"></div>
                                <div class="drop-slot" data-slot="9" style="grid-column: span 1; grid-row: span 2;"></div>
                                <div class="drop-slot" data-slot="10" style="grid-column: span 2; grid-row: span 2;"></div>
                                <div class="drop-slot" data-slot="11" style="grid-column: span 3; grid-row: span 2;"></div>
                            </div>
                        </div>

                        <!-- PAGE 2 (Main article page) -->
                        <div class="page-layer" id="page2" style="padding: 10px;">
                            <header style="background: linear-gradient(to right, #e6e6e6 0%, #111111 100%); display: flex; justify-content: space-between; align-items: center; padding: 5px 15px; margin-bottom: 10px; font-family: 'Noto Sans Bengali', sans-serif;">
                                <div style="display: flex; align-items: center; color: #111111;">
                                    <span style="font-size: 2.2rem; font-weight: bold; line-height: 1; margin-right: 15px;">২</span>
                                    @if(!empty($themeSettings['logo_image']))
                                        <img src="{{ asset($themeSettings['logo_image']) }}" alt="Logo" style="height: 35px; object-fit: contain;">
                                    @else
                                        <span style="font-size: 1.5rem; font-weight: bold; font-family: serif; line-height: 1;">দৈনিক ভোলা<span style="color:#ff0000;">টাইমস্</span></span>
                                    @endif
                                </div>
                                <div style="text-align: right; font-size: 0.85rem; line-height: 1.3; color: #ffffff;">
                                    <span class="epaperFullDate2" id="page2DateDisplayAdmin">{{ $formattedEPaperHeaderDate ?? $formattedDate }}</span>
                                </div>
                            </header>
                            <div class="broadsheet-grid" id="grid2" style="padding: 0 10px 10px 10px;">
                                <!-- Column 1: Top (Editorial) -->
                                <div class="category-box" style="grid-column: 1; grid-row: 1;">
                                    <div class="category-header">
                                        <i class="fa-solid fa-pen-nib"></i>
                                        <span>সম্পাদকীয়</span>
                                    </div>
                                    <div class="drop-slot" data-slot="1" style="flex: 1; border: none; background: transparent;"></div>
                                </div>
                                <!-- Column 2: Top (Economy) -->
                                <div class="category-box" style="grid-column: 2; grid-row: 1;">
                                    <div class="category-header">
                                        <i class="fa-solid fa-chart-line"></i>
                                        <span>অর্থনীতি</span>
                                    </div>
                                    <div class="drop-slot" data-slot="2" style="flex: 1; border: none; background: transparent;"></div>
                                </div>
                                <!-- Column 3: Top (Education) -->
                                <div class="category-box" style="grid-column: 3; grid-row: 1;">
                                    <div class="category-header">
                                        <i class="fa-solid fa-user-graduate"></i>
                                        <span>শিক্ষা</span>
                                    </div>
                                    <div class="drop-slot" data-slot="3" style="flex: 1; border: none; background: transparent;"></div>
                                </div>
                                <!-- Column 1: Bottom (Entertainment) -->
                                <div class="category-box" style="grid-column: 1; grid-row: 2;">
                                    <div class="category-header">
                                        <i class="fa-solid fa-masks-theater"></i>
                                        <span>বিনোদন</span>
                                    </div>
                                    <div class="drop-slot" data-slot="4" style="flex: 1; border: none; background: transparent;"></div>
                                </div>
                                <!-- Column 2: Bottom (International) -->
                                <div class="category-box" style="grid-column: 2; grid-row: 2;">
                                    <div class="category-header">
                                        <i class="fa-solid fa-globe"></i>
                                        <span>আন্তর্জাতিক</span>
                                    </div>
                                    <div class="drop-slot" data-slot="5" style="flex: 1; border: none; background: transparent;"></div>
                                </div>
                                <!-- Column 3: Bottom (Sports) -->
                                <div class="category-box" style="grid-column: 3; grid-row: 2;">
                                    <div class="category-header">
                                        <i class="fa-solid fa-trophy"></i>
                                        <span>খেলা</span>
                                    </div>
                                    <div class="drop-slot" data-slot="6" style="flex: 1; border: none; background: transparent;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- PAGE 3 (Jumps/Remaining part) -->
                        <div class="page-layer" id="page3" style="padding: 10px;">
                            <header style="background: linear-gradient(to right, #e6e6e6 0%, #111111 100%); display: flex; justify-content: space-between; align-items: center; padding: 5px 15px; margin-bottom: 10px; font-family: 'Noto Sans Bengali', sans-serif;">
                                <div style="display: flex; align-items: center; color: #111111;">
                                    <span style="font-size: 2.2rem; font-weight: bold; line-height: 1; margin-right: 15px;">৩</span>
                                    @if(!empty($themeSettings['logo_image']))
                                        <img src="{{ asset($themeSettings['logo_image']) }}" alt="Logo" style="height: 35px; object-fit: contain;">
                                    @else
                                        <span style="font-size: 1.5rem; font-weight: bold; font-family: serif; line-height: 1;">দৈনিক ভোলা<span style="color:#ff0000;">টাইমস্</span></span>
                                    @endif
                                </div>
                                <div style="text-align: right; font-size: 0.85rem; line-height: 1.3; color: #ffffff;">
                                    <span class="epaperFullDate2" id="page3DateDisplayAdmin">{{ $formattedEPaperHeaderDate ?? $formattedDate }}</span>
                                </div>
                            </header>
                            <div class="jump-grid" id="grid3"></div>
                        </div>

                        <!-- PAGE 4 (Back page — শেষ পাতা) -->
                        <div class="page-layer" id="page4" style="padding: 10px;">
                            <div class="broadsheet-grid" id="grid4" style="padding: 0 10px 10px 10px;">
                                <!-- Header (Takes 5 columns, Row 1) -->
                                <header style="grid-column: 1 / span 5; grid-row: 1; display: flex; flex-direction: column; font-family: 'Noto Sans Bengali', sans-serif;">
                                    <!-- Top part: Left Black Box + Logo -->
                                    <div style="display: flex; flex: 1; min-height: 80px;">
                                        <!-- Left Black Box -->
                                        <div style="background-color: #111111; color: #ffffff; padding: 15px; display: flex; align-items: center; justify-content: center; border-top-left-radius: 4px;">
                                            <span style="writing-mode: vertical-rl; transform: rotate(180deg); font-size: 1.8rem; font-weight: 800; letter-spacing: 2px;">শেষ পাতা</span>
                                        </div>
                                        <!-- Logo Area -->
                                        <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border: 2px solid #111111; border-left: none; border-bottom: none; border-top-right-radius: 4px;">
                                            @if(!empty($themeSettings['logo_image']))
                                                <img src="{{ asset($themeSettings['logo_image']) }}" alt="দৈনিক ভোলা টাইমস্" style="max-height: 55px; max-width: 100%; object-fit: contain;">
                                            @else
                                                <span style="font-size: 2.2rem; font-weight: 900; letter-spacing: -1px; color: #111111; line-height: 1;">দৈনিক ভোলা<span style="color: #dc2626;">টাইমস্</span></span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Bottom Black Box -->
                                    <div style="background-color: #111111; color: #ffffff; padding: 6px 15px; font-size: 0.95rem; display: flex; justify-content: space-between; align-items: center; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;">
                                        <span class="epaperFullDate2" id="page4DateDisplayAdmin">{{ $formattedEPaperHeaderDate ?? $formattedDate }}</span>
                                    </div>
                                </header>

                                <!-- Slot 3 (Takes 3 columns, starts from top Row 1 and spans to Row 3) -->
                                <div class="drop-slot" data-slot="3" style="grid-column: 6 / span 3; grid-row: 1 / span 3; border: 2px solid #111111; border-radius: 4px; background: #ffffff; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);"></div>

                                <!-- Grid Row 1 (Remaining slots) -->
                                <div class="drop-slot" data-slot="1" style="grid-column: 1 / span 4; grid-row: 2 / span 2;"></div>
                                <div class="drop-slot" data-slot="2" style="grid-column: 5 / span 1; grid-row: 2 / span 2;"></div>

                                <!-- Grid Row 2 -->
                                <div class="drop-slot" data-slot="4" style="grid-column: 1 / span 3; grid-row: 4 / span 2;"></div>
                                <div class="drop-slot" data-slot="5" style="grid-column: 4 / span 2; grid-row: 4 / span 2;"></div>
                                <div class="drop-slot" data-slot="6" style="grid-column: 6 / span 1; grid-row: 4 / span 2;"></div>
                                <div class="drop-slot" data-slot="7" style="grid-column: 7 / span 2; grid-row: 4 / span 2;"></div>
                                
                                <!-- Grid Row 3 -->
                                <div class="drop-slot" data-slot="8" style="grid-column: 1 / span 2; grid-row: 6 / span 2;"></div>
                                <div class="drop-slot" data-slot="9" style="grid-column: 3 / span 1; grid-row: 6 / span 2;"></div>
                                <div class="drop-slot" data-slot="10" style="grid-column: 4 / span 2; grid-row: 6 / span 2;"></div>
                                <div class="drop-slot" data-slot="11" style="grid-column: 6 / span 3; grid-row: 6 / span 2;"></div>
                            </div>

                            <!-- Footer Brand -->
                            <div style="border-top: 2px solid #111111; padding: 4px 0; display: flex; justify-content: space-between; font-size: 0.7rem; font-weight: bold; color: #333333; font-family: 'Noto Sans Bengali', sans-serif; margin-top: 5px;">
                                <span>বার্তা কক্ষ: ০১৭১১৪৬৯৫৩৯ | ইমেইল: news.bholatimes@gmail.com</span>
                                <span>দৈনিক ভোলা টাইমস্ | পৃষ্ঠা ৪</span>
                            </div>
                        </div>

                    </div><!-- #canvas -->
                </div><!-- .canvas-center -->
            </div><!-- .canvas-viewport -->
        </main>

        <!-- Right Sidebar: Formatting and content editor controls -->
        <aside class="sidebar sidebar-right">
            <div class="sidebar-header">
                <h5><i class="fa-solid fa-sliders text-primary"></i> এডিটর প্যানেল</h5>
            </div>
            
            <div class="sidebar-body custom-scroll">
                
                <!-- Empty State (Shown when no slot is selected) -->
                <div id="editorEmptyState" class="editor-empty-state">
                    <i class="fa-solid fa-i-cursor fa-3x mb-3 text-secondary" style="opacity: 0.4;"></i>
                    <p class="text-muted text-center px-4 small">এডিট করার জন্য ক্যানভাস থেকে যেকোনো স্লট সিলেক্ট করুন</p>
                </div>

                <!-- Editor Controls (Hidden by default, shown when active) -->
                <div id="editorContent" class="d-none d-flex flex-column h-100">
                    
                    <!-- Text Contents Section -->
                    <div class="editor-section">
                        <h6 class="section-title">পোস্টের তথ্য</h6>
                        <div class="form-group mb-2">
                            <label class="form-label">শিরোনাম</label>
                            <textarea id="editSlotTitle" class="form-control form-control-dark" rows="3" placeholder="শিরোনাম লিখুন..." oninput="handleTextareaInput()"></textarea>
                        </div>
                        <div class="form-group mb-1">
                            <label class="form-label">সংবাদ বিবরণ</label>
                            <textarea id="editSlotContent" class="form-control form-control-dark custom-scroll" rows="8" placeholder="মূল সংবাদ লিখুন..." oninput="handleTextareaInput()"></textarea>
                        </div>
                    </div>

                    <!-- Styling & Layout Formats -->
                    <div class="editor-section">
                        <h6 class="section-title">ডিজাইন ও ফরম্যাটিং</h6>
                        
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label">ফন্ট সাইজ (px)</label>
                                <input type="number" id="editFontSize" class="form-control form-control-dark" min="8" max="72" onchange="applyEdit()">
                            </div>
                            <div class="col-6">
                                <label class="form-label">কলাম সংখ্যা</label>
                                <select id="editColumns" class="form-select form-control-dark" onchange="applyEdit()">
                                    <option value="1">১ কলাম</option>
                                    <option value="2">২ কলাম</option>
                                    <option value="3">৩ কলাম</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label">হেডলাইন ওয়েট</label>
                                <select id="editFontWeight" class="form-select form-control-dark" onchange="applyEdit()">
                                    <option value="normal">Normal</option>
                                    <option value="600">Medium</option>
                                    <option value="bold">Bold</option>
                                    <option value="800">Extra Bold</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">হেডলাইন স্পেস</label>
                                <select id="editWordSpacing" class="form-select form-control-dark" onchange="applyEdit()">
                                    <option value="-2px">Tight</option>
                                    <option value="-1px">Semi-Tight</option>
                                    <option value="0px">Normal</option>
                                    <option value="2px">Semi-Wide</option>
                                    <option value="4px">Wide</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label">লাইন হাইট</label>
                                <select id="editLineHeight" class="form-select form-control-dark" onchange="applyEdit()">
                                    <option value="1.02">ডিফল্ট (1.02)</option>
                                    <option value="1.0">Tight (1.0)</option>
                                    <option value="1.15">Normal (1.15)</option>
                                    <option value="1.4">Relaxed (1.4)</option>
                                    <option value="1.6">Loose (1.6)</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">টেক্সট এলাইন</label>
                                <select id="editTextAlign" class="form-select form-control-dark" onchange="applyEdit()">
                                    <option value="left">Left</option>
                                    <option value="center">Center</option>
                                    <option value="right">Right</option>
                                    <option value="justify">Justify</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label">টাইটেল এলাইন</label>
                                <select id="editTitleAlign" class="form-select form-control-dark" onchange="applyEdit()">
                                    <option value="left">Left</option>
                                    <option value="center">Center</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">ছবি প্রদর্শন</label>
                                <select id="editShowImage" class="form-select form-control-dark" onchange="applyEdit()">
                                    <option value="none">ছবি ছাড়া (No Image)</option>
                                    <option value="half">অর্ধেক সাইজ (Half Image)</option>
                                    <option value="full">পূর্ণ সাইজ (Full Image)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="editor-section mt-auto pt-3 border-top border-secondary-subtle">
                        <div class="d-flex gap-2">
                            <button class="btn btn-danger w-50" onclick="removeSelectedSlot()"><i class="fa-solid fa-trash me-1"></i> ডিলিট</button>
                            <button class="btn btn-outline-light w-50" onclick="closeEditor()"><i class="fa-solid fa-xmark me-1"></i> বন্ধ করুন</button>
                        </div>
                    </div>

                </div>
            </div>
        </aside>

    </div><!-- .app-workspace -->

    <!-- html2canvas exporter library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- Main Logic Script -->
    <script>
        let wpPosts = [];
        const selectedDateVal = new Date('{{ $selectedDate->format('Y-m-d') }}');

        // Hijri Date Calculation
        const hijriOptions = { day: 'numeric', month: 'long', year: 'numeric' };
        let hijriStr = '';
        try {
            hijriStr = new Intl.DateTimeFormat('bn-BD-u-ca-islamic-umalqura', hijriOptions).format(selectedDateVal) + ' হিজরি';
        } catch(e) {
            try {
                hijriStr = new Intl.DateTimeFormat('bn-BD-u-ca-islamic', hijriOptions).format(selectedDateVal) + ' হিজরি';
            } catch(e2) {
                hijriStr = '';
            }
        }
        const hijriSpan = document.getElementById('epaperHijriDate');
        if(hijriSpan && hijriStr) hijriSpan.textContent = hijriStr;

        // Bangla Date Calculation
        function getBanglaDate(date) {
            const banglaMonths = ['বৈশাখ', 'জ্যৈষ্ঠ', 'আষাঢ়', 'শ্রাবণ', 'ভাদ্র', 'আশ্বিন', 'কার্তিক', 'অগ্রহায়ণ', 'পৌষ', 'মাঘ', 'ফাল্গুন', 'চৈত্র'];
            function toBanglaNumber(num) {
                const engToBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
                return num.toString().replace(/[0-9]/g, w => engToBn[w]);
            }
            const isLeapYear = (year) => ((year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0));
            let year = date.getFullYear();
            let month = date.getMonth();
            let day = date.getDate();
            const startOfYear = new Date(year, 0, 0);
            const diff = (date - startOfYear) + ((startOfYear.getTimezoneOffset() - date.getTimezoneOffset()) * 60 * 1000);
            const oneDay = 1000 * 60 * 60 * 24;
            let dayOfYear = Math.floor(diff / oneDay);
            let bnYear, bnMonth, bnDay;
            if (month > 3 || (month === 3 && day >= 14)) {
                bnYear = year - 593;
                const boishakhStart = 31 + (isLeapYear(year) ? 29 : 28) + 31 + 13;
                dayOfYear -= boishakhStart;
            } else {
                bnYear = year - 594;
                const prevLeapYear = ((year - 1) % 4 === 0 && (year - 1) % 100 !== 0) || ((year - 1) % 400 === 0);
                const prevYearDays = 365 + (prevLeapYear ? 1 : 0);
                const lastBoishakhDayOfYear = 31 + (prevLeapYear ? 29 : 28) + 31 + 14;
                dayOfYear = dayOfYear + prevYearDays - lastBoishakhDayOfYear;
            }
            const monthDays = [31, 31, 31, 31, 31, 30, 30, 30, 30, 30, isLeapYear(year) ? 31 : 30, 30];
            let accum = 0;
            for (let i = 0; i < 12; i++) {
                if (dayOfYear < accum + monthDays[i]) {
                    bnDay = dayOfYear - accum + 1;
                    bnMonth = i;
                    break;
                }
                accum += monthDays[i];
            }
            return `${toBanglaNumber(bnDay)} ${banglaMonths[bnMonth]} ${toBanglaNumber(bnYear)} বঙ্গাব্দ`;
        }
        const bnSpan = document.getElementById('epaperBnDate');
        if (bnSpan) bnSpan.textContent = getBanglaDate(selectedDateVal);

        let pagesData = { '1': [], '2': [], '3': [], '4': [] };
        let activePage = 1;
        let selectedSlot = null;
        let scale = 0.55;

        // Undo/Redo Stacks
        let undoStack = [];
        let redoStack = [];
        const MAX_HISTORY = 20;
        let isDirty = false;
        let typingTimer = null;

        document.addEventListener('DOMContentLoaded', () => {
            setupDragEvents();
            setupZoom();
            applyZoom();
            fetchWPPosts();
            loadEPaperLayout();
            setupKeyboardShortcuts();
        });

        // ─── Zoom via CSS zoom (works with native scroll!) ───
         ZorCount = 0;
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
                                
                                const postTitle = (post.title && typeof post.title === 'object') ? post.title.rendered : (post.title || '');
                                const postContent = (post.content && typeof post.content === 'object') ? post.content.rendered : (post.content || '');
                                const postExcerpt = (post.excerpt && typeof post.excerpt === 'object') ? post.excerpt.rendered : (post.excerpt || '');
                                const postData = {
                                    id: post.id,
                                    title: postTitle,
                                    content: postContent,
                                    excerpt: postExcerpt,
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
            document.getElementById('wpPostsList').innerHTML = '<div class="text-center mt-4 text-muted"><i class="fa-solid fa-spinner fa-spin"></i> WP পোস্ট লোড হচ্ছে...</div>';

            fetch(`{{ route('admin.epaper.wp_posts') }}?date=${dateStr}`)
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        wpPosts = data.posts;
                        renderWPList();
                    } else {
                        document.getElementById('wpPostsList').innerHTML = `<div class="text-danger text-center p-3 small">${data.message || 'পোস্ট লোড করা যায়নি।'}</div>`;
                    }
                })
                .catch(err => {
                    console.error("WP Fetch Error:", err);
                    document.getElementById('wpPostsList').innerHTML = '<div class="text-danger text-center p-3 small">পোস্ট লোড করতে সমস্যা হয়েছে।</div>';
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
                    const postTitle = (post.title && typeof post.title === 'object') ? post.title.rendered : (post.title || '');
                    const postContent = (post.content && typeof post.content === 'object') ? post.content.rendered : (post.content || '');
                    const postExcerpt = (post.excerpt && typeof post.excerpt === 'object') ? post.excerpt.rendered : (post.excerpt || '');
                    e.dataTransfer.setData('text/plain', JSON.stringify({
                        id: post.id,
                        title: postTitle,
                        content: postContent,
                        excerpt: postExcerpt,
                        image: img
                    }));
                };

                el.innerHTML = `
                    ${img ? `<img src="${img}" class="news-item-img">` : '<div class="news-item-img d-flex align-items-center justify-content-center text-secondary" style="font-size:0.6rem; border:1px solid var(--border-color);">No Img</div>'}
                    <div class="news-item-details">
                        <div class="news-item-title">${post.title.rendered}</div>
                        <div class="news-item-meta">${isPlaced ? '<span class="text-success"><i class="fa-solid fa-circle-check"></i> Placed</span>' : new Date(post.date).toLocaleDateString()}</div>
                    </div>
                `;
                list.appendChild(el);
            });

            if (list.innerHTML === '') {
                list.innerHTML = '<div class="text-center mt-4 text-muted small">কোনো সংবাদ পাওয়া যায়নি।</div>';
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
            if (page === 1 || page === 4) {
                const spans = { 1: 3, 2: 1, 3: 2, 4: 2, 5: 2, 6: 1, 7: 2, 8: 2, 9: 1, 10: 2, 11: 2 };
                defaultColumns = spans[slotId] || 2;
                
                if (slotId === 1) defaultFontSize = 32;
                else if (slotId === 2) defaultFontSize = 13;
                else if (slotId === 3) defaultFontSize = 28;
                else defaultFontSize = 16;
            }
            const style = { 
                font_size: defaultFontSize, 
                columns: defaultColumns, 
                char_limit: (page === 2 ? 5000 : 1500),
                line_height: '1.02',
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
            
            // Auto select the newly placed content slot
            const slotEl = document.querySelector(`#grid${page} .drop-slot[data-slot="${slotId}"]`);
            selectSlot(page, slotId, slotEl);
        }

        function renderCanvas() {
            // Reset grids
            [1, 2, 4].forEach(page => {
                document.querySelectorAll(`#grid${page} .drop-slot`).forEach(slot => {
                    const slotId = parseInt(slot.getAttribute('data-slot'));
                    if (page === 1 && slotId === 4) {
                        slot.innerHTML = `
                            <div class="slot-label">Slot 4 (বিজ্ঞাপন)</div>
                            <div class="slot-empty" style="padding: 10px; background: #f8fafc; color: #64748b; border: 1px dashed #cbd5e1; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; pointer-events: none;">
                                <span style="font-size: 0.65rem; font-weight: bold; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px;">বিজ্ঞাপন / Advertisement</span>
                                <div style="flex: 1; width: 100%; background: #ffffff; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold; color: #64748b; line-height: 1.4; border-radius: 4px; box-sizing: border-box; padding: 5px;">
                                    বিজ্ঞাপন দিতে যোগাযোগ করুন<br>০১৭XXXXXXXX
                                </div>
                            </div>
                        `;
                    } else {
                        slot.innerHTML = `<div class="slot-label">Slot ${slotId}</div><div class="slot-empty"><i class="fa-solid fa-plus fa-2x"></i><span>Drop Post Here</span></div>`;
                    }
                    slot.classList.remove('occupied');
                });
            });

            let existingJumps = pagesData['3'] || [];
            let jumpItems = [];

            [1, 2, 4].forEach(page => {
                pagesData[page].forEach(slotData => {
                    const slotEl = document.querySelector(`#grid${page} .drop-slot[data-slot="${slotData.slot_id}"]`);
                    if (!slotEl) return;

                    slotEl.classList.add('occupied');

                    let showJump = false;

                    // Determine how to display photo: none, half, or full
                    let showPhoto = 'none';
                    if (slotData.image) {
                        const styleVal = slotData.style.show_image;
                        if (styleVal === false || styleVal === 'none') {
                            showPhoto = 'none';
                        } else if (styleVal === true || styleVal === 'full' || styleVal === undefined) {
                            showPhoto = 'full';
                        } else if (styleVal === 'half') {
                            showPhoto = 'half';
                        } else {
                            // Fallback to column span logic
                            const gridColumnStyle = slotEl.style.gridColumn || '';
                            const spanCol = gridColumnStyle.includes('span') ? parseInt(gridColumnStyle.split('span')[1].trim()) : 8;
                            showPhoto = spanCol > 4 ? 'full' : 'none';
                        }
                    }

                    const proxyImgUrl = slotData.image ? `/admin/epaper/proxy-image?url=${encodeURIComponent(slotData.image)}` : '';

                    // Render full text first
                    slotEl.innerHTML = `
                        <div class="rendered-content" style="flex: 1; display: flex; flex-direction: column; overflow: hidden; box-sizing: border-box;">
                            <div class="rendered-title" style="font-size: ${slotData.style.font_size}px; text-align: ${slotData.style.title_align || 'center'}; color: ${slotData.style.title_color || '#111111'}; font-weight: ${slotData.style.font_weight || 'bold'}; word-spacing: ${slotData.style.word_spacing || '0px'};">${slotData.title}</div>
                            ${showPhoto === 'full' ? `<div class="rendered-image-wrapper full" style="flex-shrink:0;"><img src="${proxyImgUrl}" crossorigin="anonymous"></div>` : ''}
                            <div class="rendered-excerpt" style="column-count: ${slotData.style.columns}; column-gap: 8px; line-height: ${slotData.style.line_height || '1.02'}; text-align: ${slotData.style.text_align || 'justify'}; margin-top: auto; overflow: hidden;">
                                ${showPhoto === 'half' ? `<div class="rendered-image-wrapper half" style="flex-shrink:0;"><img src="${proxyImgUrl}" crossorigin="anonymous"></div>` : ''}
                                ${slotData.content}
                            </div>
                        </div>
                    `;

                    // Run auto-split for Page 1 and Page 4
                    if (page === 1 || page === 4) {
                        const contentEl = slotEl.querySelector('.rendered-content');
                        const excerptEl = slotEl.querySelector('.rendered-excerpt');
                        if (contentEl.scrollHeight > contentEl.clientHeight + 2 || excerptEl.scrollWidth > excerptEl.clientWidth + 2) {
                            let cleanText = slotData.content;
                            let low = 0;
                            let high = cleanText.length;
                            let bestSplit = 0;
                            const jumpTagHTML = ' <span class="jump-tag">৩য় পাতায় দেখুন</span>';
                            const imgHTML = showPhoto === 'half' ? `<div class="rendered-image-wrapper half" style="flex-shrink:0;"><img src="${proxyImgUrl}" crossorigin="anonymous"></div>` : '';
                            
                            while (low <= high) {
                                let mid = Math.floor((low + high) / 2);
                                let testText = cleanText.substring(0, mid);
                                excerptEl.innerHTML = imgHTML + testText + jumpTagHTML;
                                
                                if (contentEl.scrollHeight <= contentEl.clientHeight + 2 && excerptEl.scrollWidth <= excerptEl.clientWidth + 2) {
                                    bestSplit = mid;
                                    low = mid + 1;
                                } else {
                                    high = mid - 1;
                                }
                            }
                            
                            let finalPageText = cleanText.substring(0, bestSplit);
                            let jumpText = cleanText.substring(bestSplit);
                            
                            excerptEl.innerHTML = imgHTML + finalPageText + jumpTagHTML;
                            
                            let existing = existingJumps.find(j => j.slot_id === slotData.slot_id && j.from_page === page);
                            if (existing && existing.is_edited) {
                                jumpItems.push(existing);
                            } else {
                                jumpItems.push({ from_page: page, slot_id: slotData.slot_id, title: slotData.title, content: jumpText, is_edited: false });
                            }
                        }
                    }
                });
            });

            // Render Page 3
            const grid3 = document.getElementById('grid3');
            if (grid3) {
                grid3.innerHTML = '';
                pagesData['3'] = jumpItems;
                jumpItems.forEach((jump, index) => {
                    grid3.innerHTML += `
                        <div class="jump-slot" style="position: relative;">
                            ${jump.is_edited ? `<button onclick="resetJumpItem(${index})" class="btn btn-sm btn-outline-danger" style="position: absolute; right: 2px; top: 2px; padding: 0 4px; font-size: 10px; z-index: 10;" title="অরিজিনাল অটো-স্প্লিট এ ফিরে যান"><i class="fa-solid fa-rotate-left"></i></button>` : ''}
                            <div style="font-weight:bold; font-size: 0.95rem; margin-bottom:2px; line-height: 1.4; height: 1.4em; overflow: hidden; text-align: center; padding: 0 20px;">
                                ${jump.title}
                            </div>
                            <div class="rendered-excerpt" 
                                 contenteditable="true" 
                                 oninput="updateJumpContent(${index}, this.innerHTML)" 
                                 style="column-count: auto; overflow: visible; display: block; break-inside: auto; text-align: justify; outline: 1px dashed #ccc; padding: 2px; min-height: 20px; z-index: 1; position: relative;"
                                 onfocus="this.style.outline='2px solid #dc3545'"
                                 onblur="this.style.outline='1px dashed #ccc'">
                                ${jump.content}
                            </div>
                        </div>
                    `;
                });
            }

            // Sync visual active selection outline if a slot is selected
            if (selectedSlot) {
                const activeEl = document.querySelector(`#grid${selectedSlot.page} .drop-slot[data-slot="${selectedSlot.slotId}"]`);
                if (activeEl) activeEl.classList.add('selected');
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

            // Fill text inputs
            document.getElementById('editSlotTitle').value = slotData.title;
            document.getElementById('editSlotContent').value = slotData.content;

            // Fill style controls
            document.getElementById('editFontSize').value = slotData.style.font_size;
            document.getElementById('editColumns').value = slotData.style.columns;
            document.getElementById('editFontWeight').value = slotData.style.font_weight || 'bold';
            document.getElementById('editWordSpacing').value = slotData.style.word_spacing || '0px';
            document.getElementById('editLineHeight').value = slotData.style.line_height || '1.02';
            let showImageVal = 'full';
            if (slotData.style.show_image === false || slotData.style.show_image === 'none') {
                showImageVal = 'none';
            } else if (slotData.style.show_image === 'half') {
                showImageVal = 'half';
            }
            document.getElementById('editShowImage').value = showImageVal;
            document.getElementById('editTextAlign').value = slotData.style.text_align || 'justify';
            document.getElementById('editTitleAlign').value = slotData.style.title_align || 'center';

            // Show panel
            document.getElementById('editorEmptyState').classList.add('d-none');
            document.getElementById('editorContent').classList.remove('d-none');
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
                slotData.style.show_image = document.getElementById('editShowImage').value;
                slotData.style.text_align = document.getElementById('editTextAlign').value;
                slotData.style.title_align = document.getElementById('editTitleAlign').value;
                
                renderCanvas();
                updateUndoRedoButtons();
            }
        }

        // Live syncing of text areas with the canvas
        function handleTextareaInput() {
            if (!selectedSlot) return;
            const slotData = pagesData[selectedSlot.page].find(s => s.slot_id === selectedSlot.slotId);
            if (slotData) {
                // Debounce saving layout state to history stack to avoid cluttering on every keystroke
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    saveHistoryState();
                }, 1200);

                slotData.title = document.getElementById('editSlotTitle').value;
                slotData.content = document.getElementById('editSlotContent').value;
                
                renderCanvas();
                updateUndoRedoButtons();
            }
        }

        function removeSelectedSlot() {
            if (!selectedSlot) return;
            saveHistoryState();
            pagesData[selectedSlot.page] = pagesData[selectedSlot.page].filter(s => s.slot_id !== selectedSlot.slotId);
            closeEditor();
            renderCanvas();
            renderWPList();
            updateUndoRedoButtons();
        }

        function closeEditor() {
            selectedSlot = null;
            document.querySelectorAll('.drop-slot').forEach(s => s.classList.remove('selected'));
            document.getElementById('editorEmptyState').classList.remove('d-none');
            document.getElementById('editorContent').classList.add('d-none');
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
                                    if (!slotData.content && slotData.excerpt) {
                                        slotData.content = slotData.excerpt;
                                    }
                                    if (!slotData.style) slotData.style = {};
                                    if (slotData.style.line_height === undefined) slotData.style.line_height = '1.02';
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
                        if (data.formatted_epaper_header_date) {
                            const mainDate = document.getElementById('epaperEnDate');
                            if(mainDate) mainDate.textContent = data.formatted_epaper_header_date;
                            
                            // Generate full date for inner headers
                            try {
                                document.querySelectorAll('.epaperFullDate2').forEach(function(el) {
                                    el.textContent = data.formatted_epaper_header_date;
                                });
                            } catch(e) {
                                console.error('Date parsing error', e);
                            }
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
            
            // Sync selected slot fields if open
            if (selectedSlot) {
                const activeData = pagesData[selectedSlot.page].find(s => s.slot_id === selectedSlot.slotId);
                if (activeData) {
                    selectSlot(selectedSlot.page, selectedSlot.slotId, document.querySelector(`#grid${selectedSlot.page} .drop-slot[data-slot="${selectedSlot.slotId}"]`));
                } else {
                    closeEditor();
                }
            }
            
            updateUndoRedoButtons();
            showToast('Undo successful', 'info');
        }

        function redo() {
            if (redoStack.length === 0) return;
            const currentState = JSON.parse(JSON.stringify(pagesData));
            undoStack.push(currentState);
            pagesData = redoStack.pop();
            renderCanvas();
            renderWPList();
            
            // Sync selected slot fields if open
            if (selectedSlot) {
                const activeData = pagesData[selectedSlot.page].find(s => s.slot_id === selectedSlot.slotId);
                if (activeData) {
                    selectSlot(selectedSlot.page, selectedSlot.slotId, document.querySelector(`#grid${selectedSlot.page} .drop-slot[data-slot="${selectedSlot.slotId}"]`));
                } else {
                    closeEditor();
                }
            }

            updateUndoRedoButtons();
            showToast('Redo successful', 'info');
        }

        // Update in-editor text changes back to pagesData if modified directly on canvas
        function updateSlotTitle(page, slotId, el) {
            const slotData = pagesData[page].find(s => s.slot_id === slotId);
            if (slotData && slotData.title !== el.innerText) {
                saveHistoryState();
                slotData.title = el.innerText;
                
                // If it is the currently selected slot, update the sidebar input too
                if (selectedSlot && selectedSlot.page === page && selectedSlot.slotId === slotId) {
                    document.getElementById('editSlotTitle').value = el.innerText;
                }
                
                renderCanvas();
                renderWPList();
                updateUndoRedoButtons();
            }
        }

        function updateSlotContent(page, slotId, el) {
            const slotData = pagesData[page].find(s => s.slot_id === slotId);
            if (slotData && slotData.content !== el.innerText) {
                saveHistoryState();
                slotData.content = el.innerText;
                
                // If it is the currently selected slot, update the sidebar input too
                if (selectedSlot && selectedSlot.page === page && selectedSlot.slotId === slotId) {
                    document.getElementById('editSlotContent').value = el.innerText;
                }
                
                renderCanvas();
                renderWPList();
                updateUndoRedoButtons();
            }
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
        function updateJumpContent(index, newHtml) {
            if (pagesData['3'] && pagesData['3'][index]) {
                pagesData['3'][index].content = newHtml;
                pagesData['3'][index].is_edited = true;
                
                // Show reset button visually without re-rendering everything
                const slot = document.querySelectorAll('#grid3 .jump-slot')[index];
                if (slot && !slot.querySelector('button')) {
                    slot.insertAdjacentHTML('afterbegin', `<button onclick="resetJumpItem(${index})" class="btn btn-sm btn-outline-danger" style="position: absolute; right: 2px; top: 2px; padding: 0 4px; font-size: 10px; z-index: 10;" title="অরিজিনাল অটো-স্প্লিট এ ফিরে যান"><i class="fa-solid fa-rotate-left"></i></button>`);
                }
                
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    saveHistoryState();
                }, 1000);
            }
        }
        
        function resetJumpItem(index) {
            if (pagesData['3'] && pagesData['3'][index]) {
                pagesData['3'][index].is_edited = false;
                saveHistoryState();
                renderCanvas();
            }
        }
    </script>
</body>
</html>
