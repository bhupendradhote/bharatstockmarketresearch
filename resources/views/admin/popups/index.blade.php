@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <span class="text-indigo-600 font-bold tracking-[0.2em] uppercase text-xs">Management Console</span>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight mt-1">Popup <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Campaigns</span>
                    </h1>
                    <p class="text-slate-500 mt-2 font-medium">Create, monitor, and toggle your website overlays in
                        real-time.</p>
                </div>
                <a href="{{ route('admin.popups.create') }}"
                    class="group inline-flex items-center px-8 py-4 bg-slate-900 hover:bg-indigo-600 text-white font-bold rounded-2xl shadow-2xl shadow-slate-200 transition-all duration-300 active:scale-95 text-sm uppercase tracking-widest">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Campaign
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse ($popups as $popup)
                    @php
                        $colors =
                            [
                                'offer' => 'indigo',
                                'notification' => 'sky',
                                'policy' => 'emerald',
                                'image' => 'rose',
                                'custom' => 'slate',
                            ][$popup->type] ?? 'slate';
                    @endphp

                    <div
                        class="flex flex-col h-[550px] bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden group">

                        @if ($popup->image)
                            <div class="relative h-[250px] shrink-0 overflow-hidden">
                                <img src="{{ asset('/storage/' . $popup->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/20 to-transparent p-8 flex flex-col justify-end">
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <span
                                                class="px-3 py-1 bg-{{ $colors }}-500 text-white text-[10px] font-black uppercase tracking-tighter rounded-lg mb-2 inline-block">Featured
                                                {{ $popup->type }}</span>
                                            <h3 class="text-white text-2xl font-black leading-tight">{{ $popup->title }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($popup->type == 'offer')
                            <div
                                class="relative h-[250px] shrink-0 bg-gradient-to-br from-indigo-600 to-violet-700 p-8 flex flex-col justify-center overflow-hidden">
                                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl">
                                </div>
                                <div class="absolute top-10 left-10 text-white/5">
                                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M11 15h2v2h-2zm0-8h2v6h-2zm.99-5C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                                    </svg>
                                </div>
                                <span
                                    class="relative z-10 px-3 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-[0.2em] rounded-full border border-white/30 w-fit mb-4">Limited
                                    Offer</span>
                                <h3
                                    class="relative z-10 text-white text-3xl font-black uppercase leading-none tracking-tighter">
                                    {{ $popup->title }}</h3>
                            </div>
                        @else
                            <div
                                class="relative h-[250px] shrink-0 bg-slate-50 border-b border-slate-100 p-8 flex flex-col justify-end overflow-hidden">
                                <div class="absolute top-0 right-0 p-8">
                                    <div
                                        class="w-16 h-16 rounded-3xl bg-white shadow-sm flex items-center justify-center text-{{ $colors }}-500">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <span
                                    class="text-{{ $colors }}-600 font-bold text-[10px] uppercase tracking-[0.3em] mb-2 inline-block">{{ $popup->type }}
                                    update</span>
                                <h3 class="text-slate-900 text-2xl font-black leading-tight uppercase">{{ $popup->title }}
                                </h3>
                            </div>
                        @endif

                        <div class="flex-grow p-8 flex flex-col">
                            <div class="flex-grow max-h-28 overflow-y-auto custom-scrollbar mb-6">
                                <div class="prose prose-slate prose-sm max-w-none text-slate-500 font-medium">
                                    {!! $popup->content !!}
                                </div>
                            </div>


                            <div class="flex items-center justify-between py-4 border-t border-slate-50">

                                <div class="flex flex-col gap-1">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                        Status
                                    </span>

                                    <label class="relative inline-flex items-center cursor-pointer">

                                        <input type="checkbox" class="sr-only peer"
                                            onchange="toggleStatus({{ $popup->id }}, this)"
                                            {{ $popup->status === 'active' ? 'checked' : '' }}>

                                        <!-- Toggle -->
                                        <div
                                            class="w-12 h-6 bg-slate-200 rounded-full shadow-inner
                   peer-checked:bg-indigo-500
                   after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                   after:bg-white after:rounded-full after:h-5 after:w-5
                   after:transition-all peer-checked:after:translate-x-full">
                                        </div>

                                        <!-- Status Label -->
                                        <span
                                            class="ml-3 text-xs font-bold uppercase status-label-{{ $popup->id }}
                   {{ $popup->status === 'active' ? 'text-indigo-600' : 'text-slate-600' }}">
                                            {{ strtoupper($popup->status) }}
                                        </span>

                                    </label>
                                </div>


                                {{-- <div class="flex gap-2">
                                    <button onclick="openPreview(@json($popup))"
                                        class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-lg transition-all flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                    <a href="{{ route('admin.popups.edit', $popup->id) }}"
                                        class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-lg transition-all flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                </div> --}}
                                <div class="flex gap-2">
                                    <button onclick="openPreview(@json($popup))"
                                        class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-lg transition-all flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>

                                    <a href="{{ route('admin.popups.edit', $popup->id) }}"
                                        class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-lg transition-all flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.popups.destroy', $popup->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this campaign? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-600 hover:shadow-lg transition-all flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if ($popup->button_text)
                                <a href="{{ $popup->button_url ?? '#' }}"
                                    class="w-full py-4 bg-slate-900 group-hover:bg-{{ $colors }}-600 text-white rounded-[1.2rem] font-black text-[10px] uppercase tracking-[0.25em] text-center transition-all shadow-xl shadow-slate-200">
                                    {{ $popup->button_text }}
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>

    <style>
        /* Professional Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Dynamic Color Safelist (Tailwind workaround) */
        .bg-indigo-500 {
            background-color: #6366f1;
        }

        .bg-sky-500 {
            background-color: #0ea5e9;
        }

        .bg-emerald-500 {
            background-color: #10b981;
        }

        .bg-rose-500 {
            background-color: #f43f5e;
        }

        .text-indigo-500 {
            color: #6366f1;
        }

        .text-sky-500 {
            color: #0ea5e9;
        }

        .text-emerald-500 {
            color: #10b981;
        }

        .text-rose-500 {
            color: #f43f5e;
        }
    </style>

    <script>
        function toggleStatus(id, checkbox) {

            const isActive = checkbox.checked;
            const label = document.querySelector(`.status-label-${id}`);

            // Decide route
            const url = isActive ?
                `/admin/popups/${id}/activate` :
                `/admin/popups/${id}/deactivate`;

            // UI: loading state
            label.innerText = 'WAIT...';
            label.className =
                `ml-3 text-xs font-bold text-slate-400 animate-pulse uppercase status-label-${id}`;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(() => {
                    setTimeout(() => {
                        label.innerText = isActive ? 'ACTIVE' : 'INACTIVE';
                        label.className =
                            `ml-3 text-xs font-bold ${
                        isActive ? 'text-indigo-600' : 'text-slate-600'
                    } uppercase status-label-${id}`;
                    }, 400);
                })
                .catch(() => {
                    // rollback checkbox if error
                    checkbox.checked = !isActive;
                    label.innerText = 'ERROR';
                    label.className =
                        `ml-3 text-xs font-bold text-red-600 uppercase status-label-${id}`;
                });
        }
    </script>
@endsection
