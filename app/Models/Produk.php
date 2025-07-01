<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = "tabel_produk";

    protected $fillable = [
        'id_user',
        'nama_produk',
        'deskripsi_produk',
        'harga',
        'stok',
        'kategori',
        'foto',
        'berat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
