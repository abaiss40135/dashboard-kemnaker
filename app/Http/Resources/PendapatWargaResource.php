<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin \App\Models\PendapatWarga */
class PendapatWargaResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'jenis_pendapat_warga' => $this->jenis_pendapat,
            'uraian_pendapat_warga' => $this->uraian,
            'keyword_pendapat_warga' => $this->keyword,
        ];
    }
}
