@extends('layouts.app')

@section('content')
    <div x-data="homeCounterManager()" x-init="initSortable()" class="max-w-6xl mx-auto px-4 py-8">
        <div class="grid grid-cols-12 gap-8 text-[12px]">

            <aside class="col-span-12 lg:col-span-5 flex flex-col space-y-4">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                            </span>
                            <h3 class="font-bold text-slate-700 uppercase tracking-wider text-[11px]">Home Counters</h3>
                        </div>
                        <button @click="reset()" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-[10px] font-bold shadow-sm">
                            + ADD NEW
                        </button>
                    </div>

                    <div x-ref="sortable" class="divide-y divide-slate-100 max-h-[600px] overflow-y-auto">
                        <template x-for="item in counters" :key="item.id">
                            <div :data-id="item.id" class="group bg-white px-4 py-3 hover:bg-slate-50 flex items-center gap-3 transition-all"
                                 :class="{ 'bg-blue-50 ring-1 ring-blue-100': form.id === item.id }">
                                
                                <div class="cursor-grab text-slate-300 hover:text-slate-500">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7 7h2v2H7V7zm0 4h2v2H7v-2zm4-4h2v2h-2V7zm0 4h2v2h-2v-2zM7 15h2v2H7v-2zm4 0h2v2h-2v-2z"></path></svg>
                                </div>

                                <div class="flex-1 cursor-pointer" @click="edit(item)">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-800 text-[13px]" x-text="item.value"></span>
                                        <span class="text-[9px] px-1.5 py-0.5 bg-blue-50 text-blue-600 rounded font-mono" x-text="'#' + item.sort_order"></span>
                                    </div>
                                    <p class="text-slate-500 truncate text-[11px]" x-text="item.description"></p>
                                </div>

                                <button @click.stop="toggle(item)" 
                                    class="relative inline-flex h-5 w-9 rounded-full transition-colors duration-200"
                                    :class="item.is_active ? 'bg-emerald-500' : 'bg-slate-200'">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition duration-200 shadow"
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
                        <h2 class="font-bold text-slate-800 text-sm" x-text="form.id ? 'Edit Counter' : 'New Counter'"></h2>
                    </div>

                    <form @submit.prevent="submit()" class="p-6 space-y-5">
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-slate-600 uppercase">Value</label>
                            <input x-model="form.value" class="w-full border border-slate-200 rounded-lg px-3 py-2 outline-none focus:border-blue-500" required>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-slate-600 uppercase">Description</label>
                            <textarea x-model="form.description" rows="3" class="w-full border border-slate-200 rounded-lg px-3 py-2 outline-none focus:border-blue-500"></textarea>
                        </div>

                        <div class="flex items-center p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" x-model="form.is_active" class="w-4 h-4 rounded text-blue-600 border-slate-300">
                                <span class="text-slate-700 font-medium group-hover:text-blue-600 transition-colors">Show on Homepage</span>
                            </label>
                        </div>

                        <div class="flex justify-between items-center pt-6 border-t border-slate-100">
                            <button class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-6 py-2.5 rounded-lg shadow-md transition-all active:scale-95 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                Save Changes
                            </button>

                            <button x-show="form.id" @click.prevent="remove()" 
                                    class="inline-flex items-center gap-1.5 text-red-500 hover:text-red-700 font-bold px-3 py-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                Delete Forever
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        function homeCounterManager() {
            return {
                counters: @json($counters),
                form: { id: null, value: '', description: '', is_active: true },

                initSortable() {
                    this.$nextTick(() => {
                        new Sortable(this.$refs.sortable, {
                            handle: '.cursor-grab',
                            animation: 150,
                            onEnd: (evt) => {
                                const movedItem = this.counters.splice(evt.oldIndex, 1)[0];
                                this.counters.splice(evt.newIndex, 0, movedItem);
                                this.saveOrder();
                            }
                        });
                    });
                },

                saveOrder() {
                    const order = this.counters.map(item => item.id);
                    fetch('{{ route("admin.home.counters.reorder") }}', { // Make sure this route exists
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                        body: JSON.stringify({ order })
                    }).then(() => {
                        // Optional: Reload to see new clean #sort numbers
                        location.reload(); 
                    });
                },

                edit(item) {
                    this.form = { ...item };
                    this.form.is_active = !!item.is_active;
                },

                reset() {
                    this.form = { id: null, value: '', description: '', is_active: true };
                },

                submit() {
                    const formData = new FormData();
                    Object.entries(this.form).forEach(([k, v]) =>
                        formData.append(k, k === 'is_active' ? (v ? 1 : 0) : v ?? '')
                    );
                    
                    let url = this.form.id ? `/admin/home/counter/${this.form.id}` : '/admin/home/counter';
                    
                    fetch(url, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: formData
                    }).then(() => location.reload());
                },

                remove() {
                    if (!confirm('Are you sure? This will also re-order all other items.')) return; 
                    
                    fetch(`/admin/home/counter/${this.form.id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    }).then(() => {
                        // Reload zaroori hai taaki Controller ka naya sequence UI mein dikhe
                        location.reload();
                    });
                },

                toggle(item) {
                    fetch(`/admin/home/counter/${item.id}/toggle`, {
                        method: 'PATCH',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                    .then(res => res.json())
                    .then(data => item.is_active = data.status);
                }
            }
        }
    </script>
@endsection