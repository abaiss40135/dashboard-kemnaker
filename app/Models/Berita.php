<?php

namespace App\Models;

use App\Helpers\Constants;
use App\Traits\TaggableTrait;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use TaggableTrait;

    protected $guarded = [];
    protected $appends = [
        'url_gambar'
    ];

    public function getUrlGambarAttribute()
    {
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->gambar);
    }
}
