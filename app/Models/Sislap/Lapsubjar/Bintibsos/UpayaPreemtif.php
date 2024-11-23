<?php

namespace App\Models\Sislap\Lapsubjar\Bintibsos;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class UpayaPreemtif extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'kesatuan', 'bulan', 'masalah_sosial', 'dds', 'penyuluhan', 'sambang',
        'mobil_penling', 'sosialisasi', 'lain_lain', 'jumlah', 'keterangan',
        'user_id', 'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
