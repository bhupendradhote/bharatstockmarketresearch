@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8" x-data="bannerUpload()">
    <div class="max-w-9xl mx-auto px-4">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Offer Banner</h1>
                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-1">
                    Promotional Banner Management
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.offer-banners.index') }}"
                   class="text-sm font-semibold text-gray-400 hover:text-gray-600">
                    Discard
                </a>
                <button form="bannerForm"
                        class="px-6 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow">
                    Save Banner
                </button>
            </div>
        </div>

        <form id="bannerForm"
              action="{{ route('admin.offer-banners.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            @csrf

            <!-- LEFT COLUMN -->
            <div class="lg:col-span-8 space-y-6">

                <!-- CONTENT -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">
                        Banner Content
                    </div>

                    <div class="p-5 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                             <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                Highlight Text
                            </label>
                            <input type="text" name="highlight_text"
                                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                    Main Heading *
                                </label>
                                <input type="text" name="heading" required
                                       class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                              focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                    Sub Heading
                                </label>
                                <input type="text" name="sub_heading"
                                       class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                              focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                Description *
                            </label>
                            <textarea name="content" rows="3" required
                                      class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm resize-none
                                             focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none"></textarea>
                        </div>

                       
                    </div>
                </div>

                <!-- CTA -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">
                        Call To Action Buttons
                    </div>

                    <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- PRIMARY -->
                        <div class="p-4 rounded-xl border border-indigo-200 bg-indigo-50 space-y-3">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-600">
                                Primary Button
                            </span>

                            <input type="text" name="button1_text" placeholder="Button Text" required
                                   class="w-full rounded-lg border border-indigo-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">

                            <input type="url" name="button1_link" placeholder="Button URL" required
                                   class="w-full rounded-lg border border-indigo-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>

                        <!-- SECONDARY -->
                        <div class="p-4 rounded-xl border border-gray-200 bg-gray-50 space-y-3">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                Secondary Button
                            </span>

                            <input type="text" name="button2_text" placeholder="Button Text"
                                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">

                            <input type="url" name="button2_link" placeholder="Button URL"
                                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="lg:col-span-4 space-y-6">

                <!-- SETTINGS -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">
                        Banner Settings
                    </div>

                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Status</label>
                            <select name="is_active"
                                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                           focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                                <option value="1">Published</option>
                                <option value="0">Draft</option>
                            </select>
                        </div>

                        <div class="hidden">
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                Device Visibility
                            </label>
                            <select name="device_visibility"
                                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                           focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                                <option value="all">All Devices</option>
                                <option value="desktop">Desktop</option>
                                <option value="mobile">Mobile</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Start Date</label>
                            <input type="datetime-local" name="start_date"
                                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">End Date</label>
                            <input type="datetime-local" name="end_date"
                                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>
                    </div>
                </div>

                <!-- MEDIA -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">
                        Media Assets
                    </div>

                    <div class="p-5 space-y-4">
                        <!-- DESKTOP -->
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">
                                Desktop Banner
                            </label>
                            <div class="relative h-28 w-full rounded-xl border-2 border-dashed border-gray-200
                                        bg-gray-50 flex items-center justify-center overflow-hidden">
                                <template x-if="desktopPreview">
                                    <img :src="desktopPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!desktopPreview">
                                    <span class="text-xs font-semibold text-gray-400">Upload Desktop</span>
                                </template>
                                <input type="file" name="desktop_image" required
                                       @change="previewFile($event,'desktop')"
                                       class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>

                        <!-- MOBILE -->
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">
                                Mobile Banner
                            </label>
                            <div class="relative h-28 w-full rounded-xl border-2 border-dashed border-gray-200
                                        bg-gray-50 flex items-center justify-center overflow-hidden">
                                <template x-if="mobilePreview">
                                    <img :src="mobilePreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!mobilePreview">
                                    <span class="text-xs font-semibold text-gray-400">Upload Mobile</span>
                                </template>
                                <input type="file" name="mobile_image" required
                                       @change="previewFile($event,'mobile')"
                                       class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
function bannerUpload() {
    return {
        desktopPreview: null,
        mobilePreview: null,
        previewFile(event, type) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                if (type === 'desktop') this.desktopPreview = e.target.result;
                if (type === 'mobile') this.mobilePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}
</script>
@endsection
