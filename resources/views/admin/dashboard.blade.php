@extends('layouts.admin')

@section('title', 'ড্যাশবোর্ড | অ্যাডমিন প্যানেল | দৈনিক ভোলা টাইমস্')
@section('header_title', 'ড্যাশবোর্ড')

@section('styles')
<style>
    /* Stats Grid Layout */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    @media (min-width: 640px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .stat-card {
        background-color: var(--content-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        border-color: var(--accent);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5rem;
        color: #ffffff;
    }

    .stat-icon-posts { background-color: rgba(220, 38, 38, 0.15); color: var(--accent); }
    .stat-icon-views { background-color: rgba(16, 185, 129, 0.15); color: var(--success); }
    .stat-icon-cats { background-color: rgba(245, 158, 11, 0.15); color: var(--warning); }
    .stat-icon-tags { background-color: rgba(59, 130, 246, 0.15); color: #3b82f6; }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-value {
        font-family: 'Outfit', sans-serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.88rem;
        color: var(--text-sub);
        font-weight: 600;
    }

    /* Dashboard Layout Splits */
    .dashboard-splits {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }

    @media (min-width: 1024px) {
        .dashboard-splits {
            grid-template-columns: 2fr 1fr;
        }
    }

    /* Category breakdown styling list */
    .breakdown-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .breakdown-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border-color);
    }

    .breakdown-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .breakdown-name {
        font-weight: 600;
        font-size: 0.95rem;
    }

    .breakdown-count {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 0.85rem;
    }
</style>
@endsection

@section('content')

    <!-- Metrics Statistics Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-posts"><i class="fa-solid fa-newspaper"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalPosts) }}</span>
                <span class="stat-label">মোট সংবাদ পোস্ট</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-views"><i class="fa-solid fa-eye"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalViews) }}</span>
                <span class="stat-label">সর্বমোট ভিউ সংখ্যা</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-cats"><i class="fa-solid fa-folder-open"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalCategories) }}</span>
                <span class="stat-label">মোট ক্যাটাগরি</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-tags"><i class="fa-solid fa-tags"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ number_format($totalTags) }}</span>
                <span class="stat-label">সংবাদ ট্যাগসমূহ</span>
            </div>
        </div>
    </div>

    <!-- Dashboard Splits -->
    <div class="dashboard-splits">
        <!-- Recent Posts Section -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>সাম্প্রতিক প্রকাশিত সংবাদ</span>
                </h3>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">সব দেখুন</a>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>শিরোনাম</th>
                            <th>ক্যাটাগরি</th>
                            <th>তারিখ</th>
                            <th>ভিউস</th>
                            <th>অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPosts as $post)
                            <tr>
                                <td style="font-weight: 600; max-width: 250px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                    {{ $post->title }}
                                </td>
                                <td>
                                    @if($post->categories->first())
                                        <span class="badge badge-success">{{ $post->categories->first()->name }}</span>
                                    @else
                                        <span class="badge badge-warning">নাই</span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('d M, Y') }}</td>
                                <td style="font-family: 'Outfit', sans-serif; font-weight: 600;">{{ $post->views_count }}</td>
                                <td>
                                    <div class="action-flex">
                                        <a href="{{ route('post', $post->slug) }}" target="_blank" class="action-btn action-view" title="ভিজিট পোস্ট"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="action-btn action-edit" title="সম্পাদনা"><i class="fa-solid fa-pen"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 32px; color: var(--text-sub);">
                                    কোনো সংবাদ পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="admin-card">
            <div class="card-header-wrapper">
                <h3 class="card-title">
                    <i class="fa-solid fa-folder-tree"></i>
                    <span>শীর্ষ ৫ ক্যাটাগরি</span>
                </h3>
            </div>

            <ul class="breakdown-list">
                @forelse($categoriesBreakdown as $cat)
                    <li class="breakdown-item">
                        <span class="breakdown-name">{{ $cat->name }}</span>
                        <span class="badge badge-success breakdown-count">{{ $cat->posts_count }}টি পোস্ট</span>
                    </li>
                @empty
                    <li style="color: var(--text-sub); text-align: center;">কোনো তথ্য পাওয়া যায়নি।</li>
                @endforelse
            </ul>
        </div>
    </div>

@endsection
