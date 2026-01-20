@extends('layouts.userdashboard')

@section('content')
    <div x-data="profileHandler()" class="bg-[#f8fafc] min-h-screen">
        <div class="max-w-9xl mx-auto bg-white rounded-3xl border border-gray-200 shadow-sm p-6 md:p-10">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center justify-between mb-10">
                    <div class="flex items-center gap-4">
                        <a href="{{ url('settings') }}"
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition-all border border-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>

                        <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-100 transition">
                        Save Changes
                    </button>
                </div>

                <div class="flex items-center gap-6 mb-12 bg-gray-50 p-6 rounded-2xl border border-dashed border-gray-300">
                    <div class="relative">
                        <img :src="imageUrl"
                            class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-md">
                        <label
                            class="absolute bottom-0 right-0 bg-blue-600 text-white w-9 h-9 rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-700 transition">
                            <span>✎</span>
                            <input type="file" name="profile_image" class="hidden" @change="fileChosen">
                        </label>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-700">Profile Photo</p>
                        <p class="text-xs text-gray-400">Update your avatar here.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-600">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 outline-none focus:border-blue-500 transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-600">Date of Birth</label>
                        <input type="date" name="dob"
                            value="{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '' }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 outline-none focus:border-blue-500 transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-600">Email (Verified)</label>
                        <div class="flex gap-2">
                            <input type="email" value="{{ $user->email }}" disabled
                                class="flex-1 px-4 py-3 bg-gray-100 rounded-xl text-gray-500">
                            <button type="button" @click="initOtp('email')"
                                class="px-4 py-2 bg-blue-100 text-blue-700 rounded-xl font-bold text-sm hover:bg-blue-200">Change</button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-600">Phone Number</label>
                        <div class="flex gap-2">
                            <input type="text" value="{{ $user->phone }}" disabled
                                class="flex-1 px-4 py-3 bg-gray-100 rounded-xl text-gray-500">
                            <button type="button" @click="initOtp('phone')"
                                class="px-4 py-2 bg-red-100 text-red-700 rounded-xl font-bold text-sm hover:bg-red-200">Update</button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-600">City</label>
                        <input type="text" name="city" value="{{ $user->city }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 outline-none focus:border-blue-500 transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-600">Pincode</label>
                        <input type="text" name="pincode" value="{{ $user->pincode }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 outline-none focus:border-blue-500 transition">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-semibold text-gray-600">Full Address</label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 outline-none focus:border-blue-500 transition">{{ $user->address }}</textarea>
                    </div>
                </div>
            </form>
        </div>

        <div x-show="modal.open" x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div @click.away="modal.open = false" class="bg-white p-8 rounded-3xl w-full max-w-md shadow-2xl relative">

                <h2 class="text-xl font-bold text-center mb-4"
                    x-text="modal.type === 'email' ? 'Change Email' : 'Update Phone'"></h2>

                <div x-show="errorMessage" x-transition
                    class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs rounded-r-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span x-text="errorMessage"></span>
                </div>

                <div x-show="modal.step === 1" class="space-y-4">
                    <input type="text" x-model="modal.targetValue"
                        :placeholder="modal.type === 'email' ? 'Enter new email' : 'Enter new phone number'"
                        class="w-full px-4 py-3 border rounded-xl outline-none focus:border-blue-500">
                    <button @click="sendOtpRequest()" :disabled="loading"
                        class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold disabled:opacity-50 transition flex items-center justify-center">
                        <span x-show="!loading">Send OTP</span>
                        <span x-show="loading">Sending...</span>
                    </button>
                </div>

                <div x-show="modal.step === 2" class="space-y-4">
                    <p class="text-sm text-center text-gray-500">Enter code sent to <br><b x-text="modal.targetValue"></b>
                    </p>
                    <input type="text" x-model="modal.otpCode" placeholder="000000"
                        class="w-full text-center text-3xl tracking-widest font-bold py-3 border rounded-xl outline-none">
                    <button @click="verifyOtpRequest()" :disabled="loading"
                        class="w-full py-3 bg-green-600 text-white rounded-xl font-bold disabled:opacity-50 transition flex items-center justify-center">
                        <span x-show="!loading">Verify & Save</span>
                        <span x-show="loading">Verifying...</span>
                    </button>
                    <button @click="modal.step = 1; errorMessage = ''"
                        class="w-full text-xs text-blue-600 underline">Incorrect info? Go
                        back</button>
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
                            // Show error inside modal instead of alert
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
                            // Show error inside modal instead of alert
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
