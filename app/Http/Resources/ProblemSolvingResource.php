<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin \App\Models\Problem_solving */
class ProblemSolvingResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"                        => $this->id,
            "created_at"                => $this->created_at->format('Y-m-d H:i:s'),
            "updated_at"                => $this->updated_at->format('Y-m-d H:i:s'),
            "waktu"                     => Carbon::parse($this->tanggal_kejadian . ' ' . $this->waktu_kejadian)->format('Y-m-d H:i:s'),
            "pihak_pertama"             => $this->nama_pihak_1,
            "pekerjaan_pihak_pertama"   => $this->pekerjaan_pihak_1,
            "alamat_pihak_pertama"      => $this->alamat_pihak_1,
            "provinsi_pihak_pertama"    => $this->provinsi_pihak_1,
            "kabupaten_pihak_pertama"   => $this->kabupaten_pihak_1,
            "kecamatan_pihak_pertama"   => $this->kecamatan_pihak_1,
            "desa_pihak_pertama"        => $this->desa_pihak_1,
            "rt_pihak_pertama"          => $this->rt_pihak_1,
            "rw_pihak_pertama"          => $this->rw_pihak_1,
            "pihak_kedua"               => $this->nama_pihak_2,
            "pekerjaan_pihak_kedua"     => $this->pekerjaan_pihak_2,
            "alamat_pihak_kedua"        => $this->alamat_pihak_2,
            "provinsi_pihak_kedua"      => $this->provinsi_pihak_2,
            "kabupaten_pihak_kedua"     => $this->kabupaten_pihak_2,
            "kecamatan_pihak_kedua"     => $this->kecamatan_pihak_2,
            "desa_pihak_kedua"          => $this->desa_pihak_2,
            "rt_pihak_kedua"            => $this->rt_pihak_2,
            "rw_pihak_kedua"            => $this->rw_pihak_2,
            "uraian_kejadian"           => $this->uraian_kejadian,
            "saksi"                     => $this->saksi,
            "uraian_problem_solving"    => $this->uraian_problem_solving,
            "personel"                  => $this->penulis,
            "narasumber"                => $this->nama_narasumber,
            "pekerjaan_narasumber"      => $this->pekerjaan_narasumber,
            "alamat_narasumber"         => $this->alamat_narasumber,
            "hari_masalah_selesai"      => $this->hari_masalah_selesai,
            "tanggal_masalah_selesai"   => $this->tanggal_masalah_selesai,
            "polda"                     => $this->polda,
            "keyword"                   => $this->keyword
        ];
    }
}
