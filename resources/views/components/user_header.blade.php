{{-- resources/views/partials/header.blade.php --}}
@once
    {{-- Keep elements hidden until Alpine initializes --}}
    <style>[x-cloak]{ display: none !important; }</style>

    {{-- Alpine (remove if loaded globally) --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome (remove if loaded globally) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endonce

@php
    // Safe Route::has helper
    $RouteHas = function (string $name) {
        return \Illuminate\Support\Facades\Route::has($name);
    };

    // ---------- USER & ROLE DETECTION ----------
    $user = auth()->user();
    $userRole = null;
    $isAdmin = false;
    $isSuperAdmin = false;

    if ($user) {
        // try common role sources
        if (method_exists($user, 'getRoleNames')) {
            try { $roles = $user->getRoleNames(); if ($roles->isNotEmpty()) $userRole = (string) $roles->first(); } catch (\Throwable $e) {}
        }
        if (empty($userRole) && method_exists($user, 'roles')) {
            try { $r = $user->roles()->pluck('name')->first(); if ($r) $userRole = (string)$r; } catch (\Throwable $e) {}
        }
        if (empty($userRole) && isset($user->role)) {
            $userRole = (string) $user->role;
        }

        // normalize role and detect admin/super-admin
        if ($userRole) {
            $normalized = strtolower(str_replace(['_', ' '], '-', trim($userRole)));
            $adminRoles = ['admin', 'super-admin', 'super_admin', 'superadmin', 'administrator'];
            if (in_array($normalized, $adminRoles, true)) {
                $isAdmin = true;
            }
            // explicitly detect super-admin
            $superRoles = ['super-admin', 'super_admin', 'superadmin'];
            if (in_array($normalized, $superRoles, true)) {
                $isSuperAdmin = true;
                $isAdmin = true; // super-admin is also admin
            }
        }

        // prefer model helper if exists
        if (! $isAdmin && method_exists($user, 'isAdmin') && $user->isAdmin()) {
            $isAdmin = true;
        }
        if (! $isSuperAdmin && method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            $isSuperAdmin = true;
            $isAdmin = true;
        }
    }

    // ---------- SAFE DASHBOARD ROUTE SELECTION ----------
    $dashboardRoute = null;

    if ($isAdmin) {
        // Prefer admin.dashboard, then legacy dashboard, then admin.home, then /admin
        if ($RouteHas('admin.dashboard')) {
            $dashboardRoute = route('admin.dashboard');
        } elseif ($RouteHas('dashboard')) {
            $dashboardRoute = route('dashboard');
        } elseif ($RouteHas('admin.home')) {
            $dashboardRoute = route('admin.home');
        } else {
            $dashboardRoute = url('/admin');
        }
    } else {
        // Prefer user.dashboard, then generic dashboard, then /dashboard
        if ($RouteHas('user.dashboard')) {
            $dashboardRoute = route('user.dashboard');
        } elseif ($RouteHas('dashboard')) {
            $dashboardRoute = route('dashboard');
        } else {
            $dashboardRoute = url('/dashboard');
        }
    }

    // ---------- MARKET CALLS ROUTE SELECTION ----------
    // If super-admin -> prefer admin.tips.index, else user marketCall.index
    $marketCallsRoute = null;
    if ($isSuperAdmin) {
        if ($RouteHas('admin.tips.index')) {
            $marketCallsRoute = route('admin.tips.index');
        } elseif ($RouteHas('tips.index')) {
            $marketCallsRoute = route('tips.index');
        } else {
            $marketCallsRoute = url('/tips');
        }
    } else {
        if ($RouteHas('marketCall.index')) {
            $marketCallsRoute = route('marketCall.index');
        } elseif ($RouteHas('market-calls')) {
            // named route maybe different; try named 'market-calls'
            $marketCallsRoute = route('market-calls');
        } else {
            $marketCallsRoute = url('/market-calls');
        }
    }

    // Active-state detection
    $isDashboardActive = request()->routeIs('admin.dashboard', 'dashboard', 'user.dashboard');
    $isMarketActive = request()->routeIs('marketCall.index', 'admin.tips.index', 'market-calls', 'tips') || request()->is('market-calls*') || request()->is('tips*');

    // ensure $menus is a collection to avoid errors
    $menus = $menus ?? collect();
@endphp

<header
    class="w-full fixed top-0 z-40 flex justify-center items-center main-header"
    x-data="{ mobileMenuOpen: false }"
    aria-label="Main header">
    <div class="max-w-[1600px] w-full py-4 md:py-6 px-4 md:px-8 lg:px-16 flex items-center justify-between relative lg:bg-white/30 lg:backdrop-blur lg:rounded-full bg-white">
        {{-- Mobile Menu Button --}}
        <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            :aria-expanded="mobileMenuOpen"
            aria-controls="mobile-menu"
            class="lg:hidden text-gray-700 focus:outline-none"
        >
            <i class="fas fa-bars text-2xl" x-show="!mobileMenuOpen" x-cloak></i>
            <i class="fas fa-times text-2xl" x-show="mobileMenuOpen" x-cloak></i>
        </button>

        {{-- Logo --}}
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 [&>svg]:w-6 [&>svg]:h-6">
                {!! ($settings->logo_svg ?? null) ?: '<div class="w-6 h-6 bg-[#0939a4] rounded-full"></div>' !!}
            </div>
            <span class="font-bold text-xl text-gray-900">
                {{ $settings->website_name ?? 'BSMR' }}
            </span>
        </div>

        {{-- Desktop Menu --}}
        <nav class="hidden lg:flex items-center gap-8 text-gray-700 font-medium" x-data="{ moreOpen: false }">
            @auth
                <a href="{{ $dashboardRoute }}" class="hover:text-black transition {{ $isDashboardActive ? 'text-black font-bold' : '' }}">
                    Dashboard
                </a>

                <a href="{{ $marketCallsRoute }}" class="hover:text-black transition {{ $isMarketActive ? 'text-black font-bold' : '' }}">
                    Market Calls
                </a>
            @endauth

            {{-- Dynamic menu items --}}
            @foreach ($menus as $m)
                @php
                    $cleanLink = ltrim($m->link ?? '', '/');
                    $isActive = (
                        (!empty($cleanLink) && request()->is($cleanLink)) ||
                        (!empty($m->link) && request()->fullUrlIs(url($m->link))) ||
                        ($m->link === '/' && request()->is('/'))
                    );
                @endphp

                @if ($loop->iteration <= 5)
                    <a href="{{ $m->link ?? '#' }}" class="hover:text-black transition relative {{ $isActive ? 'text-black after:absolute after:left-0 after:bottom-[-6px] after:w-full after:h-[3px] after:bg-[#0939a4] after:rounded-full' : '' }}">
                        {{ $m->title }}
                    </a>
                @endif

                @if ($loop->iteration == 6)
                    <div class="relative" @click.away="moreOpen = false">
                        <button @click="moreOpen = !moreOpen" :aria-expanded="moreOpen" class="flex items-center gap-1 hover:text-black transition focus:outline-none">
                            More
                            <svg class="w-4 h-4 transition-transform" :class="moreOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="moreOpen" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 mt-4 w-48 bg-white border border-gray-100 shadow-xl rounded-xl py-2 z-50" role="menu" aria-orientation="vertical" aria-label="More menu">
                @endif

                @if ($loop->iteration >= 6)
                    <a href="{{ $m->link ?? '#' }}" class="block px-4 py-2 text-sm hover:bg-gray-50 hover:text-blue-600 {{ $isActive ? 'text-blue-600 bg-gray-50 font-bold' : '' }}" role="menuitem">
                        {{ $m->title }}
                    </a>
                @endif

                @if ($loop->last && $loop->count >= 6)
                        </div>
                    </div>
                @endif
            @endforeach
        </nav>

        {{-- Right side (Search & Auth / Profile) --}}
        <div class="flex items-center gap-4">
            @guest
                @if ($settings->button_active ?? false)
                    <button onclick="window.location.href='{{ $settings->button_link ?? route('login') }}'" class="hidden lg:block bg-[#0939a4] text-white px-6 py-2 rounded-full hover:bg-blue-700">
                        {{ $settings->button_text ?? 'Sign In' }}
                    </button>
                @else
                    <a href="{{ route('login') }}" class="hidden lg:block bg-[#0939a4] text-white px-6 py-2 rounded-full hover:bg-blue-700">Sign In</a>
                @endif
            @endguest

            @auth
                <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 rounded-full border border-gray-200 hover:bg-gray-50 cursor-pointer transition">
                    <img src="{{ $user->getFirstMediaUrl('profile_image') ?: 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->id }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover" />
                    <span class="text-sm font-medium text-gray-700 whitespace-nowrap">{{ $user->name }}</span>

                    {{-- Debug role badge (commented out by default) --}}
                    {{-- @if (config('app.debug'))
                        <span class="ml-2 inline-block text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700 border">
                            role: {{ $userRole ?? 'unknown' }}{{ $isAdmin ? ' (admin)' : '' }}
                        </span>
                    @endif --}}
                </div>

                <form style="margin-bottom: 0" action="{{ route('logout') }}" method="POST" class="hidden lg:block">
                    @csrf
                    <button class="bg-[#0939a4] text-white px-6 py-2 rounded-full hover:bg-blue-700">Log Out</button>
                </form>
            @endauth
        </div>

        {{-- Mobile Overlay --}}
        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-cloak aria-hidden="true"></div>

        {{-- Mobile Menu Panel --}}
        <div id="mobile-menu" x-show="mobileMenuOpen" x-cloak x-transition:enter="transition transform ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition transform ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="mobile-menu fixed top-0 left-0 h-full w-64 bg-white shadow-2xl z-50 p-6 lg:hidden overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 [&>svg]:w-6 [&>svg]:h-6">
                        {!! ($settings->logo_svg ?? null) ?: '<div class="w-6 h-6 bg-[#0939a4] rounded-full"></div>' !!}
                    </div>
                    <span class="font-bold text-xl text-gray-900">{{ $settings->website_name ?? 'BSMR' }}</span>
                </div>
                <button @click="mobileMenuOpen = false" class="text-gray-600" aria-label="Close menu"><i class="fas fa-times text-xl"></i></button>
            </div>

            @auth
                <a href="{{ $dashboardRoute }}" class="text-lg font-semibold hover:text-black {{ $isDashboardActive ? 'border-b pb-2' : '' }}">Dashboard</a>
                <a href="{{ $marketCallsRoute }}" class="text-lg font-semibold hover:text-black {{ $isMarketActive ? 'border-b pb-2' : '' }}">Market Calls</a>
            @endauth

            <nav class="flex flex-col space-y-6 mt-6">
                @foreach ($menus as $m)
                    @php
                        $cleanLink = ltrim($m->link ?? '', '/');
                        $isActive = (
                            (!empty($cleanLink) && request()->is($cleanLink)) ||
                            (!empty($m->link) && request()->fullUrlIs(url($m->link))) ||
                            ($m->link === '/' && request()->is('/'))
                        );
                    @endphp
                    <a href="{{ $m->link ?? '#' }}" class="text-lg hover:text-black {{ $isActive ? 'font-semibold pb-2 border-b' : '' }}">{{ $m->title }}</a>
                @endforeach
            </nav>

            @guest
                @if ($settings->button_active ?? false)
                    <button onclick="window.location.href='{{ $settings->button_link ?? route('login') }}'" class="mt-10 w-full bg-[#0939a4] text-white py-3 rounded-full font-semibold">{{ $settings->button_text ?? 'Sign In' }}</button>
                @else
                    <a href="{{ route('login') }}" class="mt-10 w-full inline-block bg-[#0939a4] text-white py-3 rounded-full text-center font-semibold">Sign In</a>
                @endif
            @endguest

            @auth
                {{-- Debug info for mobile (commented out by default) --}}
                {{-- @if (config('app.debug'))
                    <div class="mb-4 text-sm text-gray-600">Detected role: <strong>{{ $userRole ?? 'unknown' }}</strong> — admin: <strong>{{ $isAdmin ? 'yes' : 'no' }}</strong></div>
                @endif --}}

                <form action="{{ route('logout') }}" method="POST" class="mt-10 w-full">
                    @csrf
                    <button class="w-full bg-[#0939a4] text-white py-3 rounded-full font-semibold">Log Out</button>
                </form>
            @endauth
        </div>
    </div>
</header>
