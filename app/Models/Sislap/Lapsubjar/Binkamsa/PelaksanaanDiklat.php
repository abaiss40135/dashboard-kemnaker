<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class PelaksanaanDiklat extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'polda',
        'bujp',
        'tempat',
        'waktu',
        'pria',
        'wanita',
        'jumlah_peserta',
        'tanggal_buka',
        'tanggal_tutup',
        'sendiri',
        'kerma',
        'latdik',
        'keterangan',
        'jumlah',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
