@extends('layouts.app')

@section('content')
    <div class="p-6 bg-slate-50 min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Testimonial Management</h1>
            <div class="flex gap-2">
                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase">Pending:
                    {{ $reviews->where('status', 0)->count() }}</span>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Approved:
                    {{ $reviews->where('status', 1)->count() }}</span>
            </div>
        </div>

        <div x-data="{ open: {{ request()->anyFilled(['search', 'rating', 'user_type']) ? 'true' : 'false' }} }" class="mb-8">

            <button @click="open = !open"
                class="flex items-center justify-between w-full p-5 bg-white border border-slate-200 rounded-2xl shadow-sm transition-all hover:bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <h2 class="text-sm font-bold text-slate-800 tracking-tight">Search & Advanced Filters</h2>
                        <p class="text-xs text-slate-500 font-medium">Filter by name, rating, or user registration status
                        </p>
                    </div>
                </div>

                <div class="text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-white border-x border-b border-slate-200 p-6 rounded-b-2xl shadow-sm -mt-2 pt-8">

                <form action="{{ route('admin.reviews.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">

                    <div class="md:col-span-4">
                        <label
                            class="block text-[11px] font-bold text-slate-400 uppercase mb-2 ml-1 tracking-widest">Keywords</label>
                        <div class="relative group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Name, email, or content..."
                                class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm pl-11 pr-4 py-3 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                            <div
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-3">
                        <label
                            class="block text-[11px] font-bold text-slate-400 uppercase mb-2 ml-1 tracking-widest">Minimum
                            Rating</label>
                        <div class="relative">
                            <select name="rating"
                                class="w-full appearance-none bg-slate-50 border-slate-200 rounded-xl text-sm px-4 py-3 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none cursor-pointer">
                                <option value="">All Star Ratings</option>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} Stars {{ $i >= 4 ? '★ ★ ★ ★' : '' }}
                                    </option>
                                @endfor
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-[11px] font-bold text-slate-400 uppercase mb-2 ml-1 tracking-widest">Source
                            / Type</label>
                        <div class="relative">
                            <select name="user_type"
                                class="w-full appearance-none bg-slate-50 border-slate-200 rounded-xl text-sm px-4 py-3 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none cursor-pointer">
                                <option value="">All Reviewers</option>
                                <option value="registered" {{ request('user_type') == 'registered' ? 'selected' : '' }}>
                                    Registered Members Only</option>
                                <option value="guest" {{ request('user_type') == 'guest' ? 'selected' : '' }}>Guest
                                    (Unverified)</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-blue-900 text-white px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-blue-600 shadow-md transition-all active:scale-95">
                            Filter
                        </button>

                        @if (request()->anyFilled(['search', 'rating', 'user_type']))
                            <a href="{{ route('admin.reviews.index') }}"
                                class="bg-red-50 text-red-500 px-4 py-3 rounded-xl hover:bg-red-100 transition-all flex items-center justify-center border border-red-100"
                                title="Reset Filters">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Reviewer</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Rating & Feedback</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase text-center">Featured</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($reviews as $review)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div
                                            class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-sm font-bold text-slate-600 overflow-hidden border">
                                            @if ($review->user && $review->user->getFirstMediaUrl('avatar'))
                                                <img src="{{ $review->user->getFirstMediaUrl('avatar') }}"
                                                    class="object-cover h-full w-full">
                                            @elseif($review->getFirstMediaUrl('avatar'))
                                                <img src="{{ $review->getFirstMediaUrl('avatar') }}"
                                                    class="object-cover h-full w-full">
                                            @else
                                                {{ strtoupper(substr($review->name, 0, 1)) }}
                                            @endif
                                        </div>

                                        {{-- Green Dot if they are a registered user --}}
                                        @if ($review->user_id)
                                            <span
                                                class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-white"
                                                title="Registered User"></span>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-1">
                                            <p class="text-sm font-bold text-slate-800">{{ $review->name }}</p>
                                            @if ($review->user_id)
                                                {{-- Verified Icon for Registered Users --}}
                                                <svg class="w-3.5 h-3.5 text-blue-500" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                                </svg>
                                            @endif
                                        </div>

                                        <p
                                            class="text-[10px] font-medium {{ $review->user_id ? 'text-blue-600' : 'text-slate-400' }}">
                                            {{ $review->user_id ? 'Registered Member' : 'Guest Reviewer' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex text-amber-400 text-xs mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                                <p class="text-sm text-slate-600 line-clamp-2 w-64 italic">"{{ $review->review }}"</p>
                            </td>
                            <td class="px-6 py-4">
                                @if ($review->status == 0)
                                    <span
                                        class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-[10px] font-bold uppercase tracking-wider">Pending</span>
                                @elseif($review->status == 1)
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold uppercase tracking-wider">Approved</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold uppercase tracking-wider">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.reviews.featured', $review->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="transition-transform active:scale-90">
                                        @if ($review->is_featured)
                                            <span class="text-2xl text-amber-500">⭐</span>
                                        @else
                                            <span class="text-2xl text-slate-200 hover:text-slate-300">☆</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    {{-- Approve Action --}}
                                    @if ($review->status != 1)
                                        <form action="{{ route('admin.reviews.status', $review->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="1">
                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg transition-all shadow-sm active:translate-y-0.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Reject Action --}}
                                    @if ($review->status != 2)
                                        <form action="{{ route('admin.reviews.status', $review->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="2">
                                            <button type="submit"
                                                class="bg-white border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 p-2 rounded-lg transition-all shadow-sm active:translate-y-0.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 bg-slate-50 border-t border-slate-200">
                {{ $reviews->links('pagination.dots') }}
            </div>
        </div>
    </div>
@endsection
