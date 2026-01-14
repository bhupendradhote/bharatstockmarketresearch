@extends('layouts.user')
@section('content')
    <section class="w-full px-4 md:px-8 lg:px-16 mt-28 flex justify-center">
        <div class="max-w-[1600px] w-full">
            <div class="flex justify-between items-end mb-10 border-b border-gray-100 pb-6">
                <div>
                    <h1 class="text-3xl font-bold text-[#0939a4]">News Archive</h1>
                    <p class="text-gray-500">Discover all our news and updates.</p>
                </div>
                <form action="{{ route('news.archive') }}" method="GET">
                    <select name="sort" onchange="this.form.submit()"
                        class="rounded-xl border-gray-200 text-sm focus:ring-indigo-500">
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </form>
            </div>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-10">
                @foreach ($allNews as $item)
                    <a href="{{ route('news.show', $item->slug) }}"
                        class="bg-[#F5F7FB] rounded-2xl p-4 shadow-sm hover:shadow-md transition">
                        <img src="{{ $item->getFirstMediaUrl('thumbnail') ?: 'https://via.placeholder.com/600x400' }}"
                            class="w-full h-[180px] object-cover rounded-xl" />
                        <span class="inline-block mt-4 px-3 py-1 rounded-full text-[10px] text-white font-bold uppercase"
                            style="background-color: {{ $item->category->color_code ?? '#0939a4' }}">
                            {{ $item->category->name }}
                        </span>
                        <h3 class="mt-2 text-[18px] font-semibold text-[#0939a4]">{{ $item->title }}</h3>
                        <p class="text-gray-500 text-xs mt-2">{{ $item->published_at->format('M d, Y') }}</p>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">{{ $allNews->links() }}</div>
        </div>
    </section>
@endsection
