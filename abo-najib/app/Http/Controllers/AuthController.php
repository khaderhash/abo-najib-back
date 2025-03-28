<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $credentials = $request->only('email', 'password');
            $token = Auth::attempt($credentials); // استخدم attempt مباشرة

            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid email or password',
                ], 401);
            }

            $user = Auth::user();
            $customToken = JWTAuth::claims(['exp' => now()->addDays(7)->timestamp])->fromUser($user);

            return $this->respondWithToken($token, $user);
        } catch (ValidationException $e) {
            return $this->respondValidationError($e);
        }
    }



    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'salary' => 0,
            ]);

            $token = JWTAuth::fromUser($user);

            return $this->respondWithToken($token, $user, 'User created successfully');
        } catch (ValidationException $e) {
            return $this->respondValidationError($e);
        }
    }


    public function logout()
    {

        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }


    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh(), Auth::user());
    }


    protected function respondWithToken($token, $user = null, $message = 'Login successful')
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'user' => $user ?? Auth::user(),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * إرجاع استجابة خطأ في التحقق
     */
    protected function respondValidationError(ValidationException $e)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    }



    public function sendVerificationCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $code = rand(100000, 999999);
        $user->verification_code = $code;
        $user->save();

        Mail::to($user->email)->send(new VerificationCodeMail($code));

        return response()->json(['message' => 'Verification code sent']);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required|numeric'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->verification_code === $request->verification_code) {
            $user->verification_code = null;
            $user->save();
            return response()->json(['message' => 'Verification successful']);
        }

        return response()->json(['message' => 'Invalid verification code'], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required|numeric',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->verification_code !== $request->verification_code) {
            return response()->json(['message' => 'Invalid verification code'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->verification_code = null;
        $user->save();

        return response()->json(['message' => 'Password reset successful']);
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }
}
