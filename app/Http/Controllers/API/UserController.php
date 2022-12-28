<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return new ResourceApi(true, 'Data users ', $users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_user'     => 'required',
            'jenis_kelamin' => 'required',
            'no_hp'         => 'required|numeric|unique:users,no_hp',
            'alamat'        => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else{
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $users = User::create($input);
            return new ResourceApi(true, 'Data berhasil di simpan', $users);
        }
    }

    public function show($id)
    {
        $users = User::find($id);
        if ($users) {
            return new ResourceApi(true, 'Data ditemukan', $users);
        } else{
            return response()->json([
                'message' => 'Data tidak ada'
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_user'     => 'required',
            'jenis_kelamin' => 'required',
            'no_hp'         => 'required|numeric|unique:users,no_hp',
            'alamat'        => 'required',
            'email'         => 'required|email|unique:users,email',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else{
            $users = User::find($id);
            if ($users) {
                $users->nama_user = $request->nama_user;
                $users->jenis_kelamin = $request->jenis_kelamin;
                $users->no_hp = $request->no_hp;
                $users->alamat = $request->alamat;
                $users->email = $request->email;
                $users->save();
                return new ResourceApi(true, 'Data berhasil di update', $users);
            } else {
                return response()->json([
                    'message' => 'Data not found'
                ]);
            } 
        }
    }

    public function destroy($id)
    {
        $users = User::find($id);
        if ($users) {
            $users->delete();
            return new ResourceApi(true, 'Data berhasil di hapus', '');
        } else {
            return response()->json([
                'message' => 'Data not found'
            ]);
        }
    }
}
