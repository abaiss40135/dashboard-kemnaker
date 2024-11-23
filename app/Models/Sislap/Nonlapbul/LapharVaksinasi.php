<?php

namespace App\Models\Sislap\Nonlapbul;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class LapharVaksinasi extends Model
{
    use SislapModelTrait;

    protected $fillable = [
        'kab_kota',
        'vaksinasi_sdm_kesehatan',
        'sdm_kesehatan_divaksin_cov1',
        'sdm_kesehatan_vaksin_cov1',
        'sdm_kesehatan_divaksin_cov2',
        'sdm_kesehatan_vaksin_cov2',
        'sdm_kesehatan_divaksin_cov3',
        'sdm_kesehatan_vaksin_cov3',
        'vaksinasi_lansia_divaksin_cov1',
        'vaksinasi_lansia_vaksin_cov1',
        'vaksinasi_lansia_divaksin_cov2',
        'vaksinasi_lansia_vaksin_cov2',
        'vaksinasi_yanpublik_divaksin_cov1',
        'vaksinasi_yanpublik_vaksin_cov1',
        'vaksinasi_yanpublik_divaksin_cov2',
        'vaksinasi_yanpublik_vaksin_cov2',
        'mu_divaksin_cov1',
        'mu_vaksin_cov1',
        'mu_divaksin_cov2',
        'mu_vaksin_cov2',
        'remaja_divaksin_cov1',
        'remaja_vaksin_cov1',
        'remaja_divaksin_cov2',
        'remaja_vaksin_cov2',
        'gr_divaksin_cov1',
        'gr_vaksin_cov1',
        'gr_divaksin_cov2',
        'gr_vaksin_cov2',
        'jumlah',
        'kode_satuan',
        'user_id'

    ];

    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
