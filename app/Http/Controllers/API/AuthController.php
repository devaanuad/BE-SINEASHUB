<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // contoh respon

    /* return response()->json([
        'status' => 'success',
        'message' => 'Berhasil Login',
        'data' => data yang di kirim,
    ]); */

    public function Login(LoginRequest $request)
    {
        $credentials['role'] = 'user';
        $credentials['google_id'] = null;

        $user = User::where('email', $request->email)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Akun tidak terdaftar','status' => 'error'], 401);
        }

        $token = $user->createToken('LoginToken', ['auth'])->plainTextToken;

        return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Login',
                'data' => $user,
                'tokenLogin' => $token
            ]);
    }
    public function Register(RegisterRequest $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'password' => \Hash::make($request->password),
                'role' => 'user',
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Register',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function redirectToProvider()
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json(['url' => $url], 200);
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            // dd($user);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'error_message' => $e->getMessage()//'tidak dapat mendapatkan data user'
            ], 500);
        }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            // log them in
            $token = $existingUser->createToken('LoginToken', ['auth'])->plainTextToken;
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->save();
	        $token = $existingUser->createToken('LoginToken', ['auth'])->plainTextToken;
            auth()->login($newUser, true);
        }

        return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Login',
                'data' => $user,
                'tokenLogin' => $token
            ]);
    }

    public function Logout()
    {
        try{
            // request()->user()->currentAccessToken()->delete();
            $user = request()->user();
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Logout',
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = $request->user();
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'no_hp' => $request->no_hp,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'data tidak lengkap',
            ],400);
        }
        // $user->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Update',
        ]);
    }
    public function change_password() {
        try {
            $user = $request->user();
            $user->update([
                'password' => \Hash::make($request->password),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Update',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'terjadi kesalahan saat merubah password',
            ],500);
        }
    }
}
