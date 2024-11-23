<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class PreemtifPmk extends Model
{
    use SislapModelTrait;

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
