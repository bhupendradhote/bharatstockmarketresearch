@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="flex justify-between items-center mb-6 px-4">
            <h1 class="text-2xl font-bold text-gray-800">Policy Master Manager</h1>
            <div class="flex space-x-3">
                <a href="{{ route('admin.policies.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition font-semibold text-sm">
                    + Add/Update Policy
                </a>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden mx-4 border border-gray-200 mb-8">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3 border-b border-gray-200">Policy Name</th>
                        <th class="px-5 py-3 border-b border-gray-200">Current Version</th>
                        <th class="px-5 py-3 border-b border-gray-200">Last Updated</th>
                        <th class="px-5 py-3 border-b border-gray-200 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($policies as $policy)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm">
                                <p class="font-bold text-gray-800">{{ $policy->name }}</p>
                            </td>
                            <td class="px-5 py-4 text-sm">
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                    v{{ $policy->activeContent->version_number ?? '1' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                {{ $policy->activeContent->created_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4 text-sm text-center space-x-3">
                                <a href="{{ route('admin.policies.edit', $policy->id) }}"
                                    class="text-indigo-600 hover:underline font-bold">Edit/Update</a>
                                <button type="button" onclick="togglePreview({{ $policy->id }})"
                                    class="text-green-600 hover:underline font-bold">
                                    Preview
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Preview Section (Initially hidden) -->
        <div id="preview-container" class="hidden px-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-600">Policy Preview</h2>
                <button type="button" onclick="closePreview()"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm font-bold">
                    Close Preview
                </button>
            </div>

            <!-- Preview content will be dynamically inserted here -->
            <div id="preview-content"></div>
        </div>
    </div>

    <!-- Hidden template for policy preview -->
    <template id="policy-template">
        <div class="policy-container mb-12">
            <div
                class="flex justify-between items-center mb-4 bg-gray-100 p-3 rounded-t-lg border border-b-0 border-gray-200">
                <span class="text-sm font-bold text-gray-600 uppercase tracking-widest">Preview: <span
                        class="policy-name"></span></span>
                <a href="#"
                    class="edit-link bg-white border border-gray-300 px-3 py-1 rounded text-xs font-bold hover:bg-gray-50">
                    Edit Content
                </a>
            </div>

            <div class="bg-white shadow-xl border border-gray-200 rounded-b-lg p-10 lg:p-16 mx-auto w-full">
                <h1 class="text-3xl font-bold text-gray-900 mb-1 policy-name"></h1>
                <p class="text-sm text-gray-500 mb-8">Updated on: <span class="updated-date"></span></p>

                <div class="prose prose-slate max-w-none">
                    <div class="policy-content text-gray-800 leading-relaxed text-justify">
                        <!-- Content will be inserted here -->
                    </div>
                </div>

                <div class="mt-16 pt-8 border-t border-gray-100 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} Bharat Stock Research Market Communication Technologies Private Limited.
                </div>
            </div>
        </div>
    </template>

    <style>
        /* Document Styling to match the provided image precisely */
        .policy-content h1,
        .policy-content h2,
        .policy-content h3 {
            color: #111827;
            font-weight: 700;
            font-size: 1.25rem;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #f3f4f6;
            display: block;
            padding-bottom: 4px;
        }

        .policy-content p {
            font-size: 0.95rem;
            margin-bottom: 1.25rem;
            color: #374151;
            line-height: 1.7;
            text-align: justify;
        }

        .policy-content strong {
            color: #111827;
            font-weight: 600;
        }

        .policy-content ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .policy-content li {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            color: #374151;
        }

        /* Animation for preview */
        #preview-container {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Print optimization */
        @media print {
            .policy-container {
                page-break-after: always;
            }

            body {
                background: white;
            }
        }
    </style>

    <script>
        // Store policy data in JavaScript object for easy access
        const policiesData = {
            @foreach ($policies as $policy)
                {{ $policy->id }}: {
                    id: {{ $policy->id }},
                    name: `{{ addslashes($policy->name) }}`,
                    version: `{{ $policy->activeContent->version_number ?? '1' }}`,
                    updated_at: `{{ $policy->activeContent->created_at->format('d F Y') }}`,
                    content: `{!! addslashes($policy->activeContent->content) !!}`,
                    edit_url: `{{ route('admin.policies.edit', $policy->id) }}`
                },
            @endforeach
        };

        function togglePreview(policyId) {
            const previewContainer = document.getElementById('preview-container');
            const previewContent = document.getElementById('preview-content');

            // Clear previous content
            previewContent.innerHTML = '';

            // Get policy data
            const policy = policiesData[policyId];

            if (!policy) {
                alert('Policy data not found!');
                return;
            }

            // Get template
            const template = document.getElementById('policy-template');
            const clone = template.content.cloneNode(true);

            // Fill template with data
            const policyContainer = clone.querySelector('.policy-container');
            policyContainer.querySelector('.policy-name').textContent = policy.name;
            policyContainer.querySelectorAll('.policy-name')[1].textContent = policy.name;
            policyContainer.querySelector('.updated-date').textContent = policy.updated_at;
            policyContainer.querySelector('.policy-content').innerHTML = policy.content;
            policyContainer.querySelector('.edit-link').href = policy.edit_url;

            // Add to preview container
            previewContent.appendChild(policyContainer);

            // Show preview container
            previewContainer.classList.remove('hidden');

            // Scroll to preview section
            previewContainer.scrollIntoView({
                behavior: 'smooth'
            });
        }

        function closePreview() {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.classList.add('hidden');
        }

        // Close preview when clicking escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePreview();
            }
        });
    </script>
@endsection
