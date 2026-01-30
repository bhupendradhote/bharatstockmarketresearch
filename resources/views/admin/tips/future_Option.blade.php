@extends('layouts.app')

@section('content') <div class="bg-[#f0f2f5] font-sans min-h-screen" x-data="{ showCategoryModal: false }"> <div class="max-w-[1400px] mx-auto ">

        <form action="{{ route('tips.derivative.store') }}" method="POST" id="mainTipForm">
            @csrf

            <input type="hidden" name="tip_type" id="tip_type" value="future">
            <input type="hidden" name="category_id" id="selected_category" value="{{ old('category_id') }}">
            <input type="hidden" name="call_type" id="selected_call" value="{{ old('call_type', 'Buy') }}">
            <input type="hidden" name="option_type" id="selected_option_type" value="{{ old('option_type', 'CE') }}">
            <input type="hidden" name="symbol_token" id="symbol_token" value="{{ old('symbol_token') }}">

            <div class="flex justify-between items-center ">
                <div class="flex gap-2">
                    <a href="{{ route('admin.tips.create') }}"
                        class="w-[12rem] flex items-center space-x-2 bg-blue-700 text-[10px] font-black text-[#fdfdfd] px-3 py-3.5 my-3 rounded-lg border border-blue-100 hover:bg-blue-600 hover:text-white transition-all">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        <span class="tracking-wider">GO TO EQUITY TIPS</span>
                    </a>

                    <a href="{{ route('admin.tips.index') }}"
                        class="w-[12rem] flex items-center space-x-2 bg-blue-700 text-[10px] font-black text-[#fdfdfd] px-3 py-3.5 my-3 rounded-lg border border-blue-100 hover:bg-blue-600 hover:text-white transition-all">
                        <i class="fa-solid fa-list"></i>
                        <span>SHOW ALL TIPS</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[250px_1fr] gap-4">

                <div class="space-y-4">

                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200" x-data="{ deleteMode: false }">

                        <div class="flex justify-between items-center mb-3">
                            <h2
                                class="text-[11px] font-black text-gray-400 uppercase tracking-widest flex items-center">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span> Category
                            </h2>

                            <div class="flex gap-2">
                                <button type="button" @click="showCategoryModal = true"
                                    class="w-6 h-6 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-full hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100">
                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                </button>

                                <button type="button" @click="deleteMode = !deleteMode"
                                    class="w-6 h-6 flex items-center justify-center bg-red-50 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition-all shadow-sm border border-red-100">
                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-1.5">
                            @foreach ($categories as $cat)
                                <div class="relative category-item border border-gray-100 rounded-md p-2 text-[10px] font-bold text-center cursor-pointer select-box hover:bg-gray-50 {{ old('category_id') == $cat->id ? 'active-box' : '' }}"
                                    data-id="{{ $cat->id }}">

                                    <button type="button" x-show="deleteMode" x-transition
                                        @click.stop.prevent="deleteCategory({{ $cat->id }})"
                                        class="absolute -top-1 -right-1 w-4 h-4 bg-red-600 text-white rounded-full">

                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

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
                            @foreach ($plans as $plan)
                                <div class="plan-checkbox">
                                    <input type="checkbox" name="plans[]" value="{{ $plan->id }}"
                                        id="plan_{{ $plan->id }}" class="hidden peer">
                                    <label for="plan_{{ $plan->id }}"
                                        class="block border border-gray-100 rounded-md p-2 text-[10px] font-bold text-center cursor-pointer transition-all peer-checked:bg-[#2a5298] peer-checked:text-white hover:bg-gray-50">
                                        {{ $plan->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-visible relative z-10">

                        <div
                            class="bg-gray-50 border-b border-gray-100 p-3 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center space-x-2 bg-white border rounded-lg p-1">
                                <div class="px-4 py-1.5 text-[11px] font-black cursor-pointer select-box active-box rounded-md"
                                    data-single="instrument" data-type="future">FUTURE</div>
                                <div class="px-4 py-1.5 text-[11px] font-black cursor-pointer select-box rounded-md"
                                    data-single="instrument" data-type="option">OPTION</div>
                            </div>

                            <div class="flex items-center space-x-2 bg-white border rounded-lg p-1">
                                <div class="px-6 py-1.5 text-[11px] font-black cursor-pointer buy-select-box select-box {{ old('call_type', 'Buy') == 'Buy' ? 'buy-active' : '' }} rounded-md"
                                    data-single="trade" data-value="Buy">BUY</div>

                                <div class="px-6 py-1.5 text-[11px] font-black cursor-pointer sell-select-box select-box {{ old('call_type') == 'Sell' ? 'sell-active' : '' }} rounded-md"
                                    data-single="trade" data-value="Sell">SELL</div>
                            </div>
                        </div>

                        <div class="p-6">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                                <div x-data="stockSearchDerivative()" x-init="init()" class="relative">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">
                                        Contract / Script
                                    </label>

                                    <div class="relative">
                                        <input type="text" name="stock_name" x-model="search" @focus="loadStocks"
                                            @input="filterStocks" @click.outside="isOpen = false" autocomplete="off"
                                            required placeholder="e.g. TATASTEEL24FEB"
                                            class="w-full border-b-2 border-gray-100 focus:border-[#2a5298] py-2 text-base font-bold uppercase outline-none transition-all">

                                        <div x-show="isLoading" class="absolute right-0 top-3">
                                            <i class="fa-solid fa-circle-notch fa-spin text-gray-400"></i>
                                        </div>
                                    </div>

                                    <div x-show="isOpen && filteredStocks.length" x-cloak x-transition
                                        class="absolute z-50 w-full bg-white shadow-xl rounded-lg border border-gray-100 max-h-60 overflow-y-auto mt-1">

                                        <template x-for="stock in filteredStocks" :key="stock.token">
                                            <div @click="selectStock(stock)"
                                                class="px-4 py-2 hover:bg-gray-50 cursor-pointer border-b last:border-0 group">

                                                <div class="flex justify-between items-center">
                                                    <span
                                                        class="font-black text-sm text-gray-700 group-hover:text-blue-700"
                                                        x-text="stock.symbol"></span>
                                                    <span class="text-[9px] bg-gray-100 px-1.5 rounded text-gray-500"
                                                        x-text="stock.exch_seg"></span>
                                                </div>

                                                <div class="flex justify-between mt-1">
                                                    <span class="text-[10px] text-gray-400" x-text="stock.name"></span>
                                                    <span class="text-[10px] text-gray-400"
                                                        x-text="stock.expiry"></span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <div x-show="isOpen && !isLoading && filteredStocks.length === 0 && search.length > 1"
                                        class="absolute z-50 w-full bg-white p-3 text-xs text-gray-500 mt-1 rounded-lg shadow">
                                        No contracts found. Try searching another symbols.
                                    </div>
                                    <div x-show="errorMessage" class="text-xs text-red-500 mt-1"
                                        x-text="errorMessage"></div>
                                </div>

                               <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">
                                        Exchange
                                    </label>

                                    <select
                                        name="exchange"
                                        id="exchange_select"
                                        class="w-full border-b-2 border-gray-100 focus:border-[#2a5298] py-2 text-base font-bold outline-none bg-transparent"
                                    >
                                        <option value="NSE">NSE (NFO – NIFTY / BANKNIFTY)</option>
                                        <option value="BSE">BSE (BFO – SENSEX)</option>
                                        <option value="MCX">MCX (Commodities)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Expiry
                                        Date</label>
                                    <input type="date" name="expiry_date" id="expiry_date"
                                        class="w-full border-b-2 border-gray-100 focus:border-[#2a5298] py-2 text-base font-bold outline-none">
                                </div>
                            </div>

                            <div id="optionFields"
                                class="hidden bg-blue-50/50 p-4 rounded-xl border border-blue-100 grid grid-cols-2 gap-6 mb-8 animate-fade-in">
                                <div>
                                    <label class="block text-[10px] font-black text-blue-600 uppercase mb-2">Option
                                        Type</label>
                                    <div class="flex bg-white rounded-lg p-1 border border-blue-200">
                                        <div class="flex-1 py-1.5 text-[10px] font-bold text-center cursor-pointer select-box active-box rounded-md"
                                            data-single="cepe" data-value="CE">CALL (CE)</div>
                                        <div class="flex-1 py-1.5 text-[10px] font-bold text-center cursor-pointer select-box rounded-md"
                                            data-single="cepe" data-value="PE">PUT (PE)</div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-blue-600 uppercase mb-2">Strike
                                        Price</label>
                                    <input type="number" step="0.05" name="strike_price" id="strike_price"
                                        placeholder="0.00"
                                        class="w-full bg-white border border-blue-200 rounded-lg p-2.5 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-400">
                                </div>
                            </div>


                            <div class="flex items-center space-x-4 mb-6">
                                <select
                                    class="calc-mode-selector outline-none border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold">
                                    <option value="percentage">Percentage (%)</option>
                                    <option value="price">Fixed Price (₹)</option>
                                    <option value="fixed_percentage">Fixed % (Auto T2 & SL)</option>
                                </select>
                                <input type="number"
                                    class="manual-target-input manual-t1 outline-none border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold"
                                    placeholder="T1 gap (% or ₹)">
                                <input type="number"
                                    class="manual-target-input manual-t2 outline-none border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold"
                                    placeholder="T2 gap (% or ₹)">

                                <input type="number"
                                    class="manual-sl-input manual-sl outline-none border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold"
                                    placeholder="SL gap (% or ₹)">
                            </div>

                            <div class="bg-gray-900 rounded-2xl p-1 shadow-inner">
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-px">

                                    <div class="bg-white p-4 rounded-tl-xl md:rounded-l-xl">
                                        <label
                                            class="block text-[9px] font-black text-blue-500 uppercase mb-1">Entry
                                            Price</label>
                                        <input type="number" step="0.05" name="entry_price" id="entry_price"
                                            placeholder="0.00" class="w-full text-xl font-black outline-none">
                                    </div>

                                    <div class="bg-white p-4">
                                        <label
                                            class="block text-[9px] font-black text-yellow-600 uppercase mb-1">Current
                                            Market</label>
                                        <div class="relative">
                                            <input type="number" step="0.05" name="cmp_price" id="cmp_price"
                                                placeholder="0.00"
                                                class="w-full text-xl font-black outline-none text-yellow-600">
                                            <div id="price_loader" class="hidden absolute right-0 top-1">
                                                <i class="fa-solid fa-spinner fa-spin text-gray-300 text-xs"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-white p-4">
                                        <label class="block text-[9px] font-black text-green-500 uppercase mb-1">Target
                                            01</label>
                                        <input type="number" step="0.05" name="target_price" id="target_1"
                                            placeholder="0.00"
                                            class="w-full text-xl font-black outline-none text-green-600">
                                    </div>

                                    <div class="bg-white p-4">
                                        <label
                                            class="block text-[9px] font-black text-emerald-600 uppercase mb-1">Target
                                            02</label>
                                        <input type="number" step="0.05" name="target_price_2" id="target_2"
                                            placeholder="0.00"
                                            class="w-full text-xl font-black outline-none text-emerald-700">
                                    </div>

                                    <div class="bg-white p-4 rounded-br-xl md:rounded-r-xl">
                                        <label class="block text-[9px] font-black text-red-500 uppercase mb-1">Stop
                                            Loss</label>
                                        <input type="number" step="0.05" name="stop_loss" id="stop_loss"
                                            placeholder="0.00"
                                            class="w-full text-xl font-black outline-none text-red-600">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex items-center justify-between gap-4">
                                <button type="reset" onclick="window.location.reload()"
                                    class="text-[10px] font-black text-gray-400 hover:text-red-500 uppercase tracking-widest transition-colors">
                                    Clear Draft
                                </button>
                                <button type="submit"
                                    class="bg-[#2a5298] text-white px-12 py-3.5 rounded-xl font-black text-xs shadow-lg hover:shadow-[#2a5298]/30 transition-all uppercase tracking-[2px]">
                                    Publish Tip Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div x-show="showCategoryModal" x-cloak x-transition.opacity
        class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-[110] p-4">
        <div @click.away="showCategoryModal = false"
            class="bg-white w-full max-w-md rounded-[24px] shadow-2xl overflow-hidden border border-gray-100 animate-fade-in">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em]">Create New Category</h3>
                <button @click="showCategoryModal = false"
                    class="text-gray-400 hover:text-gray-900 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <form action="{{ route('admin.tips.category.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Category
                        Name</label>
                    <input type="text" name="name" required autofocus placeholder="e.g. Jackpot, Intraday"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showCategoryModal = false"
                        class="flex-1 py-3.5 bg-gray-100 text-gray-500 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all">Cancel</button>
                    <button type="submit"
                        class="flex-1 py-3.5 bg-emerald-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-100 transition-all">Publish
                        Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script defer src="[https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js](https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js)"></script>
<script>
    window.RISK_MASTER = @json($riskMaster ?? null);
    console.log('Active Risk Master (FNO):', window.RISK_MASTER);
</script>

<script>
    document.querySelectorAll('.select-box').forEach(box => {
        box.addEventListener('click', () => {
            const group = box.dataset.single;
            const isCategory = box.classList.contains('category-item');

            if (isCategory) {
                document.querySelectorAll('.category-item').forEach(b => b.classList.remove(
                    'active-box'));
                box.classList.add('active-box');
                document.getElementById('selected_category').value = box.dataset.id;
                return;
            }

            if (group) {
                document.querySelectorAll(`[data-single="${group}"]`).forEach(b => {
                    b.classList.remove('active-box', 'buy-active', 'sell-active');
                });

                if (group === 'trade') {
                    const val = box.dataset.value;
                    document.getElementById('selected_call').value = val;

                    if (val === 'Buy') {
                        box.classList.add('buy-active');
                    } else {
                        box.classList.add('sell-active');
                    }
                } else {
                    box.classList.add('active-box');
                    if (group === 'instrument') {
                        const type = box.dataset.type;
                        document.getElementById('tip_type').value = type;
                        const optionFields = document.getElementById('optionFields');
                        type === 'option' ? optionFields.classList.remove('hidden') : optionFields
                            .classList.add('hidden');
                        window.dispatchEvent(new CustomEvent('instrument-changed', {
                            detail: {
                                type: type
                            }
                        }));
                    }
                    if (group === 'cepe') document.getElementById('selected_option_type').value = box
                        .dataset.value;
                    if (group === 'exchange') document.getElementById('selected_exchange').value = box
                        .dataset.value;
                }
            }
        });
    });
</script>

<script>
    const entryInput = document.getElementById('entry_price');
    const t1Input = document.getElementById('target_1');
    const t2Input = document.getElementById('target_2');
    const slInput = document.getElementById('stop_loss');
    const callInput = document.getElementById('selected_call');

    function calculateFromRiskMasterFNO() {

        if (!window.RISK_MASTER) {
            console.warn('❌ Risk master not loaded');
            return;
        }

        const entry = parseFloat(entryInput.value);
        if (!entry || entry <= 0) return;

        const isBuy = callInput.value === 'Buy';
        const type = window.RISK_MASTER.calculation_type;

        let t1 = 0,
            t2 = null,
            sl = 0;

        if (type === 'percentage') {

            const t1Gap = window.RISK_MASTER.target1_value;
            const t2Gap = window.RISK_MASTER.target2_value;
            const slGap = window.RISK_MASTER.stoploss_value;

            if (isBuy) {
                t1 = entry + (entry * t1Gap / 100);
                t2 = t2Gap ? entry + (entry * t2Gap / 100) : null;
                sl = entry - (entry * slGap / 100);
            } else {
                t1 = entry - (entry * t1Gap / 100);
                t2 = t2Gap ? entry - (entry * t2Gap / 100) : null;
                sl = entry + (entry * slGap / 100);
            }

        } else {

            const t1Gap = window.RISK_MASTER.target1_value;
            const t2Gap = window.RISK_MASTER.target2_value;
            const slGap = window.RISK_MASTER.stoploss_value;

            if (isBuy) {
                t1 = entry + t1Gap;
                t2 = t2Gap ? entry + t2Gap : null;
                sl = entry - slGap;
            } else {
                t1 = entry - t1Gap;
                t2 = t2Gap ? entry - t2Gap : null;
                sl = entry + slGap;
            }
        }

        t1Input.value = t1.toFixed(2);
        t2Input.value = t2 ? t2.toFixed(2) : '';
        slInput.value = sl.toFixed(2);
    }

    entryInput.addEventListener('input', calculateFromRiskMasterFNO);

    document.querySelectorAll('[data-single="trade"]').forEach(btn => {
        btn.addEventListener('click', () => {
            setTimeout(calculateFromRiskMasterFNO, 50);
        });
    });
</script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('stockSearchDerivative', () => ({
            search: '{{ old('stock_name') }}',
            allStocks: [],
            filteredStocks: [],
            isOpen: false,
            isLoading: false,
            errorMessage: '',
            currentExchange: 'NSE',
            currentInstrument: 'future',

            // index keywords we want to ensure are discoverable
            indexKeywords: ['OPTIDX', 'SENSEX', 'NIFTY', 'BANKNIFTY', 'NIFTYBANK'],

            init() {
                const exchangeSelect = document.getElementById('exchange_select');
                if (exchangeSelect) {
                    this.currentExchange = exchangeSelect.value;
                    exchangeSelect.addEventListener('change', e => {
                        this.currentExchange = e.target.value;
                        this.filterStocks();
                    });
                }
                window.addEventListener('instrument-changed', (e) => {
                    this.currentInstrument = e.detail.type;
                    this.filterStocks();
                });
            },

            async loadStocks() {
                if (this.allStocks.length) {
                    this.isOpen = true;
                    this.filterStocks();
                    return;
                }
                this.isLoading = true;
                this.errorMessage = '';
                this.isOpen = true;

                try {
                    const res = await fetch('/api/proxy/scrips', {
                        cache: 'no-store'
                    });
                    if (!res.ok) throw new Error('Fetch failed');
                    this.allStocks = await res.json();
                } catch (e) {
                    console.error(e);
                    this.errorMessage = 'Unable to load contracts';
                } finally {
                    this.isLoading = false;
                    this.filterStocks();
                }
            },

            // helper: return true if symbol or name matches any index keyword
            isIndexSymbol(s) {
                if (!s) return false;
                const hay = (s.symbol || s.name || '').toUpperCase();
                return this.indexKeywords.some(k => hay.includes(k));
            },

            filterStocks() {
                if (!this.search || this.search.length < 2) {
                    this.filteredStocks = [];
                    return;
                }
                const term = this.search.toUpperCase();
                let out = [];
                // map NSE -> NFO (derivatives), keep other exchanges as-is
                const targetExch = (this.currentExchange === 'NSE') ? 'NFO' : this.currentExchange;

                for (let s of this.allStocks) {
                    const sExch = (s.exch_seg || '').toUpperCase();
                    const name = (s.name || '').toUpperCase();
                    const symbol = (s.symbol || '').toUpperCase();

                    // If the user searches indices (OPTIDX, SENSEX...), allow them regardless of exch_seg
                    const isIndex = this.isIndexSymbol(s);

                    // skip if exchange doesn't match AND it's not an index we want to include for currentExchange
                    if (!isIndex && sExch !== targetExch) continue;

                    if (name.includes(term) || symbol.includes(term)) {
                        // If user selected instrument 'future' restrict to FUT suffix where appropriate
                        if (this.currentInstrument === 'future') {
                            // many futures end with FUT; some index futures might have FUT or simply be indexFUT tokens
                            if (symbol.endsWith('FUT') || /FUT$/.test(symbol) || isIndex) {
                                out.push(s);
                            }
                        } else {
                            // options: include CE/PE or index option tokens
                            if (/CE$|PE$/i.test(symbol) || /CE|PE/i.test(symbol) || isIndex) {
                                out.push(s);
                            }
                        }
                    }

                    if (out.length >= 50) break;
                }
                this.filteredStocks = out;
                this.isOpen = true;
            },

            selectStock(stock) {
                this.search = stock.symbol;
                this.isOpen = false;
                const tokenInput = document.getElementById('symbol_token');
                if (tokenInput) tokenInput.value = stock.token;
                this.parseSymbolData(stock.symbol);
                this.fetchCurrentPrice(stock);
            },

            /**
             * More forgiving symbol parser:
             * - handles typical option formats with CE/PE at the end (or -CE/_CE),
             * - extracts date tokens like 12JAN23, strike like 19000 or 19000.0,
             * - still handles FUT suffixes.
             */
            parseSymbolData(rawSymbol) {
                if (!rawSymbol) return;
                const sym = rawSymbol.toUpperCase();

                // quick detection for CE/PE
                const hasCE = /\bCE\b|CE$/i.test(sym);
                const hasPE = /\bPE\b|PE$/i.test(sym);
                const hasFUT = /FUT$/i.test(sym);

                // Generic date extractor: finds 2 digits + 3 letters + 2 digits e.g. 12JAN23
                const dateMatch = sym.match(/(\d{2}[A-Z]{3}\d{2})/);
                // Strike: sequence of digits possibly with dot, that appears before CE/PE or after date
                const strikeMatch = sym.match(/(\d+(?:\.\d+)?)(?=(CE|PE)\b|CE$|PE$)/i) || sym.match(/(?:\d{2}[A-Z]{3}\d{2})(\d+(?:\.\d+)?)/);

                if (hasCE || hasPE) {
                    this.switchInstrument('option');

                    const dateStr = dateMatch ? dateMatch[1] : null;
                    const strike = strikeMatch ? strikeMatch[1] : '';
                    const type = hasCE ? 'CE' : 'PE';

                    if (dateStr) this.setExpiryDate(dateStr);
                    const strikeEl = document.getElementById('strike_price');
                    if (strikeEl) strikeEl.value = strike;
                    this.selectOptionType(type);
                    return;
                }

                if (hasFUT) {
                    this.switchInstrument('future');

                    const dateStr = dateMatch ? dateMatch[1] : null;
                    if (dateStr) this.setExpiryDate(dateStr);
                    return;
                }

                // Fallback: sometimes index symbols are labeled like "NIFTY" or "SENSEX" with no CE/PE/FUT.
                // In that case, keep current instrument and try to set expiry if present.
                if (dateMatch) {
                    const dateStr = dateMatch[1];
                    this.setExpiryDate(dateStr);
                }
            },

            setExpiryDate(dateStr) {
                if (!dateStr) return;
                const monthMap = {
                    'JAN': '01',
                    'FEB': '02',
                    'MAR': '03',
                    'APR': '04',
                    'MAY': '05',
                    'JUN': '06',
                    'JUL': '07',
                    'AUG': '08',
                    'SEP': '09',
                    'OCT': '10',
                    'NOV': '11',
                    'DEC': '12'
                };
                // dateStr expected like 12JAN23 or 05FEB26
                const day = dateStr.substring(0, 2);
                const mon = dateStr.substring(2, 5).toUpperCase();
                const yr = dateStr.substring(5, 7);
                const mm = monthMap[mon] || '01';
                const formattedDate = `20${yr}-${mm}-${day}`;
                const expiryInput = document.getElementById('expiry_date');
                if (expiryInput) expiryInput.value = formattedDate;
            },

            switchInstrument(type) {
                const tipTypeEl = document.getElementById('tip_type');
                if (tipTypeEl) tipTypeEl.value = type;

                document.querySelectorAll(`[data-single="instrument"]`).forEach(b => b.classList.remove('active-box'));
                const btn = document.querySelector(`[data-single="instrument"][data-type="${type}"]`);
                if (btn) btn.classList.add('active-box');

                const optionFields = document.getElementById('optionFields');
                if (optionFields) {
                    if (type === 'option') optionFields.classList.remove('hidden');
                    else optionFields.classList.add('hidden');
                }

                this.currentInstrument = type;
            },

            selectOptionType(type) {
                const sel = document.getElementById('selected_option_type');
                if (sel) sel.value = type;
                document.querySelectorAll(`[data-single="cepe"]`).forEach(b => b.classList.remove('active-box'));
                const btn = document.querySelector(`[data-single="cepe"][data-value="${type}"]`);
                if (btn) btn.classList.add('active-box');
            },

            async fetchCurrentPrice(stock) {
                const cmpInput = document.getElementById('cmp_price');
                const entryInput = document.getElementById('entry_price');
                const loader = document.getElementById('price_loader');

                if (loader) loader.classList.remove('hidden');
                if (cmpInput) cmpInput.value = '';

                try {
                    // For index derivatives like OPTIDX we still use the derivatives segment (NFO) when exchange= NSE
                    const apiExchange = (this.currentExchange === 'NSE') ? 'NFO' : this.currentExchange;
                    const params = new URLSearchParams({
                        symbol: stock.token,
                        exchange: apiExchange
                    });
                    const response = await fetch(`/api/angel/quote?${params.toString()}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!response.ok) throw new Error("Price fetch failed");
                    const result = await response.json();
                    let ltp = 0;
                    if (result.status && result.data) {
                        const dataPoint = result.data.fetched ? result.data.fetched[0] : result.data;
                        if (dataPoint) ltp = parseFloat(dataPoint.ltp);
                    }
                    if (ltp > 0) {
                        if (cmpInput) cmpInput.value = ltp;
                        if (entryInput) {
                            entryInput.value = ltp;
                            entryInput.dispatchEvent(new Event('input'));
                        }
                    }
                } catch (error) {
                    console.error('Price Error:', error);
                } finally {
                    if (loader) loader.classList.add('hidden');
                }
            }
        }));
    });
</script>


<script>
    (function() {
        const entry = document.getElementById('entry_price');
        const callType = document.getElementById('selected_call');
        const t1Final = document.getElementById('target_1');
        const t2Final = document.getElementById('target_2');
        const slFinal = document.getElementById('stop_loss');
        const modeSelect = document.querySelector('.calc-mode-selector');
        const manualT1 = document.querySelector('.manual-t1');
        const manualT2 = document.querySelector('.manual-t2');
        const manualSL = document.querySelector('.manual-sl');

        if (!entry || !modeSelect || !callType) return;

        function hasManualInput() {
            const mode = modeSelect.value;
            if (mode === 'fixed_percentage') {
                return manualT1 && manualT1.value;
            }
            return (
                (manualT1 && manualT1.value) ||
                (manualT2 && manualT2.value) ||
                (manualSL && manualSL.value)
            );
        }

        function calculatePrice(gapValue, type) {
            const entryPrice = parseFloat(entry.value);
            if (!entryPrice || !gapValue) return '';

            const isBuy = callType.value === 'Buy';
            const mode = modeSelect.value;
            const gap = parseFloat(gapValue);

            let diff = (mode === 'percentage') ?
                (entryPrice * gap / 100) :
                gap;

            if (type === 'target') {
                return isBuy ? entryPrice + diff : entryPrice - diff;
            } else {
                return isBuy ? entryPrice - diff : entryPrice + diff;
            }
        }

        function applyManual() {
            const mode = modeSelect.value;

            if (mode === 'fixed_percentage') {
                const entryPrice = parseFloat(entry.value);
                const gapPercent = parseFloat(manualT1.value);

                if (!isNaN(entryPrice) && !isNaN(gapPercent) && entryPrice > 0) {
                    const isBuy = callType.value === 'Buy';

                    const t1Diff = (entryPrice * gapPercent) / 100;
                    const t2Diff = (entryPrice * (gapPercent * 2)) / 100;

                    const t1Val = isBuy ? entryPrice + t1Diff : entryPrice - t1Diff;
                    const t2Val = isBuy ? entryPrice + t2Diff : entryPrice - t2Diff;
                    const slVal = isBuy ? entryPrice - t1Diff : entryPrice + t1Diff;

                    t1Final.value = t1Val.toFixed(2);
                    t2Final.value = t2Val.toFixed(2);
                    slFinal.value = slVal.toFixed(2);
                }
                return;
            }

            if (manualT1.value) {
                const v = calculatePrice(manualT1.value, 'target');
                if (v !== '') t1Final.value = v.toFixed(2);
            }

            if (manualT2.value) {
                const v = calculatePrice(manualT2.value, 'target');
                if (v !== '') t2Final.value = v.toFixed(2);
            }

            if (manualSL.value) {
                const v = calculatePrice(manualSL.value, 'sl');
                if (v !== '') slFinal.value = v.toFixed(2);
            }
        }

        function smartRecalculate() {
            const mode = modeSelect.value;
            if (mode === 'fixed_percentage') {
                manualT2.disabled = true;
                manualSL.disabled = true;
                manualT2.value = '';
                manualSL.value = '';
                manualT2.placeholder = "Auto Calculated";
                manualSL.placeholder = "Auto Calculated";
            } else {
                manualT2.disabled = false;
                manualSL.disabled = false;
                manualT2.placeholder = "T2 gap (% or ₹)";
                manualSL.placeholder = "SL gap (% or ₹)";
            }

            if (hasManualInput()) {
                applyManual();
            } else {
                if (typeof calculateFromRiskMasterFNO === 'function') {
                    calculateFromRiskMasterFNO();
                }
            }
        }

        [manualT1, manualT2, manualSL].forEach(input => {
            if (!input) return;
            input.addEventListener('input', smartRecalculate);
        });

        entry.addEventListener('input', smartRecalculate);
        modeSelect.addEventListener('change', smartRecalculate);

        document.querySelectorAll('[data-single="trade"]').forEach(btn => {
            btn.addEventListener('click', () => {
                setTimeout(smartRecalculate, 50);
            });
        });
    })();
</script>

<script>
    function deleteCategory(categoryId) {
        if (!confirm('Are you sure you want to delete this category?')) return;

        fetch(`/admin/tips-categories/${categoryId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                }
            })
            .then(() => {
                const el = document.querySelector(`[data-id="${categoryId}"]`);
                if (el) el.remove();
            })
            .catch(error => {
                console.error(error);
                alert('Unable to delete category. Please try again.');
            });
    }
</script>

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

    .active-box {
        background-color: #2a5298 !important;
        color: white !important;
        border-color: #2a5298 !important;
    }

    .buy-active {
        background-color: #10b981 !important;
        color: white !important;
        border-color: #10b981 !important;
    }

    .sell-active {
        background-color: #ef4444 !important;
        color: white !important;
        border-color: #ef4444 !important;
    }
</style>
@endsection