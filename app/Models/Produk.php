<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;
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
