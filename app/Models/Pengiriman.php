<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengiriman extends Model
{
    use SoftDeletes;
    protected $table = "tabel_pengiriman";

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

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id');
    }
}
