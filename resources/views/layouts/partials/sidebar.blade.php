@php
    if (!isset($popularPosts) || $popularPosts->isEmpty()) {
        $popularPosts = \App\Models\Post::where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(5)
            ->get();
    }
@endphp

<div class="sidebar-sticky" style="position: sticky; top: 76px;">
    <!-- Popular Posts Sidebar Widget -->
    @if($popularPosts->count() > 0)
        <div class="sidebar-card">
            <h3 class="sidebar-title">জনপ্রিয় সংবাদ</h3>
            <ul class="sidebar-popular-list">
                @foreach($popularPosts as $index => $pPost)
                    <li class="sidebar-popular-item">
                        <div class="sidebar-popular-img-box">
                            <img src="{{ $pPost->featured_image_url }}" alt="{{ $pPost->title }}" class="sidebar-popular-img" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=120'">
                        </div>
                        <h4 class="sidebar-popular-title">
                            <a href="{{ route('post', $pPost->slug) }}">{{ $pPost->title }}</a>
                        </h4>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Sidebar advertisements -->
    <div class="homepage-ad-banner mb-4">
        <span class="homepage-ad-label">বিজ্ঞাপন</span>
        <div class="homepage-ad-box-300">
            <i class="fa-solid fa-rectangle-ad text-muted" style="font-size: 2.2rem;"></i>
            <span>Square Banner Ad (300x250)</span>
        </div>
    </div>

    <div class="homepage-ad-banner">
        <span class="homepage-ad-label">বিজ্ঞাপন</span>
        <div class="homepage-ad-box-300" style="height: 400px;">
            <i class="fa-solid fa-rectangle-ad text-muted" style="font-size: 2.2rem;"></i>
            <span>Half Page Ad slot (300x600)</span>
        </div>
    </div>
</div>
