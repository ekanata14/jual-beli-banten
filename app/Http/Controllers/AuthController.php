<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Pelanggan;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Buat file ini di resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $credentials = $request->only('email', 'password');

            // Cek login sebagai Admin
            $admin = Admin::where('email', $credentials['email'])->first();
            if ($admin && Hash::check($credentials['password'], $admin->password)) {
                Auth::guard('admin')->login($admin);
                return redirect()->route('dashboard')->with('success', 'Login sebagai Admin berhasil');
            }

            // Cek login sebagai Pelanggan
            $pelanggan = Pelanggan::where('email', $credentials['email'])->first();
            if ($pelanggan && Hash::check($credentials['password'], $pelanggan->password)) {
                Auth::guard('pelanggan')->login($pelanggan);
                return redirect()->route('dashboard')->with('success', 'Login sebagai Pelanggan berhasil');
            }

            return back()->withErrors(['email' => 'Email atau password salah']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logout berhasil');
    }
}
