@extends('layouts.app')

@section('content')
    <div x-data="coreValuesManager()" class="max-w-7xl mx-auto px-4 py-10">
        <div class="grid grid-cols-12 gap-8 items-start">

            <aside class="col-span-12 lg:col-span-4 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Current Core Values</h3>
                        <p class="text-[10px] text-slate-400 mt-1">Manage and reorder your values</p>
                    </div>

                    <div class="p-4 space-y-3 max-h-[600px] overflow-y-auto">
                        @forelse ($values as $v)
                            <div class="group border-2 rounded-2xl p-4 transition-all duration-200 cursor-pointer relative"
                                :class="editId === {{ $v->id }} ?
                                    'border-blue-500 bg-blue-50/30 ring-4 ring-blue-500/5' :
                                    'border-slate-100 hover:border-slate-300 bg-white'"
                                @click="editValue({{ $v->id }}, '{{ addslashes($v->icon) }}', '{{ addslashes($v->title) }}', '{{ addslashes($v->description) }}', {{ $v->sort_order }})">

                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg shadow-sm">
                                        {!! $v->icon !!}
                                    </div>
                                    <div class="flex-1 pr-8">
                                        <h4 class="font-bold text-slate-800 text-sm leading-tight">{{ $v->title }}</h4>
                                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">{{ $v->description }}</p>
                                    </div>
                                </div>

                                <div
                                    class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form method="POST" action="{{ url('admin/about/core-values/card/' . $v->id) }}"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf @method('DELETE')
                                        <button
                                            class="p-1.5 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-slate-400 text-xs italic">No values added yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </aside>

            <main class="col-span-12 lg:col-span-8 space-y-8">

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-[#0b3186] rounded-xl flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2.5"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800 tracking-tight">Header Configuration</h3>
                    </div>

                    <form method="POST" action="{{ url('admin/about/core-values/section') }}"
                        class="grid grid-cols-2 gap-6">
                        @csrf
                        <input type="hidden" name="id" value="{{ $section?->id }}">

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Badge</label>
                            <input
                                class="w-full border-slate-200 border-2 rounded-2xl px-5 py-3 text-xs focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                                name="badge" value="{{ $section?->badge }}" placeholder="e.g. CORE VALUES">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Section
                                Title</label>
                            <input
                                class="w-full border-slate-200 border-2 rounded-2xl px-5 py-3 text-xs focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                                name="title" value="{{ $section?->title }}" placeholder="e.g. What We Stand For">
                        </div>

                        <div class="col-span-2 space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Short
                                Description</label>
                            <textarea
                                class="w-full border-slate-200 border-2 rounded-2xl px-5 py-3 text-xs focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                                name="description" rows="2" placeholder="Describe this section...">{{ $section?->description }}</textarea>
                        </div>

                        <div class="col-span-2 flex justify-end">
                            <button
                                class="bg-[#0b3186] hover:bg-blue-800 text-white px-8 py-3 rounded-2xl text-[11px] font-black tracking-[0.1em] transition-all active:scale-95">
                                UPDATE HEADER
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-8 relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 text-slate-50 opacity-10">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="3" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-slate-800 tracking-tight"
                                    x-text="editId ? 'Modify Core Value' : 'Add New Core Value'"></h3>
                            </div>
                            <template x-if="editId">
                                <button @click="resetForm()"
                                    class="text-[10px] font-bold text-red-500 hover:underline uppercase tracking-tighter">Cancel
                                    Edit</button>
                            </template>
                        </div>

                        <form method="POST" :action="formAction" class="grid grid-cols-2 gap-6">
                            @csrf
                            <template x-if="editId">
                                <input type="hidden" name="_method" value="PUT">
                            </template>

                            <input type="hidden" name="section_id" value="{{ $section?->id }}">

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Icon
                                    (Emoji or SVG)</label>
                                <input
                                    class="w-full border-slate-200 border-2 rounded-2xl px-5 py-3 text-xs focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-slate-50/30"
                                    name="icon" x-model="form.icon" placeholder="🚀">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Value
                                    Title</label>
                                <input
                                    class="w-full border-slate-200 border-2 rounded-2xl px-5 py-3 text-xs focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-slate-50/30"
                                    name="title" x-model="form.title" placeholder="e.g. Innovation">
                            </div>

                            <div class="col-span-2 space-y-2">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Full
                                    Description</label>
                                <textarea
                                    class="w-full border-slate-200 border-2 rounded-2xl px-5 py-4 text-xs focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-slate-50/30"
                                    rows="4" name="description" x-model="form.description" placeholder="Explain the value in detail..."></textarea>
                            </div>

                            <!--<div class="space-y-2">-->
                            <!--    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Sort Order</label>-->
                            <!--    <input class="w-full border-slate-200 border-2 rounded-2xl px-5 py-3 text-xs focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-slate-50/30" -->
                            <!--           type="number" name="sort_order" x-model="form.sort_order">-->
                            <!--</div>-->

                            <div class="col-span-2 pt-4">
                                <button
                                    class="w-full bg-[#0b3186] hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-200 transition-all active:scale-95 text-xs tracking-[0.2em] uppercase">
                                    <span x-text="editId ? 'Save Changes' : 'Create Value Card'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function coreValuesManager() {
            return {
                editId: null,
                formAction: '{{ url('admin/about/core-values/card') }}',
                form: {
                    icon: '',
                    title: '',
                    description: '',
                    sort_order: 0
                },

                editValue(id, icon, title, description, sortOrder) {
                    this.editId = id;
                    this.form = {
                        icon,
                        title,
                        description,
                        sort_order: sortOrder
                    };
                    this.formAction = '{{ url('admin/about/core-values/card') }}/' + id;
                    window.scrollTo({
                        top: 100,
                        behavior: 'smooth'
                    });
                },

                resetForm() {
                    this.editId = null;
                    this.form = {
                        icon: '',
                        title: '',
                        description: '',
                        sort_order: 0
                    };
                    this.formAction = '{{ url('admin/about/core-values/card') }}';
                }
            }
        }
    </script>
@endsection
