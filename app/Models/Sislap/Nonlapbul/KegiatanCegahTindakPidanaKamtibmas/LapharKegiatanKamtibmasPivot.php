<?php

namespace App\Models\Sislap\Nonlapbul\KegiatanCegahTindakPidanaKamtibmas;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LapharKegiatanKamtibmasPivot extends Pivot
{
    protected $table = "sislap_laphar_kegiatan_kamtibmas_pivot";
    protected $fillable = ['laphar_kegiatan_kamtibmas_id', 'list_kegiatan_id', 'jumlah'];

    public function LapharKegiatans()
    {
        return $this->belongsTo(LapharKegiatanKamtibmas::class);
    }

    public function ListKegiatans()
    {
        return $this->belongsTo(ListKegiatan::class);
    }
}
