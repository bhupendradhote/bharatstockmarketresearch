<!-- Header -->
<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6">
    <div>
        <h1 class="text-lg font-semibold text-slate-800">{{ $pageTitle ?? 'Dashboard' }}</h1>
        <p class="text-xs text-slate-500">Quick overview of your application</p>
    </div>

    <div class="flex items-center space-x-4">
        <a href="/admin/tips"
            class="inline-flex items-center px-4 py-1.5 text-sm font-medium text-slate-600
                border border-slate-300 rounded-lg
                hover:bg-slate-100 hover:text-slate-900
                transition duration-200">
            Tips
        </a>

        <a href="/listUser"
            class="inline-flex items-center px-4 py-1.5 text-sm font-medium text-slate-600
                border border-slate-300 rounded-lg
                hover:bg-slate-100 hover:text-slate-900
                transition duration-200">
            Customers
        </a>


        <div class="relative w-64" id="global-search-wrapper">
            <div class="relative">
                <input type="text" id="admin-search-input" placeholder="Search pages..."
                    class="w-full pl-8 pr-3 py-1.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <span class="absolute inset-y-0 left-2 flex items-center text-slate-400 text-xs">🔍</span>
            </div>

            <div id="search-results"
                class="hidden absolute top-full left-0 w-full mt-2 bg-white border border-slate-200 rounded-lg shadow-xl z-50 max-h-60 overflow-y-auto">
            </div>
        </div>

        <!-- NOTIFICATION -->
        <div class="relative">
            <button id="notificationBell"
                class="relative inline-flex items-center justify-center h-9 w-9 rounded-full bg-slate-100 text-slate-600">
                🔔
                <span id="notificationCount"
                    class="hidden absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-[10px] text-white rounded-full flex items-center justify-center">
                </span>
            </button>

            <!-- DROPDOWN -->
            <div id="notificationDropdown"
                class="hidden absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-lg shadow-lg z-50">

                <div class="px-4 py-2 border-b font-semibold text-sm">Notifications</div>

                <div id="notificationList" class="max-h-72 overflow-y-auto"></div>

                <div class="border-t text-center text-xs py-2 text-blue-600">
                    View all
                </div>
            </div>
        </div>
        <!-- USER -->

        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center focus:outline-none hover:opacity-80 transition-opacity">
                <div
                    class="h-10 w-10 rounded-full border-2 border-slate-200 overflow-hidden flex items-center justify-center bg-slate-200 shadow-sm">
                    @if (Auth::user()->getFirstMediaUrl('profile_images'))
                        <img src="{{ Auth::user()->getFirstMediaUrl('profile_images') }}" alt="{{ Auth::user()->name }}"
                            class="h-full w-full object-cover">
                    @else
                        <span class="text-sm font-bold text-slate-600">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
            </button>

            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-2xl border border-slate-100 z-[100] overflow-hidden">

                <div class="px-4 py-3 bg-slate-50 border-b border-slate-100">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                </div>

                <div class="p-2 grid grid-cols-3 gap-1 border-b border-slate-100 bg-white">
                    <a href="{{ route('users.list') }}" title="Users"
                        class="flex flex-col items-center justify-center p-2 rounded-lg hover:bg-blue-50 text-slate-600 hover:text-blue-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </a>

                    <a href="#" title="Messages"
                        class="flex flex-col items-center justify-center p-2 rounded-lg hover:bg-green-50 text-slate-600 hover:text-green-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" id="dropdown-logout" class="m-0">
                        @csrf
                        <button type="submit" title="Logout"
                            class="w-full flex flex-col items-center justify-center p-2 rounded-lg hover:bg-red-50 text-slate-600 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>

                <a href="#"
                    class="block px-4 py-2 text-xs text-slate-600 hover:bg-slate-50 transition-colors">View Profile
                    Settings</a>
            </div>
        </div>
    </div>
</header>



{{-- <script>
    let notificationCount =
        {{ \App\Models\NotificationUser::where('user_id', auth()->id())->whereNull('read_at')->count() }};
</script>
<script>
    const badge = document.getElementById('notificationCount');
    if (notificationCount > 0) {
        badge.innerText = notificationCount;
        badge.classList.remove('hidden');
    }
</script>
<script>
    document.getElementById('notificationBell').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('notificationDropdown').classList.toggle('hidden');
    });

    document.addEventListener('click', function() {
        document.getElementById('notificationDropdown').classList.add('hidden');
    });
</script>
<script>
    fetch('/admin/notifications/latest')
        .then(res => res.json())
        .then(items => {
            items.forEach(item => {
                addNotificationToDropdown({
                    fromUserId: item.notification.data?.from_user_id,
                    fromUserName: item.notification.data?.from_user_name,
                    message: item.notification.message
                });
            });
        });
</script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>


<script>
    const adminId = {{ auth()->id() }};
    const badge = document.getElementById('notificationCount');
    const list = document.getElementById('notificationList');

    let unreadCount = 0;

    /* ===============================
       🔔 BADGE UPDATE
    =============================== */
    function updateBadge() {
        if (unreadCount > 0) {
            badge.innerText = unreadCount;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    /* ===============================
       📥 RENDER NOTIFICATION
    =============================== */
    function addNotification(n) {

        const chatUser = n.data?.from_user_name || 'User';

        const html = `
        <div class="px-4 py-3 border-b hover:bg-slate-50 cursor-pointer"
             onclick="handleAdminNotification('${n.type}', ${n.data?.chat_id || 0}, ${n.data?.from_user_id || 0})">

            <p class="text-sm font-semibold">
                ${n.title}
            </p>

            <p class="text-xs text-slate-500 truncate">
                ${n.message}
            </p>
        </div>
    `;

        list.insertAdjacentHTML('afterbegin', html);

        unreadCount++;
        updateBadge();
    }

    /* ===============================
       🎯 CLICK ACTION
    =============================== */
    function handleAdminNotification(type, chatId, userId) {

        if (type === 'chat') {
            window.location.href = '/admin/chat?user=' + userId;
        }

        unreadCount = 0;
        updateBadge();
    }

    /* ===============================
       📡 LOAD OLD NOTIFICATIONS
    =============================== */
    fetch('/admin/notifications/latest')
        .then(r => r.json())
        .then(res => {

            list.innerHTML = '';
            unreadCount = 0;

            res.notifications.forEach(n => {
                addNotification(n);
            });
        });

    /* ===============================
       ⚡ REALTIME PUSHER
    =============================== */

    const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });

    /* 🎯 ADMIN PRIVATE CHANNEL */
    const adminChannel = pusher.subscribe('user.' + adminId);

    adminChannel.bind('master.notification', function(data) {

        console.log('🔥 Realtime admin:', data);

        if (!['chat', 'ticket', 'login', 'warning', 'subscription', 'disaster'].includes(data.type)) {
            return;
        }

        addNotification(data);
    });

    /* 🌍 GLOBAL CHANNEL (optional) */
    const globalChannel = pusher.subscribe('public-notifications');

    globalChannel.bind('master.notification', function(data) {

        if (data.is_global) {
            addNotification(data);
        }
    });
</script> --}}

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    const adminId = {{ auth()->id() }};
    const badge = document.getElementById('notificationCount');
    const list = document.getElementById('notificationList');
    const dropdown = document.getElementById('notificationDropdown');

    let unreadCount = 0;

    /* ===============================
       🔔 BADGE HANDLER
    =============================== */
    function updateBadge() {
        if (unreadCount > 0) {
            badge.innerText = unreadCount;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    /* ===============================
       📥 RENDER ONE NOTIFICATION
    =============================== */
    function renderNotification(n) {

        const html = `
        <div class="px-4 py-3 border-b hover:bg-slate-50 cursor-pointer"
             onclick="openAdminNotification('${n.type}', ${n.data?.chat_id || 0}, ${n.data?.from_user_id || 0})">

            <p class="text-sm font-semibold">
                ${n.title}
            </p>

            <p class="text-xs text-slate-500 truncate">
                ${n.message}
            </p>
        </div>
    `;

        list.insertAdjacentHTML('afterbegin', html);

        unreadCount++;
        updateBadge();
    }

    /* ===============================
       🎯 CLICK ACTION
    =============================== */

    function openAdminNotification(type, chatId, userId) {

        // 💬 CHAT
        if (type === 'chat') {
            window.location.href = '/admin/chat?user=' + userId;
            return;
        }

        // 🎫 TICKET
        if (type === 'ticket') {
            window.location.href = '/admin/tickets';
            return;
        }

        // 📦 Future types ready
        if (type === 'subscription') {
            window.location.href = '/admin/subscriptions';
            return;
        }

        if (type === 'warning') {
            window.location.href = '/admin/warnings';
            return;
        }

        if (type === 'login') {
            window.location.href = '/admin/logs';
            return;
        }
    }

    /* ===============================
       📡 LOAD ALL NOTIFICATIONS
    =============================== */
    function loadAdminNotifications() {

        fetch('/admin/notifications/latest')
            .then(r => r.json())
            .then(res => {

                console.log('Loaded notifications:', res);

                list.innerHTML = '';
                unreadCount = 0;

                res.notifications.forEach(n => {
                    renderNotification(n);
                });
            })
            .catch(err => console.error('Load error:', err));
    }

    /* ===============================
       🔔 BELL TOGGLE + REFRESH
    =============================== */
    document.getElementById('notificationBell').addEventListener('click', function(e) {
        e.stopPropagation();

        dropdown.classList.toggle('hidden');
        loadAdminNotifications(); // refresh every open
    });

    document.addEventListener('click', function() {
        dropdown.classList.add('hidden');
    });

    /* ===============================
       ⚡ PUSHER REALTIME
    =============================== */
    const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
        forceTLS: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });

    /* 🎯 ADMIN PRIVATE CHANNEL */
    const adminChannel = pusher.subscribe('user.' + adminId);

    adminChannel.bind('master.notification', function(data) {

        console.log('🔥 Realtime:', data);

        if (!['chat', 'ticket', 'login', 'warning', 'subscription', 'disaster'].includes(data.type)) {
            return;
        }

        renderNotification(data);
    });

    /* 🌍 GLOBAL CHANNEL (optional) */
    const globalChannel = pusher.subscribe('public-notifications');

    globalChannel.bind('master.notification', function(data) {
        if (data.is_global) {
            renderNotification(data);
        }
    });

    /* ===============================
       🚀 INITIAL LOAD
    =============================== */
    loadAdminNotifications();
</script>



<script>
    function openChatFromNotification(userId) {

        fetch('/admin/notifications/mark-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        window.location.href = '/admin/chat?user=' + userId;
    }
</script>

{{-- For Global Search... --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Database of all sidebar links
        const searchIndex = [{
                name: 'Dashboard',
                url: "{{ route('dashboard') }}",
                category: 'Main'
            },
            {
                name: 'Tips Management',
                url: "{{ route('admin.tips.index') }}",
                category: 'Tips'
            },
            {
                name: 'Tips Categories',
                url: "{{ route('admin.tips-categories.index') }}",
                category: 'Tips'
            },
            {
                name: 'Tips Price Calculation Master',
                url: "{{ route('admin.risk-reward.index') }}",
                category: 'Tips'
            },
            {
                name: 'Equity Tips',
                url: "{{ route('admin.tips.create') }}",
                category: 'Tips'
            },
            {
                name: 'Future & Options Tips',
                url: "{{ route('admin.tips.future_Option') }}",
                category: 'Tips'
            },
            {
                name: 'Blogs List',
                url: "{{ route('admin.blogs.index') }}",
                category: 'News & Blogs'
            },
            {
                name: 'Blogs Categories',
                url: "{{ route('admin.blog-categories.index') }}",
                category: 'News & Blogs'
            },
            {
                name: 'News Updates',
                url: "{{ route('admin.news.index') }}",
                category: 'News & Blogs'
            },
            {
                name: 'News Categories',
                url: "{{ route('admin.news.categories') }}",
                category: 'News & Blogs'
            },
            {
                name: 'Header Menus',
                url: "{{ route('admin.header-menus.index') }}",
                category: 'Site Settings'
            },
            {
                name: 'Contact Details',
                url: "{{ route('admin.contact.index') }}",
                category: 'Site Settings'
            },
            {
                name: 'Footer Config',
                url: "{{ route('admin.footer.index') }}",
                category: 'Site Settings'
            },
            {
                name: 'Hero Banners',
                url: "{{ route('admin.hero-banners.index') }}",
                category: 'Banners'
            },
            {
                name: 'Offer Banners',
                url: "{{ route('admin.offer-banners.index') }}",
                category: 'Banners'
            },
            {
                name: 'Pop-up Notifications',
                url: "{{ route('admin.popups.index') }}",
                category: 'Banners'
            },
            {
                name: 'Message Campaigns',
                url: "{{ route('admin.message-campaigns.index') }}",
                category: 'Banners'
            },
            {
                name: 'Disclaimer / Marquees',
                url: "{{ route('admin.marquees.index') }}",
                category: 'Legal'
            },
            {
                name: 'FAQ',
                url: "{{ route('admin.faq.index') }}",
                category: 'Support'
            },
            {
                name: 'Policies',
                url: "{{ url('admin/policies') }}",
                category: 'Legal'
            },
            {
                name: 'Service Plans',
                url: "{{ route('admin.service-plans.index') }}",
                category: 'Services'
            },
            {
                name: 'Home Counters',
                url: "{{ route('admin.home.index') }}",
                category: 'Home Content'
            },
            {
                name: 'Why Choose Us',
                url: "{{ route('admin.why-choose.index') }}",
                category: 'Home Content'
            },
            {
                name: 'Mission',
                url: "{{ route('admin.about.mission.index') }}",
                category: 'About'
            },
            {
                name: 'Users List',
                url: "{{ route('users.list') }}",
                category: 'Management'
            },
            {
                name: 'Roles',
                url: "{{ route('roles.index') }}",
                category: 'Management'
            },
            {
                name: 'Permissions',
                url: "{{ route('permissions.index') }}",
                category: 'Management'
            },
            {
                name: 'Reviews',
                url: "{{ route('admin.reviews.index') }}",
                category: 'Management'
            },
        ];

        const input = document.getElementById('admin-search-input');
        const resultsContainer = document.getElementById('search-results');

        input.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            resultsContainer.innerHTML = '';

            if (query.length < 1) {
                resultsContainer.classList.add('hidden');
                return;
            }

            // Filter links
            const filtered = searchIndex.filter(item =>
                item.name.toLowerCase().includes(query) ||
                item.category.toLowerCase().includes(query)
            );

            if (filtered.length > 0) {
                filtered.forEach(item => {
                    const div = document.createElement('a');
                    div.href = item.url;
                    div.className =
                        "block px-4 py-2 hover:bg-slate-50 border-b border-slate-100 last:border-0 transition-colors";
                    div.innerHTML = `
                    <div class="text-xs text-blue-600 font-semibold uppercase">${item.category}</div>
                    <div class="text-sm text-slate-800">${item.name}</div>
                `;
                    resultsContainer.appendChild(div);
                });
                resultsContainer.classList.remove('hidden');
            } else {
                resultsContainer.innerHTML =
                    `<div class="p-4 text-sm text-slate-500">No pages found...</div>`;
                resultsContainer.classList.remove('hidden');
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!document.getElementById('global-search-wrapper').contains(e.target)) {
                resultsContainer.classList.add('hidden');
            }
        });
    });
</script>
