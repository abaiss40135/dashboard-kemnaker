<?php

namespace App\Models\Sislap\Lapbul\Pembinaan;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class RealisasiAnggaran extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'program_kegiatan', 'bulan', 'pagu_awal', 'pagu_revisi', 'realisasi_rupiah',
        'realisasi_persen','sisa_rupiah', 'sisa_persen', 'user_id', 'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
