<?php

namespace App\Models\Giat;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PenanggungJawabUsaha extends Model
{
    protected $table = 'penanggung_jawab_usaha';
    protected $guarded = ['id'];

    public function setTanggalLahirAttribute($value)
    {
        $this->attributes['tanggal_lahir'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getTanggalLahirAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
