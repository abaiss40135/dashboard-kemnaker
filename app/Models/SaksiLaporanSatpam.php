<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaksiLaporanSatpam extends Model
{
    protected $guarded = ['id'];

    public function laporanKejadian(){
        return $this->belongsTo(LaporanKejadianSatpam::class , 'laporan_kejadian_id');
    }
}
