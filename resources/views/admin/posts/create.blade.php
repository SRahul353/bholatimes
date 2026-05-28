@extends('layouts.admin')

@section('title', 'নতুন সংবাদ লিখুন | অ্যাডমিন প্যানেল')
@section('header_title', 'নতুন সংবাদ লিখুন')

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
        border: 2px dashed var(--border-color);
        border-radius: var(--radius-sm);
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        margin-bottom: 12px;
        position: relative;
        background-color: rgba(0, 0, 0, 0.1);
    }

    .image-preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
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

    /* Premium CKEditor Custom Styles */
    .ck-editor__editable_inline {
        min-height: 400px;
        background-color: #ffffff !important;
        color: var(--text-dark) !important;
        border: 1px solid var(--border-color) !important;
        font-family: inherit !important;
    }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        border-color: var(--border-color) !important;
    }
    .ck.ck-editor__main>.ck-editor__editable.ck-focused {
        border-color: var(--accent) !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15) !important;
    }
    .ck.ck-toolbar {
        background-color: #f8fafc !important;
        border-color: var(--border-color) !important;
    }
    .ck.ck-button {
        color: var(--text-main) !important;
        cursor: pointer !important;
    }
    .ck.ck-button:hover {
        background-color: #f1f5f9 !important;
        color: var(--text-dark) !important;
    }
    .ck.ck-button.ck-on {
        background-color: #e2e8f0 !important;
        color: var(--text-dark) !important;
    }
</style>
@endsection

@section('content')

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-split">
            <!-- Left main writing card -->
            <div class="admin-card">
                <h3 class="card-title" style="margin-bottom: 24px;">
                    <i class="fa-solid fa-file-signature"></i>
                    <span>সংবাদের বিবরণ</span>
                </h3>

                <!-- Title -->
                <div class="form-group">
                    <label for="title" class="form-label">শিরোনাম (Headline)</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="এখানে সংবাদের আকর্ষণীয় শিরোনাম লিখুন..." class="form-control">
                </div>

                <!-- Excerpt -->
                <div class="form-group">
                    <label for="excerpt" class="form-label">সারসংক্ষেপ (Excerpt - সংক্ষিপ্ত বিবরণ)</label>
                    <textarea name="excerpt" id="excerpt" rows="3" placeholder="সংবাদের সংক্ষিপ্ত সারসংক্ষেপ লিখুন যা হোমপেজে হাইলাইট করা হবে..." class="form-control">{{ old('excerpt') }}</textarea>
                </div>

                <!-- Content -->
                <div class="form-group">
                    <label for="content" class="form-label">মূল সংবাদ কন্টেন্ট (Main Content)</label>
                    <textarea name="content" id="content" rows="18" required placeholder="এখানে আপনার সংবাদের বিস্তারিত কন্টেন্ট লিখুন..." class="form-control" style="line-height: 1.7; font-size: 1.05rem;">{{ old('content') }}</textarea>
                </div>
            </div>

            <!-- Right options panel -->
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
                            <option value="publish" {{ old('status') === 'publish' ? 'selected' : '' }}>প্রকাশ করুন (Publish)</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>খসড়া রাখুন (Draft)</option>
                        </select>
                    </div>

                    <div style="display: flex; gap: 12px; margin-top: 24px;">
                        <button type="submit" class="btn btn-primary" style="flex-grow: 1; justify-content: center;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>সংরক্ষণ করুন</span>
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
                        <img src="" alt="Preview Image" class="image-preview-img" id="previewImg">
                        <div class="image-preview-placeholder" id="previewPlaceholder">
                            <i class="fa-regular fa-image"></i>
                            <span>কোনো ছবি নির্বাচন করা হয়নি</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="file" name="featured_image" id="featured_image" accept="image/*" class="form-control" onchange="previewImage(this)">
                        <span class="form-text">ছবির সাইজ ৫ মেগাবাইটের কম এবং ফরম্যাট JPEG, PNG, JPG, GIF বা WEBP হতে হবে।</span>
                    </div>
                </div>

                <!-- Categories Checklist -->
                <div class="admin-card">
                    <h3 class="card-title" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-folder-open"></i>
                        <span>ক্যাটাগরি সমূহ</span>
                    </h3>

                    <div class="checklist-box">
                        @forelse($categories as $cat)
                            <label class="check-label">
                                <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ is_array(old('categories')) && in_array($cat->id, old('categories')) ? 'checked' : '' }}>
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
                        @forelse($tags as $tag)
                            <label class="check-label">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                                <span>{{ $tag->name }}</span>
                            </label>
                        @empty
                            <p style="color: var(--text-sub); font-size: 0.9rem; margin-bottom: 0;">কোনো ট্যাগ পাওয়া যায়নি।</p>
                        @endforelse
                    </div>

                    <!-- New tag add option -->
                    <div class="form-group" style="margin: 0; border-top: 1px dashed rgba(255, 255, 255, 0.1); padding-top: 14px;">
                        <label for="new_tags" class="form-label" style="font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">নতুন ট্যাগ যোগ করুন (ঐচ্ছিক)</label>
                        <input type="text" name="new_tags" id="new_tags" value="{{ old('new_tags') }}" placeholder="যেমন: শীর্ষ খবর, আন্তর্জাতিক (কমা দিয়ে আলাদা করুন)" class="form-control" style="font-size: 0.85rem; padding: 6px 12px; background-color: rgba(9, 13, 22, 0.4); border-color: var(--border-color);">
                    </div>
                </div>
            </div>
        </div>


    </form>

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    class Base64UploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }
        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => {
                        resolve({ default: reader.result });
                    };
                    reader.onerror = error => {
                        reject(error);
                    };
                    reader.readAsDataURL(file);
                }));
        }
        abort() {}
    }

    function Base64UploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new Base64UploadAdapter(loader);
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#content'), {
                extraPlugins: [Base64UploadAdapterPlugin],
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', '|',
                        'bulletedList', 'numberedList', 'blockQuote', '|',
                        'uploadImage', 'link', '|',
                        'undo', 'redo'
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    });

    // Sync Featured Image upload local preview
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
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            if (previewImg) {
                previewImg.src = '';
                previewImg.style.display = 'none';
            }
            if (placeholder) placeholder.style.display = 'flex';
        }
    }
</script>
@endsection
