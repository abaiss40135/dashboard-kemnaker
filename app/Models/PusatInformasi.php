<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PusatInformasi extends Model
{
    protected $table = 'pusat_informasi';

    protected $casts = [
        'body' => 'json'
    ];

    protected $hidden = [
        'key', 'search', 'metadata'
    ];

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query
            ->where(function ($query) use ($search){
                $query->whereRaw('search @@ websearch_to_tsquery(\'simple\', ?)', [$search])
                    ->orWhereRaw('search @@ websearch_to_tsquery(\'indonesian\', ?)', [$search]);
            })
            ->select('body')
            ->orderByRaw('ts_rank(search, websearch_to_tsquery(\'simple\', ?)) +
                            ts_rank(search, websearch_to_tsquery(\'indonesian\', ?)) DESC', [$search, $search]);
    }
}
