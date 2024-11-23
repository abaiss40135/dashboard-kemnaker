<?php

namespace App\Models\Sislap\Lapsubjar\Binpolmas;

use App\Models\User;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataFkpm extends Model
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

    public function scopeIsWilayah($query)
    {
        return $query->where('type', 'wilayah');
    }

    public function scopeIsKawasan($query)
    {
        return $query->where('type', 'kawasan');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
