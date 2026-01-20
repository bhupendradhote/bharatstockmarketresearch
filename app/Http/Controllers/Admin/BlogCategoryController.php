<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::orderBy('created_at', 'desc')->paginate(3);

        return view('admin.blogs.category', compact('categories'));
    }


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:blog_categories,name',
    ]);

    BlogCategory::create([
        'name'   => $request->name,
        'slug'   => Str::slug($request->name), // Automatically creates 'test-category' from 'Test Category'
        'status' => $request->status ? 1 : 0,
    ]);

    return back()->with('success', 'Blog category created successfully');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:blog_categories,name,'.$id,
    ]);

    $category = BlogCategory::findOrFail($id);
    $category->update([
        'name'   => $request->name,
        'slug'   => Str::slug($request->name),
        'status' => $request->status ? 1 : 0,
    ]);

    return back()->with('success', 'Category updated successfully');
}

    // public function update(Request $request, BlogCategory $category)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //     ]);

    //     $category->update([
    //         'name'   => $request->name,
    //         'status' => $request->status ? 1 : 0,
    //     ]);

    //     return back()->with('success', 'Blog category updated successfully');
    // }

    public function destroy(BlogCategory $category)
    {
        $category->delete();

        return back()->with('success', 'Blog category deleted successfully');
    }
}
