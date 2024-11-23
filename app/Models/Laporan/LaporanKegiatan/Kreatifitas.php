<?php

namespace App\Models\Laporan\LaporanKegiatan;

use App\Helpers\Constants;
use App\Models\LokasiPenugasan;
use App\Models\Personel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Kreatifitas extends Model
{
    protected $guarded = ['id'];
    protected $appends = [
        'url_file'
    ];

    public function getUrlFileAttribute()
    {
        return config('filesystems.storage_url') . $this->file;
    }

    public function personel()
    {
        return $this->hasOneThrough(Personel::class, User::class, 'id', 'user_id', 'user_id');
    }

    public function lokasi_tugas()
    {
        return $this->hasOneThrough(LokasiPenugasan::class, User::class,'id', 'user_id', 'user_id')
            ->orderByDesc('updated_at');
    }

    public function lokasiPenugasans()
    {
        return $this->hasManyThrough(LokasiPenugasan::class, User::class,'id', 'user_id', 'user_id');
    }
}
