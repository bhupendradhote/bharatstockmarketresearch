<?php

namespace App\Http\Controllers\UserDashboardController;

// Necessary imports for a sub-folder controller
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

    public function destroy(Watchlist $watchlist)
    {
        if ($watchlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
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
        // Accessing the relationship to verify ownership
        if ($script->watchlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $script->delete();
        return response()->json(['success' => true]);
    }
}