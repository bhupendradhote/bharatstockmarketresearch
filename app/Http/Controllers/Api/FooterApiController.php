<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FooterColumn;
use App\Models\FooterLink;
use App\Models\FooterSetting;
use App\Models\FooterSocialLink;

class FooterApiController extends Controller
{
    /* ============================================================
     *  GET FULL FOOTER DATA
     * ========================================================== */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'columns' => FooterColumn::with('links')->orderBy('sort_order')->get(),
                'settings' => FooterSetting::first() ?? new FooterSetting(),
                'socials' => FooterSocialLink::orderBy('sort_order')->get(),
            ]
        ], 200);
    }

    /* ============================================================
     *  FOOTER SETTINGS
     * ========================================================== */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'copyright_text' => 'nullable|string',
        ]);

        $settings = FooterSetting::first() ?? new FooterSetting();
        $settings->fill($validated)->save();

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully.',
            'settings' => $settings
        ], 200);
    }

    /* ============================================================
     *  FOOTER COLUMNS
     * ========================================================== */
    public function storeColumn(Request $request)
    {
        $request->validate(['title' => 'required|string']);

        $column = FooterColumn::create([
            'title' => $request->title,
            'sort_order' => FooterColumn::max('sort_order') + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Column created successfully.',
            'column' => $column
        ], 201);
    }

    public function updateColumn(Request $request, $id)
    {
        $column = FooterColumn::findOrFail($id);

        $request->validate(['title' => 'required|string']);

        $column->update(['title' => $request->title]);

        return response()->json([
            'success' => true,
            'message' => 'Column updated successfully.',
            'column' => $column
        ]);
    }

    public function deleteColumn($id)
    {
        FooterColumn::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Column deleted successfully.'
        ]);
    }

    public function reorderColumns(Request $request)
    {
        $request->validate([
            'order' => 'required|array'
        ]);

        foreach ($request->order as $i => $id) {
            FooterColumn::where('id', $id)->update(['sort_order' => $i]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Columns reordered successfully.'
        ]);
    }

    /* ============================================================
     *  FOOTER LINKS
     * ========================================================== */
    public function storeLink(Request $request)
    {
        $request->validate([
            'footer_column_id' => 'required|exists:footer_columns,id',
            'label' => 'required|string',
            'url' => 'nullable|string'
        ]);

        $link = FooterLink::create([
            'footer_column_id' => $request->footer_column_id,
            'label' => $request->label,
            'url' => $request->url,
            'sort_order' => FooterLink::where('footer_column_id', $request->footer_column_id)->max('sort_order') + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Link created successfully.',
            'link' => $link
        ], 201);
    }

    public function updateLink(Request $request, $id)
    {
        $link = FooterLink::findOrFail($id);

        $request->validate([
            'label' => 'required|string',
            'url'   => 'nullable|string'
        ]);

        $link->update($request->only('label', 'url'));

        return response()->json([
            'success' => true,
            'message' => 'Link updated successfully.',
            'link' => $link
        ]);
    }

    public function deleteLink($id)
    {
        FooterLink::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Link deleted successfully.'
        ]);
    }

    public function reorderLinks(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'column_id' => 'required|exists:footer_columns,id'
        ]);

        foreach ($request->order as $i => $id) {
            FooterLink::where('id', $id)->update(['sort_order' => $i]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Links reordered successfully.'
        ]);
    }

    /* ============================================================
     *  SOCIAL ICONS
     * ========================================================== */
    public function storeSocial(Request $request)
    {
        $request->validate([
            'label' => 'required|string',
            'icon'  => 'nullable|string',
            'url'   => 'required|string'
        ]);

        $social = FooterSocialLink::create([
            'label' => $request->label,
            'icon' => $request->icon,
            'url' => $request->url,
            'sort_order' => FooterSocialLink::max('sort_order') + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Social icon added successfully.',
            'social' => $social
        ], 201);
    }

    public function updateSocial(Request $request, $id)
    {
        $social = FooterSocialLink::findOrFail($id);

        $request->validate([
            'label' => 'required|string',
            'icon'  => 'nullable|string',
            'url'   => 'required|string'
        ]);

        $social->update($request->only('label', 'url', 'icon'));

        return response()->json([
            'success' => true,
            'message' => 'Social icon updated successfully.',
            'social' => $social
        ]);
    }

    public function deleteSocial($id)
    {
        FooterSocialLink::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Social icon deleted successfully.'
        ]);
    }

    public function reorderSocial(Request $request)
    {
        $request->validate([
            'order' => 'required|array'
        ]);

        foreach ($request->order as $i => $id) {
            FooterSocialLink::where('id', $id)->update(['sort_order' => $i]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Social icons reordered successfully.'
        ]);
    }
}
