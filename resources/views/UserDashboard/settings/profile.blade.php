@extends('layouts.userdashboard')

@section('content')
    <div class="bg-[#f8fafc] min-h-screen" x-data="{
        showUpgradeModal: false,
        
        {{-- 🖼️ IMAGE MODAL STATE --}}
        showImageModal: false,
        modalImageSrc: '',
        modalTitle: '',
        modalType: '', 

        currentPlan: '{{ $currentPlan }}',
        daysRemaining: '{{ $daysRemaining ? $daysRemaining . ' Days' : '0 Days' }}',
        validityTill: '{{ $validityTill ?? 'Not Active' }}',
    
        // 🔐 KYC FLAGS
        isKycCompleted: {{ $isKycCompleted ? 'true' : 'false' }},
        kycStatus: '{{ strtoupper(str_replace('_', ' ', $kycStatus)) }}'
    }">

        <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-5 md:p-8 max-w-7xl mx-auto relative">

            <div class="absolute top-6 right-6">
                <a href="{{ url('profile/edit') }}"
                    class="inline-flex items-center gap-1 bg-white border border-gray-200 text-gray-600 text-[10px] font-bold px-4 py-2 rounded-xl hover:bg-gray-50 hover:text-[#0939a4] transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                        <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                        <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                    </svg>
                    Edit Profile
                </a>
            </div>

            <div class="flex items-center gap-5 mb-10">
                <div class="w-20 h-20 rounded-full bg-gray-100 ring-4 ring-white shadow-md overflow-hidden">
                    <img src="{{ auth()->user()->getFirstMediaUrl('profile_image') ?: 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . auth()->user()->id }}"
                        alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-[#0939a4] tracking-tight">
                        {{ auth()->user()->name }}
                    </h1>
                    <span class="inline-block mt-1 px-2 py-0.5 bg-blue-50 text-[#0939a4] text-[10px] font-bold rounded">
                        {{ auth()->user()->city }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-y-6 gap-x-4 mb-10 pb-8 border-b border-gray-100">
                
                {{-- Standard Fields --}}
                <div class="space-y-1">
                    <p class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">User ID</p>
                    <p class="text-xs font-bold text-gray-700 font-mono">{{ auth()->user()->bsmr_id }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Email</p>
                    <p class="text-xs font-bold text-gray-700 truncate" title="{{ auth()->user()->email }}">{{ auth()->user()->email }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Phone</p>
                    <p class="text-xs font-bold text-gray-700 font-mono">{{ auth()->user()->phone ?? '-' }}</p>
                </div>

                @php
                    // --- LOGIC TO EXTRACT KYC DATA & IMAGES ---
                    $kyc = \App\Models\KycVerification::where('user_id', auth()->id())
                        ->where('status', 'approved')
                        ->latest()
                        ->first();

                    $aadhaar = 'Not Verified';
                    $pan = 'Not Verified';
                    $aadhaarImage = null;
                    $panImage = null;

                    if ($kyc && !empty($kyc->raw_response)) {
                        $raw = $kyc->raw_response;
                        // Data extraction based on Digio structure
                        $digioDetails = $raw['actions'][0]['details'] ?? null;

                        if ($digioDetails) {
                            // 1. Aadhaar
                            if (isset($digioDetails['aadhaar']['id_number'])) {
                                $aadhaar = 'XXXX XXXX ' . substr($digioDetails['aadhaar']['id_number'], -4);
                            }
                            if (isset($digioDetails['aadhaar']['image'])) {
                                $aadhaarImage = 'data:image/jpeg;base64,' . $digioDetails['aadhaar']['image'];
                            }

                            // 2. PAN
                            if (isset($digioDetails['pan']['id_number'])) {
                                $pan = 'XXXXXX' . substr($digioDetails['pan']['id_number'], -4);
                            }
                            if (isset($digioDetails['pan']['image'])) {
                                $panImage = 'data:image/jpeg;base64,' . $digioDetails['pan']['image'];
                            }
                        }
                    }

                    // Fallback for PAN number from User table
                    if ($pan == 'Not Verified' && auth()->user()->pan_card) {
                        $pan = 'XXXXXX' . substr(auth()->user()->pan_card, -4);
                    }
                @endphp

                <div class="space-y-1">
                    <p class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">PAN Number</p>
                    <div class="flex items-center gap-2">
                        <p class="text-xs font-bold text-gray-700 font-mono tracking-wide">{{ $pan }}</p>
                        
                        @if($panImage)
                            <button @click="showImageModal = true; modalImageSrc = '{{ $panImage }}'; modalTitle = 'PAN Card Preview'; modalType='pan'" 
                                class="text-gray-400 hover:text-[#0939a4] transition-colors p-1 hover:bg-gray-100 rounded-full cursor-pointer" 
                                title="View PAN Card">
                                {{-- EYE ICON --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Aadhaar Number</p>
                    <div class="flex items-center gap-2">
                        <p class="text-xs font-bold text-gray-700 font-mono tracking-wide">{{ $aadhaar }}</p>

                        @if($aadhaarImage)
                            <button @click="showImageModal = true; modalImageSrc = '{{ $aadhaarImage }}'; modalTitle = 'Aadhaar Card Preview'; modalType='aadhaar'" 
                                class="text-gray-400 hover:text-[#0939a4] transition-colors p-1 hover:bg-gray-100 rounded-full cursor-pointer" 
                                title="View Aadhaar Card">
                                {{-- EYE ICON --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                    <h3 class="text-sm font-bold mb-3 text-gray-800">Plan Status</h3>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs text-gray-500 font-medium">Days Left</span>
                        <b class="text-xs text-[#0939a4]" x-text="daysRemaining"></b>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs text-gray-500 font-medium">Valid Till</span>
                        <b class="text-xs text-gray-800" x-text="validityTill"></b>
                    </div>
                    <div class="pt-3 border-t border-gray-200 flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-500">KYC STATUS</span>
                        <span class="text-[10px] font-black px-2 py-1 rounded-md uppercase tracking-wide" 
                            :class="isKycCompleted ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                            x-text="kycStatus">
                        </span>
                    </div>
                </div>

                <div class="flex flex-col items-center justify-center p-4 border-x border-gray-100">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Current Plan</p>
                    <h2 class="text-2xl font-black text-[#0939a4] mb-4" x-text="currentPlan"></h2>

                    <button @click="isKycCompleted ? showUpgradeModal = true : null" :disabled="!isKycCompleted"
                        class="w-full max-w-[180px] py-2.5 rounded-xl text-[10px] font-bold text-white shadow-sm transition-transform active:scale-95"
                        :class="isKycCompleted ? 'bg-[#0939a4] hover:bg-blue-800' : 'bg-gray-300 cursor-not-allowed'">
                        Upgrade Plan
                    </button>

                    <p x-show="!isKycCompleted" class="text-[9px] text-red-500 mt-2 font-bold flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                        Complete KYC to upgrade
                    </p>
                </div>

                <div class="flex items-center justify-center p-4">
                    
                    {{-- UNVERIFIED STATE --}}
                    <a href="{{ url('/settings/kyc') }}" x-show="!isKycCompleted"
                        class="flex flex-col items-center gap-2 bg-red-50 text-red-600 px-6 py-4 rounded-2xl border border-red-100 hover:bg-red-100 transition-colors w-full text-center">
                        <div class="w-8 h-8 rounded-full bg-red-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 3.414L15.172 6.586A2 2 0 0116 8.828V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold">Complete KYC Verification</span>
                    </a>
                    
                    {{-- VERIFIED STATE (IMPROVED UI) --}}
                    <div x-show="isKycCompleted" class="w-full flex flex-col items-center justify-center p-6 bg-emerald-50 rounded-2xl border border-emerald-100 h-full group transition-all">
                        <div class="relative mb-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        <h4 class="text-emerald-900 font-bold text-sm">Account Verified</h4>
                        <p class="text-emerald-600 text-[10px] font-medium mt-1">Full Access Granted</p>
                    </div>

                </div>
            </div>
            
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 pt-8 border-t border-gray-100">
                 <a @if ($isKycCompleted) href="{{ url('/payment-invoice') }}" @else href="javascript:void(0)" onclick="alert('Please complete your KYC first.')" @endif
                    class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group"
                    :class="!isKycCompleted && 'opacity-60 cursor-not-allowed bg-gray-50'">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-800">Payments & Invoices</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Transactions history</p>
                    </div>
                </a>

                <a href="" class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-orange-50 text-orange-600 group-hover:scale-110 transition-transform">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-800">KYC Documents</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">View uploaded docs</p>
                    </div>
                </a>

                <a href="" class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-800">Help & Support</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Contact us</p>
                    </div>
                </a>
            </div>
        </div>

        <div x-show="showUpgradeModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity">
            <div class="bg-white rounded-[24px] w-full max-w-5xl p-6 max-h-[85vh] overflow-y-auto relative shadow-2xl"
                @click.away="showUpgradeModal = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100">

                <button @click="showUpgradeModal = false" class="absolute top-6 right-6 text-gray-400 hover:text-gray-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h2 class="text-xl font-bold mb-6 text-gray-800">Select Subscription Plan</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($plans as $plan)
                        @php $durations = $plan->durations->values(); @endphp
                        <div class="border border-gray-200 rounded-[20px] p-5 hover:shadow-lg transition-all duration-300 flex flex-col h-full bg-white group hover:border-blue-200" x-data="{ activeIndex: 0 }">
                            <h3 class="text-sm font-bold mb-4 text-gray-700 group-hover:text-[#0939a4]">{{ $plan->name }}</h3>
                            <div class="mb-6">
                                <span class="text-2xl font-black text-gray-900">₹{{ $durations[0]->price }}</span>
                                <p class="text-[10px] text-gray-400 font-medium">Inclusive of GST</p>
                            </div>
                            <a @if ($isKycCompleted) href="{{ route('subscription.confirm') }}?plan={{ $plan->id }}&duration=0" @else href="javascript:void(0)" @endif
                                class="w-full text-center py-2.5 rounded-xl text-xs font-bold text-white mt-auto transition-transform active:scale-95 shadow-md"
                                @class([
                                    'bg-[#0939a4] hover:bg-blue-800' => $isKycCompleted,
                                    'bg-gray-300 cursor-not-allowed' => !$isKycCompleted,
                                ])>
                                {{ $isKycCompleted ? 'Buy Now' : 'KYC Required' }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div x-show="showImageModal" x-cloak 
            class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 backdrop-blur-md p-4 transition-opacity"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            
            <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl transform transition-all" 
                 @click.away="showImageModal = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 text-sm" x-text="modalTitle"></h3>
                    <button @click="showImageModal = false" class="text-gray-400 hover:text-red-500 transition-colors bg-gray-50 rounded-full p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-8 flex flex-col items-center justify-center bg-gray-50/50 min-h-[300px]">
                    <div class="relative rounded-lg shadow-sm border border-gray-200 bg-white p-2">
                         <img :src="modalImageSrc" alt="Document Preview" class="max-w-full max-h-[50vh] object-contain rounded">
                    </div>
                </div>

                <div class="p-4 border-t border-gray-100 flex justify-end bg-gray-50">
                    <a :href="modalImageSrc" :download="modalTitle + '.jpg'" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#0939a4] text-white text-xs font-bold rounded-lg hover:bg-blue-800 transition-colors shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M12 12.75l-3.3-3.3m0 0L5.25 12.75M12 12.75V3" />
                        </svg>
                        Download Image
                    </a>
                </div>
            </div>
        </div>

    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #d1d5db; 
            border-radius: 10px;
        }
    </style>
@endsection