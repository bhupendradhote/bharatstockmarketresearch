@extends('layouts.user')
@section('content')
    <!--<div class="min-h-screen flex justify-center items-start py-16">-->


    <div class="py-16">



        <!-- SERVICE SECTION -->
        {{-- <section class="w-full px-4 md:px-8 lg:px-8 flex justify-center mt-10">
                <div
                    class="max-w-[1500px] w-full bg-[#F5F7FB] xl:h-[600px] rounded-[30px] p-10 md:px-20 md:py-24 flex flex-col justify-center items-center">

                    <!-- Badge -->
                    <span data-animate
                        class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-6">
                        Our Service
                    </span>

                    <!-- Title -->
                    <h2 data-animate class="fade-up delay-200 text-2xl md:text-4xl font-semibold text-[#0A0E23] mb-6">
                        Plans that support your market journey
                    </h2>

                    <!-- Subtitle -->
                    <p data-animate
                        class="fade-up delay-300 text-gray-600 max-w-2xl mx-auto text-sm md:text-lg leading-relaxed">
                        Select a plan that suits your investing style and get real-time recommendations, alerts,
                        and full access to the dashboard.
                    </p>

                </div>
            </section> --}}
        @php
            // Fallback content
            $badge = $banner->badge ?? 'Our Service';
            $title = $banner->title ?? 'Plans that support your market journey';
            $subtitle =
                $banner->subtitle ?? 'Select a plan that suits your investing style and get real-time recommendations.';
            $description = $banner->description ?? null;

            // Banner images (Spatie)
            $desktopBg = $banner?->getFirstMediaUrl('background');
            $mobileBg = $banner?->getFirstMediaUrl('mobile_background');
        @endphp

        <section class="w-full px-4 md:px-8 lg:px-16 flex justify-center mt-10">
            <div class="relative hero-banner has-overlay max-w-[1500px] w-full xl:h-[600px] rounded-[30px]
        p-10 md:px-20 md:py-24 flex flex-col justify-center items-center
        bg-[#F5F7FB] bg-no-repeat bg-cover bg-center"
                style="
            @if ($desktopBg) background-image: url('{{ $desktopBg }}'); @endif
        ">

                <!-- Overlay (only if image exists) -->
                @if ($desktopBg || $mobileBg)
                    <div class="absolute inset-0 bg-black/30 rounded-[30px]"></div>
                @endif

                <div class="relative z-10 text-center">

                    <!-- Badge -->
                    @if ($badge)
                        <span data-animate
                            class="fade-up delay-100 inline-block bg-[#0939a4] text-white
                    px-6 py-2 rounded-full text-sm md:text-base mb-6">
                            {{ $badge }}
                        </span>
                    @endif

                    <!-- Subtitle (Main Heading) -->
                    @if ($subtitle)
                        <p data-animate
                            class="fade-up delay-200 text-2xl md:text-4xl font-semibold
                    {{ $desktopBg || $mobileBg ? 'text-white' : 'text-[#0939a4]' }} mb-6">
                            {{ $subtitle }}
                        </p>
                    @endif

                    <!-- Description -->
                    @if ($description)
                        <p data-animate
                            class="fade-up delay-300 max-w-2xl mx-auto text-sm md:text-lg leading-relaxed
                    {{ $desktopBg || $mobileBg ? 'text-white/90' : 'text-gray-600' }}">
                            {{ $description }}
                        </p>
                    @endif

                </div>
            </div>
        </section>

        {{-- Mobile background --}}
        <style>
            @media (max-width: 768px) {
                .hero-banner {
                    background-image: url('{{ $mobileBg ?: $desktopBg }}') !important;
                }
            }
        </style>


        <!-- PLAN SECTION -->


        <section class="bg-[#f7f9fc] py-20">
            <div class="max-w-[1400px] text-center mx-auto px-4">

                <!-- HEADING -->
                <span class="inline-block bg-[#0939a4] text-white px-4 py-1 rounded-full text-sm mb-4">
                    Our Plans
                </span>

                <h2 class="text-3xl md:text-4xl font-bold text-[#0939a4] mb-12">
                    Plans designed for every type of investor
                </h2>

                <!-- PLANS GRID -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                    @foreach ($plans as $plan)
                        @php
                            $isKycCompleted =
                                auth()->check() &&
                                auth()->user()->kycVerification &&
                                auth()->user()->kycVerification->status === 'approved';
                        @endphp

                        @if ($plan->durations->count())
                            <div x-data="{
                                activeIndex: 0,
                                durations: @js(
    $plan->durations->map(
        fn($d) => [
            'duration' => $d->duration,
            'price' => $d->price,
            'features' => $d->features->map(
                fn($f) => [
                    'text' => $f->text,
                    'icon' => $f->svg_icon ?? '✔', // Aapke table ka 'svg_icon' column
                ],
            ),
        ],
    ),
)
                            }"
                                class="bg-[#e9edff] rounded-[28px] p-8 shadow-sm flex flex-col justify-between">

                                <!-- PLAN NAME -->
                                <h3 class="text-xl text-left font-semibold text-[#0939a4] mb-2">
                                    {{ $plan->name }}
                                </h3>

                                <!-- PRICE -->
                                <div class="mb-4 text-left">
                                    <span class="text-2xl font-bold text-blue-800">
                                        ₹<span x-text="durations[activeIndex]?.price.toLocaleString()"></span>
                                    </span>
                                    <span class="text-sm text-gray-600">(inclusive of GST)</span>

                                    <p class="text-xs text-gray-500 mt-1">
                                        Monthly Subscription based
                                    </p>
                                </div>

                                <!-- DURATION BUTTONS -->
                                <div class="flex flex-wrap gap-2 mb-6">
                                    <template x-for="(d, index) in durations" :key="index">
                                        <button @click="activeIndex = index"
                                            class="text-xs px-4 py-2 rounded-full transition font-medium"
                                            :class="activeIndex === index ?
                                                'bg-[#0939a4] text-white' :
                                                'bg-white text-gray-700 border'">
                                            <span x-text="d.duration"></span>
                                        </button>
                                    </template>
                                </div>

                                <!-- FEATURES -->

                                <div class="mb-8 flex-grow">
                                    <h4 class="font-semibold mb-3 text-[#0939a4] text-left">Features</h4>
                                    <ul class="space-y-3 text-gray-700 text-sm">
                                        <template x-for="(feature, i) in durations[activeIndex].features"
                                            :key="i">
                                            <li class="flex justify-between items-start gap-4">
                                                <span class="text-left" x-text="feature.text"></span>

                                                <span class="font-bold flex-shrink-0"
                                                    :class="{
                                                        'text-red-500': feature.icon === '✖',
                                                        'text-green-600': feature.icon === '✔',
                                                        'text-blue-600': feature.icon !== '✖' && feature
                                                            .icon !== '✔'
                                                    }"
                                                    x-text="feature.icon">
                                                </span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>

                                <!-- CTA -->
                                <a x-bind:href="{{ $isKycCompleted ? 'true' : 'false' }}
                                    ?
                                    '{{ route('subscription.confirm') }}?plan={{ $plan->id }}&duration=' + activeIndex
                                : '{{ route('user.settings.profile') }} '"
                                    class="block mt-auto">
                                    <button type="button"
                                        class="w-full bg-[#0939a4] hover:bg-blue-800 text-white
                                       py-3 rounded-xl text-sm font-semibold transition
                                       {{ !$isKycCompleted ? 'opacity-70 cursor-not-allowed' : '' }}">
                                        {{ $plan->button_text ?? 'Subscribe Now' }}
                                    </button>
                                </a>

                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </section>



        {{-- <!-- PLAN SECTION -->
            <section class="w-full px-4 md:px-8 lg:px-16 mt-20 flex justify-center">
                <div class="max-w-[1500px] w-full grid md:grid-cols-2 gap-14">

                    <!-- LEFT SIDE CONTENT -->
                    <div class="flex flex-col justify-between items-start">

                        <div>


                            <!-- Plan Badge -->
                            <span data-animate
                                class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-4">
                                Plan 2
                            </span>

                            <!-- Title -->
                            <h2 data-animate
                                class="fade-up delay-200 text-3xl md:text-[32px] font-semibold text-[#0A0E23] mb-1">
                                Intraday Plan
                            </h2>

                            <!-- Subtitle -->
                            <p data-animate class="fade-up delay-300 text-gray-600 mb-8">
                                Best for active traders
                            </p>

                            <!-- Duration Buttons -->
                            <div class="flex items-center gap-4 mb-8">

                                <button data-animate
                                    class="fade-up delay-200 bg-[#0939a4] text-white px-5 py-2 rounded-full text-sm shadow-sm">
                                    3 Months
                                </button>

                                <button data-animate
                                    class="fade-up delay-300 border border-gray-400 px-5 py-2 rounded-full text-sm">
                                    6 Months
                                </button>

                                <button data-animate
                                    class="fade-up delay-400 border border-gray-400 px-5 py-2 rounded-full text-sm">
                                    1 Year
                                </button>
                            </div>

                            <!-- Price -->
                            <h3 data-animate class="fade-up delay-300 text-2xl font-semibold text-[#0A0E23]">
                                ₹5000 <span class="text-lg font-medium text-gray-700">(inclusive of GST)</span>
                            </h3>
                            <p data-animate class="fade-up delay-400 text-gray-600 mb-10">
                                Monthly Subscription based
                            </p>
                        </div>

                        <!-- Subscribe Button -->
                        <button data-animate
                            class="fade-up delay-500 mt-4 px-8 py-3 text-sm font-medium rounded-full border border-gray-400 flex items-center gap-2 hover:bg-gray-100 transition">
                            Subscribe Now
                            <span class="text-lg">→</span>
                        </button>

                    </div>

                    <!-- RIGHT SIDE FEATURES GRID -->
                    <div class="grid grid-cols-2 gap-6">

                        <!-- Feature Box 1 -->
                        <div data-animate
                            class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col gap-4 shadow-sm 
                            w-40 h-40          
                            md:w-48 md:h-44   
                            lg:w-58 lg:h-48   
                            xl:w-72 xl:h-56">
                            <div
                                class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                                ✔
                            </div>

                            <p class="text-gray-800">Intraday recommendations</p>
                        </div>

                        <div data-animate
                            class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col gap-4 shadow-sm 
                            w-40 h-40          
                            md:w-48 md:h-44   
                            lg:w-58 lg:h-48   
                            xl:w-72 xl:h-56">
                            <div
                                class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                                ✔
                            </div>

                            <p class="text-gray-800">Intraday recommendations</p>
                        </div>



                        <div data-animate
                            class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col gap-4 shadow-sm 
                            w-40 h-40          
                            md:w-48 md:h-44   
                            lg:w-58 lg:h-48   
                            xl:w-72 xl:h-56">
                            <div
                                class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                                ✔
                            </div>

                            <p class="text-gray-800">Intraday recommendations</p>
                        </div>

                    </div>

                </div>
            </section>
            <!-- PLAN SECTION -->
            <section class="w-full px-4 md:px-8 lg:px-16 mt-20 flex justify-center">
                <div class="max-w-[1500px] w-full grid md:grid-cols-2 gap-14">

                    <!-- LEFT SIDE CONTENT -->
                    <div class="flex flex-col justify-between items-start">

                        <div>


                            <!-- Plan Badge -->
                            <span data-animate
                                class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-4">
                                Plan 3
                            </span>

                            <!-- Title -->
                            <h2 data-animate
                                class="fade-up delay-200 text-3xl md:text-[32px] font-semibold text-[#0A0E23] mb-1">
                                Intraday Plan
                            </h2>

                            <!-- Subtitle -->
                            <p data-animate class="fade-up delay-300 text-gray-600 mb-8">
                                Best for active traders
                            </p>

                            <!-- Duration Buttons -->
                            <div class="flex items-center gap-4 mb-8">

                                <button data-animate
                                    class="fade-up delay-200 bg-[#0939a4] text-white px-5 py-2 rounded-full text-sm shadow-sm">
                                    3 Months
                                </button>

                                <button data-animate
                                    class="fade-up delay-300 border border-gray-400 px-5 py-2 rounded-full text-sm">
                                    6 Months
                                </button>

                                <button data-animate
                                    class="fade-up delay-400 border border-gray-400 px-5 py-2 rounded-full text-sm">
                                    1 Year
                                </button>
                            </div>

                            <!-- Price -->
                            <h3 data-animate class="fade-up delay-300 text-2xl font-semibold text-[#0A0E23]">
                                ₹5000 <span class="text-lg font-medium text-gray-700">(inclusive of GST)</span>
                            </h3>
                            <p data-animate class="fade-up delay-400 text-gray-600 mb-10">
                                Monthly Subscription based
                            </p>
                        </div>

                        <!-- Subscribe Button -->
                        <button data-animate
                            class="fade-up delay-500 mt-4 px-8 py-3 text-sm font-medium rounded-full border border-gray-400 flex items-center gap-2 hover:bg-gray-100 transition">
                            Subscribe Now
                            <span class="text-lg">→</span>
                        </button>

                    </div>

                    <!-- RIGHT SIDE FEATURES GRID -->
                    <div class="grid grid-cols-2 gap-6">

                        <!-- Feature Box 1 -->
                        <div data-animate
                            class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col gap-4 shadow-sm 
                            w-40 h-40          
                            md:w-48 md:h-44   
                            lg:w-58 lg:h-48   
                            xl:w-72 xl:h-56">
                            <div
                                class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                                ✔
                            </div>

                            <p class="text-gray-800">Intraday recommendations</p>
                        </div>

                        <div data-animate
                            class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col gap-4 shadow-sm 
                            w-40 h-40          
                            md:w-48 md:h-44   
                            lg:w-58 lg:h-48   
                            xl:w-72 xl:h-56">
                            <div
                                class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                                ✔
                            </div>

                            <p class="text-gray-800">Intraday recommendations</p>
                        </div>



                        <div data-animate
                            class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col gap-4 shadow-sm 
                            w-40 h-40          
                            md:w-48 md:h-44   
                            lg:w-58 lg:h-48   
                            xl:w-72 xl:h-56">
                            <div
                                class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                                ✔
                            </div>

                            <p class="text-gray-800">Intraday recommendations</p>
                        </div>

                    </div>

                </div>
            </section> --}}


        <!-- KYC NOTICE SECTION -->
        <section class="w-full px-4 md:px-8 lg:px-16 mt-10 flex justify-center">
            <div class="max-w-[1500px] w-full text-center py-6">

                <p data-animate class="fade-up text-gray-700 text-sm md:text-base leading-relaxed max-w-xl mx-auto">
                    Subscription activation requires KYC
                </p>
                <p data-animate class="fade-up text-gray-700 text-sm md:text-base leading-relaxed max-w-xl mx-auto">
                    completion as per regulatory guidelines.
                </p>

            </div>
        </section>



        <!-- COMMON FEATURES SECTION -->
        <section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center">
            <div class="max-w-[1500px] w-full text-center">

                <!-- Badge -->
                <span data-animate
                    class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-4">
                    Common Features
                </span>

                <!-- Title -->
                <h2 data-animate class="fade-up delay-200 text-2xl md:text-3xl font-semibold text-[#0939a4] mb-14">
                    What’s Included in Every Plan
                </h2>

                <!-- Feature Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Card -->
                    <div data-animate
                        class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col items-start gap-4 shadow-sm 
                       min-h-[160px] md:min-h-[180px] lg:min-h-[200px] xl:min-h-[220px]">
                        <div
                            class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                            ✔</div>
                        <p class="text-gray-800 text-left">Intraday recommendations</p>
                    </div>

                    <!-- Card -->
                    <div data-animate
                        class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col items-start gap-4 shadow-sm 
                       min-h-[160px] md:min-h-[180px] lg:min-h-[200px] xl:min-h-[220px]">
                        <div
                            class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                            ✔</div>
                        <p class="text-gray-800 text-left">Real-time risk alerts</p>
                    </div>

                    <!-- Card -->
                    <div data-animate
                        class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col items-start gap-4 shadow-sm 
                       min-h-[160px] md:min-h-[180px] lg:min-h-[200px] xl:min-h-[220px]">
                        <div
                            class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                            ✔</div>
                        <p class="text-gray-800 text-left">Market news & insights</p>
                    </div>

                    <!-- Card -->
                    <div data-animate
                        class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col items-start gap-4 shadow-sm 
                       min-h-[160px] md:min-h-[180px] lg:min-h-[200px] xl:min-h-[220px]">
                        <div
                            class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                            ✔</div>
                        <p class="text-gray-800 text-left">Secure dashboard access</p>
                    </div>

                </div>
            </div>
        </section>




        <!-- WHY SUBSCRIBE SECTION -->
        {{-- <section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center">
            <div class="max-w-[1500px] w-full grid md:grid-cols-2 gap-12">

                <!-- LEFT SIDE TEXT -->
                <div>
                    <!-- Badge -->
                    <span data-animate
                        class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-5">
                        Why Subscribe
                    </span>

                    <!-- Title -->
                    <h2 data-animate
                        class="fade-up delay-200 text-[28px] md:text-[34px] font-semibold text-[#0939a4] leading-snug mb-4">
                        Why choose our subscription?
                    </h2>

                    <!-- Subtitle -->
                    <p data-animate class="fade-up delay-300 text-gray-700 text-base md:text-lg max-w-md">
                        We turn market complexity into simple, actionable guidance you can trust.
                    </p>
                </div>

                <!-- RIGHT SIDE CARDS GRID -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- Card 1 -->
                    <div data-animate
                        class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col gap-4 shadow-sm 
                            w-40 h-40          
                            md:w-48 md:h-44   
                            lg:w-58 lg:h-48   
                            xl:w-72 xl:h-56">
                        <div
                            class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                            ✔
                        </div>

                        <p class="text-gray-800">Intraday recommendations</p>
                    </div>

                    <div data-animate
                        class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col gap-4 shadow-sm 
                            w-40 h-40          
                            md:w-48 md:h-44   
                            lg:w-58 lg:h-48   
                            xl:w-72 xl:h-56">
                        <div
                            class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                            ✔
                        </div>

                        <p class="text-gray-800">Intraday recommendations</p>
                    </div>

                    <div data-animate
                        class="fade-up delay-200 bg-[#F5F7FB] p-6 rounded-2xl flex flex-col gap-4 shadow-sm 
                            w-40 h-40          
                            md:w-48 md:h-44   
                            lg:w-58 lg:h-48   
                            xl:w-72 xl:h-56">
                        <div
                            class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center text-white text-lg">
                            ✔
                        </div>

                        <p class="text-gray-800">Intraday recommendations</p>
                    </div>

                </div>

            </div>
        </section> --}}

        <!-- WHY SUBSCRIBE (MODERN) -->
        <section class="relative py-24 bg-gradient-to-b from-[#f7f9ff] to-white">
            <div class="max-w-[1600px] mx-auto px-4 md:px-8 lg:px-16">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

                    <!-- LEFT CONTENT -->
                    <div>
                        <!-- Badge -->
                        <span
                            class="inline-flex items-center gap-2 text-blue-100 bg-[#0939a4]
                           px-5 py-2 rounded-full text-sm font-semibold mb-6">
                            Why Subscribe
                        </span>

                        <!-- Heading -->
                        <h2
                            class="text-3xl md:text-4xl font-bold text-[#0939a4]
                           leading-tight mb-5">
                            Why choose our subscription?
                        </h2>

                        <!-- Description -->
                        <p class="text-gray-600 text-lg max-w-xl leading-relaxed">
                            We simplify complex market movements into clear, high-confidence trading insights
                            designed to help you make better decisions consistently.
                        </p>
                    </div>

                    <!-- RIGHT FEATURE CARDS -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <!-- CARD -->
                        <div
                            class="group bg-white rounded-2xl p-6 shadow-sm border
                            transition-all duration-300">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl
                               bg-[#0939a4]/10 text-[#0939a4] text-xl mb-4
                               group-hover:bg-[#0939a4] group-hover:text-white transition">
                                ✔
                            </div>

                            <h4 class="font-semibold text-gray-900 mb-2">
                                Intraday Recommendations
                            </h4>

                            <p class="text-sm text-gray-600 leading-relaxed">
                                High-probability intraday trade ideas with clear entry,
                                targets and stop-loss.
                            </p>
                        </div>

                        <!-- CARD -->
                        <div
                            class="group bg-white rounded-2xl p-6 shadow-sm border
                            transition-all duration-300">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl
                               bg-[#0939a4]/10 text-[#0939a4] text-xl mb-4
                               group-hover:bg-[#0939a4] group-hover:text-white transition">
                                ✔
                            </div>

                            <h4 class="font-semibold text-gray-900 mb-2">
                                Risk-Managed Strategy
                            </h4>

                            <p class="text-sm text-gray-600 leading-relaxed">
                                Every call is backed by predefined risk management
                                to protect your capital.
                            </p>
                        </div>

                        <!-- CARD -->
                        <div
                            class="group bg-white rounded-2xl p-6 shadow-sm border
                            transition-all duration-300">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl
                               bg-[#0939a4]/10 text-[#0939a4] text-xl mb-4
                               group-hover:bg-[#0939a4] group-hover:text-white transition">
                                ✔
                            </div>

                            <h4 class="font-semibold text-gray-900 mb-2">
                                Expert Research Team
                            </h4>

                            <p class="text-sm text-gray-600 leading-relaxed">
                                Trades are curated by experienced analysts who
                                actively track market momentum.
                            </p>
                        </div>

                        <!-- CARD -->
                        <div
                            class="group bg-white rounded-2xl p-6 shadow-sm border
                            transition-all duration-300">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl
                               bg-[#0939a4]/10 text-[#0939a4] text-xl mb-4
                               group-hover:bg-[#0939a4] group-hover:text-white transition">
                                ✔
                            </div>

                            <h4 class="font-semibold text-gray-900 mb-2">
                                Priority Support
                            </h4>

                            <p class="text-sm text-gray-600 leading-relaxed">
                                Faster response times and dedicated WhatsApp
                                support for subscribers.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </section>




        <!-- FAQ SECTION -->

        @if ($faqs->isNotEmpty())
            <section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
                <div class="max-w-[1500px] w-full grid md:grid-cols-2 gap-16">

                    <!-- LEFT -->
                    <div>
                        <span x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-4">
                            FAQ
                        </span>

                        <h2 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up delay-200 text-[28px] md:text-[34px] font-semibold text-[#0939a4] leading-snug max-w-sm">
                            Common questions from our users
                        </h2>
                    </div>

                    <!-- RIGHT -->
                    <div class="space-y-6">
                        @foreach ($faqs as $index => $faq)
                            <div x-data="{ open: false, visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                                class="fade-up delay-{{ 100 + $index * 50 }} border-b pb-4">
                                <!-- WRAPPER to control width -->
                                <div class="max-w-xl">
                                    <button @click="open = !open"
                                        class="w-full flex justify-between items-center text-left py-2">
                                        <span class="text-[16px] text-[#0A0E23] font-medium">
                                            {{ $faq->question }}
                                        </span>

                                        <span class="transition-transform duration-300 text-xl"
                                            :class="{ 'rotate-180': open }">▾</span>
                                    </button>

                                    <div x-show="open" x-collapse x-cloak class="text-gray-600 pt-3 pb-2">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>
            </section>
        @endif



        <!-- CONTACT SECTION -->
        {{--    <section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
                <div class="max-w-[1500px] w-full grid md:grid-cols-2 gap-16">

                    <!-- LEFT SIDE CONTENT -->
                    <div>

                        <!-- Badge -->
                        <span data-animate
                            class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-6">
                            FAQ
                        </span>

                        <!-- Title -->
                        <h2 data-animate
                            class="fade-up delay-200 text-[28px] md:text-[34px] font-semibold text-[#0A0E23] leading-snug mb-6">
                            Have questions about subscriptions?<br>
                            Check our FAQ section or Contact<br>
                            Us for support.
                        </h2>

                        <!-- Email -->
                        <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up delay-300 text-[16px] text-[#0A0E23] mb-4">
                            <span class="font-semibold">Email :</span>
                            {{ $contactDetail->email ?? '-' }}
                        </p>

                        <!-- Address -->
                        <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up delay-400 text-[16px] text-[#0A0E23] leading-relaxed mb-4">
                            <span class="font-semibold">Address :</span><br>
                            {!! nl2br(e($contactDetail->address ?? '')) !!}
                        </p>


                        <!-- Phone -->
                        <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up delay-500 text-[16px] text-[#0A0E23] mb-8">
                            <span class="font-semibold">Phone No :</span>
                            {{ $contactDetail->phone ?? '-' }}
                        </p>


                        <!-- Social Icons -->
                        <p data-animate class="fade-up delay-600 font-semibold text-[#0A0E23] mb-4">Follow Us</p>

                        <div data-animate class="fade-up delay-700 flex gap-6 text-2xl text-black">
                            <i class="fa-brands fa-instagram cursor-pointer hover:text-[#0939a4] transition"></i>
                            <i class="fa-brands fa-facebook cursor-pointer hover:text-[#0939a4] transition"></i>
                            <i class="fa-brands fa-linkedin cursor-pointer hover:text-[#0939a4] transition"></i>
                        </div>
                    </div>

                    <!-- RIGHT SIDE FORM -->
                    <div class="space-y-6">

                        <form method="POST" action="{{ route('inquiry.store') }}" class="space-y-6">
                            @csrf

                            <!-- Row: First & Last Name -->
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm text-gray-700 mb-2">First Name</label>
                                    <input type="text" name="first_name" placeholder="Your First Name"
                                        class="w-full border border-gray-300 px-4 py-3 rounded-full outline-none focus:ring-2 focus:ring-blue-500"
                                        required />
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-700 mb-2">Last Name</label>
                                    <input type="text" name="last_name" placeholder="Your Last Name"
                                        class="w-full border border-gray-300 px-4 py-3 rounded-full outline-none focus:ring-2 focus:ring-blue-500"
                                        required />
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" placeholder="Your Email Address"
                                    class="w-full border border-gray-300 px-4 py-3 rounded-full outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>

                            <!-- Message -->
                            <div>
                                <label class="block text-sm text-gray-700 mb-2">Your Message</label>
                                <textarea name="message" placeholder="Write Something........"
                                    class="w-full border border-gray-300 px-4 py-3 rounded-2xl outline-none min-h-[180px] focus:ring-2 focus:ring-blue-500"
                                    required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full bg-[#0939a4] text-white py-4 rounded-full text-lg font-medium hover:bg-[#0939a4] transition">
                                Submit
                            </button>
                        </form>


                    </div>

                </div>
            </section>  --}}


        <!-- CONTACT SECTION -->
        <section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
            <div class="max-w-[1500px] w-full grid md:grid-cols-2 gap-16">

                <!-- LEFT SIDE CONTENT -->
                <div>
                    <!-- Badge -->
                    <span x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-6">
                        FAQ
                    </span>

                    <!-- Title -->
                    <h2 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-200 text-[28px] md:text-[34px] font-semibold text-[#0939a4] leading-snug mb-6">
                        Have questions about subscriptions?<br>
                        Check our FAQ section or Contact<br>
                        Us for support.
                    </h2>

                    <!-- Email -->
                    <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-300 text-[16px] text-[#828597] mb-4">
                        <span class="font-semibold text-[#595959]">Email :</span>
                        {{ $contactDetail->email ?? '-' }}
                    </p>


                    <!-- Address -->
                    <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-400 text-[16px] text-[#828597] leading-relaxed mb-4">
                        <span class="font-semibold text-[#595959]">Address :</span><br>
                        {!! nl2br(e($contactDetail->address ?? '')) !!}
                    </p>


                    <!-- Phone -->
                    <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-500 text-[16px] text-[#828597] mb-8">
                        <span class="font-semibold text-[#595959]">Phone No :</span>
                        {{ $contactDetail->phone ?? '-' }}
                    </p>


                    <!-- Social Icons -->
                    <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-600 font-semibold text-[#828597] mb-4">
                        Follow Us
                    </p>

                    <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-700 flex gap-6 text-2xl text-[#0939a4]">
                        <i class="fa-brands fa-instagram cursor-pointer hover:text-[#0939a4] transition"></i>
                        <i class="fa-brands fa-facebook cursor-pointer hover:text-[#0939a4] transition"></i>
                        <i class="fa-brands fa-linkedin cursor-pointer hover:text-[#0939a4] transition"></i>
                    </div>
                </div>

                <!-- RIGHT SIDE FORM -->
                <div class="space-y-6">
                    <form method="POST" action="{{ route('inquiry.store') }}" class="space-y-6">
                        @csrf

                        <!-- Row: First & Last Name -->
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm text-gray-700 mb-2">First Name</label>
                                <input type="text" name="first_name" placeholder="Your First Name"
                                    class="w-full border border-gray-300 px-4 py-3 rounded-full outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>

                            <div>
                                <label class="block text-sm text-gray-700 mb-2">Last Name</label>
                                <input type="text" name="last_name" placeholder="Your Last Name"
                                    class="w-full border border-gray-300 px-4 py-3 rounded-full outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" placeholder="Your Email Address"
                                class="w-full border border-gray-300 px-4 py-3 rounded-full outline-none focus:ring-2 focus:ring-blue-500"
                                required />
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm text-gray-700 mb-2">Your Message</label>
                            <textarea name="message" placeholder="Write Something........"
                                class="w-full border border-gray-300 px-4 py-3 rounded-2xl outline-none min-h-[180px] focus:ring-2 focus:ring-blue-500"
                                required></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-[#0939a4] text-white py-4 rounded-full text-lg font-medium hover:bg-[#0939a4] transition">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </section>



        <!-- DISCLAIMER SECTION -->
        <section class="w-full px-4 md:px-8 lg:px-16 mt-16 flex justify-center">
            <div class="max-w-[1200px] w-full text-center py-6">

                <p data-animate
                    class="fade-up delay-100 text-gray-600 text-sm md:text-base leading-relaxed max-w-3xl mx-auto">
                    Note: All recommendations involve market risk. We provide research insights —
                    decisions are always the user's responsibility.
                </p>

            </div>
        </section>




        <!--</div>-->
    </div>


    <style>
        .hero-banner.has-overlay::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            /* overlay strength */
            border-radius: 30px;
            z-index: 1;
        }

        /* Keep content above overlay */
        .hero-banner>* {
            position: relative;
            z-index: 2;
        }

        /* Mobile background switch */
        @media (max-width: 768px) {
            .hero-banner {
                background-image: url('{{ $mobileBg ?: $desktopBg }}') !important;
            }
        }
    </style>

@endsection
