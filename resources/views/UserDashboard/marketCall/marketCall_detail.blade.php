@extends('layouts.userdashboard')

@section('content')
    <div class=" bg-[#f8fafc] " x-data="{ timeframe: '1D' }">

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <a href="/market-calls"
                    class="p-1.5 bg-white rounded-lg border border-gray-100 shadow-sm hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-gray-900 tracking-tight">TATA Motors</h1>
            </div>
            <span
                class="bg-blue-50 text-blue-600 text-[9px] font-bold px-2 py-0.5 rounded-md uppercase tracking-widest">Intraday</span>
        </div>

        <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-5 md:p-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-8">
                    <div class="flex items-center gap-2.5 mb-6">
                        <div
                            class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center overflow-hidden border border-gray-100">
                            <img src="https://logo.clearbit.com/tatamotors.com" alt="TATA"
                                class="w-6 h-6 object-contain">
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">TATA Motors</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">25,056.90 <span
                                    class="text-green-500 ml-1">INR +1.45%</span></p>
                        </div>
                    </div>

                    <div class="relative h-[240px] w-full mb-6 border border-gray-50 rounded-xl p-3">
                        <div
                            class="absolute top-6 left-1/2 -translate-x-1/2 bg-white border border-gray-100 shadow-md rounded-md px-2 py-1 z-10 text-[9px] font-bold">
                            <p class="text-gray-400 leading-none mb-1">25 Sep 14:20</p>
                            <p class="text-gray-900 text-xs">322.30</p>
                        </div>

                        <svg class="w-full h-full" viewBox="0 0 1000 300" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="chartGradient" x1="0" y1="0" x2="0"
                                    y2="1">
                                    <stop offset="0%" stop-color="#10b981" stop-opacity="0.1" />
                                    <stop offset="100%" stop-color="#10b981" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <path d="M0,200 Q100,250 200,180 T400,220 T600,100 T800,80 T1000,50" fill="none"
                                stroke="#10b981" stroke-width="2" stroke-linecap="round" />
                            <path d="M0,200 Q100,250 200,180 T400,220 T600,100 T800,80 T1000,50 L1000,300 L0,300 Z"
                                fill="url(#chartGradient)" />
                        </svg>

                        <div
                            class="flex justify-between mt-3 text-[9px] font-bold text-gray-300 px-1 uppercase tracking-tighter">
                            <span>9:30 AM</span><span>11:00 AM</span><span>12:30 PM</span><span>02:00 PM</span><span>03:30
                                PM</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-center mb-8">
                        <div class="bg-gray-50/50 py-2 rounded-xl">
                            <p class="text-gray-400 text-[9px] font-bold uppercase tracking-wider mb-0.5">Today's low</p>
                            <p class="text-gray-900 font-bold text-xs">₹ 25,003.90</p>
                        </div>
                        <div class="bg-gray-50/50 py-2 rounded-xl">
                            <p class="text-gray-400 text-[9px] font-bold uppercase tracking-wider mb-0.5">Today's high</p>
                            <p class="text-gray-900 font-bold text-xs">₹ 25,092.90</p>
                        </div>
                        <div class="bg-gray-50/50 py-2 rounded-xl">
                            <p class="text-gray-400 text-[9px] font-bold uppercase tracking-wider mb-0.5">Return</p>
                            <p class="text-red-500 font-bold text-xs">-0.04%</p>
                        </div>
                    </div>

                    <div class="flex justify-center gap-1.5">
                        <template x-for="t in ['1D', '1W', '1M', '6M', '1Y', 'MAX']">
                            <button @click="timeframe = t"
                                :class="timeframe === t ? 'bg-slate-800 text-white' :
                                    'bg-white text-gray-400 border-gray-100 hover:bg-gray-50'"
                                class="px-3 py-1.5 rounded-lg text-[9px] font-bold border transition-all uppercase tracking-widest"
                                x-text="t"></button>
                        </template>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-5">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                            <span class="text-gray-400 font-bold text-[10px] uppercase tracking-wider">Entry Price</span>
                            <span class="text-green-500 font-bold text-sm">₹642.50</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                            <span class="text-gray-400 font-bold text-[10px] uppercase tracking-wider">Target 1</span>
                            <span class="text-gray-900 font-bold text-sm">₹648.00</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                            <span class="text-gray-400 font-bold text-[10px] uppercase tracking-wider">Target 2</span>
                            <span class="text-gray-900 font-bold text-sm">₹652.00</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                            <span class="text-gray-400 font-bold text-[10px] uppercase tracking-wider">Stop-Loss</span>
                            <span class="text-red-500 font-bold text-sm">₹638.00</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <p class="text-[10px] font-bold text-gray-900 uppercase tracking-tight">Status: <span
                                class="text-green-500 ml-1">Active</span></p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">Updated: <span
                                class="text-gray-900 ml-1">11:45 AM</span></p>
                    </div>

                    <div class="bg-blue-50/50 rounded-xl p-3 border border-dashed border-blue-100">
                        <p class="text-[10px] font-bold text-blue-900 leading-relaxed uppercase tracking-tight">
                            <span class="text-blue-400 block text-[8px] tracking-[0.2em] mb-1">Analyst Note</span>
                            Trail Stop Loss to ₹640 after Target 1 is achieved.
                        </p>
                    </div>

                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-md text-[10px] uppercase tracking-[0.2em]">
                        Execute Trade
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
