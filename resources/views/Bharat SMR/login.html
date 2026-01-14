<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Bharath Stock Market Research</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .otp-input {
            transition: all 0.2s ease;
            border-width: 2px;
        }

        .otp-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            transform: scale(1.05);
        }

        .otp-input.filled {
            border-color: #10b981;
            background: #ecfdf5;
        }

        @keyframes popScale {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-scale {
            animation: popScale 0.3s ease-out;
        }
    </style>
</head>

<body class="bg-black">


    <div class="w-full min-h-screen grid md:grid-cols-2" x-data="loginApp()">

        <!-- LEFT SIDE IMAGE -->
        <div class="relative w-full h-[300px] md:h-full">
            <img src="https://images.pexels.com/photos/8370754/pexels-photo-8370754.jpeg?auto=compress&cs=tinysrgb&w=1600"
                class="w-full max-h-screen h-full object-cover" />

            <!-- Back Button -->
            <button @click="goBack()" x-show="step !== 'login'"
                class="absolute top-5 left-5 bg-white/90 px-4 py-2 rounded-md shadow text-sm">
                ← Back
            </button>
        </div>

        <!-- RIGHT SIDE CONTENT -->
        <div class="bg-white flex items-center justify-center px-6 md:px-16 py-12">

            <div class="w-full max-w-md">

                <!-- TITLE -->
                <h1 class="text-3xl font-bold text-black leading-snug">
                    Welcome to Bharath <br> Stock Market Research
                </h1>

                <p class="text-gray-500 text-sm mt-2 mb-8">
                    <span x-show="step === 'login'">Login to your Account</span>
                    <span x-show="step === 'otp'">Enter the OTP sent to your number</span>
                    <span x-show="step === 'signup'">Complete your profile</span>
                </p>

                <!-- ========================= -->
                <!-- LOGIN FORM -->
                <!-- ========================= -->
                <div x-show="step === 'login'">

                    <label class="text-gray-700 text-sm font-medium">Mobile Number</label>
                    <input type="tel" x-model="mobileNumber"
                        class="w-full border border-gray-300 px-4 py-3 rounded-md mt-2 outline-none"
                        placeholder="Enter 10-digit number">

                    <button @click="sendOTP()" :disabled="mobileNumber.length !== 10"
                        class="w-full bg-black text-white py-3 rounded-md mt-6 disabled:opacity-40">
                        Send OTP
                    </button>
                </div>

                <!-- ========================= -->
                <!-- OTP VERIFICATION -->
                <!-- ========================= -->
                <div x-show="step === 'otp'">

                    <!-- Show number -->
                    <div class="mb-5 p-4 bg-blue-50 rounded-md border border-blue-200">
                        <p class="text-sm">OTP sent to</p>
                        <p class="font-semibold text-lg">+91 <span x-text="mobileNumber"></span></p>
                    </div>

                    <!-- OTP Inputs -->
                    <div class="flex gap-3 justify-center mb-8">
                        <template x-for="(digit, index) in otpDigits" :key="index">
                            <input maxlength="1" x-model="otpDigits[index]" @input="handleOtpInput(index, $event)"
                                type="text"
                                class="otp-input w-12 h-12 border rounded-lg text-center text-xl font-bold" />
                        </template>
                    </div>

                    <button @click="verifyOTP()" :disabled="!isOtpComplete"
                        class="w-full bg-green-600 text-white py-3 rounded-md disabled:opacity-40">
                        Verify OTP
                    </button>
                </div>

                <div x-show="step === 'signup'">

                    <!-- Name -->
                    <label class="text-gray-700 text-sm font-medium mt-4 block">Name</label>
                    <input type="text" x-model="name"
                        class="w-full border border-gray-300 px-4 py-3 rounded-md mt-2 outline-none"
                        placeholder="Enter your Name">

                    <!-- Email -->
                    <label class="text-gray-700 text-sm font-medium mt-4 block">Email</label>
                    <input type="email" x-model="email"
                        class="w-full border border-gray-300 px-4 py-3 rounded-md mt-2 outline-none"
                        placeholder="Enter your Email">

                    <!-- DOB -->
                    <label class="text-gray-700 text-sm font-medium mt-4 block">DOB</label>
                    <input type="date" x-model="dob"
                        class="w-full border border-gray-300 px-4 py-3 rounded-md mt-2 outline-none">

                    <button @click="submitSignup()" class="w-full bg-black text-white py-3 rounded-md mt-6">
                        Sign Up
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- SUCCESS POPUP -->
    <div id="successPopup"
        class="fixed  inset-0 flex items-center justify-center bg-black/20 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">

        <div class="bg-white lg:p-20 px-10 py-8 rounded-2xl shadow-xl text-center animate-scale">
            <div class="w-16 h-16 mx-auto rounded-full bg-blue-600 flex items-center justify-center">
                <i class="fas fa-check text-white text-3xl"></i>
            </div>
            <h2 class="text-xl font-semibold mt-4">Signup Successfully</h2>
            <p class="text-gray-500 text-sm mt-1">You will be redirected shortly</p>
        </div>
    </div>




    <script>
        function loginApp() {
            return {
                step: "login",
                mobileNumber: "",
                otpDigits: ["", "", "", "", "", ""],
                name: "",
                email: "",
                dob: "",

                sendOTP() {
                    this.step = "otp";
                    this.otpDigits = ["", "", "", "", "", ""];
                    setTimeout(() => {
                        document.querySelector(".otp-input")?.focus();
                    }, 200);
                },

                verifyOTP() {
                    if (!this.isOtpComplete) return;
                    this.step = "signup";
                },

                submitSignup() {
                    if (!this.name || !this.email || !this.dob) {
                        alert("Please fill all fields");
                        return;
                    }

                    // SHOW POPUP
                    const popup = document.getElementById("successPopup");
                    popup.classList.remove("opacity-0", "pointer-events-none");

                    // After 1 second, fade out + redirect
                    setTimeout(() => {
                        popup.classList.add("opacity-0", "pointer-events-none");
                        window.location.href = "/";
                    }, 1200);
                },


                goBack() {
                    if (this.step === "otp") this.step = "login";
                    else if (this.step === "signup") this.step = "otp";
                },

                handleOtpInput(index, event) {
                    const value = event.target.value;
                    if (!/^\d*$/.test(value)) {
                        this.otpDigits[index] = "";
                        return;
                    }
                    event.target.classList.toggle("filled", value !== "");

                    if (value && index < 5) {
                        document.querySelectorAll(".otp-input")[index + 1].focus();
                    }
                },

                get isOtpComplete() {
                    return this.otpDigits.every((d) => d !== "");
                }
            };
        }
    </script>

</body>

</html>

