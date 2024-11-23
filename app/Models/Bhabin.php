<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bhabin extends Model
{
    protected $table = "bhabins";
    protected $guarded =[];

    public function deteksi_dinis(){
        return $this->hasMany(Deteksi_dini::class);
    }
}
