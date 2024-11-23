<?php

namespace App\Models\Sislap\Nonlapbul\PascaGempaCianjur;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JenisLaporanPascaGempa extends Pivot
{
    protected $table = 'sislap_jenis_laporan_pasca_gempa';
    protected $fillable = ['jenis_laporan', 'jenis_giat_pasca_gempa_id'];

    public function jenis_giat()
    {
        return $this->belongsTo(JenisGiatPascaGempa::class, 'id', 'jenis_giat_pasca_gempa_id');
    }
}
