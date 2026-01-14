@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Offer Banners</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Manage homepage promotional banners
                </p>
            </div>

            <a href="{{ route('admin.offer-banners.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700">
                + Add Banner
            </a>@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Offer Banners</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Manage homepage promotional banners
                    </p>
                </div>

                <a href="{{ route('admin.offer-banners.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700">
                    + Add Banner
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table Card -->
            <div class="bg-white rounded-xl shadow overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left">Banner</th>
                                <th class="px-6 py-3 text-left">Heading</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Position</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">
                            @forelse($banners as $banner)
                                <tr class="hover:bg-gray-50">
                                    <!-- Image -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <img src="{{ $banner->desktop_image_url ?? 'https://via.placeholder.com/120x60' }}"
                                                alt="Banner" class="w-28 h-14 object-cover rounded-md border" />
                                        </div>
                                    </td>

                                    <!-- Heading -->
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800">
                                            {{ $banner->heading }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $banner->sub_heading }}
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.offer-banners.toggle-status', $banner->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="transition-opacity hover:opacity-80">
                                                @if ($banner->is_active)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-green-500"></span>
                                                        Active
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-red-500"></span>
                                                        Inactive
                                                    </span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>

                                    <!-- Position -->
                                    <td class="px-6 py-4 text-center text-gray-700">
                                        {{ $banner->position }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('admin.offer-banners.edit', $banner->id) }}"
                                                class="px-3 py-1.5 text-xs font-medium text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.offer-banners.destroy', $banner->id) }}"
                                                method="POST" onsubmit="return confirm('Delete this banner?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1.5 text-xs font-medium text-red-600 border border-red-200 rounded-lg hover:bg-red-50">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        No offer banners found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3 text-left">Banner</th>
                            <th class="px-6 py-3 text-left">Heading</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Position</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($banners as $banner)
                            <tr class="hover:bg-gray-50">
                                <!-- Image -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img
                                            src="{{ $banner->desktop_image_url ?? 'https://via.placeholder.com/120x60' }}"
                                            alt="Banner"
                                            class="w-28 h-14 object-cover rounded-md border"
                                        />
                                    </div>
                                </td>

                                <!-- Heading -->
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">
                                        {{ $banner->heading }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $banner->sub_heading }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 text-center">
                                    @if($banner->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <!-- Position -->
                                <td class="px-6 py-4 text-center text-gray-700">
                                    {{ $banner->position }}
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="#"
                                           class="px-3 py-1.5 text-xs font-medium text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50">
                                            Edit
                                        </a>

                                        <form action="#" method="POST" onsubmit="return confirm('Delete this banner?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 text-xs font-medium text-red-600 border border-red-200 rounded-lg hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    No offer banners found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
