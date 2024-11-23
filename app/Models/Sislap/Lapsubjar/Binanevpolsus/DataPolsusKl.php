<?php

namespace App\Models\Sislap\Lapsubjar\Binanevpolsus;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataPolsusKl extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'kementerian',
        'nama',
        'pangkat',
        'nip',
        'golongan',
        'ttl',
        'jenis_kelamin',
        'agama',
        'jabatan',
        'wilayah_penugasan',
        'dik_umum',
        'tuk',
        'bang',
        'pim',
        'keterangan',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
