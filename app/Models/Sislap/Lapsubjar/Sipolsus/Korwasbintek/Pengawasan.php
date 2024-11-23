<?php

namespace App\Models\Sislap\Lapsubjar\Sipolsus\Korwasbintek;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class Pengawasan extends Model
{
    use SislapModelTrait;

    public $table = 'kegiatan_korwasbintek_pengawasans';

    protected $guarded  = ['id'];
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
}
