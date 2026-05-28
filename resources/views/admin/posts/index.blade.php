@extends('layouts.admin')

@section('title', 'সকল সংবাদ | অ্যাডমিন প্যানেল')
@section('header_title', 'সকল সংবাদ')

@section('content')

    <div class="admin-card">
        <div class="card-header-wrapper">
            <h3 class="card-title">
                <i class="fa-solid fa-newspaper"></i>
                <span>সংবাদ তালিকা (মোট: {{ $posts->total() }}টি)</span>
            </h3>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i>
                <span>নতুন সংবাদ লিখুন</span>
            </a>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">আইডি</th>
                        <th>শিরোনাম</th>
                        <th>ক্যাটাগরি</th>
                        <th>অবস্থা</th>
                        <th>ভিউস</th>
                        <th>তারিখ</th>
                        <th style="width: 140px;">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td style="font-family: 'Outfit', sans-serif; font-weight: 600; color: var(--text-sub);">
                                {{ $post->id }}
                            </td>
                            <td style="font-weight: 600; max-width: 320px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                {{ $post->title }}
                            </td>
                            <td>
                                @forelse($post->categories as $cat)
                                    <span class="badge badge-success" style="margin-right: 4px;">{{ $cat->name }}</span>
                                @empty
                                    <span class="badge badge-warning">নাই</span>
                                @endforelse
                            </td>
                            <td>
                                @if($post->status === 'publish')
                                    <span class="badge badge-success"><i class="fa-solid fa-circle-check"></i> প্রকাশিত</span>
                                @else
                                    <span class="badge badge-warning"><i class="fa-solid fa-circle-pause"></i> ড্রাফট</span>
                                @endif
                            </td>
                            <td style="font-family: 'Outfit', sans-serif; font-weight: 600;">
                                {{ number_format($post->views_count) }}
                            </td>
                            <td>
                                {{ $post->created_at->format('d M, Y') }}
                            </td>
                            <td>
                                <div class="action-flex">
                                    <a href="{{ route('post', $post->slug) }}" target="_blank" class="action-btn action-view" title="অনলাইন ভিউ"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="action-btn action-edit" title="সম্পাদনা"><i class="fa-solid fa-pen"></i></a>
                                    
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে সংবাদটি মুছে ফেলতে চান?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn action-delete" title="মুছে ফেলুন"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 48px; color: var(--text-sub);">
                                <i class="fa-solid fa-circle-info" style="font-size: 2rem; margin-bottom: 12px; display: block;"></i>
                                কোনো সংবাদ পাওয়া যায়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $posts->links() }}
        </div>
    </div>

@endsection
