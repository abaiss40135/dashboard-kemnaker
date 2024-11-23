<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class RPTKAJabatan extends Model
{
    protected $table = 'rptka_jabatan';
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

    public function rptkaTkiPendampings()
    {
        return $this->hasMany(RPTKATkiPendamping::class, 'rptka_jabatan_id', 'id');
    }
}
