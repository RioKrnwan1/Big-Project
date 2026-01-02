<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Authentication Controller - Handles login/logout/register
 */
class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/spk')
                ->with('success', 'Selamat datang, ' . Auth::user()->name);
        }

        return back()->withInput($request->only('email'))
            ->with('error', 'Email atau password salah');
    }

    /**
     * Show the registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());

            // Redirect ke login setelah registrasi berhasil
            return redirect()->route('login')
                ->with('success', 'Pendaftaran berhasil! Akun Anda telah terdaftar. Silakan login untuk melanjutkan.');
        } catch (\Exception $e) {
            \Log::error('Registration Error: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Anda telah berhasil logout');
    }
}
