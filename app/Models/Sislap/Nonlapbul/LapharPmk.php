<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapharPmk extends Model
{
    use SislapModelTrait;
    protected $fillable = [
        'polres',
        'jml_hewan_terinfeksi',
        'harga_daging',
        'ketersediaan_daging',
        'kode_satuan',
        'user_id'
     ];

     protected $guarded  = ['id'];
     protected $appends  = ['need_approve'];
}
