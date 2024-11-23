<?php

namespace App\Models\Laporan\ProgramPemerintah;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PemungutanSuaraCapres2024 extends Model
{
    protected $fillable = [
        'user_id',
        'suara_capres_1',
        'suara_capres_2',
        'suara_capres_3',
        'suara_tidak_sah',
        'provinsi_kode',
        'kabupaten_kode',
        'kecamatan_kode',
        'kelurahan_kode',
        'uraian_hasil_suara'
    ];

    protected $appends = [
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProvinsiAttribute()
    {
        return $this->provinsi()->first()?->name;
    }

    public function getKabupatenAttribute()
    {
        return ucwords(strtolower($this->kabupaten()->first()?->name));
    }

    public function getKecamatanAttribute()
    {
        return 'Kecamatan ' . ucwords(strtolower($this->kecamatan()->first()?->name));
    }

    public function getKelurahanAttribute()
    {
        return $this->kelurahan()->first()?->name;
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_kode', 'code');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kota::class, 'kabupaten_kode', 'code');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_kode', 'code');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Desa::class, 'kelurahan_kode', 'code');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i', strtotime($value));
    }
}
