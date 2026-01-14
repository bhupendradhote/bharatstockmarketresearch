<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Log;



class UserController extends Controller
{

public function index(Request $request)
{
    $users = User::with('roles', 'media')->get()->map(function($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'city' => $user->city,
            'status' => $user->status,
            'notes' => $user->notes ?? '', // Add this if you have notes field
            'roles' => $user->getRoleNames()->toArray(), // Make sure it's an array
            'profile_image_url' => $user->getFirstMediaUrl('profile_images') // Use correct collection name
        ];
    });

    $selectedUserId = $request->query('user');

    return view('admin.users.index', compact('users', 'selectedUserId'));
}



//        public function listUsers()
// {
//     $users = User::paginate(10); 
//     return view('admin.users.listedUsers', compact('users'));
// }


public function listUsers()
{
    $users = User::with('roles', 'media')->paginate(10);
    
    // Don't transform to arrays - keep as objects
    return view('admin.users.listedUsers', compact('users'));
}


public function update(Request $request, User $user)
{
    // Validate the request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:20',
        'city' => 'nullable|string|max:100',
        'role' => 'nullable|string|in:user,admin,manager,editor',
        'status' => 'required|in:0,1',
        'notes' => 'nullable|string',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
        'remove_profile_image' => 'nullable|boolean'
    ]);

    // Update basic user info
    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'city' => $validated['city'],
        'status' => $validated['status'],
        'notes' => $validated['notes'],
    ]);

    // Handle role update
    if (isset($validated['role'])) {
        $user->roles()->detach();
        $role = Role::where('name', $validated['role'])->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }
    }

    // Handle profile image with Media Library
    if ($request->hasFile('profile_image')) {
        // IMPORTANT: Clear existing images first
        $user->clearMediaCollection('profile_images');
        
        // Add the new media
        $media = $user->addMediaFromRequest('profile_image')
            ->usingName('profile_image_' . $user->id)
            ->usingFileName($request->file('profile_image')->getClientOriginalName())
            ->toMediaCollection('profile_images', 'public');
        
        // Log for debugging
        Log::info('New profile image uploaded for user ' . $user->id, [
            'media_id' => $media->id,
            'file_name' => $media->file_name,
            'url' => $media->getUrl()
        ]);
    }
    // Handle remove profile image checkbox
    elseif ($request->has('remove_profile_image') && $request->remove_profile_image == '1') {
        // Delete all profile images
        $user->clearMediaCollection('profile_images');
        Log::info('Profile image removed for user ' . $user->id);
    }

    // IMPORTANT: Refresh the user model to get updated media
    $user->refresh();
    
    // Get the latest profile image URL for response
    $profileImageUrl = $user->getFirstMediaUrl('profile_images');
    
    // Debug: Check what's being returned
    Log::info('Update response for user ' . $user->id, [
        'profile_image_url' => $profileImageUrl,
        'media_count' => $user->getMedia('profile_images')->count()
    ]);

    return response()->json([
        'success' => true,
        'message' => 'User updated successfully',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'city' => $user->city,
            'status' => $user->status,
            'notes' => $user->notes,
            'profile_image_url' => $profileImageUrl ?: null,
            'roles' => $user->roles->pluck('name')->toArray()
        ]
    ]);
}
}