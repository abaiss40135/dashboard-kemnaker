<?php

namespace App\Models\Laporan;

use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LaporanBhabinkamtibmas extends Model
{
    protected $table = 'laporan_bhabinkamtibmas';
    protected $appends = [
        'jenis_laporan'
    ];

    public function getJenisLaporanAttribute()
    {
        if ($this->form_type == Dds_warga::class){
            return 'DDS Warga';
        }
        if ($this->form_type == Deteksi_dini::class){
            return 'Deteksi Dini';
        }
    }
}
