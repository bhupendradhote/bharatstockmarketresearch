<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\HeroBanner;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * News Hub: Shows featured/latest news and categories.
     */
  public function index()
{
    // Fetch the Banner specifically for the News page
    $banner = HeroBanner::where('page_key', 'news')
                ->where('status', 1)
                ->orderBy('sort_order')
                ->first();

    // Fetch the 5 most recent news articles
    $latestNews = News::where('status', 'published')
        ->with('category')
        ->orderBy('published_at', 'desc')
        ->take(5)
        ->get();

    // Fetch categories for the sidebar or filter
    $categories = NewsCategory::where('is_active', true)
        ->withCount('news')
        ->get();

    return view('news.index', compact('banner', 'latestNews', 'categories'));
}

    /**
     * News Archive: Shows all news with Latest/Oldest sorting.
     */
    public function archive(Request $request)
    {
        $sortOrder = $request->get('sort', 'desc'); // Default to newest (desc)
        
        $allNews = News::where('status', 'published')
            ->with('category')
            ->orderBy('published_at', $sortOrder)
            ->paginate(12);

        return view('news.archive', compact('allNews'));
    }

    /**
     * News Details: Shows a single news article.
     */
    public function show($slug)
    {
        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count
        $news->increment('view_count');

        // Fetch related news from the same category
        $relatedNews = News::where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }
}