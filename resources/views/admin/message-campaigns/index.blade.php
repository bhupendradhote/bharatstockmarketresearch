@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-xl font-semibold text-gray-800">Message Campaigns</h1>
                    <p class="text-sm text-gray-500">Broadcast messages to all users</p>
                </div>

                <a href="{{ route('admin.message-campaigns.create') }}"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                    + New Campaign
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif


            <!-- Table -->
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Title</th>
                            <th class="px-4 py-3 text-left">Type</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-left">Schedule</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($campaigns as $campaign)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-800">
                                        {{ $campaign->title }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $campaign->description }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 capitalize">
                                    <span
                                        class="px-2 py-1 rounded text-xs
                                    @if ($campaign->type === 'success') bg-green-100 text-green-700
                                    @elseif($campaign->type === 'warning') bg-yellow-100 text-yellow-700
                                    @elseif($campaign->type === 'danger') bg-red-100 text-red-700
                                    @elseif($campaign->type === 'offer') bg-purple-100 text-purple-700
                                    @else bg-blue-100 text-blue-700 @endif">
                                        {{ $campaign->type }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    @if ($campaign->is_active)
                                        <span class="text-green-600 font-semibold">Active</span>
                                    @else
                                        <span class="text-gray-400 font-semibold">Inactive</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-xs text-gray-600">
                                    <div>Start: {{ $campaign->starts_at ?? 'Now' }}</div>
                                    <div>End: {{ $campaign->ends_at ?? 'No expiry' }}</div>
                                </td>

                                <td class="px-4 py-3 text-right flex justify-end gap-2">
                                    <form action="{{ route('admin.message-campaigns.toggle', $campaign) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="text-xs px-3 py-1 border rounded hover:bg-gray-100">
                                            {{ $campaign->is_active ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.message-campaigns.destroy', $campaign) }}" method="POST"
                                        onsubmit="return confirm('Delete this campaign?')">
                                        @csrf @method('DELETE')
                                        <button
                                            class="text-xs px-3 py-1 border border-red-200 text-red-600 rounded hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                                    No campaigns created yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $campaigns->links() }}
            </div>
        </div>
    </div>
@endsection
