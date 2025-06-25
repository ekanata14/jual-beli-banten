<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = "tabel_keranjang";

    protected $fillable = [
        'id_produk',
        'id_pelanggan',
        'jumlah'
    ];
}