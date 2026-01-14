{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Bharath Stock Market Research</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-black">
    <div class="w-full min-h-screen grid md:grid-cols-2">

        <!-- LEFT SIDE IMAGE -->
        <div class="relative w-full h-[300px] md:h-full">
            <img src="https://images.pexels.com/photos/8370754/pexels-photo-8370754.jpeg?auto=compress&cs=tinysrgb&w=1600"
                class="w-full max-h-screen h-full object-cover" />
        </div>

        <!-- RIGHT SIDE FORM -->
        <div class="bg-white flex items-center justify-center px-6 md:px-16 py-12">

            <div class="w-full max-w-md">

                <!-- TITLE -->
                <h1 class="text-3xl font-bold text-black leading-snug">
                    Welcome to Bharath <br> Stock Market Research
                </h1>

                <p class="text-gray-500 text-sm mt-2 mb-8">
                    Login to your Account
                </p>

                <!-- Laravel Login Form -->
                <form method="POST" action="{{ route('register.send_otp') }}">
                    @csrf

                    <label class="text-gray-700 text-sm font-medium">Mobile Number</label>
                    <input type="tel" name="phone" required value="{{ old('phone') }}"
                        class="w-full border border-gray-300 px-4 py-3 rounded-md mt-2 outline-none"
                        placeholder="Enter 10-digit number">

                    @error('phone')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <button class="w-full bg-black text-white py-3 rounded-md mt-6">
                        Send OTP
                    </button>
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

</html>
