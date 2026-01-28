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


    <main class=" ">

        <div class="">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h2 class="text-xl font-semibold mb-1">All Customers</h2>
                    <p class="text-xs text-gray-500">Filter and manage your platform Customers.</p>
                </div>
                
                {{-- Export Button --}}
                <button onclick="exportTableToCSV('customers_list.csv')" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-xs font-bold hover:bg-green-700 transition flex items-center gap-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M7.5 12 12 16.5m0 0L16.5 12M12 16.5V3" />
                    </svg>
                    Export CSV
                </button>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-5 p-4 border rounded-xl bg-white shadow-sm">

                <div class="md:col-span-3">
                    <label class="text-[10px] font-bold text-gray-400 uppercase mb-1 block">Search</label>
                    <input id="searchInput" type="text" class="border rounded-lg px-3 py-2 text-sm w-full outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                        placeholder="Name, email or phone...">
                </div>

                <div class="md:col-span-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase mb-1 block">Role</label>
                    <select id="roleFilter" class="border rounded-lg px-3 py-2 text-sm w-full outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
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
                </div>

                <div class="md:col-span-3">
                    <label class="text-[10px] font-bold text-gray-400 uppercase mb-1 block">Joined Date</label>
                    <input id="dateFilter" type="date" class="border rounded-lg px-3 py-2 text-sm w-full outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-gray-600">
                </div>
<!-- 
                <div class="md:col-span-2 flex flex-col justify-end pb-2">
                    <label class="text-[10px] font-bold text-gray-400 uppercase mb-2 block">Status</label>
                    <div class="flex items-center gap-3">
                        <label class="flex items-center text-sm gap-1 cursor-pointer">
                            <input type="checkbox" id="activeCheck" checked class="rounded text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700 font-medium text-xs">Active</span>
                        </label>

                        <label class="flex items-center text-sm gap-1 cursor-pointer">
                            <input type="checkbox" id="inactiveCheck" checked class="rounded text-red-600 focus:ring-red-500">
                            <span class="text-gray-700 font-medium text-xs">Inactive</span>
                        </label>
                    </div>
                </div> -->

                <div class="md:col-span-2 flex items-end">
                    <button id="resetFilters" class="w-full px-3 py-2 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Reset
                    </button>
                </div>

            </div>
            <div class="overflow-x-auto border rounded-xl shadow-sm bg-white desktop-table">
                <table class="w-full text-sm min-w-[850px]" id="usersTable">
                    <thead class="bg-gray-50 text-gray-500 border-b border-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left font-bold uppercase text-[10px] tracking-wider">#</th>
                            <th class="py-3 px-4 text-left font-bold uppercase text-[10px] tracking-wider">User</th>
                            <th class="py-3 px-4 text-left font-bold uppercase text-[10px] tracking-wider">Email</th>
                            <th class="py-3 px-4 text-left font-bold uppercase text-[10px] tracking-wider">Phone</th>
                            <th class="py-3 px-4 text-left font-bold uppercase text-[10px] tracking-wider">Joined Date</th> {{-- New Column --}}
                            <!-- <th class="py-3 px-4 text-center font-bold uppercase text-[10px] tracking-wider">Role</th> -->
                            <!-- <th class="py-3 px-4 text-center font-bold uppercase text-[10px] tracking-wider">Status</th> -->
                            <th class="py-3 px-4 text-center font-bold uppercase text-[10px] tracking-wider">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">
                        @foreach ($users as $user)
                            @php
                                $profileImageUrl = $user->getFirstMediaUrl('profile_images');
                                // Format date for data attribute (Y-m-d for comparison) and display (d M, Y)
                                $createdDate = $user->created_at ? $user->created_at->format('Y-m-d') : '';
                                $displayDate = $user->created_at ? $user->created_at->format('d M, Y') : '—';
                            @endphp

                            <tr class="hover:bg-blue-50/30 transition-colors user-row group" 
                                data-name="{{ strtolower($user->name) }}"
                                data-email="{{ strtolower($user->email) }}"
                                data-phone="{{ strtolower($user->phone ?? '') }}"
                                data-role="{{ strtolower($user->getRoleNames()->first() ?? '') }}"
                                data-status="{{ $user->status ? 'active' : 'inactive' }}"
                                data-date="{{ $createdDate }}">  {{-- Data Attribute for Filter --}}

                                <td class="px-4 py-3 text-gray-500">
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if ($profileImageUrl)
                                            <img src="{{ $profileImageUrl }}" alt="{{ $user->name }}"
                                                class="w-9 h-9 rounded-full border border-gray-200 object-cover shadow-sm"
                                                onerror="this.onerror=null; this.src='{{ asset('default-user.png') }}';">
                                        @else
                                            <div
                                                class="w-9 h-9 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xs shadow-sm">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                        @endif

                                        <div>
                                            <p class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $user->name }}</p>
                                            <span class="text-[10px] text-gray-400 font-mono">ID: {{ $user->bsmr_id }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-gray-600 font-medium">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-gray-500 font-mono text-xs">{{ $user->phone ?? '—' }}</td>
                                
                                {{-- Joined Date Column --}}
                                <td class="px-4 py-3 text-gray-500 text-xs font-medium">
                                    {{ $displayDate }}
                                </td>

                                <!-- <td class="px-4 py-3 text-center">
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-md text-[10px] font-bold uppercase tracking-wide">
                                        {{ $user->getRoleNames()->first() ?? 'No Role' }}
                                    </span>
                                </td> -->

                                <!-- <td class="px-4 py-3 text-center">
                                    @if ($user->status)
                                        <span class="status-pill active-pill border border-green-200">Active</span>
                                    @else
                                        <span class="status-pill inactive-pill border border-red-200">Inactive</span>
                                    @endif
                                </td> -->

                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('users.index', ['user' => $user->id]) }}"
                                            class="text-blue-600 hover:text-blue-800 font-bold text-xs uppercase tracking-wide hover:underline">
                                            Edit
                                        </a>
                                        <span class="text-gray-300">|</span>
                                        <a href="#" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-wide hover:underline">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div id="mobileUserList" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($users as $user)
                    @php
                        $createdDate = $user->created_at ? $user->created_at->format('Y-m-d') : '';
                    @endphp
                    <div class="mobile-user-card user-card bg-white p-4 rounded-xl border border-gray-100 shadow-sm" 
                        data-name="{{ strtolower($user->name) }}"
                        data-email="{{ strtolower($user->email) }}" data-phone="{{ strtolower($user->phone ?? '') }}"
                        data-role="{{ strtolower($user->getRoleNames()->first() ?? '') }}"
                        data-status="{{ $user->status ? 'active' : 'inactive' }}"
                        data-date="{{ $createdDate }}">
                        
                        <div class="flex items-center gap-3 mb-4 pb-3 border-b border-gray-50">
                            @if($user->image)
                                <img src="{{ asset('uploads/users/' . $user->image) }}" class="w-10 h-10 rounded-full object-cover border" />
                            @else
                                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs border border-emerald-100">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-sm text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-y-2 text-xs mb-4">
                            <div class="text-gray-500">Phone:</div>
                            <div class="text-right font-medium text-gray-700 font-mono">{{ $user->phone ?? '—' }}</div>
                            
                            <div class="text-gray-500">Joined:</div>
                            <div class="text-right font-medium text-gray-700">{{ $user->created_at ? $user->created_at->format('d M, Y') : '—' }}</div>

                            <div class="text-gray-500">Role:</div>
                            <div class="text-right font-medium text-blue-600 uppercase">{{ $user->getRoleNames()->first() ?? 'No Role' }}</div>
                            
                            <div class="text-gray-500">Status:</div>
                            <div class="text-right">
                                @if ($user->status)
                                    <span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded">Active</span>
                                @else
                                    <span class="text-red-600 font-bold bg-red-50 px-2 py-0.5 rounded">Inactive</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button class="flex-1 py-2 bg-gray-50 text-gray-700 rounded-lg text-xs font-bold border border-gray-200 hover:bg-gray-100">Edit</button>
                            <button class="flex-1 py-2 bg-red-50 text-red-600 rounded-lg text-xs font-bold border border-red-100 hover:bg-red-100">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div
                class="flex flex-col md:flex-row justify-between items-center gap-3 text-sm text-gray-600 mt-6 pagination-container bg-white p-4 rounded-xl border border-gray-100 shadow-sm">

                <p class="text-xs font-medium text-gray-500">
                    Showing <span class="font-bold text-gray-900">{{ $users->firstItem() }}</span> to <span class="font-bold text-gray-900">{{ $users->lastItem() }}</span> of <span class="font-bold text-gray-900">{{ $users->total() }}</span> entries
                </p>

                <div class="flex flex-wrap gap-2 justify-center pagination-buttons">
                    {{ $users->links('pagination.dots') }}
                </div>
            </div>


        </div>

    </main>



    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("searchInput");
            const roleFilter = document.getElementById("roleFilter");
            const dateFilter = document.getElementById("dateFilter"); // Date Input
            const activeCheck = document.getElementById("activeCheck");
            const inactiveCheck = document.getElementById("inactiveCheck");
            const resetBtn = document.getElementById("resetFilters");

            const rows = document.querySelectorAll(".user-row");
            const cards = document.querySelectorAll(".user-card");

            function filterUsers() {
                const search = searchInput.value.toLowerCase().trim();
                const role = roleFilter.value.toLowerCase();
                const selectedDate = dateFilter.value; // Get selected date (YYYY-MM-DD)
                const showActive = activeCheck.checked;
                const showInactive = inactiveCheck.checked;

                const allElements = [...rows, ...cards];

                allElements.forEach(el => {
                    const name = el.dataset.name || "";
                    const email = el.dataset.email || "";
                    const phone = el.dataset.phone || "";
                    const userRole = el.dataset.role || "";
                    const status = el.dataset.status || "";
                    const rowDate = el.dataset.date || ""; // Get date from row

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

                    // Date filter
                    if (selectedDate && rowDate !== selectedDate) {
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
            dateFilter.addEventListener("change", filterUsers); // Listener for date
            activeCheck.addEventListener("change", filterUsers);
            inactiveCheck.addEventListener("change", filterUsers);
            
            // Debounce keyboard input slightly for performance
            let timeout = null;
            searchInput.addEventListener("keyup", () => {
                clearTimeout(timeout);
                timeout = setTimeout(filterUsers, 300);
            });

            resetBtn.addEventListener("click", () => {
                searchInput.value = "";
                roleFilter.value = "";
                dateFilter.value = ""; // Reset date
                activeCheck.checked = true;
                inactiveCheck.checked = true;
                filterUsers();
            });

        });

        // ===================== CSV EXPORT SCRIPT =====================
        function exportTableToCSV(filename) {
            var csv = [];
            
            // 1. Headers
            var header = [];
            var ths = document.querySelectorAll("#usersTable thead th");
            // Skip the first (index) and last (actions) column for cleaner export
            for(let i = 1; i < ths.length - 1; i++) {
                header.push(ths[i].innerText);
            }
            csv.push(header.join(","));

            // 2. Data Rows
            var rows = document.querySelectorAll("#usersTable tbody tr");
            
            rows.forEach(row => {
                if(row.style.display === 'none') return;

                var rowData = [];
                var cols = row.querySelectorAll("td");

                let nameCell = cols[1].querySelector('p')?.innerText || cols[1].innerText;
                rowData.push('"' + nameCell.trim() + '"');
                rowData.push('"' + cols[2].innerText.trim() + '"');
                rowData.push('"' + cols[3].innerText.trim() + '"');
                rowData.push('"' + cols[4].innerText.trim() + '"');

                rowData.push('"' + cols[5].innerText.trim() + '"');

                rowData.push('"' + cols[6].innerText.trim() + '"');

                csv.push(rowData.join(","));
            });

            // 3. Download Logic
            var csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
            var downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    </script>
@endsection