<?php

namespace App\Models\Sislap\Lapsubjar\Bintibsos;

use App\Models\Sislap\Lapsubjar\Binpolmas\AnggotaPolriDaiKamtibmas;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DaiKamtibmas extends Model
{
    use SislapModelTrait;

    protected $guarded = ["id"];
    protected $appends  = ['need_approve'];

    /**
     * Uppercase polda input
     *
     * @param  string  $value
     * @return string
     */
    public function getPoldaAttribute($value)
    {
        return strtoupper($value);
    }

    /**
     * Uppercase polda input
     *
     * @param  string  $value
     * @return string
     */
    public function getPolresAttribute($value)
    {
        return strtoupper($value);
    }

    public function dataPolri()
    {
        return $this->hasOne(AnggotaPolriDaiKamtibmas::class);
    }

    public function getRwAttribute($value)
    {
        return $value ? $value : '-';
    }

    public function getRtAttribute($value)
    {
        return $value ? $value : '-';
    }

    public function getDusunAttribute($value)
    {
        return $value ? $value : '-';
    }
}
