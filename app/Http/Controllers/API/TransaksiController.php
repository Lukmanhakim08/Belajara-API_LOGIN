<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceApi;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        // $transaksi = Transaksi::all();
        $transaksi = Transaksi::with('barang', 'user')->get();
        return new ResourceApi(true, 'Data Transaksi ', $transaksi);
    }

    public function getUser($id)
    {
        $user = User::with('transaksi')->where('id', $id)->first();
        return new ResourceApi(true, 'Data Transaksi ', $user);
    }
}
