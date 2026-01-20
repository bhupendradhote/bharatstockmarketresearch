@extends('layouts.app')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="max-w-9xl mx-auto px-4" x-data="{
        openModal: false,
        editMode: false,
        actionUrl: '',
        categoryName: '',
        categoryStatus: true,
    
        initCreate() {
            this.editMode = false;
            this.actionUrl = '{{ route('admin.blog-categories.store') }}';
            this.categoryName = '';
            this.categoryStatus = true;
            this.openModal = true;
        },
    
        initEdit(category) {
            this.editMode = true;
            this.actionUrl = `/admin/blog-categories/${category.id}`;
            this.categoryName = category.name;
            this.categoryStatus = category.status == 1;
            this.openModal = true;
        }
    }">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div class="flex flex-col gap-4">
                <a href="{{ url('admin/blogs') }}"
                    class="inline-flex items-center text-xs font-extrabold text-gray-400 hover:text-indigo-600 transition-colors group w-fit">
                    <div class="p-1.5 bg-gray-100 group-hover:bg-indigo-50 rounded-lg mr-2 transition-colors">
                        <svg class="w-4 h-4 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18">
                            </path>
                        </svg>
                    </div>
                    BACK
                </a>

                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tighter">Blog Categories</h1>
                    <p class="text-base text-gray-500 mt-1 font-medium">Manage and organize your blog topics</p>
                </div>
            </div>

            <button @click="initCreate()"
                class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-2xl transition-all shadow-lg shadow-indigo-200 hover:-translate-y-0.5 active:translate-y-0">
                <svg class="w-5 h-5 mr-2 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Category
            </button>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                class="mb-8 flex items-center p-4 text-emerald-900 bg-emerald-50 border border-emerald-100 rounded-2xl">
                <div class="p-2 bg-emerald-500 rounded-lg mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="text-sm font-bold tracking-tight">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white border border-gray-100 rounded-[2rem] shadow-xl shadow-gray-200/40 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-[0.15em]">ID
                            </th>
                            <th class="px-8 py-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-[0.15em]">
                                Category Name</th>
                            <th class="px-8 py-5 text-[11px] font-extrabold text-gray-400 uppercase tracking-[0.15em]">
                                Status</th>
                            <th
                                class="px-8 py-5 text-right text-[11px] font-extrabold text-gray-400 uppercase tracking-[0.15em]">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($categories as $index => $category)
                            <tr class="group hover:bg-indigo-50/30 transition-all duration-200">
                                <td class="px-8 py-5 text-sm text-gray-400 font-bold">#{{ $index + 1 }}</td>
                                <td class="px-8 py-5">
                                    <span
                                        class="text-base font-bold text-gray-800 tracking-tight group-hover:text-indigo-700 transition-colors">
                                        {{ $category->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    @if ($category->status)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-emerald-100 text-emerald-700">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-gray-100 text-gray-500">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right space-x-1">
                                    <button @click="initEdit({{ $category }})"
                                        class="inline-flex items-center px-4 py-2 text-xs font-extrabold text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition-all">
                                        Edit
                                    </button>

                                    <form method="POST"
                                        action="{{ route('admin.blog-categories.destroy', $category->id) }}"
                                        class="inline-block" onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="inline-flex items-center px-4 py-2 text-xs font-extrabold text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition-all">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <span class="text-gray-400 font-bold">No blog categories found.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-6">
                    {{ $categories->links('pagination.dots') }}
                </div>
            </div>

            <template x-teleport="body">
                <div x-show="openModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>

                    <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="openModal = false"
                        class="absolute inset-0 bg-gray-900/40 backdrop-blur-md"></div>

                    <div x-show="openModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                        class="relative w-full max-w-lg bg-white rounded-[2.5rem] shadow-2xl overflow-hidden">

                        <div class="px-10 pt-10 pb-6 flex justify-between items-center">
                            <div>
                                <h3 class="text-2xl font-extrabold text-gray-900 tracking-tighter"
                                    x-text="editMode ? 'Edit Blog Category' : 'New Blog Category'"></h3>
                                <p class="text-sm text-gray-500 font-medium mt-1">Provide the category name and status</p>
                            </div>
                            <button @click="openModal = false"
                                class="p-2 bg-gray-100 hover:bg-gray-200 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form :action="actionUrl" method="POST" class="px-10 pb-10">
                            @csrf
                            <template x-if="editMode">
                                <input type="hidden" name="_method" value="PUT">
                            </template>

                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="block text-xs font-extrabold text-gray-400 uppercase tracking-widest mb-2 ml-1">Category
                                        Name</label>
                                    <input type="text" name="name" x-model="categoryName" required
                                        class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all outline-none text-base font-semibold"
                                        placeholder="e.g. Technology, Lifestyle...">
                                </div>

                                <label
                                    class="flex items-center group cursor-pointer p-2 bg-gray-50 rounded-2xl border border-transparent hover:border-indigo-100 hover:bg-indigo-50/30 transition-all duration-300">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" name="status" value="1" x-model="categoryStatus"
                                            class="sr-only peer">
                                        <div
                                            class="w-12 h-6 bg-gray-300 rounded-full peer peer-checked:bg-indigo-600 transition-all duration-300">
                                        </div>
                                        <div
                                            class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow-sm peer-checked:translate-x-6 transition-transform duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]">
                                        </div>
                                    </div>
                                    <div class="ml-4 flex flex-col">
                                        <span
                                            class="text-sm font-bold text-gray-700 group-hover:text-indigo-600 transition-colors">Active
                                            Status</span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Visible in blog
                                            filters</span>
                                    </div>
                                </label>
                            </div>

                            <div class="mt-10 flex gap-4">
                                <button type="button" @click="openModal = false"
                                    class="flex-1 px-6 py-4 text-sm font-bold text-gray-500 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-all">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="flex-[2] px-6 py-4 text-sm font-bold text-white bg-indigo-600 rounded-2xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all">
                                    <span x-text="editMode ? 'Update Category' : 'Save Category'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>
        </div>
    @endsection
