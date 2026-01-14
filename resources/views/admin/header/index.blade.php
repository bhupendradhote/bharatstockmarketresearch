@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <style>
        .sortable-ghost {
            opacity: 0.4;
            background-color: #f3f4f6;
            border: 1px dashed #60a5fa;
        }

        .drag-handle {
            cursor: grab;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Strict Border & No Outline Fix */
        .modern-input {
            @apply w-full rounded-lg border border-gray-200 bg-white text-sm py-2 px-3 transition-all duration-200 outline-none;
        }

        .modern-input:focus {
            @apply border-indigo-500 ring-4 ring-indigo-500/10 outline-none;
            outline: none !important;
        }
    </style>

    <div x-data="{
        openEdit: false,
        isEdit: false,
        editItem: { title: '', slug: '', link: '', order_no: 0, show_in_header: 1 },
        editAction: '',
    
        openAddModal() {
            this.isEdit = false;
            this.editItem = { title: '', slug: '', link: '', order_no: 0, show_in_header: 1 };
            this.editAction = '{{ route('admin.header-menus.applylink') }}';
            this.openEdit = true;
        },
    
        openEditModal(item, action) {
            this.isEdit = true;
            this.editItem = item;
            this.editAction = action;
            this.openEdit = true;
        },
    
        // ✅ YAHI ADD KARNA THA
        toggleHeader(id, event) {
            fetch(`/admin/header-menus/${id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        event.target.checked = !event.target.checked;
                        alert('Failed to update status');
                    }
                })
                .catch(() => {
                    event.target.checked = !event.target.checked;
                    alert('Something went wrong');
                });
        }
    
    }" class="mx-auto bg-white shadow rounded-lg p-4">


        <h2 class="text-sm font-semibold mb-4">Header Preview</h2>

        <header
            class="w-full border border-gray-200 rounded-xl mb-10 pb-3 flex items-center justify-between px-10 py-4 bg-gray-50/30">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 [&>svg]:w-6 [&>svg]:h-6">
                    {!! $settings?->logo_svg !!}
                </div>
                <span class="font-semibold text-sm">
                    {{ $settings->website_name ?? 'Site Name' }}
                </span>
            </div>

            @php
                $headerMenus = $menus->where('show_in_header', 1);
                $firstFive = $headerMenus->take(5);
                $remaining = $headerMenus->skip(5);
            @endphp

            <nav class="flex items-center gap-6 relative" x-data="{ openMore: false }">
                @foreach ($firstFive as $m)
                    <a href="{{ $m->link }}" class="text-gray-600 text-xs hover:text-blue-600 relative group">
                        {{ $m->title }}
                        <span
                            class="absolute left-1/2 -bottom-1 w-0 group-hover:w-4 transition-all h-[2px] bg-blue-600 rounded -translate-x-1/2"></span>
                    </a>
                @endforeach

                @if ($remaining->count() > 0)
                    <button @click="openMore = !openMore" class="text-gray-600 text-xs hover:text-blue-600 relative">
                        More ▾
                    </button>
                    <div x-show="openMore" @click.outside="openMore = false" x-transition
                        class="absolute top-8 right-0 bg-white shadow-xl border border-gray-100 rounded-lg w-44 py-2 z-50">
                        @foreach ($remaining as $m)
                            <a href="{{ $m->link }}"
                                class="block text-gray-600 text-xs px-4 py-2 hover:bg-blue-50 hover:text-blue-600 transition">
                                {{ $m->title }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <button @click="openAddModal()" type="button" title="Quick Add"
                    class="ml-2 flex items-center gap-1.5 px-2.5 py-1.5
           bg-white border border-gray-200 text-gray-600 text-xs font-semibold
           rounded-full hover:border-blue-500 hover:text-blue-600
           hover:shadow-md transition-all outline-none">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 6v12M6 12h12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <span>Add Links</span>
                </button>


                @if ($settings && $settings->button_active)
                    <a href="{{ $settings->button_link ?? '#' }}"
                        class="bg-blue-600 text-white text-xs px-4 py-1.5 rounded-full hover:bg-blue-700 transition">
                        {{ $settings->button_text ?? 'Sign In' }}
                    </a>
                @endif
        </header>

        <div class="mt-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-semibold text-gray-700">Manage Menu Items</h3>


                <a href="{{ route('admin.header-menus.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg shadow-sm transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Update Menu Data
                </a>
            </div>

            <div class="overflow-hidden border border-gray-200 rounded-xl">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                        <tr>
                            <th class="p-3 w-10"></th>
                            <th class="p-3">Title</th>
                            <th class="p-3">Link</th>
                            <th class="p-3 text-center">Header</th>
                            <th class="p-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-table">
                        @foreach ($menus as $m)
                            <tr class="border-t border-gray-100 bg-white hover:bg-gray-50 transition-colors"
                                data-id="{{ $m->id }}">
                                <td class="p-3">
                                    <div class="drag-handle text-gray-300 hover:text-blue-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 8h16M4 16h16"></path>
                                        </svg>
                                    </div>
                                </td>
                                <td class="p-3 font-medium text-gray-700">{{ $m->title }}</td>
                                <td class="p-3 text-gray-400 truncate max-w-[150px]">{{ $m->link }}</td>
                                <td class="p-3 text-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer"
                                            {{ $m->show_in_header ? 'checked' : '' }}
                                            @change="toggleHeader({{ $m->id }}, $event)">
                                        <div
                                            class="w-10 h-5 bg-gray-300 rounded-full peer
                   peer-checked:bg-green-600
                   after:content-['']
                   after:absolute after:top-[2px] after:left-[2px]
                   after:bg-white after:rounded-full
                   after:h-4 after:w-4 after:transition-all
                   peer-checked:after:translate-x-5">
                                        </div>
                                    </label>
                                </td>

                                <td class="p-3 flex justify-center gap-2">
                                    <button
                                        @click="openEditModal(@js($m), '{{ route('admin.header-menus.quick-update', $m) }}')"
                                        class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-md transition outline-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 1.21 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>

                                    <form action="{{ route('admin.header-menus.destroy', $m) }}" method="POST"
                                        onsubmit="return confirm('Delete this?')">
                                        @csrf @method('DELETE')
                                        <button
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-md transition outline-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openEdit" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-[100]" x-cloak>

            <div class="bg-white w-full max-w-[440px] rounded-2xl shadow-2xl border border-white/20 overflow-hidden transform transition-all"
                @click.outside="openEdit=false" x-show="openEdit" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white">
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg" x-text="isEdit ? 'Edit Menu Link' : 'Add New Link'">
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5"
                            x-text="isEdit ? 'Update the details for this navigation item.' : 'Create a new navigation item for your header.'">
                        </p>
                    </div>
                    <button @click="openEdit=false"
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-colors outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>

                <form :action="editAction" method="POST" class="p-6 space-y-5">
                    @csrf
                    <template x-if="isEdit">
                        @method('PATCH')
                    </template>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider ml-1">Display
                            Title</label>
                        <input type="text" name="title" x-model="editItem.title" required
                            placeholder="e.g. Services"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50/30 text-sm py-2.5 px-4 transition-all duration-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none shadow-sm">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider ml-1">Destination
                            URL</label>
                        <div class="flex">
                            <span
                                class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-gray-200 bg-gray-100 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101"
                                        stroke-width="2" stroke-linecap="round" />
                                    <path d="M10.172 13.828a4 4 0 015.656 0l4-4a4 4 0 10-5.656-5.656l-1.102 1.101"
                                        stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </span>
                            <input type="text" name="link" x-model="editItem.link"
                                placeholder="https://example.com"
                                class="w-full rounded-r-xl border border-gray-200 bg-gray-50/30 text-sm py-2.5 px-4 transition-all duration-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                        {{-- add here the slug please field please  --}}



                        <div class="flex flex-col justify-center space-y-1.5">
                            <label
                                class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Visibility</label>
                            <label class="relative inline-flex items-center cursor-pointer pt-1">
                                <input type="checkbox" name="show_in_header" value="1"
                                    x-model="editItem.show_in_header" class="sr-only peer">
                                <div
                                    class="w-10 h-5 bg-gray-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[3px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-[0.8rem] after:w-[0.8rem] after:transition-all peer-checked:bg-blue-600">
                                </div>
                                <span class="ml-3 text-xs font-medium text-gray-600">Visible</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-2 flex gap-3">
                        <button type="button" @click="openEdit=false"
                            class="flex-1 px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl text-sm transition-all outline-none">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-[1.5] px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-200 transition-all transform active:scale-95 outline-none"
                            x-text="isEdit ? 'Update Changes' : 'Create Link'">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableBody = document.getElementById('sortable-table');
    
        if (tableBody) {
            Sortable.create(tableBody, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
    
                onEnd: function () {
                    let orderArray = [];
    
                    document.querySelectorAll('#sortable-table tr').forEach(row => {
                        let id = row.getAttribute('data-id');
                        if (id) orderArray.push(id);
                    });
    
                    fetch('{{ route('admin.header-menus.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({ order: orderArray })
                    })
                    .then(res => {
                        console.log('HTTP STATUS:', res.status);
                        return res.text(); // 👈 read raw response
                    })
                    .then(text => {
                        console.log('RAW RESPONSE:', text);
    
                        // try parsing JSON safely
                        try {
                            const data = JSON.parse(text);
                            console.log('PARSED JSON:', data);
    
                            if (data.success) {
                                location.reload();
                            }
                        } catch (e) {
                            console.error('JSON PARSE ERROR:', e);
                        }
                    })
                    .catch(err => {
                        console.error('FETCH ERROR:', err);
                    });
                }
            });
        }
    });
    </script>

@endsection
