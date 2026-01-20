@extends('layouts.app')
@section('content')
{{-- Include Alpine.js --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="bg-[#f0f2f5] font-sans min-h-screen" x-data="{ showCategoryModal: false }">
    <div class="max-w-[1400px] mx-auto">
        @if (session('success'))
        <div class="mb-4 p-3 bg-green-500 text-white rounded-lg shadow-md animate-fade-in">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('tips.equity.store') }}" method="POST" id="equityTipForm">
            @csrf
            <input type="hidden" name="tip_type" value="equity">
            <input type="hidden" name="category_id" id="selected_category" value="{{ old('category_id') }}">
            <input type="hidden" name="call_type" id="selected_call" value="{{ old('call_type', 'Buy') }}">
            <input type="hidden" name="exchange" id="selected_exchange" value="{{ old('exchange', 'NSE') }}">
            
            <input type="hidden" name="symbol_token" id="symbol_token" value="{{ old('symbol_token') }}">

            <div class="flex justify-between items-center mb-4">
                <div class="flex gap-2">
                    <a href="{{ route('admin.tips.future_Option') }}"
                        class="w-[12rem] flex items-center space-x-2 bg-blue-700 text-[10px] font-black text-[#fdfdfd] px-3 py-3.5 rounded-lg border border-blue-100 hover:bg-blue-600 hover:text-white transition-all uppercase tracking-wider">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        <span>GO TO FUTURE & OPTION</span>
                    </a>
                    <a href="{{ route('admin.tips.index') }}"
                        class="w-[12rem] flex items-center space-x-2 bg-blue-700 text-[10px] font-black text-[#fdfdfd] px-3 py-3.5 rounded-lg border border-blue-100 hover:bg-blue-600 hover:text-white transition-all uppercase tracking-wider">
                        <i class="fa-solid fa-list"></i>
                        <span>SHOW ALL TIPS</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[250px_1fr] gap-4">
                {{-- Left Sidebar: Category & Visibility --}}
                <div class="space-y-4">
                    {{-- Category Section --}}
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest flex items-center">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span> Category
                            </h2>
                            <button type="button" @click="showCategoryModal = true"
                                class="w-6 h-6 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-full hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-1.5">
                            @foreach ($categories as $cat)
                            <div class="category-item border border-gray-100 rounded-md p-2 text-[10px] font-bold text-center cursor-pointer select-box hover:bg-gray-50 {{ old('category_id') == $cat->id ? 'active-box' : '' }}"
                                data-id="{{ $cat->id }}">
                                {{ $cat->name }}
                            </div>
                            @endforeach
                        </div>
                        @error('category_id')
                        <p class="text-red-500 text-[10px] mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Visibility Plans --}}
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
                        <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span> Visibility
                        </h2>
                        <div class="grid grid-cols-1 gap-1.5">
                            @foreach ($plans as $plan)
                            <div class="plan-checkbox">
                                <input type="checkbox" name="plans[]" value="{{ $plan->id }}"
                                    id="plan_{{ $plan->id }}" class="hidden peer"
                                    {{ is_array(old('plans')) && in_array($plan->id, old('plans')) ? 'checked' : '' }}>
                                <label for="plan_{{ $plan->id }}"
                                    class="block border border-gray-100 rounded-md p-2 text-[10px] font-bold text-center cursor-pointer transition-all peer-checked:bg-[#2a5298] peer-checked:text-white hover:bg-gray-50">
                                    {{ $plan->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Main Form Area --}}
                <div class="space-y-4">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-visible z-10 relative">
                        <div class="bg-gray-50 border-b border-gray-100 p-3 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center">
                                <span class="text-[11px] font-black text-[#2a5298] uppercase tracking-wider">Equity Cash Tip</span>
                            </div>
                            {{-- Buy/Sell Toggle --}}
                            <div class="flex items-center space-x-2 bg-white border rounded-lg p-1">
                                    {{-- BUY Button --}}
                                    <div class="px-6 py-1.5 text-[11px] font-black cursor-pointer buy-select-box select-box {{ old('call_type', 'Buy') == 'Buy' ? 'buy-active' : '' }} rounded-md"
                                        data-single="trade" data-value="Buy">BUY</div>

                                    {{-- SELL Button --}}
                                    <div class="px-6 py-1.5 text-[11px] font-black cursor-pointer sell-select-box select-box {{ old('call_type') == 'Sell' ? 'sell-active' : '' }} rounded-md"
                                        data-single="trade" data-value="Sell">SELL</div>
                                </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                
                                {{-- SEARCHABLE STOCK DROPDOWN (Alpine Component) --}}
                                <div x-data="stockSearch()" x-init="init()" class="relative">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Stock Name</label>
                                    
                                    <div class="relative">
                                        <input 
                                            type="text" 
                                            name="stock_name" 
                                            x-model="search"
                                            @focus="loadStocks"
                                            @input="filterStocks"
                                            @click.outside="isOpen = false"
                                            autocomplete="off"
                                            required
                                            class="w-full border-b-2 border-gray-100 focus:border-[#2a5298] py-2 text-base font-bold uppercase outline-none transition-all placeholder-gray-300"
                                            placeholder="SEARCH SYMBOL (e.g. RELIANCE)">
                                            
                                        {{-- Loading Indicator --}}
                                        <div x-show="isLoading" class="absolute right-0 top-3">
                                            <i class="fa-solid fa-circle-notch fa-spin text-gray-400"></i>
                                        </div>
                                    </div>

                                    {{-- Dropdown Results --}}
                                    <div x-show="isOpen && filteredStocks.length > 0" 
                                         x-transition
                                         class="absolute z-50 w-full bg-white shadow-xl rounded-b-lg border border-gray-100 max-h-60 overflow-y-auto mt-1">
                                        <template x-for="stock in filteredStocks" :key="stock.token">
                                            <div @click="selectStock(stock)" 
                                                 class="px-4 py-2 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-0 group">
                                                <div class="flex justify-between items-center">
                                                    {{-- Displaying Name (RELIANCE) --}}
                                                    <span class="text-sm font-black text-gray-800 group-hover:text-[#2a5298]" x-text="stock.name"></span>
                                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-gray-100 text-gray-500" x-text="stock.exch_seg"></span>
                                                </div>
                                                {{-- Displaying Symbol (RELIANCE-EQ) --}}
                                                <div class="flex justify-between mt-0.5">
                                                    <span class="text-[10px] text-gray-400 font-semibold" x-text="stock.symbol"></span>
                                                    <span class="text-[9px] text-gray-300" x-text="'Token: ' + stock.token"></span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <div x-show="isOpen && !isLoading && filteredStocks.length === 0 && search.length > 1" 
                                         class="absolute z-50 w-full bg-white shadow-xl p-3 text-xs text-gray-500 mt-1 rounded-lg">
                                        No stocks found in <span x-text="currentExchange"></span>
                                    </div>
                                </div>

                                {{-- Exchange Toggle --}}
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Exchange</label>
                                    <div class="flex bg-gray-50 rounded-lg p-1 border border-gray-100">
                                        <div class="flex-1 py-1.5 text-[10px] font-bold text-center cursor-pointer select-box {{ old('exchange', 'NSE') == 'NSE' ? 'active-box' : '' }} rounded-md"
                                            data-single="exchange" data-value="NSE">NSE</div>
                                        <div class="flex-1 py-1.5 text-[10px] font-bold text-center cursor-pointer select-box {{ old('exchange') == 'BSE' ? 'active-box' : '' }} rounded-md"
                                            data-single="exchange" data-value="BSE">BSE</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Price Calculation Grid --}}
                            <div class="bg-gray-900 rounded-2xl p-1 shadow-inner">
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-px">
                                    <div class="bg-white p-4 rounded-tl-xl md:rounded-l-xl">
                                        <label class="block text-[9px] font-black text-blue-500 uppercase mb-1">Entry Price</label>
                                        <input type="number" step="0.01" name="entry_price" id="entry"
                                            value="{{ old('entry_price') }}" required placeholder="0.00"
                                            class="w-full text-xl font-black outline-none">
                                    </div>
                                    <div class="bg-white p-4">
                                        <label class="block text-[9px] font-black text-yellow-600 uppercase mb-1">CMP</label>
                                        <div class="relative">
                                            <input type="number" step="0.01" name="cmp_price" id="cmp"
                                                value="{{ old('cmp_price') }}" placeholder="0.00"
                                                class="w-full text-xl font-black outline-none text-yellow-600">
                                            {{-- Mini loader for price fetch --}}
                                            <div id="price_loader" class="hidden absolute right-0 top-1">
                                                 <i class="fa-solid fa-spinner fa-spin text-gray-300 text-xs"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4">
                                        <label class="block text-[9px] font-black text-green-500 uppercase mb-1">Target 01</label>
                                        <input type="number" step="0.01" name="target_price" id="t1"
                                            value="{{ old('target_price') }}" required placeholder="0.00"
                                            class="w-full text-xl font-black outline-none text-green-600">
                                    </div>
                                    <div class="bg-white p-4">
                                        <label class="block text-[9px] font-black text-emerald-600 uppercase mb-1">Target 02</label>
                                        <input type="number" step="0.01" name="target_price_2" id="t2"
                                            value="{{ old('target_price_2') }}" placeholder="0.00"
                                            class="w-full text-xl font-black outline-none text-emerald-700">
                                    </div>
                                    <div class="bg-white p-4 rounded-br-xl md:rounded-r-xl">
                                        <label class="block text-[9px] font-black text-red-500 uppercase mb-1">Stop Loss</label>
                                        <input type="number" step="0.01" name="stop_loss" id="sl"
                                            value="{{ old('stop_loss') }}" required placeholder="0.00"
                                            class="w-full text-xl font-black outline-none text-red-600">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex items-center justify-between gap-4">
                                <button type="reset"
                                    class="text-[10px] font-black text-gray-400 hover:text-red-500 uppercase tracking-widest transition-colors">
                                    Reset Form
                                </button>
                                <button type="submit"
                                    class="bg-[#2a5298] text-white px-12 py-3.5 rounded-xl font-black text-xs shadow-lg hover:shadow-[#2a5298]/30 transition-all uppercase tracking-[2px]">
                                    Publish Equity Tip
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- CATEGORY CREATION MODAL --}}
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
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Category Name</label>
                    <input type="text" name="name" required autofocus placeholder="e.g. Intraday, Jackpot"
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all">
                    @error('name')
                    <p class="text-red-500 text-[10px] mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showCategoryModal = false"
                        class="flex-1 py-3.5 bg-gray-100 text-gray-500 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-3.5 bg-emerald-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-100 transition-all">
                        Publish Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Logic Scripts --}}
<script>
    // Global Store to share data between components/inputs
    document.addEventListener('alpine:init', () => {
        Alpine.store('stockData', {
            token: '{{ old("symbol_token") }}' // Initialize with old input if available
        });

        Alpine.data('stockSearch', () => ({
            search: '{{ old("stock_name") }}',
            allStocks: [],
            filteredStocks: [],
            isOpen: false,
            isLoading: false,
            currentExchange: document.getElementById('selected_exchange').value || 'NSE',
            errorMessage: '',

            init() {
                // Listen for exchange changes
                window.addEventListener('exchange-changed', (e) => {
                    this.currentExchange = e.detail;
                    if (this.search.length > 0) {
                        this.filterStocks();
                    }
                });
            },

            async loadStocks() {
                if (this.allStocks.length > 0) {
                    this.isOpen = true;
                    return;
                }

                this.isLoading = true;
                this.isOpen = true;
                this.errorMessage = '';

                const targetUrl = '/api/proxy/scrips';

                try {
                    const response = await fetch(targetUrl, { cache: "no-store" });

                    if (!response.ok) {
                        throw new Error('Server responded with status ' + response.status);
                    }

                    const data = await response.json();

                    if (Array.isArray(data)) {
                        this.allStocks = data;
                    } else if (data && Array.isArray(data.data)) {
                        this.allStocks = data.data;
                    } else {
                        this.allStocks = Array.isArray(data) ? data : [];
                    }

                } catch (error) {
                    console.error('Error fetching stocks:', error);
                    this.errorMessage = 'Failed to load stock list. Please try again later.';
                    this.allStocks = [];
                } finally {
                    this.isLoading = false;
                    this.filterStocks();
                }
            },

            filterStocks() {
                if (!this.search || this.search.trim() === '') {
                    this.filteredStocks = [];
                    this.isOpen = false;
                    return;
                }

                const term = this.search.toUpperCase().trim();
                const matches = [];
                let count = 0;
                const maxResults = 50;

                for (let i = 0; i < this.allStocks.length; i++) {
                    const stock = this.allStocks[i];
                    const name = stock.name ? String(stock.name).toUpperCase() : '';
                    const symbol = stock.symbol ? String(stock.symbol).toUpperCase() : '';
                    const exch_seg = stock.exch_seg ? String(stock.exch_seg).toUpperCase() : '';

                    if (exch_seg !== String(this.currentExchange).toUpperCase()) continue;

                    if (name.includes(term) || symbol.includes(term)) {
                        matches.push(stock);
                        count++;
                    }

                    if (count >= maxResults) break;
                }

                this.filteredStocks = matches;
                this.isOpen = matches.length > 0;
            },

           selectStock(stock) {
                this.search = stock.symbol || stock.name || '';
                this.isOpen = false;
            
                const tokenInput = document.getElementById('symbol_token');
                if (tokenInput) {
                    tokenInput.value = stock.token;
                    console.log("Token set to:", stock.token); // Debugging: Check console to confirm
                }
            
                this.fetchCurrentPrice(stock);
            },

            async fetchCurrentPrice(stock) {
                const cmpInput = document.getElementById('cmp');
                const entryInput = document.getElementById('entry');
                const loader = document.getElementById('price_loader');

                // UI Feedback
                if(loader) loader.classList.remove('hidden');
                
                // Clear old values to indicate fetching
                cmpInput.value = '';

                try {
  
                    const params = new URLSearchParams({
                        symbol: stock.token, 
                        exchange: stock.exch_seg
                    });

                    const response = await fetch(`/api/angel/quote?${params.toString()}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const result = await response.json();

                    // Parse the structure: { status: true, data: { fetched: [ { ltp: ... } ] } }
                    if (result.status && result.data && result.data.fetched && result.data.fetched.length > 0) {
                        const quoteData = result.data.fetched[0];
                        const ltp = parseFloat(quoteData.ltp);

                        // Update CMP
                        cmpInput.value = ltp;
                        
                        // Update Entry Price and Trigger Calculation
                        // We update entry price to CMP automatically to make it easier for user
                        if(entryInput) {
                            entryInput.value = ltp;
                            // Manually dispatch input event to trigger the vanilla JS calculation logic
                            entryInput.dispatchEvent(new Event('input'));
                        }
                    }
                } catch (error) {
                    console.error('Error fetching CMP:', error);
                } finally {
                    if(loader) loader.classList.add('hidden');
                }
            }
        }));
    });

        

    // Vanilla JS for UI Interaction & Calculations
    document.querySelectorAll('.select-box').forEach(box => {
        box.addEventListener('click', () => {
            const group = box.dataset.single;
            const isCategory = box.classList.contains('category-item');

            if (isCategory) {
                document.querySelectorAll('.category-item').forEach(b => b.classList.remove('active-box'));
                box.classList.add('active-box');
                document.getElementById('selected_category').value = box.dataset.id;
                return;
            }

            if (group) {
                document.querySelectorAll(`[data-single="${group}"]`).forEach(b => b.classList.remove('active-box'));
                box.classList.add('active-box');

                if (group === 'trade') {
                    document.getElementById('selected_call').value = box.dataset.value;
                }

                if (group === 'exchange') {
                    const newVal = box.dataset.value;
                    document.getElementById('selected_exchange').value = newVal;
                    window.dispatchEvent(new CustomEvent('exchange-changed', { detail: newVal }));
                }
            }
        });
    });
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
                    // Sabhi buttons se purani classes hatayein
                    document.querySelectorAll(`[data-single="${group}"]`).forEach(b => {
                        b.classList.remove('active-box', 'buy-active', 'sell-active');
                    });

                    // Agar "trade" group hai (Buy/Sell)
                    if (group === 'trade') {
                        const val = box.dataset.value;
                        document.getElementById('selected_call').value = val;

                        // Condition ke hisaab se color lagayein
                        if (val === 'Buy') {
                            box.classList.add('buy-active');
                        } else {
                            box.classList.add('sell-active');
                        }
                    }
                    // Baki exchange buttons ke liye purana blue style
                    else {
                        box.classList.add('active-box');
                        if (group === 'exchange') document.getElementById('selected_exchange').value = box
                            .dataset.value;
                    }
                }
            });
        });

    // Dynamic Calculation Logic
    const entry = document.getElementById('entry'),
        cmp = document.getElementById('cmp'),
        t1 = document.getElementById('t1'),
        t2 = document.getElementById('t2'),
        sl = document.getElementById('sl');

    if (entry) {
        entry.addEventListener('input', () => {
            let e = parseFloat(entry.value) || 0;
            if (e > 0) {
                if(!cmp.value) {
                    cmp.value = (e * 0.995).toFixed(2);
                }
                
                t1.value = (e * 1.02).toFixed(2);
                t2.value = (e * 1.04).toFixed(2);
                sl.value = (e * 0.985).toFixed(2);
            }
        });
    }
</script>


<style>
    [x-cloak] { display: none !important; }
    .active-box {
        background-color: #2a5298 !important;
        color: white !important;
        border-color: #2a5298 !important;
    }
    .select-box { transition: all 0.15s ease-in-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
    
    /* Custom Scrollbar for dropdown */
    .overflow-y-auto::-webkit-scrollbar { width: 6px; }
    .overflow-y-auto::-webkit-scrollbar-track { background: #f1f1f1; }
    .overflow-y-auto::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .overflow-y-auto::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
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

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Pehle se maujood active-box ko waisa hi rehne dein categories ke liye */
        .active-box {
            background-color: #2a5298 !important;
            color: white !important;
            border-color: #2a5298 !important;
        }

        /* BUY aur SELL ke liye naye styles */
        .buy-active {
            background-color: #10b981 !important;
            /* Emerald Green */
            color: white !important;
            border-color: #10b981 !important;
        }

        .sell-active {
            background-color: #ef4444 !important;
            /* Red */
            color: white !important;
            border-color: #ef4444 !important;
        }
    </style>

@endsection
