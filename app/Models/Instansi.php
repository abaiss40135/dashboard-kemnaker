<?php

namespace App\Models;

use App\Models\Sislap\Lapsubjar\Sipolsus\DataAmunisi;
use App\Models\Sislap\Lapsubjar\Sipolsus\DataSenpi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    public $timestamps = false;
    public $guarded = [];
    use HasFactory;

    public function polsus()
    {
        return $this->hasMany(Polsus::class);
    }

    public function senpis()
    {
        return $this->hasMany(DataSenpi::class);
    }

    public function amunisis()
    {
        return $this->hasMany(DataAmunisi::class);
    }
}
