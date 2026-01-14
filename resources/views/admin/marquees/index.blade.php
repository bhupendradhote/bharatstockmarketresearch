@extends('layouts.app')

@section('content')
    <div class="p-6" x-data="marqueeCrud()" x-cloak>

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-bold text-gray-800">Marquee / Disclaimer Manager</h1>

            @if (!$hasMarquee)
                <button @click="openCreate()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    + Add Marquee
                </button>
            @endif

        </div>

        <!-- TABLE -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Content</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Order</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($marquees as $marquee)
                        <tr>
                            <td class="px-4 py-3 font-medium">
                                {{ $marquee->title ?? '—' }}
                            </td>

                            <td class="px-4 py-3 text-gray-600 max-w-md">
                                {{ Str::limit(strip_tags($marquee->content), 80) }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <span
                                    class="px-2 py-1 rounded text-xs font-semibold
                            {{ $marquee->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                    {{ $marquee->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $marquee->display_order }}
                            </td>

                            <td class="px-4 py-3 text-right space-x-2">
                                <button @click="openEdit({{ $marquee }})" class="text-indigo-600 hover:underline">
                                    Edit
                                </button>

                                <form action="{{ route('admin.marquees.destroy', $marquee) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Delete this marquee?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                No marquees found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MODAL -->
        <div x-show="showModal" x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

            <div @click.outside="closeModal()" class="bg-white w-full max-w-xl rounded-lg shadow-lg">

                <form :action="formAction" method="POST" class="p-6 space-y-4">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <h2 class="text-lg font-semibold" x-text="isEdit ? 'Edit Marquee' : 'Create Marquee'"></h2>

                    <div>
                        <label class="text-sm font-medium">Title</label>
                        <input type="text" name="title" x-model="form.title" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Content *</label>
                        <textarea name="content" rows="4" x-model="form.content" required class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm">Start At</label>
                            <input type="datetime-local" name="start_at" x-model="form.start_at"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="text-sm">End At</label>
                            <input type="datetime-local" name="end_at" x-model="form.end_at"
                                class="w-full border rounded px-3 py-2">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="is_active" x-model="form.is_active" class="rounded">
                            Active
                        </label>

                        <input type="number" name="display_order" x-model="form.display_order"
                            class="w-20 border rounded px-2 py-1">
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="closeModal()" class="px-4 py-2 border rounded">
                            Cancel
                        </button>

                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ALPINE SCRIPT -->
    <script>
        function marqueeCrud() {
            return {
                showModal: false,
                isEdit: false,
                formAction: '',
                form: {
                    title: '',
                    content: '',
                    start_at: '',
                    end_at: '',
                    is_active: true,
                    display_order: 1,
                },

                openCreate() {
                    this.isEdit = false;
                    this.formAction = "{{ route('admin.marquees.store') }}";
                    this.resetForm();
                    this.showModal = true;
                },

                openEdit(marquee) {
                    this.isEdit = true;
                    this.formAction = `/admin/marquees/${marquee.id}`;

                    this.form = {
                        title: marquee.title,
                        content: marquee.content,
                        start_at: marquee.start_at,
                        end_at: marquee.end_at,
                        is_active: marquee.is_active,
                        display_order: marquee.display_order,
                    };

                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                },

                resetForm() {
                    this.form = {
                        title: '',
                        content: '',
                        start_at: '',
                        end_at: '',
                        is_active: true,
                        display_order: 1,
                    };
                }
            }
        }
    </script>
@endsection
