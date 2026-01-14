<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Reset Password – Bharat Stock Market Research</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
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
                    radial-gradient(circle at 85% 15%, rgba(46,125,50,0.08), transparent 40%),
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
        
        /* Animation for Bottom Sheet */
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

        <div class="md:hidden h-[35vh] mobile-brand-bg flex flex-col justify-end pb-12 px-8 relative shrink-0">
            <div class="absolute top-[-10%] right-[-20%] w-48 h-48 bg-[#1239B0] opacity-5 rounded-full blur-2xl"></div>

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

                <h1 class="text-[28px] font-extrabold text-[#0F172A] leading-[1.15] tracking-tight">
                    Secure Access <br>
                    <span class="text-[#1239B0]">to Your Account.</span>
                </h1>
            </div>
        </div>

        <div class="brand-bg hidden md:flex flex-col justify-between p-14 relative">
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
            
            <span class="inline-flex items-center gap-2 px-5 py-2 rounded-full
                bg-gradient-to-r from-[#1239B0] to-[#2E7D32]
                text-white text-xs font-semibold w-fit shadow">
                SEBI Registered INH000023728
            </span>
            
            <div class="mt-10">
                <h2 class="text-4xl font-extrabold text-black leading-tight">
                    Secure Access <br>
                    to Your Account
                </h2>
                <p class="mt-4 text-slate-600 text-lg max-w-sm">
                    We follow strict security practices to ensure
                    safe account recovery and responsible access.
                </p>
            </div>
            
            <div class="mt-auto bg-white/70 backdrop-blur-xl border border-white rounded-2xl p-6 shadow-lg">
                <p class="italic text-slate-700 text-sm">
                    “Multiple verification steps help us protect
                    your data and prevent unauthorized access.”
                </p>
                <div class="mt-4 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-[#2E7D32] text-white flex items-center justify-center font-bold">
                        NR
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Namita Rathore</p>
                        <p class="text-xs text-slate-500">Proprietor & Research Analyst</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col h-full bg-white md:bg-transparent rounded-t-[32px] md:rounded-none shadow-[0_-10px_40px_rgba(0,0,0,0.06)] md:shadow-none -mt-8 md:mt-0 relative z-20 px-8 pt-10 pb-6 md:p-14 md:justify-center animate-sheet md:animate-none">

            <div class="w-full md:max-w-sm mx-auto">
                
                <div class="md:hidden w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-8"></div>

                <h3 class="text-2xl md:text-3xl font-extrabold text-black mb-2">
                    Reset Password
                </h3>

                @php $attempts = session('forgot_email_attempts', 0); @endphp

                @if ($attempts >= 3)
                    <div class="mt-4 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-start gap-3">
                        <div class="mt-0.5 w-6 h-6 rounded-full bg-red-100 flex items-center justify-center shrink-0 text-red-600 text-xs">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="text-sm text-red-800 leading-snug">
                            <p class="font-bold mb-0.5">Limit Reached</p>
                            Please use your registered <b>Mobile Number</b>.
                        </div>
                    </div>
                @elseif($attempts > 0)
                    <div class="mt-4 p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-slate-400"></i>
                        Email attempts used: <b>{{ $attempts }} / 3</b>
                    </div>
                @endif

                <p class="text-slate-500 mt-6 mb-8 text-sm md:text-base leading-relaxed">
                    @if ($attempts >= 3)
                        Enter your <b>registered mobile number</b> to receive the reset OTP via SMS.
                    @else
                        Enter your <b>registered email address</b> to receive the reset OTP.
                    @endif
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="mb-8 group">
                        <label class="block text-xs md:text-sm font-bold text-slate-500 uppercase md:normal-case md:font-semibold md:text-slate-700 mb-2 ml-1">
                            {{ $attempts >= 3 ? 'Mobile Number' : 'Email Address' }}
                        </label>
                        
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fa-solid {{ $attempts >= 3 ? 'fa-mobile-screen' : 'fa-envelope' }}"></i>
                            </span>
                            
                            <input type="text" name="identity" required
                                class="w-full pl-11 pr-4 py-4 bg-[#F8FAFC] md:bg-[#F7F9FF] border-2 border-transparent focus:bg-white border-slate-100 focus:border-[#1239B0] rounded-2xl outline-none font-semibold text-slate-800 transition-all duration-200 {{ $attempts >= 3 ? 'focus:border-red-500/50' : '' }}"
                                placeholder="{{ $attempts >= 3 ? 'e.g. 9876543210' : 'name@example.com' }}">
                        </div>
                        
                        @error('identity')
                            <p class="text-red-600 text-xs font-semibold mt-2 ml-1 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-[#1239B0] text-white py-4 rounded-2xl font-bold text-lg hover:bg-[#0F2F9C] transition active:scale-[0.98] shadow-lg shadow-blue-900/20 flex justify-center items-center gap-2">
                        <span>{{ $attempts >= 3 ? 'Send SMS OTP' : 'Send Email OTP' }}</span>
                        <i class="fa-solid fa-paper-plane text-sm opacity-70"></i>
                    </button>
                </form>

                <p class="text-center text-sm text-slate-500 mt-8 font-medium">
                    Remember your password?
                    <a href="{{ route('login') }}" class="font-bold text-[#2E7D32] hover:underline ml-1">
                        Back to Login
                    </a>
                </p>
            </div>
        </div>

    </div>
</div>

</body>
</html>