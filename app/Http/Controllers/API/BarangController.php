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
        return response()->json($barang);

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
            'foto_barang' => 'required|max:1024',
        ]);

        $filename="";
        if($request->hasFile('foto_barang')){
            $filename=$request->file('foto_barang')->store('barang','public');
        }else{
            $filename=null;
        }

        $data->nama_barang = $request->nama_barang;
        $data->harga_barang = $request->harga_barang;
        $data->stok_barang = $request->stok_barang;
        $data->foto_barang = $filename;
        $result = $data->save();
        if ($result) {
            return new ResourceApi(true, 'Data berhasil di simpan', $data);
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




    
// public function create(Request $request)
// {
//     $barang = new Barang();
//     $request->validate([
//         'nama_barang' => 'required',
//         'harga_barang'=> 'required|numeric',
//         'stok_barang' => 'required|numeric',
//         'foto_barang' => 'required|max:1024',
//     ]);

//     $filename = "";
//     if ($request->hasFile('foto_barang')) {
//         $filename = $request->file('foto_barang')->store('barang','public');
//     }else {
//         $filename=null;
//     }

//     $barang->nama_barang  = $request->nama_barang;
//     $barang->harga_barang = $request->harga_barang;
//     $barang->stok_barang  = $request->stok_barang;
//     $barang->foto_barang  = $filename;
//     $simpan = $barang->save();
//     if ($simpan) {
//         return new ResourceApi(true, 'Data berhasil di tambah', $barang);
//     } else {
//         return response()->json([
//             'message' => 'Data tidak ada'
//         ], 422);
//     }
// }

// public function edit($id)
// {
//     $barangs = Barang::findOrFail($id);
//     return response()->json($barangs);
//     if ($barangs) {
//         return new ResourceApi(true, 'Data ditemukan', $barangs);
//     } else{
//         return response()->json([
//             'message' => 'Data tidak ada'
//         ], 422);
//     }
// }

// public function update(Request $request, $id)
// {
//     $data = Barang::findOrFail($id);
//     $filelocation = public_path("storage\\".$data->foto_barang);
//     $filename = "";
//     if ($request->hasFile('new_foto_barang')) {
//         if(File::exists($filelocation)){
//             File::delete($filelocation);
//         }
//         $filename = $request->file('new_foto_barang')->store('barang','public');
//     }else {
//         $filename = $request->foto_barang;
//     }
//     $data->nama_barang = $request->nama_barang;
//     $data->harga_barang = $request->harga_barang;
//     $data->stok_barang = $request->stok_barang;
//     $data->foto_barang = $filename;
//     $simpan = $data->save();
//     if ($simpan) {
//         return new ResourceApi(true, 'Data berhasil di update', $data);
//     } else {
//         return response()->json($request->errors(), 422);
//     }
// }

