@extends('layouts.userdashboard')

@section('content')
    <div class="bg-[#f8fafc] min-h-screen" x-data="{
        activeAnnouncement: 1,
        filter: 'All',
        announcements: [
            { id: 1, title: 'New Notification Center & Learning modules', date: 'Today', type: 'Features', content: 'Now Track all Alerts in one place and learn logic behind each tip via structured modules.', detail: 'Scheduled between 11.30 PM and 12.30 PM on Sunday night. During the time: \n\n • Exist logged-in users may experience brief disconnects \n • New logins and KYC documents uploads may be temporarily unavailable.' },
            { id: 2, title: 'Change in Package bill Cycle', date: '2 days ago', type: 'Service Update', content: 'Monthly plans now renew exactly 30 days from activation time for more transparent bills.', detail: 'Your billing cycle has been updated to provide better transparency. No action is required from your side.' },
            { id: 3, title: 'Plan maintenance window', date: '3 days ago', type: 'Others', content: 'Short maintenance window this weekend; reading access stays on, but new logins will be restricted.', detail: 'We are performing routine server maintenance to improve performance.' }
        ]
    }">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none">
                <template x-for="f in ['All 20', 'Features 20', 'Service Update 20', 'Others 20']">
                    <button @click="filter = f.split(' ')[0]"
                        :class="filter === f.split(' ')[0] ? 'bg-white border-blue-600 text-[#0939a4] shadow-sm' :
                            'bg-white border-gray-100 text-gray-500'"
                        class="px-5 py-2 rounded-full text-xs font-bold border transition-all whitespace-nowrap"
                        x-text="f"></button>
                </template>
            </div>

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

            <div class="lg:col-span-4 space-y-4">
                <div class="mb-2 px-2">
                    <h3 class="text-sm font-bold text-[#0939a4]">Updates Feed</h3>
                    <p class="text-[10px] text-gray-400 font-bold">Click an Announcement to view full details on the right.
                    </p>
                </div>

                <div class="space-y-4 max-h-[70vh] overflow-y-auto pr-2 scrollbar-thin">
                    <template x-for="ann in announcements" :key="ann.id">
                        <div @click="activeAnnouncement = ann.id"
                            :class="activeAnnouncement === ann.id ? 'border-blue-500 ring-1 ring-blue-500' :
                                'border-gray-100 hover:border-gray-200'"
                            class="bg-white rounded-2xl border p-5 cursor-pointer transition-all shadow-sm group">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-xs font-bold text-gray-900 group-hover:text-blue-600 transition-colors pr-4"
                                    x-text="ann.title"></h4>
                                <span class="text-[10px] text-gray-400 font-bold whitespace-nowrap"
                                    x-text="ann.date"></span>
                            </div>
                            <p class="text-[11px] text-gray-500 font-medium leading-relaxed mb-4" x-text="ann.content"></p>
                            <div class="flex gap-2">
                                <span class="bg-blue-50 text-blue-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase"
                                    x-text="ann.type"></span>
                                <span
                                    class="bg-green-50 text-green-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase">New</span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-8 md:p-10 min-h-[60vh] sticky top-6">
                    <template x-for="ann in announcements">
                        <div x-show="activeAnnouncement === ann.id" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-x-4">
                            <h2 class="text-2xl font-extrabold text-[#0939a4] mb-2" x-text="ann.title"></h2>
                            <div class="flex items-center gap-2 mb-8">
                                <span class="text-xs text-gray-400 font-bold" x-text="'30 Nov 2025 • ' + ann.type"></span>
                            </div>

                            <div class="space-y-6">
                                <h3
                                    class="text-sm font-black text-[#0939a4] uppercase tracking-widest border-b border-gray-50 pb-2">
                                    Maintenance window</h3>
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
                </div>
            </div>

        </div>
    </div>
@endsection
