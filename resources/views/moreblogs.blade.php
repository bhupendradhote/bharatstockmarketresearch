


@extends('layouts.user')
@section('content')
    <!-- HERO SECTION -->
    @if ($banner)
        <section class="w-full flex justify-center px-4 md:px-8 lg:px-16 mt-28">
            <div class="max-w-[1600px] w-full bg-[#F5F7FB] rounded-[28px]
        flex flex-col items-center text-center px-4 md:px-10 py-20 md:py-28 lg:py-32"
                style="min-height: 300px;">

                <span data-animate
                    class="fade-up delay-100 inline-block bg-[#0939a4] text-white px-6 py-2 rounded-full text-sm md:text-base mb-6">
                    {{ $banner->title ?? 'Blog' }}
                </span>

                <h1 data-animate
                    class="fade-up delay-200 text-[22px] md:text-[30px] lg:text-[36px]
            font-semibold text-[#0939a4] leading-snug">
                    {{ $banner->subtitle ?? 'Featured insights and articles' }}
                </h1>

            </div>
        </section>
    @endif


    <!-- BLOG GRID SECTION -->
    <section class="w-full px-4 md:px-8 lg:px-16 mt-16 flex justify-center">
        <div class="max-w-[1600px] w-full">

            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-10">

                @foreach ($blogs as $blog)
                    <a href="{{ route('blogdetails', $blog->slug) }}" data-animate
                        class="fade-up delay-100 bg-[#F5F7FB] rounded-2xl p-4 shadow-sm">

                        <!-- IMAGE -->
                        <img src="{{ $blog->getFirstMediaUrl('thumbnail') ?: 'https://via.placeholder.com/600x400' }}"
                            class="w-full h-[180px] object-cover rounded-xl" />

                        <!-- TITLE -->
                        <h3 class="mt-4 text-[16px] md:text-[18px] font-semibold text-[#0939a4]">
                            {{ $blog->title }}
                        </h3>

                        <!-- DESCRIPTION -->
                        <p class="text-gray-600 text-sm mt-1">
                            {{ Str::limit($blog->short_description, 80) }}
                        </p>

                        <!-- AUTHOR ROW -->
                        <div class="flex items-center gap-3 mt-4">
                            {{-- <img src="{{ $blog->getFirstMediaUrl('author') ?: 'https://via.placeholder.com/100' }}"
                                class="w-8 h-8 rounded-full object-cover" /> --}}

                            <div class="text-xs text-gray-700">
                                {{-- <p class="font-medium">
                                    {{ $blog->author_name ?? 'Admin' }}
                                </p> --}}
                                <p class="text-gray-500">
                                    {{ optional($blog->published_at)->format('F d, Y') }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>

            <!-- PAGINATION -->
            {{-- <div class="mt-12">
                {{ $blogs->links() }}
            </div> --}}

        </div>
    </section>
@endsection
