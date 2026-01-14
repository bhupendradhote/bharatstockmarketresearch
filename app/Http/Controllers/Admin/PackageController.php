<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('sort_order')->get();

        $totalPackages = $packages->count();
        $featuredPackages = $packages->where('is_featured', 1)->count();
        $activePackages = $packages->where('status', 1)->count();
        $inactivePackages = $packages->where('status', 0)->count();

        return view('admin.packages.index', compact(
            'packages',
            'totalPackages',
            'featuredPackages',
            'activePackages',
            'inactivePackages'
        ));
    }

    public function create()
    {
        $categories = PackageCategory::orderBy('name')->get();
        return view('admin.packages.create', compact('categories'));
    }
public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'category_id'         => 'required|exists:package_categories,id',
        'name'                => 'required|string|max:255',
        'description'         => 'nullable|string',
        'features'            => 'nullable|string', // comma-separated
        'amount'              => 'required|numeric|min:0',
        'discount_percentage' => 'nullable|integer|min:0|max:100',
        'discount_amount'     => 'nullable|numeric|min:0',
        'trial_days'          => 'nullable|integer|min:0',
        'duration'            => 'required|integer|min:1',
        'validity_type'       => 'required|in:days,months,years',
        'meta_title'          => 'nullable|string|max:60',
        'meta_description'    => 'nullable|string|max:160',
        'is_featured'         => 'nullable|boolean',
        'status'              => 'nullable|boolean',
        'max_devices'         => 'nullable|integer|min:1',
        'telegram_support'    => 'nullable|boolean',
        'sort_order'          => 'nullable|integer',
        'thumbnail'           => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        // Fetch category
        $category = PackageCategory::findOrFail($request->category_id);

        // Prepare data
        $data = $request->only([
            'name', 'description', 'amount', 'discount_percentage',
            'trial_days', 'duration', 'validity_type', 'meta_title',
            'meta_description', 'max_devices', 'sort_order'
        ]);

        $data['category_id'] = $request->category_id;
        $data['package_type'] = $category->name;
        $data['slug'] = \Str::slug($request->name);

        // Checkbox flags
        $data['is_featured'] = $request->boolean('is_featured');
        $data['status'] = $request->boolean('status');
        $data['telegram_support'] = $request->boolean('telegram_support');

        // -------------------------------
        // Convert comma-separated features to JSON array
        // -------------------------------
        if ($request->filled('features')) {
            $featuresArray = array_map('trim', explode(',', $request->features));
            $data['features'] = json_encode($featuresArray);
        } else {
            $data['features'] = null;
        }

        // -------------------------------
        // DISCOUNT HANDLING
        // -------------------------------
        $price = $request->amount;
        $discount = 0;

        if ($request->filled('discount_percentage')) {
            $discount = ($price * $request->discount_percentage) / 100;
        } elseif ($request->filled('discount_amount')) {
            $discount = $request->discount_amount;
        }

        $data['discount_amount'] = $discount;
        $data['final_amount'] = $price - $discount;

        // -------------------------------
        // Save Package
        // -------------------------------
        $package = Package::create($data);

        // Thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $package->addMediaFromRequest('thumbnail')->toMediaCollection('image');
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully!');

    } catch (\Exception $e) {
        \Log::error('Package create error: ' . $e->getMessage());
        return back()->withInput()->withErrors([
            'general' => 'Something went wrong!',
            'error_message' => $e->getMessage()
        ]);
    }
}



    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = PackageCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    public function edit(Package $package)
    {
        $categories = PackageCategory::orderBy('name')->get();
        return view('admin.packages.edit', compact('package', 'categories'));
    }

public function update(Request $request, $id)
{
    $package = Package::findOrFail($id);

    // Validation
    $request->validate([
        'category_id' => 'required|exists:package_categories,id',
        'name'        => 'required|string',
        'amount'      => 'required|numeric',
        'discount_percentage' => 'nullable|numeric|min:0|max:100',
        'thumbnail'   => 'nullable|image',
        'features'    => 'nullable|string', // accept comma-separated features
    ]);

    // Get category name
    $category = \App\Models\PackageCategory::find($request->category_id);
    $package->package_type = $category->name;
    $package->name = $request->name;
    $package->amount = $request->amount;

    // Convert comma-separated features into JSON
    if ($request->filled('features')) {
        $featuresArray = array_map('trim', explode(',', $request->features));
        $package->features = json_encode($featuresArray);
    } else {
        $package->features = null;
    }

    $package->discount_percentage = $request->discount_percentage ?? 0;
    $package->duration = $request->duration;
    $package->validity_type = $request->validity_type;
    $package->trial_days = $request->trial_days;
    $package->description = $request->description;

    // SEO
    $package->meta_title = $request->meta_title;
    $package->meta_description = $request->meta_description;

    // Flags
    $package->is_featured = $request->has('is_featured');
    $package->status = $request->has('status');
    $package->telegram_support = $request->has('telegram_support');

    // Other fields
    $package->max_devices = $request->max_devices;
    $package->sort_order = $request->sort_order;

    // ---- CALCULATE DISCOUNT & FINAL AMOUNT ----
    $discountAmount = 0;
    if ($request->filled('discount_percentage')) {
        $discountAmount = ($request->amount * $request->discount_percentage) / 100;
    } elseif ($request->filled('discount_amount')) {
        $discountAmount = $request->discount_amount;
    }
    $package->discount_amount = $discountAmount;
    $package->final_amount = $request->amount - $discountAmount;

    // ---- Thumbnail Update ----
    if ($request->hasFile('thumbnail')) {
        $package->clearMediaCollection('image');
        $package->addMedia($request->file('thumbnail'))->toMediaCollection('image');
    }

    $package->save();

    return redirect()->route('admin.packages.index')
                     ->with('success', 'Package updated successfully!');
}



public function show($id)
{
    $package = Package::with('category')->findOrFail($id);

    $media = $package->getFirstMedia('image'); // thumbnail

    return view('admin.packages.show', compact('package', 'media'));
}



    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
