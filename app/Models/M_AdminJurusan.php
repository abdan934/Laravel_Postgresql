<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_AdminJurusan extends Model
{
    use HasFactory;

    protected $table='tb_admin_jurusan';


    protected $fillable = [
        'id_admin_jurusan',
        'nip',
        'id_prodi',
        'id_jurusan',
        'name_admin_jurusan',
        'email_admin_jurusan',
        'no_hp_admin_jurusan',
        'jk_admin_jurusan',
        'alamat_admin_jurusan',
        'status_admin_jurusan',
        'created_at',
        'updated_at',
    ];
}