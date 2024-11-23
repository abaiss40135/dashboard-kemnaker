<?php

namespace App\Models\PolisiRW;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LokasiPenugasan extends Model
{
    protected $guarded = ['id'];
    protected $table = 'lokasi_penugasan_polisi_rw';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
