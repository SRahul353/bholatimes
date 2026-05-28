@extends('layouts.app')
 
@section('title', $post->title . ' | দৈনিক ভোলা টাইমস্')
@section('meta_description', mb_substr(strip_tags($post->content), 0, 150) . '...')
@section('meta_keywords', implode(', ', $post->tags->pluck('name')->toArray()) ?: 'দৈনিক ভোলা টাইমস্, ' . $post->title)
@section('og_title', $post->title)
@section('og_description', mb_substr(strip_tags($post->excerpt ?: $post->content), 0, 150) . '...')
@section('og_image', $post->featured_image_url)
@section('og_type', 'article')
 
@section('styles')
<style>
    /* Single Article Page Layout */
    .article-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 36px;
    }
 
    @media (min-width: 1024px) {
        .article-container {
            grid-template-columns: 2.3fr 1fr;
        }
    }
 
    /* Main Article Card */
    .article-card {
        background-color: var(--bg-card);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
 
    @media (min-width: 768px) {
        .article-card {
            padding: 44px;
            box-shadow: var(--shadow-md);
        }
    }
 
    /* Premium Category Badges */
    .article-cats {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }
 
    .article-cat-badge {
        background-color: rgba(227, 28, 37, 0.07);
        color: var(--accent);
        font-weight: 700;
        padding: 5px 14px;
        border-radius: var(--radius-sm);
        font-size: 0.88rem;
        transition: var(--transition);
        font-family: 'Noto Sans Bengali', sans-serif;
    }
 
    .article-cat-badge:hover {
        background-color: var(--accent);
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(227, 28, 37, 0.2);
    }
 
    /* Article Header */
    .article-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 2.3rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.4;
        margin-bottom: 24px;
        letter-spacing: -0.5px;
    }
 
    @media (max-width: 768px) {
        .article-title {
            font-size: 1.85rem;
        }
    }
 
    /* Elegant Meta Data Layout */
    .article-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 16px 24px;
        padding: 16px 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 32px;
        font-size: 0.88rem;
        color: var(--text-light);
        font-family: 'Noto Sans Bengali', sans-serif;
    }
 
    .article-meta span {
        display: flex;
        align-items: center;
        gap: 8px;
    }
 
    .article-meta i {
        color: var(--accent);
        font-size: 0.95rem;
    }
 
    .article-meta-divider {
        width: 1px;
        height: 14px;
        background-color: #cbd5e1;
        display: none;
    }
 
    @media (min-width: 640px) {
        .article-meta-divider {
            display: inline-block;
        }
    }
 
    /* Featured Image Box Showcase */
    .article-img-wrapper {
        border-radius: var(--radius-md);
        overflow: hidden;
        margin-bottom: 36px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        background-color: #f1f5f9;
        transition: var(--transition);
        position: relative;
    }
 
    .article-img-wrapper::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        box-shadow: inset 0 0 40px rgba(0, 0, 0, 0.02);
        pointer-events: none;
    }
 
    .article-img {
        width: 100%;
        height: auto;
        object-fit: cover;
        display: block;
        transition: var(--transition);
    }
 
    .article-img-wrapper:hover .article-img {
        transform: scale(1.01);
    }
 
    /* Article Body Content & Typography */
    .article-body {
        font-size: 1.22rem;
        color: var(--text-main);
        line-height: 1.95;
        font-family: 'Noto Sans Bengali', sans-serif;
        font-weight: 500;
    }
 
    .article-body p {
        margin-bottom: 26px;
        text-align: justify;
    }

    .article-body > p:first-of-type::first-letter {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 3.5rem;
        font-weight: 800;
        float: left;
        line-height: 1;
        margin-right: 10px;
        margin-top: 4px;
        color: var(--accent);
    }
 
    .article-body h2, .article-body h3, .article-body h4 {
        font-family: 'Noto Serif Bengali', serif;
        color: var(--primary);
        margin: 44px 0 20px 0;
        font-weight: 800;
        line-height: 1.4;
        position: relative;
        padding-left: 14px;
    }
 
    .article-body h2::before, .article-body h3::before {
        content: '';
        position: absolute;
        left: 0;
        top: 6px;
        bottom: 6px;
        width: 4px;
        background-color: var(--accent);
        border-radius: 2px;
    }
 
    .article-body h2 { font-size: 1.7rem; }
    .article-body h3 { font-size: 1.45rem; }
 
    .article-body img {
        max-width: 100%;
        height: auto;
        border-radius: var(--radius-md);
        margin: 32px auto;
        display: block;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }
 
    /* High-End Blockquote Quotation */
    .article-body blockquote {
        border-left: 4px solid var(--accent);
        padding: 20px 24px;
        font-style: italic;
        color: var(--text-light);
        margin: 36px 0;
        font-size: 1.25rem;
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
        border-radius: 0 var(--radius-md) var(--radius-md) 0;
        position: relative;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.02);
    }
 
    .article-body blockquote::before {
        content: "\f10d";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        top: 12px;
        right: 20px;
        font-size: 2.2rem;
        color: #e2e8f0;
        opacity: 0.8;
        pointer-events: none;
    }
 
    /* Share bar section */
    .share-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        margin-top: 48px;
        padding-top: 24px;
        border-top: 1px solid var(--border-color);
        font-family: 'Noto Sans Bengali', sans-serif;
    }
 
    .share-title {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--primary);
    }
 
    .share-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        color: #ffffff;
        font-size: 0.98rem;
        transition: var(--transition);
        cursor: pointer;
        border: none;
        outline: none;
    }
 
    .share-btn:hover {
        transform: translateY(-3px);
        opacity: 0.95;
        box-shadow: 0 4px 10px rgba(10, 17, 40, 0.15);
    }
 
    .share-fb { background-color: #1877f2; }
    .share-tw { background-color: #1da1f2; }
    .share-wa { background-color: #25d366; }
    .share-copy { 
        background-color: var(--primary); 
        color: #ffffff; 
        position: relative;
    }
    .share-copy:hover {
        background-color: var(--accent);
    }
 
    /* Tooltip styling for Copied alert */
    .copy-tooltip {
        position: absolute;
        bottom: 48px;
        background-color: #0f172a;
        color: #ffffff;
        padding: 4px 10px;
        border-radius: var(--radius-sm);
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: var(--transition);
        transform: translateY(6px);
        box-shadow: var(--shadow-md);
    }
    .copy-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: #0f172a;
    }
    .copy-tooltip.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
 
    /* Related News Section Redesign */
    .related-section {
        margin-top: 56px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
 
    .related-header {
        border-bottom: 2px solid var(--primary);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
    }
 
    .related-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary);
        margin: 0;
        position: relative;
        padding-bottom: 6px;
    }
 
    .related-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: var(--accent);
    }
 
    .related-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
 
    @media (min-width: 640px) {
        .related-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
 
    @media (min-width: 1024px) {
        .related-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
 
    /* Premium Cards for Related posts */
    .related-news-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }
 
    .related-news-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--accent);
    }
 
    .related-img-wrapper {
        position: relative;
        height: 135px;
        overflow: hidden;
        background-color: #cbd5e1;
    }
 
    .related-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
 
    .related-news-card:hover .related-card-img {
        transform: scale(1.04);
    }
 
    .related-card-content {
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
 
    .related-card-title {
        font-size: 0.94rem;
        font-weight: 700;
        line-height: 1.45;
        color: var(--text-dark);
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
 
    .related-card-title a:hover {
        color: var(--accent);
    }
 
    .related-card-meta {
        font-size: 0.78rem;
        color: var(--text-light);
        border-top: 1px solid #f1f5f9;
        padding-top: 8px;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
</style>
@endsection
 
@section('content')
 
    <!-- Reading Progress Bar -->
    <div class="reading-progress" id="readingProgress" style="width: 0%;"></div>
 
    <div class="article-container">
        <!-- Main Article Column -->
        <div>
            <article class="article-card">
                <!-- Categories -->
                <div class="article-cats">
                    @foreach($post->categories as $cat)
                        <a href="{{ route('category', $cat->slug) }}" class="article-cat-badge">{{ $cat->name }}</a>
                    @endforeach
                </div>
 
                <!-- Title -->
                <h1 class="article-title">{{ $post->title }}</h1>
 
                <!-- Meta data -->
                <div class="article-meta">
                    <span><i class="fa-solid fa-user"></i> {{ $post->user ? $post->user->name : 'অনলাইন ডেস্ক' }}</span>
                    <span class="article-meta-divider"></span>
                    <span><i class="fa-solid fa-calendar-days"></i> {{ $post->created_at->format('l, d F, Y') }}</span>
                    <span class="article-meta-divider"></span>
                    <span><i class="fa-solid fa-clock"></i> পড়ার সময়: {{ $post->read_time }} মিনিট</span>
                    <span class="article-meta-divider"></span>
                    <span><i class="fa-solid fa-eye"></i> {{ $post->views_count }} বার পঠিত</span>
                </div>
 
                <!-- Featured Image -->
                @if($post->featured_image)
                    <div class="article-img-wrapper">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="article-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=800'">
                    </div>
                @endif
 
                <!-- Article Body Content -->
                <div class="article-body">
                    {!! $post->content !!}
                </div>
 
                <!-- Sharing Toolbar -->
                <div class="share-bar">
                    <span class="share-title">শেয়ার করুন:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn share-fb" title="ফেসবুকে শেয়ার করুন">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}" target="_blank" class="share-btn share-tw" title="টুইটারে শেয়ার করুন">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}" target="_blank" class="share-btn share-wa" title="হোয়াটসঅ্যাপে শেয়ার করুন">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    
                    <!-- Copy Clipboard Widget Button -->
                    <button type="button" class="share-btn share-copy" onclick="copyArticleLink(this)" title="লিংক কপি করুন">
                        <i class="fa-solid fa-link"></i>
                        <span class="copy-tooltip" id="copyTooltip">লিংক কপি করা হয়েছে!</span>
                    </button>
                </div>
            </article>
 
            <!-- Related Posts Section -->
            @if($relatedPosts->count() > 0)
                <div class="related-section reveal">
                    <div class="related-header">
                        <h3 class="related-title">সম্পর্কিত খবর</h3>
                    </div>
                    <div class="related-grid">
                        @foreach($relatedPosts as $rPost)
                            <article class="related-news-card">
                                <div class="related-img-wrapper">
                                    <img src="{{ $rPost->featured_image_url }}" alt="{{ $rPost->title }}" class="related-card-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                                </div>
                                <div class="related-card-content">
                                    <h4 class="related-card-title">
                                        <a href="{{ route('post', $rPost->slug) }}">{{ $rPost->title }}</a>
                                    </h4>
                                    <div class="related-card-meta">
                                        <i class="fa-regular fa-clock"></i>
                                        <span>{{ $rPost->created_at->format('d M, Y') }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
 
        <!-- Sidebar Column -->
        <div>
            @include('layouts.partials.sidebar')
        </div>
    </div>
 
@endsection
 
@section('scripts')
<script>
    // Copy Article Link to Clipboard with UI feedback tooltip
    function copyArticleLink(button) {
        const link = window.location.href;
        
        navigator.clipboard.writeText(link).then(() => {
            // Find and show tooltip
            const tooltip = document.getElementById('copyTooltip');
            if (tooltip) {
                tooltip.classList.add('show');
                
                // Change icon temporarily
                const icon = button.querySelector('i');
                const originalClass = icon.className;
                icon.className = 'fa-solid fa-check';
                
                // Reset after 2 seconds
                setTimeout(() => {
                    tooltip.classList.remove('show');
                    icon.className = originalClass;
                }, 2000);
            }
        }).catch(err => {
            console.error('Failed to copy text: ', err);
            // Fallback for older browsers
            const textArea = document.createElement("textarea");
            textArea.value = link;
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                const tooltip = document.getElementById('copyTooltip');
                if (tooltip) {
                    tooltip.classList.add('show');
                    setTimeout(() => tooltip.classList.remove('show'), 2000);
                }
            } catch (err2) {
                console.error('Fallback copy failed: ', err2);
            }
            document.body.removeChild(textArea);
        });
    }

    // Reading Progress Bar
    const progressBar = document.getElementById('readingProgress');
    if (progressBar) {
        window.addEventListener('scroll', function() {
            const article = document.querySelector('.article-card');
            if (!article) return;
            const articleTop = article.offsetTop;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrolled = window.scrollY - articleTop + windowHeight * 0.3;
            const progress = Math.min(Math.max((scrolled / articleHeight) * 100, 0), 100);
            progressBar.style.width = progress + '%';
        });
    }
</script>
@endsection
