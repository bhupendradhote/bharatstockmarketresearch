@extends('layouts.app')

@section('content')
<div class="">
    
    {{-- 1. Header & Actions --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="font-bold text-2xl text-gray-900 tracking-tight">News Management</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your headlines, breaking news, and categories.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="toggleFilters()" type="button" 
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filters
            </button>
            <a href="{{ route('admin.news.categories') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg font-bold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                Categories
            </a>
            <a href="{{ route('admin.news.create') }}" 
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-md transition">
                + Create News
            </a>
        </div>
    </div>

    {{-- 2. Filter Section (Dynamic) --}}
    <div id="filterSection" class="hidden mb-8 bg-white shadow-sm rounded-xl p-6 border border-gray-200 transition-all">
        <form method="GET" action="{{ route('admin.news.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Search Headlines</label>
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Search news..." 
                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Category</label>
                <select name="category" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">News Type</label>
                <select name="type" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                    <option value="">All Types</option>
                    <option value="standard">Standard</option>
                    <option value="breaking">Breaking News</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2 bg-gray-900 text-white rounded-lg text-xs font-bold uppercase hover:bg-gray-800 transition">Apply</button>
                <a href="{{ route('admin.news.index') }}" class="flex-1 py-2 bg-gray-100 text-gray-600 text-center rounded-lg text-xs font-bold uppercase hover:bg-gray-200 transition">Reset</a>
            </div>
        </form>
    </div>

    {{-- 3. Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @php
            $statConfig = [
                ['label' => 'Total News', 'value' => $stats['total'], 'color' => 'blue', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
                ['label' => 'Published', 'value' => $stats['published'], 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Breaking', 'value' => $stats['breaking'], 'color' => 'red', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                ['label' => 'Featured', 'value' => $stats['featured'], 'color' => 'purple', 'icon' => 'M11.049 2.927l1.519 4.674h4.914l-3.976 2.888 1.518 4.674-3.976-2.888-3.976 2.888 1.518-4.674L4.616 7.601h4.914z']
            ];
        @endphp

        @foreach($statConfig as $st)
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex items-center">
            <div class="p-2.5 rounded-lg bg-{{ $st['color'] }}-50 text-{{ $st['color'] }}-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $st['icon'] }}"></path></svg>
            </div>
            <div class="ml-3">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $st['label'] }}</p>
                <p class="text-xl font-bold text-gray-900">{{ $st['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- 4. News Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($newsItems as $news)
            <div class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                
                {{-- Image & Badges --}}
                <div class="relative h-48 overflow-hidden bg-gray-100">
                    <img src="{{ $news->getFirstMediaUrl('thumbnail') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    {{-- Floating Type Badge --}}
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-1 {{ $news->news_type == 'breaking' ? 'bg-red-600' : 'bg-gray-900' }} text-white rounded-lg text-[10px] font-bold uppercase tracking-tight shadow-lg">
                            {{ $news->news_type }}
                        </span>
                    </div>

                    {{-- Category Badge --}}
                    <div class="absolute bottom-3 left-3">
                        <span class="px-2 py-1 bg-white/90 backdrop-blur-sm text-indigo-600 rounded-md text-[10px] font-bold uppercase border border-indigo-100">
                            {{ $news->category->name }}
                        </span>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        @if($news->is_featured)
                            <span class="bg-purple-50 text-purple-600 px-2 py-0.5 rounded text-[10px] font-bold flex items-center border border-purple-100">
                                <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Featured
                            </span>
                        @endif
                        <span class="text-[10px] text-gray-400 font-medium">
                            {{ $news->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    <h3 class="font-bold text-lg text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors line-clamp-2">
                        {{ $news->title }}
                    </h3>

                    <p class="text-sm text-gray-500 line-clamp-2 mb-6 flex-1">
                        {{ $news->short_description }}
                    </p>

                    {{-- Footer Actions --}}
                    <div class="pt-4 border-t border-gray-100 flex justify-end items-center gap-2">
                        <a href="{{ route('admin.news.edit', $news->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Delete news article?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 bg-white rounded-3xl border border-dashed border-gray-300 text-center">
                <p class="text-gray-500">No news articles found.</p>
            </div>
        @endforelse
    </div>

    {{-- 5. Pagination --}}
    <div class="mt-10">
        {{ $newsItems->links() }}
    </div>
</div>

<script>
    function toggleFilters() {
        const section = document.getElementById('filterSection');
        section.classList.toggle('hidden');
        section.classList.add('animate-fade-in-down');
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