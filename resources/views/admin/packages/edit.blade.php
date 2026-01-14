@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">

                    <div class="border-b border-gray-200 mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
                            Edit Package
                        </h2>
                    </div>

                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-4 sm:space-y-6">

                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                            {{-- Package Details --}}
                            <div class="space-y-4">
                                <h3 class="font-bold text-gray-900 text-base border-b pb-2 mb-4">📝 Package Details</h3>

                                {{-- Category & Name --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Category *</label>
                                        <div class="flex gap-2 mt-1">
                                            <select name="category_id"
                                                class="flex-1 border-gray-300 rounded-md shadow-sm py-1 px-2 text-[13px]">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('category_id', $package->package_type) == $cat->name ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button type="button" onclick="openCategoryModal()"
                                                class="inline-flex items-center px-2 py-1 bg-gray-700 text-white rounded-md text-xs">
                                                + New
                                            </button>
                                        </div>
                                        @error('category_id')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Package Name
                                            *</label>
                                        <input type="text" name="name" value="{{ old('name', $package->name) }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-1 px-2 text-sm" />
                                        @error('name')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Price --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Price *</label>
                                        <input type="number" id="amount" name="amount"
                                            value="{{ old('amount', $package->amount) }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm py-1 px-2 text-sm">
                                        @error('amount')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Features --}}
                                <div>
                                    <label class="block font-medium text-xs sm:text-sm text-gray-700">Features
                                        (JSON)</label>
                                    <textarea name="features" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-1 px-2">{{ old('features', is_array(json_decode($package->features ?? '[]')) ? implode(',', json_decode($package->features)) : '') }}</textarea>
                                    <small class="text-gray-500 text-xs">Separate each feature with a comma, e.g. Feature1,
                                        Feature2, Feature3</small>


                                    <small class="text-gray-500 text-xs">Example: ["Feature1","Feature2"]</small>
                                    @error('features')
                                        <span class="text-red-600 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Discount --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Discount %</label>
                                        <input type="number" name="discount_percentage" id="discount_percentage"
                                            value="{{ old('discount_percentage', $package->discount_percentage) }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm">
                                        @error('discount_percentage')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Discount
                                            Amount</label>
                                        <input type="number" name="discount_amount" id="discount_amount" readonly
                                            value="{{ old('discount_amount', $package->discount_amount) }}"
                                            class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md py-1 px-2 text-sm">
                                        @error('discount_amount')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Duration + Validity + Trial Days --}}
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Duration *</label>
                                        <input type="number" name="duration"
                                            value="{{ old('duration', $package->duration) }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm">
                                        @error('duration')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Validity Type
                                            *</label>
                                        <select name="validity_type"
                                            class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm">
                                            <option value="days"
                                                {{ old('validity_type', $package->validity_type) == 'days' ? 'selected' : '' }}>
                                                Days</option>
                                            <option value="months"
                                                {{ old('validity_type', $package->validity_type) == 'months' ? 'selected' : '' }}>
                                                Months</option>
                                            <option value="years"
                                                {{ old('validity_type', $package->validity_type) == 'years' ? 'selected' : '' }}>
                                                Years</option>
                                        </select>
                                        @error('validity_type')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Trial Days</label>
                                        <input type="number" name="trial_days"
                                            value="{{ old('trial_days', $package->trial_days) }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm">
                                        @error('trial_days')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                {{-- Thumbnail --}}
                                <div class="bg-gray-50 p-2 rounded-lg h-full">
                                    <label class="block font-medium text-xs sm:text-sm text-gray-700">Thumbnail
                                        Image</label>

                                    <div class="mt-1 mb-2">
                                        <div class="mt-1 mb-2">
                                            <img id="previewImage" src="{{ $package->getFirstMediaUrl('image') }}"
                                                class="w-full h-32 object-cover rounded-md mb-2"
                                                style="{{ $package->getFirstMediaUrl('image') ? '' : 'display:none;' }}">
                                        </div>


                                    </div>

                                    <input id="thumbnail" name="thumbnail" type="file" accept="image/*"
                                        class="block w-full text-xs text-gray-900 file:mr-2 file:py-1 file:px-2
                                           file:bg-indigo-50 file:text-indigo-700 rounded-md cursor-pointer">

                                    @error('thumbnail')
                                        <span class="text-red-600 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <script>
                                // Live image preview (replace old with new)
                                document.getElementById('thumbnail').addEventListener('change', function(event) {
                                    let file = event.target.files[0];
                                    let preview = document.getElementById('previewImage');

                                    if (file) {
                                        preview.src = URL.createObjectURL(file);
                                        preview.style.display = 'block';
                                    }
                                });
                            </script>
                            {{-- Right Side: SEO --}}
                            <div class="space-y-4">
                                <h3 class="font-bold text-gray-900 text-base border-b pb-2 mb-4">🔎 SEO & Descriptions</h3>

                                {{-- Description --}}
                                <div>
                                    <label class="block font-medium text-xs sm:text-sm text-gray-700">Description *</label>
                                    <textarea name="description" rows="8"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm py-1 px-2">
{{ old('description', $package->description) }}</textarea>
                                    @error('description')
                                        <span class="text-red-600 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Meta --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Meta
                                            Title</label>
                                        <input type="text" name="meta_title"
                                            value="{{ old('meta_title', $package->meta_title) }}" maxlength="60"
                                            class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm">
                                        @error('meta_title')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Meta
                                            Description</label>
                                        <textarea name="meta_description" maxlength="160" rows="2"
                                            class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm">
{{ old('meta_description', $package->meta_description) }}</textarea>
                                        @error('meta_description')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Flags --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <label>
                                        <input type="checkbox" name="is_featured" value="1"
                                            {{ old('is_featured', $package->is_featured) ? 'checked' : '' }}>
                                        Featured
                                    </label>

                                    <label>
                                        <input type="checkbox" name="status" value="1"
                                            {{ old('status', $package->status) ? 'checked' : '' }}>
                                        Active
                                    </label>
                                </div>

                                {{-- Max Devices + Telegram --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block font-medium text-xs sm:text-sm text-gray-700">Max
                                            Devices</label>
                                        <input type="number" name="max_devices"
                                            value="{{ old('max_devices', $package->max_devices) }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm">
                                    </div>

                                    <label>
                                        <input type="checkbox" name="telegram_support" value="1"
                                            {{ old('telegram_support', $package->telegram_support) ? 'checked' : '' }}>
                                        Telegram Support
                                    </label>
                                </div>

                                {{-- Sort Order --}}
                                <div>
                                    <label class="block font-medium text-xs sm:text-sm text-gray-700">Sort Order</label>
                                    <input type="number" name="sort_order"
                                        value="{{ old('sort_order', $package->sort_order) }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm">
                                </div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-200">
                            <button type="button" onclick="window.history.back()"
                                class="px-2 py-1 border bg-white rounded-md text-xs font-semibold">
                                Cancel
                            </button>

                            <button type="submit"
                                class="px-2 py-1 bg-gray-800 text-white rounded-md text-xs font-semibold">
                                Update Package
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Category Modal --}}
    <div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Create New Category</h3>
                <button onclick="closeCategoryModal()">✕</button>
            </div>

            <form id="categoryForm" class="space-y-3">
                @csrf

                <div>
                    <label class="block text-sm font-medium">Category Name *</label>
                    <input type="text" id="categoryName" required
                        class="mt-1 block w-full border-gray-300 rounded-md py-1 px-2 text-sm">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeCategoryModal()"
                        class="px-2 py-1 border rounded-md text-xs">Cancel</button>

                    <button type="submit" class="px-2 py-1 bg-indigo-600 text-white rounded-md text-xs">Create</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        // Discount auto-calc
        function calculateDiscount() {
            let price = parseFloat(document.getElementById("amount")?.value || 0);
            let percent = parseFloat(document.getElementById("discount_percentage")?.value || 0);

            let discountAmount = price - ((price * percent) / 100);

            if (!isNaN(discountAmount)) {
                document.getElementById("discount_amount").value = discountAmount.toFixed(2);
            }
        }

        document.getElementById("amount")?.addEventListener("input", calculateDiscount);
        document.getElementById("discount_percentage")?.addEventListener("input", calculateDiscount);
    </script>
@endsection
