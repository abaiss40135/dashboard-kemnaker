<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class PagelaranSatpam extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'jenis_perusahaan',
        'pria',
        'wanita',
        'jumlah',
        'gada_pratama',
        'gada_madya',
        'gada_utama',
        'belum',
        'outsourcing',
        'organik',
        'keterangan',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
