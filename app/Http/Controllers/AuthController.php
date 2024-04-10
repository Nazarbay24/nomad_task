<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->first();

        if( !password_verify($request->password, $user->password) ) {
            return response()->json(['message' => 'Неверный логин или пароль'], 400);
        }

        $token = $user->createToken($user->id);

        return response()->json([
            'message' => 'success',
            'data' => [
                'token' => $token->plainTextToken,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        if($request->user()->currentAccessToken()->delete()) {
            return response()->json([
                'message' => 'success',
            ]);
        }
        else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
