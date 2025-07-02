<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ulasan extends Model
{
    use SoftDeletes;
    protected $table = 'tabel_ulasan';

    protected $primaryKey = 'id_ulasan';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'deskripsi_ulasan',
        'rating',
    ];
}
