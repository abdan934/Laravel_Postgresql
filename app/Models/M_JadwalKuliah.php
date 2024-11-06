<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_JadwalKuliah extends Model
{
    use HasFactory;

    protected $table='tb_file_jadwal';
    protected $primaryKey='id_file_jadwal';


    protected $fillable = [
        'id_jurusan',
        'name_file_jadwal_excel',
        'name_file_jadwal_pdf',
        'semester_file_jadwal',
        'tahun_file_jadwal',
        'created_at',
        'updated_at',
    ];
}