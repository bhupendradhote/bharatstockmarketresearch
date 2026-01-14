<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogApiController extends Controller
{
    // List Blogs with filters
    public function index(Request $request)
    {
        $query = Blog::with('category')->latest();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured);
        }

        $blogs = $query->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $blogs
        ]);
    }

    // Show single blog
    public function show($id)
    {
        $blog = Blog::with('category')->find($id);
        if (!$blog) {
            return response()->json(['success' => false, 'message' => 'Blog not found'], 404);
        }

        $thumbnail = $blog->getFirstMediaUrl('thumbnail');

        return response()->json([
            'success' => true,
            'data' => [
                'blog' => $blog,
                'thumbnail' => $thumbnail,
            ]
        ]);
    }

    // Store blog
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
            "thumbnail" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
        ]);

        $metaKeywords = $request->meta_keywords ? array_map('trim', explode(',', $request->meta_keywords)) : [];
        $tableOfContents = $request->table_of_contents ? json_decode($request->table_of_contents, true) : null;

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
            "content_json" => null,
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

        if ($request->hasFile('thumbnail')) {
            $blog->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
        }

        if (!$request->reading_time) {
            $wordCount = str_word_count(strip_tags($request->content));
            $blog->update(['reading_time' => ceil($wordCount / 200)]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog created successfully',
            'data' => $blog
        ]);
    }

    // Update blog
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['success' => false, 'message' => 'Blog not found'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
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

        $blog->update([
            "title" => $request->title,
            "slug" => $request->slug,
            "category_id" => $request->category_id,
            "short_description" => $request->short_description,
            "content" => $request->content,
            "meta_title" => $request->meta_title,
            "meta_description" => $request->meta_description,
            "meta_keywords" => $request->meta_keywords,
            "canonical_url" => $request->canonical_url,
            "table_of_contents" => $request->table_of_contents,
            "reading_time" => $request->reading_time,
            "is_featured" => $request->has('is_featured') ? 1 : 0,
            "status" => $request->status,
            "published_at" => $request->status === 'published' ? ($request->published_at ?? now()) : null,
            "scheduled_for" => $request->status === 'scheduled' ? $request->scheduled_for : null,
        ]);

        if ($request->hasFile('thumbnail')) {
            $blog->clearMediaCollection('thumbnail');
            $blog->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog updated successfully',
            'data' => $blog
        ]);
    }

    // Delete blog
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['success' => false, 'message' => 'Blog not found'], 404);
        }

        $blog->clearMediaCollection();
        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog deleted successfully'
        ]);
    }
}
