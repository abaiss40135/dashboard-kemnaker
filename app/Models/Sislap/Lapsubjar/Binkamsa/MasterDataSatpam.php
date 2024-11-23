<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class MasterDataSatpam extends Model
{
    use SislapModelTrait;

    protected $table = 'sislap_master_data_satpam';

    protected $fillable = [
        'no_reg',
        'nik',
        'nama',
        'tanggal_lahir',
        'alamat',
        'tinggi_berat_badan',
        'gol_darah',
        'rumus_sidik_jari',
        'handphone',
        'email',
        'dikum_terakhir',
        'npwp',
        'perusahaan',
        'jabatan',
        'alamat_kantor',
        'nomor_kantor',
        'email_perusahaan',
        'dik_terakhir_satpam',
        'tahun_lulus',
        'is_ex_tni_polri',
        'pangkat',
        'user_id',
        'kode_satuan',
    ];

    protected $appends = ['need_approve'];
}
