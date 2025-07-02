<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetodePembayaran extends Model
{ 
    use SoftDeletes;
    protected $table = 'tabel_metode_pembayaran';

    protected $fillable = [
        'id_metode',
        'nama_metode',
        'tipe',
        'kode',
        'logo'
    ]; 
}
