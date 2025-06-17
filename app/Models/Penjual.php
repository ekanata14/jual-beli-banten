<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjual extends Model
{ 
    protected $table = "tabel_penjual";
    protected $guard = 'penjual';

    protected $fillable = [
        'id_user',
        'alamat_penjual',
        'no_telp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
