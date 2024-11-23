<?php

namespace App\Models\Sislap\Lapsubjar\Bhabin;

use App\Models\Sislap\ApprovalLaporan;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class RekapPenggelaran extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'tgl_input_data',
        'polres',
        'jumlah_desa',
        'jumlah_kelurahan',
        'jumlah_bhabin',
        'bina1_desa',
        'bina2_desa',
        'bina3_desa',
        'bina4_desa',
        'desa_kel_binaan',
        'desa_kel_sentuhan',
        'desa_kel_pantauan',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
