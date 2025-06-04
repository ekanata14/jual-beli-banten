<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = "tabel_admin";
    protected $guard = 'admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    public function penjual()
    {
        return $this->hasOne(Penjual::class, 'id_admin', 'id_admin');
    }
}
