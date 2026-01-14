<?php

namespace App\Http\Controllers;

use App\Models\HeaderMenu;
use App\Models\HeaderSetting;

class HeaderController extends Controller
{
    public static function data()
    {
        return [
            'settings' => HeaderSetting::first(),
            'menus' => HeaderMenu::visible()->get(),
        ];
    }
}
