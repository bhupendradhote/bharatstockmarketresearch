<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify OTP - Bharath Stock Market Research</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        .otp-box {
            transition: all 0.2s ease;
        }

        .otp-box:focus {
            border-color: #2563eb;
            box-shadow: 0 0 5px #93c5fd;
            transform: scale(1.08);
        }
    </style>
</head>

<body class="bg-black">

    <div class="w-full min-h-screen grid md:grid-cols-2">

        <!-- LEFT IMAGE -->
        <div class="relative w-full h-[300px] md:h-full">
            <img src="https://images.pexels.com/photos/8370754/pexels-photo-8370754.jpeg?auto=compress&cs=tinysrgb&w=1600"
                class="w-full max-h-screen h-full object-cover" />

            <a href="{{ route('login') }}" class="absolute top-5 left-5 bg-white/90 px-4 py-2 rounded-md shadow text-sm">
                ← Back
            </a>
        </div>

        <!-- RIGHT SIDE -->
        <div class="bg-white flex items-center justify-center px-6 md:px-16 py-12">

            <div class="w-full max-w-md" x-data="otpForm()">

                <h1 class="text-3xl font-bold text-black leading-snug">Enter OTP</h1>

                <p class="text-gray-500 text-sm mt-2 mb-8">
                    Enter the OTP sent to your mobile number +91 {{ $phone }}
                </p>

                <form method="POST" action="{{ route('otp.verify') }}" @submit="combineOtp()">
                    @csrf

                    <input type="hidden" name="phone" value="{{ $phone }}">

                    <!-- PHONE DISPLAY BOX -->
                    <div class="mb-5 p-4 bg-blue-50 rounded-md border border-blue-200">
                        <p class="text-sm">OTP sent to</p>
                        <p class="font-semibold text-lg">+91 {{ $phone }}</p>
                    </div>

                    <!-- Show OTP for Testing -->
                    {{-- @if (session('otp'))
                        <p class="text-sm text-gray-500 mb-4">
                            Your OTP is:
                            <strong>{{ session('otp') }}</strong>
                        </p>
                    @endif --}}

                    <!-- Hidden Final OTP Field -->
                    <input type="hidden" name="otp" x-model="finalOtp">

                    <!-- OTP INPUT BOXES -->
                    <div class="flex justify-between mb-6">
                        <template x-for="(digit, index) in otp" :key="index">
                            <input type="text" maxlength="1"
                                class="otp-box w-12 h-12 border border-gray-400 rounded-lg text-center text-xl font-semibold outline-none"
                                x-model="otp[index]" @input="moveNext(index)"
                                @keydown.backspace="moveBack(index, $event)">
                        </template>
                    </div>

                    @error('otp')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <button class="w-full bg-green-600 text-white py-3 rounded-md mt-3 text-lg">
                        Verify OTP
                    </button>
                </form>


            </div>
        </div>

    </div>


    <!-- OTP Alpine Logic -->
    <script>
        function otpForm() {
            return {
                otp: ["", "", "", "", "", ""],
                finalOtp: "",

                moveNext(index) {
                    if (this.otp[index].length === 1 && index < 5) {
                        this.$root.querySelectorAll('.otp-box')[index + 1].focus();
                    }
                },

                moveBack(index, event) {
                    if (event.key === "Backspace" && !this.otp[index] && index > 0) {
                        this.$root.querySelectorAll('.otp-box')[index - 1].focus();
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
