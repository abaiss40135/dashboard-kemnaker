<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function React\Promise\reduce;

class AkumulasiLaporanBhabinkamtibmas extends Model
{
    protected $table = "akumulasi_laporan_bhabinkamtibmas";

    protected $guarded = ['id'];

    protected $appends = ['total_laporan'];

    public function personel()
    {
        return $this->belongsTo(Personel::class, 'personel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getTotalLaporanAttribute()
    {
        return $this->jumlah_dds + $this->jumlah_deteksi_dini + $this->jumlah_ps + $this->jumlah_ps_non_sengketa + $this->jumlah_ps_eksekutif;
    }
}
