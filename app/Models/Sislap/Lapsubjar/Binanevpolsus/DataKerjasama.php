<?php

namespace App\Models\Sislap\Lapsubjar\Binanevpolsus;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataKerjasama extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'kementerian_lembaga',
        'nota_kesepahaman',
        'perjanjian_kerjasama',
        'pedoman_kerja',
        'standar_operasional',
        'no_tgl',
        'masa_berlaku',
        'tentang_judul',
        'ruang_lingkup',
        'keterangan',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
