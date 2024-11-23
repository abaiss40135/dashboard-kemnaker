<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSio extends Model
{
    public function pendaftaranSio()
    {
        return $this->hasMany(PendaftaranSio::class, 'status', 'id');
    }
}
