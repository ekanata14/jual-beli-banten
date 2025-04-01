<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{ 
    protected $table = 'tabel_transaksi';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_penjual',
        'nama_produk',
        'deskripsi_produk',
        'harga',
        'stok',
        'kategori',
        'foto',
        'berat',
    ];
}
