@extends('layouts.app')

{{-- Standard HTML Header section, replacing x-slot --}}
@section('title', 'Edit Role: ' . $role->name)

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Role: <span class="text-blue-600">{{ $role->name }}</span>
                </h2>
                <a href="{{ route('roles.index') }}" class="text-sm text-blue-600 hover:text-blue-900">
                    ← Back to Roles
                </a>
            </div>
        </div>
    </header>
@endsection
{{-- End standard HTML Header section --}}

@section('content')
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf @method('PUT')

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Role Name
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Permissions
                            </label>

                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                @foreach ($permissions as $permission)
                                    <label for="permission_{{ $permission->id }}"
                                        class="flex items-center p-3 rounded-md border border-gray-200 bg-white cursor-pointer transition 
                                        hover:bg-gray-100">

                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            id="permission_{{ $permission->id }}"
                                            class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>

                                        <div class="flex items-center justify-between w-full ml-3">
                                            <span class="text-sm text-gray-700">
                                                {{ $permission->name }}
                                            </span>

                                            @if ($role->hasPermissionTo($permission->name))
                                                <span
                                                    class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-semibold">
                                                    Assigned
                                                </span>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            @if ($permissions->count() === 0)
                                <div class="text-center py-4 text-gray-500 text-sm">
                                    No permissions available
                                </div>
                            @endif

                            @error('permissions')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <a href="{{ route('roles.index') }}"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                    Cancel
                                </a>
                                @can('delete', $role)
                                    <form method="POST" action="{{ route('roles.destroy', $role->id) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this role?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-800 transition-colors duration-150">
                                            Delete Role
                                        </button>
                                    </form>
                                @endcan
                            </div>

                            <div class="flex space-x-3">
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Update Role
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
