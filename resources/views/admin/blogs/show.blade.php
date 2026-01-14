@extends('layouts.app')

@section('content')
    <div class="py-5">
        <div class="">
            
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Blog Details
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Viewing blog: <span class="font-medium text-gray-900">{{ $blog->title }}</span>
                    </p>
                </div>
                
                <div class="flex gap-3">
                    <a href="{{ route('admin.blogs.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                        Back to List
                    </a>
                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        Edit Blog
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- LEFT COLUMN: Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- 1. Title & Excerpt Card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <div class="mb-6">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $blog->title }}</h1>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <span class="bg-gray-100 px-2 py-1 rounded text-xs font-mono">/{{ $blog->slug }}</span>
                            </div>
                        </div>

                        @if($blog->short_description)
                            <div class="p-4 bg-gray-50 rounded-md border border-gray-200">
                                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Excerpt</h4>
                                <p class="text-gray-700 text-sm leading-relaxed">
                                    {{ $blog->short_description }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- 2. Content Body --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="font-bold text-gray-900 border-b pb-4 mb-4">Content Body</h3>
                        
                        <div class="prose max-w-none text-gray-800">
                            {!! $blog->content !!}
                        </div>
                    </div>

                    {{-- 3. Table of Contents (Optional) --}}
                    @if($blog->table_of_contents)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="font-bold text-gray-900 border-b pb-4 mb-4">Table of Contents</h3>
                        <div class="bg-gray-50 p-4 rounded-md text-sm font-mono text-gray-700 whitespace-pre-wrap">
@if(is_array($blog->table_of_contents))
{{ implode("\n", $blog->table_of_contents) }}
@else
{{ $blog->table_of_contents }}
@endif
                        </div>
                    </div>
                    @endif

                </div>

                {{-- RIGHT COLUMN: Sidebar Metadata --}}
                <div class="space-y-6">

                    {{-- 1. Status & Visibility --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wide border-b pb-2 mb-4">Status</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Current Status</span>
                                @if($blog->status === 'published')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Published</span>
                                @elseif($blog->status === 'draft')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Draft</span>
                                @else
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Scheduled</span>
                                @endif
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Visibility</span>
                                @if($blog->is_featured)
                                    <span class="text-xs font-bold text-purple-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        Featured
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">Standard</span>
                                @endif
                            </div>

                            <div class="pt-3 border-t border-gray-100 space-y-2">
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase">Published Date</span>
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $blog->published_at ? $blog->published_at->format('M d, Y h:i A') : 'Not Set' }}
                                    </span>
                                </div>
                                @if($blog->scheduled_for)
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase">Scheduled For</span>
                                    <span class="text-sm font-medium text-blue-600">
                                        {{ $blog->scheduled_for->format('M d, Y h:i A') }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- 2. Category & Stats --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wide border-b pb-2 mb-4">Details</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <span class="block text-xs text-gray-400 uppercase">Category</span>
                                <span class="inline-block mt-1 px-2 py-1 bg-gray-100 rounded text-sm font-medium text-gray-800">
                                    {{ $blog->category->name ?? 'Uncategorized' }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 pt-2">
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase">Reading Time</span>
                                    <span class="text-sm font-medium">{{ $blog->reading_time ?? 0 }} mins</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase">Views</span>
                                    <span class="text-sm font-medium">{{ $blog->view_count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Featured Image --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wide border-b pb-2 mb-4">Featured Image</h3>
                        
                        @if($blog->hasMedia('thumbnail'))
                            <div class="rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ $blog->getFirstMediaUrl('thumbnail') }}" alt="Thumbnail" class="w-full h-auto object-cover">
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-8 text-center border border-gray-200 border-dashed">
                                <span class="text-gray-400 text-sm">No image uploaded</span>
                            </div>
                        @endif
                    </div>

                    {{-- 4. SEO Metadata --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wide border-b pb-2 mb-4">SEO & Meta</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="block text-xs text-gray-400 uppercase">Meta Title</span>
                                <p class="text-sm text-gray-700 mt-1 break-words">
                                    {{ $blog->meta_title ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <span class="block text-xs text-gray-400 uppercase">Meta Description</span>
                                <p class="text-sm text-gray-700 mt-1 break-words">
                                    {{ $blog->meta_description ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <span class="block text-xs text-gray-400 uppercase">Keywords</span>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @if($blog->meta_keywords)
                                        @foreach(is_array($blog->meta_keywords) ? $blog->meta_keywords : explode(',', $blog->meta_keywords) as $keyword)
                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded border border-gray-200">
                                                {{ trim($keyword) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-sm text-gray-400">None</span>
                                    @endif
                                </div>
                            </div>

                            @if($blog->canonical_url)
                            <div>
                                <span class="block text-xs text-gray-400 uppercase">Canonical URL</span>
                                <a href="{{ $blog->canonical_url }}" target="_blank" class="text-xs text-indigo-600 hover:underline break-all block mt-1">
                                    {{ $blog->canonical_url }}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection