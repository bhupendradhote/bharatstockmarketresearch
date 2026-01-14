<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Profile - Bharath Stock Market Research</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black">

    <div class="w-full min-h-screen grid md:grid-cols-2">

        <!-- LEFT IMAGE -->
        <div class="relative w-full h-[300px] md:h-full">
            <img src="https://images.pexels.com/photos/8370754/pexels-photo-8370754.jpeg?auto=compress&cs=tinysrgb&w=1600"
                class="w-full max-h-screen h-full object-cover" />
        </div>

        <!-- RIGHT SIDE -->
        <div class="bg-white flex items-center justify-center px-6 md:px-16 py-12">

            <div class="w-full max-w-md">

                <h1 class="text-3xl font-bold text-black leading-snug">
                    Complete Your Details
                </h1>

                <p class="text-gray-500 text-sm mt-2 mb-8">
                    Finish setting up your account
                </p>

                <form action="{{ route('register.complete') }}" method="POST">
                    @csrf

                    <!-- Phone -->
                    <label class="text-gray-700 text-sm font-medium mt-4 block">Phone Number</label>
                    <input type="text" name="phone" value="{{ $phone }}" readonly
                        class="w-full border border-gray-300 px-4 py-3 rounded-md mt-2 bg-gray-100 cursor-not-allowed">

                    <!-- Name -->
                    <label class="text-gray-700 text-sm font-medium mt-4 block">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full border border-gray-300 px-4 py-3 rounded-md mt-2 outline-none"
                        placeholder="Enter your full name">

                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Email -->
                    <label class="text-gray-700 text-sm font-medium mt-4 block">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        class="w-full border border-gray-300 px-4 py-3 rounded-md mt-2 outline-none"
                        placeholder="Enter your email">

                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- DOB -->
                    <label class="text-gray-700 text-sm font-medium mt-4 block">Date of Birth</label>
                    <input type="date" name="dob" required value="{{ old('dob') }}"
                        class="w-full border border-gray-300 px-4 py-3 rounded-md mt-2 outline-none">

                    @error('dob')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Submit -->
                    <button class="w-full bg-black text-white py-3 rounded-md mt-6 text-lg">
                        Save & Continue
                    </button>

                </form>
            </div>

        </div>

    </div>

</body>

</html>
