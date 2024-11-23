<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class PemegangSaham extends Model
{
    protected $table = 'pemegang_saham';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $hidden = [
        'id', 'nib_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nib()
    {
        return $this->belongsTo(NIB::class, 'nib_id', 'id');
    }
}
