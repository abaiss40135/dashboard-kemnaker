<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKejadianSatpam extends Model
{
    protected $guarded = ['id'];

    protected $appends = [
        'url_bukti'
    ];

    public function satpam(){
        return $this->belongsTo(Satpam::class , 'satpam_id');
    }

    public function saksiLaporan(){
        return $this->hasMany(SaksiLaporanSatpam::class);
    }

    public function getUrlBuktiAttribute() {
        return config('filesystems.storage_url') . str_replace('//', '/', $this->bukti);
    }
}
