<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfferBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OfferBannerController extends Controller
{
    public function index()
    {
        $banners = OfferBanner::orderBy('position')->latest()->get();
        return view('admin.offer-banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.offer-banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'content' => 'required|string',
            'button1_text' => 'required|string|max:100',
            'button1_link' => 'required|string',
            'button2_text' => 'required|string|max:100',
            'button2_link' => 'required|string',
            'desktop_image' => 'required|image',
            'mobile_image' => 'required|image',
        ]);

        $banner = OfferBanner::create([
            'slug' => Str::slug($request->heading) . '-' . time(),
            'heading' => $request->heading,
            'sub_heading' => $request->sub_heading,
            'content' => $request->content,
            'highlight_text' => $request->highlight_text,

            'button1_text' => $request->button1_text,
            'button1_link' => $request->button1_link,
            'button1_target' => $request->button1_target,

            'button2_text' => $request->button2_text,
            'button2_link' => $request->button2_link,
            'button2_target' => $request->button2_target,

            'position' => $request->position ?? 0,
            'is_active' => $request->is_active ?? 0,
            'device_visibility' => $request->device_visibility,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        if ($request->hasFile('desktop_image')) {
            $banner->addMedia($request->desktop_image)
                ->toMediaCollection('offer_banner_desktop');
        }

        if ($request->hasFile('mobile_image')) {
            $banner->addMedia($request->mobile_image)
                ->toMediaCollection('offer_banner_mobile');
        }

        return redirect()
            ->route('admin.offer-banners.index')
            ->with('success', 'Offer Banner created successfully');
    }
    
    
        public function edit(OfferBanner $offerBanner)
    {
        return view('admin.offer-banners.edit', compact('offerBanner'));
    }

    public function update(Request $request, OfferBanner $offerBanner)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'content' => 'required|string',
            'button1_text' => 'required|string|max:100',
            'button1_link' => 'required|string',
            'desktop_image' => 'nullable|image',
            'mobile_image' => 'nullable|image',
        ]);
    
        $offerBanner->update([
            'heading' => $request->heading,
            'sub_heading' => $request->sub_heading,
            'content' => $request->content,
            'highlight_text' => $request->highlight_text,
            'button1_text' => $request->button1_text,
            'button1_link' => $request->button1_link,
            'button2_text' => $request->button2_text,
            'button2_link' => $request->button2_link,
            'is_active' => $request->is_active ?? 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    
        if ($request->hasFile('desktop_image')) {
            $offerBanner->clearMediaCollection('offer_banner_desktop');
            $offerBanner->addMedia($request->desktop_image)->toMediaCollection('offer_banner_desktop');
        }
    
        if ($request->hasFile('mobile_image')) {
            $offerBanner->clearMediaCollection('offer_banner_mobile');
            $offerBanner->addMedia($request->mobile_image)->toMediaCollection('offer_banner_mobile');
        }
    
        return redirect()->route('admin.offer-banners.index')->with('success', 'Banner updated successfully');
    }
    public function destroy(OfferBanner $offerBanner)
    {
        // This will automatically delete the database record 
        // and the associated media files from storage.
        $offerBanner->delete();
    
        return redirect()
            ->route('admin.offer-banners.index')
            ->with('success', 'Banner deleted successfully');
    }
    
    
    public function toggleStatus(OfferBanner $offerBanner)
    {
        $offerBanner->update([
            'is_active' => !$offerBanner->is_active
        ]);
    
        return back()->with('success', 'Status updated successfully!');
    }
}
