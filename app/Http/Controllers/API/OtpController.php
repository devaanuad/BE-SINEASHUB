<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Sentinel;
use Reminder;
use Mail;

class OtpController extends Controller
{
    public function sendOtp(Request $req)
    {
        try {
            $user = User::where('email', $req->email)->first();
            if ($user) {
                $user = Sentinel::findById($user->id);
                $reminder = \Reminder::exist($user) ? : Reminder::create($user);

                $this->sendEmail($user, $reminder->code);
                //pindah ke form otp di front-end
                return response()->json([
                    'status' => 'success',
                    'message' => 'otp berhasil dikirim ke email'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'email tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    private function sendEmail($user, $code)
    {
        try{
            \Mail::send(
                'email/',
                ['user' => $user, 'code'=> $code],
                function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject("Hello $user->name Ubah Password Mu Dengan Kode Ini");
                }
            );

        }catch(\Exception $e){
            return response()->json([
                'status' =>  'error',
                'message' => $e->getMessage()
            ],500);
        }
    }
    public function verifyOtp(Request $req)
    {
        $iOtp = $req->otp;
        $otp = \Cookie::get('otp');

        try {
            if (\Hash::check($iOtp, $otp)) {
                //pindah ke form ganti password di front-end
                return response()->json([
                    'status' => 'success',
                    'message' => 'otp sama mantap'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'otp tidak sama'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
