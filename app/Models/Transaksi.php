<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{ 
    protected $table = 'tabel_transaksi';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_pelanggan',
        'total_harga',
        'status',
        'metode_pembayaran',
        'tanggal_transaksi',
    ];

    public function Pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
    public function MetodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran', 'metode_pembayaran');
    }
    public function Pengiriman(){
        return $this->hasOne(Pengiriman::class, 'id_transaksi', 'id_transaksi');
    }
}
