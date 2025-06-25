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
}
