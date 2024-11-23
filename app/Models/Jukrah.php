<?php

namespace App\Models;

use App\Events\JukrahAdded;
use Illuminate\Database\Eloquent\Model;

class Jukrah extends Model
{
    const TYPE = [
        'bhabinkamtibmas',
        'polisi_rw',
    ];

    protected $guarded = ['id' , 'created_at' , 'updated_at'];

    protected static function booted()
    {
//        static::created(function($jukrah) {
//            event(new JukrahAdded($jukrah));
//        });
    }
}
