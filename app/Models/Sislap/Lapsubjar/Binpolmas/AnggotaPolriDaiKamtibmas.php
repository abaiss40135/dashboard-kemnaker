<?php

namespace App\Models\Sislap\Lapsubjar\Binpolmas;

use App\Models\Sislap\Lapsubjar\Bintibsos\DaiKamtibmas;
use Illuminate\Database\Eloquent\Model;

class AnggotaPolriDaiKamtibmas extends Model
{
    protected $guarded = ["id"];

    public function daiKamtibnas()
    {
        return $this->belongsTo(DaiKamtibmas::class, "dai_kamtibmas_id");
    }
}
