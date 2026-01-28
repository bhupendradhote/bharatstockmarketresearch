@extends('layouts.user')
@section('content')

    <!-- CONTACT HERO SECTION -->
    @if ($banner)
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


    <!-- CONTACT FORM SECTION -->
    {{-- <section class="w-full mt-10 px-4 md:px-12 py-12 bg-white flex justify-center">
        <div class="max-w-[1380px] w-full">
            <div class="grid md:grid-cols-12 gap-12 items-start">

                <div class="md:col-span-6 space-y-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Get in Touch</h2>
                        <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-medium">Bharat Stock Market
                            Research</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-phone text-sm text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Call Support</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $contactDetail->phone ?? '+91 94572 96893' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-envelope text-sm text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Email</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $contactDetail->email ?? 'namitarathore05071992@gmail.com' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-location-dot text-sm text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Location</p>
                                <p class="text-xs leading-relaxed text-gray-600">
                                    223, Qila Chawni, Near Holi Chowk, Ward No. 47,<br>Rampur Road, Bareilly, UP - 243001
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl border border-blue-100 bg-blue-50/30 space-y-4">
                        <div class="flex justify-between items-center border-b border-blue-100 pb-3">
                            <div>
                                <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest">Proprietor</p>
                                <h4 class="text-sm font-bold text-gray-900">Namita Rathore</h4>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 font-bold uppercase">BSE Enlistment</p>
                                <p class="text-xs font-bold text-gray-800">6838</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-1">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">SEBI Reg. No.</p>
                                <p class="text-xs font-mono font-bold text-blue-700">INH000023728</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Validity</p>
                                <p class="text-xs font-bold text-gray-800">31 Oct 2025 - 2030</p>
                            </div>
                        </div>
                        <p class="text-[9px] text-blue-500 font-bold uppercase text-center pt-2">Registered Research Analyst
                        </p>
                    </div>
                </div>

                <div class="md:col-span-6 bg-white rounded-3xl p-2">
                    <form action="{{ route('inquiry.store') }}" method="POST"
                        class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-10">
                        @csrf

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">First Name</label>
                            <input type="text" name="first_name" required
                                class="w-full text-sm py-2 px-0 border-0 border-b border-gray-200 outline-none focus:outline-none focus:ring-0 focus:border-[#032687] transition-all placeholder:text-gray-300 bg-transparent"
                                placeholder="e.g. JOHN ">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Last Name</label>
                            <input type="text" name="last_name"
                                class="w-full text-sm py-2 px-0 border-0 border-b border-gray-200 outline-none focus:outline-none focus:ring-0 focus:border-[#2f58c7] transition-all placeholder:text-gray-300 bg-transparent"
                                placeholder="e.g. DOE ">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email
                                Address</label>
                            <input type="email" name="email" required
                                class="w-full text-sm py-2 px-0 border-0 border-b border-gray-200 outline-none focus:outline-none focus:ring-0 focus:border-[#1a46c0] transition-all placeholder:text-gray-300 bg-transparent"
                                placeholder="your@email.com">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Phone</label>
                            <input type="text" name="phone"
                                class="w-full text-sm py-2 px-0 border-0 border-b border-gray-200 outline-none focus:outline-none focus:ring-0 focus:border-[#224fca] transition-all placeholder:text-gray-300 bg-transparent"
                                placeholder="+91 00000 00000">
                        </div>

                        <div class="sm:col-span-2 space-y-3 py-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Subject</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach (['General', 'Support', 'Billing', 'Partnership'] as $sub)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="subject" value="{{ $sub }}" class="peer hidden"
                                            {{ $loop->first ? 'checked' : '' }}>
                                        <div
                                            class="px-3 py-1.5 rounded-lg border border-gray-100 text-[11px] font-bold text-gray-400 peer-checked:bg-[#032687] peer-checked:text-white peer-checked:border-[#032687] transition-all">
                                            {{ $sub }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="sm:col-span-2 space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Message</label>
                            <textarea name="message" rows="2" required
                                class="w-full text-sm py-2 px-0 border-0 border-b border-gray-200 outline-none focus:outline-none focus:ring-0 focus:border-[#032687] transition-all placeholder:text-gray-300 resize-none bg-transparent"
                                placeholder="How can we help?"></textarea>
                        </div>

                        <div class="sm:col-span-2 flex justify-start pt-2">
                            <button
                                class="bg-[#032687] text-white px-8 py-3 rounded-xl text-xs font-bold shadow-lg shadow-blue-100 hover:bg-[#032687] transition-all transform hover:-translate-y-0.5">
                                Send Inquiry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section> --}}


    <section class="w-full px-4 md:px-8 lg:px-16 mt-12 flex justify-center font-sans">
        <div
            class="max-w-[1600px] w-full bg-white rounded-2xl border border-gray-200 p-6 md:p-10 grid md:grid-cols-2 gap-10">

            <!-- LEFT PANEL -->
            <div class="bg-[#F5F7FB] rounded-xl p-8 flex flex-col justify-between">

                <div>
                    <h2 class="text-[22px] font-medium text-[#0A0E23] mb-1">
                        Contact Information
                    </h2>
                    <p class="text-gray-500 text-sm font-light mb-8">
                        Say something to start a live chat!
                    </p>

                    <!-- Phone -->
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fa-solid fa-phone text-base text-gray-600"></i>
                        <p class="text-gray-700 text-sm font-light">
                            {{ $contactDetail->phone ?? '-' }}
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fa-solid fa-envelope text-base text-gray-600"></i>
                        <p class="text-gray-700 text-sm font-light">
                            {{ $contactDetail->email ?? '-' }}
                        </p>
                    </div>

                    <!-- Location -->
                    <div class="flex items-start gap-3 mb-8">
                        <i class="fa-solid fa-location-dot text-base text-gray-600 mt-0.5"></i>
                        <p class="text-gray-700 text-sm font-light leading-relaxed">
                            {!! nl2br(e($contactDetail->address ?? '-')) !!}
                        </p>
                    </div>

                    <!-- PROPRIETOR / REGULATORY DETAILS -->
                    <div class="p-5 rounded-2xl border border-blue-100 bg-blue-50/30 space-y-4">
                        <div class="flex justify-between items-center border-b border-blue-100 pb-3">
                            <div>
                                <p class="text-[10px] text-blue-600 uppercase tracking-widest font-normal">
                                    Proprietor
                                </p>
                                <h4 class="text-sm font-medium text-gray-900">
                                    Namita Rathore
                                </h4>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-normal">
                                    BSE Enlistment
                                </p>
                                <p class="text-xs font-light text-gray-800">
                                    6838
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-1">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-normal">
                                    SEBI Reg. No.
                                </p>
                                <p class="text-xs font-mono font-light text-blue-700">
                                    INH000023728
                                </p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-normal">
                                    Validity
                                </p>
                                <p class="text-xs font-light text-gray-800">
                                    31 Oct 2025 – 2030
                                </p>
                            </div>
                        </div>

                        <p class="text-[9px] text-blue-500 uppercase tracking-widest text-center font-normal pt-2">
                            Registered Research Analyst
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL — FORM -->
            <form action="{{ route('inquiry.store') }}" method="POST" class="flex flex-col gap-6 font-sans">
                @csrf

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs text-gray-500 font-light">First Name</label>
                        <input type="text" name="first_name" required
                            class="w-full border-0 border-b border-gray-300 bg-transparent text-sm font-light focus:border-[#0939a4] focus:ring-0 outline-none ps-0 transition">
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 font-light">Last Name</label>
                        <input type="text" name="last_name"
                            class="w-full border-0 border-b border-gray-300 bg-transparent text-sm font-light focus:border-[#0939a4] focus:ring-0 outline-none ps-0 transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs text-gray-500 font-light">Email</label>
                        <input type="email" name="email" required
                            class="w-full border-0 border-b border-gray-300 bg-transparent text-sm font-light focus:border-[#0939a4] focus:ring-0 outline-none ps-0 transition">
                    </div>

                    <div>
                        <label class="text-xs text-gray-500 font-light">Phone Number</label>
                        <input type="text" name="phone"
                            class="w-full border-0 border-b border-gray-300 bg-transparent text-sm font-light focus:border-[#0939a4] focus:ring-0 outline-none ps-0 transition">
                    </div>
                </div>

                <div>
                    <label class="text-xs text-gray-500 font-light">Select Subject</label>
                    <div class="flex flex-wrap gap-6 mt-3 text-sm text-gray-700 font-light">
                        @foreach (['General Inquiry', 'Support', 'Billing', 'Partnership'] as $subject)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="subject" value="{{ $subject }}"
                                    {{ $loop->first ? 'checked' : '' }}
                                    class="w-3 h-3 appearance-none border border-gray-400 rounded-full checked:bg-[#0939a4] checked:border-[#0939a4] checked:ring-1 checked:ring-blue-200">
                                {{ $subject }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="text-xs text-gray-500 font-light">Message</label>
                    <textarea name="message" rows="3"
                        class="w-full border-0 border-b border-gray-300 bg-transparent text-sm font-light focus:border-[#0939a4] focus:ring-0 outline-none ps-0 resize-none transition"></textarea>
                </div>

                <!-- SOCIAL ICONS (MOVED TO RIGHT PANEL) -->
                <div class="flex items-center justify-between pt-4">
                    <div class="flex gap-4">
                        <a href="{{ $contactDetail->twitter ?? '#' }}"
                            class="w-9 h-9 rounded-full bg-white border shadow-sm flex items-center justify-center text-blue-500">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                        <a href="{{ $contactDetail->instagram ?? '#' }}"
                            class="w-9 h-9 rounded-full bg-white border shadow-sm flex items-center justify-center text-pink-500">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="{{ $contactDetail->facebook ?? '#' }}"
                            class="w-9 h-9 rounded-full bg-white border shadow-sm flex items-center justify-center text-blue-700">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="{{ $contactDetail->discord ?? '#' }}"
                            class="w-9 h-9 rounded-full bg-white border shadow-sm flex items-center justify-center text-purple-600">
                            <i class="fa-brands fa-discord"></i>
                        </a>
                    </div>

                    <button
                        class="bg-[#0939a4] text-white px-10 py-3 rounded-lg text-sm font-medium shadow hover:bg-blue-700 transition">
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
