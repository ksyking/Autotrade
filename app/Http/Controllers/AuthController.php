<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate like your legacy checks
        $data = $request->validate([
            'role'     => ['required', Rule::in(['buyer','seller'])],
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:6'],
        ]);

        try {
            User::create([
                'role'          => $data['role'],
                'name'          => $data['name'],
                'email'         => $data['email'],
                // store into your existing password_hash column
                'password_hash' => Hash::make($data['password']),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // MySQL duplicate email code = 1062 (extra safety if unique rule missed it)
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
                return back()
                    ->withErrors(['email' => 'That email is already registered. Try logging in.'])
                    ->withInput();
            }
            return back()
                ->withErrors(['general' => 'Signup failed. Please try again.'])
                ->withInput();
        }

        // Match your legacy flow: go to login after creating
        return redirect()->route('login')->with('created', 1);
    }

    public function showLogin() { return view('auth.login'); }
    public function login(Request $request) { /* ...your existing login from earlier... */ }
}
