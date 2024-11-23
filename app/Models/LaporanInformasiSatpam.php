<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LaporanInformasiSatpam extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function satpam()
    {
        return $this->belongsTo(Satpam::class);
    }

    public function getLokasiAttribute()
    {
        return Str::title($this->provinsi . ', ' . $this->kabupaten . ', ' . $this->kecamatan . ', ' . $this->desa);
    }
}
