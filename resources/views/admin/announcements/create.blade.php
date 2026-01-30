@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-1 px-2 sm:px-6 lg:px-8">
    <div class="max-w-9xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-4">
            <h1 class="text-2xl font-bold text-[#0939a4]">Post Announcement</h1>
            <p class="mt-2 text-sm text-gray-600">Create a new update for the user dashboard feed.</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Form Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('admin.announcements.store') }}" method="POST" class="p-4 space-y-3">
                @csrf

                {{-- Title Input --}}
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700">Announcement Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border"
                        placeholder="e.g., New Notification Center Launched">
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Type Selector --}}
                    <div>
                        <label for="type" class="block text-sm font-bold text-gray-700">Category Type</label>
                        <select name="type" id="type" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border bg-white">
                            <option value="" disabled selected>Select a type...</option>
                            <option value="Features" {{ old('type') == 'Features' ? 'selected' : '' }}>Features</option>
                            <option value="Service Update" {{ old('type') == 'Service Update' ? 'selected' : '' }}>Service Update</option>
                            <option value="Others" {{ old('type') == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date Picker --}}
                    <div>
                        <label for="published_at" class="block text-sm font-bold text-gray-700">Publish Date</label>
                        <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border text-gray-500">
                        <p class="mt-1 text-[10px] text-gray-400">Leave blank to publish immediately.</p>
                        @error('published_at')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Short Content (Summary) --}}
                <div>
                    <label for="content" class="block text-sm font-bold text-gray-700">
                        Short Summary 
                        <span class="text-xs font-normal text-gray-400 ml-1">(Visible in the list view)</span>
                    </label>
                    <textarea name="content" id="content" rows="2" maxlength="255" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border"
                        placeholder="Briefly describe the update (Max 255 chars)...">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Full Detail --}}
                <div>
                    <label for="detail" class="block text-sm font-bold text-gray-700">
                        Full Details
                        <span class="text-xs font-normal text-gray-400 ml-1">(Visible when clicked)</span>
                    </label>
                    <textarea name="detail" id="detail" rows="6" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border font-mono"
                        placeholder="Enter the complete details here.&#10;• You can use bullet points&#10;• And multiple lines">{{ old('detail') }}</textarea>
                    @error('detail')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="pt-4 flex items-center justify-end gap-4 border-t border-gray-50">
                    <button type="reset" class="text-sm font-medium text-gray-500 hover:text-gray-700">Reset</button>
                    <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-full shadow-sm text-white bg-[#0939a4] hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Publish Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection