<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LokasiPenugasan extends Model
{
    protected $guarded = ['id'];
    protected $appends = [
        'lokasi'
    ];
    protected $hidden = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'province_code', 'code')->withDefault([
            'name' => 'Provinsi Tidak Terdaftar'
        ]);
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'city_code', 'code')->withDefault([
            'name' => 'Kota/Kabupaten Tidak Terdaftar'
        ]);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'district_code', 'code')->withDefault([
            'name' => 'Kecamatan Tidak Terdaftar'
        ]);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'village_code', 'code')->withDefault([
            'name' => 'Kelurahan/Desa Tidak Terdaftar'
        ]);
    }

    public function personel()
    {
        return $this->hasOneThrough(Personel::class, User::class, 'id', 'user_id', 'user_id');
    }

    public function akumulasi_laporans()
    {
        return $this->belongsTo(AkumulasiLaporanBhabinkamtibmas::class, 'user_id', 'user_id');
    }

    public function getLokasiAttribute()
    {
        return Cache::remember('bhabinkamtibmasLokasiById' . $this->id, defaultCacheTime(Constants::CACHE1DAY),function (){
            if (isset($this->personel->polda) && $this->personel->polda == 'POLDA METRO JAYA' && $this->jenis_lokasi === 'kawasan') {
                return $this->kawasan;
            }
            $lokasi = 'Provinsi ' . $this->provinsi->name . ', ' . $this->kota->name;

            if ($this->jenis_lokasi == 'kawasan') {
                $lokasi .= ', Kawasan ' . $this->kawasan;
            } else {
                if (isset($this->kecamatan->name)){
                    $desa = $this->desa->name ?? "";
                    $lokasi .= ', Kecamatan ' . $this->kecamatan->name . (!isset($this->desa->name) || Str::contains($desa, ['DESA', 'Desa', 'desa']) ? ' '. $desa : ', Desa ' . $desa);
                }
            }
            return Str::title($lokasi);
        });
    }

    public function getLokasiSingkatAttribute()
    {
        return Cache::remember('bhabinkamtibmasLokasiSingkatById' . $this->id, defaultCacheTime(Constants::CACHE1DAY), function (){
            if ($this->jenis_lokasi == 'kawasan') {
                return 'Kawasan ' . $this->kawasan;
            } else {
                $desa = $this->desa->name ?? "";
                return !isset($this->desa->name) || Str::contains($desa, ['DESA', 'Desa', 'desa']) ? $desa : 'Desa ' . $desa;
            }
        });
    }
}
