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


class UserChatController extends Controller
{
    /**
     * User → Admin message send
     */
    public function sendMessage(Request $request)
    {
        try {

            $request->validate([
                'message' => 'required|string|max:2000',
            ]);

            $user = auth()->user();

            if (!$user) {
                throw new \Exception('User not authenticated');
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
               2️⃣ CREATE NOTIFICATION (MASTER)
               SINGLE NOTIFICATION ONLY
            ========================= */
            $notification = Notification::create([
                'type'      => 'chat',
                'title'     => 'New Support Message',
                'message'   => $request->message,
                'url'       => '/admin/chat?user=' . $user->id,
                'sender_id' => $user->id,
                'data'      => [
                    'from_user_id'   => $user->id,
                    'from_user_name' => $user->name  ?? 'User #' . $user->id,
                    'chat_id'        => $chat->id,
                ],
            ]);

            /* =========================
               3️⃣ ATTACH ADMIN (DELIVERY) - UNCOMMENT THIS
               THIS LINKS NOTIFICATION TO ADMIN
            ========================= */
            NotificationUser::create([
                'notification_id' => $notification->id,
                'user_id'         => $adminId,
            ]);

            /* =========================
               4️⃣ PUSHER BROADCAST - MESSAGES
               FOR REAL-TIME CHAT
            ========================= */
            broadcast(new UserChatMessageSent(
                $user->id,
                $adminId,
                $request->message
            ));

            /* =========================
               5️⃣ PUSHER BROADCAST - NOTIFICATION
               FOR REAL-TIME NOTIFICATION IN HEADER
            ========================= */
            $userName = $user->name ?? $user->phone ?? 'User #' . $user->id;
            
            broadcast(new NewChatNotification(
                $user->id,
                $userName,
                $request->message,
                $adminId,
                'chat'
            ));

            Log::info('📨 Single notification created and sent', [
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'message' => $request->message,
                'admin_id' => $adminId
            ]);

            return response()->json(['success' => true]);

        } catch (\Throwable $e) {

            Log::error('❌ Chat Send Error', [
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
}