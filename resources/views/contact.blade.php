@extends('layouts.user')
@section('content')
    <!-- CONTACT HERO SECTION -->

    <!-- CONTACT HERO SECTION -->
 {{--   @if ($banner)
        <section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
            <div
                class="max-w-[1600px] w-full bg-[#F5F7FB] rounded-[30px] 
            flex flex-col items-center text-center px-4 md:px-10 py-20 md:py-28 lg:py-32">

                <!-- Badge -->
                <span data-animate
                    class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full 
                text-sm md:text-base mb-6">
                    {{ $banner->title ?? 'Contact us' }}
                </span>

                <!-- Heading -->
                <h1 data-animate
                    class="fade-up delay-200 text-[22px] md:text-[30px] lg:text-[36px] font-semibold 
                text-[#0939a4] leading-snug max-w-2xl">

                    @php
                        $subtitle = trim($banner->subtitle ?? '');
                        $words = preg_split('/\s+/', $subtitle);
                        $firstLine = implode(' ', array_slice($words, 0, 4));
                        $secondLine = implode(' ', array_slice($words, 4));
                    @endphp

                    {{ $firstLine }}
                    @if ($secondLine)
                        <br>
                        {{ $secondLine }}
                    @endif
                </h1>

            </div>
        </section>
    @endif
    --}}
    @if ($banner)
@php
    $desktopBg = $banner->getFirstMediaUrl('background');
    $mobileBg  = $banner->getFirstMediaUrl('mobile_background');

    $subtitle = trim($banner->subtitle ?? '');
    $words = preg_split('/\s+/', $subtitle);
    $firstLine = implode(' ', array_slice($words, 0, 4));
    $secondLine = implode(' ', array_slice($words, 4));
@endphp

<section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
    <div
        class="relative hero-banner max-w-[1600px] w-full rounded-[30px]
        flex flex-col items-center text-center px-4 md:px-10
        py-20 md:py-28 lg:py-32
        bg-[#F5F7FB] bg-no-repeat bg-cover bg-center"
        style="
            min-height: 400px;
            @if($desktopBg)
                background-image: url('{{ $desktopBg }}');
            @endif
        "
    >

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/30 rounded-[30px]"></div>

        <div class="relative z-10">

            <!-- Badge -->
            <span data-animate
                class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2
                rounded-full text-sm md:text-base mb-6">
                {{ $banner->title ?? 'Contact us' }}
            </span>

            <!-- Heading -->
            <h1 data-animate
                class="fade-up delay-200 text-[22px] md:text-[30px] lg:text-[36px]
                font-semibold text-white leading-snug max-w-2xl">

                {{ $firstLine }}
                @if ($secondLine)
                    <br>
                    {{ $secondLine }}
                @endif
            </h1>

        </div>
    </div>
</section>

{{-- Mobile Background --}}
<style>
@media (max-width: 768px) {
    .hero-banner {
        background-image: url('{{ $mobileBg ?: $desktopBg }}') !important;
    }
}
</style>
@endif



    <!-- CONTACT FORM SECTION -->
    <section class="w-full px-4 md:px-8 lg:px-16 mt-12 flex justify-center">
        <div class="max-w-[1600px] w-full bg-white rounded-2xl border p-6 md:p-10 grid md:grid-cols-2 gap-10">

            <!-- LEFT PANEL -->
            <div class="bg-[#F5F7FB] rounded-xl p-8 flex flex-col justify-between">

                <div>
                    <h2 class="text-[22px] font-semibold text-[#0A0E23] mb-2">Contact Information</h2>
                    <p class="text-gray-600 text-sm mb-8">Say something to start a live chat!</p>

                    <!-- Phone -->
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fa-solid fa-phone text-lg"></i>
                        <p class="text-gray-700">
                            {{ $contactDetail->phone ?? '-' }}
                        </p>
                    </div>


                    <!-- Email -->
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fa-solid fa-envelope text-lg"></i>
                        <p class="text-gray-700">
                            {{ $contactDetail->email ?? '-' }}
                        </p>
                    </div>


                    <!-- Location -->
                    <div class="flex items-center gap-3 mb-8">
                        <i class="fa-solid fa-location-dot text-lg"></i>
                        <p class="text-gray-700">
                            {!! nl2br(e($contactDetail->address ?? '')) !!}
                        </p>
                    </div>

                </div>

                <!-- Social Icons -->
                <div class="flex gap-4 mt-10">
                    <a href="#"
                        class="w-9 h-9 rounded-full bg-white shadow flex items-center justify-center text-blue-500">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#"
                        class="w-9 h-9 rounded-full bg-white shadow flex items-center justify-center text-pink-500">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#"
                        class="w-9 h-9 rounded-full bg-white shadow flex items-center justify-center text-blue-700">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#"
                        class="w-9 h-9 rounded-full bg-white shadow flex items-center justify-center text-purple-600">
                        <i class="fa-brands fa-discord"></i>
                    </a>
                </div>
            </div>

            <!-- RIGHT PANEL — FORM -->
            <form action="{{ route('inquiry.store') }}" method="POST" class="flex flex-col gap-6">
                @csrf

                <!-- Name Row -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">First Name</label>
                        <input type="text" name="first_name"
                            class="w-full border-0 border-b border-gray-300 bg-transparent
                focus:border-blue-600 focus:ring-0 transition ps-0 outline-none" />
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Last Name</label>
                        <input type="text" name="last_name"
                            class="w-full border-0 border-b border-gray-300 bg-transparent
                focus:border-blue-600 focus:ring-0 transition ps-0 outline-none" />
                    </div>
                </div>

                <!-- Email + Phone -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <input type="email" name="email"
                            class="w-full border-0 border-b border-gray-300 bg-transparent
                focus:border-blue-600 focus:ring-0 transition ps-0 outline-none" />
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Phone Number</label>
                        <input type="text" name="phone"
                            class="w-full border-0 border-b border-gray-300 bg-transparent
                focus:border-blue-600 focus:ring-0 transition ps-0 outline-none" />
                    </div>
                </div>

                <!-- Subject -->
                <div>
                    <label class="text-sm text-gray-600">Select Subject?</label>

                    <div class="flex flex-wrap gap-6 mt-2 text-sm text-gray-700">

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="subject" value="General Inquiry" checked
                                class="w-3 h-3 appearance-none border border-gray-400 rounded-full
                    checked:bg-[#0939a4] checked:border-blue-600 checked:ring-1 checked:ring-blue-200">
                            General Inquiry
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="subject" value="Support"
                                class="w-3 h-3 appearance-none border border-gray-400 rounded-full
                    checked:bg-[#0939a4] checked:border-blue-600 checked:ring-1 checked:ring-blue-200">
                            Support
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="subject" value="Billing"
                                class="w-3 h-3 appearance-none border border-gray-400 rounded-full
                    checked:bg-[#0939a4] checked:border-blue-600 checked:ring-1 checked:ring-blue-200">
                            Billing
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="subject" value="Partnership"
                                class="w-3 h-3 appearance-none border border-gray-400 rounded-full
                    checked:bg-[#0939a4] checked:border-blue-600 checked:ring-1 checked:ring-blue-200">
                            Partnership
                        </label>

                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label class="text-sm text-gray-600">Message</label>
                    <textarea name="message" placeholder="Write your message.."
                        class="w-full border-0 border-b border-gray-300 bg-transparent h-20
            focus:border-blue-600 focus:ring-0 transition ps-0 outline-none"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button class="bg-[#0939a4] text-white px-10 py-3 rounded-lg shadow hover:bg-blue-700 transition">
                        Send Message
                    </button>
                </div>

            </form>



        </div>
    </section>


    <!-- FAQ SECTION -->
    @if (isset($faqs) && $faqs->count())
        <section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
            <div class="max-w-[1500px] w-full grid md:grid-cols-2 gap-16">

                <!-- LEFT TITLE AREA -->
                <div class="space-y-8">
                    <span x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-4">
                        FAQ
                    </span>

                    <h2 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-200 text-[28px] md:text-[34px] font-semibold text-[#0A0E23] leading-snug max-w-sm">
                        Common questions from our users
                    </h2>
                </div>

                <!-- RIGHT ACCORDION -->
                <div class="space-y-8">
                    @foreach ($faqs as $index => $faq)
                        <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up delay-{{ 100 + $index * 50 }} border-b pb-4">

                            <button class="w-full flex justify-between items-center text-left faq-toggle py-2">
                                <span class="text-[16px] text-[#0A0E23] font-medium">
                                    {{ $faq->question }}
                                </span>
                                <span class="faq-arrow transition-transform duration-300 text-xl">▾</span>
                            </button>

                            <div class="faq-content overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                                <p class="text-gray-600 pt-3 pb-2">
                                    {!! nl2br(e($faq->answer)) !!}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif
@endsection
