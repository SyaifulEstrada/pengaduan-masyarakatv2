<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;

class Petugas extends Authenticable
{
    use HasFactory;

    protected $table = 'petugas';

    protected $primaryKey = 'id_petugas';
    
    protected $fillable = ['nama_petugas', 'username', 'password', 'telp', 'level'];

}
