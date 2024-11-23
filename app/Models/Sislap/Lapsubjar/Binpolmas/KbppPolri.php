<?php

namespace App\Models\Sislap\Lapsubjar\Binpolmas;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class KbppPolri extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'daerah',
        'alamat_sekretariat',
        'nama_ketua',
        'no_hp',
        'jumlah_anggota',
        'kegiatan',
        'kode_satuan',
        'user_id'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
