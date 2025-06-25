<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{ 
    protected $table = 'tabel_metode_pembayaran';

    protected $fillable = [
        'id_metode',
        'nama_metode',
        'tipe',
        'kode',
        'logo'
    ]; 
}
