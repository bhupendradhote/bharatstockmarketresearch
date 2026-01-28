{{-- @extends('layouts.app')

@section('content')
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>

    <div class="flex flex-col h-screen bg-white text-gray-800">
        <div class="flex items-center justify-between px-8 py-4 border-b border-gray-100 bg-white shrink-0">
            <div>
                <h1 class="text-[11px] font-bold tracking-[0.2em] text-gray-900 uppercase">Employee Directory</h1>
            </div>

            <div class="relative flex-grow max-w-md mx-12">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg id="search-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <svg id="search-spinner" class="animate-spin h-3.5 w-3.5 text-indigo-500 htmx-indicator"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </span>

                <input type="text" name="search" placeholder="Type to filter..."
                    class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-100 rounded text-[11px] focus:ring-1 focus:ring-indigo-500 outline-none transition-all"
                    hx-get="{{ route('employees.index') }}" hx-trigger="keyup changed delay:300ms"
                    hx-target="#main-content-area"  hx-swap="innerHTML" hx-indicator="#search-spinner"
                    autocomplete="off">
            </div>

            <a href="#" class="px-4 py-2 bg-indigo-600 text-white text-[10px] font-bold rounded">+ NEW EMPLOYEE</a>
        </div>

        <div id="main-content-area" class="flex-grow overflow-auto">
            @fragment('table-body')
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-white sticky top-0">
                            <th class="px-8 py-4 text-[9px] font-bold text-gray-400 uppercase">Name</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-gray-400 uppercase">Email</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-gray-400 uppercase">Phone</th>
                            <th class="px-8 py-4 text-[9px] font-bold text-gray-400 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($employees as $employee)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-8 py-3 text-[11px] font-semibold text-gray-900">{{ $employee->name }}</td>
                                <td class="px-6 py-3 text-[11px] text-gray-500">{{ $employee->email }}</td>
                                <td class="px-6 py-3 text-[11px] text-gray-500">{{ $employee->phone ?? '---' }}</td>
                                <td class="px-8 py-3 text-right">
                                    <button class="text-indigo-600 font-bold text-[10px] uppercase">Edit</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="px-8 py-20 text-center text-gray-300 text-[10px] uppercase tracking-widest">No
                                    matching employees</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="px-8 py-4 border-t border-gray-50 flex items-center justify-between">
                    <span class="text-[10px] text-gray-400 uppercase">Results: {{ $employees->total() }}</span>
                    <div class="ajax-pagination">
                        {{ $employees->links('pagination.dots') }}
                    </div>
                </div>
            @endfragment
        </div>
    </div>

    <style>
        .htmx-indicator {
            display: none;
        }

        .htmx-request .htmx-indicator {
            display: inline;
        }

        .htmx-request #search-icon {
            display: none;
        }
    </style>
@endsection --}}


@extends('layouts.app')

@section('content')
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>

    <div class="flex flex-col h-screen bg-white text-gray-800">
        {{-- Header --}}
        <div class="flex items-center justify-between px-8 py-4 border-b border-gray-100 bg-white shrink-0">
            <div>
                <h1 class="text-[11px] font-bold tracking-[0.2em] text-gray-900 uppercase">Employee Directory</h1>
            </div>

            {{-- Search Bar --}}
            <div class="relative flex-grow max-w-md mx-12">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg id="search-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <svg id="search-spinner" class="animate-spin h-3.5 w-3.5 text-indigo-500 htmx-indicator"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </span>
                <input type="text" name="search" placeholder="Type to filter..."
                    class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-100 rounded text-[11px] focus:ring-1 focus:ring-indigo-500 outline-none transition-all"
                    hx-get="{{ route('employees.index') }}" hx-trigger="keyup changed delay:300ms"
                    hx-target="#main-content-area" hx-swap="innerHTML" hx-indicator="#search-spinner">
            </div>

            {{-- Create Trigger --}}
            <button hx-get="{{ route('employees.index') }}?action=create" hx-target="#modal-container"
                class="px-4 py-2 bg-indigo-600 text-white text-[10px] font-bold rounded uppercase tracking-widest hover:bg-indigo-700 shadow-sm">
                + NEW EMPLOYEE
            </button>
        </div>

        <div id="main-content-area" class="flex-grow overflow-auto">
            @fragment('table-body')
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-white sticky top-0">
                            <th class="px-8 py-4 text-[9px] font-bold text-gray-400 uppercase">Name</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-gray-400 uppercase">Email</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-gray-400 uppercase">Phone</th>
                            <th class="px-8 py-4 text-[9px] font-bold text-gray-400 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($employees as $employee)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-8 py-3 text-[11px] font-semibold text-gray-900">{{ $employee->name }}</td>
                                <td class="px-6 py-3 text-[11px] text-gray-500">{{ $employee->email }}</td>
                                <td class="px-6 py-3 text-[11px] text-gray-500">{{ $employee->phone ?? '---' }}</td>
                                <td class="px-8 py-3 text-right space-x-4">
                                    {{-- Edit Trigger --}}
                                    {{-- Is block mein koi change nahi, bas reference ke liye --}}
                                    <button hx-get="{{ route('employees.index') }}?action=edit&id={{ $employee->id }}"
                                        hx-target="#modal-container"
                                        class="text-indigo-600 font-bold text-[10px] uppercase hover:underline">
                                        Edit
                                    </button>

                                    {{-- Delete Trigger --}}
                                    <button hx-get="{{ route('employees.index') }}?action=delete&id={{ $employee->id }}"
                                        hx-target="#modal-container"
                                        class="text-red-400 font-bold text-[10px] uppercase hover:text-red-600">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="px-8 py-20 text-center text-gray-300 text-[10px] uppercase tracking-widest">No
                                    matching employees</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="px-8 py-4 border-t border-gray-50 flex items-center justify-between">
                    <span class="text-[10px] text-gray-400 uppercase">Results: {{ $employees->total() }}</span>
                    <div class="ajax-pagination">
                        {{ $employees->links() }}
                    </div>
                </div>
            @endfragment
        </div>
    </div>

    {{-- GLOBAL MODAL CONTAINER --}}
    <div id="modal-container">
        @fragment('modal-content')
            {{-- 1. CREATE MODAL --}}
            @if (request('action') == 'create')
                <div
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-indigo-600">Add New Employee</h3>
                            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
                        </div>
                        <form hx-post="{{ route('employees.store') }}" hx-target="#main-content-area"
                            hx-on::after-request="if(event.detail.successful) closeModal()">
                            @csrf
                            <div class="p-6 space-y-4">
                                <input type="text" name="name" placeholder="Full Name"
                                    class="w-full border border-gray-100 rounded px-3 py-2 text-[11px] focus:ring-1 focus:ring-indigo-500 outline-none"
                                    required>
                                <input type="email" name="email" placeholder="Email Address"
                                    class="w-full border border-gray-100 rounded px-3 py-2 text-[11px] focus:ring-1 focus:ring-indigo-500 outline-none"
                                    required>
                                <input type="text" name="phone" placeholder="Phone Number"
                                    class="w-full border border-gray-100 rounded px-3 py-2 text-[11px] focus:ring-1 focus:ring-indigo-500 outline-none">
                            </div>
                            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                                <button type="button" onclick="closeModal()"
                                    class="text-[10px] font-bold uppercase text-gray-400">Cancel</button>
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-6 py-2 rounded text-[10px] font-bold uppercase tracking-widest">Create
                                    Employee</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- 2. EDIT MODAL --}}
                {{-- 2. EDIT MODAL --}}
            @elseif(request('action') == 'edit')
                <div
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-[11px] font-bold uppercase tracking-widest text-orange-500">
                                Update: {{ $selectedEmployee->name }} {{-- Changed to $selectedEmployee --}}
                            </h3>
                            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
                        </div>

                        {{-- Form action mein bhi change --}}
                        <form hx-post="{{ route('employees.update', $selectedEmployee->id) }}" hx-target="#main-content-area"
                            hx-on::after-request="if(event.detail.successful) closeModal()">
                            @csrf
                            @method('PUT')
                            <div class="p-6 space-y-4">
                                <input type="text" name="name" value="{{ $selectedEmployee->name }}"
                                    class="w-full border border-gray-100 rounded px-3 py-2 text-[11px] focus:ring-1 focus:ring-indigo-500 outline-none"
                                    required>

                                <input type="email" name="email" value="{{ $selectedEmployee->email }}"
                                    class="w-full border border-gray-100 rounded px-3 py-2 text-[11px] focus:ring-1 focus:ring-indigo-500 outline-none"
                                    required>

                                <input type="text" name="phone" value="{{ $selectedEmployee->phone }}"
                                    class="w-full border border-gray-100 rounded px-3 py-2 text-[11px] focus:ring-1 focus:ring-indigo-500 outline-none">
                            </div>
                            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                                <button type="button" onclick="closeModal()"
                                    class="text-[10px] font-bold uppercase text-gray-400">Cancel</button>
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-6 py-2 rounded text-[10px] font-bold uppercase tracking-widest">Update
                                    Now</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- 3. DELETE MODAL --}}
            @elseif(request('action') == 'delete')
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                    <div class="bg-white rounded p-6 shadow-xl max-w-sm w-full text-center">
                        <p class="text-[11px] font-bold uppercase mb-4 tracking-wider text-red-600">Confirm Permanently Delete?
                        </p>
                        <div class="flex justify-center space-x-4">
                            <button onclick="closeModal()" class="text-[10px] font-bold uppercase text-gray-400">No, Go
                                Back</button>
                            <form hx-delete="{{ route('employees.destroy', request('id')) }}" hx-target="#main-content-area"
                                hx-on::after-request="closeModal()">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded text-[10px] font-bold uppercase tracking-widest shadow-lg shadow-red-100">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endfragment
    </div>

    <style>
        .htmx-indicator {
            display: none;
        }

        .htmx-request .htmx-indicator {
            display: inline;
        }

        .htmx-request #search-icon {
            display: none;
        }
    </style>

    <script>
        function closeModal() {
            document.getElementById('modal-container').innerHTML = '';
        }
        // Modal ko Esc key se bhi band karne ke liye
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });
    </script>
@endsection
