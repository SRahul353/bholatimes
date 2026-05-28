@extends('layouts.admin')

@section('title', 'ই-পেপার লেআউট বিল্ডার | অ্যাডমিন প্যানেল')
@section('header_title', 'ই-পেপার লেআউট বিল্ডার')

@section('styles')
<style>
    /* Premium Drag & Drop Layout Styles */
    .builder-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        align-items: start;
        margin-top: 16px;
    }

    @media (min-width: 1200px) {
        .builder-container {
            grid-template-columns: 360px 1fr;
        }
    }

    /* Left Sidebar: Available News Drawer */
    .news-drawer {
        background-color: var(--sidebar-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 20px;
        position: sticky;
        top: 90px;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
        box-shadow: var(--shadow);
    }

    .drawer-tabs {
        display: flex;
        border-bottom: 2px solid var(--border-color);
        margin-bottom: 16px;
        gap: 8px;
    }

    .drawer-tab {
        flex: 1;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        border-bottom: none;
        color: var(--text-sub);
        padding: 8px 12px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        transition: var(--transition);
        text-align: center;
    }

    .drawer-tab.active {
        background-color: var(--accent);
        border-color: var(--accent);
        color: #ffffff;
    }

    .news-card-item {
        background-color: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: 10px;
        margin-bottom: 12px;
        cursor: grab;
        display: flex;
        gap: 12px;
        transition: var(--transition);
        user-select: none;
    }

    .news-card-item:hover {
        border-color: var(--accent);
        background-color: rgba(255, 255, 255, 0.06);
        transform: translateY(-2px);
    }

    .news-card-item:active {
        cursor: grabbing;
    }

    .news-item-img {
        width: 60px;
        height: 45px;
        border-radius: 4px;
        object-fit: cover;
        flex-shrink: 0;
        background-color: #1e293b;
    }

    .news-item-details {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-width: 0;
        flex-grow: 1;
    }

    .news-item-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 4px 0;
        line-height: 1.35;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .news-item-meta {
        font-size: 0.75rem;
        color: var(--text-sub);
        display: flex;
        justify-content: space-between;
    }

    /* Right Canvas: Broadsheet Mockup Board */
    .broadsheet-canvas {
        background-color: #f6f3eb; /* Authentic newsprint cream */
        border: 10px solid #111111;
        border-radius: 4px;
        padding: 20px;
        color: #111111;
        box-shadow: var(--shadow);
        box-sizing: border-box;
    }

    /* Mini Broad Sheet Header Banner */
    .mini-masthead {
        border-bottom: 4px double #111111;
        padding-bottom: 8px;
        margin-bottom: 16px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .mini-logo {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 2.2rem;
        font-weight: 900;
        margin-bottom: 4px;
        letter-spacing: -1px;
    }
    .mini-logo span {
        color: #dc2626;
    }

    .mini-meta-strip {
        border-top: 1px solid #111111;
        border-bottom: 1px solid #111111;
        padding: 4px 12px;
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        font-weight: 700;
        width: 100%;
    }

    /* Mini Broadsheet Slots Grid */
    .broadsheet-grid {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 12px;
    }

    /* Broadsheet drop zone slots */
    .drop-slot {
        border: 2px dashed rgba(17, 17, 17, 0.25);
        background-color: rgba(17, 17, 17, 0.02);
        border-radius: 6px;
        position: relative;
        min-height: 100px;
        padding: 10px;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        overflow: hidden;
    }

    .drop-slot.dragover {
        border-color: #dc2626;
        background-color: rgba(220, 38, 38, 0.08);
        box-shadow: inset 0 0 10px rgba(220, 38, 38, 0.1);
    }

    .drop-slot.occupied {
        border: 1px solid #111111;
        background-color: transparent;
    }

    .slot-label {
        font-size: 0.68rem;
        font-weight: 800;
        background-color: #111111;
        color: #ffffff;
        padding: 2px 6px;
        border-radius: 30px;
        position: absolute;
        top: 6px;
        left: 6px;
        z-index: 10;
        pointer-events: none;
    }

    .slot-clear-btn {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background-color: #dc2626;
        color: #ffffff;
        border: none;
        display: none;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 12;
        font-size: 0.65rem;
    }

    .drop-slot.occupied:hover .slot-clear-btn {
        display: flex;
    }

    /* Slot empty state */
    .slot-empty {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        flex-grow: 1;
        color: rgba(17, 17, 17, 0.4);
        text-align: center;
        font-size: 0.72rem;
        padding-top: 18px;
        pointer-events: none;
    }
    .slot-empty i {
        font-size: 1.3rem;
        margin-bottom: 4px;
    }

    /* Slot occupied state styling */
    .slot-post-view {
        display: flex;
        flex-direction: column;
        height: 100%;
        width: 100%;
        padding-top: 18px;
        pointer-events: none; /* Let dragover hit the slot, not children */
    }

    .slot-post-title {
        font-size: 0.82rem;
        font-weight: 850;
        line-height: 1.3;
        color: #111111;
        text-align: center;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .slot-post-img-box {
        width: 100%;
        flex-grow: 1;
        height: 70px;
        overflow: hidden;
        border: 1px solid #111111;
        background-color: #cbd5e1;
    }

    .slot-post-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(100%) contrast(120%);
    }

    /* Column rule borders for slot sizes */
    .g-span-8 { grid-column: span 8; }
    .g-span-4 { grid-column: span 4; }
    .g-span-3 { grid-column: span 3; }
    .g-span-2 { grid-column: span 2; }
    .g-span-1 { grid-column: span 1; }

    .border-r {
        border-right: 1px solid rgba(17, 17, 17, 0.15) !important;
    }

    /* Special slot sizes heights */
    .slot-lead { min-height: 280px; }
    .slot-lead .slot-post-img-box { height: 160px; }
    .slot-lead .slot-post-title { font-size: 1.15rem; font-weight: 900; }

    .slot-medium { min-height: 180px; }
    .slot-medium .slot-post-img-box { height: 90px; }

    .slot-thin { min-height: 110px; }
    .slot-thin .slot-post-img-box { display: none; } /* hide images in single column slots to look compact */
</style>
@endsection

@section('content')
<!-- Control Ribbon Bar Card -->
<div class="admin-card">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <!-- Date Selector Input -->
        <div class="d-flex align-items-center gap-2">
            <label class="form-label mb-0 text-white" for="epaperDate" style="white-space: nowrap;"><i class="fa-solid fa-calendar-days text-danger me-1"></i>সংস্করণ তারিখ নির্বাচন:</label>
            <input type="date" id="epaperDate" class="form-control" style="width: 160px; padding: 6px 12px; background-color: rgba(9, 13, 22, 0.75);" value="{{ date('Y-m-d') }}" onchange="loadEPaperLayout()">
            <button class="btn btn-secondary btn-sm" onclick="loadEPaperLayout()" title="রিফ্রেশ"><i class="fa-solid fa-rotate"></i></button>
        </div>

        <!-- Custom Page Title / Slogan -->
        <div class="d-flex align-items-center gap-2">
            <label class="form-label mb-0 text-white" for="epaperSlogan" style="white-space: nowrap;"><i class="fa-solid fa-heading text-danger me-1"></i>মাস্টহেড স্লোগান:</label>
            <input type="text" id="epaperSlogan" class="form-control" style="width: 160px; padding: 6px 12px; background-color: rgba(9, 13, 22, 0.75);" value="প্রথম পাতা" placeholder="প্রথম পাতা">
        </div>

        <!-- Save Button -->
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="saveEPaperLayout()">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>ই-পেপার লেআউট সেভ করুন</span>
            </button>
            <a href="{{ route('epaper') }}" target="_blank" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>লাইভ দেখুন</span>
            </a>
        </div>
    </div>
</div>

<!-- Builder Workspace layout -->
<div class="builder-container">
    <!-- Left Pane: Available news lists -->
    <aside class="news-drawer">
        <h4 class="text-white mb-3" style="font-size: 0.95rem; font-weight: 700;"><i class="fa-solid fa-newspaper text-danger me-2"></i>সংবাদ কন্টেন্ট ড্রয়ার</h4>
        
        <!-- Tabs -->
        <div class="drawer-tabs">
            <div class="drawer-tab active" id="tabDate" onclick="switchDrawerTab('date')">আজকের সংবাদ</div>
            <div class="drawer-tab" id="tabRecent" onclick="switchDrawerTab('recent')">সাম্প্রতিক খবর (৩০)</div>
        </div>

        <!-- Local Search filter -->
        <div class="form-group mb-3">
            <input type="text" id="drawerSearch" class="form-control" style="font-size: 0.82rem; padding: 6px 12px;" placeholder="খবর খুঁজুন (টাইপ করুন)..." oninput="filterDrawerNews()">
        </div>

        <!-- News list container -->
        <div id="drawerNewsList" style="min-height: 200px;">
            <!-- Rendered dynamically by JS -->
        </div>
    </aside>

    <!-- Right Pane: Broadsheet Drop Canvas Layout Mockup -->
    <main class="broadsheet-canvas" id="broadsheetBoard">
        <!-- Mini Masthead Header -->
        <header class="mini-masthead">
            <h1 class="mini-logo">দৈনিক ভোলা<span>টাইমস্</span></h1>
            <div class="mini-meta-strip">
                <span>সংস্করণ: ১ম সংস্করণ</span>
                <span id="miniDateText">২৮ মে, ২০২৬</span>
                <span>Broad Sheet Layout</span>
            </div>
        </header>

        <!-- Broadsheet Interactive Grid (16 slots matching public frontpage design layout) -->
        <div class="broadsheet-grid">
            
            <!-- SECTION 1: 3 Slots (Lead, Story 2, Story 3) -->
            <!-- 1. Lead News (spans 4 col, 4 rows) -->
            <div class="drop-slot g-span-4 slot-lead border-r" data-slot="0" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">১. প্রধান খবর (Lead Story)</div>
                <button class="slot-clear-btn" onclick="clearSlot(0)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-image"></i>কার্ড টেনে এনে এখানে ফেলুন</div>
            </div>

            <!-- 2. Story 2 (spans 1 col, 4 rows) -->
            <div class="drop-slot g-span-1 slot-thin border-r" data-slot="1" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">২. সাইড লিড ১</div>
                <button class="slot-clear-btn" onclick="clearSlot(1)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-lines"></i>ড্রপ করুন</div>
            </div>

            <!-- 3. Story 3 (spans 3 col, 4 rows) -->
            <div class="drop-slot g-span-3 slot-medium" data-slot="2" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">৩. সাইড লিড ২</div>
                <button class="slot-clear-btn" onclick="clearSlot(2)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-image"></i>ড্রপ করুন</div>
            </div>


            <!-- SECTION 2: 4 Slots (Story 4, 5, 6, 7) -->
            <!-- 4. Story 4 (spans 3 col, 3 rows) -->
            <div class="drop-slot g-span-3 slot-medium border-r" data-slot="3" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">৪. কলাম সংবাদ ৩</div>
                <button class="slot-clear-btn" onclick="clearSlot(3)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-image"></i>ড্রপ করুন</div>
            </div>

            <!-- 5. Story 5 (spans 2 col, 3 rows) -->
            <div class="drop-slot g-span-2 slot-medium border-r" data-slot="4" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">৫. কলাম সংবাদ ২</div>
                <button class="slot-clear-btn" onclick="clearSlot(4)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-image"></i>ড্রপ করুন</div>
            </div>

            <!-- 6. Story 6 (spans 1 col, 3 rows) -->
            <div class="drop-slot g-span-1 slot-thin border-r" data-slot="5" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">৬. কলাম ১</div>
                <button class="slot-clear-btn" onclick="clearSlot(5)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-lines"></i>ড্রপ</div>
            </div>

            <!-- 7. Story 7 (spans 2 col, 3 rows) -->
            <div class="drop-slot g-span-2 slot-medium" data-slot="6" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">৭. কলাম সংবাদ ২</div>
                <button class="slot-clear-btn" onclick="clearSlot(6)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-image"></i>ড্রপ করুন</div>
            </div>


            <!-- SECTION 3: 4 Slots (Story 8, 9, 10, 11) -->
            <!-- 8. Story 8 (spans 2 col, 3 rows) -->
            <div class="drop-slot g-span-2 slot-medium border-r" data-slot="7" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">৮. কলাম সংবাদ ২</div>
                <button class="slot-clear-btn" onclick="clearSlot(7)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-image"></i>ড্রপ করুন</div>
            </div>

            <!-- 9. Story 9 (spans 1 col, 3 rows) -->
            <div class="drop-slot g-span-1 slot-thin border-r" data-slot="8" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">৯. কলাম ১</div>
                <button class="slot-clear-btn" onclick="clearSlot(8)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-lines"></i>ড্রপ</div>
            </div>

            <!-- 10. Story 10 (spans 3 col, 3 rows) -->
            <div class="drop-slot g-span-3 slot-medium border-r" data-slot="9" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">১০. কলাম সংবাদ ৩</div>
                <button class="slot-clear-btn" onclick="clearSlot(9)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-image"></i>ড্রপ করুন</div>
            </div>

            <!-- 11. Story 11 (spans 2 col, 3 rows) -->
            <div class="drop-slot g-span-2 slot-medium" data-slot="10" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">১১. কলাম সংবাদ ২</div>
                <button class="slot-clear-btn" onclick="clearSlot(10)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-image"></i>ড্রপ করুন</div>
            </div>


            <!-- SECTION 4: 5 Slots (Story 12, 13, 14, 15, 16) -->
            <!-- 12. Story 12 (spans 1 col, 4 rows) -->
            <div class="drop-slot g-span-1 slot-thin border-r" data-slot="11" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">১২. কলাম ১</div>
                <button class="slot-clear-btn" onclick="clearSlot(11)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-lines"></i>ড্রপ</div>
            </div>

            <!-- 13. Story 13 (spans 3 col, 4 rows) -->
            <div class="drop-slot g-span-3 slot-medium border-r" data-slot="12" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">১৩. কলাম সংবাদ ৩</div>
                <button class="slot-clear-btn" onclick="clearSlot(12)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-image"></i>ড্রপ করুন</div>
            </div>

            <!-- 14. Story 14 (spans 1 col, 4 rows) -->
            <div class="drop-slot g-span-1 slot-thin border-r" data-slot="13" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">১৪. কলাম ১</div>
                <button class="slot-clear-btn" onclick="clearSlot(13)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-lines"></i>ড্রপ</div>
            </div>

            <!-- 15. Story 15 (spans 1 col, 4 rows) -->
            <div class="drop-slot g-span-1 slot-thin border-r" data-slot="14" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">১৫. কলাম ১</div>
                <button class="slot-clear-btn" onclick="clearSlot(14)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-lines"></i>ড্রপ</div>
            </div>

            <!-- 16. Story 16 (spans 2 col, 4 rows) -->
            <div class="drop-slot g-span-2 slot-medium" data-slot="15" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)">
                <div class="slot-label">১৬. কলাম সংবাদ ২</div>
                <button class="slot-clear-btn" onclick="clearSlot(15)">&times;</button>
                <div class="slot-empty"><i class="fa-regular fa-file-image"></i>ড্রপ করুন</div>
            </div>

        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
    // State arrays and variables
    let allPublishedPosts = []; // All posts mapped by ID
    let datePosts = []; // Posts on selected date
    let recentPosts = []; // Recent 30 posts
    let currentTab = 'date'; // 'date' or 'recent'
    let ePaperLayout = Array(16).fill(null); // Array storing post objects or null for the 16 slots

    // CSRF Token for Secure AJAX posting
    const csrfToken = "{{ csrf_token() }}";

    // Date converter helper to Bengali format
    function convertDateToBengali(dateString) {
        const monthNames = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
        const bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;

        const day = date.getDate().toString().replace(/[0-9]/g, d => bnDigits[+d]);
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear().toString().replace(/[0-9]/g, d => bnDigits[+d]);
        
        return `${day} ${month}, ${year}`;
    }

    // Switch between date-specific news drawer tab and general recent news tab
    function switchDrawerTab(tabName) {
        currentTab = tabName;
        document.getElementById('tabDate').classList.toggle('active', tabName === 'date');
        document.getElementById('tabRecent').classList.toggle('active', tabName === 'recent');
        renderDrawerNews();
    }

    // Load available news list & existing e-paper layout for chosen date via AJAX
    function loadEPaperLayout() {
        const dateInput = document.getElementById('epaperDate').value;
        if (!dateInput) return;

        // Set mini heading date
        document.getElementById('miniDateText').innerText = convertDateToBengali(dateInput);

        // Fetch data
        const loadUrl = `{{ route('admin.epaper.load') }}?date=${dateInput}`;
        
        // Show loading placeholders
        document.getElementById('drawerNewsList').innerHTML = `
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-spinner fa-spin fa-2x mb-2 text-danger"></i>
                <p style="font-size: 0.85rem;">লোড হচ্ছে...</p>
            </div>`;

        fetch(loadUrl)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    datePosts = data.date_posts || [];
                    recentPosts = data.recent_posts || [];
                    
                    // Populate global allPublishedPosts cache map to make looking up detail objects quick
                    allPublishedPosts = {};
                    [...datePosts, ...recentPosts].forEach(p => {
                        allPublishedPosts[p.id] = p;
                    });

                    // Set masthead title slogan
                    document.getElementById('epaperSlogan').value = data.title || 'প্রথম পাতা';

                    // Parse layout
                    ePaperLayout = data.saved_layout || Array(16).fill(null);

                    // Update UI slots
                    renderCanvasSlots();
                    renderDrawerNews();

                    if (data.has_saved) {
                        showBannerToast('পূর্বের সংরক্ষিত লেআউট সফলভাবে লোড হয়েছে।', 'success');
                    } else {
                        showBannerToast('এই তারিখে কোনো সংরক্ষিত ই-পেপার নেই। ড্রাফট লেআউট তৈরি হয়েছে।', 'info');
                    }
                } else {
                    showBannerToast('লেআউট লোড করতে ব্যর্থ হয়েছে।', 'danger');
                }
            })
            .catch(err => {
                console.error(err);
                showBannerToast('সার্ভার কানেকশন এরর।', 'danger');
            });
    }

    // Render left news drawer list matching filters
    function renderDrawerNews() {
        const container = document.getElementById('drawerNewsList');
        const searchVal = document.getElementById('drawerSearch').value.toLowerCase();
        const activeList = currentTab === 'date' ? datePosts : recentPosts;

        // Filter out news already placed in slots to avoid duplicates on screen
        const occupiedIds = ePaperLayout.filter(p => p !== null).map(p => p.id);
        const filteredList = activeList.filter(p => {
            const matchesSearch = p.title.toLowerCase().includes(searchVal);
            const notOccupied = !occupiedIds.includes(p.id);
            return matchesSearch && notOccupied;
        });

        if (filteredList.length === 0) {
            container.innerHTML = `
                <div class="text-center py-4 text-white-50" style="font-size: 0.85rem; border: 1px dashed rgba(255,255,255,0.06); border-radius: var(--radius-sm);">
                    <i class="fa-solid fa-folder-open fa-lg d-block mb-2 text-muted"></i>
                    কোন সংবাদ পাওয়া যায়নি।
                </div>`;
            return;
        }

        container.innerHTML = filteredList.map(p => `
            <div class="news-card-item" draggable="true" ondragstart="handleDragStart(event, ${p.id})">
                <img src="${p.featured_image_url || 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=120'}" class="news-item-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=120'">
                <div class="news-item-details">
                    <h5 class="news-item-title" title="${p.title}">${p.title}</h5>
                    <div class="news-item-meta">
                        <span class="badge bg-secondary" style="font-size: 0.65rem;">${p.categories && p.categories.length > 0 ? p.categories[0].name : 'সাধারণ'}</span>
                        <span><i class="fa-regular fa-clock me-1"></i>${new Date(p.created_at).toLocaleDateString()}</span>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Filter available news items on keypress search
    function filterDrawerNews() {
        renderDrawerNews();
    }

    // Render broadsheet dropped slots UI
    function renderCanvasSlots() {
        ePaperLayout.forEach((post, index) => {
            const slotEl = document.querySelector(`.drop-slot[data-slot="${index}"]`);
            if (!slotEl) return;

            if (post) {
                // Occupied state
                slotEl.classList.add('occupied');
                
                // Determine whether to display a thumbnail preview in mockup
                const showImage = !slotEl.classList.contains('slot-thin');
                const imgMarkup = showImage ? `
                    <div class="slot-post-img-box">
                        <img src="${post.featured_image_url || 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=120'}" class="slot-post-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=120'">
                    </div>` : '';

                slotEl.querySelector('.slot-empty').style.display = 'none';
                
                // Inject visual representation
                let postPreviewEl = slotEl.querySelector('.slot-post-view');
                if (!postPreviewEl) {
                    postPreviewEl = document.createElement('div');
                    postPreviewEl.className = 'slot-post-view';
                    slotEl.appendChild(postPreviewEl);
                }
                
                postPreviewEl.innerHTML = `
                    <h4 class="slot-post-title">${post.title}</h4>
                    ${imgMarkup}
                `;
                postPreviewEl.style.display = 'flex';
            } else {
                // Empty state
                slotEl.classList.remove('occupied');
                slotEl.querySelector('.slot-empty').style.display = 'flex';
                
                const postPreviewEl = slotEl.querySelector('.slot-post-view');
                if (postPreviewEl) {
                    postPreviewEl.style.display = 'none';
                }
            }
        });
    }

    // Native Drag and Drop events
    function handleDragStart(e, postId) {
        e.dataTransfer.setData('text/plain', postId);
        e.dataTransfer.effectAllowed = 'move';
    }

    function allowDrop(e) {
        e.preventDefault();
        e.currentTarget.classList.add('dragover');
    }

    function dragLeave(e) {
        e.currentTarget.classList.remove('dragover');
    }

    function handleDrop(e) {
        e.preventDefault();
        const slotEl = e.currentTarget;
        slotEl.classList.remove('dragover');
        
        const postId = parseInt(e.dataTransfer.getData('text/plain'));
        const index = parseInt(slotEl.getAttribute('data-slot'));

        if (isNaN(postId) || isNaN(index)) return;

        const post = allPublishedPosts[postId];
        if (!post) return;

        // If the slot is already occupied, the existing post goes back to the drawer list
        ePaperLayout[index] = post;

        // Re-render UI components
        renderCanvasSlots();
        renderDrawerNews();
        
        showBannerToast('সংবাদটি সফলভাবে লেআউট গ্রিডে বসানো হয়েছে।', 'success');
    }

    // Clear and empty slot position
    window.clearSlot = function (index) {
        if (ePaperLayout[index] === null) return;
        
        ePaperLayout[index] = null;
        renderCanvasSlots();
        renderDrawerNews();
        
        showBannerToast('লেআউট স্লট খালি করা হয়েছে।', 'info');
    };

    // Save interactive broadsheet layout array to DB via AJAX POST
    window.saveEPaperLayout = function () {
        const dateInput = document.getElementById('epaperDate').value;
        const sloganInput = document.getElementById('epaperSlogan').value;

        if (!dateInput) {
            showBannerToast('ই-পেপার প্রকাশের তারিখ দিন!', 'warning');
            return;
        }

        // Prepare layout IDs array
        const layoutIds = ePaperLayout.map(post => post ? post.id : null);

        // AJAX Options
        const saveUrl = "{{ route('admin.epaper.save') }}";
        const payload = {
            date: dateInput,
            title: sloganInput || 'প্রথম পাতা',
            layout: layoutIds
        };

        fetch(saveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showBannerToast('ই-পেপার সংস্করণ সফলভাবে প্রকাশ ও সেভ করা হয়েছে!', 'success');
                // Reload to keep sync states correct
                loadEPaperLayout();
            } else {
                showBannerToast('সংরক্ষণ ব্যর্থ হয়েছে: ' + (data.message || 'অজানা ত্রুটি'), 'danger');
            }
        })
        .catch(err => {
            console.error(err);
            showBannerToast('লেআউট সেভ করতে সার্ভার ত্রুটি হয়েছে।', 'danger');
        });
    };

    // Premium banner dynamic toasts
    function showBannerToast(msg, type = 'success') {
        // Check if there is an existing flash container
        let container = document.getElementById('toastWrapper');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastWrapper';
            container.style.position = 'fixed';
            container.style.top = '20px';
            container.style.right = '20px';
            container.style.zIndex = '9999';
            container.style.display = 'flex';
            container.style.flexDirection = 'column';
            container.style.gap = '10px';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'info' ? 'success' : type} mb-0`;
        toast.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.4)';
        toast.style.animation = 'slideIn 0.3s ease forwards';
        toast.style.minWidth = '280px';
        
        let icon = 'fa-circle-check';
        if (type === 'danger') icon = 'fa-circle-exclamation';
        if (type === 'info') icon = 'fa-circle-info';
        if (type === 'warning') icon = 'fa-triangle-exclamation';

        toast.innerHTML = `
            <i class="fa-solid ${icon}"></i>
            <span>${msg}</span>
        `;

        // CSS slideIn keyframe on the fly
        if (!document.getElementById('slideKeyframeStyle')) {
            const style = document.createElement('style');
            style.id = 'slideKeyframeStyle';
            style.innerHTML = `
                @keyframes slideIn {
                    from { transform: translateX(120%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }`;
            document.head.appendChild(style);
        }

        container.appendChild(toast);

        // Auto remove
        setTimeout(() => {
            toast.style.animation = 'slideIn 0.3s ease reverse forwards';
            setTimeout(() => { toast.remove(); }, 300);
        }, 3000);
    }

    // Trigger load on first load
    document.addEventListener('DOMContentLoaded', loadEPaperLayout);
</script>
@endsection
