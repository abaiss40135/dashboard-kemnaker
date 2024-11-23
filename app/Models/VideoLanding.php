<?php

namespace App\Models;

use App\Traits\TaggableTrait;
use Illuminate\Database\Eloquent\Model;

class VideoLanding extends Model
{
    use TaggableTrait;

    protected $guarded = [];
    protected $appends = [
        'url_file_video'
    ];

    public function getUrlFileVideoAttribute()
    {
        return config('filesystems.storage_url') . $this->file_video;
    }
}
