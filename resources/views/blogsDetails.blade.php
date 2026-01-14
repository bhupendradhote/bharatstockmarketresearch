@extends('layouts.user')
@section('content')
    {{-- static --}}

    <!-- BLOG DETAILS SECTION -->
    {{-- <section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
        <div class="max-w-[900px] w-full">

            <!-- Title & Author -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-[22px] md:text-[28px] font-semibold leading-snug text-[#0A0E23]">
                        5 Key Metrics Every Investor Should<br />
                        Know Before Picking a Stock
                    </h1>
                </div>

                <div class="flex items-center gap-3">
                    <img src="https://cdn.pixabay.com/photo/2025/10/12/07/32/italy-9889149_1280.jpg"
                        class="w-10 h-10 rounded-full object-cover" />

                    <div class="text-sm">
                        <p class="font-semibold text-[#0A0E23]">Sarah Lime</p>
                        <p class="text-gray-500 text-xs">September 22, 2025</p>
                    </div>
                </div>
            </div>

            <!-- HERO IMAGE -->
            <div class="rounded-xl overflow-hidden mb-8">
                <img src="https://cdn.pixabay.com/photo/2025/10/12/07/32/italy-9889149_1280.jpg"
                    class="w-full h-[300px] md:h-[380px] object-cover" />
            </div>

            <!-- CONTENT SECTION -->
            <div class="space-y-8 text-[#0A0E23]">

                <!-- Section 1 -->
                <div>
                    <h2 class="text-xl font-semibold mb-3">Understanding the Numbers</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Knowing what to measure is essential when you're growing a product. Metrics like churn,
                        lifetime value, and customer acquisition cost offer powerful insights into the health of
                        your business. Without these numbers, decisions are just guesses.
                    </p>
                </div>

                <!-- Section 2 -->
                <div>
                    <h2 class="text-xl font-semibold mb-3">The Metrics That Matter</h2>
                    <p class="text-gray-600 leading-relaxed">
                        While there are many metrics to choose from, not all carry equal weight. Prioritize user
                        engagement, conversion rates, and feature usage to truly understand how your product
                        delivers value. These indicators guide you toward meaningful action.
                    </p>
                </div>

                <!-- Section 3 -->
                <div>
                    <h2 class="text-xl font-semibold mb-3">Applying the Insights</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Tracking metrics is only half the equation—what you do with them matters more. Use your
                        data to validate ideas, improve user experiences, and spot areas of opportunity. Regular
                        reviews lead to smarter decisions and more focused growth.
                    </p>
                </div>

            </div>

        </div>
    </section> --}}






    <!-- BLOG DETAILS SECTION -->
    <section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
        <div class="max-w-[900px] w-full">

            <!-- Title & Author -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-[22px] md:text-[28px] font-semibold leading-snug text-[#0939a4]">
                        {{ $blog->title }}
                    </h1>
                </div>

                <div class="flex items-center gap-3">
                    {{-- <img src="{{ $blog->getFirstMediaUrl('profile_images') ?: 'https://via.placeholder.com/100' }}"
                        class="w-10 h-10 rounded-full object-cover" /> --}}

                    <div class="text-sm">
                        {{-- <p class="font-semibold text-[#0A0E23]">
                            {{ $blog->author_name ?? 'Admin' }}
                        </p> --}}
                        <p class="text-gray-500 text-xs">
                            {{ optional($blog->published_at)->format('F d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- HERO IMAGE -->
            <div class="rounded-xl overflow-hidden mb-8">
                <img src="{{ $blog->getFirstMediaUrl('thumbnail') ?: 'https://via.placeholder.com/900x400' }}"
                    class="w-full h-[300px] md:h-[380px] object-cover" />
            </div>

            <!-- CONTENT SECTION -->
            <div class="space-y-8 text-[#0A0E23]">

                {!! $blog->content !!}

            </div>

        </div>
    </section>
@endsection
