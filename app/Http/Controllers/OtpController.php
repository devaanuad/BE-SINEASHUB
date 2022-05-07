<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class OtpController extends Controller
{
    public function sendOtp(Request $req)
    {
        try {
            $user = User::where('email', $req->email)->first();
            if ($user) {
                kirimOtp();
                return response()->json([
                    'status' => 'success',
                    'message' => 'otp berhasil dikirim ke email'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'user dengan email yang dimasukan tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyOtp(Request $req)
    {
        $iOtp = $req->otp;
        $otp = \Cookie::get('otp');

        try {
            if (\Hash::check($iOtp,$otp)) {
                //pindah ke form ganti password
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
