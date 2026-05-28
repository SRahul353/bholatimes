@extends('layouts.app')

@section('title', 'দৈনিক ভোলা টাইমস্ | Dainik Bhola Times - সত্যের সন্ধানে সার্বক্ষণিক')

@section('styles')
<style>
    /* Hero Grid Setup */
    .hero-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 36px;
    }
    @media (min-width: 768px) {
        .hero-grid {
            grid-template-columns: 1.5fr 1fr;
        }
    }
    @media (min-width: 1024px) {
        .hero-grid {
            grid-template-columns: 2fr 1fr 1fr;
        }
    }

    /* Lead News Card */
    .lead-news-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: var(--transition);
        position: relative;
        box-shadow: var(--shadow-sm);
    }
    .lead-news-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }
    .lead-image-box {
        position: relative;
        width: 100%;
        height: 340px;
        overflow: hidden;
        background-color: #cbd5e1;
    }
    .lead-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    .lead-news-card:hover .lead-image {
        transform: scale(1.03);
    }
    .lead-category-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background-color: var(--accent);
        color: #ffffff;
        padding: 4px 10px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-size: 0.85rem;
        z-index: 10;
        box-shadow: 0 4px 8px rgba(227, 28, 37, 0.3);
    }
    .lead-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .lead-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.7rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 10px;
        line-height: 1.35;
    }
    .lead-title a:hover {
        color: var(--accent);
    }
    .lead-excerpt {
        color: var(--text-main);
        font-size: 0.95rem;
        margin-bottom: 16px;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .lead-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 0.82rem;
        color: var(--text-light);
        border-top: 1px solid var(--border-color);
        padding-top: 12px;
    }
    .lead-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Side Lead Columns */
    .column-header {
        border-bottom: 2px solid var(--primary);
        margin-bottom: 16px;
        padding-bottom: 6px;
        display: flex;
        align-items: center;
    }
    .column-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary);
        margin: 0;
        position: relative;
        padding-bottom: 6px;
    }
    .column-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 45px;
        height: 2px;
        background-color: var(--accent);
    }
    .side-lead-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        height: 100%;
    }
    .side-lead-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 10px;
        display: flex;
        gap: 12px;
        align-items: center;
        transition: var(--transition);
        flex: 1;
    }
    .side-lead-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(227, 28, 37, 0.06);
        border-color: var(--accent);
    }
    .side-lead-img-box {
        width: 100px;
        height: 76px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        flex-shrink: 0;
        background-color: #f3f4f6;
    }
    .side-lead-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    .side-lead-card:hover .side-lead-img {
        transform: scale(1.06);
    }
    .side-lead-content {
        flex-grow: 1;
        min-width: 0;
    }
    .side-lead-title {
        font-size: 0.94rem;
        font-weight: 700;
        line-height: 1.45;
        color: var(--text-dark);
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .side-lead-title a:hover {
        color: var(--accent);
    }
    .side-lead-time {
        font-size: 0.78rem;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Tabbed Widget */
    .tabbed-widget {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: var(--shadow-sm);
    }
    .widget-tabs {
        display: flex;
        border-bottom: 2px solid var(--border-color);
    }
    .widget-tab {
        flex: 1;
        background: #f8fafc;
        border: none;
        padding: 12px 0;
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--text-light);
        cursor: pointer;
        transition: var(--transition);
        font-family: 'Noto Sans Bengali', sans-serif;
        position: relative;
    }
    .widget-tab.active {
        background-color: #ffffff;
        color: var(--accent);
    }
    .widget-tab::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: transparent;
        transition: var(--transition);
    }
    .widget-tab.active::after {
        background-color: var(--accent);
    }
    .widget-content-pane {
        padding: 16px;
        display: none;
        max-height: 440px;
        overflow-y: auto;
    }
    .widget-content-pane.active {
        display: block;
    }
    .widget-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 14px;
        padding: 0;
        margin: 0;
    }
    .widget-item {
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 12px;
        transition: var(--transition);
    }
    .widget-item:hover {
        transform: translateX(3px);
    }
    .widget-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .widget-img-box {
        width: 80px;
        height: 58px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        flex-shrink: 0;
        background-color: #f1f5f9;
    }
    .widget-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    .widget-item:hover .widget-img-box img {
        transform: scale(1.08);
    }
    .widget-item-title {
        font-size: 0.92rem;
        font-weight: 700;
        line-height: 1.45;
        color: var(--text-main);
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .widget-item-title a:hover {
        color: var(--accent);
    }

    /* Custom Scrollbar for widget content */
    .widget-content-pane::-webkit-scrollbar {
        width: 4px;
    }
    .widget-content-pane::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 2px;
    }
    .widget-content-pane::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 2px;
    }
    .widget-content-pane::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* "সারাদেশ" (District News) Section */
    .district-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 24px;
        margin-bottom: 36px;
        box-shadow: var(--shadow-sm);
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .district-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }
    .district-header i {
        color: var(--accent);
        font-size: 1.4rem;
    }
    .district-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--primary);
        margin: 0;
    }
    .district-selector-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }
    @media (min-width: 640px) {
        .district-selector-row {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    .district-select {
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: var(--radius-sm);
        font-size: 0.92rem;
        color: var(--text-main);
        outline: none;
        background-color: #ffffff;
        font-family: inherit;
        font-weight: 600;
    }
    .district-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(227, 28, 37, 0.1);
    }
    .district-btn {
        background-color: var(--accent);
        color: #ffffff;
        border: none;
        border-radius: var(--radius-sm);
        padding: 8px 16px;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        font-family: inherit;
    }
    .district-btn:hover {
        background-color: var(--accent-hover);
        box-shadow: 0 4px 10px rgba(227, 28, 37, 0.2);
    }
    .district-quick-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 16px;
        font-size: 0.85rem;
        align-items: center;
    }
    .district-quick-label {
        font-weight: 700;
        color: var(--text-light);
    }
    .district-quick-link {
        background-color: #e2e8f0;
        color: var(--text-main);
        padding: 3px 12px;
        border-radius: 20px;
        font-weight: 600;
        transition: var(--transition);
    }
    .district-quick-link:hover {
        background-color: var(--accent);
        color: #ffffff;
    }

    /* Advertisements placeholders styling */
    .homepage-ad-banner {
        margin: 12px auto 36px auto;
        text-align: center;
    }
    .homepage-ad-label {
        font-size: 0.65rem;
        color: var(--text-light);
        text-transform: uppercase;
        margin-bottom: 4px;
        letter-spacing: 1px;
        display: block;
        font-weight: 600;
    }
    .homepage-ad-box-728 {
        width: 100%;
        max-width: 728px;
        height: 90px;
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        color: #94a3b8;
        font-size: 0.8rem;
        font-family: 'Outfit', sans-serif;
        font-weight: 500;
        transition: var(--transition);
    }
    .homepage-ad-box-728:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
    }
    .homepage-ad-box-300 {
        width: 300px;
        height: 250px;
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-md);
        color: #94a3b8;
        font-size: 0.82rem;
        font-family: 'Outfit', sans-serif;
        font-weight: 500;
        gap: 6px;
        transition: var(--transition);
    }
    .homepage-ad-box-300:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
    }

    /* Categorized Section title wrapper */
    .section-title-wrapper {
        border-bottom: 2px solid var(--primary);
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-bottom: 4px;
    }
    .sec-title {
        font-family: 'Noto Serif Bengali', serif;
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--primary);
        margin: 0;
        position: relative;
        padding-bottom: 4px;
    }
    .sec-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 60px;
        height: 2px;
        background-color: var(--accent);
    }
    .sec-more-link {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--accent);
    }
    .sec-more-link:hover {
        color: var(--primary);
    }

    /* alternate layout structures */
    .grid-alternate-4 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    @media (min-width: 640px) {
        .grid-alternate-4 {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 1024px) {
        .grid-alternate-4 {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .news-grid-card {
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
    .news-grid-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--accent);
    }
    .news-grid-img-box {
        position: relative;
        height: 168px;
        overflow: hidden;
        background-color: #cbd5e1;
    }
    .news-grid-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    .news-grid-card:hover .news-grid-img {
        transform: scale(1.04);
    }
    .news-grid-content {
        padding: 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
    .news-grid-title {
        font-size: 0.98rem;
        font-weight: 700;
        line-height: 1.45;
        color: var(--text-dark);
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .news-grid-title a:hover {
        color: var(--accent);
    }
    .news-grid-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.78rem;
        color: var(--text-light);
        border-top: 1px solid #f1f5f9;
        padding-top: 8px;
        margin-top: 8px;
    }

    /* alternate 1+3 Grid layout */
    .alternate-split-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    @media (min-width: 992px) {
        .alternate-split-grid {
            grid-template-columns: 1.2fr 1fr;
        }
    }
    .alternate-split-left {
        height: 100%;
    }
    .alternate-split-right {
        display: flex;
        flex-direction: column;
        gap: 12px;
        justify-content: space-between;
    }
    .split-horizontal-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 12px;
        display: flex;
        gap: 12px;
        align-items: center;
        transition: var(--transition);
        flex-grow: 1;
        box-shadow: var(--shadow-sm);
        min-width: 0;
    }
    .split-horizontal-card:hover {
        border-color: var(--accent);
        box-shadow: var(--shadow-md);
        transform: translateX(3px);
    }

    /* Multimedia Section - Sleek dark setup */
    .multimedia-section {
        background-color: #0b1120;
        padding: 32px;
        margin: 36px 0;
        border-radius: var(--radius-lg);
        border: 1px solid rgba(255, 255, 255, 0.05);
        position: relative;
        overflow: hidden;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
    .multimedia-title-wrapper {
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-bottom: 6px;
    }
    .multimedia-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
        position: relative;
    }
    .multimedia-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 2px;
        background-color: var(--accent);
    }
    .multimedia-more {
        color: var(--accent);
        font-size: 0.85rem;
        font-weight: 700;
    }
    .multimedia-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    @media (min-width: 640px) {
        .multimedia-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 1024px) {
        .multimedia-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    .multimedia-card {
        background-color: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-md);
        overflow: hidden;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .multimedia-card:hover {
        transform: translateY(-4px);
        background-color: rgba(255, 255, 255, 0.06);
        border-color: var(--accent);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
    }
    .multimedia-img-box {
        position: relative;
        height: 160px;
        overflow: hidden;
        background-color: #000000;
    }
    .multimedia-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
        opacity: 0.85;
    }
    .multimedia-card:hover .multimedia-img {
        transform: scale(1.05);
        opacity: 0.95;
    }
    .multimedia-play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 44px;
        height: 44px;
        background-color: var(--accent);
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(227, 28, 37, 0.4);
        transition: var(--transition);
        padding-left: 3px; /* visual alignment of play arrow */
    }
    .multimedia-card:hover .multimedia-play-btn {
        background-color: #ffffff;
        color: var(--accent);
        transform: translate(-50%, -50%) scale(1.1);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.4);
    }
    .multimedia-content {
        padding: 14px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .multimedia-card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #cbd5e1;
        line-height: 1.45;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .multimedia-card-title a:hover {
        color: var(--accent);
    }
</style>
@endsection

@section('content')

    <!-- Dhaka Post Signature Hero Grid (Lead, Side Leads & Tabbed News) -->
    <div class="hero-grid">
        <!-- Lead News Column -->
        <div>
            @if($leadPost)
                <article class="lead-news-card">
                    <span class="lead-category-badge">
                        {{ $leadPost->categories->first() ? $leadPost->categories->first()->name : 'মূল খবর' }}
                    </span>
                    <div class="lead-image-box">
                        <img src="{{ $leadPost->featured_image_url }}" alt="{{ $leadPost->title }}" class="lead-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=800'">
                    </div>
                    <div class="lead-content">
                        <div>
                            <h2 class="lead-title">
                                <a href="{{ route('post', $leadPost->slug) }}">{{ $leadPost->title }}</a>
                            </h2>
                            <p class="lead-excerpt">
                                {!! Str::limit(strip_tags($leadPost->content), 240) !!}
                            </p>
                        </div>
                        <div class="lead-meta">
                            <span><i class="fa-solid fa-user"></i> {{ $leadPost->user ? $leadPost->user->name : 'সম্পাদক' }}</span>
                            <span><i class="fa-regular fa-calendar-days"></i> {{ $leadPost->created_at->format('d M, Y') }}</span>
                            <span><i class="fa-regular fa-eye"></i> {{ $leadPost->views_count }} বার পঠিত</span>
                        </div>
                    </div>
                </article>
            @else
                <div class="sidebar-card text-center" style="padding: 60px;">
                    <i class="fa-solid fa-newspaper" style="font-size: 3rem; color: var(--text-light); margin-bottom: 16px;"></i>
                    <p>কোন সংবাদ পাওয়া যায়নি।</p>
                </div>
            @endif
        </div>

        <!-- Side Leads Column (Older Lead News) -->
        <div>
            <div class="side-lead-container">
                @forelse($subLeadPosts as $post)
                    <article class="side-lead-card">
                        <div class="side-lead-img-box">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="side-lead-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=200'">
                        </div>
                        <div class="side-lead-content">
                            <h4 class="side-lead-title">
                                <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                            </h4>
                            <div class="side-lead-time">
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="text-muted p-3 text-center">কোন খবর পাওয়া যায়নি।</p>
                @endforelse
            </div>
        </div>

        <!-- Tabbed Widget Column (Latest / Popular) -->
        <div>
            <div class="tabbed-widget">
                <div class="widget-tabs">
                    <button class="widget-tab active" onclick="switchWidgetTab(event, 'widget-latest')">সর্বশেষ</button>
                    <button class="widget-tab" onclick="switchWidgetTab(event, 'widget-popular')">পঠিত</button>
                </div>
                <!-- Latest News Tab -->
                <div id="widget-latest" class="widget-content-pane active">
                    <ul class="widget-list">
                        @forelse($latestPosts->take(7) as $index => $post)
                            <li class="widget-item">
                                <div class="widget-img-box">
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="widget-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=120'">
                                </div>
                                <h5 class="widget-item-title">
                                    <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                </h5>
                            </li>
                        @empty
                            <p class="text-muted p-2">কোনো খবর পাওয়া যায়নি।</p>
                        @endforelse
                    </ul>
                </div>
                <!-- Popular News Tab -->
                <div id="widget-popular" class="widget-content-pane">
                    <ul class="widget-list">
                        @forelse($popularPosts->take(7) as $index => $post)
                            <li class="widget-item">
                                <div class="widget-img-box">
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="widget-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=120'">
                                </div>
                                <h5 class="widget-item-title">
                                    <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                </h5>
                            </li>
                        @empty
                            <p class="text-muted p-2">কোনো খবর পাওয়া যায়নি।</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bhola District News Block -->
    <div class="district-card">
        <div class="district-header">
            <i class="fa-solid fa-map-location-dot"></i>
            <h3 class="district-title">ভোলা জেলার সংবাদ</h3>
        </div>
        <div class="district-selector-row">
            <select class="district-select" id="upazilaSelect" onchange="loadUnions()">
                <option value="">উপজেলা নির্বাচন করুন</option>
                <option value="ভোলা সদর">ভোলা সদর</option>
                <option value="চরফ্যাশন">চরফ্যাশন</option>
                <option value="লালমোহন">লালমোহন</option>
                <option value="বোরহানউদ্দিন">বোরহানউদ্দিন</option>
                <option value="তজুমদ্দিন">তজুমদ্দিন</option>
                <option value="দৌলতখান">দৌলতখান</option>
                <option value="মনপুরা">মনপুরা</option>
            </select>
            <select class="district-select" id="unionSelect" disabled>
                <option value="">ইউনিয়ন নির্বাচন করুন</option>
            </select>
            <button class="district-btn" onclick="searchBholaNews()"><i class="fa-solid fa-magnifying-glass me-1"></i>খুঁজুন</button>
        </div>
        <div class="district-quick-links">
            <span class="district-quick-label">জনপ্রিয় উপজেলা:</span>
            <a href="#" class="district-quick-link" onclick="selectQuickUpazila('ভোলা সদর')">ভোলা সদর</a>
            <a href="#" class="district-quick-link" onclick="selectQuickUpazila('চরফ্যাশন')">চরফ্যাশন</a>
            <a href="#" class="district-quick-link" onclick="selectQuickUpazila('লালমোহন')">লালমোহন</a>
            <a href="#" class="district-quick-link" onclick="selectQuickUpazila('তজুমদ্দিন')">তজুমদ্দিন</a>
            <a href="#" class="district-quick-link" onclick="selectQuickUpazila('বোরহানউদ্দিন')">বোরহানউদ্দিন</a>
            <a href="#" class="district-quick-link" onclick="selectQuickUpazila('মনপুরা')">মনপুরা</a>
            <a href="#" class="district-quick-link" onclick="selectQuickUpazila('দৌলতখান')">দৌলতখান</a>
        </div>
    </div>

    <!-- Horizontal Leaderboard Ad slot -->
    <div class="homepage-ad-banner">
        <span class="homepage-ad-label">বিজ্ঞাপন</span>
        <div class="homepage-ad-box-728">
            <span>Responsive Leaderboard Ad Banner slot (728x90)</span>
        </div>
    </div>

    <!-- Categorized Blocks Alternating Grid Layouts (1+3 and 4-Column Grid) -->
    <div class="row">
        <!-- Main news stream -->
        <div class="col-lg-9">
            @foreach($categoriesWithPosts as $cat)
                @if($cat->posts->count() > 0)
                    <section class="mb-5">
                        <div class="section-title-wrapper">
                            <h3 class="sec-title">{{ $cat->name }}</h3>
                            <a href="{{ route('category', $cat->slug) }}" class="sec-more-link">আরও খবর <i class="fa-solid fa-angle-right"></i></a>
                        </div>
                        
                        @if($loop->index % 2 == 0)
                            <!-- 1+3 Grid Layout -->
                            <div class="alternate-split-grid">
                                <div class="alternate-split-left">
                                    @php $firstPost = $cat->posts->first(); @endphp
                                    @if($firstPost)
                                        <article class="lead-news-card">
                                            <div class="lead-image-box" style="height: 250px;">
                                                <img src="{{ $firstPost->featured_image_url }}" alt="{{ $firstPost->title }}" class="lead-image" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                                            </div>
                                            <div class="lead-content">
                                                <h4 class="lead-title" style="font-size: 1.3rem;">
                                                    <a href="{{ route('post', $firstPost->slug) }}">{{ $firstPost->title }}</a>
                                                </h4>
                                                <p class="lead-excerpt" style="-webkit-line-clamp: 2;">
                                                    {!! Str::limit(strip_tags($firstPost->content), 140) !!}
                                                </p>
                                                <div class="lead-meta">
                                                    <span><i class="fa-regular fa-clock"></i> {{ $firstPost->created_at->format('d M, Y') }}</span>
                                                    <span><i class="fa-regular fa-eye"></i> {{ $firstPost->views_count }} বার পঠিত</span>
                                                </div>
                                            </div>
                                        </article>
                                    @endif
                                </div>
                                
                                <div class="alternate-split-right">
                                    @foreach($cat->posts->skip(1)->take(3) as $post)
                                        <article class="split-horizontal-card">
                                            <div class="side-lead-img-box">
                                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="side-lead-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=200'">
                                            </div>
                                            <div class="side-lead-content">
                                                <h4 class="side-lead-title" style="font-size: 0.92rem;">
                                                    <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                                </h4>
                                                <div class="side-lead-time">
                                                    <i class="fa-regular fa-clock"></i>
                                                    <span>{{ $post->created_at->format('d M, Y') }}</span>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Modern 4-Column Card Grid Layout -->
                            <div class="grid-alternate-4">
                                @foreach($cat->posts->take(4) as $post)
                                    <article class="news-grid-card">
                                        <div class="news-grid-img-box">
                                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="news-grid-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                                        </div>
                                        <div class="news-grid-content">
                                            <h4 class="news-grid-title">
                                                <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                            </h4>
                                            <div class="news-grid-meta">
                                                <span><i class="fa-regular fa-clock"></i> {{ $post->created_at->format('d M, Y') }}</span>
                                                <span><i class="fa-regular fa-eye"></i> {{ $post->views_count }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </section>
                @endif
            @endforeach
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-3">
            @include('layouts.partials.sidebar')
        </div>
    </div>

    <!-- Multimedia Video and Photo Gallery Showcase (Premium Dark Theme Container) -->
    <div class="multimedia-section container-fluid">
        <div class="multimedia-title-wrapper">
            <h3 class="multimedia-title"><i class="fa-solid fa-circle-play me-2 text-danger"></i>ভিডিও ও ছবি</h3>
            <a href="#" class="multimedia-more">আরও ভিডিও <i class="fa-solid fa-angle-right"></i></a>
        </div>
        <div class="multimedia-grid">
            @forelse($popularPosts->take(4) as $post)
                <article class="multimedia-card">
                    <div class="multimedia-img-box">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="multimedia-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=400'">
                        <span class="multimedia-play-btn"><i class="fa-solid fa-play"></i></span>
                    </div>
                    <div class="multimedia-content">
                        <h4 class="multimedia-card-title">
                            <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                        </h4>
                    </div>
                </article>
            @empty
                <p class="text-white-50 text-center py-4">কোন মাল্টিমিডিয়া কন্টেন্ট পাওয়া যায়নি।</p>
            @endforelse
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Tab switching logic for Latest/Popular news widget
    function switchWidgetTab(event, tabId) {
        // Prevent default button behavior
        event.preventDefault();
        
        // Find the widget container
        const widget = event.currentTarget.closest('.tabbed-widget');
        
        // Deactivate all tabs and tab content panes inside this widget
        const tabs = widget.querySelectorAll('.widget-tab');
        const panes = widget.querySelectorAll('.widget-content-pane');
        
        tabs.forEach(tab => tab.classList.remove('active'));
        panes.forEach(pane => pane.classList.remove('active'));
        
        // Activate current tab and content pane
        event.currentTarget.classList.add('active');
        widget.querySelector(`#${tabId}`).classList.add('active');
    }

    // Bhola district Upazilas and Unions data map
    const upazilaUnions = {
        "ভোলা সদর": ["পূর্ব ইলিশা", "পশ্চিম ইলিশা", "বাপ্তা", "ধনিয়া", "আলীনগর", "চরসামাইয়া", "ভেদুরিয়া", "চরশিবলি", "রাজাপুর", "উত্তর দিঘলদী", "দক্ষিণ দিঘলদী", "কাচিয়া", "শিবপুর"],
        "চরফ্যাশন": ["ওসমানগঞ্জ", "আসলামপুর", "জিন্নাহগড়", "আমিনাবাদ", "চরমাদ্রাজ", "চরকলমি", "হাজারীগঞ্জ", "এওয়াজপুর", "জাহানপুর", "নীলকমল", "নূরাবাদ", "কুকরী মুকরী", "ঢালচর", "মজিবনগর"],
        "লালমোহন": ["কালমা", "চরভূতা", "লর্ড হার্ডিঞ্জ", "ধলীগৌরনগর", "বদরপুর", "লালমোহন", "চর উমেদ"],
        "বোরহানউদ্দিন": ["গঙ্গাপুর", "সাচড়া", "দেউলা", "টবগী", "পক্ষিয়া", "বড় মানিকা", "কুতুবা", "কাচিয়া", "হাসাননগর"],
        "তজুমদ্দিন": ["বড় মলংচড়া", "সোনাপুর", "চাঁদপুর", "চাচড়া", "শম্ভুপুর"],
        "দৌলতখান": ["মদনপুর", "মেদুয়া", "চরপাতা", "উত্তর জয়নগর", "দক্ষিণ জয়নগর", "চরখলিফা", "সৈয়দপুর", "ভবানীপুর", "হাজিপুর"],
        "মনপুরা": ["মনপুরা", "হাজিরহাট", "উত্তর সাকুচিয়া", "দক্ষিণ সাকুচিয়া"]
    };

    function loadUnions() {
        const upazilaSelect = document.getElementById('upazilaSelect');
        const unionSelect = document.getElementById('unionSelect');
        const selectedUpazila = upazilaSelect.value;

        // Clear existing choices
        unionSelect.innerHTML = '<option value="">ইউনিয়ন নির্বাচন করুন</option>';

        if (selectedUpazila && upazilaUnions[selectedUpazila]) {
            unionSelect.disabled = false;
            upazilaUnions[selectedUpazila].forEach(union => {
                const option = document.createElement('option');
                option.value = union;
                option.textContent = union;
                unionSelect.appendChild(option);
            });
        } else {
            unionSelect.disabled = true;
        }
    }

    function searchBholaNews() {
        const unionSelect = document.getElementById('unionSelect');
        const union = unionSelect.value;
        if (union) {
            window.location.href = `{{ route('search') }}?query=${encodeURIComponent(union)}`;
        } else {
            const upazilaSelect = document.getElementById('upazilaSelect');
            const upazila = upazilaSelect.value;
            if (upazila) {
                window.location.href = `{{ route('search') }}?query=${encodeURIComponent(upazila)}`;
            } else {
                alert('অনুগ্রহ করে উপজেলা বা ইউনিয়ন নির্বাচন করুন।');
            }
        }
    }

    function selectQuickUpazila(upazilaName) {
        window.location.href = `{{ route('search') }}?query=${encodeURIComponent(upazilaName)}`;
    }
</script>
@endsection