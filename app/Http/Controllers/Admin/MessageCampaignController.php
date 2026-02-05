<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MessageCampaign;
use App\Events\MessageCampaignBroadcasted;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Models\MasterNotification;
use App\Events\MasterNotificationBroadcast;
use Illuminate\Support\Str;
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
            'image'   => 'nullable|image|max:2048',
        ]);

        try {

            $imageUrl = null;

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('campaigns', 'public');
                $imageUrl = asset('/storage/' . $path);
            }

            // 🎯 MASTER CAMPAIGN NOTIFICATION
            $notification = MasterNotification::create([
                'type'     => 'campaign',
                'severity' => $request->type, // map info/success/warning/danger/offer

                'title'   => $request->title,
                'message' => Str::limit($request->content, 120),

                'data' => [
                    'detail' => $request->content,
                    'image'  => $imageUrl,
                    'created_by' => auth()->id(),
                ],

                'is_global' => true,
                'user_id'   => null,
                'channel'   => 'both',
            ]);

            // ⚡ realtime broadcast
            broadcast(new MasterNotificationBroadcast($notification));

            return redirect()
                ->route('admin.message-campaigns.index')
                ->with('success', 'Campaign sent successfully!');

        } catch (\Throwable $e) {

            Log::error('Campaign failed', [
                'error' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Campaign could not be sent');
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
