<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PolicyMaster;
use App\Models\PolicyContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PolicyController extends Controller
{
    // Sabhi Policies ki list (Master list)
    public function index()
    {
        $policies = PolicyMaster::with('activeContent')->get();
        return view('admin.policies.index', compact('policies'));
    }

    // Nayi Policy banane ka form
    public function create()
    {
        return view('admin.policies.create');
    }

    // Policy save ya update (new version) karne ka logic
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'content' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Master dhundo ya naya banao
            $master = PolicyMaster::firstOrCreate(
                ['slug' => Str::slug($request->name)],
                [
                    'name' => $request->name,
                    'title' => $request->title,
                    'description' => $request->description
                ]
            );

            // 2. Pichle saare versions ko inactive kar do
            PolicyContent::where('policy_master_id', $master->id)->update(['is_active' => false]);

            // 3. Naya Version number decide karo
            $lastVersion = PolicyContent::where('policy_master_id', $master->id)->max('version_number') ?? 0;

            // 4. Naya Content/Version insert karo
            PolicyContent::create([
                'policy_master_id' => $master->id,
                'content' => $request->content,
                'updates_summary' => $request->updates_summary,
                'version_number' => $lastVersion + 1,
                'is_active' => true,
            ]);
        });

        return redirect()->route('admin.policies.index')->with('success', 'Policy updated/created successfully!');
    }

    // Edit Page: Purana data fetch karne ke liye
public function edit($id)
{
    // Master data aur uska jo abhi LIVE content hai, dono fetch karein
    $policy = PolicyMaster::with('activeContent')->findOrFail($id);
    
    return view('admin.policies.edit', compact('policy'));
}

// Update Logic: Naya version create karne ke liye
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string',
        'content' => 'required',
    ]);

    DB::transaction(function () use ($request, $id) {
        $master = PolicyMaster::findOrFail($id);

        // 1. Master details update karein (agar name/title badla ho)
        $master->update([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
        ]);

        // 2. Pichle active version ko inactive mark karein
        PolicyContent::where('policy_master_id', $master->id)->update(['is_active' => false]);

        // 3. Version number increment karein
        $lastVersion = PolicyContent::where('policy_master_id', $master->id)->max('version_number') ?? 0;

        // 4. INSERT NEW VERSION (Purana data database mein safe rahega)
        PolicyContent::create([
            'policy_master_id' => $master->id,
            'content' => $request->content,
            'updates_summary' => $request->updates_summary, // What's New highlights
            'version_number' => $lastVersion + 1,
            'is_active' => true,
        ]);
    });

    return redirect()->route('admin.policies.index')->with('success', 'New version of policy has been published!');
}
}