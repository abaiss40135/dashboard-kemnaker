<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Models\Dokumentasi;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class PreemtifBbm extends Model
{
    use SislapModelTrait;

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];

    public function dokumentasi()
    {
        return $this->morphMany(Dokumentasi::class, 'laporan');
    }
}

