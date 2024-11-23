<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanSatpam extends Model
{
    protected $table = 'laporan_satpam';
    protected $appends = [
        'jenis_laporan', 'alamat_satpam'
    ];

    public function satpam()
    {
        return $this->belongsTo(Satpam::class);
    }

    public function getJenisLaporanAttribute()
    {
        if ($this->form_type == LaporanInformasiSatpam::class){
            return 'Laporan Informasi';
        }
        if ($this->form_type == LaporanKejadianSatpam::class){
            return 'Laporan Kejadian';
        }
    }

    public function getAlamatSatpamAttribute()
    {
        return "$this->provinsi, $this->kabupaten, $this->kecamatan, $this->desa";
    }
}
