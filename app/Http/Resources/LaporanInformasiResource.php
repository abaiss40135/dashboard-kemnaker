<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin \App\Models\LaporanInformasi */
class LaporanInformasiResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'jenis_laporan_informasi' => $this->jenis_pendapat ?? "",
            'uraian_laporan_informasi' => $this->uraian ?? "",
            'keyword_laporan_informasi' => $this->keyword ?? "",
        ];
    }
}
