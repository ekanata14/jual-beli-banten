<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    protected $table = "tabel_pelanggan";

    protected $fillable = [
        'id_user',
        'alamat_pelanggan',
        'latitude',
        'longitude',
        'kode_pos',
        'no_telp',
    ];
}
