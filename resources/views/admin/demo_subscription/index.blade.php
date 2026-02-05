@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-sm" x-data="{ openModal: false, selectedUser: null }">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-semibold text-slate-800 tracking-tight">Subscription Management</h1>
                <p class="text-xs text-slate-500">Manage user access and demo status</p>
            </div>
        </div>

        @if (session('success') || session('error'))
            <div class="mb-4">
                @if (session('success'))
                    <div class="bg-emerald-50 border border-emerald-100 p-3 rounded text-emerald-700 text-xs">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-rose-50 border border-rose-100 p-3 rounded text-rose-700 text-xs">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        <div class="bg-white p-4 rounded-lg border border-slate-200 mb-6">
            <form method="GET" action="{{ route('admin.demo.index') }}" class="flex flex-wrap items-center gap-3">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, Email, Phone..."
                        class="w-full border-indigo-400 rounded text-xs focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 p-1.5 outline-none">
                </div>

                <select name="status" class="border-slate-200 rounded text-xs focus:ring-1 focus:ring-indigo-500 py-1.5">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="UnSubscribed" {{ request('status') == 'never' ? 'selected' : '' }}>Never Subscribed
                    </option>
                </select>

                <select name="type" class="border-slate-200 rounded text-xs focus:ring-1 focus:ring-indigo-500 py-1.5">
                    <option value="">All Types</option>
                    <option value="demo" {{ request('type') == 'demo' ? 'selected' : '' }}>Demo</option>
                    <option value="paid" {{ request('type') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>

                <button type="submit"
                    class="bg-indigo-50 text-indigo-700 px-4 py-1.5 rounded border border-indigo-100 hover:bg-indigo-100 transition font-medium text-xs">
                    Apply Filters
                </button>
                <a href="{{ route('admin.demo.index') }}" class="text-slate-400 hover:text-slate-600 text-xs px-2">Clear</a>
            </form>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-5 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">User
                            Details</th>
                        <th class="px-5 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Subscription Status</th>
                        <th class="px-5 py-3 text-right text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($users as $user)
                        @php $lastSub = $user->subscriptions->first(); @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="font-medium text-slate-700">{{ $user->name }}</div>
                                <div class="text-[11px] text-slate-400 flex flex-col mt-0.5">
                                    <span>{{ $user->email }}</span>
                                    <span>{{ $user->phone ?? 'No phone number' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                @if (!$lastSub)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200">New
                                        Account</span>
                                @elseif($lastSub->isActive())
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="w-fit px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Active</span>
                                        <span
                                            class="text-[9px] text-slate-400 uppercase font-semibold tracking-tighter">{{ $lastSub->payment_status }}
                                            Access</span>
                                    </div>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100">Expired</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right whitespace-nowrap">
                                @if (!$lastSub || !$lastSub->isActive())
                                    <button
                                        @click="openModal = true; selectedUser = { id: {{ $user->id }}, name: '{{ $user->name }}' }"
                                        class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50 transition">
                                        Grant Demo
                                    </button>
                                @else
                                    <span class="text-[11px] text-slate-300 font-medium italic">Already Access</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links('pagination.dots') }}
        </div>

        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
            <div class="fixed inset-0 bg-slate-900/20 backdrop-blur-[1px]" @click="openModal = false"></div>

            <div class="bg-white rounded-lg shadow-xl border border-slate-200 w-full max-w-sm overflow-hidden relative z-10"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95">

                <form method="POST" action="{{ route('admin.demo.grant') }}" class="p-5">
                    @csrf
                    <input type="hidden" name="user_id" :value="selectedUser?.id">

                    <h3 class="text-sm font-bold text-slate-800 mb-1">Grant Demo Access</h3>
                    <p class="text-xs text-slate-500 mb-5">Assigning access to <span class="text-indigo-600 font-semibold"
                            x-text="selectedUser?.name"></span></p>

                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Duration (Days)</label>
                        <input type="number" name="days" min="1" max="30" value="3" required
                            class="w-full border border-indigo-400 p-1.5 rounded text-xs outline-none focus:ring-1 focus:ring-indigo-500 py-2 shadow-sm">
                        <p class="mt-1.5 text-[10px] text-slate-400 italic">Access will automatically expire after selected
                            days.</p>
                    </div>

                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-50 mt-4">
                        <button type="button" @click="openModal = false"
                            class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700">Cancel</button>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-1.5 text-xs font-semibold rounded hover:bg-indigo-700 transition">
                            Confirm Access
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
    </style>
@endsection
