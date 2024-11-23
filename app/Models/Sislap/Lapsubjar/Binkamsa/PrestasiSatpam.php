<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class PrestasiSatpam extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'kualifikasi',
        'kantor',
        'prestasi',
        'keterangan',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
