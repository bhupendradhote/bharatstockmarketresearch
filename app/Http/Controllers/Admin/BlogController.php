<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class BlogController extends Controller
{

    public function index(Request $request)
{
    $query = Blog::with('category')
        // ->withCount('comments') // if you have comments relationship
        ->latest();

    // Search filter
    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('short_description', 'like', "%{$search}%");
        });
    }

    // Category filter
    if ($request->has('category') && $request->category) {
        $query->where('category_id', $request->category);
    }

    // Status filter
    if ($request->has('status') && $request->status) {
        $query->where('status', $request->status);
    }

    // Featured filter
    if ($request->has('featured') && $request->featured !== '') {
        $query->where('is_featured', $request->featured);
    }

    $blogs = $query->paginate(10);

    // Get stats
    $totalBlogs = Blog::count();
    $publishedBlogs = Blog::where('status', 'published')->count();
    $draftBlogs = Blog::where('status', 'draft')->count();
    $featuredBlogs = Blog::where('is_featured', true)->count();

    // Get categories for filter
    $categories = BlogCategory::all();

    return view('admin.blogs.index', compact(
        'blogs', 
        'categories', 
        'totalBlogs', 
        'publishedBlogs', 
        'draftBlogs', 
        'featuredBlogs'
    ));
}
    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.create', compact('categories'));
    }

public function store(Request $request)
{
    $request->validate([
        "title" => "required|string|max:255",
        "slug" => "required|string|max:255|unique:blogs,slug",
        "category_id" => "required|exists:blog_categories,id",
        "short_description" => "nullable|string|max:500",
        "content" => "required",
        "meta_title" => "nullable|string|max:60",
        "meta_description" => "nullable|string|max:160",
        "meta_keywords" => "nullable|string",
        "canonical_url" => "nullable|url",
        "reading_time" => "nullable|integer|min:1",
        "status" => "required|in:draft,published,scheduled",
        "published_at" => "nullable|date",
        "scheduled_for" => "nullable|date|after:now",
        "table_of_contents" => "nullable|json",
    ]);

    // Prepare meta keywords array
    $metaKeywords = $request->meta_keywords ? 
        array_map('trim', explode(',', $request->meta_keywords)) : 
        [];

    // Parse table of contents if provided
    $tableOfContents = null;
    if ($request->table_of_contents) {
        try {
            $tableOfContents = json_decode($request->table_of_contents, true);
        } catch (\Exception $e) {
            $tableOfContents = null;
        }
    }

    // Determine published_at based on status
    $publishedAt = null;
    if ($request->status === 'published') {
        $publishedAt = $request->published_at ?: now();
    } elseif ($request->status === 'scheduled') {
        $publishedAt = $request->scheduled_for;
    }

    $blog = Blog::create([
        "title" => $request->title,
        "slug" => $request->slug,
        "category_id" => $request->category_id,
        "short_description" => $request->short_description,
        "content" => $request->content,
        "content_json" => null, // You can parse HTML to JSON if needed
        "meta_title" => $request->meta_title,
        "meta_description" => $request->meta_description,
        "meta_keywords" => $metaKeywords,
        "reading_time" => $request->reading_time,
        "is_featured" => $request->boolean('is_featured'),
        "status" => $request->status,
        "published_at" => $publishedAt,
        "scheduled_for" => $request->scheduled_for,
        "view_count" => 0,
        "like_count" => 0,
        "share_count" => 0,
        "canonical_url" => $request->canonical_url,
        "table_of_contents" => $tableOfContents,
    ]);

    // Attach thumbnail media
    if ($request->hasFile('thumbnail')) {
        $blog->addMediaFromRequest('thumbnail')
             ->toMediaCollection('thumbnail');
    }

    // If reading time wasn't provided, calculate it
    if (!$request->reading_time) {
        $wordCount = str_word_count(strip_tags($request->content));
        $readingTime = ceil($wordCount / 200); // Assuming 200 words per minute
        $blog->update(['reading_time' => $readingTime]);
    }

    return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully!');
}

    // AJAX category store
    public function storeCategory(Request $request)
    {
        $request->validate([
            "name" => "required|unique:blog_categories,name"
        ]);

        $cat = BlogCategory::create([
            "name" => $request->name,
            "slug" => Str::slug($request->name),
        ]);

        // Return JSON response with success and category data
        return response()->json([
            "success" => true,
            "category" => [
                "id" => $cat->id,
                "name" => $cat->name,
            ]
        ]);
    }



    public function edit($id)
{
    $blog = Blog::findOrFail($id);
    $categories = BlogCategory::orderBy('name')->get();

    return view('admin.blogs.edit', compact('blog', 'categories'));
}


public function update(Request $request, $id)
{
    $blog = Blog::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'slug'  => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
        'category_id' => 'required|exists:blog_categories,id',
        'short_description' => 'required|string|max:160',
        'content' => 'required',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'meta_keywords' => 'nullable|string',
        'meta_title' => 'nullable|string|max:60',
        'meta_description' => 'nullable|string|max:160',
        'canonical_url' => 'nullable|url',
        'table_of_contents' => 'nullable|string',
        'reading_time' => 'nullable|integer',
        'status' => 'required|in:draft,published,scheduled',
        'published_at' => 'nullable|date',
        'scheduled_for' => 'nullable|date',
        'is_featured' => 'nullable|boolean',
    ]);

    // Update Fields
    $blog->title = $request->title;
    $blog->slug = $request->slug;
    $blog->category_id = $request->category_id;
    $blog->reading_time = $request->reading_time;
    $blog->short_description = $request->short_description;
    $blog->content = $request->content;

    // SEO
    $blog->meta_title = $request->meta_title;
    $blog->meta_description = $request->meta_description;
    $blog->meta_keywords = $request->meta_keywords;
    $blog->canonical_url = $request->canonical_url;
    $blog->table_of_contents = $request->table_of_contents;

    // Featured
    $blog->is_featured = $request->has('is_featured') ? 1 : 0;

    // Publishing Logic
    $blog->status = $request->status;

    if ($request->status == "published") {
        $blog->published_at = $request->published_at ?? now();
        $blog->scheduled_for = null;
    } 
    elseif ($request->status == "scheduled") {
        $blog->scheduled_for = $request->scheduled_for;
        $blog->published_at = null;
    } 
    else {
        $blog->published_at = null;
        $blog->scheduled_for = null;
    }

    // Handle Thumbnail with Media Library
    if ($request->hasFile('thumbnail')) {
        // Remove old media if exists
        $blog->clearMediaCollection('thumbnail');

        // Add new media
        $blog->addMediaFromRequest('thumbnail')
             ->toMediaCollection('thumbnail');
    }

    $blog->save();

    return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
}


// Show a single blog
public function show($id)
{
    $blog = Blog::with('category')->findOrFail($id);

    // Get the thumbnail media
    $media = $blog->getMedia('thumbnail')->first();

    return view('admin.blogs.show', compact('blog', 'media'));
}


public function destroy($id)
{
    $blog = Blog::findOrFail($id);

    // Remove all media related to the blog
    $blog->clearMediaCollection();

    // Delete the blog
    $blog->delete();

    return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully!');
}



}
