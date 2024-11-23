<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class LapharDitbinmas extends Model
{
    use SislapModelTrait;

    protected $table   = 'laphar_ditbinmas';
    protected $appends = ['need_approve'];
    protected $guarded = ['id'];
}
