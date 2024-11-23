<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapharPelatihanFaba extends Model
{
    use SislapModelTrait;
    protected $fillable = [
        'polda',
        'lokasi_pelatihan',
        'nama_trainer',
        'jumlah_peserta',
        'kode_satuan',
        'user_id'
     ];

     protected $guarded  = ['id'];
     protected $appends  = ['need_approve'];
}
