@extends('layouts.userdashboard')

@section('content')
    {{-- We use Js::from to pass PHP data to Alpine --}}
    <div class="bg-[#f8fafc] min-h-screen" 
         x-data="{
            activeAnnouncement: {{ $announcements->isNotEmpty() ? $announcements->first()['id'] : 'null' }},
            filter: 'All',
            announcements: {{ \Illuminate\Support\Js::from($announcements) }},
            
            // Computed property to get items based on filter
            get filteredItems() {
                if (this.filter === 'All') return this.announcements;
                return this.announcements.filter(item => item.type === this.filter);
            },

            // Helper to get count for buttons
            getCount(type) {
                if (type === 'All') return this.announcements.length;
                return this.announcements.filter(item => item.type === type).length;
            }
         }">

        {{-- Filter Buttons Section --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none">
                {{-- Dynamic Filter Buttons --}}
                <template x-for="type in ['All', 'Features', 'Service Update', 'Others']">
                    <button @click="filter = type"
                        :class="filter === type ? 'bg-white border-blue-600 text-[#0939a4] shadow-sm' :
                            'bg-white border-gray-100 text-gray-500'"
                        class="px-5 py-2 rounded-full text-xs font-bold border transition-all whitespace-nowrap">
                        <span x-text="type"></span>
                        <span x-text="getCount(type)" class="ml-1 opacity-75"></span>
                    </button>
                </template>
            </div>

            {{-- Search & Time Filter (Visual only for now) --}}
            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" placeholder="Search using keyword"
                        class="pl-10 pr-4 py-2 bg-white border border-gray-100 rounded-full text-xs font-medium w-64 focus:outline-none focus:ring-1 focus:ring-[#0939a4] shadow-sm">
                    <svg class="w-4 h-4 absolute left-4 top-2.5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <button
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-100 rounded-full text-xs font-bold text-gray-700 shadow-sm">
                    last 30 days
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- LEFT COLUMN: List of Announcements --}}
            <div class="lg:col-span-4 space-y-4">
                <div class="mb-2 px-2">
                    <h3 class="text-sm font-bold text-[#0939a4]">Updates Feed</h3>
                    <p class="text-[10px] text-gray-400 font-bold">Click an Announcement to view full details on the right.</p>
                </div>

                <div class="space-y-4 max-h-[70vh] overflow-y-auto pr-2 scrollbar-thin">
                    {{-- Loop through filtered items --}}
                    <template x-for="ann in filteredItems" :key="ann.id">
                        <div @click="activeAnnouncement = ann.id"
                            :class="activeAnnouncement === ann.id ? 'border-blue-500 ring-1 ring-blue-500' :
                                'border-gray-100 hover:border-gray-200'"
                            class="bg-white rounded-2xl border p-5 cursor-pointer transition-all shadow-sm group">
                            
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-xs font-bold text-gray-900 group-hover:text-blue-600 transition-colors pr-4"
                                    x-text="ann.title"></h4>
                                <span class="text-[10px] text-gray-400 font-bold whitespace-nowrap"
                                    x-text="ann.date_human"></span>
                            </div>
                            
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed mb-4 line-clamp-2" x-text="ann.content"></p>
                            
                            <div class="flex gap-2">
                                <span class="bg-blue-50 text-blue-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase"
                                    x-text="ann.type"></span>
                                
                                {{-- Show NEW badge if is_new is true --}}
                                <template x-if="ann.is_new">
                                    <span class="bg-green-50 text-green-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">New</span>
                                </template>
                            </div>
                        </div>
                    </template>
                    
                    {{-- Empty State --}}
                    <template x-if="filteredItems.length === 0">
                        <div class="text-center py-10 text-gray-400 text-xs">
                            No announcements found in this category.
                        </div>
                    </template>
                </div>
            </div>

            {{-- RIGHT COLUMN: Detail View --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-8 md:p-10 min-h-[60vh] sticky top-6">
                    
                    {{-- Show details matching activeAnnouncement ID --}}
                    <template x-for="ann in announcements">
                        <div x-show="activeAnnouncement === ann.id" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform translate-x-4">
                            
                            <h2 class="text-2xl font-extrabold text-[#0939a4] mb-2" x-text="ann.title"></h2>
                            
                            <div class="flex items-center gap-2 mb-8">
                                <span class="text-xs text-gray-400 font-bold" x-text="ann.date_formatted + ' • ' + ann.type"></span>
                            </div>

                            <div class="space-y-6">
                                <h3 class="text-sm font-black text-[#0939a4] uppercase tracking-widest border-b border-gray-50 pb-2">
                                    Details
                                </h3>
                                {{-- whitespace-pre-line preserves line breaks from database --}}
                                <div class="text-sm text-gray-600 font-medium leading-loose whitespace-pre-line"
                                    x-text="ann.detail"></div>
                            </div>

                            <div class="mt-12 pt-8 border-t border-gray-50">
                                <p class="text-[11px] text-gray-400 font-medium italic">
                                    If the update impacts you and you have a question, you can raise a ticket from the
                                    Support & Complaints page.
                                </p>
                            </div>
                        </div>
                    </template>

                    {{-- Empty State if no announcements exist at all --}}
                    <template x-if="announcements.length === 0">
                        <div class="flex flex-col items-center justify-center h-full text-gray-400">
                             <p class="text-sm font-bold">No announcements available.</p>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
@endsection