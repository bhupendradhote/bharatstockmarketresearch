  <!-- Header -->
  {{-- <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6">
      <div>
          @isset($header)
              {{ $header }}
          @else
              <h1 class="text-lg font-semibold text-slate-800">{{ $pageTitle ?? 'Dashboard' }}</h1>
              <p class="text-xs text-slate-500">Quick overview of your application</p>
          @endisset
      </div>
      <div class="flex items-center space-x-4">
          <div class="relative">
              <input type="text" placeholder="Search..."
                  class="pl-8 pr-3 py-1.5 text-sm border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
              <span class="absolute inset-y-0 left-2 flex items-center text-slate-400 text-xs">
                  🔍
              </span>
          </div>
          <div class="relative">
              <!-- 🔔 Bell -->
              <button id="notificationBell"
                  class="relative inline-flex items-center justify-center h-9 w-9 rounded-full bg-slate-100 text-slate-600">
                  🔔
                  <span id="notificationCount"
                      class="hidden absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-[10px] text-white rounded-full flex items-center justify-center">
                      0
                  </span>
              </button>

              <!-- 🔽 Dropdown -->
              <div id="notificationDropdown"
                  class="hidden absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-lg shadow-lg z-50">

                  <div class="px-4 py-2 border-b font-semibold text-sm">
                      Notifications
                  </div>

                  <div id="notificationList" class="max-h-72 overflow-y-auto">
                      <!-- notifications will be injected -->
                  </div>

                  <div class="border-t text-center text-xs py-2 text-blue-600 cursor-pointer">
                      View all
                  </div>
              </div>
          </div>

          <button class="flex items-center space-x-2">
              <div class="h-9 w-9 rounded-full bg-slate-200 flex items-center justify-center text-sm font-semibold">
                  AK
              </div>
              <div class="hidden md:block text-left">
                  <p class="text-xs font-semibold text-slate-800">{{ Auth::user()->name ?? 'Admin User' }}</p>
                  <p class="text-[11px] text-slate-500">{{ Auth::user()->email ?? 'admin@metawish.ai' }}</p>
              </div>
          </button>
      </div>
  </header> --}}


  <!-- Header -->
  <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6">
      <div>
          <h1 class="text-lg font-semibold text-slate-800">{{ $pageTitle ?? 'Dashboard' }}</h1>
          <p class="text-xs text-slate-500">Quick overview of your application</p>
      </div>

      <div class="flex items-center space-x-4">

          <!-- SEARCH -->
          <div class="relative">
              <input type="text" placeholder="Search..."
                  class="pl-8 pr-3 py-1.5 text-sm border border-slate-200 rounded-md focus:outline-none" />
              <span class="absolute inset-y-0 left-2 flex items-center text-slate-400 text-xs">🔍</span>
          </div>

          <!-- 🔔 NOTIFICATION -->
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
          <div class="flex items-center space-x-2">
              <div class="h-9 w-9 rounded-full bg-slate-200 flex items-center justify-center text-sm font-semibold">
                  {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
              </div>
              <div class="hidden md:block">
                  <p class="text-xs font-semibold">{{ Auth::user()->name }}</p>
                  <p class="text-[11px] text-slate-500">{{ Auth::user()->email }}</p>
              </div>
          </div>
      </div>
  </header>
  <script>
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
      // Pusher configuration
      Pusher.logToConsole = true; // Debug के लिए true रखें

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

      // Admin ID
      const adminId = {{ auth()->id() }};

      // Subscribe to admin's private channel
      const channel = pusher.subscribe('private-user.' + adminId);

      console.log('Subscribed to channel: private-user.' + adminId);

      // Listen for NOTIFICATION event
      channel.bind('user-chat-notification', function(data) {
          console.log('Notification received:', data);

          // Update notification count
          let badge = document.getElementById('notificationCount');
          let currentCount = parseInt(badge.innerText) || 0;
          currentCount++;

          badge.innerText = currentCount;
          badge.classList.remove('hidden');

          // Add animation
          badge.classList.add('animate-bounce');
          setTimeout(() => badge.classList.remove('animate-bounce'), 600);

          // Add notification to dropdown
          addNotificationToDropdown(data);
      });

      // Listen for MESSAGE event (if needed)
      channel.bind('user-chat-message', function(data) {
          console.log('Chat message received:', data);
          // This is for real-time chat messages
      });

      // Function to add notification to dropdown
      function addNotificationToDropdown(data) {
          const list = document.getElementById('notificationList');

          if (list) {
              const notificationHTML = `
                <div class="px-4 py-3 border-b hover:bg-slate-50 cursor-pointer"
                     onclick="openChatFromNotification(${data.fromUserId})">
                    <p class="text-sm font-medium">
                        New message from ${data.fromUserName}
                    </p>
                    <p class="text-xs text-slate-500 truncate">
                        ${data.message}
                    </p>
                </div>
            `;

              list.insertAdjacentHTML('afterbegin', notificationHTML);
          }
      }

      // Function to open chat from notification
      function openChatFromNotification(userId) {
          // Mark notifications as read
          fetch('/admin/notifications/mark-read', {
              method: 'POST',
              headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              }
          }).then(() => {
              // Update badge count
              document.getElementById('notificationCount').classList.add('hidden');
              document.getElementById('notificationCount').innerText = '0';

              // Redirect to chat
              window.location.href = '/admin/chat?user=' + userId;
          });
      }
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
