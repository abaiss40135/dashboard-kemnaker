<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class ProyekProduk extends Model
{
    protected $table = 'data_proyek_produk';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $hidden = [
        'id', 'data_proyek_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'data_proyek_id', 'id');
    }

    public function setPiTanggalAttribute($value)
    {
        $this->attributes['pi_tanggal'] = $value === '-' ? null : $value;
    }
}
