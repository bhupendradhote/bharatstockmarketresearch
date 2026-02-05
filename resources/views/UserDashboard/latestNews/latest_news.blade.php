@extends('layouts.userdashboard')

@section('content')
    {{-- 
       LOGIC PREPARATION:
       We slice the $news collection to fill the specific "Mosaic" slots in the header.
       We use $blogs for the main list feed to ensure they are displayed prominently.
    --}}
    @php
        // --- Header Mosaic Data (First 4 News Items) ---
        $feat1 = $news->get(0); // Large Left
        $feat2 = $news->get(1); // Top Right
        $feat3 = $news->get(2); // Bottom Right 1
        $feat4 = $news->get(3); // Bottom Right 2

        // --- Sidebar Data ---
        // Take news that wasn't in the header, or trending
        $sidebarNews = $news->where('is_trending', true)->take(5);
        if($sidebarNews->isEmpty()) {
            $sidebarNews = $news->skip(4)->take(5);
        }

        // --- Bottom Footer Data (Hot News) ---
        // Just grabbing random chunks for the 3-column footer look
        $hotNews1 = $news->take(3);
        $hotNews2 = $news->skip(2)->take(3);
        $hotNews3 = $news->skip(4)->take(3);
    @endphp

    <div class="font-sans text-gray-800 bg-white">
        
        {{-- =================================================================================
             PART 1: FEATURED MOSAIC (Top Section)
             Matches the "1 Big, 1 Wide, 2 Small" layout.
             ================================================================================= --}}
        <div class="max-w-7xl mx-auto mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-1 h-auto lg:h-[500px]">
                
                {{-- 1. LEFT LARGE ITEM --}}
                @if($feat1)
                <div class="relative group h-[500px] lg:h-auto overflow-hidden">
                    <a href="{{ url('/news/'.$feat1->slug) }}">
                        {{-- ROBUST IMAGE CHECK: images -> thumbnail -> default --}}
                        <img src="{{ $feat1->getFirstMediaUrl('images') ?: $feat1->getFirstMediaUrl('thumbnail') ?: $feat1->getFirstMediaUrl('default') ?: 'https://via.placeholder.com/600x800' }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6 md:p-8">
                            @if($feat1->category)
                                <span class="bg-[#efe141] text-black text-[10px] font-bold px-2 py-1 uppercase mb-3 inline-block">
                                    {{ $feat1->category->name }}
                                </span>
                            @endif
                            <h2 class="text-white text-2xl md:text-3xl font-bold uppercase leading-tight hover:underline">
                                {{ Str::limit($feat1->title, 60) }}
                            </h2>
                            <p class="text-gray-300 text-xs mt-2 uppercase font-semibold">
                                By {{ $feat1->author->name ?? 'Admin' }} - {{ $feat1->published_at->format('M d, Y') }}
                            </p>
                        </div>
                    </a>
                </div>
                @endif

                {{-- RIGHT COLUMN WRAPPER --}}
                <div class="flex flex-col gap-1 h-full">
                    
                    {{-- 2. TOP RIGHT (WIDE) --}}
                    @if($feat2)
                    <div class="relative group h-1/2 overflow-hidden">
                        <a href="{{ url('/news/'.$feat2->slug) }}">
                             {{-- ROBUST IMAGE CHECK --}}
                            <img src="{{ $feat2->getFirstMediaUrl('images') ?: $feat2->getFirstMediaUrl('thumbnail') ?: $feat2->getFirstMediaUrl('default') ?: 'https://via.placeholder.com/600x400' }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-5">
                                @if($feat2->category)
                                    <span class="bg-[#efe141] text-black text-[10px] font-bold px-2 py-1 uppercase mb-2 inline-block">
                                        {{ $feat2->category->name }}
                                    </span>
                                @endif
                                <h3 class="text-white text-lg font-bold uppercase leading-tight">
                                    {{ Str::limit($feat2->title, 50) }}
                                </h3>
                            </div>
                        </a>
                    </div>
                    @endif

                    {{-- BOTTOM RIGHT SPLIT (2 SMALL ITEMS) --}}
                    <div class="grid grid-cols-2 gap-1 h-1/2">
                        {{-- 3. Bottom Left --}}
                        @if($feat3)
                        <div class="relative group h-full overflow-hidden">
                            <a href="{{ url('/news/'.$feat3->slug) }}">
                                 {{-- ROBUST IMAGE CHECK --}}
                                <img src="{{ $feat3->getFirstMediaUrl('images') ?: $feat3->getFirstMediaUrl('thumbnail') ?: $feat3->getFirstMediaUrl('default') ?: 'https://via.placeholder.com/400x400' }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 p-4">
                                    @if($feat3->category)
                                        <span class="bg-[#efe141] text-black text-[10px] font-bold px-1.5 py-0.5 uppercase mb-2 inline-block">
                                            {{ $feat3->category->name }}
                                        </span>
                                    @endif
                                    <h4 class="text-white text-sm font-bold uppercase leading-tight">
                                        {{ Str::limit($feat3->title, 40) }}
                                    </h4>
                                </div>
                            </a>
                        </div>
                        @endif

                        {{-- 4. Bottom Right --}}
                        @if($feat4)
                        <div class="relative group h-full overflow-hidden">
                            <a href="{{ url('/news/'.$feat4->slug) }}">
                                 {{-- ROBUST IMAGE CHECK --}}
                                <img src="{{ $feat4->getFirstMediaUrl('images') ?: $feat4->getFirstMediaUrl('thumbnail') ?: $feat4->getFirstMediaUrl('default') ?: 'https://via.placeholder.com/400x400' }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-0 left-0 p-4">
                                    @if($feat4->category)
                                        <span class="bg-[#efe141] text-black text-[10px] font-bold px-1.5 py-0.5 uppercase mb-2 inline-block">
                                            {{ $feat4->category->name }}
                                        </span>
                                    @endif
                                    <h4 class="text-white text-sm font-bold uppercase leading-tight">
                                        {{ Str::limit($feat4->title, 40) }}
                                    </h4>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

 

        {{-- =================================================================================
             PART 2: MAIN CONTENT & SIDEBAR
             Left: Blog Feed (List Layout). Right: Sidebar Widgets.
             ================================================================================= --}}
        <div class="max-w-7xl mx-auto px-4 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- LEFT COLUMN: LATEST NEWS / BLOGS FEED --}}
            <div class="lg:col-span-8">
                <div class="border-b-2 border-black mb-6">
                    <h3 class="inline-block bg-black text-white text-xs font-bold uppercase px-3 py-1.5">Latest News</h3>
                </div>

                <div class="space-y-8">
                    @forelse($blogs as $blog)
                        <div class="flex flex-col md:flex-row gap-6 group">
                            {{-- Image --}}
                            <div class="w-full md:w-5/12 h-48 md:h-44 overflow-hidden relative">
                                <a href="{{ url('/blogdetails/'.$blog->slug) }}">
                                     {{-- ROBUST IMAGE CHECK --}}
                                    <img src="{{ $blog->getFirstMediaUrl('images') ?: $blog->getFirstMediaUrl('thumbnail') ?: $blog->getFirstMediaUrl('default') ?: 'https://via.placeholder.com/400x300' }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    @if($blog->category)
                                        <span class="absolute top-0 left-0 bg-[#efe141] text-black text-[10px] font-bold px-2 py-1 uppercase">
                                            {{ $blog->category->name }}
                                        </span>
                                    @endif
                                </a>
                            </div>

                            {{-- Content --}}
                            <div class="w-full md:w-7/12 flex flex-col justify-center">
                                <div class="flex items-center gap-3 text-[10px] text-gray-500 uppercase font-bold mb-2">
                                    @if($blog->category)
                                        <span class="text-[#efe141]">{{ $blog->category->name }}</span>
                                    @endif
                                    <span>{{ $blog->view_count }} views</span>
                                </div>
                                
                                <h2 class="text-xl font-bold text-gray-900 uppercase leading-tight mb-2 group-hover:text-gray-600 transition-colors">
                                    <a href="{{ url('/blog/'.$blog->slug) }}">
                                        {{ $blog->title }}
                                    </a>
                                </h2>

                                <div class="text-[10px] text-gray-400 font-bold uppercase mb-3">
                                    {{ $blog->author->name ?? 'Admin' }} - {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Just now' }}
                                </div>

                                <p class="text-sm text-gray-600 leading-relaxed line-clamp-2">
                                    {{ Str::limit(strip_tags($blog->description), 120) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p>No posts available.</p>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $blogs->appends(['news_page' => request('news_page')])->links() }}
                </div>
            </div>

            {{-- RIGHT COLUMN: SIDEBAR --}}
            <div class="lg:col-span-4 space-y-10">
                
                {{-- Widget: Latest News (Small Thumbs) --}}
                <div>
                    <div class="border-b-2 border-black mb-5">
                        <h3 class="inline-block bg-black text-white text-xs font-bold uppercase px-3 py-1.5">Trending</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($sidebarNews as $item)
                            <div class="flex gap-4 group">
                                <div class="w-20 h-16 flex-shrink-0 overflow-hidden">
                                    <a href="{{ url('/news/'.$item->slug) }}">
                                         {{-- ROBUST IMAGE CHECK --}}
                                        <img src="{{ $item->getFirstMediaUrl('images') ?: $item->getFirstMediaUrl('thumbnail') ?: $item->getFirstMediaUrl('default') ?: 'https://via.placeholder.com/150' }}" 
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </a>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold uppercase leading-snug mb-1 group-hover:text-blue-600">
                                        <a href="{{ url('/news/'.$item->slug) }}">{{ Str::limit($item->title, 50) }}</a>
                                    </h4>
                                    <span class="text-[10px] text-gray-400 uppercase font-bold">
                                        {{ $item->published_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        {{-- =================================================================================
             PART 3: FOOTER WIDGETS (HOT NEWS GRID)
             3 Columns at the bottom.
             ================================================================================= --}}
        <div class="bg-[#f2f2f2] mt-16 py-10 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    {{-- Col 1 --}}
                    <div>
                        <div class="border-b border-gray-300 mb-4 pb-1">
                            <h4 class="text-xs font-black uppercase text-gray-800">Hot News</h4>
                        </div>
                        <div class="space-y-4">
                            @foreach($hotNews1 as $hot)
                                <div class="flex gap-3 group">
                                    <div class="w-16 h-16 flex-shrink-0 overflow-hidden">
                                         {{-- ROBUST IMAGE CHECK --}}
                                        <img src="{{ $hot->getFirstMediaUrl('images') ?: $hot->getFirstMediaUrl('thumbnail') ?: $hot->getFirstMediaUrl('default') ?: 'https://via.placeholder.com/100' }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h5 class="text-[11px] font-bold leading-tight mb-1 group-hover:text-blue-600">
                                            <a href="{{ url('/news/'.$hot->slug) }}">{{ Str::limit($hot->title, 40) }}</a>
                                        </h5>
                                        <p class="text-[9px] text-gray-400">{{ $hot->published_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Col 2 --}}
                    <div>
                        <div class="border-b border-gray-300 mb-4 pb-1">
                            <h4 class="text-xs font-black uppercase text-gray-800">Hot News</h4>
                        </div>
                        <div class="space-y-4">
                            @foreach($hotNews2 as $hot)
                                <div class="flex gap-3 group">
                                    <div class="w-16 h-16 flex-shrink-0 overflow-hidden">
                                         {{-- ROBUST IMAGE CHECK --}}
                                        <img src="{{ $hot->getFirstMediaUrl('images') ?: $hot->getFirstMediaUrl('thumbnail') ?: $hot->getFirstMediaUrl('default') ?: 'https://via.placeholder.com/100' }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h5 class="text-[11px] font-bold leading-tight mb-1 group-hover:text-blue-600">
                                            <a href="{{ url('/news/'.$hot->slug) }}">{{ Str::limit($hot->title, 40) }}</a>
                                        </h5>
                                        <p class="text-[9px] text-gray-400">{{ $hot->published_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Col 3 --}}
                    <div>
                        <div class="border-b border-gray-300 mb-4 pb-1">
                            <h4 class="text-xs font-black uppercase text-gray-800">Hot News</h4>
                        </div>
                        <div class="space-y-4">
                            @foreach($hotNews3 as $hot)
                                <div class="flex gap-3 group">
                                    <div class="w-16 h-16 flex-shrink-0 overflow-hidden">
                                         {{-- ROBUST IMAGE CHECK --}}
                                        <img src="{{ $hot->getFirstMediaUrl('images') ?: $hot->getFirstMediaUrl('thumbnail') ?: $hot->getFirstMediaUrl('default') ?: 'https://via.placeholder.com/100' }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h5 class="text-[11px] font-bold leading-tight mb-1 group-hover:text-blue-600">
                                            <a href="{{ url('/news/'.$hot->slug) }}">{{ Str::limit($hot->title, 40) }}</a>
                                        </h5>
                                        <p class="text-[9px] text-gray-400">{{ $hot->published_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection