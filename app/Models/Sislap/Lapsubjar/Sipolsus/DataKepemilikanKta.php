<?php

namespace App\Models\Sislap\Lapsubjar\Sipolsus;

use App\Models\User;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataKepemilikanKta extends Model
{
    protected $table = "data_kepemilikan_kta";
    use SislapModelTrait;

    protected $guarded = ["id"];

    protected $appends  = ['need_approve'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
