@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Contact Details</h2>
            <p class="text-xs text-slate-500">Update the official contact information for the website.</p>
        </div>
        
    </div>

    @if (session('success'))
        <div class="mb-4 flex items-center bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded shadow-sm transition-all">
            <div class="flex-shrink-0">
                <svg class="h-4 w-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-xs font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50 border-b border-slate-100 px-6 py-3">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600">Information Settings</h3>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('admin.contact.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="flex items-center text-xs font-semibold text-slate-700">
                            <svg class="w-3.5 h-3.5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Official Email Address
                        </label>
                        <input type="email" name="email" value="{{ old('email', $contact->email ?? '') }}"
                            placeholder="e.g. support@metawish.com"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder:text-slate-300">
                        @error('email') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="flex items-center text-xs font-semibold text-slate-700">
                            <svg class="w-3.5 h-3.5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            Phone Number
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', $contact->phone ?? '') }}"
                            placeholder="+91 00000 00000"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder:text-slate-300">
                        @error('phone') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="flex items-center text-xs font-semibold text-slate-700">
                        <svg class="w-3.5 h-3.5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Office Address
                    </label>
                    <textarea name="address" rows="4" 
                        placeholder="Enter full physical address..."
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder:text-slate-300">{{ old('address', $contact->address ?? '') }}</textarea>
                    @error('address') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-lg text-xs shadow-lg shadow-emerald-500/30 transition-all transform active:scale-95 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Update Contact Info
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection