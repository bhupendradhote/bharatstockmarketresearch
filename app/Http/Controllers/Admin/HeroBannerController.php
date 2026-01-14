<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HeroBannerController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::orderBy('sort_order')->get();

        $bannersJson = $banners->map(function($b){
    return [
        'id' => $b->id,
        'title' => $b->title,
        'badge' => $b->badge,
        'subtitle' => $b->subtitle,
        'description' => $b->description,
        'page_key' => $b->page_key,
        'status' => $b->status,
        'background_url' => $b->getFirstMediaUrl('background'),
        'mobile_background_url' => $b->getFirstMediaUrl('mobile_background'),
    ];
});
return view('admin.hero_banners.index', compact('banners', 'bannersJson'));

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page_key' => 'nullable|string|max:191',
            'badge' => 'nullable|string|max:191',
            'title' => 'nullable|string|max:191',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'button_text_1' => 'nullable|string|max:191',
            'button_link_1' => 'nullable|string|max:1000',
            'button_text_2' => 'nullable|string|max:191',
            'button_link_2' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',

            // file uploads, not used when media picker is used
            'background_image' => 'nullable|image|max:5120',
            'mobile_background_image' => 'nullable|image|max:5120',

            // media picker IDs
            'background_media_id' => 'nullable|integer|exists:media,id',
            'mobile_media_id' => 'nullable|integer|exists:media,id',
        ]);

        $banner = HeroBanner::create($data);

        /** ----------------------
         * Spatie: File upload method (fallback)
         * ---------------------- */
        if ($request->hasFile('background_image')) {
            $banner->clearMediaCollection('background');
            $banner->addMediaFromRequest('background_image')->toMediaCollection('background');
        }

        if ($request->hasFile('mobile_background_image')) {
            $banner->clearMediaCollection('mobile_background');
            $banner->addMediaFromRequest('mobile_background_image')->toMediaCollection('mobile_background');
        }

        /** ----------------------
         * Spatie: Media Picker (A2)
         * ---------------------- */
        if ($request->filled('background_media_id')) {
            $banner->clearMediaCollection('background');
            $media = Media::find($request->background_media_id);
            if ($media) {
                $media->copy($banner, 'background');
            }
        }

        if ($request->filled('mobile_media_id')) {
            $banner->clearMediaCollection('mobile_background');
            $media = Media::find($request->mobile_media_id);
            if ($media) {
                $media->copy($banner, 'mobile_background');
            }
        }

        return redirect()->route('admin.hero-banners.index')->with('success', 'Hero Banner Created Successfully');
    }

    public function update(Request $request, $id)
    {
        $banner = HeroBanner::findOrFail($id);

        $data = $request->validate([
            'page_key' => 'nullable|string|max:191',
            'badge' => 'nullable|string|max:191',
            'title' => 'nullable|string|max:191',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'button_text_1' => 'nullable|string|max:191',
            'button_link_1' => 'nullable|string|max:1000',
            'button_text_2' => 'nullable|string|max:191',
            'button_link_2' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer',
            'status' => 'nullable|boolean',

            'background_image' => 'nullable|image|max:5120',
            'mobile_background_image' => 'nullable|image|max:5120',

            'background_media_id' => 'nullable|integer|exists:media,id',
            'mobile_media_id' => 'nullable|integer|exists:media,id',
        ]);

        $banner->update($data);

        /** ----------------------
         * File Upload (fallback)
         * ---------------------- */
        if ($request->hasFile('background_image')) {
            $banner->clearMediaCollection('background');
            $banner->addMediaFromRequest('background_image')->toMediaCollection('background');
        }

        if ($request->hasFile('mobile_background_image')) {
            $banner->clearMediaCollection('mobile_background');
            $banner->addMediaFromRequest('mobile_background_image')->toMediaCollection('mobile_background');
        }

        /** ----------------------
         * Spatie Media Picker
         * ---------------------- */
        if ($request->filled('background_media_id')) {
            $banner->clearMediaCollection('background');
            $media = Media::find($request->background_media_id);
            if ($media) {
                $media->copy($banner, 'background');
            }
        }

        if ($request->filled('mobile_media_id')) {
            $banner->clearMediaCollection('mobile_background');
            $media = Media::find($request->mobile_media_id);
            if ($media) {
                $media->copy($banner, 'mobile_background');
            }
        }

        return redirect()->route('admin.hero-banners.index')->with('success', 'Hero Banner Updated Successfully');
    }

    public function destroy($id)
    {
        $banner = HeroBanner::findOrFail($id);

        // delete spatie media
        $banner->clearMediaCollection('background');
        $banner->clearMediaCollection('mobile_background');

        $banner->delete();

        return redirect()->route('admin.hero-banners.index')->with('success', 'Hero Banner Deleted Successfully');
    }

    /**
     * Drag & Drop Reorder
     */
    public function reorder(Request $request)
    {
        $payload = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:hero_banners,id',
        ]);

        foreach ($payload['order'] as $position => $id) {
            HeroBanner::where('id', $id)->update(['sort_order' => $position]);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * A2 — Inline media picker API (returns JSON)
     */
    public function mediaApi(Request $request)
    {
        $media = Media::orderBy('id', 'desc')->paginate(40);

        return response()->json([
            'data' => $media->map(fn($m) => $this->mediaFromSpatie($m)),
            'pagination' => [
                'page' => $media->currentPage(),
                'total' => $media->total(),
            ]
        ]);
    }

    /**
     * A2 — Upload to global media library
     */
    public function mediaUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120'
        ]);

        // Create temp model to attach global media (optional model)
        $temp = new HeroBanner(); // ANY model implementing HasMedia works
        $temp->id = 0; // Fake ID so medialibrary creates a row
        $temp->exists = true;

        $media = $temp->addMediaFromRequest('file')
            ->toMediaCollection('global_media');

        return response()->json([
            'success' => true,
            'media' => $this->mediaFromSpatie($media)
        ]);
    }

    /**
     * Helper — convert Spatie media into JSON form for Alpine
     */
    private function mediaFromSpatie(Media $m)
    {
        return [
            'id' => $m->id,
            'name' => $m->file_name,
            'url' => $m->getFullUrl(),
            'thumb' => $m->hasGeneratedConversion('thumb')
                ? $m->getFullUrl('thumb')
                : $m->getFullUrl(),
        ];
    }
    public function toggleStatus($id)
{
    $banner = HeroBanner::findOrFail($id);

    $banner->status = !$banner->status;
    $banner->save();

    return response()->json([
        'success' => true,
        'status' => $banner->status
    ]);
}

}
