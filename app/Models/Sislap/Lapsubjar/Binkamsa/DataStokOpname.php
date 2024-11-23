<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataStokOpname extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'bulan',
        'kta_gp_guna',
        'kta_gp_rusak',
        'kta_gp_jumlah',
        'kta_gp_sisa',
        'kta_gp_no_blangko',
        'kta_gm_guna',
        'kta_gm_rusak',
        'kta_gm_jumlah',
        'kta_gm_sisa',
        'kta_gm_no_blangko',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
