@extends('layouts.app')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div x-data="{
        openCreate: false,
        openEdit: false,
        openDelete: false,
    
        selectedPage: 'all',
    
        predefinedPages: ['home', 'about', 'service', 'blog'],
        useCustomPage: false,
    
        editItem: {
            page_type: 'home',
            page_slug: '',
            question: '',
            answer: '',
            sort_order: 0,
            status: 1
        },
    
        deleteAction: '',
    
        isCustomPage(page) {
            return !this.predefinedPages.includes(page);
        }
    }" class="p-5 text-xs">

        <div class="grid grid-cols-12 gap-4">

            <!-- LEFT SIDEBAR -->
            <div class="col-span-3">
                <div class="bg-white border rounded shadow-sm p-3 space-y-2">
                    <h3 class="font-semibold text-gray-700 text-sm mb-2">Pages</h3>

                    <button @click="selectedPage='all'" class="w-full text-left px-2 py-1 rounded"
                        :class="selectedPage === 'all' ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100'">
                        All Pages
                    </button>

                    @foreach ($pages as $page)
                        <button @click="selectedPage='{{ $page }}'" class="w-full text-left px-2 py-1 rounded"
                            :class="selectedPage === '{{ $page }}' ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100'">
                            {{ ucfirst($page) }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- MAIN -->
            <div class="col-span-9 bg-white p-4 space-y-4">

                <!-- HEADER -->
                <div class="flex justify-between items-center">
                    <h2 class="font-semibold text-gray-700 text-sm">FAQ Manager</h2>

                    <button
                        @click="
                    openCreate=true;
                    openEdit=false;
                    useCustomPage=false;
                    editItem={
                        page_type:'home',
                        page_slug:'',
                        question:'',
                        answer:'',
                        sort_order:0,
                        status:1
                    };
                "
                        class="px-3 py-1.5 bg-blue-600 text-white rounded">
                        + Add FAQ
                    </button>
                </div>

                <!-- TABLE -->
                <div class="bg-white border rounded shadow-sm">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr class="text-left text-gray-600">
                                <th class="p-2">Question</th>
                                <th class="p-2">Page</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Order</th>
                                <th class="p-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs as $faq)
                                <tr x-show="selectedPage==='all' || selectedPage==='{{ $faq->page_type }}'"
                                    class="border-b hover:bg-gray-50">

                                    <td class="p-2 font-medium">
                                        {{ Str::limit($faq->question, 60) }}
                                    </td>

                                    <td class="p-2">
                                        <span class="bg-gray-100 px-2 py-0.5 rounded">
                                            {{ $faq->page_type }}
                                        </span>
                                    </td>

                                    <td class="p-2">
                                        @if ($faq->status)
                                            <span class="text-green-600 bg-green-100 px-2 rounded">Active</span>
                                        @else
                                            <span class="text-red-600 bg-red-100 px-2 rounded">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="p-2">{{ $faq->sort_order }}</td>

                                    <td class="p-2 text-right space-x-1">
                                        <button
                                            @click="
                                    openEdit=true;
                                    openCreate=false;
                                    editItem={
                                        id:{{ $faq->id }},
                                        page_type:'{{ $faq->page_type }}',
                                        page_slug:'{{ $faq->page_slug }}',
                                        question:'{{ addslashes($faq->question) }}',
                                        answer:'{{ addslashes($faq->answer) }}',
                                        sort_order:'{{ $faq->sort_order }}',
                                        status:'{{ $faq->status }}'
                                    };
                                    useCustomPage = isCustomPage('{{ $faq->page_type }}');
                                "
                                            class="px-2 py-1 bg-yellow-500 text-white rounded">
                                            Edit
                                        </button>

                                        <button
                                            @click="
                                    openDelete=true;
                                    deleteAction='{{ route('admin.faq.destroy', $faq->id) }}';
                                "
                                            class="px-2 py-1 bg-red-600 text-white rounded">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- CREATE / EDIT MODAL -->
        <div x-show="openCreate || openEdit" x-cloak
            class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white w-[520px] rounded shadow max-h-[90vh] flex flex-col">

                <!-- HEADER -->
                <div class="p-4 border-b sticky top-0 bg-white">
                    <h3 class="font-semibold text-gray-700 text-sm" x-text="openCreate ? 'Add FAQs' : 'Edit FAQ'"></h3>
                </div>

                <!-- BODY -->
                <div class="p-4 overflow-y-auto space-y-3">

                    <form method="POST"
                        :action="openCreate
                            ?
                            '{{ route('admin.faq.store') }}' :
                            '{{ url('admin/faq/') }}/' + editItem.id">

                        @csrf
                        <template x-if="openEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <!-- PAGE -->
                        <div class="space-y-1">
                            <label class="text-[11px] font-semibold text-gray-600">Page</label>

                            <div class="flex gap-3 text-[11px]">
                                <label><input type="radio" x-model="useCustomPage" :value="false"> Select
                                    Page</label>
                                <label><input type="radio" x-model="useCustomPage" :value="true"> Add New</label>
                            </div>

                            <select x-show="!useCustomPage" name="page_type" x-model="editItem.page_type"
                                class="w-full border rounded p-1 text-xs">
                                <option value="home">Home</option>
                                <option value="about">About</option>
                                <option value="service">Service</option>
                                <option value="contact">Contact</option>
                                <option value="blog">Blog</option>
                            </select>

                            <input x-show="useCustomPage" type="text" name="page_type" x-model="editItem.page_type"
                                class="w-full border rounded p-1 text-xs" placeholder="Custom page name">
                        </div>

                        <!-- FAQ REPEATER (FIXED) -->
                        <div x-data="{
                            faqs: [],
                            reset() {
                                if (openEdit) {
                                    this.faqs = [{
                                        question: editItem.question ?? '',
                                        answer: editItem.answer ?? ''
                                    }];
                                } else {
                                    this.faqs = [{ question: '', answer: '' }];
                                }
                            }
                        }" x-effect="reset()"
                            class="space-y-3 max-h-[45vh] overflow-y-auto border rounded p-2 bg-gray-50">

                            <template x-for="(faq,index) in faqs" :key="index">
                                <div class="bg-white border rounded p-2 space-y-1">

                                    <div>
                                        <label class="text-[11px] font-semibold">Question</label>
                                        <input type="text" :name="openCreate ? 'questions[]' : 'question'"
                                            x-model="faq.question" class="w-full border rounded p-1 text-xs" required>
                                    </div>

                                    <div>
                                        <label class="text-[11px] font-semibold">Answer</label>
                                        <textarea :name="openCreate ? 'answers[]' : 'answer'" x-model="faq.answer" rows="2"
                                            class="w-full border rounded p-1 text-xs" required></textarea>
                                    </div>

                                    <button x-show="faqs.length>1 && openCreate" type="button"
                                        @click="faqs.splice(index,1)" class="text-red-600 text-[10px]">
                                        Remove
                                    </button>

                                </div>
                            </template>

                            <button x-show="openCreate" type="button" @click="faqs.push({question:'',answer:''})"
                                class="text-blue-600 text-xs">
                                + Add another question
                            </button>
                        </div>

                        <!-- STATUS -->
                        <div class="flex gap-2 pt-3">
                            <input type="number" name="sort_order" x-model="editItem.sort_order" placeholder="Order"
                                class="w-1/2 border rounded p-1 text-xs">
                            <select name="status" x-model="editItem.status" class="w-1/2 border rounded p-1 text-xs">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <!-- FOOTER -->
                        <div class="flex justify-end gap-2 pt-4 border-t mt-4 sticky bottom-0 bg-white">
                            <button type="button" @click="openCreate=false;openEdit=false"
                                class="border px-3 py-1 text-xs">
                                Cancel
                            </button>
                            <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- DELETE MODAL -->
        <div x-show="openDelete" x-cloak class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white p-4 rounded w-[300px]">
                <p class="text-sm mb-3">Delete this FAQ?</p>
                <div class="flex justify-end gap-2">
                    <button @click="openDelete=false" class="border px-3 py-1">Cancel</button>
                    <form :action="deleteAction" method="POST">
                        @csrf @method('DELETE')
                        <button class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
