<?php

namespace App\Http\Controllers;

use App\Models\FooterColumn;
use App\Models\FooterSetting;
use App\Models\FooterSocialLink;

class FooterController extends Controller
{
    public static function data()
{
    return [
        'settings' => FooterSetting::first(),
        'columns'  => FooterColumn::active()->orderBy('sort_order')->get(),
        'socials'  => FooterSocialLink::active()->orderBy('sort_order')->get(),
        'brand'    => \App\Models\FooterBrandSetting::active()->orderBy('sort_order')->first(),
    ];
}
}
