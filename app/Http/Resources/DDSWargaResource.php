<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin \App\Models\Dds_warga */
class DDSWargaResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $dds = [
            'id'                    => $this->id,
            'personel'              => $this->penulis,
            'polda'                 => $this->polda,
            'tanggal_kunjungan'     => $this->tanggal,
            'nama_kepala_keluarga'  => $this->nama_kepala_keluarga,
            'jenis_kelamin'         => $this->jenis_kelamin_kepala_keluarga,
            'tempat_lahir'          => $this->tempat_lahir_kepala_keluarga,
            'tanggal_lahir'         => $this->tanggal_lahir_kepala_keluarga,
            'agama'                 => $this->agama_kepala_keluarga,
            'nomor_telepon'         => $this->no_tel_kepala_keluarga,
            'pekerjaan'             => $this->pekerjaan_kepala_kelurga ?? "",
            'alamat'                => $this->detail_alamat_kepala_keluarga,
            'provinsi'              => $this->provinsi_kepala_keluarga,
            'kabupaten'             => $this->kabupaten_kepala_keluarga,
            'kecamatan'             => $this->kecamatan_kepala_keluarga,
            'desa'                  => $this->desa_kepala_keluarga,
            'rt'                    => $this->rt_kepala_keluarga,
            'rw'                    => $this->rw_kepala_keluarga,
            'pendapat_warga'        => PendapatWargaResource::collection($this->whenLoaded('pendapat_warga')),
            'created_at'            => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'            => $this->updated_at->format('Y-m-d H:i:s'),
        ];

        $laporan_informasi = (new LaporanInformasiResource($this->whenLoaded('laporan_informasi')));

        return array_merge($dds, json_decode($laporan_informasi->toJson(), true));
    }
}
