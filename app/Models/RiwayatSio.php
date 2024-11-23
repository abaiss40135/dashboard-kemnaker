<?php

namespace App\Models;

use App\Helpers\Constants;
use App\Models\Log\LogStatusRiwayatSio;
use App\Models\OSS\Checklist;
use Illuminate\Database\Eloquent\Model;

class RiwayatSio extends Model
{
    protected $table = 'riwayat_sio';
    protected $guarded = ['id'];
    protected $casts = [
        'jadwal_audit' => 'datetime'
    ];
    protected $appends = [
        'status'
    ];

    const KANTOR_PUSAT  = 'KANTOR PUSAT';
    const PERLUASAN     = 'PERLUASAN';

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'id_izin', 'id_izin');
    }

    public function statusSios()
    {
        return $this->belongsToMany(StatusSio::class, 'log_status_riwayat_sio', 'riwayat_sio_id', 'status_sio_id')
            ->using(LogStatusRiwayatSio::class)
            ->orderByPivot('created_at', 'desc')
            ->withPivot('keterangan')
            ->withTimestamps();
    }

    public function log_statuses()
    {
        return $this->hasMany(LogStatusRiwayatSio::class, 'riwayat_sio_id', 'id');
    }

    public function status_terakhir()
    {
        return $this->hasOne(LogStatusRiwayatSio::class, 'riwayat_sio_id', 'id')
            ->orderBy('created_at', 'desc');
    }

    public function dokumens()
    {
        return $this->hasMany(BerkasPendaftaranSio::class, 'riwayat_sio_id', 'id');
    }

    public function fileDS()
    {
        return $this->hasMany(FileDS::class, 'id_izin', 'id_izin')->orderByDesc('updated_at');
    }

    public function getUrlFileSuratRekomAttribute()
    {
        return config('filesystems.storage_url') . $this->file_surat_rekom;
    }

    public function getUrlFileHasilAuditAttribute()
    {
        return config('filesystems.storage_url') . $this->file_hasil_audit;
    }

    public function scopeHasChecklist($query)
    {
        return $query->has('checklist');
    }

    public function scopeOperatorPolda($query, $polda)
    {
        return $query->has('dokumens')
            ->has('status_terakhir')
            ->where('polda', $polda);
    }

    public function scopeValid($query)
    {
        return $query->whereDoesntHave('dokumens', function ($query) {
            $query->where('berkas_pendaftaran_sio.validasi', false);
        })
            ->where('riwayat_sio.validasi_hasil_audit', '=', true)
            ->where('riwayat_sio.validasi_surat_rekom', '=', true);
    }

    public function scopeValidOrNull($query)
    {
        return $query->whereDoesntHave('dokumens', function ($query) {
            $query->where('berkas_pendaftaran_sio.validasi', false);
        })->where(function ($query) {
            $query->where(function ($query) {
                $query->whereNotNull('riwayat_sio.keterangan_validasi_hasil_audit')
                    ->orWhere('riwayat_sio.validasi_hasil_audit', true);
            })->orWhere(function ($query) {
                $query->whereNotNull('riwayat_sio.keterangan_validasi_surat_rekom')
                    ->orWhere('riwayat_sio.validasi_surat_rekom', true);
            })->orWhere(function ($query){
                $query->whereNull('riwayat_sio.validasi_hasil_audit')
                    ->whereNull('riwayat_sio.validasi_surat_rekom');
            });
        });
    }

    public function getStatusAttribute()
    {
        return $this->statusSios()->first(['id', 'status']) ?? null;
    }
}
