@extends('layouts.app')

@section('content')
    <div class="container mx-auto ">
        <div class="bg-white shadow-lg rounded-xl p-8 border-t-4 border-orange-500">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit & Update: {{ $policy->name }}</h2>
                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-bold">
                    Current: v{{ $policy->activeContent->version_number ?? '1' }}
                </span>
            </div>

            <form action="{{ route('admin.policies.update', $policy->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block font-bold mb-2">Policy Name</label>
                        <input type="text" name="name" value="{{ $policy->name }}" class="w-full border p-2 rounded"
                            required>
                    </div>
                    <div>
                        <label class="block font-bold mb-2">Display Title</label>
                        <input type="text" name="title" value="{{ $policy->title }}" class="w-full border p-2 rounded">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2">SEO Description</label>
                    <textarea name="description" rows="2" class="w-full border p-2 rounded">{{ $policy->description }}</textarea>
                </div>

                <div class="mb-6 bg-blue-50 p-4 border border-blue-200 rounded">
                    <label class="block font-bold text-blue-800 mb-2 underline">✨ What is changing in this new
                        version?</label>
                    <textarea name="updates_summary" rows="3" class="w-full border-blue-300 p-2 rounded"
                        placeholder="Example: Changed section 4.2 for better clarity on data usage..."></textarea>
                    <p class="text-xs text-blue-600 mt-1 italic font-medium">Note: These highlights will be shown to users
                        at the top of the policy.</p>
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2 uppercase">Policy Content</label>
                    <textarea id="editor" name="content">
                    {!! $policy->activeContent->content ?? '' !!}
                </textarea>
                </div>

                <div class="flex justify-end pt-4 border-t space-x-3">
                    <a href="{{ route('admin.policies.index') }}" class="py-3 px-6 text-gray-600">Cancel</a>
                    <button type="submit"
                        class="bg-orange-600 text-white font-bold py-3 px-10 rounded-lg shadow-md hover:bg-orange-700">
                        Publish New Version (v{{ ($policy->activeContent->version_number ?? 0) + 1 }})
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#editor')).catch(error => console.error(error));
    </script>
@endsection
