<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'tabel_ulasan';

    protected $primaryKey = 'id_ulasan';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'deskripsi_ulasan',
        'rating',
    ];
}
