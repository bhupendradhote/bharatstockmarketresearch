@extends('layouts.user')
@section('content')
    <!-- NEWS & BLOG HERO SECTION -->
    <!-- NEWS & BLOG HERO SECTION -->
    @if ($banner)
        <section class="w-full flex justify-center px-4 md:px-8 lg:px-16 mt-28">
            <div class="max-w-[1600px] w-full bg-[#F5F7FB] rounded-[30px] flex flex-col items-center text-center px-4 md:px-10 py-20 md:py-28 lg:py-32"
                style="min-height: 400px;">

                <!-- Badge -->
                <span data-animate
                    class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-6">
                    {{ $banner->title }}
                </span>

                <!-- Heading -->
                <h2 data-animate
                    class="fade-up delay-200 text-[22px] md:text-[30px] lg:text-[36px] font-semibold text-[#0939a4] max-w-3xl leading-snug">
                    {{ $banner->subtitle }}
                </h2>

                <!-- Subtext -->
                <p data-animate class="fade-up delay-300 text-gray-600 text-sm md:text-base max-w-xl mt-4">
                    {{ $banner->description }}
                </p>

            </div>
        </section>
    @endif

    <!-- LATEST BLOGS SECTION -->
    @if (isset($latestBlogs) && $latestBlogs->count())
        <section class="w-full px-4 md:px-8 lg:px-16 mt-20 flex justify-center">
            <div class="max-w-[1600px] w-full">

                <!-- Top Row -->
                <div class="flex justify-between items-center mb-6">
                    <span data-animate
                        class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base">
                        Latest Blogs
                    </span>

                    <a href="{{ url('news') }}" data-animate
                        class="fade-up delay-200 text-sm md:text-base font-medium text-[#0A0E23] underline hover:text-blue-600 transition">
                        View News
                    </a>
                </div>

                <!-- Heading -->
                <h2 data-animate
                    class="fade-up delay-200 text-[22px] md:text-[28px] lg:text-[32px] font-semibold text-[#0939a4] mb-10">
                    Latest Market Updates
                </h2>

                @foreach ($latestBlogs as $index => $blog)
                    <!-- BLOG ROW -->
                    <div class="grid md:grid-cols-2 gap-10 items-start {{ $index === 0 ? 'mb-16' : '' }}">

                        {{-- IMAGE --}}
                        <div data-animate
                            class="fade-up delay-300 rounded-2xl overflow-hidden relative
        h-[220px] md:h-[320px] lg:h-[380px]
        {{ $index % 2 === 1 ? 'md:order-2' : '' }}">

                            <img src="{{ $blog->getFirstMediaUrl('thumbnail') ?: 'https://via.placeholder.com/800x500' }}"
                                alt="{{ $blog->title }}" class="absolute inset-0 w-full h-full object-cover" />
                        </div>


                        {{-- CONTENT --}}
                        <div
                            class="flex flex-col justify-center
                    {{ $index % 2 === 1 ? 'md:order-1' : '' }}">

                            <h3 data-animate
                                class="fade-up delay-300 text-[20px] md:text-[24px] font-semibold text-[#0939a4] leading-snug mb-2">
                                {{ $blog->title }}
                            </h3>

                            <p data-animate class="fade-up delay-400 text-gray-600 text-sm md:text-base mb-4">
                                {{ $blog->short_description }}
                            </p>

                            <a href="{{ route('blogdetails', $blog->slug) }}" data-animate
                                class="fade-up delay-500 text-blue-600 text-sm md:text-base underline font-medium hover:text-blue-700">
                                Read more
                            </a>
                        </div>

                    </div>
                @endforeach

            </div>
        </section>
    @endif





    <!-- BLOGS SECTION -->
    {{-- <section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center py-10">
        <div class="max-w-[1600px] w-full">

            <!-- Top Row: Badge & View More -->
            <div class="flex justify-between items-center mb-6">
                <span x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base">
                    Blogs
                </span>

                <a href="{{ route('moreblogs') }}" x-data="{ visible: false }" x-intersect.half="visible = true"
                    :class="{ 'animated': visible }"
                    class="fade-up delay-200 text-sm md:text-base font-medium text-[#0A0E23] underline hover:text-blue-600 transition">
                    View More Blogs
                </a>
            </div>

            <!-- Heading -->
            <h2 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                class="fade-up delay-200 text-[22px] md:text-[28px] lg:text-[32px] font-semibold text-[#0939a4] mb-10">
                Learn More About the Market
            </h2>

            <!-- BLOG GRID -->
            <div class="grid md:grid-cols-3 gap-10">

                <!-- BLOG CARD 1 -->
                <a href="{{ route('blogdetails') }}" x-data="{ visible: false }" x-intersect.half="visible = true"
                    :class="{ 'animated': visible }" class="fade-up delay-200 flex flex-col">
                    <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="rounded-2xl overflow-hidden fade-up delay-300">
                        <img src="https://cdn.pixabay.com/photo/2025/10/12/07/32/italy-9889149_1280.jpg" alt="Blog Image"
                            class="w-full h-[220px] object-cover" />
                    </div>

                    <h3 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-400 mt-4 text-[16px] md:text-[18px] font-semibold text-[#0A0E23] leading-snug">
                        5 Key Metrics Every Investor Should Know Before Picking a Stock
                    </h3>

                    <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-500 text-gray-600 text-sm mt-1">
                        September 22, 2025
                    </p>
                </a>
                <a href="{{ route('blogdetails') }}" x-data="{ visible: false }" x-intersect.half="visible = true"
                    :class="{ 'animated': visible }" class="fade-up delay-200 flex flex-col">
                    <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="rounded-2xl overflow-hidden fade-up delay-300">
                        <img src="https://cdn.pixabay.com/photo/2025/10/12/07/32/italy-9889149_1280.jpg" alt="Blog Image"
                            class="w-full h-[220px] object-cover" />
                    </div>

                    <h3 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-400 mt-4 text-[16px] md:text-[18px] font-semibold text-[#0A0E23] leading-snug">
                        5 Key Metrics Every Investor Should Know Before Picking a Stock
                    </h3>

                    <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-500 text-gray-600 text-sm mt-1">
                        September 22, 2025
                    </p>
                </a>
                <a href="/blogDetails.html" x-data="{ visible: false }" x-intersect.half="visible = true"
                    :class="{ 'animated': visible }" class="fade-up delay-200 flex flex-col">
                    <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="rounded-2xl overflow-hidden fade-up delay-300">
                        <img src="https://cdn.pixabay.com/photo/2025/10/12/07/32/italy-9889149_1280.jpg" alt="Blog Image"
                            class="w-full h-[220px] object-cover" />
                    </div>

                    <h3 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-400 mt-4 text-[16px] md:text-[18px] font-semibold text-[#0A0E23] leading-snug">
                        5 Key Metrics Every Investor Should Know Before Picking a Stock
                    </h3>

                    <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-500 text-gray-600 text-sm mt-1">
                        September 22, 2025
                    </p>
                </a>

                <!-- BLOG CARD 2 -->
                <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="fade-up delay-200 flex flex-col">
                    <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="rounded-2xl overflow-hidden fade-up delay-300">
                        <img src="https://cdn.pixabay.com/photo/2025/10/12/07/32/italy-9889149_1280.jpg" alt="Blog Image"
                            class="w-full h-[220px] object-cover" />
                    </div>

                    <h3 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-400 mt-4 text-[16px] md:text-[18px] font-semibold text-[#0A0E23] leading-snug">
                        Why Market Research Matters More Than Luck in Investing
                    </h3>

                    <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-500 text-gray-600 text-sm mt-1">
                        September 22, 2025
                    </p>
                </div>

                <!-- BLOG CARD 3 -->
                <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="fade-up delay-200 flex flex-col">
                    <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="rounded-2xl overflow-hidden fade-up delay-300">
                        <img src="https://cdn.pixabay.com/photo/2025/10/12/07/32/italy-9889149_1280.jpg" alt="Blog Image"
                            class="w-full h-[220px] object-cover" />
                    </div>

                    <h3 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-400 mt-4 text-[16px] md:text-[18px] font-semibold text-[#0A0E23] leading-snug">
                        Beginner's Guide: How to Read a Company's Financial Health
                    </h3>

                    <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-500 text-gray-600 text-sm mt-1">
                        September 22, 2025
                    </p>
                </div>

            </div>

        </div>
    </section> --}}

    <section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center py-10">
        <div class="max-w-[1600px] w-full">

            <!-- Top Row: Badge & View More -->
            <div class="flex justify-between items-center mb-6">
                <span x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base">
                    Blogs
                </span>

                <a href="{{ route('moreblogs') }}" x-data="{ visible: false }" x-intersect.half="visible = true"
                    :class="{ 'animated': visible }"
                    class="fade-up delay-200 text-sm md:text-base font-medium text-[#0A0E23] underline hover:text-blue-600 transition">
                    View More Blogs
                </a>
            </div>

            <!-- Heading -->
            <h2 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                class="fade-up delay-200 text-[22px] md:text-[28px] lg:text-[32px] font-semibold text-[#0939a4] mb-10">
                Learn More About the Market
            </h2>

            <!-- BLOG GRID (DYNAMIC) -->
            <div class="grid md:grid-cols-3 gap-10">

                @if (isset($latest3Blogs) && $latest3Blogs->count())
                    @foreach ($latest3Blogs as $blog)
                        <a href="{{ route('blogdetails', $blog->slug) }}" x-data="{ visible: false }"
                            x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up delay-200 flex flex-col">

                            <!-- IMAGE (same size & UI) -->
                            <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                                class="rounded-2xl overflow-hidden fade-up delay-300">

                                <img src="{{ $blog->getFirstMediaUrl('thumbnail') ?: 'https://via.placeholder.com/600x400' }}"
                                    alt="{{ $blog->title }}" class="w-full h-[220px] object-cover" />
                            </div>

                            <!-- TITLE -->
                            <h3 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                                class="fade-up delay-400 mt-4 text-[16px] md:text-[18px] font-semibold text-[#0939a4] leading-snug">
                                {{ $blog->title }}
                            </h3>

                            <!-- DATE -->
                            <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                                class="fade-up delay-500 text-gray-600 text-sm mt-1">
                                {{ optional($blog->published_at)->format('F d, Y') }}
                            </p>

                        </a>
                    @endforeach
                @endif

            </div>

        </div>
    </section>


    <!-- FAQ SECTION -->
    @if (isset($faqs) && $faqs->count())
        <section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
            <div class="max-w-[1500px] w-full grid md:grid-cols-2 gap-16">

                <!-- LEFT -->
                <div class="space-y-8">
                    <span x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                        class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base">
                        FAQ
                    </span>

                    <h2 x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                        class="fade-up delay-200 text-[28px] md:text-[34px] font-semibold text-[#0939a4] leading-snug max-w-sm">
                        Common questions from our users
                    </h2>
                </div>

                <!-- RIGHT (Accordion) -->
                <div class="space-y-8">
                    @foreach ($faqs as $index => $faq)
                        <div x-data="{ open: false, show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                            class="fade-up delay-{{ 100 + $index * 50 }} border-b pb-4">
                            <div class="max-w-xl">

                                <!-- QUESTION -->
                                <button @click="open = !open" type="button"
                                    class="w-full flex justify-between items-center text-left py-2">
                                    <span class="text-[16px] text-[#0A0E23] font-medium">
                                        {{ $faq->question }}
                                    </span>

                                    <span class="transition-transform duration-300 text-xl"
                                        :class="{ 'rotate-180': open }">
                                        ▾
                                    </span>
                                </button>

                                <!-- ANSWER -->
                                <div x-show="open" x-collapse x-cloak class="text-gray-600 pt-3 pb-2 leading-relaxed">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif



@endsection
