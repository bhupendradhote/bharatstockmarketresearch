@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    <div x-data="keyFeatures()" x-init="init()" class="w-full px-6 py-4 text-xs">

        <div class="grid grid-cols-12 gap-6">

            <!-- ================= LEFT SIDE ================= -->
            <div class="col-span-4 space-y-4">

                <!-- SECTION FORM -->
                <div class="bg-white rounded-md shadow p-3">
                    <h3 class="font-semibold mb-2">Key Features – Content</h3>

                    <input x-model="heading" class="w-full border rounded px-2 py-1.5 mb-2" placeholder="Section Heading">

                    <textarea x-model="description" rows="2" class="w-full border rounded px-2 py-1.5"
                        placeholder="Section Description"></textarea>

                    <button @click="saveSection" class="mt-2 bg-blue-600 text-white px-3 py-1.5 rounded">
                        Save
                    </button>
                </div>

                <!-- IMAGE MANAGER -->
                <div class="bg-white rounded-md shadow p-3">
                    <h3 class="font-semibold mb-2">
                        Images (Drag & Drop)
                    </h3>

                    <div id="sortable" class="flex flex-wrap gap-2">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="relative w-24 h-16 border rounded overflow-hidden cursor-move">

                                <img :src="item.image" class="w-full h-full object-cover">

                                <!-- REMOVE -->
                                <button @click="removeImage(item.id, index)"
                                    class="absolute top-0 right-0 bg-red-600 text-white text-[10px] px-1">
                                    ✕
                                </button>
                            </div>
                        </template>
                    </div>

                    <input type="file" @change="uploadImage" class="mt-3 w-full text-xs">
                </div>

            </div>

            <!-- ================= RIGHT SIDE : PREVIEW ================= -->
            <div class="col-span-8">

                <div class="bg-gray-50 rounded-lg p-4">

                    <span class="inline-block bg-blue-600 text-white px-3 py-1 rounded-full text-[11px]"x-text="heading">

                    </span>

                    <h2 class="text-base font-semibold mt-2" x-text="description"></h2>
                    {{-- <p class="text-xs text-gray-600 mt-1" x-text="description"></p> --}}

                    <div class="grid grid-cols-[75%_25%] gap-4 mt-4">

                        <!-- LARGE -->
                        <div class="h-[240px] rounded-lg overflow-hidden border" :class="{ 'opacity-40': !items[0] }">
                            <img :src="items[0]?.image" class="w-full h-full object-cover">
                        </div>

                        <!-- SMALL -->
                        <div class="flex flex-col gap-4">
                            <template x-for="item in items.slice(1)" :key="item.id">
                                <div class="h-[110px] rounded-lg overflow-hidden border">
                                    <img :src="item.image" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function keyFeatures() {
            return {
                heading: @json($section->heading),
                description: @json($section->description),
                items: @json(
                    $items->map(fn($i) => [
                            'id' => $i->id,
                            'image' => $i->getFirstMediaUrl('feature_images'),
                        ])),

                init() {
                    let el = document.getElementById('sortable');
                    new Sortable(el, {
                        animation: 150,
                        onEnd: (evt) => {
                            const moved = this.items.splice(evt.oldIndex, 1)[0];
                            this.items.splice(evt.newIndex, 0, moved);

                            fetch('{{ route('admin.home.key-features.reorder') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    order: this.items.map(i => i.id)
                                })
                            });
                        }
                    });
                },

                saveSection() {
                    fetch('{{ route('admin.home.key-features.section') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            heading: this.heading,
                            description: this.description
                        })
                    });
                },

                uploadImage(e) {
                    let form = new FormData();
                    form.append('image', e.target.files[0]);

                    fetch('{{ route('admin.home.key-features.item.store') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: form
                        })
                        .then(res => res.json())
                        .then(() => location.reload());
                },

                removeImage(id, index) {
                    fetch(`{{ url('/admin/home/key-features/item') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => {
                        this.items.splice(index, 1);
                    });
                }
            }
        }
    </script>
@endsection
