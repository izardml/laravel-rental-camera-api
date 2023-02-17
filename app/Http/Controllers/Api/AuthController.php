<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated.'
        ], 401);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Email dan Password tidak boleh kosong.'
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Salah.',
            ], 404);
        }
        $token = $user->createToken('ApiToken')->plainTextToken;
        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ], 201);
    }
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout Successfully'
        ], 200);
    }
}
