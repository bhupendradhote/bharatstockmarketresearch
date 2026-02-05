@extends('layouts.userdashboard')
@section('content')
    {{-- WRAPPER FOR BACKGROUND GRADIENT --}}
    <div class="dashboard-mesh min-h-screen p-4 sm:p-6 rounded-3xl">
        <div class="space-y-10 pb-10" x-cloak x-data="marketDashboard({
            highlights: {{ $highlights->toJson() }},
            marketCalls: {{ $marketCalls->toJson() }},
            categories: {{ $categories->toJson() }},
            {{-- userPlanId: {{ $activeSubscription->service_plan_id ?? 'null' }}, --}}
            userPlanId: {{ $activeSubscription->service_plan_id ?? 'null' }},
            isDemo: {{ $activeSubscription && $activeSubscription->isDemo() ? 'true' : 'false' }},
            firstCategory: '{{ $categories->first()->name ?? '' }}'
        })">
            {{-- MARKET HIGHLIGHTS SECTION --}}
            <section x-show="highlights.length > 0">
                <div class="flex items-center gap-2 mb-6">
                    <div class="h-8 w-1.5 bg-[#0939a4] rounded-full shadow-lg shadow-blue-500/30"></div>
                    <h2 class="text-2xl font-black text-[#0939a4] tracking-tight drop-shadow-sm">Today's Highlights</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-4">
                    <template x-for="item in highlights" :key="item.id">
                        {{-- Card Component --}}
                        <div x-data="stockCard(item)" x-init="init()" class="relative group stockCard">

                            {{-- MAIN CARD UI (Glassmorphism applied) --}}
                            <div
                                class="glass-panel rounded-[24px] px-2 pb-3 pt-5 relative overflow-visible transition-all duration-300 hover:shadow-2xl">

                                {{-- Top Floating Tag (Only show if accessed, or show generic potential if locked) --}}
                                <div
                                    class="absolute -top-2 -left-1 bg-[#8e44ad] text-white text-xs font-bold px-3 py-1 rounded-tl-xl rounded-tr-xl rounded-br-xl rounded-tl-none shadow-lg shadow-purple-500/40 z-10 flex items-center gap-1">
                                    <span
                                        x-text="checkAccess(item) ? upsidePercent + '% potential' : 'High Potential'"></span>
                                    <div class="absolute top-full left-0 w-2 h-2 bg-[#732d91] -z-10"
                                        style="clip-path: polygon(100% 0, 0 0, 100% 100%);"></div>
                                </div>

                                {{-- Header --}}
                                <div class="flex justify-between items-start mb-6 mt-2">
                                    <div class="flex gap-3 items-center">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-[#0939a4] flex items-center justify-center shadow-lg shadow-blue-500/20 shrink-0">
                                            <span class="text-white font-black text-[10px]" x-text="item.exchange"></span>
                                        </div>
                                        <div>
                                            <h3 class="font-black text-gray-800 text-base leading-tight uppercase tracking-tight"
                                                x-text="item.stock_name"></h3>
                                            <p class="text-[10px] text-gray-500 font-bold mt-0.5">
                                                Published on <span x-text="formatDate(item.created_at)"></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-1">
                                        <div class="flex items-center gap-2 livelable">
                                            <div
                                                class="bg-red-500 text-white text-[9px] font-black px-2 py-0.5 rounded flex items-center gap-1 ">
                                                <span class="animate-pulse w-1.5 h-1.5 bg-white rounded-full"></span> LIVE
                                            </div>
                                            <span
                                                class="text-xs text-gray-400 font-medium cursor-pointer hover:text-[#0939a4] transition-colors">Save
                                                <i class="fa-regular fa-bookmark ml-0.5"></i></span>
                                        </div>
                                        <div class="text-right mt-1">
                                            {{-- Animated CMP --}}
                                            <div class="text-base font-black text-gray-800 transition-colors duration-300"
                                                x-text="cmp" :class="flashColor"></div>
                                            <div class="text-[10px] font-bold"
                                                :class="changePercent >= 0 ? 'text-green-600' : 'text-red-500'">
                                                <span x-text="changePercent"></span>%
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SECURED CONTENT CONDITION --}}

                                {{-- 1. IF USER HAS ACCESS: SHOW DATA --}}
                                <template x-if="checkAccess(item)">
                                    <div class="potential-up">
                                        {{-- Potential Upside Section --}}
                                        <div class="mb-3">
                                            <div class="flex items-baseline gap-2 mb-4">
                                                <h4 class="text-4xl font-black text-[#58ae72]" x-text="upsidePercent + '%'">
                                                </h4>
                                                <span
                                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Potential
                                                    Upside</span>
                                            </div>
                                            {{-- VISUAL SLIDER --}}
                                            <div class="relative h-12 mx-1">
                                                <div
                                                    class="flex justify-between text-[10px] font-bold text-gray-500 mb-1 px-1">
                                                    <div class="text-left">Stop-Loss<br><span class="text-gray-800 text-xs"
                                                            x-text="item.stop_loss"></span></div>
                                                    <div class="text-center">Entry<br><span class="text-gray-800 text-xs"
                                                            x-text="item.entry_price"></span></div>
                                                    <div class="text-right">Target<br><span class="text-gray-800 text-xs"
                                                            x-text="item.target_price"></span></div>
                                                </div>
                                                {{-- Track (Dynamic Gradient) --}}
                                                <div class="absolute top-10 left-0 w-full h-2 rounded-full shadow-inner"
                                                    :class="(item.call_type && item.call_type.toUpperCase() === 'SELL') ?
                                                    'range-gradient-sell' : 'range-gradient-buy'">
                                                </div>
                                                {{-- Current Position Dot (Dynamic) --}}
                                                <div class="absolute top-11 -translate-y-1/2 -translate-x-1/2 z-10 transition-all duration-700 ease-out"
                                                    :style="`left: ${cmpPosition}%`">
                                                    <div
                                                        class="w-5 h-5 bg-white border-[3px] border-[#58ae72] rounded-full shadow-[0_4px_10px_rgba(0,0,0,0.2)] flex items-center justify-center">
                                                        <div class="w-1.5 h-1.5 bg-[#58ae72] rounded-full"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Price Pill --}}
                                        <div
                                            class="bg-gray-50/50 backdrop-blur-sm rounded-xl p-1 flex justify-between items-center mb-3 border border-white/60">
                                            <div class="text-gray-500 text-xs font-medium"
                                                x-text="parseFloat(item.stop_loss).toFixed(2)"></div>
                                            <div class="w-px h-4 bg-gray-300"></div>
                                            <div class="text-gray-800 text-sm font-black" x-text="cmp"></div>
                                            <div class="w-px h-4 bg-gray-300"></div>
                                            <div class="text-xs font-bold"
                                                :class="isProfit ? 'text-green-600' : 'text-red-500'">
                                                <span x-text="changePercent"></span>%
                                            </div>
                                        </div>
                                        {{-- Action Button --}}
                                        <button
                                            class="glass-button w-full py-1.5 rounded-full font-black text-base text-gray-800 transition-all mb-2 flex items-center justify-center gap-2">
                                            <span x-text="item.call_type ? item.call_type : 'VIEW DETAILS'"></span>
                                            <i class="fa-solid fa-chevron-right text-xs"></i>
                                        </button>
                                    </div>
                                </template>

                                {{-- 2. IF USER DOES NOT HAVE ACCESS: SHOW UPGRADE BOX (No Overlay) --}}
                                <template x-if="!checkAccess(item)">
                                    <div
                                        class="potential-up bg-gray-50/50 flex flex-col items-center justify-center py-6 gap-3">

                                        <div class="text-center">
                                            <h3 class="text-[#8e44ad] font-black text-sm uppercase tracking-tight">Premium
                                                Trade</h3>
                                            <p class="text-gray-500 text-[10px] font-bold">Upgrade to view potential</p>
                                        </div>
                                        <a href="{{ url('/settings') }}"
                                            class="bg-[#8e44ad] text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-wider shadow-lg hover:bg-[#732d91] transition-all">
                                            Unlock Now
                                        </a>
                                    </div>
                                </template>

                            </div>
                        </div>
                    </template>
                </div>
            </section>
            {{-- MARKET CALLS TABS SECTION --}}
            <section>
                <div class="flex items-center gap-2 mb-6 mt-8">
                    <div class="h-8 w-1.5 bg-[#0939a4] rounded-full shadow-lg"></div>
                    <h2 class="text-2xl font-black text-[#0939a4] tracking-tight">Market Calls</h2>
                </div>
                {{-- Tabs --}}
                <div class="flex border-b border-gray-200/50 mb-8 overflow-x-auto scrollbar-none gap-6 pb-1">
                    <template x-for="cat in categories" :key="cat.id">
                        <button @click="callTab = cat.name"
                            :class="callTab === cat.name ? 'border-b-4 border-[#0939a4] text-[#0939a4] font-black' :
                                'text-gray-400 font-bold hover:text-gray-600'"
                            class="pb-3 px-2 text-sm whitespace-nowrap transition-all uppercase tracking-wide">
                            <span x-text="cat.name"></span>
                            <span
                                class="ml-1 text-[10px] bg-white/60 backdrop-blur-sm px-1.5 py-0.5 rounded-full text-gray-500 shadow-sm border border-white/50"
                                x-text="countTipsInTab(cat.name)"></span>
                        </button>
                    </template>
                </div>
                {{-- Filtered Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-4">
                    <template x-for="call in marketCalls" :key="call.id">
                        <template x-if="call.category && call.category.name === callTab">
                            {{-- Reuse Card Logic / UI --}}
                            <div x-data="stockCard(call)" x-init="init()" class="relative group">

                                {{-- MAIN CARD UI --}}
                                <div
                                    class="glass-panel rounded-[24px] p-5 relative overflow-visible transition-all hover:shadow-2xl">

                                    <div
                                        class="absolute -top-2 -left-1 bg-[#8e44ad] text-white text-xs font-bold px-3 py-1 rounded-tl-xl rounded-tr-xl rounded-br-xl rounded-tl-none shadow-lg shadow-purple-500/40 z-10 flex items-center gap-1">
                                        <span
                                            x-text="checkAccess(call) ? upsidePercent + '% potential' : 'High Potential'"></span>
                                        <div class="absolute top-full left-0 w-2 h-2 bg-[#732d91] -z-10"
                                            style="clip-path: polygon(100% 0, 0 0, 100% 100%);"></div>
                                    </div>
                                    <div class="flex justify-between items-start mb-6 mt-2">
                                        <div class="flex gap-3 items-center">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-[#0939a4] flex items-center justify-center shadow-lg shadow-blue-500/20 shrink-0">
                                                <span class="text-white font-black text-[10px]"
                                                    x-text="call.exchange"></span>
                                            </div>
                                            <div>
                                                <h3 class="font-black text-gray-800 text-base leading-tight uppercase tracking-tight"
                                                    x-text="call.stock_name"></h3>
                                                <p class="text-[10px] text-gray-500 font-bold mt-0.5">
                                                    Published on <span x-text="formatDate(call.created_at)"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-1">
                                            <div class="flex items-center gap-2 livelable">
                                                <div
                                                    class="bg-red-500 text-white text-[9px] font-black px-2 py-0.5 rounded flex items-center gap-1 ">
                                                    <span class="animate-pulse w-1.5 h-1.5 bg-white rounded-full"></span>
                                                    LIVE
                                                </div>
                                                <span
                                                    class="text-xs text-gray-400 font-medium cursor-pointer hover:text-[#0939a4] transition-colors">Save
                                                    <i class="fa-regular fa-bookmark ml-0.5"></i></span>
                                            </div>
                                            <div class="text-right mt-1">
                                                {{-- Animated CMP --}}
                                                <div class="text-base font-black text-gray-800 transition-colors duration-300"
                                                    x-text="cmp" :class="flashColor"></div>
                                                <div class="text-[10px] font-bold"
                                                    :class="changePercent >= 0 ? 'text-green-600' : 'text-red-500'">
                                                    <span x-text="changePercent"></span>%
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SECURED CONTENT CONDITION --}}

                                    {{-- 1. IF USER HAS ACCESS --}}
                                    <template x-if="checkAccess(call)">
                                        <div class="potential-up">
                                            <div class="mb-3">
                                                <div class="flex items-baseline gap-2 mb-4">
                                                    <h4 class="text-4xl font-black text-[#58ae72]"
                                                        x-text="upsidePercent + '%'"></h4>
                                                    <span
                                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Potential
                                                        Upside</span>
                                                </div>
                                                <div class="relative h-12 mx-1">
                                                    <div
                                                        class="flex justify-between text-[10px] font-bold text-gray-500 mb-1 px-1">
                                                        <div class="text-left">Stop-Loss<br><span
                                                                class="text-gray-800 text-xs"
                                                                x-text="call.stop_loss"></span></div>
                                                        <div class="text-center">Entry<br><span
                                                                class="text-gray-800 text-xs"
                                                                x-text="call.entry_price"></span></div>
                                                        <div class="text-right">Target<br><span
                                                                class="text-gray-800 text-xs"
                                                                x-text="call.target_price"></span></div>
                                                    </div>
                                                    {{-- Dynamic Gradient Bar --}}
                                                    <div class="absolute top-10 left-0 w-full h-2 rounded-full shadow-inner"
                                                        :class="(call.call_type && call.call_type
                                                            .toUpperCase() === 'SELL') ? 'range-gradient-sell' :
                                                        'range-gradient-buy'">
                                                    </div>
                                                    <div class="absolute top-11 -translate-y-1/2 -translate-x-1/2 z-10 transition-all duration-700 ease-out"
                                                        :style="`left: ${cmpPosition}%`">
                                                        <div
                                                            class="w-5 h-5 bg-white border-[3px] border-[#58ae72] rounded-full shadow-[0_4px_10px_rgba(0,0,0,0.2)] flex items-center justify-center">
                                                            <div class="w-1.5 h-1.5 bg-[#58ae72] rounded-full"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="bg-gray-50/50 backdrop-blur-sm rounded-xl p-1 flex justify-between items-center mb-3 border border-white/60">
                                                <div class="text-gray-500 text-xs font-medium"
                                                    x-text="parseFloat(call.stop_loss).toFixed(2)"></div>
                                                <div class="w-px h-4 bg-gray-300"></div>
                                                <div class="text-gray-800 text-sm font-black" x-text="cmp"></div>
                                                <div class="w-px h-4 bg-gray-300"></div>
                                                <div class="text-xs font-bold"
                                                    :class="isProfit ? 'text-green-600' : 'text-red-500'">
                                                    <span x-text="changePercent"></span>%
                                                </div>
                                            </div>
                                            <button
                                                class="glass-button w-full py-1.5 rounded-full font-black text-base text-gray-800 transition-all mb-5 flex items-center justify-center gap-2">
                                                <span x-text="call.call_type ? call.call_type : 'VIEW DETAILS'"></span>
                                                <i class="fa-solid fa-chevron-right text-xs"></i>
                                            </button>
                                        </div>
                                    </template>

                                    {{-- 2. IF USER DOES NOT HAVE ACCESS --}}
                                    <template x-if="!checkAccess(call)">
                                        <div
                                            class="potential-up bg-gray-50/50 flex flex-col items-center justify-center py-6 gap-3">

                                            <div class="text-center">
                                                <h3 class="text-[#8e44ad] font-black text-sm uppercase tracking-tight">
                                                    Premium Trade</h3>
                                                <p class="text-gray-500 text-[10px] font-bold">Upgrade to view potential
                                                </p>
                                            </div>
                                            <a href="{{ url('/settings') }}"
                                                class="bg-[#8e44ad] text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-wider shadow-lg hover:bg-[#732d91] transition-all">
                                                Unlock Now
                                            </a>
                                        </div>
                                    </template>

                                </div>
                            </div>
                        </template>
                    </template>
                    {{-- Empty State --}}
                    <div x-show="countTipsInTab(callTab) === 0"
                        class="col-span-full py-20 text-center glass-panel rounded-[30px]">
                        <div
                            class="w-16 h-16 bg-white/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-white">
                            <i class="fa-regular fa-folder-open text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm font-bold">No active calls in <span class="text-[#0939a4]"
                                x-text="callTab"></span></p>
                    </div>
                </div>
            </section>
        </div>
    </div>
    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('alpine:init', () => {

            // Alpine.data('marketDashboard', (config) => ({
            //     callTab: config.firstCategory,
            //     highlights: config.highlights,
            //     marketCalls: config.marketCalls,
            //     categories: config.categories,
            //     userPlanId: config.userPlanId,
            //     isDemo: config.isDemo,

            //     // checkAccess(tip) {
            //     //     if (!this.userPlanId) return false;
            //     //     if (!tip.plan_access) return false;
            //     //     return tip.plan_access.some(access => access.service_plan_id === this.userPlanId);
            //     // },
            //     checkAccess(tip) {

            //         // 🧪 Demo user → full access
            //         if (this.isDemo) return true;

            //         // 💳 Paid user → plan based
            //         if (!this.userPlanId) return false;
            //         if (!tip.plan_access) return false;

            //         return tip.plan_access.some(
            //             access => access.service_plan_id === this.userPlanId
            //         );
            //     },

            //     countTipsInTab(tabName) {
            //         return this.marketCalls.filter(call => call.category && call.category.name ===
            //             tabName).length;
            //     },

            //     formatDate(dateStr) {
            //         const d = new Date(dateStr);
            //         const day = d.getDate().toString().padStart(2, '0');
            //         const month = d.toLocaleString('en-US', {
            //             month: 'short'
            //         }).toUpperCase();
            //         const time = d.toLocaleTimeString('en-US', {
            //             hour: 'numeric',
            //             minute: '2-digit'
            //         });
            //         return `${day} ${month} • ${time}`;
            //     }
            // }));

            Alpine.data('marketDashboard', (config) => ({
                callTab: config.firstCategory,
                highlights: config.highlights,
                marketCalls: config.marketCalls,
                categories: config.categories,

                userPlanId: config.userPlanId,
                isDemo: config.isDemo, // ⭐ ADD THIS LINE ⭐

                checkAccess(tip) {

                    if (this.isDemo) return true; // Demo = full access

                    if (!this.userPlanId) return false;
                    if (!tip.plan_access) return false;

                    return tip.plan_access.some(
                        access => access.service_plan_id === this.userPlanId
                    );
                },

                countTipsInTab(tabName) {
                    return this.marketCalls.filter(call =>
                        call.category && call.category.name === tabName
                    ).length;
                },

                formatDate(dateStr) {
                    const d = new Date(dateStr);
                    const day = d.getDate().toString().padStart(2, '0');
                    const month = d.toLocaleString('en-US', {
                        month: 'short'
                    }).toUpperCase();
                    const time = d.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit'
                    });
                    return `${day} ${month} • ${time}`;
                }
            }));

            Alpine.data('stockCard', (item) => ({
                item: item,
                cmp: null,
                timer: null,
                flashColor: '',

                init() {
                    this.cmp = parseFloat(item.cmp_price) ? parseFloat(item.cmp_price) : parseFloat(item
                        .entry_price);

                    this.startLiveFeed();
                },

                startLiveFeed() {
                    if (this.timer) clearInterval(this.timer);
                    this.timer = setInterval(() => {
                        this.fetchLivePrice();
                    }, 3000);
                },

                async fetchLivePrice() {
                    if (!this.item.symbol_token) return;

                    try {
                        const params = new URLSearchParams({
                            symbol: this.item.symbol_token,
                            exchange: this.item.exchange
                        });

                        const response = await fetch(`/api/angel/quote?${params.toString()}`);
                        if (!response.ok) return;

                        const result = await response.json();

                        if (result.status && result.data && result.data.fetched && result.data
                            .fetched.length > 0) {
                            const newPrice = parseFloat(result.data.fetched[0].ltp);

                            if (newPrice !== this.cmp) {
                                this.flashColor = newPrice > this.cmp ? 'text-green-600' :
                                    'text-red-600';

                                this.cmp = newPrice;

                                // Reset color after 500ms
                                setTimeout(() => {
                                    this.flashColor = '';
                                }, 500);
                            }
                        }
                    } catch (e) {
                        console.error('Fetch error:', e);
                    }
                },

                get upsidePercent() {
                    const entry = parseFloat(this.item.entry_price);
                    const target = parseFloat(this.item.target_price);
                    if (!entry || !target) return 0;
                    return (((target - entry) / entry) * 100).toFixed(1);
                },

                get isProfit() {
                    const entry = parseFloat(this.item.entry_price);
                    return this.cmp >= entry;
                },

                get changePercent() {
                    const entry = parseFloat(this.item.entry_price);
                    if (!this.cmp || !entry) return "0.00";
                    return (((this.cmp - entry) / entry) * 100).toFixed(2);
                },

                get totalRange() {
                    return parseFloat(this.item.target_price) - parseFloat(this.item.stop_loss);
                },

                get cmpPosition() {
                    const sl = parseFloat(this.item.stop_loss);

                    if (!this.cmp) return 50;

                    const range = this.totalRange;
                    if (range === 0) return 50;

                    let pos = ((this.cmp - sl) / range) * 100;
                    return Math.min(Math.max(pos, 0), 100);
                }
            }));
        });
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .dashboard-mesh {
            background-color: #f3f4f6;
            background-image:
                radial-gradient(at 0% 0%, hsla(253, 16%, 90%, 1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225, 39%, 90%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(339, 49%, 90%, 1) 0, transparent 50%),
                radial-gradient(at 0% 100%, hsla(225, 39%, 90%, 1) 0, transparent 50%);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .glass-panel-highlight {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        .glass-button {
            background: linear-gradient(90deg, #ffc1076e 0%, #0096889c 30%, #4CAF50 100%);
            border: 1px solid rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transition: all 0.2s ease;
            color: #fff;
        }

        .glass-button:hover {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .range-gradient-buy {
            background: linear-gradient(90deg,
                    #ef4444 0%,
                    #fbbf24 40%,
                    #22c55e 100%);
        }

        .range-gradient-sell {
            background: linear-gradient(90deg,
                    #22c55e 0%,
                    #fbbf24 40%,
                    #ef4444 100%);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .stockCard {
            border: 2.5px solid #fff;
            border-radius: 27px;
            padding: 23px 0 0;
        }

        .livelable {
            position: absolute;
            right: 0;
            top: -8px;
            background: #fff;
            padding: 4px;
            border-radius: 10px;
        }

        .potential-up {
            border: 2px solid #fff;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
@endsection
