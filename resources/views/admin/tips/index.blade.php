@extends('layouts.app')

@section('content')
    {{-- Include Alpine.js for modal logic --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="p-4 md:p-6 space-y-6 text-sm text-gray-700" x-data="{
        showModal: false,
        showCategoryModal: false,
        activeTip: null,
        filterType: 'all',
        tipsList: {{ json_encode($tips->items()) }},
    
        // Filter Logic
        get filteredTips() {
            if (this.filterType === 'all') return this.tipsList;
            return this.tipsList.filter(tip => tip.tip_type.toLowerCase() === this.filterType.toLowerCase());
        },
    
        openRandomTip() {
            let list = this.filteredTips;
            if (list.length > 0) {
                let random = Math.floor(Math.random() * list.length);
                this.activeTip = list[random];
                this.showModal = true;
            }
        }
    }">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h1 class="text-lg font-bold text-gray-800 tracking-tight">Market Analytics Dashboard</h1>

            <div class="flex flex-wrap items-center gap-2">
                {{-- NEW: Category Creation Button --}}
                <button @click="showCategoryModal = true"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-xs font-black hover:bg-emerald-700 transition flex items-center gap-2 shadow-lg shadow-emerald-200">
                    <i class="fa-solid fa-plus"></i> CATEGORY
                </button>

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

        {{-- Success/Error Alerts --}}
        @if (session('success'))
            <div
                class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-xs font-bold animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter Tabs --}}
        <div class="bg-gray-100 p-1 rounded-xl inline-flex gap-1 border border-gray-200">
            <button @click="filterType = 'all'"
                :class="filterType === 'all' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2 rounded-lg text-[11px] font-black uppercase tracking-widest transition-all">
                All Tips
            </button>
            <button @click="filterType = 'equity'"
                :class="filterType === 'equity' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2 rounded-lg text-[11px] font-black uppercase tracking-widest transition-all">
                Equity
            </button>
            <button @click="filterType = 'future'"
                :class="filterType === 'future' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2 rounded-lg text-[11px] font-black uppercase tracking-widest transition-all">
                Future
            </button>
            <button @click="filterType = 'option'"
                :class="filterType === 'option' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2 rounded-lg text-[11px] font-black uppercase tracking-widest transition-all">
                Option
            </button>
        </div>

        {{-- Data Table --}}
        <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 text-gray-500 border-b border-gray-100">
                        <tr>
                            <th class="p-4 text-left font-bold uppercase tracking-wider">Stock / Exchange</th>
                            <th class="p-4 text-center font-bold uppercase tracking-wider">Call</th>
                            <th class="p-4 text-center font-bold uppercase tracking-wider">Category</th>
                            <th class="p-4 text-center font-bold uppercase tracking-wider">Entry</th>
                            <th class="p-4 text-center font-bold uppercase tracking-wider">Target</th>
                            <th class="p-4 text-center font-bold uppercase tracking-wider">Stop Loss</th>
                            <th class="p-4 text-center font-bold uppercase tracking-wider">Status</th>
                            <th class="p-4 text-right font-bold uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <template x-for="tip in filteredTips" :key="tip.id">
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="p-4">
                                    <div class="font-black text-gray-900" x-text="tip.stock_name"></div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase" x-text="tip.exchange"></div>
                                </td>
                                <td class="p-4 text-center">
                                    <span :class="tip.call_type === 'Buy' ? 'bg-green-600' : 'bg-red-600'"
                                        class="px-2 py-1 rounded text-white text-[10px] font-black uppercase"
                                        x-text="tip.call_type"></span>
                                </td>
                                <td class="p-4 text-center text-gray-500 font-medium" x-text="tip.category?.name || '-'">
                                </td>
                                <td class="p-4 text-center font-bold text-gray-700">₹<span x-text="tip.entry_price"></span>
                                </td>
                                <td class="p-4 text-center font-bold text-green-600">₹<span
                                        x-text="tip.target_price"></span></td>
                                <td class="p-4 text-center font-bold text-red-500">₹<span x-text="tip.stop_loss"></span>
                                </td>
                                <td class="p-4 text-center">
                                    <span
                                        :class="tip.status === 'Active' ? 'bg-blue-50 text-blue-700 border-blue-100' :
                                            'bg-gray-50 text-gray-500 border-gray-100'"
                                        class="px-2 py-1 rounded-md text-[10px] font-bold border"
                                        x-text="tip.status"></span>
                                </td>
                                <td class="p-4 text-right">
                                    <button @click="activeTip = tip; showModal = true;"
                                        class="text-blue-600 hover:underline text-xs font-black uppercase tracking-tight">Details</button>
                                    <span class="text-red-500 text-sm font-bold"> | </span>
                                    <a :href="`{{ url('admin/tips') }}/${tip.id}/edit`"
                                        class="text-blue-600 hover:underline text-xs font-black uppercase tracking-tight">
                                        Edit
                                    </a>
                                </td>
                                
                            </tr>
                        </template>
                        <template x-if="filteredTips.length === 0">
                            <tr>
                                <td colspan="8" class="p-12 text-center text-gray-400 italic font-medium">No tips found
                                    for this category.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <div class="mt-8 p-5 border-t-2">
                    {{ $tips->links() }}
                </div>
            </div>
        </div>

        {{-- Live Preview Cards --}}
        <div class="mt-12">
            <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center">
                <span class="w-12 h-[2px] bg-blue-600 mr-4"></span> Live Preview Cards
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <template x-for="tip in filteredTips" :key="'card-' + tip.id">
                    <div
                        class="bg-white rounded-[24px] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-5 group relative overflow-hidden">

                        <div class="flex justify-between items-start mb-5">
                            <div>
                                <h3 class="font-black text-gray-900 text-lg leading-none mb-1" x-text="tip.stock_name"></h3>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest"
                                    x-text="tip.exchange + ' • ' + (tip.category?.name || 'General')"></p>
                            </div>
                            <span
                                :class="tip.call_type === 'Buy' ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50'"
                                class="text-[11px] font-black px-3 py-1 rounded-full uppercase tracking-tighter"
                                x-text="tip.call_type"></span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-5">
                            <div class="bg-gray-50 p-3 rounded-2xl border border-gray-100">
                                <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Entry Price</p>
                                <p class="font-black text-base text-gray-900">₹<span x-text="tip.entry_price"></span></p>
                            </div>
                            <div class="bg-blue-50/50 p-3 rounded-2xl border border-blue-100/50">
                                <p class="text-[9px] font-black text-blue-500 uppercase mb-1">Target</p>
                                <p class="font-black text-base text-blue-700">₹<span x-text="tip.target_price"></span></p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between px-2 mb-6">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Risk (SL)</span>
                            <span class="text-xs font-black text-red-500 bg-red-50 px-2 py-0.5 rounded"
                                x-text="'₹' + tip.stop_loss"></span>
                        </div>

                        <button @click="activeTip = tip; showModal = true;"
                            class="w-full py-3 bg-gray-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.15em] hover:bg-blue-600 transition-all shadow-lg shadow-gray-200">
                            Analyze details
                        </button>
                    </div>
                </template>
            </div>
        </div>


        {{-- TIP DETAILS MODAL --}}
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
                        <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100">
                            <p class="text-[9px] font-black text-blue-400 uppercase mb-1">CMP</p>
                            <p class="text-lg font-black text-blue-700">₹<span
                                    x-text="activeTip?.cmp_price || activeTip?.entry_price"></span></p>
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

                    <template x-if="activeTip?.tip_type !== 'equity'">
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
                            <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Admin Note /
                                Technical Analysis</p>
                        </div>
                        <p class="text-sm font-medium text-amber-900 leading-relaxed italic"
                            x-text="activeTip?.admin_note || 'No additional notes provided for this trade.'"></p>
                    </div>

                    <div class="flex gap-3">
                        <button @click="showModal = false"
                            class="flex-1 py-4 bg-gray-100 text-gray-900 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition-all">Close</button>
                        <button
                            class="flex-1 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">Copy
                            Trade</button>
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
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Category
                            Name</label>
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

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        /* Modal Animation */
        .animate-fade-in {
            animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>
@endsection
