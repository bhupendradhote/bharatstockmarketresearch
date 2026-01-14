<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewApiController extends Controller
{
    // ================= FETCH REVIEWS =================
    public function index()
    {
        $reviews = Review::orderBy('created_at', 'desc')
            ->get()
            ->map(function ($review) {
                return [
                    'id'      => $review->id,
                    'name'    => $review->name,
                    'rating'  => $review->rating,
                    'review'  => $review->review,
                    'country' => $review->country,
                    'state'   => $review->state,
                    'city'    => $review->city,
                    'image'   => $review->getFirstMediaUrl('review_images'),
                    'date'    => $review->created_at->format('Y-m-d'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }

    // ================= STORE REVIEW =================
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
            'name'    => auth()->check() ? auth()->user()->name : ($validated['name'] ?? null),
            'email'   => auth()->check() ? auth()->user()->email : ($validated['email'] ?? null),
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

        return response()->json([
            'success' => true,
            'message' => auth()->check()
                ? 'Thank you! Your review is live.'
                : 'Thank you! Your review is submitted for approval.',
            'data' => ['id' => $review->id]
        ]);
    }

    // ================= UPDATE REVIEW =================
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // Optional: allow only owner to update
        if ($review->user_id && auth()->id() !== $review->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'review'  => 'required|string',
            'country' => 'nullable|string|max:255',
            'state'   => 'nullable|string|max:255',
            'city'    => 'nullable|string|max:255',
            'image'   => 'nullable|image|max:2048',
        ]);

        $review->update([
            'rating'  => $validated['rating'],
            'review'  => $validated['review'],
            'country' => $validated['country'] ?? null,
            'state'   => $validated['state'] ?? null,
            'city'    => $validated['city'] ?? null,
        ]);

        if ($request->hasFile('image')) {
            $review->clearMediaCollection('review_images');
            $review->addMediaFromRequest('image')
                ->toMediaCollection('review_images');
        }

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully'
        ]);
    }

    // ================= DELETE REVIEW =================
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Optional: allow only owner or admin
        if ($review->user_id && auth()->id() !== $review->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $review->clearMediaCollection('review_images');
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    }
}
