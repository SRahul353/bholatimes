@extends('layouts.admin')

@section('title', 'ক্যাটাগরি সমূহ | অ্যাডমিন প্যানেল')
@section('header_title', 'ক্যাটাগরি সমূহ')

@section('styles')
<style>
    .cat-split {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }

    @media (min-width: 1024px) {
        .cat-split {
            grid-template-columns: 1.8fr 1fr;
        }
    }
</style>
@endsection

@section('content')

    <div class="cat-split">
        <!-- Left Table List Column -->
        <div class="admin-card">
            <h3 class="card-title" style="margin-bottom: 20px;">
                <i class="fa-solid fa-folder-tree"></i>
                <span>ক্যাটাগরি তালিকা (মোট: {{ count($categories) }}টি)</span>
            </h3>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>নাম</th>
                            <th>স্লাগ</th>
                            <th>পোস্ট সংখ্যা</th>
                            <th style="width: 80px;">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                            <tr>
                                <td style="font-weight: 600;">{{ $cat->name }}</td>
                                <td style="font-family: 'Outfit', sans-serif; font-size: 0.85rem; color: var(--text-sub);">
                                    {{ $cat->slug }}
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $cat->posts_count }}টি পোস্ট</span>
                                </td>
                                <td>
                                    <div class="action-flex">
                                        <a href="{{ route('category', $cat->slug) }}" target="_blank" class="action-btn action-view" title="ভিজিট ক্যাটাগরি"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                        
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে ক্যাটাগরিটি মুছে ফেলতে চান? এর অধীনস্থ পোস্টগুলো মুছে যাবে না, শুধু ক্যাটাগরি সম্পর্ক বিচ্ছিন্ন হবে।');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn action-delete" title="মুছে ফেলুন"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 32px; color: var(--text-sub);">
                                    কোনো ক্যাটাগরি পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Add Form Column -->
        <div class="admin-card" style="height: fit-content;">
            <h3 class="card-title" style="margin-bottom: 20px;">
                <i class="fa-solid fa-folder-plus"></i>
                <span>নতুন ক্যাটাগরি তৈরি</span>
            </h3>

            @if($errors->any())
                <div class="alert alert-danger" style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 10px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 20px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">ক্যাটাগরির নাম</label>
                    <input type="text" name="name" id="name" required placeholder="যেমন: বিনোদন, খেলাধুলা..." class="form-control">
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">সংক্ষিপ্ত বিবরণ (ঐচ্ছিক)</label>
                    <textarea name="description" id="description" rows="4" placeholder="ক্যাটাগরি সম্পর্কিত সংক্ষিপ্ত বিবরণ..." class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>ক্যাটাগরি সেভ করুন</span>
                </button>
            </form>
        </div>
    </div>

@endsection
