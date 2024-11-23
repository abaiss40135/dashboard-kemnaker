<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPerubahanJumlahBhabinkamtibmas extends Model
{
    protected $guarded = [];

    public function lokasi_tugas()
    {
        return $this->hasOneThrough(
            LokasiPenugasan::class,
            User::class,
            'nrp',
            'user_id',
            'nrp',
            'id'
        );
    }

    public function personel()
    {
        return $this->hasOneThrough(
            Personel::class,
            User::class,
            'nrp',
            'user_id',
            'nrp',
            'id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nrp', 'nrp');
    }

    public function countJumlahBhabinNow($province_code = '', $district_code = '')
    {
        return $this->when(!empty($province_code), function($q) {
            $q->where("province_code", $this->province_code);
        })->when(!empty($district_code), function($q) {
            $q->where("district_code", $this->district_code);
        })->count();
    }

    public function getFileDataPersonelBhabinkamtibmasPolresAttribute($value)
    {
        return config('filesystems.storage_url') . str_replace('//', '/', $value);
    }
}
