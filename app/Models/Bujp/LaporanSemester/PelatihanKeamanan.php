<?php

namespace App\Models\Bujp\LaporanSemester;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanKeamanan extends Model
{
    protected $fillable = [
        'user_id',
        'bujp_id',
        'no_sio',
        'pengguna_jasa',
        'alamat',
        'tempat_diklat',
        'pihak_yang_menyewakan_tempat',
        'fasilitas',
        'jenis_diklat',
        'waktu_diklat_dari',
        'waktu_diklat_sampai',
        'jumlah_peserta',
    ];

    protected $appends = [
        'waktu_diklat_dari_raw',
        'waktu_diklat_sampai_raw',
        'fasilitas_escape'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function bujp()
    {
        return $this->belongsTo(\App\Models\Bujp::class);
    }

    public function getWaktuDiklatDariAttribute($value)
    {
        return date('d F', strtotime($value));
    }

    public function getWaktuDiklatSampaiAttribute($value)
    {
        return date('d F Y', strtotime($value));
    }

    public function getWaktuDiklatDariRawAttribute()
    {
        return $this->attributes['waktu_diklat_dari'];
    }

    public function getWaktuDiklatSampaiRawAttribute($value)
    {
        return $this->attributes['waktu_diklat_sampai'];
    }

    public function getFasilitasEscapeAttribute()
    {
        return str_replace('<br>',"\r\n", $this->attributes['fasilitas']);
    }
}
