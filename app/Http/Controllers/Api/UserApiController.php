<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Role;


class UserApiController extends Controller
{
    public function user(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'city'  => $user->city ?? '',
                'status' => $user->status,
                'notes' => $user->notes ?? '',
                'profile_image_url' => $user->getFirstMediaUrl('profile_images') ?: null,
                'roles' => $user->roles->pluck('name')->toArray(),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]
        ]);
    }

    public function usersCountToken()
    {
        $users = User::with(['roles', 'media'])->get();

    return response()->json([
        'success' => true,
        'count' => $users->count(),
        'users' => $users->map(function ($user) {
            return [
                ...$user->toArray(),

                'profile_image_url' => $user->getFirstMediaUrl('profile_images') ?: null,
                'roles' => $user->roles->pluck('name')->toArray(),
            ];
        }),
    ]);
    }


    public function update(Request $request, $id = null)
    {   
        if ($id === null) {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
        } else {
            $authUser = Auth::user();
            if (!$authUser->hasRole('super-admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required to update other users.',
                ], 403);
            }
            
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }
        }

        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        if ($request->has('role') && $request->role) {
            $user->roles()->detach();
            $role = Role::where('name', $request->role)->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        }

        if ($request->hasFile('profile_image')) {
            $user->clearMediaCollection('profile_images');
            
            $media = $user->addMediaFromRequest('profile_image')
                ->usingName('profile_image_' . $user->id)
                ->usingFileName($request->file('profile_image')->getClientOriginalName())
                ->toMediaCollection('profile_images', 'public');
            
            Log::info('New profile image uploaded via API for user ' . $user->id, [
                'media_id' => $media->id,
                'file_name' => $media->file_name,
                'url' => $media->getUrl()
            ]);
        }
        elseif ($request->has('remove_profile_image') && $request->remove_profile_image == '1') {
            $user->clearMediaCollection('profile_images');
            Log::info('Profile image removed via API for user ' . $user->id);
        }

        $user->refresh();
        
        $profileImageUrl = $user->getFirstMediaUrl('profile_images');
        
        Log::info('Update response via API for user ' . $user->id, [
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