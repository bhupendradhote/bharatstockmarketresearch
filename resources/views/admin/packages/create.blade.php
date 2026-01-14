@extends('layouts.app')
@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">

                    <div class="border-b border-gray-200 mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
                            Create New Package
                        </h2>
                    </div>
                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded">
                            {{ session('error') }}
                        </div>
                    @endif


                    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4 sm:space-y-6" id="packageForm">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                            {{-- Package Details --}}
                            <div class="space-y-4">
                                <h3 class="font-bold text-gray-900 text-base border-b pb-2 mb-4">📝 Package Details</h3>

                                {{-- Category & Name --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label for="category_id"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Category *</label>
                                        <div class="flex gap-2 mt-1">
                                            <select id="category_id" name="category_id" required
                                                class="flex-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-1 px-2 text-[13px]">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" onclick="openCategoryModal()"
                                                class="inline-flex items-center px-2 py-1 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                + New
                                            </button>
                                        </div>
                                        @error('category_id')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="name"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Package Name
                                            *</label>
                                        <input id="name" name="name" type="text"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2"
                                            value="{{ old('name') }}" required autofocus />
                                        @error('name')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Amount & Duration --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label for="amount"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Price *</label>
                                        <input id="amount" name="amount" type="number" min="0" step="0.01"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2"
                                            value="{{ old('amount') }}" required />
                                        @error('amount')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                {{-- Features --}}
                                <div>
                                    <label for="features"
                                        class="block font-medium text-xs sm:text-sm text-gray-700">Features (JSON)</label>
                                    <textarea id="features" name="features" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-1 px-2">{{ old('features') }}</textarea>
                                    <small class="text-gray-500 text-xs">Separate each feature with a comma, e.g. Feature1,
                                        Feature2, Feature3</small>


                                    @error('features')
                                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Discount --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label for="discount_percentage"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Discount %</label>
                                        <input id="discount_percentage" name="discount_percentage" type="number"
                                            min="0" max="100"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2"
                                            value="{{ old('discount_percentage') }}" />
                                        @error('discount_percentage')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="discount_amount"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Discount
                                            Amount</label>
                                        <input id="discount_amount" name="discount_amount" type="number" min="0"
                                            step="0.01"
                                            class="mt-1 block w-full border-gray-300 bg-gray-100 cursor-not-allowed focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2"
                                            value="{{ old('discount_amount') }}" readonly />

                                        @error('discount_amount')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Trial Days --}}
                                {{-- Duration, Validity Type & Trial Days --}}
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                                    {{-- Duration --}}
                                    <div>
                                        <label for="duration"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Duration *</label>
                                        <input id="duration" name="duration" type="number" min="1"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2"
                                            value="{{ old('duration') }}" required />
                                        @error('duration')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Validity Type --}}
                                    <div>
                                        <label for="validity_type"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Validity Type
                                            *</label>
                                        <select id="validity_type" name="validity_type" required
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2">
                                            <option value="days" {{ old('validity_type') == 'days' ? 'selected' : '' }}>
                                                Days</option>
                                            <option value="months"
                                                {{ old('validity_type') == 'months' ? 'selected' : '' }}>Months</option>
                                            <option value="years" {{ old('validity_type') == 'years' ? 'selected' : '' }}>
                                                Years</option>
                                        </select>
                                        @error('validity_type')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Trial Days --}}
                                    <div>
                                        <label for="trial_days"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Trial Days</label>
                                        <input id="trial_days" name="trial_days" type="number" min="0"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2"
                                            value="{{ old('trial_days') }}" />
                                        @error('trial_days')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>


                                {{-- Thumbnail --}}
                                <div class="bg-gray-50 p-2 rounded-lg h-full">
                                    <label for="thumbnail"
                                        class="block font-medium text-xs sm:text-sm text-gray-700">Thumbnail Image</label>
                                    <div class="mt-1">
                                        <div id="thumbnailPreview" class="mb-2 hidden w-full">
                                            <img id="previewImage" class="w-full h-32 object-cover rounded-md">
                                        </div>
                                        <input id="thumbnail" name="thumbnail" type="file"
                                            class="block w-full text-xs text-gray-900
                                        file:mr-2 file:py-1 file:px-2
                                        file:rounded-md file:border-0
                                        file:text-xs file:font-semibold
                                        file:bg-indigo-50
                                        file:text-indigo-700
                                        hover:file:bg-indigo-100
                                        cursor-pointer"
                                            accept="image/*" onchange="showThumbnailPreview(event)">
                                        @error('thumbnail')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            {{-- SEO & Description --}}
                            <div class="space-y-4">
                                <h3 class="font-bold text-gray-900 text-base border-b pb-2 mb-4">🔎 SEO & Descriptions</h3>

                                <div>
                                    <label for="description"
                                        class="block font-medium text-xs sm:text-sm text-gray-700">Description *</label>
                                    <textarea id="description" name="description" rows="8"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                                    <div>
                                        <label for="meta_title"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Meta Title</label>
                                        <input id="meta_title" name="meta_title" type="text"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2"
                                            value="{{ old('meta_title') }}" maxlength="60" />
                                        @error('meta_title')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="meta_description"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Meta
                                            Description</label>
                                        <textarea id="meta_description" name="meta_description" rows="2"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2"
                                            maxlength="160">{{ old('meta_description') }}</textarea>
                                        @error('meta_description')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Flags --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                                    <div>
                                        <label><input type="checkbox" name="is_featured" value="1"
                                                {{ old('is_featured') ? 'checked' : '' }}> Featured</label>
                                    </div>
                                    <div>
                                        <label><input type="checkbox" name="status" value="1"
                                                {{ old('status') ? 'checked' : '' }}> Active</label>
                                    </div>
                                </div>

                                {{-- Max Devices & Telegram --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                                    <div>
                                        <label for="max_devices"
                                            class="block font-medium text-xs sm:text-sm text-gray-700">Max Devices</label>
                                        <input type="number" name="max_devices" id="max_devices"
                                            class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm"
                                            value="{{ old('max_devices') }}">
                                        @error('max_devices')
                                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label><input type="checkbox" name="telegram_support" value="1"
                                                {{ old('telegram_support') ? 'checked' : '' }}> Telegram Support</label>
                                    </div>
                                </div>

                                {{-- Sort Order --}}
                                <div class="mt-3">
                                    <label for="sort_order"
                                        class="block font-medium text-xs sm:text-sm text-gray-700">Sort Order</label>
                                    <input type="number" name="sort_order" id="sort_order"
                                        class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm"
                                        value="{{ old('sort_order') }}">
                                    @error('sort_order')
                                        <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        {{-- Submit --}}
                        <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-200">
                            <button type="button" onclick="window.history.back()"
                                class="inline-flex items-center px-2 py-1 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Cancel</button>
                            <button type="submit"
                                class="inline-flex items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Save
                                Package</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Category Modal --}}
    <div id="categoryModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-sm w-full">
            <div class="p-4 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm sm:text-lg font-semibold text-gray-900">Create New Category</h3>
                    <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="categoryForm" class="space-y-3">
                    @csrf
                    <div>
                        <label for="categoryName" class="block font-medium text-xs sm:text-sm text-gray-700">Category Name
                            *</label>
                        <input id="categoryName" name="name" type="text"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 px-2"
                            required />
                    </div>

                    <div class="flex justify-end gap-2 pt-3">
                        <button type="button" onclick="closeCategoryModal()"
                            class="inline-flex items-center px-2 py-1 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Cancel</button>
                        <button type="submit"
                            class="inline-flex items-center px-2 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Thumbnail preview
        window.showThumbnailPreview = function(event) {
            const previewBox = document.getElementById('thumbnailPreview');
            const previewImg = document.getElementById('previewImage');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewBox.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else previewBox.classList.add('hidden');
        }

        // Category modal
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            document.getElementById('categoryName').focus();
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.getElementById('categoryForm').reset();
        }

        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('categoryName').value;
            fetch("{{ route('admin.packages_category.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    name
                })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    const select = document.getElementById('category_id');
                    const option = document.createElement('option');
                    option.value = data.category.id;
                    option.text = data.category.name;
                    option.selected = true;
                    select.appendChild(option);
                    closeCategoryModal();
                } else alert(data.message || 'Error creating category');
            }).catch(err => console.error(err));
        });
    </script>

    <script>
        function calculateDiscount() {
            let price = parseFloat(document.getElementById("amount").value) || 0;
            let percent = parseFloat(document.getElementById("discount_percentage").value) || 0;

            // Formula → (price * percent) / 100
            let discount = price - ((price * percent) / 100);


            document.getElementById("discount_amount").value = discount.toFixed(2);
        }

        // Run on typing
        document.getElementById("amount").addEventListener("input", calculateDiscount);
        document.getElementById("discount_percentage").addEventListener("input", calculateDiscount);
    </script>
@endsection
