<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageApiController extends Controller
{
    // ==========================================
    // GET ALL PACKAGES
    // ==========================================
    public function index()
    {
        $packages = Package::with('category')->orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => $packages->map(function ($p) {
                return $this->formatPackage($p);
            })
        ]);
    }

    // ==========================================
    // GET SINGLE PACKAGE
    // ==========================================
    public function show($id)
    {
        $package = Package::with('category')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $this->formatPackage($package)
        ]);
    }

    // ==========================================
    // CREATE PACKAGE
    // ==========================================
    public function store(Request $request)
{
    $request->validate([
        'category_id'         => 'required|exists:package_categories,id',
        'name'                => 'required|string|max:255',
        'description'         => 'nullable|string',
        'features'            => 'nullable|string',
        'amount'              => 'required|numeric|min:0',
        'discount_percentage' => 'nullable|integer|min:0|max:100',
        'discount_amount'     => 'nullable|numeric|min:0',
        'trial_days'          => 'nullable|integer|min:0',
        'duration'            => 'required|integer|min:1',
        'validity_type'       => 'required|in:days,months,years',
        'is_featured'         => 'nullable|boolean',
        'status'              => 'nullable|boolean',
        'telegram_support'    => 'nullable|boolean',
        'max_devices'         => 'nullable|integer|min:1',
        'sort_order'          => 'nullable|integer',
        'thumbnail'           => 'nullable|image|max:2048'
    ]);

    $category = PackageCategory::find($request->category_id);

    $data = $request->except('thumbnail', 'features');
    $data['slug'] = Str::slug($request->name);
    $data['package_type'] = $category->name;

    // FEATURES → JSON ARRAY
    if ($request->filled('features')) {
        $data['features'] = array_map('trim', explode(',', $request->features));
    }

    // DISCOUNT LOGIC
    $price = $request->amount;
    $discount = 0;

    if ($request->filled('discount_percentage')) {
        $discount = ($price * $request->discount_percentage) / 100;
    } elseif ($request->filled('discount_amount')) {
        $discount = $request->discount_amount;
    }

    $data['discount_amount'] = $discount;
    $data['final_amount'] = $price - $discount;

    $package = Package::create($data);

    if ($request->hasFile('thumbnail')) {
        $package->addMediaFromRequest('thumbnail')->toMediaCollection('image');
    }

    return response()->json([
        'success' => true,
        'message' => 'Package created successfully',
        'data' => $this->formatPackage($package)
    ]);
}

    // ==========================================
    // UPDATE PACKAGE
    // ==========================================
public function update(Request $request, $id)
{
    try {
        $package = Package::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'category_id' => 'required|exists:package_categories,id',
            'name'        => 'required|string',
            'amount'      => 'required|numeric',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'thumbnail'   => 'nullable|image',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // CATEGORY
        $category = PackageCategory::find($request->category_id);
        $package->package_type = $category->name;

        // BASIC FIELDS
        $package->name = $request->name;
        $package->amount = $request->amount;
        $package->description = $request->description ?? $package->description;
        $package->duration = $request->duration ?? $package->duration;
        $package->validity_type = $request->validity_type ?? $package->validity_type;
        $package->trial_days = $request->trial_days ?? $package->trial_days;
        $package->meta_title = $request->meta_title ?? $package->meta_title;
        $package->meta_description = $request->meta_description ?? $package->meta_description;
        $package->is_featured = $request->boolean('is_featured');
        $package->status = $request->boolean('status');
        $package->telegram_support = $request->boolean('telegram_support');
        $package->max_devices = $request->max_devices ?? $package->max_devices;
        $package->sort_order = $request->sort_order ?? $package->sort_order;

        // FEATURES → JSON ARRAY
        if ($request->filled('features')) {
            $package->features = array_map('trim', explode(',', $request->features));
        }

        // DISCOUNT
        $discountAmount = 0;
        if ($request->filled('discount_percentage')) {
            $discountAmount = ($package->amount * $request->discount_percentage) / 100;
        } elseif ($request->filled('discount_amount')) {
            $discountAmount = $request->discount_amount;
        }

        $package->discount_amount = $discountAmount;
        $package->final_amount = $package->amount - $discountAmount;

        // THUMBNAIL UPDATE
        if ($request->hasFile('thumbnail')) {
            $package->clearMediaCollection('image');
            $package->addMedia($request->file('thumbnail'))->toMediaCollection('image');
        }

        if (!$package->isDirty()) {
            return response()->json([
                'success' => false,
                'message' => 'No changes detected. Package not updated.',
            ], 200);
        }

        $package->save();

        return response()->json([
            'success' => true,
            'message' => 'Package updated successfully!',
            'package' => $package
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}



    // ==========================================
    // DELETE PACKAGE
    // ==========================================
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return response()->json([
            'success' => true,
            'message' => 'Package deleted successfully'
        ]);
    }

    // ==========================================
    // FORMAT PACKAGE FOR API RESPONSE
    // ==========================================
    private function formatPackage($p)
    {
        return [
            'id' => $p->id,
            'name' => $p->name,
            'slug' => $p->slug,
            'category' => $p->category ? $p->category->name : null,
            'package_type' => $p->package_type,
            'description' => $p->description,
            'features' => $p->features,
            'amount' => $p->amount,
            'discount_amount' => $p->discount_amount,
            'final_amount' => $p->final_amount,
            'duration' => $p->duration,
            'validity_type' => $p->validity_type,
            'trial_days' => $p->trial_days,
            'max_devices' => $p->max_devices,
            'telegram_support' => $p->telegram_support,
            'status' => $p->status,
            'is_featured' => $p->is_featured,
            'sort_order' => $p->sort_order,
            'thumbnail' => $p->getFirstMediaUrl('image'),
            'created_at' => $p->created_at,
            'updated_at' => $p->updated_at,
        ];
    }
}
