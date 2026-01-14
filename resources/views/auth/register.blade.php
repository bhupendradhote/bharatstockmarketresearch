<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Register – Bharat Stock Market Research</title>

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
                    radial-gradient(circle at 10% 20%, rgba(46,125,50,0.08), transparent 40%),
                    linear-gradient(180deg, #EEF2FF 0%, #ffffff 100%);
            }
        }

        /* Desktop Body Color */
        @media (min-width: 768px) {
            body { background-color: #F6F8FC; }
        }

        .market-grid {
            background-image:
                linear-gradient(rgba(18,57,176,.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(18,57,176,.05) 1px, transparent 1px);
            background-size: 26px 26px;
        }

        /* Animation for the card sliding up */
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

        <div class="md:hidden h-[30vh] mobile-brand-bg flex flex-col justify-end pb-12 px-8 relative shrink-0">
            
            <div class="absolute top-[-20%] left-[-10%] w-48 h-48 bg-[#1239B0] opacity-5 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                           <div class="flex items-center gap-3 mb-4">
                    <div class="h-12 w-12 bg-white rounded-full shadow-sm flex items-center justify-center text-[#1239B0] font-bold text-xs border border-blue-50">
                        <img 
                        src="{{ asset('public/assets/images/bharatlogo.webp') }}" 
                        alt="Bharat Stock Market Research Logo"
                        class="h-12 w-12 object-contain rounded-full"
                    >
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#E8F5E9] border border-[#C8E6C9] text-[#2E7D32] text-[10px] font-bold tracking-wide">
                        SEBI REG: INH000023728
                    </span>
                </div>

                <h1 class="text-[26px] font-extrabold text-[#0F172A] leading-[1.15] tracking-tight">
                    Start Your <br>
                    <span class="text-[#1239B0]">Investing Journey.</span>
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
                    Start Your <br>
                    Research-Driven <br>
                    Investing Journey
                </h2>
                <p class="mt-4 text-slate-600 text-lg max-w-sm">
                    Join investors who trade with discipline, transparency, and risk awareness.
                </p>
            </div>

            <div class="mt-auto bg-white/70 backdrop-blur-xl border border-white rounded-2xl p-6 shadow-lg">
                <p class="italic text-slate-700 text-sm">
                    “Account creation helps us ensure compliance, personalization, and responsible investing.”
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

            <div class="w-full md:max-w-sm mx-auto">

                <div class="md:hidden w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6"></div>

                <div class="mb-6">
                    <h3 class="text-2xl md:text-3xl font-extrabold text-black mb-1">
                        Create Account
                    </h3>
                    <p class="text-slate-500 text-sm">
                        Please fill in your details to continue.
                    </p>
                </div>

                <form method="POST" action="{{ route('register.details.store') }}" x-data="{ showPass: false, showConfirm: false }">
                    @csrf

                    <div class="space-y-4">
                        
                        <div class="group">
                            <label class="hidden md:block text-sm font-semibold text-slate-700 mb-1.5">Full Name</label>
                            <label class="md:hidden text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block ml-1">Full Name</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i class="fa-regular fa-user"></i>
                                </span>
                                <input type="text" name="name" required value="{{ old('name') }}"
                                    class="w-full pl-11 pr-4 py-3.5 bg-[#F8FAFC] md:bg-[#F7F9FF] border-2 border-transparent focus:bg-white border-slate-100 focus:border-[#1239B0] rounded-xl outline-none font-semibold text-slate-800 transition-all"
                                    placeholder="Enter your full name">
                            </div>
                            @error('name') <p class="text-red-600 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="group">
                            <label class="hidden md:block text-sm font-semibold text-slate-700 mb-1.5">Email Address</label>
                            <label class="md:hidden text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block ml-1">Email</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i class="fa-regular fa-envelope"></i>
                                </span>
                                <input type="email" name="email" required value="{{ old('email') }}"
                                    class="w-full pl-11 pr-4 py-3.5 bg-[#F8FAFC] md:bg-[#F7F9FF] border-2 border-transparent focus:bg-white border-slate-100 focus:border-[#1239B0] rounded-xl outline-none font-semibold text-slate-800 transition-all"
                                    placeholder="example@mail.com">
                            </div>
                            @error('email') <p class="text-red-600 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <!--<div class="group">-->
                        <!--    <label class="hidden md:block text-sm font-semibold text-slate-700 mb-1.5">Date of Birth</label>-->
                        <!--    <label class="md:hidden text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block ml-1">Date of Birth</label>-->
                        <!--    <div class="relative">-->
                        <!--        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">-->
                        <!--            <i class="fa-regular fa-calendar"></i>-->
                        <!--        </span>-->
                        <!--        <input type="date" name="dob" required value="{{ old('dob') }}"-->
                        <!--            class="w-full pl-11 pr-4 py-3.5 bg-[#F8FAFC] md:bg-[#F7F9FF] border-2 border-transparent focus:bg-white border-slate-100 focus:border-[#1239B0] rounded-xl outline-none font-semibold text-slate-800 transition-all text-slate-500 focus:text-slate-800 valid:text-slate-800">-->
                        <!--    </div>-->
                        <!--    @error('dob') <p class="text-red-600 text-xs mt-1 ml-1">{{ $message }}</p> @enderror-->
                        <!--</div>-->

                        <div class="group">
                            <label class="hidden md:block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                            <label class="md:hidden text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block ml-1">Password</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input :type="showPass ? 'text' : 'password'" name="password" required
                                    class="w-full pl-11 pr-12 py-3.5 bg-[#F8FAFC] md:bg-[#F7F9FF] border-2 border-transparent focus:bg-white border-slate-100 focus:border-[#1239B0] rounded-xl outline-none font-semibold text-slate-800 transition-all"
                                    placeholder="Create password">
                                <button type="button" @click="showPass=!showPass" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#1239B0]">
                                    <i class="fa-regular" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            @error('password') <p class="text-red-600 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="group">
                            <label class="hidden md:block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password</label>
                            <label class="md:hidden text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block ml-1">Confirm Password</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                                    class="w-full pl-11 pr-12 py-3.5 bg-[#F8FAFC] md:bg-[#F7F9FF] border-2 border-transparent focus:bg-white border-slate-100 focus:border-[#1239B0] rounded-xl outline-none font-semibold text-slate-800 transition-all"
                                    placeholder="Confirm password">
                                <button type="button" @click="showConfirm=!showConfirm" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#1239B0]">
                                    <i class="fa-regular" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="mt-8 pb-4">
                        <button type="submit"
                            class="w-full bg-[#1239B0] text-white py-4 rounded-2xl font-bold text-lg hover:bg-[#0F2F9C] transition active:scale-[0.98] shadow-lg shadow-blue-900/20">
                            Continue
                        </button>

                        <p class="text-center text-sm text-slate-600 mt-6">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-bold text-[#2E7D32] hover:underline">
                                Login
                            </a>
                        </p>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>