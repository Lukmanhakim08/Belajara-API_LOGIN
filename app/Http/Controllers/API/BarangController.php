<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceApi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BarangController extends Controller
{    
    public function index()
    {
        $barang = Barang::all();
        return new ResourceApi(true, 'Data berhasil di simpan', $barang);
    }
    
    public function foto($folder, $data)
    {
        $path = public_path("../storage/app/public/" . $folder . "/") . $data;
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = response()->make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }


    public function store(Request $request)
    {
        $data = new Barang();
        $request->validate([
            'nama_barang' => 'required',
            'harga_barang'=> 'required|numeric',
            'stok_barang' => 'required|numeric',
            'deskripsi'   => 'required',
        ]);

        // $filename="";
        // if($request->hasFile('foto_barang')){
        //     $filename=$request->file('foto_barang')->store('barang','public');
        // }else{
        //     $filename=null;
        // }

        $data->nama_barang  = $request->nama_barang;
        $data->harga_barang = $request->harga_barang;
        $data->stok_barang  = $request->stok_barang;
        $data->deskripsi    = $request->deskripsi;
        $result = $data->save();
        if ($result) {
            return response()->json([
                'message' => 'Data barang berhasil di tambahkan',
            ], 200);
            // return new ResourceApi(true, 'Data berhasil di simpan', $data);
        } else {
            return response()->json($request->errors(), 422);
        }
    }

    public function show($id)
    {
        $barangs = Barang::find($id);
        if ($barangs) {
            return new ResourceApi(true, 'Data ditemukan', $barangs);
        } else{
            return response()->json([
                'message' => 'Data tidak ada'
            ], 422);
        }
    }

    public function destroy($id)
    {
        $barangs = Barang::find($id);
        if ($barangs) {
            $barangs->delete();
            return new ResourceApi(true, 'Data berhasil di hapus', '');
        } else {
            return response()->json([
                'message' => 'Data not found'
            ]);
        }
    }
}