<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsNonSengketa extends Model
{
    protected $guarded = ['id'];
    protected $appends = [
        'keyword'
    ];

    public function keywords()
    {
        return $this->morphToMany(Keyword::class, 'keywordable');
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

    public function getKeywordAttribute()
    {
        return $this->keywords()->get(['keyword'])->implode('keyword', ', ');
    }
    
    public function getJenisLaporanAttribute()
    {
        return 'PS Non Sengketa';
    }
}
