<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            $user = $user->load('shift', 'parkingGate');
            if ($user->shift == null || $user->parkingGate == null) {
                auth()->logout();
                return response()->json([
                    'message' => 'User belum di setting oleh admin.'
                ], 400);
            }


            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'data' => $user
            ], 200);
        }

        return response()->json([
            'message' => 'Login failed',
        ], 401);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load('shift', 'parkingGate');
        if ($user->shift == null || $user->parkingGate == null) {
            return response()->json([
                'message' => 'User belum di setting oleh admin.'
            ], 400);
        }
        return response()->json([
            'data' => $user,
            'message' => 'user fetch successfully'
        ], 200);
    }

    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }
}
