<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Login – Bharat Stock Market Research</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .script-font { font-family: 'Dancing Script', cursive; }

        /* --- YOUR ORIGINAL BRAND BACKGROUND --- */
        .brand-bg {
            background:
                radial-gradient(circle at top right, rgba(46,125,50,0.15), transparent 40%),
                linear-gradient(135deg, #EEF2FF 0%, #E8EDFF 100%);
        }

        /* Mobile specific background setup */
        @media (max-width: 767px) {
            body { background: #EEF2FF; } /* Fallback */
            .mobile-brand-bg {
                background:
                    radial-gradient(circle at 80% 20%, rgba(46,125,50,0.10), transparent 50%),
                    linear-gradient(180deg, #EEF2FF 0%, #ffffff 100%);
            }
        }

        /* Desktop Background */
        @media (min-width: 768px) {
            body { background-color: #F6F8FC; }
        }

        .input-focus:focus {
            border-color: #1239B0;
            box-shadow: 0 0 0 4px rgba(18,57,176,0.10);
        }

        /* Mobile Animation: Slide Up */
        @keyframes slideUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-sheet {
            animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>

<body class="antialiased text-slate-800">

<div class="min-h-screen flex items-center justify-center md:px-6">

    <div class="w-full md:max-w-[1150px] md:bg-white md:rounded-[34px] md:shadow-2xl overflow-hidden flex flex-col md:grid md:grid-cols-2 md:min-h-[680px] h-screen md:h-auto relative">

        <div class="md:hidden h-[35vh] mobile-brand-bg flex flex-col justify-center px-8 relative">
            <div class="absolute top-[-20%] left-[-10%] w-48 h-48 bg-[#1239B0] opacity-5 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-12 w-12 bg-white rounded-full shadow-sm flex items-center justify-center text-[#1239B0] font-bold text-xs border border-blue-50">
                        <img 
                        src="{{ asset('assets/images/bharatlogo.webp') }}" 
                        alt="Bharat Stock Market Research Logo"
                        class="h-12 w-12 object-contain rounded-full"
                    >
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#E8F5E9] border border-[#C8E6C9] text-[#2E7D32] text-[10px] font-bold tracking-wide">
                        SEBI REG: INH000023728
                    </span>
                </div>

                <h1 class="text-3xl font-extrabold text-[#0F172A] leading-tight">
                    Smarter <br> 
                    <span class="text-[#1239B0]">Confident Investing.</span>
                </h1>
            </div>
        </div>

        <div class="brand-bg hidden md:flex flex-col justify-between p-14 relative">
            <div class="flex items-center gap-3 mb-6">
               <div class="h-12 w-12 bg-white rounded-full shadow flex items-center justify-center">
                    <img 
                        src="{{ asset('assets/images/bharatlogo.webp') }}" 
                        alt="Bharat Stock Market Research Logo"
                        class="h-12 w-12 object-contain rounded-full"
                    >
                </div>
                
                <span class="font-extrabold text-[#0F172A] text-lg tracking-tight">
                    Bharat Stock Market Research
                </span>

            </div>
            <span class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-gradient-to-r from-[#1239B0] to-[#2E7D32] text-white text-xs font-semibold w-fit shadow">
                SEBI Registered INH000023728
            </span>
            <div class="mt-10">
                <h2 class="text-4xl font-extrabold text-black leading-tight">
                    Smart Research for <br>
                    <span class="text-black">Confident</span> <span class="text-black">Investors</span>
                </h2>
                <p class="mt-4 text-slate-600 text-lg max-w-sm">
                    Trade with clarity using research-backed insights, disciplined strategies, and risk-aware decisions.
                </p>
            </div>
            <div class="mt-auto bg-white/70 backdrop-blur-xl border border-white rounded-2xl p-6 shadow-lg">
                <p class="italic text-slate-700 text-sm">"Transparency, risk awareness, and long-term value creation are the foundation of our research."</p>
                <div class="mt-4 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-[#2E7D32] text-white flex items-center justify-center font-bold">NR</div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Namita Rathore</p>
                        <p class="text-xs text-slate-500">Proprietor & Research Analyst</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col h-full bg-white md:bg-transparent rounded-t-[30px] md:rounded-none shadow-[0_-10px_40px_rgba(0,0,0,0.05)] md:shadow-none -mt-6 md:mt-0 relative z-20 md:justify-center px-8 pt-10 pb-6 md:p-14 animate-sheet md:animate-none">

            <div class="w-full md:max-w-sm mx-auto flex flex-col h-full">

                <div class="md:hidden w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-8"></div>

                <div class="mb-8">
                    <h3 class="text-2xl md:text-3xl font-extrabold text-[#0F172A] mb-2">
                        Welcome Back
                    </h3>
                    <p class="text-slate-500 text-sm md:text-base">
                        Please enter your details to sign in.
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" x-data="{ show:false }" class="flex flex-col flex-grow">
                    @csrf

                    <div class="space-y-5">
                        <div class="group">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 block ml-1">Email or Mobile</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i class="fa-regular fa-envelope"></i>
                                </span>
                                <input type="text" name="login_identity" required
                                    class="w-full pl-11 pr-4 py-4 bg-[#F8FAFC] md:bg-[#F7F9FF] border-2 border-transparent focus:bg-white border-slate-100 focus:border-[#1239B0] rounded-2xl outline-none font-semibold text-slate-800 transition-all duration-200"
                                    placeholder="user@example.com">
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1.5 ml-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Password</label>
                            </div>

                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input :type="show ? 'text' : 'password'" name="password" required
                                    class="w-full pl-11 pr-12 py-4 bg-[#F8FAFC] md:bg-[#F7F9FF] border-2 border-transparent focus:bg-white border-slate-100 focus:border-[#1239B0] rounded-2xl outline-none font-semibold text-slate-800 transition-all duration-200"
                                    placeholder="••••••••">

                                <button type="button" @click="show=!show"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#1239B0] p-2">
                                    <i class="fa-regular" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            
                          <div class="flex items-center justify-between mt-4 px-1">
                            <label class="flex items-center gap-3 text-sm font-medium text-slate-600 cursor-pointer">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    class="w-4 h-4 rounded border-slate-300 text-[#1239B0] focus:ring-[#1239B0]"
                                >
                                <span>Keep me signed in</span>
                            </label>
                        
                            <a href="{{ route('password.request') }}"
                               class="text-sm font-bold text-[#1239B0] hover:underline">
                                Forgot password?
                            </a>
                        </div>

                        </div>
                    </div>

                    <div class="mt-auto pt-6">
                     

                        <button class="w-full bg-[#1239B0] text-white py-4 rounded-2xl font-bold text-lg hover:bg-[#0e2a85] transition-transform active:scale-[0.98] shadow-lg shadow-blue-900/20 flex justify-center items-center gap-2">
                            <span>Sign In</span>
                            <i class="fa-solid fa-arrow-right text-sm opacity-70"></i>
                        </button>

                        <p class="text-center text-xs text-slate-400 mt-6 font-medium">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-[#2E7D32] font-bold hover:underline">Create Account</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>