@extends('layouts.userdashboard')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="space-y-8">

        <section x-data="{
            indices: [],
            loading: true,
            
            config: {
                '99926000': { name: 'NIFTY 50', order: 1 },
                '99919000': { name: 'SENSEX', order: 2 },
                '99926009': { name: 'BANK NIFTY', order: 3 },
                '99926037': { name: 'FIN NIFTY', order: 4 },
                '99926004': { name: 'MIDCAP 50', order: 5 },
                '99926002': { name: 'NIFTY AUTO', order: 6 },
                '99926006': { name: 'NIFTY IT', order: 7 },
                '99926005': { name: 'NIFTY FMCG', order: 8 },
                '99926008': { name: 'NIFTY METAL', order: 9 },
                '99926010': { name: 'NIFTY PHARMA', order: 10 },
                '99926017': { name: 'NIFTY OIL & GAS', order: 11 },
                '99926016': { name: 'NIFTY CONS. DURABLES', order: 12 },
                '99926013': { name: 'NIFTY REALTY', order: 13 },
                '99926018': { name: 'NIFTY HEALTHCARE', order: 14 },
                '99926012': { name: 'NIFTY PSU BANK', order: 15 },
                '99926011': { name: 'NIFTY PVT BANK', order: 16 },
                '99926007': { name: 'NIFTY MEDIA', order: 17 },
                '99926022': { name: 'NIFTY ENERGY', order: 18 },
                '99926021': { name: 'NIFTY INFRA', order: 19 },
                '99926025': { name: 'NIFTY COMMODITIES', order: 20 },
            },

            // --- Scroll Logic ---
            scroll(direction) {
                const container = this.$refs.scroller;
                const scrollAmount = 300; // Width of one card + gap
                if (direction === 'left') {
                    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                } else {
                    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                }
            },

            fetchIndices() {
                fetch('/api/angel/indices')
                    .then(res => res.json())
                    .then(res => {
                        if(res.status && res.data && res.data.fetched) {
                            let rawData = res.data.fetched;
                            let processed = rawData.map(item => {
                                let token = item.symbolToken;
                                let conf = this.config[token] || { name: item.tradingSymbol, order: 999 };
                                let change = parseFloat(item.netChange);
                                let percent = parseFloat(item.percentChange);
                                let ltp = parseFloat(item.ltp);
                                return {
                                    id: token,
                                    name: conf.name,
                                    order: conf.order,
                                    value: ltp.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}),
                                    change: `${change > 0 ? '+' : ''}${change.toFixed(2)} (${percent.toFixed(2)}%)`,
                                    positive: change >= 0
                                };
                            });
                            this.indices = processed.sort((a, b) => a.order - b.order);
                        }
                    })
                    .catch(err => console.error('Indices Fetch Error:', err))
                    .finally(() => this.loading = false);
            },
            init() {
                this.fetchIndices();
                setInterval(() => { this.fetchIndices(); }, 3000);
            }
        }">
            <div class="flex items-center gap-2 mb-4">
                <h3 class="font-semibold text-lg">Indices</h3>
                <span class="flex items-center gap-1 bg-green-50 text-green-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-green-100">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> Live
                </span>
            </div>

            <div class="w-full bg-gray-50 p-6 rounded-xl border border-gray-100">
                <div class="flex flex-col lg:flex-row gap-6">
                    
                    <div class="flex-grow min-w-0 relative group"> <div x-show="loading" class="flex justify-center items-center h-48 w-full">
                             <svg class="animate-spin h-8 w-8 text-[#0939a4]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <button @click="scroll('left')" 
                                x-show="!loading"
                                class="absolute left-0 top-1/2 -translate-y-1/2 z-10 p-2 rounded-full bg-white/80 backdrop-blur-sm shadow-md border border-gray-100 text-gray-700 hover:bg-[#0939a4] hover:text-white transition-all -ml-3 md:-ml-4 hidden group-hover:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <div x-ref="scroller"
                             x-show="!loading" 
                             class="grid grid-rows-2 grid-flow-col gap-4 overflow-x-auto pb-4 scrollbar-hide snap-x scroll-smooth">
                            
                            <template x-for="item in indices" :key="item.id">
                                <div class="w-64 flex-shrink-0 bg-white rounded-xl p-4 border border-gray-200 shadow-sm snap-start hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider" x-text="item.name"></p>
                                            <h4 class="font-bold text-xl mt-0.5 text-gray-800" x-text="item.value"></h4>
                                            <p class="text-xs font-bold mt-1"
                                                :class="item.positive ? 'text-green-500' : 'text-red-500'" x-text="item.change"></p>
                                        </div>
                                        <div class="h-8 w-16 opacity-50">
                                            <svg class="w-full h-full" viewBox="0 0 50 20" preserveAspectRatio="none">
                                                <path d="M0 15 Q 10 5, 25 10 T 50 5" fill="none"
                                                    :stroke="item.positive ? '#10b981' : '#ef4444'" stroke-width="2"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button @click="scroll('right')" 
                                x-show="!loading"
                                class="absolute right-0 top-1/2 -translate-y-1/2 z-10 p-2 rounded-full bg-white/80 backdrop-blur-sm shadow-md border border-gray-100 text-gray-700 hover:bg-[#0939a4] hover:text-white transition-all -mr-3 md:-mr-4 hidden group-hover:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <div class="lg:w-64 flex-shrink-0 bg-white rounded-xl p-5 border border-gray-200 text-center shadow-sm flex flex-col justify-center h-full min-h-[180px]">
                        <div class="flex items-center gap-3 mb-3 justify-center">
                            <div class="relative">
                                <img src="https://i.pravatar.cc/80" class="w-10 h-10 rounded-full border border-gray-100" />
                                <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></div>
                            </div>
                            <div class="text-left">
                                <p class="text-xs text-gray-500">Welcome,</p>
                                <h4 class="font-bold text-gray-800 text-sm">Vasanth</h4>
                            </div>
                        </div>
                        <div class="space-y-1 text-left bg-gray-50 p-2 rounded-lg text-[10px]">
                            <p class="flex justify-between text-gray-500 font-medium">Plan: <span class="text-blue-600 font-bold">Premium</span></p>
                            <p class="flex justify-between text-gray-500 font-medium">Expires: <span class="text-orange-600 font-bold">35 Days</span></p>
                        </div>
                        <button class="w-full bg-[#0939a4] hover:bg-blue-700 text-white text-[10px] font-bold py-2 rounded-lg mt-3 transition-colors">
                            View Market Calls
                        </button>
                    </div>

                </div>
            </div>
        </section>

        <section class="grid lg:grid-cols-1 gap-6">
            <div class="p-6 bg-gray-50" x-data="{
                activeTab: 1,
                stocks: [
                    { id: 1, type: 'Buy', name: 'TATA Motors', price: '69.25', time: '17 DEC, 10:19 AM', change: '+1.45(2.14%)', entry: '642.50', target: '648.00', sl: '638.00', category: 'Intraday' },
                    { id: 2, type: 'Sell', name: 'HDFC Bank', price: '1650.10', time: '17 DEC, 10:20 AM', change: '-10.20(0.65%)', entry: '1660.00', target: '1640.00', sl: '1675.00', category: 'Intraday' },
                    { id: 3, type: 'Buy', name: 'Reliance', price: '2450.00', time: '17 DEC, 10:22 AM', change: '+25.00(1.02%)', entry: '2430.00', target: '2490.00', sl: '2410.00', category: 'Swing' },
                    { id: 4, type: 'Buy', name: 'Infosys', price: '1420.50', time: '17 DEC, 10:25 AM', change: '+5.45(0.38%)', entry: '1410.00', target: '1450.00', sl: '1395.00', category: 'Intraday' },
                    { id: 5, type: 'Sell', name: 'Wipro', price: '480.20', time: '17 DEC, 10:30 AM', change: '-2.10(0.42%)', entry: '485.00', target: '470.00', sl: '492.00', category: 'Intraday' }
                ]
            }">
                <h2 class="text-2xl font-bold mb-6 text-[#0939a4]">Today's Market Highlights</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <template x-for="(stock, index) in stocks" :key="stock.id">
                        <div x-show="(activeTab === 1 && index < 4) || (activeTab === 2 && index >= 4)"
                            x-transition:enter="transition ease-out duration-300"
                            class="relative bg-white rounded-2xl border border-gray-200 p-5 shadow-sm overflow-hidden">
                            <div :class="stock.type === 'Buy' ? 'bg-[#00c853]' : 'bg-[#ff3d00]'"
                                class="absolute top-0 left-0 text-white text-[10px] uppercase font-bold px-4 py-1 rounded-br-lg"
                                x-text="stock.type"></div>
                            <div class="flex justify-end items-center gap-2 mb-2">
                                <span class="bg-blue-50 text-blue-600 text-[10px] font-semibold px-2 py-0.5 rounded" x-text="stock.category"></span>
                            </div>
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="font-bold text-gray-800 text-lg" x-text="stock.name"></h3>
                                <span class="text-[#00c853] font-bold text-lg" x-text="stock.price"></span>
                            </div>
                            <div class="flex justify-between items-center mb-6">
                                <p class="text-[11px] text-gray-400 font-medium" x-text="stock.time"></p>
                                <p class="text-sm font-bold text-black" x-text="stock.change"></p>
                            </div>
                            <div class="flex justify-between text-center border-t border-gray-50 pt-4">
                                <div><p class="text-gray-400 text-[12px] mb-1">Entry</p><p class="text-[#00c853] font-bold text-sm" x-text="'₹' + stock.entry"></p></div>
                                <div><p class="text-gray-400 text-[12px] mb-1">Target</p><p class="text-black font-bold text-sm" x-text="'₹' + stock.target"></p></div>
                                <div><p class="text-gray-400 text-[12px] mb-1">Stop-Loss</p><p class="text-[#ff3d00] font-bold text-sm" x-text="'₹' + stock.sl"></p></div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="flex justify-center gap-2 mt-8">
                    <button @click="activeTab = 1" :class="activeTab === 1 ? 'bg-slate-800 w-10' : 'bg-gray-300 w-3'" class="h-2 rounded-full transition-all duration-300"></button>
                    <button @click="activeTab = 2" :class="activeTab === 2 ? 'bg-slate-800 w-10' : 'bg-gray-300 w-3'" class="h-2 rounded-full transition-all duration-300"></button>
                </div>
            </div>
        </section>

        <section class="grid lg:grid-cols-2 gap-8 p-6 bg-gray-50" x-data="{ momentumTab: 'Small Cap', timeFilter: '15 min' }">
            
            <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-4">
                    <h3 class="text-2xl font-bold text-[#0939a4]">Stock in Momentum</h3>
                    <span class="flex items-center gap-1 bg-green-50 text-green-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-green-100">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> Live
                    </span>
                </div>
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden h-full">
                    <div class="bg-[#0939a4] text-white text-center py-2 text-xs font-bold uppercase tracking-wider">Intraday Trends for you</div>
                    <div class="p-4">
                        <table class="w-full">
                            <thead><tr class="text-gray-400 text-[11px] font-bold uppercase tracking-tight"><th class="text-left pb-4">Symbol</th><th class="text-center pb-4" x-text="timeFilter + ' change'"></th><th class="text-right pb-4">LTP</th></tr></thead>
                            <tbody class="divide-y divide-gray-50">
                                <template x-for="stock in [{s: 'SHAKTIPUMP', c: '+13.65(+2.49%)', p: '585.00', pos: true}, {s: 'JAINREC', c: '+3.90(+1.02%)', p: '391.35', pos: true}, {s: 'BALRAMCHIN', c: '+5.90(+1.35%)', p: '443.00', pos: true}]">
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-4 font-bold text-[#0939a4] text-sm" x-text="stock.s"></td>
                                        <td class="py-4 text-center font-bold text-sm" :class="stock.pos ? 'text-green-500' : 'text-red-500'" x-text="stock.c"></td>
                                        <td class="py-4 text-right font-bold text-[#0939a4] text-sm" x-text="stock.p"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex flex-col" x-data="{
                moversTab: 'Top Gainers',
                moversData: [],
                isLoading: false,
                fetchMovers() {
                    this.isLoading = true;
                    let type = this.moversTab === 'Top Gainers' ? 'GAINERS' : 'LOSERS';
                    fetch(`/api/angel/gainers-losers?datatype=${type}`)
                        .then(res => res.json())
                        .then(response => {
                            if(response.status && Array.isArray(response.data)) {
                                this.moversData = response.data.slice(0, 10).map(item => {
                                    let change = parseFloat(item.netChange);
                                    let pct = parseFloat(item.percentChange);
                                    let rawSymbol = item.tradingSymbol;
                                    let cleanName = rawSymbol;
                                    let dateMatch = rawSymbol.match(/\d{2}[A-Z]{3}\d{2}/);
                                    if (dateMatch && dateMatch.index > 0) cleanName = rawSymbol.substring(0, dateMatch.index);
                                    else cleanName = rawSymbol.replace('-EQ', '').replace('-BE', '');
                                    
                                    return {
                                        s: cleanName, v: item.ltp,
                                        c: `${change > 0 ? '+' : ''}${change.toFixed(2)} (${pct.toFixed(2)}%)`,
                                        pos: change >= 0
                                    };
                                });
                            } else { this.moversData = []; }
                        })
                        .catch(err => { console.error(err); this.moversData = []; })
                        .finally(() => this.isLoading = false);
                },
                init() { this.fetchMovers(); this.$watch('moversTab', () => this.fetchMovers()); }
            }">
                <div class="flex items-center gap-2 mb-4">
                    <h3 class="text-2xl font-bold text-[#0939a4]">Market Movers</h3>
                    <span class="flex items-center gap-1 bg-green-50 text-green-600 text-[10px] font-bold px-2 py-0.5 rounded-full border border-green-100">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> Live
                    </span>
                </div>
                <div class="flex border-b border-gray-200 mb-6 overflow-x-auto scrollbar-none">
                    <template x-for="tab in ['Top Gainers', 'Top Losers']">
                        <button @click="moversTab = tab" :class="moversTab === tab ? 'border-b-2 border-black text-black font-bold' : 'text-gray-500 font-medium'" class="pb-2 px-4 text-sm whitespace-nowrap transition-all" x-text="tab"></button>
                    </template>
                </div>
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col h-full relative min-h-[300px]">
                    <div x-show="isLoading" class="absolute inset-0 bg-white/80 z-10 flex justify-center items-center rounded-3xl">
                        <svg class="animate-spin h-8 w-8 text-[#0939a4]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <div class="space-y-6 flex-grow">
                        <div x-show="!isLoading && moversData.length === 0" class="text-center py-10 text-gray-400 text-sm">No data available.</div>
                        <template x-for="mover in moversData">
                            <div class="flex justify-between items-start border-b border-gray-50 last:border-0 last:pb-0">
                                <div>
                                    <p class="font-bold text-[#0939a4] text-sm tracking-tight" x-text="mover.s"></p>
                                    <p class="text-[11px] font-medium text-gray-400" x-text="mover.n"></p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-[#0939a4] text-sm" x-text="mover.v"></p>
                                    <p class="text-[11px] font-bold" :class="mover.pos ? 'text-green-500' : 'text-red-500'" x-text="mover.c"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button class="w-full bg-[#0939a4] hover:bg-blue-700 text-white font-bold py-4 rounded-2xl mt-8 transition-all shadow-lg shadow-blue-100 text-sm">View All</button>
                </div>
            </div>
        </section>

    </div>
@endsection