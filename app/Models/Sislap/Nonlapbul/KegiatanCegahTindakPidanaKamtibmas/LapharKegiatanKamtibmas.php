<?php

namespace App\Models\Sislap\Nonlapbul\KegiatanCegahTindakPidanaKamtibmas;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class LapharKegiatanKamtibmas extends Model
{
    use SislapModelTrait;

    //LAPHAR KEGIATAN CEGAH TINDAK PIDANA DAN GANGGUAN KAMTIBMAS
    protected $table   = 'sislap_laphar_kegiatan_kamtibmas';
    protected $appends = ['need_approve', 'tanggal'];
    protected $guarded = ['id'];

    public function kegiatans()
    {
        return $this->belongsToMany(ListKegiatan::class, 'sislap_laphar_kegiatan_kamtibmas_pivot')
                    ->withPivot(['jumlah']);
    }

    /**
     * Uppercase polda input
     *
     * @return string
     */
    public function getTanggalAttribute()
    {
        return $this->created_at->translatedFormat(config('app.long_date_format'));
    }
}
