@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8" 
         x-data="bannerUpload('{{ $offerBanner->getFirstMediaUrl('offer_banner_desktop') }}', '{{ $offerBanner->getFirstMediaUrl('offer_banner_mobile') }}')">
        <div class="max-w-9xl mx-auto px-4">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Offer Banner</h1>
                    <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-1">
                        Updating: {{ $offerBanner->heading }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.offer-banners.index') }}" class="text-sm font-semibold text-gray-400 hover:text-gray-600">
                        Cancel
                    </a>
                    <button form="bannerForm" class="px-6 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow">
                        Update Banner
                    </button>
                </div>
            </div>

            <form id="bannerForm" action="{{ route('admin.offer-banners.update', $offerBanner->id) }}" method="POST"
                enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                @csrf
                @method('PUT')

                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                        <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">
                            Banner Content
                        </div>

                        <div class="p-5 space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Highlight Text</label>
                                    <input type="text" name="highlight_text" value="{{ $offerBanner->highlight_text }}"
                                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Main Heading *</label>
                                    <input type="text" name="heading" required value="{{ $offerBanner->heading }}"
                                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Sub Heading</label>
                                    <input type="text" name="sub_heading" value="{{ $offerBanner->sub_heading }}"
                                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Description *</label>
                                <textarea name="content" rows="3" required
                                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm resize-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">{{ $offerBanner->content }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                        <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">Call To Action</div>
                        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 rounded-xl border border-indigo-200 bg-indigo-50 space-y-3">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-600">Primary Button</span>
                                <input type="text" name="button1_text" value="{{ $offerBanner->button1_text }}" required class="w-full rounded-lg border border-indigo-200 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                                <input type="url" name="button1_link" value="{{ $offerBanner->button1_link }}" required class="w-full rounded-lg border border-indigo-200 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                            </div>
                            <div class="p-4 rounded-xl border border-gray-200 bg-gray-50 space-y-3">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Secondary Button</span>
                                <input type="text" name="button2_text" value="{{ $offerBanner->button2_text }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                                <input type="url" name="button2_link" value="{{ $offerBanner->button2_link }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                        <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">Settings</div>
                        <div class="p-5 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Status</label>
                                <select name="is_active" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                                    <option value="1" {{ $offerBanner->is_active ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ !$offerBanner->is_active ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Start Date</label>
                                <input type="datetime-local" name="start_date" value="{{ $offerBanner->start_date ? date('Y-m-d\TH:i', strtotime($offerBanner->start_date)) : '' }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">End Date</label>
                                <input type="datetime-local" name="end_date" value="{{ $offerBanner->end_date ? date('Y-m-d\TH:i', strtotime($offerBanner->end_date)) : '' }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                        <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">Media Assets</div>
                        <div class="p-5 space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Desktop Banner</label>
                                <div class="relative h-32 w-full rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 flex items-center justify-center overflow-hidden">
                                    <template x-if="desktopPreview">
                                        <img :src="desktopPreview" class="w-full h-full object-cover">
                                    </template>
                                    <input type="file" name="desktop_image" @change="previewFile($event,'desktop')" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Mobile Banner</label>
                                <div class="relative h-32 w-full rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 flex items-center justify-center overflow-hidden">
                                    <template x-if="mobilePreview">
                                        <img :src="mobilePreview" class="w-full h-full object-cover">
                                    </template>
                                    <input type="file" name="mobile_image" @change="previewFile($event,'mobile')" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bannerUpload(existingDesktop, existingMobile) {
            return {
                desktopPreview: existingDesktop || null,
                mobilePreview: existingMobile || null,
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