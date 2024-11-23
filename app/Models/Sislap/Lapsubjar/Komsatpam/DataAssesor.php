<?php

namespace App\Models\Sislap\Lapsubjar\Komsatpam;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataAssesor extends Model
{
    use SislapModelTrait;
    protected $fillable = [
        'nama',
        'polri',
        'non_polri',
        'no_reg_assesor',
        'gu',
        'gm',
        'gp',
        'jml',
        'status',
        'keterangan',
        'user_id',
        'kode_satuan'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
