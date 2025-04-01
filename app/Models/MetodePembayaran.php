<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{ 
    protected $primaryKey = 'id_metode';

    protected $fillable = [
        'id_metode',
        'nama_metode',
        'tipe',
        'kode',
        'logo'
    ]; 
}
