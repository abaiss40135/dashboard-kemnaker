<?php

namespace App\Models\Sislap\Lapsubjar\Bagrenmin;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class CapaianKinerja extends Model
{
    use SislapModelTrait;
    protected $fillable = [
        'sasaran',
        'indikator',
        'target',
        'realisasi',
        'kegiatan',
        'hasil',
        'hambatan',
        'solusi_hambatan',
        'keterangan',
        'triwulan',
        'tahun',
        'user_id',
        'kode_satuan'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
