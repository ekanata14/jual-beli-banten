<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $table = "tabel_order";

    protected $fillable = [
        'id_transaksi',
        'id_pengiriman', // ada, karena pengirima one to many terhadap ini -> nullable
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

    public function Pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'id_pengiriman', 'id');
    }
}
