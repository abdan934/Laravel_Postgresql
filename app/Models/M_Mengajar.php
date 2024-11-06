<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Mengajar extends Model
{
    use HasFactory;

    protected $table='tb_mengajar';
    protected $primaryKey='id_mengajar';

    protected $fillable = [
        'id_mengajar',
        'kode_mengajar',
        'kode_matkul',
        'nidn',
        'status_mengajar',
        'created_at',
        'updated_at',
    ];
}