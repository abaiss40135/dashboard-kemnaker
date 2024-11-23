<?php

namespace App\Support\Model;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

abstract class LocationModel extends Model
{
    abstract public function getLongLocationNameAttribute(): string;

    public function cacheLongLocation(string $location, $kode_daerah)
    {
        return Cache::remember('longLocationName' . $kode_daerah, defaultCacheTime(Constants::CACHE1DAY), function () use ($location) {
            return strtoupper($location);
        });
    }
}
