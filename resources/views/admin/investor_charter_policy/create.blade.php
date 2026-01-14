@extends('layouts.app')

@section('content')
    <div class="p-6 max-w-7xl mx-auto grid grid-cols-12 gap-6">

        {{-- LEFT --}}
        <div class="col-span-9 space-y-6">

            <h1 class="text-lg font-semibold">Create Investor Charter Policy</h1>

            <form method="POST" action="{{ route('admin.investor-charter-policy.store') }}">
                @csrf

                {{-- Policy Info --}}
                <div class="bg-white p-4 rounded shadow space-y-3 text-sm">
                    <div>
                        <label class="text-xs font-medium">Title</label>
                        <input type="text" name="title" value="Investor Charter"
                            class="w-full border rounded px-2 py-1 text-xs">
                    </div>

                    <div>
                        <label class="text-xs font-medium">Version (Auto)</label>
                        <input type="text" value="{{ $nextVersion }}" readonly
                            class="w-full border rounded px-2 py-1 text-xs bg-gray-100">
                    </div>

                    <div>
                        <label class="text-xs font-medium">Description</label>
                        <textarea name="description" rows="2" class="w-full border rounded px-2 py-1 text-xs"></textarea>
                    </div>
                </div>

                {{-- Pages --}}
                <div id="pagesWrapper" class="space-y-4">

                    {{-- PAGE 1 --}}
                    <div class="bg-white rounded shadow text-sm page-card">
                        <div class="flex justify-between items-center px-4 py-2 border-b cursor-pointer"
                            onclick="togglePage(this)">
                            <span class="font-medium text-xs page-label">Page 1</span>
                            <span class="text-xs text-gray-400">Required</span>
                        </div>

                        <div class="p-4 space-y-3 page-content">
                            <input type="text" name="pages[0][page_title]" placeholder="Page Title"
                                class="w-full border rounded px-2 py-1 text-xs">

                            <textarea name="pages[0][content]" class="ckeditor w-full border rounded px-2 py-1 text-xs" rows="4"></textarea>
                        </div>
                    </div>

                </div>

                <button type="button" onclick="addPage()" class="px-3 py-1 text-xs bg-gray-700 text-white rounded">
                    + Add Page
                </button>

                <button class="px-5 py-2 bg-blue-600 text-white text-sm rounded ml-2">
                    Save Policy
                </button>

            </form>
        </div>

        {{-- RIGHT --}}
        <div class="col-span-3">
            <div class="bg-white rounded shadow p-4 text-xs sticky top-20">
                <h3 class="font-semibold mb-3">Pages</h3>
                <ul id="pageManager" class="space-y-2"></ul>
            </div>
        </div>

    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <script>
        let editors = [];

        document.addEventListener('DOMContentLoaded', () => {
            initEditors();
            syncSidebar();
        });

        function initEditors() {
            document.querySelectorAll('.ckeditor').forEach((el, i) => {
                ClassicEditor.create(el).then(editor => {
                    editors[i] = editor;
                });
            });
        }

        function togglePage(header) {
            header.nextElementSibling.classList.toggle('hidden');
        }

        function addPage() {
            const wrapper = document.getElementById('pagesWrapper');

            wrapper.insertAdjacentHTML('beforeend', `
        <div class="bg-white rounded shadow text-sm page-card">
            <div class="flex justify-between items-center px-4 py-2 border-b cursor-pointer"
                onclick="togglePage(this)">
                <span class="font-medium text-xs page-label"></span>
                <button type="button" onclick="removePage(this)"
                    class="text-red-500 text-xs">Remove</button>
            </div>

            <div class="p-4 space-y-3 page-content">
                <input type="text" class="page-title-input w-full border rounded px-2 py-1 text-xs"
                    placeholder="Page Title">

                <textarea class="ckeditor w-full border rounded px-2 py-1 text-xs"
                    rows="4"></textarea>
            </div>
        </div>
    `);

            reIndexPages();
        }

        function removePage(btn) {
            if (!confirm('Remove this page?')) return;

            btn.closest('.page-card').remove();
            reIndexPages();
        }

        function reIndexPages() {
            editors.forEach(e => e && e.destroy());
            editors = [];

            document.querySelectorAll('.page-card').forEach((card, index) => {

                // Label
                card.querySelector('.page-label').innerText = `Page ${index + 1}`;

                // Inputs
                card.querySelector('input').name = `pages[${index}][page_title]`;
                card.querySelector('textarea').name = `pages[${index}][content]`;

            });

            initEditors();
            syncSidebar();
        }

        function syncSidebar() {
            const sidebar = document.getElementById('pageManager');
            sidebar.innerHTML = '';

            document.querySelectorAll('.page-card').forEach((_, i) => {
                sidebar.insertAdjacentHTML('beforeend', `
            <li onclick="scrollToPage(${i})"
                class="cursor-pointer px-2 py-1 rounded bg-gray-100 hover:bg-gray-200">
                Page ${i + 1}
            </li>
        `);
            });
        }

        function scrollToPage(index) {
            document.querySelectorAll('.page-card')[index]
                .scrollIntoView({
                    behavior: 'smooth'
                });
        }
    </script>
@endsection
