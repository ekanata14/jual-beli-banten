<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjual extends Model
{ 
    use SoftDeletes;
    protected $table = "tabel_penjual";
    protected $guard = 'penjual';

    protected $fillable = [
        'id_user',
        'alamat_penjual',
        'kode_pos',
        'no_telp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
