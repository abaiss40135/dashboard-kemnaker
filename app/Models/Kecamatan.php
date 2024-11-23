<?php

namespace App\Models;

use App\Support\Model\LocationModel;

class Kecamatan extends LocationModel
{
    protected $table = 'districts';

    protected $guarded = ['id'];

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'city_code', 'code');
    }

    public function desas()
    {
        return $this->hasMany(Desa::class, 'district_code', 'code');
    }

    public function getLongLocationNameAttribute(): string
    {
        return $this->cacheLongLocation('Kec. ' . $this->name . ', ' . $this->kota->long_location_name, $this->code);
    }
}
