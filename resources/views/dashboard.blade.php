@extends('layouts.app')



@section('content')
    <div class="space-y-6">
        <!-- KPI Cards -->
        <div class="grid gap-4 grid-cols-1 md:grid-cols-4">
            <div class="bg-white border border-slate-100 rounded-lg p-4">
                <p class="text-xs text-slate-500">Total Orders</p>
                <p class="text-2xl font-semibold text-slate-800 mt-1">1,248</p>
                <p class="text-[11px] text-emerald-600 mt-1">+12% vs last week</p>
            </div>
            <div class="bg-white border border-slate-100 rounded-lg p-4">
                <p class="text-xs text-slate-500">Revenue</p>
                <p class="text-2xl font-semibold text-slate-800 mt-1">₹8.4L</p>
                <p class="text-[11px] text-emerald-600 mt-1">+7% vs last month</p>
            </div>
            <div class="bg-white border border-slate-100 rounded-lg p-4">
                <p class="text-xs text-slate-500">Active Customers</p>
                <p class="text-2xl font-semibold text-slate-800 mt-1">312</p>
                <p class="text-[11px] text-slate-500 mt-1">Last 30 days</p>
            </div>
            <div class="bg-white border border-slate-100 rounded-lg p-4">
                <p class="text-xs text-slate-500">Pending Invoices</p>
                <p class="text-2xl font-semibold text-slate-800 mt-1">29</p>
                <p class="text-[11px] text-red-500 mt-1">Need attention</p>
            </div>
        </div>

        <!-- Two-column layout -->
        <div class="grid gap-6 grid-cols-1 lg:grid-cols-3">
            <section class="lg:col-span-2 bg-white border border-slate-100 rounded-lg p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-slate-800">Recent Orders</h2>
                    <button class="text-xs text-emerald-600 hover:text-emerald-700">View all</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead class="bg-slate-50 text-slate-500">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium">Order #</th>
                                <th class="px-3 py-2 text-left font-medium">Customer</th>
                                <th class="px-3 py-2 text-left font-medium">Amount</th>
                                <th class="px-3 py-2 text-left font-medium">Status</th>
                                <th class="px-3 py-2 text-right font-medium">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="px-3 py-2 text-slate-700">INV-2025-0012</td>
                                <td class="px-3 py-2 text-slate-600">Sharma Jewellers</td>
                                <td class="px-3 py-2 text-slate-800 font-semibold">₹42,500</td>
                                <td class="px-3 py-2">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] bg-emerald-50 text-emerald-700">
                                        Paid
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-right text-slate-500">05 Dec 2025</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-slate-700">INV-2025-0011</td>
                                <td class="px-3 py-2 text-slate-600">Gupta & Sons</td>
                                <td class="px-3 py-2 text-slate-800 font-semibold">₹18,900</td>
                                <td class="px-3 py-2">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] bg-amber-50 text-amber-700">
                                        Pending
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-right text-slate-500">04 Dec 2025</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-slate-700">INV-2025-0010</td>
                                <td class="px-3 py-2 text-slate-600">Kohinoor Jewels</td>
                                <td class="px-3 py-2 text-slate-800 font-semibold">₹65,200</td>
                                <td class="px-3 py-2">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] bg-red-50 text-red-700">
                                        Overdue
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-right text-slate-500">02 Dec 2025</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="bg-white border border-slate-100 rounded-lg p-4 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-slate-800">Quick Actions</h2>
                </div>
                <div class="space-y-2">
                    <button
                        class="w-full flex items-center justify-between px-3 py-2 text-xs border border-slate-200 rounded-md hover:bg-slate-50">
                        <span>Create new invoice</span>
                        <span>➕</span>
                    </button>
                    <button
                        class="w-full flex items-center justify-between px-3 py-2 text-xs border border-slate-200 rounded-md hover:bg-slate-50">
                        <span>Add new product</span>
                        <span>💎</span>
                    </button>
                    <button
                        class="w-full flex items-center justify-between px-3 py-2 text-xs border border-slate-200 rounded-md hover:bg-slate-50">
                        <span>Download report</span>
                        <span>⬇️</span>
                    </button>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-800 mb-2">Today's summary</p>
                    <ul class="space-y-1 text-[11px] text-slate-600">
                        <li>• 32 invoices generated</li>
                        <li>• 4 payments pending</li>
                        <li>• 2 low-stock alerts</li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
@endsection
