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
            // Debugging: Incoming request check karne ke liye Laravel Logs mein dekhein
            Log::info('Campaign MarkAsSeen Request:', $request->all());

            // Check if user is authenticated
            if (!auth()->check()) {
                return response()->json(['success' => false, 'error' => 'User not authenticated'], 401);
            }

            // Create entry (Single array format)
            $log = MessageCampaignLog::create([
                'message_campaign_id' => $request->campaign_id,
                'user_id'             => auth()->id(),
                'seen_at'             => now(),
                'status'              => 'seen',
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Logged successfully',
                'data'    => $log
            ]);

        } catch (\Exception $e) {
            // Agar database fail hota hai toh full error return karega
            Log::error('Campaign Log Error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString() // Sirf development ke liye
            ], 500);
        }
    }
}
