<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'nama_barang',
        'harga_barang',
        'stok_barang',
        'foto_barang',
    ];

    public function barang()
    {
        return $this->hasMany('App\Models\Barang', 'barang_id');
        // return $this->hasMany(Barang::class, 'barang_id');
    }
}
