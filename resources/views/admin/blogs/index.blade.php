@extends('layouts.app')

@section('content')
<div class="">
    
    {{-- 1. Header & Actions --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Blog Management</h2>
            <p class="text-sm text-gray-500 mt-1">Manage, filter, and monitor your published articles.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="toggleFilters()" type="button" 
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filters
            </button>

            <a href="{{ route('admin.blogs.create') }}" 
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-md transition">
                + Add New Blog
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg text-sm flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- 2. Filter Section --}}
    <div id="filterSection" class="hidden mb-8 bg-white shadow-sm rounded-xl p-6 border border-gray-200 transition-all">
        <form method="GET" action="{{ route('admin.blogs.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div>
                <label for="search" class="block text-xs font-bold text-gray-500 uppercase mb-2">Search Title</label>
                <input id="search" name="search" type="text" value="{{ request('search') }}" placeholder="e.g. 'How to...'" 
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
            </div>

            <div>
                <label for="status" class="block text-xs font-bold text-gray-500 uppercase mb-2">Status</label>
                <select id="status" name="status" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                </select>
            </div>

            <div>
                <label for="category" class="block text-xs font-bold text-gray-500 uppercase mb-2">Category</label>
                <select id="category" name="category" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2 bg-gray-900 text-white rounded-lg text-xs font-bold uppercase hover:bg-gray-800 transition">Apply</button>
                <a href="{{ route('admin.blogs.index') }}" class="flex-1 py-2 bg-gray-100 text-gray-600 text-center rounded-lg text-xs font-bold uppercase hover:bg-gray-200 transition">Reset</a>
            </div>
        </form>
    </div>

    {{-- 3. Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Total Blogs', 'value' => $totalBlogs, 'color' => 'blue', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                ['label' => 'Published', 'value' => $publishedBlogs, 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Drafts', 'value' => $draftBlogs, 'color' => 'yellow', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                ['label' => 'Featured', 'value' => $featuredBlogs, 'color' => 'purple', 'icon' => 'M11.049 2.927l1.519 4.674h4.914l-3.976 2.888 1.518 4.674-3.976-2.888-3.976 2.888 1.518-4.674L4.616 7.601h4.914z']
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex items-center">
            <div class="p-2.5 rounded-lg bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path></svg>
            </div>
            <div class="ml-3">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $stat['label'] }}</p>
                <p class="text-xl font-bold text-gray-900">{{ $stat['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- 4. Blog Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($blogs as $blog)
            <div class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                
                {{-- Card Image --}}
                <div class="relative h-52 overflow-hidden bg-gray-100">
                    @if ($blog->hasMedia('thumbnail'))
                        <img src="{{ $blog->getFirstMediaUrl('thumbnail') }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    {{-- Status Badge --}}
                    <div class="absolute top-3 right-3">
                         @php
                            $statusClasses = [
                                'published' => 'bg-green-500 text-white',
                                'draft' => 'bg-amber-500 text-white',
                                'scheduled' => 'bg-indigo-500 text-white'
                            ];
                         @endphp
                         <span class="px-2.5 py-1 {{ $statusClasses[$blog->status] ?? 'bg-gray-500' }} rounded-lg text-[10px] font-bold uppercase tracking-tight shadow-lg">
                            {{ $blog->status }}
                         </span>
                    </div>

                    {{-- Category Floating Badge --}}
                    <div class="absolute bottom-3 left-3">
                        <span class="px-2 py-1 bg-white/90 backdrop-blur-sm text-indigo-600 rounded-md text-[10px] font-bold uppercase border border-indigo-100">
                            {{ $blog->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        @if($blog->is_featured)
                            <span class="bg-purple-50 text-purple-600 px-2 py-0.5 rounded text-[10px] font-bold flex items-center border border-purple-100">
                                <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Featured
                            </span>
                        @endif
                        <span class="text-[10px] text-gray-400 font-medium">
                            {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Last updated ' . $blog->updated_at->diffForHumans() }}
                        </span>
                    </div>

                    <h3 class="font-bold text-lg text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">
                        {{ Str::limit($blog->title, 60) }}
                    </h3>

                    <p class="text-sm text-gray-500 line-clamp-2 mb-6 flex-1 leading-relaxed">
                        {{ $blog->short_description ?? Str::limit(strip_tags($blog->content), 100) }}
                    </p>

                    {{-- Card Footer --}}
                    <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
                        <div class="flex items-center gap-4 text-gray-400">
                            <div class="flex items-center text-xs">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ $blog->view_count ?? 0 }}
                            </div>
                            <div class="flex items-center text-xs">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                {{ $blog->like_count ?? 0 }}
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit Article">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Archive this article?');" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
                <div class="bg-gray-50 p-6 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">No Articles Found</h3>
                <p class="text-sm text-gray-500 mb-6 text-center max-w-xs">We couldn't find any blogs matching your current filters.</p>
                <a href="{{ route('admin.blogs.create') }}" class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transition">Create Your First Blog</a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-10">
        {{ $blogs->links() }}
    </div>

</div>

<script>
    function toggleFilters() {
        const section = document.getElementById('filterSection');
        if (section.classList.contains('hidden')) {
            section.classList.remove('hidden');
            section.classList.add('animate-fade-in-down');
        } else {
            section.classList.add('hidden');
        }
    }
</script>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fade-in-down 0.3s ease-out; }
</style>

@endsection