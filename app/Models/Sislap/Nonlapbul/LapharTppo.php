<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class LapharTppo extends Model
{
    use SislapModelTrait;

    protected $table   = 'laphar_tppo';
    protected $appends = ['need_approve'];
    protected $guarded = ['id'];
}
