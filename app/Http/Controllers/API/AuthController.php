<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_user'       => 'required',
            'jenis_kelamin'   => 'required',
            'level'           => 'required',
            'no_hp'           => 'required|numeric|unique:users,no_hp',
            'alamat'          => 'required',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required',
            'confirm_password'=> 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'succces' => false,
                'message' => 'Ada kesalahan',
                'data'    => $validator->errors()
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $users = User::create($input);
        $success['token'] = $users->createToken('auth_token')->plainTextToken;
        $success['nama_user'] = $users->nama_user;

        return response()->json([
            'success' => true,
            'message' => 'sukses register',
            'data'    => $users
        ]);
    }

    public function login(Request $request)
    {
        $users = User::where('email', $request->email)->first();
        if (!$users || !Hash::check($request->password, $users->password)) {
            return response()->json([
                'message' => 'Email dan password salah'
            ],401);
        }
        $token = $users->createToken('token-name')->plainTextToken;
        return response()->json([
            'message' => 'Login berhasil',
            'token'   => $token,
            'data'    => $users,
            
        ],200);
    }

    public function logout(Request $request)
    {
        $users = $request->user();
        $users->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout berhasil',
        ],200);
    }
}
