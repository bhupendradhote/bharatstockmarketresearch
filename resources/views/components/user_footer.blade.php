<footer
    id="footer"
    class="relative bg-gradient-to-b from-gray-50 to-white border-t border-gray-200 font-sans"
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
>
    <!-- CONTAINER -->
    <div
        class="mx-auto max-w-[1600px] px-6 pt-24 pb-12 transition-all duration-700 ease-out transform"
        :class="{ 'opacity-100 translate-y-0': visible, 'opacity-0 translate-y-10': !visible }"
    >

        <!-- TOP GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-14 lg:gap-10 mb-20">

            <!-- BRAND / ABOUT -->
            <div class="lg:col-span-3 space-y-6">

                @if (isset($brand) && $brand)
                    <!-- LOGO -->
                    <div class="flex items-center gap-3">
                        @if ($brand->icon_svg)
                            <div class="w-9 h-9 text-blue-600">{!! $brand->icon_svg !!}</div>
                        @elseif($brand->image)
                            <img src="{{ asset('uploads/footer/' . $brand->image) }}" class="w-9 h-9 object-contain">
                        @else
                            <div class="w-9 h-9 rounded-xl bg-blue-600"></div>
                        @endif

                        <h2 class="text-xl font-bold text-gray-900 tracking-tight">
                            {{ $brand->title }}
                        </h2>
                    </div>

                    @if ($brand->subtitle)
                        <p class="text-sm font-medium text-gray-500">
                            {{ $brand->subtitle }}
                        </p>
                    @endif

                    @if ($brand->description)
                        <p class="text-sm leading-relaxed text-gray-600 max-w-md">
                            {{ $brand->description }}
                        </p>
                    @endif

                    @if ($brand->content)
                        <p class="text-sm leading-relaxed text-gray-600">
                            {!! nl2br(e($brand->content)) !!}
                        </p>
                    @endif

                    @if ($brand->note)
                        <p class="text-xs italic text-gray-400">
                            {{ $brand->note }}
                        </p>
                    @endif

                    @if ($brand->button_text && $brand->button_link)
                        <a
                            href="{{ $brand->button_link }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 hover:shadow-md transition-all"
                        >
                            {{ $brand->button_text }}
                            <span class="text-lg">→</span>
                        </a>
                    @endif

                @else
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-600"></div>
                        <h2 class="text-xl font-bold text-gray-900">
                            {{ $settings->website_name ?? 'Bharat Stock Market Research' }}
                        </h2>
                    </div>

                    <p class="text-sm leading-relaxed text-gray-600 max-w-md">
                        {{ $settings->description ?? 'Save Money, Time and Efforts with our premium research tools.' }}
                    </p>
                @endif

                <!-- SOCIAL ICONS -->
                @if(isset($socials) && count($socials) > 0)
                    <div class="flex items-center gap-3 pt-2">
                        @foreach ($socials as $s)
                            <a
                                href="{{ $s->url }}"
                                target="_blank"
                                class="w-11 h-11 flex items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 hover:text-blue-600 hover:border-blue-600 hover:shadow-lg transition-all"
                            >
                                <i class="{{ $s->icon }} text-lg"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- LINKS -->
            <div class="lg:col-span-6 grid grid-cols-2 sm:grid-cols-3 gap-10">
                @foreach ($columns as $col)
                    <div>
                        <h3 class="mb-6 text-xs font-bold uppercase tracking-widest text-gray-900">
                            {{ $col->title }}
                        </h3>

                        <ul class="space-y-1.5">
                            @foreach ($col->links()->active()->get() as $link)
                                <li class="mt-0">
                                   <a
                                    href="{{ $link->url }}"
                                    class="group inline-flex items-start gap-2 text-sm text-gray-600 hover:text-blue-600 transition-all"
                                >
                                    <span class="mt-[2px] text-blue-500 opacity-0 group-hover:opacity-100 transition">
                                        →
                                    </span>
                                    <span class="leading-relaxed">
                                        {{ $link->label }}
                                    </span>
                                </a>

                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            <!-- CONTACT -->
            <div class="lg:col-span-3">
                <h3 class="mb-6 text-xs font-bold uppercase tracking-widest text-gray-900">
                    Contact
                </h3>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm space-y-5">

                    <!-- EMAIL -->
                    <div class="flex gap-3">
                        <div class="text-blue-600 mt-1">
                            ✉️
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide font-semibold text-gray-400">Email</p>
                            <a
                                href="mailto:{{ $settings->email }}"
                                class="text-sm font-medium text-gray-700 hover:text-blue-600 break-all"
                            >
                                {{ $settings->email }}
                            </a>
                        </div>
                    </div>

                    <!-- PHONE -->
                    <div class="flex gap-3">
                        <div class="text-blue-600 mt-1">
                            📞
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide font-semibold text-gray-400">Phone</p>
                            <a
                                href="tel:{{ $settings->phone }}"
                                class="text-sm font-medium text-gray-700 hover:text-blue-600"
                            >
                                {{ $settings->phone }}
                            </a>
                        </div>
                    </div>

                    <!-- ADDRESS -->
                    <div class="flex gap-3 border-t border-gray-100 pt-4">
                        <div class="text-blue-600 mt-1">
                            📍
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide font-semibold text-gray-400">Office</p>
                            <p class="text-sm text-gray-600 leading-snug">
                                {!! nl2br(e($settings->address)) !!}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- BOTTOM BAR -->
        <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-500">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-gray-900">
                    {{ $settings->website_name ?? 'Bharat Stock Market Research' }}
                </span>
                <span class="hidden md:inline text-gray-300">|</span>
                <span>
                    {{ $settings->copyright_text ?? '© 2025 All rights reserved.' }}
                </span>
            </div>
        </div>

    </div>
</footer>
