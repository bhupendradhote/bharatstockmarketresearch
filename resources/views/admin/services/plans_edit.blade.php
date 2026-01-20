@extends('layouts.app')

@section('content')
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <div class="mx-auto px-6 py-6 h-screen flex flex-col" x-data="editPlanForm()">

        <form action="{{ route('admin.service-plans.update', $servicePlan->id) }}" method="POST" class="flex flex-col h-full">
            @csrf
            @method('PUT')

            <div class="flex justify-between items-center mb-6 shrink-0">
                <div>
                    <h1 class="text-lg font-bold text-gray-800">Edit Service Plan</h1>
                    <p class="text-xs text-gray-500">Updating: <span
                            class="font-semibold text-blue-600">{{ $servicePlan->name }}</span></p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.service-plans.index') }}"
                        class="px-4 py-2 bg-white border border-gray-200 rounded text-xs font-medium text-gray-600 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded shadow-sm transition flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Update Plan
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 overflow-hidden h-full">

                <div class="lg:col-span-1 space-y-5 overflow-y-auto no-scrollbar pb-20"
                    style="max-height: calc(100vh - 140px);">

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                        <h3
                            class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-50 pb-2">
                            1. Essentials</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Plan Name</label>
                                <input type="text" name="name" value="{{ $servicePlan->name }}"
                                    class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded text-sm focus:ring-1 focus:ring-blue-500 outline-none transition"
                                    required>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Short
                                    Description</label>
                                <textarea name="tagline" rows="2"
                                    class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded text-sm focus:ring-1 focus:ring-blue-500 outline-none transition"
                                    required>{{ $servicePlan->tagline }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Sort
                                        Order</label>
                                    <input type="number" name="sort_order" value="{{ $servicePlan->sort_order }}"
                                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded text-sm focus:ring-1 focus:ring-blue-500 outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Button
                                        Text</label>
                                    <input type="text" name="button_text" value="{{ $servicePlan->button_text }}"
                                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded text-sm focus:ring-1 focus:ring-blue-500 outline-none transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                        <h3
                            class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-50 pb-2">
                            2. Manage Durations</h3>
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <template x-for="(plan, index) in plans" :key="index">
                                <label
                                    class="flex items-center p-2 rounded border cursor-pointer transition-all select-none"
                                    :class="plan.selected ? 'border-blue-500 bg-blue-50' : 'border-gray-100 hover:bg-gray-50'">
                                    {{-- <input type="checkbox" x-model="plan.selected"
                                        class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded"> --}}

                                    <input type="checkbox" :name="'plans[' + plan.key + '][selected]'"
                                        x-model="plan.selected" value="1"
                                        class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded">
                                    <span class="ml-2 text-[11px] font-semibold text-gray-700" x-text="plan.label"></span>

                                </label>
                            </template>
                        </div>
                        <div class="pt-3 border-t border-gray-100" x-data="{ newLabel: '' }">
                            <div class="flex gap-2">
                                <input type="text" x-model="newLabel"
                                    @keydown.enter.prevent="addCustom(newLabel); newLabel=''"
                                    class="flex-1 px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded outline-none focus:border-blue-500"
                                    placeholder="Add duration...">
                                <button type="button" @click="addCustom(newLabel); newLabel=''"
                                    class="bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-blue-800 transition">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                        <h3
                            class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-50 pb-2">
                            3. Visibility</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-600 font-medium">Featured Plan</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="featured" value="1" class="sr-only peer"
                                        {{ $servicePlan->featured ? 'checked' : '' }}>
                                    <div
                                        class="w-8 h-4 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-600 font-medium">Published Status</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="status" value="1" class="sr-only peer"
                                        {{ $servicePlan->status ? 'checked' : '' }}>
                                    <div
                                        class="w-8 h-4 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-green-500">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-4 overflow-y-auto no-scrollbar pb-20"
                    style="max-height: calc(100vh - 140px);">

                    <div
                        class="flex items-center justify-between sticky top-0 bg-[#F9FAFB] py-2 z-10 border-b border-gray-100 mb-2">
                        <h3 class="text-sm font-bold text-gray-800">Pricing Tiers Configuration</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Scroll to edit features</p>
                    </div>

                    <template x-for="(plan, index) in plans" :key="index">
                        <div x-show="plan.selected" x-transition
                            class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 relative group transition-all hover:border-blue-200 mb-4">

                            <div class="grid grid-cols-2 gap-6 mb-5">
                                <div>
                                    <label
                                        class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Duration
                                        Label</label>
                                    <input type="text" :name="'plans[' + plan.key + '][duration]'" x-model="plan.label"
                                        class="w-full px-0 py-1 bg-transparent border-b border-gray-200 text-sm font-bold text-gray-800 focus:border-blue-500 outline-none">
                                </div>

                                <div>
                                    <label
                                        class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Price
                                        (INR)</label>
                                    <div class="flex items-center">
                                        <span class="text-sm font-bold text-gray-400 mr-1">₹</span>
                                        <input type="number" :name="'plans[' + plan.key + '][price]'"
                                            x-model="plan.price"
                                            class="w-full px-0 py-1 bg-transparent border-b border-gray-200 text-sm font-bold text-gray-800 focus:border-blue-500 outline-none"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded p-4 border border-gray-100">
                                <div class="flex justify-between items-center mb-3">
                                    <label class="text-[10px] font-bold text-gray-500 uppercase">Features Inclusion</label>
                                    <button type="button" @click="addFeature(index)"
                                        class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded font-bold hover:bg-blue-100 transition">
                                        + Add Feature
                                    </button>
                                </div>

                                <div class="space-y-2">
                                    <template x-for="(feat, fIndex) in plan.features" :key="fIndex">
                                        <div class="flex gap-2 items-center">
                                            <div class="w-28 shrink-0 relative">
                                                <select :name="'plans[' + plan.key + '][features][' + fIndex + '][svg]'"
                                                    x-model="feat.svg"
                                                    class="w-full pl-7 pr-2 py-1.5 bg-white border border-gray-200 rounded text-[11px] appearance-none outline-none focus:border-blue-500">
                                                    <option value="✔">Included</option>
                                                    <option value="✖">Excluded</option>
                                                    <option value="Premium">Premium</option>
                                                </select>
                                                <div
                                                    class="absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none">
                                                    <span x-show="feat.svg === '✔'"
                                                        class="text-green-500 text-[10px] font-bold">✔</span>
                                                    <span x-show="feat.svg === '✖'"
                                                        class="text-red-400 text-[10px] font-bold">✖</span>
                                                    <span x-show="feat.svg === 'Premium'"
                                                        class="text-blue-500 text-[10px] font-bold">★</span>
                                                </div>
                                            </div>
                                            <input type="text"
                                                :name="'plans[' + plan.key + '][features][' + fIndex + '][text]'"
                                                x-model="feat.text"
                                                class="flex-1 px-3 py-1.5 bg-white border border-gray-200 rounded text-xs focus:ring-1 focus:ring-blue-400 outline-none"
                                                placeholder="Feature description...">
                                            <button type="button" @click="removeFeature(index, fIndex)"
                                                class="p-1.5 text-gray-300 hover:text-red-400"
                                                x-show="plan.features.length > 1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </form>
    </div>
    <script>
        function editPlanForm() {
            const existingData = @json($cleanDurations);

            return {
                plans: existingData.map(d => ({
                    label: d.duration,
                    key: d.duration.replace(/\s+/g, "_").toLowerCase(),
                    selected: true,
                    price: d.price,
                    features: d.features && d.features.length > 0 ?
                        d.features.map(f => ({
                            svg: f.svg_icon || '✔',
                            text: f.text
                        })) : [{
                            svg: '✔',
                            text: ''
                        }]
                })),

                addCustom(label) {
                    if (!label) return;
                    const key = label.replace(/\s+/g, "_").toLowerCase();
                    if (this.plans.some(p => p.key === key)) return alert('Exists');

                    this.plans.push({
                        label: label,
                        key: key,
                        selected: true,
                        price: '',
                        features: [{
                            svg: '✔',
                            text: ''
                        }]
                    });
                },

                addFeature(pIdx) {
                    this.plans[pIdx].features.push({
                        svg: '✔',
                        text: ''
                    });
                },

                removeFeature(pIdx, fIdx) {
                    if (this.plans[pIdx].features.length > 1) {
                        this.plans[pIdx].features.splice(fIdx, 1);
                    }
                }
            }
        }
    </script>
@endsection
