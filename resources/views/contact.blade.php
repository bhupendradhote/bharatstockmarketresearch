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
    <section class="w-full mt-10 px-4 md:px-12 py-12 bg-white flex justify-center">
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
                                placeholder="e.g. Namita">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Last Name</label>
                            <input type="text" name="last_name"
                                class="w-full text-sm py-2 px-0 border-0 border-b border-gray-200 outline-none focus:outline-none focus:ring-0 focus:border-[#2f58c7] transition-all placeholder:text-gray-300 bg-transparent"
                                placeholder="e.g. Rathore">
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
