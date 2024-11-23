<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class PosisiProyek extends Model
{
    protected $table = 'data_posisi_proyek';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $hidden = [
        'id', 'data_proyek_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lokasiProyek()
    {
        return $this->belongsTo(LokasiProyek::class, 'data_proyek_id', 'id');
    }
}
