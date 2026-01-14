@extends('layouts.app')

@section('content')
    <style>
        .status-pill {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .active-pill {
            background: #d1fae5;
            color: #065f46;
        }

        .inactive-pill {
            background: #fee2e2;
            color: #991b1b;
        }

        .mobile-user-card {
            display: none;
        }

        @media(max-width: 768px) {
            .desktop-table {
                display: none;
            }

            .mobile-user-card {
                display: block;
            }
        }

        .pagination-btn {
            padding: 6px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: white;
            font-size: 13px;
            transition: 0.2s;
        }

        .pagination-btn:hover {
            background: #f3f4f6;
        }

        .pagination-active {
            background: #1f2937 !important;
            color: white !important;
            border-color: #1f2937 !important;
        }
    </style>


    <main class="p-4 md:p-6">

        <div class="bg-white shadow rounded-lg p-4">

            <h2 class="text-xl font-semibold mb-1">All Users</h2>
            <p class="text-xs text-gray-500 mb-4">Filter and manage your platform users.</p>


            <!-- ===================== FILTER SECTION ===================== -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-5 p-3 border rounded-lg bg-gray-50">

                <!-- Search -->
                <input id="searchInput" type="text" class="border rounded px-3 py-2 text-sm w-full"
                    placeholder="Search name, email or phone">

                <!-- Role Filter -->
                <select id="roleFilter" class="border rounded px-3 py-2 text-sm w-full">
                    <option value="">All Roles</option>
                    @php
                        $allRoles = [];
                        foreach ($users as $u) {
                            $r = $u->getRoleNames()->first();
                            if ($r && !in_array($r, $allRoles)) {
                                $allRoles[] = $r;
                            }
                        }
                    @endphp

                    @foreach ($allRoles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>

                <!-- Status Checkboxes -->
                <div class="flex items-center gap-3">
                    <label class="flex items-center text-sm gap-1">
                        <input type="checkbox" id="activeCheck" checked>
                        Active
                    </label>

                    <label class="flex items-center text-sm gap-1">
                        <input type="checkbox" id="inactiveCheck" checked>
                        Inactive
                    </label>
                </div>

                <!-- Reset Button -->
                <button id="resetFilters" class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded">
                    Reset Filters
                </button>

            </div>
            <!-- ===================== /FILTER SECTION ===================== -->



            <!-- ===================== DESKTOP TABLE ===================== -->
            <div class="overflow-x-auto border rounded-lg desktop-table">
                <table class="w-full text-sm min-w-[850px]">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="py-2 px-3">#</th>
                            <th class="py-2 px-3 text-left">User</th>
                            <th class="py-2 px-3 text-left">Email</th>
                            <th class="py-2 px-3 text-left">Phone</th>
                            <th class="py-2 px-3 text-center">Role</th>
                            <th class="py-2 px-3 text-center">Status</th>
                            <th class="py-2 px-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="userTable">
                        @foreach ($users as $user)
                            @php
                                // Get profile image URL from media library
                                $profileImageUrl = $user->getFirstMediaUrl('profile_images');
                            @endphp

                            <tr class="border-b hover:bg-gray-50 user-row" data-name="{{ strtolower($user->name) }}"
                                data-email="{{ strtolower($user->email) }}"
                                data-phone="{{ strtolower($user->phone ?? '') }}"
                                data-role="{{ strtolower($user->getRoleNames()->first() ?? '') }}"
                                data-status="{{ $user->status ? 'active' : 'inactive' }}">

                                <td class="px-3 py-2">
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>

                                <td class="px-3 py-2 flex items-center gap-2">
                                    @if ($profileImageUrl)
                                        <img src="{{ $profileImageUrl }}" alt="{{ $user->name }}"
                                            class="w-8 h-8 rounded-full border object-cover"
                                            onerror="this.onerror=null; this.src='{{ asset('default-user.png') }}';">
                                    @else
                                        <div
                                            class="w-8 h-8 rounded-full bg-emerald-100 border flex items-center justify-center text-emerald-700 font-semibold text-xs">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <p class="font-medium">{{ $user->name }}</p>
                                        <span class="text-[11px] text-gray-500">ID: {{ $user->id }}</span>
                                    </div>
                                </td>

                                <td class="px-3 py-2">{{ $user->email }}</td>
                                <td class="px-3 py-2">{{ $user->phone ?? '—' }}</td>

                                <td class="px-3 py-2 text-center">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                        {{ $user->getRoleNames()->first() ?? 'No Role' }}
                                    </span>
                                </td>

                                <td class="px-3 py-2 text-center">
                                    @if ($user->status)
                                        <span class="status-pill active-pill">Active</span>
                                    @else
                                        <span class="status-pill inactive-pill">Inactive</span>
                                    @endif
                                </td>

                                <td class="px-3 py-2 text-center">
                                    <a href="{{ route('users.index', ['user' => $user->id]) }}"
                                        class="text-blue-600 hover:underline">
                                        Edit
                                    </a>
                                    <a href="#" class="text-red-600 hover:underline ml-2">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- ===================== MOBILE CARDS ===================== -->
            <div id="mobileUserList" class="mt-4">
                @foreach ($users as $user)
                    <div class="mobile-user-card user-card" data-name="{{ strtolower($user->name) }}"
                        data-email="{{ strtolower($user->email) }}" data-phone="{{ strtolower($user->phone ?? '') }}"
                        data-role="{{ strtolower($user->getRoleNames()->first() ?? '') }}"
                        data-status="{{ $user->status ? 'active' : 'inactive' }}">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ $user->image ? asset('uploads/users/' . $user->image) : 'https://via.placeholder.com/50' }}"
                                class="w-12 h-12 rounded-full border" />
                            <div>
                                <p class="font-medium text-sm">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>

                        <p class="text-xs"><strong>Phone:</strong> {{ $user->phone ?? '—' }}</p>
                        <p class="text-xs"><strong>Role:</strong> {{ $user->getRoleNames()->first() ?? 'No Role' }}</p>
                        <p class="text-xs"><strong>Status:</strong>
                            @if ($user->status)
                                <span class="active-pill text-[10px]">Active</span>
                            @else
                                <span class="inactive-pill text-[10px]">Inactive</span>
                            @endif
                        </p>

                        <div class="flex justify-end mt-3">
                            <button class="text-blue-600 text-xs mr-3">Edit</button>
                            <button class="text-red-600 text-xs">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div
                class="flex flex-col md:flex-row justify-between items-center gap-3 
            text-sm text-gray-600 mt-4 pagination-container">

                <!-- Showing text -->
                <p class="text-sm">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                </p>

                <!-- Pagination Buttons -->
                <div class="flex flex-wrap gap-2 justify-center pagination-buttons">

                    {{-- Prev --}}
                    @if ($users->onFirstPage())
                        <button class="pagination-btn opacity-50 cursor-not-allowed">Prev</button>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="pagination-btn">Prev</a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($users->links()->elements[0] as $page => $url)
                        @if ($page == $users->currentPage())
                            <button class="pagination-btn pagination-active">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="pagination-btn">Next</a>
                    @else
                        <button class="pagination-btn opacity-50 cursor-not-allowed">Next</button>
                    @endif

                </div>
            </div>


        </div>

    </main>



    <!-- ===================== FILTER SCRIPT ===================== -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("searchInput");
            const roleFilter = document.getElementById("roleFilter");
            const activeCheck = document.getElementById("activeCheck");
            const inactiveCheck = document.getElementById("inactiveCheck");
            const resetBtn = document.getElementById("resetFilters");

            const rows = document.querySelectorAll(".user-row");
            const cards = document.querySelectorAll(".user-card");

            function filterUsers() {
                const search = searchInput.value.toLowerCase();
                const role = roleFilter.value.toLowerCase();
                const showActive = activeCheck.checked;
                const showInactive = inactiveCheck.checked;

                [...rows, ...cards].forEach(el => {
                    const name = el.dataset.name;
                    const email = el.dataset.email;
                    const phone = el.dataset.phone;
                    const userRole = el.dataset.role;
                    const status = el.dataset.status;

                    let visible = true;

                    // Search filter
                    if (search && !(
                            name.includes(search) ||
                            email.includes(search) ||
                            phone.includes(search)
                        )) {
                        visible = false;
                    }

                    // Role filter
                    if (role && userRole !== role) {
                        visible = false;
                    }

                    // Status checkbox filter
                    if (status === "active" && !showActive) visible = false;
                    if (status === "inactive" && !showInactive) visible = false;

                    el.style.display = visible ? "" : "none";
                });
            }

            searchInput.addEventListener("input", filterUsers);
            roleFilter.addEventListener("change", filterUsers);
            activeCheck.addEventListener("change", filterUsers);
            inactiveCheck.addEventListener("change", filterUsers);
            searchInput.addEventListener("keyup", filterUsers);

            resetBtn.addEventListener("click", () => {
                searchInput.value = "";
                roleFilter.value = "";
                activeCheck.checked = true;
                inactiveCheck.checked = true;
                filterUsers();
            });

        });
    </script>
@endsection
