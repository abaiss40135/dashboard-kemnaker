<?php

namespace App\Models\Sislap\Lapsubjar\Bhabin;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class RekapPendampingan extends Model
{
    use SislapModelTrait;

    protected $guarded = ['id'];

    protected $appends  = ['need_approve'];
}
