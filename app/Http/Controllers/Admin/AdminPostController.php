<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('categories')
            ->latest()
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:publish,draft',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'social_card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'new_tags' => 'nullable|string',
        ]);

        // Generate Slug safely
        $slug = Str::slug($request->title);
        if (empty($slug)) {
            // Bengali titles output empty slug in standard Str::slug, so we create a random slug
            $slug = 'post-' . time();
        }
        
        // Ensure uniqueness
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Image Handling
        $featuredImagePath = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads'), $filename);
            $featuredImagePath = 'uploads/' . $filename;
        }

        $socialCardImagePath = null;
        if ($request->hasFile('social_card_image')) {
            $file = $request->file('social_card_image');
            $filename = time() . '_card_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads'), $filename);
            $socialCardImagePath = 'uploads/' . $filename;
        }

        // Create Post
        $post = Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'featured_image' => $featuredImagePath,
            'social_card_image' => $socialCardImagePath,
            'status' => $request->status,
            'user_id' => Auth::id(),
            'views_count' => 0,
        ]);

        // Sync Relations
        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }
        
        $tagIds = $request->input('tags', []);
        if ($request->filled('new_tags')) {
            $newTagsArray = explode(',', $request->new_tags);
            foreach ($newTagsArray as $tagName) {
                $tagName = trim($tagName);
                if (!empty($tagName)) {
                    $slug = Str::slug($tagName);
                    if (empty($slug)) {
                        $slug = 'tag-' . time() . '-' . rand(10, 99);
                    }
                    $tag = Tag::firstOrCreate(
                        ['name' => $tagName],
                        ['slug' => $slug]
                    );
                    $tagIds[] = $tag->id;
                }
            }
        }
        $post->tags()->sync($tagIds);

        return redirect()->route('admin.posts.index')->with('success', 'সংবাদটি সফলভাবে তৈরি ও প্রকাশ করা হয়েছে।')->with('open_social_card', $post->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::with(['categories', 'tags'])->findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:publish,draft',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'social_card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'new_tags' => 'nullable|string',
        ]);

        // Handle Slug update if title changed
        $slug = $post->slug;
        if ($request->title !== $post->title) {
            $slug = Str::slug($request->title);
            if (empty($slug)) {
                $slug = 'post-' . time();
            }
            
            $originalSlug = $slug;
            $count = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        // Image Handling
        $featuredImagePath = $post->featured_image;
        if ($request->hasFile('featured_image')) {
            // Delete old file if it exists in uploads directory
            if ($post->featured_image && file_exists(public_path($post->featured_image))) {
                @unlink(public_path($post->featured_image));
            }

            $file = $request->file('featured_image');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads'), $filename);
            $featuredImagePath = 'uploads/' . $filename;
        }

        $socialCardImagePath = $post->social_card_image;
        if ($request->hasFile('social_card_image')) {
            // Delete old file if it exists in uploads directory
            if ($post->social_card_image && file_exists(public_path($post->social_card_image))) {
                @unlink(public_path($post->social_card_image));
            }

            $file = $request->file('social_card_image');
            $filename = time() . '_card_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads'), $filename);
            $socialCardImagePath = 'uploads/' . $filename;
        }

        // Update Post
        $post->update([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'featured_image' => $featuredImagePath,
            'social_card_image' => $socialCardImagePath,
            'status' => $request->status,
        ]);

        // Sync Relations
        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        } else {
            $post->categories()->detach();
        }
        
        $tagIds = $request->input('tags', []);
        if ($request->filled('new_tags')) {
            $newTagsArray = explode(',', $request->new_tags);
            foreach ($newTagsArray as $tagName) {
                $tagName = trim($tagName);
                if (!empty($tagName)) {
                    $slug = Str::slug($tagName);
                    if (empty($slug)) {
                        $slug = 'tag-' . time() . '-' . rand(10, 99);
                    }
                    $tag = Tag::firstOrCreate(
                        ['name' => $tagName],
                        ['slug' => $slug]
                    );
                    $tagIds[] = $tag->id;
                }
            }
        }
        $post->tags()->sync($tagIds);

        return redirect()->route('admin.posts.index')->with('success', 'সংবাদটি সফলভাবে আপডেট করা হয়েছে।')->with('open_social_card', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Delete associated featured image file
        if ($post->featured_image && file_exists(public_path($post->featured_image))) {
            @unlink(public_path($post->featured_image));
        }

        // Delete associated social card image file
        if ($post->social_card_image && file_exists(public_path($post->social_card_image))) {
            @unlink(public_path($post->social_card_image));
        }

        // Detach and delete
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'সংবাদটি সফলভাবে মুছে ফেলা হয়েছে।');
    }

    /**
     * Show the Social Card Generator page for the specified post.
     */
    public function socialCard($id)
    {
        $post = Post::findOrFail($id);
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $themeSettings = [
            'logo_image' => '',
            'logo_text' => 'Times<span>Panel</span>'
        ];
        if (file_exists($themeSettingsPath)) {
            $themeSettings = array_merge($themeSettings, json_decode(file_get_contents($themeSettingsPath), true));
        }
        $recentPosts = Post::latest()->take(20)->get();
        return view('admin.posts.social_card', compact('post', 'themeSettings', 'recentPosts'));
    }

    /**
     * Redirect to the Social Card Generator of the latest post.
     */
    public function socialCardIndex()
    {
        $post = Post::latest()->first();
        if (!$post) {
            return redirect()->route('admin.dashboard')->with('error', 'কোনো সংবাদ পোস্ট পাওয়া যায়নি।');
        }
        return redirect()->route('admin.posts.social-card', $post->id);
    }
}
