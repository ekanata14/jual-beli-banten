<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

// Models
use App\Models\User;
use App\Models\Pelanggan;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $viewData = [
            'title' => 'Register Page',
        ];
        return view('auth.register', $viewData);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'alamat_pelanggan' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'], // Optional latitude
            'longitude' => ['nullable', 'numeric'], // Optional longitude
            'kode_pos' => ['nullable', 'string', 'max:10'], // Optional postal code
            'phone_number' => ['nullable', 'string', 'max:15'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan', // Default role for new users
        ]);

        // Create a Pelanggan record for the new user
        Pelanggan::create([
            'id_user' => $user->id,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'kode_pos' => $request->kode_pos,
            'no_telp' => $request->phone_number,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
