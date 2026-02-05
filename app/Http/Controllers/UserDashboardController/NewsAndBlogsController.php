<?php

namespace App\Http\Controllers\UserDashboardController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\News;

class NewsAndBlogsController extends Controller
{
  
    public function index()
    {
        $blogs = Blog::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with(['category', 'media']) 
            ->latest('published_at')
            ->paginate(6, ['*'], 'blogs_page');

        $news = News::published()
            ->with(['category', 'author', 'media'])
            ->latest('published_at') // Orders by newest first
            ->paginate(6, ['*'], 'news_page');

return view('UserDashboard.latestNews.latest_news', compact('blogs', 'news'));
        }

    public function showBlog($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'media'])
            ->firstOrFail();

        $blog->increment('view_count');

        $relatedBlogs = Blog::where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        return view('user.news-blogs.blog-detail', compact('blog', 'relatedBlogs'));
    }


    public function showNews($slug)
    {
        $newsItem = News::published()
            ->where('slug', $slug)
            ->with(['category', 'author', 'media'])
            ->firstOrFail();

        $newsItem->increment('view_count');

        $relatedNews = News::published()
            ->where('category_id', $newsItem->category_id)
            ->where('id', '!=', $newsItem->id)
            ->latest()
            ->take(3)
            ->get();

        return view('user.news-blogs.news-detail', compact('newsItem', 'relatedNews'));
    }
}