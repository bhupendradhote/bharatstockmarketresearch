@extends('layouts.user')

@section('content')
    @php
        use App\Models\PolicyMaster;

        $policies = PolicyMaster::where('is_enabled', 1)
            ->with(['activeContent'])
            ->orderBy('id')
            ->get();

        $firstPolicy = $policies->first();
    @endphp

    <div class="max-w-7xl mx-auto px-4 mt-36">

        <!-- ================= HERO ================= -->
        <section class="text-center mb-14">
            <span
                class="inline-flex items-center gap-2 bg-indigo-50 text-[#0939a4] text-sm font-semibold px-4 py-1.5 rounded-full mb-5">
                ⚖ Legal Information
            </span>



            <p class="max-w-3xl mx-auto text-lg text-slate-500">
                Complete transparency in our regulatory compliance, terms of service,
                and legal obligations as a SEBI registered research analyst at
                <strong>Bharat Stock Market Research</strong>.
            </p>
        </section>

        <!-- ================= TABS ================= -->
        <div class="bg-slate-100 p-2 rounded-xl mb-6">
            <div class="flex flex-wrap gap-2 justify-around">
                @foreach ($policies as $policy)
                    <button type="button" data-target="{{ $policy->slug }}"
                        class="policy-tab
                    px-4 py-2
                    rounded-lg
                    text-sm font-medium
                    whitespace-nowrap
                    transition-all duration-200
                    {{ $policy->id === $firstPolicy->id
                        ? 'bg-white text-slate-900 shadow ring-1 ring-slate-200'
                        : 'text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}">
                        {{ $policy->name }}
                    </button>
                @endforeach
            </div>
        </div>


        <!-- ================= CONTENT CARD ================= -->
        <div class="bg-white rounded-2xl shadow-xl p-8">

            @foreach ($policies as $policy)
                <div id="{{ $policy->slug }}" class="policy-content {{ $policy->id === $firstPolicy->id ? '' : 'hidden' }}">

                    <h2 class="text-2xl font-bold text-slate-900 mb-1">
                        {{ $policy->name }}
                    </h2>

                    @if ($policy->title)
                        <p class="text-slate-500 mb-4">
                            {{ $policy->title }}
                        </p>
                    @endif

                    @if ($policy->description)
                        <p class="text-slate-700 mb-6">
                            {{ $policy->description }}
                        </p>
                    @endif

                    <!-- CKEDITOR CONTENT -->
                    <div class="policy-editor-content">
                        {!! optional($policy->activeContent)->content ?? '<p>Content not available.</p>' !!}
                    </div>

                </div>
            @endforeach

        </div>
    </div>

    <!-- ================= TAB SCRIPT (FIXED) ================= -->
    <script>
        const tabs = document.querySelectorAll('.policy-tab');
        const contents = document.querySelectorAll('.policy-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // reset tabs
                tabs.forEach(t => {
                    t.classList.remove('bg-white', 'text-slate-900', 'shadow');
                    t.classList.add('text-slate-600');
                });

                // hide all contents
                contents.forEach(c => c.classList.add('hidden'));

                // activate current
                tab.classList.add('bg-white', 'text-slate-900', 'shadow');
                tab.classList.remove('text-slate-600');

                const target = document.getElementById(tab.dataset.target);
                if (target) target.classList.remove('hidden');
            });
        });
    </script>

    <!-- ================= CKEDITOR CONTENT FIX ================= -->
    <style>
        .policy-editor-content h1,
        .policy-editor-content h2,
        .policy-editor-content h3 {
            margin: 1.25rem 0 0.5rem;
            font-weight: 600;
        }

        .policy-editor-content p {
            margin-bottom: 0.75rem;
            line-height: 1.8;
            color: #1f2937;
        }

        .policy-editor-content ul,
        .policy-editor-content ol {
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .policy-editor-content ul li {
            list-style: disc;
            margin-bottom: 0.5rem;
        }

        .policy-editor-content ol li {
            list-style: decimal;
            margin-bottom: 0.5rem;
        }

        .policy-editor-content strong {
            font-weight: 600;
        }

        .policy-editor-content a {
            color: #2563eb;
            text-decoration: underline;
        }

        .policy-editor-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .policy-editor-content th,
        .policy-editor-content td {
            border: 1px solid #e5e7eb;
            padding: 0.5rem;
            text-align: left;
        }
    </style>
@endsection
