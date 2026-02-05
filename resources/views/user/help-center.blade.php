@extends('layouts.user')

@section('title', 'Help Center')

@section('content')
    {{-- Main Container with Alpine.js State --}}
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8 mt-24" x-data="{
        openModal: false,
        viewModal: false,
        selectedTicket: { subject: '', category: '', description: '', status: '', priority: '', date: '', image: '' }
    }">

        {{-- ================= HEADER & TOP ACTIONS ================= --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Help Center</h1>
                <p class="text-gray-500">Track your support requests and get help instantly.</p>
            </div>
            <button @click="openModal = true"
                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition-all transform active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Support Ticket
            </button>
        </div>

        {{-- ================= ANALYSIS CARDS ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-4 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Tickets</p>
                    <h4 class="text-2xl font-bold text-gray-800">{{ $tickets->count() }}</h4>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-4 bg-amber-50 text-amber-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">In Progress</p>
                    <h4 class="text-2xl font-bold text-gray-800">{{ $tickets->where('status', 'In Progress')->count() }}
                    </h4>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Resolved</p>
                    <h4 class="text-2xl font-bold text-gray-800">{{ $tickets->where('status', 'Resolved')->count() }}</h4>
                </div>
            </div>
        </div>

        {{-- ================= TICKET LIST ================= --}}
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-800">Recent Activity</h2>

            @if ($tickets->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-100">
                    <div class="mb-4 flex justify-center text-gray-300">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 5-8-5">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-400 font-medium">No tickets found. Need help? Raise a new ticket.</p>
                </div>
            @endif

            <div class="grid gap-4">
                @foreach ($tickets as $ticket)
                    <div @click="selectedTicket = { 
                            subject: '{{ addslashes($ticket->subject) }}', 
                            category: '{{ $ticket->issue }}', 
                            description: '{{ addslashes($ticket->description) }}', 
                            status: '{{ $ticket->status }}', 
                            priority: '{{ $ticket->priority }}',
                            date: '{{ $ticket->created_at->format('M d, Y') }}',
                            image: '{{ $ticket->getFirstMediaUrl('tickets') }}' 
                         }; viewModal = true"
                        class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:border-blue-300 transition-all duration-300 group cursor-pointer">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-xs font-bold px-2 py-0.5 rounded bg-gray-100 text-gray-600 tracking-wide">#{{ $loop->iteration }}</span>
                                    <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        {{ $ticket->subject }}</h3>
                                </div>
                                <p class="text-sm text-gray-500 line-clamp-1 italic">"{{ $ticket->description }}"</p>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="text-right hidden sm:block">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                                        {{ $ticket->priority }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $ticket->created_at->diffForHumans() }}</p>
                                </div>
                                <span
                                    class="px-4 py-1.5 rounded-lg text-xs font-bold 
                                    @if ($ticket->status == 'In Progress') bg-amber-100 text-amber-700
                                    @elseif($ticket->status == 'Open') bg-blue-100 text-blue-700
                                    @else bg-emerald-100 text-emerald-700 @endif">
                                    {{ strtoupper($ticket->status) }}
                                </span>
                                <svg class="w-5 h-5 text-gray-300 group-hover:text-gray-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ================= MODAL: VIEW TICKET DETAILS ================= --}}
        <div x-show="viewModal" class="fixed inset-0 z-[60] overflow-y-auto" x-cloak style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-60 backdrop-blur-sm"
                    @click="viewModal = false"></div>

                <div
                    class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all">
                    <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Ticket Details</h3>
                        <button @click="viewModal = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-2xl font-black text-blue-600" x-text="selectedTicket.subject"></h4>
                                <p class="text-xs text-gray-400 mt-1" x-text="'Raised on: ' + selectedTicket.date"></p>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-600"
                                x-text="selectedTicket.priority"></span>
                        </div>

                        <div>
                            <label
                                class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Description</label>
                            <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100"
                                x-text="selectedTicket.description"></p>
                        </div>

                        {{-- Spatie Image Display --}}
                        <div x-show="selectedTicket.image">
                            <label
                                class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-2">Attached
                                Image</label>
                            <div class="rounded-2xl overflow-hidden border border-gray-200">
                                <img :src="selectedTicket.image" class="w-full h-auto max-h-64 object-cover"
                                    alt="Ticket Attachment">
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 text-right">
                        <button @click="viewModal = false"
                            class="px-6 py-2 bg-blue-800 text-white rounded-xl font-bold hover:bg-blue-900 transition-all">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= MODAL: RAISE NEW TICKET ================= --}}
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50 backdrop-blur-sm"
                    @click="openModal = false"></div>

                <div
                    class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div
                        class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4 flex justify-between items-center text-white">
                        <h3 class="text-lg font-bold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                </path>
                            </svg>
                            Raise Support Ticket
                        </h3>
                        <button @click="openModal = false"><svg class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>

                    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data"
                        class="p-6 space-y-4">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Subject</label>
                                <input type="text" name="subject"
                                    class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 bg-gray-50 p-2.5 text-sm"
                                    placeholder="Enter subject..." required>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Category</label>
                                <select name="issue" id="issueSelect" onchange="handleIssue()"
                                    class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 bg-gray-50 p-2.5 text-sm"
                                    required>
                                    <option value="">Select Category</option>
                                    <option>Login Problem</option>
                                    <option>Payment Failed</option>
                                    <option>Bug in App</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <input type="text" name="other_issue" id="otherIssue"
                            class="hidden w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 bg-gray-50 p-2.5 text-sm"
                            placeholder="Specify your issue...">

                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 bg-gray-50 p-2.5 text-sm"
                                placeholder="Describe your problem in detail..." required></textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Screenshot</label>
                            <div class="flex items-center gap-3">
                                <label
                                    class="flex-1 flex flex-col items-center justify-center h-16 border-2 border-dashed border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                                    <div class="flex flex-col items-center justify-center pt-2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="text-[10px] text-gray-400">Click to upload</p>
                                    </div>
                                    <input type="file" name="attachment" class="hidden" accept="image/*"
                                        onchange="previewImage(event)" />
                                </label>
                                <div
                                    class="w-16 h-16 bg-gray-100 rounded-xl border border-gray-200 flex items-center justify-center overflow-hidden">
                                    <img id="output" class="hidden object-cover w-full h-full" />
                                    <svg id="placeholderIcon" class="w-6 h-6 text-gray-300" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 pt-2">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Priority</label>
                                <select name="priority"
                                    class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 bg-gray-50 p-2.5 text-sm">
                                    <option>Low</option>
                                    <option>Medium</option>
                                    <option>High</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl shadow-md transform active:scale-95 text-sm transition-all">
                                    Submit Ticket
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const output = document.getElementById('output');
            const placeholder = document.getElementById('placeholderIcon');
            reader.onload = function() {
                output.src = reader.result;
                output.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        function handleIssue() {
            const select = document.getElementById("issueSelect");
            const other = document.getElementById("otherIssue");
            if (select.value === "other") {
                other.classList.remove("hidden");
                other.setAttribute("required", true);
            } else {
                other.classList.add("hidden");
                other.value = "";
                other.removeAttribute("required");
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
