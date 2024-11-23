<?php

namespace App\Models\Log;

use App\Models\Personel;
use App\Models\RiwayatSio;
use App\Models\StatusSio;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LogStatusRiwayatSio extends Pivot
{
   protected $table = 'log_status_riwayat_sio';

   public function riwayatSio()
   {
       return $this->belongsTo(RiwayatSio::class, 'riwayat_sio_id', 'id');
   }

   public function statusSio()
   {
       return $this->belongsTo(StatusSio::class, 'status_sio_id', 'id');
   }

   public function user()
   {
       return $this->belongsTo(User::class, 'user_id', 'id');
   }

    public function personel()
    {
        return $this->hasOneThrough(Personel::class, User::class, 'id', 'user_id', 'user_id')
            ->withDefault([
                'nama' => 'BOS V2'
            ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOperatorMabesTingkatSatu($query)
    {
        return $query->where('status_sio_id', '>=',  3);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOperatorMabesTingkatDua($query)
    {
        return $query->where('status_sio_id', '>=', 4)->where('role', 'operator_mabes_2');
    }
}
