<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AtensiPimpinan extends Model
{
    use Notifiable;
    protected $guarded = [];
    protected $appends = [
       'tanggal_lengkap'
    ];

    public function getTanggalLengkapAttribute(){
        return Carbon::create($this->created_at)->diffForHumans();
    }
}
