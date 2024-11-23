<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Deteksi_dini extends Model
{
    protected $guarded = [];
    protected $table = "deteksi_dinis";

    protected $appends = [];

    public function keywords()
    {
        return $this->morphToMany(Keyword::class, 'keywordable')->withTimestamps();
    }

    public function bhabin()
    {
        return $this->belongsTo(Bhabin::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function personel()
    {
        return $this->hasOneThrough(Personel::class, User::class, 'id', 'user_id', 'user_id');
    }

    public function laporan_informasi()
    {
        return $this->morphOne(LaporanInformasi::class, 'form');
    }

    public function lokasi_tugas()
    {
        return $this->hasOneThrough(LokasiPenugasan::class, User::class, 'id', 'user_id', 'user_id')
            ->orderByDesc('updated_at');
    }

    /*public function getAlamatAttribute()
    {
        $alamat = $this->detail_alamat . ' ' . $this->rt . '/' . $this->rw . ', Desa ' . $this->desa . ' Kec. ' . $this->kecamatan . ' ' . $this->kabupaten . ' ' . $this->provinsi;
        return Str::title($alamat);
    }*/
}
