<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HeroBannerApiController extends Controller
{
    // ===== LIST ALL HERO BANNERS =====
    public function index()
    {
        $banners = HeroBanner::orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => $banners->map(fn ($b) => $this->bannerResponse($b))
        ]);
    }

    // ===== LIST HERO BANNERS BY PAGE KEY =====
    public function byPage($page_key)
    {
        $banners = HeroBanner::where('page_key', $page_key)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $banners->map(fn ($b) => $this->bannerResponse($b))
        ]);
    }

    // ===== CREATE HERO BANNER =====
public function store(Request $request)
{
    $data = $this->validateBanner($request);

    DB::transaction(function () use ($request, $data, &$banner) {

        // If page_key exists, update that banner
        if (!empty($data['page_key'])) {
            $banner = HeroBanner::where('page_key', $data['page_key'])->first();
        }

        if ($banner ?? false) {
            // UPDATE existing banner
            $banner->update($data);
        } else {
            // CREATE new banner
            $banner = HeroBanner::create($data);
        }

        // Handle media (same logic as before)
        $this->handleMedia($request, $banner);
    });

    return response()->json([
        'success' => true,
        'message' => 'Hero banner saved successfully',
        'data' => $this->bannerResponse($banner)
    ]);
}


    // ===== UPDATE HERO BANNER =====
    public function update(Request $request, $id)
    {
        $banner = HeroBanner::findOrFail($id);

        $data = $this->validateBanner($request);

        $banner->update($data);

        $this->handleMedia($request, $banner);

        return response()->json([
            'success' => true,
            'message' => 'Hero banner updated successfully',
            'data' => $this->bannerResponse($banner)
        ]);
    }

    // ===== DELETE HERO BANNER =====
    public function destroy($id)
    {
        $banner = HeroBanner::findOrFail($id);

        $banner->clearMediaCollection('background');
        $banner->clearMediaCollection('mobile_background');

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hero banner deleted successfully'
        ]);
    }

    // ===== DRAG & DROP REORDER =====
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:hero_banners,id',
        ]);

        foreach ($request->order as $position => $id) {
            HeroBanner::where('id', $id)->update(['sort_order' => $position]);
        }

        return response()->json(['success' => true]);
    }

    // ===== MEDIA PICKER LIST =====
    public function mediaApi()
    {
        $media = Media::orderByDesc('id')->paginate(40);

        return response()->json([
            'data' => $media->map(fn ($m) => $this->mediaFromSpatie($m)),
            'pagination' => [
                'page' => $media->currentPage(),
                'total' => $media->total(),
            ]
        ]);
    }

    // ===== MEDIA UPLOAD =====
    public function mediaUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120'
        ]);

        $temp = new HeroBanner();
        $temp->id = 0;
        $temp->exists = true;

        $media = $temp->addMediaFromRequest('file')
            ->toMediaCollection('global_media');

        return response()->json([
            'success' => true,
            'media' => $this->mediaFromSpatie($media)
        ]);
    }

    // ===== HELPERS =====

    private function validateBanner(Request $request)
    {
        return $request->validate([
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
    }

    private function handleMedia(Request $request, HeroBanner $banner)
    {
        if ($request->hasFile('background_image')) {
            $banner->clearMediaCollection('background');
            $banner->addMediaFromRequest('background_image')->toMediaCollection('background');
        }

        if ($request->hasFile('mobile_background_image')) {
            $banner->clearMediaCollection('mobile_background');
            $banner->addMediaFromRequest('mobile_background_image')->toMediaCollection('mobile_background');
        }

        if ($request->filled('background_media_id')) {
            $banner->clearMediaCollection('background');
            Media::find($request->background_media_id)?->copy($banner, 'background');
        }

        if ($request->filled('mobile_media_id')) {
            $banner->clearMediaCollection('mobile_background');
            Media::find($request->mobile_media_id)?->copy($banner, 'mobile_background');
        }
    }

    private function bannerResponse(HeroBanner $b)
    {
        return [
            'id' => $b->id,
            'page_key' => $b->page_key,
            'badge' => $b->badge,
            'title' => $b->title,
            'subtitle' => $b->subtitle,
            'description' => $b->description,
            'button_text_1' => $b->button_text_1,
            'button_link_1' => $b->button_link_1,
            'button_text_2' => $b->button_text_2,
            'button_link_2' => $b->button_link_2,
            'sort_order' => $b->sort_order,
            'status' => $b->status,
            'background_url' => $b->getFirstMediaUrl('background'),
            'mobile_background_url' => $b->getFirstMediaUrl('mobile_background'),
        ];
    }

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
}
