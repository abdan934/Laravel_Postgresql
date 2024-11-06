<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Mahasiswa extends Model
{
    use HasFactory;

    protected $table='tb_mahasiswa';
    protected $primaryKey='id_mhs';

    protected $fillable = [
        'id_mhs',
        'npm',
        'id_prodi',
        'id_jurusan',
        'name_mhs',
        'email_mhs',
        'no_hp',
        'jk_mhs',
        'tempat_tgl_lahir_mhs',
        'alamat_mhs',
        'status_mhs',
        'tahun_masuk',
        'created_at',
        'updated_at',
    ];

        public function prodi()
    {
        return $this->belongsTo(M_Prodi::class, 'id_prodi', 'id_prodi');
    }
}
