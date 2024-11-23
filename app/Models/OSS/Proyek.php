<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'data_proyek';
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

    public function lokasi()
    {
        return $this->hasOne(LokasiProyek::class, 'data_proyek_id', 'id');

    }

    public function lokasiProyeks()
    {
        return $this->hasMany(LokasiProyek::class, 'data_proyek_id', 'id');

    }

    public function lokasiUtama()
    {
        return $this->hasOne(LokasiProyek::class, 'data_proyek_id', 'id')->where('status_lokasi', '01');

    }

    public function proyekProduks()
    {
        return $this->hasMany(ProyekProduk::class, 'data_proyek_id', 'id');
    }

    public function checklist()
    {
        return $this->hasOne(Checklist::class, 'id_proyek', 'id_proyek');
    }
}
