@extends('layouts.app')

{{-- Standard HTML Header section, replacing x-slot --}}
@section('title', 'Create New Role')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                Create New Role
            </h2>
        </div>
    </header>
@endsection
{{-- End standard HTML Header section --}}

@section('content')
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <a href="{{ route('roles.index') }}"
                            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-900 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Roles
                        </a>
                    </div>

                    <div class="max-w-2xl mx-auto">
                        <form method="POST" action="{{ route('roles.store') }}" class="space-y-6">
                            @csrf

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Role Name
                                </label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required autofocus>
                                @error('name')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-4">
                                    Permissions
                                </label>

                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    @if ($permissions->count() > 0)
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                            @foreach ($permissions as $permission)
                                                <label
                                                    class="inline-flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors duration-150 cursor-pointer">
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <span class="ml-3 text-sm text-gray-700">
                                                        {{ $permission->name }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <p class="text-gray-500 text-sm">
                                                No permissions available. Please create permissions first.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                @error('permissions')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                <a href="{{ route('roles.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancel
                                </a>

                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Create Role
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
