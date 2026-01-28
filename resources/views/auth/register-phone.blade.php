{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify Phone - Bharath Stock Market Research</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-black">
    <div class="w-full min-h-screen grid md:grid-cols-2">

        <div class="relative w-full h-[300px] md:h-full">
            <img src="https://images.pexels.com/photos/8370754/pexels-photo-8370754.jpeg?auto=compress&cs=tinysrgb&w=1600"
                class="w-full max-h-screen h-full object-cover" />
        </div>

        <div class="bg-white flex items-center justify-center px-6 md:px-16 py-12">

            <div class="w-full max-w-md">

                <h1 class="text-3xl font-bold text-black leading-snug">
                    Verify Your Mobile
                </h1>

                <p class="text-gray-500 text-sm mt-2 mb-6">
                    Almost there! Please verify your phone number to complete registration.
                </p>

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Registration Details
                    </p>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-user text-gray-400 mr-3 w-4"></i>
                        <span class="text-gray-800 font-medium">{{ session('reg_data.name') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-gray-400 mr-3 w-4"></i>
                        <span class="text-gray-800 font-medium">{{ session('reg_data.email') }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('register.send_otp') }}">
                    @csrf

                    <label class="text-gray-700 text-sm font-medium">Mobile Number</label>
                    <div class="relative mt-2">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                            +91
                        </span>
                        <input type="tel" name="phone" required value="{{ old('phone') }}"
                            class="w-full border border-gray-300 pl-12 pr-4 py-3 rounded-md outline-none focus:border-black transition"
                            placeholder="Enter 10-digit number">
                    </div>

                    @error('phone')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                        class="w-full bg-black text-white py-3 rounded-md mt-6 font-semibold hover:bg-gray-800 transition shadow-lg">
                        Send OTP
                    </button>

                    <div class="mt-6 text-center">
                        <a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-black">
                            <i class="fas fa-arrow-left mr-1"></i> Edit Registration Details
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html> --}}



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify Phone – Bharat Stock Market Research</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: Inter, system-ui, sans-serif;
        }

        .brand-bg {
            background:
                radial-gradient(circle at top right, rgba(46, 125, 50, 0.15), transparent 40%),
                linear-gradient(135deg, #EEF2FF 0%, #E8EDFF 100%);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-100 antialiased">

    <div class="min-h-screen flex items-center justify-center md:px-6">

        <div
            class="w-full md:max-w-[1150px] md:bg-white md:rounded-[34px] md:shadow-2xl
               overflow-hidden flex flex-col md:grid md:grid-cols-2
               md:min-h-[680px] h-screen md:h-auto relative">

            <!-- ================= LEFT BRAND PANEL ================= -->
            <div class="brand-bg hidden md:flex flex-col justify-between p-14 relative">

                <div class="flex items-center gap-3 mb-6">
                    <div class="h-12 w-12 bg-white rounded-full shadow flex items-center justify-center">
                        <img src="assets/images/bharatlogo.webp" alt="Bharat Stock Market Research Logo"
                            class="h-12 w-12 object-contain rounded-full">
                    </div>
                    <span class="font-extrabold text-black text-lg tracking-tight">
                        Bharat Stock Market Research
                    </span>
                </div>

                <span
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full
                       bg-gradient-to-r from-[#1239B0] to-[#2E7D32]
                       text-white text-xs font-semibold w-fit shadow">
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
                        <div
                            class="h-10 w-10 rounded-full bg-[#2E7D32] text-white flex items-center justify-center font-bold">
                            NR
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Namita Rathore</p>
                            <p class="text-xs text-slate-500">Proprietor & Research Analyst</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ================= END LEFT PANEL ================= -->

            <!-- ================= RIGHT VERIFY PANEL ================= -->
            <div
                class="flex flex-col h-full bg-white
                   rounded-t-[30px] md:rounded-none
                   shadow-[0_-10px_40px_rgba(0,0,0,0.05)]
                   md:shadow-none
                   -mt-6 md:mt-0
                   relative z-20
                   md:justify-center
                   px-8 pt-10 pb-6 md:p-14">

                <div class="w-full max-w-md mx-auto flex flex-col h-full">

                    <!-- Mobile handle -->
                    <div class="md:hidden w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-8"></div>

                    <!-- Heading -->
                    <div class="mb-8">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-[#0F172A] mb-2">
                            Verify Your Mobile
                        </h1>
                        <p class="text-slate-500 text-sm md:text-base">
                            Almost there! Please verify your phone number to complete registration.
                        </p>
                    </div>

                    <!-- Registration Summary (static demo values) -->
                    <div class="bg-[#F8FAFC] border border-slate-200 rounded-2xl p-4 mb-8">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">
                            Registration Details
                        </p>

                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-regular fa-user text-slate-400"></i>
                            <span class="font-semibold text-slate-700">{{ session('reg_data.name') }}</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <i class="fa-regular fa-envelope text-slate-400"></i>
                            <span class="font-semibold text-slate-700">{{ session('reg_data.email') }}</span>
                        </div>
                    </div>

                    <!-- Form -->

                    <form method="POST" action="{{ route('register.send_otp') }}">
                        @csrf

                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">
                            Mobile Number
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-semibold">
                                +91
                            </span>

                            <input type="tel" name="phone" required value="{{ old('phone') }}" maxlength="10"
                                class="w-full pl-14 pr-4 py-4 bg-[#F8FAFC]
                                   border-2 border-transparent
                                   focus:bg-white focus:border-[#1239B0]
                                   rounded-2xl outline-none
                                   font-semibold text-slate-800 transition-all"
                                placeholder="Enter 10-digit number">
                        </div>
                        @error('phone')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror

                        <!-- CTA -->
                        <div class="mt-auto pt-6">
                            <button type="submit"
                                class="w-full bg-[#1239B0] text-white py-4 rounded-2xl
                                   font-bold text-lg
                                   hover:bg-[#0e2a85]
                                   transition-transform active:scale-[0.98]
                                   shadow-lg shadow-blue-900/20">
                                Send OTP
                            </button>

                            <div class="mt-6 text-center">
                                <a href="{{ route('register') }}"
                                    class="text-sm font-bold text-[#2E7D32] hover:underline">
                                    <i class="fa-solid fa-arrow-left mr-1"></i>
                                    Edit Registration Details
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- ================= END RIGHT PANEL ================= -->

        </div>
    </div>

</body>

</html>
