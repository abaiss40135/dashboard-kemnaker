<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class OpsDamaiCartenz extends Model
{    
    use SislapModelTrait;

    protected $guarded = ['id'];
    protected $appends = ['need_approve'];
    protected $table   = 'ops_damai_cartenzs';

    const PI_AJAR     = 'pi ajar';
    const KOTEKA      = 'koteka';
    const KELADI_SAGU = 'keladi sagu';
    const KASUARI     = 'kasuari';

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
