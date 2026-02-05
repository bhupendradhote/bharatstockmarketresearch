@extends('layouts.app')

@section('content')
    <div class="space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <div class="grid gap-6 grid-cols-1 md:grid-cols-2 xl:grid-cols-4">
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-start justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Customers</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ number_format($stats['total_users']) }}</p>
                    <div class="flex items-center mt-2 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full w-fit">
                        <span>↑ Active</span>
                    </div>
                </div>
                <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-start justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Revenue</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">₹{{ number_format($stats['total_revenue'] / 100000, 2) }}L</p>
                    <p class="text-xs text-slate-400 mt-2">Lifetime Collection</p>
                </div>
                <div class="p-3 bg-emerald-50 rounded-lg text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-start justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-sm font-medium text-slate-500">Paid Subscribers</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['active_subs'] }}</p>
                    <p class="text-xs text-slate-400 mt-2">Recurring Revenue</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-lg text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-start justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-sm font-medium text-slate-500">Active Demos</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['active_demos'] }}</p>
                    <p class="text-xs text-cyan-600 mt-2 font-medium">Trial Users</p>
                </div>
                <div class="p-3 bg-cyan-50 rounded-lg text-cyan-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid gap-8 grid-cols-1 lg:grid-cols-3">
            
            <section class="lg:col-span-2 space-y-8">

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-base font-semibold text-slate-800">New Registered Users</h2>
                        <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-3">User Details</th>
                                    <th class="px-6 py-3">Phone</th>
                                    <th class="px-6 py-3 text-right">Registered</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($users as $user)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-900">{{ $user->name }}</div>
                                                <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-slate-600 font-mono text-xs">{{ $user->phone ?? '-' }}</td>
                                    <td class="px-6 py-3 text-right text-slate-500 text-xs">{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="px-6 py-4 text-center text-slate-400 text-sm">No new users found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-slate-50 px-6 py-3 border-t border-slate-100">
                        {{ $users->appends(request()->query())->links('pagination.dots') }}
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-base font-semibold text-slate-800">Recent Market Tips</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-3">Stock Symbol</th>
                                    <th class="px-6 py-3">Details</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Entry Price</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($tips as $tip)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-3 font-bold text-slate-700">{{ $tip->stock_name }}</td>
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium ring-1 ring-inset
                                                {{ $tip->call_type === 'Buy' ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20' : 'bg-red-50 text-red-700 ring-red-600/20' }}">
                                                {{ $tip->call_type }}
                                            </span>
                                            <span class="text-xs text-slate-500 border border-slate-200 px-1.5 py-0.5 rounded">{{ $tip->tip_type }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                            {{ $tip->trade_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right font-mono font-medium text-slate-800">₹{{ $tip->entry_price }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-slate-400 text-sm">No recent tips.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-slate-50 px-6 py-3 border-t border-slate-100">
                        {{ $tips->appends(request()->query())->links('pagination.dots') }}
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-base font-semibold text-slate-800">Offer Banners</h2>
                        <a href="{{ route('admin.offer-banners.index') }}" class="text-xs font-medium text-orange-600 hover:text-orange-800">Manage All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-3">Banner Info</th>
                                    <th class="px-6 py-3">Position</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Visibility</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($banners as $banner)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-3">
                                            @if($banner->getFirstMediaUrl('offer_banner_desktop'))
                                            <img src="{{ $banner->getFirstMediaUrl('offer_banner_desktop') }}" class="w-10 h-6 object-cover rounded border border-slate-200">
                                            @else
                                            <div class="w-10 h-6 bg-slate-100 rounded border border-slate-200 flex items-center justify-center text-[10px] text-slate-400">N/A</div>
                                            @endif
                                            <div>
                                                <div class="font-medium text-slate-900 line-clamp-1">{{ $banner->heading }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-slate-600 text-xs">{{ $banner->position }}</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-semibold tracking-wide
                                            {{ $banner->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $banner->is_active ? 'ACTIVE' : 'INACTIVE' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-xs text-slate-500">
                                        {{ ucfirst($banner->device_visibility) }}
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-slate-400 text-sm">No banners found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-slate-50 px-6 py-3 border-t border-slate-100">
                        {{ $banners->appends(request()->query())->links('pagination.dots') }}
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-base font-semibold text-slate-800">Service Plans</h2>
                        <a href="/admin/service-plans" class="text-xs font-medium text-blue-600 hover:text-blue-800">Manage All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-3">Plan Name</th>
                                    <th class="px-6 py-3">Tagline</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Durations</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($servicePlans as $plan)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-3 font-medium text-slate-800">
                                        {{ $plan->name }}
                                        @if($plan->featured)
                                            <span class="ml-2 text-[10px] bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded">Featured</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-slate-500 text-xs">{{ $plan->tagline }}</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-semibold tracking-wide
                                            {{ $plan->status ? 'bg-emerald-100 text-emerald-700' : 'bg-red-50 text-red-600' }}">
                                            {{ $plan->status ? 'ACTIVE' : 'INACTIVE' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-xs text-slate-500">
                                        {{ $plan->durations->count() }} Variants
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-slate-400 text-sm">No service plans found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-slate-50 px-6 py-3 border-t border-slate-100">
                        {{ $servicePlans->appends(request()->query())->links('pagination.dots') }}
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-base font-semibold text-slate-800">Recent Support Tickets</h2>
                        <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">{{ $stats['pending_tickets'] }} Pending</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-3">Ticket ID</th>
                                    <th class="px-6 py-3">Subject</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($tickets as $ticket)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-3 text-slate-600 text-xs font-mono">#{{ $ticket->id }}</td>
                                    <td class="px-6 py-3 font-medium text-slate-800">{{ Str::limit($ticket->subject ?? 'No Subject', 30) }}</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-semibold tracking-wide
                                            {{ $ticket->status == 'Open' ? 'bg-red-100 text-red-600' : ($ticket->status == 'Resolved' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700') }}">
                                            {{ $ticket->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-xs text-slate-500">
                                        {{ $ticket->created_at->format('M d') }}
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-slate-400 text-sm">No tickets found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-slate-50 px-6 py-3 border-t border-slate-100">
                        {{ $tickets->appends(request()->query())->links('pagination.dots') }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">
                        <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 flex justify-between">
                            <h2 class="text-sm font-semibold text-slate-800">Paid Subscriptions</h2>
                        </div>
                        <div class="overflow-y-auto flex-1">
                            <table class="min-w-full text-xs">
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($subscriptions as $sub)
                                    <tr>
                                        <td class="px-5 py-3">
                                            <div class="font-medium text-slate-700">{{ $sub->user->name ?? 'Unknown' }}</div>
                                            <div class="text-slate-400 mt-0.5">₹{{ $sub->amount }}</div>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <span class="px-2 py-1 rounded-full text-[10px] font-semibold tracking-wide bg-emerald-100 text-emerald-700">
                                                PAID
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="2" class="px-5 py-4 text-center text-slate-400">No subscriptions yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 border-t border-slate-100 text-xs bg-slate-50">
                             {{ $subscriptions->appends(request()->query())->links('pagination.dots') }}
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">
                        <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 flex justify-between">
                            <h2 class="text-sm font-semibold text-slate-800">Recent Demos</h2>
                        </div>
                        <div class="overflow-y-auto flex-1">
                            <table class="min-w-full text-xs">
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($demoSubscriptions as $demo)
                                    <tr>
                                        <td class="px-5 py-3">
                                            <div class="font-medium text-slate-700">{{ $demo->user->name ?? 'Unknown' }}</div>
                                            <div class="text-slate-400 mt-0.5">
                                                Exp: {{ \Carbon\Carbon::parse($demo->end_date)->format('M d') }}
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <span class="px-2 py-1 rounded-full text-[10px] font-semibold tracking-wide bg-cyan-100 text-cyan-700">
                                                DEMO
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="2" class="px-5 py-4 text-center text-slate-400">No active demos.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 border-t border-slate-100 text-xs bg-slate-50">
                             {{ $demoSubscriptions->appends(request()->query())->links('pagination.dots') }}
                        </div>
                    </div>

                </div>

            </section>

            <aside class="space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                    <h2 class="text-sm font-bold text-slate-800 mb-4 tracking-wide uppercase text-[11px] text-slate-400">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('admin.tips.create') }}" 
                           class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:border-indigo-500 hover:text-indigo-600 hover:shadow-sm transition-all duration-200">
                            <span class="flex items-center gap-3">
                                <span class="p-1 bg-indigo-50 text-indigo-600 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </span>
                                Create New Tip
                            </span>
                            <span class="text-slate-300 group-hover:text-indigo-600">→</span>
                        </a>

                        <a href="{{ route('admin.offer-banners.create') }}" 
                           class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:border-orange-500 hover:text-orange-600 hover:shadow-sm transition-all duration-200">
                            <span class="flex items-center gap-3">
                                <span class="p-1 bg-orange-50 text-orange-600 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </span>
                                Add Banner
                            </span>
                            <span class="text-slate-300 group-hover:text-orange-600">→</span>
                        </a>

                        <a href="{{ url('admin/demo-subscriptions') }}" 
                           class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:border-cyan-500 hover:text-cyan-600 hover:shadow-sm transition-all duration-200">
                            <span class="flex items-center gap-3">
                                <span class="p-1 bg-cyan-50 text-cyan-600 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </span>
                                Grant Demo Access
                            </span>
                            <span class="text-slate-300 group-hover:text-cyan-600">→</span>
                        </a>
                        <a href="/admin/message-campaigns">
                        <button class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:border-blue-500 hover:text-blue-600 hover:shadow-sm transition-all duration-200">
                             <span class="flex items-center gap-3">
                                <span class="p-1 bg-blue-50 text-blue-600 rounded">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                </span>
                                Send Campaign
                            </span>
                            <span class="text-slate-300 group-hover:text-blue-600">→</span>
                        </button>
                        </a>
                    </div>
                </div>

                <div class="bg-indigo-900 rounded-xl shadow-lg p-5 text-white relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-700 rounded-full opacity-50 blur-xl"></div>
                    
                    <h2 class="text-sm font-bold tracking-wide uppercase text-indigo-200 mb-4 relative z-10">Today's Snapshot</h2>
                    <ul class="space-y-3 relative z-10 text-sm">
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-red-400"></span>
                            <span class="text-indigo-100"><strong class="text-white">{{ $stats['pending_tickets'] }}</strong> pending tickets</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span class="text-indigo-100"><strong class="text-white">{{ $stats['active_tips'] }}</strong> tips currently active</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                            <span class="text-indigo-100"><strong class="text-white">{{ $stats['active_demos'] }}</strong> active demos</span>
                        </li>
                    </ul>
                </div>
            </aside>

        </div>
    </div>
@endsection