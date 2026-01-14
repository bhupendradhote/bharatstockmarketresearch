@extends('layouts.app')

@section('content')
    <div x-data="whyChooseManager()" x-init="initSortable()" class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-12 gap-8 text-[12px]">

            <aside class="col-span-12 lg:col-span-5 flex flex-col space-y-4">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <h3 class="font-bold text-slate-700 uppercase tracking-wider text-[11px]">Why Choose Sections</h3>
                        </div>
                        <button @click="reset()" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-[10px] font-bold shadow-sm transition-all active:scale-95">
                            + NEW SECTION
                        </button>
                    </div>

                    <div x-ref="sortable" class="divide-y divide-slate-100 max-h-[600px] overflow-y-auto custom-scrollbar">
                        <template x-for="item in sections" :key="item.id">
                            <div :data-id="item.id" 
                                 class="group relative bg-white px-4 py-3 hover:bg-slate-50 transition-colors flex items-center gap-3"
                                 :class="{ 'bg-blue-50/50 ring-1 ring-inset ring-blue-100': form.id === item.id }">

                                <div class="cursor-grab active:cursor-grabbing text-slate-300 hover:text-slate-500 py-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7 7h2v2H7V7zm0 4h2v2H7v-2zm4-4h2v2h-2V7zm0 4h2v2h-2v-2zM7 15h2v2H7v-2zm4 0h2v2h-2v-2z"></path></svg>
                                </div>

                                <div class="w-10 h-10 rounded bg-slate-100 overflow-hidden border border-slate-200 flex-shrink-0">
                                    <img :src="item.image_url" class="w-full h-full object-cover" x-show="item.image_url">
                                    <div x-show="!item.image_url" class="w-full h-full flex items-center justify-center text-slate-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                </div>

                                <div class="flex-1 cursor-pointer min-w-0" @click="edit(item)">
                                    <p class="font-bold text-slate-800 text-[13px] truncate" x-text="item.title || 'Untitled'"></p>
                                    <p class="text-slate-500 truncate text-[11px]" x-text="item.heading"></p>
                                </div>

                                <button @click.stop="toggle(item)" 
                                    class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 focus:outline-none"
                                    :class="item.is_active ? 'bg-emerald-500' : 'bg-slate-200'">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200"
                                          :class="item.is_active ? 'translate-x-4' : 'translate-x-0'"></span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </aside>

            <section class="col-span-12 lg:col-span-7">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-bold text-slate-800 text-sm" x-text="form.id ? 'Edit Section Content' : 'Create New Section'"></h2>
                    </div>

                    <form @submit.prevent="submit()" class="p-6 space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold text-slate-600 uppercase">Admin Title</label>
                                <input x-model="form.title" placeholder="e.g. Quality Assurance" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-slate-800">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[11px] font-bold text-slate-600 uppercase">Badge</label>
                                <input x-model="form.badge" placeholder="e.g. 01, NEW, BEST" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-slate-800">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-slate-600 uppercase">Heading</label>
                            <input x-model="form.heading" placeholder="Enter display heading" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-slate-800">
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-slate-600 uppercase">Description</label>
                            <textarea x-model="form.description" rows="3" placeholder="Explain why this feature is great..." class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none text-slate-800"></textarea>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[11px] font-bold text-slate-600 uppercase">Section Image</label>
                            <div class="flex items-start gap-4 p-4 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                                <div class="relative w-24 h-24 rounded-lg bg-white border border-slate-200 overflow-hidden group shadow-sm flex-shrink-0">
                                    <template x-if="imagePreview">
                                        <img :src="imagePreview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!imagePreview && form.image_url">
                                        <img :src="form.image_url" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!imagePreview && !form.image_url">
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex-1 space-y-2">
                                    <input type="file" @change="handleFileChange($event)" class="block w-full text-[11px] text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-[11px] file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                    <p class="text-[10px] text-slate-400">Recommended: Transparent PNG or high-quality JPG (Max 2MB).</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <label class="flex items-center gap-3 cursor-pointer select-none group">
                                <input type="checkbox" x-model="form.is_active" class="w-4 h-4 rounded text-blue-600 border-slate-300">
                                <span class="text-slate-700 font-medium group-hover:text-blue-600 transition-colors">Section Visibility</span>
                            </label>
                        </div>

                        <div class="flex justify-between items-center pt-6 border-t border-slate-100">
                            <button class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-6 py-2.5 rounded-lg shadow-md transition-all active:scale-95 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                Save Changes
                            </button>
                            <button x-show="form.id" @click.prevent="remove()" class="text-red-500 hover:text-red-700 font-bold px-3 py-2 flex items-center gap-1.5 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                Delete
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    <script>
        function whyChooseManager() {
            return {
                sections: @json($whyChoose),
                image: null,
                imagePreview: null, // For live selection preview

                form: {
                    id: null,
                    title: '',
                    badge: '',
                    heading: '',
                    description: '',
                    is_active: true,
                    image_url: '' // Make sure your model/API returns the full path
                },

                handleFileChange(event) {
                    const file = event.target.files[0];
                    this.image = file;
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                initSortable() {
                    this.$nextTick(() => {
                        new Sortable(this.$refs.sortable, {
                            handle: '.cursor-grab',
                            animation: 150,
                            onEnd: e => {
                                const moved = this.sections.splice(e.oldIndex, 1)[0];
                                this.sections.splice(e.newIndex, 0, moved);
                                this.saveOrder();
                            }
                        });
                    });
                },

                saveOrder() {
                    fetch('/admin/why-choose/reorder', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                        body: JSON.stringify({ order: this.sections.map(i => i.id) })
                    });
                },

                edit(item) {
                    this.form = { ...item };
                    this.imagePreview = null; // Clear any newly selected file preview
                    this.image = null;
                },

                reset() {
                    this.form = { id: null, title: '', badge: '', heading: '', description: '', is_active: true, image_url: '' };
                    this.image = null;
                    this.imagePreview = null;
                },

                submit() {
                    const fd = new FormData();
                    Object.entries(this.form).forEach(([k, v]) => {
                        if (k === 'id' || k === 'image_url') return;
                        if (k === 'is_active') {
                            fd.append('is_active', v ? 1 : 0);
                        } else {
                            fd.append(k, v ?? '');
                        }
                    });
                    if (this.image) fd.append('image', this.image);

                    fetch(this.form.id ? `/admin/why-choose/${this.form.id}` : `/admin/why-choose`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: fd
                    }).then(() => location.reload());
                },

                remove() {
                    if (!confirm('Delete section?')) return;
                    fetch(`/admin/why-choose/${this.form.id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    }).then(() => location.reload());
                },

                toggle(item) {
                    fetch(`/admin/why-choose/${item.id}/toggle`, {
                        method: 'PATCH',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    }).then(r => r.json()).then(d => item.is_active = d.status);
                }
            }
        }
    </script>
@endsection