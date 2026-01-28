@extends('layouts.app')

@section('content')
    {{-- CSRF Token for AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Include Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="p-4 md:p-6 space-y-6 text-sm text-gray-700" x-data="{
        showModal: false,
        showCategoryModal: false,
        activeTip: null,
        filterType: 'all',
        allTips: {{ json_encode(collect($tips->items())->map(function ($tip) {
            $tip->priceDirection = null; 
            $tip->is_updating = false;
            return $tip;
        })) }},
    
        get filteredTips() {
            if (this.filterType === 'all') return this.allTips;
            return this.allTips.filter(tip => {
                return tip.tip_type && tip.tip_type.toLowerCase().trim() === this.filterType.toLowerCase().trim();
            });
        },
    
        exportCSV() {
            const data = this.filteredTips;
            if (!data || data.length === 0) {
                alert('No data available to export.');
                return;
            }
            const headers = [
                'ID', 'Type', 'Stock Name', 'Token', 'Exchange', 'Call', 'Category', 
                'Entry Price', 'Target 1', 'Target 2', 'Stop Loss', 'Status', 'Trade Status', 'Date Created'
            ];
            const rows = data.map(tip => [
                tip.id,
                tip.tip_type,
                `&quot;${tip.stock_name}&quot;`, 
                tip.symbol_token,
                tip.exchange,
                tip.call_type,
                tip.category ? tip.category.name : '',
                tip.entry_price,
                tip.target_price,
                tip.target_price_2 || '',
                tip.stop_loss,
                tip.status,
                tip.trade_status,
                tip.created_at
            ]);
            const csvContent = [
                headers.join(','), 
                ...rows.map(e => e.join(','))
            ].join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'market_tips_export.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
    
        openRandomTip() {
            let list = this.filteredTips;
            if (list.length > 0) {
                let random = Math.floor(Math.random() * list.length);
                this.activeTip = list[random];
                this.showModal = true;
            }
        },
    
        init() {
            $store.liveMarket.start(this.allTips);
        }
    }" @ajax-updated.window="allTips = $event.detail.tips; $store.liveMarket.start(allTips)">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h1 class="text-lg font-bold text-gray-800 tracking-tight">Market Analytics Dashboard</h1>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ url('admin/risk-reward-master') }}"
                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg text-xs font-black hover:bg-yellow-600 transition flex items-center gap-2 shadow-lg shadow-yellow-200">
                    <i class="fa-solid fa-calculator"></i> PRICE MASTER
                </a>
                
                <a href="{{ url('admin/tips-categories') }}"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-xs font-black hover:bg-emerald-700 transition flex items-center gap-2 shadow-lg shadow-emerald-200">
                    <i class="fa-solid fa-layer-group"></i> CATEGORIES
                </a>

                <button @click="openRandomTip()"
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg text-xs font-black hover:bg-purple-700 transition flex items-center gap-2 shadow-lg shadow-purple-200">
                    <i class="fa-solid fa-dice"></i> RANDOM PREVIEW
                </button>

                <a href="{{ route('admin.tips.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-black hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                    + EQUITY
                </a>
                <a href="{{ route('admin.tips.future_Option') }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-black hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                    + FUTURE & OPTION
                </a>
            </div>
        </div>

        <div id="tips-table-container"> 
            {{-- SEARCH & FILTER FORM --}}
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-6">
                <form id="filterForm" action="{{ route('admin.tips.index') }}" method="GET"
                    class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 items-end">
                    
                    {{-- 1. Search Stock --}}
                    <div class="col-span-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block tracking-widest">Search Stock</label>
                        <div class="relative">
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                placeholder="Search e.g. VEDL..."
                                class="filter-input w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-bold outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                            <i class="fa-solid fa-magnifying-glass absolute right-4 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- 2. Trade Status (Open/Closed) --}}
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block tracking-widest">Trade Status</label>
                        <select name="trade_status"
                            class="filter-input w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-bold outline-none">
                            <option value="">All</option>
                            <option value="Open" {{ request('trade_status') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ request('trade_status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    {{-- 3. Result Status --}}
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block tracking-widest">Result Status</label>
                        <select name="status"
                            class="filter-input w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-bold outline-none">
                            <option value="">All Results</option>
                            <option value="Active" {{ (request('status') == 'Active' || request('status') == 'active') ? 'selected' : '' }}>Active</option>
                            <option value="T1-Achieved" {{ request('status') == 'T1-Achieved' ? 'selected' : '' }}>T1 Achieved</option>
                            <option value="T2-Achieved" {{ request('status') == 'T2-Achieved' ? 'selected' : '' }}>T2 Achieved</option>
                            <option value="SL-Hit" {{ request('status') == 'SL-Hit' ? 'selected' : '' }}>SL Hit</option>
                            <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    {{-- 4. Date --}}
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block tracking-widest">Date</label>
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="filter-input w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-xs font-bold outline-none focus:ring-4 focus:ring-blue-500/10 transition-all">
                    </div>

                    {{-- 5. Month --}}
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block tracking-widest">Month</label>
                        <select name="month"
                            class="filter-input w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-bold outline-none">
                            <option value="">All Months</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- 6. Year --}}
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block tracking-widest">Year</label>
                        <select name="year"
                            class="filter-input w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-bold outline-none">
                            <option value="">All Years</option>
                            @for ($y = date('Y'); $y >= 2023; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- 7. Reset Button --}}
                    <div class="flex">
                        <a href="{{ route('admin.tips.index') }}"
                            class="w-full bg-gray-100 text-gray-500 py-2.5 rounded-xl font-black text-[10px] uppercase flex items-center justify-center hover:bg-gray-200 transition-all gap-2">
                            <i class="fa-solid fa-rotate-right"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Filter Tabs --}}
           <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
             <div class="mb-4 bg-gray-100 p-1 rounded-xl inline-flex gap-1 border border-gray-200 flex-wrap">
                <button @click="filterType = 'all'"
                    :class="filterType === 'all' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'"
                    class="px-6 py-2 rounded-lg text-[11px] font-black uppercase tracking-widest transition-all">All Tips</button>
                <button @click="filterType = 'equity'"
                    :class="filterType === 'equity' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'"
                    class="px-6 py-2 rounded-lg text-[11px] font-black uppercase tracking-widest transition-all">Equity</button>
                <button @click="filterType = 'future'"
                    :class="filterType === 'future' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'"
                    class="px-6 py-2 rounded-lg text-[11px] font-black uppercase tracking-widest transition-all">Future</button>
                <button @click="filterType = 'option'"
                    :class="filterType === 'option' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'"
                    class="px-6 py-2 rounded-lg text-[11px] font-black uppercase tracking-widest transition-all">Option</button>
            </div>
                <button @click="exportCSV()"
                    class=" mb-4 px-4 py-2 bg-green-700 text-white rounded-lg text-xs font-black hover:bg-green-800 transition flex items-center gap-2 shadow-lg shadow-green-200">
                    <i class="fa-solid fa-file-csv"></i> EXPORT CSV
                </button>
           </div>
            
            {{-- Data Table --}}
            <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs" id="tipsTable">
                        <thead class="bg-gray-50 text-gray-500 border-b border-gray-100">
                            <tr>
                                <th class="p-4 text-left font-bold uppercase tracking-wider">Date</th>
                                <!-- <th class="p-4 text-left font-bold uppercase tracking-wider">Time</th> -->
                                <th class="p-4 text-left font-bold uppercase tracking-wider">Stock / Exc.</th>
                                <th class="p-4 text-center font-bold uppercase tracking-wider">Call</th>
                                <th class="p-4 text-center font-bold uppercase tracking-wider">Type</th>
                                <th class="p-4 text-center font-bold uppercase tracking-wider">Category</th>
                                <th class="p-4 text-center font-bold uppercase tracking-wider">Entry</th>
                                <th class="p-4 text-center font-bold uppercase tracking-wider">T-1</th>
                                <th class="p-4 text-center font-bold uppercase tracking-wider">T-2</th>
                                <th class="p-4 text-center font-bold uppercase tracking-wider">SL</th>
                                <th class="p-4 text-center font-bold uppercase tracking-wider">CMP</th>
                                <th class="p-4 text-center font-bold uppercase tracking-wider">Status</th>
                                <th class="p-4 text-right font-bold uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <template x-for="tip in filteredTips" :key="tip.id">
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="p-4 whitespace-nowrap">
                                        <div class="flex flex-col gap-0">
                                            <span class="text-xs font-black text-gray-800 uppercase tracking-tight" 
                                                x-text="new Date(tip.created_at).toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: '2-digit'})">
                                            </span>
                                            
                                            <div class="flex items-center gap-1 text-[10px] font-bold text-gray-400">
                                                <i class="fa-regular fa-clock text-[9px]"></i>
                                                <span x-text="new Date(tip.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-black text-gray-900" x-text="tip.stock_name"></div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase"
                                            x-text="tip.exchange"></div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span :class="tip.call_type === 'Buy' ? 'bg-green-600' : 'bg-red-600'"
                                            class="px-2 py-1 rounded text-white text-[10px] font-black uppercase"
                                            x-text="tip.call_type"></span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="px-2 py-1 rounded bg-gray-100 text-gray-600 text-[10px] font-bold uppercase"
                                            x-text="tip.tip_type"></span>
                                    </td>
                                    <td class="p-4 text-center text-gray-500 font-medium"
                                        x-text="tip.category?.name || '-'"></td>
                                    <td class="p-4 text-center font-bold text-gray-700">₹<span
                                            x-text="tip.entry_price"></span></td>
                                    <td class="p-4 text-center font-bold text-green-600">₹<span
                                            x-text="tip.target_price"></span></td>
                                    <td class="p-4 text-center font-bold text-emerald-700">₹<span
                                            x-text="tip.target_price_2 || '-'"></span></td>
                                    <td class="p-4 text-center font-bold text-red-500">₹<span
                                            x-text="tip.stop_loss"></span></td>
                                    <td class="p-4 text-center font-bold">
                                        <span
                                            :class="{
                                                'text-green-600': tip.priceDirection === 'up',
                                                'text-red-600': tip.priceDirection === 'down',
                                                'text-gray-900': !tip.priceDirection
                                            }">
                                            ₹<span x-text="tip.cmp_price"></span>
                                            <template x-if="tip.priceDirection === 'up'"><span> ▲</span></template>
                                            <template x-if="tip.priceDirection === 'down'"><span> ▼</span></template>
                                        </span>
                                    </td>
                                    
                                    {{-- UPDATED STATUS COLUMN --}}
                                    <td class="p-4 text-center">
                                        <span
                                            :class="{
                                                'bg-blue-50 text-blue-700 border-blue-100': tip.status === 'Active' || tip.status === 'active',
                                                'bg-green-100 text-green-700 border-green-200': tip.status === 'T1-Achieved',
                                                'bg-emerald-100 text-emerald-800 border-emerald-200': tip.status === 'T2-Achieved',
                                                'bg-red-100 text-red-700 border-red-200': tip.status === 'SL-Hit',
                                                'bg-white-800 text-white border-gray-900': tip.trade_status === 'Closed',
                                                'bg-white-50 text-gray-500 border-gray-100': !['Active', 'active', 'T1-Achieved', 'T2-Achieved', 'SL-Hit'].includes(tip.status) && tip.trade_status !== 'Closed'
                                            }"
                                            class="px-2 py-1 rounded-md text-[10px] font-bold border whitespace-nowrap">
                                            
                                            <i x-show="tip.is_updating" class="fa-solid fa-circle-notch fa-spin mr-1"></i>
                                            <span x-text="tip.trade_status === 'Closed' ? 'Closed (' + tip.status + ')' : tip.status"></span>
                                        </span>
                                    </td>

                                    <td class="p-4 text-right whitespace-nowrap">
                                        <button @click="activeTip = tip; showModal = true;"
                                            class="text-blue-600 hover:text-blue-800 transition-colors text-xs font-black uppercase inline-flex items-center gap-1">
                                            <i class="fa-solid fa-eye"></i> 
                                        </button>
                                        <span class="text-gray-300 mx-1">|</span>
                                        <a :href="`{{ url('admin/tips') }}/${tip.id}/edit`"
                                            class="text-blue-600 hover:text-blue-800 transition-colors text-xs font-black uppercase inline-flex items-center gap-1">
                                            <i class="fa-solid fa-pen-to-square"></i> 
                                        </a>
                                    </td>
                                </tr>
                            </template>
                            
                            <tr x-show="filteredTips.length === 0">
                                <td colspan="13" class="p-8 text-center text-gray-400 text-xs font-bold uppercase tracking-widest">
                                    No data found for selected filter
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="pagination-container" class="mt-8 p-5 border-t-2">
                        {{ $tips->links('pagination.dots') }}
                    </div>
                </div>
            </div>

            <div id="new-tips-data" style="display:none">{{ $tips->getCollection()->toJson() }}</div>
        </div>

        {{-- TIP DETAILS MODAL (Pop-up) --}}
        <div x-show="showModal" x-cloak x-transition.opacity
            class="fixed inset-0 bg-gray-900/80 backdrop-blur-md flex items-center justify-center z-[100] p-4">

            <div @click.away="showModal = false"
                class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden relative border border-gray-100 max-h-[90vh] overflow-y-auto animate-fade-in">

                <button @click="showModal = false"
                    class="absolute top-6 right-6 text-gray-400 hover:text-gray-900 transition-colors p-2 bg-gray-50 rounded-full z-10">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-blue-200"
                                x-text="activeTip ? activeTip.stock_name.charAt(0) : ''"></div>
                            <div>
                                <h2 class="text-2xl font-black text-gray-900 tracking-tight leading-none mb-1"
                                    x-text="activeTip?.stock_name"></h2>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-[10px] font-black text-blue-600 uppercase tracking-widest bg-blue-50 px-2 py-0.5 rounded"
                                        x-text="activeTip?.tip_type"></span>
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                        x-text="activeTip?.exchange"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span
                                :class="activeTip?.call_type === 'Buy' ? 'bg-green-100 text-green-700' :
                                    'bg-red-100 text-red-700'"
                                class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest"
                                x-text="activeTip?.call_type"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Entry Price</p>
                            <p class="text-lg font-black text-gray-900">₹<span x-text="activeTip?.entry_price"></span></p>
                        </div>
                        
                        <div class="relative overflow-hidden bg-blue-50 p-5 rounded-3xl border border-blue-200 shadow-sm hover:shadow-md transition-all">
                            <div class="absolute -top-6 -right-6 w-20 h-20 bg-blue-300/20 rounded-full blur-2xl"></div>
                            <p class="text-[8px] font-black text-blue-500 uppercase tracking-widest mb-2">
                                Current Market Price
                            </p>
                            <div class="flex items-end gap-2">
                                <span class="text-xl font-black text-blue-700">₹</span>
                                <span class="text-xl font-extrabold tracking-tight text-blue-700"
                                    x-text="activeTip?.cmp_price || activeTip?.entry_price">
                                </span>
                                <span x-show="activeTip?.priceDirection === 'up'"
                                    class="text-green-600 text-lg font-black animate-pulse">▲</span>
                                <span x-show="activeTip?.priceDirection === 'down'"
                                    class="text-red-600 text-lg font-black animate-pulse">▼</span>
                            </div>
                        </div>

                        <div class="bg-red-50 p-4 rounded-2xl border border-red-100">
                            <p class="text-[9px] font-black text-red-400 uppercase mb-1">Stop Loss</p>
                            <p class="text-lg font-black text-red-700">₹<span x-text="activeTip?.stop_loss"></span></p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-2xl border border-green-100">
                            <p class="text-[9px] font-black text-green-500 uppercase mb-1">Target 1</p>
                            <p class="text-lg font-black text-green-700">₹<span x-text="activeTip?.target_price"></span>
                            </p>
                        </div>
                        <div class="bg-green-50/50 p-4 rounded-2xl border border-green-100">
                            <p class="text-[9px] font-black text-green-500 uppercase mb-1">Target 2</p>
                            <p class="text-lg font-black text-green-700">₹<span
                                    x-text="activeTip?.target_price_2 || '-'"></span></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Category</p>
                            <p class="text-sm font-black text-gray-700" x-text="activeTip?.category?.name || 'N/A'"></p>
                        </div>
                    </div>

                    <template x-if="activeTip?.tip_type && activeTip?.tip_type !== 'equity'">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 border-t pt-6">
                            <div x-show="activeTip?.strike_price">
                                <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Strike Price</p>
                                <p class="text-sm font-black text-gray-900" x-text="activeTip?.strike_price"></p>
                            </div>
                            <div x-show="activeTip?.option_type">
                                <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Option Type</p>
                                <p class="text-sm font-black text-gray-900" x-text="activeTip?.option_type"></p>
                            </div>
                            <div x-show="activeTip?.expiry_date">
                                <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Expiry Date</p>
                                <p class="text-sm font-black text-gray-900" x-text="activeTip?.expiry_date"></p>
                            </div>
                        </div>
                    </template>

                    <div class="bg-amber-50 p-5 rounded-2xl border border-amber-100 mb-8">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-circle-info text-amber-500 text-xs"></i>
                            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Admin Note</p>
                        </div>
                        <p class="text-sm font-medium text-amber-900 leading-relaxed italic"
                            x-text="activeTip?.admin_note || 'No additional notes provided for this trade.'"></p>
                    </div>

                    <div class="flex gap-3">
                        <button @click="showModal = false"
                            class="flex-1 py-4 bg-gray-100 text-gray-900 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition-all">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- NEW: CREATE CATEGORY MODAL --}}
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

    {{-- 🔴🔴🔴 LIVE PRICE & STATUS ENGINE 🔴🔴🔴 --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('liveMarket', {
                previousPrices: {},

                start(tipsList) {
                    console.log('🚀 Live Market Store Started', tipsList.length);

                    setInterval(async () => {
                        // console.log('⏱ Fetching Angel live prices...');

                        // Filter only Active trades to check
                        const activeTips = tipsList.filter(t => !['SL-Hit', 'T2-Achieved', 'Closed', 'archived', 'cancel'].includes(t.status));

                        for (const tip of activeTips) {
                            
                            if (!tip.symbol_token) continue;
                            if (tip.is_updating) continue; // Skip if currently updating via AJAX

                            try {
                                const params = new URLSearchParams({
                                    symbol: tip.symbol_token, 
                                    exchange: tip.exchange
                                });

                                const res = await fetch(`/api/angel/quote?${params.toString()}`);
                                const json = await res.json();

                                if (json?.data?.fetched?.length) {
                                    const newPrice = parseFloat(json.data.fetched[0].ltp);
                                    const oldPrice = parseFloat(tip.cmp_price);

                                    // 1. Update Direction
                                    if (!this.previousPrices[tip.id]) {
                                        this.previousPrices[tip.id] = oldPrice;
                                    }

                                    if (newPrice > this.previousPrices[tip.id]) {
                                        tip.priceDirection = 'up';
                                    } else if (newPrice < this.previousPrices[tip.id]) {
                                        tip.priceDirection = 'down';
                                    }

                                    tip.cmp_price = newPrice;
                                    this.previousPrices[tip.id] = newPrice;
                                    
                                    // 2. CHECK STATUS (T1, T2, SL) AND SAVE TO DB
                                    this.checkStatus(tip);

                                } 
                            } catch (e) {
                                console.error('❌ Angel API error:', e);
                            }
                        }

                    }, 3000); // 3 seconds interval
                },

                // Helper to calculate status based on Tip Type
                checkStatus(tip) {
                    // 🛑 CRITICAL CHECK: IF TRADE IS CLOSED, DO NOT UPDATE STATUS
                    if (tip.trade_status === 'Closed' || tip.status === 'Closed') {
                        return;
                    }

                    const cmp = parseFloat(tip.cmp_price);
                    const t1 = parseFloat(tip.target_price);
                    const t2 = tip.target_price_2 ? parseFloat(tip.target_price_2) : null;
                    const sl = parseFloat(tip.stop_loss);
                    const callType = tip.call_type.toLowerCase(); // 'buy' or 'sell'

                    let newStatus = tip.status;

                    if (callType === 'buy') {
                        // BUY LOGIC
                        if (t2 && cmp >= t2) {
                            newStatus = 'T2-Achieved';
                        } else if (cmp >= t1) {
                            // Only upgrade to T1 if we aren't already at T2
                            if (newStatus !== 'T2-Achieved') {
                                newStatus = 'T1-Achieved';
                            }
                        } else if (cmp <= sl) {
                            newStatus = 'SL-Hit';
                        }
                    } else if (callType === 'sell') {
                        // SELL LOGIC (Targets are lower, SL is higher)
                        if (t2 && cmp <= t2) {
                            newStatus = 'T2-Achieved';
                        } else if (cmp <= t1) {
                            if (newStatus !== 'T2-Achieved') {
                                newStatus = 'T1-Achieved';
                            }
                        } else if (cmp >= sl) {
                            newStatus = 'SL-Hit';
                        }
                    }

                    // 3. IF STATUS CHANGED, SAVE TO DATABASE VIA AJAX
                    if (newStatus !== tip.status) {
                        console.log(`⚡ Status Change Detected for #${tip.id}: ${tip.status} -> ${newStatus}`);
                        this.updateTipStatus(tip, newStatus);
                    }
                },

                // AJAX FUNCTION TO UPDATE DB
                async updateTipStatus(tip, newStatus) {
                    tip.is_updating = true;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    try {
                        const response = await fetch(`/admin/tips/${tip.id}/update-live-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                status: newStatus,
                                cmp_price: tip.cmp_price
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            // Update local model
                            tip.status = result.new_status;
                            
                            if(result.trade_status) {
                                tip.trade_status = result.trade_status;
                            }
                        } else {
                            console.error('Failed to update status', result);
                        }
                    } catch (error) {
                        console.error('AJAX Error:', error);
                    } finally {
                        tip.is_updating = false;
                    }
                }
            });
        });
    </script>

    <style>
        [x-cloak] { display: none !important; }
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
        .animate-fade-in { animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>

    {{-- AJAX SCRIPT (Keeping existing jQuery for Filter) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function filterTips(pageUrl = null) {
                let form = $('#filterForm');
                let url = pageUrl || form.attr('action');
                let formData = form.serialize();
                $('#tips-table-container').css('opacity', '0.5');

                $.ajax({
                    url: url,
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        let newHtml = $(response).find('#tips-table-container').html();
                        $('#tips-table-container').html(newHtml);

                        let freshTips = JSON.parse($(response).find('#new-tips-data').text());
                        window.dispatchEvent(new CustomEvent('ajax-updated', {
                            detail: { tips: freshTips }
                        }));

                        $('#tips-table-container').css('opacity', '1');
                        window.history.pushState({}, '', url + '?' + formData);
                    }
                });
            }

            $(document).on('change', '.filter-input', function() {
                if (this.id !== 'searchInput') filterTips();
            });

            let typingTimer;
            $(document).on('keyup', '#searchInput', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(filterTips, 700);
            });

            $(document).on('click', '#pagination-container a', function(e) {
                e.preventDefault();
                filterTips($(this).attr('href'));
            });
        });
    </script>
@endsection