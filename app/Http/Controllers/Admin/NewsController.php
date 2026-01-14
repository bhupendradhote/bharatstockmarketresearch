<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // --- NEWS METHODS ---
 public function index(Request $request)
{
    $query = News::with('category');

    // Apply Filters
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }
    if ($request->filled('type')) {
        $query->where('news_type', $request->type);
    }

    $newsItems = $query->latest()->paginate(12);
    
    // Get categories for the filter dropdown
    $categories = NewsCategory::orderBy('name')->get();

    $stats = [
        'total'     => News::count(),
        'published' => News::where('status', 'published')->count(),
        'breaking'  => News::where('news_type', 'breaking')->count(),
        'featured'  => News::where('is_featured', true)->count(),
    ];

    return view('admin.news.index', compact('newsItems', 'stats', 'categories'));
}

    public function create()
    {
        $categories = NewsCategory::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validation: Only Title, Category, Content, and Status are strictly required.
        // All other fields are treated as nullable.
        $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:news_categories,id',
            'content'           => 'required',
            'status'            => 'required|in:published,draft,scheduled',
            'news_type'         => 'nullable|string',
            'location'          => 'nullable|string',
            'short_description' => 'nullable|string',
            'source_name'       => 'nullable|string',
            'source_url'        => 'nullable|url',
            'video_url'         => 'nullable|url',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'canonical_url'     => 'nullable|url',
            'thumbnail'         => 'nullable|image|max:2048', // 2MB Max
        ]);

        // Prepare data for storage
        $data = $request->all();
        
        // Handle Boolean Checkboxes (Checkboxes only send data if checked)
        $data['is_featured'] = $request->has('is_featured');
        $data['is_trending'] = $request->has('is_trending');
        
        // Automatic Logic
        $data['slug'] = Str::slug($request->title);
        // $data['user_id'] = auth()->id();
        
        // Set published_at if status is 'published' and it's not already set
        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        // Create News Record
        $news = News::create($data);

        // Handle Image Upload using Spatie Media Library
        if ($request->hasFile('thumbnail')) {
            $news->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
        }

        return redirect()->route('admin.news.index')->with('success', 'News article saved successfully!');
    }

    /**
 * Show the form for editing the specified news article.
 *
 * @param  int  $id
 * @return \Illuminate\Contracts\View\View
 */
    public function edit($id)
    {
        // 1. Fetch the news article by ID or throw 404 if not found
        $news = News::findOrFail($id);

        // 2. Fetch all categories for the dropdown menu
        $categories = NewsCategory::orderBy('name', 'asc')->get();

        // 3. Return the edit blade view with both variables
        return view('admin.news.edit', compact('news', 'categories'));
    }


    public function update(Request $request, News $news)
    {
        // 1. Validation
        // Most fields are nullable as requested. 
        // category_id is validated against the news_categories table.
        $request->validate([
            'title'             => 'required|string|max:255',
            'category_id'       => 'required|exists:news_categories,id',
            'content'           => 'required',
            'status'            => 'required|in:published,draft,scheduled',
            'news_type'         => 'nullable|string',
            'location'          => 'nullable|string',
            'short_description' => 'nullable|string',
            'source_name'       => 'nullable|string',
            'source_url'        => 'nullable|url',
            'video_url'         => 'nullable|url',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'canonical_url'     => 'nullable|url',
            'thumbnail'         => 'nullable|image|max:2048', // 2MB Max
        ]);

        // 2. Prepare data
        $data = $request->all();
        
        // 3. Handle Boolean Checkboxes 
        // Important: if a checkbox is unchecked, $request->has() returns false.
        $data['is_featured'] = $request->has('is_featured');
        $data['is_trending'] = $request->has('is_trending');
        
        // 4. Update Slug (optional: usually slugs shouldn't change for SEO, 
        // but if you want it to update with the title, keep this line)
        $data['slug'] = Str::slug($request->title);
        
        // 5. Manage Published Date
        // Only set published_at if it's currently null and the status is being set to published
        if ($request->status === 'published' && !$news->published_at) {
            $data['published_at'] = now();
        }

        // 6. Update the Record
        $news->update($data);

        // 7. Handle Image Upload using Spatie Media Library
        if ($request->hasFile('thumbnail')) {
            // This will remove the old thumbnail and add the new one
            $news->clearMediaCollection('thumbnail');
            $news->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
        }

        // 8. Redirect
        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully!');
    }

    // --- CATEGORY METHODS ---
    public function categoryIndex()
    {
        $categories = NewsCategory::latest()->get();
        return view('admin.news.categories', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:news_categories,name',
        ]);

        $category = NewsCategory::create([
            'name'       => $request->name,
            'slug'       => Str::slug($request->name),
            'color_code' => $request->color_code ?? '#4f46e5', // Default color if null
        ]);

        // Support for AJAX response (for your Modal)
        if ($request->expectsJson()) {
            return response()->json([
                'success'  => true,
                'category' => $category
            ]);
        }

        return back()->with('success', 'Category added!');
    }

    /**
 * Update an existing category
 */
public function categoryUpdate(Request $request, $id)
{
    $category = NewsCategory::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255|unique:news_categories,name,' . $id,
        'color_code' => 'required|string|max:7',
    ]);

    $category->update([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'color_code' => $request->color_code,
    ]);

    return back()->with('success', 'Category updated successfully!');
}

/**
 * Delete a category
 */
public function categoryDestroy($id)
{
    $category = NewsCategory::findOrFail($id);

    // Check if category is linked to news to prevent errors
    if ($category->news()->count() > 0) {
        return back()->with('error', 'Cannot delete! This category has news articles linked to it.');
    }

    $category->delete();
    return back()->with('success', 'Category deleted successfully!');
}
}