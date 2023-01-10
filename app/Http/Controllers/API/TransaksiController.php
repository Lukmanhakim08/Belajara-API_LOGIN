<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceApi;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{

    public function index()
    {
        $transaksi = Transaksi::with('user', 'barang')->get();
        return new ResourceApi(true, 'Data Transaksi ', $transaksi);
    }

    public function getUser($id)
    {
        $transaksi = Transaksi::with('user','barang')->where('user_id', $id)->get();
        return new ResourceApi(true, 'Data Transaksi ', $transaksi);
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
