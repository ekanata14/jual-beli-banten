<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = "tabel_kurir";
    protected $primaryKey = 'id_kurir';

    protected $fillable = [
        'kode_kurir',
        'nama_kurir',
        'kode_servis',
        'nama_servis',
        'rentan_durasi',
        'unit_durasi',
    ];
}
