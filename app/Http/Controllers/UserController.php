<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

//User Controller - Mengelola profil pengguna
class UserController extends Controller
{
    
    //Menampilkan halaman profil pengguna
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

  
    //Memperbarui data profil pengguna
    public function updateProfile(UserRequest $request)
    {
        try {
            $user = Auth::user();
            $data = $request->validated();

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