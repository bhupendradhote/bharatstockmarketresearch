@extends('layouts.user')

<!--Testimonial Style-->
<style>
/* Section level lock */
.testimonial-section {
    width: 100%;
    max-width: 100vw; /* Page ki width se bahar kabhi nahi jayega */
    overflow-x: hidden; /* Hard Lock */
    margin-block: 5rem;
    
    /*padding: 60px 0;*/
    /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica;*/
}

.testimonial-wrapper {
    width: 100%;
    /*max-width: 1400px;*/
    margin: 0 auto;
    padding: 0 20px;
    box-sizing: border-box;
    background: #f9fafb;
    border-radius: 20px;
        padding: 60px 50px;

}



/* The Combined Badge Style */
.badge {
    display: inline-block;
    background: #005bc1; /* Your specific blue */
    color: #ffffff;
    padding: 8px 20px;   /* Adjusted to match px-5 py-2 */
    border-radius: 9999px; /* Rounded-full */
    font-size: 14px;     /* text-sm */
    font-weight: 500;    /* font-medium */
    text-transform: uppercase;
    letter-spacing: 0.025em;
    
    /* ✅ TEXT SHADOW ADDED HERE */
    /* offset-x | offset-y | blur-radius | color */
    text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.3);
    
    transition: all 0.3s ease;
}

.heading {
    font-size: clamp(20px, 5vw, 32px); /* Responsive font bina layout tode */
    color: #111827;
    margin: 15px 0 30px 0;
}

/* Slider Window: Iska size fixed hai mobile screen ke liye */
.slider-window {
    width: 100%;
    overflow: hidden; /* Iske bahar ka sab gayab ho jayega */
    position: relative;
}

.slider-track {
    display: flex;
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    will-change: transform;
}

/* Card Styling: Mobile pe 100% width */
.testimonial-card {
    min-width: 100%; /* Yahan mobile pe ek hi card dikhega */
    padding: 10px;
    box-sizing: border-box;
}

.card-inner {
    background: #fff;
    border: 1px solid #e5e7eb;
    padding: 25px;
    border-radius: 16px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 240px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.quote-mark { font-size: 40px; color: #d1d5db; height: 30px; }
.quote-content { color: #4b5563; font-size: 15px; line-height: 1.6; margin-bottom: 20px; }

.card-footer { display: flex; align-items: center; gap: 12px; border-top: 1px solid #f3f4f6; pt: 15px; margin-top: auto; }
.avatar { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
.u-name { display: block; font-weight: 700; color: #111827; font-size: 14px; }
.u-place { display: block; color: #6b7280; font-size: 12px; }

/* Desktop Adjustment */
@media (min-width: 768px) {
    .testimonial-card { min-width: 50%; }
}
@media (min-width: 1024px) {
    .testimonial-card { min-width: 33.333%; }
}

/* Navigation */
.slider-nav { display: flex; align-items: center; justify-content: center; gap: 20px; margin-top: 30px; }
.arrow { width: 40px; height: 40px; border-radius: 50%; border: 1px solid #d1d5db; background: #fff; cursor: pointer; font-size: 20px; }
.dots { display: flex; gap: 8px; }
.dot { width: 8px; height: 8px; background: #d1d5db; border-radius: 50%; cursor: pointer; transition: 0.3s; }
.dot.active { background: #2563eb; width: 24px; border-radius: 4px; }
</style>

@section('content')

   {{--   
   <section class="disclaimer-section  mt-28">
        <marquee behavior="scroll" direction="left" scrollamount="5">
            ⚠️ Disclaimer: This website is for informational purposes only. We do not provide any financial, legal, or
            investment advice. Please consult a professional before making any decisions.
            <span class="text-slate-300 text-sm font-medium">⚠️ <strong>Important:</strong> All information provided on
                this website is for general educational purposes only.</span>
            <span class="text-slate-300 text-sm font-medium">• Investing in financial markets involves risks. Always
                consult with a professional advisor.</span>
            <span class="text-slate-300 text-sm font-medium">• Past performance is not indicative of future results. Use
                this data at your own discretion.</span>
            <span class="text-slate-300 text-sm font-medium">• BSMR does not take responsibility for any financial losses
                incurred using our tools or advice.</span>
        </marquee>
    </section>
    --}}
    
    @if ($marquees->count() > 0)
        <section class="disclaimer-section mt-28">
            <marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop();" onmouseout="this.start();">
                @foreach ($marquees as $marquee)
                    <span class="marquee-item inline-flex items-center mx-4">
                        {{-- Title in bold if it exists --}}
                        @if ($marquee->title)
                            <strong class="mr-1">{{ $marquee->title }}:</strong>
                        @endif

                        {{-- The main dynamic content --}}
                        <span class="text-slate-300 text-sm font-medium">
                            {{ $marquee->content }}
                        </span>

                        {{-- Separator between multiple marquee items --}}
                        @if (!$loop->last)
                            <span class="mx-6 text-indigo-400">•</span>
                        @endif
                    </span>
                @endforeach
            </marquee>
        </section>
    @endif
    <style>
        .disclaimer-section {
            background: #0b3186;
            color: #ffffff;
            padding: 8px 0;
            font-size: 14px;
        }
    </style>
<section class="relative bg-gray-100 py-12 w-full px-4 sm:px-6 mt-[0.5rem] lg:px-8 border-y-4 border-yellow-400">
  <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>

  <div class="relative max-w-5xl mx-auto">
    
    <div class="text-center mb-10">
      <span class="inline-block px-4 py-1 rounded-full bg-yellow-200 text-yellow-800 text-xs font-bold uppercase tracking-widest mb-4">
        Official Notice
      </span>
      <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight">
        Website Under Construction
      </h2>
      <div class="h-1 w-20 bg-[#0939a4] mx-auto mt-2 mb-4"></div>
      <p class="max-w-2xl mx-auto text-gray-600 leading-relaxed">
        <span class="font-bold text-gray-800">Bharat Stock Market Research</span> is currently upgrading its digital platform. 
        As a SEBI Registered Research Analyst, we maintain full transparency.
      </p>
    </div>

    <div class="bg-white rounded-xl shadow-xl border border-gray-300 overflow-hidden">
      <div class="bg-gray-900 px-5 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <div class="h-3 w-3 rounded-full bg-red-500"></div>
          <div class="h-3 w-3 rounded-full bg-yellow-500"></div>
          <div class="h-3 w-3 rounded-full bg-green-500"></div>
          <span class="ml-3 text-gray-300 text-xs font-mono uppercase">sebi_registration_verify.pdf</span>
        </div>
        <!--<a href="sebi-certificate.pdf" download class="bg-[#0939a4] hover:bg-blue-700 text-white px-4 py-1.5 rounded text-xs font-bold transition duration-200">-->
        <!--  DOWNLOAD CERTIFICATE-->
        <!--</a>-->
      </div>
      
      <div class="relative w-full bg-gray-200" style="height: 500px;">
        <object 
          data="sebi-certificate.pdf" 
          type="application/pdf" 
          class="w-full h-full shadow-inner"
        >
          <div class="flex flex-col items-center justify-center h-full p-10 text-center">
            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            <p class="text-gray-600 mb-4">PDF preview not supported in this browser.</p>
            <a href="{{ asset('/pdf/SEBI_Certificate.pdf') }}" target="blank" class="bg-gray-800 text-white px-6 py-2 rounded-lg font-bold">Open Registration PDF</a>
          </div>
        </object>
      </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-200 pt-6">
      <div class="text-left">
        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Research Analyst</p>
        <p class="text-sm text-gray-800 font-semibold">Namita Rathore (Proprietor)</p>
      </div>
      <div class="text-left md:text-right">
        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">SEBI Registration</p>
        <p class="text-sm text-gray-800 font-semibold">INH000023728 | Valid from 31/10/2025</p>
      </div>
    </div>

  </div>
</section>

     


    <!-- HERO SECTION -->
    @if ($banner && $banner->status)
        <section class="w-full px-2 md:px-6 md:py-8 flex justify-center mt-20" id="hero">
            <div x-data="{ sectionVisible: false }" x-intersect.full="sectionVisible = true" :class="{ 'animated': sectionVisible }"
                class="animate-section flex max-w-[1600px] py-10 px-4 w-full md:px-10 lg:px-16
               rounded-[30px] bg-[#F5F7FB] flex-col lg:flex-row lg:items-center gap-10">

                <!-- LEFT SIDE (70%) -->
                <div class="lg:w-[70%] w-full">

                      {{-- BADGE --}}
                        <span x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up inline-block bg-[#0939a4] text-white
                           px-4 md:px-6 py-2 rounded-full 
                           text-xs md:text-sm font-medium">
                            {{-- {{ $banner->title }} --}}
                            Bharat Stock Market Research
                        </span>



                    {{-- SUBTITLE --}}
                    @if ($banner->subtitle)
                        <h1 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up delay-200 text-3xl md:text-5xl lg:text-6xl
                           text-[#2452d28c] leading-tight my-8">
                            <span class="text-[#014694]">

                                {{ $banner->title }}
                            </span>
                            <br>
                            {{ $banner->subtitle }}
                        </h1>
                    @endif

                    {{-- DESCRIPTION --}}
                    @if ($banner->description)
                        <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up delay-300 text-gray-600 mt-4 md:mt-6
                           max-w-md text-base md:text-lg">
                            {{ $banner->description }}
                        </p>
                    @endif

                    {{-- BUTTONS --}}
                    @if ($banner->show_buttons && ($banner->button_text_1 || $banner->button_text_2))
                        <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                            class="fade-up delay-400 flex flex-col sm:flex-row
                           gap-3 md:gap-4 mt-6 md:mt-8">

                            @if ($banner->button_text_1)
                                <a href="{{ $banner->button_link_1 ?? '#' }}"
                                    class="bg-[#05b] text-white px-6 md:px-8 py-3
                                  rounded-full font-semibold hover:bg-blue-800
                                  transition text-center text-base md:text-lg">
                                    {{ $banner->button_text_1 }}
                                </a>
                            @endif

                            @if ($banner->button_text_2)
                                <a href="{{ $banner->button_link_2 ?? '#' }}"
                                    class="bg-white border border-gray-300 px-6 md:px-8 py-3
                                  rounded-full font-semibold hover:bg-gray-100
                                  transition text-center text-base md:text-lg">
                                    {{ $banner->button_text_2 }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

            <div class="lg:w-[30%] w-full flex justify-center lg:justify-end mt-8 lg:mt-0">
    @if ($banner->getFirstMediaUrl('background'))
        <img x-data="{ visible: false, isFloating: false }" 
             x-intersect.half="visible = true"
             x-init="setTimeout(() => { isFloating = true }, 1300);" 
             :class="{ 'animated': visible, 'floating': isFloating }"
             src="{{ $banner->getFirstMediaUrl('background') }}" 
             alt="hero image"
             class="zoom-in delay-500
                    w-[280px] sm:w-[320px] md:w-[400px]
                    lg:w-[480px] xl:w-[520px]
                    drop-shadow-2xl">
    @endif
</div>
            </div>
        </section>
    @endif




{{--
     <!--STATS SECTION -->
    @if ($counters)
        <section class="w-full flex justify-center mt-20 px-4 md:px-8 lg:px-16" id="stats">
            <div class="max-w-[1600px] w-full grid grid-cols-2 md:grid-cols-4 gap-10 md:gap-16 text-center">

                @foreach ($counters as $index => $counter)
                    <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up {{ $index > 0 ? 'delay-' . $index * 100 : '' }} stat-{{ $index + 1 }}">

                        <h2 class="text-4xl md:text-5xl font-bold text-[#0939a4]">
                            {{ $counter->value }}
                        </h2>

                        <p class="text-gray-600 text-sm md:text-base mt-2">
                            {!! nl2br(e($counter->description)) !!}
                        </p>
                    </div>
                @endforeach

            </div>
        </section>
    @endif
    --}}
    

        
        @if ($counters)
        <section class="w-full flex justify-center mt-20 px-4 md:px-8 lg:px-16" id="stats">
            <div class="max-w-[1600px] w-full grid grid-cols-2 md:grid-cols-4 gap-10 md:gap-16 text-center">
        
                @foreach ($counters as $index => $counter)
                    @php
                        $number = (int) filter_var($counter->value, FILTER_SANITIZE_NUMBER_INT);
                        $suffix = str_replace($number, '', $counter->value);
                        // Har counter ke liye thoda extra delay calculate kar rahe hain
                        $staggerDelay = $index * 200; 
                    @endphp
        
                    <div x-data="{ 
                            visible: false, 
                            current: 0, 
                            target: {{ $number }},
                            animated: false,
                            startCounter() {
                                if (this.animated) return;
                                this.animated = true;
                                
                                // CSS Animation ke saath sync karne ke liye thoda wait karega
                                setTimeout(() => {
                                    let startTime = null;
                                    const duration = 2500; // 2.5 seconds for extra smoothness
        
                                    const step = (timestamp) => {
                                        if (!startTime) startTime = timestamp;
                                        const progress = Math.min((timestamp - startTime) / duration, 1);
                                        
                                        // 'EaseOut' formula: starts fast, ends slow
                                        const easeOut = 1 - Math.pow(1 - progress, 3);
                                        this.current = Math.floor(easeOut * this.target);
        
                                        if (progress < 1) {
                                            window.requestAnimationFrame(step);
                                        } else {
                                            this.current = this.target;
                                        }
                                    };
                                    window.requestAnimationFrame(step);
                                }, {{ 500 + $staggerDelay }}); // Entrance animation khatam hone ka wait
                            }
                        }" 
                        x-intersect.half="visible = true; startCounter()" 
                        :class="{ 'animated': visible }"
                        class="fade-up stat-{{ $index + 1 }}"
                        style="transition-delay: {{ $staggerDelay }}ms;">
        
                        <h2 class="text-4xl md:text-5xl font-bold text-[#0939a4]">
                            <span x-text="current">0</span>{{ $suffix }}
                        </h2>
        
                        <p class="text-gray-600 text-sm md:text-base mt-2 font-medium">
                            {!! nl2br(e($counter->description)) !!}
                        </p>
                    </div>
                @endforeach
        
            </div>
        </section>
        @endif

<!-- WHY CHOOSE US – STATIC SECTION -->
<section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center">
    <div class="max-w-[1600px] w-full bg-[#F5F7FB] rounded-[30px] p-6 md:p-12 lg:p-16">

        <!-- TOP CONTENT -->
        <div class="grid lg:grid-cols-2 gap-10 mb-14">
            <!-- LEFT -->
            <div>
                <span class="inline-block bg-[#0939a4] text-white px-5 py-2 rounded-full text-sm font-medium mb-6">
                    Why choose us
                </span>

                <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-[#0939a4] leading-snug">
                    Providing research-based stock<br>
                    insights for responsible investing.
                </h2>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center">
                <p class="text-gray-600 text-sm md:text-base leading-relaxed max-w-xl">
                    We deliver well-researched stock recommendations and timely alerts,
                    so you can take action with better information and reduced uncertainty.
                </p>
            </div>
        </div>

        <!-- FEATURE CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                <div class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center mb-4">
                    🎯
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                    Research you can rely on
                </h4>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Every market call is backed by structured research and clear levels,
                    helping you act with confidence.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                <div class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center mb-4">
                    ⏱️
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                    Timely updates that matter
                </h4>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Get instant alerts on targets, stop-loss changes,
                    and new calls so you’re always updated.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                <div class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center mb-4">
                    📄
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                    Complete Transparency & Compliance
                </h4>
                <p class="text-gray-600 text-sm leading-relaxed">
                    From KYC to disclosures, everything is shared openly
                    to maintain trust and responsibility.
                </p>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                <div class="w-10 h-10 rounded-full bg-[#0939a4] flex items-center justify-center mb-4">
                    📊
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                    All your market essentials in one place
                </h4>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Market calls, news, data, documents, and payments —
                    all organised in one secure dashboard.
                </p>
            </div>

        </div>
    </div>
</section>



    <!-- WHY CHOOSE US SECTION -->
   {{-- @if ($whyChoose)
        <section class="w-full px-2 md:px-6 md:py-8 flex justify-center" id="why-choose">
            <div class="max-w-[1600px] w-full bg-[#F5F7FB] rounded-[30px] p-3 md:p-10 lg:p-14" x-data="{ sectionVisible: false }"
                x-intersect.half="sectionVisible = true" :class="{ 'animate-section animated': sectionVisible }">

                <!-- BADGE -->
                <span x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="fade-up inline-block bg-[#0939a4] text-white px-5 py-2 rounded-full text-sm font-medium mb-6">
                    {{ $whyChoose->badge ?? 'Why choose us' }}
                </span>

                <div class="grid lg:grid-cols-2 gap-10 w-full items-start">

                    <!-- HEADING -->
                    <h2 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-100 text-2xl md:text-3xl lg:text-4xl font-bold text-[#0939a4] leading-snug">
                        {!! nl2br(e($whyChoose->heading ?? '')) !!}
                    </h2>

                    <!-- DESCRIPTION -->
                    <p x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="fade-up delay-200 text-gray-700 text-sm md:text-base leading-relaxed">
                        {!! nl2br(e($whyChoose->description ?? '')) !!}
                    </p>
                </div>

                <!-- IMAGE -->
                <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="zoom-in delay-300 mt-10 rounded-xl overflow-hidden border-2 border-[#c1b8b8] h-[300px] md:h-[420px] lg:h-[490px]">

                    @if ($whyChoose && $whyChoose->getFirstMediaUrl('why_choose_image'))
                        <img src="{{ $whyChoose->getFirstMediaUrl('why_choose_image') }}" alt="Why choose us image"
                            class="w-full h-full object-cover object-center" />
                    @endif

                </div>
            </div>
        </section>
    @endif --}}

    
    
  @if ($offerBanner)
    <section class="w-full flex justify-center mt-16 mb-12 px-4 md:px-8 lg:px-16" id="offer-banner">
        <div class="max-w-[1500px] w-full relative overflow-hidden rounded-[2rem] bg-[#030712] shadow-2xl group">
            
            <div class="absolute inset-0 z-0">
                <picture>
                    <source media="(max-width: 768px)" srcset="{{ $offerBanner->mobile_image_url }}">
                    <img src="{{ $offerBanner->desktop_image_url }}" 
                         alt="{{ $offerBanner->heading }}" 
                         class="w-full h-full object-cover opacity-70 transition-transform duration-[10000ms] ease-in-out group-hover:scale-110">
                </picture>
                <div class="absolute inset-0 bg-gradient-to-r from-[#030712] via-[#030712]/60 to-transparent"></div>
            </div>

            <div class="relative z-10 flex flex-col justify-center min-h-[450px] md:min-h-[550px] p-8 md:p-16 lg:p-24"
                 x-data="{ visible: false }" 
                 x-intersect="visible = true">
                
                @if($offerBanner->highlight_text)
                    <div x-show="visible" x-transition.enter.duration.800ms
                         class="inline-flex items-center space-x-2 bg-yellow-500/10 border border-yellow-500/30 backdrop-blur-md px-4 py-1.5 rounded-full mb-8 w-fit">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-yellow-500"></span>
                        </span>
                        <span class="text-yellow-500 text-xs font-bold uppercase tracking-[0.2em]">
                            {{ $offerBanner->highlight_text }}
                        </span>
                    </div>
                @endif

                <h2 x-show="visible" x-transition.enter.delay.200ms
                    class="text-4xl md:text-6xl lg:text-7xl font-black text-white leading-tight mb-6 drop-shadow-md">
                    {{ $offerBanner->heading }}
                </h2>

                <p x-show="visible" x-transition.enter.delay.400ms
                   class="text-slate-300 text-lg md:text-xl max-w-2xl mb-10 leading-relaxed font-light">
                    {{ $offerBanner->content }}
                </p>

                <div x-show="visible" x-transition.enter.delay.600ms class="flex flex-wrap gap-5">
                    @if ($offerBanner->button1_text)
                        <a href="{{ $offerBanner->button1_link }}" target="{{ $offerBanner->button1_target }}"
                            class="group/btn relative inline-flex items-center justify-center px-10 py-4 font-bold text-black transition-all duration-300 bg-yellow-500 rounded-2xl hover:bg-yellow-400 active:scale-95 shadow-[0_20px_40px_-15px_rgba(234,179,8,0.4)] overflow-hidden">
                            <span class="relative z-10 flex items-center">
                                {{ $offerBanner->button1_text }}
                                <svg class="w-5 h-5 ml-2 transition-transform duration-300 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </a>
                    @endif

                    @if ($offerBanner->button2_text)
                        <a href="{{ $offerBanner->button2_link }}" target="{{ $offerBanner->button2_target }}"
                            class="inline-flex items-center justify-center px-10 py-4 font-bold text-white transition-all duration-300 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 backdrop-blur-xl">
                            {{ $offerBanner->button2_text }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-yellow-500/10 blur-[100px] rounded-full pointer-events-none"></div>
        </div>
    </section>
@endif


    <!-- HOW IT WORKS SECTION -->
    @if ($howItWorks)
        <section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center" id="how-it-works">
            <div class="max-w-[1600px] w-full">

                <!-- Badge -->
                <span x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="fade-up inline-block bg-[#0939a4] text-white px-5 py-2 rounded-full text-sm font-medium mb-4">
                    {{ $howItWorks->badge ?? 'How it Works' }}
                </span>

                <!-- Title -->
                <h2 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="fade-up delay-100 text-2xl md:text-3xl lg:text-4xl font-semibold text-[#0939a4] mb-12">
                    {{ $howItWorks->heading }}
                </h2>

                @foreach ($howItWorks->steps as $index => $step)
                    @php
                        $isEven = $index % 2 === 1;
                    @endphp

                    <div class="grid md:grid-cols-2 gap-10 md:gap-16  items-center {{ $index < count($howItWorks->steps) - 1 ? 'mb-24' : '' }}"
                        x-data="{ visible: false }" x-intersect.half="visible = true"
                        :class="{ 'animate-section animated': visible }">

                        {{-- IMAGE --}}
                        <div x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                            class="fade-up rounded-2xl w-full h-[220px] md:h-[400px] border-2 border-gray-300 overflow-hidden
                           {{ $isEven ? 'order-1 md:order-2' : '' }}">

                            <img src="{{ $step->getFirstMediaUrl('how_it_works_step') }}"
                                class="w-full h-full object-cover object-center rounded-2xl" />
                        </div>

                        {{-- TEXT --}}
                        <div class="{{ $isEven ? 'order-2 md:order-1' : '' }}">
                            <h3 x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                                class="fade-up delay-100 text-xl md:text-2xl font-semibold text-[#0939a4] mb-2">
                                {{ $step->title }}
                            </h3>

                            <p x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                                class="fade-up delay-200 text-gray-600 max-w-sm">
                                {{ $step->description }}
                            </p>
                        </div>

                    </div>
                @endforeach

            </div>
        </section>
    @endif


    <!-- CTA SECTION -->
    <section class="w-full flex justify-center mt-24 px-4 md:px-8 lg:px-16">
        <div class="max-w-[1600px] w-full text-center" x-data="{ visible: false }" x-intersect.half="visible = true"
            :class="{ 'animate-section animated': visible }">

            <!-- Text -->
            <h2 x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                class="fade-up text-xl md:text-2xl lg:text-3xl text-[#0939a4] font-medium leading-relaxed mb-8">
                From registration to real-time recommendations<br class="hidden md:block">
                smoothly and securely.
            </h2>

            <!-- Buttons -->
            <div class="flex justify-center gap-4 mt-4">

                <!-- Join Now Button -->
                <a href="#" x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                    class="fade-up delay-100 bg-[#0939a4] text-white px-6 md:px-8 py-3 rounded-full font-semibold
                      hover:bg-blue-700 transition text-sm md:text-base">
                    Join Now
                </a>

                <!-- Download App Button -->
                <a href="#" x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                    class="fade-up delay-200 bg-white border border-gray-300 px-6 md:px-8 py-3 rounded-full font-semibold 
                      hover:bg-gray-100 transition text-sm md:text-base">
                    Download App
                </a>
            </div>

        </div>
    </section>


    <!-- OUR PLANS SECTION -->
   {{-- <section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center" id="plans">
        <div class="max-w-[1600px] w-full bg-[#F5F7FB] rounded-[30px] p-6 md:p-12 lg:p-16">

            <!-- Badge -->
            <span class="inline-block bg-[#0939a4] text-white px-5 py-2 rounded-full text-sm font-medium mb-4">
                Our Plans
            </span>

            <!-- Title -->
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-[#0939a4] mb-12">
                Plans designed for every type of investor
            </h2>

            <!-- PLANS GRID -->
            <div class="grid md:grid-cols-3 gap-8">

                @foreach ($plans as $plan)
                    <div x-data="{
                        activeDuration: 0,
                        durations: @js(
    $plan->durations
        ->values()
        ->map(
            fn($d) => [
                'label' => $d->duration,
                'price' => $d->price,
                'features' => $d->features
                    ->values()
                    ->map(
                        fn($f) => [
                            'text' => $f->text,
                            'icon' => $f->svg_icon ?? '✔', // default ✔
                        ],
                    )
                    ->toArray(),
            ],
        )
        ->toArray(),
)
                    }"
                        class="bg-white rounded-3xl p-8 shadow-sm {{ $plan->featured ? 'border-2 border-blue-500' : '' }}">

                        <!-- Plan Name -->
                        <h3 class="text-xl font-semibold mb-4">
                            {{ $plan->name }}
                        </h3>

                        <!-- Price -->
                        <p class="text-xl font-bold">
                            ₹<span x-text="durations[activeDuration].price"></span>
                            (inclusive of GST)
                        </p>

                        <p class="text-gray-600 text-sm mb-6">
                            Monthly Subscription based
                        </p>

                        <!-- Duration Buttons -->
                        <div class="flex gap-3 mb-6 flex-wrap">
                            <template x-for="(d, index) in durations" :key="index">
                                <button @click="activeDuration = index" class="px-4 py-2 rounded-full text-sm transition"
                                    :class="activeDuration === index ?
                                        'bg-[#0939a4] text-white' :
                                        'border text-gray-700 hover:bg-gray-50'">
                                    <span x-text="d.label"></span>
                                </button>
                            </template>
                        </div>

                        <!-- Features -->
                        <h4 class="font-semibold mb-3">Features</h4>

                        <ul class="space-y-2 text-gray-700 text-sm">
                            <template x-for="(feature, fIndex) in durations[activeDuration].features"
                                :key="fIndex">
                                <li class="flex justify-between">
                                    <span x-text="feature.text"></span>

                                    <span
                                        :class="feature.icon === '✖' ?
                                            'text-red-500' :
                                            feature.icon === '✔' ?
                                            'text-green-600' :
                                            'text-gray-600'"
                                        x-text="feature.icon">
                                    </span>
                                </li>
                            </template>
                        </ul>
                        <!-- SUBSCRIBE BUTTON -->
                        <div class="mt-8">
                            @auth
                                <a :href="`{{ url('/subscribe/confirm') }}?plan={{ $plan->id }}&duration=${activeDuration}`"
                                    class="w-full inline-flex justify-center items-center px-6 py-3 rounded-full
                   bg-[#0939a4] text-white font-medium hover:bg-blue-700 transition">
                                    Subscribe Now
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="w-full inline-flex justify-center items-center px-6 py-3 rounded-full
                   bg-[#0939a4] text-white font-medium hover:bg-blue-700 transition">
                                    Subscribe Now
                                </a>
                            @endauth
                        </div>


                    </div>
                @endforeach

            </div>
        </div>
    </section> --}}

<section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center" id="plans">
    <div class="max-w-[1600px] w-full bg-[#F5F7FB] rounded-[30px] p-6 md:p-12 lg:p-16">

        <span class="inline-block bg-[#0939a4] text-white px-5 py-2 rounded-full text-sm font-medium mb-4">
            Our Plans
        </span>

        <h2 class="text-2xl md:text-3xl lg:text-4xl font-semibold text-[#0939a4] mb-12">
            Plans designed for every type of investor
        </h2>

        <div class="grid md:grid-cols-3 gap-8">

            @foreach ($plans as $plan)
                <div x-data="{
                    activeDuration: 0,
                    durations: @js($plan->durations->values()->map(fn($d) => [
                        'label' => $d->duration,
                        'price' => $d->price,
                        'features' => $d->features->values()->map(fn($f) => [
                            'text' => $f->text,
                            'icon' => $f->svg_icon ?? '✔',
                        ])->toArray(),
                    ])->toArray())
                }"
                class="group relative bg-[#0015ff0f]  rounded-3xl p-8 shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-2 {{ $plan->featured ? 'border-2 border-[#d8dbff]' : '' }}">

                    @auth
                        <a :href="`{{ url('/services') }}?plan={{ $plan->id }}&duration=${activeDuration}`" class="absolute inset-0 z-10" aria-label="Subscribe to {{ $plan->name }}"></a>
                    @else
                        <a href="{{ route('login') }}" class="absolute inset-0 z-10" aria-label="Login to subscribe"></a>
                    @endauth

                    <div class="relative z-20 pointer-events-none">
                        <h3 class="text-xl font-semibold mb-4 text-[#0939a4]">
                            {{ $plan->name }}
                        </h3>

                        <p class="text-xl font-bold text-[#0939a4]">
                            ₹<span x-text="durations[activeDuration].price"></span>
                            <span class="text-sm font-normal text-gray-500">(inclusive of GST)</span>
                        </p>

                        <p class="text-gray-500 text-sm mb-6">
                            Monthly Subscription based
                        </p>
                    </div>

                    <div class="relative z-30 flex gap-3 mb-6 flex-wrap pointer-events-auto">
                        <template x-for="(d, index) in durations" :key="index">
                            <button @click="activeDuration = index" 
                                class="px-4 py-2 rounded-full text-sm transition font-medium"
                                :class="activeDuration === index ?
                                    'bg-[#0939a4] text-white shadow-md' :
                                    'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                                <span x-text="d.label"></span>
                            </button>
                        </template>
                    </div>

                    <div class="relative z-20 pointer-events-none">
                        <h4 class="font-semibold mb-3 text-[#0939a4]">Features</h4>
                        <ul class="space-y-3 text-gray-700 text-sm">
                            <template x-for="(feature, fIndex) in durations[activeDuration].features" :key="fIndex">
                                <li class="flex justify-between items-center">
                                    <span x-text="feature.text"></span>
                                    <span class="font-bold"
                                        :class="feature.icon === '✖' ? 'text-red-500' : 'text-green-600'"
                                        x-text="feature.icon">
                                    </span>
                                </li>
                            </template>
                        </ul>
                        
                        <!--<div class="mt-8">-->
                        <!--     <div class="w-full inline-flex justify-center items-center px-6 py-3 rounded-full bg-[#0939a4] text-white font-medium group-hover:bg-blue-700 transition">-->
                        <!--        Subscribe Now-->
                        <!--     </div>-->
                        <!--</div>-->
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</section>






    <!-- KEY FEATURES SECTION -->
   {{-- @if ($keyFeatures)
        <section class="w-full flex justify-center mt-20 px-4 md:px-8 lg:px-16" id="features">
            <div class="max-w-[1600px] w-full">

                <!-- Badge -->
                <span x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="fade-up inline-block bg-[#0939a4] text-white px-5 py-2 rounded-full text-sm font-medium">
                    {{ $keyFeatures->heading ?? 'Key Features of the Platform' }}
                </span>

                <!-- Heading -->
                <h2 x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="fade-up delay-100 text-2xl md:text-3xl lg:text-4xl font-bold text-[#0939a4] mt-6">
                    {{ $keyFeatures->description ?? 'Everything you need in one platform' }}
                </h2>

                <!-- Animated Feature Grid -->
                <div class="grid lg:grid-cols-[75%_25%] md:grid-cols-[75%_25%] gap-6 mt-10">

                    <!-- LARGE IMAGE (FIRST ITEM) -->
                    <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                        class="zoom-in delay-200 h-[320px] md:h-[420px] lg:h-[600px]
                            rounded-2xl overflow-hidden border border-gray-200">

                        @if ($keyFeatures->items->first())
                            <img src="{{ $keyFeatures->items->first()->getFirstMediaUrl('feature_images') }}"
                                class="w-full h-full object-cover object-center" />
                        @endif
                    </div>

                    <!-- RIGHT SIDE (2 SMALL IMAGES) -->
                    <div class="flex flex-col gap-6">
                        @foreach ($keyFeatures->items->slice(1, 2) as $index => $item)
                            <div x-data="{ visible: false }" x-intersect.half="visible = true"
                                :class="{ 'animated': visible }"
                                class="zoom-in delay-{{ 300 + $index * 100 }}
                                    h-[150px] md:h-[200px] lg:h-[290px]
                                    rounded-2xl overflow-hidden border border-gray-200">

                                <img src="{{ $item->getFirstMediaUrl('feature_images') }}"
                                    class="w-full h-full object-cover object-center" />
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </section>
    @endif
    --}}
    @if ($keyFeatures)
    <section class="w-full flex justify-center mt-20 px-4 md:px-8 lg:px-16" id="features">
        <div class="w-full lg:max-w-[1600px]">

            <span x-data="{ visible: false }" x-intersect.half="visible = true" 
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'"
                class="inline-block bg-[#0939a4] text-white px-5 py-2 rounded-full text-sm font-medium transition-all duration-700 [text-shadow:_0px_1px_2px_rgb(0_0_0_/_30%)]">
                {{ $keyFeatures->heading ?? 'Key Features of the Platform' }}
            </span>

            <h2 x-data="{ visible: false }" x-intersect.half="visible = true"
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'"
                class="text-2xl md:text-3xl lg:text-4xl font-bold text-[#0939a4] mt-6 transition-all duration-700 delay-100">
                {{ $keyFeatures->description ?? 'Everything you need in one platform' }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-10">

                <div x-data="{ visible: false }" x-intersect.half="visible = true"
                    :class="visible ? 'opacity-100 scale-100' : 'opacity-0 scale-95'"
                    class="md:col-span-9 rounded-2xl overflow-hidden border border-gray-200 transition-all duration-700 delay-200">
                    
                    @if ($keyFeatures->items->first())
                        <img src="{{ $keyFeatures->items->first()->getFirstMediaUrl('feature_images') }}"
                            class="w-full h-full object-cover aspect-[4/3] md:aspect-auto md:h-[450px] lg:h-[600px]" 
                            alt="Main Feature" />
                    @endif
                </div>

                <div class="md:col-span-3 flex flex-col gap-6">
                    @foreach ($keyFeatures->items->slice(1, 2) as $index => $item)
                        <div x-data="{ visible: false }" x-intersect.half="visible = true"
                            :class="visible ? 'opacity-100 scale-100' : 'opacity-0 scale-95'"
                            class="flex-1 rounded-2xl overflow-hidden border border-gray-200 transition-all duration-700"
                            style="transition-delay: {{ 300 + ($index * 100) }}ms">

                            <img src="{{ $item->getFirstMediaUrl('feature_images') }}"
                                class="w-full h-full object-cover min-h-[150px] md:min-h-0" 
                                alt="Sub Feature" />
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
@endif




    <!-- TESTIMONIALS SECTION -->
@if($testimonials->isNotEmpty())
<section class="testimonial-section mt-20 px-4 md:px-8 lg:px-16">
    <div class="testimonial-wrapper ">
        <span class="badge bg-[#0939a4]">Testimonials</span>
        <h2 class="heading font-medium text-[#0939a4]">Real experiences from our subscribers</h2>

        <div class="slider-window">
            <div class="slider-track" id="sliderTrack">
                @foreach ($testimonials as $r)
                    @if(!empty($r->review))
                    <div class="testimonial-card">
                        <div class="card-inner">
                            <div class="quote-mark">❝</div>

                            <p class="quote-content">
                                {{ $r->review }}
                            </p>
                            
                            <div class="card-footer">
                                <img
                                    src="{{ $r->getFirstMediaUrl('review_images')
                                        ?: 'https://ui-avatars.com/api/?name=' . urlencode($r->user?->name ?? $r->name) }}"
                                    class="avatar">

                                <div class="user-meta">
                                    <span class="u-name">
                                        {{ $r->user?->name ?? $r->name }}
                                    </span>
                                    <span class="u-place">
                                        {{ trim($r->city . ', ' . $r->state) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="slider-nav">
            <button class="arrow" onclick="moveSlide(-1)">‹</button>
            <div class="dots" id="dotsContainer"></div>
            <button class="arrow" onclick="moveSlide(1)">›</button>
        </div>
    </div>
</section>
@endif





    <!-- FAQ SECTION -->

@if (isset($faqs) && $faqs->count())
<section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
    <div class="max-w-[1500px] w-full grid md:grid-cols-2 gap-16">

        <!-- LEFT TITLE AREA -->
        <div class="space-y-8">
            <span
                x-data="{ visible: false }"
                x-intersect.half="visible = true"
                :class="{ 'animated': visible }"
                class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-4"
            >
                FAQ
            </span>

            <h2
                x-data="{ visible: false }"
                x-intersect.half="visible = true"
                :class="{ 'animated': visible }"
                class="fade-up delay-200 text-[28px] md:text-[34px] font-semibold text-[#0939a4] leading-snug max-w-sm"
            >
                Common questions from our users
            </h2>
        </div>

        <!-- RIGHT ACCORDION -->
        <div class="space-y-6">
            @foreach ($faqs as $index => $faq)
            <div
                x-data="{ open: false, visible: false }"
                x-intersect.half="visible = true"
                :class="{ 'animated': visible }"
                class="fade-up delay-{{ 100 + $index * 50 }} border-b pb-4"
            >
                <!-- QUESTION -->
                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center text-left py-2"
                >
                    <span class="text-[16px] text-[#0A0E23] font-medium">
                        {{ $faq->question }}
                    </span>

                    <span
                        class="transition-transform duration-300 text-xl"
                        :class="{ 'rotate-180': open }"
                    >
                        ▾
                    </span>
                </button>

                <!-- ANSWER -->
                <div
                    x-show="open"
                    x-collapse
                    x-cloak
                    class="text-gray-600 pt-3 pb-2"
                >
                    {!! nl2br(e($faq->answer)) !!}
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endif



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
                    <i class="fa-brands fa-instagram cursor-pointer hover:text-blue-600 transition"></i>
                    <i class="fa-brands fa-facebook cursor-pointer hover:text-blue-600 transition"></i>
                    <i class="fa-brands fa-linkedin cursor-pointer hover:text-blue-600 transition"></i>
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
                        class="w-full bg-[#0939a4] text-white py-4 rounded-full text-lg font-medium hover:bg-blue-700 transition">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </section>





    <!-- DOWNLOAD APP SECTION -->

    @if ($downloadApp)
        <section class="w-full px-4 md:px-8 lg:px-16 mt-24 flex justify-center">
            <div class="max-w-[1600px] w-full">

                <div x-data="{ visible: false }" x-intersect.half="visible = true"
                    :class="{ 'animate-section animated': visible }"
                    class="grid md:grid-cols-2 bg-[#F5F7FB] rounded-[30px] overflow-hidden shadow-sm">

                    <!-- LEFT TEXT -->
                    <div class="p-8 md:p-12 lg:p-16 flex flex-col justify-center">

                        <!-- Badge -->
                        @if ($downloadApp->title)
                            <div>
                                <span x-data="{ show: false }" x-intersect.half="show = true"
                                    :class="{ 'animated': show }"
                                    class="fade-up inline-block bg-[#0939a4] text-white px-5 py-2 rounded-full text-sm font-medium mb-6">
                                    {{ $downloadApp->title }}
                                </span>
                            </div>
                        @endif

                        <!-- Heading -->
                        @if ($downloadApp->heading)
                            <h2 x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                                class="fade-up delay-100 text-2xl md:text-3xl lg:text-4xl font-bold text-[#0939a4] leading-snug mb-4">
                                {!! nl2br(e($downloadApp->heading)) !!}
                            </h2>
                        @endif

                        <!-- Description -->
                        @if ($downloadApp->description)
                            <p x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                                class="fade-up delay-200 text-gray-600 text-sm md:text-base max-w-md mb-8">
                                {{ $downloadApp->description }}
                            </p>
                        @endif

                        <!-- Store Buttons (STATIC for now) -->
                        <div x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                            class="fade-up delay-300 flex flex-wrap gap-4">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                                class="h-12 cursor-pointer" alt="Google Play">

                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                                class="h-12 cursor-pointer" alt="App Store">
                        </div>

                    </div>

                    <!-- RIGHT IMAGE -->
                    <div class="relative overflow-hidden h-[450px]">
                        @if ($downloadApp->getFirstMediaUrl('image'))
                            <img x-data="{ show: false }" x-intersect.half="show = true" :class="{ 'animated': show }"
                                class="zoom-in delay-200 w-full h-full object-cover object-center"
                                src="{{ $downloadApp->getFirstMediaUrl('image') }}" alt="Download App">
                        @endif
                    </div>

                </div>

            </div>
        </section>
    @endif
<script>
    let index = 0;
    const track = document.getElementById('sliderTrack');
    const dotsBox = document.getElementById('dotsContainer');
    const allCards = document.querySelectorAll('.testimonial-card');

    function getCPV() {
        if (window.innerWidth >= 1024) return 3;
        if (window.innerWidth >= 768) return 2;
        return 1;
    }

    function render() {
        const cpv = getCPV();
        const movePercent = 100 / cpv;
        track.style.transform = `translateX(-${index * movePercent}%)`;
        
        // Dots Update
        dotsBox.innerHTML = '';
        const totalDots = allCards.length - cpv + 1;
        for (let i = 0; i < totalDots; i++) {
            const d = document.createElement('div');
            d.className = `dot ${i === index ? 'active' : ''}`;
            d.onclick = () => { index = i; render(); };
            dotsBox.appendChild(d);
        }
    }

    function moveSlide(step) {
        const cpv = getCPV();
        const max = allCards.length - cpv;
        index += step;
        if (index < 0) index = max;
        if (index > max) index = 0;
        render();
    }

    window.addEventListener('resize', render);
    render();
</script>


@endsection
<!--Testimonial Scripts-->



