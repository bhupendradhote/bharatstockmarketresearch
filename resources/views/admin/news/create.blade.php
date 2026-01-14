@extends('layouts.app')

@section('content')
    <div class="max-w-[1600px] mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Create News Article</h2>
                <p class="text-sm text-gray-500">Draft your story, optimize for search, and publish to the world.</p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="window.history.back()"
                    class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                    Discard
                </button>
                <button type="submit" form="newsForm"
                    class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Save & Publish News
                </button>
            </div>
        </div>

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" id="newsForm">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Left Column: Content Area (8 Cols) --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Editor Card --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider">Main Story Content</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Headline *</label>
                                <input name="title" type="text" required placeholder="Write a catchy headline..."
                                    class="w-full text-lg font-semibold rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 placeholder:text-gray-300 py-3 transition-all outline-none">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">News Type</label>
                                    <select name="news_type"
                                        class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none py-2.5 text-sm font-medium text-gray-700">
                                        <option value="regular">Regular News</option>
                                        <option value="breaking">Breaking News</option>
                                        <option value="exclusive">Exclusive</option>
                                        <option value="live">Live Update</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Location</label>
                                    <input name="location" type="text" placeholder="e.g. New York, USA"
                                        class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none py-2.5 text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Short Summary</label>
                                <textarea name="short_description" rows="2" placeholder="Brief intro for social media and cards..."
                                    class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none py-2.5 text-sm"></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Detailed Article Body *</label>
                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                     <textarea id="editor" name="content"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Source Info Card --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 text-sm uppercase tracking-wider">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.803a4 4 0 015.656 0l4 4a4 4 0 01-5.656 5.656l-1.103-1.103" />
                            </svg>
                            Attribution & Source
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <input name="source_name" type="text" placeholder="Source Agency (e.g. Reuters)"
                                class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none py-2.5 text-sm">
                            <input name="source_url" type="url" placeholder="Source Link (https://...)"
                                class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none py-2.5 text-sm">
                        </div>
                    </div>
                </div>

                {{-- Right Column: Sidebar (4 Cols) --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- Publishing Status --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Publishing Details</label>
                        <div class="space-y-4">
                            <select name="status" class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-semibold text-gray-700 py-2.5">
                                <option value="published">Publish Now</option>
                                <option value="draft">Save as Draft</option>
                                <option value="scheduled">Schedule Post</option>
                            </select>

                            <div class="pt-2">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-bold text-gray-700">Category</label>
                                    <button type="button" onclick="openCategoryModal()"
                                        class="text-indigo-600 text-xs font-bold hover:bg-indigo-50 px-2 py-1 rounded-lg transition">+ New</button>
                                </div>
                                <select name="category_id" id="category_id" required
                                    class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 py-2.5 text-sm">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Featured Image Card --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Post Thumbnail</label>
                        <div id="image-preview" class="hidden mb-4 relative group">
                            <img id="preview-img" src="#" class="w-full h-44 object-cover rounded-xl border border-gray-200">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition rounded-xl flex items-center justify-center">
                                <p class="text-white text-xs font-bold">Change Image</p>
                            </div>
                        </div>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-indigo-300 transition-all">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-xs text-gray-500 font-medium">Click to upload image</p>
                            </div>
                            <input type="file" name="thumbnail" class="hidden" onchange="previewImage(event)" />
                        </label>
                    </div>

                    {{-- Video Section --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Video Integration</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                                </svg>
                            </span>
                            <input name="video_url" type="url" placeholder="YouTube or Vimeo URL"
                                class="w-full pl-10 rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all py-2.5 text-sm">
                        </div>
                    </div>

                    {{-- SEO Optimization --}}
                    <div class="bg-indigo-900 rounded-2xl shadow-lg p-6 text-white border border-indigo-800">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="p-1.5 bg-indigo-500/30 rounded-lg text-indigo-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-sm uppercase tracking-wider">SEO Optimization</h3>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-300 mb-1">Focus Meta Title</label>
                                <input name="meta_title" type="text"
                                    class="w-full bg-indigo-800/50 border border-indigo-700 rounded-lg text-sm text-white placeholder:text-indigo-400 focus:ring-2 focus:ring-indigo-400 py-2.5 outline-none"
                                    placeholder="SEO Title...">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-300 mb-1">Meta Description</label>
                                <textarea name="meta_description" rows="3"
                                    class="w-full bg-indigo-800/50 border border-indigo-700 rounded-lg text-sm text-white placeholder:text-indigo-400 focus:ring-2 focus:ring-indigo-400 py-2.5 outline-none"
                                    placeholder="Write meta description..."></textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-300 mb-1">Canonical URL</label>
                                <input name="canonical_url" type="url"
                                    class="w-full bg-indigo-800/50 border border-indigo-700 rounded-lg text-sm text-white placeholder:text-indigo-400 focus:ring-2 focus:ring-indigo-400 py-2.5 outline-none"
                                    placeholder="https://...">
                            </div>
                        </div>
                    </div>

                    {{-- Featured & Trending Switches --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-100 rounded-xl">
                            <span class="text-sm font-bold text-gray-700">Featured Post</span>
                            <input type="checkbox" name="is_featured" value="1"
                                class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-100 rounded-xl">
                            <span class="text-sm font-bold text-gray-700">Trending Now</span>
                            <input type="checkbox" name="is_trending" value="1"
                                class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    {{-- Instant Category Modal --}}
    <div id="categoryModal"
        class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100">
            <h3 class="text-xl font-black text-gray-900 mb-2">New Category</h3>
            <p class="text-sm text-gray-500 mb-6">Create a news segment instantly.</p>
            <form id="categoryForm" class="space-y-4">
                @csrf
                <input type="text" id="categoryName" placeholder="e.g. Technology"
                    class="w-full rounded-2xl border border-gray-200 py-3 px-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeCategoryModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-bold rounded-2xl hover:bg-gray-200 transition">Cancel</button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor', {
            height: 500,
            removeButtons: 'About'
        });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview-img');
                output.src = reader.result;
                document.getElementById('image-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        // AJAX Category Post
        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('categoryName').value;
            fetch("{{ route('admin.news.categories.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        name: name
                    })
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