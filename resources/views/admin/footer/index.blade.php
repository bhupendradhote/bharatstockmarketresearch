@extends('layouts.app')

@push('styles')
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .empty-state {
            padding: 2rem;
            text-align: center;
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            background: #f9fafb;
        }

        .empty-state h4 {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #4b5563;
        }

        .empty-state p {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }

        .social-icons-wrapper {
            position: relative;
            padding: 0.5rem;
        }

        .add-social-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: #3b82f6;
            color: white;
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .social-icon-item {
            position: relative;
            display: inline-block;
            margin: 0.25rem;
        }

        .social-icon-item:hover .social-actions {
            display: flex;
        }

        .social-actions {
            position: absolute;
            top: -0.5rem;
            right: -0.5rem;
            display: none;
            gap: 0.125rem;
        }

        .social-action-btn {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.625rem;
            cursor: pointer;
        }

        .drag-handle {
            cursor: move;
        }

        .preview-empty-state {
            padding: 1.5rem;
            text-align: center;
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            background: #f8fafc;
        }
    </style>
@endpush

@section('content')
    <div x-data="{
        openAddColumn: false,
        openAddLink: false,
        openEditColumn: false,
        openEditLink: false,
        openEditSocial: false,
        openEditSettings: false,
        openAddSocial: false,
        openEditBrand: false,
        openAddBrand: false,
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

                    <label class="text-xs font-semibold">Email</label>
                    <input type="text" name="email" value="{{ $settings->email }}" class="border rounded px-2 py-1">

                    <label class="text-xs font-semibold">Phone</label>
                    <input type="text" name="phone" value="{{ $settings->phone }}" class="border rounded px-2 py-1">

                    <label class="text-xs font-semibold">Address</label>
                    <textarea name="address" class="border rounded px-2 py-1">{{ $settings->address }}</textarea>

                    <label class="text-xs font-semibold">Copyright Text</label>
                    <input type="text" name="copyright_text" value="{{ $settings->copyright_text }}"
                        class="border rounded px-2 py-1">

                    <button class="bg-blue-600 text-white rounded px-3 py-1 mt-2 text-xs hover:bg-blue-700">
                        Update Settings
                    </button>
                </form>
            </div>

            {{-- ================================================= --}}
            {{-- 2) FOOTER COLUMNS + LINKS (Manager) --}}
            {{-- ================================================= --}}
            <div class="bg-white shadow rounded-lg p-3">

                <h3 class="text-xs font-semibold mb-2 border-b pb-1">Footer Columns</h3>

                <button @click="openAddColumn=true"
                    class="bg-blue-600 text-white px-3 py-1 rounded mb-3 text-xs hover:bg-blue-700">
                    + Add Column
                </button>

                {{-- Columns list (manager) --}}
                <div id="sortableColumns" class="space-y-3 max-h-[450px] overflow-y-auto">

                    @if ($columns->count() > 0)
                        @foreach ($columns as $column)
                            <div class="border rounded p-2 bg-white column-item flex items-start justify-between hover:bg-gray-50"
                                data-id="{{ $column->id }}">

                                <div class="flex items-center gap-3">
                                    {{-- drag handle --}}
                                    <span class="drag-handle cursor-move text-gray-400 text-lg">☰</span>

                                    {{-- column title (click to edit) --}}
                                    <div>
                                        <div class="font-semibold cursor-pointer hover:text-blue-600"
                                            @click="
                                                openEditColumn = true;
                                                editItem = { id: {{ $column->id }}, title: '{{ addslashes($column->title) }}' };
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
                                        class="text-blue-600 text-lg px-2 py-0.5 hover:text-blue-800"
                                        title="Add link to {{ $column->title }}">
                                        +
                                    </button>

                                    {{-- edit --}}
                                    <button type="button"
                                        @click="
                                            openEditColumn = true;
                                            editItem = { id: {{ $column->id }}, title: '{{ addslashes($column->title) }}' };
                                            editAction = '{{ route('admin.footer.column.update', $column->id) }}';
                                        "
                                        class="border text-yellow-600 rounded px-2 py-0.5 text-[10px] hover:bg-yellow-50">
                                        Edit
                                    </button>

                                    {{-- delete --}}
                                    <form method="POST" action="{{ route('admin.footer.column.delete', $column->id) }}"
                                        onsubmit="return confirm('Delete column?')">
                                        @csrf @method('DELETE')
                                        <button class="border text-red-600 rounded px-2 py-0.5 text-[10px] hover:bg-red-50">
                                            Del
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <h4>No Columns Yet</h4>
                            <p>Start by adding your first footer column</p>
                            <button @click="openAddColumn=true"
                                class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                + Create First Column
                            </button>
                        </div>
                    @endif

                </div>
            </div>

            {{-- ================================================= --}}
            {{-- 3) SOCIAL ICONS --}}
            {{-- ================================================= --}}
            <div class="bg-white shadow rounded-lg p-3">

                <h3 class="text-xs font-semibold mb-2 border-b pb-1">Social Icons</h3>

                <div class="mb-3">
                    <button @click="openAddSocial=true"
                        class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 w-full mb-2">
                        + Add Social Icon
                    </button>
                </div>

                <div id="sortableSocials" class="space-y-2 max-h-[450px] overflow-y-auto">

                    @if ($socials->count() > 0)
                        @foreach ($socials as $s)
                            <div class="social-item border rounded p-2 flex justify-between items-center hover:bg-gray-50"
                                data-id="{{ $s->id }}">

                                <div class="flex items-center gap-2">
                                    <span class="drag-handle cursor-move text-gray-400">⋮⋮</span>

                                    <div @click="
                                        openEditSocial=true;
                                        editItem={
                                            id:{{ $s->id }},
                                            label:'{{ addslashes($s->label) }}',
                                            icon:'{{ addslashes($s->icon) }}',
                                            url:'{{ addslashes($s->url) }}'
                                        };
                                        editAction='{{ route('admin.footer.social.update', $s->id) }}';
                                    "
                                        class="cursor-pointer flex items-center gap-2">
                                        <i class="{{ $s->icon }} text-lg w-6 text-center"></i>
                                        <div>
                                            <div class="font-semibold">{{ $s->label }}</div>
                                            <div class="text-gray-500 text-[11px]">{{ $s->url }}</div>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('admin.footer.social.delete', $s->id) }}" method="POST"
                                    onsubmit="return confirm('Delete social icon?')">
                                    @csrf @method('DELETE')
                                    <button class="border text-red-600 rounded px-2 py-0.5 text-[10px] hover:bg-red-50">
                                        Del
                                    </button>
                                </form>

                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <h4>No Social Icons</h4>
                            <p>Add social media links to your footer</p>
                        </div>
                    @endif

                </div>

            </div>

        </div> {{-- END GRID --}}



        {{-- ================================================= --}}
        {{-- FOOTER PREVIEW (FULLY DRAGGABLE + EDITABLE) --}}
        {{-- ================================================= --}}
        <div class="mt-10 bg-white shadow rounded-lg p-6">

            <h3 class="text-xs font-semibold mb-3 border-b pb-2">Footer Preview (Drag & Edit)</h3>

            {{-- Edit settings button --}}
            <div class="flex justify-between mb-3">
                <button class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs hover:bg-gray-200"
                    @click="openAddColumn=true">
                    + Add Column
                </button>

                <button class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs hover:bg-gray-200"
                    @click="openEditSettings = true">
                    Edit Footer Settings
                </button>
            </div>

            <div class="border rounded p-4 mb-6 hover:bg-gray-50">

                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold uppercase text-xs">Branding</h3>

                    @if ($brand && $brand->title)
                        <button type="button"
                            class="text-yellow-600 text-[10px] px-2 py-1 border rounded hover:bg-yellow-50"
                            @click="
                                    openEditBrand = true;
                                    editAction = '{{ route('admin.footer.brand.update') }}';

                                    editItem = {
                                        title: @js($brand->title),
                                        subtitle: @js($brand->subtitle),
                                        icon_svg: @js($brand->icon_svg),
                                        description: @js($brand->description),
                                        button_text: @js($brand->button_text),
                                        button_link: @js($brand->button_link),
                                        note: @js($brand->note)
                                    };
                                ">
                            Edit
                        </button>
                    @else
                        <button type="button" class="text-blue-600 text-[12px] px-2 py-1 rounded"
                            @click="openAddBrand=true; editAction='{{ route('admin.footer.brand.update') }}'">
                            + Add Branding
                        </button>
                    @endif
                </div>

                {{-- Brand Preview --}}
                @if ($brand && $brand->title)
                    <div class="flex items-center gap-3">
                        {{-- icon --}}
                        @if ($brand->icon_svg)
                            <div class="w-10 h-10">{!! $brand->icon_svg !!}</div>
                        @else
                            <div class="w-10 h-10 bg-blue-600 rounded-full"></div>
                        @endif

                        <div>
                            <div class="font-semibold">{{ $brand->title }}</div>
                            @if ($brand->subtitle)
                                <div class="text-gray-500 text-[12px]">{{ $brand->subtitle }}</div>
                            @endif
                        </div>
                    </div>

                    @if ($brand->description)
                        <p class="text-gray-600 text-[12px] mt-2">{{ $brand->description }}</p>
                    @endif
                @else
                    <p class="text-gray-400 text-[12px]">No branding added yet.</p>
                @endif

            </div>

            {{-- preview columns are sortable (reorders columns visually) --}}
            <div id="footerPreviewColumns" class="grid grid-cols-2 md:grid-cols-4 gap-4 text-[11px]">

                {{-- BRANDING block (grid item) --}}
                {{-- BRANDING ROW (FULL WIDTH, TOP LEFT) --}}


                {{-- EXISTING COLUMNS --}}
                @if ($columns->count() > 0)
                    @foreach ($columns as $col)
                        <div class="footer-column-preview border rounded p-2 hover:bg-gray-50"
                            data-id="{{ $col->id }}">

                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="drag-handle cursor-move text-gray-400">☰</span>

                                    <div class="font-bold uppercase cursor-pointer hover:text-blue-600"
                                        @click="
                                            openEditColumn=true;
                                            editItem={id:{{ $col->id }},title:'{{ addslashes($col->title) }}'};
                                            editAction='{{ route('admin.footer.column.update', $col->id) }}';
                                         ">
                                        {{ $col->title }}
                                    </div>
                                </div>

                                {{-- add link in preview --}}
                                <button type="button" class="text-blue-600 text-lg hover:text-blue-800"
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
                                @if ($col->links->count() > 0)
                                    @foreach ($col->links as $link)
                                        <li class="flex items-center gap-2 link-item-preview p-1 border rounded hover:bg-blue-50"
                                            data-id="{{ $link->id }}">
                                            <span class="drag-handle cursor-move text-gray-400 text-[10px]">⋮⋮</span>

                                            <div class="flex-1">
                                                <div class="text-gray-700 cursor-pointer hover:text-blue-600"
                                                    @click="
                                                        openEditLink=true;
                                                        editItem={id:{{ $link->id }},label:'{{ addslashes($link->label) }}',url:'{{ addslashes($link->url) }}'};
                                                        editAction='{{ route('admin.footer.link.update', $link->id) }}';
                                                     ">
                                                    {{ $link->label }}
                                                </div>
                                                <div class="text-gray-400 text-[11px] truncate">{{ $link->url }}</div>
                                            </div>

                                            <form method="POST"
                                                action="{{ route('admin.footer.link.delete', $link->id) }}"
                                                onsubmit="return confirm('Delete link?')">
                                                @csrf @method('DELETE')
                                                <button
                                                    class="text-red-600 text-[10px] px-2 py-0.5 border rounded hover:bg-red-50">
                                                    Del
                                                </button>
                                            </form>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="text-center text-gray-400 text-[10px] py-2">
                                        No links yet. Click + to add.
                                    </li>
                                @endif
                            </ul>

                        </div>
                    @endforeach
                @else
                    {{-- Empty state for columns --}}
                    <div class="col-span-2 md:col-span-3 preview-empty-state">
                        <h4 class="font-semibold mb-2">No Footer Columns Yet</h4>
                        <p class="text-gray-500 mb-3">Add columns to organize your footer links</p>
                        <button @click="openAddColumn=true"
                            class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                            + Add First Column
                        </button>
                    </div>
                @endif

                {{-- Social & Contact in preview --}}
                <div class="border rounded p-2 hover:bg-gray-50">
                    <div class="flex items-center justify-between mb-2">
                        <div class="font-bold uppercase">Follow Us</div>
                        <button type="button" class="text-blue-600 text-lg hover:text-blue-800"
                            @click="openAddSocial=true" title="Add social icon">
                            +
                        </button>
                    </div>

                    {{-- Social Icons with drag & drop and edit --}}
                    <div id="previewSocialIcons" class="social-icons-wrapper flex flex-wrap gap-2 mb-3">
                        @foreach ($socials as $s)
                            <div class="social-icon-item" data-id="{{ $s->id }}">
                                <i class="{{ $s->icon }} text-lg cursor-pointer hover:text-blue-600"
                                    @click="
                                    openEditSocial=true;
                                    editItem={
                                        id:{{ $s->id }},
                                        label:'{{ addslashes($s->label) }}',
                                        icon:'{{ addslashes($s->icon) }}',
                                        url:'{{ addslashes($s->url) }}'
                                    };
                                    editAction='{{ route('admin.footer.social.update', $s->id) }}';
                                "
                                    title="{{ $s->label }}"></i>
                                <div class="social-actions">
                                    <button class="social-action-btn text-blue-600 hover:bg-blue-50"
                                        @click.stop="
                                            openEditSocial=true;
                                            editItem={
                                                id:{{ $s->id }},
                                                label:'{{ addslashes($s->label) }}',
                                                icon:'{{ addslashes($s->icon) }}',
                                                url:'{{ addslashes($s->url) }}'
                                            };
                                            editAction='{{ route('admin.footer.social.update', $s->id) }}';
                                        ">
                                        ✎
                                    </button>
                                    <form action="{{ route('admin.footer.social.delete', $s->id) }}" method="POST"
                                        onsubmit="return confirm('Delete social icon?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="social-action-btn text-red-600 hover:bg-red-50">
                                            ×
                                        </button>
                                    </form>
                                </div>
                                <span
                                    class="drag-handle cursor-move text-gray-400 text-[10px] absolute -top-1 -right-1">⋮⋮</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-1">
                        @if ($settings->email)
                            <p class="cursor-pointer hover:text-blue-600" @click="openEditSettings = true">
                                <strong>Email:</strong> {{ $settings->email }}
                            </p>
                        @endif
                        @if ($settings->address)
                            <p class="cursor-pointer hover:text-blue-600" @click="openEditSettings = true">
                                <strong>Address:</strong> {{ $settings->address }}
                            </p>
                        @endif
                        @if ($settings->phone)
                            <p class="cursor-pointer hover:text-blue-600" @click="openEditSettings = true">
                                <strong>Phone:</strong> {{ $settings->phone }}
                            </p>
                        @endif
                    </div>
                </div>

            </div>

            <div class="border-t my-4"></div>

            <div class="text-center text-gray-600 text-[11px]">
                <p>{{ $settings->copyright_text }}</p>
            </div>

        </div>

        {{-- ================================================= --}}
        {{-- MODALS (ADD / EDIT COLUMN / LINK / SOCIAL / SETTINGS) --}}
        {{-- ================================================= --}}

        {{-- ADD COLUMN --}}
        <div x-show="openAddColumn" x-transition class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-80 p-4 rounded shadow" @click.outside="openAddColumn=false">

                <h3 class="text-sm font-semibold mb-2">Add Column</h3>

                <form action="{{ route('admin.footer.column.store') }}" method="POST">
                    @csrf

                    <input name="title" placeholder="Column Title (e.g., Company, Services)"
                        class="border rounded px-2 py-1 w-full mb-2 text-xs" required>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openAddColumn=false"
                            class="bg-gray-300 px-3 py-1 rounded text-xs hover:bg-gray-400">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Add</button>
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

                    <label class="text-xs">Label *</label>
                    <input name="label" class="border rounded px-2 py-1 w-full mb-2 text-xs" required>

                    <label class="text-xs">URL *</label>
                    <input name="url" class="border rounded px-2 py-1 w-full mb-2 text-xs" required
                        placeholder="https://example.com or /page">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openAddLink=false"
                            class="bg-gray-300 px-3 py-1 rounded text-xs hover:bg-gray-400">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Add
                            Link</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- ADD SOCIAL --}}
        <div x-show="openAddSocial" x-transition class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-4 rounded shadow" @click.outside="openAddSocial=false">

                <h3 class="text-sm font-semibold mb-2">Add Social Icon</h3>

                <form action="{{ route('admin.footer.social.store') }}" method="POST">
                    @csrf

                    <label class="text-xs">Label *</label>
                    <input name="label" class="border rounded px-2 py-1 w-full mb-2 text-xs"
                        placeholder="Facebook, Twitter, etc." required>

                    <label class="text-xs">Icon Class *</label>
                    <input name="icon" class="border rounded px-2 py-1 w-full mb-2 text-xs"
                        placeholder="fa-brands fa-facebook" required>
                    <p class="text-gray-500 text-[10px] mb-2">
                        Use Font Awesome classes: fa-brands fa-facebook, fa-brands fa-twitter, etc.
                    </p>

                    <label class="text-xs">URL *</label>
                    <input name="url" class="border rounded px-2 py-1 w-full mb-2 text-xs"
                        placeholder="https://facebook.com/yourpage" required>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openAddSocial=false"
                            class="bg-gray-300 px-3 py-1 rounded text-xs hover:bg-gray-400">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Add
                            Social</button>
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
                        class="border rounded px-2 py-1 w-full mb-2 text-xs" required>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openEditColumn=false"
                            class="bg-gray-300 px-3 py-1 rounded text-xs hover:bg-gray-400">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Update</button>
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
                    <input name="label" x-model="editItem.label" class="border rounded px-2 py-1 w-full mb-2 text-xs"
                        required>

                    <label class="text-xs">URL</label>
                    <input name="url" x-model="editItem.url" class="border rounded px-2 py-1 w-full mb-2 text-xs"
                        required>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openEditLink=false"
                            class="bg-gray-300 px-3 py-1 rounded text-xs hover:bg-gray-400">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Update</button>
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
                    <input name="label" x-model="editItem.label" class="border rounded px-2 py-1 w-full mb-2 text-xs"
                        required>

                    <label class="text-xs">Icon Class</label>
                    <input name="icon" x-model="editItem.icon" class="border rounded px-2 py-1 w-full mb-2 text-xs"
                        required>

                    <label class="text-xs">URL</label>
                    <input name="url" x-model="editItem.url" class="border rounded px-2 py-1 w-full mb-2 text-xs"
                        required>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openEditSocial=false"
                            class="bg-gray-300 px-3 py-1 rounded text-xs hover:bg-gray-400">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Update</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- EDIT SETTINGS --}}
        <div x-show="openEditSettings" x-transition
            class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-5 rounded shadow" @click.outside="openEditSettings=false">

                <h3 class="text-sm font-semibold mb-3">Edit Footer Settings</h3>

                <form action="{{ route('admin.footer.settings.update') }}" method="POST">
                    @csrf

                    <label class="text-xs">Email</label>
                    <input name="email" value="{{ $settings->email }}"
                        class="border rounded px-2 py-1 w-full mb-2 text-xs">

                    <label class="text-xs">Phone</label>
                    <input name="phone" value="{{ $settings->phone }}"
                        class="border rounded px-2 py-1 w-full mb-2 text-xs">

                    <label class="text-xs">Address</label>
                    <textarea name="address" class="border rounded px-2 py-1 w-full mb-2 text-xs">{{ $settings->address }}</textarea>

                    <label class="text-xs">Copyright</label>
                    <input name="copyright_text" value="{{ $settings->copyright_text }}"
                        class="border rounded px-2 py-1 w-full mb-2 text-xs">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openEditSettings=false"
                            class="bg-gray-300 px-3 py-1 rounded text-xs hover:bg-gray-400">
                            Cancel
                        </button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Update</button>
                    </div>

                </form>

            </div>
        </div>

        {{-- BRAND ADD Modal --}}
        <div x-show="openAddBrand" x-transition class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-5 rounded shadow" @click.outside="openAddBrand=false">
                <h3 class="text-sm font-semibold mb-3">Add Branding</h3>

                <form action="{{ route('admin.footer.brand.update') }}" method="POST">
                    @csrf

                    <label class="text-xs">Title</label>
                    <input name="title" class="border rounded px-2 py-1 w-full mb-2 text-xs" required>

                    <label class="text-xs">Subtitle</label>
                    <input name="subtitle" class="border rounded px-2 py-1 w-full mb-2 text-xs">

                    <label class="text-xs">Icon SVG</label>
                    <textarea name="icon_svg" rows="3" class="border rounded px-2 py-1 w-full mb-2 text-xs"></textarea>

                    <label class="text-xs">Description</label>
                    <textarea name="description" rows="3" class="border rounded px-2 py-1 w-full mb-2 text-xs"></textarea>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openAddBrand=false"
                            class="bg-gray-300 px-3 py-1 rounded text-xs">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Add
                            Branding</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- BRAND EDIT Modal --}}
        <div x-show="openEditBrand" x-transition class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-96 p-5 rounded shadow" @click.outside="openEditBrand=false">
                <h3 class="text-sm font-semibold mb-3">Edit Branding</h3>

                <form :action="editAction" method="POST">
                    @csrf

                    <label class="text-xs">Title</label>
                    <input name="title" x-model="editItem.title" class="border rounded px-2 py-1 w-full mb-2 text-xs"
                        required>

                    <label class="text-xs">Subtitle</label>
                    <input name="subtitle" x-model="editItem.subtitle"
                        class="border rounded px-2 py-1 w-full mb-2 text-xs">

                    <label class="text-xs">Icon SVG</label>
                    <textarea name="icon_svg" x-model="editItem.icon_svg" rows="3"
                        class="border rounded px-2 py-1 w-full mb-2 text-xs"></textarea>

                    <label class="text-xs">Description</label>
                    <textarea name="description" x-model="editItem.description" rows="3"
                        class="border rounded px-2 py-1 w-full mb-2 text-xs"></textarea>

                    <label class="text-xs">Button Text</label>
                    <input name="button_text" x-model="editItem.button_text"
                        class="border rounded px-2 py-1 w-full mb-2 text-xs">

                    <label class="text-xs">Button Link</label>
                    <input name="button_link" x-model="editItem.button_link"
                        class="border rounded px-2 py-1 w-full mb-2 text-xs">

                    <label class="text-xs">Note</label>
                    <input name="note" x-model="editItem.note" class="border rounded px-2 py-1 w-full mb-4 text-xs">

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="openEditBrand=false"
                            class="bg-gray-300 px-3 py-1 rounded text-xs">Cancel</button>
                        <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Save</button>
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
                        // Only send numeric column ids to backend (exclude brand placeholder)
                        const allIds = Array.from(previewCols.querySelectorAll(
                                ".footer-column-preview, .footer-branding-preview"))
                            .map(el => el.dataset.id);

                        // Filter numeric ids for columns
                        const columnOrder = allIds.filter(id => /^\d+$/.test(id)).map(id => parseInt(id));

                        // send reorder for columns (preserves existing backend)
                        sendOrder("{{ route('admin.footer.column.reorder') }}", {
                            order: columnOrder
                        });
                    }
                });
            }

            /* SORTABLE: Links in Preview (per column) */
            document.querySelectorAll(".sortableLinksPreview").forEach(list => {
                new Sortable(list, {
                    animation: 150,
                    handle: ".drag-handle",
                    group: {
                        name: 'footer-links',
                        pull: true,
                        put: true
                    },
                    onAdd(evt) {
                        // Element moved to a new column
                        const item = evt.item;
                        const newColumnId = evt.to.dataset.columnId;
                        const linkId = item.dataset.id;

                        // Update link column in DB
                        fetch("{{ route('admin.footer.link.move') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({
                                link_id: linkId,
                                new_column_id: newColumnId
                            })
                        });
                    },
                    onEnd(evt) {
                        // Send updated order for the column
                        const columnId = evt.to.dataset.columnId;
                        const order = Array.from(evt.to.querySelectorAll(".link-item-preview"))
                            .map(el => el.dataset.id);

                        sendOrder("{{ route('admin.footer.link.reorder') }}", {
                            order,
                            column_id: columnId
                        });
                    }
                });

            });

            /* SORTABLE: Social Icons in Manager */
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

            /* SORTABLE: Social Icons in Preview */
            const previewSocialIcons = document.getElementById("previewSocialIcons");
            if (previewSocialIcons) {
                new Sortable(previewSocialIcons, {
                    animation: 150,
                    handle: ".drag-handle",
                    onEnd() {
                        const order = Array.from(previewSocialIcons.querySelectorAll(".social-icon-item"))
                            .map(el => el.dataset.id);
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
            }).then(response => {
                if (!response.ok) {
                    console.error('Reorder request failed');
                }
            }).catch(e => {
                console.error("Reorder request failed", e);
            });
        }
    </script>
@endsection
