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
        'id_order', // Hilang
        'id_kurir',
        'no_resi',
        'nama_penerima',
        'alamat_penerima',
        'latitude_penerima',
        'longitude_penerima',
        'kode_pos_penerima',
        'telp_penerima',
        'id_penjual',
        'alamat_penjual',
        'latitude_penjual',
        'longitude_penjual',
        'kode_pos_penjual',
        'status_pengiriman',
        'waktu_pengiriman',
        'biaya_pengiriman',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_pengiriman', 'id');
    }

    public function kurir()
    {
        return $this->belongsTo(Kurir::class, 'id_kurir', 'id');
    }
}
