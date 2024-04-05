<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
class ApiController extends Controller
{
    //register (POST)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'User created successfully!',
            'status' => true,
            'Data' => $user,
        ]);
    }
    //login (POST)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $token = JWTAuth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        if (!$token) {
            return response()->json([
                'message' => 'Login failed!',
                'status' => false,
            ]);
        }
        return response()->json([
            'message' => 'Login successfully!',
            'status' => true,
            'token' => $token,
        ]);
    }

    //profile (GET)
    public function profile(Request $request)
    {
        $user = auth()->user();

        return response()->json([
            'message' => 'User profile!',
            'status' => true,
            'Data' => $user,
        ]);
    }
    //refreshToken
    public function refreshToken(Request $request)
    {
        $newToken = auth()->refresh();
        return response()->json([
            'message' => 'Refresh token successfully!',
            'status' => true,
            'token' => $newToken,
        ]);
    }

    //logout (POST)
    public function logout(Request $request)
    {
        auth()->logout();
        return response()->json([
            'message' => 'تم تسجيل الخروج',
            'status' => true,
        ]);
    }
}
