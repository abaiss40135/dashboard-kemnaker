<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas\DataKomunitasMasyarakat;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'polda'           => 'required',
            'polres'          => 'required',
            'nama_kommas'     => 'required',
            'akta_notaris'    => 'nullable',
            'tanggal_akta_notaris' => 'nullable',
            'npwp'            => 'nullable',
            'sumber_dana'     => 'required',
            'bidang_kegiatan' => 'required',
            'jml_anggota'     => 'required',
            'nama_ketua'      => 'required',
            'no_hp_ketua'     => 'required',
            'provinsi'   => 'required',
            'kabupaten'  => 'required',
            'kecamatan'  => 'nullable',
            'desa'       => 'nullable',
            'provinsi_code'   => 'required',
            'kabupaten_code'  => 'required',
            'kecamatan_code'  => 'nullable',
            'desa_code'       => 'nullable',
            'jalan'           => 'nullable',
            'rt'              => 'nullable',
            'rw'              => 'nullable',
        ];
    }
}
