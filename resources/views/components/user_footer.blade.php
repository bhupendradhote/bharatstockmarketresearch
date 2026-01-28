<footer class="bg-gray-50 border-t border-gray-200 pt-20 pb-10 font-sans" id="footer"
    x-data="{ visible: false }"
    x-intersect.once="visible = true">

    <div class="mx-auto px-6 max-w-[1600px]"
         :class="{ 'opacity-100 translate-y-0': visible, 'opacity-0 translate-y-10': !visible }"
         class="transition-all duration-700 ease-out transform">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 mb-16">

            <div class="lg:col-span-4 flex flex-col gap-6">
                <div class="space-y-4">
                    @if (isset($brand) && $brand)
                        <div class="flex items-center gap-3">
                            @if ($brand->icon_svg)
                                <div class="w-8 h-8 text-blue-600">{!! $brand->icon_svg !!}</div>
                            @elseif($brand->image)
                                <img src="{{ asset('uploads/footer/' . $brand->image) }}" class="w-8 h-8 object-contain">
                            @else
                                <div class="w-8 h-8 bg-blue-600 rounded-lg shadow-sm"></div>
                            @endif

                            <h2 class="font-bold text-xl text-gray-900 tracking-tight">
                                {{ $brand->title }}
                            </h2>
                        </div>

                        @if ($brand->subtitle)
                            <p class="text-gray-500 text-sm font-medium">{{ $brand->subtitle }}</p>
                        @endif

                        @if ($brand->description)
                            <p class="text-gray-600 text-sm leading-relaxed max-w-sm">
                                {{ $brand->description }}
                            </p>
                        @endif

                        @if ($brand->content)
                            <p class="text-gray-600 text-sm leading-relaxed">{!! nl2br(e($brand->content)) !!}</p>
                        @endif

                        @if ($brand->note)
                            <p class="text-gray-400 text-xs italic">{{ $brand->note }}</p>
                        @endif

                        @if ($brand->button_text && $brand->button_link)
                            <div class="pt-2">
                                <a href="{{ $brand->button_link }}"
                                   class="inline-flex items-center justify-center bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition-all shadow-sm hover:shadow-md">
                                    {{ $brand->button_text }}
                                </a>
                            </div>
                        @endif

                    @else
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg"></div>
                            <h2 class="font-bold text-xl text-gray-900 tracking-tight">
                                {{ $settings->website_name ?? 'Bharat Stock Market Research' }}
                            </h2>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed max-w-sm">
                            {{ $settings->description ?? 'Save Money, Time and Efforts with our premium research tools.' }}
                        </p>
                    @endif
                </div>

                @if(isset($socials) && count($socials) > 0)
                    <div class="flex items-center gap-4 mt-2">
                        @foreach ($socials as $s)
                            <a href="{{ $s->url }}" target="_blank"
                               class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-600 hover:text-blue-600 hover:border-blue-600 hover:shadow-md transition-all duration-300">
                                <i class="{{ $s->icon }} text-lg"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="lg:col-span-5 grid grid-cols-2 gap-8 sm:gap-12">
                @foreach ($columns as $col)
                    <div>
                        <h3 class="font-bold text-gray-900 text-xs uppercase tracking-wider mb-6">
                            {{ $col->title }}
                        </h3>
                        <ul class="space-y-3">
                            @foreach ($col->links()->active()->get() as $link)
                                <li>
                                    <a href="{{ $link->url }}"
                                       class="text-gray-600 hover:text-blue-600 text-sm transition-colors duration-200 flex items-center group">
                                       <span class="w-0 overflow-hidden group-hover:w-2 transition-all duration-300 opacity-0 group-hover:opacity-100 text-blue-400 mr-0 group-hover:mr-1">&rsaquo;</span>
                                       {{ $link->label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-3">
                <h3 class="font-bold text-gray-900 text-xs uppercase tracking-wider mb-6">
                    Contact Us
                </h3>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-5 h-5 text-blue-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide">Email</p>
                            <a href="mailto:{{ $settings->email }}" class="text-sm text-gray-700 hover:text-blue-600 font-medium break-all">
                                {{ $settings->email }}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-5 h-5 text-blue-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide">Phone</p>
                            <a href="tel:{{ $settings->phone }}" class="text-sm text-gray-700 hover:text-blue-600 font-medium">
                                {{ $settings->phone }}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 pt-2 border-t border-gray-100 mt-2">
                        <div class="mt-1 w-5 h-5 text-blue-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        </div>
                        <div>
                             <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide">Office</p>
                            <p class="text-sm text-gray-600 leading-snug">
                                {!! nl2br(e($settings->address)) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
            <div class="flex flex-col md:flex-row items-center gap-1 md:gap-4">
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