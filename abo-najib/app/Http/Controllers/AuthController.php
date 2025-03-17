<?php

namespace App\Http\Controllers;

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

            if (!$token = Auth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid email or password',
                ], 401);
            }

            return $this->respondWithToken($token);
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
}

// namespace App\Http\Controllers;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use App\Models\User;
// use Tymon\JWTAuth\Facades\JWTAuth;


// class AuthController extends Controller
// {

//     public function __construct()
//     {
//         // تعيين middleware لحماية جميع الدوال ما عدا login و register
//         $this->middleware('auth:api', ['except' => ['login', 'register']]);
//     }

//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => 'required|string|email',
//             'password' => 'required|string',
//         ]);
//         $credentials = $request->only('email', 'password');

//         $token = Auth::attempt($credentials);
//         if (!$token) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => 'Unauthorized',
//             ], 401);
//         }

//         $user = Auth::user();
//         return response()->json([
//                 'status' => 'success',
//                 'user' => $user,
//                 'authorisation' => [
//                     'token' => $token,
//                     'type' => 'bearer',
//                 ]
//             ]);

//     }

//     public function register(Request $request) {
//         try {
//             $request->validate([
//                 'name' => 'required|string|max:255',
//                 'email' => 'required|string|email|max:255|unique:users',
//                 'password' => 'required|string|min:6',
//             ]);

//             $user = User::create([
//                 'name' => $request->name,
//                 'email' => $request->email,
//                 'password' => Hash::make($request->password),
//                 'salary' => 0,
//             ]);

//             $token = JWTAuth::fromUser($user);

//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'User created successfully',
//                 'user' => $user,
//                 'authorisation' => [
//                     'token' => $token,
//                     'type' => 'bearer',
//                 ]
//             ]);
//         } catch (\Illuminate\Validation\ValidationException $e) {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => 'Validation failed',
//                 'errors' => $e->errors()
//             ], 422);
//         }
//     }

//     public function logout()
//     {
//         Auth::logout();
//         return response()->json([
//             'status' => 'success',
//             'message' => 'Successfully logged out',
//         ]);
//     }

//     public function refresh()
//     {
//         return response()->json([
//             'status' => 'success',
//             'user' => Auth::user(),
//             'authorisation' => [
//                 'token' => Auth::refresh(),
//                 'type' => 'bearer',
//             ]
//         ]);
//     }

// }
