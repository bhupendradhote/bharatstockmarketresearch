@extends('layouts.app')

@section('content')
    <div class="w-full min-h-screen bg-[#f1f5f9]" x-data="{
        openAddModal: false,
        openEditModal: false,
        currentCert: { id: '', user_id: '', certificate_name: '', issue_date: '', expiry_date: '', status: '' }
    }">

        <div class="bg-white border-b border-slate-200 px-6 py-4 sticky top-0 z-10 shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <h1 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Certificates Library
                    </h1>
                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest mt-0.5">Admin Management</p>
                </div>

                <form action="{{ route('admin.certificates.index') }}" method="GET"
                    class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search ID or Name..."
                            class="text-[11px] pl-8 pr-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none w-44 bg-slate-50">
                        <svg class="w-3 h-3 absolute left-2.5 top-2.5 text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" />
                        </svg>
                    </div>

                    <button type="submit"
                        class="bg-blue-700 text-white px-3 py-1.5 rounded-lg text-[11px] font-semibold hover:bg-blue-800 transition-all">Filter</button>

                    <div class="h-6 w-[1px] bg-slate-200 mx-1"></div>

                    <button type="button" @click="openAddModal = true"
                        class="bg-indigo-600 text-white px-4 py-1.5 rounded-lg text-[11px] font-bold hover:bg-indigo-700 shadow-md shadow-indigo-100 transition-all">
                        + ADD CERTIFICATE
                    </button>
                </form>
            </div>
        </div>

        <div class="">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase">Owner</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase">Details</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase">Validity</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase text-center">Status</th>
                                <th class="px-5 py-3 text-[10px] font-bold text-slate-500 uppercase text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($certificates as $cert)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-[11px] font-bold text-indigo-600">
                                                {{ strtoupper(substr($cert->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-[12px] font-bold text-slate-700 leading-tight">
                                                    {{ $cert->user->name }}</p>
                                                <p class="text-[10px] text-slate-400 font-mono">ID: #{{ $cert->user_id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <p class="text-[12px] font-medium text-slate-700">
                                            {{ $cert->certificate_name ?? 'N/A' }}</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5 font-mono">
                                            {{ $cert->certificate_number ?? '--' }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="text-[11px] text-slate-600 italic">I:
                                            {{ $cert->issue_date ? $cert->issue_date->format('d M, Y') : '--' }}</div>
                                        <div class="text-[11px] font-bold text-slate-500">E:
                                            {{ $cert->expiry_date ? $cert->expiry_date->format('d M, Y') : 'Lifetime' }}
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span
                                            class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest
                                    {{ $cert->status == 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $cert->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex justify-end items-center gap-2">
                                            <button
                                                @click="
                                        openEditModal = true; 
                                        currentCert = {
                                            id: '{{ $cert->id }}',
                                            user_id: '{{ $cert->user_id }}',
                                            certificate_name: '{{ $cert->certificate_name }}',
                                            issue_date: '{{ $cert->issue_date ? $cert->issue_date->format('Y-m-d') : '' }}',
                                            expiry_date: '{{ $cert->expiry_date ? $cert->expiry_date->format('Y-m-d') : '' }}',
                                            status: '{{ $cert->status }}'
                                        }"
                                                class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                        stroke-width="2" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('admin.certificates.destroy', $cert->id) }}"
                                                method="POST" class="inline" onsubmit="return confirm('Delete this?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                            stroke-width="2" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-20 text-center text-slate-400 text-xs italic">No data
                                        found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 pagination-container">
                    {{ $certificates->links() }}
                </div>
            </div>
        </div>

        <div x-show="openAddModal" class="fixed inset-0 z-[60] overflow-y-auto" x-cloak style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-600/50 backdrop-blur-sm" @click="openAddModal = false"></div>
                <div
                    class="bg-white rounded-xl shadow-xl z-[70] w-full max-w-md overflow-hidden relative border border-slate-200">
                    <div class="px-6 py-4 bg-white border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-[12px] font-bold text-slate-700 uppercase tracking-wider">Create New Certificate
                        </h3>
                        <button @click="openAddModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                    </div>
                    <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data"
                        class="p-6 space-y-4">
                        @csrf
                        <div>
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 mb-4">
                                <p class="text-[10px] text-slate-400 uppercase font-black tracking-tighter">Uploading as:
                                </p>
                                <p class="text-[12px] font-bold text-slate-700">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Title</label>
                            <input type="text" name="certificate_name"
                                class="w-full text-[12px] border border-slate-200 rounded-lg p-2.5 outline-none focus:border-indigo-500"
                                placeholder="e.g. Master Gold Cert">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Issue Date</label>
                                <input type="date" name="issue_date"
                                    class="w-full text-[12px] border border-slate-200 rounded-lg p-2.5 outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Expiry
                                    Date</label>
                                <input type="date" name="expiry_date"
                                    class="w-full text-[12px] border border-slate-200 rounded-lg p-2.5 outline-none focus:border-indigo-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Certificate
                                File</label>
                            <input type="file" name="file" class="text-[11px] w-full">
                        </div>
                        <div class="pt-4 flex justify-end gap-2">
                            <button type="button" @click="openAddModal = false"
                                class="text-[11px] font-bold text-slate-400 px-4">CANCEL</button>
                            <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-[11px] font-bold">SAVE
                                DOCUMENT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="openEditModal" class="fixed inset-0 z-[60] overflow-y-auto" x-cloak style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-600/50 backdrop-blur-sm" @click="openEditModal = false"></div>
                <div
                    class="bg-white rounded-xl shadow-xl z-[70] w-full max-w-md overflow-hidden relative border border-slate-200">
                    <div class="px-6 py-4 bg-white border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-[12px] font-bold text-slate-700 uppercase tracking-wider">Update Certificate</h3>
                        <button @click="openEditModal = false"
                            class="text-slate-400 hover:text-slate-600">&times;</button>
                    </div>
                    <form :action="'{{ url('admin/certificates') }}/' + currentCert.id" method="POST"
                        enctype="multipart/form-data" class="p-6 space-y-4">
                        @csrf @method('PUT')
                        <div>
                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 mb-4">
                                <p class="text-[10px] text-slate-400 uppercase font-black tracking-tighter">Uploading as:
                                </p>
                                <p class="text-[12px] font-bold text-slate-700">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Title</label>
                            <input type="text" name="certificate_name" x-model="currentCert.certificate_name"
                                class="w-full text-[12px] border border-slate-200 rounded-lg p-2.5 outline-none focus:border-indigo-500">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Issue Date</label>
                                <input type="date" name="issue_date" x-model="currentCert.issue_date"
                                    class="w-full text-[12px] border border-slate-200 rounded-lg p-2.5 outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Expiry
                                    Date</label>
                                <input type="date" name="expiry_date" x-model="currentCert.expiry_date"
                                    class="w-full text-[12px] border border-slate-200 rounded-lg p-2.5 outline-none focus:border-indigo-500">
                            </div>
                        </div>
                        <div class="pt-4 flex justify-end gap-2">
                            <button type="button" @click="openEditModal = false"
                                class="text-[11px] font-bold text-slate-400 px-4">CANCEL</button>
                            <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-[11px] font-bold uppercase">UPDATE
                                NOW</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .pagination-container nav {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .pagination-container span[aria-current="page"] span {
            background: #4f46e5 !important;
            color: white !important;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 11px;
        }

        .pagination-container a,
        .pagination-container span {
            border: 1px solid #e2e8f0;
            padding: 4px 10px;
            font-size: 11px;
            margin: 0 2px;
            border-radius: 6px;
            color: #64748b;
        }
    </style>
@endsection
