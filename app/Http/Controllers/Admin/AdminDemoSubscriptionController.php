<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class AdminDemoSubscriptionController extends Controller
{
    // public function index()
    // {
    //     $users = User::with(['subscriptions' => function ($q) {
    //         $q->latest();
    //     }])->get();

    //     return view('admin.demo_subscription.index', compact('users'));
    // }

    public function index(Request $request)
{
    $query = User::query()->with(['subscriptions' => function ($q) {
        $q->latest();
    }]);

    // Filter by Name, Email, or Phone
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%"); // Ensure you have a phone column
        });
    }

    // Filter by Status (Requires slightly more logic for Eloquent)
    if ($request->filled('status')) {
        if ($request->status === 'never') {
            $query->doesntHave('subscriptions');
        } elseif ($request->status === 'active') {
            $query->whereHas('subscriptions', function($q) {
                $q->where('status', 'active')->where('end_date', '>', now());
            });
        
        }
    }

    // Filter by Type (Demo vs Paid)
    if ($request->filled('type')) {
        $query->whereHas('subscriptions', function($q) use ($request) {
            $q->where('payment_status', $request->type);
        });
    }

    $users = $query->paginate(10); // Added pagination for professionalism

    return view('admin.demo_subscription.index', compact('users'));
}

    public function grantDemo(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'days'    => 'required|integer|min:1|max:30',
        ]);

        $lastSub = UserSubscription::where('user_id', $request->user_id)
                    ->latest()
                    ->first();

        // ❌ Block if active subscription exists
        if ($lastSub && $lastSub->isActive()) {
            return back()->with('error', 'User already has active subscription!');
        }

        // ✅ Create demo subscription
        UserSubscription::create([
            'user_id' => $request->user_id,
            'payment_status' => 'demo',
            'start_date' => now(),
            'end_date' => now()->addDays((int) $request->days),    
            'status' => 'active',
        ]);

        return back()->with('success', 'Demo access granted successfully!');
    }
}