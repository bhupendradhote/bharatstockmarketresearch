<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Events\UserChatMessageSent;
use App\Events\NewChatNotification;
use Illuminate\Support\Facades\Log;
use App\Models\MasterNotification;
use App\Models\MasterNotificationRead;
use App\Events\MasterNotificationBroadcast;

class UserChatController extends Controller
{
    /**
     * User → Admin message send
     */
    
    public function index()
    {
        $userId = auth()->id();

        /* ======================================
           ✅ Mark all CHAT notifications as read
        ====================================== */

        $chatNotificationIds = MasterNotification::where('type', 'chat')
            ->where('user_id', $userId)   // only for this user
            ->pluck('id');

        foreach ($chatNotificationIds as $id) {
            MasterNotificationRead::updateOrCreate(
                [
                    'master_notification_id' => $id,
                    'user_id' => $userId,
                ],
                [
                    'read_at' => now(),
                ]
            );
        }

        /* ======================================
           📩 Open chat UI
        ====================================== */

        return view('user.chat');
    }

        public function sendMessage(Request $request)
    {
        try {

            $request->validate([
                'message' => 'required|string|max:2000',
            ]);

            $user = auth()->user();

            if (!$user) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            $adminId = 1;

            /* =========================
            1️⃣ SAVE CHAT MESSAGE
            ========================= */
            $chat = ChatMessage::create([
                'from_user_id' => $user->id,
                'to_user_id'   => $adminId,
                'message'      => $request->message,
                'from_role'    => 'user',
                'is_read'      => 0,
            ]);

            /* =========================
            2️⃣ MASTER NOTIFICATION (CHAT)
            ========================= */
            $notification = \App\Models\MasterNotification::create([
                'type'     => 'chat',
                'severity' => 'info',

                'title'   => 'New Support Message',
                'message' => $request->message,

                'data' => [
                    'from_user_id'   => $user->id,
                    'from_user_name' => $user->name ?? 'User #' . $user->id,
                    'chat_id'        => $chat->id,
                    'url'            => '/admin/chat?user=' . $user->id,
                ],

                'is_global' => false,
                'user_id'   => $adminId,
                'channel'   => 'both',
            ]);

            /* =========================
            3️⃣ REALTIME CHAT MESSAGE
            ========================= */
            broadcast(new \App\Events\UserChatMessageSent(
                $user->id,
                $adminId,
                $request->message
            ));

            /* =========================
            4️⃣ REALTIME MASTER NOTIFICATION
            ========================= */
            broadcast(new \App\Events\MasterNotificationBroadcast($notification));

            \Log::info('💬 Chat + MasterNotification sent', [
                'chat_id' => $chat->id,
                'notification_id' => $notification->id,
                'user_id' => $user->id,
                'admin_id' => $adminId
            ]);

            return response()->json(['success' => true]);

        } catch (\Throwable $e) {

            \Log::error('❌ Chat Send Failed', [
                'msg' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Chat history (User ↔ Admin)
     */
    public function history()
    {
        $userId = auth()->id();
        $adminId = 1;

        $messages = ChatMessage::where(function ($q) use ($userId, $adminId) {
                $q->where('from_user_id', $userId)
                  ->where('to_user_id', $adminId);
            })
            ->orWhere(function ($q) use ($userId, $adminId) {
                $q->where('from_user_id', $adminId)
                  ->where('to_user_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get(['id', 'message', 'from_role', 'created_at']);

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }


    /**
     * Chat delete behaviour 
     **/
        public function markNotificationRead($id)
    {
        $userId = auth()->id();

        MasterNotificationRead::updateOrCreate(
            [
                'master_notification_id' => $id,
                'user_id' => $userId,
            ],
            [
                'read_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }
    
    /**
     * Mark All Notifications behaviour 
     **/

    public function markAllNotificationsRead()
{
    $userId = auth()->id();

    // 🔥 get ALL notifications (all types)
    $notificationIds = \App\Models\MasterNotification::pluck('id');

    foreach ($notificationIds as $id) {
        \App\Models\MasterNotificationRead::updateOrCreate(
            [
                'master_notification_id' => $id,
                'user_id' => $userId,
            ],
            [
                'read_at' => now(),
            ]
        );
    }

    return response()->json(['success' => true]);
}
}