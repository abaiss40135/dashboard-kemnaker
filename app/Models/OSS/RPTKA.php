<?php

namespace App\Models\OSS;

use Illuminate\Database\Eloquent\Model;

class RPTKA extends Model
{
    protected $table = 'data_rptka';
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

    public function rptkaJabatans()
    {
        return $this->hasMany(RPTKAJabatan::class, 'rptka_id', 'id');
    }

    public function rptkaNegaras()
    {
        return $this->hasMany(RPTKANegara::class, 'rptka_id', 'id');
    }

    public function rptkaLokasis()
    {
        return $this->hasMany(RPTKALokasi::class, 'rptka_id', 'id');
    }
}
