<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataIjazahSatpam extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'bulan',
        'ijazah_gp_guna',
        'ijazah_gp_rusak',
        'ijazah_gp_jumlah',
        'ijazah_gp_sisa',
        'ijazah_gp_no_blangko',
        'ijazah_gm_guna',
        'ijazah_gm_rusak',
        'ijazah_gm_jumlah',
        'ijazah_gm_sisa',
        'ijazah_gm_no_blangko',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
