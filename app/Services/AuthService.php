<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function authenticate($request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            // Cek kolom login di sini
            if ($user->is_active === 0) {
                auth()->logout();
                session()->flush();
                return [
                    'success' => false,
                    'message' => 'Your account is not active. Contact Super Admin.'
                ];
            }

            $request->session()->regenerate();
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Invalid credentials'];
    }


    public function checkUserActive($email)
    {
        return $this->user->where('email', $email)->first()->login;
    }
    public function showMinute()
    {

        $request = session()->get('waktuLogin');
        $waktuLogin = $request;
        $selisihMenit = $waktuLogin->diffForHumans();

        return $selisihMenit;
    }
}
