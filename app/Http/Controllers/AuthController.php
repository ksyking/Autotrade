<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showAuth(Request $request)
    {
        // ?tab=login or ?tab=register
        $tab = $request->query('tab', session('created') ? 'login' : 'login');
        return view('auth.index', ['tab' => in_array($tab, ['login','register']) ? $tab : 'login']);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password_hash)) {
            throw ValidationException::withMessages(['auth' => 'Invalid email or password.']);
        }

        Auth::login($user);
        return redirect()->route('autotrade.home');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'role'     => ['required', Rule::in(['buyer','seller'])],
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:6'],
        ]);

        User::create([
            'role'          => $data['role'],
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password_hash' => Hash::make($data['password']),
        ]);

        // send them back to the same page on the Login tab with a success flash
        return redirect()->route('auth.page', ['tab' => 'login'])->with('created', 1);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.page', ['tab' => 'login']);
    }
}
