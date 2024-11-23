<?php

namespace App\Models\Giat;

use App\Models\Personel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DDSTempatUsaha extends Model
{
    protected $table = 'dds_tempat_usaha';
    protected $guarded = ['id'];

    public function penanggung_jawabs()
    {
        return $this->hasMany(PenanggungJawabUsaha::class, 'dds_tempat_usaha_id', 'id');
    }

    public function penanggung_jawab_usaha()
    {
        return $this->hasOne(PenanggungJawabUsaha::class, 'dds_tempat_usaha_id', 'id')->where('type', 'KANTOR');
    }

    public function penanggung_jawab_keamanan()
    {
        return $this->hasOne(PenanggungJawabUsaha::class, 'dds_tempat_usaha_id', 'id')->where('type', 'KEAMANAN');
    }

    public function karyawans()
    {
        return $this->hasMany(KaryawanTempatUsaha::class, 'dds_tempat_usaha_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function personel()
    {
        return $this->hasOneThrough(Personel::class, User::class, 'id', 'user_id', 'user_id')
            ->withDefault([
                'nama' => 'Tidak terdaftar pada SIPP 2.0',
                'lama_jabatan' => '-',
                'pangkat' => '-',
                'handphone' => '-'
            ]);
    }

    public function setTanggalKunjunganAttribute($value)
    {
        $this->attributes['tanggal_kunjungan'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getTanggalKunjunganAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getJamKerjaAttribute()
    {
        return "{$this->jam_kerja_awal} - {$this->jam_kerja_akhir}";
    }
}
