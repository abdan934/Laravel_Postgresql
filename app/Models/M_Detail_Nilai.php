<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Detail_Nilai extends Model
{
    use HasFactory;

    protected $table='tb_detail_nilai';
    protected $primaryKey='id_detail_nilai';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_detail_nilai',
        'id_nilai',
        'lain_detail',
        'lain_prosentase_detail',
        'uts_detail',
        'uts_prosentase_detail',
        'uas_detail',
        'uas_prosentase_detail',
        'created_at',
        'updated_at',
    ];

    public function nilai()
    {
        return $this->belongsTo(M_Nilai::class, 'id_nilai', 'id_nilai');
    }
}
