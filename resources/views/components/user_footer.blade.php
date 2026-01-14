<!-- FOOTER -->
<footer class="flex justify-center" id="footer">
    <div class="flex bg-[#F5F7FB] w-full flex-col px-8 mt-20 pt-16 pb-10 gap-10 max-w-[1600px]" x-data="{ sectionVisible: false }"
        x-intersect.half="sectionVisible = true" :class="{ 'animate-section animated': sectionVisible }">

        <!-- TOP GRID -->
        <div class="grid md:grid-cols-4 gap-12">

            <!-- BRAND BLOCK -->
            <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                class="fade-up">

                @if (isset($brand) && $brand)

                    <div class="flex items-center gap-2">
                        <!-- ICON -->
                        @if ($brand->icon_svg)
                            <div class="w-7 h-7">{!! $brand->icon_svg !!}</div>
                        @elseif($brand->image)
                            <img src="{{ asset('uploads/footer/' . $brand->image) }}" class="w-7 h-7 object-contain">
                        @else
                            <div class="w-7 h-7 bg-blue-600 rounded-full"></div>
                        @endif

                        <!-- TITLE -->
                        <h2 class="font-semibold text-lg text-gray-900">
                            {{ $brand->title }}
                        </h2>
                    </div>

                    <!-- SUBTITLE -->
                    @if ($brand->subtitle)
                        <p class="text-gray-500 text-sm mt-1">{{ $brand->subtitle }}</p>
                    @endif

                    <!-- DESCRIPTION -->
                    @if ($brand->description)
                        <p class="text-gray-600 mt-4">{{ $brand->description }}</p>
                    @endif

                    <!-- EXTRA CONTENT -->
                    @if ($brand->content)
                        <p class="text-gray-600 mt-4">{!! nl2br(e($brand->content)) !!}</p>
                    @endif

                    <!-- NOTE -->
                    @if ($brand->note)
                        <p class="text-gray-400 text-xs mt-3 italic">{{ $brand->note }}</p>
                    @endif

                    <!-- BUTTON -->
                    @if ($brand->button_text && $brand->button_link)
                        <a href="{{ $brand->button_link }}"
                            class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-full text-sm hover:bg-blue-700 transition">
                            {{ $brand->button_text }}
                        </a>
                    @endif
                @else
                    <!-- DEFAULT STATIC -->
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 bg-blue-600 rounded-full"></div>
                        <h2 class="font-semibold text-lg text-gray-900">
                            {{ $settings->website_name ?? 'Bharat Stock Market Research' }}
                        </h2>
                    </div>

                    <p class="text-gray-600 mt-4">
                        {{ $settings->description ?? 'Save Money, Time and Efforts' }}
                    </p>
                @endif

            </div>

            <!-- EMPTY GRID SPACERS (match UI) -->
            <div></div>
            <div></div>

            <!-- FOLLOW US -->
            <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                class="fade-up delay-100">

                <h3 class="font-semibold text-gray-900 mb-3 text-base">Follow Us</h3>

                <div class="flex gap-4 text-gray-800 mb-6 text-2xl">
                    @foreach ($socials as $s)
                        <a href="{{ $s->url }}" target="_blank">
                            <i
                                class="{{ $s->icon }} hover:text-blue-600 transition duration-300 cursor-pointer"></i>
                        </a>
                    @endforeach
                </div>

            </div>

        </div>

        <!-- FOOTER COLUMNS -->
        <div class="grid md:grid-cols-4 gap-12">

            @foreach ($columns as $col)
                <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                    class="fade-up delay-200">

                    <h3 class="font-semibold text-gray-900 mb-4 text-base">
                        {{ $col->title }}
                    </h3>

                    <ul class="space-y-2 text-gray-600">
                        @foreach ($col->links()->active()->get() as $link)
                            <li>
                                <a href="{{ $link->url }}" class="hover:text-black transition duration-300 text-sm">
                                    {{ $link->label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div>
            @endforeach

            <!-- CONTACT SECTION -->
            <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
                class="fade-up delay-500">

                <p class="text-gray-600 text-sm">
                    <span class="font-semibold">Email :</span> {{ $settings->email }}
                </p>

                <p class="text-gray-600 mt-4 text-sm">
                    <span class="font-semibold">Address :</span>
                    {!! nl2br(e($settings->address)) !!}
                </p>

                <p class="text-gray-600 mt-4 text-sm">
                    <span class="font-semibold">Phone No :</span> {{ $settings->phone }}
                </p>

            </div>

        </div>

        <!-- COPYRIGHT -->
        <div x-data="{ visible: false }" x-intersect.half="visible = true" :class="{ 'animated': visible }"
            class="fade-up delay-600 mt-16 border-t pt-6 text-center text-gray-600 text-sm">

            <p class="font-semibold text-gray-900 text-sm">
                {{ $settings->website_name ?? 'Bharath Stock Market Research' }}
            </p>

            <p class="mt-1 text-xs">
                {{ $settings->copyright_text ?? '2025 Bharath Stock Market Research. All rights reserved' }}
            </p>

        </div>

    </div>
</footer>
