



@extends('layouts.userdashboard')

@section('content')
    <div class="bg-[#f8fafc]" x-data="{
        showUpgradeModal: false,
        currentPlan: '{{ $currentPlan }}',
        daysRemaining: '{{ $daysRemaining ? $daysRemaining . ' Days' : '-' }}',
        validityTill: '{{ $validityTill }}',
        kycStatus: '{{ auth()->user()->kyc_status ?? 'Not Completed' }}',
    
        /* 🔒 SAFETY DEFAULTS (FIXES ALL ERRORS) */
        activeIndex: 0,
        prices: [],
        labels: []
    }">

        <!-- ================= PROFILE CARD ================= -->
        <div class="bg-white rounded-[24px] border shadow-sm p-4 md:p-8 max-w-9xl mx-auto relative">

            <div class="absolute top-6 right-6">
                <button class="bg-[#0939a4] hover:bg-blue-800 text-white text-[9px] font-bold px-4 py-1.5 rounded-lg">
                    Edit Profile
                </button>
            </div>

            <div class="flex items-center gap-4 mb-8">
                <div class="w-20 h-20 rounded-full bg-[#0939a4] hover:bg-blue-800 overflow-hidden">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ auth()->user()->id }}"
                        class="w-full h-full object-cover">
                </div>
                <h1 class="text-2xl font-bold text-[#0939a4]">
                    {{ auth()->user()->name }}
                </h1>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10 pb-8 border-b">
                <div>
                    <p class="text-[10px] text-gray-400 font-semibold">USER ID</p>
                    <p class="text-xs font-bold">{{ auth()->user()->id }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-semibold">EMAIL</p>
                    <p class="text-xs font-bold truncate">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-semibold">PHONE</p>
                    <p class="text-xs font-bold">{{ auth()->user()->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-semibold">PAN</p>
                    <p class="text-xs font-bold">******</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-semibold">AADHAR</p>
                    <p class="text-xs font-bold">**** ****</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-sm font-bold mb-2">Plan Details</h3>
                    <p class="text-xs">Validity: <b x-text="daysRemaining"></b></p>
                    <p class="text-xs">Valid Till: <b x-text="validityTill"></b></p>
                    <p class="text-xs">
                        KYC:
                        <span x-text="kycStatus"
                            :class="kycStatus === 'Completed' ? 'text-green-600' : 'text-red-600'"></span>
                    </p>
                </div>

                <div class="flex flex-col items-center justify-center border-x">
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Current Plan</p>
                    <h2 class="text-xl font-black" x-text="currentPlan"></h2>

                    <button @click="showUpgradeModal = true"
                        class="mt-3 bg-[#0939a4] hover:bg-blue-800 text-white text-[9px] font-bold px-4 py-2 rounded-lg">
                        Upgrade Plan
                    </button>
                </div>

                <div class="flex items-center justify-center">
                    <a href="{{ url('/settings/kyc') }}" x-show="kycStatus !== 'Completed'"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg text-[9px] font-bold">
                        Complete KYC
                    </a>
                </div>
            </div>
             <div class="mt-10 grid grid-cols-2 gap-4">
                 <a href="/payment-invoice">
                     
                
                <div
                    class="flex items-center gap-2 text-gray-600 hover:text-[#0939a4] cursor-pointer group transition-colors">
                    <div class="w-6 h-6 flex items-center justify-center bg-gray-50 rounded group-hover:bg-blue-50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-tight">Payment & Invoices</span>
                </div>
                 </a>
                <div
                    class="flex items-center gap-2 text-gray-600 hover:text-[#0939a4] cursor-pointer group transition-colors">
                    <div class="w-6 h-6 flex items-center justify-center bg-gray-50 rounded group-hover:bg-blue-50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-tight">KYC & Agreement</span>
                </div>
                <div
                    class="flex items-center gap-2 text-gray-600 hover:text-[#0939a4] cursor-pointer group transition-colors">
                    <div class="w-6 h-6 flex items-center justify-center bg-gray-50 rounded group-hover:bg-blue-50">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-tight">Support</span>
                </div>
                <div class="flex items-center gap-2 text-red-500 hover:text-red-700 cursor-pointer group transition-colors">
                    <div class="w-6 h-6 flex items-center justify-center bg-red-50 rounded group-hover:bg-red-100">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-tight">Delete Account</span>
                </div>
            </div>
        </div>

        <!-- ================= UPGRADE MODAL ================= -->
        <div x-show="showUpgradeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">

            <div class="bg-white rounded-[24px] w-full max-w-5xl p-6 max-h-[85vh] overflow-y-auto relative"
                @click.away="showUpgradeModal = false">

                <button @click="showUpgradeModal = false" class="absolute top-6 right-6 text-gray-400 hover:text-gray-900">
                    ✕
                </button>

                <h2 class="text-xl font-bold mb-6">Choose a Plan</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    @foreach ($plans as $plan)
                        @php
                            $durations = $plan->durations->values();
                        @endphp

                        <div class="relative pt-4"
                            x-data='{
            activeIndex: 0,
            prices: @json($durations->pluck('price')),
            labels: @json($durations->pluck('duration'))
         }'>

                            @if ($plan->featured)
                                <div
                                    class="absolute top-0 left-0 right-0 bg-[#0939a4] hover:bg-blue-800 text-white text-[8px] font-bold py-1 rounded-t-xl text-center">
                                    Recommended
                                </div>
                            @endif

                            <div class="border rounded-[20px] p-4 shadow-sm bg-white flex flex-col h-full">

                                <h3 class="text-sm font-bold mb-3">{{ $plan->name }}</h3>

                                <!-- PRICE -->
                                <div class="mb-4">
                                    <span class="text-lg font-black" x-text="'₹' + prices[activeIndex]"></span>
                                    <p class="text-[9px] text-gray-400">Incl. GST</p>
                                </div>

                                <!-- DURATIONS -->
                                <div class="flex gap-1 mb-4">
                                    @foreach ($durations as $i => $duration)
                                        <button type="button" @click="activeIndex = {{ $i }}"
                                            class="flex-1 py-1 rounded-md text-[8px] font-bold transition"
                                            :class="activeIndex === {{ $i }} ?
                                                'bg-[#0939a4] hover:bg-blue-800 text-white' :
                                                'border border-gray-100 text-gray-400'">
                                            {{ $duration->duration }}
                                        </button>
                                    @endforeach
                                </div>

                                <!-- FEATURES -->
                                <div class="space-y-2 mb-6 flex-grow">
                                    <p class="text-[8px] font-bold text-gray-300 uppercase border-b pb-1">
                                        Features
                                    </p>
                                    @foreach ($durations->first()->features as $feature)
                                        <div class="flex justify-between text-[10px] font-bold">
                                            <span class="text-gray-500">{{ $feature->text }}</span>
                                            <span>{!! $feature->svg_icon ?? '✔' !!}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- PURCHASE -->
                                <a :href="'{{ route('subscription.confirm') }}?plan={{ $plan->id }}&duration=' + activeIndex"
                                    class="w-full text-center bg-[#0939a4] hover:bg-blue-800 hover:bg-blue-500 text-white py-2 rounded-lg text-xs font-bold">
                                    Purchase
                                </a>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
