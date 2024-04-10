<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function myProfile()
    {
        $user = Auth::user();

        return response()->json([
            'message' => 'success',
            'data' => $user
        ]);
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = Auth::user();
        $user->fill($request->all());

        if ($user->save()) {
            return response()->json([
                'message' => 'success',
            ]);
        }
        return response()->json([
            'message' => 'error',
        ], 400);
    }
}
