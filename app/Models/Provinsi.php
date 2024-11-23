<?php

namespace App\Models;

use App\Support\Model\LocationModel;

class Provinsi extends LocationModel
{
    protected $table = 'provinces';

    protected $guarded = ['id'];

    public function kecamatans()
    {
        return $this->belongsTo(Kota::class, 'province_code', 'code');
    }

    public function kota()
    {
        return $this->hasMany(Kota::class, 'province_code', 'code');
    }

    public function getLongLocationNameAttribute(): string
    {
        return $this->cacheLongLocation('Provinsi ' . $this->name, $this->code);
    }

    public static function getCodeOfProvince($province)
    {
        return self::firstWhere('name', 'ilike', '%'. trim($province) .'%')->code;
    }
}
