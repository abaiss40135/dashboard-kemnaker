<?php

namespace App\Models;

use App\Traits\StringPrimaryTrait;
use Illuminate\Database\Eloquent\Model;

class JenisBerkas extends Model
{
    use StringPrimaryTrait;

    protected $table = 'jenis_berkas';
    protected $fillable = ['jenis', 'keterangan'];
    protected $casts = [
        'jenis' => 'string'
    ];
    protected $primaryKey = 'jenis';

    public function berkasPendaftaran()
    {
        return $this->hasMany(BerkasPendaftaranSio::class, 'jenis_berkas', 'jenis');
    }
}
