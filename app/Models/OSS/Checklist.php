<?php

namespace App\Models\OSS;

use App\Models\FileDS;
use App\Models\RiwayatSio;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $table = 'data_checklist';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $hidden = [
        'id', 'nib_id'
    ];
    protected $appends = [
        'tanggal_pengajuan'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nib()
    {
        return $this->belongsTo(NIB::class, 'nib_id', 'id');
    }

    public function persyaratans()
    {
        return $this->hasMany(Persyaratan::class, 'data_checklist_id', 'id');
    }

    public function riwayatSios()
    {
        return $this->hasMany(RiwayatSio::class, 'id_izin', 'id_izin');
    }

    public function riwayatSio()
    {
        return $this->hasOne(RiwayatSio::class, 'id_izin', 'id_izin')->orderByDesc('tanggal_pengajuan');
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'id_proyek', 'id_proyek');
    }

    public function file_ds()
    {
        return $this->hasOne(FileDS::class, 'id_izin', 'id_izin');
    }

    public function getTanggalPengajuanAttribute()
    {
        return $this->riwayatSios()->orderByDesc('tanggal_pengajuan')->first()->tanggal_pengajuan ?? null;
    }
}
