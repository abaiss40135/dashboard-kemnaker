<?php

namespace App\Models\Sislap\Lapsubjar\Bintibsos;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class KegiatanSubditbintibsos extends Model
{
    use SislapModelTrait;

    protected $fillable = ['kesatuan', 'uraian_kegiatan', 'keterangan', 'user_id', 'kode_satuan'];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
