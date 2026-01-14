@extends('layouts.userdashboard')

@section('content')
    <div class="bg-[#f8fafc] flex  justify-center" x-data="{
        step: 'start',
        contactMethod: '',
        // Progress bar configuration
        steps: [
            { id: 'contact', label: 'Verify Contact' },
            { id: 'pan', label: 'PAN' },
            { id: 'aadhaar', label: 'Aadhaar' },
            { id: 'photo', label: 'Photo' },
            { id: 'agreement', label: 'Agreement' },
            { id: 'esign', label: 'eSign' }
        ],
        getCurrentIndex() {
            if (['start'].includes(this.step)) return -1;
            if (['contact_choice', 'mobile_input', 'email_input', 'otp_verify'].includes(this.step)) return 0;
            if (['pan_input', 'pan_details'].includes(this.step)) return 1;
            if (['aadhaar_input'].includes(this.step)) return 2;
            if (['photo_upload'].includes(this.step)) return 3;
            if (['agreement_view'].includes(this.step)) return 4;
            if (['esign_process', 'complete'].includes(this.step)) return 5;
            return 0;
        }
    }">

        <div
            class="w-full max-w-9xl bg-white rounded-[24px] border border-gray-100 shadow-sm p-8 md:p-12 relative overflow-hidden">

            <button x-show="step !== 'start' && step !== 'complete'" @click="window.history.back()"
                class="absolute top-8 left-8 p-1.5 hover:bg-gray-50 rounded-lg border border-gray-100 transition-colors">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <div x-show="step !== 'start' && step !== 'complete'"
                class="flex items-center justify-between mb-12 max-w-md mx-auto relative">
                <div class="absolute top-4 left-0 w-full h-[1px] bg-gray-100 -z-0"></div>
                <template x-for="(s, index) in steps">
                    <div class="flex flex-col items-center gap-2 z-10 bg-white px-2">
                        <div :class="index <= getCurrentIndex() ? 'bg-[#0939a4] border-blue-600' : 'bg-gray-200 border-gray-200'"
                            class="w-3 h-3 rounded-full border-2 transition-colors duration-300">
                            <template x-if="index < getCurrentIndex()">
                                <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                                </svg>
                            </template>
                        </div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter"
                            :class="index === getCurrentIndex() ? 'text-blue-600' : ''" x-text="s.label"></span>
                    </div>
                </template>
            </div>

            <div x-show="step === 'start'" class="text-center space-y-6">
                <h2 class="text-xl font-bold text-gray-900">Complete your KYC</h2>
                <button @click="step = 'contact_choice'"
                    class="w-full max-w-xs mx-auto bg-[#0939a4] hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-all text-[10px] uppercase tracking-[0.2em] shadow-lg shadow-blue-100">
                    Start KYC
                </button>
                <p class="text-[10px] text-gray-400 max-w-xs mx-auto leading-relaxed uppercase tracking-tight">
                    KYC is mandatory to activate your subscription and unlock market calls.
                </p>
                <div class="pt-8 border-t border-gray-50">
                    <a href="#"
                        class="text-[10px] font-bold text-gray-400 hover:text-blue-600 transition-colors uppercase tracking-widest">Need
                        Help? Contact Support</a>
                </div>
            </div>

            <div x-show="step === 'contact_choice'" class="text-center space-y-8">
                <h2 class="text-lg font-bold text-gray-900">Choose Phone Number or Email<br><span
                        class="text-gray-400 font-medium">to Verify Contact details</span></h2>
                <div class="space-y-3 max-w-xs mx-auto">
                    <button @click="step = 'mobile_input'"
                        class="w-full bg-[#0939a4] text-white py-3.5 rounded-xl font-bold text-[10px] uppercase tracking-widest">Phone
                        Number</button>
                    <button @click="step = 'email_input'"
                        class="w-full bg-[#0939a4] text-white py-3.5 rounded-xl font-bold text-[10px] uppercase tracking-widest">Email</button>
                </div>
            </div>

            <div x-show="step === 'mobile_input' || step === 'email_input'" class="text-center space-y-6">
                <h2 class="text-lg font-bold text-gray-900"
                    x-text="step === 'mobile_input' ? 'Enter Mobile Number' : 'Enter Email Address'"></h2>
                <div class="max-w-sm mx-auto space-y-4">
                    <input type="text"
                        :placeholder="step === 'mobile_input' ? 'Enter Mobile Number' : 'Enter Email Address'"
                        class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3.5 text-xs font-medium focus:ring-1 focus:ring-blue-500 focus:outline-none transition-all">
                    <button @click="step = 'otp_verify'"
                        class="w-full bg-[#0939a4] text-white py-3.5 rounded-xl font-bold text-[10px] uppercase tracking-widest">Verify</button>
                </div>
            </div>

            <div x-show="step === 'otp_verify'" class="text-center space-y-6">
                <h2 class="text-lg font-bold text-gray-900">Enter OTP to Verify</h2>
                <div class="flex justify-center gap-2 max-w-sm mx-auto mb-4">
                    <template x-for="i in 6">
                        <input type="text" maxlength="1"
                            class="w-10 h-12 text-center bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:ring-1 focus:ring-blue-500 focus:outline-none">
                    </template>
                </div>
                <button @click="step = 'pan_input'"
                    class="w-full max-w-xs mx-auto bg-[#0939a4] text-white py-3.5 rounded-xl font-bold text-[10px] uppercase tracking-widest">Verify
                    OTP</button>
            </div>

            <div x-show="step === 'pan_input'" class="text-center space-y-6">
                <h2 class="text-lg font-bold text-gray-900">Enter PAN Number</h2>
                <div class="max-w-sm mx-auto space-y-4">
                    <input type="text" placeholder="PAN Number"
                        class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3.5 text-xs font-medium focus:ring-1 focus:ring-blue-500 focus:outline-none uppercase">
                    <button @click="step = 'pan_details'"
                        class="w-full bg-[#0939a4] text-white py-3.5 rounded-xl font-bold text-[10px] uppercase tracking-widest">Verify
                        PAN</button>
                </div>
            </div>

            <div x-show="step === 'pan_details'" class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-gray-900 uppercase tracking-tight">Name on PAN</label>
                        <input type="text" placeholder="Name of the PAN Holder"
                            class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-xs focus:outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-gray-900 uppercase tracking-tight">Father's Name</label>
                        <input type="text" placeholder="Father's Name"
                            class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-xs focus:outline-none">
                    </div>
                    <div class="col-span-2 space-y-1.5 pt-2">
                        <label class="text-[10px] font-bold text-gray-900 uppercase tracking-tight">Address Details</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" placeholder="Flat/Door Number"
                                class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-xs">
                            <input type="text" placeholder="Street"
                                class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-xs">
                            <input type="text" placeholder="City"
                                class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-xs">
                            <input type="text" placeholder="Pincode"
                                class="bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-xs">
                        </div>
                    </div>
                </div>
                <button @click="step = 'aadhaar_input'"
                    class="w-full bg-[#0939a4] text-white py-3.5 rounded-xl font-bold text-[10px] uppercase tracking-[0.2em]">Continue</button>
            </div>

            <div x-show="step === 'aadhaar_input'" class="text-center space-y-6">
                <h2 class="text-lg font-bold text-gray-900">Enter Aadhaar Number</h2>
                <div class="max-w-sm mx-auto space-y-4">
                    <div class="relative">
                        <input type="text" placeholder="Aadhaar Number"
                            class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3.5 text-xs font-medium focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-green-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <button @click="step = 'photo_upload'"
                        class="w-full bg-[#0939a4] text-white py-3.5 rounded-xl font-bold text-[10px] uppercase tracking-widest">Verify
                        Aadhaar</button>
                </div>
            </div>

            <div x-show="step === 'photo_upload'" class="text-center space-y-6">
                <h2 class="text-lg font-bold text-gray-900">Take a Live Photo</h2>
                <p class="text-[10px] text-gray-400 uppercase tracking-tight">Please ensure your face is clearly visible
                </p>
                <div class="max-w-xs mx-auto space-y-4">
                    <div
                        class="w-48 h-48 mx-auto bg-gray-50 border-2 border-dashed border-gray-200 rounded-full flex items-center justify-center relative overflow-hidden">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <button @click="step = 'agreement_view'"
                        class="w-full bg-[#0939a4] text-white py-3.5 rounded-xl font-bold text-[10px] uppercase tracking-widest">Capture
                        Photo</button>
                </div>
            </div>

            <div x-show="step === 'agreement_view'" class="space-y-6">
                <h2 class="text-lg font-bold text-gray-900 text-center">Service Agreement</h2>
                <div
                    class="max-h-64 overflow-y-auto p-4 bg-gray-50 border border-gray-100 rounded-xl text-[10px] text-gray-600 leading-relaxed">
                    <p class="font-bold mb-2">Terms & Conditions:</p>
                    <p>1. I hereby authorize the company to verify my details through the provided documents.</p>
                    <p class="mt-2">2. All financial advice provided is for informational purposes only.</p>
                    <p class="mt-2">3. I agree to the privacy policy and data handling guidelines of the platform.</p>
                    <p class="mt-2">4. Digital signatures provided in the next step will be legally binding.</p>
                </div>
                <div class="flex items-start gap-3 px-2">
                    <input type="checkbox" class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-tighter">I have read and agree to
                        all terms of service</label>
                </div>
                <button @click="step = 'esign_process'"
                    class="w-full bg-[#0939a4] text-white py-3.5 rounded-xl font-bold text-[10px] uppercase tracking-[0.2em]">Accept
                    & Proceed</button>
            </div>

            <div x-show="step === 'esign_process'" class="text-center space-y-6">
                <h2 class="text-lg font-bold text-gray-900">Digital eSign</h2>
                <p class="text-[10px] text-gray-400 uppercase tracking-tight">Authenticating your signature via Aadhaar OTP
                </p>
                <div class="max-w-sm mx-auto p-8 bg-gray-50 border border-gray-100 rounded-2xl">
                    <svg class="w-12 h-12 text-blue-600 mx-auto animate-pulse" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    <p class="mt-4 text-[10px] font-bold text-gray-900 uppercase">Redirecting to eSign Gateway...</p>
                </div>
                <button @click="step = 'complete'"
                    class="w-full max-w-xs mx-auto bg-[#0939a4] text-white py-3.5 rounded-xl font-bold text-[10px] uppercase tracking-widest">Complete
                    Process</button>
            </div>

            <div x-show="step === 'complete'" class="text-center space-y-6 py-8">
                <div
                    class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">KYC Submitted!</h2>
                <p class="text-[10px] text-gray-400 max-w-xs mx-auto uppercase tracking-tight">
                    Your verification is under review. You will receive an update within 24 hours.
                </p>
                <a href="/dashboard"
                    class="inline-block w-full max-w-xs bg-[#0939a4] text-white font-bold py-3.5 rounded-xl text-[10px] uppercase tracking-widest shadow-lg">
                    Back to Dashboard
                </a>
            </div>

        </div>
    </div>
@endsection
