<?php

namespace App\Models\Sislap\Lapsubjar\Bintibsos;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class SakaBhayangkara extends Model
{
    use SislapModelTrait;

    protected $fillable = ['kesatuan', 'uraian', 'sasaran', 'hasil', 'keterangan', 'user_id', 'kode_satuan'];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
