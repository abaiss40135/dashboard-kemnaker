<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class RPTKATkiPendamping extends Model
{
    protected $table = 'rptka_tki_pendamping';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $hidden = [
        'id', 'rptka_jabatan_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rptkaJabatan()
    {
        return $this->belongsTo(RPTKAJabatan::class, 'rptka_jabatan_id', 'id');
    }
}
