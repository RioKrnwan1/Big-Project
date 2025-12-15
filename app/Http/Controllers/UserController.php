<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

/**
 * User Controller - Manages admin users
 */
class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(UserRequest $request)
    {
        try {
            User::create($request->validated());

            return redirect()->route('users.index')
                ->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan user');
        }
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', 'User tidak ditemukan');
        }
    }

    /**
     * Update the specified user
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $data = $request->validated();

            // Remove password if empty (no update needed)
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user->update($data);

            return redirect()->route('users.index')
                ->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error updating user: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui user');
        }
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        try {
            // Prevent deleting the last user
            if (User::count() <= 1) {
                return back()->with('error', 'Tidak dapat menghapus user terakhir');
            }

            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()
                ->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting user: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus user');
        }
    }

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