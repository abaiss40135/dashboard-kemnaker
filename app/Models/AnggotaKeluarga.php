<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    protected $guarded = [];

    public function dds_warga(){
        return $this->belongsTo(Dds_warga::class, 'dds_warga_id');
    }
}
