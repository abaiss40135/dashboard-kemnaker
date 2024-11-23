<?php

namespace App\Models\PolisiRW;

use App\Models\Desa;
use App\Models\Personel;
use App\Models\Sipp\Satuan;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $guarded = ['id'];
    protected $table = 'laporan_polisi_rw';

    public function personel()
    {
        return $this->belongsTo(Personel::class, 'personel_id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function alat_kejahatan()
    {
        return $this->belongsTo(AlatKejahatan::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'village_code', 'code');
    }

    public function kegiatan()
    {
        return $this->belongsTo(KategoriKegiatan::class, 'kategori_kegiatan_id');
    }

    public function kerawanan()
    {
        return $this->belongsTo(KategoriKerawanan::class, 'kategori_kerawanan_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'kode_satuan', 'kode_satuan');
    }

    public function getWaktuAttribute($value)
    {
        return substr($value, 0, 5);
    }

    public function getFotoAttribute($value)
    {
        return json_decode($value);
    }
}
