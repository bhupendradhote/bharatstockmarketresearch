<aside class="w-64 bg-[#0b3186] text-slate-100 flex flex-col transition-all duration-300 ease-in-out" id="main-sidebar">
    <div class="h-16 flex items-center justify-between px-4 border-b border-slate-800">
        <span class="text-lg font-semibold admin-name">Metawish Admin</span>
        <button id="sidebar-toggle" class="p-1 rounded-lg hover:bg-[#0b3186] transition-colors duration-200 text-sm"
            title="Toggle Sidebar">
            ←
        </button>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <a href="{{ route('dashboard') }}"
            class="flex items-center px-3 py-2 rounded-md bg-[#3463c8] text-white text-sm font-medium group">
            <span class="inline-block h-2 w-2 rounded-full bg-emerald-400 mr-2 flex-shrink-0"></span>
            <span class="sidebar-text">Dashboard</span>
        </a>

        <a href="{{ route('admin.tips.index') }}"
            class="flex items-center px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group">
            <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
            </span>
            <span class="sidebar-text">Tips</span>
        </a>

        {{-- NEW ANNOUNCEMENTS DROPDOWN --}}
        <div class="dropdown-container" data-dropdown-id="announcements" x-data="{ open: {{ request()->routeIs('admin.announcements.*') ? 'true' : 'false' }} }">
            <button @click="open = !open; toggleDropdown('announcements-menu')"
                class="flex items-center justify-between w-full px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group dropdown-btn">
                <div class="flex items-center">
                    <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </span>
                    <span class="sidebar-text">Announcements</span>
                </div>
                <span class="arrow-icon transition-transform duration-300" :class="{ 'rotate-180': open }">▼</span>
            </button>

            <div id="announcements-menu"
                class="dropdown-content {{ request()->routeIs('admin.announcements.*') ? '' : 'hidden' }} pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.announcements.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text {{ request()->routeIs('admin.announcements.index') ? 'bg-[#3463c8] text-white' : '' }}">
                    All Announcements
                </a>
                <a href="{{ route('admin.announcements.create') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text {{ request()->routeIs('admin.announcements.create') ? 'bg-[#3463c8] text-white' : '' }}">
                    Add New
                </a>
            </div>
        </div>

        <div class="dropdown-container" data-dropdown-id="news-blogs" x-data="{ open: false }">
            <button @click="open = !open; toggleDropdown('news-blogs-menu')"
                class="flex items-center justify-between w-full px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group dropdown-btn">
                <div class="flex items-center">
                    <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 4v4h4" />
                        </svg>
                    </span>
                    <span class="sidebar-text">News & Blogs</span>
                </div>
                <span class="arrow-icon transition-transform duration-300" :class="{ 'rotate-180': open }">▼</span>
            </button>

            <div id="news-blogs-menu" class="dropdown-content hidden pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.blogs.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    Blogs List
                </a>
                <a href="{{ route('admin.news.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    News Updates
                </a>
            </div>
        </div>

        <div class="dropdown-container" data-dropdown-id="site-settings" x-data="{ open: false }">
            <button @click="open = !open; toggleDropdown('site-settings-menu')"
                class="flex items-center justify-between w-full px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group dropdown-btn">
                <div class="flex items-center">
                    <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <span class="sidebar-text">Site Settings</span>
                </div>
                <span class="arrow-icon transition-transform duration-300" :class="{ 'rotate-180': open }">▼</span>
            </button>

            <div id="site-settings-menu" class="dropdown-content hidden pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.header-menus.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    Header Menus
                </a>
                <a href="{{ route('admin.contact.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    Contact Details
                </a>
                <a href="{{ route('admin.footer.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    Footer Config
                </a>
            </div>
        </div>

        <div class="dropdown-container" data-dropdown-id="banners-ads" x-data="{ open: false }">
            <button @click="open = !open; toggleDropdown('banners-ads-menu')"
                class="flex items-center justify-between w-full px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group dropdown-btn">
                <div class="flex items-center">
                    <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </span>
                    <span class="sidebar-text">Banners & Ads</span>
                </div>
                <span class="arrow-icon transition-transform duration-300" :class="{ 'rotate-180': open }">▼</span>
            </button>

            <div id="banners-ads-menu" class="dropdown-content hidden pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.hero-banners.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    Hero Banners
                </a>
                <a href="{{ route('admin.offer-banners.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    Offer Banners
                </a>
                <a href="{{ route('admin.popups.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    Pop-up Notifications
                </a>
                <a href="{{ route('admin.message-campaigns.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    Message Campaigns
                </a>
            </div>
        </div>

        <div class="dropdown-container">
            <a href="{{ route('admin.marquees.index') }}"
                class="flex items-center px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group">
                <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </span>
                <span class="sidebar-text">Disclaimer</span>
            </a>
        </div>


        <a href="{{ route('users.list') }}"
            class="flex items-center px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group">
            <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </span>
            <span class="sidebar-text">Customers</span>
        </a>
        <a href="{{ route('admin.faq.index') }}"
            class="flex items-center px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group">
            <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.44.011m1 15h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <span class="sidebar-text">FAQ</span>
        </a>

        <a href="{{ url('admin/policies') }}"
            class="flex items-center px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group">
            <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </span>
            <span class="sidebar-text">Policies</span>
        </a>

        <div class="dropdown-container" data-dropdown-id="services" x-data="{ open: false }">
            <button @click="open = !open; toggleDropdown('services-menu')"
                class="flex items-center justify-between w-full px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group dropdown-btn">
                <div class="flex items-center">
                    <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span class="sidebar-text">Services</span>
                </div>
                <span class="arrow-icon transition-transform duration-300" :class="{ 'rotate-180': open }">▼</span>
            </button>

            <div id="services-menu" class="dropdown-content hidden pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.service-plans.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    Service Plans
                </a>
                <a href="{{ url('admin/demo-subscriptions') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">
                    Demo Subcription
                </a>
            </div>
        </div>

        <div class="dropdown-container" data-dropdown-id="home" x-data="{ open: false }">
            <button @click="open = !open; toggleDropdown('home-menu')"
                class="flex items-center justify-between w-full px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group dropdown-btn">
                <div class="flex items-center">
                    <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </span>
                    <span class="sidebar-text">Home</span>
                </div>
                <span class="arrow-icon transition-transform duration-300" :class="{ 'rotate-180': open }">▼</span>
            </button>
            <div id="home-menu" class="dropdown-content hidden pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.home.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Home
                    Counters</a>
                <a href="{{ route('admin.why-choose.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Why
                    Choose Us</a>
                <a href="{{ route('admin.how-it-works.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">How It
                    Works</a>
                <a href="{{ route('admin.home.key-features.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Key
                    Features</a>
                <a href="{{ route('admin.home.download-app.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Download
                    App Section</a>
            </div>
        </div>

        <div class="dropdown-container" data-dropdown-id="about" x-data="{ open: false }">
            <button @click="open = !open; toggleDropdown('about-menu')"
                class="flex items-center justify-between w-full px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group dropdown-btn">
                <div class="flex items-center">
                    <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <span class="sidebar-text">About</span>
                </div>
                <span class="arrow-icon transition-transform duration-300" :class="{ 'rotate-180': open }">▼</span>
            </button>
            <div id="about-menu" class="dropdown-content hidden pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.about.mission.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Mission</a>
                <a href="{{ route('admin.about.core-values.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Core
                    Values</a>
                <a href="{{ route('admin.about.why-platform.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Why
                    Platform</a>
            </div>
        </div>

        <div class="dropdown-container" data-dropdown-id="management" x-data="{ open: false }">
            <button @click="open = !open; toggleDropdown('management-menu')"
                class="flex items-center justify-between w-full px-3 py-2 rounded-md hover:bg-[#3463c8] text-sm text-slate-200 group dropdown-btn">
                <div class="flex items-center">
                    <span class="w-4 h-4 mr-2 flex-shrink-0 text-slate-400 group-hover:text-white">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                    <span class="sidebar-text">Management</span>
                </div>
                <span class="arrow-icon transition-transform duration-300" :class="{ 'rotate-180': open }">▼</span>
            </button>
            <div id="management-menu" class="dropdown-content hidden pl-8 mt-1 space-y-1">
                <a href="{{ url('admin/employees') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Employees</a>
                <a href="{{ route('roles.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Roles</a>
                <a href="{{ route('permissions.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Permissions</a>
                <a href="{{ route('admin.reviews.index') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Reviews</a>
                <a href="{{ url('admin/tickets') }}"
                    class="block px-3 py-2 text-sm text-slate-300 rounded-md hover:bg-[#3463c8] sidebar-text">Tickets</a>
            </div>
        </div>
    </nav>
</aside>

<style>
    .sidebar-text {
        transition: opacity 0.3s ease;
        white-space: nowrap;
        overflow: hidden;
    }

    .dropdown-content {
        transition: all 0.3s ease;
        max-height: 0;
        overflow: hidden;
    }

    .dropdown-content:not(.hidden) {
        max-height: 500px;
    }

    .arrow-icon {
        transition: transform 0.3s ease;
        font-size: 10px;
    }

    aside.w-16 nav a,
    aside.w-16 .dropdown-container button {
        justify-content: center;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    aside.w-16 nav a span:first-child,
    aside.w-16 .dropdown-container button span:first-child {
        margin-right: 0;
    }

    aside,
    .sidebar-text,
    .dropdown-content {
        transition: all 0.3s ease-in-out;
    }

    .dropdown-btn:hover {
        background-color: #3463c8;
    }
</style>
