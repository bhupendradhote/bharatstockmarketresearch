@extends('layouts.user')

@section('title', 'Subscription Active')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-20 text-center">

        <div class="bg-white border rounded-3xl p-10">

            <h1 class="text-2xl font-semibold text-green-600 mb-4">
                🎉 Subscription Activated!
            </h1>

            <p class="text-gray-600 mb-6">
                Your plan is now active. You will start receiving tips shortly.
            </p>

            <a href="{{ url('/dashboard') }}"
                class="inline-block px-6 py-3 rounded-full
                  bg-blue-600 text-white font-medium
                  hover:bg-blue-700 transition">
                Go to Dashboard
            </a>

        </div>
    </div>
@endsection
