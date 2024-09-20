<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * userRegistration
     */
    function userRegistration(Request $request) {
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
             ]);
     
             return response()->json([
                 'status' => 'success',
                 'message' => 'Your account is created successfully',
             ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong, please try again.',
                // 'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * userLogin
     */
    function userLogin(Request $request) {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->count();
        if($count == 1) {
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'token' => $token,
            ]);
        }else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized',
            ]);
        }
    }

    /**
     * sendOTP
     */
    function sendOTP(Request $request) {
        $email = $request->input('email');
        $otp = rand(1000,9999);
        $count = User::where('email', '=', $email)->count();

        if($count == 1) {
            // send OTP to the email address
            Mail::to($email)->send(new OTPMail($otp));

            // insert/update the otp to the database
            User::where('email','=',$email)->update(['otp'=>$otp]);

            return response()->json([
                'status' => 'Success',
                'message' => 'A verification code has been sent to your email address',
            ]);
        }else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized',
            ]);
        }
    }

    /**
     * OTP Verification
     */
    function verifyOTP(Request $request) {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();

        if($count == 1) {
            // make the OTP 0 as it was at the time of registration
            User::where('email', '=', $email)->update(['otp' => '0']);

            // token for resetting the password
            $token = JWTToken::Token4Reset($request->input('email'));
            return response()->json([
                'status' => 'Success',
                'message' => 'The OTP is verified successfully',
                'token' => $token
            ]);

        }else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized',
            ]);
        }
    }
    
    /**
     * Reset Password
     */
    function resetPassword(Request $request) {
        try {
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'Success',
                'message' => 'Your password has been reset successfully'
            ]);
        } catch(Exception) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Something went wrong, please try again.'
            ]);
        }
    }
}