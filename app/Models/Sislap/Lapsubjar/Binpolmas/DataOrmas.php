<?php

namespace App\Models\Sislap\Lapsubjar\Binpolmas;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataOrmas extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'nama_kommas',
        'badan_hukum',
        'akta_notaris',
        'pengesahan',
        'npwp',
        'duk_pembina',
        'pengurus',
        'bergerak',
        'kebijakan',
        'jumlah_anggota',
        'keterangan',
        'kode_satuan',
        'user_id'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
