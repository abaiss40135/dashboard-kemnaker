<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class LokasiProyek extends Model
{
    protected $table = 'data_lokasi_proyek';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $casts = [
        'data_lokasi_proyek' => 'array'
    ];
    protected $hidden = [
        'id', 'nib_id', 'data_proyek_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'data_proyek_id', 'id');
    }

    public function posisiProyeks()
    {
        return $this->hasMany(PosisiProyek::class, 'data_lokasi_proyek_id', 'id');
    }

    public function setDataLokasiProyekAttribute(array $value)
    {
        $this->attributes['data_lokasi_proyek'] = json_encode($value);
    }
}
