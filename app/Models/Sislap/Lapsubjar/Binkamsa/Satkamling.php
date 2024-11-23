<?php

namespace App\Models\Sislap\Lapsubjar\Binkamsa;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class Satkamling extends Model
{
    use SislapModelTrait;

    protected $table = 'sislap_satkamling';
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
