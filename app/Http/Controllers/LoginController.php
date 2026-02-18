<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class LoginController extends Controller
{
    protected $authService;
    protected $userService;
    public function __construct(authService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function index()
    {
        //        check if user is already logged in
        if (Auth::check()) {
            return redirect()->route('suspect')->with('success', 'You are already logged in!');
        }

        return view('login.index');
    }

    public function authenticate(Request $request) : RedirectResponse
    {

        $auth = $this->authService->authenticate($request);

        // Set session timeout ke 7 jam
        session(['login_time' => now()]);
        session(['session_expires_at' => now()->addHours(env('SESSION_EXPIRES_TIME'))]);

        if (!$auth['success']) {
            return redirect()->back()->with('error', $auth['message']);
        }

                $waktuLogin = Carbon::now();
                $waktuLogin = session()->put('waktuLogin', $waktuLogin);
                return redirect()->route('suspect')->with('success', 'Login Successful!');
    }

    public function logout(Request $request): RedirectResponse
    {
//        if (auth()->user()->role !== 'super_admin')
//        {
//            auth()->user()->update([
//                "is_active" => 0
//            ]);
//        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'logged out successfully.');
    }
}
