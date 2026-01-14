<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Verify & Reset – Bharat Stock Market Research</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* --- DESKTOP BRAND BG --- */
        .brand-bg {
            background:
                radial-gradient(circle at top right, rgba(46,125,50,0.15), transparent 40%),
                linear-gradient(135deg, #EEF2FF 0%, #E8EDFF 100%);
        }

        /* --- MOBILE BRAND BG --- */
        @media (max-width: 767px) {
            body { background: #EEF2FF; }
            .mobile-brand-bg {
                background:
                    radial-gradient(circle at 20% 10%, rgba(46,125,50,0.10), transparent 50%),
                    linear-gradient(180deg, #EEF2FF 0%, #ffffff 100%);
            }
        }

        /* Desktop Background */
        @media (min-width: 768px) {
            body { background-color: #F6F8FC; }
        }

        .market-grid {
            background-image:
                linear-gradient(rgba(18,57,176,.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(18,57,176,.05) 1px, transparent 1px);
            background-size: 26px 26px;
        }

        /* Focus & Animation */
        .input-focus:focus {
            border-color: #1239B0;
            box-shadow: 0 0 0 4px rgba(18,57,176,0.15);
        }
        
        .otp-box:focus {
            border-color: #1239B0;
            box-shadow: 0 0 0 4px rgba(18,57,176,0.15);
            transform: translateY(-2px);
        }

        @keyframes slideUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-sheet {
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>

<body class="antialiased text-slate-800">

<div class="min-h-screen flex items-center justify-center md:px-6">

    <div class="w-full md:max-w-[1150px] md:bg-white md:rounded-[34px] md:shadow-2xl overflow-hidden flex flex-col md:grid md:grid-cols-2 md:min-h-[680px] h-screen md:h-auto relative">

        <div class="md:hidden h-[30vh] mobile-brand-bg flex flex-col justify-end pb-10 px-8 relative shrink-0">
            <a href="{{ route('password.request') }}" class="absolute top-6 left-6 text-slate-500 hover:text-[#1239B0]">
                <i class="fa-solid fa-arrow-left text-lg"></i>
            </a>

            <div class="absolute top-[-10%] left-[-10%] w-48 h-48 bg-[#1239B0] opacity-5 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                <div class="mb-4">
                     <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#E8F5E9] border border-[#C8E6C9] text-[#2E7D32] text-[10px] font-bold tracking-wide shadow-sm">
                        <i class="fa-solid fa-lock mr-2"></i>
                        SECURITY CHECK
                    </span>
                </div>

                <h1 class="text-[28px] font-extrabold text-[#0F172A] leading-[1.15] tracking-tight">
                    Verify & <br>
                    <span class="text-[#1239B0]">Reset Password.</span>
                </h1>
            </div>
        </div>

        <div class="brand-bg  hidden md:flex flex-col justify-between p-14 relative">
            
            <div class="flex items-center gap-3 mb-6">
                <div class="h-12 w-12 bg-white rounded-full shadow flex items-center justify-center text-xs font-bold text-blue-900"> <img 
                        src="{{ asset('public/assets/images/bharatlogo.webp') }}" 
                        alt="Bharat Stock Market Research Logo"
                        class="h-12 w-12 object-contain rounded-full"
                    ></div>
                <span class="font-extrabold text-black text-lg tracking-tight">
                    Bharat Stock Market Research
                </span>
            </div>

            <span class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-gradient-to-r from-[#1239B0] to-[#2E7D32] text-white text-xs font-semibold w-fit shadow">
                SEBI Registered INH000023728
            </span>

            <div class="mt-10">
                <h2 class="text-4xl font-extrabold text-black leading-tight">
                    Final Step to <br>
                    Secure Access
                </h2>
                <p class="mt-4 text-slate-600 text-lg max-w-sm">
                    Verify it's you to set a new password and regain access to your dashboard.
                </p>
            </div>

            <div class="mt-auto bg-white/70 backdrop-blur-xl border border-white rounded-2xl p-6 shadow-lg">
                <p class="italic text-slate-700 text-sm">
                    “Security is not just a feature, it's a promise to our investors.”
                </p>
                <div class="mt-4 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-[#2E7D32] text-white flex items-center justify-center font-bold">NR</div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Namita Rathore</p>
                        <p class="text-xs text-slate-500">Proprietor & Research Analyst</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col h-full bg-white md:bg-transparent rounded-t-[32px] md:rounded-none shadow-[0_-10px_40px_rgba(0,0,0,0.06)] md:shadow-none -mt-6 md:mt-0 relative z-20 px-8 pt-8 pb-6 md:p-14 md:justify-center overflow-y-auto animate-sheet md:animate-none">

            <div class="w-full md:max-w-md mx-auto" x-data="resetHandler()">

                <div class="md:hidden w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6"></div>

                <div class="mb-8">
                    <h3 class="text-2xl md:text-3xl font-extrabold text-black mb-1">
                        Enter Details
                    </h3>
                    <p class="text-slate-500 text-sm mb-3">
                        Enter OTP and set your new password.
                    </p>
                    
                    <div class="inline-flex items-center gap-2 bg-[#F1F5F9] border border-slate-200 pl-3 pr-4 py-1.5 rounded-full">
                        <span class="text-xs text-slate-500 font-medium">Sent to:</span>
                        <span class="text-[#1239B0] font-bold text-sm">{{ session('reset_identity') }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.update') }}" @submit="combineOtp()">
                    @csrf
                    <input type="hidden" name="otp" x-model="finalOtp">

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 ml-1">Verification Code</label>
                        <div class="flex justify-between gap-1 md:gap-3">
                            <template x-for="(digit, index) in otp" :key="index">
                                <input type="text" maxlength="1" inputmode="numeric"
                                    class="otp-box w-11 h-12 md:w-14 md:h-14 bg-[#F8FAFC] md:bg-[#F7F9FF] border border-slate-200 rounded-xl text-center text-xl font-bold text-slate-800 outline-none transition-all duration-200"
                                    x-model="otp[index]" 
                                    @input="moveNext(index)"
                                    @keydown.backspace="moveBack(index, $event)"
                                    @paste="handlePaste($event)">
                            </template>
                        </div>
                        @error('otp')
                            <p class="text-red-600 text-xs mt-2 font-semibold ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-5 mb-8">
                        
                        <div class="group relative">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">New Password</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input :type="showNew ? 'text' : 'password'" name="password" required
                                    class="w-full pl-11 pr-12 py-3.5 bg-[#F8FAFC] md:bg-[#F7F9FF] border-2 border-transparent focus:bg-white border-slate-100 focus:border-[#1239B0] rounded-xl outline-none font-semibold text-slate-800 transition-all"
                                    placeholder="Enter new password">
                                <button type="button" @click="showNew=!showNew" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#1239B0]">
                                    <i class="fa-regular" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-600 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="group relative">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">Confirm Password</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                                    class="w-full pl-11 pr-12 py-3.5 bg-[#F8FAFC] md:bg-[#F7F9FF] border-2 border-transparent focus:bg-white border-slate-100 focus:border-[#1239B0] rounded-xl outline-none font-semibold text-slate-800 transition-all"
                                    placeholder="Confirm new password">
                                <button type="button" @click="showConfirm=!showConfirm" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#1239B0]">
                                    <i class="fa-regular" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <button type="submit"
                        class="w-full bg-[#1239B0] text-white py-4 rounded-2xl font-bold text-lg hover:bg-[#0F2F9C] transition active:scale-[0.98] shadow-lg shadow-blue-900/20 flex justify-center items-center gap-2">
                        <span>Reset Password</span>
                        <i class="fa-solid fa-check text-sm opacity-70"></i>
                    </button>

                    <div class="mt-6 text-center">
                        <a href="{{ route('password.request') }}" class="text-xs text-slate-500 hover:text-black hover:underline">
                            Wrong email or phone? Change it here
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<script>
    function resetHandler() {
        return {
            otp: ["", "", "", "", "", ""],
            finalOtp: "",
            showNew: false,
            showConfirm: false,

            moveNext(index) {
                // Numeric filter
                this.otp[index] = this.otp[index].replace(/[^0-9]/g, '');
                if (this.otp[index].length === 1 && index < 5) {
                    this.$root.querySelectorAll('.otp-box')[index + 1].focus();
                }
                this.combineOtp();
            },

            moveBack(index, event) {
                if (event.key === "Backspace" && !this.otp[index] && index > 0) {
                    this.$root.querySelectorAll('.otp-box')[index - 1].focus();
                }
                this.combineOtp();
            },

            handlePaste(event) {
                event.preventDefault();
                const pastedData = (event.clipboardData || window.clipboardData).getData('text');
                const numericData = pastedData.replace(/[^0-9]/g, '').slice(0, 6);
                
                if (numericData) {
                    numericData.split('').forEach((char, index) => {
                        if (index < 6) this.otp[index] = char;
                    });
                    this.combineOtp();
                    const focusIndex = Math.min(numericData.length, 5);
                    this.$root.querySelectorAll('.otp-box')[focusIndex].focus();
                }
            },

            combineOtp() {
                this.finalOtp = this.otp.join("");
            }
        };
    }
</script>

</body>
</html>