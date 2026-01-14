@extends('layouts.app')

@section('content')
    <div class="mx-auto bg-white shadow rounded-lg p-4">

        <h2 class="text-sm font-semibold mb-4">Add New Footer Column</h2>

        <form action="{{ route('admin.footer.column.store') }}" method="POST" class="text-xs">
            @csrf

            <!-- TITLE -->
            <div class="mb-3">
                <label class="block mb-1 font-semibold">Column Title</label>
                <input type="text" name="title" required class="border px-3 py-1.5 rounded w-full"
                    placeholder="Enter column title">
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.footer.index') }}" class="bg-gray-300 px-3 py-1 rounded text-xs">
                    Cancel
                </a>

                <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                    Save
                </button>
            </div>

        </form>
    </div>
@endsection
