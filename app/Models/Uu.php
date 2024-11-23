<?php

namespace App\Models;

use App\Helpers\Constants;
use App\Traits\TaggableTrait;
use Illuminate\Database\Eloquent\Model;

class Uu extends Model
{
    use TaggableTrait;

    protected $guarded = [];
    protected $appends = [
        'url_file_uu'
    ];

    public function getUrlFileUuAttribute()
    {
        return config('filesystems.storage_url') . str_replace('//', '/', $this->file_uu);
    }
}
