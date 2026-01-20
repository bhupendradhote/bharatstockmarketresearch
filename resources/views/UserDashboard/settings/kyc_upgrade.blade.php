{{-- @extends('layouts.userdashboard')

@section('content')
    <div class="bg-[#f8fafc] flex justify-center min-h-screen">
        <div class="w-full max-w-3xl bg-white rounded-2xl border shadow-sm p-8 md:p-12" x-data="digioKyc()"
            x-init="init()">

            <!-- CHECK KYC STATUS -->
            <div x-show="step === 'check'" class="text-center space-y-6">
                <h2 class="text-xl font-bold">KYC Verification</h2>

                <!-- Loading -->
                <div x-show="checking" class="text-gray-600">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#0939a4] mb-2"></div>
                    <p>Checking KYC status from Digio...</p>
                </div>

                <!-- ✅ APPROVED -->
                <div x-show="kycState === 'approved' && !checking" class="space-y-4">
                    <div class="text-green-600">
                        <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>

                    <h3 class="text-lg font-bold">KYC Completed</h3>
                    <p class="text-gray-600">Your KYC has been successfully verified.</p>
                    <p class="text-sm text-gray-500" x-text="kycDetails"></p>
                </div>

                <!-- ⏳ PENDING -->
                <div x-show="kycState === 'pending' && !checking" class="space-y-4">
                    <div class="text-yellow-500">
                        <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z" />
                        </svg>
                    </div>

                    <h3 class="text-lg font-bold">KYC Submitted</h3>
                    <p class="text-gray-600">
                        Your KYC is submitted and pending approval.<br>
                        Please wait, no further action is required.
                    </p>
                    <p class="text-sm text-gray-500" x-text="kycDetails"></p>
                </div>

                <!-- ❌ NO KYC -->
                <div x-show="kycState === 'none' && !checking" class="space-y-6">
                    <p class="text-gray-600">You need to complete KYC verification to continue.</p>

                    <button @click="step = 'agreement'"
                        class="w-full max-w-xs mx-auto bg-[#0939a4] text-white py-3 rounded-xl font-bold uppercase text-[11px]">
                        Start New KYC
                    </button>
                </div>
            </div>

            <!-- AGREEMENT -->
            <div x-show="step === 'agreement'" class="space-y-6">
                <h2 class="text-lg font-bold text-center">Aadhaar Consent</h2>

                <div class="max-h-60 overflow-y-auto p-4 bg-gray-50 border rounded-xl text-xs text-gray-600">
                    I voluntarily give consent for Aadhaar based KYC through UIDAI.
                </div>

                <label class="flex items-start gap-2 text-xs font-semibold text-gray-600">
                    <input type="checkbox" x-model="consent" class="mt-1">
                    I agree to Aadhaar based verification
                </label>

                <button @click="consent ? step = 'digio' : error = 'Please provide consent to continue'"
                    class="w-full bg-[#0939a4] text-white py-3 rounded-xl font-bold uppercase text-[11px]">
                    Continue
                </button>

                <p x-show="error" class="text-xs text-red-500" x-text="error"></p>
            </div>

            <!-- DIGIO -->
            <div x-show="step === 'digio'" class="space-y-6">
                <h2 class="text-lg font-bold text-center">Aadhaar OTP Verification</h2>

                <button :disabled="loading" @click="startDigio()"
                    class="w-full bg-[#0939a4] text-white py-3 rounded-xl font-bold uppercase text-[11px] disabled:opacity-60">
                    <span x-show="!loading">Proceed to Aadhaar OTP</span>
                    <span x-show="loading">Redirecting to Digio...</span>
                </button>

                <p x-show="error" class="text-xs text-red-500" x-text="error"></p>
            </div>

        </div>
    </div>

    <script>
        function digioKyc() {
            return {
                step: 'check',
                checking: true,
                loading: false,
                consent: false,
                error: null,

                // approved | pending | none
                kycState: 'none',
                kycDetails: '',

                init() {
                    this.checkKycFromDigio();
                },

                checkKycFromDigio() {
                    fetch('{{ route('digio.check.kyc.status') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.checking = false;

                            console.log('Digio Check Response:', data);

                            const status = (data.kyc_status || 'none').toLowerCase();
                            this.kycDetails = `Current Status: ${status.replace('_',' ').toUpperCase()}`;

                            if (['approved', 'completed', 'success'].includes(status)) {
                                this.kycState = 'approved';
                            } else if (['approval_pending', 'pending', 'in_progress', 'processing'].includes(status)) {
                                this.kycState = 'pending';
                            } else {
                                this.kycState = 'none';
                            }
                        })
                        .catch(() => {
                            this.checking = false;
                            this.kycState = 'none';
                        });
                },

                startDigio() {
                    this.loading = true;
                    this.error = null;

                    fetch('{{ route('digio.test.redirect') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                mobile: '{{ auth()->user()->mobile }}',
                                name: '{{ auth()->user()->name }}'
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (!data.success || !data.redirect_url) {
                                this.error = 'Unable to start KYC';
                                this.loading = false;
                                return;
                            }
                            window.location.href = data.redirect_url;
                        })
                        .catch(() => {
                            this.error = 'Server error. Please try again.';
                            this.loading = false;
                        });
                }
            }
        }
    </script>
@endsection --}}


@extends('layouts.userdashboard')

@section('content')
    <div class="bg-[#f8fafc] flex justify-center min-h-screen">
        <div class="w-full max-w-3xl bg-white rounded-2xl border shadow-sm p-8 md:p-12" x-data="digioKyc()"
            x-init="init()">

            <!-- ================= CHECK STATUS ================= -->
            <div x-show="step === 'check'" class="text-center space-y-6">
                <h2 class="text-xl font-bold">KYC Verification</h2>

                <!-- Loading -->
                <div x-show="checking" class="text-gray-600">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#0939a4] mb-2"></div>
                    <p>Checking KYC status from Digio...</p>
                </div>

                <!-- ✅ APPROVED -->
                <div x-show="kycState === 'approved' && !checking" class="space-y-4">
                    <div class="text-green-600">
                        <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold">KYC Completed</h3>
                    <p class="text-gray-600">Your KYC has been successfully verified.</p>
                    <p class="text-sm text-gray-500" x-text="kycDetails"></p>
                </div>

                <!-- ⏳ PENDING -->
                <div x-show="kycState === 'pending' && !checking" class="space-y-4">
                    <div class="text-yellow-500">
                        <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold">KYC In Progress</h3>
                    <p class="text-gray-600">
                        Your KYC is submitted and pending approval.<br>
                        Please wait, no further action required.
                    </p>
                    <p class="text-sm text-gray-500" x-text="kycDetails"></p>
                </div>

                <!-- ❌ REJECTED / FAILED / EXPIRED -->
                <div x-show="kycState === 'rejected' && !checking" class="space-y-4">
                    <div class="text-red-600">
                        <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-5H9v-2h2v2zm0-4H9V5h2v4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold">KYC Failed</h3>
                    <p class="text-gray-600">
                        Your KYC was rejected or expired.<br>
                        Please start again.
                    </p>
                    <p class="text-sm text-gray-500" x-text="kycDetails"></p>

                    <button @click="step='agreement'"
                        class="w-full max-w-xs mx-auto bg-[#0939a4] text-white py-3 rounded-xl font-bold uppercase text-[11px]">
                        Retry KYC
                    </button>
                </div>

                <!-- ❌ NO KYC -->
                <div x-show="kycState === 'none' && !checking" class="space-y-6">
                    <p class="text-gray-600">
                        You need to complete KYC verification to continue.
                    </p>

                    <button @click="step='agreement'"
                        class="w-full max-w-xs mx-auto bg-[#0939a4] text-white py-3 rounded-xl font-bold uppercase text-[11px]">
                        Start KYC
                    </button>
                </div>
            </div>

            <!-- ================= AGREEMENT ================= -->
            <div x-show="step === 'agreement'" class="space-y-6">
                <h2 class="text-lg font-bold text-center">Aadhaar Consent</h2>

                <div class="max-h-60 overflow-y-auto p-4 bg-gray-50 border rounded-xl text-xs text-gray-600">
                    I voluntarily give consent for Aadhaar based KYC through UIDAI.
                </div>

                <label class="flex items-start gap-2 text-xs font-semibold text-gray-600">
                    <input type="checkbox" x-model="consent" class="mt-1">
                    I agree to Aadhaar based verification
                </label>

                <button @click="consent ? step='digio' : error='Please provide consent'"
                    class="w-full bg-[#0939a4] text-white py-3 rounded-xl font-bold uppercase text-[11px]">
                    Continue
                </button>

                <p x-show="error" class="text-xs text-red-500" x-text="error"></p>
            </div>

            <!-- ================= DIGIO ================= -->
            <div x-show="step === 'digio'" class="space-y-6">
                <h2 class="text-lg font-bold text-center">Aadhaar OTP Verification</h2>

                <button :disabled="loading" @click="startDigio()"
                    class="w-full bg-[#0939a4] text-white py-3 rounded-xl font-bold uppercase text-[11px] disabled:opacity-60">
                    <span x-show="!loading">Proceed to Digio</span>
                    <span x-show="loading">Redirecting...</span>
                </button>

                <p x-show="error" class="text-xs text-red-500" x-text="error"></p>
            </div>

        </div>
    </div>

    <script>
        function digioKyc() {
            return {
                step: 'check',
                checking: true,
                loading: false,
                consent: false,
                error: null,

                kycState: 'none',
                kycDetails: '',

                init() {
                    this.fetchStatus();
                },

                fetchStatus() {
                    fetch('{{ route('digio.check.kyc.status') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.checking = false;

                            const status = (data.kyc_status || data.status || '').toLowerCase();
                            this.kycDetails = status ?
                                `Current Status: ${status.replaceAll('_',' ').toUpperCase()}` :
                                'No KYC record found';

                            if (['approved', 'completed', 'success'].includes(status)) {
                                this.kycState = 'approved';
                            } else if (['initiated', 'pending', 'approval_pending', 'processing', 'in_progress']
                                .includes(status)) {
                                this.kycState = 'pending';
                            } else if (['rejected', 'failed', 'expired'].includes(status)) {
                                this.kycState = 'rejected';
                            } else {
                                this.kycState = 'none';
                            }
                        })
                        .catch(() => {
                            this.checking = false;
                            this.kycState = 'none';
                            this.kycDetails = 'Unable to fetch KYC status';
                        });
                },

                startDigio() {
                    this.loading = true;
                    this.error = null;

                    fetch('{{ route('digio.test.redirect') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                mobile: '{{ auth()->user()->mobile }}',
                                name: '{{ auth()->user()->name }}'
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (!data.success || !data.redirect_url) {
                                this.error = data.note || 'Unable to start KYC';
                                this.loading = false;
                                return;
                            }
                            window.location.href = data.redirect_url;
                        })
                        .catch(() => {
                            this.error = 'Server error. Please try again.';
                            this.loading = false;
                        });
                }
            }
        }
    </script>
@endsection
