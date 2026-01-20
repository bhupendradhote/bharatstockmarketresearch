<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MessageCampaign;
use App\Events\MessageCampaignBroadcasted;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
class MessageCampaignController extends Controller
{
    /**
     * List campaigns
     */
    public function index()
    {
        $campaigns = MessageCampaign::latest()->paginate(10);
        return view('admin.message-campaigns.index', compact('campaigns'));
    }

    /**
     * Create form
     */
    public function create()
    {
        return view('admin.message-campaigns.create');
    }

    /**
     * Store & broadcast campaign
     */


public function store(Request $request)
{
    $request->validate([
        'title'   => 'required|string|max:255',
        'content' => 'required|string',
        'type'    => 'required|in:info,success,warning,danger,offer',
        'image'   => 'nullable|image|max:2048', // 🔑 image validation
    ]);

    try {
        $imageUrl = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('campaigns', 'public');
            $imageUrl = asset('/storage/' . $path);
        }

        $campaign = MessageCampaign::create([
            'title'       => $request->title,
            'description' => $request->description,
            'message'     => $request->message,
            'content'     => $request->content,
            'type'        => $request->type,
            'image'       => $imageUrl, // 🔑 SAVE URL
            'is_active'   => true,
            'starts_at'   => $request->starts_at,
            'ends_at'     => $request->ends_at,
            'created_by'  => auth()->id(),
        ]);

        event(new MessageCampaignBroadcasted($campaign));

        return redirect()
            ->route('admin.message-campaigns.index')
            ->with('success', 'Message campaign sent successfully');

    } catch (\Throwable $e) {
        Log::error('Campaign send failed', ['error' => $e->getMessage()]);

        return back()
            ->withInput()
            ->with('error', 'Message campaign could not be sent');
    }
}


    /**
     * Toggle campaign status
     */
    public function toggle(MessageCampaign $campaign)
    {
        $campaign->update([
            'is_active' => !$campaign->is_active,
        ]);

        return back()->with('success', 'Campaign status updated');
    }

    /**
     * Delete campaign
     */
    public function destroy(MessageCampaign $campaign)
    {
        $campaign->delete();
        return back()->with('success', 'Campaign deleted');
    }
}
