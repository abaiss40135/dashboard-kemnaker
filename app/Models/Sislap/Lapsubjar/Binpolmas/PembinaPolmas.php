<?php

namespace App\Models\Sislap\Lapsubjar\Binpolmas;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class PembinaPolmas extends Model
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

    public function getLampiranFileAttribute($value)
    {
//        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->foto_profile);
        return $value ? config('filesystems.storage_url') . $value : '';
    }
}