<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjual extends Model
{ 
    protected $table = "tabel_penjual";
    protected $primaryKey = 'id_penjual';

    protected $fillable = [
        'id_admin',
        'nama_penjual',
        'alamat_penjual',
        'no_telp',
    ];
}
