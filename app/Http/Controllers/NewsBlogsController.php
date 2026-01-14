<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use App\Models\Faq;

class NewsBlogsController extends Controller
{
    /**
     * Blog Listing Page
     */
    public function index()
    {
        $blogs = Blog::with('category')
            ->where('status', 1)
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->paginate(9);

              $banner = HeroBanner::where('page_key', 'blogs')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->first();

               // LATEST 2 BLOGS (DATE WISE)
            $latestBlogs = Blog::where('status', 'published')
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->take(2)
                ->get();

           // ✅ LATEST 3 BLOGS (Published only)
            $latest3Blogs = Blog::where('status', 'published')
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->take(3)
                ->get();
                        /* ---------------- FAQs ---------------- */
        $faqs = Faq::where('page_type', 'blog')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view('news&blogs', compact('blogs', 'banner', 'latestBlogs', 'latest3Blogs', 'faqs'));
    }

    /**
     * Single Blog Page
     */
public function show($slug)
{
    $blog = Blog::with('category')
        ->where('slug', $slug)
                ->firstOrFail();

    // Increase view count (optional but recommended)
    $blog->increment('view_count');

    return view('blogsDetails', compact('blog'));
}


public function moreBlogs()
{
    // HERO BANNER (separate banner key)
    $banner = HeroBanner::where('page_key', 'moreblogs')
        ->where('status', 1)
        ->orderBy('sort_order')
        ->first();

    // ALL PUBLISHED BLOGS
    $blogs = Blog::with('category')
        ->whereNotNull('published_at')
        ->orderByDesc('published_at')
        ->paginate(9); // pagination ready

    return view('moreblogs', compact('blogs', 'banner'));
}
}
