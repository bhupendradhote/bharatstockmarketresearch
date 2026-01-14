@extends('layouts.user')
@section('content')
       @if ($banner)
@php
    $desktopBg = $banner->getFirstMediaUrl('background');
    $mobileBg  = $banner->getFirstMediaUrl('mobile_background');
@endphp

<section class="w-full flex justify-center px-4 md:px-8 lg:px-16 mt-28">
    <div
        class="max-w-[1600px] relative w-full rounded-[24px] flex flex-col items-center text-center px-4 md:px-10 py-20 md:py-28 lg:py-32
               bg-[#F5F7FB] bg-no-repeat bg-cover bg-center"
        style="
            min-height: 400px;
            @if($desktopBg)
                background-image: url('{{ $desktopBg }}');
            @endif
        "
    >

        <!-- Overlay (optional but recommended) -->
        <div class="absolute inset-0 w-full bg-black/30 rounded-[30px]"></div>

        <div class="relative z-10">

            <!-- Badge -->
            <span data-animate
                class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-6">
                {{ $banner->title }}
            </span>

            <!-- Heading -->
            <h2 data-animate
                class="fade-up delay-200 text-[22px] md:text-[30px] lg:text-[36px] font-semibold text-white max-w-3xl leading-snug">
                {{ $banner->subtitle }}
            </h2>

            <!-- Description -->
            <p data-animate
                class="fade-up delay-300 text-white/90 text-sm md:text-base max-w-xl mt-4">
                {{ $banner->description }}
            </p>

        </div>
    </div>
</section>
@endif


    <section class="w-full px-4 md:px-8 lg:px-16 mt-20 flex justify-center">
        <div class="max-w-[1600px] w-full">
            <div class="flex justify-between items-center mb-6">
                <span class="bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm">Latest News</span>
                <a href="{{ route('news.archive') }}" class="text-[#0A0E23] underline hover:text-blue-600 transition">View
                    More</a>
            </div>

            @foreach ($latestNews as $index => $item)
                <div class="grid md:grid-cols-2 gap-10 items-start mb-16">
                    <div
                        class="rounded-2xl overflow-hidden relative h-[220px] md:h-[380px] {{ $index % 2 === 1 ? 'md:order-2' : '' }}">
                        <img src="{{ $item->getFirstMediaUrl('thumbnail') ?: 'https://via.placeholder.com/800x500' }}"
                            class="absolute inset-0 w-full h-full object-cover" />
                    </div>
                    <div class="flex flex-col justify-center {{ $index % 2 === 1 ? 'md:order-1' : '' }}">
                        <h3 class="text-[20px] md:text-[24px] font-semibold text-[#0939a4] leading-snug mb-2">
                            {{ $item->title }}</h3>
                        <p class="text-gray-600 text-sm md:text-base mb-4">{{ $item->short_description }}</p>
                        <a href="{{ route('news.show', $item->slug) }}"
                            class="text-blue-600 text-sm underline font-medium">Read more</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
