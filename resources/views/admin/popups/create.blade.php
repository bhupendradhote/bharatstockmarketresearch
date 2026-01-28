{{-- @extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-10">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Create New Popup</h1>
                <p class="text-sm text-gray-500">Configure your marketing and notification overlays.</p>
            </div>
            <a href="{{ route('admin.popups.index') }}"
                class="text-sm font-medium text-gray-600 hover:text-gray-800 transition">
                &larr; Back to List
            </a>
        </div>

        <form action="{{ route('admin.popups.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">General Information
                        </h2>

                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Popup Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                placeholder="e.g. Summer Sale 2024"
                                class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Short Description</label>
                            <textarea name="description" rows="2" placeholder="Internal notes or brief summary..."
                                class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Popup Body Content</label>
                            <div class="rounded-lg overflow-hidden border border-gray-300">
                                <textarea name="content" id="editor">{{ old('content') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl border border-dashed border-gray-300 p-6">
                        <h2 class="text-sm font-semibold text-gray-600 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Call to Action (Optional)
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Button Text</label>
                                <input type="text" name="button_text" placeholder="e.g. Shop Now"
                                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Button URL</label>
                                <input type="text" name="button_url" placeholder="https://..."
                                    class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-sm font-semibold text-gray-700 mb-4">Featured Image</h2>
                        <div class="mt-2 flex flex-col items-center">
                            <div id="image-preview-container"
                                class="hidden mb-4 w-full h-48 rounded-lg border-2 border-dashed border-gray-300 overflow-hidden bg-gray-50">
                                <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-contain">
                            </div>

                            <label
                                class="w-full flex flex-col items-center px-4 py-4 bg-white text-blue-600 rounded-lg shadow-sm border border-blue-200 cursor-pointer hover:bg-blue-50 transition tracking-wide text-sm font-semibold">
                                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                <span>Select Image</span>
                                <input type='file' name="image" id="image-input" class="hidden" accept="image/*" />
                            </label>
                            <p class="text-[10px] text-gray-400 mt-2 text-center uppercase">Recommended: 800x600px (PNG,
                                JPG)</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-sm font-semibold text-gray-700 mb-4">Settings</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Popup Type</label>
                                <select name="type" class="w-full border rounded px-3 py-2">
                                    <option value="">-- Select Type --</option>
                                    <option value="notification">Notification</option>
                                    <option value="offer">Offer</option>
                                    <option value="policy">Policy</option>
                                    <option value="image">Image</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Priority</label>
                                <input type="number" name="priority" value="0"
                                    class="w-full text-sm border-gray-300 rounded-lg">
                            </div>

                            <div class="pt-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_dismissible" value="1" checked
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-700">Dismissible</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg shadow-lg hover:bg-indigo-700 hover:shadow-indigo-200 transition-all duration-200 transform hover:-translate-y-0.5">
                            Publish Popup
                        </button>
                        <button type="button"
                            class="w-full mt-3 bg-white text-gray-500 font-semibold py-2 text-sm hover:text-gray-700 transition">
                            Save as Draft
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('editor', {
            height: 250,
            uiColor: '#F9FAFB',
            removeButtons: 'About,Maximize,Source'
        });

        // Image Preview Logic
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');

        imageInput.onchange = evt => {
            const [file] = imageInput.files;
            if (file) {
                previewContainer.classList.remove('hidden');
                imagePreview.src = URL.createObjectURL(file);
            }
        }
    </script>

    <style>
        /* Custom refinements for CKEditor to match the UI */
        .cke_chrome {
            border: none !important;
            box-shadow: none !important;
        }

        .cke_bottom {
            background: #f9fafb !important;
        }
    </style>
@endsection --}}


@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.popups.index') }}"
                        class="group p-2 bg-white rounded-xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-all">
                        <svg class="w-5 h-5 text-slate-500 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Campaign <span
                                class="text-indigo-600">Builder</span></h1>
                        <p class="text-sm text-slate-500 font-medium">Design and deploy your website's next high-converting
                            overlay.</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="window.history.back()"
                        class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition">Discard</button>
                    <button form="popupForm" type="submit"
                        class="px-8 py-3 bg-blue-700 text-white text-sm font-black uppercase tracking-widest rounded-xl shadow-xl shadow-slate-200 hover:bg-blue-600 transition-all active:scale-95">
                        Launch Campaign
                    </button>
                </div>
            </div>

            <form id="popupForm" action="{{ route('admin.popups.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    <div class="lg:col-span-8 space-y-8">

                        <div
                            class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 transition-all hover:shadow-md">
                            <div class="flex items-center gap-3 mb-8">
                                <div
                                    class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Core Configuration
                                </h2>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-500 uppercase tracking-[0.1em] mb-2">Campaign
                                        Title <span class="text-rose-500">*</span></label>
                                    <input type="text" name="title" value="{{ old('title') }}" required
                                        placeholder="e.g., BLACK FRIDAY 50% OFF"
                                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition-all text-slate-900 font-bold placeholder:text-slate-300">
                                    @error('title')
                                        <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-500 uppercase tracking-[0.1em] mb-2">Internal
                                        Note (Description)</label>
                                    <input type="text" name="description" value="{{ old('description') }}"
                                        placeholder="Brief summary for your admin team..."
                                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition-all text-slate-900 font-medium placeholder:text-slate-300">
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-500 uppercase tracking-[0.1em] mb-2">Popup
                                        Messaging</label>
                                    <div class="rounded-2xl overflow-hidden border border-slate-100">
                                        <textarea name="content" id="editor">{{ old('content') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-indigo-900 rounded-[2rem] p-8 shadow-2xl shadow-indigo-100 relative overflow-hidden group">
                            <div
                                class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-800 rounded-full blur-3xl opacity-50 group-hover:scale-110 transition-transform duration-1000">
                            </div>

                            <div class="relative z-10">
                                <div class="flex items-center gap-3 mb-8 text-white">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center border border-white/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-black uppercase tracking-tight">Call to Action</h2>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-indigo-300 uppercase tracking-widest mb-2">Button
                                            Label</label>
                                        <input type="text" name="button_text" placeholder="e.g., Claim Reward"
                                            class="w-full px-5 py-4 bg-white/10 border border-white/10 rounded-2xl focus:ring-2 focus:ring-white/30 text-white placeholder:text-white/30 transition-all font-bold">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-indigo-300 uppercase tracking-widest mb-2">Target
                                            URL</label>
                                        <input type="text" name="button_url" placeholder="https://yourstore.com/deal"
                                            class="w-full px-5 py-4 bg-white/10 border border-white/10 rounded-2xl focus:ring-2 focus:ring-white/30 text-white placeholder:text-white/30 transition-all font-bold">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-4 space-y-8">

                        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8">
                            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6">Visual Asset</h2>

                            <div id="image-preview-container" class="relative group cursor-pointer mb-4">
                                <div id="preview-placeholder"
                                    class="w-full h-56 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[1.5rem] flex flex-col items-center justify-center transition-all group-hover:bg-slate-100">
                                    <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tap to
                                        Upload</span>
                                </div>
                                <img id="image-preview" src="#" alt="Preview"
                                    class="hidden w-full h-56 object-cover rounded-[1.5rem] shadow-lg">

                                <label class="absolute inset-0 cursor-pointer">
                                    <input type='file' name="image" id="image-input" class="hidden"
                                        accept="image/*" />
                                </label>
                            </div>
                            <p class="text-[9px] text-slate-400 text-center font-bold leading-relaxed uppercase">High
                                resolution PNG/JPG<br>Recommended: 1080x1080px</p>
                        </div>

                        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8">
                            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6">Campaign Rules
                            </h2>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Display
                                        Category</label>
                                    <select name="type"
                                        class="w-full p-4 bg-slate-50 border-none rounded-xl text-slate-800 font-bold focus:ring-2 focus:ring-indigo-500/20">
                                        <option value="notification">Notification</option>
                                        <option value="offer">Offer</option>
                                        <option value="policy">Policy</option>
                                        <option value="image">Image</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Stack
                                        Priority (Higher First)</label>
                                    <input type="number" name="priority" value="0"
                                        class="w-full p-4 bg-slate-50 border-none rounded-xl text-slate-800 font-black focus:ring-2 focus:ring-indigo-500/20">
                                </div>

                                <div class="p-4 bg-slate-50 rounded-2xl flex items-center justify-between">
                                    <span class="text-xs font-black text-slate-600 uppercase">Allow Dismiss</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_dismissible" value="1" checked
                                            class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-emerald-50 rounded-[2rem] p-6 border border-emerald-100">
                            <h4
                                class="text-xs font-black text-emerald-700 uppercase mb-2 tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 10-2 0v1a1 1 0 102 0zM14.243 15.657a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM10 14a4 4 0 100-8 4 4 0 000 8z" />
                                </svg>
                                Optimization Tip
                            </h4>
                            <p class="text-[10px] text-emerald-600 font-bold uppercase leading-relaxed">Popups with CTA
                                buttons have a 40% higher conversion rate. Always link to a direct landing page.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        // CKEditor Styling to match theme
        CKEDITOR.replace('editor', {
            height: 300,
            uiColor: '#ffffff',
            contentsCss: ['https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css'],
            removeButtons: 'About,Maximize,Source,Image,Table,HorizontalRule,SpecialChar',
            toolbarGroups: [{
                    name: 'basicstyles',
                    groups: ['basicstyles', 'cleanup']
                },
                {
                    name: 'paragraph',
                    groups: ['list', 'indent', 'blocks', 'align', 'bidi']
                },
                {
                    name: 'links'
                },
                {
                    name: 'styles'
                },
                {
                    name: 'colors'
                },
            ]
        });

        // Image Preview with toggle
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const placeholder = document.getElementById('preview-placeholder');

        imageInput.onchange = evt => {
            const [file] = imageInput.files;
            if (file) {
                placeholder.classList.add('hidden');
                imagePreview.classList.remove('hidden');
                imagePreview.src = URL.createObjectURL(file);
            }
        }
    </script>

    <style>
        /* Premium refinements */
        .cke_chrome {
            border: 1px solid #f1f5f9 !important;
            border-radius: 1rem !important;
            overflow: hidden;
        }

        .cke_top {
            background: #f8fafc !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        .cke_bottom {
            background: #ffffff !important;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endsection
