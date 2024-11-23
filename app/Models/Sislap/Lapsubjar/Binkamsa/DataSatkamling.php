<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataSatkamling extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'kesatuan',
        'jml_poskamling',
        'aktif',
        'pasif',
        'ketua_pelaksana',
        'pelaksana',
        'jml_pecalang',
        'jml_pokdarkamtibmas',
        'jml_siswa',
        'jml_mahasiswa',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
