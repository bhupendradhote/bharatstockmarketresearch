@extends('layouts.app')

@php
    $sectionData = $section
        ? $section->toArray()
        : [
            'id' => null,
            'badge' => '',
            'heading' => '',
            'sub_heading' => '',
            'description' => '',
            'is_active' => true,
        ];
    $stepsData = $steps ?? collect();
@endphp

@section('content')
    <div x-data="howItWorks()" x-init="initSortable()" class="max-w-7xl mx-auto px-4 py-10">
        <form @submit.prevent="save">
            <div class="grid grid-cols-12 gap-8 items-start">

                <aside class="col-span-12 lg:col-span-4 space-y-6 lg:sticky lg:top-10">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
                        <div class="flex items-center gap-3 mb-8">
                            <div
                                class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800">Section Info</h2>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Badge
                                    Text</label>
                                <input x-model="section.badge"
                                    class="w-full border-slate-200 border-2 rounded-2xl px-5 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                                    placeholder="e.g. OUR PROCESS">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Main
                                    Heading</label>
                                <input x-model="section.heading"
                                    class="w-full border-slate-200 border-2 rounded-2xl px-5 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                                    placeholder="e.g. How It Works">
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Description</label>
                                <textarea x-model="section.description" rows="4"
                                    class="w-full border-slate-200 border-2 rounded-2xl px-5 py-3 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                                    placeholder="Write a short intro..."></textarea>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-slate-100">
                            <button type="submit"
                                class="w-full bg-[#0b3186] hover:bg-blue-900 text-white font-black px-6 py-4 rounded-2xl shadow-xl transition-all active:scale-95 text-xs tracking-widest">
                                PUBLISH CHANGES
                            </button>
                        </div>
                    </div>
                </aside>

                <main class="col-span-12 lg:col-span-8">
                    <div class="bg-white rounded-3xl shadow-md border border-slate-200 overflow-hidden">

                        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg">Process Workflow</h3>
                                <p class="text-xs text-slate-400">Add, remove, and reorder steps.</p>
                            </div>
                            <button type="button" @click="addStep"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl text-xs font-bold flex items-center gap-2 transition-all shadow-lg shadow-blue-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="3" d="M12 4v16m8-8H4"></path>
                                </svg>
                                ADD NEW STEP
                            </button>
                        </div>

                        <div class="bg-slate-50/50 p-6 border-b border-slate-100">
                            <div x-ref="sortableTabs" class="flex items-center gap-4 overflow-x-auto pb-2 scrollbar-hide">
                                <template x-for="(step, i) in steps" :key="step.uid">
                                    <div @click="activeStep = i"
                                        class="flex items-center gap-3 px-6 py-4 rounded-2xl border-2 cursor-pointer transition-all whitespace-nowrap group relative"
                                        :class="activeStep === i ? 'bg-white border-blue-600 shadow-md ring-4 ring-blue-500/5' :
                                            'bg-slate-200/50 border-transparent text-slate-500 hover:bg-white hover:border-slate-300'">

                                        <div class="cursor-move text-slate-400 group-hover:text-blue-500">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M7 7h2v2H7V7zm0 4h2v2H7v-2zm4-4h2v2h-2V7zm0 4h2v2h-2v-2z"></path>
                                            </svg>
                                        </div>

                                        <span class="font-black text-xs uppercase"
                                            :class="activeStep === i ? 'text-blue-600' : ''"
                                            x-text="'Step ' + (i + 1)"></span>

                                        <button type="button" @click.stop="removeStep(i)"
                                            class="ml-2 p-1 rounded-lg hover:bg-red-50 text-slate-400 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="p-8 lg:p-12 min-h-[450px]">
                            <template x-if="steps.length > 0">
                                <div class="space-y-8" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-4">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div class="space-y-8">
                                            <div class="space-y-3">
                                                <label
                                                    class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Step
                                                    Title</label>
                                                <input x-model="steps[activeStep].title"
                                                    class="w-full border-slate-200 border-2 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                                                    placeholder="e.g. Register Account">
                                            </div>
                                            <div class="space-y-3">
                                                <label
                                                    class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Description</label>
                                                <textarea x-model="steps[activeStep].description" rows="6"
                                                    class="w-full border-slate-200 border-2 rounded-2xl px-6 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none"
                                                    placeholder="Explain what happens in this step..."></textarea>
                                            </div>
                                        </div>

                                        <div class="space-y-3">
                                            <label
                                                class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Step
                                                Image</label>
                                            <div
                                                class="relative group aspect-square rounded-[40px] border-2 border-dashed border-slate-200 bg-slate-50/50 overflow-hidden flex flex-col items-center justify-center transition-all hover:bg-white hover:border-blue-400">
                                                <template x-if="steps[activeStep].preview">
                                                    <img :src="steps[activeStep].preview"
                                                        class="absolute inset-0 w-full h-full object-contain p-6 group-hover:scale-105 transition-transform duration-500">
                                                </template>

                                                <div class="relative z-10 flex flex-col items-center text-center p-6">
                                                    <div
                                                        class="p-4 rounded-3xl bg-white shadow-xl mb-4 text-blue-500 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-width="1.5"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <input type="file" accept="image/*"
                                                        @change="handleImage($event, steps[activeStep])"
                                                        class="absolute inset-0 opacity-0 cursor-pointer">
                                                    <span class="text-xs font-black text-slate-700 uppercase">Upload
                                                        Media</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </template>

                            <template x-if="steps.length === 0">
                                <div
                                    class="flex flex-col items-center justify-center py-20 bg-slate-50/50 rounded-[40px] border-2 border-dashed border-slate-100">
                                    <div
                                        class="w-20 h-20 bg-white rounded-3xl shadow-sm flex items-center justify-center mb-6 text-slate-200">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="2"
                                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-bold">No steps created yet.</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </main>
            </div>
        </form>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        function howItWorks() {
            return {
                section: @json($sectionData),
                activeStep: 0,
                steps: @json($stepsData).map(s => ({
                    ...s,
                    uid: crypto.randomUUID(),
                    image: null,
                    preview: (s.media && s.media.length > 0) ? s.media[0].original_url : null
                })),

                initSortable() {
                    this.$nextTick(() => {
                        new Sortable(this.$refs.sortableTabs, {
                            handle: '.cursor-move',
                            animation: 300,
                            onEnd: (evt) => {
                                const moved = this.steps.splice(evt.oldIndex, 1)[0];
                                this.steps.splice(evt.newIndex, 0, moved);
                                this.activeStep = evt.newIndex;
                            }
                        });
                    });
                },

                addStep() {
                    this.steps.push({
                        uid: crypto.randomUUID(),
                        id: null,
                        title: '',
                        description: '',
                        is_active: true,
                        image: null,
                        preview: null
                    });
                    this.activeStep = this.steps.length - 1;
                },

                removeStep(index) {
                    if (confirm('Delete this step?')) {
                        this.steps.splice(index, 1);
                        this.activeStep = Math.max(0, this.steps.length - 1);
                    }
                },

                handleImage(e, step) {
                    const file = e.target.files[0];
                    if (!file) return;
                    step.image = file;
                    step.preview = URL.createObjectURL(file);
                },

                save() {
                    const fd = new FormData();
                    fd.append('section', JSON.stringify(this.section));
                    this.steps.forEach((step, i) => {
                        fd.append(`steps[${i}][id]`, step.id ?? '');
                        fd.append(`steps[${i}][title]`, step.title);
                        fd.append(`steps[${i}][description]`, step.description ?? '');
                        fd.append(`steps[${i}][is_active]`, 1);
                        fd.append(`steps[${i}][sort_order]`, i + 1);
                        if (step.image) fd.append(`steps[${i}][image]`, step.image);
                    });

                    fetch('{{ route('admin.how-it-works.save') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: fd
                    }).then(() => {
                        alert('Workflow published successfully!');
                        location.reload();
                    });
                }
            }
        }
    </script>
@endsection
