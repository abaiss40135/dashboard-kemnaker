<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiUser extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengubah()
    {
        return $this->belongsTo(User::class, 'user_id_pengubah');
    }
}
