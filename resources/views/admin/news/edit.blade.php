@extends('layouts.app')

@section('content')
    <div class="max-w-[1600px] mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Edit News Article</h2>
                <p class="text-sm text-gray-500">Updating: <span class="text-indigo-600 font-bold">{{ $news->title }}</span></p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="window.history.back()"
                    class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                    Cancel
                </button>
                <button type="submit" form="newsForm"
                    class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Update Article
                </button>
            </div>
        </div>

        {{-- Note the route change to 'update' and the @method('PUT') --}}
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" id="newsForm">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Left Column: Content Area --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Editor Card --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider">Main Story Content</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Headline *</label>
                                <input name="title" type="text" required value="{{ old('title', $news->title) }}"
                                    class="w-full text-lg font-semibold rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 placeholder:text-gray-300 py-3 transition-all outline-none">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">News Type</label>
                                    <select name="news_type" class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none py-2.5 text-sm font-medium text-gray-700">
                                        <option value="regular" {{ $news->news_type == 'regular' ? 'selected' : '' }}>Regular News</option>
                                        <option value="breaking" {{ $news->news_type == 'breaking' ? 'selected' : '' }}>Breaking News</option>
                                        <option value="exclusive" {{ $news->news_type == 'exclusive' ? 'selected' : '' }}>Exclusive</option>
                                        <option value="live" {{ $news->news_type == 'live' ? 'selected' : '' }}>Live Update</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Location</label>
                                    <input name="location" type="text" value="{{ old('location', $news->location) }}"
                                        class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none py-2.5 text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Short Summary</label>
                                <textarea name="short_description" rows="2" 
                                    class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none py-2.5 text-sm">{{ old('short_description', $news->short_description) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Detailed Article Body *</label>
                                <div class="border border-gray-200 rounded-xl overflow-hidden">
                                    <textarea id="editor" name="content">{!! old('content', $news->content) !!}</textarea>
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
                            <input name="source_name" type="text" value="{{ old('source_name', $news->source_name) }}" placeholder="Source Agency"
                                class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none py-2.5 text-sm">
                            <input name="source_url" type="url" value="{{ old('source_url', $news->source_url) }}" placeholder="Source Link"
                                class="w-full rounded-xl border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none py-2.5 text-sm">
                        </div>
                    </div>
                </div>

                {{-- Right Column: Sidebar --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- Publishing Status --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Publishing Details</label>
                        <div class="space-y-4">
                            <select name="status" class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 font-semibold text-gray-700 py-2.5">
                                <option value="published" {{ $news->status == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ $news->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="scheduled" {{ $news->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            </select>

                            <div class="pt-2">
                                <label class="text-sm font-bold text-gray-700 block mb-2">Category</label>
                                <select name="category_id" id="category_id" required class="w-full rounded-xl border border-gray-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 py-2.5 text-sm">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $news->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Thumbnail Card --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Post Thumbnail</label>
                        
                        {{-- Show current image if it exists --}}
                        <div id="image-preview" class="{{ $news->getFirstMediaUrl('thumbnail') ? '' : 'hidden' }} mb-4 relative group">
                            <img id="preview-img" src="{{ $news->getFirstMediaUrl('thumbnail') }}" class="w-full h-44 object-cover rounded-xl border border-gray-200">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition rounded-xl flex items-center justify-center">
                                <p class="text-white text-xs font-bold">Replace Image</p>
                            </div>
                        </div>
                        
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-indigo-300 transition-all">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-xs text-gray-500 font-medium text-center">Click to upload new image</p>
                            </div>
                            <input type="file" name="thumbnail" class="hidden" onchange="previewImage(event)" />
                        </label>
                    </div>

                    {{-- Video --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Video Integration</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                                </svg>
                            </span>
                            <input name="video_url" type="url" value="{{ old('video_url', $news->video_url) }}" placeholder="YouTube URL"
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
                                <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-300 mb-1">Meta Title</label>
                                <input name="meta_title" type="text" value="{{ old('meta_title', $news->meta_title) }}"
                                    class="w-full bg-indigo-800/50 border border-indigo-700 rounded-lg text-sm text-white placeholder:text-indigo-400 focus:ring-2 focus:ring-indigo-400 py-2.5 outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-300 mb-1">Meta Description</label>
                                <textarea name="meta_description" rows="3" 
                                    class="w-full bg-indigo-800/50 border border-indigo-700 rounded-lg text-sm text-white placeholder:text-indigo-400 focus:ring-2 focus:ring-indigo-400 py-2.5 outline-none">{{ old('meta_description', $news->meta_description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Switches --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-100 rounded-xl">
                            <span class="text-sm font-bold text-gray-700">Featured Post</span>
                            <input type="checkbox" name="is_featured" value="1" {{ $news->is_featured ? 'checked' : '' }}
                                class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-100 rounded-xl">
                            <span class="text-sm font-bold text-gray-700">Trending Now</span>
                            <input type="checkbox" name="is_trending" value="1" {{ $news->is_trending ? 'checked' : '' }}
                                class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300">
                        </div>
                    </div>

                </div>
            </div>
        </form>
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
    </script>
@endsection