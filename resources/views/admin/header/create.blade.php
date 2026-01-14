@extends('layouts.app')

@section('content')
    <div x-data="{
        showMenu: false,
        existingOrders: @json($orders),
        orderNo: ''
    }" class="mx-auto bg-white shadow rounded-lg p-4">

        <h2 class="text-sm font-semibold mb-3">Add Header Menu + Header Settings</h2>

        <form action="{{ route('admin.header-menus.store') }}" method="POST">
            @csrf

            <!-- ================== HEADER SETTINGS ================== -->
            <div class="border rounded p-3 mb-5 bg-gray-50">
                <h3 class="text-xs font-semibold mb-3">Header Left (Brand Logo + Website Name)</h3>

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <label class="font-medium">Website Name</label>
                        <input type="text" name="website_name" value="{{ $settings->website_name ?? '' }}"
                            class="border w-full px-2 py-1 rounded" required>
                    </div>

                    <div>
                        <label class="font-medium">Logo SVG</label>
                        <textarea name="logo_svg" rows="2" class="border w-full px-2 py-1 rounded text-xs" placeholder="<svg>...">{{ $settings->logo_svg ?? '' }}</textarea>
                    </div>
                </div>

                <hr class="my-4 border-gray-300">

                <h3 class="text-xs font-semibold mb-2">Header Right (CTA Button)</h3>

                <div class="grid grid-cols-3 gap-3 text-xs">
                    <div>
                        <label class="font-medium">CTA Button Text</label>
                        <input type="text" name="button_text" value="{{ $settings->button_text ?? '' }}"
                            class="border w-full px-2 py-1 rounded" placeholder="Sign In / Register">
                    </div>

                    <div>
                        <label class="font-medium">CTA Link</label>
                        <input type="text" name="button_link" value="{{ $settings->button_link ?? '' }}"
                            class="border w-full px-2 py-1 rounded" placeholder="/login">
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <input type="checkbox" name="button_active" value="1"
                            {{ isset($settings) && $settings->button_active ? 'checked' : '' }}>
                        <label class="font-medium">Show Button?</label>
                    </div>
                </div>
            </div>

            <!-- ================== TOGGLE SWITCH ================== -->
            <div class="flex items-center gap-2 mb-3">
                <input type="checkbox" x-model="showMenu" checked class="h-3 w-3">
                <label class="text-xs font-semibold">Add Navigation Menu Item?</label>
            </div>

            <!-- ================== MENU FORM ================== -->
            <div x-show="showMenu" x-transition class="border rounded p-3 bg-white">

                <h3 class="text-xs font-semibold mb-2">Navigation Menu Item</h3>

                <div class="grid grid-cols-3 gap-3 text-xs">

                    <div>
                        <label class="font-medium">Title</label>
                        <input type="text" name="title" x-bind:required="showMenu"
                            class="border w-full px-2 py-1 rounded">
                    </div>

                    <div>
                        <label class="font-medium">Slug</label>
                        <input type="text" name="slug" x-bind:required="showMenu"
                            class="border w-full px-2 py-1 rounded" placeholder="home/about">
                    </div>

                    <div>
                        <label class="font-medium">Link URL</label>
                        <input type="text" name="link" x-bind:required="showMenu"
                            class="border w-full px-2 py-1 rounded" placeholder="/about">
                    </div>

                    <!-- 🟦 ORDER NUMBER with duplicate detection -->
                    <div>
                        <label class="font-medium">Order No</label>
                        <input type="number" name="order_no" x-model="orderNo" x-bind:required="showMenu"
                            @input="
                                if (existingOrders.includes(parseInt(orderNo))) {
                                    alert('⚠️ This order number is already used!');
                                    orderNo = '';
                                }
                            "
                            class="border w-full px-2 py-1 rounded" placeholder="1,2,3...">

                        <!-- inline error msg -->
                        <p x-show="existingOrders.includes(parseInt(orderNo))" class="text-red-600 text-[10px] mt-1">
                            ❗ This order is already in use.
                        </p>
                    </div>

                    <div>
                        <label class="font-medium">Show in Header?</label>
                        <input type="checkbox" name="show_in_header" value="1" checked>
                    </div>

                    <div>
                        <label class="font-medium">Status</label>
                        <input type="checkbox" name="status" value="1" checked>
                    </div>

                </div>

                <div class="mt-3">
                    <label class="text-xs font-medium">SVG Icon (optional)</label>
                    <textarea name="icon_svg" rows="2" class="border w-full px-2 py-1 text-xs rounded" placeholder="<svg>..."></textarea>
                </div>
            </div>

            <!-- ================== SAVE BUTTON ================== -->
            <div class="text-right
                        mt-4">
                <a href="{{ route('admin.header-menus.index') }}" class="bg-gray-300 text-xs px-3 py-1 rounded">
                    Cancel
                </a>

                <button :disabled="existingOrders.includes(parseInt(orderNo))"
                    :class="existingOrders.includes(parseInt(orderNo)) ? 'bg-gray-400 cursor-not-allowed' :
                        'bg-blue-600'"
                    class="text-white text-xs px-3 py-1 rounded">
                    Save Header & Menu
                </button>
            </div>

        </form>
    </div>
@endsection
