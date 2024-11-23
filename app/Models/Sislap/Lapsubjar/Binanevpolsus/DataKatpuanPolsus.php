<?php

namespace App\Models\Sislap\Lapsubjar\Binanevpolsus;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataKatpuanPolsus extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'polda',
        'instansi',
        'tempat',
        'katpuan',
        'pria',
        'wanita',
        'jumlah',
        'tgl_buka',
        'tgl_tutup',
        'lama_hari',
        'keterangan',
        'kode_satuan',
        'user_id'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
