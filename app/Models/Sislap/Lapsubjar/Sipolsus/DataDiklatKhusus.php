<?php

namespace App\Models\Sislap\Lapsubjar\Sipolsus;

use App\Models\User;
use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataDiklatKhusus extends Model
{
    use SislapModelTrait;

    protected $table = "data_diklat_khusus";
    protected $guarded = ["id"];

    protected $appends  = ['need_approve'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
