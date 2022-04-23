<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Sanctum\PersonalAccessToken;

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

        $token = $user->createToken('LoginToken',['auth'])->plainTextToken;

        return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Login',
                'data' => $user,
                'tokenLogin' => $token
            ]);
    }
    public function Register(Request $request)
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
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json(
            [
                'url' => $url
            ],
            200
        );
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            // dd($user);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal Login',
                'status' => 'Error',
                'error_message' => $e
            ],500);
        }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            // log them in
            $token = $existingUser->createToken('LoginToken',['auth'])->plainTextToken;
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

    public function Logout()
    {
        if (method_exists(request()->user()->currentAccessToken(), 'delete')){
            request()->user()->currentAccessToken()->delete();
        }
        $token_id = \Str::before(request()->bearerToken(),'|');
        $token = \Auth::user()->tokens()->where('id',$token_id)->delete();
        $logout = auth()->guard('web')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Logout',
            'token_id' => $token_id,
            'status_hapus' => $token,'logout' => $logout
        ]);
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
}
