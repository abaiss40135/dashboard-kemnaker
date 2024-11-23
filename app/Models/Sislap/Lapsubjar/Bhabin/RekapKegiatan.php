<?php

namespace App\Models\Sislap\Lapsubjar\Bhabin;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class RekapKegiatan extends Model
{
    use SislapModelTrait;

   protected $fillable = [
       'polres',
       'dds',
       'li',
       'sosial',
       'dana_perdata',
       'fisik',
       'non_fisik',
       'pendampingan_danadesa',
       'binluh_narkoba',
       'pengendalian_pemotonganruminansia',
       'user_id',
       'kode_satuan'
   ];
   protected $guarded  = ['id'];
   protected $appends  = ['need_approve'];
}
