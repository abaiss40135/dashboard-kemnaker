<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

/** @see \App\Models\PendapatWarga */
class PendapatWargaCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        dd($this->collection);
        return [
            'pendapat_warga' => $this->collection,
        ];
    }
}
