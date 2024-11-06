<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Nilai extends Model
{
    use HasFactory;

    protected $table='tb_nilai';
    protected $primaryKey='id_nilai';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_nilai',
        'kode_mengajar',
        'id_keterangan',
        'npm',
        'kelas_nilai',
        'tahun_ajar_awal_nilai',
        'tahun_ajar_akhir_nilai',
        'semester_nilai',
        'sks',
        'angka_nilai',
        // 'predikat_nilai',
        'created_at',
        'updated_at',
    ];

        public function detailNilai()
    {
        return $this->hasMany(M_DetailNilai::class, 'id_nilai', 'id_nilai');
    }
}
