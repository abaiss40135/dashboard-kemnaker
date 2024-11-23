<?php

namespace App\Models\Sislap\Lapsubjar\Binanevpolsus;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class DataSenpi extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'kementerian_lembaga',
        'senpi_larpan_jml',
        'senpi_larpan_bb',
        'senpi_larpan_rr',
        'senpi_larpan_rb',
        'senpi_larpend_jml',
        'senpi_larpend_bb',
        'senpi_larpend_rr',
        'senpi_larpend_rb',
        'amunisi_larpan_jml',
        'amunisi_larpan_bb',
        'amunisi_larpan_rr',
        'amunisi_larpan_rb',
        'amunisi_larpend_jml',
        'amunisi_larpend_bb',
        'amunisi_larpend_rr',
        'amunisi_larpend_rb',
        'user_id',
        'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
