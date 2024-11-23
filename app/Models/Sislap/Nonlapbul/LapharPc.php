<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class LapharPc extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'satker',
        'perbelanjaan',
        'perkantoran',
        'pemukiman',
        'kawasan',
        'transportasi_publik',
        'tempat_wisata',
        'komunitas_hobi',
        'jumlah_komunitas',
        'kode_satuan',
        'user_id'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
