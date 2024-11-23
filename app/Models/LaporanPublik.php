<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPublik extends Model
{
    protected $guarded = ['id'];
    protected $table = "laporan_publiks";

     public function keywords()
     {
         return $this->morphToMany(Keyword::class, 'keywordable');
     }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function laporan_informasi()
     {
         return $this->morphOne(LaporanInformasi::class, 'form')
             ->withDefault([
                 'uraian' => ''
             ]);
     }

    public function pengguna_publik() {
        return $this->hasOneThrough(PenggunaPublik::class, User::class, 'id', 'user_id', 'user_id');
    }

    public function getTanggalAttribute($value)
    {
        return $value ?? $this->created_at->format('Y-m-d');
    }
}
