<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['file_uri'];

    public function laporan()
    {
        return $this->morphTo();
    }

    public function getFileUriAttribute() {
        return config('filesystems.storage_url') . str_replace('//', '/', $this->file);
    }
}