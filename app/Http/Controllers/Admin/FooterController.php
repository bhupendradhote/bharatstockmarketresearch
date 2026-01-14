<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FooterColumn;
use App\Models\FooterLink;
use App\Models\FooterSetting;
use App\Models\FooterSocialLink;
use App\Models\FooterBrandSetting;

class FooterController extends Controller
{
    // MAIN FOOTER BUILDER PAGE
    public function index()
    {
        return view('admin.footer.index', [
            'columns'  => FooterColumn::with('links')->orderBy('sort_order')->get(),
            'settings' => FooterSetting::first() ?? new FooterSetting(),
            'socials'  => FooterSocialLink::orderBy('sort_order')->get(),
            'brand'    => FooterBrandSetting::first() ?? new FooterBrandSetting(),
        ]);
    }

    /* ===========================================
       BRANDING SECTION CRUD
       =========================================== */
    public function updateBrand(Request $request)
    {
        $brand = FooterBrandSetting::firstOrCreate([]);

        $brand->update($request->only([
            'title',
            'subtitle',
            'icon_svg',
            'description',
            'content',
            'note',
            'button_text',
            'button_link',
            'image',
            'status',
            'sort_order'
        ]));

        return back()->with('success', 'Brand section updated successfully.');
    }

    /* ===========================================
       EXISTING CONTROLLERS
       =========================================== */

    // FOOTER COLUMNS
    public function storeColumn(Request $request)
    {
        $request->validate(['title' => 'required']);
        FooterColumn::create([
            'title' => $request->title,
            'sort_order' => FooterColumn::max('sort_order') + 1
        ]);
        return back();
    }

    public function updateColumn(Request $request, $id)
    {
        FooterColumn::findOrFail($id)->update([
            'title' => $request->title
        ]);
        return back();
    }

    public function deleteColumn($id)
    {
        FooterColumn::findOrFail($id)->delete();
        return back();
    }

    public function reorderColumns(Request $request)
    {
        foreach ($request->order as $i => $id) {
            FooterColumn::where('id', $id)->update(['sort_order' => $i]);
        }
        return response()->json(['success' => true]);
    }

    // FOOTER LINKS
    public function storeLink(Request $request)
    {
        $request->validate(['footer_column_id' => 'required', 'label' => 'required']);
        FooterLink::create([
            'footer_column_id' => $request->footer_column_id,
            'label' => $request->label,
            'url' => $request->url,
            'sort_order' => FooterLink::where('footer_column_id', $request->footer_column_id)->max('sort_order') + 1
        ]);
        return back();
    }

    public function updateLink(Request $request, $id)
    {
        FooterLink::findOrFail($id)->update($request->only('label', 'url'));
        return back();
    }

    public function deleteLink($id)
    {
        FooterLink::findOrFail($id)->delete();
        return back();
    }

    public function reorderLinks(Request $request)
    {
        foreach ($request->order as $i => $id) {
            FooterLink::where('id', $id)->update(['sort_order' => $i]);
        }
        return response()->json(['success' => true]);
    }

    // FOOTER SETTINGS
    public function updateSettings(Request $request)
    {
        $settings = FooterSetting::first() ?? new FooterSetting();
        $settings->fill($request->only(['email','address','phone','copyright_text']));
        $settings->save();
        return back();
    }

    // SOCIAL ICONS
    public function storeSocial(Request $request)
    {
        $request->validate(['label' => 'required', 'url' => 'required']);

        FooterSocialLink::create([
            'label' => $request->label,
            'icon' => $request->icon,
            'url' => $request->url,
            'sort_order' => FooterSocialLink::max('sort_order') + 1
        ]);

        return back();
    }

    public function updateSocial(Request $request, $id)
    {
        FooterSocialLink::findOrFail($id)->update($request->only('label','url','icon'));
        return back();
    }

    public function deleteSocial($id)
    {
        FooterSocialLink::findOrFail($id)->delete();
        return back();
    }

    public function reorderSocial(Request $request)
    {
        foreach ($request->order as $i => $id) {
            FooterSocialLink::where('id', $id)->update(['sort_order' => $i]);
        }
        return response()->json(['success' => true]);
    }

    public function moveLink(Request $request)
{
    $request->validate([
        'link_id' => 'required',
        'new_column_id' => 'required',
    ]);

    FooterLink::where('id', $request->link_id)
        ->update([
            'footer_column_id' => $request->new_column_id
        ]);

    return response()->json(['success' => true]);
}

}
