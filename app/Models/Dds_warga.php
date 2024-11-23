<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Dds_warga extends Model
{
    use ModelTrait;

    protected $guarded = ['id'];

    protected $appends = [

    ];

    public function keywords()
    {
        return $this->morphToMany(Keyword::class, 'keywordable')->withTimestamps();
    }

    public function anggota_keluargas()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'dds_warga_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lokasi_tugas()
    {
        return $this->hasOneThrough(LokasiPenugasan::class, User::class,'id', 'user_id', 'user_id')
                    ->orderByDesc('updated_at');
    }

    public function personel()
    {
        return $this->hasOneThrough(Personel::class, User::class, 'id', 'user_id', 'user_id');
    }

    public function pendapat_warga()
    {
        return $this->hasMany(PendapatWarga::class, 'dds_warga_id', 'id');
    }

    public function getKeywordAttribute()
    {
        return $this->keywords()->get(['keyword'])->implode('keyword', ', ');
    }

    public function laporan_informasi()
    {
        return $this->morphOne(LaporanInformasi::class, 'form');
    }

    /*public function getAlamatAttribute()
    {
        $alamat = $this->detail_alamat_kepala_keluarga . ' ' . $this->rt_kepala_keluarga . '/' . $this->rw_kepala_keluarga . ', Desa ' . $this->desa_kepala_keluarga . ' Kec. ' . $this->kecamatan_kepala_keluarga . ' ' . $this->kabupaten_kepala_keluarga . ' ' . $this->provinsi_kepala_keluarga;
        return Str::title($alamat);
    }*/

}
