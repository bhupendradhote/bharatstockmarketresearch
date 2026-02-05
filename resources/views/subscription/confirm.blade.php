@extends('layouts.userdashboard')

@section('title', 'Confirm Subscription')

@section('content')
    <div class="max-w-7xl mx-auto px-4 " x-data="couponHandler()">

        <h1 class="text-2xl font-semibold mb-8">Confirm Your Subscription</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div
                class="lg:col-span-2 max-h-[85vh] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-[#0939a4] scrollbar-track-transparent">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($plans as $plan)
                        @php $durations = $plan->durations->values(); @endphp
                        <div
                            class="rounded-[24px] p-6 bg-[#eef1ff] border transition {{ $selectedPlan->id === $plan->id ? 'border-blue-600 ring-2 ring-blue-200' : 'border-transparent' }}">
                            <h3 class="text-lg font-bold text-[#0939a4] mb-1">{{ $plan->name }}</h3>
                            <p class="text-2xl font-black text-gray-900 mb-1">
                                ₹{{ number_format($selectedPlan->id === $plan->id ? $selectedDuration->price : $durations[0]->price, 2) }}
                                <span class="text-sm font-medium text-gray-500">(inclusive of GST)</span>
                            </p>
                            <p class="text-sm text-gray-500 mb-5">Monthly Subscription based</p>

                            <div class="flex gap-3 mb-6">
                                @foreach ($durations as $index => $duration)
                                    <a href="{{ route('subscription.confirm', ['plan' => $plan->id, 'duration' => $index]) }}"
                                        class="px-5 py-2 rounded-full text-sm font-bold transition {{ $selectedPlan->id === $plan->id && $selectedDuration->id === $duration->id ? 'bg-[#0939a4] text-white shadow' : 'bg-white text-gray-700 hover:bg-blue-50' }}">
                                        {{ $duration->duration }}
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                <h4 class="text-sm font-bold mb-3 text-gray-700">Features</h4>
                                <ul class="space-y-2 text-sm">
                                    @php
                                        $currentFeatures =
                                            $selectedPlan->id === $plan->id
                                                ? $selectedDuration->features
                                                : $durations[0]->features;
                                    @endphp
                                    @foreach ($currentFeatures as $feature)
                                        <li class="flex justify-between items-start gap-4">
                                            <span class="text-gray-600 text-left">{{ $feature->text }}</span>
                                            <span
                                                class="font-bold flex-shrink-0 {{ $feature->svg_icon === '✖' ? 'text-red-500' : ($feature->svg_icon === '✔' ? 'text-green-600' : 'text-blue-600') }}">
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

                <div class="pt-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Have a coupon?</label>
                    <div class="flex gap-2 mt-1">
                        <input type="text" id="coupon_code" placeholder="ENTER CODE"
                            class="flex-1 border-2 border-dashed border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-blue-500 outline-none uppercase font-bold">
                        <button type="button" id="applyCouponBtn"
                            class="px-4 py-2 bg-gray-800 text-white rounded-xl text-sm font-bold hover:bg-black transition">
                            Apply
                        </button>
                    </div>
                    <div id="coupon_msg" class="text-[11px] mt-1 hidden"></div>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="text-gray-500">Total Price</span>
                    <span id="display_price" class="font-black text-xl text-indigo-700">
                        ₹{{ number_format($selectedDuration->price, 2) }}
                    </span>
                </div>

                <hr class="border-dashed">

                <button id="payBtn" data-plan="{{ $selectedPlan->id }}" data-duration="{{ $selectedDuration->id }}"
                    class="w-full mt-2 px-6 py-3 rounded-xl bg-[#0939a4] text-white font-bold hover:bg-blue-800 transition shadow-lg shadow-blue-100">
                    Pay Now
                </button>

                <p class="text-[10px] text-gray-400 text-center">Secure payment powered by Razorpay</p>
            </div>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payBtn = document.getElementById('payBtn');
            const couponInput = document.getElementById('coupon_code');
            const couponMsg = document.getElementById('coupon_msg');

            if (!payBtn) return;

            payBtn.addEventListener('click', function() {
                const planId = this.dataset.plan;
                const durationId = this.dataset.duration;
                const couponCode = couponInput.value.trim();

                payBtn.disabled = true;
                payBtn.innerText = 'Processing...';
                couponMsg.classList.add('hidden');

                fetch("{{ route('subscription.razorpay.initiate') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            plan_id: planId,
                            duration_id: durationId,
                            coupon_code: couponCode // 👈 Sending coupon to backend
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) {
                            // Show coupon or logic error
                            couponMsg.innerText = data.message || 'Unable to initiate payment';
                            couponMsg.className = "text-[11px] mt-1 text-red-500 block font-medium";

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
                                            duration_id: durationId,
                                            coupon_code: couponCode
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(result => {
                                        if (result.success) {
                                            window.location.href =
                                                "/dashboard?subscribed=success";
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
                                color: "#0939a4"
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const applyBtn = document.getElementById('applyCouponBtn'); // Ensure your button has this ID
            const couponInput = document.getElementById('coupon_code');
            const couponMsg = document.getElementById('coupon_msg');
            const displayPrice = document.getElementById('display_price'); // The span showing the price
            const payBtn = document.getElementById('payBtn');

            applyBtn.addEventListener('click', function() {
                const code = couponInput.value.trim();
                const durationId = payBtn.dataset.duration;

                if (!code) return;

                applyBtn.disabled = true;
                applyBtn.innerText = 'Applying...';

                fetch("{{ route('subscription.coupon.apply') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            coupon_code: code,
                            duration_id: durationId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        applyBtn.disabled = false;
                        applyBtn.innerText = 'Apply';
                        couponMsg.classList.remove('hidden');

                        if (data.success) {
                            // Update UI
                            couponMsg.innerText = data.message;
                            couponMsg.className = "text-[11px] mt-1 text-green-600 block font-medium";
                            displayPrice.innerText = '₹' + data.new_total;

                            // Store the code in the Pay Button so initiateRazorpay can find it
                            payBtn.dataset.coupon = code;
                        } else {
                            couponMsg.innerText = data.message;
                            couponMsg.className = "text-[11px] mt-1 text-red-500 block font-medium";
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        applyBtn.disabled = false;
                        applyBtn.innerText = 'Apply';
                    });
            });
        });
    </script>
@endsection
