<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Jurusan extends Model
{
    use HasFactory;

    protected $table='tb_jurusan';
    protected $primaryKey='id_jurusan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_jurusan',
        'name_jurusan',
    ];

    public function m_prodis()
    {
        return $this->hasMany(M_Prodi::class, 'id_jurusan', 'id_jurusan');
    }
    public function m_mhs()
    {
        return $this->hasMany(M_Mahasiswa::class, 'id_jurusan', 'id_jurusan');
    }
}
