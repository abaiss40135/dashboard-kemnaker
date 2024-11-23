<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class LaporanInformasi extends Model
{
    use ModelTrait;

    protected $table = 'laporan_informasi';
    protected $guarded = ['id'];
    protected $fillable = [
        'bidang', 'uraian', 'metode', 'nilai_abjad',
        'nilai_angka', 'form_id', 'form_type'
    ];


    protected static function boot() {
        parent::boot();

        static::deleting(function($laporanInformasi) {
            $laporanInformasi->keywords()->detach();
        });
    }
    /**
     * Get the parent formulir model (dds or detekdi dini).
     */
    public function form()
    {
        return $this->morphTo();
    }

    public function keywords()
    {
        return $this->morphToMany(Keyword::class, 'keywordable')->withTimestamps();
    }
}
