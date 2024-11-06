<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Prodi extends Model
{
    use HasFactory;

    protected $table='tb_prodi';
    protected $primaryKey='id_prodi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_prodi',
        'id_jurusan',
        'name_prodi',
        'jenjang_prodi',
    ];
}