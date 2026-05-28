<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource and creation form.
     */
    public function index()
    {
        $categories = Category::withCount('posts')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        // Generate slug
        $slug = Str::slug($request->name);
        if (empty($slug)) {
            $slug = 'category-' . time();
        }

        // Uniqueness check for slugs
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'নতুন ক্যাটাগরি সফলভাবে তৈরি করা হয়েছে।');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Detach pivot relations first
        $category->posts()->detach();
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটাগরি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
