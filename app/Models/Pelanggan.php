<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use Notifiable;
    protected $table = "tabel_pelanggan";

    protected $fillable = [
        'id_user',
        'alamat_pelanggan',
        'kode_pos',
        'no_telp',
    ];
}
