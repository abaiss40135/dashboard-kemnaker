<?php

namespace App\Models\Sislap\Lapsubjar\Sipolsus;

use App\Models\Instansi;
use App\Models\User;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataSenpi extends Model
{
    protected $table = "data_senpi";
    use SislapModelTrait;

    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}