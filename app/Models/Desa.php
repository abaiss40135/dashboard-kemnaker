<?php

namespace App\Models;

use App\Support\Model\LocationModel;
use Illuminate\Support\Str;

class Desa extends LocationModel
{
    protected $table = 'villages';

    protected $guarded = [];

    protected $appends = [
        'long_location_name'
    ];

    public function getNameAttribute($value)
    {
        return Str::title($value);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'district_code', 'code');
    }


    public function getLongLocationNameAttribute(): string
    {
        return $this->cacheLongLocation('Desa/Kelurahan ' . $this->name . ', ' . $this->kecamatan->long_location_name, $this->code);
    }
}
