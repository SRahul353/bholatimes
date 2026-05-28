<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EPaper;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminEPaperController extends Controller
{
    /**
     * Display the admin E-Paper layout builder dashboard.
     */
    public function index()
    {
        return view('admin.epaper.index');
    }

    /**
     * Load the news articles and saved layout data for a specific date via AJAX.
     */
    public function loadDateData(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d'
        ]);

        $dateString = $request->input('date');
        $date = Carbon::parse($dateString);

        // 1. Fetch published posts specifically on this date
        $datePosts = Post::with(['categories', 'user'])
            ->where('status', 'publish')
            ->whereDate('created_at', $date)
            ->latest()
            ->get();

        // 2. Fetch recent posts (last 30) for fallback/general selection
        $recentPosts = Post::with(['categories', 'user'])
            ->where('status', 'publish')
            ->latest()
            ->limit(30)
            ->get();

        // 3. Find existing E-Paper layout for this date
        $epaper = EPaper::whereDate('publish_date', $date)->first();

        $savedLayout = [];
        if ($epaper && is_array($epaper->layout_data)) {
            // Load full post objects in the exact order stored in layout_data
            $postIds = $epaper->layout_data;
            
            // Fetch the posts matching these IDs
            $postsMap = Post::with(['categories', 'user'])
                ->whereIn('id', $postIds)
                ->get()
                ->keyBy('id');

            // Construct array keeping nulls for any deleted/missing posts
            foreach ($postIds as $id) {
                if (isset($postsMap[$id])) {
                    $savedLayout[] = $postsMap[$id];
                } else {
                    $savedLayout[] = null;
                }
            }
        } else {
            // Pre-populate with up to 16 of the day's posts as a convenient default starting draft!
            $draftPosts = $datePosts->take(16);
            foreach ($draftPosts as $p) {
                $savedLayout[] = $p;
            }
            // Pad out to 16 elements
            while (count($savedLayout) < 16) {
                $savedLayout[] = null;
            }
        }

        return response()->json([
            'success' => true,
            'date' => $dateString,
            'date_posts' => $datePosts,
            'recent_posts' => $recentPosts,
            'saved_layout' => $savedLayout,
            'has_saved' => $epaper ? true : false,
            'title' => $epaper ? $epaper->title : 'প্রথম পাতা'
        ]);
    }

    /**
     * Save the dragged-and-dropped E-Paper layout order in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'layout' => 'required|array|size:16',
            'title' => 'nullable|string|max:100'
        ]);

        $date = Carbon::parse($request->input('date'));
        $layoutIds = $request->input('layout'); // e.g. [12, null, 45, ...]
        
        // Clean layout array to ensure it casts properly in JSON
        $layoutIdsCleaned = [];
        foreach ($layoutIds as $id) {
            $layoutIdsCleaned[] = $id ? (int)$id : null;
        }

        // Save or update layout
        $epaper = EPaper::updateOrCreate(
            ['publish_date' => $date, 'page_number' => 1],
            [
                'title' => $request->input('title') ?? 'প্রথম পাতা',
                'layout_data' => $layoutIdsCleaned,
                'image' => null // image is unused since broadsheet is built dynamically
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'ই-পেপার লেআউট সফলভাবে সংরক্ষিত হয়েছে।',
            'epaper' => $epaper
        ]);
    }
}
