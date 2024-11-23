<?php

namespace App\Models;

use App\Events\PaparanAdded;
use App\Helpers\Constants;
use App\Traits\TaggableTrait;
use Illuminate\Database\Eloquent\Model;

class Paparan extends Model
{
    use TaggableTrait;

    protected $guarded = [];

    protected $appends = [
        'url_gambar',
        'url_thumbnail'
    ];


    /*
     * This is the event that will be fired when a new paparan is created
     * */
    protected static function booted()
    {
//        static::created(function($paparan) {
//            event(new PaparanAdded($paparan));
//        });
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function getUrlGambarAttribute()
    {
        return !empty($this->gambar) ? config('filesystems.storage_url') . $this->gambar : null;
    }

    public function getUrlThumbnailAttribute()
    {
        return !empty($this->thumbnail) ? config('filesystems.storage_url') . $this->thumbnail : null;
    }
}
