<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (!empty($request->attributes->all()['sanctum']) && !empty($request->headers->get('bearer'))) {
            return response(['message' => 'Unauthorized'], 401);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $request->user();
        $user->tokens()->delete();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        Auth::login($user);

        return response()->json([
            'user' => $user,
            'token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function logout()
    {
        Auth::logout();
    }
}
