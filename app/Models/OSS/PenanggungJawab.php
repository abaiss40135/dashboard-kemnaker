<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class PenanggungJawab extends Model
{
    protected $table = 'penanggung_jawab';
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

    public function pemegang_saham()
    {
        return $this->hasOne(PemegangSaham::class, 'no_identitas_pemegang_saham', 'no_identitas_penanggung_jwb')
            ->withDefault([
                'jabatan_pemegang_saham' => "-",
                'npwp_pemegang_saham' => "-",
                'email_pemegang_saham' => "-",
                'total_modal_pemegang' => 0,
                'flag_asing' => "-",
            ]);
    }
}
