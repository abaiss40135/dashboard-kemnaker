<?php

namespace App\Models\Sislap\Nonlapbul\KegiatanCegahTindakPidanaKamtibmas;

use Illuminate\Database\Eloquent\Model;

class ListKegiatan extends Model
{
    protected $table = 'sislap_laphar_list_kegiatan';
    protected $guarded = ['id'];

    public function LapharKegiatans()
    {
        return $this->belongsToMany(LapharKegiatanKamtibmas::class, 'sislap_laphar_kegiatan_kamtibmas_pivot');
    }
}
