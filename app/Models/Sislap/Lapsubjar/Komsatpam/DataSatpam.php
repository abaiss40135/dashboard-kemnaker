<?php

namespace App\Models\Sislap\Lapsubjar\Komsatpam;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataSatpam extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'polda',
        'diklat_gp',
        'diklat_gm',
        'diklat_gu',
        'bersertifikasi_gp',
        'bersertifikasi_gm',
        'bersertifikasi_gu',
        'belum_bersertifikasi_gm',
        'belum_bersertifikasi_gp',
        'belum_bersertifikasi_gu',
        'keterangan',
        'user_id',
        'kode_satuan'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
