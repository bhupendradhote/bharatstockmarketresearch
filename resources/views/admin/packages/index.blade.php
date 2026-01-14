@extends('layouts.app')

@section('content')

    <!-- Header -->
    <div class="pb-6 border-b mb-6">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Package Management
            </h2>
            <a href="{{ route('admin.packages.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Create New Package
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="mb-6 bg-white shadow-md rounded-lg p-6">
            <form method="GET" action="{{ route('admin.packages.index') }}" class="grid grid-cols-4 gap-6">

                <!-- Search -->
                <div>
                    <label class="text-gray-700 font-medium">Search</label>
                    <input name="search" type="text"
                        class="mt-2 block w-full border-gray-300 bg-white text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2"
                        value="{{ request('search') }}" placeholder="Search package name">
                </div>

                <!-- Status -->
                <div>
                    <label class="text-gray-700 font-medium">Status</label>
                    <select name="status"
                        class="mt-2 block w-full border-gray-300 bg-white text-gray-700 rounded-md shadow-sm px-3 py-2">
                        <option value="">All</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Featured -->
                <div>
                    <label class="text-gray-700 font-medium">Featured</label>
                    <select name="featured"
                        class="mt-2 block w-full border-gray-300 bg-white text-gray-700 rounded-md shadow-sm px-3 py-2">
                        <option value="">All</option>
                        <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured</option>
                        <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                    </select>
                </div>

                <!-- Reset -->
                <div class="flex items-end">
                    <a href="{{ route('admin.packages.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-4 gap-4 mb-6">

            <!-- Total Packages -->
            <div class="bg-white rounded-lg shadow p-4 flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    📦
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Packages</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalPackages }}</p>
                </div>
            </div>

            <!-- Featured -->
            <div class="bg-white rounded-lg shadow p-4 flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    ⭐
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Featured</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $featuredPackages }}</p>
                </div>
            </div>

            <!-- Active -->
            <div class="bg-white rounded-lg shadow p-4 flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    ✔️
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Active</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $activePackages }}</p>
                </div>
            </div>

            <!-- Inactive -->
            <div class="bg-white rounded-lg shadow p-4 flex items-center">
                <div class="p-3 rounded-full bg-red-100">
                    ❌
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Inactive</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $inactivePackages }}</p>
                </div>
            </div>

        </div>

        <!-- Packages Table -->
        <div class="bg-white shadow-sm rounded-lg p-6">

            @if ($packages->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
                        <thead>
                            <tr class="bg-gray-100 text-xs text-gray-600 uppercase tracking-wide">
                                <th class="px-3 py-2 border-b">Package</th>
                                <th class="px-3 py-2 border-b">Dis. Price</th>
                                <th class="px-3 py-2 border-b">Duration</th>
                                <th class="px-3 py-2 border-b">Featured</th>
                                <th class="px-3 py-2 border-b">Status</th>
                                <th class="px-3 py-2 border-b">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white text-[13px]">
                            @foreach ($packages as $package)
                                <tr class="hover:bg-gray-50 border-b">

                                    <!-- Package -->
                                    <td class="px-3 py-2">
                                        <div class="flex items-center space-x-2">

                                            @if ($package->hasMedia('image'))
                                                <img src="{{ $package->getFirstMediaUrl('image') }}"
                                                    class="h-8 w-8 rounded object-cover">
                                            @else
                                                <div class="h-8 w-8 rounded bg-gray-200"></div>
                                            @endif

                                            <div>
                                                <p class="font-medium text-gray-900 leading-tight">
                                                    {{ $package->name }}
                                                </p>
                                                <p class="text-xs text-gray-500 leading-tight">
                                                    {{ Str::limit($package->description, 40) }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Price -->
                                    <td class="px-3 py-2 text-gray-700">
                                        ₹{{ number_format($package->final_amount, 2) }}
                                    </td>

                                    <!-- Duration -->
                                    <td class="px-3 py-2 text-gray-700 text-xs">
                                        {{ $package->duration }} {{ ucfirst($package->validity_type) }}
                                    </td>

                                    <!-- Featured -->
                                    <td class="px-3 py-2">
                                        @if ($package->is_featured)
                                            <span
                                                class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full text-xs">Yes</span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full text-xs">No</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="px-3 py-2">
                                        @if ($package->status)
                                            <span
                                                class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-3 py-2 flex space-x-3 text-xs">
                                        <a href="{{ route('admin.packages.show', $package->id) }}"
                                            class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('admin.packages.edit', $package->id) }}"
                                            class="text-green-600 hover:text-green-900">Edit</a>

                                        <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this package?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                {{-- <div class="mt-6">
                    {{ $packages->links() }}
                </div> --}}
            @else
                <div class="text-center py-12 text-gray-500">
                    No packages found.
                </div>
            @endif

        </div>

    </div>

@endsection
