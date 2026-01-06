<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//Authentication Controller - Menangani login/logout/registrasi
class AuthController extends Controller
{
    //Menampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    //Memproses permintaan login
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

    //Menampilkan form registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    //Memproses permintaan registrasi
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

    //Memproses permintaan logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Anda telah berhasil logout');
    }
}
