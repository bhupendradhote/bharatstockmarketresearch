@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-9xl mx-auto px-4">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Message Campaign</h1>
                <p class="text-xs text-gray-500 uppercase tracking-widest font-semibold mt-1">
                    Broadcast message to all users
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.message-campaigns.index') }}"
                   class="text-sm font-semibold text-gray-400 hover:text-gray-600">
                    Cancel
                </a>

                <button form="campaignForm"
                        class="px-6 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow">
                    Send Campaign
                </button>
            </div>
        </div>

        <!-- ERRORS -->
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <form id="campaignForm"
              action="{{ route('admin.message-campaigns.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            @csrf

            <!-- LEFT -->
            <div class="lg:col-span-8 space-y-6">

                <!-- CONTENT -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">
                        Campaign Content
                    </div>

                    <div class="p-5 space-y-5">

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                Title *
                            </label>
                            <input type="text" name="title" required
                                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                Description
                            </label>
                            <input type="text" name="description"
                                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                Short Message (Toast)
                            </label>
                            <input type="text" name="message"
                                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                Full Content *
                            </label>
                            <textarea name="content" rows="4" required
                                      class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm resize-none
                                             focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none"></textarea>
                        </div>
                    </div>
                </div>

             
            </div>

            <!-- RIGHT -->
            <div class="lg:col-span-4 space-y-6">

                <!-- SETTINGS -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">
                        Campaign Settings
                    </div>

                    <div class="p-5 space-y-4">

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                Type
                            </label>
                            <select name="type"
                                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                           focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                                <option value="info">Info</option>
                                <option value="success">Success</option>
                                <option value="warning">Warning</option>
                                <option value="danger">Danger</option>
                                <option value="offer">Offer</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                Start Time
                            </label>
                            <input type="datetime-local" name="starts_at"
                                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">
                                End Time
                            </label>
                            <input type="datetime-local" name="ends_at"
                                   class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm
                                          focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>

                    </div>
                </div>
              <!-- IMAGE -->
<div class="bg-white border border-gray-200 rounded-xl shadow-sm">
    <div class="px-5 py-3 border-b bg-gray-50 text-xs font-bold uppercase tracking-widest text-gray-400">
        Campaign Image
    </div>

    <div class="p-5 space-y-3">
        <label class="block text-xs font-semibold text-gray-500 uppercase">
            Image (Optional)
        </label>

        <!-- Preview Box -->
        <div id="imagePreviewBox"
             class="hidden relative w-full h-40 rounded-lg border border-dashed border-gray-300 bg-gray-50 overflow-hidden">
            <img id="imagePreview"
                 class="w-full h-full object-cover">
            <button type="button"
                    onclick="removeImage()"
                    class="absolute top-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded">
                Remove
            </button>
        </div>

        <!-- Upload Input -->
        <input type="file"
               name="image"
               accept="image/*"
               onchange="previewImage(this)"
               class="block w-full text-sm text-gray-600
                      file:mr-4 file:px-4 file:py-2
                      file:rounded-lg file:border-0
                      file:bg-indigo-50 file:text-indigo-600
                      hover:file:bg-indigo-100">
    </div>
</div>

            </div>
        </form>
    </div>
</div>
@endsection

<script>
function previewImage(input) {
    const previewBox = document.getElementById('imagePreviewBox');
    const previewImg = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewBox.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const input = document.querySelector('input[name="image"]');
    const previewBox = document.getElementById('imagePreviewBox');
    const previewImg = document.getElementById('imagePreview');

    input.value = '';
    previewImg.src = '';
    previewBox.classList.add('hidden');
}
</script>
