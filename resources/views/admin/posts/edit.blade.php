@extends('layouts.admin')

@section('title', 'সংবাদ সম্পাদনা | অ্যাডমিন প্যানেল')
@section('header_title', 'সংবাদ সম্পাদনা')

@section('styles')
<style>
    /* Split form layout for media and options */
    .form-split {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }

    @media (min-width: 1024px) {
        .form-split {
            grid-template-columns: 2.2fr 1fr;
        }
    }

    /* Checklist card */
    .checklist-box {
        max-height: 240px;
        overflow-y: auto;
        border: 1px solid var(--border-color);
        padding: 12px 16px;
        border-radius: var(--radius-sm);
        background-color: rgba(9, 13, 22, 0.4);
    }

    .check-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.95rem;
        margin-bottom: 8px;
        cursor: pointer;
    }

    .check-label input {
        cursor: pointer;
        accent-color: var(--accent);
    }

    /* Featured Image preview box */
    .image-preview-box {
        width: 100%;
        height: 180px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        margin-bottom: 12px;
        position: relative;
        background-color: rgba(0, 0, 0, 0.15);
    }

    .image-preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-preview-placeholder {
        color: var(--text-sub);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
    }

    .image-preview-placeholder i {
        font-size: 2rem;
    }

    /* ================== Advanced Social Card Generator Styling ================== */
    @import url('https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@400;700&family=Baloo+Da+2:wght@400;700&family=Galada&family=Hind+Siliguri:wght@400;500;700&family=Mina:wght@400;700&family=Noto+Sans+Bengali:wght@400;500;700&family=Tiro+Bangla:ital@0;1&display=swap');

    .preview-wrapper {
        width: 378px;
        height: 378px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        background-color: #000000;
        position: relative;
        box-shadow: var(--shadow-lg);
    }

    .scale-container {
        transform: scale(0.35);
        transform-origin: top left;
        width: 1080px;
        height: 1080px;
        position: absolute;
        top: 0;
        left: 0;
    }

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
        border-top: 3px solid var(--accent);
    }
    
    .full-width-ad-bar img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        display: block; 
    }

    [contenteditable="true"] { 
        outline: none; 
        border-radius: 4px; 
        padding: 2px 6px; 
        transition: all 0.2s; 
    }
    
    [contenteditable="true"]:hover, [contenteditable="true"]:focus { 
        background: rgba(255, 255, 255, 0.08); 
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.08); 
    }
</style>
@endsection

@section('content')

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-split">
            <!-- Left main writing card -->
            <div class="admin-card">
                <h3 class="card-title" style="margin-bottom: 24px;">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>সংবাদ বিবরণ সম্পাদন</span>
                </h3>

                <!-- Title -->
                <div class="form-group">
                    <label for="title" class="form-label">শিরোনাম (Headline)</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required placeholder="এখানে সংবাদের শিরোনাম লিখুন..." class="form-control">
                </div>

                <!-- Excerpt -->
                <div class="form-group">
                    <label for="excerpt" class="form-label">সারসংক্ষেপ (Excerpt - সংক্ষিপ্ত বিবরণ)</label>
                    <textarea name="excerpt" id="excerpt" rows="3" placeholder="সংবাদের সংক্ষিপ্ত বিবরণ লিখুন..." class="form-control">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <!-- Content -->
                <div class="form-group">
                    <label for="content" class="form-label">মূল সংবাদ কন্টেন্ট (Main Content)</label>
                    <textarea name="content" id="content" rows="18" required placeholder="এখানে মূল খবরটি লিখুন..." class="form-control" style="line-height: 1.7; font-size: 1.05rem;">{{ old('content', $post->content) }}</textarea>
                </div>
            </div>

            <!-- Right options panelpanel -->
            <div>
                <!-- Publish status card -->
                <div class="admin-card">
                    <h3 class="card-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>প্রকাশের অবস্থা</span>
                    </h3>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status" class="form-label">স্ট্যাটাস</label>
                        <select name="status" id="status" class="form-control">
                            <option value="publish" {{ old('status', $post->status) === 'publish' ? 'selected' : '' }}>প্রকাশিত (Publish)</option>
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>খসড়া (Draft)</option>
                        </select>
                    </div>

                    <div style="display: flex; gap: 12px; margin-top: 24px;">
                        <button type="submit" class="btn btn-primary" style="flex-grow: 1; justify-content: center;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>হালনাগাদ করুন</span>
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">বাতিল</a>
                    </div>
                </div>

                <!-- Featured Image upload card -->
                <div class="admin-card">
                    <h3 class="card-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-image"></i>
                        <span>ফিচার্ড ইমেজ</span>
                    </h3>

                    <div class="image-preview-box" id="previewContainer">
                        @if($post->featured_image)
                            <img src="{{ $post->featured_image_url }}" alt="Featured Image Preview" class="image-preview-img" id="previewImg">
                            <div class="image-preview-placeholder" id="previewPlaceholder" style="display: none;">
                                <i class="fa-regular fa-image"></i>
                                <span>ছবি নির্বাচন করা হয়নি</span>
                            </div>
                        @else
                            <img src="" alt="Featured Image Preview" class="image-preview-img" id="previewImg" style="display: none;">
                            <div class="image-preview-placeholder" id="previewPlaceholder">
                                <i class="fa-regular fa-image"></i>
                                <span>ছবি নির্বাচন করা হয়নি</span>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="file" name="featured_image" id="featured_image" accept="image/*" class="form-control" onchange="previewImage(this)">
                        <span class="form-text">নতুন ছবি আপলোড করতে পারেন। ছবির সাইজ ৫ মেগাবাইটের কম হতে হবে।</span>
                    </div>
                </div>

                <!-- Categories Checklist -->
                <div class="admin-card">
                    <h3 class="card-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-folder-open"></i>
                        <span>ক্যাটাগরি সমূহ</span>
                    </h3>

                    <div class="checklist-box">
                        @php
                            $selectedCats = old('categories', $post->categories->pluck('id')->toArray());
                        @endphp
                        @forelse($categories as $cat)
                            <label class="check-label">
                                <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCats) ? 'checked' : '' }}>
                                <span>{{ $cat->name }}</span>
                            </label>
                        @empty
                            <p style="color: var(--text-sub); font-size: 0.9rem;">কোনো ক্যাটাগরি পাওয়া যায়নি।</p>
                        @endforelse
                    </div>
                </div>

                <!-- Tags Checklist -->
                <div class="admin-card">
                    <h3 class="card-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-tags"></i>
                        <span>ট্যাগসমূহ</span>
                    </h3>

                    <div class="checklist-box" style="margin-bottom: 16px;">
                        @php
                            $selectedTags = old('tags', $post->tags->pluck('id')->toArray());
                        @endphp
                        @forelse($tags as $tag)
                            <label class="check-label">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}>
                                <span>{{ $tag->name }}</span>
                            </label>
                        @empty
                            <p style="color: var(--text-sub); font-size: 0.9rem; margin-bottom: 0;">কোনো ট্যাগ পাওয়া যায়নি।</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        @can('admin-or-super')
            <!-- Social Card Generator at the bottom of the form -->
            <div class="admin-card" style="margin-top: 24px; border-top: 3px solid var(--accent);">
                <h3 class="card-title" style="margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                    <i class="fa-solid fa-share-nodes"></i>
                    <span>সোশ্যাল মিডিয়া কার্ড জেনারেটর (Advanced Social Card Generator)</span>
                </h3>

                <div class="row align-items-start">
                    <!-- Left: Controls -->
                    <div class="col-lg-7 d-flex flex-column gap-3">
                        <p style="color: var(--text-sub); font-size: 0.95rem; line-height: 1.7; margin-bottom: 12px;">
                            ফেসবুক বা অন্য সোশ্যাল মিডিয়ায় খবর শেয়ার করার জন্য এই জেনারেটরটি খবরের শিরোনাম, মূল ছবি, তারিখ ও বিজ্ঞাপন দিয়ে একটি আকর্ষণীয় সোশ্যাল মিডিয়া শেয়ারিং কার্ড তৈরি করবে। আপনি সরাসরি ডানে কার্ডের যেকোনো টেক্সটের ওপর ক্লিক করে সরাসরি টাইপ করে পরিবর্তন করতে পারেন! অথবা নিচের টুলসগুলো ব্যবহার করুন।
                        </p>

                        <div class="card p-3 border-secondary" style="background-color: rgba(30, 41, 59, 0.2); border: 1px solid rgba(255,255,255,0.08); border-radius: var(--radius-md);">
                            <div class="row g-3">
                                <!-- Font -->
                                <div class="col-sm-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">ফন্ট (Font Style)</label>
                                    <select class="form-control" style="background-color: rgba(9, 13, 22, 0.75);" onchange="changeFontFamily(this.value)">
                                        <option value="'Noto Sans Bengali', sans-serif" selected>Noto Sans (ডিফল্ট)</option>
                                        <option value="'Baloo Da 2', sans-serif">Baloo Da 2 (গোলাকার)</option>
                                        <option value="'Anek Bangla', sans-serif">Anek Bangla (আধুনিক)</option>
                                        <option value="'Tiro Bangla', serif">Tiro Bangla (পত্রিকা স্টাইল)</option>
                                        <option value="'Hind Siliguri', sans-serif">Hind Siliguri</option>
                                        <option value="'Mina', sans-serif">Mina</option>
                                        <option value="'Galada', cursive">Galada (স্টাইলিশ)</option>
                                    </select>
                                </div>

                                <!-- Font Size -->
                                <div class="col-sm-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">ফন্ট সাইজ (Headline Size)</label>
                                    <select class="form-control" style="background-color: rgba(9, 13, 22, 0.75);" onchange="changeFontSize(this.value)">
                                        @for ($i = 40; $i <= 80; $i+=2)
                                            <option value="{{ $i }}" {{ $i == 52 ? 'selected' : '' }}>{{ $i }} px</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Line Height -->
                                <div class="col-sm-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">লাইন হাইট (Line Height)</label>
                                    <select class="form-control" style="background-color: rgba(9, 13, 22, 0.75);" onchange="changeLineHeight(this.value)">
                                        <option value="1.0">1.0</option>
                                        <option value="1.1">1.1</option>
                                        <option value="1.2">1.2</option>
                                        <option value="1.3" selected>1.3</option>
                                        <option value="1.4">1.4</option>
                                        <option value="1.5">1.5</option>
                                    </select>
                                </div>

                                <!-- Color Picker -->
                                <div class="col-sm-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">সিলেক্টেড টেক্সট কালার</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color border-secondary" style="width: 52px; height: 38px; padding: 2px; background-color: transparent;" oninput="changeSelectedColor(this.value)">
                                        <span style="font-size: 0.8rem; color: var(--text-sub);">যেকোনো টেক্সট মাউস দিয়ে সিলেক্ট করে রঙ পরিবর্তন করুন</span>
                                    </div>
                                </div>

                                <!-- Custom Card Image Upload -->
                                <div class="col-12 mt-3">
                                    <label for="social_card_image" class="form-label" style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">সোশ্যাল কার্ডের জন্য কাস্টম ছবি (ঐচ্ছিক)</label>
                                    @if($post->social_card_image)
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <img src="{{ $post->social_card_image_url }}" alt="Existing Social Card" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                                            <span style="font-size: 0.75rem; color: var(--success);"><i class="fa-solid fa-circle-check"></i> কাস্টম সোশ্যাল কার্ড ইমেজ আপলোড করা আছে</span>
                                        </div>
                                    @endif
                                    <input type="file" name="social_card_image" id="social_card_image" accept="image/*" class="form-control" onchange="previewSocialCardImage(this)">
                                    <span class="form-text" style="font-size: 0.75rem; color: var(--text-sub);">নতুন ছবি আপলোড করলে পূর্বেরটি প্রতিস্থাপিত হবে। আপলোড না করলে মূল ফিচার্ড ইমেজটিই কার্ডে ব্যবহৃত হবে।</span>
                                </div>

                                <!-- Ad URL Link Option -->
                                <div class="col-12 mt-3">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">বিজ্ঞাপন ব্যানার লিংক (Paste 1080x100 Image Link)</label>
                                    <div class="d-flex gap-2">
                                        <input type="text" id="ad_url_input" placeholder="বিজ্ঞাপন ইমেজের লিংক দিন..." class="form-control" style="background-color: rgba(9, 13, 22, 0.75);">
                                        <button type="button" onclick="updateMainAd()" class="btn btn-secondary text-white" style="font-size: 0.85rem; white-space: nowrap;"><i class="fa-solid fa-check me-1"></i>Apply</button>
                                    </div>
                                    <span class="form-text" style="font-size: 0.75rem; color: var(--text-sub);">১০৮০x১০০ মাপের বিজ্ঞাপন ইমেজের লিংক দিয়ে Apply করুন।</span>
                                </div>
                            </div>
                        </div>

                        <!-- Save Card Button -->
                        <div class="mt-3">
                            <button type="button" onclick="download_SocialCard(event)" class="btn btn-success btn-lg d-inline-flex align-items-center gap-2 px-4" style="background-color: #27ae60; border-color: #27ae60; box-shadow: 0 4px 12px rgba(39,174,96,0.3); font-weight: 700;">
                                <i class="fa-solid fa-download"></i>
                                <span>সোশ্যাল কার্ড ইমেজ সেভ করুন</span>
                            </button>
                        </div>
                    </div>

                    <!-- Right: Real-time Live Preview Mockup -->
                    <div class="col-lg-5 d-flex flex-column align-items-center mt-4 mt-lg-0">
                        <h4 class="form-label" style="margin-bottom: 16px; width: 100%; max-width: 378px; text-align: left; font-weight: 700; font-size: 0.95rem;">
                            <i class="fa-regular fa-eye" style="color: var(--accent);"></i> রিয়েল-টাইম প্রিভিউ (Live Card Preview)
                        </h4>

                        <!-- Scaled-down Wrapper Container -->
                        <div class="preview-wrapper">
                            <div class="scale-container">
                                <div id="social_card_node" class="news-card-1080">
                                    
                                    <!-- News Image Section -->
                                    <div class="news-image-wrapper">
                                        @if($post->social_card_image)
                                            <img src="{{ $post->social_card_image_url }}" class="news-image" id="cardImagePreview" crossorigin="anonymous">
                                        @elseif($post->featured_image)
                                            <img src="{{ $post->featured_image_url }}" class="news-image" id="cardImagePreview" crossorigin="anonymous">
                                        @else
                                            <img src="" class="news-image" id="cardImagePreview" crossorigin="anonymous" style="display: none;">
                                            <div id="cardImagePlaceholder" style="width:100%; height:100%; background:#2c3e50; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.4); font-size: 40px;">
                                                <i class="fa-regular fa-image"></i>
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
                </div>
            </div>
        @endcan
    </form>

@endsection

@section('scripts')
    <!-- html2canvas Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
    // Global state variables pre-populated with existing post images
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
            if (target) target.style.fontFamily = fontName;
        }
    }

    // Font color logic
    function changeSelectedColor(color) {
        document.execCommand('styleWithCSS', false, true); 
        document.execCommand('foreColor', false, color);
    }

    // Font size logic
    function changeFontSize(size) {
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

    // Line height logic
    function changeLineHeight(val) {
        const target = document.getElementById('editable_headline');
        if (target) target.style.lineHeight = val;
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

    // Background Image updater
    function updateCardBackground() {
        const cardImg = document.getElementById('cardImagePreview');
        const placeholder = document.getElementById('cardImagePlaceholder');
        const src = socialCardImageSrc || featuredImageSrc;

        if (src) {
            if (cardImg) {
                cardImg.src = src;
                cardImg.style.display = 'block';
            }
            if (placeholder) placeholder.style.display = 'none';
        } else {
            if (cardImg) {
                cardImg.src = '';
                cardImg.style.display = 'none';
            }
            if (placeholder) placeholder.style.display = 'flex';
        }
    }

    // Sync Featured Image upload
    function previewImage(input) {
        const previewImg = document.getElementById('previewImg');
        const placeholder = document.getElementById('previewPlaceholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                }
                if (placeholder) placeholder.style.display = 'none';
                
                featuredImageSrc = e.target.result;
                updateCardBackground();
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            @if($post->featured_image)
                if (previewImg) {
                    previewImg.src = '{{ $post->featured_image_url }}';
                    previewImg.style.display = 'block';
                }
                if (placeholder) placeholder.style.display = 'none';
                featuredImageSrc = '{{ $post->featured_image_url }}';
            @else
                if (previewImg) {
                    previewImg.src = '';
                    previewImg.style.display = 'none';
                }
                if (placeholder) placeholder.style.display = 'flex';
                featuredImageSrc = '';
            @endif
            updateCardBackground();
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

    // Save as Image Function
    function download_SocialCard(e) {
        e.preventDefault();
        const node = document.getElementById('social_card_node');
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;

        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-1"></i> প্রসেসিং...';
        btn.style.pointerEvents = 'none';

        html2canvas(node, {
            useCORS: true,
            allowTaint: false,
            width: 1080,
            height: 1080,
            scale: 2, 
            backgroundColor: '#000000'
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'NewsCard-BholaTimes-{{ $post->id }}.jpg';
            link.href = canvas.toDataURL("image/jpeg", 0.9);
            link.click();
            
            btn.innerHTML = originalText;
            btn.style.pointerEvents = 'auto';
        }).catch(err => {
            console.error("html2canvas render failed:", err);
            alert("ছবি সেভ করতে সমস্যা হয়েছে। কনসোল লগ চেক করুন বা ইমেজ লিংকগুলো ঠিক আছে কিনা দেখুন।");
            btn.innerHTML = originalText;
            btn.style.pointerEvents = 'auto';
        });
    }

    // Event Listeners for real-time form bindings
    document.addEventListener('DOMContentLoaded', function() {
        const mainTitleInput = document.getElementById('title');
        const headlinePreview = document.getElementById('editable_headline');

        if (mainTitleInput && headlinePreview) {
            mainTitleInput.addEventListener('input', function() {
                headlinePreview.innerText = this.value || 'সংবাদের শিরোনাম এখানে লিখুন...';
            });
        }

        // Generate Bengali dynamic date for first load
        updateBengaliDate();
    });
</script>
@endsection
