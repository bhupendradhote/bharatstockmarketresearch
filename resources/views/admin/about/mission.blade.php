@extends('layouts.app')

@section('content')
    <div x-data="missionForm()" x-init="init()" class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

        <h2 class="text-lg font-semibold mb-6">
            Mission & Values
        </h2>

        <form method="POST" action="{{ url('admin/about/mission/store') }}" @submit="submitForm" class="space-y-4">
            @csrf

            <!-- ID (only filled if record exists) -->
            <input type="hidden" name="id" x-model="form.id">

            <!-- Badge -->
            <div>
                <label class="text-sm block mb-1">Badge</label>
                <input type="text" name="badge" x-model="form.badge" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Title -->
            <div>
                <label class="text-sm block mb-1">Title (optional)</label>
                <input type="text" name="title" x-model="form.title" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Mission Text -->
            <div>
                <label class="text-sm block mb-1">Mission Text</label>
                <textarea name="mission_text" rows="4" x-model="form.mission_text" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <!-- Active -->
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" x-model="form.is_active">
                Active
            </label>

            <!-- Button -->
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded"
                x-text="form.id ? 'Update' : 'Create'"></button>
        </form>

    </div>

    {{-- Alpine.js --}}
    <script>
        function missionForm() {
            return {
                form: {
                    id: null,
                    badge: '',
                    title: '',
                    mission_text: '',
                    is_active: true,
                },

                init() {
                    @if ($mission)
                        this.form = {
                            id: {{ $mission->id }},
                            badge: @js($mission->badge),
                            title: @js($mission->title),
                            mission_text: @js($mission->mission_text),
                            is_active: {{ $mission->is_active ? 'true' : 'false' }},
                        }
                    @endif
                },

                submitForm() {
                    // Nothing special needed
                    // Laravel updateOrCreate handles logic
                }
            }
        }
    </script>
@endsection
