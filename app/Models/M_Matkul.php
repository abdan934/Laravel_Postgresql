<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Matkul extends Model
{
    use HasFactory;

    protected $table='tb_matkul';

    protected $fillable = [
        'id_matkul',
        'kode_matkul',
        'id_jurusan',
        'nama_matkul_ind',
        'nama_matkul_eng',
        'created_at',
        'updated_at',
    ];
}