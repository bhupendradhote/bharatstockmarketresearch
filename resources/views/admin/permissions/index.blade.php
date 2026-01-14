@extends('layouts.app')

{{-- Standard HTML Header section, replacing x-slot --}}
@section('title', 'Permissions Management')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                Permissions Management
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

                    <div class="mb-8">
                        <p class="text-sm text-gray-600 text-center mb-4">
                            Manage permissions that can be assigned to roles. Permissions define specific actions users
                            can perform.
                        </p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg mb-8 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            Add New Permission
                        </h3>

                        <form method="POST" action="{{ route('permissions.store') }}" class="space-y-4">
                            @csrf

                            <div class="flex flex-col sm:flex-row sm:items-center gap-4">

                                <div class="flex-grow">
                                    <input name="name" type="text"
                                        placeholder="e.g., create-posts, edit-users, delete-comments"
                                        class="w-full rounded-md border-gray-300 shadow-sm 
                                            focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        required />

                                    <p class="mt-1 text-xs text-gray-500">
                                        Use lowercase with hyphens (e.g., view-reports, manage-users)
                                    </p>
                                </div>

                                <button type="submit"
                                    class="flex items-center justify-center gap-2 px-5 py-3 
                                        bg-blue-600 border border-transparent rounded-md font-semibold text-xs 
                                        text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900
                                        focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 
                                        disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Permission
                                </button>
                            </div>

                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>


                    <div class="overflow-x-auto">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                All Permissions ({{ $permissions->count() }})
                            </h3>
                            @if ($permissions->count() > 0)
                                <span class="text-sm text-gray-500">
                                    Showing {{ $permissions->count() }} permissions
                                </span>
                            @endif
                        </div>

                        @if ($permissions->count() > 0)
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Permission Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Created
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($permissions as $permission)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $permission->name }}
                                                        </div>
                                                        {{-- Uncomment if you need this info --}}
                                                        {{-- <div class="text-xs text-gray-500">
                                                            {{ $permission->roles_count ?? 0 }} roles assigned
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-600">
                                                    {{ $permission->created_at->format('M d, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form method="POST"
                                                    action="{{ route('permissions.destroy', $permission->id) }}"
                                                    onsubmit="return confirm('Are you sure you want to delete this permission? This may affect roles that use it.')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No permissions yet
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Start by adding your first permission above.
                                </p>
                            </div>
                        @endif
                    </div>

                    @if ($permissions->count() > 0)
                        <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Permission Tips
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>• **Permissions** should describe specific actions (e.g., **create-users**,
                                            **delete-posts**)</p>
                                        <p>• Assign permissions to **roles**, not directly to users</p>
                                        <p>• **Deleting** a permission will remove it from all roles</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
