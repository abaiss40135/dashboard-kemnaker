<?php

namespace App\Models\Sislap\Lapsubjar\Binanevpolsus;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataKejadian extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'kementerian',
        'tindak_pidana',
        'kronologi',
        'tindak_lanjut',
        'keterangan',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
