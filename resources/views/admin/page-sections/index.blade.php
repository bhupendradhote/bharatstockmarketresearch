@extends('layouts.app')

@section('content')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <div x-data="pageSectionManager()" x-init="init()" class="max-w-7xl mx-auto grid grid-cols-12 gap-4 text-[11px]">

        <!-- ================= LEFT SIDEBAR ================= -->
        <aside class="col-span-4 bg-white rounded-lg shadow p-3">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-semibold text-xs">Sections</h3>

                <select x-model="filterPage" @change="filterByPage()" class="border rounded px-2 py-1 text-[11px]">
                    <option value="">all</option>
                    <option value="home">home</option>
                    <option value="about">about</option>
                    <option value="services">services</option>
                    <option value="contact">contact</option>
                </select>
            </div>

            <div class="space-y-1.5 max-h-[560px] overflow-y-auto">
                <template x-for="item in sections" :key="item.id">
                    <div @click="edit(item)" class="border rounded px-2.5 py-2 cursor-pointer hover:bg-gray-50"
                        :class="{ 'bg-blue-50 border-blue-400': form.id === item.id }">

                        <p class="font-medium text-[11px]" x-text="item.title || 'No title'"></p>
                        <p class="text-[10px] text-gray-500">
                            <span x-text="item.page_type"></span> •
                            <span x-text="item.section_key"></span>
                        </p>
                    </div>
                </template>
            </div>
        </aside>

        <!-- ================= RIGHT PANEL ================= -->
        <section class="col-span-8 bg-white rounded-lg shadow">

            <!-- HEADER -->
            <div class="flex justify-between items-center px-4 py-2 border-b">
                <h2 class="font-semibold text-xs" x-text="form.id ? 'Edit Section' : 'Create Section'"></h2>

                <button @click="resetForm()" class="text-blue-600 text-[11px]">
                    + New
                </button>
            </div>

            <!-- FORM -->
            <form @submit.prevent="submit()" class="p-4 space-y-4">

                <!-- BASIC -->
                <div class="grid grid-cols-3 gap-2">
                    <select x-model="form.page_type" required class="border rounded px-2 py-1.5 text-[11px]">
                        <option value="">page</option>
                        <option value="home">home</option>
                        <option value="about">about</option>
                        <option value="services">services</option>
                        <option value="contact">contact</option>
                    </select>

                    <input x-model="form.section_key" placeholder="section key"
                        class="border rounded px-2 py-1.5 text-[11px]">

                    <label class="flex items-center gap-1 text-[11px]">
                        <input type="checkbox" x-model="form.status">
                        Active
                    </label>
                </div>

                <!-- TITLES -->
                <div class="grid grid-cols-3 gap-2">
                    <input x-model="form.title" placeholder="Title" class="border rounded px-2 py-1.5 text-[11px]">
                    <input x-model="form.subtitle" placeholder="Subtitle" class="border rounded px-2 py-1.5 text-[11px]">
                    <input x-model="form.badge" placeholder="Badge" class="border rounded px-2 py-1.5 text-[11px]">
                </div>

                <!-- IMAGES -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] text-gray-500">Desktop Image</label>
                        <input type="file"
                            @change="
                            desktopImage = $event.target.files[0];
                            preview.desktop = URL.createObjectURL(desktopImage);
                        ">
                        <template x-if="preview.desktop">
                            <img :src="preview.desktop" class="mt-1 h-16 w-full object-cover rounded border">
                        </template>
                    </div>

                    <div>
                        <label class="text-[10px] text-gray-500">Mobile Image</label>
                        <input type="file"
                            @change="
                            mobileImage = $event.target.files[0];
                            preview.mobile = URL.createObjectURL(mobileImage);
                        ">
                        <template x-if="preview.mobile">
                            <img :src="preview.mobile" class="mt-1 h-16 w-full object-cover rounded border">
                        </template>
                    </div>
                </div>

                <!-- DESCRIPTION -->
                <textarea x-model="form.description" class="w-full border rounded px-2 py-1.5 text-[11px]"
                    placeholder="Short description"></textarea>

                <!-- CONTENT -->
                <div>
                    <label class="text-[10px] text-gray-500 mb-1 block">Content</label>
                    <div x-ref="editor" class="border rounded min-h-[120px]"></div>
                </div>

                <!-- BUTTONS -->
                <div class="grid grid-cols-2 gap-2">
                    <input x-model="form.button_1_text" placeholder="Button 1 Text"
                        class="border rounded px-2 py-1.5 text-[11px]">
                    <input x-model="form.button_1_link" placeholder="Button 1 Link"
                        class="border rounded px-2 py-1.5 text-[11px]">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <input x-model="form.button_2_text" placeholder="Button 2 Text"
                        class="border rounded px-2 py-1.5 text-[11px]">
                    <input x-model="form.button_2_link" placeholder="Button 2 Link"
                        class="border rounded px-2 py-1.5 text-[11px]">
                </div>

                <!-- ACTIONS -->
                <div class="flex justify-between pt-3 border-t">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-1.5 rounded text-[11px]">
                        Save
                    </button>

                    <button x-show="form.id" @click.prevent="remove()" class="text-red-600 text-[11px]">
                        Delete
                    </button>
                </div>

            </form>
        </section>
    </div>

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

    <script>
        function pageSectionManager() {
            return {
                sections: @json($sections),
                filterPage: '',
                quill: null,

                desktopImage: null,
                mobileImage: null,

                preview: {
                    desktop: null,
                    mobile: null
                },

                form: {
                    id: null,
                    page_type: '',
                    section_key: '',
                    title: '',
                    subtitle: '',
                    badge: '',
                    description: '',
                    content: '',
                    button_1_text: '',
                    button_1_link: '',
                    button_2_text: '',
                    button_2_link: '',
                    status: true
                },

                init() {
                    if (this.quill) return;
                    this.quill = new Quill(this.$refs.editor, {
                        theme: 'snow'
                    });
                },

                filterByPage() {
                    window.location.href = `?page=${this.filterPage}`;
                },

                edit(item) {
                    this.form = {
                        ...item
                    };
                    this.form.status = !!item.status;
                    this.quill.root.innerHTML = item.content || '';
                    this.preview.desktop = item.desktop_image_url || null;
                    this.preview.mobile = item.mobile_image_url || null;
                },

                resetForm() {
                    this.form = {
                        id: null,
                        page_type: '',
                        section_key: '',
                        title: '',
                        subtitle: '',
                        badge: '',
                        description: '',
                        content: '',
                        button_1_text: '',
                        button_1_link: '',
                        button_2_text: '',
                        button_2_link: '',
                        status: true
                    };
                    this.preview = {
                        desktop: null,
                        mobile: null
                    };
                    this.desktopImage = this.mobileImage = null;
                    this.quill.root.innerHTML = '';
                },

                submit() {
                    const formData = new FormData();

                    Object.entries(this.form).forEach(([k, v]) =>
                        formData.append(k, k === 'status' ? (v ? 1 : 0) : v ?? '')
                    );

                    formData.set('content', this.quill.root.innerHTML);

                    if (this.desktopImage) formData.append('desktop_image', this.desktopImage);
                    if (this.mobileImage) formData.append('mobile_image', this.mobileImage);

                    let url = '/admin/page-sections';
                    if (this.form.id) {
                        url += '/' + this.form.id;
                        formData.append('_method', 'PUT');
                    }

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(() => location.reload())
                        .catch(err => alert('Error: ' + err));
                },

                remove() {
                    if (!confirm('Delete this section?')) return;

                    fetch(`/admin/page-sections/${this.form.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => location.reload());
                }
            }
        }
    </script>
@endsection
