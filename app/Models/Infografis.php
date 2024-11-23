<?php

namespace App\Models;

use App\Events\InfografisAdded;
use App\Helpers\Constants;
use App\Traits\TaggableTrait;
use Illuminate\Database\Eloquent\Model;

class Infografis extends Model
{
    use TaggableTrait;

    protected $guarded = [];
    protected $appends = [
        'url_gambar'
    ];

    /*
     * This is the event that will be fired when a new Infografis is created
     * */
    protected static function booted()
    {
//        static::created(function($infografis) {
//            event(new InfografisAdded($infografis));
//        });
    }

    public function getUrlGambarAttribute()
    {
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->gambar);
    }
}
