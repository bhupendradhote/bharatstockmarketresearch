<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeaderMenu;
use App\Models\HeaderSetting;
use Illuminate\Http\Request;

class HeaderMenuApiController extends Controller
{
    // ===============================
    // GET ALL MENUS + SETTINGS
    // ===============================
    public function index()
    {
        return response()->json([
            'success' => true,
            'settings' => HeaderSetting::first(),
            'menus' => HeaderMenu::orderBy('order_no')->get()
        ]);
    }

    // ===============================
    // GET SETTINGS ONLY (optional)
    // ===============================
    public function settings()
    {
        return response()->json([
            'success' => true,
            'data' => HeaderSetting::first()
        ]);
    }

    // ===============================
    // STORE MENU + UPDATE SETTINGS
    // ===============================
    public function store(Request $request)
    {
        // Update settings (always ID = 1)
        HeaderSetting::updateOrCreate(
            ['id' => 1],
            [
                'website_name'  => $request->website_name,
                'logo_svg'      => $request->logo_svg,
                'button_text'   => $request->button_text,
                'button_link'   => $request->button_link,
                'button_active' => $request->button_active ? 1 : 0,
            ]
        );

        // Insert menu only if it exists
        if ($request->title) {
            $request->validate([
                'title'    => 'required|string|max:100',
                'slug'     => 'required|string|unique:header_menus,slug',
                'link'     => 'required|string',
                'order_no' => 'required|integer|unique:header_menus,order_no',
            ]);

            $menu = HeaderMenu::create([
                'icon_svg'       => $request->icon_svg,
                'title'          => $request->title,
                'slug'           => $request->slug,
                'link'           => $request->link,
                'order_no'       => $request->order_no,
                'show_in_header' => $request->show_in_header ? 1 : 0,
                'status'         => $request->status ? 1 : 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu created successfully',
                'data' => $menu
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
        ]);
    }

    // ===============================
    // TOGGLE STATUS
    // ===============================
    public function toggleStatus(HeaderMenu $menu)
    {
        $menu->status = !$menu->status;
        $menu->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated',
            'status'  => $menu->status
        ]);
    }

    // ===============================
    // QUICK UPDATE EDIT MODAL
    // ===============================
    public function quickUpdate(Request $request, HeaderMenu $menu)
    {
        $data = $request->only('title', 'slug', 'link', 'order_no');
        $data['show_in_header'] = $request->has('show_in_header') ? 1 : 0;

        $menu->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Menu updated successfully',
            'data' => $menu
        ]);
    }

    // ===============================
    // DELETE MENU
    // ===============================
    public function destroy(HeaderMenu $menu)
    {
        $menu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu deleted'
        ]);
    }
}
