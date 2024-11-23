<?php

namespace App\Models\OSS;

use App\Models\Bujp;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\RiwayatSio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NIB extends Model
{
    protected $table = 'nomor_induk_berusaha';
    protected $guarded = ['id'];
    protected $casts = [
        'nib' => 'string'
    ];
    protected $hidden = [
        'id', 'nib_id', 'created_at', 'updated_at'
    ];

    public function pemegangSahams()
    {
        return $this->hasMany(PemegangSaham::class, 'nib_id', 'id');
    }

    public function penanggungJawabs()
    {
        return $this->hasMany(PenanggungJawab::class, 'nib_id', 'id');
    }

    public function legalitas(){
        return $this->hasMany(Legalitas::class, 'nib_id', 'id');
    }

    public function rptkas()
    {
        return $this->hasMany(RPTKA::class, 'nib_id', 'id');
    }

    public function proyeks()
    {
        return $this->hasMany(Proyek::class, 'nib_id', 'id');
    }

    public function dnis()
    {
        return $this->hasMany(DNI::class, 'nib_id', 'id');
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class, 'nib_id', 'id');
    }

    public function checklist()
    {
        return $this->hasOne(Checklist::class, 'id_izin', 'id_izin');
    }

    public function bujp()
    {
        return $this->hasOne(Bujp::class, 'nib', 'nib');
    }

    public function desa()
    {
        return $this->hasOne(Desa::class, 'code', 'perseroan_daerah_id');
    }

    //ACESSOR::GETTER
    public function getNamaPerseroanAttribute($value)
    {
        if (!Str::startsWith($value, ['PT ', 'PT.'])) return 'PT ' . $value;

        return $value;
    }

    //MUTATOR::SETTER
    public  function setTipeDokumenAttribute($value)
    {
        $this->attributes['tipe_dokumen'] = $value === '-' ? null : $value;
    }
}
