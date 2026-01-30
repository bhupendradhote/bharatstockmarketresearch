@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-1 px-4 sm:px-6 lg:px-8">
    <div class="max-w-9xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-[#0939a4]">Edit Announcement</h1>
                <p class="mt-2 text-sm text-gray-600">Update the details for this notification.</p>
            </div>
            <a href="{{ route('admin.announcements.index') }}" class="text-sm font-bold text-gray-500 hover:text-[#0939a4]">
                &larr; Back to List
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" class="p-4 space-y-3">
                @csrf
                @method('PUT') {{-- Important for Updates --}}

                {{-- Title Input --}}
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700">Announcement Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border">
                    @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Type Selector --}}
                    <div>
                        <label for="type" class="block text-sm font-bold text-gray-700">Category Type</label>
                        <select name="type" id="type" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border bg-white">
                            <option value="Features" {{ old('type', $announcement->type) == 'Features' ? 'selected' : '' }}>Features</option>
                            <option value="Service Update" {{ old('type', $announcement->type) == 'Service Update' ? 'selected' : '' }}>Service Update</option>
                            <option value="Others" {{ old('type', $announcement->type) == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                        @error('type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Date Picker --}}
                    <div>
                        <label for="published_at" class="block text-sm font-bold text-gray-700">Publish Date</label>
                        <input type="datetime-local" name="published_at" id="published_at" 
                            value="{{ old('published_at', $announcement->published_at ? $announcement->published_at->format('Y-m-d\TH:i') : '') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border text-gray-500">
                        @error('published_at') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Short Content --}}
                <div>
                    <label for="content" class="block text-sm font-bold text-gray-700">Short Summary</label>
                    <textarea name="content" id="content" rows="2" maxlength="255" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border">{{ old('content', $announcement->content) }}</textarea>
                    @error('content') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Full Detail --}}
                <div>
                    <label for="detail" class="block text-sm font-bold text-gray-700">Full Details</label>
                    <textarea name="detail" id="detail" rows="6" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 border font-mono">{{ old('detail', $announcement->detail) }}</textarea>
                    @error('detail') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Actions --}}
                <div class="pt-4 flex items-center justify-end gap-4 border-t border-gray-50">
                    <a href="{{ route('admin.announcements.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Cancel</a>
                    <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-full shadow-sm text-white bg-[#0939a4] hover:bg-blue-800 transition-colors">
                        Update Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection