<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Kajur extends Model
{
    use HasFactory;

    protected $table='tb_kajur';

    protected $fillable = [
        'id_kajur',
        'nidn',
        'id_jurusan',
        'status_kajur',
    ];
}
