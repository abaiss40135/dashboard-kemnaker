<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class LapharMinyakGoreng extends Model
{
    use SislapModelTrait;

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
