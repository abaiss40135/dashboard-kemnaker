<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendapatWarga extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'dds_warga_id', 'jenis_pendapat', 'nilai_informasi_abjad',
        'nilai_informasi_angka', 'bidang_pendapat', 'uraian'
    ];

    protected static function boot() {
        parent::boot();

        static::deleting(function($pendapatWarga) {
            $pendapatWarga->keywords()->detach();
        });
    }

    public function dds_warga(){
        return $this->belongsTo(Dds_warga::class, 'dds_warga_id');
    }

    public function keywords()
    {
        return $this->morphToMany(Keyword::class, 'keywordable')->withTimestamps();
    }
}
