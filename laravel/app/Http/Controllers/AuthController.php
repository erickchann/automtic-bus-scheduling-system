<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        // Username or password do not match or empty
        $credentials = $request->only(['username', 'password']);
        if ($validator->fails() || !Auth::attempt($credentials)) {
            return response()->json(['message' => 'invalid login'], 401);
        }

        // To generate and get login token using username and password
        $user = Auth::user();
        $token = bcrypt($user->id);

        $user->update(['token' => $token]);

        return response()->json($token, 200);
    }

    public function logout(Request $request) 
    {
        $user = User::where('token', $request->bearerToken())->first();

        // Accesed without token / token not valid
        if (!$user) {
            return response()->json(['message' => 'unauthorized user'], 401);
        }

        $user->update(['token' => null]);

        return response()->json(['message' => 'logout success'], 200);
    }
}
