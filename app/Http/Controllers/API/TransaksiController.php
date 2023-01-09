<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceApi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{

    public function index(Request $request )
    {
        $transaksi = Transaksi::with('user', 'barang')->get()->first();
        return new ResourceApi(true, 'Data Transaksi ', $transaksi);
    }

    public function getUser($id)
    {
        $user = User::with('transaksi')->get()->where('id', $id);
        return new ResourceApi(true, 'Data Transaksi ', $user);
    }

    public function bayar(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'barang_id'=> 'required',
            'bayar' => 'required',
        ]);
        $pembayaran = new Transaksi();
        $pembayaran->user_id   = $request->user_id;
        $pembayaran->barang_id = $request->barang_id;
        $pembayaran->bayar     = $request->bayar;
        $pembayaran->save();
        return response()->json([
            'message' => 'Data pembayaran berhasil',
            'data'    =>$pembayaran
        ], 200);
    }
}
