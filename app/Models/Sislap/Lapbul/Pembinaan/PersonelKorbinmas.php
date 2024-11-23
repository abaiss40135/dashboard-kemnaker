<?php

namespace App\Models\Sislap\Lapbul\Pembinaan;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class PersonelKorbinmas extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'satker', 'bulan', 'irjen_dsp', 'irjen_riil', 'brigjen_dsp', 'brigjen_riil',
        'kbp_dsp', 'kbp_riil', 'akbp_dsp', 'akbp_riil', 'kp_dsp', 'kp_riil',
        'akp_dsp', 'akp_riil', 'ip_dsp', 'ip_riil', 'ba_ta_dsp', 'ba_ta_riil',
        'pns_4_dsp', 'pns_4_riil', 'pns_3_dsp', 'pns_3_riil', 'pns_1_2_dsp',
        'pns_1_2_riil', 'user_id', 'kode_satuan'
    ];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
