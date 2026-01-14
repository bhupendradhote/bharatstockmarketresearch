<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestorCharterPolicy;
use App\Models\InvestorCharterPage;
use App\Models\InvestorCharterPolicyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InvestorCharterPolicyController extends Controller
{
    /* ===============================
       INDEX
    =============================== */
    public function index()
    {
        $policies = InvestorCharterPolicy::withCount('pages')
            ->orderByDesc('created_at')
            ->get();
            $activePolicy = InvestorCharterPolicy::with(['pages' => function ($q) {
                $q->where('is_visible', true)->orderBy('page_order');
            }])->where('is_active', true)->first();

            return view('admin.investor_charter_policy.index', compact('policies', 'activePolicy'));


    }

    /* ===============================
       CREATE
    =============================== */
    public function create()
    {
        $nextVersion = $this->generateNextVersion();

        return view('admin.investor_charter_policy.create', compact('nextVersion'));
    }

    /* ===============================
       STORE
    =============================== */
    public function store(Request $request)
        {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',

                'pages.*.page_title' => 'required|string|max:255',
                'pages.*.content' => 'required|string',
            ]);

            DB::transaction(function () use ($request) {

                // Generate version automatically
                $version = $this->generateNextVersion();

                // Archive old active policy
                InvestorCharterPolicy::where('is_active', true)->update([
                    'is_active' => false,
                    'is_archived' => true,
                ]);

                // Create policy
                $policy = InvestorCharterPolicy::create([
                    'title' => $request->title,
                    'version' => $version,
                    'description' => $request->description,
                    'effective_from' => now(),
                    'is_active' => true,
                ]);

                // Create pages
                foreach ($request->pages as $index => $page) {
                    InvestorCharterPage::create([
                        'policy_id' => $policy->id,
                        'page_title' => $page['page_title'],
                        'page_slug' => Str::slug($page['page_title']),
                        'content' => $page['content'],
                        'page_order' => $index + 1,
                    ]);
                }

                // Log
                InvestorCharterPolicyLog::create([
                    'policy_id' => $policy->id,
                    'action' => 'created',
                    'remarks' => "Investor charter policy {$version} created",
                    'performed_by' => auth()->id(),
                ]);
            });

            return redirect()
                ->route('admin.investor-charter-policy.index')
                ->with('success', 'Investor Charter Policy created successfully.');
        }

    /* ===============================
       VERSION GENERATOR
    =============================== */
    private function generateNextVersion()
    {
        $latest = InvestorCharterPolicy::orderByDesc('id')->first();

        if (!$latest || !$latest->version) {
            return 'v1.0';
        }

        [$major, $minor] = array_map(
            'intval',
            explode('.', ltrim($latest->version, 'v'))
        );

        $minor++;

        if ($minor >= 10) {
            $major++;
            $minor = 0;
        }

        return 'v' . $major . '.' . $minor;
    }
}
