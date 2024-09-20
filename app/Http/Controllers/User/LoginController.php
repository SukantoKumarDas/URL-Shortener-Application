<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = '/';

    public function __construct() {
        $this->middleware('guest:web')->except('logout');
    }

    public function showRegisterForm() {
        return view('user.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('web')->login($user);
        return redirect()->route('home');
    }

    public function showLoginForm() {
        return view('user.login');
    }

    protected function validateLogin(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->validate($credentials)) {
            return true;
        }
        return false;
    }

    public function login(Request $request) {
        if ($this->validateLogin($request)) {
            $user = User::where('email', $request->input('email'))->first();
            Auth::login($user);
            return redirect()->route('create-custom-url');
        }
        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request) {
        Auth::guard('web')->logout();
        return $this->loggedOut($request) ?: redirect()->route('home');
    }
}
