@extends('layouts.user')
@section('content')
    <section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
        <div class="max-w-[900px] w-full">
            <div class="mb-6">
                <span class="inline-block px-4 py-1 rounded-full text-xs text-white font-bold mb-4"
                    style="background-color: {{ $news->category->color_code }}">
                    {{ $news->category->name }}
                </span>
                <h1 class="text-[28px] md:text-[34px] font-semibold leading-tight text-[#0939a4]">{{ $news->title }}</h1>
                <p class="text-gray-500 text-sm mt-2">Published on {{ $news->published_at->format('F d, Y') }}</p>
            </div>

            <div class="rounded-2xl overflow-hidden mb-8 shadow-lg">
                <img src="{{ $news->getFirstMediaUrl('thumbnail') ?: 'https://via.placeholder.com/900x450' }}"
                    class="w-full object-cover" />
            </div>

            <div class="prose prose-blue max-w-none text-[#0A0E23] leading-relaxed">
                {!! $news->content !!}
            </div>

            @if ($news->source_url)
                <div class="mt-10 p-6 bg-gray-50 rounded-xl border-l-4 border-indigo-500">
                    <p class="text-sm font-bold text-gray-700">Source: <a href="{{ $news->source_url }}" target="_blank"
                            class="text-indigo-600 underline">{{ $news->source_name ?? 'Original Article' }}</a></p>
                </div>
            @endif
        </div>
    </section>
@endsection
