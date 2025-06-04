<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Users
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $viewData = [
            "title" => "Login",
        ];
        return view('auth.login', $viewData); // Buat file ini di resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $credentials = $request->only('email', 'password');
            // Cek login sebagai User (Admin atau Pelanggan)
            $user = User::where('email', $credentials['email'])->first();
            if ($user && Hash::check($credentials['password'], $user->password)) {
                Auth::login($user);

                // Misal ada kolom 'role' untuk membedakan admin/pelanggan
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Login sebagai Admin berhasil');
                } elseif ($user->role === 'penjual') {
                    return redirect()->route('penjual.dashboard')->with('success', 'Login sebagai Penjual berhasil');
                } else {
                    return redirect()->route('penjual.dashboard')->with('success', 'Login sebagai Pelanggan berhasil');
                }
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
