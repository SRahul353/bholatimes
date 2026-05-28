<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin panel dashboard main hub.
     */
    public function index()
    {
        // 1. Core Metrics
        $totalPosts = Post::count();
        $totalViews = Post::sum('views_count');
        $totalCategories = Category::count();
        $totalTags = Tag::count();

        // 2. Recent Posts Activity
        $recentPosts = Post::with('categories')
            ->latest()
            ->limit(5)
            ->get();

        // 3. Category Breakdown (Category names with their post count)
        $categoriesBreakdown = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPosts', 
            'totalViews', 
            'totalCategories', 
            'totalTags', 
            'recentPosts',
            'categoriesBreakdown'
        ));
    }

}
