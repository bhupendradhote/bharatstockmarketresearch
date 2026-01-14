@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white shadow-lg rounded-xl p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Create or Update Policy Version</h2>

            <form action="{{ route('admin.policies.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block font-bold mb-2">Policy Name (Internal)</label>
                        <input type="text" name="name" placeholder="e.g. Privacy Policy"
                            class="w-full border p-2 rounded" required>
                    </div>
                    <div>
                        <label class="block font-bold mb-2">Display Title (Public)</label>
                        <input type="text" name="title" placeholder="e.g. Our Commitment to Privacy"
                            class="w-full border p-2 rounded">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2">Short Description</label>
                    <textarea name="description" rows="2" class="w-full border p-2 rounded"
                        placeholder="Brief intro about this policy..."></textarea>
                </div>

                <div class="mb-6 bg-yellow-50 p-4 border border-yellow-200 rounded">
                    <label class="block font-bold text-yellow-800 mb-2">✨ What's New in this version? (Highlights)</label>
                    <textarea name="updates_summary" rows="3" class="w-full border-yellow-300 p-2 rounded"
                        placeholder="1. Refund days increased to 15&#10;2. UPI added"></textarea>
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2 uppercase">Full Policy Document Content</label>
                    <textarea id="editor" name="content"></textarea>
                </div>

                <div class="flex justify-end pt-4 border-t">
                    <button type="submit"
                        class="bg-green-600 text-white font-bold py-3 px-10 rounded-lg shadow-md hover:bg-green-700">
                        Publish Version & Go Live
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#editor')).catch(error => console.error(error));
    </script>
    <style>
        .ck-editor__editable {
            min-height: 350px;
        }
    </style>
@endsection
