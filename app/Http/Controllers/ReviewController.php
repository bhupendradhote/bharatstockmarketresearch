<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function index()
    {
        $reviews = Review::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rating-form', compact('reviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'nullable|string|max:255',
            'email'   => 'nullable|email|max:255',
            'rating'  => 'required|integer|min:1|max:5',
            'review'  => 'required|string',
            'country' => 'nullable|string|max:255',
            'state'   => 'nullable|string|max:255',
            'city'    => 'nullable|string|max:255',
            'image'   => 'nullable|image|max:2048',
        ]);

        $review = Review::create([
            'user_id' => auth()->id(),
            'name'    => auth()->check() ? auth()->user()->name : $validated['name'],
            'email'   => auth()->check() ? auth()->user()->email : $validated['email'],
            'rating'  => $validated['rating'],
            'review'  => $validated['review'],
            'country' => $validated['country'] ?? null,
            'state'   => $validated['state'] ?? null,
            'city'    => $validated['city'] ?? null,
            'status'  => auth()->check(),
        ]);

        if ($request->hasFile('image')) {
            $review->addMediaFromRequest('image')
                   ->toMediaCollection('review_images');
        }

        return back()->with('success', 'Thank you! Your review has been submitted.');
    }
}
