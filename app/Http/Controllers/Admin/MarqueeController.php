<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marquee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarqueeController extends Controller
{
    /**
     * List all marquees
     */
    public function index()
{
    $marquees = Marquee::orderBy('display_order')->get();

    // Check if marquee already exists
    $hasMarquee = $marquees->count() > 0;

    return view('admin.marquees.index', compact('marquees', 'hasMarquee'));
}


    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.marquees.create');
    }

    /**
     * Store marquee
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'nullable|string|max:255',
            'content'       => 'required|string',
            'start_at'      => 'nullable|date',
            'end_at'        => 'nullable|date|after_or_equal:start_at',
            'display_order' => 'nullable|integer',
        ]);

        Marquee::create([
            'title'         => $request->title,
            'content'       => $request->content,
            'is_active'     => $request->has('is_active'),
            'start_at'      => $request->start_at,
            'end_at'        => $request->end_at,
            'display_order' => $request->display_order ?? 1,
            'created_by'    => Auth::id(),
        ]);

        return redirect()->route('admin.marquees.index')
            ->with('success', 'Marquee created successfully');
    }

    /**
     * Edit marquee
     */
    public function edit(Marquee $marquee)
    {
        return view('admin.marquees.edit', compact('marquee'));
    }

    /**
     * Update marquee
     */
    public function update(Request $request, Marquee $marquee)
    {
        $request->validate([
            'title'         => 'nullable|string|max:255',
            'content'       => 'required|string',
            'start_at'      => 'nullable|date',
            'end_at'        => 'nullable|date|after_or_equal:start_at',
            'display_order' => 'nullable|integer',
        ]);

        $marquee->update([
            'title'         => $request->title,
            'content'       => $request->content,
            'is_active'     => $request->has('is_active'),
            'start_at'      => $request->start_at,
            'end_at'        => $request->end_at,
            'display_order' => $request->display_order ?? 1,
            'updated_by'    => Auth::id(),
        ]);

        return redirect()->route('admin.marquees.index')
            ->with('success', 'Marquee updated successfully');
    }

    /**
     * Delete marquee
     */
    public function destroy(Marquee $marquee)
    {
        $marquee->delete();

        return redirect()->route('admin.marquees.index')
            ->with('success', 'Marquee deleted successfully');
    }

    /**
     * Toggle active status (AJAX-friendly)
     */
    public function toggle(Marquee $marquee)
    {
        $marquee->update([
            'is_active' => ! $marquee->is_active,
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'status' => true,
            'is_active' => $marquee->is_active,
        ]);
    }
}
