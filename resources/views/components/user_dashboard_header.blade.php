<header class="w-full px-6 py-4 bg-white border-b relative z-30">
    <div class="flex items-center justify-between gap-4">

        <div class="flex-1 max-w-xl relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                🔍
            </span>
            <input
                type="text"
                placeholder="Search using stock name..."
                class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200
                text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
            />
        </div>

        <div class="flex items-center gap-4">

            <a href="/" class="w-10 h-10 flex items-center justify-center rounded-full
                border border-gray-200 hover:bg-gray-100 transition">
                🏠
            </a>

            <button
                id="openNotification"
                class="relative w-10 h-10 flex items-center justify-center rounded-full
                border border-gray-200 hover:bg-gray-100 transition">
                🔔
                <span id="notificationBadge" class="hidden absolute top-0 right-0 w-4 h-4 bg-red-500 text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white">
                    0
                </span>
            </button>

            <div class="flex items-center gap-2 px-3 py-1.5 rounded-full
                border border-gray-200 hover:bg-gray-50 cursor-pointer transition">
                <img
                    src="{{ auth()->user()->getFirstMediaUrl('profile_image') ?: 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . auth()->user()->id }}"
                    alt="{{ auth()->user()->name }}"
                    class="w-8 h-8 rounded-full object-cover"
                />
                <span class="text-sm font-medium text-gray-700 whitespace-nowrap">
                    {{ Auth::user()->name }}
                </span>
            </div>
        </div>
    </div>
</header>

<div
    id="notificationBackdrop"
    class="fixed inset-0 bg-black/40 opacity-0 pointer-events-none transition-opacity duration-300 z-40">
</div>

<div
    id="notificationPanel"
    class="fixed top-0 right-0 h-full w-[380px] max-w-full bg-white shadow-xl
    translate-x-full transition-transform duration-300 ease-in-out z-50 flex flex-col">

    <div class="flex items-center justify-between px-5 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">
            Notifications
            <span id="panelCount" class="ml-2 text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full hidden">0</span>
        </h3>
        <button
            id="closeNotification"
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
        <a href="/notifications"
           class="block text-center text-sm font-medium text-blue-600 hover:underline">
            View all notifications
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- Configuration ---
    // Ensure you have these routes defined in web.php
    const API_URL = "/notifications/fetch"; 
    const READ_URL = "/notifications/read/";

    // --- Elements ---
    const openBtn = document.getElementById('openNotification');
    const closeBtn = document.getElementById('closeNotification');
    const panel = document.getElementById('notificationPanel');
    const backdrop = document.getElementById('notificationBackdrop');
    const badge = document.getElementById('notificationBadge');
    const panelCount = document.getElementById('panelCount');
    const listContainer = document.getElementById('notificationList');

    // --- Toggle Logic ---
    function openNotification() {
        panel.classList.remove('translate-x-full');
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.classList.add('opacity-100');
        // Fetch data every time panel opens to get latest
        fetchNotifications();
    }

    function closeNotification() {
        panel.classList.add('translate-x-full');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        backdrop.classList.remove('opacity-100');
    }

    openBtn.addEventListener('click', openNotification);
    closeBtn.addEventListener('click', closeNotification);
    backdrop.addEventListener('click', closeNotification);

    // --- API Logic ---
    function fetchNotifications() {
        fetch(API_URL)
            .then(response => response.json())
            .then(data => {
                updateBadge(data.count);
                renderList(data.notifications);
            })
            .catch(error => {
                console.error('Error:', error);
                listContainer.innerHTML = '<div class="p-5 text-center text-red-500 text-sm">Failed to load</div>';
            });
    }

    function updateBadge(count) {
        if (count > 0) {
            badge.innerText = count > 99 ? '99+' : count;
            badge.classList.remove('hidden');
            
            panelCount.innerText = count + ' New';
            panelCount.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
            panelCount.classList.add('hidden');
        }
    }

    function renderList(notifications) {
        if (notifications.length === 0) {
            listContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center h-48 text-gray-400">
                    <span class="text-2xl mb-2">📭</span>
                    <p class="text-sm">No new notifications</p>
                </div>`;
            return;
        }

        let html = '';
        notifications.forEach(notif => {
            // Determine styles based on read/unread status
            const isUnread = notif.read_at === null;
            const bgClass = isUnread ? 'bg-blue-50/60 border-l-4 border-blue-500' : 'bg-white hover:bg-gray-50 border-l-4 border-transparent';
            const titleWeight = isUnread ? 'font-semibold text-gray-900' : 'font-medium text-gray-700';
            const icon = getIcon(notif.type);

            html += `
                <div onclick="handleRead(${notif.tracking_id}, '${notif.url}')" 
                     class="px-5 py-4 border-b cursor-pointer transition ${bgClass} group">
                    <div class="flex gap-3">
                        <div class="mt-0.5 text-lg">${icon}</div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <p class="text-sm ${titleWeight}">
                                    ${notif.title}
                                </p>
                                <span class="text-[10px] text-gray-400 whitespace-nowrap ml-2">
                                    ${timeAgo(notif.created_at)}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                ${notif.message}
                            </p>
                        </div>
                    </div>
                </div>
            `;
        });
        listContainer.innerHTML = html;
    }

    // --- Helpers ---

    // 1. Icon mapper based on 'type' column
    function getIcon(type) {
        if (type === 'chat') return '💬';
        if (type === 'alert') return '🚀';
        if (type === 'warning') return '⚠️';
        return '🔔'; // Default
    }

    // 2. Click Handler (Mark as read + Redirect)
    window.handleRead = function(id, url) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        fetch(READ_URL + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        // Redirect if URL exists
        if (url && url !== 'null' && url !== '') {
            window.location.href = url;
        }
    };

    // 3. Time Ago Formatter
    function timeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        
        let interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + "y";
        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + "mo";
        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + "d";
        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + "h";
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + "m";
        return "now";
    }

    // Load on page load
    fetchNotifications();
});
</script>