@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-[#0939a4]">Announcements</h1>
                <p class="text-sm text-gray-600 mt-1">Manage updates, news, and maintenance alerts shown on the user dashboard.</p>
            </div>
            <a href="{{ route('admin.announcements.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-[#0939a4] hover:bg-blue-800 text-white text-sm font-bold rounded-full transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Announcement
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 text-green-800 px-4 py-3 rounded-lg border border-green-200 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-gray-500">ID</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-gray-500">Title & Content</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-gray-500">Type</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-gray-500">Publish Date</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-gray-500 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($announcements as $announcement)
                            <tr class="hover:bg-blue-50/50 transition-colors group">
                                <td class="px-6 py-4 font-mono text-xs text-gray-400">#{{ $announcement->id }}</td>
                                
                                <td class="px-6 py-4 max-w-sm">
                                    <div class="font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors">{{ $announcement->title }}</div>
                                    <div class="text-xs text-gray-500 line-clamp-2" title="{{ $announcement->content }}">
                                        {{ $announcement->content }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $badges = [
                                            'Features' => 'bg-purple-50 text-purple-700 border-purple-100',
                                            'Service Update' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'Others' => 'bg-gray-50 text-gray-600 border-gray-100',
                                        ];
                                        $badgeClass = $badges[$announcement->type] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase border {{ $badgeClass }}">
                                        {{ $announcement->type }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-gray-700">
                                            {{ $announcement->published_at ? $announcement->published_at->format('d M, Y') : 'Draft' }}
                                        </span>
                                        <span class="text-[10px] text-gray-400">
                                            {{ $announcement->published_at ? $announcement->published_at->format('h:i A') : '' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex justify-end items-center gap-3">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('admin.announcements.edit', $announcement->id) }}" 
                                           class="text-gray-400 hover:text-blue-600 transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this announcement? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <p class="text-sm font-medium">No announcements found</p>
                                        <p class="text-xs mt-1">Get started by creating a new update.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($announcements->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $announcements->links() }} 
                </div>
            @endif
        </div>
    </div>
</div>
@endsection