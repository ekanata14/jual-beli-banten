<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'tabel_transaksi';

    protected $fillable = [
        'id_user',
        'total_harga',
        'status',
        'metode_pembayaran',
        'tanggal_transaksi',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function MetodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran', 'metode_pembayaran');
    }
    public function Pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'id_transaksi', 'id');
    }
}
