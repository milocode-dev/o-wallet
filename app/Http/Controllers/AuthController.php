<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email|required',
            'password' => 'string|min:8|required',
        ]);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        User::create($validatedData);

        return redirect()->route('login')->with('success', 'Berhasil register!');
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'email|required',
            'password' => 'string|min:8|required',
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
    
        return redirect('login');
    }
}
