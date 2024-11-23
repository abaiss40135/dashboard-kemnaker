<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kawasan extends Model
{
    protected $table = 'kawasan';
    protected $guarded = ['id'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'province_code', 'code');
    }
}
