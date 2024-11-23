<?php

namespace App\Models\Sislap\Nonlapbul\PascaGempaCianjur;

use Illuminate\Database\Eloquent\Model;

class JenisGiatPascaGempa extends Model
{
    protected $table = 'sislap_jenis_giat_pasca_gempa';
    protected $guarded = ['id'];

    public function jenis_laporans()
    {
        return $this->hasMany(JenisLaporanPascaGempa::class, 'jenis_giat_pasca_gempa_id', 'id');
    }
}
