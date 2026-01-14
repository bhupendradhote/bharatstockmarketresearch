@extends('layouts.app')

@section('content')
    <div class="p-6 space-y-6 text-sm text-gray-700">

        <!-- HEADER -->
        <div class="flex justify-between items-center">
            <h1 class="text-lg font-semibold">Create Market Tip</h1>

            <a href="{{ route('admin.tips.index') }}" class="px-4 py-2 bg-gray-100 rounded text-xs font-semibold">
                Back to Tips
            </a>
        </div>

        <!-- FORM CARD -->
        <form method="POST" action="{{ route('admin.tips.store') }}">
            @csrf

            <div class="bg-white border rounded-xl shadow-sm p-6 space-y-6">

                <!-- BASIC INFO -->
                <div>
                    <h2 class="text-sm font-semibold mb-4">Basic Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="text-xs font-semibold">Stock Name</label>
                            <input type="text" name="stock_name" required
                                class="w-full mt-1 border rounded px-3 py-2 text-xs">
                        </div>

                        <div>
                            <label class="text-xs font-semibold">Exchange</label>
                            <select name="exchange" required class="w-full mt-1 border rounded px-3 py-2 text-xs">
                                <option value="NSE">NSE</option>
                                <option value="BSE">BSE</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold">Call Type</label>
                            <select name="call_type" required class="w-full mt-1 border rounded px-3 py-2 text-xs">
                                <option value="BUY">BUY</option>
                                <option value="SELL">SELL</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold">Category</label>

                            <div class="flex gap-2 mt-1">
                                <select name="category_id" required class="w-full border rounded px-3 py-2 text-xs">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="button"
                                    onclick="document.getElementById('categoryModal').classList.remove('hidden')"
                                    class="px-3 text-xs bg-gray-100 rounded">
                                    + Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PRICE DETAILS -->
                <div>
                    <h2 class="text-sm font-semibold mb-4">Price Details</h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="number" step="0.01" name="entry_price" required placeholder="Entry"
                            class="border rounded px-3 py-2 text-xs">
                        <input type="number" step="0.01" name="target_price" required placeholder="Target"
                            class="border rounded px-3 py-2 text-xs">
                        <input type="number" step="0.01" name="stop_loss" required placeholder="Stop Loss"
                            class="border rounded px-3 py-2 text-xs">
                        <input type="number" step="0.01" name="cmp_price" placeholder="CMP"
                            class="border rounded px-3 py-2 text-xs">
                    </div>
                </div>

                <!-- PLAN ACCESS -->
                <div>
                    <h2 class="text-sm font-semibold mb-4">Plan Access</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($plans as $plan)
                            <div class="border rounded-lg p-4">
                                <p class="font-semibold text-xs mb-2">{{ $plan->name }}</p>

                                <div class="space-y-2 text-xs">
                                    @foreach ($plan->durations as $duration)
                                        <label class="flex items-center gap-2">
                                            <input type="checkbox" name="plan_access[]"
                                                value="{{ $plan->id }}_{{ $duration->id }}">
                                            {{ $duration->duration }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- STATUS & NOTE -->
                <div>
                    <h2 class="text-sm font-semibold mb-4">Status & Notes</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <select name="status" required class="border rounded px-3 py-2 text-xs">
                            <option value="Active">Active</option>
                            <option value="Target Hit">Target Hit</option>
                            <option value="SL Hit">SL Hit</option>
                            <option value="Closed">Closed</option>
                        </select>

                        <textarea name="admin_note" rows="3" placeholder="Optional message"
                            class="md:col-span-2 border rounded px-3 py-2 text-xs"></textarea>
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.tips.index') }}" class="px-5 py-2 bg-gray-100 rounded text-xs font-semibold">
                        Cancel
                    </a>

                    <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded text-xs font-semibold">
                        Publish Tip
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- CATEGORY MODAL -->
    <div id="categoryModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">

        <form method="POST" action="{{ route('admin.tips.category.store') }}"
            class="bg-white w-full max-w-sm rounded-xl p-6">
            @csrf

            <h3 class="text-sm font-semibold mb-4">Create Category</h3>

            <input type="text" name="name" required placeholder="Category name"
                class="w-full border rounded px-3 py-2 text-xs mb-4">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('categoryModal').classList.add('hidden')"
                    class="px-4 py-2 text-xs bg-gray-100 rounded">
                    Cancel
                </button>

                <button type="submit" class="px-4 py-2 text-xs bg-blue-600 text-white rounded">
                    Save
                </button>
            </div>
        </form>
    </div>
@endsection
