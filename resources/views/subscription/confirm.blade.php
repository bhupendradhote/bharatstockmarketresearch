@extends('layouts.user')

@section('title', 'Confirm Subscription')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-16">

        <h1 class="text-2xl font-semibold mb-6">
            Confirm Your Subscription
        </h1>

        <div class="bg-white rounded-2xl border p-6 space-y-4">

            <div class="flex justify-between">
                <span class="text-gray-600">Plan</span>
                <span class="font-medium">{{ $plan->name }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-600">Duration</span>
                <span class="font-medium">{{ $duration->duration }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-600">Price</span>
                <span class="font-semibold text-lg">
                    ₹{{ number_format($duration->price) }}
                </span>
            </div>

            <hr>

            <form method="POST" action="{{ route('subscription.pay') }}">
                @csrf

                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                <input type="hidden" name="duration_id" value="{{ $duration->id }}">

                <button type="submit"
                    class="w-full mt-4 px-6 py-3 rounded-full
                       bg-blue-600 text-white font-medium
                       hover:bg-blue-700 transition">
                    Pay Now (Dummy)
                </button>
            </form>

        </div>
    </div>
@endsection
