<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
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
            return response()->json([
                        'message' => 'Unauthorized'
                    ], 401);
        }

        $token = $user->createAuthToken('LoginToken', 1440)->plainTextToken;

        return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Login',
                'data' => $user,
                'tokenLogin' => $token
            ]);
    }
    public function Register(LoginRequest $request)
    {
        $userGoogle = Socialite::driver('google')->user();
        $findUserGoogle = User::where('google_id', $userGoogle->id)->first();
        if ($findUserGoogle) {
            $user = User::updateOrCreate(['google_id' => $userGoogle->id], [
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'user',
            ]);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'role' => 'user',
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Register',
        ]);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            // dd($user);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal Login',
                'status' => 'Error',
                'error_message' => $e
            ]);
        }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            // log them in
            $token = $existingUser->createAuthToken('LoginToken', 1440)->plainTextToken;
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->save();
            auth()->login($newUser, true);
        }

        return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Login',
                'data' => $user,
                'tokenLogin' => $token
            ]);
    }

    public function refreshToken()
    {
        $user = User::where('id', \Auth::id())->first();
        $token = $user->createAuthToken('refToken', 1440)->plainTextToken;
        return response()->json(['status' => 'ok', 'token' => $token]);
    }

    public function Logout()
    {
        request()->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Logout',
        ]);
    }

    public function update(Request $request)
    {
        $user = User::where('id', \Auth::id())->first();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'no_hp' => $request->no_hp,
        ]);
        // $user->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Update',
        ]);
    }
}
