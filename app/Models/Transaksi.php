<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;
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

    public function Orders()
    {
        return $this->hasMany(Order::class, 'id_transaksi', 'id');
    }
}
