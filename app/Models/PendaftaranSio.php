<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Model;

class PendaftaranSio extends Model
{
    protected $guarded = ['id'];

    public function bujp(){
        return $this->belongsTo(Bujp::class , 'bujp_id');
    }

    public function statusSio()
    {
        return $this->belongsTo(StatusSio::class, 'status', 'id');
    }

    public function berkasPendaftaran()
    {
        return $this->hasMany(BerkasPendaftaranSio::class, 'pendaftaran_sio_id', 'id')->orderBy('id');
    }

    public function getUrlSuratRekomAttribute()
    {
        return config('filesystems.storage_url') . $this->surat_rekom;
    }

    public function getUrlHasilAuditAttribute()
    {
        return config('filesystems.storage_url') . $this->hasil_audit;
    }
}
