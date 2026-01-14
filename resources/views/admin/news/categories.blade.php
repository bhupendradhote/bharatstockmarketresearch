@extends('layouts.app')

@section('content')
    <div class="max-w-[1200px] mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">News Categories</h2>
            <p class="text-sm text-gray-500">Organize your stories into segments like Tech, Sports, or Politics.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Left: Create Form --}}
            <div class="lg:col-span-4">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sticky top-6">
                    <h3 class="font-bold text-gray-800 mb-4">Create New Category</h3>
                    <form action="{{ route('admin.news.categories.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Category
                                    Name</label>
                                <input name="name" type="text" required placeholder="e.g. Technology"
                                    class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-indigo-500 py-2.5">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Color
                                    Label</label>
                                <input name="color_code" type="color" value="#4f46e5"
                                    class="h-11 w-20 rounded-lg border-gray-200 cursor-pointer p-1">
                            </div>
                            <button type="submit"
                                class="w-full py-3 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg">
                                Save Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Right: Table --}}
            <div class="lg:col-span-8">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Color</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Name</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="w-6 h-6 rounded-full border shadow-sm"
                                            style="background-color: {{ $category->color_code }}"></div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-700">{{ $category->name }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            {{-- Edit Trigger --}}
                                            <button
                                                onclick="openEditModal('{{ $category->id }}', '{{ $category->name }}', '{{ $category->color_code }}')"
                                                class="p-2 text-gray-400 hover:text-indigo-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            {{-- Delete Trigger --}}
                                            <form action="{{ route('admin.news.categories.update', $category->id) }}"
                                                method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">No categories found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal"
        class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-8 shadow-2xl">
            <h3 class="text-xl font-black mb-4">Edit Category</h3>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <input type="text" name="name" id="edit_name" required class="w-full rounded-2xl border-gray-200 py-3"
                    placeholder="Category Name">
                <input type="color" name="color_code" id="edit_color" class="h-12 w-full rounded-xl cursor-pointer">
                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 py-3 bg-gray-100 font-bold rounded-2xl">Cancel</button>
                    <button type="submit"
                        class="flex-1 py-3 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, color) {
            const form = document.getElementById('editForm');
            // This matches the Route: admin.news.categories.update
            form.action = `/admin/news-categories/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_color').value = color;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
@endsection
