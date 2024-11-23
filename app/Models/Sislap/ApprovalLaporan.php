<?php

namespace App\Models\Sislap;

use App\Models\Personel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ApprovalLaporan extends Model
{
    protected $table = 'sislap_approval_laporan';
    protected $guarded = ['id'];
    protected $appends = ['waktu'];

    public function user()
    {
        return $this->belongsTo(User::class, 'approver', 'id');
    }

    public function personel()
    {
        return $this->hasOneThrough(Personel::class, User::class, 'id', 'user_id', 'approver');
    }

    public function approvable()
    {
        return $this->morphTo();
    }

    public function scopeApproved($query){
        return $query->where('is_approve', true);
    }

    public function getWaktuAttribute()
    {
        return $this->created_at->translatedFormat(config('app.long_datetime_format'));
    }
}
