@extends('layouts.app')

@section('content')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <div x-data="whyPlatformForm()" x-init="init()" class="max-w-7xl mx-auto grid grid-cols-12 gap-5 text-xs p-6">

        <aside class="col-span-4 bg-white rounded-lg shadow border border-gray-200 p-4">

            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="font-bold text-gray-800 text-xs">Why Platform Sections</h3>
                <button @click="createNew()" class="bg-blue-50 text-blue-600 px-2 py-1 rounded border border-blue-200 font-semibold hover:bg-blue-100 transition-colors">
                    ➕ New Section
                </button>
            </div>

            <div class="space-y-2 max-h-[70vh] overflow-y-auto pr-1">
                @foreach ($sections as $s)
                    <div class="border rounded-lg px-3 py-3 cursor-pointer flex justify-between items-center transition-all group"
                        :class="{
                            'bg-blue-50 border-blue-400 ring-1 ring-blue-400': section.id === {{ $s->id }},
                            'border-gray-100 hover:border-blue-300 bg-white': section.id !== {{ $s->id }},
                            'opacity-60': !{{ $s->is_active ? 'true' : 'false' }}
                        }"
                        @click="loadSection(
                            {{ $s->id }},
                            @js($s->badge),
                            @js($s->heading),
                            @js($s->subheading),
                            @js($s->closing_text),
                            @js($s->contents->first()?->content ?? ''),
                            @js($s->getFirstMediaUrl('why_platform_image')),
                            {{ $s->is_active ? 'true' : 'false' }}
                        )">
                        <div class="truncate mr-2">
                            <p class="font-bold text-gray-900 text-[11px] truncate">
                                {{ $s->heading }}
                            </p>
                            <p class="text-[10px] text-gray-500 truncate">
                                {{ $s->subheading }}
                            </p>
                        </div>

                        <span class="w-2.5 h-2.5 rounded-full border border-white shadow-sm flex-shrink-0" 
                              style="background: {{ $s->is_active ? '#22c55e' : '#cbd5e1' }}">
                        </span>
                    </div>
                @endforeach
            </div>
        </aside>

        <main class="col-span-8 bg-white rounded-lg shadow border border-gray-200 p-6">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="font-bold text-base text-gray-900" x-text="section.id ? 'Edit Section' : 'Create New Section'"></h2>
                    <p class="text-[10px] text-gray-500 italic" x-text="section.id ? 'Editing existing block ID: #' + section.id : 'Drafting a new content block'"></p>
                </div>

                <template x-if="section.id">
                    <form method="POST" :action="`{{ url('admin/about/why-platform') }}/${section.id}`"
                        @submit.prevent="confirmDelete($event)">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-50 text-red-600 px-3 py-1.5 rounded-md border border-red-100 hover:bg-red-100 transition-colors font-medium">
                            Delete Section
                        </button>
                    </form>
                </template>
            </div>

            <form method="POST" action="{{ url('admin/about/why-platform/store') }}" enctype="multipart/form-data"
                @submit="prepareSubmit()" class="space-y-6">
                @csrf

                <input type="hidden" name="id" x-model="section.id">

                <div class="grid grid-cols-2 gap-4">

                    <div class="flex flex-col gap-1">
                        <label class="font-bold text-gray-700 ml-1 uppercase text-[10px]">Badge Text</label>
                        <input class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none h-10 transition-all" 
                               name="badge" placeholder="e.g. Innovation" x-model="section.badge">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="font-bold text-gray-700 ml-1 uppercase text-[10px]">Subheading</label>
                        <input class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none h-10 transition-all" 
                               name="subheading" placeholder="e.g. How we lead" x-model="section.subheading">
                    </div>

                    <div class="flex flex-col gap-1 col-span-2">
                        <label class="font-bold text-gray-700 ml-1 uppercase text-[10px]">Main Heading</label>
                        <textarea class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" 
                                  rows="2" name="heading" placeholder="Enter the primary section title" x-model="section.heading"></textarea>
                    </div>

                    <div class="col-span-2 flex flex-col gap-2">
                        <label class="font-bold text-gray-700 ml-1 uppercase text-[10px]">Section Media</label>
                        <div class="border-2 border-dashed border-gray-200 rounded-lg p-4 bg-gray-50 flex flex-col items-center">
                            <input type="file" name="image" @change="previewImage($event)" class="text-[11px] mb-3 file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                            
                            <template x-if="imagePreview">
                                <div class="relative w-full">
                                    <img :src="imagePreview" class="h-48 w-full object-cover rounded-md border shadow-sm">
                                    <div class="absolute top-2 right-2 bg-black/50 text-white px-2 py-1 rounded text-[10px]">Current Preview</div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1 col-span-2">
                        <label class="font-bold text-gray-700 ml-1 uppercase text-[10px]">Closing Text</label>
                        <textarea class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all" 
                                  rows="2" name="closing_text" placeholder="Short text appearing at the bottom" x-model="section.closing_text"></textarea>
                    </div>

                    <div class="flex items-center gap-3 col-span-2 p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <input type="checkbox" name="is_active" value="1" x-model="section.is_active" 
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="font-bold text-gray-700">Display this section publicly</span>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-5 mt-4">
                    <label class="font-bold text-gray-700 ml-1 uppercase text-[10px] mb-2 block">Paragraph Content</label>
                    <div class="border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                        <div id="why-quill-editor" style="height: 250px;" class="bg-white"></div>
                    </div>
                    <input type="hidden" name="paragraphs[0][content]" :value="editorHtml">
                    <input type="hidden" name="paragraphs[0][sort_order]" value="0">
                </div>

                <div class="flex justify-end pt-2">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-lg text-xs shadow-md transform transition active:scale-95">
                        Save Section Changes
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>

    <script>
        function whyPlatformForm() {
            return {
                section: {
                    id: null,
                    badge: '',
                    heading: '',
                    subheading: '',
                    closing_text: '',
                    is_active: true,
                },

                quill: null,
                editorHtml: '',
                imagePreview: null,

                init() {
                    this.$nextTick(() => {
                        if (this.quill) return;

                        this.quill = new Quill('#why-quill-editor', {
                            theme: 'snow',
                            placeholder: 'Describe the benefits here...',
                            modules: {
                                toolbar: [
                                    ['bold', 'italic'],
                                    [{ list: 'ordered' }, { list: 'bullet' }],
                                    ['link', 'clean']
                                ]
                            }
                        });

                        this.quill.on('text-change', () => {
                            this.editorHtml = this.quill.root.innerHTML;
                        });
                    });
                },

                loadSection(id, badge, heading, subheading, closingText, content, image, isActive) {
                    this.section = {
                        id,
                        badge,
                        heading,
                        subheading,
                        closing_text: closingText,
                        is_active: isActive
                    };

                    this.editorHtml = content ?? '';
                    this.imagePreview = image ?? null;

                    if (this.quill) {
                        this.quill.root.innerHTML = this.editorHtml;
                    }
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                createNew() {
                    this.section = {
                        id: null,
                        badge: '',
                        heading: '',
                        subheading: '',
                        closing_text: '',
                        is_active: true
                    };

                    this.editorHtml = '';
                    this.imagePreview = null;

                    if (this.quill) {
                        this.quill.root.innerHTML = '';
                    }
                },

                previewImage(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.imagePreview = URL.createObjectURL(file);
                    }
                },

                prepareSubmit() {
                    if (this.quill) {
                        this.editorHtml = this.quill.root.innerHTML;
                    }
                },

                confirmDelete(e) {
                    if (confirm('Permanently delete this section? This action cannot be undone.')) {
                        e.target.submit();
                    }
                }
            }
        }
    </script>

    <style>
        .ql-toolbar.ql-snow {
            border: none !important;
            border-bottom: 1px solid #d1d5db !important;
            background: #f8fafc;
        }
        .ql-container.ql-snow {
            border: none !important;
        }
        .ql-editor {
            font-size: 13px;
        }
    </style>
@endsection