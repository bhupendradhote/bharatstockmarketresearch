<!DOCTYPE html>
<html x-data="{
    mobileMenuOpen: false,
    animatedSections: [],
    floating: true
}" x-init="setInterval(() => { floating = !floating }, 3000);" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Metawish Admin') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!--<link rel="icon" type="image/svg+xml" href="/favicon.svg">-->
    <link rel="icon" type="image/svg+xml" href="{{ asset('/storage/favicon/icon.svg') }}">



    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/testimonial.css') }}">
    <script src="{{ asset('assets/js/animation.js') }}"></script>
    <script src="{{ asset('assets/js/testimonial.js') }}"></script>
    <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .offer-pop-cont h3 {
            text-align: justify !important;
        }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</head>

<body class="bg-white" :class="{ 'menu-open': mobileMenuOpen }">
    <div x-data="{
        showExpiry: false,
        expiryMsg: '',
        storageKey: 'last_expiry_shown_{{ auth()->id() }}',
    
        init() {
            // 1. Listen for Real-time Pusher events
            window.addEventListener('plan-expiring-alert', (e) => {
                if (this.canShowAlert()) {
                    this.expiryMsg = e.detail.message;
                    this.triggerShow();
                }
            });
    
            // 2. Page Load Check (Session based)
            @if(session('plan_expiring_days') !== null)
            if (this.canShowAlert()) {
                let days = {{ session('plan_expiring_days') }};
                this.expiryMsg = (days == 0) ? 'Alert: Your plan expires today!' : 'Alert: Your plan expires in ' + days + ' day(s)!';
                this.triggerShow();
            }
            @endif
        },
    
        canShowAlert() {
            const lastShown = localStorage.getItem(this.storageKey);
            if (!lastShown) return true;
    
            const now = new Date().getTime();
            const twentyFourHours = 24 * 60 * 60 * 1000; // 24 hours in milliseconds
    
            // Check agar abhi ka time last shown time se 24 hours zyada hai
            return (now - lastShown) > twentyFourHours;
        },
    
        triggerShow() {
            this.showExpiry = true;
            // Store current timestamp as last shown
            localStorage.setItem(this.storageKey, new Date().getTime());
    
            // Auto hide after 15 seconds
            setTimeout(() => { this.showExpiry = false; }, 15000);
        }
    }" x-show="showExpiry" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        class="fixed bottom-10 right-10 z-[100] max-w-sm w-full" style="display: none;">

        <div
            class="bg-white border-l-4 border-red-600 shadow-2xl rounded-2xl p-4 flex items-start gap-4 ring-1 ring-black/5">
            <div class="bg-red-50 p-2 rounded-full">
                <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-gray-900">Subscription Alert!</h3>
                <p class="text-xs text-gray-600 mt-1 font-medium" x-text="expiryMsg"></p>
                <div class="mt-3">
                    <a href="{{ url('/settings') }}"
                        class="text-[11px] font-black text-red-600 uppercase tracking-tighter hover:underline">
                        Renew Now →
                    </a>
                </div>
            </div>
            <button @click="showExpiry = false" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
    <div class="min-h-screen flex">

        <div class="flex-1 flex flex-col">
            {{-- @include('components.user_header') --}}
            @php
                $header = \App\Http\Controllers\HeaderController::data();

                // ✅ Only menus with valid link & active
                $menus = collect($header['menus'])
                    ->filter(function ($menu) {
                        return !empty($menu->link) && $menu->show_in_header;
                    })
                    ->values();
            @endphp


            @include('components.user_header', [
                'settings' => $header['settings'],
                'menus' => $menus,
            ])



            <main>
                @yield('content')
            </main>



            <!-- ================= CHAT FLOATING BUTTON ================= -->
            <div class="fixed bottom-6 right-6 z-50" x-data="{ open: false }" x-cloak x-init="open = false">

                <!-- Floating Actions -->
                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-10 scale-90"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-10 scale-90"
                    class="flex flex-col gap-4 mb-4 items-center" @click.away="open = false">

                    <!-- Review -->
                    <a href="{{ url('/reviews') }}"
                        class="w-12 h-12 rounded-full bg-orange-500 hover:bg-orange-600 
                   shadow-lg flex items-center justify-center transition-all 
                   group relative">
                        <i class="fa-solid fa-star text-white text-lg"></i>
                        <span
                            class="absolute right-14 bg-gray-800 text-white text-[10px] 
                       px-2 py-1 rounded opacity-0 group-hover:opacity-100 
                       transition-opacity whitespace-nowrap shadow-md">
                            Write Review
                        </span>
                    </a>

                    <!-- Support Chat -->
                    <a href="{{ url('/support/chat') }}"
                        class="w-12 h-12 rounded-full bg-emerald-600 hover:bg-emerald-700 
                   shadow-lg flex items-center justify-center transition-all 
                   group relative">
                        <i class="fa-solid fa-comments text-white text-lg"></i>
                        <span
                            class="absolute right-14 bg-gray-800 text-white text-[10px] 
                       px-2 py-1 rounded opacity-0 group-hover:opacity-100 
                       transition-opacity whitespace-nowrap shadow-md">
                            Support Chat
                        </span>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/919457296893?text={{ urlencode('Hello, I need some help regarding your services.') }}"
                        target="_blank"
                        class="w-12 h-12 rounded-full bg-[#25D366] hover:bg-[#128C7E] 
                   shadow-lg flex items-center justify-center transition-all 
                   group relative">
                        <i class="fa-brands fa-whatsapp text-white text-2xl"></i>
                        <span
                            class="absolute right-14 bg-gray-800 text-white text-[10px] 
                       px-2 py-1 rounded opacity-0 group-hover:opacity-100 
                       transition-opacity whitespace-nowrap shadow-md">
                            WhatsApp Us
                        </span>
                    </a>
                </div>

                <!-- Main Toggle Button -->
                <button @click="open = !open"
                    class="w-14 h-14 rounded-full bg-[#0939a4] hover:bg-blue-700 
               shadow-2xl flex items-center justify-center 
               transition-all duration-300 relative group overflow-hidden"
                    :class="open ? 'rotate-90 bg-red-500' : ''">
                    <template x-if="!open">
                        <i class="fa-solid fa-headset text-white text-2xl"></i>
                    </template>

                    <template x-if="open">
                        <i class="fa-solid fa-xmark text-white text-2xl"></i>
                    </template>

                    <!-- Ping Animation -->
                    <span x-show="!open"
                        class="absolute inline-flex h-full w-full rounded-full 
                   bg-blue-400 opacity-40 animate-ping">
                    </span>
                </button>
            </div>

            {{-- POPUP SECTION --}}
            @php
                // Fetch the highest priority active popup
                $activePopup = \App\Models\Popup::where('status', 'active')
                    ->orderBy('priority', 'desc')
                    ->latest()
                    ->first();
            @endphp

            @if ($activePopup)
                <div x-data="{
                    showPopup: false,
                    storageKey: 'popup_last_shown_{{ $activePopup->id }}',
                
                    init() {
                        const today = new Date().toISOString().slice(0, 10);
                        const lastShown = localStorage.getItem(this.storageKey);
                
                        // Show only if NOT shown today
                        if (lastShown !== today) {
                            setTimeout(() => {
                                this.showPopup = true;
                            }, 2000);
                        }
                    },
                
                    dismiss() {
                        this.showPopup = false;
                        const today = new Date().toISOString().slice(0, 10);
                        localStorage.setItem(this.storageKey, today);
                    }
                }" x-show="showPopup" x-cloak
                    class="fixed inset-0 z-[999] flex items-center justify-center px-4">

                    <!-- BACKDROP -->
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" x-show="showPopup" x-transition
                        @if ($activePopup->is_dismissible) @click="dismiss()" @endif>
                    </div>

                    <!-- POPUP CARD -->
                    <div class="relative bg-white w-full
                   max-w-[92%] sm:max-w-md md:max-w-lg
                   rounded-3xl shadow-2xl overflow-hidden
                   transform transition-all"
                        x-show="showPopup" x-transition:enter="ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-90 translate-y-10"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                        {{-- Close button --}}
                        @if ($activePopup->is_dismissible)
                            <button @click="dismiss()"
                                class="absolute top-4 right-4 z-20 w-9 h-9 bg-black/10 hover:bg-black/20 backdrop-blur rounded-full flex items-center justify-center text-white shadow">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        @endif

                        <div class="flex flex-col">

                            {{-- IMAGE (only if exists) --}}
                            @if ($activePopup->image)
                                <div class="relative h-40 md:h-64 overflow-hidden">
                                    <img src="{{ asset('/storage/' . $activePopup->image) }}"
                                        class="w-full h-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-black/20">
                                    </div>
                                </div>
                            @endif

                            {{-- CONTENT --}}
                            <div class="p-5 md:p-10 text-center">

                                @if ($activePopup->type === 'offer')
                                    <span
                                        class="inline-block px-4 py-1 mb-4
                                   bg-indigo-100 text-indigo-600
                                   text-[10px] font-black uppercase tracking-[0.2em] rounded-full">
                                        Limited Offer
                                    </span>
                                @endif

                                <h2 class="text-xl md:text-3xl font-black text-slate-900 mb-4">
                                    {{ $activePopup->title }}
                                </h2>

                                {{-- RESPONSIVE CONTENT HEIGHT --}}
                                <div
                                    class="prose prose-slate prose-sm mx-auto text-slate-500 font-medium italic
                               max-h-[90px] overflow-y-auto
                               md:max-h-none md:overflow-visible offer-pop-cont">
                                    {!! $activePopup->content !!}
                                </div>

                                {{-- BUTTON --}}
                                @if ($activePopup->button_text)
                                    <div class="mt-6">
                                        <a href="{{ $activePopup->button_url ?? '#' }}" @click="dismiss()"
                                            class="inline-block w-full py-3 md:py-4
                                       bg-slate-900 text-white
                                       rounded-2xl font-black text-xs uppercase tracking-[0.2em]
                                       hover:bg-indigo-600 transition-all">
                                            {{ $activePopup->button_text }}
                                        </a>
                                    </div>
                                @endif

                                {{-- Don't show today --}}
                                @if ($activePopup->is_dismissible)
                                    <button @click="dismiss()"
                                        class="mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600">
                                        Don't show this today
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- End POPUP SECTION --}}


            {{-- Message Campaigns show here  --}}

            {{-- @php
                use Carbon\Carbon;

                $today = Carbon::today();

                $activeCampaigns = \App\Models\MessageCampaign::where('is_active', 1)
                    ->whereDate('starts_at', '<=', $today)
                    ->whereDate('ends_at', '>=', $today)
                    ->latest()
                    ->get(['id', 'title', 'message', 'description', 'image']);

                $seenCampaignIds = auth()->check()
                    ? \App\Models\MessageCampaignLog::where('user_id', auth()->id())
                        ->pluck('message_campaign_id')
                        ->toArray()
                    : [];
            @endphp

            <script>
                window.AUTH_USER_ID = {{ auth()->check() ? auth()->id() : 'null' }};
                window.ALL_CAMPAIGNS = @json($activeCampaigns);
                window.SEEN_CAMPAIGNS = @json($seenCampaignIds);
            </script> --}}

            @auth

                @php

                    $userId = auth()->id();

                    $activeCampaigns = \App\Models\MasterNotification::where('type', 'campaign')

                        // 🌍 global OR personal
                        ->where(function ($q) use ($userId) {
                            $q->where('is_global', true)->orWhere('user_id', $userId);
                        })

                        // 👁️ hide already read for this user
                        ->whereDoesntHave('reads', function ($q) use ($userId) {
                            $q->where('user_id', $userId);
                        })

                        ->orderByDesc('id')
                        ->limit(10)
                        ->get()
                        ->map(function ($c) {
                            return [
                                'id' => $c->id,
                                'title' => $c->title,
                                'message' => $c->message,
                                'description' => $c->data['detail'] ?? '',
                                'image' => $c->data['image'] ?? null,
                            ];
                        })
                        ->toArray();

                @endphp

                <script>
                    window.ALL_CAMPAIGNS = @json($activeCampaigns);
                </script>


                <div id="campaign-bell-container" class="fixed top-5 right-5 z-[60] hidden">
                    <button onclick="openCampaignDetails()"
                        class="relative flex items-center justify-center w-12 h-12 bg-yellow-400 rounded-full shadow-lg hover:bg-yellow-500 transition-all animate-vibrate">
                        <i class="fa-solid fa-bell text-white text-xl"></i>
                        <span class="absolute top-0 right-0 flex h-3 w-3">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                    </button>
                </div>



                <div id="campaign-toast"
                    class="fixed z-50 hidden
                    w-[92%] max-w-[340px]
                    left-[97%] -translate-x-1/2 top-3
                    sm:left-auto sm:translate-x-0 sm:top-5 sm:right-5
                    overflow-hidden rounded-[1.75rem] bg-white shadow-2xl
                    transition-all duration-500 transform scale-95 border border-white/20">

                    <!-- IMAGE WRAPPER -->
                    <div id="campaign-image-wrapper"
                        class="relative h-44 sm:h-48 w-full overflow-hidden bg-slate-900 hidden">

                        <img id="campaign-image" class="h-full w-full object-cover opacity-90" src=""
                            alt="">

                        <div class="absolute inset-0 bg-gradient-to-t from-white via-white/30 to-transparent"></div>

                        <button onclick="closeCampaignToast()"
                            class="absolute top-3 right-3 z-20
                   flex h-9 w-9 items-center justify-center
                   rounded-full bg-black/30 text-white backdrop-blur
                   transition hover:bg-red-500">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <!-- CONTENT -->
                    <div id="campaign-content-wrapper" class="relative bg-white px-5 sm:px-7 pb-6 pt-6 sm:pt-10">

                        <!-- ICON -->
                        <div id="campaign-icon"
                            class="relative mx-auto sm:mx-0
                    flex h-11 w-11 items-center justify-center
                    rounded-xl bg-yellow-400 shadow-md ring-4 ring-white">
                            <i class="fa-solid fa-bolt-lightning text-white text-lg"></i>
                        </div>

                        <div class="mt-4 space-y-2 text-center sm:text-left">
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] text-blue-600">
                                New Announcement
                            </span>

                            <h4 id="campaign-title" class="text-lg sm:text-xl font-black leading-snug text-slate-900">
                            </h4>

                            <div class="h-1 w-10 bg-slate-100 rounded-full mx-auto sm:mx-0"></div>

                            <p id="campaign-message"
                                class="text-[13px] sm:text-sm font-medium leading-relaxed text-slate-500 italic">
                            </p>
                        </div>

                        <button onclick="closeCampaignToast()"
                            class="group mt-6 flex w-full items-center justify-center gap-2
                   rounded-xl bg-slate-900 py-3.5
                   text-[10px] font-bold uppercase tracking-[0.18em]
                   text-white shadow-lg transition-all
                   active:scale-95 hover:bg-blue-600">
                            <span>Got it, Thanks!</span>
                            <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                        </button>
                        <button onclick="closeAllCampaigns()"
                            class="mt-3 text-[10px] font-bold uppercase text-slate-400 hover:text-red-500">
                            Close all notifications
                        </button>

                    </div>
                </div>

                <style>
                    @keyframes vibrate {

                        0%,
                        100% {
                            transform: rotate(0deg);
                        }

                        20% {
                            transform: rotate(15deg);
                        }

                        40% {
                            transform: rotate(-15deg);
                        }

                        60% {
                            transform: rotate(10deg);
                        }

                        80% {
                            transform: rotate(-10deg);
                        }
                    }

                    .animate-vibrate {
                        animation: vibrate 0.6s cubic-bezier(.36, .07, .19, .97) both infinite;
                        animation-delay: 1.5s;
                    }

                    #campaign-toast {
                        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                    }
                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {

                        const bell = document.getElementById('campaign-bell-container');
                        const toast = document.getElementById('campaign-toast');

                        const title = document.getElementById('campaign-title');
                        const message = document.getElementById('campaign-message');
                        const image = document.getElementById('campaign-image');
                        const imageWrap = document.getElementById('campaign-image-wrapper');
                        const icon = document.getElementById('campaign-icon');

                        let pendingCampaigns = [];
                        let activeCampaign = null;

                        /* ===============================
                            🧠 BUILD PENDING QUEUE
                        ================================*/
                        // if (window.AUTH_USER_ID && Array.isArray(window.ALL_CAMPAIGNS)) {

                        //     pendingCampaigns = window.ALL_CAMPAIGNS.filter(c => {
                        //         return !window.SEEN_CAMPAIGNS.includes(c.id);
                        //     });

                        //     if (pendingCampaigns.length) {
                        //         showNextCampaign();
                        //     }
                        // }
                        if (Array.isArray(window.ALL_CAMPAIGNS) && window.ALL_CAMPAIGNS.length) {
                            pendingCampaigns = [...window.ALL_CAMPAIGNS];
                            showNextCampaign();
                        }

                        /* ===============================
                            🔴 PUSHER REALTIME
                        ================================*/
                        // const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                        //     cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                        //     forceTLS: true
                        // });

                        // pusher.subscribe('all-users')
                        //     .bind('message.campaign.sent', function(data) {

                        //         if (!data || window.SEEN_CAMPAIGNS.includes(data.id)) return;

                        //         pendingCampaigns.push(data);

                        //         if (!activeCampaign) {
                        //             showNextCampaign();
                        //         }
                        // });

                        Echo.channel('public-notifications')
                            .listen('.master.notification', (data) => {

                                if (data.type !== 'campaign') return;

                                const campaign = {
                                    id: data.id,
                                    title: data.title,
                                    message: data.message,
                                    description: data.data?.detail || '',
                                    image: data.data?.image || null
                                };

                                pendingCampaigns.push(campaign);

                                if (!activeCampaign) {
                                    showNextCampaign();
                                }
                            });

                        /* ===============================
                            🔔 SHOW NEXT CAMPAIGN
                        ================================*/
                        function showNextCampaign() {

                            if (!pendingCampaigns.length) return;

                            activeCampaign = pendingCampaigns[0];

                            title.innerText = activeCampaign.title || 'Announcement';
                            message.innerText = activeCampaign.message || activeCampaign.description || '';

                            if (activeCampaign.image) {
                                image.src = activeCampaign.image;
                                imageWrap.classList.remove('hidden');
                                icon.classList.add('absolute', '-top-6', 'left-6');
                            } else {
                                imageWrap.classList.add('hidden');
                                icon.classList.remove('absolute', '-top-6', 'left-6');
                            }

                            bell.classList.remove('hidden');
                        }

                        /* ===============================
                            🔔 OPEN MODAL
                        ================================*/
                        window.openCampaignDetails = function() {
                            bell.classList.add('hidden');
                            toast.classList.remove('hidden');
                            toast.classList.add('scale-100');
                        };

                        /* ===============================
                            ❌ CLOSE ONE (NEXT AUTO)
                        ================================*/
                        window.closeCampaignToast = function() {

                            if (!activeCampaign) return;

                            logCampaign(activeCampaign.id);

                            pendingCampaigns.shift();
                            activeCampaign = null;

                            toast.classList.add('hidden');

                            if (pendingCampaigns.length) {
                                setTimeout(showNextCampaign, 400);
                            }
                        };

                        /* ===============================
                            ❌ CLOSE ALL (ONE CLICK)
                        ================================*/
                        window.closeAllCampaigns = function() {

                            pendingCampaigns.forEach(c => logCampaign(c.id));

                            pendingCampaigns = [];
                            activeCampaign = null;

                            toast.classList.add('hidden');
                            bell.classList.add('hidden');
                        };

                        /* ===============================
                            🧾 LOG SEEN
                        ================================*/
                        function logCampaign(id) {
                            fetch('/campaign/mark-as-seen', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    campaign_id: id
                                })
                            }).catch(() => {});
                        }

                    });
                </script>
            @endauth

            {{-- END message campaign --}}




            {{-- @include('components.user_footer') --}}
            @php
                $footer = \App\Http\Controllers\FooterController::data();
            @endphp

            @include('components.user_footer', [
                'settings' => $footer['settings'],
                'columns' => $footer['columns'],
                'socials' => $footer['socials'],
                'brand' => $footer['brand'],
            ])

        </div>
    </div>

    <!-- FIXED ORDER -->
    <!-- Load Alpine FIRST -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Load your script AFTER Alpine -->
    <script src="{{ asset('assets/js/script.js') }}"></script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @auth
            const authUserId = {{ auth()->id() }};

            window.Echo.private('user.' + authUserId)
                .listen('.plan.expiring', (e) => {
                    // Ye global event layout ke popup ko trigger karega
                    window.dispatchEvent(new CustomEvent('plan-expiring-alert', {
                        detail: {
                            message: e.message
                        }
                    }));
                });

            console.log('🔥 Attaching Echo listener for user:', authUserId);

            Echo.private('user.' + authUserId)
                .listen('.user-chat-message', (e) => {
                    console.log('🔥 USER CHAT EVENT RECEIVED', e);
                    window.dispatchEvent(new CustomEvent('chat-user-message', {
                        detail: e
                    }));
                })
                .listen('.admin-chat-message', (e) => {
                    console.log('🔥 ADMIN CHAT EVENT RECEIVED', e);
                    window.dispatchEvent(new CustomEvent('chat-admin-message', {
                        detail: e
                    }));
                });
        @endauth

        });
    </script>

    {{-- message campaign --}}
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>



    <script src="{{ asset('assets/js/animation.js') }}"></script>
</body>

</html>
