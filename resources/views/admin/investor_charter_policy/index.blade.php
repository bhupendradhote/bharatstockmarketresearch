@extends('layouts.app')

@section('content')
    <div class="p-6 space-y-10">

        {{-- ================= HEADER ================= --}}
        <div class="flex justify-between items-center">
            <h1 class="text-lg font-semibold">Investor Charter Policies</h1>

            <a href="{{ route('admin.investor-charter-policy.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                + Create Policy
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- ================= TABLE ================= --}}
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Title</th>
                        <th class="p-3">Version</th>
                        <th class="p-3">Pages</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($policies as $policy)
                        <tr class="border-t">
                            <td class="p-3">{{ $policy->title }}</td>
                            <td class="p-3 text-center">{{ $policy->version }}</td>
                            <td class="p-3 text-center">{{ $policy->pages_count }}</td>
                            <td class="p-3 text-center">
                                @if ($policy->is_active)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-gray-200 text-gray-600 rounded">Archived</span>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                {{ $policy->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                No policies found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ================= PREVIEW ================= --}}
        @if ($activePolicy)
            <div class="border-t pt-10">

                <h2 class="text-lg font-semibold mb-6">
                    Investor Charter Preview
                    <span class="text-sm text-gray-500">(Version {{ $activePolicy->version }})</span>
                </h2>

                <div class="space-y-10 bg-gray-100 p-6 rounded-lg">

                    @foreach ($activePolicy->pages as $index => $page)
                        <section class="bg-white max-w-5xl mx-auto p-8 rounded shadow page">

                            {{-- PAGE HEADER --}}
                            <div class="mb-6 text-center">
                                <h3 class="text-xl font-semibold uppercase">
                                    {{ $index === 0 ? $activePolicy->title : $page->page_title }}
                                </h3>

                                <p class="text-xs text-gray-500 mt-1">
                                    Page {{ $index + 1 }} of {{ $activePolicy->pages->count() }}
                                    | Last Updated: {{ $activePolicy->effective_from->format('d M Y') }}
                                </p>
                            </div>

                            {{-- PAGE CONTENT --}}
                            <div class="text-sm text-gray-700 leading-relaxed space-y-4">
                                {!! $page->content !!}
                            </div>

                        </section>
                    @endforeach

                </div>
            </div>
        @endif

    </div>

    <style>
        .page {
            page-break-after: always;
        }
    </style>
@endsection
