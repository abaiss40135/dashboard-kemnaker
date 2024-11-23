<?php


namespace App\Traits;


trait ModelTrait
{
    public function scopeWithAndWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }

    public function scopeWithAndOrWhereHas($query, $relation, $constraint){
        return $query->orWhereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }
}
