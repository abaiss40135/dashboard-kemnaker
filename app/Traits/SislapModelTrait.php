<?php

namespace App\Traits;

use App\Models\Personel;
use App\Models\Sislap\ApprovalLaporan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait SislapModelTrait
{
    public static function bootSislapModelTrait(): void
    {
        static::deleting(fn (Model $model) =>
            $model->approvals()->delete(),
        );
    }

    public function personel()
    {
        return $this->hasOneThrough(Personel::class, User::class, 'id', 'user_id', 'user_id');
    }

    public function approval()
    {
        return $this->morphOne(ApprovalLaporan::class, 'approvable')->latestOfMany();
    }

    public function approvals()
    {
        return $this->morphMany(ApprovalLaporan::class, 'approvable')->latest();
    }

    public function getNeedApproveAttribute()
    {
        /**
         * laporan ditolak, hanya bisa diajukan ulang oleh level dibawahnya
         */

        if ($this->approval) {
            if (($this->approval->is_approve === null || $this->approval->is_approve)
                && (auth()->user()->haveRole('operator_bagopsnalev_polres') || auth()->user()->haveRole('operator_binpolmas_polres'))
                && !($this->approval->level === 'polres')) {
                return false;
            }

            if (!$this->approval->is_approve){
                return !Str::contains(auth()->user()?->role() ?? 'polda', $this->approval->level);
            }
            /**
             * approver sama dengan current user
             */
            if ($this->approval->approver === auth()->user()->id){
                return false;
            }
            if ($this->approval->level === 'polda'){
                return !$this->approval->user->haveRole('operator_bagopsnalev_mabes') && $this->approval->is_approve;
            }
            if ($this->approval->level === 'polres'){
                return !$this->approval->user->haveRole('operator_bagopsnalev_polda') && $this->approval->is_approve;
            }
        }
        return !$this->approval;
    }
}
