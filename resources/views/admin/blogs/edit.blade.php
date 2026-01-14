@extends('layouts.app')

@section('content')
<div class="">
    {{-- Top Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-indigo-600 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                <span class="text-xs font-bold uppercase tracking-wider">Editor Mode</span>
            </div>
            <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Edit Blog</h2>
            <p class="text-sm text-gray-500 mt-1">Updating: <span class="font-medium text-gray-700">{{ $blog->title }}</span></p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" onclick="window.history.back()"
                class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition">
                Cancel
            </button>
            <a href="{{ route('admin.blogs.show', $blog->id) }}" target="_blank"
                class="px-4 py-2 bg-blue-50 border border-blue-200 rounded-lg text-sm font-semibold text-blue-700 shadow-sm hover:bg-blue-100 transition flex items-center gap-2">
                <span>View Live</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
            </a>
            <button type="submit" form="blogForm" id="submitBtnTop"
                class="px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition">
                Update Blog
            </button>
        </div>
    </div>

    <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="blogForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Main Content Column --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Main Content</h3>
                    </div>
                    
                    <div class="p-6 space-y-5">
                        {{-- Title --}}
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Blog Title <span class="text-red-400">*</span></label>
                            <input id="title" name="title" type="text" value="{{ old('title', $blog->title) }}" required
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 shadow-sm">
                        </div>

                        {{-- Slug --}}
                        <div>
                            <label for="slug" class="block text-sm font-semibold text-gray-700 mb-1">URL Slug</label>
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-xs">/blog/</span>
                                    <input id="slug" name="slug" type="text" value="{{ old('slug', $blog->slug) }}" required readonly
                                        class="w-full pl-14 rounded-lg border-gray-300 bg-gray-50 text-gray-500 text-sm shadow-sm">
                                </div>
                                <button type="button" onclick="generateSlug()" class="px-3 py-2 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 uppercase tracking-tighter transition">
                                    Regenerate
                                </button>
                            </div>
                        </div>

                        {{-- Excerpt --}}
                        <div>
                            <label for="short_description" class="flex justify-between text-sm font-semibold text-gray-700 mb-1">
                                <span>Short Description</span>
                                <span class="text-xs font-normal text-gray-400"><span id="charCount">0</span>/160</span>
                            </label>
                            <textarea id="short_description" name="short_description" rows="2" maxlength="160"
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm">{{ old('short_description', $blog->short_description) }}</textarea>
                        </div>

                        {{-- Editor --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Article Body <span class="text-red-400">*</span></label>
                            <textarea id="content" name="content" class="hidden">{{ old('content', $blog->content) }}</textarea>
                            <textarea id="editor" name="editor">{{ old('content', $blog->content) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SEO Card --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Search Engine Optimization</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="meta_title" class="flex justify-between text-xs font-semibold text-gray-600 mb-1">
                                    <span>Meta Title</span>
                                    <span id="metaTitleCount" class="font-normal text-gray-400">0/60</span>
                                </label>
                                <input id="meta_title" name="meta_title" type="text" value="{{ old('meta_title', $blog->meta_title) }}" maxlength="60"
                                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="meta_keywords" class="text-xs font-semibold text-gray-600 mb-1 block">Keywords</label>
                                <input id="meta_keywords" name="meta_keywords" type="text" value="{{ old('meta_keywords', is_array($blog->meta_keywords) ? implode(',', $blog->meta_keywords) : $blog->meta_keywords) }}"
                                    class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:ring-indigo-500">
                            </div>
                        </div>
                        <div>
                            <label for="meta_description" class="flex justify-between text-xs font-semibold text-gray-600 mb-1">
                                <span>Meta Description</span>
                                <span id="metaDescCount" class="font-normal text-gray-400">0/160</span>
                            </label>
                            <textarea id="meta_description" name="meta_description" rows="2" maxlength="160"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:ring-indigo-500">{{ old('meta_description', $blog->meta_description) }}</textarea>
                        </div>
                        <div>
                            <label for="canonical_url" class="block text-xs font-semibold text-gray-600 mb-1">Canonical URL</label>
                            <input id="canonical_url" name="canonical_url" type="url" value="{{ old('canonical_url', $blog->canonical_url) }}"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Column --}}
            <div class="space-y-6">
                {{-- Publishing --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Publishing Settings</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                            <select id="status" name="status" class="w-full rounded-lg border-gray-300 text-sm shadow-sm">
                                <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="scheduled" {{ old('status', $blog->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            </select>
                        </div>

                        <div id="scheduledField" class="{{ old('status', $blog->status) == 'scheduled' ? '' : 'hidden' }}">
                            <label for="scheduled_for" class="block text-sm font-semibold text-gray-700 mb-1 text-xs">Schedule For</label>
                            <input id="scheduled_for" name="scheduled_for" type="datetime-local" value="{{ old('scheduled_for', $blog->scheduled_for ? \Carbon\Carbon::parse($blog->scheduled_for)->format('Y-m-d\TH:i') : '') }}"
                                class="w-full rounded-lg border-gray-300 text-xs shadow-sm">
                        </div>

                        <div>
                            <label for="published_at" class="block text-sm font-semibold text-gray-700 mb-1 text-xs">Publication Date</label>
                            <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('Y-m-d\TH:i') : '') }}"
                                class="w-full rounded-lg border-gray-300 text-xs shadow-sm">
                        </div>

                        <div class="flex items-center gap-2 py-2">
                            <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 shadow-sm">
                            <label for="is_featured" class="text-sm text-gray-700 font-medium">Feature this post</label>
                        </div>

                        <button type="submit" id="submitBtnMain"
                            class="w-full py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-bold shadow-md hover:bg-indigo-700 transition">
                            Save Changes
                        </button>
                    </div>
                </div>

                {{-- Image --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Featured Image</h3>
                    <div class="space-y-4">
                        {{-- Current Image --}}
                        @if($blog->hasMedia('thumbnail'))
                            <div id="currentThumbnail" class="relative group">
                                <img src="{{ $blog->getFirstMediaUrl('thumbnail') }}" class="w-full h-32 object-cover rounded-lg border border-gray-200 shadow-sm">
                                <div class="absolute inset-0 bg-gray-900/40 opacity-0 group-hover:opacity-100 transition rounded-lg flex items-center justify-center">
                                    <span class="text-white text-[10px] font-bold uppercase">Current Image</span>
                                </div>
                            </div>
                        @endif

                        {{-- Preview for new upload --}}
                        <div id="thumbnailPreview" class="hidden relative">
                            <img id="previewImage" class="w-full h-32 object-cover rounded-lg border border-indigo-200 shadow-sm">
                            <span class="absolute top-2 left-2 bg-indigo-600 text-white text-[8px] px-1.5 py-0.5 rounded font-bold uppercase">New</span>
                        </div>

                        <input id="thumbnail" name="thumbnail" type="file" accept="image/*" onchange="showThumbnailPreview(event)"
                            class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                    </div>
                </div>

                {{-- Category --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Category</h3>
                    <div class="flex gap-2">
                        <select id="category_id" name="category_id" required class="flex-1 rounded-lg border-gray-300 text-sm shadow-sm">
                            <option value="">Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $blog->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="openCategoryModal()" class="px-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-600 font-bold hover:bg-gray-100">+</button>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Metrics</h3>
                    <div class="space-y-3">
                        <div>
                            <label for="reading_time" class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Reading Time (Mins)</label>
                            <input id="reading_time" name="reading_time" type="number" value="{{ old('reading_time', $blog->reading_time) }}"
                                class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm shadow-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Category Modal (Kept Simple) --}}
<div id="categoryModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-sm w-full p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">New Category</h3>
        <form id="categoryForm" class="space-y-4">
            @csrf
            <input id="categoryName" name="name" type="text" class="w-full rounded-lg border-gray-300 shadow-sm" placeholder="Category Name" required />
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 text-sm font-semibold text-gray-500">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold">Create</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', { height: 400, removePlugins: 'elementspath', resize_enabled: false });

    CKEDITOR.instances.editor.on('change', function() {
        document.getElementById('content').value = this.getData();
        updateReadingTime();
    });

    function generateSlug() {
        const title = document.getElementById('title').value;
        if (title) {
            const slug = title.toLowerCase().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '');
            document.getElementById('slug').value = slug;
        }
    }

    document.getElementById('status').addEventListener('change', function() {
        document.getElementById('scheduledField').classList.toggle('hidden', this.value !== 'scheduled');
    });

    function updateCount(inputId, countId) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(countId);
        if(input && counter) counter.innerText = input.value.length;
    }

    ['short_description', 'meta_title', 'meta_description'].forEach(id => {
        const input = document.getElementById(id);
        const countId = id === 'short_description' ? 'charCount' : id === 'meta_title' ? 'metaTitleCount' : 'metaDescCount';
        input.addEventListener('input', () => updateCount(id, countId));
        updateCount(id, countId);
    });

    function showThumbnailPreview(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('thumbnailPreview').classList.remove('hidden');
                const current = document.getElementById('currentThumbnail');
                if(current) current.classList.add('opacity-40');
            };
            reader.readAsDataURL(file);
        }
    }

    function updateReadingTime() {
        const content = CKEDITOR.instances.editor.getData().replace(/<[^>]*>/g, ' ');
        const words = content.trim().split(/\s+/).length;
        document.getElementById('reading_time').value = Math.ceil(words / 200) || 1;
    }

    function openCategoryModal() { document.getElementById('categoryModal').classList.remove('hidden'); }
    function closeCategoryModal() { document.getElementById('categoryModal').classList.add('hidden'); }

    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        fetch("{{ route('blogs.category.store') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" },
            body: JSON.stringify({ name: document.getElementById('categoryName').value })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('category_id');
                select.add(new Option(data.category.name, data.category.id, true, true));
                closeCategoryModal();
            }
        });
    });
</script>
@endsection