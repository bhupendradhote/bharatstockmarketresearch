@extends('layouts.userdashboard')

@section('content')
    <div x-data="profileHandler()" class="bg-[#f8fafc] min-h-screen">
        
        {{-- Main Card Container --}}
        <div class="max-w-7xl mx-auto bg-white rounded-[24px] border border-gray-100 shadow-sm p-6 md:p-8 relative">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl flex items-center gap-2 text-sm font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- Header Section --}}
                <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <a href="{{ url('settings') }}"
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-50 text-gray-500 hover:bg-gray-100 hover:text-[#0939a4] transition-all border border-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>

                        <div>
                            <h1 class="text-2xl font-black text-[#0939a4]">Edit Profile</h1>
                            <p class="text-xs text-gray-400 font-medium">Update your personal details</p>
                        </div>
                    </div>

                    <button type="submit"
                        class="bg-[#0939a4] hover:bg-blue-800 text-white text-xs font-bold px-6 py-3 rounded-xl shadow-lg shadow-blue-100 transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        Save Changes
                    </button>
                </div>

                {{-- Image Upload Section --}}
                <div class="flex items-center gap-6 mb-10">
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-full p-1 border-2 border-dashed border-[#0939a4]/30">
                            <img :src="imageUrl" class="w-full h-full rounded-full object-cover">
                        </div>
                        
                        <label class="absolute bottom-0 right-0 bg-[#0939a4] text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-800 transition shadow-md border-2 border-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                            </svg>
                            <input type="file" name="profile_image" class="hidden" @change="fileChosen">
                        </label>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Profile Photo</p>
                        <p class="text-[10px] text-gray-400 mt-1">Accepts JPG, PNG or GIF.</p>
                    </div>
                </div>

                {{-- Form Fields Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    
                    <div class="space-y-1">
                        <label class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-700 outline-none focus:border-[#0939a4] focus:ring-1 focus:ring-[#0939a4] transition">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Date of Birth</label>
                        <input type="date" name="dob"
                            value="{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '' }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-700 outline-none focus:border-[#0939a4] focus:ring-1 focus:ring-[#0939a4] transition">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Email (Verified)</label>
                        <div class="flex gap-2 relative">
                            <input type="email" value="{{ $user->email }}" disabled
                                class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-500 cursor-not-allowed">
                            <button type="button" @click="initOtp('email')"
                                class="absolute right-2 top-2 bottom-2 px-3 bg-blue-50 text-[#0939a4] hover:bg-[#0939a4] hover:text-white rounded-lg font-bold text-[10px] transition-colors border border-blue-100">
                                Change
                            </button>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Phone Number</label>
                        <div class="flex gap-2 relative">
                            <input type="text" value="{{ $user->phone }}" disabled
                                class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-500 cursor-not-allowed">
                            <button type="button" @click="initOtp('phone')"
                                class="absolute right-2 top-2 bottom-2 px-3 bg-blue-50 text-[#0939a4] hover:bg-[#0939a4] hover:text-white rounded-lg font-bold text-[10px] transition-colors border border-blue-100">
                                Change
                            </button>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">City</label>
                        <input type="text" name="city" value="{{ $user->city }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-700 outline-none focus:border-[#0939a4] focus:ring-1 focus:ring-[#0939a4] transition">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Pincode</label>
                        <input type="text" name="pincode" value="{{ $user->pincode }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-700 outline-none focus:border-[#0939a4] focus:ring-1 focus:ring-[#0939a4] transition">
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-[10px] text-gray-400 font-bold tracking-wider uppercase">Full Address</label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-700 outline-none focus:border-[#0939a4] focus:ring-1 focus:ring-[#0939a4] transition resize-none">{{ $user->address }}</textarea>
                    </div>
                </div>
            </form>
        </div>

        {{-- OTP Modal --}}
        <div x-show="modal.open" x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            
            <div @click.away="modal.open = false" 
                class="bg-white p-6 md:p-8 rounded-[24px] w-full max-w-md shadow-2xl relative transform transition-all"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100">

                <button @click="modal.open = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h2 class="text-xl font-black text-center mb-1 text-[#0939a4]"
                    x-text="modal.type === 'email' ? 'Change Email' : 'Update Phone'"></h2>
                <p class="text-xs text-center text-gray-400 mb-6">Verify your new contact details</p>

                <div x-show="errorMessage" x-transition
                    class="mb-4 p-3 bg-red-50 border border-red-100 text-red-600 text-xs font-bold rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span x-text="errorMessage"></span>
                </div>

                {{-- Step 1: Input --}}
                <div x-show="modal.step === 1" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-[10px] text-gray-400 font-bold tracking-wider uppercase" x-text="modal.type === 'email' ? 'New Email Address' : 'New Phone Number'"></label>
                        {{-- 🎨 Custom Background Color applied here --}}
                        <input type="text" x-model="modal.targetValue"
                            :placeholder="modal.type === 'email' ? 'Enter new email' : 'Enter new phone number'"
                            class="w-full px-4 py-3 border border-blue-100 rounded-xl outline-none focus:border-[#0939a4] text-sm font-bold text-gray-700 bg-[#0015ff0f]">
                    </div>

                    <button @click="sendOtpRequest()" :disabled="loading"
                        class="w-full py-3 bg-[#0939a4] hover:bg-blue-800 text-white rounded-xl font-bold text-sm disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2 shadow-lg shadow-blue-100">
                        <span x-show="!loading">Send OTP</span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Sending...
                        </span>
                    </button>
                </div>

                {{-- Step 2: OTP Verification --}}
                <div x-show="modal.step === 2" class="space-y-5">
                    <p class="text-sm text-center text-gray-600 bg-gray-50 py-2 rounded-lg border border-gray-100">
                        Code sent to <b class="text-[#0939a4]" x-text="modal.targetValue"></b>
                    </p>
                    
                    <div class="space-y-1">
                        <label class="text-[10px] text-gray-400 font-bold tracking-wider uppercase text-center w-full block">Enter OTP</label>
                        {{-- 🎨 Custom Background Color applied here --}}
                        <input type="text" x-model="modal.otpCode" placeholder="0 0 0 0 0 0" maxlength="6"
                            class="w-full text-center text-3xl tracking-[0.5em] font-black py-3 border border-blue-100 rounded-xl outline-none focus:border-[#0939a4] text-[#0939a4] bg-[#0015ff0f]">
                    </div>

                    <button @click="verifyOtpRequest()" :disabled="loading"
                        class="w-full py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-sm disabled:opacity-50 transition flex items-center justify-center gap-2 shadow-lg shadow-green-100">
                        <span x-show="!loading">Verify & Update</span>
                        <span x-show="loading" class="flex items-center gap-2">
                             <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verifying...
                        </span>
                    </button>
                    
                    <button @click="modal.step = 1; errorMessage = ''"
                        class="w-full text-xs text-gray-400 font-bold hover:text-[#0939a4] transition-colors">
                        Entered wrong info? Go Back
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function profileHandler() {
            return {
                imageUrl: '{{ $user->getFirstMediaUrl('profile_image') ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}',
                loading: false,
                errorMessage: '',
                modal: {
                    open: false,
                    type: '',
                    step: 1,
                    targetValue: '',
                    otpCode: ''
                },

                initOtp(type) {
                    this.errorMessage = '';
                    this.modal = {
                        open: true,
                        type: type,
                        step: 1,
                        targetValue: '',
                        otpCode: ''
                    };
                },

                async sendOtpRequest() {
                    this.loading = true;
                    this.errorMessage = '';
                    try {
                        let res = await fetch("{{ route('profile.sendOtp') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                type: this.modal.type,
                                value: this.modal.targetValue
                            })
                        });
                        let data = await res.json();
                        if (res.ok && data.success) {
                            this.modal.step = 2;
                        } else {
                            this.errorMessage = data.message || "Failed to send OTP. Please try again.";
                        }
                    } catch (e) {
                        this.errorMessage = "Connection error. Please try again.";
                    } finally {
                        this.loading = false;
                    }
                },

                async verifyOtpRequest() {
                    this.loading = true;
                    this.errorMessage = '';
                    try {
                        let res = await fetch("{{ route('profile.verifyOtp') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                type: this.modal.type,
                                otp: this.modal.otpCode
                            })
                        });
                        let data = await res.json();
                        if (res.ok && data.success) {
                            window.location.reload();
                        } else {
                            this.errorMessage = data.message || "Invalid OTP code.";
                        }
                    } catch (e) {
                        this.errorMessage = "Verification failed. Please try again.";
                    } finally {
                        this.loading = false;
                    }
                },

                fileChosen(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = (e) => this.imageUrl = e.target.result;
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection