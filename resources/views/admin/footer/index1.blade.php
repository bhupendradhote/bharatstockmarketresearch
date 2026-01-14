@extends('layouts.app')

@section('content')
    <div x-data="{
        openAddColumn: false,
        openAddLink: false,
        openEditColumn: false,
        openEditLink: false,
        openEditSocial: false,
        editItem: {},
        editAction: ''
    }" class="mx-auto p-4 text-xs">

        <h2 class="text-sm font-semibold mb-4">Footer Builder</h2>

        {{-- ================================================= --}}
        {{-- 3 COLUMN LAYOUT --}}
        {{-- ================================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- ================================================= --}}
            {{-- 1) FOOTER SETTINGS --}}
            {{-- ================================================= --}}
            <div class="bg-white shadow rounded-lg p-3">
                <h3 class="text-xs font-semibold mb-2 border-b pb-1">Footer Settings</h3>

                <form method="POST" action="{{ route('admin.footer.settings.update') }}" class="grid gap-2">
                    @csrf

                    <label>Email</label>
                    <input type="text" name="email" value="{{ $settings->email }}" class="border rounded px-2 py-1">

                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $settings->phone }}" class="border rounded px-2 py-1">

                    <label>Address</label>
                    <textarea name="address" class="border rounded px-2 py-1">{{ $settings->address }}</textarea>

                    <label>Copyright Text</label>
                    <input type="text" name="copyright_text" value="{{ $settings->copyright_text }}"
                        class="border rounded px-2 py-1">

                    <button class="bg-blue-600 text-white rounded px-3 py-1 mt-2">Update</button>
                </form>
            </div>

            {{-- ================================================= --}}
            {{-- 2) FOOTER COLUMNS + LINKS (Manager) --}}
            {{-- ================================================= --}}
            <div class="bg-white shadow rounded-lg p-3">

                <h3 class="text-xs font-semibold mb-2 border-b pb-1">Footer Columns</h3>

                <button @click="openAddColumn=true" class="bg-blue-600 text-white px-3 py-1 rounded mb-3">
                    + Add Column
                </button>

                {{-- Columns list (manager) --}}
                <div id="sortableColumns" class="space-y-3 max-h-[450px] overflow-y-auto">

                    @foreach ($columns as $column)
                        <div class="border rounded p-2 bg-white column-item flex items-start justify-between"
                            data-id="{{ $column->id }}">

                            <div class="flex items-center gap-3">
                                {{-- drag handle --}}
                                <span class="drag-handle cursor-move text-gray-400 text-lg">☰</span>

                                {{-- column title (click to edit) --}}
                                <div>
                                    <div class="font-semibold cursor-pointer"
                                        @click="
                                            openEditColumn = true;
                                            editItem = { id: {{ $column->id }}, title: '{{ $column->title }}' };
                                            editAction = '{{ route('admin.footer.column.update', $column->id) }}';
                                         ">
                                        {{ $column->title }}
                                    </div>
                                    <div class="text-gray-400 text-[11px]">Links: {{ $column->links->count() }}</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- add link quick button (opens add link modal) --}}
                                <button type="button"
                                    @click="
                                        openAddLink = true;
                                        editItem = { footer_column_id: {{ $column->id }} };
                                    "
                                    class="text-blue-600 text-lg px-2 py-0.5" title="Add link to {{ $column->title }}">
                                    +
                                </button>

                                {{-- edit --}}
                                <button type="button"
                                    @click="
                                        openEditColumn = true;
                                        editItem = { id: {{ $column->id }}, title: '{{ $column->title }}' };
                                        editAction = '{{ route('admin.footer.column.update', $column->id) }}';
                                    "
                                    class="border text-yellow-600 rounded px-2 py-0.5 text-[10px]">
                                    Edit
                                </button>

                                {{-- delete --}}
                                <form method="POST" action="{{ route('admin.footer.column.delete', $column->id) }}"
                                    onsubmit="return confirm('Delete column?')">
                                    @csrf @method('DELETE')
                                    <button class="border text-red-600 rounded px-2 py-0.5 text-[10px]">Del</button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            {{-- ================================================= --}}
            {{-- 3) SOCIAL ICONS --}}
            {{-- ================================================= --}}
            <div class="bg-white shadow rounded-lg p-3">

                <h3 class="text-xs font-semibold mb-2 border-b pb-1">Social Icons</h3>

                <form method="POST" action="{{ route('admin.footer.social.store') }}" class="grid gap-2 mb-3">
                    @csrf
                    <input name="label" class="border rounded px-2 py-1" placeholder="Label">
                    <input name="icon" class="border rounded px-2 py-1" placeholder="fa-facebook">
                    <input name="url" class="border rounded px-2 py-1" placeholder="URL">

                    <button class="bg-blue-600 text-white px-3 py-1 rounded">+ Add Social</button>
                </form>

                <div id="sortableSocials" class="space-y-2 max-h-[450px] overflow-y-auto">

                    @foreach ($socials as $s)
                        <div class="social-item border rounded p-2 flex justify-between items-center"
                            data-id="{{ $s->id }}">

                            <div class="flex items-center gap-2">
                                <span class="drag-handle cursor-move text-gray-400">⋮⋮</span>

                                <div @click="
                                    openEditSocial=true;
                                    editItem={
                                        id:{{ $s->id }},
                                        label:'{{ $s->label }}',
                                        icon:'{{ $s->icon }}',
                                        url:'{{ $s->url }}'
                                    };
                                    editAction='{{ route('admin.footer.social.update', $s->id) }}';
                                "
                                    class="cursor-pointer">
                                    <div class="font-semibold">{{ $s->label }}</div>
                                    <div class="text-gray-500 text-[11px]">{{ $s->icon }} — {{ $s->url }}</div>
                                </div>
                            </div>

                            <form action="{{ route('admin.footer.social.delete', $s->id) }}" method="POST"
                                onsubmit="return confirm('Delete social icon?')">
                                @csrf @method('DELETE')
                                <button class="border text-red-600 rounded px-2 py-0.5 text-[10px]">Del</button>
                            </form>

                        </div>
                    @endforeach

                </div>

            </div>

        </div> {{-- END GRID --}}

        {{-- ================================================= --}}
        {{-- FOOTER PREVIEW (FULLY DRAGGABLE + EDITABLE) --}}
        {{-- ================================================= --}}
        <div class="mt-10 bg-white shadow rounded-lg p-6">

            <h3 class="text-xs font-semibold mb-3 border-b pb-2">Footer Preview (Drag & Edit)</h3>

            {{-- preview columns are sortable (reorders columns visually) --}}
            <div id="footerPreviewColumns" class="grid grid-cols-2 md:grid-cols-4 gap-4 text-[11px]">

                @foreach ($columns as $col)
                    <div class="footer-column-preview border rounded p-2" data-id="{{ $col->id }}">

                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="drag-handle cursor-move text-gray-400">☰</span>

                                <div class="font-bold uppercase cursor-pointer"
                                    @click="
                                        openEditColumn=true;
                                        editItem={id:{{ $col->id }},title:'{{ $col->title }}'};
                                        editAction='{{ route('admin.footer.column.update', $col->id) }}';
                                     ">
                                    {{ $col->title }}
                                </div>
                            </div>

                            {{-- add link in preview --}}
                            <button type="button" class="text-blue-600 text-lg"
                                @click="
                                        openAddLink=true;
                                        editItem = { footer_column_id: {{ $col->id }} };
                                    "
                                title="Add link to {{ $col->title }}">
                                +
                            </button>
                        </div>

                        {{-- links preview (sortable per column) --}}
                        <ul id="links-preview-{{ $col->id }}" class="sortableLinksPreview space-y-1"
                            data-column-id="{{ $col->id }}">
                            @foreach ($col->links as $link)
                                <li class="flex items-center gap-2 link-item-preview p-1 border rounded"
                                    data-id="{{ $link->id }}">
                                    <span class="drag-handle cursor-move text-gray-400 text-[10px]">⋮⋮</span>

                                    <div class="flex-1">
                                        <div class="text-gray-700 cursor-pointer"
                                            @click="
                                                openEditLink=true;
                                                editItem={id:{{ $link->id }},label:'{{ $link->label }}',url:'{{ $link->url }}'};
                                                editAction='{{ route('admin.footer.link.update', $link->id) }}';
                                             ">
                                            {{ $link->label }}
                                        </div>
                                        <div class="text-gray-400 text-[11px]">{{ $link->url }}</div>
                                    </div>

                                    <form method="POST" action="{{ route('admin.footer.link.delete', $link->id) }}"
                                        onsubmit="return confirm('Delete link?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 text-[10px] px-2 py-0.5 border rounded">Del</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                @endforeach

                {{-- Social & Contact in preview --}}
                <div class="border rounded p-2">
                    <div class="font-bold uppercase mb-2">Follow Us</div>

                    <div class="flex gap-3 mb-3">
                        @foreach ($socials as $s)
                            <i class="{{ $s->icon }} text-lg cursor-pointer hover:text-blue-600"
                                @click="
                                openEditSocial=true;
                                editItem={
                                    id:{{ $s->id }},
                                    label:'{{ $s->label }}',
                                    icon:'{{ $s->icon }}',
                                    url:'{{ $s->url }}'
                                };
                                editAction='{{ route('admin.footer.social.update', $s->id) }}';
                            "></i>
                        @endforeach
                    </div>

                    <div class="space-y-1">
                        @if ($settings->email)
                            <p><strong>Email:</strong> {{ $settings->email }}</p>
                        @endif
                        @if ($settings->address)
                            <p><strong>Address:</strong> {{ $settings->address }}</p>
                        @endif
                        @if ($settings->phone)
                            <p><strong>Phone:</strong> {{ $settings->phone }}</p>
                        @endif
                    </div>
                </div>

            </div>

            <div class="border-t my-4"></div>

            <div class="text-center text-gray-600 text-[11px]">
                <p>Bharath Stock Market Research</p>
                <p>{{ $settings->copyright_text }}</p>
            </div>

        </div>

        {{-- ================================================= --}}
        {{-- MODALS (ADD / EDIT COLUMN / LINK / SOCIAL) --}}
        {{-- ================================================= --}}

        {{-- ADD COLUMN --}}
        <div x-show="openAddColumn" x-transition class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-80 p-4 rounded shadow" @click.outside="openAddColumn=false">

                <h3 class="text-sm font-semibold mb-2">Add Column</h3>

                <form action="{{ route('admin.footer.column.store') }}" method="POST">
                    @csrf

                    <input name="title" placeholder="Column Title" class="border rounded px-2 py-1 w-full mb-2">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openAddColumn=false"
                            class="bg-gray-300 px-3 py-1 rounded">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded">Add</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- ADD LINK (used by manager + preview + add icon) --}}
        <div x-show="openAddLink" x-transition class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded shadow" @click.outside="openAddLink=false">

                <h3 class="text-sm font-semibold mb-2">Add Link</h3>

                <form action="{{ route('admin.footer.link.store') }}" method="POST">
                    @csrf

                    <!-- use Alpine binding for column id -->
                    <input type="hidden" name="footer_column_id" x-bind:value="editItem.footer_column_id">

                    <label class="text-xs">Label</label>
                    <input name="label" class="border rounded px-2 py-1 w-full mb-2">

                    <label class="text-xs">URL</label>
                    <input name="url" class="border rounded px-2 py-1 w-full mb-2">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openAddLink=false"
                            class="bg-gray-300 px-3 py-1 rounded">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded">Add Link</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- EDIT COLUMN --}}
        <div x-show="openEditColumn" x-transition class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-80 p-4 rounded shadow" @click.outside="openEditColumn=false">

                <h3 class="text-sm font-semibold mb-2">Edit Column</h3>

                <form :action="editAction" method="POST">
                    @csrf @method('PATCH')

                    <input type="text" name="title" x-model="editItem.title"
                        class="border rounded px-2 py-1 w-full mb-2">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openEditColumn=false"
                            class="bg-gray-300 px-3 py-1 rounded">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded">Update</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- EDIT LINK --}}
        <div x-show="openEditLink" x-transition class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded shadow" @click.outside="openEditLink=false">

                <h3 class="text-sm font-semibold mb-2">Edit Link</h3>

                <form :action="editAction" method="POST">
                    @csrf @method('PATCH')

                    <label class="text-xs">Label</label>
                    <input name="label" x-model="editItem.label" class="border rounded px-2 py-1 w-full mb-2">

                    <label class="text-xs">URL</label>
                    <input name="url" x-model="editItem.url" class="border rounded px-2 py-1 w-full mb-2">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openEditLink=false"
                            class="bg-gray-300 px-3 py-1 rounded">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded">Update</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- EDIT SOCIAL --}}
        <div x-show="openEditSocial" x-transition class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded shadow" @click.outside="openEditSocial=false">

                <h3 class="text-sm font-semibold mb-2">Edit Social Icon</h3>

                <form :action="editAction" method="POST">
                    @csrf @method('PATCH')

                    <label class="text-xs">Label</label>
                    <input name="label" x-model="editItem.label" class="border rounded px-2 py-1 w-full mb-2">

                    <label class="text-xs">Icon Class</label>
                    <input name="icon" x-model="editItem.icon" class="border rounded px-2 py-1 w-full mb-2">

                    <label class="text-xs">URL</label>
                    <input name="url" x-model="editItem.url" class="border rounded px-2 py-1 w-full mb-2">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openEditSocial=false"
                            class="bg-gray-300 px-3 py-1 rounded">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded">Update</button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    {{-- ================================================= --}}
    {{-- DRAG & DROP SCRIPT --}}
    {{-- ================================================= --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            /* SORTABLE: Manager Columns */
            const managerColumns = document.getElementById("sortableColumns");
            if (managerColumns) {
                new Sortable(managerColumns, {
                    animation: 150,
                    handle: ".drag-handle",
                    onEnd() {
                        const order = Array.from(document.querySelectorAll(".column-item")).map(el => el
                            .dataset.id);
                        sendOrder("{{ route('admin.footer.column.reorder') }}", {
                            order
                        });
                    }
                });
            }

            /* SORTABLE: Preview Columns (visual) */
            const previewCols = document.getElementById("footerPreviewColumns");
            if (previewCols) {
                new Sortable(previewCols, {
                    animation: 150,
                    handle: ".drag-handle",
                    onEnd() {
                        const order = Array.from(previewCols.querySelectorAll(".footer-column-preview"))
                            .map(el => el.dataset.id);
                        // reuse same endpoint to reorder columns
                        sendOrder("{{ route('admin.footer.column.reorder') }}", {
                            order
                        });
                    }
                });
            }

            /* SORTABLE: Links in Manager (each column links if present) */
            document.querySelectorAll("[id^='links-']").forEach(list => {
                new Sortable(list, {
                    animation: 150,
                    handle: ".drag-handle",
                    onEnd() {
                        const columnId = list.id.replace('links-', '');
                        const order = Array.from(list.querySelectorAll(".link-item")).map(el => el
                            .dataset.id);
                        sendOrder("{{ route('admin.footer.link.reorder') }}", {
                            order,
                            column_id: columnId
                        });
                    }
                });
            });

            /* SORTABLE: Links in Preview (per column) */
            document.querySelectorAll(".sortableLinksPreview").forEach(list => {
                new Sortable(list, {
                    animation: 150,
                    handle: ".drag-handle",
                    onEnd() {
                        const columnId = list.dataset.columnId;
                        const order = Array.from(list.querySelectorAll(".link-item-preview")).map(
                            el => el.dataset.id);
                        sendOrder("{{ route('admin.footer.link.reorder') }}", {
                            order,
                            column_id: columnId
                        });
                    }
                });
            });

            /* SORTABLE: Social Icons */
            const socialList = document.getElementById("sortableSocials");
            if (socialList) {
                new Sortable(socialList, {
                    animation: 150,
                    handle: ".drag-handle",
                    onEnd() {
                        const order = Array.from(document.querySelectorAll(".social-item")).map(el => el
                            .dataset.id);
                        sendOrder("{{ route('admin.footer.social.reorder') }}", {
                            order
                        });
                    }
                });
            }
        });

        /* SEND REORDER REQUEST */
        function sendOrder(url, payload) {
            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(payload)
            }).catch(e => {
                console.error("Reorder request failed", e);
            });
        }
    </script>
@endsection
