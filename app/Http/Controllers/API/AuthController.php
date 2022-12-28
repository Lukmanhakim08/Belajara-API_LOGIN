<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_user'       => 'required',
            'jenis_kelamin'   => 'required',
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
            'data'    => $success
        ]);
    }


    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['nama_user'] = $auth->nama_user;
            return response()->json([
                'success' => true,
                'message' => 'Login sukses',
                'data'    => $success
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan cek kembali email dan passwordnya',
                'data'    => null
            ]);
        }
    }
}
