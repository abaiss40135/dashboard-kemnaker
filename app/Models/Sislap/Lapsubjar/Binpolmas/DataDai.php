<?php

namespace App\Models\Sislap\Lapsubjar\Binpolmas;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataDai extends Model
{
    use SislapModelTrait;
    protected $fillable = [
        'nama_dai',
        'perorangan_kelompok',
        'no_hp',
        'rt_rw',
        'desa_kel',
        'kecamatan',
        'kab_kota',
        'keterangan',
        'kode_satuan',
        'user_id'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
