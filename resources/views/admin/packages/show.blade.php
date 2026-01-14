@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow-xl sm:rounded-lg p-6 space-y-6">

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">{{ $package->name }}</h1>

                {{-- Edit Button --}}
                <a href="{{ route('admin.packages.edit', $package->id) }}"
                    class="text-gray-500 hover:text-gray-800 ml-2 flex items-center text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.232 5.232l3.536 3.536M4 20h4l12-12-4-4L4 16v4z" />
                    </svg>
                </a>
            </div>

            {{-- Category & Status --}}
            <div class="flex flex-wrap gap-4 text-sm text-gray-600 mt-2">
                <span>Category: <strong>{{ $package->package_type ?? 'N/A' }}</strong></span>
                <span>Status: <strong>{{ $package->status ? 'Active' : 'Inactive' }}</strong></span>

                @if ($package->is_featured)
                    <span class="text-indigo-600 font-medium">Featured</span>
                @endif

                @if ($package->trial_days)
                    <span>Trial Days: <strong>{{ $package->trial_days }}</strong></span>
                @endif

                @if ($package->duration)
                    <span>Duration: <strong>{{ $package->duration }} {{ $package->validity_type }}</strong></span>
                @endif
            </div>

            {{-- Prices --}}
            <div class="flex flex-wrap gap-4 mt-2 text-gray-500 text-sm">
                <span>Price: <strong>₹{{ $package->amount }}</strong></span>

                @if ($package->discount_percentage > 0)
                    <span>Discount: <strong>{{ $package->discount_percentage }}%</strong></span>
                @endif

                @if ($package->discount_amount > 0)
                    <span>Discount Amount: <strong>₹{{ $package->discount_amount }}</strong></span>
                @endif

                <span>Final Price: <strong class="text-green-600">₹{{ $package->final_price }}</strong></span>
            </div>

            {{-- Thumbnail --}}
            @if ($media)
                <div class="mt-4">
                    <img src="{{ $media->getUrl() }}" alt="Package Thumbnail"
                        class="w-full object-cover rounded-md max-h-[250px]">
                </div>
            @endif

            {{-- Description --}}
            @if ($package->description)
                <div class="mt-4 p-4 bg-gray-50 rounded-md border border-gray-200">
                    <h3 class="font-semibold text-gray-700 text-sm mb-2">Description</h3>
                    <div class="prose max-w-full text-gray-800">
                        {!! $package->description !!}
                    </div>
                </div>
            @endif

            {{-- Features --}}
            @if ($package->features)
                <div class="mt-4 p-4 bg-gray-50 rounded-md border border-gray-200">
                    <h3 class="font-semibold text-gray-700 text-sm mb-2">Features</h3>

                    @if (is_array($package->features))
                        <ul class="list-disc list-inside text-gray-800">
                            @foreach ($package->features as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-800">{{ $package->features }}</p>
                    @endif
                </div>
            @endif

            {{-- Other Details --}}
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">Max Devices</h4>
                    <p class="text-gray-800">{{ $package->max_devices ?? 'N/A' }}</p>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">Telegram Support</h4>
                    <p class="text-gray-800">{{ $package->telegram_support ? 'Yes' : 'No' }}</p>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 text-sm">Sort Order</h4>
                    <p class="text-gray-800">{{ $package->sort_order }}</p>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="mt-6">
                <a href="{{ route('admin.packages.index') }}" class="px-3 py-1 bg-gray-800 text-white rounded-md text-sm">
                    Back to Packages
                </a>
            </div>

        </div>
    </div>
@endsection
