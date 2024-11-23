<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use ModelTrait;

    protected $guarded = ['id'];

    public function ddsWargas()
    {
        return $this->morphedByMany(Dds_warga::class, 'keywordable');
    }

    public function deteksiDinis()
    {
        return $this->morphedByMany(Deteksi_dini::class, 'keywordable');
    }

    public function problemSolvings()
    {
        return $this->morphedByMany(Problem_solving::class, 'keywordable');
    }

    public function laporanInformasis()
    {
        return $this->morphedByMany(LaporanInformasi::class, 'keywordable');
    }

    public function pendapatWargas()
    {
        return $this->morphedByMany(PendapatWarga::class, 'keywordable');
    }

    public function scopeWhereKeyword($query, $keyword)
    {
        $query->whereHas('ddsWargas.keywords', function ($query) use ($keyword){
            $query->where('keyword', 'ilike', '%'.$keyword.'%');
        })->orWhereHas('deteksiDinis.keywords', function ($query) use ($keyword){
            $query->where('keyword', 'ilike', '%'.$keyword.'%');
        })->orWhereHas('problemSolvings.keywords', function ($query) use ($keyword){
            $query->where('keyword', 'ilike', '%'.$keyword.'%');
        });
    }

    public function scopeOrWhereKeyword($query, $keyword)
    {
        $query->orWhereHas('ddsWargas.keywords', function ($query) use ($keyword){
            $query->where('keyword', 'ilike', '%'.$keyword.'%');
        })->orWhereHas('deteksiDinis.keywords', function ($query) use ($keyword){
            $query->where('keyword', 'ilike', '%'.$keyword.'%');
        })->orWhereHas('problemSolvings.keywords', function ($query) use ($keyword){
            $query->where('keyword', 'ilike', '%'.$keyword.'%');
        });
    }
}
