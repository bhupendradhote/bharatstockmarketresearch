<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\MasterNotification;
use App\Models\MasterNotificationRead;
use App\Events\MasterNotificationBroadcast;

use Illuminate\Support\Facades\Auth;
use App\Events\AdminChatMessageSent; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class AdminChatController extends Controller
{
    /**
     * Admin → User message send
     */
        public function sendMessage(Request $request)
        {
            try {

                Log::info('📩 Admin sending chat message', $request->all());

                $request->validate([
                    'to_user_id' => 'required|exists:users,id',
                    'message'    => 'required|string|max:2000',
                ]);

                $admin = Auth::user();
                Log::info('👤 Admin authenticated', ['admin_id' => $admin->id]);

                // 💬 Save chat message
                $chat = ChatMessage::create([
                    'from_user_id' => $admin->id,
                    'to_user_id'   => $request->to_user_id,
                    'message'      => $request->message,
                    'from_role'    => 'admin',
                ]);

                Log::info('✅ Chat saved', ['chat_id' => $chat->id]);

                // 🔔 MASTER notification for user
                $notification = MasterNotification::create([
                    'type'    => 'chat',
                    'title'   => 'New message from Admin',
                    'message' => Str::limit($request->message, 80),

                    'data' => [
                        'chat_id' => $chat->id,
                        'from_id' => $admin->id,
                        'role'    => 'admin',
                    ],

                    'user_id'   => $request->to_user_id,
                    'is_global' => false,

                    'channel' => 'both',
                ]);

                Log::info('🔔 Master notification created', [
                    'notification_id' => $notification->id,
                    'to_user' => $request->to_user_id
                ]);

                // ⚡ Realtime push
                broadcast(new MasterNotificationBroadcast($notification));

                Log::info('📡 Broadcast fired successfully');

                return response()->json([
                    'success' => true,
                    'data' => $chat,
                ]);

            } catch (\Throwable $e) {

                Log::error('❌ Chat notification failed', [
                    'error' => $e->getMessage(),
                    'line'  => $e->getLine(),
                    'file'  => $e->getFile(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong',
                ], 500);
            }
        }

    /**
     * Admin ↔ User conversation fetch
     */
    public function getConversation($userId)
    {
        $adminId = auth()->id();

        $messages = \App\Models\ChatMessage::where(function ($q) use ($adminId, $userId) {
                $q->where('from_user_id', $adminId)
                  ->where('to_user_id', $userId);
            })
            ->orWhere(function ($q) use ($adminId, $userId) {
                $q->where('from_user_id', $userId)
                  ->where('to_user_id', $adminId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    /**
     * Admin inbox – unique users list
     */
    public function inbox()
    {
        $adminId = auth()->id();

        $users = \App\Models\ChatMessage::where('to_user_id', $adminId)
            ->orWhere('from_user_id', $adminId)
            ->with('fromUser')
            ->select('from_user_id')
            ->distinct()
            ->get();

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }


    // public function inboxWithUnread()
    // {
    //     $adminId = auth()->id();

    //     $users = ChatMessage::join('users', 'users.id', '=', 'chat_messages.from_user_id')
    //         ->where(function ($q) use ($adminId) {
    //             $q->where('chat_messages.to_user_id', $adminId)
    //             ->orWhere('chat_messages.from_user_id', $adminId);
    //         })
    //         ->select(
    //             'chat_messages.from_user_id',
    //             'users.name',
    //             'users.phone',
    //             DB::raw('SUM(CASE WHEN chat_messages.is_read = 0 AND chat_messages.to_user_id = '.$adminId.' THEN 1 ELSE 0 END) as unread_count')
    //         )
    //         ->groupBy('chat_messages.from_user_id', 'users.name', 'users.phone')
    //         ->get();

    //     return response()->json([
    //         'success' => true,
    //         'users' => $users
    //     ]);
    // }

    public function inboxWithUnread()
{
    $adminId = auth()->id();

    $users = ChatMessage::join('users', 'users.id', '=', 'chat_messages.from_user_id')

        ->where(function ($q) use ($adminId) {
            $q->where('chat_messages.to_user_id', $adminId)
              ->orWhere('chat_messages.from_user_id', $adminId);
        })

        ->select(
            'chat_messages.from_user_id',
            'users.name',
            'users.phone',

            // ✅ latest message time per user
            DB::raw('MAX(chat_messages.created_at) as last_message_time'),

            // ✅ unread count same as before
            DB::raw('SUM(
                CASE 
                    WHEN chat_messages.is_read = 0 
                    AND chat_messages.to_user_id = '.$adminId.' 
                    THEN 1 
                    ELSE 0 
                END
            ) as unread_count')
        )

        ->groupBy(
            'chat_messages.from_user_id',
            'users.name',
            'users.phone'
        )

        // 🔥 latest chat always on top
        ->orderByDesc('last_message_time')

        ->get();

    return response()->json([
        'success' => true,
        'users' => $users
    ]);
}
    // public function markAsRead($userId)
    // {
    //     $adminId = auth()->id();

    //     ChatMessage::where('from_user_id', $userId)
    //         ->where('to_user_id', $adminId)
    //         ->where('is_read', 0)
    //         ->update(['is_read' => 1]);

    //     return response()->json(['success' => true]);
    // }



public function markAsRead($userId)
{
    $adminId = auth()->id();

    /* ============================
       ✅ Mark chat messages read
    ============================ */
    ChatMessage::where('from_user_id', $userId)
        ->where('to_user_id', $adminId)
        ->where('is_read', 0)
        ->update(['is_read' => 1]);

    /* ============================
       ✅ Mark master notifications read
       (only chat type for this user)
    ============================ */
    $notificationIds = MasterNotification::where('type', 'chat')
        ->where('user_id', $adminId)
        ->where('data->from_user_id', $userId)
        ->pluck('id');

    foreach ($notificationIds as $nid) {
        MasterNotificationRead::updateOrCreate(
            [
                'master_notification_id' => $nid,
                'user_id' => $adminId
            ],
            [
                'read_at' => now()
            ]
        );
    }

    return response()->json(['success' => true]);
}



    
    public function adminNotifications()
    {
        $adminId = auth()->id();

        Log::info('🔔 Admin notifications fetch started', [
            'admin_id' => $adminId
        ]);

        $types = [
            'chat',
            'ticket',
            'login',
            'warning',
            'subscription',
            'disaster'
        ];

        Log::info('📂 Filtering notification types', $types);

        $notifications = MasterNotification::whereIn('type', $types)

            // ✅ ONLY notifications SENT TO ADMIN
            ->where('user_id', $adminId)

            // ❌ REMOVE admin's own sent notifications
            ->where(function ($q) use ($adminId) {
                $q->whereNull('data->from_id')
                ->orWhere('data->from_id', '!=', $adminId);
            })

            // ✅ REMOVE already read
            ->whereNotIn('id', function ($q) use ($adminId) {
                $q->select('master_notification_id')
                ->from('master_notification_reads')
                ->where('user_id', $adminId);
            })

            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        Log::info('📥 Final unread USER notifications', [
            'count' => $notifications->count()
        ]);

        Log::debug('📄 Sample filtered notifications',
            $notifications->take(3)->toArray()
        );

        return response()->json([
            'notifications' => $notifications
        ]);
    }


}