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
    <link rel="icon" type="image/svg+xml" href="{{ asset('public/storage/favicon/icon.svg') }}">



    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    
    <link rel="stylesheet" href="{{ asset('public/assets/css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/testimonial.css') }}">
    <script src="{{asset('public/assets/js/animation.js')}}"></script>
    <script src="{{asset('public/assets/js/testimonial.js')}}"></script>
    <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <style>
    [x-cloak] { display: none !important; }
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
<div 
    class="fixed bottom-6 right-6 z-50"
    x-data="{ open: false }"
    x-cloak
    x-init="open = false"
>

    <!-- Floating Actions -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-10 scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-10 scale-90"
        class="flex flex-col gap-4 mb-4 items-center"
        @click.away="open = false"
    >

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
    <button 
        @click="open = !open"
        class="w-14 h-14 rounded-full bg-[#0939a4] hover:bg-blue-700 
               shadow-2xl flex items-center justify-center 
               transition-all duration-300 relative group overflow-hidden"
        :class="open ? 'rotate-90 bg-red-500' : ''"
    >
        <template x-if="!open">
            <i class="fa-solid fa-headset text-white text-2xl"></i>
        </template>

        <template x-if="open">
            <i class="fa-solid fa-xmark text-white text-2xl"></i>
        </template>

        <!-- Ping Animation -->
        <span 
            x-show="!open"
            class="absolute inline-flex h-full w-full rounded-full 
                   bg-blue-400 opacity-40 animate-ping">
        </span>
    </button>
</div>



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
                        const today = new Date().toISOString().slice(0, 10); // Format: YYYY-MM-DD
                        const lastShownDate = localStorage.getItem(this.storageKey);
                
                        // Check if it was NOT shown today
                        if (lastShownDate !== today) {
                            setTimeout(() => { this.showPopup = true }, 2000);
                        }
                    },
                
                    dismiss() {
                        this.showPopup = false;
                        const today = new Date().toISOString().slice(0, 10);
                        // Save today's date so it won't show until tomorrow
                        localStorage.setItem(this.storageKey, today);
                    }
                }" x-show="showPopup"
                    class="fixed inset-0 z-[999] flex items-center justify-center px-4" x-cloak>

                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" x-show="showPopup"
                        x-transition:enter="duration-300" x-transition:leave="duration-200"
                        @if ($activePopup->is_dismissible) @click="dismiss()" @endif>
                    </div>

                    <div class="relative bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all"
                        x-show="showPopup" x-transition:enter="ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-90 translate-y-10"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                        @if ($activePopup->is_dismissible)
                            <button @click="dismiss()"
                                class="absolute top-5 right-5 z-20 w-10 h-10 bg-black/10 hover:bg-black/20 backdrop-blur-md rounded-full flex items-center justify-center text-white transition-all shadow-lg">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        @endif

                        <div class="flex flex-col">
                            @if ($activePopup->image)
                                <div class="relative h-64 overflow-hidden">
                                    <img src="{{ asset('public/storage/' . $activePopup->image) }}"
                                        class="w-full h-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-black/20">
                                    </div>
                                </div>
                            @endif

                            <div class="p-8 md:p-10 text-center">
                                @if ($activePopup->type === 'offer')
                                    <span
                                        class="inline-block px-4 py-1 bg-indigo-100 text-indigo-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-4">Limited
                                        Offer</span>
                                @endif

                                <h2 class="text-3xl font-black text-slate-900 leading-tight mb-4 tracking-tight">
                                    {{ $activePopup->title }}
                                </h2>

                                <div class="prose prose-slate prose-sm mx-auto text-slate-500 font-medium italic">
                                    {!! $activePopup->content !!}
                                </div>

                                @if ($activePopup->button_text)
                                    <div class="mt-8">
                                        <a href="{{ $activePopup->button_url ?? '#' }}" @click="dismiss()"
                                            class="inline-block w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-indigo-600 transition-all active:scale-95">
                                            {{ $activePopup->button_text }}
                                        </a>
                                    </div>
                                @endif

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
            
            
                  {{-- Message Campaigns show here  --}}
            <div id="campaign-toast"
                class="fixed top-5 right-5 z-50 hidden bg-white shadow border rounded-lg p-4 max-w-sm">
                <button onclick="closeCampaignToast()" class="absolute top-2 right-2">✕</button>

                <img id="campaign-image" class="w-full h-32 object-cover rounded mb-2 hidden">

                <h4 id="campaign-title" class="font-semibold text-sm"></h4>
                <p id="campaign-message" class="text-sm mt-1"></p>
            </div>




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

   {{-- @if (auth()->check())
        <div x-data="profilePopup({
            phone: '{{ auth()->user()->phone }}',
            name: '{{ auth()->user()->name }}'
        })" x-init="init()">

            <!-- Light Overlay -->
            <div x-show="show" x-transition.opacity class="fixed inset-0 bg-black/20 z-40" @click="closePopup()">
            </div>

            <!-- Popup Box (Top Right) -->
            <div x-show="show" x-transition
                class="fixed top-5 right-5 z-50 bg-white w-[320px] rounded-xl shadow-2xl p-4">

                <!-- Close -->
                <button @click="closePopup()" class="absolute top-2 right-2 text-gray-400 hover:text-black text-lg">
                    &times;
                </button>

                <h3 class="text-lg font-semibold text-gray-900 mb-1">
                    Complete your profile
                </h3>

                <p class="text-sm text-gray-600 mb-3">
                    Hi,
                    <template x-if="hasName">
                        <strong x-text="name"></strong>
                    </template>
                    <template x-if="!hasName">
                        <strong>User</strong>
                    </template>,
                    your profile is incomplete.
                </p>

                <div class="bg-gray-50 rounded-md p-3 text-xs mb-4">
                    <p><strong>Phone:</strong> +91 <span x-text="phone"></span></p>
                    <template x-if="!hasName">
                        <p class="text-red-500 font-medium mt-1">
                            Name not added yet
                        </p>
                    </template>
                </div>

               
            </div>
        </div>
    @endif
    --}}
    <script>
        function profilePopup(data) {
            return {
                show: false,
                phone: data.phone,
                name: data.name,
                maxCancels: 3,

                get hasName() {
                    return this.name && this.name.trim() !== "";
                },

                get cancelCount() {
                    return parseInt(localStorage.getItem('profilePopupCancelCount') || 0);
                },

                init() {
                    // ✅ Show popup ONLY if:
                    // 1. Name empty
                    // 2. Cancel count < 3
                    if (!this.hasName && this.cancelCount < this.maxCancels) {
                        this.show = true;
                    }
                },

                closePopup() {
                    // ➕ Increase cancel count
                    let count = this.cancelCount + 1;
                    localStorage.setItem('profilePopupCancelCount', count);

                    this.show = false;
                }
            }
        }
    </script>



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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const toast = document.getElementById('campaign-toast');
            const titleEl = document.getElementById('campaign-title');
            const msgEl = document.getElementById('campaign-message');
            const imgEl = document.getElementById('campaign-image');

            const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                forceTLS: true
            });

            const channel = pusher.subscribe('all-users');

            channel.bind('message.campaign.sent', function(data) {

                console.log('Campaign data:', data); // 🔍 DEBUG

                if (!data || !data.id) return;

                if (seenToday(data.id)) return;

                titleEl.innerText = data.title ?? '';
                msgEl.innerText = data.message || data.description || '';

                // ✅ IMAGE FIX
                if (data.image && data.image.startsWith('http')) {
                    imgEl.src = data.image;
                    imgEl.classList.remove('hidden');
                } else {
                    imgEl.classList.add('hidden');
                }

                toast.classList.remove('hidden');
                markSeen(data.id);
            });

            window.closeCampaignToast = function() {
                toast.classList.add('hidden');
            };

            function markSeen(id) {
                localStorage.setItem('campaign_seen_' + id, today());
            }

            function seenToday(id) {
                return localStorage.getItem('campaign_seen_' + id) === today();
            }

            function today() {
                return new Date().toISOString().split('T')[0];
            }
        });
    </script>


    
    <script src="{{ asset('public/assets/js/animation.js') }}"></script>

    

</body>

</html>
