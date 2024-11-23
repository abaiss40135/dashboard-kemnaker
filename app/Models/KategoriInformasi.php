<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriInformasi extends Model
{
    protected $table = 'kategori_informasi';
    protected $guarded = ['id'];

    public function getUrlIconPrimaryAttribute()
    {
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->icon_primary);
    }

    public function getUrlIconSecondaryAttribute()
    {
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->icon_secondary);
    }

    public function getIconAttribute()
    {
        $icon = roles(['bhabinkamtibmas', 'polisi_rw']) ? $this->icon_primary : $this->icon_secondary;
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $icon);
    }
}
