<?php

namespace App\Models\Sislap\Lapsubjar\Bagrenmin;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class SerapanAnggaran extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'kode',
        'program',
        'bulan',
        'pagu',
        'realisasi',
        'presentase',
        'sisa',
        'pnbp_pagu',
        'pnbp_realisasi',
        'pnbp_presentase',
        'pnbp_sisa',
        'hambatan',
        'user_id',
        'kode_satuan'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
