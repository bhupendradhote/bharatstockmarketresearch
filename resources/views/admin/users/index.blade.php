@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-pOZQ7+6iX14a7qYw0r0Yp5O+v6B8+VjsLPL6tYFxOJvOzfiqHRa2hT1/O0G2G45m4Bb8J6GZ7bz5fR5l7De+AA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" integrity="sha384-MV+VvF0QoI6u0YvBMQK/xh2C2P6Yo3V2v6DlZz/cYt0/nl/7v8EHPbRrP49Y1U5b" crossorigin="anonymous">


   <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-slate-800">Edit User</h3>
                <button id="closeModalBtn" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="editUserForm" method="POST" action="#" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div class="border border-slate-200 rounded-lg p-6 bg-slate-50">
                        <h4 class="text-lg font-medium text-slate-800 mb-4">Profile Image</h4>
                        
                        <div class="flex flex-col md:flex-row items-start gap-6">
                            <div class="flex flex-col items-center">
                                <div class="h-40 w-40 rounded-full overflow-hidden border-4 border-white shadow-lg mb-4">
                                    <img id="currentProfileImage" 
                                         src="" 
                                         alt="Current Profile"
                                         class="h-full w-full object-cover"
                                         onerror="this.src='https://ui-avatars.com/api/?name=User&background=10b981&color=fff&size=256'">
                                </div>
                                <p class="text-sm text-slate-600" id="currentImageText">Current profile image</p>
                            </div>
                            
                            <div class="flex-1">
                                <div class="mb-4">
                                    <label for="profile_image" class="block text-sm font-medium text-slate-700 mb-2">
                                        Upload New Image
                                    </label>
                                    <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-emerald-400 transition-colors cursor-pointer"
                                         onclick="document.getElementById('profile_image').click()"
                                         id="dropZone">
                                        <div class="mx-auto w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center mb-3">
                                            <i class="fas fa-cloud-upload-alt text-emerald-600 text-xl"></i>
                                        </div>
                                        <p class="text-slate-700 font-medium mb-1">Click to upload or drag and drop</p>
                                        <p class="text-sm text-slate-500">PNG, JPG, GIF up to 5MB</p>
                                    </div>
                                    <input type="file" 
                                           id="profile_image" 
                                           name="profile_image" 
                                           accept="image/*" 
                                           class="hidden"
                                           onchange="previewImage(event)">
                                </div>
                                
                                <!-- New Image Preview -->
                                <div id="newImagePreview" class="hidden">
                                    <p class="text-sm font-medium text-slate-700 mb-2">New Image Preview:</p>
                                    <div class="flex items-center gap-4">
                                        <div class="h-20 w-20 rounded-full overflow-hidden">
                                            <img id="newImagePreviewImg" 
                                                 src="" 
                                                 alt="New Profile Preview"
                                                 class="h-full w-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-sm text-slate-600 mb-1">New image selected</p>
                                            <button type="button" 
                                                    onclick="removeNewImage()"
                                                    class="text-xs text-red-600 hover:text-red-700">
                                                <i class="fas fa-times mr-1"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Remove Current Image Option -->
                                <div class="mt-4" id="removeImageOption">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="remove_profile_image" 
                                               name="remove_profile_image" 
                                               value="1"
                                               class="h-4 w-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                                        <label for="remove_profile_image" class="ml-2 text-sm text-slate-700">
                                            Remove current profile image
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Details Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_name" class="block text-sm font-medium text-slate-700 mb-1">
                                Full Name *
                            </label>
                            <input type="text" id="edit_name" name="name" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="edit_email" class="block text-sm font-medium text-slate-700 mb-1">
                                Email Address *
                            </label>
                            <input type="email" id="edit_email" name="email" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="edit_phone" class="block text-sm font-medium text-slate-700 mb-1">
                                Phone Number
                            </label>
                            <input type="tel" id="edit_phone" name="phone" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <!-- City -->
                        <div>
                            <label for="edit_city" class="block text-sm font-medium text-slate-700 mb-1">
                                City
                            </label>
                            <input type="text" id="edit_city" name="city" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="edit_role" class="block text-sm font-medium text-slate-700 mb-1">
                                Role
                            </label>
                            <select id="edit_role" name="role" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="edit_status" class="block text-sm font-medium text-slate-700 mb-1">
                                Status
                            </label>
                            <select id="edit_status" name="status" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Additional Fields (full width) -->
                    <div>
                        <label for="edit_notes" class="block text-sm font-medium text-slate-700 mb-1">
                            Additional Notes
                        </label>
                        <textarea id="edit_notes" name="notes" rows="3" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                        <button type="button" id="cancelEditBtn" 
                            class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-md hover:bg-slate-200 transition">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-emerald-500 rounded-md hover:bg-emerald-600 transition flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



    <div class="flex flex-col lg:flex-row gap-6">

            <!-- LEFT SIDEBAR -->
                <div class="lg:w-1/4 w-full">
                                <div class="bg-white rounded-lg shadow h-[calc(100vh-9rem)] flex flex-col">
                            <div class="p-4 border-b border-slate-200 flex-shrink-0">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold text-slate-800">Customers List</h2>
                                    <button class="text-xs bg-emerald-500 text-white px-3 py-1.5 rounded-md hover:bg-emerald-600">
                                        <i class="fas fa-plus mr-1"></i> Add User
                                    </button>
                                </div>
                                <div class="relative">
                                    <input type="text" placeholder="Search Customers..."
                                        class="w-full pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-md focus:ring-emerald-500">
                                    <i class="fas fa-search absolute left-3 top-2.5 text-slate-400 text-sm"></i>
                                </div>
                            </div>

                            <div class="flex-1 overflow-hidden">
                                <div class="h-full overflow-y-auto p-4 pt-3">
                                    @foreach ($users as $user)
                                        @php 
                                            // Handle null/empty name for initials
                                            $initials = '??'; // Default fallback
                                            if (!empty($user['name'])) {
                                                $initials = strtoupper(substr($user['name'], 0, 2));
                                            }
                                            
                                            // Get profile image URL from user array
                                            $profileImageUrl = $user['profile_image_url'] ?? null;
                                        @endphp

                                        <div onclick="selectUser({{ $user['id'] }})" id="user-{{ $user['id'] }}"
                                            class="user-item p-3 rounded-md border border-slate-200 hover:bg-slate-50 cursor-pointer transition mb-3">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full flex items-center justify-center mr-3 relative overflow-hidden">
                                                    @if ($profileImageUrl)
                                                        <img src="{{ $profileImageUrl }}" 
                                                            alt="{{ $user['name'] ?? 'User' }}"
                                                            class="h-full w-full object-cover"
                                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    @endif
                                                    
                                                    <div class="h-full w-full rounded-full {{ $profileImageUrl ? 'hidden' : 'bg-emerald-100 flex items-center justify-center text-emerald-700 font-semibold' }}">
                                                        {{ $initials }}
                                                    </div>
                                                </div>
                                                
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-medium text-sm text-slate-800 truncate">{{ $user['name'] ?? 'Unnamed User' }}</h4>
                                                    <p class="text-xs text-slate-500 truncate">{{ $user['phone'] ?? 'No phone' }}</p>
                                                </div>
                                                <span class="h-2 w-2 rounded-full bg-emerald-500 ml-2"></span>
                                            </div>
                                        </div> @endforeach
                                </div>
                            </div>

                            <div class="p-4
        border-t border-slate-200 flex-shrink-0">
    <p class="text-xs text-slate-500 text-center">{{ count($users) }} customer total</p>
    </div>
    </div>
    </div>

    <!-- RIGHT CONTENT AREA -->
    <div class="lg:w-3/4 w-full min-h-1/2 overflow-y-auto">
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-semibold text-slate-800">Customer Management</h1>
                    <p class="text-sm text-slate-500 mt-1">View and manage customer profiles and permissions</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow mb-6 p-6">
            <div id="userDetails">
                <p class="text-slate-500">Select a customer to view details...</p>
            </div>
        </div>
    </div>
    </div>
    <script>
        let allUsers = @json($users);
        let selectedUserId = @json($selectedUserId);

        if (selectedUserId) selectedUserId = parseInt(selectedUserId);

        const editUserModal = document.getElementById('editUserModal');
        const editUserForm = document.getElementById('editUserForm');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');

        const DEBUG = true;

        function debugLog(message, data = null) {
            if (DEBUG) {
                console.log(`[DEBUG] ${message}`, data || '');
            }
        }

        function getUserInitials(userName) {
            if (!userName || userName.trim().length === 0) {
                return '??';
            }
            return userName.substring(0, 2).toUpperCase();
        }

        function openEditModal(user) {
            debugLog('Opening edit modal for user:', user);

            // Populate form fields with user data
            document.getElementById('edit_name').value = user.name || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_phone').value = user.phone || '';
            document.getElementById('edit_city').value = user.city || '';
            document.getElementById('edit_notes').value = user.notes || '';

            // Set role
            const roleSelect = document.getElementById('edit_role');
            const roleName = (user.roles && user.roles.length > 0) ? user.roles[0] : 'user';
            roleSelect.value = roleName;

            // Set status
            const statusSelect = document.getElementById('edit_status');
            statusSelect.value = user.status ? '1' : '0';

            // Update form action
            editUserForm.action = `/users/${user.id}`;
            debugLog('Form action set to:', editUserForm.action);

            // Set current profile image for media library
            const currentImage = document.getElementById('currentProfileImage');
            const currentImageText = document.getElementById('currentImageText');
            const removeImageOption = document.getElementById('removeImageOption');

            if (user.profile_image_url) {
                currentImage.src = user.profile_image_url;
                currentImageText.textContent = 'Current profile image';
                removeImageOption.classList.remove('hidden');
            } else {
                // Generate initials avatar as fallback
                const initials = getUserInitials(user.name);
                currentImage.src =
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name || 'User')}&background=10b981&color=fff&size=256`;
                currentImageText.textContent = 'No profile image';
                removeImageOption.classList.add('hidden');
            }

            document.getElementById('profile_image').value = '';
            document.getElementById('newImagePreview').classList.add('hidden');
            document.getElementById('remove_profile_image').checked = false;

            editUserModal.classList.remove('hidden');
            editUserModal.classList.add('flex');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeEditModal() {
            editUserModal.classList.add('hidden');
            editUserModal.classList.remove('flex');
            document.body.style.overflow = ''; // Restore scrolling
        }

        // Function to show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-md shadow-lg text-white z-50 ${
            type === 'success' ? 'bg-emerald-500' : 'bg-red-500'
        }`;
            notification.textContent = message;
            document.body.appendChild(notification);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        function updateUserInArray(updatedUser) {
            const index = allUsers.findIndex(u => u.id === updatedUser.id);
            if (index !== -1) {
                allUsers[index] = {
                    ...allUsers[index],
                    ...updatedUser
                };
                debugLog('User updated in array:', allUsers[index]);
                return true;
            }
            return false;
        }

        closeModalBtn.addEventListener('click', closeEditModal);
        cancelEditBtn.addEventListener('click', closeEditModal);

        // Close modal when clicking outside
        editUserModal.addEventListener('click', function(e) {
            if (e.target === editUserModal) {
                closeEditModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !editUserModal.classList.contains('hidden')) {
                closeEditModal();
            }
        });

        function selectUser(id) {
            debugLog('Selecting user with ID:', id);

            // Highlight
            document.querySelectorAll('.user-item').forEach(item => {
                item.classList.remove('bg-emerald-50', 'border-emerald-400');
            });
            let selectedItem = document.getElementById('user-' + id);
            if (selectedItem) selectedItem.classList.add('bg-emerald-50', 'border-emerald-400');

            // Find user
            let user = allUsers.find(u => u.id === id);
            if (!user) {
                debugLog('User not found with ID:', id);
                return;
            }

            let initials = getUserInitials(user.name);
            let profileImage = user.profile_image_url || null;
            let statusText = user.status ? "Active" : "Inactive";
            let statusClass = user.status ? "bg-green-100 text-green-700" : "bg-red-100 text-red-600";
            let roleName = (user.roles && user.roles.length > 0) ? user.roles[0] : "User";
            let displayName = user.name || 'Unnamed User';

            document.getElementById("userDetails").innerHTML = `
        <div class="flex flex-col md:flex-row items-start gap-6">
            <div class="flex flex-col items-center">
                <div class="h-32 w-32 rounded-full flex items-center justify-center mb-3 overflow-hidden">
                    ${
                        profileImage
                        ? `<img src="${profileImage}" class="h-full w-full object-cover">`
                        : `<div class="h-full w-full bg-emerald-100 flex items-center justify-center text-4xl text-emerald-700 font-bold">${initials}</div>`
                    }
                </div>
                <button onclick="openEditModal(${JSON.stringify(user).replace(/"/g, '&quot;')})" 
                    class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                    <i class="fas fa-camera mr-1"></i> Change Photo
                </button>
            </div>

            <div class="flex-1 border-l border-slate-200 pl-6">
                <div class="flex flex-wrap items-center gap-4 mb-4">
                    <h2 class="text-2xl font-bold text-slate-800">${displayName}</h2>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">
                        ${roleName}
                    </span>
                    <span class="px-3 py-1 ${statusClass} text-xs font-semibold rounded-full">
                        ${statusText}
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Email Address</p>
                        <p class="font-medium text-slate-800">${user.email || 'No email'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Phone Number</p>
                        <p class="font-medium text-slate-800">${user.phone ?? 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 mb-1">City</p>
                        <p class="font-medium text-slate-800">${user.city ?? 'N/A'}</p>
                    </div>
                </div>
            </div>

            <div>
                <button onclick="openEditModal(${JSON.stringify(user).replace(/"/g, '&quot;')})" 
                    class="px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 flex items-center gap-2 transition">
                    <i class="fas fa-edit"></i>
                    Edit User
                </button>
            </div>
        </div>
        `;
        }

        // Auto select
        if (selectedUserId) {
            selectUser(selectedUserId);
        } else if (allUsers.length > 0) {
            selectUser(allUsers[0].id);
        }

        // Form submission handler
        editUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            debugLog('Form submission started');

            // Get form data for debugging
            const formData = new FormData(this);
            debugLog('Form data:', Object.fromEntries(formData));

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            const originalDisabled = submitBtn.disabled;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            submitBtn.disabled = true;

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            debugLog('CSRF Token:', csrfToken);

            // Prepare fetch request
            const url = this.action;
            debugLog('Making request to:', url);

            formData.append('_method', 'PUT');

            fetch(url, {
                    method: 'POST', // Use POST with _method parameter
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    debugLog('Response status:', response.status);
                    debugLog('Response headers:', Object.fromEntries(response.headers.entries()));

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    debugLog('Response data:', data);

                    if (data.success) {
                        // Update the user in our array
                        const updated = updateUserInArray(data.user);

                        if (updated) {
                            selectUser(data.user.id);

                            showNotification(data.message || 'User updated successfully!', 'success');

                            // Close modal
                            closeEditModal();
                        } else {
                            showNotification('User updated but could not refresh view', 'error');
                        }
                    } else {
                        let errorMessage = 'Error updating user';

                        if (data.errors) {
                            const errors = Object.values(data.errors).flat();
                            errorMessage = errors.join('\n');
                            debugLog('Validation errors:', data.errors);
                        } else if (data.message) {
                            errorMessage = data.message;
                        }

                        showNotification(errorMessage, 'error');

                        // Keep modal open if there are validation errors
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = originalDisabled;
                        return;
                    }
                })
                .catch(error => {
                    debugLog('Fetch error:', error);
                    console.error('Error:', error);
                    showNotification('An error occurred while updating the user: ' + error.message, 'error');

                    // Restore button state on error
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = originalDisabled;
                })
                .finally(() => {
                    // Only restore button if not already restored (in case of validation errors)
                    if (submitBtn.innerHTML.includes('fa-spinner')) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = originalDisabled;
                    }
                });
        });

        // Image preview and upload functions
        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];

            debugLog('Image selected:', file);

            if (file) {
                // Validate file size (5MB = 5 * 1024 * 1024 bytes)
                if (file.size > 5 * 1024 * 1024) {
                    showNotification('File size must be less than 5MB', 'error');
                    input.value = '';
                    return;
                }

                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    showNotification('Only JPEG, PNG, and GIF images are allowed', 'error');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();

                reader.onload = function(e) {
                    // Show new image preview
                    document.getElementById('newImagePreview').classList.remove('hidden');
                    document.getElementById('newImagePreviewImg').src = e.target.result;

                    // Hide remove image option when uploading new one
                    document.getElementById('removeImageOption').classList.add('hidden');
                    debugLog('Image preview loaded');
                }

                reader.onerror = function(e) {
                    debugLog('Error reading file:', e);
                    showNotification('Error reading image file', 'error');
                }

                reader.readAsDataURL(file);
            }
        }

        function removeNewImage() {
            // Clear file input
            document.getElementById('profile_image').value = '';
            debugLog('New image removed');

            // Hide new image preview
            document.getElementById('newImagePreview').classList.add('hidden');

            // Show remove image option again
            document.getElementById('removeImageOption').classList.remove('hidden');
        }

        // Drag and drop functionality
        const dropZone = document.getElementById('dropZone');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-emerald-500', 'bg-emerald-50');
            debugLog('Drag highlight');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-emerald-500', 'bg-emerald-50');
            debugLog('Drag unhighlight');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            debugLog('File dropped');
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                // Only process first file
                const file = files[0];

                // Validate file
                if (file.type.startsWith('image/')) {
                    // Create a new DataTransfer object
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    // Assign to file input
                    document.getElementById('profile_image').files = dataTransfer.files;

                    // Trigger change event
                    const event = new Event('change', {
                        bubbles: true
                    });
                    document.getElementById('profile_image').dispatchEvent(event);
                } else {
                    showNotification('Please drop an image file', 'error');
                }
            }
        }
    </script>

    {{-- image script --}}
    <script>
        // Image preview and upload functions
        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Show new image preview
                    document.getElementById('newImagePreview').classList.remove('hidden');
                    document.getElementById('newImagePreviewImg').src = e.target.result;

                    // Hide remove image option when uploading new one
                    document.getElementById('removeImageOption').classList.add('hidden');
                }

                reader.readAsDataURL(file);
            }
        }

        function removeNewImage() {
            // Clear file input
            document.getElementById('profile_image').value = '';

            // Hide new image preview
            document.getElementById('newImagePreview').classList.add('hidden');

            // Show remove image option again
            document.getElementById('removeImageOption').classList.remove('hidden');
        }

        // Drag and drop functionality
        const dropZone = document.getElementById('dropZone');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-emerald-500', 'bg-emerald-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-emerald-500', 'bg-emerald-50');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                document.getElementById('profile_image').files = files;

                // Trigger change event
                const event = new Event('change', {
                    bubbles: true
                });
                document.getElementById('profile_image').dispatchEvent(event);
            }
        }

        // Update the openEditModal function to handle images
        function openEditModal(user) {
            // Populate form fields with user data
            document.getElementById('edit_name').value = user.name || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_phone').value = user.phone || '';
            document.getElementById('edit_city').value = user.city || '';
            document.getElementById('edit_notes').value = user.notes || '';

            // Set role
            const roleSelect = document.getElementById('edit_role');
            const roleName = (user.roles && user.roles.length > 0) ? user.roles[0] : 'user';
            roleSelect.value = roleName;

            // Set status
            const statusSelect = document.getElementById('edit_status');
            statusSelect.value = user.status ? '1' : '0';

            // Update form action
            editUserForm.action = `/users/${user.id}`;

            // Set current profile image
            const currentImage = document.getElementById('currentProfileImage');
            const currentImageText = document.getElementById('currentImageText');
            const removeImageOption = document.getElementById('removeImageOption');

            if (user.profile_image_url) {
                currentImage.src = user.profile_image_url;
                currentImageText.textContent = 'Current profile image';
                removeImageOption.classList.remove('hidden');
            } else {
                // Generate initials avatar as fallback
                const initials = getUserInitials(user.name);
                currentImage.src =
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name || 'User')}&background=10b981&color=fff&size=256`;
                currentImageText.textContent = 'No profile image';
                removeImageOption.classList.add('hidden');
            }

            // Reset file input
            document.getElementById('profile_image').value = '';
            document.getElementById('newImagePreview').classList.add('hidden');
            document.getElementById('remove_profile_image').checked = false;

            // Show modal
            editUserModal.classList.remove('hidden');
            editUserModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    </script>
@endsection
