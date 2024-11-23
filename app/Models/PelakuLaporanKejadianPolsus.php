<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelakuLaporanKejadianPolsus extends Model
{
    protected $guarded = [];

    public function laporanKejadian() {
        return $this->belongsTo(LaporanKejadianPolsus::class, "laporan_id");
    }
}
