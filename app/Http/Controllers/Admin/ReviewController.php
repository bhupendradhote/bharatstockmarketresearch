<?php 
// app/Http/Controllers/Admin/ReviewController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
public function index(Request $request)
{
    $reviews = Review::with('user')
        ->when($request->search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->when($request->rating, function ($query, $rating) {
            $query->where('rating', $rating);
        })
        ->when($request->user_type, function ($query, $type) {
            if ($type === 'registered') {
                $query->whereNotNull('user_id');
            } elseif ($type === 'guest') {
                $query->whereNull('user_id');
            }
        })
        ->latest()
        ->paginate(10)
        ->withQueryString(); // This keeps filters active when clicking page numbers

    return view('admin.reviews.index', compact('reviews'));
}

    public function updateStatus(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|in:0,1,2',
        ]);

        $review->update([
            'status' => $request->status,
            'approved_at' => $request->status == 1 ? now() : null
        ]);

        return back()->with('success', 'Review status updated successfully.');
    }

    public function toggleFeatured(Review $review)
    {
        $review->update(['is_featured' => !$review->is_featured]);
        return back()->with('success', 'Featured status updated.');
    }
}