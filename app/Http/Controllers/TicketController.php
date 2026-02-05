<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Events\TicketUpdated;
use App\Models\MasterNotification;
use App\Events\MasterNotificationBroadcast;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    // List tickets for the authenticated user
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('user.help-center',compact('tickets'));
    }

    // Create a new ticket
//   public function store(Request $request)
// {
//     Log::info('Ticket submission started', [
//         'user_id' => Auth::id(),
//         'data' => $request->all()
//     ]);

//     $request->validate([
//         'subject' => 'required|string|max:255',
//         'issue' => 'required|string',
//         'other_issue' => 'required_if:issue,other',
//         'description' => 'required|string',
//         'priority' => 'required|in:Low,Medium,High',
//     ], [
//         'other_issue.required_if' => 'Please enter your issue when selecting Other.'
//     ]);

//     Log::info('Ticket validation passed');

//     $finalIssue = $request->issue === 'other'
//         ? $request->other_issue
//         : $request->issue;

//     Log::info('Final issue resolved', [
//         'final_issue' => $finalIssue
//     ]);

//     $ticket = Ticket::create([
//         'user_id' => Auth::id(),
//         'subject' => $request->subject,
//         'issue' => $finalIssue,
//         'description' => $request->description,
//         'priority' => $request->priority,
//         'status' => 'In Progress',
//     ]);

//     if ($request->hasFile('attachment')) {
//         $ticket->addMediaFromRequest('attachment')
//                ->toMediaCollection('tickets');
//     }

//     // Media add karne ke baad, model ko refresh karein taaki media relation load ho jaye
//     $ticket->refresh(); 

//     // Pusher ko bhejte waqt image_url ko manually add karein
//     $ticket->setAttribute('image_url', $ticket->getFirstMediaUrl('tickets'));

//     // Ab event fire karein, ab Pusher message mein image_url jayega
//     event(new TicketUpdated($ticket));

//     Log::info('Ticket created successfully', [
//         'ticket_id' => $ticket->id
//     ]);

//     return redirect()->back()->with('success', 'Ticket raised successfully!');
// }

public function store(Request $request)
{
    try {

        Log::info('🎫 Ticket submission started', [
            'user_id' => Auth::id(),
            'data' => $request->all()
        ]);

        $request->validate([
            'subject' => 'required|string|max:255',
            'issue' => 'required|string',
            'other_issue' => 'required_if:issue,other',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
        ], [
            'other_issue.required_if' => 'Please enter your issue when selecting Other.'
        ]);

        Log::info('✅ Ticket validation passed');

        $finalIssue = $request->issue === 'other'
            ? $request->other_issue
            : $request->issue;

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'issue' => $finalIssue,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'In Progress',
        ]);

        Log::info('📌 Ticket created', ['ticket_id' => $ticket->id]);

        if ($request->hasFile('attachment')) {
            $ticket->addMediaFromRequest('attachment')
                   ->toMediaCollection('tickets');
        }

        $ticket->refresh();
        $ticket->setAttribute('image_url', $ticket->getFirstMediaUrl('tickets'));

        // ===============================
        // 🔔 MASTER NOTIFICATION TO ADMIN
        // ===============================

        $adminId = 1; // or dynamic admin finder

        $notification = MasterNotification::create([
            'type'    => 'ticket',
            'title'   => 'New Support Ticket 🎫',
            'message' => Str::limit($request->subject, 80),

            'data' => [
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'priority' => $request->priority,
                'issue' => $finalIssue,
            ],

            'user_id'   => $adminId,   // ADMIN RECEIVES
            'is_global' => false,
            'channel'   => 'both',
        ]);

        Log::info('🔔 Ticket notification created', [
            'notification_id' => $notification->id,
            'admin_id' => $adminId
        ]);

        // ⚡ Realtime push to admin
        broadcast(new MasterNotificationBroadcast($notification));

        Log::info('📡 Ticket broadcast sent');

        return redirect()->back()->with('success', 'Ticket raised successfully!');

    } catch (\Throwable $e) {

        Log::error('❌ Ticket notification failed', [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return redirect()->back()->with('error', 'Something went wrong!');
    }
}
}