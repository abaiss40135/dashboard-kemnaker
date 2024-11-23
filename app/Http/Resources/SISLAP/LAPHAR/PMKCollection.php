<?php

namespace App\Http\Resources\SISLAP\LAPHAR;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

/** @see \App\Models\Sislap\PenyakitMulutKuku */
class PMKCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array|Arrayable|Collection|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($request->is('*pmk*')) {
            return $this->collection->map(function ($item) {
                return new PMKResource($item);
            });
        }
        return parent::toArray($request);
    }
}
