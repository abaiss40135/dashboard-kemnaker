<?php

namespace App\Models\Sislap\Lapsubjar\Bhabin;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class RekapPenghargaan extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'polres',
        'kapolri',
        'kabaharkam',
        'kakorbinmas',
        'kapolda',
        'dirbinmas',
        'kapolres',
        'kapolsek',
        'instansi',
        'lain_lain',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
