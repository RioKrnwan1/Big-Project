<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

/**
 * User Controller - Manages user profile
 */
class UserController extends Controller
{
    /**
     * Show the authenticated user's profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    /**
     * Update the authenticated user's profile
     */
    public function updateProfile(UserRequest $request)
    {
        try {
            $user = Auth::user();
            $data = $request->validated();

            // Remove password if empty (no update needed)
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user->update($data);

            return redirect()->route('profile')
                ->with('success', 'Profile berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error updating profile: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui profile');
        }
    }
}