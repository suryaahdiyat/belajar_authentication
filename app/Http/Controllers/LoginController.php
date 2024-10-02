<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function loginV(){
        return view("pages.login");
    }

    public function registerV(){
        return view("pages.register");
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email:dns|max:255',
            'password' => 'required|min:4'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'failed login');
    }

    public function register(Request $request){
        // dd($request->all());
        $validatedData = $request->validate([
            'email' => 'required|email:dns|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(4)->mixedCase()->symbols()],
            // 'password' => 'required|confirmed|string|min:4',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);
        return redirect('/login')->with('success', 'register success');
    }

    public function logout(){
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }
}
