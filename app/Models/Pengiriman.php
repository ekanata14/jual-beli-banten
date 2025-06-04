<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = "tabel_pengiriman";
    protected $primaryKey = 'id_pengiriman';

    protected $fillable = [
        'id_transaksi',
        'id_order',
        'id_kurir',
        'no_resi',
        'nama_penerima',
        'alamat_penerima',
        'telp_penerima',
        'status_pengiriman',
        'waktu_pengiriman',
        'biaya_pengiriman',
    ];
}
