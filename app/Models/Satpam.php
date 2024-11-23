<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Satpam extends Model
{
    protected $guarded = [];
    protected $appends = ['foto_profile'];

    public function bujp() {
        return $this->belongsTo(Bujp::class)->withDefault([
            'nama_badan_usaha' => 'Non BUJP'
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporanKejadian(){
        return $this->hasMany(LaporanKejadianSatpam::class);
    }

    public function laporanInformasis() {
        return $this->hasMany(LaporanInformasiSatpam::class);
    }

    public function getLokasiAttribute()
    {
        return $this->tempat_tugas;
    }

    public function getFotoProfileAttribute() {
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->foto_kta);
    }
}
