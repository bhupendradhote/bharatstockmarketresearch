<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    /**
     * Return Angel Broking scrip master JSON via server-side proxy.
     */
    public function scripMaster()
    {
        $url = 'https://margincalculator.angelbroking.com/OpenAPI_File/files/OpenAPIScripMaster.json';

        try {
            // timeout and simple fetching
            $response = Http::timeout(15)->get($url);

            if ($response->successful()) {
                // Return raw JSON body and correct content type
                return response($response->body(), 200)
                    ->header('Content-Type', 'application/json');
            }

            return response()->json([
                'error' => 'Upstream fetch failed',
                'status' => $response->status()
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Exception fetching upstream',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
