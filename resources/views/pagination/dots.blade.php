@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-3 mt-3 select-none text-[11px]">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="text-blue-300 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="text-blue-600 hover:text-blue-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            {{-- Dots separator --}}
            @if (is_string($element))
                <span class="px-1 text-gray-400 text-[10px]">{{ $element }}</span>
            @endif

            @if (is_array($element))
                <div class="flex items-center gap-2">
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white font-bold text-[10px] shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="w-6 h-6 flex items-center justify-center rounded-full bg-white border border-gray-200 text-[10px] text-gray-700 hover:bg-blue-50 transition shadow-sm">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="text-blue-600 hover:text-blue-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @else
            <span class="text-blue-300 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        @endif

    </nav>
@endif
