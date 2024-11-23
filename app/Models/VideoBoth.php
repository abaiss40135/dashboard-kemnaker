<?php

namespace App\Models;

use App\Events\VideoAdded;
use Illuminate\Database\Eloquent\Model;

class VideoBoth extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['url_file'];

    /*
     * This is the event that will be fired when a new Video Both is created
     * */
    protected static function booted()
    {
//        static::created(function($video) {
//            event(new VideoAdded($video));
//        });
    }

    public function personel()
    {
        return $this->hasOneThrough(Personel::class, User::class, 'id', 'user_id', 'user_id');
    }

    public function lokasi_tugas()
    {
        return $this->hasOneThrough(LokasiPenugasan::class, User::class,'id', 'user_id', 'user_id')
            ->orderByDesc('updated_at');
    }

    public function lokasiPenugasans()
    {
        return $this->hasManyThrough(LokasiPenugasan::class, User::class,'id', 'user_id', 'user_id');
    }

    public function getUrlFileAttribute()
    {
        return config('filesystems.storage_url') . $this->file;
    }
}
