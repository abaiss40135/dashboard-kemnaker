<?php

namespace App\Models\Sislap\Lapsubjar\Binanevpolsus;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataGiatKorwas extends Model
{
    use SislapModelTrait;
    protected $fillable = [
        'instansi',
        'waktu',
        'tempat',
        'kegiatan',
        'keterangan',
        'kode_satuan',
        'user_id'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
