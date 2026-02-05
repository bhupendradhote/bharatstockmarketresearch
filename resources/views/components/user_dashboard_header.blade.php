<header class="w-full px-6 py-4 bg-white border-b relative z-30">
    <div class="flex items-center justify-between gap-4">

        <div class="flex-1 max-w-xl relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                🔍
            </span>
            <input type="text" placeholder="Search using stock name..."
                class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200
                text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50" />
        </div>

        <div class="flex items-center gap-4">

            <a href="/"
                class="w-10 h-10 flex items-center justify-center rounded-full
                border border-gray-200 hover:bg-gray-100 transition">
                🏠
            </a>

            <button id="openNotification"
                class="relative w-10 h-10 flex items-center justify-center rounded-full
                border border-gray-200 hover:bg-gray-100 transition">
                🔔
                <span id="notificationBadge"
                    class="hidden absolute top-0 right-0 w-4 h-4 bg-red-500 text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white">
                    0
                </span>
            </button>

            <div
                class="flex items-center gap-2 px-3 py-1.5 rounded-full
                border border-gray-200 hover:bg-gray-50 cursor-pointer transition">
                <img src="{{ auth()->user()->getFirstMediaUrl('profile_image') ?: 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . auth()->user()->id }}"
                    alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover" />
                <span class="text-sm font-medium text-gray-700 whitespace-nowrap">
                    {{ Auth::user()->name }}
                </span>
            </div>
        </div>
    </div>
</header>

<div id="notificationBackdrop"
    class="fixed inset-0 bg-black/40 opacity-0 pointer-events-none transition-opacity duration-300 z-40">
</div>

<div id="notificationPanel"
    class="fixed top-0 right-0 h-full w-[380px] max-w-full bg-white shadow-xl
    translate-x-full transition-transform duration-300 ease-in-out z-50 flex flex-col">

    <div class="flex items-center justify-between px-5 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">
            Notifications
            <span id="panelCount"
                class="ml-2 text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full hidden">0</span>
        </h3>
        <button id="closeNotification"
            class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
            ✕
        </button>
    </div>

    <div id="notificationList" class="flex-1 overflow-y-auto">
        <div class="flex flex-col items-center justify-center h-40 text-gray-400">
            <span class="animate-pulse">Loading...</span>
        </div>
    </div>

    <div class="p-4 border-t bg-gray-50">
        <a href="#" id="markAllNotifications"
            class="block text-center text-sm font-medium text-blue-600 hover:underline">
            Clear all notifications
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ================= CONFIG ================= */
        const API_URL = "/announcements/fetch"; // unseen announcements
        const READ_URL = "/announcements/read/"; // mark seen

        /* ================= ELEMENTS ================= */
        const openBtn = document.getElementById('openNotification');
        const closeBtn = document.getElementById('closeNotification');
        const panel = document.getElementById('notificationPanel');
        const backdrop = document.getElementById('notificationBackdrop');
        const badge = document.getElementById('notificationBadge');
        const panelCount = document.getElementById('panelCount');
        const listContainer = document.getElementById('notificationList');

        /* ================= TOGGLE ================= */
        function openNotification() {
            panel.classList.remove('translate-x-full');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100');
            fetchNotifications();
        }

        function closeNotification() {
            panel.classList.add('translate-x-full');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            backdrop.classList.remove('opacity-100');
        }

        openBtn.onclick = openNotification;
        closeBtn.onclick = closeNotification;
        backdrop.onclick = closeNotification;

        /* ================= FETCH ================= */


        function fetchNotifications() {

            fetch('/announcements/fetch')
                .then(r => r.json())
                .then(data => {

                    const notifications = data.notifications;

                    updateBadge(data.count);
                    renderList(notifications);

                })
                .catch(() => {
                    listContainer.innerHTML = `
                <div class="p-5 text-center text-red-500 text-sm">
                    Failed to load
                </div>`;
                });
        }

        function updateBadge(count) {
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.classList.remove('hidden');
                panelCount.textContent = count + " New";
                panelCount.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
                panelCount.classList.add('hidden');
            }
        }

        /* ================= RENDER ================= */
        function renderList(notifications) {

            if (!notifications.length) {
                listContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center h-48 text-gray-400">
                    <span class="text-2xl mb-2">📭</span>
                    <p class="text-sm">No new notifications</p>
                </div>`;
                return;
            }

            listContainer.innerHTML = notifications.map(n => {

                // 🎯 Icon logic
                // const icon = n.type === 'announcement' ? '📢' : '💬';
                const iconMap = {
                    chat: '💬',
                    tip: '💡',
                    popup: '🪟',
                    announcement: '📢',
                    subscription: '💳',
                    campaign: '📣',
                    system: '⚙️',
                    disaster: '🚨',
                    login: '🔐',
                    warning: '⚠️',
                    success: '✅',
                    ticket: '🎫',
                };

                const icon = iconMap[n.type] || '🔔';

                return `
                    <div class="group px-5 py-4 border-b cursor-pointer transition
                        bg-blue-50/60 border-l-4 border-blue-500 hover:bg-blue-100
                        flex justify-between items-start">

                        <div onclick="handleRead(${n.tracking_id}, '${n.url}')" 
                            class="flex gap-3 flex-1">

                            <div class="mt-0.5 text-lg">${icon}</div>

                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <p class="text-sm font-semibold text-gray-900">
                                        ${n.title}
                                    </p>
                                    <span class="text-[10px] text-gray-400 ml-2">
                                        ${timeAgo(n.created_at)}
                                    </span>
                                </div>

                                <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                                    ${n.message}
                                </p>
                            </div>
                        </div>

                        <!-- 🗑 HOVER DELETE -->
                        <button onclick="deleteNotification(${n.tracking_id}, event)"
                            class="ml-3 text-red-500 hover:text-red-700 text-sm
                                opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            🗑️
                        </button>
                    </div>
                    `;
            }).join('');
        }

        /* ================= CLICK ================= */
        window.handleRead = function(id, url) {

            const token = document.querySelector('meta[name="csrf-token"]').content;

            fetch(READ_URL + id, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token
                }
            });

            window.location.href = url;
        };

        /* ================= TIME ================= */
        function timeAgo(date) {
            const seconds = Math.floor((new Date() - new Date(date)) / 1000);
            const map = [
                [31536000, 'y'],
                [2592000, 'mo'],
                [86400, 'd'],
                [3600, 'h'],
                [60, 'm']
            ];
            for (let [s, l] of map)
                if (seconds >= s) return Math.floor(seconds / s) + l;
            return "now";
        }

        /* ================== DELETE NOTIFICATION ============== */
        window.deleteNotification = function(id, e) {
            e.stopPropagation();

            const token = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/notifications/delete/${id}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token
                }
            }).then(() => fetchNotifications());
        };


        /* ================= MARK ALL NOTIFICATIONS ================= */
        document.getElementById('markAllNotifications').onclick = function(e) {
            e.preventDefault();

            const token = document.querySelector('meta[name="csrf-token"]').content;

            fetch('/notifications/mark-all', {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token
                }
            }).then(() => {
                listContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-48 text-gray-400">
                        <span class="text-2xl mb-2">📭</span>
                        <p class="text-sm">No new notifications</p>
                    </div>
                `;

                badge.classList.add('hidden');
                panelCount.classList.add('hidden');
            });
        };
        /* ================= REALTIME ================= */

        Echo.channel('public-notifications')
            .listen('.master.notification', (data) => {
                console.log('Realtime received:', data);
                fetchNotifications(); // refresh panel
            });

        fetchNotifications();
    });
</script>
