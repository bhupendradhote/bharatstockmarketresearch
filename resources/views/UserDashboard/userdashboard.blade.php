@extends('layouts.userdashboard')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Google Fonts & AlpineJS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Styles --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background: #94a3b8;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="space-y-8 pb-12 max-w-[1600px] mx-auto">

        {{-- Section 1: Market Overview (Indices) --}}
        <section x-data="{
            indices: [],
            loading: true,
            config: {
                '99926000': { name: 'NIFTY 50', order: 1 },
                '99919000': { name: 'SENSEX', order: 2 },
                '99926009': { name: 'BANK NIFTY', order: 3 },
                '99926037': { name: 'FIN NIFTY', order: 4 },
                '99926004': { name: 'MIDCAP 50', order: 5 },
                '99926006': { name: 'NIFTY IT', order: 6 },
                '99926002': { name: 'NIFTY AUTO', order: 7 }
            },
            scroll(direction) {
                const container = this.$refs.scroller;
                const scrollAmount = 300;
                container.scrollBy({ left: direction === 'left' ? -scrollAmount : scrollAmount, behavior: 'smooth' });
            },
            fetchIndices() {
                fetch(`${window.location.origin}/api/angel/indices`)
                    .then(res => res.json())
                    .then(res => {
                        if (res && res.status && res.data && Array.isArray(res.data.fetched)) {
                            this.indices = res.data.fetched.map(item => {
                                let conf = this.config[item.symbolToken] || { name: item.tradingSymbol, order: 999 };
                                let change = parseFloat(item.netChange || 0);
                                let percent = parseFloat(item.percentChange || item.percent_change || 0);
                                return {
                                    id: item.symbolToken,
                                    name: conf.name,
                                    order: conf.order,
                                    value: (parseFloat(item.ltp || 0)).toLocaleString('en-IN', { minimumFractionDigits: 2 }),
                                    change: `${change > 0 ? '+' : ''}${change.toFixed(2)} (${percent.toFixed(2)}%)`,
                                    positive: change >= 0
                                };
                            }).sort((a, b) => a.order - b.order);
                        }
                    })
                    .catch(err => console.error('Indices fetch error', err))
                    .finally(() => this.loading = false);
            },
            init() {
                this.fetchIndices();
                setInterval(() => { this.fetchIndices(); }, 5000);
            }
        }" x-init="init()">
            <div class="flex items-center justify-between mb-4 px-1">
                <h3 class="font-bold text-xl text-slate-800 tracking-tight">Market Overview</h3>
                <div
                    class="flex items-center gap-2 bg-emerald-50 text-emerald-700 text-[11px] font-bold px-3 py-1 rounded-full border border-emerald-100 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    LIVE MARKET
                </div>
            </div>

            <div
                class="w-full bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col lg:flex-row">
                <div class="flex-grow min-w-0 relative group p-1 lg:border-r border-slate-100">
                    <div x-show="loading" class="flex justify-center items-center h-[180px] w-full text-[#0939a4]">
                        <svg class="animate-spin h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>

                    <button @click="scroll('left')" x-show="!loading"
                        class="absolute left-2 top-1/2 -translate-y-1/2 z-20 p-2.5 rounded-full bg-white shadow-lg text-slate-500 hover:text-[#0939a4] hover:scale-110 transition-all opacity-0 group-hover:opacity-100 duration-300 border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="scroll('right')" x-show="!loading"
                        class="absolute right-2 top-1/2 -translate-y-1/2 z-20 p-2.5 rounded-full bg-white shadow-lg text-slate-500 hover:text-[#0939a4] hover:scale-110 transition-all opacity-0 group-hover:opacity-100 duration-300 border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div x-ref="scroller" x-show="!loading"
                        class="grid grid-rows-2 grid-flow-col gap-3 overflow-x-auto p-4 scrollbar-hide snap-x scroll-smooth h-[210px]">
                        <template x-for="item in indices" :key="item.id">
                            <div
                                class="w-64 flex-shrink-0 bg-gradient-to-br from-white to-slate-50 rounded-2xl p-4 border border-slate-100 snap-start hover:shadow-md hover:border-blue-100 transition-all duration-300 flex justify-between items-center group cursor-default">
                                <div>
                                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest"
                                        x-text="item.name"></p>
                                    <h4 class="font-bold text-sm mt-1 text-slate-800 tracking-tight" x-text="item.value">
                                    </h4>
                                    <p class="text-xs font-bold mt-1 inline-block py-0.5 rounded"
                                        :class="item.positive ? 'text-emerald-600' : 'text-rose-600'" x-text="item.change">
                                    </p>
                                </div>
                                <div class="h-10 w-14 opacity-50 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-full h-full overflow-visible" viewBox="0 0 50 20"
                                        preserveAspectRatio="none">
                                        <path d="M0 15 C 15 15, 15 5, 25 10 S 35 15, 50 5" fill="none"
                                            :stroke="item.positive ? '#10b981' : '#f43f5e'" stroke-width="2.5"
                                            stroke-linecap="round" vector-effect="non-scaling-stroke" />
                                        <circle cx="50" cy="5" r="2.5"
                                            :fill="item.positive ? '#10b981' : '#f43f5e'" />
                                    </svg>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div
                    class="lg:w-72 flex-shrink-0 bg-slate-50/80 p-5 flex flex-col justify-center border-t lg:border-t-0 border-slate-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="relative">
                            <img src="{{ auth()->user()->getFirstMediaUrl('profile_image') ?: 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . auth()->user()->id }}"
                                alt="User"
                                class="w-12 h-12 rounded-full border-2 border-white shadow-sm bg-white object-cover" />
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full">
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider mb-0.5">Welcome back</p>
                            <h4 class="font-bold text-slate-800 text-sm truncate">{{ Auth::user()->name }}</h4>
                        </div>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-slate-100 shadow-sm mb-4">
                        <div
                            class="flex justify-between items-center text-xs mb-2 border-b border-dashed border-slate-100 pb-2">
                            <span class="text-slate-500 font-medium">Current Plan</span>
                            <span
                                class="text-[#0939a4] font-bold bg-blue-50 px-2 py-0.5 rounded">{{ $currentPlan ?? 'Free' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500 font-medium">Expires In</span>
                            <span class="text-orange-600 font-bold">{{ $daysRemaining ?? 'N/A' }} Days</span>
                        </div>
                    </div>
                    <a href='/market-calls'
                        class="w-full bg-[#0939a4] hover:bg-blue-800 text-white text-xs font-bold py-3 rounded-xl text-center transition-all shadow-md shadow-blue-900/10 flex justify-center items-center gap-2 group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-blue-200 group-hover:text-white transition-colors" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        View Premium Calls
                    </a>
                </div>
            </div>
        </section>

        {{-- Main Content Grid --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">


            {{-- Section 2: Today's Highlights --}}
            <div class="lg:col-span-8 space-y-5" x-data="{
                activeTab: 1,
                stocks: {{ $highlights->toJson() }},
                userPlanId: {{ $activeSubscription->service_plan_id ?? 'null' }},
                isDemo: {{ $activeSubscription && $activeSubscription->isDemo() ? 'true' : 'false' }},
            
                checkAccess(tip) {
                    if (this.isDemo) return true;
                    if (!this.userPlanId) return false;
                    if (!tip.plan_access) return false;
            
                    return tip.plan_access.some(
                        access => access.service_plan_id === this.userPlanId
                    );
                }
            }" x-show="stocks.length">

                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-slate-800">Today's Highlights</h2>
                    <div class="flex gap-2">
                        <button @click="activeTab = 1"
                            :class="activeTab === 1 ? 'bg-[#0939a4] w-8' : 'bg-slate-300 w-2 hover:bg-slate-400'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                        <button @click="activeTab = 2"
                            :class="activeTab === 2 ? 'bg-[#0939a4] w-8' : 'bg-slate-300 w-2 hover:bg-slate-400'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <template x-for="(stock, index) in stocks" :key="stock.id">

                        <div x-show="(activeTab === 1 && index < 4) || (activeTab === 2 && index >= 4)" x-transition
                            class="relative bg-white rounded-3xl border border-slate-200 p-6 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">

                            <!-- BUY / SELL badge -->
                            <div :class="stock.call_type === 'BUY' ? 'bg-emerald-100 text-emerald-700' :
                                'bg-rose-100 text-rose-700'"
                                class="absolute top-5 right-5 text-[10px] uppercase font-bold px-3 py-1.5 rounded-full tracking-wide shadow-sm"
                                x-text="stock.call_type"></div>

                            <div class="mb-5">
                                <span
                                    class="bg-indigo-50 text-indigo-600 text-[10px] font-bold px-2 py-0.5 rounded border border-indigo-100 uppercase tracking-wider">
                                    Intraday
                                </span>

                                <h3 class="font-bold text-slate-800 text-xl mt-2 group-hover:text-[#0939a4]"
                                    x-text="stock.stock_name"></h3>

                                <p class="text-xs text-slate-400 mt-1"
                                    x-text="new Date(stock.created_at).toLocaleTimeString()"></p>
                            </div>

                            <!-- ===== FULL DATA (SUBSCRIBED) ===== -->
                            <template x-if="checkAccess(stock)">
                                <div>

                                    <div
                                        class="flex items-end justify-between mb-6 pb-6 border-b border-dashed border-slate-100">
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase">
                                                Current Price
                                            </p>
                                            <p class="text-xl font-bold text-slate-800" x-text="'₹' + stock.cmp_price">
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 gap-2">
                                        <div class="bg-slate-50 rounded-xl p-2 text-center border border-slate-100">
                                            <p class="text-slate-400 text-[10px] uppercase font-bold">Entry</p>
                                            <p class="text-slate-800 font-bold text-sm" x-text="stock.entry_price"></p>
                                        </div>

                                        <div
                                            class="bg-emerald-50/50 rounded-xl p-2 text-center border border-emerald-100/50">
                                            <p class="text-emerald-600 text-[10px] uppercase font-bold">Target</p>
                                            <p class="text-emerald-600 font-bold text-sm" x-text="stock.target_price"></p>
                                        </div>

                                        <div class="bg-rose-50/50 rounded-xl p-2 text-center border border-rose-100/50">
                                            <p class="text-rose-500 text-[10px] uppercase font-bold">Stop Loss</p>
                                            <p class="text-rose-500 font-bold text-sm" x-text="stock.stop_loss"></p>
                                        </div>
                                    </div>

                                </div>
                            </template>

                            <!-- ===== LOCKED VIEW (FREE USER) ===== -->
                            <template x-if="!checkAccess(stock)">
                                <div
                                    class="bg-slate-50 rounded-2xl border border-dashed border-slate-200 p-6 text-center mt-4">

                                    <p class="text-sm font-bold text-[#8e44ad] uppercase">
                                        Premium Tip
                                    </p>

                                    <p class="text-xs text-slate-400 mt-1">
                                        Subscribe to unlock trade levels
                                    </p>

                                    <a href="{{ url('/settings') }}"
                                        class="inline-block mt-4 bg-[#8e44ad] text-white px-5 py-2 rounded-full text-[10px] font-black uppercase shadow hover:bg-[#732d91] transition">
                                        Upgrade Now
                                    </a>

                                </div>
                            </template>

                        </div>

                    </template>

                </div>
            </div>

            {{-- Section 3: ADVANCED WATCHLIST SECTION --}}
            <div class="lg:col-span-4 flex flex-col h-full" x-data="watchlistComponent()" x-init="init()">

                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-xl font-bold text-slate-800">Watchlist</h2>
                    <div class="flex gap-2">
                        <button x-show="watchlists.length > 0" @click="deleteWatchlist()"
                            class="p-1.5 rounded-lg border border-red-200 bg-white hover:bg-red-50 text-red-500 transition-colors"
                            title="Delete Current List">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                        <button x-show="watchlists.length > 0" @click="startEditing()"
                            class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition-colors"
                            title="Rename List">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button @click="showCreateList = !showCreateList; showRenameInput = false;"
                            class="p-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 transition-colors"
                            title="Create New List">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                        <button @click="showAddScript = !showAddScript; showRenameInput = false;"
                            class="text-xs font-bold text-[#0939a4] bg-white hover:bg-[#0939a4] hover:text-white px-3 py-1.5 rounded-lg border border-blue-100 shadow-sm transition-all flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add Script
                        </button>
                    </div>
                </div>

                {{-- Dynamic Tabs --}}
                <div class="flex gap-2 mb-3 overflow-x-auto scrollbar-hide pb-1">
                    <template x-for="(list, idx) in watchlists" :key="list.id">
                        <button @click="activeIndex = idx; showRenameInput = false;"
                            :class="activeIndex === idx ? 'bg-[#0939a4] text-white' :
                                'bg-white text-slate-500 border border-slate-100'"
                            class="px-4 py-1.5 rounded-full text-[11px] font-bold whitespace-nowrap transition-all"
                            x-text="list.name"></button>
                    </template>
                </div>

                {{-- Inline Form: Rename Watchlist --}}
                <div x-show="showRenameInput" x-transition
                    class="mb-4 bg-yellow-50 p-3 rounded-2xl border border-yellow-100">
                    <label class="block text-[10px] font-bold text-yellow-800 uppercase mb-2">Rename Watchlist</label>
                    <div class="flex gap-2">
                        <input type="text" x-model="renameName" @keyup.enter="renameWatchlist()"
                            class="flex-grow bg-white border-none rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-yellow-500 outline-none" />
                        <button @click="renameWatchlist()"
                            class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-xs font-bold">Save</button>
                        <button @click="showRenameInput = false"
                            class="text-slate-500 px-2 text-xs font-bold">Cancel</button>
                    </div>
                </div>

                {{-- Inline Form: Create Watchlist --}}
                <div x-show="showCreateList" x-transition class="mb-4 bg-blue-50 p-3 rounded-2xl border border-blue-100">
                    <label class="block text-[10px] font-bold text-blue-800 uppercase mb-2">Watchlist Name</label>
                    <div class="flex gap-2">
                        <input type="text" x-model="newListName" @keyup.enter="createWatchlist()"
                            placeholder="e.g. My Portfolio"
                            class="flex-grow bg-white border-none rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none" />
                        <button @click="createWatchlist()"
                            class="bg-[#0939a4] text-white px-4 py-2 rounded-lg text-xs font-bold">Create</button>
                    </div>
                </div>

                {{-- Inline Form: Add Script --}}
                <div x-show="showAddScript" x-transition class="mb-4 bg-slate-800 p-3 rounded-2xl shadow-lg relative">
                    <label class="block text-[10px] font-bold text-slate-300 uppercase mb-2">Search Symbol</label>
                    <div class="relative">
                        <div class="flex gap-2">
                            <input type="text" x-model.debounce.500ms="scriptQuery" @input="searchSymbols()"
                                @keyup.enter="addScript()" placeholder="e.g. RELIANCE, SBIN..."
                                class="flex-grow bg-slate-700 text-white border-none rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none placeholder-slate-400" />
                            <button @click="addScript()"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap">Add</button>
                        </div>

                        {{-- Loading Spinner --}}
                        <div x-show="isSearching" class="absolute right-16 top-2.5">
                            <svg class="animate-spin h-5 w-5 text-blue-400" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>

                        {{-- Search Results Dropdown --}}
                        <div x-show="searchResults.length > 0"
                            class="absolute left-0 right-0 mt-2 bg-slate-700 rounded-xl shadow-2xl z-[100] border border-slate-600 overflow-hidden max-h-60 overflow-y-auto custom-scrollbar">
                            <template x-for="res in searchResults" :key="res.token ? res.token : res.symbol">
                                <button @click="addScript(res.symbol)"
                                    class="w-full text-left px-4 py-3 hover:bg-slate-600 border-b border-slate-600/50 flex justify-between items-center group">
                                    <div>
                                        <span class="block text-white font-bold text-sm group-hover:text-blue-400"
                                            x-text="res.symbol"></span>
                                        <span class="text-[10px] text-slate-400 uppercase"
                                            x-text="res.exchange + ' • ' + res.name"></span>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-[11px] font-bold"
                                            :class="res.positive ? 'text-emerald-400' : 'text-rose-400'"
                                            x-text="res.ltp"></span>
                                        <span class="text-[9px] text-slate-400" x-text="res.instrument"></span>
                                    </div>
                                </button>
                            </template>
                        </div>

                        {{-- No Results State --}}
                        <div x-show="!isSearching && scriptQuery.length >= 2 && searchResults.length === 0"
                            class="absolute left-0 right-0 mt-2 bg-slate-700 rounded-xl shadow-lg border border-slate-600 p-3 text-center z-[100]">
                            <p class="text-xs text-slate-400">No symbols found. Press <b>Add</b> to add directly.</p>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-3xl overflow-hidden shadow-sm flex flex-col max-h-[600px]">
                    <div
                        class="p-4 bg-slate-50/80 border-b border-slate-100 flex justify-between items-center backdrop-blur-sm sticky top-0 z-10">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Symbol</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">LTP / Change</span>
                    </div>

                    <div class="overflow-y-auto custom-scrollbar p-2 space-y-1 min-h-[200px]">
                        {{-- Empty State --}}
                        <div x-show="watchlists.length === 0 || !watchlists[activeIndex] || (watchlists[activeIndex].scripts && watchlists[activeIndex].scripts.length === 0)"
                            class="flex flex-col items-center justify-center py-10 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 opacity-20" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="text-xs font-medium">List is empty</p>
                        </div>

                        <template x-if="watchlists.length > 0">
                            <template
                                x-for="(item, sIdx) in (watchlists[activeIndex] && watchlists[activeIndex].scripts ? watchlists[activeIndex].scripts : [])"
                                :key="item.id ? item.id : item.symbol + sIdx">
                                <div
                                    class="group flex justify-between items-center p-3 hover:bg-white rounded-2xl transition-all cursor-pointer border border-transparent hover:border-blue-50 hover:shadow-sm relative">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-800 text-sm" x-text="item.symbol"></span>
                                            <span class="bg-emerald-500 w-1.5 h-1.5 rounded-full shadow-sm"
                                                x-show="Number(item.change) >= 0"></span>
                                        </div>
                                        <span class="text-[11px] text-slate-400 font-medium"
                                            x-text="item.exchange || 'NSE'"></span>
                                    </div>

                                    {{-- Delete Action --}}
                                    <button @click.stop="removeScript(item.id, sIdx)"
                                        class="absolute left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 bg-rose-50 text-rose-600 p-1.5 rounded-lg transition-all hover:bg-rose-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>

                                    <div class="text-right">
                                        <div class="font-bold text-slate-800 text-sm tracking-tight"
                                            x-text="(item.ltp !== undefined ? ('₹' + item.ltp) : '--')"></div>
                                        <div class="text-[9px] mt-1 flex items-center justify-end gap-2">
                                            <span class="flex items-center text-[11px] font-bold"
                                                :class="Number(item.change) >= 0 ? 'text-emerald-600' : 'text-rose-600'">
                                                <svg x-show="Number(item.change) >= 0" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-3 w-3 inline-block mr-1" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 3a1 1 0 01.894.553l4 8A1 1 0 0114 13H6a1 1 0 01-.894-1.447l4-8A1 1 0 0110 3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <svg x-show="Number(item.change) < 0" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-3 w-3 inline-block mr-1" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 17a1 1 0 01-.894-.553l-4-8A1 1 0 016 7h8a1 1 0 01.894 1.447l-4 8A1 1 0 0110 17z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span
                                                    x-text="(item.change !== undefined && item.change !== null) ? ((Number(item.change) > 0 ? '+' : '') + Number(item.change).toFixed(2)) : '--'"></span>
                                            </span>
                                            <span class="text-[10px] text-slate-400"
                                                x-text="(item.percentChange !== undefined && item.percentChange !== null) ? ( (Number(item.percentChange)>0?'+':'') + Number(item.percentChange).toFixed(2) + '%') : ''"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </template>
                    </div>
                </div>
            </div>

        </section>

        {{-- Bottom Section: Momentum & Movers --}}
        <section class="grid lg:grid-cols-2 gap-8" x-data="{ momentumTab: 'Small Cap', timeFilter: '15 min' }">
            <!-- <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-5">
                    <h3 class="text-xl font-bold text-slate-800">Stocks in Momentum</h3>
                    <span
                        class="flex items-center gap-1 bg-white text-emerald-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-100 shadow-sm">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Live
                    </span>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden h-full">
                    <div
                        class="bg-gradient-to-r from-[#0939a4] to-blue-700 p-4 flex justify-between items-center text-white">
                        <span class="text-xs font-bold uppercase tracking-wider opacity-90">Intraday Trends</span>
                        <button
                            class="text-[10px] bg-white/20 hover:bg-white/30 px-2 py-1 rounded backdrop-blur-md transition-colors">View
                            All</button>
                    </div>

                    <div class="p-0">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                                    <th class="text-left py-3 px-6">Symbol</th>
                                    <th class="text-center py-3 px-2" x-text="timeFilter + ' change'"></th>
                                    <th class="text-right py-3 px-6">LTP</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <template
                                    x-for="stock in [{s: 'SHAKTIPUMP', c: '+13.65 (+2.49%)', p: '585.00', pos: true}, {s: 'JAINREC', c: '+3.90 (+1.02%)', p: '391.35', pos: true}, {s: 'BALRAMCHIN', c: '+5.90 (+1.35%)', p: '443.00', pos: true}]">
                                    <tr class="hover:bg-blue-50/40 transition-colors group cursor-default">
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-slate-800 text-sm group-hover:text-[#0939a4] transition-colors"
                                                x-text="stock.s"></div>
                                            <div class="text-[10px] text-slate-400 font-semibold">NSE EQ</div>
                                        </td>
                                        <td class="py-4 px-2 text-center">
                                            <span class="font-bold text-xs px-2 py-1 rounded-md"
                                                :class="stock.pos ? 'text-emerald-700 bg-emerald-50' :
                                                    'text-rose-700 bg-rose-50'"
                                                x-text="stock.c"></span>
                                        </td>
                                        <td class="py-4 px-6 text-right font-bold text-slate-800 text-sm"
                                            x-text="'₹'+stock.p"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->

            {{-- Market Movers Section --}}
            <div class="flex flex-col" x-data="{
                moversTab: 'Top Gainers',
                moversData: [],
                isLoading: false,
                fetchMovers() {
                    this.isLoading = true;
                    let type = this.moversTab === 'Top Gainers' ? 'GAINERS' : 'LOSERS';
                    fetch(`${window.location.origin}/api/angel/gainers-losers?datatype=${type}`)
                        .then(res => res.json())
                        .then(response => {
                            if (response.status && Array.isArray(response.data)) {
                                this.moversData = response.data.slice(0, 10).map(item => {
                                    let change = parseFloat(item.netChange || 0);
                                    let pct = parseFloat(item.percentChange || item.percent_change || 0);
                                    let rawSymbol = item.tradingSymbol || item.symbol || '';
                                    let cleanName = rawSymbol.replace('-EQ', '').replace('-BE', '');
            
                                    return {
                                        s: cleanName,
                                        v: (parseFloat(item.ltp || 0)).toFixed(2),
                                        c: `${change > 0 ? '+' : ''}${change.toFixed(2)} (${pct.toFixed(2)}%)`,
                                        pos: change >= 0
                                    };
                                });
                            }
                        })
                        .catch(err => console.error(err))
                        .finally(() => this.isLoading = false);
                },
                init() {
                    this.fetchMovers();
                    this.$watch('moversTab', () => this.fetchMovers());
                    setInterval(() => { this.fetchMovers(); }, 15000);
                }
            }" x-init="init()">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-xl font-bold text-slate-800">Market Movers</h3>
                    <div class="flex p-1 bg-slate-100 rounded-xl">
                        <template x-for="tab in ['Top Gainers', 'Top Losers']">
                            <button @click="moversTab = tab"
                                :class="moversTab === tab ? 'bg-white text-[#0939a4] shadow-sm font-bold' :
                                    'text-slate-500 hover:text-slate-700 font-medium'"
                                class="py-1.5 px-3 text-xs rounded-lg transition-all duration-200"
                                x-text="tab"></button>
                        </template>
                    </div>
                </div>

                <div
                    class="bg-white rounded-3xl border border-slate-200 shadow-sm p-2 flex flex-col h-full relative min-h-[300px]">
                    <div x-show="isLoading"
                        class="absolute inset-0 bg-white/60 z-10 flex justify-center items-center rounded-3xl backdrop-blur-sm">
                        <svg class="animate-spin h-8 w-8 text-[#0939a4]" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>

                    <div class="space-y-1 flex-grow max-h-[400px] overflow-y-auto custom-scrollbar p-2">
                        <template x-for="mover in moversData">
                            <div
                                class="flex justify-between items-center p-3 rounded-xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold"
                                        :class="mover.pos ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600'">
                                        <span x-text="mover.s.substring(0,1)"></span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm tracking-tight group-hover:text-[#0939a4] transition-colors"
                                            x-text="mover.s"></p>
                                        <p class="text-[10px] font-bold text-slate-400">NSE</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-slate-800 text-sm" x-text="mover.v"></p>
                                    <p class="text-[10px] font-bold inline-block px-1.5 rounded"
                                        :class="mover.pos ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50'"
                                        x-text="mover.c"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Alpine component script (watchlist logic + quote fetching) --}}
    <script>
        function watchlistComponent() {
            return {
                showAddScript: false,
                showCreateList: false,
                showRenameInput: false,
                newListName: '',
                renameName: '',
                scriptQuery: '',
                activeIndex: 0,
                watchlists: [],
                searchResults: [],
                isSearching: false,

                // local caches
                tokenCache: {},
                quoteMap: {},
                quoteInterval: null,
                quotePollingMs: 3000,

                normalize(item) {
                    const symbol = (item.symbol || item.tradingSymbol || item.symbolName || '').toString().replace(
                        /-EQ|-BE/ig, '').toUpperCase();
                    const name = item.name || item.companyName || symbol;
                    const token = item.token || item.symbolToken || item.id || '';
                    const ltpRaw = item.ltp ?? item.lastPrice ?? item.price ?? '--';
                    const ltp = (typeof ltpRaw === 'number' || !isNaN(parseFloat(ltpRaw))) ? parseFloat(ltpRaw).toFixed(2) :
                        String(ltpRaw);
                    const instrument = item.instrument || item.instrumenttype || item.type || '';
                    const exchange = item.exchange || item.exch_seg || 'NSE';
                    const positive = 'positive' in item ? !!item.positive : (parseFloat(item.netChange || item.change ||
                        0) >= 0);
                    return {
                        symbol,
                        name,
                        token,
                        instrument,
                        exchange,
                        ltp,
                        positive
                    };
                },

                /* ---------- SEARCH ---------- */
                async searchSymbols() {
                    if (!this.scriptQuery || this.scriptQuery.length < 2) {
                        this.searchResults = [];
                        return;
                    }

                    this.isSearching = true;
                    const q = encodeURIComponent(this.scriptQuery);
                    const primary = `${window.location.origin}/api/angel/search?query=${q}`;

                    try {
                        const r = await fetch(primary, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        const payload = await r.json();
                        let arr = [];
                        if (!payload) arr = [];
                        else if (Array.isArray(payload)) arr = payload;
                        else if (Array.isArray(payload.data)) arr = payload.data;
                        else if (payload.data && Array.isArray(payload.data.fetched)) arr = payload.data.fetched;
                        else arr = [];

                        this.searchResults = (arr || []).map(i => this.normalize(i)).slice(0, 50);
                    } catch (err) {
                        console.error('searchSymbols error', err);
                        this.searchResults = [];
                    } finally {
                        this.isSearching = false;
                    }
                },

                /* ---------- WATCHLISTS ---------- */
                async fetchWatchlists() {
                    try {
                        const r = await fetch(`${window.location.origin}/watchlists`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        const data = await r.json();

                        if (Array.isArray(data)) this.watchlists = data;
                        else if (data && Array.isArray(data.data)) this.watchlists = data.data;
                        else this.watchlists = data || [];

                        this.watchlists.forEach(w => {
                            w.scripts = w.scripts || [];
                            w.scripts.forEach(s => {
                                s.symbol = (s.symbol || s.name || s.ticker || '').toString()
                                    .toUpperCase();
                                s.exchange = s.exchange || s.exch_seg || 'NSE';
                                s.ltp = (s.ltp === null || s.ltp === undefined) ? '--' : ((typeof s
                                    .ltp === 'number') ? s.ltp.toFixed(2) : s.ltp);
                                s.percentChange = (s.percentChange !== undefined && s.percentChange !==
                                    null) ? Number(s.percentChange).toFixed(2) : ((s
                                    .percent_change !== undefined && s.percent_change !== null
                                ) ? Number(s.percent_change).toFixed(2) : null);
                                if (s.change === undefined || s.change === null) {
                                    if (s.net_change !== undefined && s.net_change !== null) {
                                        s.change = Number(s.net_change).toFixed(2);
                                    } else {
                                        s.change = '0.00';
                                    }
                                }
                                if (s.token) this.tokenCache[s.symbol] = s.token;
                            });
                        });

                        await this.updateQuotes();
                        if (this.quoteInterval) clearInterval(this.quoteInterval);
                        this.quoteInterval = setInterval(() => this.updateQuotes(), this.quotePollingMs);
                    } catch (err) {
                        console.error('Error fetching watchlists:', err);
                    }
                },

                async createWatchlist() {
                    if (this.newListName.trim() === '') return;
                    try {
                        const res = await fetch(`${window.location.origin}/watchlists`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                name: this.newListName.trim()
                            })
                        });
                        const newList = await res.json();
                        const list = (newList && newList.data) ? newList.data : newList;
                        if (!list) return;
                        list.scripts = list.scripts || [];
                        this.watchlists.push(list);
                        this.newListName = '';
                        this.showCreateList = false;
                        this.activeIndex = Math.max(0, this.watchlists.length - 1);
                        await this.updateQuotes();
                    } catch (err) {
                        console.error('Create watchlist error:', err);
                    }
                },

                /* ---------- EDIT & DELETE WATCHLIST ---------- */
                startEditing() {
                    if (!this.watchlists[this.activeIndex]) return;
                    this.renameName = this.watchlists[this.activeIndex].name;
                    this.showRenameInput = true;
                    this.showCreateList = false;
                    this.showAddScript = false;
                },

                async renameWatchlist() {
                    if (!this.renameName.trim()) return;
                    const activeList = this.watchlists[this.activeIndex];
                    try {
                        const res = await fetch(`${window.location.origin}/watchlists/${activeList.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                name: this.renameName.trim()
                            })
                        });

                        if (res.ok) {
                            this.watchlists[this.activeIndex].name = this.renameName.trim();
                            this.showRenameInput = false;
                            this.renameName = '';
                        }
                    } catch (err) {
                        console.error('Rename watchlist error:', err);
                    }
                },

                async deleteWatchlist() {
                    const activeList = this.watchlists[this.activeIndex];
                    if (!activeList) return;

                    if (!confirm(`Are you sure you want to delete "${activeList.name}"? This cannot be undone.`))
                        return;

                    try {
                        const res = await fetch(`${window.location.origin}/watchlists/${activeList.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        if (res.ok) {
                            this.watchlists.splice(this.activeIndex, 1);
                            if (this.activeIndex >= this.watchlists.length) {
                                this.activeIndex = Math.max(0, this.watchlists.length - 1);
                            }
                        }
                    } catch (err) {
                        console.error('Delete watchlist error:', err);
                    }
                },

                async addScript(selectedSymbol) {
                    const symbolToAdd = (selectedSymbol || this.scriptQuery || '').toString().toUpperCase().trim();
                    if (!symbolToAdd) return;

                    if (!this.watchlists || !this.watchlists.length) {
                        alert('Please create a watchlist first.');
                        return;
                    }

                    const activeList = this.watchlists[this.activeIndex];

                    try {
                        const res = await fetch(`${window.location.origin}/watchlists/${activeList.id}/scripts`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                symbol: symbolToAdd
                            })
                        });
                        const payload = await res.json();
                        const script = (payload && payload.data) ? payload.data : payload;
                        if (!script) return;
                        activeList.scripts = activeList.scripts || [];
                        script.symbol = (script.symbol || script.name || symbolToAdd).toString().toUpperCase();
                        script.ltp = (script.ltp === null || script.ltp === undefined) ? '--' : ((typeof script.ltp ===
                            'number') ? script.ltp.toFixed(2) : script.ltp);
                        script.percentChange = (script.percentChange !== undefined && script.percentChange !== null) ?
                            Number(script.percentChange).toFixed(2) : ((script.percent_change !== undefined && script
                                .percent_change !== null) ? Number(script.percent_change).toFixed(2) : null);
                        script.change = (script.change !== undefined && script.change !== null) ? Number(script.change)
                            .toFixed(2) : (script.net_change !== undefined ? Number(script.net_change).toFixed(2) :
                                '0.00');
                        activeList.scripts.push(script);

                        this.scriptQuery = '';
                        this.searchResults = [];
                        this.showAddScript = false;
                        await this.updateQuotes();
                    } catch (err) {
                        console.error('Add script error:', err);
                        this.scriptQuery = '';
                        this.searchResults = [];
                        this.showAddScript = false;
                    }
                },

                async removeScript(scriptId, index) {
                    if (!scriptId) return;
                    try {
                        await fetch(`${window.location.origin}/watchlist-scripts/${scriptId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        if (this.watchlists[this.activeIndex] && this.watchlists[this.activeIndex].scripts) {
                            this.watchlists[this.activeIndex].scripts.splice(index, 1);
                        }
                    } catch (err) {
                        console.error('Remove script error:', err);
                    }
                },

                /* ---------- QUOTE LOGIC (UNCHANGED) ---------- */
                getTokenForSymbol(symbol) {
                    return new Promise((resolve) => {
                        if (!symbol) return resolve(null);
                        if (this.tokenCache[symbol]) return resolve(this.tokenCache[symbol]);
                        const q = encodeURIComponent(symbol);
                        const url = `${window.location.origin}/api/angel/search?query=${q}`;
                        fetch(url, {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            })
                            .then(r => r.json())
                            .then(payload => {
                                let arr = [];
                                if (!payload) arr = [];
                                else if (Array.isArray(payload)) arr = payload;
                                else if (Array.isArray(payload.data)) arr = payload.data;
                                else if (payload.data && Array.isArray(payload.data.fetched)) arr = payload.data
                                    .fetched;
                                else arr = [];
                                let found = null;
                                for (const it of arr) {
                                    const s = ((it.symbol || it.tradingSymbol || it.name || '') + '').toString()
                                        .toUpperCase();
                                    if (s === symbol) {
                                        found = it;
                                        break;
                                    }
                                }
                                if (!found && arr.length) found = arr[0];
                                const token = found ? (found.token || found.symbolToken || found.id || '') :
                                    null;
                                if (token) this.tokenCache[symbol] = token;
                                resolve(token || null);
                            })
                            .catch(err => {
                                console.error('getTokenForSymbol error', err);
                                resolve(null);
                            });
                    });
                },

                async updateQuotes() {
                    try {
                        const tokensSet = new Set();
                        const symbolToToken = {};
                        this.watchlists.forEach(w => {
                            (w.scripts || []).forEach(s => {
                                if (!s) return;
                                s.symbol = (s.symbol || '').toString().toUpperCase();
                                if (s.token) {
                                    tokensSet.add(String(s.token));
                                    symbolToToken[s.symbol] = String(s.token);
                                    this.tokenCache[s.symbol] = String(s.token);
                                } else if (this.tokenCache[s.symbol]) {
                                    tokensSet.add(String(this.tokenCache[s.symbol]));
                                    symbolToToken[s.symbol] = String(this.tokenCache[s.symbol]);
                                }
                            });
                        });

                        const symbolsToResolve = [];
                        this.watchlists.forEach(w => {
                            (w.scripts || []).forEach(s => {
                                const sym = (s.symbol || '').toString().toUpperCase();
                                if (!sym) return;
                                if (!symbolToToken[sym]) symbolsToResolve.push(sym);
                            });
                        });

                        const uniqueSymbolsToResolve = Array.from(new Set(symbolsToResolve));
                        if (uniqueSymbolsToResolve.length) {
                            const promises = uniqueSymbolsToResolve.map(sym => this.getTokenForSymbol(sym));
                            const resolved = await Promise.all(promises);
                            resolved.forEach((tok, idx) => {
                                const sym = uniqueSymbolsToResolve[idx];
                                if (tok) {
                                    tokensSet.add(String(tok));
                                    symbolToToken[sym] = String(tok);
                                }
                            });
                        }

                        const tokens = Array.from(tokensSet);
                        if (tokens.length === 0) return;

                        const quoteRes = await fetch(`${window.location.origin}/api/angel/quote`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                exchange: 'NSE',
                                tokens: tokens,
                                datatype: 'FULL'
                            })
                        });

                        const ct = quoteRes.headers.get('content-type') || '';
                        if (!ct.includes('application/json')) return;

                        const payload = await quoteRes.json();
                        let fetched = [];
                        if (!payload) fetched = [];
                        else if (Array.isArray(payload)) fetched = payload;
                        else if (payload.data && Array.isArray(payload.data.fetched)) fetched = payload.data.fetched;
                        else if (payload.data && Array.isArray(payload.data)) fetched = payload.data;
                        else if (payload.fetched && Array.isArray(payload.fetched)) fetched = payload.fetched;
                        else if (payload.data && payload.data.fetched && typeof payload.data.fetched === 'object')
                            fetched = [payload.data.fetched];
                        else if (payload.data && typeof payload.data === 'object' && payload.data.symbolToken)
                            fetched = [payload.data];

                        const quoteMap = {};
                        fetched.forEach(q => {
                            if (!q) return;
                            const tokenKey = q.symbolToken || q.token || q.id || null;
                            const symName = (q.tradingSymbol || q.symbol || q.name || '').toString().replace(
                                /-EQ|-BE/ig, '').toUpperCase();
                            if (tokenKey) quoteMap[String(tokenKey)] = q;
                            if (symName) quoteMap[symName] = q;
                        });

                        this.watchlists.forEach(w => {
                            (w.scripts || []).forEach(s => {
                                const sym = (s.symbol || '').toString().toUpperCase();
                                const token = s.token ? String(s.token) : symbolToToken[sym];
                                const q = (token && quoteMap[token]) ? quoteMap[token] : (quoteMap[
                                    sym] || null);
                                if (!q) return;

                                const ltp = Number(q.ltp ?? q.lastPrice ?? 0);
                                const change = Number(q.netChange ?? q.change ?? q.net_change ?? 0);
                                let pct = null;
                                if (q.percentChange !== undefined && q.percentChange !== null) pct =
                                    Number(q.percentChange);
                                else if (q.percent_change !== undefined && q.percent_change !== null)
                                    pct = Number(q.percent_change);
                                else if (q.percent !== undefined && q.percent !== null) pct = Number(q
                                    .percent);

                                if (pct === null) {
                                    if (s.percentChange !== null && s.percentChange !== undefined) pct =
                                        Number(s.percentChange);
                                    else if (s.percent_change !== null && s.percent_change !==
                                        undefined) pct = Number(s.percent_change);
                                    else {
                                        const prevClose = Number(q.close ?? q.previousClose ?? q
                                            .closePrice ?? 0);
                                        if (prevClose && prevClose !== 0) pct = ((ltp - prevClose) /
                                            prevClose) * 100;
                                        else pct = 0;
                                    }
                                }

                                s.ltp = isNaN(ltp) ? '--' : ltp.toFixed(2);
                                s.change = isNaN(change) ? '0.00' : change.toFixed(2);
                                s.percentChange = isNaN(pct) ? '0.00' : Number(pct).toFixed(2);
                                s.positive = (parseFloat(s.change || 0) >= 0);

                                const cacheKey = token || sym;
                                this.quoteMap[cacheKey] = {
                                    ltp: s.ltp,
                                    change: s.change,
                                    percentChange: s.percentChange
                                };
                            });
                        });

                    } catch (err) {
                        console.error('quote update error', err);
                    }
                },

                async init() {
                    await this.fetchWatchlists();
                    window.addEventListener('beforeunload', () => {
                        if (this.quoteInterval) clearInterval(this.quoteInterval);
                    });
                }
            };
        }
    </script>
@endsection
