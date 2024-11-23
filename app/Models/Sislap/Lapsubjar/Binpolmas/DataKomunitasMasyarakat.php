<?php

namespace App\Models\Sislap\Lapsubjar\Binpolmas;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataKomunitasMasyarakat extends Model
{
    use SislapModelTrait;

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve', 'provinsi', 'kabupaten', 'kecamatan', 'desa'];
    const SUMBER_DANA = [
        'iuran anggota',
        'bantuan/sumbangan masyarakat/asing/lembaga asing',
        'hasil usaha ormas',
        'APBN/APBN',
    ];

    public function getProvinsiAttribute()
    {
        return Provinsi::firstWhere('code', $this->provinsi_code)?->name;
    }

    public function getKabupatenAttribute()
    {
        return Kota::firstWhere('code', $this->kabupaten_code)?->name;
    }

    public function getKecamatanAttribute()
    {
        return Kecamatan::firstWhere('code', $this->kecamatan_code)?->name;
    }

    public function getDesaAttribute()
    {
        return Desa::firstWhere('code', $this->desa_code)?->name;
    }
}
