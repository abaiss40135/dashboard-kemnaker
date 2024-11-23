<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas\DataOrsosmas;

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
            'type'            => 'required',
            'nama_orsosmas'   => 'required',
            'dasar_hukum'     => 'nullable',
            'tanggal_dasar_hukum' => 'nullable',
            'akta_notaris'        => 'required',
            'tanggal_akta_notaris'=> 'required',
            'npwp'            => 'required',
            'provinsi_code'   => 'required',
            'kabupaten_code'  => 'required',
            'kecamatan_code'  => 'nullable',
            'desa_code'       => 'nullable',
            'provinsi'        => 'required',
            'kabupaten'       => 'required',
            'kecamatan'       => 'nullable',
            'desa'            => 'nullable',
            'jalan'           => 'nullable',
            'rt'              => 'nullable',
            'rw'              => 'nullable',
            'sumber_dana'     => 'required',
            'bidang_kegiatan' => 'required',
            'jml_anggota'     => 'required',
            'nama_ketua'      => 'required',
            'no_hp_ketua'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'dasar_hukum.required' => 'No AHU KEMENKUMHAM harus diisi',
        ];
    }
}
