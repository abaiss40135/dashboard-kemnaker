<?php

namespace App\Models\Sislap\Lapsubjar\Bintibsos;

use App\Models\Sislap\ApprovalLaporan;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataJumlahAnggota extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'kesatuan',
        'jmlsaka_pa',
        'jmlsaka_pi',
        'kmdsaka_pa',
        'kmdsaka_pi',
        'kmlsaka_pa',
        'kmlsaka_pi',
        'jmlpamong_pa',
        'jmlpamong_pi',
        'kmdpamong_pa',
        'kmdpamong_pi',
        'kmlpamong_pa',
        'kmlpamong_pi',
        'keterangan',
        'user_id',
        'kode_satuan'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
