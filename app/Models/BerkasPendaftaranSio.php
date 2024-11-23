<?php

namespace App\Models;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Model;

class BerkasPendaftaranSio extends Model
{
    protected $table = 'berkas_pendaftaran_sio';
    protected $guarded = ['id'];
    protected $fillable = ['riwayat_sio_id', 'nama', 'file','jenis_berkas', 'validasi', 'keterangan'];
    protected $casts = [
        'jenis_berkas' => 'string'
    ];
    protected $appends = [
        'file_url'
    ];

    public function pendaftaranSio()
    {
        return $this->belongsTo(PendaftaranSio::class, 'pendaftaran_sio_id', 'id');
    }

    public function jenisBerkas()
    {
        return $this->belongsTo(JenisBerkas::class, 'jenis_berkas', 'jenis');
    }

    public function scopeValid($query)
    {
        return $query->where('validasi', true);
    }

    public function scopeInvalid($query)
    {
        return $query->whereNull('validasi')->orWhere('validasi', false);
    }

    public function getFileUrlAttribute()
    {
        return !empty($this->file) ? config('filesystems.storage_url') . str_replace('//', '/', $this->file) : $this->file;
    }
}
