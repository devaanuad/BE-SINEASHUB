<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // contoh respon

   /* return response()->json([
        'status' => 'success',
        'message' => 'Berhasil Login',
        'data' => $user,
    ]); */

    public function Login(LoginRequest $request)
    {
        $credentials['role'] = 'user';
        $credentials['google_id'] = null;

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $token = $user->createToken('Token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Login',
            'data' => $user,
            'token' => $token
        ]);
    }

    public function register(Request $request)
    {
        # code...
    }

    public function logout()
    {
        # code...
    }
}
