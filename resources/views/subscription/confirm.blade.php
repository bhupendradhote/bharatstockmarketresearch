@extends('layouts.userdashboard')

@section('title', 'Confirm Subscription')

@section('content')
    <div class="max-w-7xl mx-auto px-4 ">

        <h1 class="text-2xl font-semibold mb-8">
            Confirm Your Subscription
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">


            <!-- ================= PLAN CARDS (SCROLLABLE CONTAINER) ================= -->
            <div
                class="lg:col-span-2
                    max-h-[85vh]   /* 👈 80–90% viewport height */
                    overflow-y-auto
                    pr-2
                    scrollbar-thin
                    scrollbar-thumb-[#0939a4]
                    scrollbar-track-transparent">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    @foreach ($plans as $plan)
                        @php
                            $durations = $plan->durations->values();
                        @endphp

                        <div
                            class="rounded-[24px] p-6 bg-[#eef1ff] border transition
                    {{ $selectedPlan->id === $plan->id ? 'border-blue-600 ring-2 ring-blue-200' : 'border-transparent' }}">

                            <!-- PLAN TITLE -->
                            <h3 class="text-lg font-bold text-[#0939a4] mb-1">
                                {{ $plan->name }}
                            </h3>

                            <!-- PRICE (SELECTED DURATION) -->
                            <p class="text-2xl font-black text-gray-900 mb-1">
                                ₹{{ number_format($selectedPlan->id === $plan->id ? $selectedDuration->price : $durations[0]->price, 2) }}
                                <span class="text-sm font-medium text-gray-500">(inclusive of GST)</span>
                            </p>

                            <p class="text-sm text-gray-500 mb-5">
                                Monthly Subscription based
                            </p>

                            <!-- DURATION BUTTONS -->
                            <div class="flex gap-3 mb-6">
                                @foreach ($durations as $index => $duration)
                                    <a href="{{ route('subscription.confirm', [
                                        'plan' => $plan->id,
                                        'duration' => $index,
                                    ]) }}"
                                        class="px-5 py-2 rounded-full text-sm font-bold transition
                               {{ $selectedPlan->id === $plan->id && $selectedDuration->id === $duration->id
                                   ? 'bg-[#0939a4] text-white shadow'
                                   : 'bg-white text-gray-700 hover:bg-blue-50' }}">
                                        {{ $duration->duration }}
                                    </a>
                                @endforeach
                            </div>

                            <!-- FEATURES -->
                            <div class="mt-6">
                                <h4 class="text-sm font-bold mb-3 text-gray-700">Features</h4>

                                <ul class="space-y-2 text-sm">
                                    @php
                                        // Jis duration ko user ne select kiya hai ya phir pehli duration ke features
                                        $currentFeatures =
                                            $selectedPlan->id === $plan->id
                                                ? $selectedDuration->features
                                                : $durations[0]->features;
                                    @endphp

                                    @foreach ($currentFeatures as $feature)
                                        <li class="flex justify-between items-start gap-4">
                                            <span class="text-gray-600 text-left">
                                                {{ $feature->text }}
                                            </span>

                                            {{-- Dynamic Icon logic based on svg_icon column --}}
                                            <span
                                                class="font-bold flex-shrink-0 
                    {{ $feature->svg_icon === '✖' ? 'text-red-500' : ($feature->svg_icon === '✔' ? 'text-green-600' : 'text-blue-600') }}">
                                                {{ $feature->svg_icon ?? '✔' }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- ================= ORDER SUMMARY ================= -->
            <div class="bg-white rounded-2xl border p-6 space-y-4 h-fit shadow-sm">

                <h3 class="text-lg font-bold">Order Summary</h3>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Plan</span>
                    <span class="font-semibold">{{ $selectedPlan->name }}</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Duration</span>
                    <span class="font-semibold">{{ $selectedDuration->duration }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Price</span>
                    <span class="font-black text-xl">
                        ₹{{ number_format($selectedDuration->price, 2) }}
                    </span>
                </div>

                <hr>

                <button id="payBtn" data-plan="{{ $selectedPlan->id }}" data-duration="{{ $selectedDuration->id }}"
                    class="w-full mt-2 px-6 py-3 rounded-full
                       bg-[#0939a4] text-white font-bold
                       hover:bg-blue-800 transition">
                    Pay Now
                </button>

                <p class="text-[10px] text-gray-400 text-center">
                    Secure payment powered by Razorpay
                </p>
            </div>
        </div>
    </div>

    <!-- ================= RAZORPAY ================= -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const payBtn = document.getElementById('payBtn');
            if (!payBtn) return;

            payBtn.addEventListener('click', function() {

                const planId = this.dataset.plan;
                const durationId = this.dataset.duration;

                payBtn.disabled = true;
                payBtn.innerText = 'Processing...';

                fetch("{{ route('subscription.razorpay.initiate') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            plan_id: planId,
                            duration_id: durationId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {

                        if (!data.success) {
                            alert(data.message || 'Unable to initiate payment');
                            payBtn.disabled = false;
                            payBtn.innerText = 'Pay Now';
                            return;
                        }

                        const options = {
                            key: data.key,
                            amount: data.amount,
                            currency: "INR",
                            name: "{{ config('app.name') }}",
                            description: data.description,
                            order_id: data.order_id,

                            handler: function(response) {

                                fetch("{{ route('subscription.razorpay.verify') }}", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({
                                            razorpay_order_id: response
                                                .razorpay_order_id,
                                            razorpay_payment_id: response
                                                .razorpay_payment_id,
                                            razorpay_signature: response
                                                .razorpay_signature,
                                            plan_id: planId,
                                            duration_id: durationId
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(result => {
                                        if (result.success) {
                                            alert(
                                                'Payment verified & subscription activated'
                                            );
                                            window.location.reload();
                                        } else {
                                            alert(result.message || 'Verification failed');
                                        }
                                    });
                            },

                            modal: {
                                ondismiss: function() {
                                    payBtn.disabled = false;
                                    payBtn.innerText = 'Pay Now';
                                }
                            },

                            prefill: data.user,
                            theme: {
                                color: "#1d4ed8"
                            }
                        };

                        new Razorpay(options).open();
                    })
                    .catch(() => {
                        alert('Something went wrong');
                        payBtn.disabled = false;
                        payBtn.innerText = 'Pay Now';
                    });
            });
        });
    </script>
@endsection
