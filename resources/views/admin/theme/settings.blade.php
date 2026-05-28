@extends('layouts.admin')

@section('title', 'থিম ডিজাইন সেটিংস | দৈনিক ভোলা টাইমস্')
@section('header_title', 'থিম ডিজাইন সেটিংস')

@section('styles')
<style>
    /* Styling for Drag & Drop Menu Builder */
    .available-cat-item {
        background-color: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition);
    }
    .available-cat-item:hover {
        background-color: #f1f5f9;
        border-color: var(--accent);
    }
    .menu-item-row {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }
    .menu-item-row.depth-1 {
        margin-left: 45px !important;
        background-color: #f8fafc;
        border-style: dashed;
        border-left: 3px solid var(--accent);
    }
    .drag-handle {
        cursor: grab;
        color: var(--text-sub);
        font-size: 1.1rem;
        margin-right: 12px;
    }
    .drag-handle:hover {
        color: var(--text-dark);
    }
    .menu-item-title {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-dark);
        flex-grow: 1;
        display: flex;
        align-items: center;
    }
    .menu-item-actions {
        display: flex;
        gap: 6px;
    }
    .menu-btn {
        background-color: #f8fafc;
        border: 1px solid var(--border-color);
        color: var(--text-sub);
        width: 32px;
        height: 32px;
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.85rem;
    }
    .menu-btn:hover {
        background-color: var(--primary-bg);
        color: var(--text-dark);
    }
    .menu-btn-indent:hover {
        color: #38bdf8;
        border-color: #0284c7;
    }
    .menu-btn-outdent:hover {
        color: #38bdf8;
        border-color: #0284c7;
    }
    .menu-btn-delete:hover {
        color: #f87171;
        border-color: #dc2626;
    }
</style>
@endsection

@section('content')
<div class="admin-card">
    <div class="card-header-wrapper">
        <h3 class="card-title">
            <i class="fa-solid fa-palette"></i>
            <span>থিম ডিজাইন সেটিংস প্যানেল (সুপার অ্যাডমিন)</span>
        </h3>
        <span class="badge badge-success">সুপার অ্যাডমিন কন্ট্রোল</span>
    </div>

    <!-- Error Alerts -->
    @if($errors->any())
        <div class="alert alert-danger" style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5;">
            <i class="fa-solid fa-circle-exclamation"></i>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.theme.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Left Side: Brand Logo Configuration -->
            <div class="col-lg-6">
                <h4 class="mb-4 text-dark pb-2 border-bottom" style="font-size: 1.05rem; border-color: var(--border-color) !important;"><i class="fa-solid fa-signature text-danger me-2"></i>লোগো কনফিগারেশন</h4>

                <div class="form-group">
                    <label class="form-label" for="logo_text">লোগো এইচটিএমএল টেক্সট (Logo HTML Text)</label>
                    <input type="text" name="logo_text" id="logo_text" class="form-control" value="{{ old('logo_text', $settings['logo_text']) }}" required>
                    <span class="form-text">লোগো ইমেজ আপলোড করা না থাকলে এই টেক্সটটি প্রদর্শিত হবে। আপনি এইচটিএমএল ট্যাগ ব্যবহার করতে পারেন, যেমন: <code>দৈনিক ভোলা&lt;span&gt;টাইমস্&lt;/span&gt;</code>।</span>
                </div>

                <div class="form-group mt-4">
                    <label class="form-label" for="logo_image">লোগো ইমেজ আপলোড (Upload Brand Logo)</label>
                    <input type="file" name="logo_image" id="logo_image" class="form-control" accept="image/*">
                    <span class="form-text">লোগো ইমেজ আপলোড করা হলে লোগো টেক্সটের পরিবর্তে ইমেজটি প্রদর্শিত হবে। সর্বোচ্চ ফাইল সাইজ ২ মেগাবাইট।</span>
                    
                    @if(!empty($settings['logo_image']))
                        <div class="mt-3 p-3 text-center" style="background-color: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.05); border-radius: var(--radius-sm);">
                            <span class="d-block form-label mb-2" style="font-size: 0.85rem; color: var(--text-sub);">বর্তমান লোগো প্রিভিউ (Current Logo Preview)</span>
                            <img src="{{ asset($settings['logo_image']) }}" alt="দৈনিক ভোলা টাইমস্ লোগো" style="max-height: 50px; background-color: white; padding: 8px; border-radius: 4px;">
                        </div>
                    @endif
                </div>

                <div class="form-group mt-4">
                    <label class="form-label" for="font_family">ফন্ট ফ্যামিলি (Font Family Selection)</label>
                    <select name="font_family" id="font_family" class="form-control" style="background-color: rgba(9, 13, 22, 0.75);">
                        <option value="'Noto Sans Bengali', 'Outfit', sans-serif" {{ $settings['font_family'] == "'Noto Sans Bengali', 'Outfit', sans-serif" ? 'selected' : '' }}>নোটো সান্স বেঙ্গলি ও আউটফিট (Premium Noto Sans Bengali & Outfit)</option>
                        <option value="'Noto Serif Bengali', 'Noto Sans Bengali', serif" {{ $settings['font_family'] == "'Noto Serif Bengali', 'Noto Sans Bengali', serif" ? 'selected' : '' }}>নোটো শেরিফ বেঙ্গলি ও নোটো সান্স (Premium Noto Serif & Noto Sans)</option>
                        <option value="'Outfit', sans-serif" {{ $settings['font_family'] == "'Outfit', sans-serif" ? 'selected' : '' }}>শুধুমাত্র আউটফিট ইংরেজি (Outfit English Only)</option>
                        <option value="system-ui, sans-serif" {{ $settings['font_family'] == "system-ui, sans-serif" ? 'selected' : '' }}>সিস্টেম ডিফল্ট ফন্ট (System Default Fonts)</option>
                    </select>
                    <span class="form-text">এই ফন্ট ফ্যামিলিটি সমগ্র সাইটে প্রয়োগ করা হবে।</span>
                </div>
            </div>

            <!-- Right Side: Colors Configuration -->
            <div class="col-lg-6">
                <h4 class="mb-4 text-dark pb-2 border-bottom" style="font-size: 1.05rem; border-color: var(--border-color) !important;"><i class="fa-solid fa-droplet text-danger me-2"></i>রঙ কনফিগারেশন (Color Palette)</h4>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="form-label" for="primary_color">প্রাইমারি কালার (Primary Navy)</label>
                        <div class="d-flex gap-2">
                            <input type="color" class="form-control form-control-color" style="width: 52px; height: 42px; padding: 4px; border: 1px solid var(--border-color); background-color: transparent;" id="primary_color_picker" value="{{ old('primary_color', $settings['primary_color']) }}" oninput="document.getElementById('primary_color').value = this.value">
                            <input type="text" name="primary_color" id="primary_color" class="form-control" value="{{ old('primary_color', $settings['primary_color']) }}" required size="7" maxlength="7" oninput="document.getElementById('primary_color_picker').value = this.value">
                        </div>
                        <span class="form-text">সাইটের ব্যাকড্রপ, ফুটার ও গুরুত্বপূর্ণ হেডার ব্যানার রঙ।</span>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="form-label" for="accent_color">অ্যাকসেন্ট কালার (Accent Crimson)</label>
                        <div class="d-flex gap-2">
                            <input type="color" class="form-control form-control-color" style="width: 52px; height: 42px; padding: 4px; border: 1px solid var(--border-color); background-color: transparent;" id="accent_color_picker" value="{{ old('accent_color', $settings['accent_color']) }}" oninput="document.getElementById('accent_color').value = this.value">
                            <input type="text" name="accent_color" id="accent_color" class="form-control" value="{{ old('accent_color', $settings['accent_color']) }}" required size="7" maxlength="7" oninput="document.getElementById('accent_color_picker').value = this.value">
                        </div>
                        <span class="form-text">চলমান খবর, ক্যাটাগরি লাইন এবং বাটন ও হোভার লিংক রঙ।</span>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-6 form-group">
                        <label class="form-label" for="bg_site">সাইট ব্যাকগ্রাউন্ড (Site Background)</label>
                        <div class="d-flex gap-2">
                            <input type="color" class="form-control form-control-color" style="width: 52px; height: 42px; padding: 4px; border: 1px solid var(--border-color); background-color: transparent;" id="bg_site_picker" value="{{ old('bg_site', $settings['bg_site']) }}" oninput="document.getElementById('bg_site').value = this.value">
                            <input type="text" name="bg_site" id="bg_site" class="form-control" value="{{ old('bg_site', $settings['bg_site']) }}" required size="7" maxlength="7" oninput="document.getElementById('bg_site_picker').value = this.value">
                        </div>
                        <span class="form-text">সংবাদ কার্ডের পিছনের মূল ব্যাকগ্রাউন্ড রঙ।</span>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label class="form-label" for="text_main">টেক্সট কালার (Body Text Color)</label>
                        <div class="d-flex gap-2">
                            <input type="color" class="form-control form-control-color" style="width: 52px; height: 42px; padding: 4px; border: 1px solid var(--border-color); background-color: transparent;" id="text_main_picker" value="{{ old('text_main', $settings['text_main']) }}" oninput="document.getElementById('text_main').value = this.value">
                            <input type="text" name="text_main" id="text_main" class="form-control" value="{{ old('text_main', $settings['text_main']) }}" required size="7" maxlength="7" oninput="document.getElementById('text_main_picker').value = this.value">
                        </div>
                        <span class="form-text">সাইটের সংবাদ বিবরণ এবং অনুচ্ছেদের মূল টেক্সটের রঙ।</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Configuration Section -->
        <div class="row mt-4">
            <div class="col-12">
                <h4 class="mb-4 text-dark pb-2 border-bottom" style="font-size: 1.05rem; border-color: var(--border-color) !important;">
                    <i class="fa-solid fa-rectangle-list text-danger me-2"></i>ফুটার কনফিগারেশন (Footer Settings)
                </h4>
                
                <div class="row">
                    <!-- Left: Footer Logo & Text Description -->
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="footer_logo_image">ফুটার লোগো ইমেজ আপলোড (Footer Brand Logo)</label>
                        <input type="file" name="footer_logo_image" id="footer_logo_image" class="form-control" accept="image/*">
                        <span class="form-text">ফুটার লোগো আলাদা আপলোড করতে চাইলে এখানে আপলোড করুন। খালি থাকলে মূল ব্র্যান্ড লোগো বা লোগো টেক্সটটি ফুটারে প্রদর্শিত হবে।</span>
                        
                        @if(!empty($settings['footer_logo_image']))
                            <div class="mt-3 p-3 text-center" style="background-color: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.05); border-radius: var(--radius-sm);">
                                <span class="d-block form-label mb-2" style="font-size: 0.85rem; color: var(--text-sub);">বর্তমান ফুটার লোগো প্রিভিউ (Current Footer Logo)</span>
                                <img src="{{ asset($settings['footer_logo_image']) }}" alt="ফুটার লোগো" style="max-height: 50px; background-color: white; padding: 8px; border-radius: 4px;">
                            </div>
                        @endif

                        <div class="mt-4">
                            <label class="form-label" for="footer_text">ফুটার বিবরণ (Footer Description Text)</label>
                            <textarea name="footer_text" id="footer_text" class="form-control" rows="4">{{ old('footer_text', $settings['footer_text'] ?? '') }}</textarea>
                            <span class="form-text">ফুটারে লোগোর নিচে প্রদর্শিত মূল বিবরণ বা পরিচিতি টেক্সট।</span>
                        </div>
                    </div>

                    <!-- Right: Jogajog & Sompadok Settings -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label" for="contact_address">ঠিকানা (Contact Address)</label>
                                <input type="text" name="contact_address" id="contact_address" class="form-control" value="{{ old('contact_address', $settings['contact_address'] ?? '') }}">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label" for="contact_phone">ফোন (Contact Phone)</label>
                                <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-label" for="contact_email">ইমেইল (Contact Email)</label>
                            <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 form-group">
                                <label class="form-label" for="editorial_board_president">সম্পাদক মণ্ডলীর সভাপতি (Editorial Board President)</label>
                                <input type="text" name="editorial_board_president" id="editorial_board_president" class="form-control" value="{{ old('editorial_board_president', $settings['editorial_board_president'] ?? '') }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-6 form-group">
                                <label class="form-label" for="editorial_publisher">প্রধান সম্পাদক ও প্রকাশক (Chief Editor & Publisher)</label>
                                <input type="text" name="editorial_publisher" id="editorial_publisher" class="form-control" value="{{ old('editorial_publisher', $settings['editorial_publisher'] ?? '') }}">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label" for="editorial_editor">ভারপ্রাপ্ত সম্পাদক (Acting Editor)</label>
                                <input type="text" name="editorial_editor" id="editorial_editor" class="form-control" value="{{ old('editorial_editor', $settings['editorial_editor'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Social Profiles -->
                    <div class="col-md-6">
                        <h5 class="text-dark mb-3" style="font-size: 0.95rem; font-weight: 600;"><i class="fa-solid fa-share-nodes text-danger me-2"></i>সোশ্যাল প্রোফাইল লিংক (Social Links)</h5>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label" for="social_facebook">ফেসবুক (Facebook)</label>
                                <input type="text" name="social_facebook" id="social_facebook" class="form-control" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label" for="social_twitter">টুইটার (Twitter / X)</label>
                                <input type="text" name="social_twitter" id="social_twitter" class="form-control" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-6 form-group">
                                <label class="form-label" for="social_youtube">ইউটিউব (YouTube)</label>
                                <input type="text" name="social_youtube" id="social_youtube" class="form-control" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label" for="social_instagram">ইনস্টাগ্রাম (Instagram)</label>
                                <input type="text" name="social_instagram" id="social_instagram" class="form-control" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Copyright Text -->
                    <div class="col-md-6 form-group d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="text-dark mb-3" style="font-size: 0.95rem; font-weight: 600;"><i class="fa-solid fa-copyright text-danger me-2"></i>কপিরাইট ইনফরমেশন</h5>
                            <label class="form-label" for="copyright_text">কпиরাইট টেক্সট (Copyright Notice)</label>
                            <input type="text" name="copyright_text" id="copyright_text" class="form-control" value="{{ old('copyright_text', $settings['copyright_text'] ?? '') }}">
                            <span class="form-text">ফুটারে সর্বনিচে কপিরাইট টেক্সট হিসেবে প্রদর্শিত হবে।</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Menu Drag & Drop Configuration -->
        <div class="row mt-4">
            <div class="col-12 form-group">
                <h4 class="mb-3 text-dark pb-2 border-bottom" style="font-size: 1.05rem; border-color: var(--border-color) !important;">
                    <i class="fa-solid fa-bars text-danger me-2"></i>প্রধান মেনু কনফিগারেশন (Drag & Drop Nested Menu Builder)
                </h4>
                <span class="form-text mb-3 d-block text-muted" style="font-size: 0.88rem;">বাম দিকের তালিকা থেকে ক্যাটাগরিগুলো ডান দিকের "মেনু লেআউট" এ যুক্ত করুন। ড্র্যাগ অ্যান্ড ড্রপ করে সাজান এবং সাব-মেনু তৈরি করতে ইনডেন্ট করুন।</span>
                
                <div class="row">
                    <!-- Left Column: Available Categories -->
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: 700; color: var(--accent);"><i class="fa-solid fa-list-ul me-1"></i>ক্যাটাগরি সমূহ (Available)</label>
                        <div class="p-3" style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); max-height: 400px; overflow-y: auto;">
                            <div class="d-flex flex-column gap-2" id="availableCategories">
                                <!-- Rendered dynamically by JavaScript -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Menu Structure -->
                    <div class="col-md-8">
                        <label class="form-label" style="font-weight: 700; color: var(--accent);"><i class="fa-solid fa-network-wired me-1"></i>মেনু লেআউট (Menu Structure)</label>
                        <div class="p-3" style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); min-height: 250px;">
                            <ul class="list-unstyled d-flex flex-column gap-2 mb-0" id="menuBuilderList">
                                <!-- Rendered dynamically by JavaScript -->
                            </ul>
                            <div id="emptyMenuMsg" class="text-center text-muted py-4 d-none">
                                <i class="fa-solid fa-folder-open d-block mb-2" style="font-size: 2rem;"></i>
                                মেনুটি খালি। বাম দিক থেকে ক্যাটাগরি যুক্ত করুন।
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden input to store serialized structure -->
                <input type="hidden" name="menu_structure" id="menuStructureInput">
                <span class="form-text mt-3 d-block">যে ক্যাটাগরিগুলো মেনু লেআউটে সাজাবেন, শুধুমাত্র সেগুলোই হেডার মেনু এবং মোবাইল মেনুতে প্রদর্শিত হবে। কোনোটিই সাজানো না থাকলে ডিফল্টরূপে পোস্ট থাকা ক্যাটাগরিগুলো প্রদর্শিত হবে।</span>
            </div>
        </div>

        <!-- Homepage Categories Drag & Drop Configuration -->
        <div class="row mt-4">
            <div class="col-12 form-group">
                <h4 class="mb-3 text-dark pb-2 border-bottom" style="font-size: 1.05rem; border-color: var(--border-color) !important;">
                    <i class="fa-solid fa-house-laptop text-danger me-2"></i>হোমপেজ ক্যাটাগরি লেআউট কনফিগারেশন (Drag & Drop Category Order)
                </h4>
                <span class="form-text mb-3 d-block text-muted" style="font-size: 0.88rem;">বাম দিকের তালিকা থেকে ক্যাটাগরিগুলো ডান দিকের "হোমপেজ লেআউট" এ যুক্ত করুন। ড্র্যাগ অ্যান্ড ড্রপ করে তাদের প্রদর্শনীর ক্রম সাজান। হোমপেজে এই ক্যাটাগরিগুলো ঠিক এই ক্রমানুসারে একের পর এক প্রদর্শিত হবে। কোনোটিই সাজানো না থাকলে হোমপেজে শুধুমাত্র শীর্ষ খবর ও সর্বশেষ খবর প্রদর্শিত হবে (কোনো ক্যাটাগরি ব্লক প্রদর্শিত হবে না)।</span>
                
                <div class="row">
                    <!-- Left Column: Available Categories -->
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: 700; color: var(--accent);"><i class="fa-solid fa-list-ul me-1"></i>ক্যাটাগরি সমূহ (Available)</label>
                        <div class="p-3" style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); max-height: 400px; overflow-y: auto;">
                            <div class="d-flex flex-column gap-2" id="availableHomeCategories">
                                <!-- Rendered dynamically by JavaScript -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Home Category Layout Order -->
                    <div class="col-md-8">
                        <label class="form-label" style="font-weight: 700; color: var(--accent);"><i class="fa-solid fa-layer-group me-1"></i>হোমপেজ লেআউট (Homepage Layout Order)</label>
                        <div class="p-3" style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); min-height: 250px;">
                            <ul class="list-unstyled d-flex flex-column gap-2 mb-0" id="homeCategoryList">
                                <!-- Rendered dynamically by JavaScript -->
                            </ul>
                            <div id="emptyHomeCategoryMsg" class="text-center text-muted py-4 d-none">
                                <i class="fa-solid fa-folder-open d-block mb-2" style="font-size: 2rem;"></i>
                                হোমপেজ লেআউটটি খালি। বাম দিক থেকে ক্যাটাগরি যুক্ত করুন।
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden input to store serialized structure -->
                <input type="hidden" name="homepage_categories" id="homepageCategoriesInput">
            </div>
        </div>

        <!-- Custom CSS Area -->
        <div class="row mt-4">
            <div class="col-12 form-group">
                <h4 class="mb-3 text-dark pb-2 border-bottom" style="font-size: 1.05rem; border-color: var(--border-color) !important;"><i class="fa-solid fa-code text-danger me-2"></i>কাস্টম সিএসএস (Custom CSS Overlay)</h4>
                <label class="form-label" for="custom_css">অতিরিক্ত সিএসএস কোড (Custom Stylesheets)</label>
                <textarea name="custom_css" id="custom_css" rows="6" class="form-control" style="font-family: monospace; font-size: 0.9rem;" placeholder="/* Add custom styles here */&#10;body {&#10;    /* custom style rules */&#10;}">{{ old('custom_css', $settings['custom_css']) }}</textarea>
                <span class="form-text">এখানে লেখা সিএসএস রুলস সরাসরি সাইটের মূল সিএসএস-এর নিচে ইনজেক্ট করা হবে। সতর্কতার সাথে কোড লিখুন।</span>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-4 pt-3 d-flex gap-3" style="border-top: 1px solid var(--border-color);">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>ডিজাইন পরিবর্তন সংরক্ষণ করুন</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fa-solid fa-ban me-1"></i>বাতিল করুন</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Full list of categories from backend
        const allCategories = @json($categories);
        
        // Initial menu structure loaded from settings (stored as JSON)
        let menuItems = @json($settings['menu_structure'] ?? []);
        
        // Ensure menuItems is an array
        if (!Array.isArray(menuItems)) {
            menuItems = [];
        }

        const availableContainer = document.getElementById('availableCategories');
        const menuBuilderList = document.getElementById('menuBuilderList');
        const emptyMsg = document.getElementById('emptyMenuMsg');
        const structureInput = document.getElementById('menuStructureInput');

        // Render the builder lists
        function renderMenuBuilder() {
            // Clear lists
            availableContainer.innerHTML = '';
            menuBuilderList.innerHTML = '';

            // Filter out already added items
            const addedIds = menuItems.map(item => parseInt(item.id));
            
            // 1. Render Available categories on the left
            allCategories.forEach(cat => {
                if (!addedIds.includes(cat.id)) {
                    const div = document.createElement('div');
                    div.className = 'available-cat-item';
                    div.innerHTML = `
                        <span style="font-weight: 600; color: var(--text-dark);">${cat.name}</span>
                        <button type="button" class="btn btn-secondary btn-sm p-1 px-2" onclick="addMenuItem(${cat.id}, '${cat.name.replace(/'/g, "\\'")}')">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    `;
                    availableContainer.appendChild(div);
                }
            });

            if (availableContainer.children.length === 0) {
                availableContainer.innerHTML = '<div class="text-center text-muted py-3" style="font-size: 0.85rem;">সকল ক্যাটাগরি মেনুতে সাজানো হয়েছে।</div>';
            }

            // 2. Render Menu Layout on the right
            if (menuItems.length === 0) {
                emptyMsg.classList.remove('d-none');
            } else {
                emptyMsg.classList.add('d-none');
                
                menuItems.forEach((item, index) => {
                    const li = document.createElement('li');
                    const depth = item.depth || 0;
                    li.className = `menu-item-row depth-${depth}`;
                    li.setAttribute('data-id', item.id);
                    li.setAttribute('data-index', index);
                    
                    const subIndicator = depth === 1 ? '<i class="fa-solid fa-arrow-turn-up fa-rotate-90 text-muted me-2" style="font-size: 0.85rem;"></i>' : '';
                    
                    li.innerHTML = `
                        <div class="drag-handle"><i class="fa-solid fa-grip-vertical"></i></div>
                        <div class="menu-item-title">
                            ${subIndicator}
                            <span>${item.name}</span>
                            ${depth === 1 ? '<span class="badge badge-warning ms-2" style="font-size: 0.65rem; padding: 2px 6px; background-color: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2);">সাব-মেনু</span>' : ''}
                        </div>
                        <div class="menu-item-actions">
                            <button type="button" class="menu-btn menu-btn-outdent" title="প্রধান মেনু করুন (Outdent)" onclick="changeDepth(${index}, 0)" ${depth === 0 ? 'disabled style="opacity: 0.3; cursor: not-allowed;"' : ''}>
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button type="button" class="menu-btn menu-btn-indent" title="সাব-মেনু করুন (Indent)" onclick="changeDepth(${index}, 1)" ${depth === 1 || index === 0 ? 'disabled style="opacity: 0.3; cursor: not-allowed;"' : ''}>
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                            <button type="button" class="menu-btn menu-btn-delete" title="মুছে ফেলুন" onclick="removeMenuItem(${index})">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    `;
                    menuBuilderList.appendChild(li);
                });
            }

            // Update serialized JSON input
            updateSerializedInput();
        }

        // Add menu item
        window.addMenuItem = function (id, name) {
            menuItems.push({ id: id, name: name, depth: 0 });
            renderMenuBuilder();
        };

        // Remove menu item
        window.removeMenuItem = function (index) {
            menuItems.splice(index, 1);
            renderMenuBuilder();
        };

        // Change depth (Indent/Outdent)
        window.changeDepth = function (index, newDepth) {
            if (index === 0 && newDepth === 1) return; // First item cannot be sub-menu
            
            menuItems[index].depth = newDepth;
            renderMenuBuilder();
        };

        // Update serialized JSON string
        function updateSerializedInput() {
            structureInput.value = JSON.stringify(menuItems);
        }

        // Initialize SortableJS for Menu Structure List
        new Sortable(menuBuilderList, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'bg-primary-subtle',
            onEnd: function () {
                // Read new DOM order
                const reorderedItems = [];
                menuBuilderList.querySelectorAll('li.menu-item-row').forEach(row => {
                    const idx = parseInt(row.getAttribute('data-index'));
                    reorderedItems.push(menuItems[idx]);
                });
                menuItems = reorderedItems;
                
                // First item can never be depth 1
                if (menuItems.length > 0 && menuItems[0].depth === 1) {
                    menuItems[0].depth = 0;
                }
                
                renderMenuBuilder();
            }
        });

        // First render
        renderMenuBuilder();

        // ==========================================
        // Homepage Categories Sortable Logic
        // ==========================================
        let homeCategories = @json($settings['homepage_categories'] ?? []);
        if (!Array.isArray(homeCategories)) {
            homeCategories = [];
        }

        const availableHomeContainer = document.getElementById('availableHomeCategories');
        const homeCategoryList = document.getElementById('homeCategoryList');
        const emptyHomeMsg = document.getElementById('emptyHomeCategoryMsg');
        const homepageCategoriesInput = document.getElementById('homepageCategoriesInput');

        function renderHomeCategoriesBuilder() {
            availableHomeContainer.innerHTML = '';
            homeCategoryList.innerHTML = '';

            const addedIds = homeCategories.map(item => parseInt(item.id));

            // 1. Available categories
            allCategories.forEach(cat => {
                if (!addedIds.includes(cat.id)) {
                    const div = document.createElement('div');
                    div.className = 'available-cat-item';
                    div.innerHTML = `
                        <span style="font-weight: 600; color: var(--text-dark);">${cat.name}</span>
                        <button type="button" class="btn btn-secondary btn-sm p-1 px-2" onclick="addHomeCategory(${cat.id}, '${cat.name.replace(/'/g, "\\'")}')">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    `;
                    availableHomeContainer.appendChild(div);
                }
            });

            if (availableHomeContainer.children.length === 0) {
                availableHomeContainer.innerHTML = '<div class="text-center text-muted py-3" style="font-size: 0.85rem;">সকল ক্যাটাগরি হোমপেজে সাজানো হয়েছে।</div>';
            }

            // 2. Homepage layout category order
            if (homeCategories.length === 0) {
                emptyHomeMsg.classList.remove('d-none');
            } else {
                emptyHomeMsg.classList.add('d-none');

                homeCategories.forEach((item, index) => {
                    const li = document.createElement('li');
                    li.className = 'menu-item-row';
                    li.setAttribute('data-id', item.id);
                    li.setAttribute('data-index', index);

                    li.innerHTML = `
                        <div class="drag-handle"><i class="fa-solid fa-grip-vertical"></i></div>
                        <div class="menu-item-title">
                            <span>${item.name}</span>
                        </div>
                        <div class="menu-item-actions">
                            <button type="button" class="menu-btn menu-btn-delete" title="মুছে ফেলুন" onclick="removeHomeCategory(${index})">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    `;
                    homeCategoryList.appendChild(li);
                });
            }

            updateHomeCategoriesInput();
        }

        window.addHomeCategory = function (id, name) {
            homeCategories.push({ id: id, name: name });
            renderHomeCategoriesBuilder();
        };

        window.removeHomeCategory = function (index) {
            homeCategories.splice(index, 1);
            renderHomeCategoriesBuilder();
        };

        function updateHomeCategoriesInput() {
            homepageCategoriesInput.value = JSON.stringify(homeCategories);
        }

        new Sortable(homeCategoryList, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'bg-primary-subtle',
            onEnd: function () {
                const reorderedItems = [];
                homeCategoryList.querySelectorAll('li.menu-item-row').forEach(row => {
                    const idx = parseInt(row.getAttribute('data-index'));
                    reorderedItems.push(homeCategories[idx]);
                });
                homeCategories = reorderedItems;
                renderHomeCategoriesBuilder();
            }
        });

        // Initialize Home Categories builder
        renderHomeCategoriesBuilder();
    });
</script>
@endsection
