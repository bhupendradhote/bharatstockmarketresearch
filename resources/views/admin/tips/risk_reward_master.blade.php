@extends('layouts.app')

@section('content')
    <div x-data="{ modalOpen: false }" class="max-w-6xl mx-auto p-8 space-y-10 antialiased">

        <div class="flex items-center justify-between border-b border-gray-100 pb-8">
            <div class="flex flex-col gap-4">
                <a href="javascript:history.back()"
                    class="group flex items-center gap-2 text-slate-400 hover:text-blue-600 transition-colors w-fit">
                    <div class="p-2 rounded-full bg-slate-100 group-hover:bg-blue-50 transition-colors">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest">Back</span>
                </a>

                <div>
                    <h1 class="text-4xl font-black tracking-tight text-slate-900 leading-tight">
                        Risk Reward <span class="text-blue-600">Master</span>
                    </h1>
                    <p class="text-slate-500 text-[10px] font-medium mt-1 uppercase tracking-wider">
                        Configure global trading calculation parameters
                    </p>
                </div>
            </div>

            <button @click="modalOpen = true"
                class="group flex items-center gap-3 bg-blue-800 text-white pl-4 pr-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-600 shadow-xl shadow-slate-200 transition-all active:scale-95">
                <div class="bg-white/10 p-1 rounded-lg group-hover:bg-white/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                Create New Master
            </button>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div
                class="relative overflow-hidden bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3 animate-bounce-short shadow-sm">
                <div class="absolute left-0 top-0 h-full w-1.5 bg-emerald-500"></div>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        {{-- MASTER LIST SECTION --}}
        <div class="bg-white border border-slate-200 rounded-[2rem] shadow-2xl shadow-slate-200/60 overflow-hidden">
            <div class="px-10 py-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <div>
                    <h2 class="text-xl font-black text-slate-800 tracking-tight">Active Logs</h2>
                    <p class="text-xs text-slate-400 font-bold uppercase mt-1">Global Configuration History</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 bg-blue-500 rounded-full animate-ping"></span>
                    <span
                        class="text-[11px] font-black bg-white px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 shadow-sm uppercase tracking-tighter">
                        Records: {{ $masters->count() }}
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto px-4 pb-4">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-6 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Strategy Type</th>
                            <th
                                class="px-6 py-6 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Primary T1</th>
                            <th
                                class="px-6 py-6 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Secondary T2</th>
                            <th
                                class="px-6 py-6 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Protection (SL)</th>
                            <th
                                class="px-6 py-6 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Current Status</th>
                            <th
                                class="px-6 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Management</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($masters as $master)
                            <tr class="hover:bg-slate-50/80 transition-all group">
                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl {{ $master->calculation_type == 'percentage' ? 'bg-indigo-50 text-indigo-600' : 'bg-orange-50 text-orange-600' }} flex items-center justify-center font-black text-xs border border-current/10">
                                            {{ $master->calculation_type == 'percentage' ? '%' : '₹' }}
                                        </div>
                                        <span
                                            class="font-black text-slate-700 uppercase text-[11px] tracking-widest">{{ $master->calculation_type }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span
                                        class="font-black text-slate-900 text-sm italic">{{ $master->target1_value }}{{ $master->calculation_type == 'percentage' ? '%' : '' }}</span>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    @if ($master->target2_value)
                                        <span
                                            class="font-bold text-slate-500 text-sm">{{ $master->target2_value }}{{ $master->calculation_type == 'percentage' ? '%' : '' }}</span>
                                    @else
                                        <span class="text-slate-300 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span
                                        class="inline-block px-3 py-1 bg-red-50 text-red-600 rounded-lg font-black text-sm">
                                        {{ $master->stoploss_value }}{{ $master->calculation_type == 'percentage' ? '%' : '' }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    @if ($master->is_active)
                                        <span
                                            class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-500 text-white rounded-full text-[9px] font-black tracking-widest shadow-lg shadow-emerald-200">
                                            <span class="h-[4px] w-[4px] bg-red-800 rounded-full animate-ping"></span>
                                            LIVE
                                        </span>
                                    @else
                                        <span
                                            class="px-4 py-1.5 bg-slate-100 text-slate-400 rounded-full text-[9px] font-black tracking-widest border border-slate-200">
                                            INACTIVE
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-6 text-right">
                                    @if (!$master->is_active)
                                        <form method="POST"
                                            action="{{ route('admin.risk-reward.activate', $master->id) }}">
                                            @csrf
                                            <button
                                                class="bg-white border-2 border-blue-900 text-blue-900 px-5 py-2 rounded-xl font-black text-[10px] uppercase tracking-tighter hover:bg-blue-900 hover:text-white transition-all active:scale-90">
                                                Active
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex justify-end">
                                            <div
                                                class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <template x-teleport="body">
            <div x-show="modalOpen" class="fixed inset-0 z-[99] flex items-center justify-center overflow-hidden" x-cloak>

                <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" @click="modalOpen = false"
                    class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

                <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90 translate-y-8"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-90 translate-y-8"
                    class="relative w-full max-w-2xl bg-white border border-slate-200 rounded-[2.5rem] shadow-2xl p-10 overflow-hidden mx-4">

                    <div
                        class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-blue-100 rounded-full blur-3xl opacity-50">
                    </div>

                    <div class="flex items-center justify-between mb-10 relative">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Create Master</h2>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">New Configuration
                                    Node</p>
                            </div>
                        </div>
                        <button @click="modalOpen = false" class="text-slate-300 hover:text-red-500 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('admin.risk-reward.store') }}" class="space-y-8 relative">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label
                                    class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Calculation
                                    Method</label>
                                <div class="relative">
                                    <select name="calculation_type" required
                                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 appearance-none focus:border-blue-500 focus:bg-white transition-all outline-none">
                                        <option value="percentage">Percentage Based (%)</option>
                                        <option value="price">Fixed Currency (₹)</option>
                                    </select>
                                    <div
                                        class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label
                                    class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 text-emerald-500">Target
                                    One (Primary)</label>
                                <input type="number" step="0.01" name="target1_value" required
                                    placeholder="e.g. 5.00"
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black focus:border-emerald-500 focus:bg-white transition-all outline-none">
                            </div>

                            <div class="space-y-3">
                                <label
                                    class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 text-blue-500">Target
                                    Two (Secondary)</label>
                                <input type="number" step="0.01" name="target2_value" placeholder="Optional value"
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black focus:border-blue-500 focus:bg-white transition-all outline-none">
                            </div>

                            <div class="space-y-3">
                                <label
                                    class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 text-red-500">Stop
                                    Loss Limit</label>
                                <input type="number" step="0.01" name="stoploss_value" required
                                    placeholder="e.g. 2.50"
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black focus:border-red-500 focus:bg-white transition-all outline-none">
                            </div>
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="button" @click="modalOpen = false"
                                class="flex-1 bg-slate-100 text-slate-500 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-[2] bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 shadow-xl shadow-blue-200 transition-all active:scale-95">
                                Save Master
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes bounce-short {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }
        }

        .animate-bounce-short {
            animation: bounce-short 2s ease-in-out infinite;
        }
    </style>
@endsection
