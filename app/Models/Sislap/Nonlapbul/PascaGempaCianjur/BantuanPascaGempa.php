<?php

namespace App\Models\Sislap\Nonlapbul\PascaGempaCianjur;

use App\Models\Kecamatan;
use App\Models\Personel;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class BantuanPascaGempa extends Model
{
    use SislapModelTrait;

    protected $table = 'sislap_bantuan_pasca_gempa';
    protected $appends  = ['need_approve', 'tanggal'];
    protected $guarded = ['id'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'district_code', 'code');
    }

    public function jenis_kegiatan()
    {
        return $this->belongsTo(JenisGiatPascaGempa::class, 'jenis_kegiatan_id');
    }

    public function personel()
    {
        return $this->belongsTo(Personel::class, 'personel_id');
    }

    public function setLokasiKegiatanAttribute($value)
    {
        $this->attributes['lokasi_kegiatan'] = strtoupper($value);
    }

    public function setUraianKegiatanAttribute($value)
    {
        $this->attributes['uraian_kegiatan'] = strtoupper($value);
    }
}
