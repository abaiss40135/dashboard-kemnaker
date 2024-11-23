<?php

namespace App\Models\PolisiRW;

use App\Models\Desa;
use App\Models\Personel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KetuaRW extends Model
{
    protected $guarded = ['id'];
    protected $table = 'ketua_rw';
    protected $fillable = [
        'nik',
        'nama',
        'hp',
        'village_code',
        'alamat',
        'rw',
        'kategori_kegiatan_id',
        'kategori_kerawanan_id',
        'personel_id'
    ];

    public function kategori_kegiatan(): BelongsTo
    {
        return $this->belongsTo(KategoriKegiatan::class, 'kategori_kegiatan_id');
    }

    public function kategori_kerawanan(): BelongsTo
    {
        return $this->belongsTo(KategoriKerawanan::class, 'kategori_kerawanan_id');
    }

    public function personel()
    {
        return $this->belongsTo(Personel::class, 'personel_id', 'personel_id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'village_code', 'code');
    }
}
