<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kurir extends Model
{
    use SoftDeletes;
    protected $table = "tabel_kurir";

    protected $fillable = [
        'kode_kurir',
        'nama_kurir',
        'kode_servis',
        'nama_servis',
        'rentan_durasi',
        'unit_durasi',
    ];
}
