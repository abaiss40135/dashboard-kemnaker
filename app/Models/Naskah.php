<?php

namespace App\Models;

use App\Helpers\Constants;
use App\Traits\TaggableTrait;
use Illuminate\Database\Eloquent\Model;

class Naskah extends Model
{
    use TaggableTrait;

    protected $guarded = [];
    protected $appends = [
        'url_file_naskah'
    ];

    public function getUrlFileNaskahAttribute()
    {
        return config('filesystems.storage_url') . $this->file_naskah;
    }
}
