<?php

namespace App\Http\Controllers\UserDashboardController;

use App\Http\Controllers\Controller;
use App\Models\Watchlist;
use App\Models\WatchlistScript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        return response()->json(
            Auth::user()->watchlists()->with('scripts')->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:50']);
        
        $watchlist = Auth::user()->watchlists()->create([
            'name' => $request->name
        ]);

        return response()->json($watchlist->load('scripts'));
    }

    // NEW: Update method for renaming
    public function update(Request $request, Watchlist $watchlist)
    {
        if ($watchlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate(['name' => 'required|string|max:50']);
        
        $watchlist->update([
            'name' => $request->name
        ]);

        return response()->json($watchlist);
    }

    public function destroy(Watchlist $watchlist)
    {
        if ($watchlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Optional: Detach scripts first if foreign keys don't cascade automatically
        // $watchlist->scripts()->delete(); 
        
        $watchlist->delete();
        return response()->json(['success' => true]);
    }

    public function addScript(Request $request, Watchlist $watchlist)
    {
        if ($watchlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate(['symbol' => 'required|string']);

        $script = $watchlist->scripts()->create([
            'symbol' => strtoupper($request->symbol),
            'trading_symbol' => strtoupper($request->symbol),
            'exchange' => 'NSE'
        ]);

        return response()->json($script);
    }

    public function removeScript(WatchlistScript $script)
    {
        if ($script->watchlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $script->delete();
        return response()->json(['success' => true]);
    }
}