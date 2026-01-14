@extends('layouts.user')

@section('content')
    <div class="py-12 bg-gray-50 min-h-screen mt-12">
        <div class="max-w-7xl mx-auto px-4">

            <div class="bg-white  border border-gray-200 rounded-sm p-8 md:p-16">

                <header class="mb-10 border-b border-gray-100 pb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $policy->name }}</h1>
                    <p class="text-sm text-gray-500 italic">
                        Last Updated: {{ $policy->activeContent->created_at->format('d F Y') }}
                    </p>
                </header>

                <div class="mb-8 text-gray-700 leading-relaxed font-medium">
                    {{ $policy->description }}
                </div>

                <article class="prose-custom">
                    {!! $policy->activeContent->content !!}
                </article>

                <div class="mt-20 pt-8 border-t border-gray-100 text-center">
                    <p class="text-[10px] uppercase tracking-widest text-gray-400">
                        &copy; {{ date('Y') }} Bharat Stock Research Market Communication Technologies Private Limited.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Typography to match your image style */
        .prose-custom h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
        }

        .prose-custom p {
            font-size: 0.95rem;
            line-height: 1.7;
            color: #374151;
            margin-bottom: 1.25rem;
            text-align: justify;
        }

        .prose-custom ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .prose-custom li {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            color: #374151;
        }
    </style>
@endsection
