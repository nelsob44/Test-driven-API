<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Socialite;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $token = User::whereEmail($request->email)->first()->createToken($request->email)->accessToken;

            return response()->json(['token' => $token]);
        }
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $user = Socialite::driver($provider)->user();

        return redirect()->away("http://localhost:8000?token=$user->token");

        \Log::info('user', [$user]);
        \Log::info($user->token);
    }
}
