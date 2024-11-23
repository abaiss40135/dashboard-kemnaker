<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlasterRutinitasBhabinkamtibmas extends Model
{
    protected $table = "klaster_rutinitas_bhabinkamtibmas";

    protected $guarded = ['id'];

    protected $appends = [
//        'start_date', 'end_date'
    ];

    public function personel(){
        return $this->belongsTo(Personel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStartDateAttribute()
    {
        return $this->created_at->startOfWeek();
    }

    public function getEndDateAttribute()
    {
        return $this->created_at->endOfWeek();
    }
}
