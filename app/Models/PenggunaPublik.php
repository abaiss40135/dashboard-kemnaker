<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenggunaPublik extends Model
{
    protected $table = 'pengguna_publik';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
