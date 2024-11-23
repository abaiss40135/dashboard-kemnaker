<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class KasusSatpam extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'hari_tanggal_jam',
        'kasus',
        'tkp','uraian_kejadian',
        'keterangan',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
