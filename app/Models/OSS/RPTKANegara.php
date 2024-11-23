<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class RPTKANegara extends Model
{
    protected $table = 'rptka_negara';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $hidden = [
        'id', 'rptka_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rptka()
    {
        return $this->belongsTo(RPTKA::class, 'rptka_id', 'id');
    }
}
