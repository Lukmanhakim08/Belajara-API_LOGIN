<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (request()->isMethod('post')) {
            return [
                'nama_barang' => 'required|string|max:258',
                'harga_barang' => 'required|numeric',
                'stok_barang' => 'required|numeric',
                'foto_barang' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        } else {
            return [
                'nama_barang' => 'required|string|max:258',
                'harga_barang' => 'required|numeric',
                'stok_barang' => 'required|numeric',
                'foto_barang' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }
        
    }

    public function messages()
    {
        if (request()->isMethod('post')) {
            return [
                'nama_barang.required' => 'Nama barang harus di isi',
                'harga_barang.required' => 'Harga barang harus angka',
                'stok_barang.required' => 'Stok barang harus angka',
                'foto_barang.required' => 'Foto barang sesuai dengan format',
            ];
        } else {
            return [
                'nama_barang.required' => 'Nama barang harus di isi',
                'harga_barang.required' => 'Harga barang harus angka',
                'stok_barang.required' => 'Stok barang harus angka',
            ];
        }
        
    }
}
