<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class LapharKarhutla extends Model
{
    use SislapModelTrait;

    protected $fillable = [
       'polres',
       'himbauan',
       'fgd',
       'maklumat_kapolda',
       'kode_satuan',
       'user_id'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
