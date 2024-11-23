<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataBujp extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'nama_perusahaan',
        'konsultasi_aktif',
        'konsultasi_tidak_aktif',
        'penerapan_aktif',
        'penerapan_tidak_aktif',
        'pelatihan_aktif',
        'pelatihan_tidak_aktif',
        'penyediaan_aktif',
        'penyediaan_tidak_aktif',
        'jasa_aktif',
        'jasa_tidak_aktif',
        'kawal_aktif',
        'kawal_tidak_aktif',
        'perluasan',
        'total',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
