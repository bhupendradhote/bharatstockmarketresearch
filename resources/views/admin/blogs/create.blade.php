@extends('layouts.app')

@section('content')
<div class="">
    {{-- Top Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="font-bold text-2xl text-gray-900 tracking-tight leading-tight">
                Create New Blog
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Craft a new article with content, SEO and a featured image in one place.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" onclick="window.history.back()"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                Cancel
            </button>
            <button type="submit" form="blogForm" id="submitBtnTop"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                Save Blog
            </button>
        </div>
    </div>

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT COLUMN: Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Main Content</h3>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100 font-bold uppercase">Required</span>
                    </div>

                    <div class="p-6 space-y-5">
                        {{-- Title --}}
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">
                                Blog Title <span class="text-red-500">*</span>
                            </label>
                            <input id="title" name="title" type="text"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 shadow-sm @error('title') border-red-500 @enderror"
                                value="{{ old('title') }}" required autofocus
                                placeholder="E.g. How AI can automate your business processes" />
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            <label for="slug" class="block text-sm font-semibold text-gray-700 mb-1">URL Slug</label>
                            <div class="flex items-center gap-2">
                                <div class="relative flex-1">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-xs pointer-events-none">
                                        /blog/
                                    </span>
                                    <input id="slug" name="slug" type="text"
                                        class="block w-full pl-14 rounded-lg border-gray-300 bg-gray-50 text-gray-500 text-sm shadow-sm"
                                        value="{{ old('slug') }}" required readonly />
                                </div>
                                <button type="button" onclick="generateSlug()"
                                    class="px-3 py-2 bg-white border border-gray-300 rounded-lg font-bold text-xs text-gray-600 uppercase tracking-tighter hover:bg-gray-50 transition">
                                    Regenerate
                                </button>
                            </div>
                        </div>

                        {{-- Excerpt --}}
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="short_description" class="text-sm font-semibold text-gray-700">Short Description (Excerpt)</label>
                                <span class="text-xs text-gray-400 font-normal"><span id="charCount">0</span>/160</span>
                            </div>
                            <textarea id="short_description" name="short_description" rows="2"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm"
                                maxlength="160" placeholder="A brief summary for listing cards.">{{ old('short_description') }}</textarea>
                        </div>

                        {{-- Editor --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Content <span class="text-red-500">*</span></label>
                            <textarea id="content" name="content" class="hidden">{{ old('content') }}</textarea>
                            <textarea id="editor" name="editor">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SEO Preview Tip --}}
                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 flex gap-3">
                    <div class="text-amber-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-amber-900 uppercase tracking-tight">SEO Strategy</p>
                        <p class="text-xs text-amber-800 mt-0.5">The title and meta description below roughly match how this blog will appear in Google results. Keep them clear and relevant.</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Sidebar --}}
            <div class="space-y-6">

                {{-- Card: Publishing --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Publishing</h3>
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-gray-400 uppercase">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Draft
                        </span>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                            <select id="status" name="status" class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            </select>
                        </div>

                        <div id="scheduledField" class="hidden">
                            <label for="scheduled_for" class="block text-sm font-semibold text-gray-700 mb-1">Schedule Date</label>
                            <input id="scheduled_for" name="scheduled_for" type="datetime-local"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm" />
                        </div>

                        <div class="flex items-center py-1">
                            <input id="is_featured" name="is_featured" type="checkbox" value="1"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                {{ old('is_featured') ? 'checked' : '' }}>
                            <label for="is_featured" class="ml-2 block text-sm font-medium text-gray-700">Mark as featured post</label>
                        </div>

                        <div class="pt-2">
                            <button type="submit" id="submitBtnMain"
                                class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-bold text-sm text-white shadow-md hover:bg-indigo-700 transition">
                                Save Blog
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Card: Category --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Category</h3>
                    <div class="flex gap-2">
                        <select id="category_id" name="category_id" required
                            class="flex-1 rounded-lg border-gray-300 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Choose Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="openCategoryModal()"
                            class="px-3 bg-indigo-50 border border-indigo-100 rounded-lg text-indigo-600 font-bold hover:bg-indigo-100 transition">
                            +
                        </button>
                    </div>
                </div>

                {{-- Card: Featured Image --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Featured Image</h3>
                    <div class="space-y-3">
                        <div id="thumbnailPreview" class="hidden">
                            <img id="previewImage" class="w-full h-40 object-cover rounded-lg border border-gray-200 shadow-sm">
                        </div>
                        <input id="thumbnail" name="thumbnail" type="file" accept="image/*" onchange="showThumbnailPreview(event)"
                            class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer" />
                        <p class="text-[10px] text-gray-400 text-center uppercase tracking-tighter font-semibold">Recommended: 1200x630px</p>
                    </div>
                </div>

                {{-- Card: SEO Details --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">SEO Details</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="flex justify-between text-xs font-bold text-gray-600 mb-1">
                                <span>Meta Title</span>
                                <span id="metaTitleCount" class="font-normal text-gray-400">0/60</span>
                            </label>
                            <input id="meta_title" name="meta_title" type="text" value="{{ old('meta_title') }}" maxlength="60"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="flex justify-between text-xs font-bold text-gray-600 mb-1">
                                <span>Meta Description</span>
                                <span id="metaDescCount" class="font-normal text-gray-400">0/160</span>
                            </label>
                            <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500">{{ old('meta_description') }}</textarea>
                        </div>
                        <div>
                            <label for="reading_time" class="block text-xs font-bold text-gray-600 mb-1">Reading Time (mins)</label>
                            <input id="reading_time" name="reading_time" type="number"
                                class="w-full rounded-lg border-gray-300 text-sm bg-gray-50" placeholder="Auto-calculated" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

{{-- Category Modal --}}
<div id="categoryModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-900 uppercase">New Category</h3>
            <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form id="categoryForm" class="p-6 space-y-4">
            @csrf
            <div>
                <label for="categoryName" class="block text-xs font-bold text-gray-700 uppercase mb-1">Category Name</label>
                <input id="categoryName" name="name" type="text"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required />
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50 rounded-lg transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 transition">Create</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
    // CKEditor Setup
    CKEDITOR.replace('editor', {
        height: 400,
        removePlugins: 'elementspath',
        resize_enabled: false,
        toolbarGroups: [
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
            { name: 'styles',      groups: [ 'styles' ] },
            { name: 'insert',      groups: [ 'links', 'images' ] },
        ]
    });

    CKEDITOR.instances.editor.on('change', function () {
        document.getElementById('content').value = this.getData();
        updateReadingTime();
    });

    // Slug Generator
    function generateSlug() {
        const title = document.getElementById('title').value;
        if (title) {
            const slug = title.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            document.getElementById('slug').value = slug;
        }
    }

    // Auto-fill and SEO Logic
    document.getElementById('title').addEventListener('blur', function () {
        if (!document.getElementById('slug').value) generateSlug();
        if (this.value) {
            if (!document.getElementById('meta_title').value) {
                document.getElementById('meta_title').value = this.value.substring(0, 60);
                updateCharCount('meta_title', 'metaTitleCount');
            }
        }
    });

    // Toggle Schedule
    document.getElementById('status').addEventListener('change', function () {
        document.getElementById('scheduledField').classList.toggle('hidden', this.value !== 'scheduled');
    });

    // Character Counters
    function updateCharCount(inputId, countId) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(countId);
        if (input && counter) {
            counter.innerText = input.value.length;
        }
    }

    ['short_description', 'meta_title', 'meta_description'].forEach(id => {
        const input = document.getElementById(id);
        const countId = id === 'short_description' ? 'charCount' : id === 'meta_title' ? 'metaTitleCount' : 'metaDescCount';
        input.addEventListener('input', () => updateCharCount(id, countId));
        updateCharCount(id, countId); // Initial count
    });

    // Image Preview
    function showThumbnailPreview(event) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('thumbnailPreview').classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Reading Time
    function updateReadingTime() {
        const content = CKEDITOR.instances.editor.getData().replace(/<[^>]*>/g, ' ');
        const words = content.trim().split(/\s+/).length;
        document.getElementById('reading_time').value = Math.ceil(words / 200) || 1;
    }

    // Category Modal Logic
    function openCategoryModal() { document.getElementById('categoryModal').classList.remove('hidden'); }
    function closeCategoryModal() { document.getElementById('categoryModal').classList.add('hidden'); }

    // AJAX Category Post
    document.getElementById('categoryForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const name = document.getElementById('categoryName').value;
        const token = document.querySelector('input[name="_token"]').value;

        fetch("{{ route('blogs.category.store') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": token, "Accept": "application/json" },
            body: JSON.stringify({ name: name })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('category_id');
                const option = new Option(data.category.name, data.category.id, true, true);
                select.add(option);
                closeCategoryModal();
            }
        });
    });

    // Form Submit Loading State
    document.getElementById('blogForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtnMain');
        const topBtn = document.getElementById('submitBtnTop');
        [btn, topBtn].forEach(b => {
            b.disabled = true;
            b.classList.add('opacity-50', 'cursor-not-allowed');
            b.innerText = 'Saving...';
        });
    });
</script>
@endsection