@extends('layouts.app')
 
@section('title', $category->name . ' | ক্যাটাগরি | দৈনিক ভোলা টাইমস্')
@section('meta_description', $category->description ?: $category->name . ' ক্যাটাগরির সকল খবর ও সর্বশেষ আপডেট জানুন দৈনিক ভোলা টাইমস্-এ।')
@section('og_title', $category->name . ' - দৈনিক ভোলা টাইমস্')
 
@section('styles')
<style>
    /* Category Page Grid Layout */
    .archive-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 36px;
    }
 
    @media (min-width: 1024px) {
        .archive-container {
            grid-template-columns: 2.3fr 1fr;
        }
    }
 
    /* Premium Header Showcase */
    .category-header {
        background-color: var(--primary);
        color: #ffffff;
        border-radius: var(--radius-lg);
        padding: 32px 36px;
        margin-bottom: 36px;
        position: relative;
        overflow: hidden;
        border-bottom: 4px solid var(--accent);
        box-shadow: var(--shadow-sm);
        font-family: 'Noto Sans Bengali', sans-serif;
    }
 
    .category-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 120px;
        height: 100%;
        background: linear-gradient(135deg, transparent 40%, rgba(227, 28, 37, 0.08) 100%);
        pointer-events: none;
    }

    .category-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: -200px;
        width: 100px;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
        animation: headerShimmer 4s infinite;
        pointer-events: none;
    }

    @keyframes headerShimmer {
        0% { left: -200px; }
        100% { left: 100%; }
    }
 
    .category-header-title {
        font-size: 2.1rem;
        font-weight: 800;
        margin-bottom: 10px;
        line-height: 1.3;
    }
 
    .category-header-desc {
        color: #cbd5e1;
        font-size: 0.98rem;
        max-width: 600px;
        line-height: 1.6;
        margin: 0;
        font-weight: 500;
    }
 
    /* Premium News Grid */
    .archive-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 40px;
        font-family: 'Noto Sans Bengali', sans-serif;
    }
 
    @media (min-width: 640px) {
        .archive-grid {
            grid-template-columns: repeat(2, 1fr);
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
        height: 175px;
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
        padding: 16px;
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
        margin-bottom: 12px;
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
        padding-top: 10px;
        margin-top: 4px;
    }
 
    /* Dynamic Pagination styling */
    .pagination-wrapper {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }
 
    .pagination-wrapper nav {
        background-color: #ffffff;
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }

    @media (max-width: 480px) {
        .category-header {
            padding: 20px 20px;
        }
        .category-header-title {
            font-size: 1.5rem;
        }
    }
</style>
@endsection
 
@section('content')
 
    <div class="archive-container">
        <!-- Main Archives Column -->
        <div>
            <!-- Category Header -->
            <div class="category-header">
                <h1 class="category-header-title">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="category-header-desc">{{ $category->description }}</p>
                @else
                    <p class="category-header-desc">"{{ $category->name }}" ক্যাটাগরির সমস্ত সংবাদসমূহ নিচে দেওয়া হলো।</p>
                @endif
            </div>
 
            <!-- Posts Grid -->
            @if($posts->count() > 0)
                <div class="archive-grid reveal">
                    @foreach($posts as $post)
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
                                    <span><i class="fa-regular fa-eye"></i> {{ $post->views_count }} বার পঠিত</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
 
                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="sidebar-card text-center" style="padding: 60px; font-family: 'Noto Sans Bengali', sans-serif;">
                    <i class="fa-solid fa-folder-open" style="font-size: 3rem; color: var(--text-light); margin-bottom: 16px;"></i>
                    <p style="font-size: 1.1rem; color: var(--text-light);">এই ক্যাটাগরিতে কোনো খবর পাওয়া যায়নি।</p>
                </div>
            @endif
        </div>
 
        <!-- Sidebar Column -->
        <div>
            @include('layouts.partials.sidebar')
        </div>
    </div>
 
@endsection
