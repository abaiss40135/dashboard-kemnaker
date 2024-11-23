<?php

namespace App\Models\Sislap\Lapsubjar\Bintibsos;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class GiatPembinaan extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'kesatuan', 'bulan', 'bencana_dan_pembinaan', 'penyuluhan', 'sambang',
        'sosialisasi', 'upacara', 'polisi_cilik', 'olahraga', 'baksos',
        'trauma_healing', 'evakuasi', 'lain_lain', 'jumlah', 'keterangan',
        'user_id', 'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
