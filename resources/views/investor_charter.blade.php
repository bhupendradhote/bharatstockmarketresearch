@extends('layouts.user')

@section('content')
    <div class="bg-black py-10 mt-24 main-print">

        <style>
            .page {
                page-break-after: always;
            }

            @media print {
                .page {
                    page-break-after: always;
                }

                .main-header,
                .support-chat {
                    display: none;
                }

                .main-print {
                    margin-top: 0;
                }

                button {
                    display: none;
                }


            }
        </style>

        @foreach ($policy->pages as $index => $page)
            <section class="page max-w-5xl mx-auto bg-white p-10 mb-10 rounded-md shadow">

                {{-- PAGE TITLE --}}
                @if ($index === 0)
                    <h1 class="text-2xl font-semibold mb-2 text-center uppercase">
                        {{ $policy->title }}
                    </h1>
                @else
                    <h2 class="text-xl font-semibold mb-2">
                        {{ $page->page_title }}
                    </h2>
                @endif

                {{-- PAGE META --}}
                <p class="text-sm text-gray-500 {{ $index === 0 ? 'text-center' : '' }} mb-8">
                    Page {{ $index + 1 }} of {{ $policy->pages->count() }}
                    | Last Updated: {{ $policy->effective_from->format('d F Y') }}
                </p>

                {{-- PAGE CONTENT --}}
                <div class="text-sm text-gray-700 space-y-4 leading-relaxed">
                    {!! $page->content !!}
                </div>

            </section>
        @endforeach

    </div>
@endsection
