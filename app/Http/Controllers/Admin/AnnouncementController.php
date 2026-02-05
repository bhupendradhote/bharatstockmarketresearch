<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Events\AnnouncementPublished;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\AnnouncementNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\MasterNotification;
use App\Events\MasterNotificationBroadcast;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch announcements, latest first, with pagination
        $announcements = Announcement::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
  
    


    

        public function store(Request $request)
        {
            $validated = $request->validate([
                'title'   => 'required|string|max:255',
                'type'    => 'required|string|in:Features,Service Update,Others',
                'content' => 'required|string|max:255',
                'detail'  => 'required|string',
                'published_at' => 'nullable|date',
            ]);

            $publishedAt = $validated['published_at'] ?? now();

            // 📢 1️⃣ OLD SYSTEM (keep working)
            $announcement = Announcement::create([
                'title'        => $validated['title'],
                'type'         => $validated['type'],
                'content'      => $validated['content'],
                'detail'       => $validated['detail'],
                'published_at' => $publishedAt,
            ]);

            // 🌍 2️⃣ MASTER NOTIFICATION SYSTEM
            $notification = MasterNotification::create([
                'type'     => 'announcement',
                'severity' => null,

                'title'   => $validated['title'],
                'message' => $validated['content'],

                'data' => [
                    'category'     => $validated['type'],
                    'detail'       => $validated['detail'],
                    'published_at'=> $publishedAt,
                    'announcement_id' => $announcement->id, // link both systems
                    'created_by'  => auth()->id(),
                ],

                'user_id'   => null,
                'is_global' => true,
                'channel'   => 'both',
            ]);

            // 🚀 Realtime broadcast
            broadcast(new MasterNotificationBroadcast($notification));

            return redirect()
                ->route('admin.announcements.index')
                ->with('success', 'Announcement published successfully!');
        }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'type'    => 'required|string|in:Features,Service Update,Others',
            'content' => 'required|string|max:255',
            'detail'  => 'required|string',
            'published_at' => 'nullable|date',
            'is_active' => 'boolean'
        ]);

        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }
}