@extends('layouts.userdashboard')

@section('content')
    <div class=" bg-[#f8fafc]">
        <div class="max-w-9xl mx-auto bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">

            <div class="p-6 md:p-8 border-b border-gray-50 bg-white">
                <div class="flex items-center gap-3 mb-1">
                    <a href="{{ url('/settings') }}" class="p-1.5 hover:bg-gray-100 rounded-full transition-colors">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Payment & Invoices</h1>
                </div>
                <p class="text-[10px] text-gray-400 font-medium ml-9 uppercase tracking-wider">
                    Manage subscriptions and download past invoices.
                </p>
            </div>

            <div class="p-6 md:p-10 space-y-10">

                <div class="space-y-5">
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Current Plan Summary</h2>

                    <div
                        class="flex flex-col md:flex-row md:items-start justify-between gap-6 bg-gray-50/50 p-6 rounded-[24px] border border-gray-100">
                        <div class="space-y-3 min-w-[240px]">
                            <h3 class="text-2xl font-black text-[#0939a4] tracking-tighter">Premium</h3>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-[10px] font-bold">
                                    <span class="text-gray-400 uppercase tracking-widest">Validity</span>
                                    <span class="text-gray-900">3 Months</span>
                                </div>
                                <div class="flex items-center justify-between text-[10px] font-bold">
                                    <span class="text-gray-400 uppercase tracking-widest">Validity Till</span>
                                    <span class="text-gray-900">12 Dec 2025</span>
                                </div>
                                <div class="flex items-center justify-between text-[10px] font-bold">
                                    <span class="text-gray-400 uppercase tracking-widest">Status</span>
                                    <span class="text-green-500">ACTIVE</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2.5">
                            <button
                                class="bg-[#0939a4] hover:bg-blue-700 text-white text-[9px] font-bold px-10 py-2.5 rounded-xl transition-all shadow-md uppercase tracking-widest">
                                Upgrade Plan
                            </button>
                            <button
                                class="bg-[#0939a4] hover:bg-blue-700 text-white text-[9px] font-bold px-10 py-2.5 rounded-xl transition-all shadow-md uppercase tracking-widest">
                                Renew Plan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <a href="#"
                        class="flex items-center justify-between group p-3 rounded-2xl border border-gray-50 hover:border-blue-100 hover:bg-blue-50/30 transition-all">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-lg group-hover:bg-blue-100 transition-colors">
                                <svg class="w-4 h-4 text-gray-600 group-hover:text-[#0939a4]" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-[11px] font-bold text-gray-700 uppercase tracking-tight">Payment History &
                                Invoices</span>
                        </div>
                        <svg class="w-3 h-3 text-gray-300 group-hover:text-[#0939a4] transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="#"
                        class="flex items-center justify-between group p-3 rounded-2xl border border-gray-50 hover:border-blue-100 hover:bg-blue-50/30 transition-all">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-lg group-hover:bg-blue-100 transition-colors">
                                <svg class="w-4 h-4 text-gray-600 group-hover:text-[#0939a4]" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span class="text-[11px] font-bold text-gray-700 uppercase tracking-tight">Legal
                                Disclaimer</span>
                        </div>
                        <svg class="w-3 h-3 text-gray-300 group-hover:text-[#0939a4] transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="pt-6 border-t border-gray-50">
                    <div class="flex items-start gap-3 bg-red-50/50 p-4 rounded-2xl border border-red-100">
                        <div class="p-1.5 bg-red-100 rounded-lg text-red-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-800 leading-tight uppercase tracking-tight">
                                Renewal Reminder
                            </p>
                            <p class="text-[10px] text-gray-500">
                                Your plan expires soon. Renew now to continue receiving Market Calls without interruption.
                            </p>
                            <button
                                class="text-[10px] font-black text-[#0939a4] hover:text-blue-800 transition-colors uppercase tracking-widest pt-1">
                                [ Renew Plan ]
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
    </style>
@endsection
