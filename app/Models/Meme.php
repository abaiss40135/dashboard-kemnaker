<?php

namespace App\Models;

use App\Events\MemeAdded;
use App\Helpers\Constants;
use App\Traits\TaggableTrait;
use Illuminate\Database\Eloquent\Model;

class Meme extends Model
{
    use TaggableTrait;

    protected $guarded = [];
    protected $appends = [
        'url_gambar'
    ];

    /*
     * This is the event that will be fired when a new Meme is created
     * */
    protected static function booted()
    {
//        static::created(function($meme) {
//            event(new MemeAdded($meme));
//        });
    }

    public function getUrlGambarAttribute()
    {
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->gambar);
    }
}
