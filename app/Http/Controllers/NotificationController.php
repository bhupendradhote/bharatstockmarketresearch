<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function fetchNotifications()
    {
        $userId = Auth::id();

        // 1. Get the count of unread notifications
        $unreadCount = DB::table('notification_users')
            ->where('user_id', $userId)
            ->whereNull('read_at') // If read_at is NULL, it's unread
            ->where('is_active', 1)
            ->count();

        // 2. Fetch the actual notifications with details
        $notifications = DB::table('notification_users as nu')
            ->join('notifications as n', 'nu.notification_id', '=', 'n.id')
            ->select(
                'nu.id as tracking_id', // The unique ID for this user's specific notification
                'nu.read_at',
                'nu.created_at',
                'n.title',
                'n.message',
                'n.url',
                'n.type'
            )
            ->where('nu.user_id', $userId)
            ->where('nu.is_active', 1)
            ->orderBy('nu.created_at', 'desc')
            ->limit(20) // Limit to latest 20
            ->get();

        return response()->json([
            'count' => $unreadCount,
            'notifications' => $notifications
        ]);
    }

    // Optional: Route to mark a specific notification as read when clicked
    public function markAsRead($id)
    {
        DB::table('notification_users')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}