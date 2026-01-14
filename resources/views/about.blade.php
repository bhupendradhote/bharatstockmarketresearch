@extends('layouts.user')

@section('content')
    <!-- PAGE WRAPPER -->
    <!-- ABOUT HERO SECTION -->
  @if ($banner)
@php
    $badge = $banner->badge ?? 'About Us';
    $subtitle = $banner->subtitle
        ?? 'A research platform built around responsibility and trust.';
    $description = $banner->description
        ?? 'We help retail investors understand the market better through clear, research-based stock insights.';

    $desktopBg = $banner->getFirstMediaUrl('background');
    $mobileBg  = $banner->getFirstMediaUrl('mobile_background');
@endphp

<section class="w-full flex justify-center px-4 md:px-8 lg:px-16 mt-24">
    <div
        class="relative hero-banner max-w-[1600px] w-full rounded-[30px]
        py-40 px-6 md:px-10 text-center
        bg-[#F5F7FB] bg-no-repeat bg-cover bg-center"
        style="
            @if($desktopBg)
                background-image: url('{{ $desktopBg }}');
            @endif
        "
    >

        <!-- Overlay (only when image exists) -->
        @if($desktopBg || $mobileBg)
            <div class="absolute inset-0 bg-black/30 rounded-[30px]"></div>
        @endif

        <div class="relative z-10">

            <!-- Badge -->
            <span
                class="inline-block bg-[#0939a4] text-white px-6 py-2
                rounded-full text-sm md:text-base mb-8">
                {{ $badge }}
            </span>

            <!-- Heading -->
            <h2
                class="text-2xl md:text-3xl my-[2.2rem] lg:text-4xl font-semibold
                leading-snug mb-10
                {{ ($desktopBg || $mobileBg) ? 'text-white' : 'text-[#0939a4]' }}">
                {{ $subtitle }}
            </h2>

            <!-- Description -->
            <p
                class="text-sm md:text-base max-w-2xl mx-auto leading-relaxed
                {{ ($desktopBg || $mobileBg) ? 'text-white/90' : 'text-gray-700' }}">
                {{ $description }}
            </p>

        </div>
    </div>
</section>

{{-- Mobile background image --}}
<style>
@media (max-width: 768px) {
    .hero-banner {
        background-image: url('{{ $mobileBg ?: $desktopBg }}') !important;
    }
}
</style>
@endif



    <!-- MISSION & VALUES SECTION -->
    @if ($mission)
        <section class="w-full flex justify-center px-4 md:px-8 lg:px-16 mt-24">
            <div class="max-w-[1200px] w-full text-center">

                @if ($mission->title)
                    <span data-animate
                        class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base">
                        {{ $mission->title }}
                    </span>
                @endif

                @if ($mission->mission_text)
                    <h2 data-animate
                        class="fade-up delay-200 text-[16px] md:text-[16px] lg:text-[16px]
                   leading-relaxed text-[#7a7e90] font-medium max-w-2xl text-justify  mx-auto mt-10">
                        {{ $mission->mission_text }}
                    </h2>
                @endif

            </div>
        </section>
    @endif




    <!-- CORE VALUES SECTION -->
    @if ($coreSection && $coreSection->values->count())
        <section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center">
            <div class="max-w-[1500px] w-full grid md:grid-cols-2 gap-12 items-start">

                <!-- LEFT TEXT -->
                <div class="text-left">
                    @if ($coreSection->title)
                        <span data-animate
                            class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-4">
                            {{ $coreSection->title }}
                        </span>
                    @endif

                    <h2 data-animate
                        class="fade-up delay-200 text-[22px] md:text-[24px] lg:text-[26px]
                       font-semibold text-[#0939a4] leading-relaxed max-w-sm">
                        {!! nl2br(e($coreSection->description)) !!}
                    </h2>
                </div>

                <!-- RIGHT GRID -->
                <div class="grid sm:grid-cols-2 gap-6">
                    @foreach ($coreSection->values as $i => $value)
                        <div data-animate
                            class="fade-up delay-{{ 200 + $i * 100 }}
                           bg-[#F5F7FB] p-6 rounded-2xl shadow-sm min-h-[180px]
                           flex flex-col gap-3">

                            <div
                                class="w-10 h-10 rounded-full bg-[#0939a4] text-white
                                flex items-center justify-center">
                                {!! $value->icon ?? '✓' !!}
                            </div>

                            <h3 class="font-semibold text-[#0A0E23]">
                                {{ $value->title }}
                            </h3>

                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ $value->description }}
                            </p>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif


    <!-- WHY WE BUILT THIS PLATFORM -->
    @if ($whyPlatforms->count())
        @foreach ($whyPlatforms as $index => $whyPlatform)
            <section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center">
                <div class="max-w-[1500px] w-full">

                    {{-- BADGE --}}
                    @if ($whyPlatform->subheading)
                        <span data-animate
                            class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-6">
                            {{ $whyPlatform->subheading }}
                        </span>
                    @endif

                    {{-- HEADING --}}
                    <h2 data-animate
                        class="fade-up delay-200 text-[20px] md:text-[26px] lg:text-[28px]
                            font-medium text-[#0939a4] leading-relaxed max-w-4xl mb-10">
                        {{ $whyPlatform->heading }}
                    </h2>

                    {{-- TWO COLUMN LAYOUT (ALTERNATING) --}}
                    <div
                        class="flex flex-col md:flex-row gap-10 items-start
                        {{ $index % 2 === 1 ? 'md:flex-row-reverse' : '' }}">

                        {{-- IMAGE --}}
                        <div data-animate class="fade-up delay-200 md:w-1/2">
                            @if ($whyPlatform->getFirstMediaUrl('why_platform_image'))
                                <img src="{{ $whyPlatform->getFirstMediaUrl('why_platform_image') }}"
                                    class="rounded-2xl w-full object-cover h-[260px] md:h-[350px] shadow-md">
                            @endif
                        </div>

                        {{-- CONTENT --}}
                        <div data-animate class="fade-up delay-300 md:w-1/2">
                            @foreach ($whyPlatform->contents as $content)
                                <div
                                    class="
                                        mb-6
                                        text-[15px] md:text-[16px]
                                        text-[#0A0E23]
                                        leading-relaxed
                                        prose max-w-none
                                        [&_ul]:list-disc
                                        [&_ul]:pl-5
                                        [&_ul]:mb-5
                                        [&_li]:mb-1
                                        [&_li:has(br)]:hidden
                                        [&_p]:mb-4
                                        [&_h3]:text-[18px]
                                        [&_h3]:font-semibold
                                        [&_h3]:mt-6
                                        [&_h3]:mb-2
                                    ">
                                    {!! $content->content !!}
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </section>
        @endforeach
    @endif





    <!-- GET THE APP SECTION -->
    @if ($downloadApp)
        <!-- GET THE APP SECTION -->
        <section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center py-10">
            <div class="max-w-[900px] w-full text-center">

                <!-- Badge -->
                @if ($downloadApp->title)
                    <span data-animate
                        class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-6">
                        {{ $downloadApp->title }}
                    </span>
                @endif

                <!-- Heading -->
                @if ($downloadApp->heading)
                    <h2 data-animate
                        class="fade-up delay-200 text-[20px] md:text-[26px] lg:text-[28px] font-semibold text-gray-600 mt-4">
                        {!! nl2br(e($downloadApp->heading)) !!}
                    </h2>
                @endif

                <!-- Description -->
                @if ($downloadApp->description)
                    <p data-animate class="fade-up delay-300 text-gray-400 text-xs md:text-sm mt-3 mb-8">
                        {{ $downloadApp->description }}
                    </p>
                @endif

                <!-- Store Buttons (Static for now) -->
                <div data-animate class="fade-up delay-400 flex justify-center gap-4 flex-wrap mt-4">

                    <!-- Google Play -->
                    <a href="#" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                            alt="Get it on Google Play" class="w-[140px] md:w-[160px] cursor-pointer">
                    </a>

                    <!-- App Store -->
                    <a href="#" target="_blank">
                        <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                            alt="Download on the App Store" class="w-[140px] md:w-[160px] cursor-pointer">
                    </a>

                </div>

            </div>
        </section>
    @endif

@endsection
