<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DikumPersonel extends Model
{
    public $timestamps = false;
    protected $table = 'dikum_personel';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
