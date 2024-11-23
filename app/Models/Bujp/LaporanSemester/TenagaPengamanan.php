<?php

namespace App\Models\Bujp\LaporanSemester;

use App\Models\Bujp;
use App\Models\User;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class TenagaPengamanan extends Model
{
    use SislapModelTrait;

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];

    protected $fillable = [
        'user_id',
        'bujp_id',
        'no_sio',
        'tanggal_sio',
        'pengguna_jasa',
        'kualifikasi_gp',
        'kualifikasi_gm',
        'kualifikasi_gu',
        'perumahan',
        'hotel',
        'rumah_sakit',
        'perbankan',
        'pabrik',
        'toko',
        'perkebunan',
        'tambang',
        'kantor',
        'transportasi',
        'pendidikan',
    ];

    public function Bujp()
    {
        return $this->belongsTo(Bujp::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
