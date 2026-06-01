<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\EPaper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewspaperController extends Controller
{
    /**
     * Display the newspaper homepage.
     */
    public function index()
    {
        // 1. Fetch Lead Post (with 'শীর্ষ খবর' tag if available, otherwise latest post)
        $topNewsTag = Tag::where('name', 'শীর্ষ খবর')->first();
        $leadPost = null;
        if ($topNewsTag) {
            $leadPost = Post::with(['categories', 'user'])
                ->where('status', 'publish')
                ->whereHas('tags', function($query) use ($topNewsTag) {
                    $query->where('tags.id', $topNewsTag->id);
                })
                ->latest()
                ->first();
        }

        if (!$leadPost) {
            $leadPost = Post::with(['categories', 'user'])
                ->where('status', 'publish')
                ->latest()
                ->first();
        }

        $leadPostId = $leadPost ? $leadPost->id : 0;

        // 2. Fetch Column 2 Sub Lead Posts (with 'শীর্ষ খবর' tag, excluding lead post)
        $subLeadPosts = collect();
        if ($topNewsTag && $leadPostId) {
            $subLeadPosts = Post::with('categories')
                ->where('status', 'publish')
                ->where('id', '!=', $leadPostId)
                ->whereHas('tags', function($query) use ($topNewsTag) {
                    $query->where('tags.id', $topNewsTag->id);
                })
                ->latest()
                ->limit(4)
                ->get();
        }

        // Fill remaining side leads if fewer than 4 are found
        $needed = 4 - $subLeadPosts->count();
        if ($needed > 0) {
            $excludeIds = $subLeadPosts->pluck('id')->push($leadPostId)->toArray();
            $fillPosts = Post::with('categories')
                ->where('status', 'publish')
                ->whereNotIn('id', $excludeIds)
                ->latest()
                ->limit($needed)
                ->get();
            $subLeadPosts = $subLeadPosts->merge($fillPosts);
        }

        // 3. Latest News Sidebar (10 latest posts, excluding lead)
        $latestPosts = Post::with('categories')
            ->where('status', 'publish')
            ->where('id', '!=', $leadPostId)
            ->latest()
            ->limit(10)
            ->get();

        // 4. Popular News (Top 5 read posts)
        $popularPosts = Post::where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(5)
            ->get();

        // 5. Categorized News Blocks (load from settings layout list if set, otherwise empty to respect "sudho first section ta thakbo")
        $themeSettingsPath = storage_path('app/theme_settings.json');
        $homepageCategoryIds = [];
        if (file_exists($themeSettingsPath)) {
            $themeSettings = json_decode(file_get_contents($themeSettingsPath), true);
            $homepageCategories = $themeSettings['homepage_categories'] ?? [];
            $homepageCategoryIds = collect($homepageCategories)->pluck('id')->toArray();
        }

        if (!empty($homepageCategoryIds)) {
            $categoriesWithPosts = Category::with(['posts' => function($query) use ($leadPostId) {
                    $query->where('status', 'publish')
                        ->where('posts.id', '!=', $leadPostId)
                        ->latest()
                        ->limit(4);
                }])
                ->whereIn('id', $homepageCategoryIds)
                ->get()
                ->sortBy(function($category) use ($homepageCategoryIds) {
                    return array_search($category->id, $homepageCategoryIds);
                })
                ->values();
        } else {
            $categoriesWithPosts = collect();
        }

        return view('home', compact('leadPost', 'subLeadPosts', 'latestPosts', 'popularPosts', 'categoriesWithPosts'));
    }

    /**
     * Display a single news post.
     */
    public function show($slug)
    {
        $decoded = urldecode($slug);
        $encoded = urlencode($slug);
        $rawencoded = rawurlencode($slug);

        $post = Post::with(['categories', 'tags', 'user'])
            ->where(function($query) use ($slug, $decoded, $encoded, $rawencoded) {
                $query->where('slug', $slug)
                      ->orWhere('slug', $decoded)
                      ->orWhere('slug', $encoded)
                      ->orWhere('slug', $rawencoded);
            })
            ->where('status', 'publish')
            ->firstOrFail();

        // Increment views count safely
        $post->increment('views_count');

        // Fetch related posts (same category, excluding current post)
        $categoryIds = $post->categories->pluck('id')->toArray();
        $relatedPosts = Post::where('status', 'publish')
            ->where('id', '!=', $post->id)
            ->whereHas('categories', function($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->latest()
            ->limit(4)
            ->get();

        // Top 5 popular posts for the single post page sidebar
        $popularPosts = Post::where('status', 'publish')
            ->where('id', '!=', $post->id)
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(5)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts', 'popularPosts'));
    }

    /**
     * Display posts by category.
     */
    public function category($slug)
    {
        $decoded = urldecode($slug);
        $encoded = urlencode($slug);
        $rawencoded = rawurlencode($slug);

        $category = Category::where(function($query) use ($slug, $decoded, $encoded, $rawencoded) {
                $query->where('slug', $slug)
                      ->orWhere('slug', $decoded)
                      ->orWhere('slug', $encoded)
                      ->orWhere('slug', $rawencoded);
            })
            ->firstOrFail();

        $posts = $category->posts()
            ->where('status', 'publish')
            ->latest()
            ->paginate(12);

        // Fetch sidebar trending posts
        $popularPosts = Post::where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(5)
            ->get();

        return view('posts.category', compact('category', 'posts', 'popularPosts'));
    }

    /**
     * Search for news articles.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $posts = Post::with('categories')
            ->where('status', 'publish')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(12);

        $popularPosts = Post::where('status', 'publish')
            ->orderBy('views_count', 'desc')
            ->latest()
            ->limit(5)
            ->get();

        return view('posts.search', compact('posts', 'query', 'popularPosts'));
    }

    /**
     * Display the digital E-Paper broadsheet.
     */
    public function epaper(Request $request)
    {
        $dateString = $request->input('date');
        
        // If no explicit date requested, try loading today's date
        if (!$dateString) {
            $dateString = Carbon::today()->format('Y-m-d');
        }

        try {
            $date = Carbon::parse($dateString);
        } catch (\Exception $e) {
            $date = Carbon::today();
            $dateString = $date->format('Y-m-d');
        }

        // Find saved E-Paper for the chosen date
        $epaper = EPaper::whereDate('publish_date', $date)->first();

        // Fallback logic for when there is no saved E-Paper for the selected date
        if (!$epaper && !$request->has('date')) {
            // User just visited the /epaper homepage, load the LATEST saved E-Paper in the database!
            $latestEpaper = EPaper::orderBy('publish_date', 'desc')->first();
            if ($latestEpaper) {
                $epaper = $latestEpaper;
                $date = $latestEpaper->publish_date;
                $dateString = $date->format('Y-m-d');
            }
        }

        $pagesData = [
            '1' => [], '2' => [], '3' => [], '4' => []
        ];
        $hasSavedEPaper = false;

        if ($epaper) {
            $hasSavedEPaper = true;
            if (!empty($epaper->pages_data)) {
                $pagesData = $epaper->pages_data;
            } elseif (!empty($epaper->layout_data)) {
                // Legacy fallback
                $postIds = $epaper->layout_data;
                $postsMap = Post::with(['user'])->whereIn('id', $postIds)->get()->keyBy('id');
                $page1 = [];
                foreach ($postIds as $idx => $id) {
                    if ($id && isset($postsMap[$id])) {
                        $p = $postsMap[$id];
                        $page1[] = [
                            'slot_id' => $idx + 1,
                            'post_id' => $p->id,
                            'title' => $p->title,
                            'excerpt' => strip_tags($p->content),
                            'image' => $p->featured_image_url,
                            'style' => ['font_size' => 14, 'columns' => 2, 'char_limit' => 1200]
                        ];
                    }
                }
                $pagesData['1'] = $page1;
            }
        }

        $selectedDate = $date;

        $days = ['Sunday'=>'রবিবার','Monday'=>'সোমবার','Tuesday'=>'মঙ্গলবার','Wednesday'=>'বুধবার','Thursday'=>'বৃহস্পতিবার','Friday'=>'শুক্রবার','Saturday'=>'শনিবার'];
        $months = ['Jan'=>'জানুয়ারি','Feb'=>'ফেব্রুয়ারি','Mar'=>'মার্চ','Apr'=>'এপ্রিল','May'=>'মে','Jun'=>'জুন','Jul'=>'জুলাই','Aug'=>'আগস্ট','Sep'=>'সেপ্টেম্বর','Oct'=>'অক্টোবর','Nov'=>'নভেম্বর','Dec'=>'ডিসেম্বর'];
        $enNumbers = ['0','1','2','3','4','5','6','7','8','9'];
        $bnNumbers = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

        $dayNum = str_replace($enNumbers, $bnNumbers, $selectedDate->format('d'));
        $yearNum = str_replace($enNumbers, $bnNumbers, $selectedDate->format('Y'));
        $monthName = $months[$selectedDate->format('M')] ?? $selectedDate->format('M');
        $dayName = $days[$selectedDate->format('l')] ?? $selectedDate->format('l');
        $formattedDate = "{$dayNum} {$monthName} {$yearNum} ({$dayName})";

        return view('epaper.show', compact('pagesData', 'selectedDate', 'hasSavedEPaper', 'formattedDate'));
    }
}
