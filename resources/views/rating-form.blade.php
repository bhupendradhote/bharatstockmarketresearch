@extends('layouts.user')

@section('title', 'Reviews and Ratings')

@section('content')

    <div x-data="reviewLocation()" x-init="initLocation()" class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
        <div class="max-w-5xl w-full grid md:grid-cols-2 gap-12 items-stretch">

            <!-- LEFT CONTENT -->
            <div class="flex flex-col justify-center space-y-6">
                <h1 class="text-3xl md:text-4xl font-bold text-[#2563eb]">
                    We Value Your Feedback!
                </h1>

                <p class="text-gray-600 leading-relaxed">
                    Your experience matters to us. Share your thoughts, rate our services,
                    and help others make informed decisions.
                </p>

                <p class="text-gray-600 leading-relaxed">
                    Upload a photo if you’d like to visually showcase your experience.
                </p>
            </div>

            <!-- RIGHT FORM -->
            <div class="relative bg-white rounded-2xl shadow-xl p-8">

                <!-- SUCCESS MESSAGE -->
                @if (session('success'))
                    <div id="successMessage"
                        class="absolute top-4 left-1/2 -translate-x-1/2 bg-[#005bc1] text-white
                           px-6 py-3 rounded-lg font-semibold shadow-lg animate-slideDown">
                        {{ session('success') }}
                    </div>
                @endif

                <h2 class="text-2xl font-bold text-center text-[#2563eb] mb-2">
                    Submit Your Review
                </h2>

                <p class="text-center text-gray-500 mb-6">
                    We’d love to hear from you
                </p>

                <!-- FORM -->
                <form method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Hidden Location Fields -->
                    <input type="hidden" name="country" x-model="country">
                    <input type="hidden" name="state" x-model="state">
                    <input type="hidden" name="city" x-model="city">

                    <!-- NAME -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Your Name
                        </label>
                        <input type="text" name="name"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm
                               focus:border-[#2563eb] focus:ring-[#2563eb] focus:outline-none"
                            placeholder="Enter your name">
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input type="email" name="email"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm
                               focus:border-[#2563eb] focus:ring-[#2563eb] focus:outline-none"
                            placeholder="Enter your email">
                    </div>

                    <!-- STAR RATING -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Rating
                        </label>

                        <div class="flex flex-row-reverse justify-end gap-1">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating"
                                    value="{{ $i }}" class="hidden peer" required>
                                <label for="star{{ $i }}"
                                    class="text-3xl cursor-pointer text-gray-300
                                       peer-hover:text-[#2563eb] peer-checked:text-[#2563eb]
                                       transition transform hover:scale-110">
                                    ★
                                </label>
                            @endfor
                        </div>
                    </div>

                    <!-- REVIEW -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Your Review
                        </label>
                        <textarea name="review" rows="4" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm
                               focus:border-[#2563eb] focus:ring-[#2563eb] focus:outline-none"
                            placeholder="Write your review..."></textarea>
                    </div>

                    <!-- IMAGE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload an Image (Optional)
                        </label>

                        <div class="relative">
                            <input type="file" name="image" accept="image/*" onchange="previewImage(event)"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                            <div
                                class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-dashed
                                   border-[#2563eb] rounded-xl text-[#2563eb] text-sm font-medium
                                   hover:bg-[#005bc1] hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V12m0 0l5-5 5 5M12 7v9m5 4H7" />
                                </svg>
                                <span>Click to upload image</span>
                            </div>
                        </div>

                        <img id="imagePreview" class="hidden mt-4 mx-auto w-28 h-28 object-cover rounded-xl border">
                    </div>

                    <!-- SUBMIT -->
                    <button type="submit"
                        class="w-full bg-[#005bc1] text-white font-semibold py-3 rounded-xl
                           hover:bg-blue-800 transition transform hover:scale-[1.02]">
                        Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- IMAGE PREVIEW -->
    <script>
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>

    <!-- ALPINE LOCATION SCRIPT -->
    <script>
        function reviewLocation() {
            return {
                country: '',
                state: '',
                city: '',

                initLocation() {
                    fetch('https://ipapi.co/json/')
                        .then(res => res.json())
                        .then(data => {
                            this.country = data.country_name || '';
                            this.state = data.region || '';
                            this.city = data.city || '';
                        })
                        .catch(() => {
                            this.country = '';
                            this.state = '';
                            this.city = '';
                        });
                }
            }
        }
    </script>

    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translate(-50%, -20px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        .animate-slideDown {
            animation: slideDown 0.6s ease forwards;
        }
    </style>

@endsection
