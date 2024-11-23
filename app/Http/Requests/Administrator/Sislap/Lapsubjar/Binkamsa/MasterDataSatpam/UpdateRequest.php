<?php

namespace App\Http\Requests\Administrator\Sislap\Lapsubjar\Binkamsa\MasterDataSatpam;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'no_reg' => 'nullable',
            'nik' => 'nullable',
            'nama' => 'nullable',
            'tanggal_lahir' => 'nullable',
            'alamat' => 'nullable',
            'tinggi_berat_badan' => 'nullable',
            'gol_darah' => 'nullable',
            'rumus_sidik_jari' => 'nullable',
            'handphone' => 'nullable',
            'email' => 'nullable',
            'dikum_terakhir' => 'nullable',
            'npwp' => 'nullable',
            'perusahaan' => 'nullable',
            'jabatan' => 'nullable',
            'alamat_kantor' => 'nullable',
            'nomor_kantor' => 'nullable',
            'email_perusahaan' => 'nullable',
            'dik_terakhir_satpam' => 'nullable',
            'tahun_lulus' => 'nullable',
            'is_ex_tni_polri' => 'nullable',
            'pangkat' => 'nullable',
        ];
    }
}
