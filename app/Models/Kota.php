<?php

namespace App\Models;

use App\Support\Model\LocationModel;

class Kota extends LocationModel
{
    protected $table = 'cities';

    protected $guarded = ['id'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'province_code', 'code');
    }

    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class, 'city_code', 'code');
    }

    public function getLongLocationNameAttribute(): string
    {
        return $this->cacheLongLocation($this->name . ', ' .  $this->provinsi->long_location_name, $this->code);
    }

    public static function getCodeOfKota($kota)
    {
        return self::firstWhere('name', 'ilike', '%'. $kota .'%')->code;
    }
}
