@extends('layouts.app')

@push('styles')
    <style>
        [x-cloak] { display: none !important; }
        /* Professional Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
        
        .thumb-sm {
            height: 80px;
            width: 100%;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
        }
    </style>
@endpush

@section('content')
    <div x-data="heroManager()" x-init="init()" class="p-6 text-sm bg-slate-50 min-h-screen">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Hero Banner Manager</h1>
                <p class="text-xs text-slate-500 mt-1">Design, organize, and publish high-impact hero banners for your website.</p>
            </div>

            <div class="flex items-center gap-3">
                <button @click="refresh()" class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </button>
                <button @click="openCreate()" class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white rounded-xl shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition-all transform active:scale-95 font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create New Banner
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 block">Quick Search</label>
                    <div class="relative">
                        <input x-model="filter" @input="filterList()" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all" placeholder="Search by page key or title...">
                        <svg class="w-4 h-4 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-bold text-slate-800">Your Banners</h3>
                        <span class="text-[10px] bg-slate-200 text-slate-600 px-2 py-0.5 rounded-full uppercase font-bold tracking-tighter">Drag to Sort</span>
                    </div>
                    <div id="heroList" class="max-h-[600px] overflow-y-auto custom-scrollbar p-2 space-y-2">
                        @foreach ($banners as $b)
                            <div data-id="{{ $b->id }}" @click="selectBannerById({{ $b->id }})" class="group flex items-center justify-between p-3 rounded-xl border border-transparent hover:border-emerald-200 hover:bg-emerald-50/30 transition-all cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <span class="drag-handle cursor-move text-slate-300 group-hover:text-emerald-500 transition-colors">⋮⋮</span>
                                    <div>
                                        <div class="font-bold text-slate-700 leading-tight truncate w-40">{{ $b->title ?: 'Draft Banner' }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ strtoupper($b->page_key) }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button @click.stop="openEditId({{ $b->id }})" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                                    <button @click.stop="confirmDelete({{ $b->id }})" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Live Preview</h3>
                        <template x-if="preview">
                            <span :class="bannerStatus[preview.id] ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'" class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest" x-text="bannerStatus[preview.id] ? 'Online' : 'Offline'"></span>
                        </template>
                    </div>

                    <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-900 border-4 border-slate-100 shadow-inner group">
                        <template x-if="preview">
                            <div class="w-full h-full relative">
                                <img :src="preview.background_url || '/images/placeholder-hero.png'" class="absolute inset-0 w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent flex items-center px-12">
                                    <div class="max-w-md text-left">
                                        <span x-show="preview.badge" class="px-3 py-1 bg-emerald-500 text-white text-[10px] rounded-full font-bold mb-4 inline-block" x-text="preview.badge"></span>
                                        <h2 class="text-4xl text-white font-black mb-3 leading-tight" x-text="preview.title"></h2>
                                        <p class="text-slate-200 text-sm line-clamp-2 mb-2" x-text="preview.subtitle"></p>
                                        <p class="text-slate-400 text-xs mb-6 line-clamp-2" x-text="preview.description"></p>
                                        <div class="flex gap-4">
                                            <button x-show="preview.button_text_1" class="px-6 py-2 bg-emerald-500 text-white text-xs font-bold rounded-lg" x-text="preview.button_text_1"></button>
                                            <button x-show="preview.button_text_2" class="px-6 py-2 border border-white text-white text-xs font-bold rounded-lg" x-text="preview.button_text_2"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template x-if="!preview">
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-500 bg-slate-50">
                                <svg class="w-16 h-16 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="font-medium">Select a banner to see how it looks live.</p>
                            </div>
                        </template>
                    </div>

                    <div class="mt-10">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Gallery View</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <template x-for="b in bannersPreview" :key="b.id">
                                <div @click="selectBanner(b)" :class="preview && preview.id == b.id ? 'ring-2 ring-emerald-500 ring-offset-2 border-emerald-500' : 'border-slate-200'" class="relative group cursor-pointer border rounded-xl overflow-hidden transition-all hover:shadow-lg">
                                    <img :src="b.background_url || '/images/placeholder-hero.png'" class="w-full h-24 object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="modalOpen" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50">
            <div @click.outside="closeModal()" class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden transition-all border border-white/20">
                
                <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-slate-50/50">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-800" x-text="isEdit ? 'Edit Banner Configuration' : 'Design New Hero Banner'"></h3>
                        <p class="text-xs text-slate-500">Fill in the details below to update your website's primary visual.</p>
                    </div>
                    <button @click="closeModal()" class="p-2 hover:bg-white rounded-full transition shadow-sm text-slate-400 hover:text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="formAction" method="POST" enctype="multipart/form-data" class="flex-1 overflow-auto">
                    @csrf
                    <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                        
                        <div class="p-8 space-y-5 border-r border-slate-100">
                            <h4 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-4">Content Settings</h4>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Page Key</label>
                                    <input name="page_key" x-model="form.page_key" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none" placeholder="e.g. home">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Badge Text</label>
                                    <input name="badge" x-model="form.badge" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none" placeholder="e.g. New Arrival">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Banner Title</label>
                                <input name="title" x-model="form.title" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold text-slate-800" placeholder="Enter main headline...">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Subtitle / Tagline</label>
                                <input name="subtitle" x-model="form.subtitle" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none" placeholder="Short catchphrase...">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Long Description</label>
                                <textarea name="description" x-model="form.description" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none" placeholder="Detailed banner description..."></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Button 1 Text</label>
                                    <input name="button_text_1" x-model="form.button_text_1" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none" placeholder="Shop Now">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Button 1 URL</label>
                                    <input name="button_link_1" x-model="form.button_link_1" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none" placeholder="/shop">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Button 2 Text</label>
                                    <input name="button_text_2" x-model="form.button_text_2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none" placeholder="Learn More">
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Button 2 URL</label>
                                    <input name="button_link_2" x-model="form.button_link_2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none" placeholder="/about">
                                </div>
                            </div>
                        </div>

                        <div class="p-8 bg-slate-50/50 space-y-6">
                            <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-4">Media Assets & Settings</h4>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Sort Order</label>
                                    <input name="sort_order" type="number" x-model="form.sort_order" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Status</label>
                                    <select name="status" x-model="form.status" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 outline-none font-bold text-emerald-700">
                                        <option value="1">PUBLISHED</option>
                                        <option value="0">DRAFT</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-xs font-bold text-slate-700 ml-1">Desktop Background (1920x800)</label>
                                <div class="relative group h-40 w-full rounded-2xl border-2 border-dashed border-slate-300 hover:border-emerald-500 transition-colors flex flex-col items-center justify-center bg-white overflow-hidden shadow-sm">
                                    <template x-if="form.desktop_preview || form.background_url">
                                        <img :src="form.desktop_preview || form.background_url" class="absolute inset-0 w-full h-full object-cover">
                                    </template>
                                    <div class="relative z-10 flex flex-col items-center pointer-events-none group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8 text-slate-400 group-hover:text-emerald-500 transition-colors mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="text-[10px] font-bold text-slate-500 group-hover:text-emerald-600 uppercase">Change Desktop Image</p>
                                    </div>
                                    <input type="file" name="background_image" @change="localImage($event,'desktop')" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-xs font-bold text-slate-700 ml-1">Mobile Background (800x1200)</label>
                                <div class="relative group h-32 w-full rounded-2xl border-2 border-dashed border-slate-300 hover:border-blue-500 transition-colors flex flex-col items-center justify-center bg-white overflow-hidden shadow-sm">
                                    <template x-if="form.mobile_preview || form.mobile_background_url">
                                        <img :src="form.mobile_preview || form.mobile_background_url" class="absolute inset-0 w-full h-full object-cover">
                                    </template>
                                    <div class="relative z-10 flex flex-col items-center pointer-events-none group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-slate-400 group-hover:text-blue-500 transition-colors mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        <p class="text-[10px] font-bold text-slate-500 group-hover:text-blue-600 uppercase text-center">Upload Mobile Version</p>
                                    </div>
                                    <input type="file" name="mobile_background_image" @change="localImage($event,'mobile')" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sticky bottom-0 bg-white border-t border-slate-100 p-6 flex justify-end gap-3 shadow-[0_-10px_20px_-15px_rgba(0,0,0,0.1)]">
                        <button @click="closeModal()" type="button" class="px-6 py-2.5 text-xs font-bold text-slate-500 hover:text-slate-800 transition uppercase tracking-widest">Cancel</button>
                        <button type="submit" class="px-10 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-xl shadow-emerald-500/20 hover:bg-emerald-700 transition transform active:scale-95">
                            Save Configuration
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <form x-ref="deleteForm" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    @endpush

    <script>
        function heroManager() {
            return {
                banners: @json($bannersJson),
                bannersPreview: [],
                preview: null,
                modalOpen: false,
                isEdit: false,
                formAction: '',
                bannerStatus: {},
                filter: '',

                form: {
                    id: null,
                    page_key: '',
                    badge: '',
                    title: '',
                    subtitle: '',
                    description: '',
                    button_text_1: '',
                    button_link_1: '',
                    button_text_2: '',
                    button_link_2: '',
                    sort_order: 0,
                    status: 1,
                    desktop_preview: null,
                    mobile_preview: null,
                    background_url: null,
                    mobile_background_url: null,
                },

                init() {
                    this.bannersPreview = this.banners;
                    this.banners.forEach(b => {
                        this.bannerStatus[b.id] = b.status;
                    });

                    const el = document.getElementById('heroList');
                    new Sortable(el, {
                        animation: 150,
                        handle: '.drag-handle',
                        onEnd: () => {
                            const order = Array.from(el.querySelectorAll('[data-id]')).map(x => x.dataset.id);
                            fetch("{{ route('admin.hero-banners.reorder') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({ order })
                            });
                        }
                    });
                },

                refresh() { window.location.reload(); },

                selectBanner(b) {
                    this.preview = b;
                    this.form = { ...this.form, ...b };
                },

                selectBannerById(id) {
                    const b = this.banners.find(x => x.id == id);
                    if (b) this.selectBanner(b);
                },

                openCreate() {
                    this.isEdit = false;
                    this.modalOpen = true;
                    this.formAction = "{{ route('admin.hero-banners.store') }}";
                    this.form = { id: null, page_key: '', badge: '', title: '', subtitle: '', description: '', button_text_1: '', button_link_1: '', button_text_2: '', button_link_2: '', sort_order: 0, status: 1, desktop_preview: null, mobile_preview: null, background_url: null, mobile_background_url: null };
                    this.preview = null;
                },

                openEditId(id) {
                    const b = this.banners.find(x => x.id == id);
                    if (!b) return;
                    this.isEdit = true;
                    this.modalOpen = true;
                    this.formAction = `/admin/hero-banners/${b.id}`;
                    this.form = { ...this.form, ...b };
                    this.preview = b;
                },

                closeModal() { this.modalOpen = false; },

                confirmDelete(id) {
                    if (!confirm("Delete this banner?")) return;
                    this.$refs.deleteForm.action = `/admin/hero-banners/${id}`;
                    this.$refs.deleteForm.submit();
                },

                localImage(e, type) {
                    const file = e.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = ev => {
                        if (type === 'desktop') this.form.desktop_preview = ev.target.result;
                        else this.form.mobile_preview = ev.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                filterList() {
                    if (!this.filter) {
                        document.querySelectorAll("#heroList > div").forEach(item => item.style.display = '');
                        return;
                    }
                    document.querySelectorAll("#heroList > div").forEach(item => {
                        item.style.display = item.innerText.toLowerCase().includes(this.filter.toLowerCase()) ? '' : 'none';
                    });
                }
            }
        }
    </script>
@endsection