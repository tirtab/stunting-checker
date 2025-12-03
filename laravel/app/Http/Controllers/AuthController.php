<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // === Tampilkan Form Register ===
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // === Proses Register ===
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Simpan user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'users',
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan cek stunting anak Anda.');
    }

    // === Tampilkan Form Login ===
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // === Proses Login ===
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect("/beranda")->with('success', 'Login berhasil!');
        }



        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    // === Logout ===
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
