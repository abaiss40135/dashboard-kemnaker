<?php

namespace App\Models\Sislap\Lapbul\Operasional;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataKerjasamaDitbinmas extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'satker',
        'mou',
        'isi',
        'masa_berlaku',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
