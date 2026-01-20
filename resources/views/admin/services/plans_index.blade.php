@extends('layouts.app')

@section('content')
    <div x-data="{ showFilters: false }" class="p-6 text-sm">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Service Plans</h1>
                <p class="text-xs text-gray-500">Manage subscription packages and pricing tiers.</p>
            </div>

            <div class="flex items-center gap-3">
                {{-- Bulk Delete Button --}}
                <button id="delete-selected" class="hidden px-4 py-2 bg-red-600 text-white rounded shadow text-xs hover:bg-red-700 transition flex items-center gap-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Delete Selected
                </button>

                <button @click="showFilters = !showFilters" class="px-3 py-2 bg-gray-100 rounded text-xs hover:bg-gray-200">
                    {{-- Filter Icon --}}
                    <span x-text="showFilters ? 'Hide Filters' : 'Filters'"></span>
                </button>

                <a href="{{ route('admin.service-plans.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded shadow text-xs hover:bg-blue-700">
                    + Add New Plan
                </a>
            </div>
        </div>

        <div x-show="showFilters" x-transition class="bg-white rounded-lg shadow-sm border p-4 mb-5">
            <div class="flex items-center justify-between mb-3">
                <div class="font-semibold text-sm text-gray-800">Filter Tools</div>
                <div class="text-xs text-gray-500">Search & Filter Plans</div>
            </div>

            <form method="GET" action="{{ route('admin.service-plans.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-xs font-medium text-gray-600">Search by Name</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Plan name..." 
                               class="w-full mt-1 px-3 py-2 border rounded text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Status</label>
                        <select name="status" class="w-full mt-1 px-3 py-2 border rounded text-xs">
                            <option value="">All Status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Featured</label>
                        <select name="featured" class="w-full mt-1 px-3 py-2 border rounded text-xs">
                            <option value="">All</option>
                            <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured</option>
                            <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="submit" class="px-3 py-1 bg-gray-800 text-white rounded text-xs">Apply Filter</button>
                    <a href="{{ route('admin.service-plans.index') }}" class="px-3 py-1 bg-gray-200 rounded text-xs text-gray-700">Clear</a>
                </div>
            </form>
        </div>

        @if ($plans->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($plans as $plan)
                    <div x-data="{
                        activeDuration: 0,
                        durations: {{ $plan->durations->map(function($d) {
                            return [
                                'label' => $d->duration,
                                'price' => number_format($d->price, 2),
                                'features' => $d->features->map(function($f) {
                                    return ['text' => $f->text, 'icon' => $f->svg_icon ?: '✔'];
                                })
                            ];
                        })->values()->toJson() }}
                    }" 
                    class="bg-white rounded-lg shadow-sm border p-5 hover:border-blue-300 transition relative">

                        <input type="checkbox" class="multi-check absolute top-4 left-4 w-4 h-4 rounded border-gray-300 text-blue-600" value="{{ $plan->id }}">

                        <div class="absolute top-4 right-4 flex gap-2">
                            <a href="{{ route('admin.service-plans.edit', $plan->id) }}" class="p-1 text-gray-400 hover:text-yellow-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <button type="button" onclick="confirmDelete({{ $plan->id }})" class="p-1 text-gray-400 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>

                        <div class="mt-6">
                            <h3 class="font-semibold text-gray-800 text-base truncate">{{ $plan->name }}</h3>
                            
                            <div class="flex gap-1 mt-2">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $plan->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $plan->status ? 'Active' : 'Inactive' }}
                                </span>
                                @if($plan->featured)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">Featured</span>
                                @endif
                            </div>

                            <div class="my-4 h-16">
                                <template x-if="durations.length > 0">
                                    <div>
                                        <div class="text-xl font-bold text-gray-900">
                                            ₹<span x-text="durations[activeDuration].price"></span>
                                        </div>
                                        <div class="text-[10px] text-gray-500 uppercase tracking-tighter">Incl. GST • Subscription</div>
                                    </div>
                                </template>
                            </div>

                            <div class="flex gap-1 mb-4 flex-wrap">
                                <template x-for="(d, index) in durations" :key="index">
                                    <button @click="activeDuration = index" 
                                            class="px-3 py-1 rounded text-[11px] border transition"
                                            :class="activeDuration === index ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100'">
                                        <span x-text="d.label"></span>
                                    </button>
                                </template>
                            </div>

                            <div class="border-t border-gray-100 pt-4">
                                <div class="text-[11px] font-bold text-gray-400 uppercase mb-3">Plan Features</div>
                                <ul class="space-y-2 text-xs text-gray-600">
                                    <template x-if="durations.length > 0">
                                        <template x-for="(feature, fIndex) in durations[activeDuration].features" :key="fIndex">
                                            <li class="flex justify-between items-center">
                                                <span x-text="feature.text"></span>
                                                <span x-html="feature.icon === '✔' ? '<span class=\'text-green-600\'>✔</span>' : (feature.icon === '✖' ? '<span class=\'text-red-500\'>✖</span>' : feature.icon)"></span>
                                            </li>
                                        </template>
                                    </template>
                                </ul>
                            </div>

                            <a href="{{ route('admin.service-plans.edit', $plan->id) }}" class="mt-5 w-full block text-center py-2 bg-blue-700 text-white rounded text-xs hover:bg-blue-800 transition">
                                Edit Plan Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $plans->links() }}
            </div>

        @else
            <div class="text-center py-16 bg-white rounded-lg border-2 border-dashed border-gray-200">
                <p class="text-gray-500 text-sm">No Service Plans Found</p>
                <a href="{{ route('admin.service-plans.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded text-xs">
                    + Add New Plan
                </a>
            </div>
        @endif

        {{-- Hidden Select All --}}
        <input type="checkbox" id="check-all" class="hidden">
    </div>
@endsection


<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const checkAll = document.getElementById("check-all");
        const deleteBtn = document.getElementById("delete-selected");
        const checks = () => [...document.querySelectorAll(".multi-check")];

        // SELECT ALL
        if(checkAll){
            checkAll.addEventListener("change", e => {
                checks().forEach(ch => ch.checked = e.target.checked);
                toggleDeleteBtn();
            });
        }

        // SHOW/HIDE BULK DELETE BUTTON
        function toggleDeleteBtn() {
            const anyChecked = checks().some(ch => ch.checked);
            if(deleteBtn){
                deleteBtn.classList.toggle("hidden", !anyChecked);
            }
        }

        // INDIVIDUAL CHECKBOXES
        checks().forEach(ch =>
            ch.addEventListener("change", toggleDeleteBtn)
        );

        // SINGLE DELETE
        window.confirmDelete = function(id) {
            if (!confirm("Are you sure you want to delete this plan?")) return;

            fetch(`/admin/service-plans/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            }).then(() => location.reload());
        };

        // BULK DELETE
        if(deleteBtn){
            deleteBtn.addEventListener("click", () => {
                const selected = checks().filter(ch => ch.checked).map(ch => ch.value);
                if (!selected.length) return;

                if (!confirm(`Delete ${selected.length} selected plans?`)) return;

                fetch(`/admin/service-plans/multi-delete`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        ids: selected
                    })
                }).then(() => location.reload());
            });
        }

    });
</script>
