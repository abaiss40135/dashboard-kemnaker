<?php

namespace App\Models\Sislap\Lapsubjar\Binpolmas;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class KegiatanPetugasPolmas extends Model
{
    use SislapModelTrait;

    protected $table = 'sislap_kegiatan_petugas_polmas';
    protected $guarded = ['id'];
    protected $appends = ['need_approve', 'lampiran_url'];

    public function getLampiranUrlAttribute()
    {
        return config('filesystems.storage_url') . str_replace('//', '/', $this->lampiran);
    }
}
