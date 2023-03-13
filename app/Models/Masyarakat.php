<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;

class Masyarakat extends Authenticable
{
    use HasFactory;

    protected $table = 'masyarakat';

    protected $primaryKey = 'nik';
    
    protected $fillable = ['nik', 'nama', 'username', 'password', 'telp'];

}
