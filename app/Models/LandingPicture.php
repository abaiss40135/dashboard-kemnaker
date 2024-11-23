<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPicture extends Model
{
    protected $appends = ['url_file'];

    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getUrlFileAttribute()
    {
        return config('filesystems.storage_url') . str_replace('//', '/', $this->file);
    }
}
