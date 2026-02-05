<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageCampaignLog;
use Illuminate\Support\Facades\Log;
class CampaignController extends Controller
{
   
    public function markAsSeen(Request $request)
{
    try {

        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthenticated'
            ], 401);
        }

        $request->validate([
            'campaign_id' => 'required|exists:master_notifications,id'
        ]);

        // Prevent duplicate read rows
        $alreadyRead = \App\Models\MasterNotificationRead::where(
            'master_notification_id',
            $request->campaign_id
        )
        ->where('user_id', auth()->id())
        ->exists();

        if ($alreadyRead) {
            return response()->json([
                'success' => true,
                'message' => 'Already marked as read'
            ]);
        }

        $read = \App\Models\MasterNotificationRead::create([
            'master_notification_id' => $request->campaign_id,
            'user_id' => auth()->id(),
            'read_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $read
        ]);

    } catch (\Throwable $e) {

        Log::error('Master notification read failed', [
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'error' => 'Something went wrong'
        ], 500);
    }
}
}
