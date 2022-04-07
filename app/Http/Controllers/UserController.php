<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //authenticate user with laravel sanctum
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email:dns',
            'password' => 'required|string',
            'remember_me' => 'boolean'// buat remember me nanti ditambahin lagi
        ]);
    
        $credentials = request(['email', 'password']);
        $credentials['role'] = 'user';
        $credentials['google_id'] = null;

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        return response()->json([
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user,
            'message' => 'Successfully logged in'
        ]);
    }
}
