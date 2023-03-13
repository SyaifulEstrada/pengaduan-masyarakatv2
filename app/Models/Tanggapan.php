<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;

class Tanggapan extends Authenticable
{
    use HasFactory;

    protected $table = 'tanggapan';

    protected $primaryKey = 'id_tanggapan';

    protected $fillable = ['id_pengaduan', 'tgl_tanggapan', 'tanggapan', 'id_petugas'];

}
