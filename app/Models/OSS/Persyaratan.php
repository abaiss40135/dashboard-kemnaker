<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    protected $table = 'data_persyaratan';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $hidden = [
        'id', 'data_checklist_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'data_checklist_id', 'id');
    }
}
