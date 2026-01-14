<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderMenu;
use App\Models\HeaderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeaderMenuController extends Controller
{
    public function index()
    {
        $menus = HeaderMenu::orderBy('order_no')->paginate(10);
        $settings = HeaderSetting::first(); // ADD THIS

        return view('admin.header.index', compact('menus', 'settings'));
    }

   public function create()
{
    $count = HeaderMenu::where('show_in_header', 1)->count();
    // if ($count >= 7) {
    //     return redirect()->route('admin.header-menus.index')
    //         ->with('error', 'You can only show maximum 7 menus in header.');
    // }

    // 🟦 Fetch old settings if exist
    $settings = HeaderSetting::first();
      $orders = HeaderMenu::pluck('order_no'); 

    return view('admin.header.create', compact('settings','orders'));
}

 public function store(Request $request)
{
    // 🟦 Update/Create Header Settings (ONLY ONE RECORD)
    HeaderSetting::updateOrCreate(
        ['id' => 1], // always first record
        [
            'website_name'  => $request->website_name,
            'logo_svg'      => $request->logo_svg,
            'button_text'   => $request->button_text,
            'button_link'   => $request->button_link,
            'button_active' => $request->button_active ? 1 : 0,
        ]
    );

    // 🟥 If menu switched ON then insert menu
    if ($request->title) {
        $request->validate([
            'title'    => 'required|string|max:100',
            'slug'     => 'required|string|unique:header_menus,slug',
            'link'     => 'required|string',
            'order_no' => 'required|integer|unique:header_menus,order_no',
        ]);

        HeaderMenu::create([
            'icon_svg'       => $request->icon_svg,
            'title'          => $request->title,
            'slug'           => $request->slug,
            'link'           => $request->link,
            'order_no'       => $request->order_no,
            'show_in_header' => $request->show_in_header ? 1 : 0,
            'status'         => $request->status ? 1 : 0,
        ]);
    }

    return redirect()->route('admin.header-menus.index')
        ->with('success', 'Header updated successfully!');
}

 public function toggleStatus(HeaderMenu $menu)
{
    $menu->show_in_header = ! $menu->show_in_header;
    $menu->save();

    return response()->json([
        'success' => true,
        'status' => $menu->show_in_header
    ]);
}

    public function quickUpdate(Request $request, HeaderMenu $menu)
    {
        $data = $request->only('title','slug','link','order_no');

        // checkbox fix
        $data['show_in_header'] = $request->has('show_in_header') ? 1 : 0;

        $menu->update($data);

        return redirect()->back()->with('success', 'Menu Updated Successfully');
    }



    public function destroy(HeaderMenu $header_menu)
    {
        $header_menu->delete();
        return back()->with('success', 'Menu deleted successfully!');
    }



public function reorder(Request $request)
{
    $orders = $request->input('order');

    // Safety check
    if (!is_array($orders) || empty($orders)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid order payload'
        ], 422);
    }

    DB::transaction(function () use ($orders) {

        /**
         * STEP 1:
         * Temporarily shift all order_no to a high number
         * so UNIQUE conflict never happens
         */
        foreach ($orders as $index => $id) {
            HeaderMenu::where('id', $id)->update([
                'order_no' => $index + 1000
            ]);
        }

        /**
         * STEP 2:
         * Set final correct order (1,2,3...)
         */
        foreach ($orders as $index => $id) {
            HeaderMenu::where('id', $id)->update([
                'order_no' => $index + 1
            ]);
        }
    });

    return response()->json([
        'success' => true
    ]);
}

public function appendLink(Request $request) 
{
    $request->validate([
        'title' => 'required|string|max:255',
        'link'  => 'nullable|string',
    ]);

    // Get the current highest order number, default to 0 if none exist
    $maxOrder = HeaderMenu::max('order_no') ?? 0;

    HeaderMenu::create([
        'title'          => $request->title,
        'slug'           => $request->title,
        'link'           => $request->link,
        'order_no'       => $maxOrder + 1, // Automatically set to last position
        'show_in_header' => $request->has('show_in_header'), 
    ]);

    return back()->with('success', 'Menu item added successfully!');
}
}
