<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EPaper;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminEPaperController extends Controller
{
    /**
     * Display the admin E-Paper layout builder dashboard.
     */
    public function index()
    {
        $selectedDate = Carbon::today();
        
        $days = ['Sunday'=>'রবিবার','Monday'=>'সোমবার','Tuesday'=>'মঙ্গলবার','Wednesday'=>'বুধবার','Thursday'=>'বৃহস্পতিবার','Friday'=>'শুক্রবার','Saturday'=>'শনিবার'];
        $months = ['Jan'=>'জানুয়ারি','Feb'=>'ফেব্রুয়ারি','Mar'=>'মার্চ','Apr'=>'এপ্রিল','May'=>'মে','Jun'=>'জুন','Jul'=>'জুলাই','Aug'=>'আগস্ট','Sep'=>'সেপ্টেম্বর','Oct'=>'অক্টোবর','Nov'=>'নভেম্বর','Dec'=>'ডিসেম্বর'];
        $enNumbers = ['0','1','2','3','4','5','6','7','8','9'];
        $bnNumbers = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

        $dayNum = str_replace($enNumbers, $bnNumbers, $selectedDate->format('d'));
        $yearNum = str_replace($enNumbers, $bnNumbers, $selectedDate->format('Y'));
        $monthName = $months[$selectedDate->format('M')] ?? $selectedDate->format('M');
        $dayName = $days[$selectedDate->format('l')] ?? $selectedDate->format('l');
        $formattedDate = "{$dayNum} {$monthName} {$yearNum} ({$dayName})";

        return view('admin.epaper.index', compact('selectedDate', 'formattedDate'));
    }

    /**
     * Load the saved layout data for a specific date via AJAX.
     */
    public function loadDateData(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d'
        ]);

        $dateString = $request->input('date');
        $date = Carbon::parse($dateString);

        // Find existing E-Paper layout for this date
        $epaper = EPaper::whereDate('publish_date', $date)->first();

        $savedLayout = [
            '1' => [],
            '2' => [],
            '3' => [],
            '4' => [],
        ];

        if ($epaper) {
            if (!empty($epaper->pages_data)) {
                $savedLayout = $epaper->pages_data;
            } elseif (!empty($epaper->layout_data)) {
                // Legacy migration
                $postIds = $epaper->layout_data;
                $postsMap = Post::whereIn('id', $postIds)->get()->keyBy('id');
                $page1 = [];
                foreach ($postIds as $idx => $id) {
                    if ($id && isset($postsMap[$id])) {
                        $p = $postsMap[$id];
                        $page1[] = [
                            'slot_id' => $idx + 1,
                            'post_id' => $p->id,
                            'title' => $p->title,
                            'excerpt' => strip_tags($p->content), // simplify for migration
                            'image' => $p->featured_image_url,
                            'style' => ['font_size' => 14]
                        ];
                    }
                }
                $savedLayout['1'] = $page1;
            }
        }

        $days = ['Sunday'=>'রবিবার','Monday'=>'সোমবার','Tuesday'=>'মঙ্গলবার','Wednesday'=>'বুধবার','Thursday'=>'বৃহস্পতিবার','Friday'=>'শুক্রবার','Saturday'=>'শনিবার'];
        $months = ['Jan'=>'জানুয়ারি','Feb'=>'ফেব্রুয়ারি','Mar'=>'মার্চ','Apr'=>'এপ্রিল','May'=>'মে','Jun'=>'জুন','Jul'=>'জুলাই','Aug'=>'আগস্ট','Sep'=>'সেপ্টেম্বর','Oct'=>'অক্টোবর','Nov'=>'নভেম্বর','Dec'=>'ডিসেম্বর'];
        $enNumbers = ['0','1','2','3','4','5','6','7','8','9'];
        $bnNumbers = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

        $dayNum = str_replace($enNumbers, $bnNumbers, $date->format('d'));
        $yearNum = str_replace($enNumbers, $bnNumbers, $date->format('Y'));
        $monthName = $months[$date->format('M')] ?? $date->format('M');
        $dayName = $days[$date->format('l')] ?? $date->format('l');
        $formattedDate = "{$dayNum} {$monthName} {$yearNum} ({$dayName})";

        return response()->json([
            'success' => true,
            'date' => $dateString,
            'saved_layout' => $savedLayout,
            'has_saved' => $epaper ? true : false,
            'title' => $epaper ? $epaper->title : 'প্রথম পাতা',
            'formatted_date' => $formattedDate
        ]);
    }

    /**
     * Save the dragged-and-dropped E-Paper layout order in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'layout' => 'required|array', // Now expects the 4-page json
            'title' => 'nullable|string|max:100'
        ]);

        $date = Carbon::parse($request->input('date'));
        $layoutData = $request->input('layout'); 

        // Save or update layout
        $epaper = EPaper::updateOrCreate(
            ['publish_date' => $date, 'page_number' => 1],
            [
                'title' => $request->input('title') ?? 'প্রথম পাতা',
                'pages_data' => $layoutData,
                'total_pages' => 4,
                'image' => null // image is unused since broadsheet is built dynamically
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'ই-পেপার লেআউট সফলভাবে সংরক্ষিত হয়েছে।',
            'epaper' => $epaper
        ]);
    }

    /**
     * Proxy WordPress REST API to fetch posts and avoid CORS issues.
     */
    public function proxyWPPosts(Request $request)
    {
        // Force the live site URL as requested
        $siteUrl = 'https://www.bholatimes24.com';
        
        $perPage = $request->input('per_page', 50);
        $search = $request->input('search', '');
        $date = $request->input('date', ''); // optional exact date

        $query = [
            'per_page' => $perPage,
            '_embed' => '1',
            'status' => 'publish'
        ];

        if (!empty($search)) {
            $query['search'] = $search;
        }

        if (!empty($date)) {
            $carbonDate = Carbon::parse($date);
            $query['after'] = $carbonDate->startOfDay()->toIso8601String();
            $query['before'] = $carbonDate->endOfDay()->toIso8601String();
        }

        try {
            $response = Http::withoutVerifying()->timeout(15)->get($siteUrl . '/wp-json/wp/v2/posts', $query);
            
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'posts' => $response->json()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch from WP API: ' . $e->getMessage(),
                'posts' => []
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch from WP API',
            'posts' => []
        ]);
    }

    /**
     * Proxy image requests to bypass CORS restrictions during html2canvas export.
     */
    public function proxyImage(Request $request)
    {
        $url = $request->input('url');
        if (!$url) {
            return response('No URL provided', 400);
        }

        try {
            $response = Http::withoutVerifying()->timeout(10)->get($url);
            if ($response->successful()) {
                $contentType = $response->header('Content-Type');
                return response($response->body(), 200)
                    ->header('Content-Type', $contentType ?: 'image/jpeg')
                    ->header('Access-Control-Allow-Origin', '*');
            }
        } catch (\Exception $e) {
            // fail silently and return empty
        }
        return response('', 404);
    }
}
