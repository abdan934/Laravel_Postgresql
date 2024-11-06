<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Dosen extends Model
{
    use HasFactory;

    protected $table='tb_dosen';
    protected $primaryKey='id_dosen';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id_dosen',
        'nidn',
        'nip',
        'id_prodi',
        'id_jurusan',
        'name_dosen',
        'email_dosen',
        'no_hp_dosen',
        'jk_dosen',
        'alamat_dosen',
        'status_dosen',
        'created_at',
        'updated_at',
    ];
}
