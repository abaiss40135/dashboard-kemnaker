<?php

namespace App\Models\Sislap\Lapbul\Operasional;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class KomunitasBinaan extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'komunitas_binaan',
        'jumlah_komunitas_binaan',
        'jumlah_anggota',
        'peran_polri',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
