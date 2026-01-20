<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipCategory;
use Illuminate\Http\Request;

class TipCategoryController extends Controller
{
    public function index()
    {
        $categories = TipCategory::orderBy('created_at', 'desc')->paginate(5);

        return view('admin.tips.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        TipCategory::create([
            'name' => $request->name,
            'status' => $request->status ? 1 : 0,
        ]);

        return back()->with('success', 'Category created successfully');
    }

    public function update(Request $request, TipCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update([
            'name' => $request->name,
            'status' => $request->status ? 1 : 0,
        ]);

        return back()->with('success', 'Category updated successfully');
    }

    public function destroy(TipCategory $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted successfully');
    }
}
