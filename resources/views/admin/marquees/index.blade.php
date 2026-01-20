{{-- @extends('layouts.app')

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
@endsection --}}


@extends('layouts.app')

@section('content')
    <div class="p-8 bg-gray-50 min-h-screen font-sans" x-data="marqueeCrud()" x-cloak>

        @php $activeMarquee = $marquees->where('is_active', true)->first(); @endphp
        @if ($activeMarquee)
            <div
                class="mb-8 overflow-hidden rounded-xl bg-[#0b3186] text-white py-3 shadow-2xl border border-slate-800 ring-1 ring-white/10">
                <div class="flex items-center px-5 gap-6">
                    <div class="flex items-center gap-2 whitespace-nowrap">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-600"></span>
                        </span>
                        <span class="text-[10px] uppercase font-black tracking-[0.2em] text-indigo-300">Live Preview</span>
                    </div>

                    <div class="h-4 w-[1px] bg-slate-700"></div>

                    <marquee class="text-sm font-semibold tracking-wide text-slate-100 cursor-default" scrollamount="7"
                        direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        @if ($activeMarquee->title)
                            <span class="text-indigo-400 font-black mr-2 uppercase tracking-tighter">
                                [{{ $activeMarquee->title }}]
                            </span>
                        @endif
                        <span class="mr-20">{{ strip_tags($activeMarquee->content) }}</span>
                    </marquee>
                </div>
            </div>
        @endif
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Marquee Manager</h1>
                <p class="text-[11px] text-gray-500 uppercase font-semibold tracking-wider mt-1">Manage scrolling dashboard
                    announcements</p>
            </div>

            <button @click="openCreate"
                class="inline-flex items-center gap-2 px-4 py-2 bg-[#0b3186] text-white text-xs font-bold rounded-lg hover:bg-[#0c3386] transition shadow-sm uppercase">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add Marquee
            </button>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                        <th class="px-6 py-4 text-left">Title</th>
                        <th class="px-6 py-4 text-left">Content</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($marquees as $marquee)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-[13px] font-bold text-gray-800">
                                {{ $marquee->title ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-[12px] text-gray-600 italic leading-relaxed">
                                {{ Str::limit(strip_tags($marquee->content), 80) }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($marquee->is_active)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-tighter">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span>
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black bg-gray-50 text-gray-400 border border-gray-200 uppercase tracking-tighter">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    @if (!$marquee->is_active)
                                        <button @click="activate({{ $marquee->id }})"
                                            class="mr-2 text-[10px] font-black text-emerald-600 hover:text-emerald-700 uppercase tracking-widest transition border border-emerald-200 px-2 py-1 rounded bg-emerald-50/50">
                                            Activate
                                        </button>
                                    @endif

                                    <button @click="openEdit({{ $marquee }})"
                                        class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </button>

                                    <form method="POST" action="{{ route('admin.marquees.destroy', $marquee) }}"
                                        class="inline" onsubmit="return confirm('Delete this marquee?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                            title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                </path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition.opacity>
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

            <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-gray-100 overflow-hidden"
                @click.outside="closeModal">

                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                    <h2 class="text-xs font-black text-gray-800 uppercase tracking-[0.2em]"
                        x-text="isEdit ? 'Update Marquee' : 'Create New Marquee'"></h2>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <form :action="formAction" method="POST" class="p-6 space-y-5">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Headline
                            (Optional)</label>
                        <input type="text" name="title" x-model="form.title" placeholder="e.g. MAINTENANCE NOTICE"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500 outline-none transition">
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Scrolling
                            Text Content</label>
                        <textarea name="content" rows="4" x-model="form.content" placeholder="Enter the message..." required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500 outline-none transition"></textarea>
                    </div>

                    <div class="p-4 bg-indigo-50/30 border border-indigo-100/50 rounded-xl">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="is_active" x-model="form.is_active"
                                class="w-5 h-5 rounded border-gray-300 text-indigo-600">
                            <span class="text-xs font-bold text-indigo-900">Mark as Active Announcement</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="closeModal"
                            class="px-5 py-2.5 text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                            Cancel
                        </button>
                        <button
                            class="px-8 py-2.5 bg-[#0b3186] text-white text-[11px] font-black rounded-xl hover:bg-[#1443a8] shadow-lg uppercase tracking-widest transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function marqueeCrud() {
            return {
                showModal: false,
                isEdit: false,
                formAction: '',
                form: {
                    title: '',
                    content: '',
                    is_active: false
                },
                openCreate() {
                    this.isEdit = false;
                    this.formAction = "{{ route('admin.marquees.store') }}";
                    this.form = {
                        title: '',
                        content: '',
                        is_active: false
                    };
                    this.showModal = true;
                },
                openEdit(m) {
                    this.isEdit = true;
                    this.formAction = `/admin/marquees/${m.id}`;
                    this.form = {
                        title: m.title,
                        content: m.content,
                        is_active: m.is_active
                    };
                    this.showModal = true;
                },
                activate(id) {
                    fetch(`/admin/marquees/${id}/toggle`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => window.location.reload());
                },
                closeModal() {
                    this.showModal = false;
                }
            }
        }
    </script>
@endsection
