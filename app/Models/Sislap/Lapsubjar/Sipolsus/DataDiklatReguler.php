<?php

namespace App\Models\Sislap\Lapsubjar\Sipolsus;

use App\Models\User;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataDiklatReguler extends Model
{
    protected $table = "data_diklat_reguler";
    use SislapModelTrait;

    protected $guarded = ["id"];

    protected $appends  = ['need_approve'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
