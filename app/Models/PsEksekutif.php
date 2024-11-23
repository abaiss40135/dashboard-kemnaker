<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsEksekutif extends Model
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

    public function getKeywordAttribute()
    {
        return $this->keywords()->get(['keyword'])->implode('keyword', ', ');
    }
}
