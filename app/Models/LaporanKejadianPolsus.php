<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKejadianPolsus extends Model
{
    protected $table = 'laporan_kejadian_polsus';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public function pelaku() {
        return $this->hasMany(PelakuLaporanKejadianPolsus::class, "laporan_id");
    }

    public function saksi() {
        return $this->hasMany(SaksiLaporanKejadianPolsus::class, "laporan_id");
    }

}
