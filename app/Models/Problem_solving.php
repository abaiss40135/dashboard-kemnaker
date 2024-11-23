<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Problem_solving extends Model
{
    protected $guarded = [];
    protected $appends = [
        'url_skb'
    ];

    public function keywords()
    {
        return $this->morphToMany(Keyword::class, 'keywordable')->withTimestamps();
    }

    public function laporan_informasi()
    {
        return $this->morphOne(LaporanInformasi::class, 'form');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function personel()
    {
        return $this->hasOneThrough(Personel::class, User::class, 'id', 'user_id', 'user_id');
    }

    public function getUrlSkbAttribute()
    {
        return !empty($this->surat_kesepakatan) ? config('filesystems.storage_url') . $this->surat_kesepakatan : null;
    }

    public function getJenisLaporanAttribute()
    {
        return 'PS Sengketa';
    }

    /*public function getAlamatAttribute()
    {
        $alamat = $this->alamat_narasumber;
        return Str::title($alamat);
    }*/
}
