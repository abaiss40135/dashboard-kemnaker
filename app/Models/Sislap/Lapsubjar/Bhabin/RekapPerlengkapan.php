<?php

namespace App\Models\Sislap\Lapsubjar\Bhabin;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class RekapPerlengkapan extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'tgl_input_data',
        'polres',
        'r2',
        'toa',
        'gigaphone',
        'rompi_jaket',
        'borgol',
        'kamera',
        'ht',
        'tongkat_polri',
        'hp',
        'lain_lain',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
