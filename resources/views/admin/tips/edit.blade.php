@extends('layouts.app')

@section('content')
    <div class="bg-[#f0f2f5] font-sans min-h-screen" x-data="{
        showCategoryModal: false,
        tipType: '{{ old('tip_type', $tip->tip_type) }}'
    }">
        <div class="max-w-[1400px] mx-auto p-4">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-xl font-black text-gray-800 uppercase tracking-tight">Edit Tip <span
                            class="text-blue-600">v{{ $tip->version }}</span></h1>
                    <p class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">Updating: {{ $tip->stock_name }}
                    </p>
                </div>
                <div
                    class="bg-amber-100 border border-amber-200 text-amber-700 px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-wider">
                    ⚠️ Saving will archive v{{ $tip->version }} and create v{{ $tip->version + 1 }}
                </div>
            </div>

            <form action="{{ route('admin.tips.update', $tip->id) }}" method="POST" id="mainTipForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="tip_type" id="tip_type" x-model="tipType">
                <input type="hidden" name="category_id" id="selected_category"
                    value="{{ old('category_id', $tip->category_id) }}">
                <input type="hidden" name="call_type" id="selected_call" value="{{ old('call_type', $tip->call_type) }}">
                <input type="hidden" name="option_type" id="selected_option_type"
                    value="{{ old('option_type', $tip->option_type) }}">

                <div class="grid grid-cols-1 lg:grid-cols-[250px_1fr] gap-4">

                    {{-- SIDEBAR: CATEGORY & PLANS --}}
                    <div class="space-y-4">
                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                            <h2
                                class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span> Category
                            </h2>
                            <div class="grid grid-cols-2 gap-1.5">
                                @foreach ($categories as $cat)
                                    <div class="category-item border border-gray-100 rounded-md p-2 text-[10px] font-bold text-center cursor-pointer select-box hover:bg-gray-50 {{ old('category_id', $tip->category_id) == $cat->id ? 'active-box' : '' }}"
                                        data-id="{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                            <h2
                                class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center">
                                <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span> Visibility
                            </h2>
                            <div class="grid grid-cols-1 gap-1.5">
                                @php $activePlans = $tip->planAccess->pluck('service_plan_id')->toArray(); @endphp
                                @foreach ($plans as $plan)
                                    <div class="plan-checkbox">
                                        <input type="checkbox" name="plans[]" value="{{ $plan->id }}"
                                            id="plan_{{ $plan->id }}" class="hidden peer"
                                            {{ in_array($plan->id, $activePlans) ? 'checked' : '' }}>
                                        <label for="plan_{{ $plan->id }}"
                                            class="block border border-gray-100 rounded-md p-2 text-[10px] font-bold text-center cursor-pointer transition-all peer-checked:bg-[#2a5298] peer-checked:text-white hover:bg-gray-50">
                                            {{ $plan->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- MAIN CONTENT --}}
                    <div class="space-y-4">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div
                                class="bg-gray-50 border-b border-gray-100 p-3 flex flex-wrap items-center justify-between gap-4">
                                {{-- Updated Instrument Selection with Equity --}}
                                <div class="flex items-center space-x-2 bg-white border rounded-lg p-1">
                                    <div class="px-4 py-1.5 text-[11px] font-black cursor-pointer select-box rounded-md {{ old('tip_type', $tip->tip_type) == 'equity' ? 'active-box' : '' }}"
                                        @click="tipType = 'equity'" data-single="instrument" data-type="equity">EQUITY</div>
                                    <div class="px-4 py-1.5 text-[11px] font-black cursor-pointer select-box rounded-md {{ old('tip_type', $tip->tip_type) == 'future' ? 'active-box' : '' }}"
                                        @click="tipType = 'future'" data-single="instrument" data-type="future">FUTURE</div>
                                    <div class="px-4 py-1.5 text-[11px] font-black cursor-pointer select-box rounded-md {{ old('tip_type', $tip->tip_type) == 'option' ? 'active-box' : '' }}"
                                        @click="tipType = 'option'" data-single="instrument" data-type="option">OPTION</div>
                                </div>
 
                              <div class="flex items-center space-x-2 bg-white border rounded-lg p-1">

    <div
        class="px-6 py-1.5 text-[11px] font-black cursor-pointer select-box rounded-md buy-box
        {{ old('call_type', $tip->call_type) == 'Buy' ? 'active-buy' : '' }}"
        data-single="trade"
        data-value="Buy">
        BUY
    </div>

    <div
        class="px-6 py-1.5 text-[11px] font-black cursor-pointer select-box rounded-md sell-box
        {{ old('call_type', $tip->call_type) == 'Sell' ? 'active-sell' : '' }}"
        data-single="trade"
        data-value="Sell">
        SELL
    </div>

</div>

                            </div>

                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">STOCK
                                            Name</label>
                                        <input type="text" name="stock_name"
                                            value="{{ old('stock_name', $tip->stock_name) }}" required
                                            class="w-full border-b-2 border-gray-100 focus:border-[#2a5298] py-2 text-base font-bold uppercase outline-none transition-all">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-black text-gray-400 uppercase mb-1">Exchange</label>
                                        <select name="exchange"
                                            class="w-full border-b-2 border-gray-100 focus:border-[#2a5298] py-2 text-base font-bold outline-none bg-transparent">
                                            <option value="NSE" {{ $tip->exchange == 'NSE' ? 'selected' : '' }}>NSE
                                            </option>
                                            <option value="BSE" {{ $tip->exchange == 'BSE' ? 'selected' : '' }}>BSE
                                            </option>
                                            <option value="MCX" {{ $tip->exchange == 'MCX' ? 'selected' : '' }}>MCX
                                            </option>
                                        </select>
                                    </div>
                                    {{-- Expiry Date: Hidden if Equity --}}
                                    <div x-show="tipType !== 'equity'" x-cloak>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Expiry
                                            Date</label>
                                        <input type="date" name="expiry_date"
                                            value="{{ old('expiry_date', $tip->expiry_date) }}"
                                            class="w-full border-b-2 border-gray-100 focus:border-[#2a5298] py-2 text-base font-bold outline-none">
                                    </div>
                                </div>

                                {{-- OPTION SPECIFIC FIELDS: Only for Option --}}
                                <div id="optionFields" x-show="tipType === 'option'" x-cloak
                                    class="bg-blue-50/50 p-4 rounded-xl border border-blue-100 grid grid-cols-2 gap-6 mb-8 animate-fade-in">
                                    <div>
                                        <label class="block text-[10px] font-black text-blue-600 uppercase mb-2">Option
                                            Type</label>
                                        <div class="flex bg-white rounded-lg p-1 border border-blue-200">
                                            <div class="flex-1 py-1.5 text-[10px] font-bold text-center cursor-pointer select-box rounded-md {{ old('option_type', $tip->option_type) == 'CE' ? 'active-box' : '' }}"
                                                data-single="cepe" data-value="CE">CALL (CE)</div>
                                            <div class="flex-1 py-1.5 text-[10px] font-bold text-center cursor-pointer select-box rounded-md {{ old('option_type', $tip->option_type) == 'PE' ? 'active-box' : '' }}"
                                                data-single="cepe" data-value="PE">PUT (PE)</div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-blue-600 uppercase mb-2">Strike
                                            Price</label>
                                        <input type="number" name="strike_price"
                                            value="{{ old('strike_price', $tip->strike_price) }}" placeholder="0.00"
                                            class="w-full bg-white border border-blue-200 rounded-lg p-2.5 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-400">
                                    </div>
                                </div>

                                {{-- PRICE GRID --}}
                                <div class="bg-gray-900 rounded-2xl p-1 shadow-inner">
                                    <div class="grid grid-cols-2 md:grid-cols-5 gap-px">
                                        <div class="bg-white p-4 rounded-tl-xl md:rounded-l-xl">
                                            <label class="block text-[9px] font-black text-blue-500 uppercase mb-1">Entry
                                                Price</label>
                                            <input type="number" step="0.01" name="entry_price" id="entry_price"
                                                value="{{ old('entry_price', $tip->entry_price) }}"
                                                class="w-full text-xl font-black outline-none">
                                        </div>
                                        <div class="bg-white p-4">
                                            <label
                                                class="block text-[9px] font-black text-yellow-600 uppercase mb-1">Current
                                                Market</label>
                                            <input type="number" step="0.01" name="cmp_price" id="cmp_price"
                                                value="{{ old('cmp_price', $tip->cmp_price) }}"
                                                class="w-full text-xl font-black outline-none text-yellow-600">
                                        </div>
                                        <div class="bg-white p-4">
                                            <label class="block text-[9px] font-black text-green-500 uppercase mb-1">Target
                                                01</label>
                                            <input type="number" step="0.01" name="target_price" id="target_1"
                                                value="{{ old('target_price', $tip->target_price) }}"
                                                class="w-full text-xl font-black outline-none text-green-600">
                                        </div>
                                        <div class="bg-white p-4">
                                            <label
                                                class="block text-[9px] font-black text-emerald-600 uppercase mb-1">Target
                                                02</label>
                                            <input type="number" step="0.01" name="target_price_2" id="target_2"
                                                value="{{ old('target_price_2', $tip->target_price_2) }}"
                                                class="w-full text-xl font-black outline-none text-emerald-700">
                                        </div>
                                        <div class="bg-white p-4 rounded-br-xl md:rounded-r-xl">
                                            <label class="block text-[9px] font-black text-red-500 uppercase mb-1">Stop
                                                Loss</label>
                                            <input type="number" step="0.01" name="stop_loss" id="stop_loss"
                                                value="{{ old('stop_loss', $tip->stop_loss) }}"
                                                class="w-full text-xl font-black outline-none text-red-600">
                                        </div>
                                    </div>
                                </div>

                                {{-- ADMIN NOTES --}}
                                <div class="mt-6">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Admin Remarks
                                        (Version Update Note)</label>
                                    <textarea name="admin_note" rows="3" placeholder="Explain why you are updating this tip..."
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm font-bold outline-none focus:border-blue-500 transition-all">{{ old('admin_note', $tip->admin_note) }}</textarea>
                                </div>

                                <div class="mt-8 flex items-center justify-between gap-4">
                                    <a href="{{ route('admin.tips.index') }}"
                                        class="text-[10px] font-black text-gray-400 hover:text-red-500 uppercase tracking-widest transition-colors">
                                        Discard Changes
                                    </a>
                                    <button type="submit"
                                        class="bg-[#2a5298] text-white px-12 py-3.5 rounded-xl font-black text-xs shadow-lg hover:shadow-[#2a5298]/30 transition-all uppercase tracking-[2px]">
                                        Update to v{{ $tip->version + 1 }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .active-box {
            background-color: #2a5298 !important;
            color: white !important;
            border-color: #2a5298 !important;
        }

        .select-box {
            transition: all 0.15s ease-in-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
<style>
    /* BUY / SELL COLORS */
    .buy-box {
        color: #166534; /* green-800 */
    }

    .sell-box {
        color: #991b1b; /* red-800 */
    }

    .active-buy {
        background-color: #16a34a !important; /* green-600 */
        color: white !important;
        border-color: #16a34a !important;
    }

    .active-sell {
        background-color: #dc2626 !important; /* red-600 */
        color: white !important;
        border-color: #dc2626 !important;
    }
</style>

    <script>
        document.querySelectorAll('.select-box').forEach(box => {
            box.addEventListener('click', () => {
                const group = box.dataset.single;
                if (group) {
                    document.querySelectorAll(`[data-single="${group}"]`).forEach(b => b.classList.remove(
                        'active-box'));
                    box.classList.add('active-box');

                    if (group === 'trade') document.getElementById('selected_call').value = box.dataset
                        .value;
                    if (group === 'cepe') document.getElementById('selected_option_type').value = box
                        .dataset.value;

                    // Specific logic for instrument switch
                    if (group === 'instrument') {
                        const type = box.dataset.type;
                        document.getElementById('tip_type').value = type;
                    }
                }
            });
        });

        document.querySelectorAll('.category-item').forEach(box => {
            box.addEventListener('click', () => {
                document.querySelectorAll('.category-item').forEach(b => b.classList.remove('active-box'));
                box.classList.add('active-box');
                document.getElementById('selected_category').value = box.dataset.id;
            });
        });
document.querySelectorAll('.select-box').forEach(box => {
    box.addEventListener('click', () => {
        const group = box.dataset.single;

        if (group === 'trade') {
            document.querySelectorAll('[data-single="trade"]').forEach(b => {
                b.classList.remove('active-buy', 'active-sell');
            });

            if (box.dataset.value === 'Buy') {
                box.classList.add('active-buy');
            }

            if (box.dataset.value === 'Sell') {
                box.classList.add('active-sell');
            }

            document.getElementById('selected_call').value = box.dataset.value;
            return;
        }

        if (group) {
            document.querySelectorAll(`[data-single="${group}"]`)
                .forEach(b => b.classList.remove('active-box'));

            box.classList.add('active-box');

            if (group === 'cepe')
                document.getElementById('selected_option_type').value = box.dataset.value;

            if (group === 'instrument')
                document.getElementById('tip_type').value = box.dataset.type;
        }
    });
});

    </script>
@endsection
