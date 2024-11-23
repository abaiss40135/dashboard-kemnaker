<?php

namespace App\Models\Sislap\Nonlapbul\Laporan3t;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class LapharTracing extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'nama_polres',
        'jumlah_pasien',
        'tracing_pasien_sudah_sembuh',
        'tracing_pasien_sudah_md',
        'tracing_pasien_tanpa_alamat',
        'tracing_pasien_domisi_luar_daerah',
        'tracing_pasien_isoman',
        'tracing_pasien_isoter',
        'tracing_pasien_rawat_inap',
        'jumlah_kontak_erat',
        'tracing_kontak_erat_sehat',
        'tracing_kontak_erat_isoman',
        'tracing_kontak_erat_isoter',
        'tracing_kontak_erat_dirawat',
        'tracing_kontak_erat_tanpa_alamat',
        'tracing_kontak_erat_domisili_luar_daerah',
        'dll',
        'keterangan',
        'kode_satuan',
        'user_id'
    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
