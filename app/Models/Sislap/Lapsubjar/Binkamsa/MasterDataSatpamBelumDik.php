<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class MasterDataSatpamBelumDik extends Model
{
    use SislapModelTrait;

    protected $table = 'sislap_master_data_satpam_belum_dik';

    protected $fillable = [
        'nama',
        'perusahaan',
        'tanggal_lahir',
        'jenis_kelamin',
        'lama_bertugas',
        'dikum_terakhir',
        'user_id',
        'kode_satuan',
    ];

    protected $appends = ['need_approve'];
}
