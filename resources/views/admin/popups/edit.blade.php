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
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit <span
                                class="text-indigo-600">Campaign</span></h1>
                        <p class="text-sm text-slate-500 font-medium">Refine your overlay settings and live updates.</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="window.location='{{ route('admin.popups.index') }}'"
                        class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition">Cancel</button>
                    <button form="popupForm" type="submit"
                        class="px-8 py-3 bg-slate-900 text-white text-sm font-black uppercase tracking-widest rounded-xl shadow-xl shadow-slate-200 hover:bg-indigo-600 transition-all active:scale-95">
                        Update Campaign
                    </button>
                </div>
            </div>

            <form id="popupForm" action="{{ route('admin.popups.update', $popup->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                                    <input type="text" name="title" value="{{ old('title', $popup->title) }}" required
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
                                    <input type="text" name="description"
                                        value="{{ old('description', $popup->description) }}"
                                        placeholder="Brief summary for your admin team..."
                                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition-all text-slate-900 font-medium placeholder:text-slate-300">
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-black text-slate-500 uppercase tracking-[0.1em] mb-2">Popup
                                        Messaging</label>
                                    <div class="rounded-2xl overflow-hidden border border-slate-100">
                                        <textarea name="content" id="editor">{{ old('content', $popup->content) }}</textarea>
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
                                        <input type="text" name="button_text"
                                            value="{{ old('button_text', $popup->button_text) }}"
                                            placeholder="e.g., Claim Reward"
                                            class="w-full px-5 py-4 bg-white/10 border border-white/10 rounded-2xl focus:ring-2 focus:ring-white/30 text-white placeholder:text-white/30 transition-all font-bold">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-indigo-300 uppercase tracking-widest mb-2">Target
                                            URL</label>
                                        <input type="text" name="button_url"
                                            value="{{ old('button_url', $popup->button_url) }}"
                                            placeholder="https://yourstore.com/deal"
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
                                    class="{{ $popup->image ? 'hidden' : '' }} w-full h-56 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[1.5rem] flex flex-col items-center justify-center transition-all group-hover:bg-slate-100">
                                    <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tap to
                                        Update</span>
                                </div>

                                <img id="image-preview"
                                    src="{{ $popup->image ? asset('public/storage/' . $popup->image) : '#' }}" alt="Preview"
                                    class="{{ $popup->image ? '' : 'hidden' }} w-full h-56 object-cover rounded-[1.5rem] shadow-lg">

                                <label class="absolute inset-0 cursor-pointer">
                                    <input type='file' name="image" id="image-input" class="hidden"
                                        accept="image/*" />
                                </label>
                            </div>
                            <p class="text-[9px] text-slate-400 text-center font-bold leading-relaxed uppercase">High
                                resolution PNG/JPG<br>Current: {{ $popup->image ? 'Saved Asset' : 'None' }}</p>
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
                                        @foreach (['notification', 'offer', 'policy', 'image', 'custom'] as $type)
                                            <option value="{{ $type }}"
                                                {{ $popup->type == $type ? 'selected' : '' }}>{{ ucfirst($type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Stack
                                        Priority</label>
                                    <input type="number" name="priority"
                                        value="{{ old('priority', $popup->priority) }}"
                                        class="w-full p-4 bg-slate-50 border-none rounded-xl text-slate-800 font-black focus:ring-2 focus:ring-indigo-500/20">
                                </div>

                                <div class="p-4 bg-slate-50 rounded-2xl flex items-center justify-between">
                                    <span class="text-xs font-black text-slate-600 uppercase">Allow Dismiss</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_dismissible" value="1"
                                            {{ $popup->is_dismissible ? 'checked' : '' }} class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor', {
            height: 300,
            uiColor: '#ffffff',
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
        .cke_chrome {
            border: 1px solid #f1f5f9 !important;
            border-radius: 1rem !important;
            overflow: hidden;
        }

        .cke_top {
            background: #f8fafc !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endsection
