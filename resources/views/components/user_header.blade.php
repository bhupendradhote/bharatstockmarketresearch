<header class="w-full fixed top-0 z-40 flex justify-center items-center main-header" x-data="{ mobileMenuOpen: false }">

    <div
        class="max-w-[1600px] w-full py-4 md:py-6 px-4 md:px-8 lg:px-16 
        flex items-center justify-between relative 
        lg:bg-white/30 lg:backdrop-blur lg:rounded-full bg-white">

        <!-- Mobile Menu Button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-700 focus:outline-none">
            <i class="fas fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
            <i class="fas fa-times text-2xl" x-show="mobileMenuOpen" x-cloak></i>
        </button>

        <!-- Logo -->
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 [&>svg]:w-6 [&>svg]:h-6">
                {!! $settings->logo_svg ?? '<div class="w-6 h-6 bg-[#0939a4] rounded-full"></div>' !!}
            </div>
            <span class="font-bold text-xl text-gray-900">
                {{ $settings->website_name ?? 'BSMR' }}
            </span>
        </div>

        <!-- Desktop Menu -->
        <nav class="hidden lg:flex items-center gap-8 text-gray-700 font-medium" x-data="{ moreOpen: false }">

            @foreach ($menus as $m)
                @php
                    $cleanLink = ltrim($m->link, '/');
                    $isActive =
                        request()->is($cleanLink) ||
                        request()->fullUrlIs(url($m->link)) ||
                        ($m->link === '/' && request()->is('/'));
                @endphp

                {{-- Pehle 5 items show honge --}}
                @if ($loop->iteration <= 5)
                    <a href="{{ $m->link }}"
                        class="hover:text-black transition relative
                {{ $isActive ? 'text-black after:absolute after:left-0 after:bottom-[-6px] after:w-full after:h-[3px] after:bg-[#0939a4] after:rounded-full' : '' }}">
                        {{ $m->title }}
                    </a>
                @endif

                {{-- Jab 6th item start ho, dropdown open karo --}}
                @if ($loop->iteration == 6)
                    <div class="relative" @click.away="moreOpen = false">
                        <button @click="moreOpen = !moreOpen"
                            class="flex items-center gap-1 hover:text-black transition focus:outline-none">
                            More
                            <svg class="w-4 h-4 transition-transform" :class="moreOpen ? 'rotate-180' : ''"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="moreOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute left-0 mt-4 w-48 bg-white border border-gray-100 shadow-xl rounded-xl py-2 z-50"
                            x-cloak>
                @endif

                {{-- 6th aur uske baad wale items yaha list honge --}}
                @if ($loop->iteration >= 6)
                    <a href="{{ $m->link }}"
                        class="block px-4 py-2 text-sm hover:bg-gray-50 hover:text-blue-600 {{ $isActive ? 'text-blue-600 bg-gray-50 font-bold' : '' }}">
                        {{ $m->title }}
                    </a>
                @endif

                {{-- Last item par dropdown div close karein --}}
                @if ($loop->last && $loop->count >= 6)
    </div>
    </div>
    @endif
    @endforeach

    </nav>

    <!-- Auth Buttons -->
    @guest
        @if ($settings->button_active)
            <button onclick="window.location.href='{{ $settings->button_link ?? route('login') }}'"
                class="hidden lg:block bg-[#0939a4] text-white px-6 py-2 rounded-full hover:bg-blue-700">
                {{ $settings->button_text ?? 'Sign In' }}
            </button>
        @endif
    @endguest

    @auth
        <form action="{{ route('logout') }}" method="POST" class="hidden lg:block">
            @csrf
            <button class="bg-[#0939a4] text-white px-6 py-2 rounded-full hover:bg-blue-700">
                Log Out
            </button>
        </form>
    @endauth

    <!-- Mobile Overlay -->
    <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        x-cloak></div>

    <!-- Mobile Menu Panel -->
    <div x-show="mobileMenuOpen" x-cloak
        class="mobile-menu fixed top-0 left-0 h-full w-64 bg-white shadow-2xl 
                z-50 p-6 lg:hidden"
        x-transition>

        <!-- Mobile Header -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 [&>svg]:w-6 [&>svg]:h-6">
                    {!! $settings->logo_svg ?? '<div class="w-6 h-6 bg-[#0939a4] rounded-full"></div>' !!}
                </div>
                <span class="font-bold text-xl text-gray-900">
                    {{ $settings->website_name ?? 'BSMR' }}
                </span>
            </div>

            <button @click="mobileMenuOpen=false" class="text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Dynamic Mobile Links -->
        <nav class="flex flex-col space-y-6">
            @foreach ($menus as $m)
                @php
                    $cleanLink = ltrim($m->link, '/');
                    $isActive =
                        request()->is($cleanLink) ||
                        request()->fullUrlIs(url($m->link)) ||
                        ($m->link === '/' && request()->is('/'));
                @endphp

                <a href="{{ $m->link }}"
                    class="text-lg hover:text-black 
                              {{ $isActive ? 'font-semibold pb-2 border-b' : '' }}">
                    {{ $m->title }}
                </a>
            @endforeach
        </nav>

        @guest
            @if ($settings->button_active)
                <button onclick="window.location.href='{{ $settings->button_link ?? route('login') }}'"
                    class="mt-10 w-full bg-[#0939a4] text-white py-3 rounded-full font-semibold">
                    {{ $settings->button_text ?? 'Sign In' }}
                </button>
            @endif
        @endguest

        @auth
            <form action="{{ route('logout') }}" method="POST" class="mt-10 w-full">
                @csrf
                <button class="w-full bg-[#0939a4] text-white py-3 rounded-full font-semibold">
                    Log Out
                </button>
            </form>
        @endauth

    </div>

    </div>

</header>
