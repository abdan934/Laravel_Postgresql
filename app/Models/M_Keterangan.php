<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Keterangan extends Model
{
    use HasFactory;

    protected $table='tb_keterangan';

    protected $fillable = [
        'id_keterangan',
        'alpha',
        'izin',
        'sakit',
        'catatan',
        'created_at',
        'updated_at',
    ];
}