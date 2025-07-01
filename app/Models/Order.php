<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "tabel_order";

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah',
        'subtotal',
    ];

    public function Transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }
    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }
}
