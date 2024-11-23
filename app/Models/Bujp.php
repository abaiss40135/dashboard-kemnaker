<?php

namespace App\Models;

use App\Models\OSS\Checklist;
use App\Models\OSS\NIB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Bujp extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'nib' => 'string'
    ];
    protected $appends = [
        'url_logo_badan_usaha',
        'url_foto_penanggung_jawab',
        'url_foto_ktp_penanggung_jawab'
    ];

    public function satpams() {
        return $this->hasMany(Satpam::class);
    }

    public function pendaftaran_sios(){
        return $this->hasMany(PendaftaranSio::class, 'bujp_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nib()
    {
        return $this->belongsTo(NIB::class, 'nib', 'nib');
    }

    public function getUrlLogoBadanUsahaAttribute () {
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->logo_badan_usaha);
    }

    public function getUrlFotoPenanggungJawabAttribute () {
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->foto_penanggung_jawab);
    }

    public function getUrlFotoKtpPenanggungJawabAttribute () {
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->foto_ktp_penanggung_jawab);
    }

    public function getNamaBadanUsahaAttribute($value)
    {
        $haystack = 'PT ';
        if (!Str::startsWith($value, $haystack)) return $haystack . $value;

        return $value;
    }
}
