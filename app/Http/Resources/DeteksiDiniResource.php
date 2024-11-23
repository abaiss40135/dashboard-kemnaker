<?php

namespace App\Http\Resources;

use App\Helpers\Regex;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin \App\Models\Deteksi_dini */
class DeteksiDiniResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $deteksi_dini = [
            "id"                => $this->id,
            "created_at"        => $this->created_at->format('Y-m-d H:i:s'),
            "updated_at"        => $this->updated_at->format('Y-m-d H:i:s'),
            "nama_narasumber"   => $this->nama_narasumber,
            "pekerjaan"         => $this->pekerjaan,
            "provinsi"          => $this->provinsi,
            "kabupaten"         => $this->kabupaten,
            "kecamatan"         => $this->kecamatan,
            "desa"              => $this->desa,
            "detail_alamat"     => $this->detail_alamat,
            "rt"                => $this->rt,
            "rw"                => $this->rw,
            "waktu"             => Carbon::parse($this->tanggal_mendapatkan_informasi . ' ' . $this->jam_mendapatkan_informasi)->format('Y-m-d H:i:s'),
            "lokasi"            => $this->lokasi_mendapatkan_informasi,
            "personel"          => $this->penulis,
            "lat_long"          => Regex::replace($this->titik_mendapatkan_informasi, '0-9\.\,'),
            "polda"             => $this->polda
        ];

        $laporan_informasi = (new LaporanInformasiResource($this->whenLoaded('laporan_informasi')));

        return array_merge($deteksi_dini, json_decode($laporan_informasi->toJson(), true));
    }
}
